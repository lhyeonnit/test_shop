<?php 
include_once("./inc/head.php");
include_once("./inc/adm_sidebar.php"); 
?>
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">상품 목록</h4>
        </div>
    </div>
    <input type="button" class="btn btn-info ml-2" value="상품 등록" onclick="location.href='/adm_product_form.php'" />
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
                    <th class="text-center" style="width:450px;">
                        상품정보
                    </th>
                    <th class="text-center" style="width:80px;">
                        재고
                    </th>
                    <th class="text-center" style="width:100px;">
                        판매 상태
                    </th>
                    <th class="text-center" style="width:140px;">
                        등록일시
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">
                        <?=$counts?>
                    </td>
                    <td class="text-center">
                        <input type="button" class="btn btn-outline-primary btn-sm" value="수정" onclick="location.href=''" />
                        <input type="button" class="btn btn-outline-danger btn-sm" value="삭제" onclick="" />
                    </td>
                    <td>
                        <div class="media product_list_media">
                            <img src="" onerror="this.src=''" class="align-self-center mr-3" alt="">
                            <div class="mr-3">
                                <small class="mt-2">상품명</small>
                                <span class="text-info">가격</span>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        재고
                    </td>
                    <td class="text-center">
                        판매상태
                    </td>
                    <td class="text-center">
                        등록일시
                    </td>
                </tr>
                <tr>
                    <td colspan="6" class="text-center"><b>자료가 없습니다.</b></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<?php include_once("./inc/tail.php"); ?>