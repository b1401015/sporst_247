<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
/**
 * HOME VIEW - dynamic data binding (CodeIgniter 4)
 * Expected variables from controller:
 * - $featuredPosts (array)
 * - $trendingPosts (array)
 * - $popularPosts  (array)
 * - $latestPosts   (array)
 * Optional:
 * - $videos, $ads
 */

$e = fn($v) => esc($v ?? '');

$postUrl = function ($p) {
    // You can change this to your real route if needed
    if (!empty($p['category_slug']) && !empty($p['slug'])) {
        return site_url($p['category_slug'] . '/' . $p['slug']);
    }
    return site_url('news/' . ($p['slug'] ?? ''));
};

$postImg = function ($p) {
    if (!empty($p['thumbnail'])) return base_url($p['thumbnail']);
    return base_url('media_frontend/image/4.jpg');
};

$avatarImg = function ($i = 0) {
    $fallbacks = [
        'media_frontend/image/8.jpg',
        'media_frontend/image/9.jpg',
    ];
    return base_url($fallbacks[$i % count($fallbacks)]);
};

$postDate = fn($p) =>
    !empty($p['published_at']) ? date('M d, Y', strtotime($p['published_at'])) : '';

$badgeClass = function ($type) {
    $type = strtolower((string)$type);
    if ($type === 'popular') return 'bg_orange';
    if ($type === 'latest')  return 'bg_violet';
    return 'bg_yellow'; // trending/default
};

// Safe slices for sections
$featuredTop  = array_slice($featuredPosts ?? [], 0, 5);
$trendingTop  = array_slice($trendingPosts ?? [], 0, 5);
$popularTop   = array_slice($popularPosts  ?? [], 0, 5);
$latestTop    = array_slice($latestPosts  ?? [], 0, 5);

// Main grids
$gridA = array_slice($latestPosts ?? [], 0, 4);        // 4 cards in grids
$sideLatestMini = array_slice($latestPosts ?? [], 0, 3); // sidebar mini list
$rightPopular = array_slice($popularPosts ?? [], 0, 4);
$rightTrendingNewest = array_slice($trendingPosts ?? [], 0, 3);

// Fallback for "Most Commented" (if you don't have comment_count in DB yet)
$rightTrendingCommented = array_slice($popularPosts ?? [], 0, 3);
$rightTrendingPopular = array_slice($popularPosts ?? [], 0, 3);
?>

