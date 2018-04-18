<?php defined ('OACI') || exit ('此檔案不允許讀取。');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2013 - 2018, OACI
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

class LogAudio extends Model {
  static $table_name = 'log_audios';

  static $has_one = array (
  );

  static $has_many = array (
  );

  static $belongs_to = array (
  );

  public function __construct ($attrs = array (), $guardAttrs = true, $instantiatingViafind = false, $newRecord = true) {
    parent::__construct ($attrs, $guardAttrs, $instantiatingViafind, $newRecord);

    // 設定檔案上傳器
    Uploader::bind ('file', 'LogAudioFileFileUploader');
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

  public function putFile2S3 () {
    return true;
    if (!(isset ($this->id) && isset ($this->file) && isset ($this->message_id) && !((string)$this->file) && $this->message_id)) return false;
    
    Load::lib ('OALineBot.php');
    Load::sysFunc ('file.php');

    if (!(($oaLineBot = OALineBot::create ()) &&
        ($response = $oaLineBot->bot ()->getMessageContent ($this->message_id)) &&
        $response->isSucceeded () &&
        ($path = FCPATH . 'tmp' . DIRECTORY_SEPARATOR . uniqid (rand () . '_') . (($contentType = $response->getHeader ('Content-Type')) ? get_extension_by_mime ($contentType) : '')) &&
        write_file ($path, $response->getRawBody ())))
      return false;

    return $this->file->put ($path);
  }
}

/* -- 檔案上傳器物件 ------------------------------------------------------------------ */
class LogAudioFileFileUploader extends FileUploader {
}
