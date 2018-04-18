<?php defined ('OACI') || exit ('此檔案不允許讀取。');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2013 - 2018, OACI
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

class Line extends ApiController {

  public function __construct () {
    parent::__construct ();
  }

  public function index () {
    Load::lib ('OALineBot.php');

    foreach (OALineBot::events () as $event) {
      if (!$source = Source::findOrCreateSource ($event))
        continue;
      
      $speaker = Source::findOrCreateSpeaker ($event);
      
      if (!$log = OALineBot::createLog ($source, $speaker, $event))
        continue;


      switch (get_class ($log)) {
        case 'LogJoin':
          break;

        case 'LogLocation':
          OALineBotMsg::create ()->text ($log->latitude . ' - ' . $log->longitude)->reply ($log);
          break;

        case 'LogFollow':
          OALineBotMsg::create ()->text ('Hello 你好～😊')->reply ($log);
          break;

        case 'LogText':
          OALineBotMsg::create ()->text ($log->text)->reply ($log);
          break;
        
        case 'LogPostback':
          break;

        default:
          break;
      }
    }
  }
}
