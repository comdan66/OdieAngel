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
          OALineBotMsg::create ()->text ('Hello 大家好，我是 Odie 小添屎！ 嘿嘿')->reply ($log);
          break;

        case 'LogImage':
          // OALineBotMsg::create ()->image ($log->file->url ())->reply ($log);
          break;

        case 'LogLocation':
          // OALineBotMsg::create ()->text ($log->latitude . ' - ' . $log->longitude)->reply ($log);
          break;

        case 'LogFollow':
          // OALineBotMsg::create ()->text ('Hello 你好～😊')->reply ($log);
          break;

        case 'LogText':
          $pattern = 'Miller';
          $pattern = !preg_match ('/\(\?P<k>.+\)/', $pattern) ? '/(?P<k>(' . $pattern . '))/i' : ('/(' . $pattern . ')/i');
          preg_match_all ($pattern, $log->text, $result);
          
          if (!$result['k']) 
            break;

          if ($source->sid == 'C8f870c3f0d5b095efe0866504205bdb2') {
            OALineBotMsg::create ()->text ('幹嘛？找我逆！？')->reply ($log);
          } else {
            OALineBotMsg::create ()->text ('~~~~')->reply ($log);
          }

          break;
        
        case 'LogPostback':
          break;

        default:
          break;
      }
    }
  }
}
