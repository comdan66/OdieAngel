<?php defined ('OACI') || exit ('此檔案不允許讀取。');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2013 - 2018, OACI
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

abstract class ApiController extends Controller {

  public function __construct () {
    parent::__construct ();
    
    if (ENVIRONMENT === 'production')
      header ("Access-Control-Allow-Origin: http://ximen.wifi.adpost.com.tw");
    else
      header ("Access-Control-Allow-Origin: http://dev.ximen.wifi.adpost.com.tw");
  }
}
