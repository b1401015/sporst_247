<?php
// Build tree parent -> children
$parents = [];
$childrenMap = [];

foreach (($categories ?? []) as $c) {
    $pid = (int)($c['parent_id'] ?? 0);
    if ($pid === 0) $parents[] = $c;
    else $childrenMap[$pid][] = $c;
}
?>

<section id="top" class="py-2 bg_violet_dark">
  <div class="container-xl">
    <div class="row top_1">
      <div class="col-md-4">
        <div class="input-group rounded-pill bg_violet px-3">
          <input type="text" class="form-control bg-transparent border-0 font_10 text-white" placeholder="Enter your search here...">
          <span class="input-group-btn">
            <button class="btn btn-primary bg-transparent border-0 rounded-0 p-1 px-3" type="button">
              <i class="fa fa-search col_green font_14"></i>
            </button>
          </span>
        </div>
      </div>

      <div class="col-md-8">
        <ul class="mb-0 text-uppercase font_10 d-flex justify-content-end mt-2">
          <li class="nav-item dropdown">
            <a class="dropdown-toggle text-white" href="#" id="navbarDropdownLang" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Language: <span class="font_11 col_green">EN</span>
              <img src="<?= base_url('media_frontend/image/icons-svg/chevron-down.svg') ?>" width="10" height="10" alt="Submenu open/close icon">
            </a>
            <ul class="dropdown-menu drop_top shadow" aria-labelledby="navbarDropdownLang">
              <li><a class="dropdown-item" href="#"> Hindi</a></li>
              <li><a class="dropdown-item" href="#"> English</a></li>
              <li><a class="dropdown-item" href="#"> German</a></li>
              <li><a class="dropdown-item border-0" href="#"> Spanish</a></li>
            </ul>
          </li>

          <li class="light_gray mx-2">/</li>

          <li class="nav-item dropdown">
            <a class="dropdown-toggle text-white" href="#" id="navbarDropdownCur" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Currency: <span class="font_11 col_green">USD</span>
              <img src="<?= base_url('media_frontend/image/icons-svg/chevron-down.svg') ?>" width="10" height="10" alt="Submenu open/close icon">
            </a>
            <ul class="dropdown-menu drop_top shadow" aria-labelledby="navbarDropdownCur">
              <li><a class="dropdown-item" href="#"> Dollor</a></li>
              <li><a class="dropdown-item" href="#"> Pound</a></li>
              <li><a class="dropdown-item" href="#"> Euro</a></li>
              <li><a class="dropdown-item border-0" href="#"> Rupee</a></li>
            </ul>
          </li>

          <li class="light_gray mx-2">/</li>
          <li class="sign_up"><a class="text-white" href="#">Sign In / Sign Up </a></li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section id="header">
  <nav class="navbar navbar-expand-lg navbar-light w-100">
    <div class="container-xl">
      <a class="d-flex text-white" href="<?= site_url('/') ?>">
        <b class="fs-3 d-block logo bg_violet_dark p-2 pb-3 px-3">
          <i class="fa fa-football col_green me-1"></i> Sports News
        </b>
      </a>

      <button class="navbar-toggler offcanvas-nav-btn  ms-auto me-3" type="button">
        <img src="<?= base_url('media_frontend/image/icons-svg/list.svg') ?>" width="40" height="40" alt="Open TemplateOnweb website menu"/>
      </button>

      <div class="offcanvas offcanvas-start offcanvas-nav" style="width: 20rem">
        <div class="offcanvas-header shadow">
          <a class="d-flex text-white" href="<?= site_url('/') ?>">
            <b class="fs-4  d-block  logo">
              <i class="fa fa-football col_green me-1"></i> Sports News
            </b>
          </a>
          <img src="<?= base_url('media_frontend/image/icons-svg/x.svg') ?>" width="40" height="40" class="ms-auto"
               data-bs-dismiss="offcanvas" aria-label="Close" alt="Close TemplateOnweb website menu"/>
        </div>

        <div class="offcanvas-body pt-0 align-items-center">
          <ul class="navbar-nav align-items-lg-center ms-auto">

            <!-- HOME giữ nguyên -->
            <li class="nav-item">
              <a class="nav-link dropdown-toggle active" href="<?= base_url() ?>" title="Visit home page">
                TRANG CHỦ
              </a>
            </li>

            <!-- ======= CATEGORY (động từ DB) ======= -->
            <?php foreach ($parents as $p): ?>
              <?php $children = $childrenMap[$p['id']] ?? []; ?>

              <?php if (!empty($children)): ?>
                <li class="nav-item dropdown drop_border">
                  <a class="nav-link dropdown-toggle" href="#" id="catDrop<?= (int)$p['id'] ?>" role="button"
                     data-bs-toggle="dropdown" aria-expanded="false">
                    <?= esc($p['name']) ?>
                    <img src="<?= base_url('media_frontend/image/icons-svg/chevron-down.svg') ?>" width="15" height="15" alt="Submenu open/close icon">
                  </a>
                  <ul class="dropdown-menu drop_1 shadow" aria-labelledby="catDrop<?= (int)$p['id'] ?>">
                    <?php foreach ($children as $ch): ?>
                      <li>
                        <a class="dropdown-item" href="<?= base_url('category/'.$ch['slug']) ?>">
                          <?= esc($ch['name']) ?>
                        </a>
                      </li>
                    <?php endforeach; ?>
                  </ul>
                </li>
              <?php else: ?>
                <li class="nav-item">
                  <a class="nav-link dropdown-toggle" href="<?= site_url('category/'.$p['slug']) ?>" title="Visit home page">
                    <?= esc($p['name']) ?>
                  </a>
                </li>
              <?php endif; ?>
            <?php endforeach; ?>
            <!-- ======= /CATEGORY ======= -->

            <!-- NEWS giữ nguyên -->
            <li class="nav-item dropdown drop_border">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownNews" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                News
                <img src="<?= base_url('media_frontend/image/icons-svg/chevron-down.svg') ?>" width="15" height="15" alt="Submenu open/close icon">
              </a>
              <ul class="dropdown-menu drop_1 shadow" aria-labelledby="navbarDropdownNews">
                <li><a class="dropdown-item" href="news.html"> News</a></li>
                <li><a class="dropdown-item border-0" href="news_detail.html"> News Detail</a></li>
              </ul>
            </li>

            <!-- PAGES giữ nguyên -->
            <li class="nav-item dropdown drop_border">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownPages" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Pages
                <img src="<?= base_url('media_frontend/image/icons-svg/chevron-down.svg') ?>" width="15" height="15" alt="Submenu open/close icon">
              </a>
              <ul class="dropdown-menu drop_1 shadow" aria-labelledby="navbarDropdownPages">
                <li><a class="dropdown-item" href="videos.html"> Videos</a></li>
                <li><a class="dropdown-item border-0" href="team.html"> Team</a></li>
              </ul>
            </li>

            <!-- CONTACT giữ nguyên -->
            <li class="nav-item">
              <a class="nav-link dropdown-toggle" href="contact.html" title="Visit home page">
                Contact Us
              </a>
            </li>
          </ul>

          <!-- Social giữ nguyên -->
          <ul class="navbar-nav align-items-lg-center ms-auto social_nav">
            <li class="nav-item">
              <a class="nav-link dropdown-toggle px-3 fs-5" href="#" title="Visit home page">
                <i class="fa-brands fa-facebook-f"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link dropdown-toggle px-3 fs-5" href="#" title="Visit home page">
                <i class="fa-brands fa-twitter"></i>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link dropdown-toggle fs-5 px-3" href="#" title="Visit home page">
                <i class="fa-brands fa-instagram"></i>
              </a>
            </li>
          </ul>

        </div>
      </div>
    </div>
  </nav>
</section>
