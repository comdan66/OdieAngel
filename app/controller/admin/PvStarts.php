<?php defined ('OACI') || exit ('此檔案不允許讀取。');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2013 - 2018, OACI
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

class PvStarts extends AdminRestfulController {

  public function __construct () {
    parent::__construct ();
    $this->layout->with ('title', '開始使用按鈕')
                 ->with ('current_url', RestfulUrl::url ('admin/Starts@index'));
  }

  public function index () {
    $where = Where::create ('start_id = ?', $this->parent->id);

    $search = Restful\Search::create ($where)
                            ->input ('開始日期', function ($val) { return Where::create ('DATE(created_at) >= ?', $val); }, 'date')
                            ->input ('結束日期', function ($val) { return Where::create ('DATE(created_at) <= ?', $val); }, 'date');

    $total = PvStart::count ($where);
    $page  = Pagination::info ($total);
    $objs  = PvStart::find ('all', array (
               'order' => Restful\Order::desc ('created_at'),
               'offset' => $page['offset'],
               'limit' => $page['limit'],
               'where' => $where));

    $search->setObjs ($objs)
           ->setTotal ($total);

    return $this->view->setPath ('admin/Pvs/index.php')
                      ->with ('search', $search)
                      ->with ('pagination', implode ('', $page['links']));
  }

  public function add () {
  }

  public function create () {
  }

  public function edit ($obj) {
  }

  public function update ($obj) {
  }

  public function destroy ($obj) {
  }

  public function show ($obj) {
  }
}
