<!DOCTYPE html>
<html lang="tw">
  <head>
    <meta http-equiv="Content-Language" content="zh-tw" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />

    <title>Ximen Free Wifi 西門智慧商圈</title>

    <?php echo $asset->renderCSS ();?>
    <?php echo $asset->renderJS ();?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-112653908-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-112653908-1');
</script>

  </head>
  <body lang="zh-tw">
    <main id='main'>
      <div id='header' class="<?php ?>">
        <h1><a href="<?php echo Url::base('intro');?>">Ximen Free Wifi 西門智慧商圈</a></h1>
        <a class='icon-2' id='sf'></a>
        <a class='icon-1' id='st'></a>

        <form id='fm' action='<?php echo Url::base ('stores'); ?>'>
          <input type='text' name='f' value='<?php echo $f; ?>' minlength='0'/>
          <button class='icon-2'> 搜尋</button>
        </form>

        <div id='tags'>
          <?php foreach( $storeTags as $storeTag ): ?>
            <a href='<?php echo Url::base ('stores/?t=' . $storeTag->id . ''); ?>'><?php echo $storeTag->name; ?></a>
          <?php endforeach; ?>
        </div>
      </div>

      <div id='list'>
  <?php foreach( $boxes as $box ): ?>
    <?php if( $box instanceof OriAd ): ?>
            <div class='box' data-link='<?php echo $box->link; ?>' data-ajax='<?php echo Url::base ('api/pvs/'); ?>' data-table='<?php echo get_class($box); ?>' data-id='<?php echo($box->id);?>'>
              <div class='logo'>
                <img src='<?php echo $box->pic->url('w100'); ?>' />
              </div>
              <div class='content'>
                <h2><?php echo $box->title; ?></h2>
                <span><?php echo $box->content; ?></span>
                <a>瀏覽商點</a>
              </div>
            </div>
    <?php else: ?>
            <div class='box' data-box='<?php echo Url::base ('api/stores/' . $box->id); ?>' data-ajax='<?php echo Url::base ('api/pvs/'); ?>' data-table='<?php echo get_class($box); ?>' data-id='<?php echo($box->id);?>'>
              <div class='logo'>
                <img src='<?php echo $box->icon->url('w100'); ?>' />
              </div>
              <div class='content'>
                <h2><?php echo $box->name; ?></h2>
                <span><?php echo $box->content; ?></span>
                <a>瀏覽商點</a>
              </div>
            </div>
    <?php endif; ?>
    <?php endforeach; ?>
  </div>

      <div id='banner' class='swiper-container'>
        <a class='icon-3 l swiper-button-prev'></a>
        <a class='icon-4 r swiper-button-next'></a>
        <div class='swiper-wrapper banner'>
    <?php foreach( $brands as $brand ): ?>
            <a class='swiper-slide ad box' data-link='<?php echo $brand->link;?>' data-ajax='<?php echo Url::base ('api/pvs/'); ?>' data-table='<?php echo get_class($brand); ?>' data-id='<?php echo $brand->id; ?>'>
              <img src='<?php echo $brand->pic->url('w100'); ?>'>
            </a>
    <?php endforeach;?>
        </div>
      </div>
    </main>

  </body>
</html>
