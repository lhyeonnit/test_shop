<?php 
include_once("./inc/head.php"); 
$row = pdo_select($db, 'product_t', '*', ['idx' => $_GET['idx']], ['fetch' => 'one']);
?>

<section class="ftco-section">
	<div class="container">
		<div class="col-md-4 ftco-animate">
            <div class="blog-entry justify-content-end">
                <div class="d-flex">
                    <?php for ($i=1; $i<=3; $i++): 
                        $img = htmlspecialchars($row['pt_img' . $i]);
                        if (!$img) continue;
                    ?>
                    <div class="square mr-2">
                        <img style="width: 100%; height: auto;" src="<?= $img ?>" alt="이미지">
                    </div>
                    <?php endfor; ?>
                </div>
                <div class="text mt-3 float-right d-block">
                    <h3 class="heading">
                        <?= htmlspecialchars($row['pt_name'] ?? '') ?>
                    </h3>
                    <div class="d-flex align-items-center mb-3 meta">
                        <p class="mb-0">
                            <span class="mr-2"><?= htmlspecialchars($row['pt_price'] ?? 0) ?>원</span>
                            <!-- <a href="#" class="mr-2">Admin</a>
                            <a href="#" class="meta-chat"><span class="icon-chat"></span> 3</a> -->
                        </p>
                    </div>
                    <p><?= htmlspecialchars($row['pt_content'] ?? '') ?></p>
                </div>
            </div>
        </div>
	</div>
</section>

<?php include_once("./inc/tail.php"); ?>