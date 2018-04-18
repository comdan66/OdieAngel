<?php defined ('OACI') || exit ('此檔案不允許讀取。');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2013 - 2018, OACI
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

Router::get ('', 'Main@index');

// Router::get ('', 'main@index');
// Router::get ('intro', 'main@intro');
// Router::get ('stores', 'main@stores');
// Router::get ('store', 'main@toStores');

// Router::get ('login', 'main@login');
// Router::get ('logout', 'main@logout');
// Router::post ('login', 'main@ac_signin');


Router::dir ('api', function () {
  Router::get ('stores/(:id)', 'stores@index($1)', array (array ('model' => 'Store')));
  Router::post ('pvs', 'pvs@index');
});

Router::dir ('admin', function () {
  Router::get ('', 'Main');
  
  Router::get ('login', 'Auth@login');
  Router::post ('login', 'Auth@acSignin');
  Router::get ('logout', 'Auth@logout');

  Router::get ('login', 'Auth@login');
  Router::post ('login', 'Auth@acSignin');
  Router::get ('logout', 'Auth@logout');

  Router::restful ('admins', 'Admins', array (
    array ('model' => 'Admin')));

  Router::restful ('backups', 'Backups', array (
    array ('model' => 'Backup')));

  Router::restful ('deploys', 'Deploys', array (
    array ('model' => 'Deploy')));

  Router::restful ('starts', 'Starts', array (
    array ('model' => 'Start')));

  Router::restful ('index_header_banners', 'IndexHeaderBanners', array (
    array ('model' => 'IndexHeaderBanner')));

  Router::restful ('index_footer_banners', 'IndexFooterBanners', array (
    array ('model' => 'IndexFooterBanner')));

  Router::restful ('store_tags', 'StoreTags', array (
    array ('model' => 'StoreTag')));

  Router::restful ('stores', 'Stores', array (
    array ('model' => 'Store')));

  Router::restful ('ori_ads', 'OriAds', array (
    array ('model' => 'OriAd')));

  Router::restful ('brands', 'Brands', array (
    array ('model' => 'Brand')));

  Router::restful (array ('start', 'pvs'), 'PvStarts', array (
    array ('model' => 'Start'), array ('model' => 'PvStart')));

  Router::restful (array ('index_header_banner', 'pvs'), 'PvIndexHeaderBanners', array (
    array ('model' => 'IndexHeaderBanner'), array ('model' => 'PvIndexHeaderBanner')));

  Router::restful (array ('index_footer_banner', 'pvs'), 'PvIndexFooterBanners', array (
    array ('model' => 'IndexFooterBanner'), array ('model' => 'PvIndexFooterBanner')));

  Router::restful (array ('store', 'pvs'), 'PvStores', array (
    array ('model' => 'Store'), array ('model' => 'PvStore')));

  Router::restful (array ('ori_ad', 'pvs'), 'PvOriAds', array (
    array ('model' => 'OriAd'), array ('model' => 'PvOriAd')));

  Router::restful (array ('brand', 'pvs'), 'PvBrands', array (
    array ('model' => 'Brand'), array ('model' => 'PvBrand')));

});
// echo '<meta http-equiv="Content-type" content="text/html; charset=utf-8" /><pre>';
// var_dump (Router::$routers);
// exit ();
