<?php include_once("./inc/head.php"); ?>
<section class="ftco-section" id="admin-section">
    <div class="container">
        <div class="row justify-content-center mb-5 pb-5">
			<div class="col-md-7 heading-section text-center ftco-animate">
				<h1 class="big big-2">Admin</h1>
				<h2 class="mb-4">관리자 로그인</h2>
			</div>
		</div>
        <div class="card">
            <!--로그인 폼 박스-->
            <div class="login-box">
                <form method="post" name="frm_form" id="frm_form" action="">
                    <table class="login-table ft-18 mb-30 mt-30">
                        <!--아이디-->
                        <tr>
                            <th class="fs_16">아이디<span class="point-color">*</span></th>
                            <td>
                                <input type="text" class="form-control text-secondary"
                                placeholder="아이디를 입력하세요." id="mt_id" name="mt_id">
                            </td>
                        </tr>
                        <!--아이디-->

                        <!-- 비밀번호 -->
                        <tr>
                            <th class="fs_16">비밀번호<span class="point-color">*</span></th>
                            <td colspan="2">
                                <input type="password" class="form-control" placeholder="비밀번호를 입력하세요." name="mt_pwd" id="mt_pwd">
                            </td>
                        </tr>
                        <!-- 비밀번호 -->

                    </table>
                    <!--로그인-->
                    <button type="button" id="login_btn" class="btn btn-primary py-3 px-5">로그인</button>
                    <!--로그인-->
                </form>
            </div>
            <!--로그인 폼 박스-->
        </div>
    </div>
</section>
<?php include_once("./inc/tail.php"); ?>