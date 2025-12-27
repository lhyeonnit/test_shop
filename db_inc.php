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

function pdo_insert($db, $table, $data) {
    $columns = implode(", ", array_keys($data));
    $placeholders = ":" . implode(", :", array_keys($data));

    $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
    $stmt = $db->prepare($sql);

    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }

    return $stmt->execute();
}