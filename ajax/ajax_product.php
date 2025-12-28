<?php 
include_once $_SERVER['DOCUMENT_ROOT']."/lib_inc.php"; 

function save_uploaded_image(array $file, string $uploadDirAbs, string $uploadDirWeb): ?string
{
    if (!isset($file['error']) || is_array($file['error'])) return null;
    if ($file['error'] !== UPLOAD_ERR_OK) return null;

    // 용량 제한 (필요시 조정)
    $maxBytes = 3 * 1024 * 1024; // 5MB
    if (($file['size'] ?? 0) > $maxBytes) return null;

    // mime 체크 (가볍게)
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime  = $finfo->file($file['tmp_name']);
    $allowed = [
        'image/jpeg' => 'jpg',
        'image/png'  => 'png',
        'image/webp' => 'webp',
        'image/gif'  => 'gif',
    ];
    if (!isset($allowed[$mime])) return null;

    if (!is_dir($uploadDirAbs)) {
        if (!mkdir($uploadDirAbs, 0775, true)) return null;
    }

    $ext = $allowed[$mime];
    $filename = 'product_img_' . date('Ymd_His') . '_' . bin2hex(random_bytes(2)) . '.' . $ext;
    $destAbs = rtrim($uploadDirAbs, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destAbs)) return null;

    return rtrim($uploadDirWeb, '/') . '/' . $filename;
}

/**
 * $_FILES['input_file'] (multiple) 구조를 "파일 배열 리스트"로 정규화
 */
function normalize_files_array(array $files): array
{
    $normalized = [];
    if (!isset($files['name']) || !is_array($files['name'])) return $normalized;

    $count = count($files['name']);
    for ($i = 0; $i < $count; $i++) {
        if (($files['name'][$i] ?? '') === '') continue;
        $normalized[] = [
            'name'     => $files['name'][$i] ?? '',
            'type'     => $files['type'][$i] ?? '',
            'tmp_name' => $files['tmp_name'][$i] ?? '',
            'error'    => $files['error'][$i] ?? UPLOAD_ERR_NO_FILE,
            'size'     => $files['size'][$i] ?? 0,
        ];
    }
    return $normalized;
}

