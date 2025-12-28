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
                <div class="row justify-content-center pb-5">
                    <div class="col-md-7 heading-section text-center ftco-animate">
                        <h1 class="big big-2">Admin</h1>
                        <h4 class="mb-4">상품 등록/수정</h4>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <form method="post" name="frm_form" id="frm_form" action="" target="hidden_ifrm" enctype="multipart/form-data">
                            <div class="form-group row align-items-center">
                                <label for="" class="col-sm-2 col-form-label">상품명</label>
                                <div class="col-sm-10">
                                    <input type="text" id="" name="" class="form-control" placeholder="상품명을 입력해주세요" maxlength="20" value="">
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label class="col-sm-2 col-form-label">이미지 <span id="">(0/3)</span></label>
                                <div id="file_list_div" class="upload_img_wrap">
                                    <div class="form-group upload_img_item">
                                        <label for="input_file" class="file_upload square"><i class="xi-plus-circle"></i>파일선택</label>
                                        <input type="file" name="input_file[]" id="input_file" value="파일추가" class="d-none" oninput="" accept="image/*" multiple="multiple">
                                    </div>
                                    <div class="form-group upload_img_item img_del_div" >
                                        <input type="hidden" name="img_file_idx[]" value="" accept="image/*">
                                        <label class="square">
                                            <img src="" alt="이미지">
                                            <button class="btn btn-link btn-sm btn_delete img_del_btn"><i class="xi-close text-white"></i></button>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="" class="col-sm-2 col-form-label">상품 내용</label>
                                <div class="col-sm-10">
                                    <textarea id="content" name="content" class="form-control" placeholder="상품 내용을 입력해주세요" rows="3"></textarea>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="" class="col-sm-2 col-form-label">상품 가격</label>
                                <div class="col-sm-3">
                                    <input type="text" id="" name="" class="form-control" placeholder="상품 가격을 입력해주세요" maxlength="10" value="">
                                    <span>원</span>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="" class="col-sm-2 col-form-label">상품 수량</label>
                                <div class="col-sm-4">
                                    <input type="text" id="" name="" class="form-control" placeholder="상품명을 입력해주세요" maxlength="3" value="">
                                    <span>개</span>
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="" class="col-sm-2 col-form-label">판매 상태</label>
                                <div class="col-sm-10">
                                    <input type="hidden" name="pt_show" id="pt_show" value="Y" />
                                    <div class="btn-group" role="group" aria-label="pt_show">
                                        <button type="button" onclick="f_pt_show('Y');" id="f_pt_show_btn1" class="btn btn-outline-secondary btn-info text-white">노출함</button>
                                        <button type="button" onclick="f_pt_show('N');" id="f_pt_show_btn2" class="btn btn-outline-secondary">노출안함</button>
                                    </div>
                                </div>
                            </div>
                            <div class="fixed-bottom">
                                <p class="p-3 mt-3 text-center">
                                    <input type="submit" value="" class="btn btn-info" />
                                    <input type="button" value="목록" onclick="location.href=''" class="btn btn-outline-secondary mx-2" />
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</section>
<?php include_once("./inc/tail.php"); ?>