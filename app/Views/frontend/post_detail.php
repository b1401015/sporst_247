<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
    $postTitle   = esc($post['title'] ?? 'News Detail');
    $postSlug    = $post['slug'] ?? null;
    $thumb       = $post['thumbnail'] ?? null;
    $thumbUrl    = $thumb ? base_url($thumb) : base_url('image/28.jpg');
    $createdAt   = $post['created_at'] ?? null;
    $dateText    = $createdAt ? date('M d, Y', strtotime($createdAt)) : '';
    $authorName  = esc($post['author_name'] ?? 'Admin');
    $categoryName= esc($post['category_name'] ?? ($post['category'] ?? 'News'));
    $viewCount   = (int) ($post['view_count'] ?? 0);
    $commentCount= is_array($comments ?? null) ? count($comments) : 0;
    $summary     = esc($post['summary'] ?? '');
    $content     = $post['content'] ?? '';
?>

<section id="contact" class="bg-light">
  <div class="container-fluid p-0">
    <div class="row mx-0">
      <div class="col-md-2 p-0">
        <div class="footer_bottom_left contact_left p-3 text-end position-relative d-none d-md-block">
          <span class="text-white fs-5">News Detail</span>
        </div>
      </div>
      <div class="col-md-10 p-0">
        <div class="contact_righto  p-3 bg-white">
          <span class="mb-0 font_11 light_gray">
            <a class="fw-bold" href="<?= site_url('/') ?>">Home</a>
            <span class="mx-2">/</span> <?= $postTitle ?>
          </span>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="news" class="pt-0 pt-md-5 pb-5 bg-light">
  <div class="container-xl">
    <div class="row news_1">
      <div class="col-md-8">
        <div class="news_dt">

          <div class="news_dt1">
            <a href="#"><img class="img-fluid" alt="<?= $postTitle ?>" src="<?= $thumbUrl ?>"></a>
          </div>

          <div class="news_dt2 p-4 bg-white">
            <b class="d-inline-block bg_yellow text-white p-1 px-3 font_10 text-uppercase rounded-1"><?= $categoryName ?></b>

            <b class="d-block fs-2 text-uppercase mt-2 mb-1"><a href="#"><?= $postTitle ?></a></b>

            <ul class="mb-0 font_11 fw-bold text-uppercase justify-content-between d-flex">
              <li>
                <a href="#"><img class="rounded-circle" alt="author" src="<?= base_url('image/9.jpg') ?>"></a>
                <span class="light_gray ms-2"><?= $authorName ?></span>
                <?php if ($dateText): ?>
                  <span class="light_gray ms-2">• <?= esc($dateText) ?></span>
                <?php endif; ?>
              </li>
              <li class="my-auto">
                <a class="light_gray" href="#"><i class="fa fa-eye me-1"></i> <?= number_format($viewCount) ?></a>
                <a class="light_gray mx-3" href="#comments"><i class="fa fa-comment me-1"></i> <?= number_format($commentCount) ?></a>
              </li>
            </ul>

            <?php if ($summary): ?>
              <p class="mt-4"><?= $summary ?></p>
            <?php endif; ?>

            <!-- Nội dung bài viết -->
            <div class="mt-4">
              <?= $content ?>
            </div>

            <?php if (! empty($popularTags) && is_array($popularTags)): ?>
              <ul class="mb-0 d-flex flex-wrap text-uppercase font_11 tags mt-4">
                <?php foreach ($popularTags as $tag): ?>
                  <li class="mx-1 mt-1 mb-1">
                    <a class="d-block border p-1 px-2" href="#"><?= esc($tag) ?></a>
                  </li>
                <?php endforeach; ?>
              </ul>
            <?php endif; ?>
          </div>

          <div class="news_dt3 mt-3">
            <ul class="mb-0 text-uppercase fw-bold justify-content-between d-flex">
              <li class="d-inline-block"><a href="#" class="d-inline-block bg-primary text-white rounded-1 font_10 p-3 px-5"><i class="fa-brands fa-facebook-f me-2 align-middle"></i> Share on facebook</a></li>
              <li class="d-inline-block"><a href="#" class="d-inline-block bg-info text-white rounded-1 font_10 p-3 px-5"><i class="fa-brands fa-twitter me-2 align-middle"></i> Share on twitter</a></li>
              <li class="d-inline-block"><a href="#" class="d-inline-block bg-danger text-white rounded-1 font_10 p-3 px-5"><i class="fa-brands fa-instagram me-2 align-middle"></i> Share on instagram</a></li>
            </ul>
          </div>

          <!-- Bài liên quan (giữ layout, gắn data) -->
          <?php if (! empty($related) && is_array($related)): ?>
            <div class="news_dt5 mt-3">
              <div class="row row-cols-1 row-cols-md-2">
                <?php foreach (array_slice($related, 0, 2) as $idx => $r): ?>
                  <?php
                    $rTitle = esc($r['title'] ?? 'Post');
                    $rSlug  = $r['slug'] ?? '#';
                    $rDate  = ! empty($r['created_at']) ? date('M d, Y', strtotime($r['created_at'])) : '';
                  ?>
                  <div class="col">
                    <div class="news_dt5_left bg-white p-3">
                      <ul class="mb-0">
                        <li class="d-flex">
                          <?php if ($idx === 0): ?>
                            <span class="mt-4"><a class="d-inline-block bg-dark text-white rounded-1 p-2 px-3 font_13" href="<?= site_url('post/' . $rSlug) ?>"><i class="fa fa-chevron-left"></i></a></span>
                          <?php endif; ?>

                          <span class="flex-column <?= $idx === 0 ? 'ms-1' : 'me-1' ?>">
                            <b class="d-inline-block bg_yellow text-white p-1 px-3 font_10 text-uppercase rounded-1 mx-3"><?= $idx === 0 ? 'Related' : 'Related' ?></b>
                            <b class="d-block font_13 text-uppercase mt-2 px-3"><a href="<?= site_url('post/' . $rSlug) ?>"><?= $rTitle ?></a></b>
                            <?php if ($rDate): ?>
                              <span class="light_gray font_10 fw-bold text-uppercase px-3"><i class="fa fa-clock me-1 text-warning align-middle"></i> <?= esc($rDate) ?></span>
                            <?php endif; ?>
                          </span>

                          <?php if ($idx === 1): ?>
                            <span class="mt-4"><a class="d-inline-block bg-black text-white rounded-1 p-2 px-3 font_13" href="<?= site_url('post/' . $rSlug) ?>"><i class="fa fa-chevron-right"></i></a></span>
                          <?php endif; ?>
                        </li>
                      </ul>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>
            </div>
          <?php endif; ?>

          <!-- Comments -->
          <div id="comments" class="news_1_right1 bg-white mt-3 border_light">
            <b class="d-block text-uppercase p-3 border_thick">Comments (<?= number_format($commentCount) ?>)</b>

            <?php if (! empty($comments) && is_array($comments)): ?>
              <?php foreach ($comments as $c): ?>
                <?php
                  $cName = esc($c['user_name'] ?? 'Khách');
                  $cTime = ! empty($c['created_at']) ? date('d/m/Y H:i', strtotime($c['created_at'])) : '';
                  $cText = esc($c['content'] ?? '');
                ?>
                <ul class="mb-0 border-top pt-4 pb-4">
                  <li class="d-flex px-3">
                    <span><a href="#"><img width="50" class="rounded-circle" alt="avatar" src="<?= base_url('image/25.jpg') ?>"></a></span>
                    <span class="flex-column mx-2 mt-2">
                      <b class="d-block font_14 lh-1"><?= $cName ?></b>
                      <?php if ($cTime): ?>
                        <span class="light_gray font_10 fw-bold mt-1 d-block"><i class="fa fa-clock text-warning align-middle me-1"></i> <?= esc($cTime) ?></span>
                      <?php endif; ?>
                    </span>
                  </li>
                  <li class="px-3 mt-2">
                    <span class="flex-column">
                      <span class="gray_dark font_12 d-block"><?= $cText ?></span>
                    </span>
                  </li>
                </ul>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="border-top p-3">
                <span class="light_gray">Chưa có bình luận nào.</span>
              </div>
            <?php endif; ?>
          </div>

          <!-- Write a Comment -->
          <div class="news_1_right1 bg-white mt-3 border_light">
            <b class="d-block text-uppercase p-3 border_thick">Write a Comment</b>
            <div class="pt-4 pb-4 border-top">
              <?php if (session('message')): ?>
                <div class="alert alert-success mx-3"><?= esc(session('message')) ?></div>
              <?php endif; ?>

              <form class="row g-3 needs-validation px-3" method="post" action="<?= site_url('post/comment/' . ($postSlug ?? '')) ?>" novalidate="">
                <?= csrf_field() ?>
                <div class="col-md-6">
                  <input type="text" class="form-control font_12" name="user_name" placeholder="Name" required="">
                  <div class="invalid-feedback">Please provide a valid name.</div>
                </div>

                <div class="col-md-6">
                  <input type="email" class="form-control font_12" name="user_email" placeholder="Email">
                </div>

                <div class="col-md-12">
                  <textarea name="content" class="form-control form_text font_12" placeholder="Your Message (Maximum 300 words)" required=""></textarea>
                  <div class="invalid-feedback">Please provide a valid message.</div>
                </div>

                <div class="col-12">
                  <div class="form-check font_14">
                    <input class="form-check-input" type="checkbox" value="1" id="invalidCheck" required="">
                    <label class="form-check-label" for="invalidCheck">
                      Before registration read our <a href="#">Privacy Statement</a> and <a href="#">Terms &amp; Conditions</a>
                    </label>
                    <div class="invalid-feedback">You must agree before submitting.</div>
                  </div>
                </div>

                <div class="col-12 center_sm">
                  <button class="btn btn-primary bg_violet_dark text-white p-3 px-5 border-0 rounded-0 w-100 text-uppercase font_12 fw-bold" type="submit">
                    Post Your Comment
                  </button>
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>

      <!-- SIDEBAR giữ nguyên block của bạn, chỉ gắn data nơi có thể -->
      <div class="col-md-4">
        <div class="news_1_right">

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

          <!-- Popular News -->
          <div class="news_1_right1 bg-white border_light mt-3">
            <b class="d-block text-uppercase p-3 border_thick">Popular News</b>
            <ul class="mb-0 border-top pt-3">
              <?php if (! empty($popularPosts) && is_array($popularPosts)): ?>
                <?php foreach ($popularPosts as $pp): ?>
                  <?php
                    $ppTitle = esc($pp['title'] ?? 'Post');
                    $ppSlug  = $pp['slug'] ?? '#';
                    $ppDate  = ! empty($pp['created_at']) ? date('M d, Y', strtotime($pp['created_at'])) : '';
                    $ppThumb = ! empty($pp['thumbnail']) ? base_url($pp['thumbnail']) : base_url('image/20.jpg');
                  ?>
                  <li class="d-flex border-bottom pb-3 mb-3">
                    <span class="ps-3"><a href="<?= site_url('post/' . $ppSlug) ?>"><img width="70" alt="thumb" src="<?= $ppThumb ?>"></a></span>
                    <span class="flex-column mx-3">
                      <b class="d-inline-block bg_yellow text-white p-1 px-3 font_10 text-uppercase rounded-1">Popular</b>
                      <b class="d-block font_13 text-uppercase mt-1"><a href="<?= site_url('post/' . $ppSlug) ?>"><?= $ppTitle ?></a></b>
                      <?php if ($ppDate): ?>
                        <span class="light_gray font_10 fw-bold text-uppercase"><i class="fa fa-clock me-1 text-warning align-middle"></i> <?= esc($ppDate) ?></span>
                      <?php endif; ?>
                    </span>
                  </li>
                <?php endforeach; ?>
              <?php else: ?>
                <!-- Giữ mẫu của bạn nếu chưa có data -->
                <li class="d-flex border-bottom pb-3 mb-3">
                  <span class="ps-3"><a href="#"><img width="70" alt="abc"  src="<?= base_url('image/20.jpg') ?>"></a></span>
                  <span class="flex-column mx-3">
                    <b class="d-inline-block bg_violet text-white p-1 px-3 font_10 text-uppercase rounded-1">Latest</b>
                    <b class="d-block font_13 text-uppercase mt-1"><a href="#">TEMPOR INCIDIDUNT UT LABORE   UT ENIM AD MINIM</a></b>
                    <span class="light_gray font_10 fw-bold  text-uppercase"> <i class="fa fa-clock me-1 text-warning align-middle"></i> Aug 13, 2016</span>
                  </span>
                </li>
              <?php endif; ?>
            </ul>
          </div>

          <!-- Trending News -->
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
                    <?php if (! empty($trendingNewest) && is_array($trendingNewest)): ?>
                      <?php foreach ($trendingNewest as $t): ?>
                        <?php
                          $tTitle = esc($t['title'] ?? 'Post');
                          $tSlug  = $t['slug'] ?? '#';
                          $tDate  = ! empty($t['created_at']) ? date('M d, Y', strtotime($t['created_at'])) : '';
                          $tSum   = esc($t['summary'] ?? '');
                        ?>
                        <li class="border-bottom pb-3 mb-3">
                          <b class="d-inline-block bg_yellow text-white p-1 px-3 font_10 text-uppercase rounded-1 mx-3">Newest</b>
                          <b class="d-block font_15 text-uppercase mt-2  px-3"><a href="<?= site_url('post/' . $tSlug) ?>"><?= $tTitle ?></a></b>
                          <?php if ($tDate): ?>
                            <span class="light_gray font_10 fw-bold  text-uppercase px-3"> <i class="fa fa-clock me-1 text-warning align-middle"></i> <?= esc($tDate) ?></span>
                          <?php endif; ?>
                          <?php if ($tSum): ?>
                            <span class="gray_dark mt-3 px-3 font_12 mb-0 d-block"><?= $tSum ?></span>
                          <?php endif; ?>
                        </li>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <li class="border-bottom pb-3 mb-3">
                        <b class="d-inline-block bg_yellow text-white p-1 px-3 font_10 text-uppercase rounded-1 mx-3">Newest</b>
                        <b class="d-block font_15 text-uppercase mt-2  px-3"><a href="#">TEMPOR INCIDIDUNT UT LABORE  MAGNA ALIQUA. UT ENIM AD MINIM</a></b>
                        <span class="light_gray font_10 fw-bold  text-uppercase px-3"> <i class="fa fa-clock me-1 text-warning align-middle"></i> Aug 13, 2016</span>
                        <span class="gray_dark mt-3 px-3 font_12 mb-0 d-block">Praesent sapien massa, convallis a semper pellentesque nec, egestas non nisi.</span>
                      </li>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>

              <div class="tab-pane" id="profile9">
                <div class="profile8_inner">
                  <ul class="mb-0 mt-3">
                    <?php if (! empty($trendingCommented) && is_array($trendingCommented)): ?>
                      <?php foreach ($trendingCommented as $t): ?>
                        <?php
                          $tTitle = esc($t['title'] ?? 'Post');
                          $tSlug  = $t['slug'] ?? '#';
                          $tDate  = ! empty($t['created_at']) ? date('M d, Y', strtotime($t['created_at'])) : '';
                          $tSum   = esc($t['summary'] ?? '');
                        ?>
                        <li class="border-bottom pb-3 mb-3">
                          <b class="d-inline-block bg_orange text-white p-1 px-3 font_10 text-uppercase rounded-1 mx-3">Commented</b>
                          <b class="d-block font_15 text-uppercase mt-2  px-3"><a href="<?= site_url('post/' . $tSlug) ?>"><?= $tTitle ?></a></b>
                          <?php if ($tDate): ?>
                            <span class="light_gray font_10 fw-bold  text-uppercase px-3"> <i class="fa fa-clock me-1 text-warning align-middle"></i> <?= esc($tDate) ?></span>
                          <?php endif; ?>
                          <?php if ($tSum): ?>
                            <span class="gray_dark mt-3 px-3 font_12 mb-0 d-block"><?= $tSum ?></span>
                          <?php endif; ?>
                        </li>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <li class="border-bottom pb-3 mb-3">
                        <b class="d-inline-block bg_orange text-white p-1 px-3 font_10 text-uppercase rounded-1 mx-3">Commented</b>
                        <b class="d-block font_15 text-uppercase mt-2  px-3"><a href="#">SIT AMET, CONSECTETUR ADIPISCING ELIT, SED DO EIUSMOD</a></b>
                        <span class="light_gray font_10 fw-bold  text-uppercase px-3"> <i class="fa fa-clock me-1 text-warning align-middle"></i> Aug 13, 2016</span>
                        <span class="gray_dark mt-3 px-3 font_12 mb-0 d-block">Praesent sapien massa, convallis a semper pellentesque nec, egestas non nisi.</span>
                      </li>
                    <?php endif; ?>
                  </ul>
                </div>
              </div>

              <div class="tab-pane" id="profile10">
                <ul class="mb-0 mt-3">
                  <?php if (! empty($trendingPopular) && is_array($trendingPopular)): ?>
                    <?php foreach ($trendingPopular as $t): ?>
                      <?php
                        $tTitle = esc($t['title'] ?? 'Post');
                        $tSlug  = $t['slug'] ?? '#';
                        $tDate  = ! empty($t['created_at']) ? date('M d, Y', strtotime($t['created_at'])) : '';
                        $tSum   = esc($t['summary'] ?? '');
                      ?>
                      <li class="border-bottom pb-3 mb-3">
                        <b class="d-inline-block bg_yellow text-white p-1 px-3 font_10 text-uppercase rounded-1 mx-3">Popular</b>
                        <b class="d-block font_15 text-uppercase mt-2  px-3"><a href="<?= site_url('post/' . $tSlug) ?>"><?= $tTitle ?></a></b>
                        <?php if ($tDate): ?>
                          <span class="light_gray font_10 fw-bold  text-uppercase px-3"> <i class="fa fa-clock me-1 text-warning align-middle"></i> <?= esc($tDate) ?></span>
                        <?php endif; ?>
                        <?php if ($tSum): ?>
                          <span class="gray_dark mt-3 px-3 font_12 mb-0 d-block"><?= $tSum ?></span>
                        <?php endif; ?>
                      </li>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <li class="border-bottom pb-3 mb-3">
                      <b class="d-inline-block bg_yellow text-white p-1 px-3 font_10 text-uppercase rounded-1 mx-3">Popular</b>
                      <b class="d-block font_15 text-uppercase mt-2  px-3"><a href="#">Lorem Ipsum Dolor Sit Amet, Sonet Intellegat  Usu At, Nec</a></b>
                      <span class="light_gray font_10 fw-bold  text-uppercase px-3"> <i class="fa fa-clock me-1 text-warning align-middle"></i> Aug 13, 2016</span>
                      <span class="gray_dark mt-3 px-3 font_12 mb-0 d-block">Praesent sapien massa, convallis a semper pellentesque nec, egestas non nisi.</span>
                    </li>
                  <?php endif; ?>
                </ul>
              </div>
            </div>
          </div>

          <!-- Latest Comments (giữ block của bạn, gắn data nếu có) -->
          <div class="news_1_right1 bg-white mt-3 border_light">
            <b class="d-block text-uppercase p-3 border_thick">Latest Comments</b>
            <ul class="mb-0 border-top pt-3">
              <?php if (! empty($latestComments) && is_array($latestComments)): ?>
                <?php foreach ($latestComments as $lc): ?>
                  <?php
                    $lcName = esc($lc['user_name'] ?? 'Khách');
                    $lcText = esc($lc['content'] ?? '');
                    $lcTime = ! empty($lc['created_at']) ? date('d/m/Y H:i', strtotime($lc['created_at'])) : '';
                  ?>
                  <li class="d-flex border-bottom pb-3 mb-3">
                    <span class="ps-3"><a href="#"><img width="40" alt="avatar" class="rounded-circle" src="<?= base_url('image/25.jpg') ?>"></a></span>
                    <span class="flex-column mx-3">
                      <b class="d-block font_14"><a href="#"><?= $lcName ?></a></b>
                      <?php if ($lcTime): ?>
                        <span class="light_gray font_10 d-block fw-bold"><i class="fa fa-clock text-warning align-middle me-1"></i> <?= esc($lcTime) ?></span>
                      <?php endif; ?>
                      <span class="light_gray font_12 mt-2 d-block"><?= $lcText ?></span>
                    </span>
                  </li>
                <?php endforeach; ?>
              <?php else: ?>
                <li class="d-flex pb-3">
                  <span class="ps-3"><a href="#"><img width="40" alt="abc" class="rounded-circle" src="<?= base_url('image/27.jpg') ?>"></a></span>
                  <span class="flex-column mx-3">
                    <b class="d-block font_14"><a href="#">Semper Eget</a></b>
                    <span class="light_gray font_10 d-block fw-bold"><i class="fa fa-clock text-warning align-middle me-1"></i> 40 Min ago</span>
                    <span class="light_gray font_12 mt-2 d-block">Egestas non nisi. Donec sollicitudin molestie malesuada. Mauris blandit aliquet elit"</span>
                  </span>
                </li>
              <?php endif; ?>
            </ul>
          </div>

          <!-- Popular tags (giữ nguyên block) -->
          <div class="news_1_right1 bg-white mt-3 border_light pb-3">
            <b class="d-block text-uppercase p-3 border_thick">Popular tags</b>
            <ul class="mb-0 d-flex flex-wrap text-uppercase font_11 tags border-top px-3 pt-3">
              <?php if (! empty($popularTags) && is_array($popularTags)): ?>
                <?php foreach ($popularTags as $tag): ?>
                  <li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#"><?= esc($tag) ?></a></li>
                <?php endforeach; ?>
              <?php else: ?>
                <!-- fallback giữ đúng code mẫu của bạn -->
                <li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">News</a></li>
                <li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">Headlines</a></li>
                <li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">Sports</a></li>
                <li class="mx-1 mt-1 mb-1"><a class="d-block border p-2 px-3" href="#">Event</a></li>
              <?php endif; ?>
            </ul>
          </div>

        </div>
      </div>

    </div>
  </div>
</section>

<?= $this->endSection() ?>
