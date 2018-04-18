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
    <div id='top' class='swiper-container'>
      <div class='swiper-wrapper'>
<?php foreach ($hBanners as $banner) { ?>
        <a class='box swiper-slide' data-link='<?php echo $banner->link;?>' data-ajax='<?php echo Url::base ('api/pvs/'); ?>' data-table='<?php echo get_class($banner); ?>' data-id='<?php echo($banner->id);?>'>
          <img src="<?php echo $banner->pic->url ('min');?>">
        </a>
<?php }?>
      </div>
    </div>
    <div id='mid'>
      <a class='img' href='<?php echo Url::base ('stores');?>'>
        <img src="/assets/img/store.jpg" >
      </a>
    </div>
    <div id='bot' class='swiper-container'>
      <div class='swiper-wrapper'>
  <?php foreach ($fBanners as $banner) { ?>
          <a class='box swiper-slide' data-link='<?php echo $banner->link;?>' data-ajax='<?php echo Url::base ('api/pvs/'); ?>' data-table='<?php echo get_class($banner); ?>' data-id='<?php echo($banner->id);?>'>
            <img src="<?php echo $banner->pic->url ('min');?>">
          </a>
  <?php }?>
      </div>
    </div>
  </body>
</html>
