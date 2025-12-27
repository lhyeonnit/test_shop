<?php

$servername = 'localhost';
$dbuser = 'test_shop';
$dbpassword = 'testshop';
$dbname = 'test_shop';

try {
    // DSN(Data Source Name)을 설정 - 접속할 데이터베이스 서버와 데이터베이스 이름 지정
    $dsn = "mysql:host={$servername};dbname={$dbname}";

    // PDO 객체 생성 - MySQL에 연결 시도
    $db = new PDO($dsn, $dbuser, $dbpassword);

    // 프리페어드 스테이트먼트 시 에뮬레이션을 비활성화 (보안을 위해 실제 prepare 사용)
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    // 버퍼드 쿼리 활성화 - 결과를 모두 클라이언트 메모리에 가져와서 처리 (기본값이 true지만 명시적으로 지정)
    $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);

    // 에러 발생 시 예외(Exception)를 던지도록 설정 - 디버깅 및 예외처리 용이
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // 예외 발생 시 에러 메시지를 출력
    echo $e->getMessage();
}

/**
 * 식별자(테이블명/컬럼명) 검증
 * - 영문/숫자/언더스코어만 허용(권장)
 */
function pdo_assert_identifier(string $name): void {
    if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $name)) {
        throw new InvalidArgumentException("잘못된 식별자: {$name}");
    }
}

/**
 * 컬럼 화이트리스트 적용
 */
function pdo_filter_allowed_columns(array $data, ?array $allowedColumns): array {
    if ($allowedColumns === null) return $data;
    $allowed = array_flip($allowedColumns);
    return array_intersect_key($data, $allowed);
}

/**
 * WHERE 조건 빌더 (동등 비교 기본)
 * - ['id' => 1, 'status' => 'ready'] 형태
 * - NULL은 IS NULL 처리
 * - IN: ['id' => ['IN', [1,2,3]]]
 * - LIKE: ['name' => ['LIKE', '%abc%']]
 */
function pdo_build_where(array $where, array &$params, string $prefix = 'w_'): string {
    if (empty($where)) return '';

    $clauses = [];
    foreach ($where as $col => $val) {
        pdo_assert_identifier($col);

        if (is_array($val) && isset($val[0])) {
            $op = strtoupper($val[0]);

            if ($op === 'IN') {
                $list = $val[1] ?? [];
                if (!is_array($list) || count($list) === 0) {
                    // IN () 방지: 결과가 없게 만들기
                    $clauses[] = "1=0";
                    continue;
                }
                $inPlaceholders = [];
                foreach ($list as $i => $v) {
                    $ph = ":{$prefix}{$col}_in_{$i}";
                    $inPlaceholders[] = $ph;
                    $params[$ph] = $v;
                }
                $clauses[] = "{$col} IN (" . implode(',', $inPlaceholders) . ")";
                continue;
            }

            if ($op === 'LIKE') {
                $ph = ":{$prefix}{$col}";
                $params[$ph] = $val[1] ?? '';
                $clauses[] = "{$col} LIKE {$ph}";
                continue;
            }

            // 필요하면 >, <, >= 같은 연산도 확장 가능
            throw new InvalidArgumentException("WHERE에서 지원되지 않는 연산자: {$op}");
        }

        if ($val === null) {
            $clauses[] = "{$col} IS NULL";
            continue;
        }

        $ph = ":{$prefix}{$col}";
        $params[$ph] = $val;
        $clauses[] = "{$col} = {$ph}";
    }

    return 'WHERE ' . implode(' AND ', $clauses);
}

/**
 * INSERT
 * @return string lastInsertId
 */
function pdo_insert(PDO $db, string $table, array $data, ?array $allowedColumns = null): string {
    pdo_assert_identifier($table);

    $data = pdo_filter_allowed_columns($data, $allowedColumns);
    if (empty($data)) {
        throw new InvalidArgumentException("Insert 데이터가 비었습니다.");
    }

    foreach (array_keys($data) as $col) pdo_assert_identifier($col);

    $cols = array_keys($data);
    $placeholders = array_map(fn($c) => ":{$c}", $cols);

    $sql = "INSERT INTO {$table} (" . implode(',', $cols) . ") VALUES (" . implode(',', $placeholders) . ")";
    $stmt = $db->prepare($sql);

    foreach ($data as $col => $val) {
        $stmt->bindValue(":{$col}", $val);
    }

    $stmt->execute();
    return $db->lastInsertId();
}

