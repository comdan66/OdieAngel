<?php if (!defined ('BASEPATH')) exit ('No direct script access allowed');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2017 OA Wu Design
 * @license     http://creativecommons.org/licenses/by-nc/2.0/tw/
 */

class DeployTool {

  public static function genApi () {
    Load::sysFunc ('file.php');
    
    $index = array (
      'hBanners' => array_map (function ($t) { return array_merge ($t->backup (), array ('pic' => $t->pic->url ('min'))); }, IndexHeaderBanner::find ('all', array ('order' => 'sort DESC', 'where' => array ('status = ?', IndexHeaderBanner::STATUS_ON)))),
      'start' => array_map (function ($t) { return array_merge ($t->backup (), array ('pic' => $t->pic->url ('wh710_400'))); }, Start::find ('all', array ('order' => 'id DESC', 'where' => array ()))),
      'fBanners' => array_map (function ($t) { return array_merge ($t->backup (), array ('pic' => $t->pic->url ('min'))); }, IndexFooterBanner::find ('all', array ('order' => 'sort DESC', 'where' => array ('status = ?', IndexFooterBanner::STATUS_ON)))),
      );

    // index
    if (!write_file ($path = FCPATH . 'json' . DIRECTORY_SEPARATOR . 'index.json', json_encode ($index)))
      gg ('寫入檔案失敗！');

    $stores = array_map (function ($t) { return array (
        'id' => $t->id,
        'tag' => $t->store_tag_id,
        'pic' => $t->icon->url ('w100'),
        'title' => $t->name,
        'content' => $t->content,
      ); }, Store::find( 'all', array ('order' => 'sort DESC', 'where' => array('status = ?', Store::STATUS_ON  ) ) ));
    $oriAds = array_map (function ($t) { return array (
        'id' => $t->id,
        'link' => $t->link,
        'pic' => $t->pic->url ('w100'),
        'title' => $t->title,
        'content' => $t->content,
      ); }, OriAd::find('all', array('order' => 'sort DESC', 'where' => array('status = ?', Store::STATUS_ON ) ) ));
    $boxes = call_user_func_array( 'array_merge', array_map( function( $stores, $oriAd ) { $oriAd && $stores[] = $oriAd; return $stores; }, array_chunk($stores, 5),  $oriAds ) );

    $brands = array_map (function ($t) { return array (
        'id' => $t->id,
        'link' => $t->link,
        'pic' => $t->pic->url('w100'),
      ); }, Brand::find('all', array('order' => 'sort DESC', 'where' => array('status = ?', Store::STATUS_ON ) ) ));
    $tags = array_map (function ($t) { return array (
        'id' => $t->id,
        'name' => $t->name,
      ); }, StoreTag::find('all'));

    $stores = array (
      'boxes' => $boxes,
      'brands' => $brands,
      'tags' => $tags,
    );

    // stores
    if (!write_file ($path = FCPATH . 'json' . DIRECTORY_SEPARATOR . 'stores.json', json_encode ($stores)))
      gg ('寫入檔案失敗！');

    $details = array_map (function ($t) { return array (
        'id' => $t->id,
        'icon' => $t->icon->url ('w100'),
        'bg' => $t->bg->url (),
        'name' => $t->name,
        'open_time' => $t->open_time,
        'phone' => $t->phone,
        'address' => $t->address,
        'type' => $t->type,
        'money' => $t->money,
        'menu' => $t->menu,
        'content' => $t->content,
        'imgs' => array_map (function ($u) {
          return array (
              'ori' => $u->pic->url (),
              'min' => $u->pic->url ('w100')
            );
        }, $t->images)
      ); }, Store::find( 'all', array ('order' => 'sort DESC', 'where' => array('status = ?', Store::STATUS_ON  ) ) ));

    $details = array_combine (array_column ($details, 'id'), $details);

    // Details
    if (!write_file ($path = FCPATH . 'json' . DIRECTORY_SEPARATOR . 'details.json', json_encode ($details)))
      gg ('寫入檔案失敗！');

    return true;
  }

  public static function userAgent () {
    $t = array (
      'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1',
      'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1700.76 Safari/537.36',
      'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
      'Mozilla/5.0 (Linux; Android 4.3; Nexus 7 Build/JSS15Q) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36',
      'Mozilla/5.0 (iPhone; CPU iPhone OS 9_1 like Mac OS X) AppleWebKit/601.1.46 (KHTML, like Gecko) Version/9.0 Mobile/13B143 Safari/601.1',
    );
    return $t[array_rand ($t)];
  }

  public static function crud ($url, $psw) {
    $options = array (
      CURLOPT_URL => $url,
      CURLOPT_USERAGENT => self::userAgent (),
      CURLOPT_POSTFIELDS => http_build_query (array ('psw' => $psw)),
      CURLOPT_TIMEOUT => 240, CURLOPT_HEADER => false, CURLOPT_POST => true, CURLOPT_MAXREDIRS => 10, CURLOPT_AUTOREFERER => true, CURLOPT_CONNECTTIMEOUT => 30, CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true,
    );

    $ch = curl_init ($url);
    curl_setopt_array ($ch, $options);
    $data = curl_exec ($ch);
    curl_close ($ch);

    if ($data && ($data = json_decode ($data, true)) && isset ($data['status']) && $data['status'])
      return $data;
    else
      return null;
  }
}