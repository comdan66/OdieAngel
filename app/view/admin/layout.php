<!DOCTYPE html>
<html lang="tw">
  <head>
    <meta http-equiv="Content-Language" content="zh-tw" />
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui" />

    <title>西門 Wifi 後台系統</title>

    <?php echo $asset->renderCSS ();?>
    <?php echo $asset->renderJS ();?>

  </head>
  <body lang="zh-tw">

    <main id='main'>
      <header id='main-header'>
        <a id='hamburger' class='icon-01'></a>
        <nav><b><?php echo isset ($title) && $title ? $title : '';?></b></nav>
        <a href='<?php echo URL::base ('admin/logout');?>' class='icon-02'></a>
      </header>

      <div class='flash <?php echo $flash['type'];?>'><?php echo $flash['msg'];?></div>

      <div id='container'>
  <?php echo isset ($content) ? $content : ''; ?>
      </div>

    </main>

    <div id='menu'>
      <header id='menu-header'>
        <a href='<?php echo URL::base ();?>' class='icon-21'></a>
        <span>西門 Wifi 後台系統</span>
      </header>

      <div id='menu-user'>
        <figure class='_ic'>
          <img src="<?php echo Asset::url ('assets/img/admin.png');?>">
        </figure>

        <div>
          <span>Hi, 您好!</span>
          <b><?php echo Admin::current ()->name;?></b>
        </div>
      </div>

      <div id='menu-main'>
        
        <div>
          <span class='icon-14'>首頁區</span>
          <div>
            <a href="<?php echo $url = RestfulUrl::url ('admin/Starts@index');?>" class='icon-21<?php echo isset ($current_url) && $url === $current_url ? ' active' : '';?>'>開始使用按鈕</a>
            <a href="<?php echo $url = RestfulUrl::url ('admin/IndexHeaderBanners@index');?>" class='icon-19<?php echo isset ($current_url) && $url === $current_url ? ' active' : '';?>'>上方廣告輪播</a>
            <a href="<?php echo $url = RestfulUrl::url ('admin/IndexFooterBanners@index');?>" class='icon-19<?php echo isset ($current_url) && $url === $current_url ? ' active' : '';?>'>下方廣告輪播</a>
          </div>
        </div>
        <div>
          <span class='icon-14'>商家管理</span>
          <div>
            <a href="<?php echo $url = RestfulUrl::url ('admin/StoreTags@index');?>" class='icon-42<?php echo isset ($current_url) && $url === $current_url ? ' active' : '';?>'>商家分類</a>
            <a href="<?php echo $url = RestfulUrl::url ('admin/Stores@index');?>" class='icon-21<?php echo isset ($current_url) && $url === $current_url ? ' active' : '';?>'>商家列表</a>
          </div>
        </div>
        <div>
          <span class='icon-14'>美食情報</span>
          <div>
            <a href="<?php echo $url = RestfulUrl::url ('admin/OriAds@index');?>" class='icon-21<?php echo isset ($current_url) && $url === $current_url ? ' active' : '';?>'>原生廣告</a>
            <a href="<?php echo $url = RestfulUrl::url ('admin/Brands@index');?>" class='icon-21<?php echo isset ($current_url) && $url === $current_url ? ' active' : '';?>'>品牌輪播</a>
          </div>
        </div>


  <?php if (Admin::current()->in_roles (array (AdminRole::ROLE_ADMIN, AdminRole::ROLE_ROOT))) { ?>
          <div>
            <span class='icon-14' data-cntlabel='backup' data-cnt='<?php echo ($bcnt = Backup::count (Where::create ('`read` = ?', Backup::READ_NO))) + ($dcnt = Deploy::count (Where::create ('`read` = ?', Deploy::READ_NO)));?>'>系統</span>
            <div>
        <?php if (Admin::current()->in_roles (array (AdminRole::ROLE_ADMIN))) { ?>
                <a href="<?php echo $url = RestfulUrl::url ('admin/Admins@index');?>" class='icon-15<?php echo isset ($current_url) && $url === $current_url ? ' active' : '';?>'>後台權限</a>
        <?php } ?>
        <?php if (Admin::current()->in_roles (array (AdminRole::ROLE_ROOT))) { ?>
                <a data-cntlabel='backup' data-cnt='<?php echo $bcnt;?>' href="<?php echo $url = RestfulURL::url ('admin/Backups@index');?>" class='icon-22<?php echo isset ($current_url) && $url === $current_url ? ' active' : '';?>'>每日備份</a>
                <a data-cntlabel='deploy' data-cnt='<?php echo $dcnt;?>' href="<?php echo $url = RestfulURL::url ('admin/Deploys@index');?>" class='icon-10<?php echo isset ($current_url) && $url === $current_url ? ' active' : '';?>'>部署紀錄</a>
        <?php } ?>
            </div>
          </div>
  <?php } ?>

      </div>
    </div>

    <footer id='footer'><span>後台版型設計 by </span><a href='http://www.adpost.com.tw/' target='_blank'>AD Post</a></footer>

  </body>
</html>