/**
 * UPDATE
 * @return int affected rows
 */
function pdo_update(PDO $db, string $table, array $data, array $where, ?array $allowedColumns = null): int {
    pdo_assert_identifier($table);

    $data = pdo_filter_allowed_columns($data, $allowedColumns);
    if (empty($data)) {
        throw new InvalidArgumentException("Update 데이터가 비었습니다.");
    }
    if (empty($where)) {
        // 실수 방지: WHERE 없으면 업데이트 금지
        throw new InvalidArgumentException("업데이트를 위해 WHERE가 필요합니다.");
    }

    foreach (array_keys($data) as $col) pdo_assert_identifier($col);

    $setParts = [];
    $params = [];

    foreach ($data as $col => $val) {
        $ph = ":s_{$col}";
        $setParts[] = "{$col} = {$ph}";
        $params[$ph] = $val;
    }

    $whereSql = pdo_build_where($where, $params, 'w_');

    $sql = "UPDATE {$table} SET " . implode(', ', $setParts) . " {$whereSql}";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);

    return $stmt->rowCount();
}

/**
 * DELETE
 * @return int affected rows
 */
function pdo_delete(PDO $db, string $table, array $where): int {
    pdo_assert_identifier($table);

    if (empty($where)) {
        // 실수 방지: WHERE 없으면 삭제 금지
        throw new InvalidArgumentException("삭제를 위해 WHERE가 필요합니다.");
    }

    $params = [];
    $whereSql = pdo_build_where($where, $params, 'w_');

    $sql = "DELETE FROM {$table} {$whereSql}";
    $stmt = $db->prepare($sql);
    $stmt->execute($params);

    return $stmt->rowCount();
}

/**
 * SELECT
 * - columns: ['idx','pt_name'] / '*' 가능
 * - options: [
 *     'orderBy' => 'idx DESC',
 *     'limit' => 10,
 *     'offset' => 0,
 *     'fetch' => 'all'|'one'|'col'  // 기본 all
 *   ]
 */
function pdo_select(PDO $db, string $table, array|string $columns = '*', array $where = [], array $options = []): mixed {
    pdo_assert_identifier($table);

    if (is_array($columns)) {
        foreach ($columns as $c) {
            if ($c !== '*') pdo_assert_identifier($c);
        }
        $colSql = implode(',', $columns);
    } else {
        $colSql = $columns;
    }

    $params = [];
    $whereSql = pdo_build_where($where, $params, 'w_');

    $sql = "SELECT {$colSql} FROM {$table} {$whereSql}";

    if (!empty($options['orderBy'])) {
        // orderBy는 바인딩 불가 → 간단 검증(너무 엄격하면 불편해서 최소한만)
        $orderBy = $options['orderBy'];
        if (!preg_match('/^[a-zA-Z0-9_,\s]+(ASC|DESC)?$/i', $orderBy)) {
            throw new InvalidArgumentException("잘못된 orderBy.");
        }
        $sql .= " ORDER BY {$orderBy}";
    }

    if (isset($options['limit'])) {
        $limit = (int)$options['limit'];
        if ($limit < 0) $limit = 0;
        $sql .= " LIMIT {$limit}";
    }

    if (isset($options['offset'])) {
        $offset = (int)$options['offset'];
        if ($offset < 0) $offset = 0;
        $sql .= " OFFSET {$offset}";
    }

    $stmt = $db->prepare($sql);
    $stmt->execute($params);

    $fetch = $options['fetch'] ?? 'all';

    return match ($fetch) {
        'one' => $stmt->fetch(PDO::FETCH_ASSOC) ?: null,
        'col' => $stmt->fetchColumn(),
        default => $stmt->fetchAll(PDO::FETCH_ASSOC),
    };
}