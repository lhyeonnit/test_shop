<?php 
include_once("./inc/head.php");
$num = 1;
include_once("./inc/adm_sidebar.php"); 
if (empty($_SESSION['is_admin'])) {
    header('Location: adm_login.php');
    exit;
}
$row = [
    'pt_name'    => '',
    'pt_price'   => '',
    'pt_stock'   => '',
    'pt_content' => '',
    'pt_status'  => '',
];
$act = $_GET['act'] ?? 'input';
$idx = isset($_GET['idx']) ? (int)$_GET['idx'] : 0;
$productImgs = [];
if ($act === 'update' && $idx > 0) {
    $found = pdo_select($db, 'product_t', '*', ['idx' => $idx], ['fetch' => 'one']);
    if (is_array($found)) {
        $row = array_merge($row, $found);
        $_act = "update";
        $_act_txt = "수정";
        // $productImgs = array_values(array_filter([
        //     $row['pt_img1'] ?? '',
        //     $row['pt_img2'] ?? '',
        //     $row['pt_img3'] ?? '',
        // ]));
        $productImgs = [1 => $row['pt_img1'], 2 => $row['pt_img2'], 3 => $row['pt_img3']];
    } else {
        $_act = "input";
        $_act_txt = "등록";
    }
} else {
    $_act = "input";
    $_act_txt = "등록";
}
?>
        <div class="main">
            <div class="container">
                <div class="row justify-content-center pb-5">
                    <div class="col-md-7 heading-section text-center ftco-animate">
                        <h1 class="big big-2">Admin</h1>
                        <h4 class="mb-4">상품 <?= $_act_txt ?></h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form method="post" name="frm_form" id="frm_form" action="" target="hidden_ifrm" enctype="multipart/form-data">
                            <input type="hidden" name="act" id="act" value="<?=$_act?>" />
                            <input type="hidden" name="idx" id="idx" value="<?=$idx?>" />
                            <div class="form-group row align-items-center">
                                <label for="" class="col-sm-2 col-form-label">상품명</label>
                                <div class="col-sm-10">
                                    <input type="text" id="pt_name" name="pt_name" class="form-control" placeholder="상품명을 입력해주세요" maxlength="20" value="<?= $row["pt_name"] ?>">
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label class="col-sm-2 col-form-label">이미지 <span id="img_count">(0/3)</span></label>
                                <div class="upload_img_wrap" id="upload_wrap">
                                    <div class="form-group upload_img_item upload_btn" id="upload_btn">
                                        <label for="input_file" class="file_upload square">
                                            <i class="xi-plus-circle"></i>파일선택
                                        </label>
                                        <input type="file" name="input_file[]" id="input_file" value="파일추가" class="d-none" oninput="" accept="image/*" multiple="multiple">
                                    </div>
                                    <!-- 기존 이미지 미리보기(오른쪽으로 나열) -->
                                    <?php for ($slot=1; $slot<=3; $slot++): 
                                    $img = $productImgs[$slot] ?? '';
                                    if (!$img) continue;
                                    ?>
                                    <div class="form-group upload_img_item preview_item existing img_del_div" data-slot="<?= $slot ?>">
                                        <input type="hidden" name="pt_img_existing[<?= $slot ?>]" value="<?= htmlspecialchars($img) ?>">
                                        <input type="hidden" name="pt_img_del[<?= $slot ?>]" class="del-flag" value="0">
                                        <label class="square">
                                            <img src="<?= htmlspecialchars($img) ?>" alt="이미지">
                                            <button type="button"
                                                    class="btn btn-link btn-sm img_del_btn"
                                                    onclick="deletePreview(this)">X</button>
                                        </label>
                                    </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="" class="col-sm-2 col-form-label">상품 내용</label>
                                <div class="col-sm-10">
                                    <textarea id="pt_content" name="pt_content" class="form-control" placeholder="상품 내용을 입력해주세요" rows="3"><?= $row["pt_content"] ?></textarea>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="" class="col-sm-2 col-form-label">상품 가격</label>
                                <div class="col-sm-2 d-flex align-items-end">
                                    <input type="number" id="pt_price" name="pt_price" class="form-control" max="1000000" min="1000" step="100" value="<?= $row["pt_price"] ?>">
                                    <span>원</span>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="" class="col-sm-2 col-form-label">상품 수량</label>
                                <div class="col-sm-2 d-flex align-items-end">
                                    <input type="number" id="pt_stock" name="pt_stock" class="form-control" max="100" min="0" step="10" value="<?= $row["pt_stock"] ?>">
                                    <span>개</span>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="pt_status" class="col-sm-2 col-form-label">판매 상태</label>
                                <div class="col-sm-2">
                                    <select name="pt_status" id="pt_status" class="form-control form-control-sm">
                                        <option value="1" <?php if($row["pt_status"] == '1'){echo 'selected';} ?>>판매중</option>
                                        <option value="0" <?php if($row["pt_status"] == '0'){echo 'selected';} ?>>판매종료</option>
                                    </select>
                                </div>
                            </div>
                            <p class="p-3 mt-3 text-center">
                                <input type="button" value="확인" id="next_btn" class="btn btn-dark" />
                                <input type="button" value="목록" onclick="location.href='/adm_products.php'" class="btn btn-outline-secondary mx-2" />
                            </p>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>
