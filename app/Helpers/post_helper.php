<?php

function post_url(array $p): string {
  return site_url('post/' . ($p['slug'] ?? ''));
}

function post_img(array $p): string {
  return !empty($p['thumbnail']) ? base_url($p['thumbnail']) : base_url('media_frontend/image/4.jpg');
}

function post_date(array $p): string {
  return !empty($p['published_at']) ? date('M d, Y', strtotime($p['published_at'])) : '';
}