if (($_POST['act'] ?? '') === 'product_update') {
    $pt_idx     = (int)($_POST['idx'] ?? 0);
    $pt_name    = trim($_POST['pt_name'] ?? '');
    $pt_content = trim($_POST['pt_content'] ?? '');
    $pt_price   = (int)($_POST['pt_price'] ?? 0);
    $pt_stock   = (int)($_POST['pt_stock'] ?? 0);
    $pt_status  = (int)($_POST['pt_status'] ?? 1);

    if ($pt_name === '') {
        echo json_encode(['result'=>false,'msg'=>'상품명을 입력하세요']);
        exit;
    }
    if ($pt_content === '') {
        echo json_encode(['result'=>false,'msg'=>'상품내용을 입력하세요']);
        exit;
    }
    if ($pt_price === '') {
        echo json_encode(['result'=>false,'msg'=>'상품가격을 입력하세요']);
        exit;
    }
    if ($pt_stock === '') {
        echo json_encode(['result'=>false,'msg'=>'상품수량을 입력하세요']);
        exit;
    }
    if ($pt_status === '') {
        echo json_encode(['result'=>false,'msg'=>'상품상태를 입력하세요']);
        exit;
    }
    
    if ($pt_idx > 0) {
        $exists = pdo_select($db, 'product_t', 'idx', ['idx' => $pt_idx], ['fetch' => 'one']);
        if (!$exists) {
            echo json_encode(['result'=>false,'msg'=>'존재하지 않는 상품입니다.']);
            exit;
        }
    }

    if ($pt_idx === 0) {
        $ok = pdo_insert($db, 'product_t', [
            'pt_name'    => $pt_name,
            'pt_price'   => $pt_price,
            'pt_stock'   => $pt_stock,
            'pt_content' => $pt_content,
            'pt_status'  => $pt_status,
            'created_at' => date('Y-m-d H:i:s'),
        ], allowedColumns: [
            'pt_name','pt_price','pt_stock','pt_content','pt_status','created_at'
        ]);

        if (!$ok) {
            echo json_encode(['result'=>false,'msg'=>'상품 저장(등록)에 실패했습니다.']);
            exit;
        }

        $pt_idx = (int)$db->lastInsertId();

    } else {
        $ok = pdo_update($db, 'product_t', [
            'pt_name'    => $pt_name,
            'pt_price'   => $pt_price,
            'pt_stock'   => $pt_stock,
            'pt_content' => $pt_content,
            'pt_status'  => $pt_status,
        ], [
            'idx' => $pt_idx
        ], allowedColumns: [
            'pt_name','pt_price','pt_stock','pt_content','pt_status'
        ]);

        if ($ok === false) {
            echo json_encode(['result'=>false,'msg'=>'상품 저장(수정)에 실패했습니다.']);
            exit;
        }
    }

    // 이미지 처리
    $existingImgs = $_POST['pt_img_existing'] ?? [];
    $delFlags     = $_POST['pt_img_del'] ?? [];

    $kept = [];
    if (is_array($existingImgs)) {
        foreach ($existingImgs as $slot => $img) {
            $img = trim((string)$img);
            if ($img === '') continue;

            // 삭제 플래그 확인
            $del = (string)($delFlags[$slot] ?? '0');

            if ($del === '1') {
                continue; // 삭제 대상 → 유지 안 함
            }

            // 유지
            $kept[$slot] = $img;
        }
    }

    // 신규 업로드 처리
    $newWebPaths = [];
    if (isset($_FILES['input_file'])) {
        $uploadDirAbs = $_SERVER['DOCUMENT_ROOT'] . '/uploads';
        $uploadDirWeb = '/uploads';                            

        $files = normalize_files_array($_FILES['input_file']);

        // 이미 kept가 몇 장인지 고려해서 남은 자리만 업로드
        $remain = 3 - count($kept);
        if ($remain > 0) {
            foreach ($files as $file) {
                if ($remain <= 0) break;

                $saved = save_uploaded_image($file, $uploadDirAbs, $uploadDirWeb);
                if ($saved) {
                    $newWebPaths[] = $saved;
                    $remain--;
                }
            }
        }
        // 남은 자리가 0이면 업로드 파일은 무시
    }

    // 이미지 3개 구성
    $final = array_slice(array_merge($kept, $newWebPaths), 0, 3);

    $img1 = $final[0] ?? null;
    $img2 = $final[1] ?? null;
    $img3 = $final[2] ?? null;

    // DB에 pt_img1~3 반영
    pdo_update($db, 'product_t', [
        'pt_img1' => $img1,
        'pt_img2' => $img2,
        'pt_img3' => $img3,
    ], [
        'idx' => $pt_idx
    ], allowedColumns: ['pt_img1','pt_img2','pt_img3']);

    echo json_encode([
        'result' => true,
        'msg'    => '저장되었습니다',
        'idx'    => $pt_idx,
        'imgs'   => [$img1, $img2, $img3],
    ]);
    exit;
}


if (($_POST['act'] ?? '') === 'product_delete') {

    $pt_idx = (int)($_POST['idx'] ?? 0);

    if ($pt_idx <= 0) {
        echo json_encode(['result'=>false,'msg'=>'잘못된 요청입니다.']);
        exit;
    }

    // 삭제 전 이미지 경로 조회
    $row = pdo_select(
        $db,
        'product_t',
        ['pt_img1', 'pt_img2', 'pt_img3'],
        ['idx' => $pt_idx],
        ['fetch' => 'one']
    );


    if (!$row) {
        echo json_encode(['result'=>false,'msg'=>'이미 삭제되었거나 존재하지 않습니다.']);
        exit;
    }

        $imgs = [$row['pt_img1'], $row['pt_img2'], $row['pt_img3']];

    foreach ($imgs as $img) {
        if (!$img) continue;

        // 보안: uploads 폴더만 삭제
        if (str_starts_with($img, '/uploads/')) {
            $absPath = $_SERVER['DOCUMENT_ROOT'] . $img;
            if (is_file($absPath)) {
                @unlink($absPath);
            }
        }
    }

    pdo_delete($db, 'product_t', ['idx' => $pt_idx]);

    echo json_encode([
        'result' => true,
        'msg'    => '삭제되었습니다.'
    ]);
    exit;
}


echo json_encode(['result'=>false,'msg'=>'Invalid request']);
exit;