<script>
(function(){
    const max = 3;
    const input = document.getElementById('input_file');
    const wrap = document.getElementById('upload_wrap');
    const countEl = document.getElementById('img_count');
    const uploadBtn = document.getElementById('upload_btn');

    // 신규 파일을 누적 관리(삭제 가능하게)
    let selectedFiles = [];

    function getExistingCount() {
        // 기존 이미지 중 "삭제 표시(del-flag=1)" 아닌 것만 카운트
        const existing = wrap.querySelectorAll('.preview_item.existing');
        let cnt = 0;
        existing.forEach(el => {
        const flag = el.querySelector('.del-flag');
        if (!flag || flag.value !== '1') cnt++;
        });
        return cnt;
    }

    function getNewCount() {
        return selectedFiles.length;
    }

    function getTotalCount() {
        return getExistingCount() + getNewCount();
    }

    function updateUIState() {
        const total = getTotalCount();
        countEl.textContent = `(${total}/${max})`;

        // 3개 꽉 차면 업로드 버튼 비활성화
        if (total >= max) {
        input.disabled = true;
        uploadBtn.classList.add('disabled');
        uploadBtn.style.opacity = '0.5';
        uploadBtn.style.pointerEvents = 'none';
        } else {
        input.disabled = false;
        uploadBtn.classList.remove('disabled');
        uploadBtn.style.opacity = '';
        uploadBtn.style.pointerEvents = '';
        }
    }

    function rebuildInputFiles() {
        // selectedFiles -> input.files로 반영
        const dt = new DataTransfer();
        selectedFiles.forEach(f => dt.items.add(f));
        input.files = dt.files;
    }

    function makeNewPreview(file, index) {
        const div = document.createElement('div');
        div.className = 'form-group upload_img_item preview_item new img_del_div';
        div.dataset.newIndex = String(index);

        const label = document.createElement('label');
        label.className = 'square';

        const img = document.createElement('img');
        img.alt = '이미지';

        const btn = document.createElement('button');
        btn.type = 'button';
        btn.className = 'btn btn-link btn-sm img_del_btn';
        btn.textContent = 'X';
        btn.addEventListener('click', () => deletePreview(btn));

        label.appendChild(img);
        label.appendChild(btn);
        div.appendChild(label);

        wrap.appendChild(div);

        // 미리보기 로딩
        const reader = new FileReader();
        reader.onload = (e) => { img.src = e.target.result; };
        reader.readAsDataURL(file);

        return div;
    }

    input.addEventListener('change', function(){
        const incoming = Array.from(this.files || []);
        if (incoming.length === 0) return;

        const remain = max - getTotalCount();
        if (remain <= 0) {
        // 이미 꽉 참: 그냥 무시 + input 비움
        this.value = '';
        updateUIState();
        return;
        }

        // 남은 자리만큼만 추가, 나머지는 무시
        const toAdd = incoming.slice(0, remain);

        toAdd.forEach(file => {
        selectedFiles.push(file);
        // 현재 selectedFiles 길이-1이 방금 추가된 인덱스
        makeNewPreview(file, selectedFiles.length - 1);
        });

        // input.files를 selectedFiles로 재구성
        rebuildInputFiles();

        updateUIState();
    });

    // 전역 함수로 호출되고 있으니 window에 등록
    window.deletePreview = function(btn){
        const item = btn.closest('.img_del_div');
        if (!item) return;

        // 1) 기존 이미지인 경우: del-flag = 1로 표시하고 숨김
        if (item.classList.contains('existing')) {
        const flag = item.querySelector('.del-flag');
        if (flag) flag.value = '1';
        item.style.display = 'none';
        updateUIState();
        return;
        }

        // 2) 신규 이미지인 경우: selectedFiles에서 제거 + DOM 제거 + input.files 재구성
        if (item.classList.contains('new')) {
        // new preview들은 DOM 순서로 인덱스가 꼬일 수 있으니, "현재 new 목록 기준"으로 제거
        const newItems = Array.from(wrap.querySelectorAll('.preview_item.new'));
        const idx = newItems.indexOf(item); 
        if (idx >= 0) {
            selectedFiles.splice(idx, 1);
        }
        item.remove();

        // 남은 new 프리뷰들의 dataset 인덱스 재정렬
        const remainNew = Array.from(wrap.querySelectorAll('.preview_item.new'));
        remainNew.forEach((el, i) => el.dataset.newIndex = String(i));

        rebuildInputFiles();
        updateUIState();
        return;
        }
    };

    // 최초 카운트 세팅(기존 이미지 반영)
    updateUIState();

    $('#next_btn').on('click',function(){
        product_update();
    })
})();

function product_update(){
    $('#input_file').prop('disabled', false);

    var form = $('#frm_form')[0];
    var formData = new FormData(form);
    formData.append('act','product_update');

    $.ajax({
        url: "/ajax/ajax_product.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        dataType: "json",
        // async: false,
        cache: false,
        success: function (response) {
            if (response.result) {
                alert(response.msg);
                location.href = "/adm_products.php";
            } else {
                alert(response.msg);
            }
        },
    });

}
</script>

<?php include_once("./inc/tail.php"); ?>