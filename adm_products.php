<?php 
include_once("./inc/head.php");
$num = 1;
include_once("./inc/adm_sidebar.php"); 
if (empty($_SESSION['is_admin'])) {
    header('Location: adm_login.php');
    exit;
}
?>
        <div class="main">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" style="margin-bottom: 0;">상품 목록</h4>
                    </div>
                </div>
                <div class="py-3" style="justify-self: end;">
                    <input type="button" class="btn btn-info ml-2" value="상품 등록" onclick="location.href='/adm_product_form.php'" />
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center align-content-center" style="width:80px;">
                                    번호
                                </th>
                                <th class="text-center align-content-center" style="width:200px;">
                                    관리
                                </th>
                                <th class="text-center align-content-center" style="width:450px;">
                                    상품정보
                                </th>
                                <th class="text-center align-content-center" style="width:80px;">
                                    재고
                                </th>
                                <th class="text-center align-content-center" style="width:100px;">
                                    판매 상태
                                </th>
                                <th class="text-center align-content-center" style="width:140px;">
                                    등록일시
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center align-content-center">
                                    번호
                                </td>
                                <td class="text-center align-content-center">
                                    <input type="button" class="btn btn-outline-primary btn-sm" value="수정" onclick="location.href=''" />
                                    <input type="button" class="btn btn-outline-danger btn-sm" value="삭제" onclick="" />
                                </td>
                                <td>
                                    <div class="media">
                                        <img src="/images/image_2.jpg" onerror="this.src=''" class="mr-3" alt="">
                                        <div class="mr-3">
                                            <small class="mt-2">상품명</small>
                                            <p class="text-dark">상품내용</p>
                                            <p class="text-info">가격</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center align-content-center">
                                    재고
                                </td>
                                <td class="text-center align-content-center">
                                    판매상태
                                </td>
                                <td class="text-center align-content-center">
                                    등록일시
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-center align-content-center"><b>자료가 없습니다.</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once("./inc/tail.php"); ?>