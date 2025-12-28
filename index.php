<?php 
include_once("./inc/head.php"); 
$list = pdo_select($db, 'product_t', '*', ['pt_status' => 1], ['fetch' => 'all']);
?>
<section class="ftco-section" id="products-section">
	<div class="container">
		<div class="row justify-content-center mb-5 pb-5">
			<div class="col-md-7 heading-section text-center ftco-animate">
				<h1 class="big big-2">Products</h1>
				<h2 class="mb-4">All Products</h2>
				<p>모든 상품을 확인해보세요.</p>
			</div>
		</div>
		
		<div class="row d-flex">
			<?php foreach ($list as $row){ ?>
			<div class="col-md-4 ftco-animate">
				<div class="blog-entry justify-content-end">
					<a href="product_detail.php?idx=<?= htmlspecialchars($row['idx'] ?? 0) ?>" class="block-20" style="background-image: url('<?= htmlspecialchars($row['pt_img1'] ?? ''); ?>');">
					</a>
					<div class="text mt-3 float-right d-block">
						<h3 class="heading"><a href="product_detail.php?idx=<?= htmlspecialchars($row['idx'] ?? 0) ?>"><?= htmlspecialchars($row['pt_name'] ?? '') ?></a>
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
			<?php } ?>
		</div>
	</div>
</section>
<?php include_once("./inc/tail.php"); ?>