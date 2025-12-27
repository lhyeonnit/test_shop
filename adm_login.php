<?php 
include_once("./inc/head.php");
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['mt_id'] === 'admin' && $_POST['mt_pwd'] === '1234!') {
        $_SESSION['is_admin'] = true;
        header('Location: adm_index.php');
        exit;
    } else {
        $login_error = '아이디 또는 비밀번호가 올바르지 않습니다.';
    }
}
?>
?>
<section class="ftco-section" id="admin-section">
    <div class="container">
        <div class="row justify-content-center pb-5">
			<div class="col-md-7 heading-section text-center ftco-animate">
				<h1 class="big big-2">Admin</h1>
				<h2 class="mb-4">관리자 로그인</h2>
			</div>
		</div>
        <div class="card">
            <!--로그인 폼 박스-->
            <div class="login-box">
                <form method="post" name="frm_form" id="frm_form" action="">
                    <table class="login-table">
                        <!--아이디-->
                        <tr>
                            <th>아이디</th>
                            <td>
                                <input type="text" class="form-control text-secondary"
                                placeholder="아이디를 입력하세요." id="mt_id" name="mt_id">
                            </td>
                        </tr>
                        <!--아이디-->

                        <!-- 비밀번호 -->
                        <tr>
                            <th >비밀번호</th>
                            <td>
                                <input type="password" class="form-control" placeholder="비밀번호를 입력하세요." name="mt_pwd" id="mt_pwd">
                            </td>
                        </tr>
                        <!-- 비밀번호 -->

                    </table>
                    <!--로그인-->
                    <button type="submit" class="btn btn-primary py-3 px-5 mt-3">로그인</button>
                    <!--로그인-->
                </form>
            </div>
            <!--로그인 폼 박스-->
        </div>
    </div>
</section>
<?php include_once("./inc/tail.php"); ?>