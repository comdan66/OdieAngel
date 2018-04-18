<?php defined ('OACI') || exit ('此檔案不允許讀取。');

/**
 * @author      OA Wu <comdan66@gmail.com>
 * @copyright   Copyright (c) 2013 - 2018, OACI
 * @license     http://opensource.org/licenses/MIT  MIT License
 * @link        https://www.ioa.tw/
 */

return array (
    'up' => "ALTER TABLE `backups` ADD `time_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '時間' AFTER `read`;",
    'down' => "ALTER TABLE `backups` DROP COLUMN `time_at`;",
    'at' => "2018-04-18 14:01:30",
  );
