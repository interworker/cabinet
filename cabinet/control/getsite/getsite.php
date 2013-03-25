<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="utf-8">
        
        <?php mb_internal_encoding('UTF-8'); ?>
        <?php $today = date('Y-m-d'); ?>
        
        <title>Скачивание страниц сайта</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <?php $root_folder = 'cabinet'; ?>
        <?php $root = $_SERVER['DOCUMENT_ROOT'] . '/' . $root_folder; ?>
        <?php $message = ''; ?>
        
        <!-- ЗАГРУЗКА-СТИЛЕЙ---НАЧАЛО -->
        <link href="/<?=$root_folder?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="/<?=$root_folder?>/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="/<?=$root_folder?>/css/my_style.css" rel="stylesheet">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- ЗАГРУЗКА-СТИЛЕЙ---КОНЕЦ -->
    </head>
<?php

if (isset ($_POST['action']) || isset ($_POST['write']) || isset ($_POST['rewrite'])) {
    
    require_once ($root . '/lib/config.php');
    require_once 'myCURL/myCURL.php';
    require_once 'myFiles/myFiles.php';
    require_once 'myFiles/myFilesPhpQuery.php';
    require_once 'myRazbor/myRazbor.php';
    require_once 'phpQuery/phpQuery.php';
    require_once 'godb/database.php';
    
    $mode = 'mode';/* одна страница, одна страница и все ссылки на ней, до конца, по сайтмапу */
    
    $url = $_POST['url'];
    $pattern_url = '{^(http://)?([^\\s]+?\\.[^\\s]+?)$}i';
    if (preg_match($pattern_url, $url, $match)) {
        $url = 'http://' . $match[2];
    }
    else {
        $url = '';
    }
    
    $area = $_POST['area'];
    
    $dir = '';
    if (mb_strlen($url)) {
        if (mb_strlen($_POST['folder']) === 0) {
            $pattern_folder = '{(http://)?([^/]+)}i';
            if (preg_match($pattern_folder, $url, $match)) {
                $folder = str_replace('.', '__', $match[2]);
                $dir = my_path("$root/control/tempdir/$folder");
            }
        }
        else {
            $folder = $_POST['folder'];
            $dir = my_path("$root/control/tempdir/$folder");
        }
    }
    else {
        $message = <<< ERROR
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h4>Ошибка mb_strlen(url) = 0</h4>
</div>
<a href="/{$root_folder}/control/getsite/getsite.php" class="btn btn-success">Вернуться в начало</a>
ERROR;
    }
    
    $check = -1;
    if (mb_strlen($dir)) {
        $check = 1;
        if (isset ($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'windows-1251', 'UTF-8');
        if (file_exists($dir)) {
            if (isset ($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
            if (!isset ($_POST['write']) && !isset ($_POST['rewrite'])) {
$message = <<< FORM
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h4>Внимание, папка {$folder} уже существует!</h4>
</div>
<form method="post">
    <input type="hidden" name="url" value="{$url}">
    <input type="hidden" name="area" value="{$area}">
    <input type="hidden" name="folder" value="{$folder}">
    <button type="submit" class="btn btn-warning" name="write">Продолжить без удаления</button>
    &nbsp;&nbsp;
    <button type="submit" class="btn btn-danger" name="rewrite">Продолжить с удалением</button>
    &nbsp;&nbsp;
    <a href="/{$root_folder}/control/getsite/getsite.php" class="btn btn-success">Вернуться в начало</a>
</form>
FORM;
            }
            elseif (isset ($_POST['rewrite'])) {
                $check = my_remove_dir($dir);
            }
        }
        else {
            if (isset ($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
        }
    }
    else {
        $message = <<< ERROR
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h4>Ошибка mb_strlen(dir) = 0</h4>
</div>
<a href="/{$root_folder}/control/getsite/getsite.php" class="btn btn-success">Вернуться в начало</a>
ERROR;
    }
    
    $go = FALSE;
    if ($check === 1) {
        if (isset ($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'windows-1251', 'UTF-8');
        if (!file_exists($dir)) {
            if (isset ($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
            $dir = my_make_dirs($dir);
            if (mb_strlen($dir)) $go = TRUE;
        }
        elseif (isset ($_POST['write'])) {
            if (isset ($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
            $go = TRUE;
        }
        else {
            if (isset ($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
        }
    }
    else {
        $message = <<< ERROR
<div class="alert alert-error">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <h4>Ошибка check !== 1</h4>
</div>
<a href="/{$root_folder}/control/getsite/getsite.php" class="btn btn-success">Вернуться в начало</a>
ERROR;
    }
    
    if ($go) {
        
        $structura = array ('id' => 1, 'level' => 2, 'parent' => 3, 'url' => 4, 'file' => 5, 'file_etalon' => 6, 'anchor' => 7, 'title' => 8);
        
        $filename_structura = 'structura.txt';
        $file_structura = my_file($filename_structura, $dir);
        
        $structura = my_create_file_structura($structura, $dir, $filename_structura);
        
        if (count($structura)) {
            $num_row = 1;
            $data = array ( );
            $id = 1;
            $data[ ] = array ('id' => $id, 'level' => 0, 'parent' => 0, 'url' => $url);
            
            if (my_write_file_structura($data, $num_row, 'rewrite', $dir, $filename_structura)) {
                
                do {
                    $task = my_read_row_file_structura($num_row, $dir, $filename_structura);
                    
                    if ($task['parent'] === 0) {
                        $refer = FALSE;
                    }
                    else {
                        $where['id'] = $task['parent'];
                        $refer = my_read_cell_where_file_structura($where, 'url', $dir, $filename_structura);
                    }
                    
                    if (@mb_strlen($task['url'])) $files = my_getsite($task['url'], $dir, TRUE, $today, $refer);
                    
                    if (mb_strlen($files['file'])) {
                        $meta = my_get_meta($files['file']);
                        if (isset($meta['title'])) {
                            $title = $meta['title'];
                        }
                        else {
                            $title = '';
                        }
                        
                        $data_rewrite[1] = array('id' => $task['id'], 'level' => $task['level'], 'parent' => $task['parent'], 'url' => $task['url'], 'file' => $files['file'], 'file_etalon' => $files['file_etalon'], 'anchor' => $task['anchor'], 'title' => $title);
                        if (my_write_file_structura($data_rewrite, $num_row, 'rewrite', $dir, $filename_structura)) {
                            
                            $urls_already = my_read_col_file_structura('url', $dir, $filename_structura);
                            
                            $urls_func = my_get_urls($files['file'], $only_html_files = TRUE, $substring = $area, $no_img = FALSE, $parts_regexp = FALSE, $parts_phpquery = FALSE);
                            
                            $urls = array( );
                            foreach ($urls_func as $source => $anchors) {
                                foreach ($anchors as $href => $anchor) {
                                    if (array_search($href, $urls_already) === FALSE) $urls[$href] = $anchor;
                                }
                            }
                            
                            $data = array ( );
                            foreach ($urls as $href => $anchor) {
                                $id++;
                                $level = $task['level'] + 1;
                                $parent = $task['id'];
                                $data[ ] = array ('id' => $id, 'level' => $level, 'parent' => $parent, 'url' => $href, 'anchor' => $anchor);
                            }
                            if (count($data)) my_write_file_structura($data, $num_row, 'write', $dir, $filename_structura);
                            $num_row++;
                        }
                    }
                    $num_rows = count(my_file_to_array($file_structura)) - count($structura);
                }
                while ($num_row <= $num_rows);
                
                $message = <<< DONE
<h4>Весь сайт пройден!</h4>
<a href="/{$root_folder}/control/getsite/getsite.php" class="btn btn-success">Вернуться в начало</a>
DONE;
            }
        }
    }
    else {
        $query = 'INSERT INTO `errors` (`filename`, `place`, `description`, `checkdate`) VALUES (?, ?i, ?, ?)';
        $data = array (__FILE__, __LINE__, 'Произошла ошибка $go === FALSE', $today);
        $db->query($query, $data);
    }
}
?>
    <body>
        <div class="container">
        
        <?php if (mb_strlen($message)): ?>
            <?=$message?>
        <?php else: ?>
            <form method="post">
                <legend>Сайт для скачивания</legend>
                <label for="url">URL</label>
                <input class="span7" type="text" id="url" name="url" value="http://" REQUIRED>
                <label for="area">Раздел, за который нельзя выходить</label>
                <input class="span7" type="text" id="area" name="area" placeholder="Если не указано, то идем по всем ссылкам (внутри сайта)">
                <label for="folder">Папка для записи</label>
                <input class="span7" type="text" id="folder" name="folder" placeholder="Если не указано, будет создана новая папка по имени домена">
                <br><br>
                <button type="submit" class="btn btn-primary" name="action">Обработать</button>
            </form>
        <?php endif; ?>
            
        </div> <!-- .container -->
        
        <!-- ПОДКЛЮЧЕНИЕ-СКРИПТОВ---НАЧАЛО -->
        <script src="/<?=$root_folder?>/js/jquery-1.8.1.min.js"></script>
        <script src="/<?=$root_folder?>/js/bootstrap.min.js"></script>
        <script src="/<?=$root_folder?>/js/my_script.js"></script>
        <!-- ПОДКЛЮЧЕНИЕ-СКРИПТОВ---КОНЕЦ -->
    </body>
</html>