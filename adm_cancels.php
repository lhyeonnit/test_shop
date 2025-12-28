<?php 
include_once("./inc/head.php");
$num = 3;
include_once("./inc/adm_sidebar.php"); 
?>
        <div class="main">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title" style="margin-bottom: 0;">취소 내역</h4>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th class="text-center" style="width:80px;">
                                    번호
                                </th>
                                <th class="text-center" style="width:150px;">
                                    관리
                                </th>
                                <th class="text-center" style="width:150px;">
                                    주문번호
                                </th>
                                <th class="text-center" style="width:150px;">
                                    주문상태
                                </th>
                                <th class="text-center" style="width:450px;">
                                    상품정보
                                </th>
                                <th class="text-center" style="width:150px;">
                                    구매자 정보
                                </th>
                                <th class="text-center" style="width:200px;">
                                    구매자 주소
                                </th>
                                <th class="text-center" style="width:140px;">
                                    구매일시
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    번호
                                </td>
                                <td class="text-center">
                                    <input type="button" class="btn btn-outline-primary btn-sm" value="상세" onclick="location.href=''" />
                                    <input type="button" class="btn btn-outline-danger btn-sm" value="삭제" onclick="" />
                                </td>
                                <td class="text-center">
                                    주문번호
                                </td>
                                <td class="text-center">
                                    주문상태
                                </td>
                                <td>
                                    <div class="media">
                                        <img src="" onerror="this.src=''" class="mr-3" alt="">
                                        <div class="mr-3">
                                            <small class="mt-2">상품명</small>
                                            <span class="text-info">가격</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">
                                    구매자 이름<br>
                                    구매자 번호
                                </td>
                                <td class="text-center">
                                    구매자 주소
                                </td>
                                <td class="text-center">
                                    주문일시
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8" class="text-center"><b>자료가 없습니다.</b></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once("./inc/tail.php"); ?>