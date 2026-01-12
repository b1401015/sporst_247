<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
/**
 * HOME VIEW - CodeIgniter 4
 * Vars from controller:
 * - $featuredPosts, $trendingPosts, $popularPosts, $latestPosts
 * - $bannerAll, $bannerTrending, $bannerPopular, $bannerLatest (2 items each)
 * - optional $videos, $ads
 */

helper('post'); // dùng post_url(), post_img(), post_date()

// decode entity + esc để không bị &Aacute;
$clean = fn($v) => esc(html_entity_decode($v ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8'));

$featuredPosts = $featuredPosts ?? [];
$trendingPosts = $trendingPosts ?? [];
$popularPosts  = $popularPosts  ?? [];
$latestPosts   = $latestPosts   ?? [];

$bannerAll      = $bannerAll      ?? [];
$bannerTrending = $bannerTrending ?? [];
$bannerPopular  = $bannerPopular  ?? [];
$bannerLatest   = $bannerLatest   ?? [];

// Slices
$gridA           = array_slice($latestPosts, 0, 4);
$sideLatestMini  = array_slice($latestPosts, 0, 3);
$rightPopular    = array_slice($popularPosts, 0, 4);
$rightTrendNew   = array_slice($trendingPosts, 0, 3);

// fallback tab phải (nếu chưa có comment_count)
$rightTrendCmt   = array_slice($popularPosts, 0, 3);
$rightTrendPop   = array_slice($popularPosts, 0, 3);

// Hero
$hero = $latestPosts[0] ?? $featuredPosts[0] ?? null;

// badge map
$badgeClass = function(string $type){
    $type = strtolower($type);
    return match($type){
        'popular' => 'bg_orange',
        'latest'  => 'bg_violet',
        default   => 'bg_yellow',
    };
};
?>

<section id="news" class="pt-4 pb-5 bg-light">
	<div class="container-xl">
		<div class="row news_1">
			<div class="col-md-8">
				<div class="news_1_left">

					<!-- HEADER TABS 1 -->
					<div class="news_1_left1 p-3 bg-white border_thick">
						<div class="news_1_left1_inner row">
							<div class="col-md-3 col-sm-4">
								<div class="news_1_left1_inner_left pt-1">
									<b class="d-block text-uppercase">Tin nổi bật</b>
								</div>
							</div>
							<div class="col-md-9 col-sm-8">
								<div class="news_1_left1_inner_right">
									<ul class="nav nav-tabs mb-0 fw-bold font_11 border-0 justify-content-end">
										<li class="nav-item d-inline-block">
											<a href="#home" data-bs-toggle="tab" class="nav-link active text-center">
												<span class="d-md-block text-uppercase">Tất cả</span>
											</a>
										</li>
										<li class="nav-item d-inline-block">
											<a href="#profile1" data-bs-toggle="tab" class="nav-link text-center">
												<span class="d-md-block text-uppercase">Xu hướng</span>
											</a>
										</li>
										<li class="nav-item d-inline-block">
											<a href="#profile2" data-bs-toggle="tab" class="nav-link text-center border-end-0">
												<span class="d-md-block text-uppercase">Phổ biến</span>
											</a>
										</li>
										<li class="nav-item d-inline-block">
											<a href="#profile3" data-bs-toggle="tab" class="nav-link text-center border-end-0">
												<span class="d-md-block text-uppercase">Mới nhất</span>
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

							<div class="tab-pane active" id="home">
								<?= view('frontend/partials/_carousel', [
									'posts'      => $bannerAll,                 // ✅ dùng đúng biến controller
									'carouselId' => 'carouselExampleCaptions1',
									'badgeText'  => 'Nổi bật',
									'badgeClass' => 'bg_yellow',
									'clean'      => $clean,
								]) ?>
							</div>

							<div class="tab-pane" id="profile1">
								<?= view('frontend/partials/_carousel', [
									'posts'      => $bannerTrending,
									'carouselId' => 'carouselExampleCaptions2',
									'badgeText'  => 'Xu hướng',
									'badgeClass' => 'bg_yellow',
									'clean'      => $clean,
								]) ?>
							</div>

							<div class="tab-pane" id="profile2">
								<?= view('frontend/partials/_carousel', [
									'posts'      => $bannerPopular,
									'carouselId' => 'carouselExampleCaptions3',
									'badgeText'  => 'Phổ biến',
									'badgeClass' => 'bg_orange',
									'clean'      => $clean,
								]) ?>
							</div>

							<div class="tab-pane" id="profile3">
								<?= view('frontend/partials/_carousel', [
									'posts'      => $bannerLatest,
									'carouselId' => 'carouselExampleCaptions4',
									'badgeText'  => 'Mới nhất',
									'badgeClass' => 'bg_violet',
									'clean'      => $clean,
								]) ?>
							</div>

						</div>
					</div>

					<?= view('frontend/partials/_today_fixtures', [
						'todayMatches' => $todayMatches ?? []
					]) ?>


					<!-- ======= MAIN GRID ======= -->
					<div class="news_1_left3 mt-3">

						<div class="row row-cols-1 row-cols-lg-2 row-cols-md-1">
							<?php foreach (array_slice($gridA, 0, 2) as $i => $p): ?>
							<div class="col">
								<?= view('frontend/partials/_post_list_item', [
									'p'          => $p,
									'label'      => $p['category_name'] ?? (($i === 0) ? 'Mới nhất' : 'Phổ biến'),
									'badgeClass' => $badgeClass($i === 0 ? 'latest' : 'popular'),
									'clean'      => $clean,
									'showThumb'      => true,
								]) ?>
							</div>
							<?php endforeach; ?>
						</div>

						<div class="row row-cols-1 row-cols-lg-2 row-cols-md-1 mt-3">
							<?php foreach (array_slice($gridA, 2, 1) as $p): ?>
							<div class="col">
								<?= view('frontend/partials/_post_list_item', [
									'p'          => $p,
									'label'      => $p['category_name'] ?? 'Tin tức',
									'badgeClass' => 'bg_yellow',
									'clean'      => $clean,
								]) ?>
							</div>
							<?php endforeach; ?>

							<div class="col">
								<div class="blog_left bg-white pt-3 pb-3 border_light">
									<ul class="mb-0">
										<?php foreach ($sideLatestMini as $i => $p): ?>
										<li class="<?= $i < count($sideLatestMini) - 1 ? 'border-bottom pb-3 mb-3' : '' ?>">
											<?php
												$label = ($i === 0) ? 'Mới nhất' : (($i === 1) ? 'Phổ biến' : 'Xu hướng');
												$cls   = ($i === 1) ? 'bg_orange' : 'bg_yellow';
											?>
											<b class="d-inline-block <?= $cls ?> text-white p-1 px-3 font_10 text-uppercase rounded-1 mx-3"><?= $label ?></b>
											<b class="d-block font_15 text-uppercase mt-2 px-3">
												<a href="<?= post_url($p) ?>"><?= $clean($p['title'] ?? '') ?></a>
											</b>
											<span class="light_gray font_10 fw-bold text-uppercase px-3">
												<i class="fa fa-clock me-1 text-warning align-middle"></i> <?= esc(post_date($p)) ?>
											</span>
											<span class="gray_dark mt-3 px-3 font_12 mb-0 d-block"><?= $clean($p['summary'] ?? '') ?></span>
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

					<!-- Dark featured block -->
					<?php if ($hero): ?>
					<div class="news_1_left4 mt-3 bg-dark rounded-1">
						<div class="row row-cols-1 row-cols-lg-2 row-cols-md-1">
							<div class="col">
								<div class="news_1_left4_left">
									<a href="<?= post_url($hero) ?>"><img src="<?= post_img($hero) ?>" class="img-fluid" alt="..."></a>
								</div>
							</div>
							<div class="col">
								<div class="news_1_left4_right pt-4">
									<ul class="mb-0">
										<li>
											<b class="d-inline-block bg_yellow text-white p-1 px-3 font_10 text-uppercase rounded-1">Mới nhất</b>
											<b class="d-block fs-4 text-uppercase mt-2 mb-2">
												<a class="text-white" href="<?= post_url($hero) ?>"><?= $clean($hero['title'] ?? '') ?></a>
											</b>
											<span class="light_gray font_10 fw-bold text-uppercase">
												<i class="fa fa-clock me-1 text-warning align-middle"></i> <?= esc(post_date($hero)) ?>
											</span>
											<span class="gray_dark mt-3 font_12 mb-0 d-block"><?= $clean($hero['summary'] ?? '') ?></span>
											<span class="mb-0 mt-4 d-block">
												<a class="button" href="<?= post_url($hero) ?>">Xem thêm <i class="fa fa-arrow-right ms-2 col_yellow"></i></a>
											</span>
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
									<b class="d-block text-uppercase">Tin mới nhất</b>
								</div>
							</div>
							<div class="col-md-9 col-sm-8">
								<div class="news_1_left1_inner_right">
									<ul class="nav nav-tabs mb-0 fw-bold font_11 border-0 justify-content-end">
										<li class="nav-item d-inline-block">
											<a href="#profile4" data-bs-toggle="tab" class="nav-link active text-center">
												<span class="d-md-block text-uppercase">Tất cả</span>
											</a>
										</li>
										<li class="nav-item d-inline-block">
											<a href="#profile5" data-bs-toggle="tab" class="nav-link text-center">
												<span class="d-md-block text-uppercase">Xu hướng</span>
											</a>
										</li>
										<li class="nav-item d-inline-block">
											<a href="#profile6" data-bs-toggle="tab" class="nav-link text-center border-end-0">
												<span class="d-md-block text-uppercase">Phổ biến</span>
											</a>
										</li>
										<li class="nav-item d-inline-block">
											<a href="#profile7" data-bs-toggle="tab" class="nav-link text-center border-end-0">
												<span class="d-md-block text-uppercase">Mới nhất</span>
											</a>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>

					<?php
						$tabAll    = array_slice($latestPosts, 0, 4);
						$tabTrend  = array_slice($trendingPosts, 0, 4);
						$tabPop    = array_slice($popularPosts, 0, 4);
						$tabLatest = array_slice($latestPosts, 0, 4);
					?>

					<div class="news_1_left2 mt-3">
						<div class="tab-content">

							<div class="tab-pane active" id="profile4">
								<?php foreach ($tabAll as $i => $p): ?>
									<?= view('frontend/partials/_post_row_card', [
										'p'          => $p,
										'label'      => ($i % 2 ? 'Phổ biến' : 'Mới nhất'),
										'badgeClass' => ($i % 2 ? 'bg_orange' : 'bg_yellow'),
										'clean'      => $clean,
									]) ?>
								<?php endforeach; ?>
								<?php if (empty($tabAll)): ?><div class="p-4 bg-white border_light">Chưa có dữ liệu.</div><?php endif; ?>
							</div>

							<div class="tab-pane" id="profile5">
								<?php foreach ($tabTrend as $p): ?>
									<?= view('frontend/partials/_post_row_card', [
										'p'          => $p,
										'label'      => 'Xu hướng',
										'badgeClass' => 'bg_yellow',
										'clean'      => $clean,
									]) ?>
								<?php endforeach; ?>
								<?php if (empty($tabTrend)): ?><div class="p-4 bg-white border_light">Chưa có dữ liệu.</div><?php endif; ?>
							</div>

							<div class="tab-pane" id="profile6">
								<?php foreach ($tabPop as $p): ?>
									<?= view('frontend/partials/_post_row_card', [
										'p'          => $p,
										'label'      => 'Phổ biến',
										'badgeClass' => 'bg_orange',
										'clean'      => $clean,
									]) ?>
								<?php endforeach; ?>
								<?php if (empty($tabPop)): ?><div class="p-4 bg-white border_light">Chưa có dữ liệu.</div><?php endif; ?>
							</div>

							<div class="tab-pane" id="profile7">
								<?php foreach ($tabLatest as $p): ?>
									<?= view('frontend/partials/_post_row_card', [
										'p'          => $p,
										'label'      => 'Mới nhất',
										'badgeClass' => 'bg_violet',
										'clean'      => $clean,
									]) ?>
								<?php endforeach; ?>
								<?php if (empty($tabLatest)): ?><div class="p-4 bg-white border_light">Chưa có dữ liệu.</div><?php endif; ?>
							</div>

						</div>
					</div>

				</div>
			</div>

			<!-- RIGHT SIDEBAR -->
			<div class="col-md-4">
				<div class="news_1_right">

					<!-- Social blocks -->
					<div class="news_1_right1">
						<ul class="mb-0 bg_violet d-flex justify-content-between">
							<li><a class="bg_violet_dark social_icon d-inline-block text-center text-white" href="#"><i class="fa-brands fa-facebook-f"></i></a></li>
							<li class="lh-1 social_text text-uppercase">
								<a class="text-white" href="#">
									<span class="font_13">
										<b>Thích trang Facebook </b><br>
										<span class="font_11">86500 lượt thích</span>
									</span>
								</a>
							</li>
							<li class="pt-3 pe-3"><a class="rounded-circle plus_icon text-white d-inline-block font_14 text-center" href="#"><i class="fa-brands fa-plus"></i></a></li>
						</ul>

						<ul class="mb-0 bg-primary d-flex justify-content-between mt-3">
							<li><a class="bg_primary_dark social_icon d-inline-block text-center text-white" href="#"><i class="fa-brands fa-twitter"></i></a></li>
							<li class="lh-1 social_text text-uppercase">
								<a class="text-white" href="#">
									<span class="font_13">
										<b>Theo dõi Twitter </b><br>
										<span class="font_11">58500 người theo dõi</span>
									</span>
								</a>
							</li>
							<li class="pt-3 pe-3"><a class="rounded-circle plus_icon text-white d-inline-block font_14 text-center" href="#"><i class="fa-brands fa-plus"></i></a></li>
						</ul>

						<ul class="mb-0 bg_yellow d-flex justify-content-between mt-3">
							<li><a class="bg_warning_dark social_icon d-inline-block text-center text-white" href="#"><i class="fa fa-rss"></i></a></li>
							<li class="lh-1 social_text text-uppercase">
								<a class="text-white" href="#">
									<span class="font_13">
										<b>Đăng ký RSS </b><br>
										<span class="font_11">585 người đăng ký</span>
									</span>
								</a>
							</li>
							<li class="pt-3 pe-3"><a class="rounded-circle plus_icon text-white d-inline-block font_14 text-center" href="#"><i class="fa-brands fa-plus"></i></a></li>
						</ul>
					</div>

					<!-- Popular News list -->
					<div class="news_1_right1 bg-white mt-3 border_light">
						<b class="d-block text-uppercase p-3 border_thick">Tin phổ biến</b>
						<ul class="mb-0 border-top pt-3">
							<?php foreach ($rightPopular as $i => $p): ?>
							<li class="d-flex <?= $i < count($rightPopular)-1 ? 'border-bottom pb-3 mb-3' : 'pb-3' ?>">
								<span class="ps-3">
									<a href="<?= post_url($p) ?>"><img width="70" alt="abc" src="<?= post_img($p) ?>"></a>
								</span>
								<span class="flex-column mx-3">
									<?php
										$lbl = ($i % 2 === 0) ? 'Mới nhất' : 'Phổ biến';
										$cls = ($i % 2 === 0) ? 'bg_violet' : 'bg_yellow';
									?>
									<b class="d-inline-block <?= $cls ?> text-white p-1 px-3 font_10 text-uppercase rounded-1"><?= $lbl ?></b>
									<b class="d-block font_13 text-uppercase mt-1">
										<a href="<?= post_url($p) ?>"><?= $clean($p['title'] ?? '') ?></a>
									</b>
									<span class="light_gray font_10 fw-bold text-uppercase">
										<i class="fa fa-clock me-1 text-warning align-middle"></i> <?= esc(post_date($p)) ?>
									</span>
								</span>
							</li>
							<?php endforeach; ?>
							<?php if (empty($rightPopular)): ?>
								<li class="px-3 pb-3">Chưa có dữ liệu.</li>
							<?php endif; ?>
						</ul>
					</div>

					<!-- Trending News tabs -->
					 <?= view('frontend/partials/_epl_widget') ?>
					<!-- Tags -->
					<div class="news_1_right1 bg-white mt-3 border_light pb-3">
						<b class="d-block text-uppercase p-3 border_thick">Thẻ phổ biến</b>
						<ul class="mb-0 d-flex flex-wrap text-uppercase font_11 tags border-top px-3 pt-3">
							<li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">Tin tức</a></li>
							<li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">Tiêu điểm</a></li>
							<li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">Thể thao</a></li>
							<li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">Cricket</a></li>
							<li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">Sự kiện</a></li>
							<li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">Phổ biến</a></li>
							<li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">Xu hướng</a></li>
						</ul>
					</div>

					<!-- Newsletter -->
					<div class="news_1_right1 bg-white mt-3 border_light pb-4">
						<b class="d-block text-uppercase p-3 border_thick">Bản tin</b>
						<b class="px-3 text-uppercase font_11 border-top pt-3 d-block">Đăng ký ngay!</b>
						<p class="px-3 mt-2 mb-3">Aliqm Lorem Ante, Dapibus In, Viverra Feugiat Phasellus.</p>
						<div class="input-group px-3">
							<input type="text" class="form-control font_11" placeholder="Email của bạn...">
							<span class="input-group-btn">
								<button class="btn btn-primary bg_violet_dark border-0 rounded-0 p-3 px-4 font_11" type="button">GỬI</button>
							</span>
						</div>
					</div>

				</div>
			</div>

		</div>
	</div>
</section>

<?= $this->endSection() ?>
