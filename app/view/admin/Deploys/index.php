<?php echo $search; ?>

<div class='panel'>
<?php echo $search->setTableClomuns (
  Restful\Column::create ('已讀')->setWidth (60)->setClass ('center')->setTd (function ($obj, $column) { return $column->setSwitch ($obj->read == Deploy::READ_YES, array ('class' => 'switch ajax', 'data-column' => 'read', 'data-url' => RestfulURL::url ('admin/Deploys@read', $obj), 'data-true' => Deploy::READ_YES, 'data-false' => Deploy::READ_NO, 'data-cntlabel' => 'deploy')); }),
  Restful\Column::create ('ID')->setWidth (60)->setSort ('id')->setTd (function ($obj) { return $obj->id; }),
  Restful\Column::create ('狀態')->setWidth (100)->setTd (function ($obj) { return $obj->status != Deploy::STATUS_SUCCESS ? '<b style="color: red">' . Deploy::$statusNames[$obj->status] . '</b>' : Deploy::$statusNames[$obj->status]; }),
  Restful\Column::create ('大小')->setWidth (100)->setTd (function ($obj) { return byte_format ($obj->size); }),
  Restful\Column::create ('檔案')->setTd (function ($obj) { return $obj->file->link ('紀錄檔', array ('target' => '_blank')); }),
  Restful\Column::create ('建立時間')->setWidth (155)->setClass ('right')->setTd (function ($obj) { return $obj->created_at->format ('Y-m-d H:i:s'); })
  );
?>
</div>

<div class='pagination'><div><?php echo $pagination;?></div></div>
