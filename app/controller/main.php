<?php defined ('OACI') || exit ('此檔案不允許讀取。');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2013 - 2018, OACI
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

class main extends Controller {

  public function toStores () {
    return refresh (URL::base ('stores'));
  }
  public function stores () {
    $f = Input::get ('f');
    $t = Input::get ('t');

    $asset = Asset::create (3)
                  ->addCSS ('/assets/css/icon-site.css')
                  ->addCSS ('/assets/css/site/layout.css')

                  ->addJS ('/assets/js/res/jquery-1.10.2.min.js')
                  ->addJS ('/assets/js/res/swiper/swiper.min.js')
                  ->addJS ('/assets/js/res/imgLiquid-min.js')
                  ->addJS ('/assets/js/site/layout.js');

    if( !empty($f) ) {
      $where = Where::create( 'name LIKE ?', '%'.$f.'%' );
      $where->or( 'content LIKE ?', '%'.$f.'%' );
      $where->and( 'status = ?', Store::STATUS_ON );
    } else {
      $where = Where::create( 'status = ?', Store::STATUS_ON  );
    }

    if( !empty($t) ) {
      $where->and( 'store_tag_id = ?', $t );
    }

    $stores = Store::find( 'all', array ('order' => 'sort DESC', 'where' => $where ) );

    $oriAds = OriAd::find('all', array('order' => 'sort DESC', 'where' => array('status = ?', Store::STATUS_ON ) ) );
    $boxes = call_user_func_array( 'array_merge', array_map( function( $stores, $oriAd ) {
      $oriAd && $stores[] = $oriAd;
      return $stores;
    }, array_chunk($stores, 5),  $oriAds ) );

    $brands = Brand::find('all', array('order' => 'sort DESC', 'where' => array('status = ?', Store::STATUS_ON ) ) );
    $storeTags = StoreTag::find('all');

    return View::create ('stores.php')
               ->with ('asset', $asset)
               ->with ('f', $f)
               ->with ('t', $t)
               ->with ('boxes', $boxes)
               ->with ('brands', $brands)
               ->with ('storeTags', $storeTags);
  }

  public function intro () {
    $asset = Asset::create (3)
                  ->addCSS ('/assets/css/icon-site.css')
                  ->addCSS ('/assets/css/site/layout.css')

                  ->addJS ('/assets/js/res/jquery-1.10.2.min.js')
                  ->addJS ('/assets/js/res/swiper/swiper.min.js')
                  ->addJS ('/assets/js/res/imgLiquid-min.js')
                  ->addJS ('/assets/js/site/layout.js');

    $hBanners = IndexHeaderBanner::find ('all', array ('order' => 'sort DESC', 'where' => array ('status = ?', IndexHeaderBanner::STATUS_ON)));
    $fBanners = IndexFooterBanner::find ('all', array ('order' => 'sort DESC', 'where' => array ('status = ?', IndexFooterBanner::STATUS_ON)));
    $start = Start::find ('one', array ('order' => 'id DESC', 'where' => array ()));
    
    Start::transaction (function () use ($start) {
      $start->click_cnt = $start->click_cnt + 1;
      if (!$start->save ())
        return false;
      
      return PvStart::create (array ('start_id' => $start->id));
    });
    
    return View::create ('intro.php')
               ->with ('asset', $asset)
               ->with ('hBanners', $hBanners)
               ->with ('fBanners', $fBanners);
  }
}