<section id="news" class="pt-4 pb-5 bg-light">
	<div class="container-xl">
		<div class="row news_1">
			<div class="col-md-8">
				<div class="news_1_left">
					<div class="news_1_left1 p-3 bg-white border_thick">
						<div class="news_1_left1_inner row">
							<div class="col-md-3 col-sm-4">
								<div class="news_1_left1_inner_left pt-1">
									<b class="d-block text-uppercase">Featured News</b>
								</div>
							</div>
							<div class="col-md-9 col-sm-8">
								<div class="news_1_left1_inner_right">
									<ul class="nav nav-tabs mb-0 fw-bold font_11 border-0 justify-content-end">
										<li class="nav-item d-inline-block">
											<a href="#home" data-bs-toggle="tab" aria-expanded="false" class="nav-link active text-center">
												<span class="d-md-block text-uppercase">All</span>
											</a>
										</li>
										<li class="nav-item d-inline-block">
											<a href="#profile1" data-bs-toggle="tab" aria-expanded="true" class="nav-link text-center">
												<span class="d-md-block text-uppercase">Trending</span>
											</a>
										</li>
										<li class="nav-item d-inline-block">
											<a href="#profile2" data-bs-toggle="tab" aria-expanded="true" class="nav-link border-end-0 text-center">
												<span class="d-md-block text-uppercase">Popular</span>
											</a>
										</li>

										<li class="nav-item d-inline-block">
											<a href="#profile3" data-bs-toggle="tab" aria-expanded="true" class="nav-link border-end-0 text-center">
												<span class="d-md-block text-uppercase">Latest</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>

					<!-- TOP CAROUSEL TABS -->
					<div class="news_1_left2 mt-3">
						<div class="tab-content">

							<!-- ALL -->
							<div class="tab-pane active" id="home">
								<?php if (!empty($featuredTop)): ?>
								<div id="carouselExampleCaptions1" class="carousel slide" data-bs-ride="carousel">
									<div class="carousel-indicators">
										<?php foreach ($featuredTop as $i => $p): ?>
											<button type="button" data-bs-target="#carouselExampleCaptions1" data-bs-slide-to="<?= $i ?>"
												class="<?= $i === 0 ? 'active' : '' ?>" aria-label="Slide <?= $i + 1 ?>"></button>
										<?php endforeach; ?>
									</div>
									<div class="carousel-inner">
										<?php foreach ($featuredTop as $i => $p): ?>
										<div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
											<div class="news_1_left2_inner position-relative">
												<div class="news_1_left2_inner1">
													<a href="<?= $postUrl($p) ?>"><img src="<?= $postImg($p) ?>" class="img-fluid" alt="<?= $e($p['title']) ?>"></a>
												</div>
												<div class="news_1_left2_inner2 position-absolute bottom-0 px-4 bg_back w-100 h-100 top-0">
													<ul class="mb-0">
														<li class="d-flex">
															<span class="flex-column">
																<b class="d-inline-block bg_yellow text-white p-1 px-3 font_10 text-uppercase rounded-1"><?= $e($p['category_name'] ?? 'Featured') ?></b>
																<b class="d-block fs-2 text-uppercase mt-2 mb-2">
																	<a class="text-white" href="<?= $postUrl($p) ?>"><?= $e($p['title']) ?></a>
																</b>
																<span class="text-light font_11 fw-bold text-uppercase">
																	<img src="<?= $avatarImg($i) ?>" class="me-2 rounded-circle" alt="abc">
																	<?= $e($p['category_name'] ?? 'News') ?> - <?= $postDate($p) ?>
																</span>
															</span>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<?php endforeach; ?>
									</div>
								</div>
								<?php else: ?>
									<div class="p-4 bg-white border_light">Chưa có dữ liệu Featured.</div>
								<?php endif; ?>
							</div>

							<!-- TRENDING -->
							<div class="tab-pane" id="profile1">
								<?php if (!empty($trendingTop)): ?>
								<div id="carouselExampleCaptions2" class="carousel slide" data-bs-ride="carousel">
									<div class="carousel-indicators">
										<?php foreach ($trendingTop as $i => $p): ?>
											<button type="button" data-bs-target="#carouselExampleCaptions2" data-bs-slide-to="<?= $i ?>"
												class="<?= $i === 0 ? 'active' : '' ?>" aria-label="Slide <?= $i + 1 ?>"></button>
										<?php endforeach; ?>
									</div>
									<div class="carousel-inner">
										<?php foreach ($trendingTop as $i => $p): ?>
										<div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
											<div class="news_1_left2_inner position-relative">
												<div class="news_1_left2_inner1">
													<a href="<?= $postUrl($p) ?>"><img src="<?= $postImg($p) ?>" class="img-fluid" alt="<?= $e($p['title']) ?>"></a>
												</div>
												<div class="news_1_left2_inner2 position-absolute bottom-0 px-4 bg_back w-100 h-100 top-0">
													<ul class="mb-0">
														<li class="d-flex">
															<span class="flex-column">
																<b class="d-inline-block bg_yellow text-white p-1 px-3 font_10 text-uppercase rounded-1">Trending</b>
																<b class="d-block fs-2 text-uppercase mt-2 mb-2">
																	<a class="text-white" href="<?= $postUrl($p) ?>"><?= $e($p['title']) ?></a>
																</b>
																<span class="text-light font_11 fw-bold text-uppercase">
																	<img src="<?= $avatarImg($i) ?>" class="me-2 rounded-circle" alt="abc">
																	<?= $e($p['category_name'] ?? 'News') ?> - <?= $postDate($p) ?>
																</span>
															</span>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<?php endforeach; ?>
									</div>
								</div>
								<?php else: ?>
									<div class="p-4 bg-white border_light">Chưa có dữ liệu Trending.</div>
								<?php endif; ?>
							</div>

							<!-- POPULAR -->
							<div class="tab-pane" id="profile2">
								<?php if (!empty($popularTop)): ?>
								<div id="carouselExampleCaptions3" class="carousel slide" data-bs-ride="carousel">
									<div class="carousel-indicators">
										<?php foreach ($popularTop as $i => $p): ?>
											<button type="button" data-bs-target="#carouselExampleCaptions3" data-bs-slide-to="<?= $i ?>"
												class="<?= $i === 0 ? 'active' : '' ?>" aria-label="Slide <?= $i + 1 ?>"></button>
										<?php endforeach; ?>
									</div>
									<div class="carousel-inner">
										<?php foreach ($popularTop as $i => $p): ?>
										<div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
											<div class="news_1_left2_inner position-relative">
												<div class="news_1_left2_inner1">
													<a href="<?= $postUrl($p) ?>"><img src="<?= $postImg($p) ?>" class="img-fluid" alt="<?= $e($p['title']) ?>"></a>
												</div>
												<div class="news_1_left2_inner2 position-absolute bottom-0 px-4 bg_back w-100 h-100 top-0">
													<ul class="mb-0">
														<li class="d-flex">
															<span class="flex-column">
																<b class="d-inline-block bg_orange text-white p-1 px-3 font_10 text-uppercase rounded-1">Popular</b>
																<b class="d-block fs-2 text-uppercase mt-2 mb-2">
																	<a class="text-white" href="<?= $postUrl($p) ?>"><?= $e($p['title']) ?></a>
																</b>
																<span class="text-light font_11 fw-bold text-uppercase">
																	<img src="<?= $avatarImg($i + 1) ?>" class="me-2 rounded-circle" alt="abc">
																	<?= $e($p['category_name'] ?? 'News') ?> - <?= $postDate($p) ?>
																</span>
															</span>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<?php endforeach; ?>
									</div>
								</div>
								<?php else: ?>
									<div class="p-4 bg-white border_light">Chưa có dữ liệu Popular.</div>
								<?php endif; ?>
							</div>

							<!-- LATEST -->
							<div class="tab-pane" id="profile3">
								<?php if (!empty($latestTop)): ?>
								<div id="carouselExampleCaptions4" class="carousel slide" data-bs-ride="carousel">
									<div class="carousel-indicators">
										<?php foreach ($latestTop as $i => $p): ?>
											<button type="button" data-bs-target="#carouselExampleCaptions4" data-bs-slide-to="<?= $i ?>"
												class="<?= $i === 0 ? 'active' : '' ?>" aria-label="Slide <?= $i + 1 ?>"></button>
										<?php endforeach; ?>
									</div>
									<div class="carousel-inner">
										<?php foreach ($latestTop as $i => $p): ?>
										<div class="carousel-item <?= $i === 0 ? 'active' : '' ?>">
											<div class="news_1_left2_inner position-relative">
												<div class="news_1_left2_inner1">
													<a href="<?= $postUrl($p) ?>"><img src="<?= $postImg($p) ?>" class="img-fluid" alt="<?= $e($p['title']) ?>"></a>
												</div>
												<div class="news_1_left2_inner2 position-absolute bottom-0 px-4 bg_back w-100 h-100 top-0">
													<ul class="mb-0">
														<li class="d-flex">
															<span class="flex-column">
																<b class="d-inline-block bg_violet text-white p-1 px-3 font_10 text-uppercase rounded-1">Latest</b>
																<b class="d-block fs-2 text-uppercase mt-2 mb-2">
																	<a class="text-white" href="<?= $postUrl($p) ?>"><?= $e($p['title']) ?></a>
																</b>
																<span class="text-light font_11 fw-bold text-uppercase">
																	<img src="<?= $avatarImg($i) ?>" class="me-2 rounded-circle" alt="abc">
																	<?= $e($p['category_name'] ?? 'News') ?> - <?= $postDate($p) ?>
																</span>
															</span>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<?php endforeach; ?>
									</div>
								</div>
								<?php else: ?>
									<div class="p-4 bg-white border_light">Chưa có dữ liệu Latest.</div>
								<?php endif; ?>
							</div>

						</div>
					</div>

					<!-- ======= MAIN GRID (kept structure, data bound) ======= -->
					<div class="news_1_left3 mt-3">
						<div class="row row-cols-1 row-cols-lg-2 row-cols-md-1">
							<?php foreach (array_slice($gridA, 0, 2) as $i => $p): ?>
							<div class="col">
								<div class="card">
									<div class="card-body p-0">
										<div class="blog_1 position-relative">
											<div class="blog_1_inner_top">
												<a href="<?= $postUrl($p) ?>"><img src="<?= $postImg($p) ?>" class="img-fluid" alt="..."></a>
											</div>
											<div class="blog_1_inner position-absolute top-0 p-3">
												<b class="d-inline-block <?= $badgeClass($i === 0 ? 'latest' : 'popular') ?> text-white p-1 px-3 font_10 text-uppercase rounded-1">
													<?= $e($p['category_name'] ?? ($i === 0 ? 'Latest' : 'Popular')) ?>
												</b>
											</div>
											<div class="blog_1_inner_1 position-absolute text-end w-100 p-3">
												<ul class="mb-0">
													<li class="d-block fs-6 mt-2"><a class="d-block bg-info text-white  rounded-circle text-center icon_1 icon_2" href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
													<li class="d-block fs-6 mt-2"><a class="d-block bg-danger text-white  rounded-circle text-center icon_1 icon_2" href="#"><i class="fa-brands fa-twitter"></i></a></li>
													<li class="d-block fs-6 mt-2"><a class="d-block bg-success text-white  rounded-circle text-center icon_1 icon_2" href="#"><i class="fa-brands fa-pinterest-p"></i></a></li>
													<li class="d-block fs-6 mt-2"><a class="d-block bg_violet text-white  rounded-circle text-center icon_1 icon_2" href="#"><i class="fa-brands fa-instagram"></i></a></li>
													<li class="d-block fs-6 mt-2"><a class="d-block bg_yellow text-white  rounded-circle text-center icon_1"><i class="fa fa-plus"></i></a></li>
												</ul>
											</div>
										</div>
										<div class="blog_2 pt-3 pb-3">
											<span class="light_gray font_12 fw-bold px-3 text-uppercase"><?= $postDate($p) ?></span>
											<b class="d-block fs-5 text-uppercase mt-2 px-3">
												<a href="<?= $postUrl($p) ?>"><?= $e($p['title']) ?></a>
											</b>
											<p class="gray_dark mt-3 px-3 mb-0"><?= $e($p['summary'] ?? '') ?></p>
											<hr>
											<ul class="mb-0 px-3 font_11 fw-bold text-uppercase justify-content-between d-flex">
												<li>
													<a href="<?= $postUrl($p) ?>"><img class="rounded-circle" alt="abc" src="<?= $avatarImg($i) ?>"></a>
													<span class="light_gray ms-2"><?= $e($p['category_name'] ?? 'Author') ?></span>
												</li>
												<li class="my-auto">
													<a class="light_gray" href="<?= $postUrl($p) ?>"><i class="fa fa-eye me-1"></i> <?= (int)($p['view_count'] ?? 0) ?></a>
													<a class="light_gray mx-3" href="#"><i class="fa fa-heart me-1 text-danger"></i> 0</a>
													<a class="light_gray" href="#"><i class="fa fa-comment me-1"></i> 0</a>
												</li>
											</ul>
										</div>

									</div>
								</div>
							</div>
							<?php endforeach; ?>
						</div>

						<div class="row row-cols-1  row-cols-lg-2 row-cols-md-1 mt-3">
							<?php foreach (array_slice($gridA, 2, 1) as $i => $p): ?>
							<div class="col">
								<div class="card">
									<div class="card-body p-0">
										<div class="blog_1 position-relative">
											<div class="blog_1_inner_top">
												<a href="<?= $postUrl($p) ?>"><img src="<?= $postImg($p) ?>" class="img-fluid" alt="..."></a>
											</div>
											<div class="blog_1_inner position-absolute top-0 p-3">
												<b class="d-inline-block bg_yellow text-white p-1 px-3 font_10 text-uppercase rounded-1"><?= $e($p['category_name'] ?? 'News') ?></b>
											</div>
											<div class="blog_1_inner_1 position-absolute text-end w-100 p-3">
												<ul class="mb-0">
													<li class="d-block fs-6 mt-2"><a class="d-block bg-info text-white  rounded-circle text-center icon_1 icon_2" href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
													<li class="d-block fs-6 mt-2"><a class="d-block bg-danger text-white  rounded-circle text-center icon_1 icon_2" href="#"><i class="fa-brands fa-twitter"></i></a></li>
													<li class="d-block fs-6 mt-2"><a class="d-block bg-success text-white  rounded-circle text-center icon_1 icon_2" href="#"><i class="fa-brands fa-pinterest-p"></i></a></li>
													<li class="d-block fs-6 mt-2"><a class="d-block bg_violet text-white  rounded-circle text-center icon_1 icon_2" href="#"><i class="fa-brands fa-instagram"></i></a></li>
													<li class="d-block fs-6 mt-2"><a class="d-block bg_yellow text-white  rounded-circle text-center icon_1"><i class="fa fa-plus"></i></a></li>
												</ul>
											</div>
										</div>
										<div class="blog_2 pt-3 pb-3">
											<span class="light_gray font_12 fw-bold px-3 text-uppercase"><?= $postDate($p) ?></span>
											<b class="d-block fs-5 text-uppercase mt-2 px-3"><a href="<?= $postUrl($p) ?>"><?= $e($p['title']) ?></a></b>
											<p class="gray_dark mt-3 px-3 mb-0"><?= $e($p['summary'] ?? '') ?></p>
											<hr>
											<ul class="mb-0 px-3 font_11 fw-bold text-uppercase justify-content-between d-flex">
												<li>
													<a href="<?= $postUrl($p) ?>"><img class="rounded-circle" alt="abc" src="<?= $avatarImg(0) ?>"></a>
													<span class="light_gray ms-2"><?= $e($p['category_name'] ?? 'Author') ?></span>
												</li>
												<li class="my-auto">
													<a class="light_gray" href="<?= $postUrl($p) ?>"><i class="fa fa-eye me-1"></i> <?= (int)($p['view_count'] ?? 0) ?></a>
													<a class="light_gray mx-3" href="#"><i class="fa fa-heart me-1 text-danger"></i> 0</a>
													<a class="light_gray" href="#"><i class="fa fa-comment me-1"></i> 0</a>
												</li>
											</ul>
										</div>

									</div>
								</div>
							</div>
							<?php endforeach; ?>

							<div class="col">
								<div class="blog_left bg-white pt-3 pb-3 border_light">
									<ul class="mb-0">
										<?php foreach ($sideLatestMini as $i => $p): ?>
										<li class="<?= $i < count($sideLatestMini) - 1 ? 'border-bottom pb-3 mb-3' : '' ?>">
											<?php
												$label = ($i === 0) ? 'Latest' : (($i === 1) ? 'Popular' : 'Trending');
												$cls   = ($i === 1) ? 'bg_orange' : 'bg_yellow';
											?>
											<b class="d-inline-block <?= $cls ?> text-white p-1 px-3 font_10 text-uppercase rounded-1 mx-3"><?= $label ?></b>
											<b class="d-block font_15 text-uppercase mt-2  px-3"><a href="<?= $postUrl($p) ?>"><?= $e($p['title']) ?></a></b>
											<span class="light_gray font_10 fw-bold  text-uppercase px-3">
												<i class="fa fa-clock me-1 text-warning align-middle"></i> <?= $postDate($p) ?>
											</span>
											<span class="gray_dark mt-3 px-3 font_12 mb-0 d-block"><?= $e($p['summary'] ?? '') ?></span>
										</li>
										<?php endforeach; ?>
										<?php if (empty($sideLatestMini)): ?>
											<li class="px-3">Chưa có dữ liệu.</li>
										<?php endif; ?>
									</ul>
								</div>
							</div>
						</div>
					</div>

					<!-- Dark featured block (use latest first) -->
					<?php $hero = ($latestPosts[0] ?? $featuredPosts[0] ?? null); ?>
					<?php if ($hero): ?>
					<div class="news_1_left4 mt-3 bg-dark  rounded-1">
						<div class="row row-cols-1  row-cols-lg-2 row-cols-md-1">
							<div class="col">
								<div class="news_1_left4_left">
									<a href="<?= $postUrl($hero) ?>"><img src="<?= $postImg($hero) ?>" class="img-fluid" alt="..."></a>
								</div>
							</div>
							<div class="col">
								<div class="news_1_left4_right pt-4">
									<ul class="mb-0">
										<li>
											<b class="d-inline-block bg_yellow text-white p-1 px-3 font_10 text-uppercase rounded-1">Latest</b>
											<b class="d-block fs-4 text-uppercase mt-2 mb-2"><a class="text-white" href="<?= $postUrl($hero) ?>"><?= $e($hero['title']) ?></a></b>
											<span class="light_gray font_10 fw-bold  text-uppercase"> <i class="fa fa-clock me-1 text-warning align-middle"></i> <?= $postDate($hero) ?></span>
											<span class="gray_dark mt-3  font_12 mb-0 d-block"><?= $e($hero['summary'] ?? '') ?></span>
											<span class="mb-0 mt-4 d-block"><a class="button" href="<?= $postUrl($hero) ?>">Read More <i class="fa fa-arrow-right ms-2 col_yellow"></i></a></span>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<?php endif; ?>

					<!-- ================== LATEST NEWS (tabbed list) ================== -->
					<div class="news_1_left1 p-3 bg-white border_thick mt-3">
						<div class="news_1_left1_inner row">
							<div class="col-md-3 col-sm-4">
								<div class="news_1_left1_inner_left pt-1">
									<b class="d-block text-uppercase">Latest News</b>
								</div>
							</div>
							<div class="col-md-9 col-sm-8">
								<div class="news_1_left1_inner_right">
									<ul class="nav nav-tabs mb-0 fw-bold font_11 border-0 justify-content-end">
										<li class="nav-item d-inline-block">
											<a href="#profile4" data-bs-toggle="tab" aria-expanded="false" class="nav-link active text-center">
												<span class="d-md-block text-uppercase">All</span>
											</a>
										</li>
										<li class="nav-item d-inline-block">
											<a href="#profile5" data-bs-toggle="tab" aria-expanded="true" class="nav-link text-center">
												<span class="d-md-block text-uppercase">Trending</span>
											</a>
										</li>
										<li class="nav-item d-inline-block">
											<a href="#profile6" data-bs-toggle="tab" aria-expanded="true" class="nav-link border-end-0 text-center">
												<span class="d-md-block text-uppercase">Popular</span>
											</a>
										</li>
										<li class="nav-item d-inline-block">
											<a href="#profile7" data-bs-toggle="tab" aria-expanded="true" class="nav-link border-end-0 text-center">
												<span class="d-md-block text-uppercase">Latest</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>

					<div class="news_1_left2 mt-3">
						<div class="tab-content">

							<?php
								$tabAll = array_slice($latestPosts ?? [], 0, 4);
								$tabTrend = array_slice($trendingPosts ?? [], 0, 4);
								$tabPop = array_slice($popularPosts ?? [], 0, 4);
								$tabLatest = array_slice($latestPosts ?? [], 0, 4);

								$renderCardRow = function ($p, $label, $badge) use ($postUrl, $postImg, $postDate, $e, $avatarImg) {
									?>
									<div class="card mt-3">
										<div class="card-body p-0">
											<div class="row row-cols-1 row-cols-sm-1 row-cols-lg-2 row-cols-md-1 mx-0">
												<div class="col p-0">
													<div class="blog_inner_left position-relative">
														<div class="blog_inner_left1">
															<a href="<?= $postUrl($p) ?>"><img src="<?= $postImg($p) ?>" class="img-fluid" alt="..."></a>
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
														<b class="d-inline-block <?= $badge ?> text-white p-1 px-3 font_10 text-uppercase rounded-1 mx-3"><?= $label ?></b>
														<b class="d-block fs-5 text-uppercase mt-2 mb-1 px-3"><a href="<?= $postUrl($p) ?>"><?= $e($p['title']) ?></a></b>
														<span class="light_gray font_12 fw-bold px-3 text-uppercase"><?= $postDate($p) ?></span>

														<p class="mt-3 px-3 mb-0 pb-4"><?= $e($p['summary'] ?? '') ?></p>
														<div class="mt-auto w-100">
															<ul class="mb-0 px-3 py-3 font_11 fw-bold text-uppercase justify-content-between d-flex border-top">
																<li>
																	<a href="<?= $postUrl($p) ?>"><img class="rounded-circle" alt="abc" src="<?= $avatarImg(0) ?>"></a>
																	<span class="light_gray ms-2"><?= $e($p['category_name'] ?? 'Author') ?></span>
																</li>
																<li class="my-auto">
																	<a class="light_gray" href="<?= $postUrl($p) ?>"><i class="fa fa-eye me-1"></i> <?= (int)($p['view_count'] ?? 0) ?></a>
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
									<?php
								};
							?>

							<div class="tab-pane active" id="profile4">
								<?php foreach ($tabAll as $i => $p) $renderCardRow($p, ($i % 2 ? 'Popular' : 'Latest'), ($i % 2 ? 'bg_orange' : 'bg_yellow')); ?>
								<?php if (empty($tabAll)): ?><div class="p-4 bg-white border_light">Chưa có dữ liệu.</div><?php endif; ?>
							</div>

							<div class="tab-pane" id="profile5">
								<?php foreach ($tabTrend as $p) $renderCardRow($p, 'Trending', 'bg_yellow'); ?>
								<?php if (empty($tabTrend)): ?><div class="p-4 bg-white border_light">Chưa có dữ liệu.</div><?php endif; ?>
							</div>

							<div class="tab-pane" id="profile6">
								<?php foreach ($tabPop as $p) $renderCardRow($p, 'Popular', 'bg_orange'); ?>
								<?php if (empty($tabPop)): ?><div class="p-4 bg-white border_light">Chưa có dữ liệu.</div><?php endif; ?>
							</div>

							<div class="tab-pane" id="profile7">
								<?php foreach ($tabLatest as $p) $renderCardRow($p, 'Latest', 'bg_violet'); ?>
								<?php if (empty($tabLatest)): ?><div class="p-4 bg-white border_light">Chưa có dữ liệu.</div><?php endif; ?>
							</div>
						</div>
					</div>

				</div>
			</div>

			<!-- RIGHT SIDEBAR -->
			<div class="col-md-4">
				<div class="news_1_right">

					<!-- Social blocks (kept) -->
					<div class="news_1_right1">
						<ul class="mb-0 bg_violet d-flex justify-content-between">
							<li><a class="bg_violet_dark social_icon d-inline-block text-center text-white" href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
							<li class="lh-1 social_text text-uppercase">
								<a class="text-white" href="#">
									<span class="font_13">
										<b>Like Our Facebook Page </b><br>
										<span class="font_11">86500 Likes</span>
									</span>
								</a>
							</li>
							<li class="pt-3 pe-3"><a class="rounded-circle plus_icon rounded-circle text-white d-inline-block font_14 text-center" href="#"><i class="fa-brands fa-plus"></i></a></li>
						</ul>
						<ul class="mb-0 bg-primary d-flex justify-content-between mt-3">
							<li><a class="bg_primary_dark social_icon d-inline-block text-center text-white" href="#"><i class="fa-brands fa-twitter"></i></a></li>
							<li class="lh-1 social_text text-uppercase">
								<a class="text-white" href="#">
									<span class="font_13">
										<b>Follow us twitter Page </b><br>
										<span class="font_11">58500 Followers</span>
									</span>
								</a>
							</li>
							<li class="pt-3 pe-3"><a class="rounded-circle plus_icon rounded-circle text-white d-inline-block font_14 text-center" href="#"><i class="fa-brands fa-plus"></i></a></li>
						</ul>
						<ul class="mb-0 bg_yellow d-flex justify-content-between mt-3">
							<li><a class="bg_warning_dark social_icon d-inline-block text-center text-white" href="#"><i class="fa fa-rss"></i></a></li>
							<li class="lh-1 social_text text-uppercase">
								<a class="text-white" href="#">
									<span class="font_13">
										<b>Subscribe to our rss </b><br>
										<span class="font_11">585 Subscribers</span>
									</span>
								</a>
							</li>
							<li class="pt-3 pe-3"><a class="rounded-circle plus_icon rounded-circle text-white d-inline-block font_14 text-center" href="#"><i class="fa-brands fa-plus"></i></a></li>
						</ul>
					</div>

					<!-- Popular News list (dynamic) -->
					<div class="news_1_right1 bg-white mt-3 border_light">
						<b class="d-block text-uppercase p-3 border_thick">Popular News</b>
						<ul class="mb-0 border-top pt-3">
							<?php foreach ($rightPopular as $i => $p): ?>
							<li class="d-flex <?= $i < count($rightPopular)-1 ? 'border-bottom pb-3 mb-3' : 'pb-3' ?>">
								<span class="ps-3">
									<a href="<?= $postUrl($p) ?>"><img width="70" alt="abc" src="<?= $postImg($p) ?>"></a>
								</span>
								<span class="flex-column mx-3">
									<?php $lbl = ($i % 2 === 0) ? 'Latest' : 'Popular'; $cls = ($i % 2 === 0) ? 'bg_violet' : 'bg_yellow'; ?>
									<b class="d-inline-block <?= $cls ?> text-white p-1 px-3 font_10 text-uppercase rounded-1"><?= $lbl ?></b>
									<b class="d-block font_13 text-uppercase mt-1"><a href="<?= $postUrl($p) ?>"><?= $e($p['title']) ?></a></b>
									<span class="light_gray font_10 fw-bold  text-uppercase"> <i class="fa fa-clock me-1 text-warning align-middle"></i> <?= $postDate($p) ?></span>
								</span>
							</li>
							<?php endforeach; ?>
							<?php if (empty($rightPopular)): ?>
								<li class="px-3 pb-3">Chưa có dữ liệu.</li>
							<?php endif; ?>
						</ul>
					</div>

					<!-- Trending News tabs (dynamic) -->
					<div class="news_1_right1 bg-white mt-3 border_light">
						<b class="d-block text-uppercase p-3 border_thick">Trending News</b>
						<div class="news_1_left1_inner_right">
							<ul class="nav nav-tabs mb-0 fw-bold font_11 border-top border-bottom pt-1 pb-1 justify-content-around">
								<li class="nav-item d-inline-block">
									<a href="#profile8" data-bs-toggle="tab" aria-expanded="false" class="nav-link active text-center">
										<span class="d-md-block text-uppercase">Newest</span>
									</a>
								</li>
								<li class="nav-item d-inline-block">
									<a href="#profile9" data-bs-toggle="tab" aria-expanded="true" class="nav-link text-center">
										<span class="d-md-block text-uppercase">Most Commented</span>
									</a>
								</li>
								<li class="nav-item d-inline-block">
									<a href="#profile10" data-bs-toggle="tab" aria-expanded="true" class="nav-link border-end-0 text-center">
										<span class="d-md-block text-uppercase">Popular</span>
									</a>
								</li>
							</ul>
						</div>

						<div class="tab-content">
							<div class="tab-pane active" id="profile8">
								<div class="profile8_inner">
									<ul class="mb-0 mt-3">
										<?php foreach ($rightTrendingNewest as $i => $p): ?>
										<li class="<?= $i < count($rightTrendingNewest)-1 ? 'border-bottom pb-3 mb-3' : 'pb-3' ?>">
											<b class="d-inline-block bg_yellow text-white p-1 px-3 font_10 text-uppercase rounded-1 mx-3">Newest</b>
											<b class="d-block font_15 text-uppercase mt-2  px-3"><a href="<?= $postUrl($p) ?>"><?= $e($p['title']) ?></a></b>
											<span class="light_gray font_10 fw-bold  text-uppercase px-3"> <i class="fa fa-clock me-1 text-warning align-middle"></i> <?= $postDate($p) ?></span>
											<span class="gray_dark mt-3 px-3 font_12 mb-0 d-block"><?= $e($p['summary'] ?? '') ?></span>
										</li>
										<?php endforeach; ?>
										<?php if (empty($rightTrendingNewest)): ?>
											<li class="px-3 pb-3">Chưa có dữ liệu.</li>
										<?php endif; ?>
									</ul>
								</div>
							</div>

							<div class="tab-pane" id="profile9">
								<div class="profile8_inner">
									<ul class="mb-0 mt-3">
										<?php foreach ($rightTrendingCommented as $i => $p): ?>
										<li class="<?= $i < count($rightTrendingCommented)-1 ? 'border-bottom pb-3 mb-3' : 'pb-3' ?>">
											<b class="d-inline-block bg_orange text-white p-1 px-3 font_10 text-uppercase rounded-1 mx-3">Commented</b>
											<b class="d-block font_15 text-uppercase mt-2  px-3"><a href="<?= $postUrl($p) ?>"><?= $e($p['title']) ?></a></b>
											<span class="light_gray font_10 fw-bold  text-uppercase px-3"> <i class="fa fa-clock me-1 text-warning align-middle"></i> <?= $postDate($p) ?></span>
											<span class="gray_dark mt-3 px-3 font_12 mb-0 d-block"><?= $e($p['summary'] ?? '') ?></span>
										</li>
										<?php endforeach; ?>
										<?php if (empty($rightTrendingCommented)): ?>
											<li class="px-3 pb-3">Chưa có dữ liệu.</li>
										<?php endif; ?>
									</ul>
								</div>
							</div>

							<div class="tab-pane" id="profile10">
								<ul class="mb-0 mt-3">
									<?php foreach ($rightTrendingPopular as $i => $p): ?>
									<li class="<?= $i < count($rightTrendingPopular)-1 ? 'border-bottom pb-3 mb-3' : 'pb-3' ?>">
										<b class="d-inline-block bg_yellow text-white p-1 px-3 font_10 text-uppercase rounded-1 mx-3">Popular</b>
										<b class="d-block font_15 text-uppercase mt-2  px-3"><a href="<?= $postUrl($p) ?>"><?= $e($p['title']) ?></a></b>
										<span class="light_gray font_10 fw-bold  text-uppercase px-3"> <i class="fa fa-clock me-1 text-warning align-middle"></i> <?= $postDate($p) ?></span>
										<span class="gray_dark mt-3 px-3 font_12 mb-0 d-block"><?= $e($p['summary'] ?? '') ?></span>
									</li>
									<?php endforeach; ?>
									<?php if (empty($rightTrendingPopular)): ?>
										<li class="px-3 pb-3">Chưa có dữ liệu.</li>
									<?php endif; ?>
								</ul>
							</div>

						</div>
					</div>

					<!-- Tags (kept) -->
					<div class="news_1_right1 bg-white mt-3 border_light pb-3">
						<b class="d-block text-uppercase p-3 border_thick">Popular tags</b>
						<ul class="mb-0 d-flex flex-wrap text-uppercase font_11 tags border-top px-3 pt-3">
							<li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">News</a></li>
							<li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">Headlines</a></li>
							<li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">Sports</a></li>
							<li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">Cricket</a></li>
							<li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">Event</a></li>
							<li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">Popular</a></li>
							<li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">Trending</a></li>
						</ul>
					</div>

					<!-- Newsletter (kept) -->
					<div class="news_1_right1 bg-white mt-3 border_light pb-4">
						<b class="d-block text-uppercase p-3 border_thick">Our Newsletter</b>
						<b class="px-3 text-uppercase font_11 border-top pt-3 d-block">Subscribe Now!</b>
						<p class="px-3 mt-2 mb-3">Aliqm Lorem Ante, Dapibus In, Viverra Feugiat Phasellus.</p>
						<div class="input-group px-3">
							<input type="text" class="form-control font_11" placeholder="Your Email address...">
							<span class="input-group-btn">
								<button class="btn btn-primary bg_violet_dark border-0 rounded-0 p-3 px-4 font_11" type="button">SEND</button>
							</span>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>
</section>

<?= $this->endSection() ?>
