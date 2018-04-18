<?php defined ('OACI') || exit ('此檔案不允許讀取。');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2013 - 2018, OACI
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

class pvs extends ApiController {

  public function __construct () {
    parent::__construct ();
  }

  public function index() {
    $validation = function(&$posts, &$pvModel, &$obj) {
      Validation::need ($posts, 'table', '表格')->isString ()->doTrim ()->doRemoveHtmlTags ();
      Validation::need ($posts, 'id', 'ID')->isNumber ()->doTrim ()->doRemoveHtmlTags ()->greater (0);

      if (!(in_array ($model = $posts['table'], array ('Brand', 'IndexFooterBanner', 'IndexHeaderBanner', 'OriAd', 'Store', 'Start')) && class_exists ($model)))
        Validation::error('查無資訊(1)！');

      if (!class_exists ($pvModel = 'Pv' . $model))
        Validation::error('查無資訊(2)！');

      if (!$obj = $model::find ('one', array ('select' => 'id, click_cnt', 'where' => array ('id = ?', $posts['id']))))
        Validation::error('查無資訊(3)！');
    };

    $posts = Input::post ();

    if ($error = Validation::form ($validation, $posts, $pvModel, $obj))
      return Output::json ($error, 400);
    

    $transaction = function ($posts, $pvModel, $obj) {
      if (!$obj->create_pvs (array ()))
        return false;

      $obj->click_cnt = count ($obj->pvs);
      return $obj->save ();
    };

    if ($error = $pvModel::getTransactionError ($transaction, $posts, $pvModel, $obj))
      return Output::json ($error, 400);

    return Output::json (array (
      'result' => true,
    ));
  }
}
