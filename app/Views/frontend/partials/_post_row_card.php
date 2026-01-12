<?php
// expected: $p (array), $label (string), $badgeClass (string)
// optional: $e (callable) for esc helper, else fallback to esc()

helper('post'); // để dùng post_url(), post_img(), post_date()

$e = $e ?? fn($v) => esc($v ?? '');

$p = $p ?? [];
$label = $label ?? '';
$badgeClass = $badgeClass ?? 'bg_yellow';

$url  = function_exists('post_url') ? post_url($p) : site_url('post/' . ($p['slug'] ?? ''));
$img  = function_exists('post_img') ? post_img($p) : base_url('media_frontend/image/4.jpg');
$date = function_exists('post_date') ? post_date($p) : (!empty($p['published_at']) ? date('M d, Y', strtotime($p['published_at'])) : '');

$title = $e($p['title'] ?? '');
$summary = $e($p['summary'] ?? '');
$views = (int)($p['view_count'] ?? 0);
?>

<div class="card mt-3">
	<div class="card-body p-0">
		<div class="row row-cols-1 row-cols-sm-1 row-cols-lg-2 row-cols-md-1 mx-0">

			<div class="col p-0">
				<div class="blog_inner_left position-relative">
					<div class="blog_inner_left1">
						<a href="<?= $url ?>"><img src="<?= $img ?>" class="img-fluid" alt="..."></a>
					</div>

					<div class="blog_inner_left2 position-absolute top-0 p-3">
						<ul class="mb-0">
							<li class="d-block fs-5"><a class="d-block bg_yellow text-white rounded-circle text-center icon_1" href="#"><i class="fa fa-plus"></i></a></li>
							<li class="d-block fs-5 mt-2"><a class="d-block bg-info text-white rounded-circle text-center icon_1 icon_2" href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
							<li class="d-block fs-5 mt-2"><a class="d-block bg-danger text-white rounded-circle text-center icon_1 icon_2" href="#"><i class="fa-brands fa-twitter"></i></a></li>
							<li class="d-block fs-5 mt-2"><a class="d-block bg-success text-white rounded-circle text-center icon_1 icon_2" href="#"><i class="fa-brands fa-pinterest-p"></i></a></li>
							<li class="d-block fs-5 mt-2"><a class="d-block bg_violet text-white rounded-circle text-center icon_1 icon_2" href="#"><i class="fa-brands fa-instagram"></i></a></li>
						</ul>
					</div>
				</div>
			</div>

			<div class="col p-0">
				<div class="blog_inner_right pt-4 d-flex flex-column align-items-start border-start">
					<b class="d-inline-block <?= esc($badgeClass) ?> text-white p-1 px-3 font_10 text-uppercase rounded-1 mx-3">
						<?= esc($label) ?>
					</b>

					<b class="d-block fs-5 text-uppercase mt-2 mb-1 px-3">
						<a href="<?= $url ?>"><?= $title ?></a>
					</b>

					<span class="light_gray font_12 fw-bold px-3 text-uppercase"><?= esc($date) ?></span>

					<p class="mt-3 px-3 mb-0 pb-4"><?= $summary ?></p>

					<div class="mt-auto w-100">
						<ul class="mb-0 px-3 py-3 font_11 fw-bold text-uppercase justify-content-between d-flex border-top">
							<li>
								<span class="light_gray font_10 fw-bold text-uppercase">
									<i class="fa fa-clock me-1 text-warning align-middle"></i> <?= esc($date) ?>
								</span>
							</li>
							<li class="my-auto">
								<a class="light_gray" href="<?= $url ?>"><i class="fa fa-eye me-1"></i> <?= $views ?></a>
								<a class="light_gray mx-3" href="#"><i class="fa fa-heart me-1 text-danger"></i> 0</a>
								<a class="light_gray" href="#"><i class="fa fa-comment me-1"></i> 0</a>
							</li>
						</ul>
					</div>

				</div>
			</div>

		</div>
	</div>
</div>
