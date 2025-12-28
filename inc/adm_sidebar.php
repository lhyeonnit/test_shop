<?php
$current = basename($_SERVER['PHP_SELF']); // ex) products.php
function active($file, $current) {
  return $file === $current ? 'active text-primary' : 'text-dark';
}
?>
<style>
    .admin-layout {
        min-height: 100vh;
    }
    /* 사이드바 */
    .sidebar {
        position: absolute;
        top: 0;
        left: 0;
        width: 260px;          /* 원하는 고정 가로 길이 */
        height: 100vh;         /* 화면 높이만큼 */
        background: #ffffff;
        border-right: 1px solid #e5e5e5;
        padding: 20px 0;
        overflow-y: auto;      /* 메뉴가 많아지면 사이드바만 스크롤 */
        z-index: 1000;
    }

    /* 사이드바 타이틀 */
    .sidebar-title {
        font-weight: 700;
        padding: 0 20px 12px 20px;
        margin-bottom: 8px;
    }

    /* 메뉴 아이템 */
    .side-item {
        display: block;
        padding: 16px 20px;
        text-decoration: none;
        color: #111;
        border-left: 4px solid transparent;
    }

    .side-item:hover {
        background: #f5f7fb;
    }

    .side-item.active {
        background: #0d6efd;
        color: #fff;
        border-left-color: #084298;
    }

    .main {
        margin-left: 260px;
        padding: 24px;
    }
    @media (max-width: 768px) {
        .sidebar {
            width: 220px;
        }
        .main {
            margin-left: 220px;
        }
    }
</style>
<section class="ftco-section" id="products-section">
    <div class="admin-layout">
        <aside class="sidebar">
            <div class="sidebar-title">메뉴</div>

            <a class="side-item <?php if($num == 1) {echo "active";} ?>" href="/adm_products.php">상품 목록</a>
            <a class="side-item <?php if($num == 2) {echo "active";} ?>" href="/adm_payments.php">결제 내역</a>
            <a class="side-item <?php if($num == 3) {echo "active";} ?>" href="/adm_cancels.php">취소 내역</a>
        </aside>