<?php defined ('OACI') || exit ('此檔案不允許讀取。');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2013 - 2018, OACI
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

class Deploy extends Model {
  static $table_name = 'deploys';

  static $has_one = array (
  );

  static $has_many = array (
  );

  static $belongs_to = array (
  );

  const STATUS_FAILURL = 'failure';
  const STATUS_SUCCESS = 'success';

  static $statusNames = array (
    self::STATUS_FAILURL => '失敗',
    self::STATUS_SUCCESS => '成功',
  );

  const READ_NO  = 'no';
  const READ_YES = 'yes';

  static $readTexts = array (
    self::READ_NO  => '未讀',
    self::READ_YES => '已讀',
  );

  public function __construct ($attrs = array (), $guardAttrs = true, $instantiatingViafind = false, $newRecord = true) {
    parent::__construct ($attrs, $guardAttrs, $instantiatingViafind, $newRecord);

    // 設定檔案上傳器
    Uploader::bind ('file', 'DeployFileFileUploader');
  }

  public function destroy () {
    if (!isset ($this->id))
      return false;
    
    return $this->delete ();
  }

  public function putFiles ($files) {
    foreach ($files as $key => $file)
      if (isset ($files[$key]) && $files[$key] && isset ($this->$key) && $this->$key instanceof Uploader && !$this->$key->put ($files[$key]))
        return false;
    return true;
  }
}

/* -- 檔案上傳器物件 ------------------------------------------------------------------ */
class DeployFileFileUploader extends FileUploader {
}
