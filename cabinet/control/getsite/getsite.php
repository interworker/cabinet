<!DOCTYPE html>
<html lang="ru">
    <head>
        <title>Скачивание страниц сайта</title>
        <meta charset="utf-8">
    <?php
        
        mb_internal_encoding('UTF-8');
        
        $cabinet_flr = 'cabinet';
        $cabinet_dir = $_SERVER['DOCUMENT_ROOT'] . '/' . $cabinet_flr;
        
        $dir = dirname(realpath(__FILE__));
        
        $message = '';
        $today = date('Y-m-d');
        
    ?>
        <!-- ЗАГРУЗКА-СТИЛЕЙ---НАЧАЛО -->
        <link href="/<?=$cabinet_flr?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="/<?=$cabinet_flr?>/css/bootstrap-responsive.min.css" rel="stylesheet">
        <link href="/<?=$cabinet_flr?>/css/mystyle.css" rel="stylesheet">
        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
          <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!-- ЗАГРУЗКА-СТИЛЕЙ---КОНЕЦ -->
    </head>
<?php
    if (isset($_POST['action'])) {
        
        require_once ($cabinet_dir . '/lib/config.php');
        
        require_once 'godb/database.php';
        require_once 'myCURL/myCURL.php';
        require_once 'myFiles/myFiles.php';
        require_once 'myFiles/myFilesPhpQuery.php';
        require_once 'myRazbor/myRazbor.php';
        require_once 'phpQuery/phpQuery.php';
        
        require_once 'dumper.php';
        
        echo '<H3>$_POST[ action ]</H3>', PHP_EOL;
        dumper($_POST);
        
/* Начало разбора POST запроса */
        $start_url = $_POST['start_url'];
        
        $method = $_POST['method'];
        
        $method_one_dir_string = $_POST['method_one_dir_string'];
        
        $exclude_string = $_POST['exclude_string'];
        
        $algorithm = false;
        if (isset($_POST['algorithm'])) $algorithm = true;
        
        $only_SGML = false;
        if (isset($_POST['only_SGML'])) $only_SGML = true;
        
        $etalon = false;
        if (isset($_POST['etalon'])) $etalon = true;
        
        $another = false;
        if (isset($_POST['another'])) $another = true;
        
        $linkmode = $_POST['linkmode'];
        
        $work_dir = $_POST['work_dir'];
/* Конец разбора POST запроса */
        
/* Добавить в FORM данные по строке $linkmode_transform_string и $proxy */
/* Принудительно */
        $linkmode_transform_string = '';
        $proxy = false;
        
        my_curl($start_url, $work_dir, $method, $method_one_dir_string, $algorithm, $only_SGML, $etalon, $exclude_string, $another, $linkmode, $linkmode_transform_string, $proxy);
        
/* Переделать */
        $message = '<p>Сделано</p>';
    }
?>
    <body>
        <div class="container">
            
        <?php if (mb_strlen($message)): ?>
            <?=$message?>
        <?php endif; ?>
        
        <?php if (isset($_POST['work_dir'])): ?>
            <form method="post" class="form-horizontal">
                <fieldset>
                    <legend>Анализируемый сайт</legend>
                    <div class="control-group">
                        <label class="control-label" for="start_url">Стартовый URL</label>
                        <div class="controls">
                            <input type="text" id="start_url" name="start_url" placeholder="с http://" REQUIRED>
                        </div><!-- .controls -->
                    </div><!-- .control-group -->
                    <div class="control-group">
                        <label class="control-label" for="method">Метод анализа</label>
                        <div class="controls">
                            <input type="text" id="method" name="method" placeholder="one_dir" REQUIRED>
                        </div><!-- .controls -->
                    </div><!-- .control-group -->
                    <div class="control-group">
                        <label class="control-label" for="method_one_dir_string">Директория для метода <b>one_dir</b></label>
                        <div class="controls">
                            <input type="text" id="method_one_dir_string" name="method_one_dir_string" placeholder="по первой ссылке, если пусто">
                        </div><!-- .controls -->
                    </div><!-- .control-group -->
                    <div class="control-group">
                        <label class="control-label" for="exclude_string">Исключать URL, содержащие</label>
                        <div class="controls">
                            <input type="text" id="exclude_string" name="exclude_string">
                        </div><!-- .controls -->
                    </div><!-- .control-group -->
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" name="algorithm">Работать по алгоритму (для метода <b>all_from_one_link</b> или <b>one_dir</b>)
                            </label><!-- .checkbox -->
                        </div><!-- .controls -->
                    </div><!-- .control-group -->
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" name="only_SGML">Только SGML
                            </label><!-- .checkbox -->
                        </div><!-- .controls -->
                    </div><!-- .control-group -->
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" name="etalon">Создавать эталон
                            </label><!-- .checkbox -->
                        </div><!-- .controls -->
                    </div><!-- .control-group -->
                    <div class="control-group">
                        <div class="controls">
                            <label class="checkbox">
                                <input type="checkbox" name="another">Выходить за пределы базового URL
                            </label><!-- .checkbox -->
                        </div><!-- .controls -->
                    </div><!-- .control-group -->
                    <div class="control-group">
                        <label class="control-label" for="linkmode">Метод обработки ссылок</label>
                        <div class="controls">
                            <input type="text" id="linkmode" name="linkmode" placeholder="linkmode" REQUIRED>
                        </div><!-- .controls -->
                    </div><!-- .control-group -->
                    <!-- HIDDEN INPUTS -->
                    <input type="hidden" name="work_dir" value="<?=$_POST['work_dir']?>">
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary" name="action">Обработать</button>
                    </div><!-- .form-actions -->
                </fieldset>
            </form><!-- .form-horizontal -->
        <?php else: ?>
            <form method="post" class="form-inline">
                <span class="help-block">Введите относительный путь к рабочей папке (от корня кабинета)</span>
                <input type="text" name="work_dir" class="input-xlarge" placeholder="cabinet/control/tempdir">
                <button type="submit" class="btn btn-primary">Установить</button>
            </form><!-- .form-inline -->
        <?php endif; ?>
            
        </div> <!-- .container -->
        
        <!-- ПОДКЛЮЧЕНИЕ-СКРИПТОВ---НАЧАЛО -->
        <script src="/<?=$cabinet_flr?>/js/jquery-1.8.1.min.js"></script>
        <script src="/<?=$cabinet_flr?>/js/bootstrap.min.js"></script>
        <script src="/<?=$cabinet_flr?>/js/my_script.js"></script>
        <!-- ПОДКЛЮЧЕНИЕ-СКРИПТОВ---КОНЕЦ -->
    </body>
</html>