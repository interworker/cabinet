<!DOCTYPE html>
<html>
<head lang="ru">
    <title>Добавление новых страниц на заданный сайт Интерстола, прописанных в файле structura.txt. Добавление посредством Imacros</title>
    <meta charset="utf-8">
<?php
    
    mb_internal_encoding('UTF-8');
    
    $cabinet_flr = 'cabinet';
    $cabinet_dir = $_SERVER['DOCUMENT_ROOT'] . '/' . $cabinet_flr;
    
    $dir = dirname(realpath(__FILE__));
    
?>
    <link href="/<?=$cabinet_flr?>/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/<?=$cabinet_flr?>/css/mystyle.css" rel="stylesheet">
</head>
<?php
    
    if (isset($_POST['action'])) {
        
        require_once ($cabinet_dir . '/lib/config.php');
        require_once 'myCURL/myCURL.php';
        require_once 'myFiles/myFiles.php';
        require_once 'myFiles/myFilesPhpQuery.php';
        require_once 'myRazbor/myRazbor.php';
        require_once 'phpQuery/phpQuery.php';
        
        $error_log = array( );
        
        $name_of_col = trim($_POST['col']);
        
        $tempdir = 'cabinet/control/tempdir';
        $tempdir = my_path($tempdir);
        
        $structura_filename = basename($_FILES['file']['name']);
        $file = $tempdir . DIRECTORY_SEPARATOR . $structura_filename;
        if ($_FILES['file']['error'] === 0) {
            if (copy($_FILES['file']['tmp_name'], $file)) {
                $structura = my_get_structura_from_file_structura($tempdir, $structura_filename);
                
                if (isset($structura[$name_of_col])) {
                    
                    $titles = my_read_col_file_structura($name_of_col, $tempdir, $structura_filename, true);
                    
                    echo '<pre>';
                    print_r($titles);
                    echo '</pre>';
                }
                else {
                    $error_log[ ] = 'Передан некорректный файл, или указан неправильный заголовок';
                }
            }
        }
        else {
            $error_log[ ] = 'Ошибка при загрузке файла';
        }
    }
    
?>
<body>
    <div class="container">
    
<?php if (count($error_log)): ?>
<?='Присутствует $error_log'?>
<?php endif; ?>
    
    <form method="post" enctype="multipart/form-data" class="form-horizontal"><!-- action="/getpost.php"-->
        <fieldset>
            <legend>Добавление новых страниц на сайт (на базе Интерстола)</legend>
            <div class="control-group">
                <label class="control-label" for="site">Страницы добавляются на сайт:</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="site" name="site" placeholder="http://" REQUIRED>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="file">Структурный файл:</label>
                <div class="controls">
                    <input type="file" class="input-file" id="file" name="file">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="col">Название колонки с Тайтлом новой страницы:</label>
                <div class="controls">
                    <input type="text" class="input-xlarge" id="col" name="col" placeholder="title" REQUIRED>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="sitemap_mode">Проверять наличие страниц по:</label>
                <div class="controls">
                    <select id="sitemap_mode" name="sitemap_mode">
                        <option value="mapsite">mapsite</option>
                        <option value="sitemap">sitemap</option>
                    </select>
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" name="action">Обработать</button>
            </div>
        </fieldset>
    </form>
    
    </div><!-- .container -->
    
    <script src="/<?=$cabinet_flr?>/js/jquery-1.9.1.min.js"></script>
    <script src="/<?=$cabinet_flr?>/js/bootstrap.min.js"></script>
</body>
</html>