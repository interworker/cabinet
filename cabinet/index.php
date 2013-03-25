<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Кабинет</title>
        <?php
            $root_folder = 'cabinet';
            $root = $_SERVER['DOCUMENT_ROOT'] . '/' . $root_folder;
        ?>
        <meta charset="utf-8">
        <?php mb_internal_encoding('UTF-8'); ?>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- ЗАГРУЗКА-СТИЛЕЙ---НАЧАЛО -->
        <link href="/<?=$root_folder?>/css/bootstrap.css" rel="stylesheet">
        <link href="/<?=$root_folder?>/css/bootstrap-responsive.css" rel="stylesheet">
        <link href="/<?=$root_folder?>/css/MY_styles.css" rel="stylesheet">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- ЗАГРУЗКА-СТИЛЕЙ---КОНЕЦ -->
        <?php
            require_once ($root . '/lib/config.php');
            require_once 'godb/database.php';
        ?>
    </head>
    <body>
        <?php
            if (isset ($_GET['reset'])) {
                $db->query('UPDATE `mainpage` SET `switch`=?i WHERE `id`=?i', array (0, 1));
            }
        ?>
        <div class="container">
            <div class="row">
                <div class="span2">
                    <a href="/<?=$root_folder?>/index.php">Главная</a>
                </div><!-- .span2 -->
                <div class="span2">
                    <a href="http://www.internet-stolica.ru/cabinet.php?idr=102&c=73bf65c463">Кабинет представителя</a>
                </div><!-- .span2 -->
                <div class="span2 offset6">
                    <a href="/<?=$root_folder?>/index.php?reset" class="btn red-border">Задать главную</a>
                </div><!-- .span2 .offset2 -->
            </div><!-- .row -->
            <?php
                $switch = $db->query('SELECT `switch` FROM `mainpage` WHERE `id`=?i', array(1), 'el');
            ?>
            <?php if ($switch): ?>
                <span>On</span>
            <?php else: ?>
                <span>Off</span>
            <?php
                $db->query('UPDATE `mainpage` SET `switch`=?i WHERE `id`=?i', array (1, 1));
            ?>
            <?php endif; ?>
        </div><!-- .container -->
        
        <!-- ПОДКЛЮЧЕНИЕ-СКРИПТОВ---НАЧАЛО -->
        <script src="/<?=$root_folder?>/js/jquery-1.7.2.min.js"></script>
        <script src="/<?=$root_folder?>/js/bootstrap.min.js"></script>
        <script src="/<?=$root_folder?>/js/MY_scripts.js"></script>
        <!-- ПОДКЛЮЧЕНИЕ-СКРИПТОВ---КОНЕЦ -->
    </body>
</html>