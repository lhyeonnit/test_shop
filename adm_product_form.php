<?php 
include_once("./inc/head.php");
include_once("/adm_sidebar.php"); 
if (empty($_SESSION['is_admin'])) {
    header('Location: adm_login.php');
    exit;
}
?>
<section class="ftco-section">
    <div class="container">
        <div class="row justify-content-center pb-5">
			<div class="col-md-7 heading-section text-center ftco-animate">
				<h1 class="big big-2">Admin</h1>
				<h2 class="mb-4">상품 등록</h2>
			</div>
		</div>
        <!-- <div class="card">
            <div class="login-box">
                <form method="post" name="frm_form" id="frm_form" action="">
                    <table class="login-table">
                        <tr>
                            <th>아이디</th>
                            <td>
                                <input type="text" class="form-control text-secondary"
                                placeholder="아이디를 입력하세요." id="mt_id" name="mt_id">
                            </td>
                        </tr>
                        <tr>
                            <th >비밀번호</th>
                            <td>
                                <input type="password" class="form-control" placeholder="비밀번호를 입력하세요." name="mt_pwd" id="mt_pwd">
                            </td>
                        </tr>
                    </table>
                    <button type="submit" class="btn btn-primary py-3 px-5 mt-3">로그인</button>
                </form>
            </div>
        </div> -->
    </div>
</section>
<?php include_once("./inc/tail.php"); ?>