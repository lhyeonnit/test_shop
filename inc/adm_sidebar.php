<?php
$current = basename($_SERVER['PHP_SELF']); // ex) products.php
function active($file, $current) {
  return $file === $current ? 'active text-primary' : 'text-dark';
}
?>
<div class="border-end p-3 sidebar">
  <h5 class="mb-4">관리자</h5>
  <div class="list-group">
    <a class="list-group-item list-group-item-action <?= active('adm_products.php', $current) ?>"
       href="/adm_products.php">상품 목록</a>

    <a class="list-group-item list-group-item-action <?= active('adm_payments.php', $current) ?>"
       href="/adm_payments.php">결제 내역</a>

    <a class="list-group-item list-group-item-action <?= active('adm_cancels.php', $current) ?>"
       href="/adm_cancels.php">취소 내역</a>
  </div>
</div>
