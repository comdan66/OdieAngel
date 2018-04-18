<?php defined ('OACI') || exit ('此檔案不允許讀取。');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2013 - 2018, OACI
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

class Source extends Model {
  static $table_name = 'sources';

  static $has_one = array (
  );

  static $has_many = array (
  );

  static $belongs_to = array (
  );

  public function __construct ($attrs = array (), $guardAttrs = true, $instantiatingViafind = false, $newRecord = true) {
    parent::__construct ($attrs, $guardAttrs, $instantiatingViafind, $newRecord);
  }

  public function destroy () {
    if (!isset ($this->id))
      return false;
    
    return $this->delete ();
  }

  const TYPE_USER    = 'user';
  const TYPE_GROUP   = 'group';
  const TYPE_ROOM    = 'room';
  const TYPE_OTHER   = 'other';

  static $typeNames = array (
    self::TYPE_USER   => '使用者',
    self::TYPE_GROUP  => '群組',
    self::TYPE_ROOM   => '聊天室',
    self::TYPE_OTHER  => '其他',
  );

  public static function getType ($event) {
    if ($event->isUserEvent ()) return Source::TYPE_USER;
    if ($event->isGroupEvent ()) return Source::TYPE_GROUP;
    if ($event->isRoomEvent ()) return Source::TYPE_ROOM;
    return Source::TYPE_OTHER;
  }
  public static function findOrCreateSource ($event) {
    if (!$sid = $event->getEventSourceId ())
      return null;
    
    $params = array (
      'sid' => $sid,
      'title' => '',
      'type' => Source::getType ($event)
    );

    if (!$source = Source::find ('one', array ('select' => 'id, sid, title, type', 'conditions' => array ('sid = ?', $params['sid']))))
      if (!Source::transaction (function () use (&$source, $params) { return $source = Source::create ($params); }))
        return null;
    
    $source->updateTitle ();

    return $source;
  }
  public function updateTitle () {
    if (!(isset ($this->id) && isset ($this->sid) && isset ($this->title) && isset ($this->type) && ($this->type == Source::TYPE_USER) && !$this->title))
      return false;

    Load::lib ('OALineBot.php');

    if (!(($oaLineBot = OALineBot::create ()) && ($response = $oaLineBot->bot ()->getProfile ($this->sid)) && $response->isSucceeded () && ($profile = $response->getJSONDecodedBody ()) && isset ($profile['displayName'])))
      return false;
    
    $this->title = $profile['displayName'];
    return $this->save ();
  }
}
