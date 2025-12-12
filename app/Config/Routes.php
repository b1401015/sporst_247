<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

// Application Routes (from Routes.partial.php)


$routes->get('/', 'Home::index');
$routes->get('category/(:segment)', 'Category::view/$1');
$routes->get('post/(:segment)', 'Post::detail/$1');
$routes->post('post/(:segment)/comment', 'Post::comment/$1');
$routes->get('tag/(:segment)', 'Tag::index/$1');
$routes->get('search', 'Search::index');
$routes->get('results', 'Results::index');
$routes->get('league/(:segment)', 'Results::league/$1');
$routes->get('league/(:segment)/table', 'Results::table/$1');
$routes->get('league/(:segment)/week/(:num)', 'Results::weekTable/$1/$2');
$routes->get('league/(:segment)/scorers', 'Scorers::league/$1');
$routes->get('live', 'Live::index');
$routes->get('live/matches', 'Live::matches');
$routes->get('medals', 'Medals::index');
$routes->get('videos', 'Videos::index');
$routes->get('video/(:segment)', 'Videos::detail/$1');
$routes->get('standings', 'Standings::index');
$routes->get('rss', 'Rss::index');
$routes->get('sitemap.xml', 'Sitemap::index');

$routes->group('api', function($routes) {
    $routes->get('standings', 'Api\Standings::all');
    $routes->get('standings/league/(:segment)', 'Api\Standings::league/$1');
    $routes->get('standings/league/(:segment)/week/(:num)', 'Api\Standings::week/$1/$2');
    $routes->get('standings/league/(:segment)/scorers', 'Api\Standings::scorers/$1');
});

$routes->group('admin', ['filter' => 'auth'], function($routes) {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->presenter('posts',      ['controller' => 'Admin\Posts']);
    $routes->presenter('categories', ['controller' => 'Admin\Categories']);
    $routes->presenter('tags',       ['controller' => 'Admin\Tags']);
    $routes->presenter('leagues',    ['controller' => 'Admin\Leagues']);
    $routes->presenter('teams',      ['controller' => 'Admin\Teams']);
    $routes->presenter('matches',    ['controller' => 'Admin\Matches']);
    $routes->presenter('ads',        ['controller' => 'Admin\Ads']);
    $routes->presenter('users',      ['controller' => 'Admin\Users']);
    $routes->presenter('comments',   ['controller' => 'Admin\Comments']);
    $routes->presenter('countries',  ['controller' => 'Admin\Countries']);
    $routes->presenter('medals',     ['controller' => 'Admin\Medals']);
    $routes->presenter('videos',     ['controller' => 'Admin\Videos']);
    $routes->presenter('players',    ['controller' => 'Admin\Players']);
    $routes->presenter('goals',      ['controller' => 'Admin\Goals']);
    $routes->get('settings',         'Admin\Settings::index');
    $routes->post('settings/save',   'Admin\Settings::save');
});

$routes->match(['get','post'],'login', 'Auth::login');
$routes->get('logout', 'Auth::logout');

