<?php

function is_nonzero($var) {
    return (mb_strlen($var) !== 0);
}

function is_nonzero_hard($var) {
    return (($var !== "\r") && ($var !== "\n") && ($var !== "\r\n") && (mb_strlen($var) !== 0));
}

function my_file_to_array($file, $trim = TRUE) {
    
    $result_trim = array ( );
    
    if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
    if (file_exists($file)) {
        $lines = explode("\n", file_get_contents($file));
        if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
        
        $lines = array_filter($lines, 'is_nonzero_hard');
        
        if (count($lines)) {
            foreach ($lines as $line) {
                if (mb_substr($line, 0, 1) === "\r") $line = mb_substr($line, 1);
                if (mb_substr($line, -1) === "\r") $line = mb_substr($line, 0, -1);
                if ($trim) {
                    $result[ ] = trim($line);
                }
                else $result[ ] = $line;
            }
            foreach ($result as $res) {
                if (mb_strlen($res)) $result_trim[ ] = $res;
            }
        }
    }
    
    return $result_trim;
}

function my_string_to_array($string, $trim = TRUE) {
    
    $result = array ( );
    
    if (mb_strlen($string)) {
        $lines = explode("\n", $string);
        $lines = array_filter($lines, 'is_nonzero_hard');
        
        if (count($lines)) {
            foreach ($lines as $line) {
                if (mb_substr($line, 0, 1) === "\r") $line = mb_substr($line, 1);
                if (mb_substr($line, -1) === "\r") $line = mb_substr($line, 0, -1);
                if ($trim) {
                    $result[ ] = trim($line);
                }
                else $result[ ] = $line;
            }
        }
    }
    
    return $result;
}

function my_url_file($file) {
    
    $url = '';
    
    $file = str_replace("\\", '/', $file);
    
    $pattern1 = '{([^\/]+\.[^\.]+\.[^\.]+)$}i';
    $pattern2 = '{^([^\/]+\/)(www)?(\/)?(.*)$}i';
    $replace2 = '$2.$1$4';
    preg_match($pattern1, $file, $match);
    if (mb_strlen($match[0]) > 0) {
        if (preg_match($pattern2, $match[1]) === 1) {
            $url = preg_replace($pattern2, $replace2, $match[1]);
            $url = 'http://' . $url;
        }
    }
    
    return $url;
}

function file_anchor( $file_win ) {

    $file_url = file_url( $file_win );

    $result = '<a href="' . $file_url . '">' . $file_win . '</a>';

    return $result;
}

function my_path($dir = '') {
    
    $result = '';
    
    if (mb_strlen($dir) > 0) {
        if ((mb_substr($dir, -1) === '/') || (mb_substr($dir, -1) === "\\")) $dir = mb_substr($dir, 0, -1);
	}
    
	$sistem = php_uname('s');
    
	if (mb_stripos($sistem, 'Windows') !== FALSE) {
		$document_root = str_replace('/', '\\', $_SERVER['DOCUMENT_ROOT']);
		if (mb_strlen($dir)) $dir = str_replace('/', '\\', $dir);
	}
	else {
		$document_root = $_SERVER['DOCUMENT_ROOT'];
		if (mb_strlen($dir)) $dir = str_replace('\\', '/', $dir);
	}
    
	if (mb_stripos($dir, $document_root) === FALSE) {
        if ((mb_substr($dir, 0, 1) === '/') || (mb_substr($dir, 0, 1) === '\\')) $dir = mb_substr($dir, 1);
        $path = $document_root . DIRECTORY_SEPARATOR . $dir;
    }
    else {
        $path = $dir;
    }
    
	if ((mb_substr($path, -1) === '/') || (mb_substr($path, -1) === '\\')) $path = mb_substr($path, 0, -1);
    
    $result = $path;
    
    return $result;
}

function my_check_tempdir($dir, $tempdir = 'cabinet/control/tempdir') {
    
    $result = FALSE;
    
    $dir = my_path($dir);
    $tempdir = my_path($tempdir);
    
    if ((mb_strlen($dir) >= mb_strlen($tempdir)) && (mb_stripos($dir, $tempdir) !== FALSE)) {
        $result = TRUE;
    }
    
    return $result;
}

function my_make_dirs($dir, $rel_folder = '') {
    
    $result = '';
    
    $tempfolder = 'cabinet/control/tempdir';
    
    $dir = my_path($dir);
    $tempdir = my_path($tempfolder);
    
    if (mb_strlen($rel_folder) && (mb_stripos($rel_folder, $dir) === FALSE)) {
        if ((mb_substr($rel_folder, 0, 1) === '/') || (mb_substr($rel_folder, 0, 1) === '\\')) $rel_folder = mb_substr($rel_folder, 1);
        if ((mb_substr($rel_folder, -1) === '/') || (mb_substr($rel_folder, -1) === '\\')) $rel_folder = mb_substr($rel_folder, 0, -1);
        if (isset ($_SERVER['COMSPEC'])) {
            $rel_folder = str_replace('/', '\\', $rel_folder);
        }
        else {
            $rel_folder = str_replace('\\', '/', $rel_folder);
        }
        $dir .= DIRECTORY_SEPARATOR . $rel_folder;
    }
    
    if ((mb_strlen($dir) >= mb_strlen($tempdir)) && (mb_stripos($dir, $tempdir) !== FALSE)) {
        
        $pattern_tempdir = $_SERVER['DOCUMENT_ROOT'];
        if (mb_substr($pattern_tempdir, -1) !== '/') $pattern_tempdir .= '/';
        $pattern_tempdir .= $tempfolder;
        
        $pattern_dirs_str = $pattern_tempdir . '/';
        $delimiter = '/';
        
        if (isset ($_SERVER['COMSPEC'])) {
            $pattern_tempdir = str_replace('/', '\\\\', $pattern_tempdir);
            $pattern_dirs_str = $pattern_tempdir . '\\\\';
            $delimiter = str_replace('/', '\\', $delimiter);
        }
        
        $pattern_dirs_str = '{^' . $pattern_dirs_str . '(.+?)$}i';
        
        if (preg_match($pattern_dirs_str, $dir, $match)) {
            if (mb_strlen($match[1])) {
                if (mb_substr($match[1], 0, 1) === $delimiter) $match[1] = mb_substr($match[1], 1);
                if (mb_substr($match[1], -1) === $delimiter) $match[1] = mb_substr($match[1], 0, -1);
                
                $folders = explode($delimiter, $match[1]);
                
                $dir = $tempdir;
                foreach ($folders as $folder) {
                    $dir .= DIRECTORY_SEPARATOR . $folder;
                    if (isset ($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'windows-1251', 'UTF-8');
                    if (!is_dir($dir)) @mkdir($dir, 0777);
                    if (isset ($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
                }
            }
        }
        if (isset ($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'windows-1251', 'UTF-8');
        if (is_dir($dir)) {
            if (isset ($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
            $result = $dir;
        }
    }
    
    return $result;
}

function my_absolute_path_from_url($url) {
    $result = '';
    $pattern = '{^http:\/\/[^\/]+\/(.+)\/([^\/]+)$}i';
    $check = preg_match($pattern, $url, $matches);
    if ($check !== FALSE) {
        $dir = my_path($matches[1]);
        $filename = $matches[2];
        $result = $dir . DIRECTORY_SEPARATOR . $filename;
    }
    return $result;
}

function my_out_file_name($file_in, $dir_out = '') {

    if (!$out_dir) {
        $out_file = $in_file;
    }
    else {
        $reg_ex_file_name = '{([^\\\/]+\.[a-zA-Z]+)$}i';
        preg_match( $reg_ex_file_name, $in_file, $match );
        if ( $match[ 0 ] ) $out_file_name = $match[ 1 ];

        $out_file = $out_dir . DIRECTORY_SEPARATOR . $out_file_name;
    }

    $result = $out_file;

    return $result;
}

function my_all_files($dir, $check_size = FALSE, $pattern_func = '') {
    
    $result = array ( );
    
    if (mb_strlen($pattern_func) > 0) {
        $check_pattern = TRUE;
        $pattern_func = html_entity_decode($pattern_func, ENT_QUOTES, 'utf-8');
    }
    else {
        $check_pattern = FALSE;
    }
    
    $dir = my_path($dir);
    
    if (isset ($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'windows-1251', 'UTF-8');
    $f = opendir($dir);
    if (isset ($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
    $files = array ( );
    while(($filename = readdir($f)) !== FALSE) {
        if ($filename !== '.' && $filename !== '..') {
            if (isset ($_SERVER['COMSPEC'])) $filename = mb_convert_encoding($filename, 'UTF-8', 'windows-1251');
            $file = my_path($dir) . DIRECTORY_SEPARATOR . $filename;
            if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
            if (is_file($file)) {
                if ($check_size && (filesize($file) === 0)) continue;
                if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
                if ($check_pattern) {
                    if (preg_match($pattern_func, $file)) $files[$filename] = $file;
                }
                else {
                    $files[$filename] = $file;
                }
            }
        }
    }
    closedir($f);
    
    if (count($files)) $result = $files;
    
    return $result;
}

function my_remove_dir($dir, $tempdir = 'cabinet/control/tempdir') {
    
    $result = -1;
    
    $dir = my_path($dir);
    $tempdir = my_path($tempdir);
    
    if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'windows-1251', 'UTF-8');
    if (file_exists($dir) && is_dir($dir)) {
        if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
        
        $result = 0;
        
        if (my_check_tempdir($dir, $tempdir)) {
            
            $home = $dir;
            $dirs = array ( );
            $dirs[$dir] = FALSE;
            do {
                $_dirs = array_keys($dirs, FALSE, TRUE);
                if (count($_dirs)) {
                    foreach ($_dirs as $dir) {
                        $dirs[$dir] = TRUE;
                        if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'windows-1251', 'UTF-8');
                        $d = opendir($dir);
                        if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
                        while(($dirname = readdir($d)) !== FALSE) {
                            if (($dirname !== '.') && ($dirname !== '..')) {
                                if (isset($_SERVER['COMSPEC'])) $dirname = mb_convert_encoding($dirname, 'UTF-8', 'windows-1251');
                                $dir_into = my_path($dir) . DIRECTORY_SEPARATOR . $dirname;
                                if (isset($_SERVER['COMSPEC'])) $dir_into = mb_convert_encoding($dir_into, 'windows-1251', 'UTF-8');
                                if (is_dir($dir_into)) {
                                    if (isset($_SERVER['COMSPEC'])) $dir_into = mb_convert_encoding($dir_into, 'UTF-8', 'windows-1251');
                                    if (!isset($dirs[$dir_into])) $dirs[$dir_into] = FALSE;
                                }
                            }
                        }
                        closedir($d);
                    }
                }
            }
            while (count($_dirs));
            
            $remdirs = array( );
            $pattern_split = '{\\\\|/}';
            foreach ($dirs as $dir => $val) {
                $deep = preg_split($pattern_split, $dir);
                $remdirs[$dir] = count($deep);
            }
            arsort($remdirs);
            foreach ($remdirs as $dir => $val) {
                $files = my_all_files($dir);
                foreach ($files as $file) {
                    if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
                    @unlink($file);
                    if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
                }
                if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'windows-1251', 'UTF-8');
                @rmdir($dir);
                if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
            }
            
            if (isset($_SERVER['COMSPEC'])) $home = mb_convert_encoding($home, 'windows-1251', 'UTF-8');
            if (!file_exists($home)) $result = 1;
            if (isset($_SERVER['COMSPEC'])) $home = mb_convert_encoding($home, 'UTF-8', 'windows-1251');
        }
    }
    else {
        if (isset ($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
    }
    
    return $result;
}

function my_file($filename, $dir = '') {
    
    $filepath = my_path($dir);
    
    if ((mb_substr($filepath, -1) === '/') || (mb_substr($filepath, -1) === "\\")) $filepath = mb_substr($filepath, 0, -1);
    
    $file = $filepath . DIRECTORY_SEPARATOR . $filename;
    
    return $file;
}

function my_random_string($length = 15, $start = 'alpha') {
    
    $string = '';
    
    if ($length > 0) {
        
        $abc = array (
                        1   =>  'a',
                        2   =>  'b',
                        3   =>  'c',
                        4   =>  'd',
                        5   =>  'e',
                        6   =>  'f',
                        7   =>  'g',
                        8   =>  'h',
                        9   =>  'i',
                        10  =>  'j',
                        11  =>  'k',
                        12  =>  'l',
                        13  =>  'm',
                        14  =>  'n',
                        15  =>  'o',
                        16  =>  'p',
                        17  =>  'q',
                        18  =>  'r',
                        19  =>  's',
                        20  =>  't',
                        21  =>  'u',
                        22  =>  'v',
                        23  =>  'w',
                        24  =>  'x',
                        25  =>  'y',
                        26  =>  'z'
        );
        
        for ($i = 0; $i < $length; $i++) {
            
            $check = mt_rand(0, 1);
            
            if (($i === 0) && ($start === 'alpha')) $check = 1;
            
            if ($check) {
                $letter_num = mt_rand(1, 26);
                $letter = $abc[$letter_num];
                $string .= $letter;
            }
            else {
                $num = mt_rand(0, 9);
                $string .= $num;
            }
        }
    }
    
    return $string;
}

function my_random_filename($prefix, $filetype = '', $length = 15) {
    
    $filename = '';
    
    if (mb_strlen($prefix)) {
        $filename .= $prefix . my_random_string($length, $start = 'alphanumeric');
    }
    else {
        $filename .= my_random_string($length);
    }
    
    if (mb_strlen($filetype)) {
        if (mb_substr($filetype, 0, 1) !== '.') $filename .= '.';
        $filename .= $filetype;
    }
    
    return $filename;
}

function my_random_file($dir, $prefix, $filetype = '', $length = 15) {
/* возможно, целесообразно сделать проверку на две директории */
    $file = '';
    
    $check = true;
    $i = 0;
    do {
        $i++;
        $filename = my_random_filename($prefix, $filetype, $length);
        $pattern_files = "{(\\\\|/)$filename(\\.[^\\\\/]*)?$}i";
        $pattern_files = htmlentities($pattern_files, ENT_QUOTES, 'utf-8');
        $files = my_all_files($dir, FALSE, $pattern_files);
        $check_arr = array( );
        foreach ($files as $file) {
            $check_arr[ ] = file_exists($file);
        }
        if (array_search(true, $check_arr, true) === false) {
            $check = false;
            $file = my_file($filename, $dir);
        }
    }
    while (($check === true) && ($i <= 100));
    
    if ($check) $file = '';
    
    return $file;
}

/* УСТАРЕЛО
function my_file_in_array($file) {
    
    $result = array ( );
    
    if (filesize($file) > 0) {
		$f_func = fopen($file, "rt");
		$lines = explode("\n", fread($f_func, filesize($file)));
		fclose($f_func);
        
        $result = array_filter($lines, 'is_nonzero');
    }
    else {
        $result = array ('при расчете функции my_file_in_array произошла ошибка => ' . $file . ' пустой, либо его нет');
    }
    
    return $result;
}
*/

function my_file_in_line($file) {
    
    $file_in_line = '';
    
    if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
	if (filesize($file)) {
		$f_func = fopen($file, "rt");
		$lines = explode("\n", fread($f_func, filesize($file)));
        if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
		fclose($f_func);
        
        for ($i = 0; $i < count($lines); $i++) {
			if (mb_strlen($lines[$i])) {
                $str_func = trim($lines[$i]);
                if (mb_strlen($str_func)) {
                    if (mb_substr($str_func, 0, 1) !== '<') {
                        $file_in_line .= ' ' . $str_func;
                    }
                    else {
                        $file_in_line .= $str_func;
                    }
                }
            }
		}
        
        $lines = explode("\r", $file_in_line);
        
        if (count($lines) > 1) {
            
            $file_in_line = '';
            
            for ($i = 0; $i < count($lines); $i++) {
                if (mb_strlen($lines[ $i ])) {
                    $str_func = trim($lines[$i]);
                    if (mb_strlen($str_func)) {
                        if (mb_substr($str_func, 0, 1) !== '<') {
                            $file_in_line .= ' ' . $str_func;
                        }
                        else {
                            $file_in_line .= $str_func;
                        }
                    }
                }
            }
        }
	}
    else {
        if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
    }
    
    return $file_in_line;
}

function my_string_in_line($string, $delimiter = ' ') {
    
    $string_in_line = '';
    
    if (mb_strlen($string)) {
        
        $lines = explode("\n", $string);
        
        for ($i = 0; $i < count($lines); $i++) {
            if (mb_strlen($lines[$i])) {
                $str_func = trim($lines[$i]);
                if (mb_strlen($str_func)) {
                    if (mb_substr($str_func, 0, 1) !== '<') {
                        $string_in_line .= $delimiter . $str_func;
                    }
                    else {
                        $string_in_line .= $str_func;
                    }
                }
            }
        }
        
        $lines = explode("\r", $string_in_line);
        
        if (count($lines) > 1) {
            $string_in_line = '';
            for ($i = 0; $i < count($lines); $i++) {
                if (mb_strlen($lines[$i])) {
                    $str_func = trim($lines[$i]);
                    if (mb_strlen($str_func)) {
                        if (mb_substr($str_func, 0, 1) !== '<') {
                            $string_in_line .= $delimiter . $str_func;
                        }
                        else {
                            $string_in_line .= $str_func;
                        }
                    }
                }
            }
        }
    }
    
    return $string_in_line;
}

function my_string_in_line_2($string, $need_delim = true) {
    
    $string_in_line = '';
    
    if (mb_strlen($string)) {
        
        $lines = explode("\n", $string);
        
        for ($i = 0; $i < count($lines); $i++) {
            if (mb_strlen($lines[$i])) {
                $str_func = trim($lines[$i]);
                if (mb_strlen($str_func)) {
                    if ($need_delim) {
                        $string_in_line .= ' ' . $str_func;
                    }
                    else {
                        if (mb_substr($str_func, 0, 1) !== '<') {
                            $string_in_line .= ' ' . $str_func;
                        }
                        else {
                            $string_in_line .= $str_func;
                        }
                    }
                }
            }
        }
        
        $lines = explode("\r", $string_in_line);
        
        if (count($lines) > 1) {
            $string_in_line = '';
            for ($i = 0; $i < count($lines); $i++) {
                if (mb_strlen($lines[$i])) {
                    $str_func = trim($lines[$i]);
                    if (mb_strlen($str_func)) {
                        if ($need_delim) {
                            $string_in_line .= ' ' . $str_func;
                        }
                        else {
                            if (mb_substr($str_func, 0, 1) !== '<') {
                                $string_in_line .= ' ' . $str_func;
                            }
                            else {
                                $string_in_line .= $str_func;
                            }
                        }
                    }
                }
            }
        }
    }
    
    return $string_in_line;
}

/* УСТАРЕЛО
function my_array_in_file($array, $file) {
    if (count($array) > 0) {
        $f = fopen( $file, 'wt' );
        foreach ($array as $k => $v) {
            $k = trim($k);
            $v = trim($v);
            if (mb_strlen($v) > 0) {
                $str = $k . "\t" . $v . "\n";
                fwrite($f, $str);
            }
        }
        fclose($f);
    }
}
*/

function my_array_to_file($array, $file, $add_write = 'write' /* 'add' */, $key_mode = 'auto' /* 'with_keys' || 'without_keys' */, $delimiter = "\t") {
/* Режим ADD использовать с осторожностью, он дублирует записи. Лучше перезаписывать файл, работая в паре с функцией MY_FILE_TO_ARRAY */
    $result = false;
    
    $check = true;
    foreach ($array as $key => $value) {
        if ($check) {
            if ((mb_strpos($key, "\r") !== false)
             || (mb_strpos($key, "\n") !== false)
             || (mb_strpos($key, $delimiter) !== false)
             || (mb_strpos($value, "\r") !== false)
             || (mb_strpos($value, "\n") !== false)
             || (mb_strpos($value, $delimiter) !== false)) $check = false;
        }
    }
    
    if ($check) {
        
        if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
        if ($add_write === 'write') {
            $f = fopen($file, 'wt');
        }
        elseif ($add_write === 'add') {
            $f = fopen($file, 'at');
        }
        if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
        
        if (count($array) > 0) {
            $string = '';
            if ($key_mode === 'auto') {
                $pattern_numeric_key = '{^\\d+$}';
                $check_numeric_key = true;
                foreach ($array as $key => $value) {
                    if ($check_numeric_key) {
                        if (!preg_match($pattern_numeric_key, $key)) $check_numeric_key = false;
                    }
                }
                if (!$check_numeric_key) {
                    $key_mode = 'with_keys';
                }
                else {
                    $key_mode = 'without_keys';
                }
            }
            
            if ($key_mode === 'with_keys') {
                foreach ($array as $key => $value) {
                    $string .= $key . $delimiter . $value . "\n";
                }
            }
            elseif ($key_mode === 'without_keys') {
                foreach ($array as $value) {
                    $string .= $value . "\n";
                }
            }
            if (mb_strlen($string)) $result = fwrite($f, $string);
        }
        fclose($f);
    }
    
    return $result;
}

function my_get_structura_from_file_structura($dir, $filename = 'structura.txt') {
    
    $structura = array( );
    
    $file_structura = my_file($filename, $dir);
    
    if (isset($_SERVER['COMSPEC'])) $file_structura = mb_convert_encoding($file_structura, 'windows-1251', 'UTF-8');
    if (file_exists($file_structura) && @filesize($file_structura)) {
        if (isset($_SERVER['COMSPEC'])) $file_structura = mb_convert_encoding($file_structura, 'UTF-8', 'windows-1251');
        
        $lines = my_file_to_array($file_structura);
        
        $structura_array = array ( );
        foreach ($lines as $line) {
            if (mb_substr($line, 0, 2) === "-\t") {
                $elements = explode("\t", $line);
                if (count($elements) === 3) {
                    $key = $elements[1];
                    $val = $elements[2] - 1;
                    if (mb_strlen($key) && mb_strlen($val)) $structura_array[$key] = (int)$val;
                }
            }
        }
        
        if (count($structura_array)) {
            $check = TRUE;
            if (asort($structura_array)) {
                $i = 0;
                foreach ($structura_array as $val) {
                    if ($val !== $i) $check = FALSE;
                    $i++;
                }
            }
            
            if ($check) $structura = $structura_array;
        }
    }
    else {
        if (isset ($_SERVER['COMSPEC'])) $file_structura = mb_convert_encoding($file_structura, 'UTF-8', 'windows-1251');
    }
    
    return $structura;
}

function my_create_file_structura($structura_array, $dir, $filename = 'structura.txt') {
    
    $result = array ( );
    
    $dir = my_make_dirs($dir);
    
    if (mb_strlen($dir) && is_array($structura_array)) {
        if (count($structura_array)) {
            $file_structura = my_file($filename, $dir);
            
            $string = '';
            foreach ($structura_array as $key => $val) $string .= '-' . "\t" . $key . "\t" . $val . "\n";
            
            if (isset ($_SERVER['COMSPEC'])) $file_structura = mb_convert_encoding($file_structura, 'windows-1251', 'UTF-8');
            $f = fopen($file_structura, 'wt');
            if (isset ($_SERVER['COMSPEC'])) $file_structura = mb_convert_encoding($file_structura, 'UTF-8', 'windows-1251');
            
            $check = fwrite($f, $string);
            
            fclose($f);
            
            if ($check) $result = my_get_structura_from_file_structura($dir, $filename);
        }
    }
    
    return $result;
}

function my_check_data_structura($data, $dir, $filename = 'structura.txt') {
    
    $result = FALSE;
    
    if (is_array($data)) {
        if (count($data)) {
            $check = TRUE;
            foreach ($data as $val) {
                if (!is_array($val)) $check = FALSE;
            }
            
            if ($check) {
                $structura = my_get_structura_from_file_structura($dir, $filename);
            }
            else {
                $structura = array ( );
            }
            
            if (count($structura)) {
                foreach ($data as $point) {
                    foreach ($point as $key => $val) {
                        if (!isset ($structura[$key])) $check = FALSE;
                    }
                }
            }
            
            $result = $check;
        }
    }
    
    return $result;
}

function my_write_file_structura($data, $num_row, $write_rewrite, $dir = '', $filename = 'structura.txt') {
    
    $result = FALSE;
    
    if (my_check_data_structura($data, $dir, $filename)) {
        
        sort($data);
        
        $file_structura = my_file($filename, $dir);
        
        $structura = my_get_structura_from_file_structura($dir, $filename);
        
        $lines = my_file_to_array($file_structura, FALSE);
        
        $string = '';
        for ($i = 0; $i < (count($structura) + $num_row - 1); $i++) $string .= $lines[$i] . "\n";
        
        if (($write_rewrite === 'rewrite') && (count($data) === 1)) {
            foreach ($structura as $key => $val) {
                if (isset($data[0][$key])) {
                    if (mb_strpos($data[0][$key], "\t") !== FALSE) $data[0][$key] = str_replace("\t", ' ', $data[0][$key]);
                    $string .= $data[0][$key] . "\t";
                }
                else {
                    $string .= "\t";
                }
            }
            
            if (mb_substr($string, -1) === "\t") $string = mb_substr($string, 0, -1);
            $string .= "\n";
            
            for ($i = (count($structura) + $num_row); $i < count($lines); $i++) $string .= $lines[$i] . "\n";
        }
        elseif ($write_rewrite === 'write') {
            $i = count($structura) + $num_row - 1;
            $string .= $lines[$i] . "\n";
            
            foreach ($data as $point) {
                foreach ($structura as $key => $val) {
                    if (isset($point[$key])) {
                        if (mb_strpos($point[$key], "\t") !== FALSE) $point[$key] = str_replace("\t", ' ', $point[$key]);
                        $string .= $point[$key] . "\t";
                    }
                    else {
                        $string .= "\t";
                    }
                }
                
                if (mb_substr($string, -1) === "\t") $string = mb_substr($string, 0, -1);
                $string .= "\n";
            }
            
            for ($i = (count($structura) + $num_row); $i < count($lines); $i++) {
                $string .= $lines[$i] . "\n";
            }
        }
        
        if (isset($_SERVER['COMSPEC'])) $file_structura = mb_convert_encoding($file_structura, 'windows-1251', 'UTF-8');
        $f = fopen($file_structura, 'wt');
        if (isset($_SERVER['COMSPEC'])) $file_structura = mb_convert_encoding($file_structura, 'UTF-8', 'windows-1251');
        if (fwrite($f, $string)) $result = TRUE;
        fclose($f);
    }
    
    return $result;
}

function my_read_row_file_structura($num_row, $dir = '', $filename = 'structura.txt') {
    
    $result = array ( );
    
    $structura = my_get_structura_from_file_structura($dir, $filename);
    
    if (count($structura)) {
        
        $file_structura = my_file($filename, $dir);
        $lines = my_file_to_array($file_structura, FALSE);
        
        $num_row = count($structura) + $num_row - 1;
        $row = explode("\t", $lines[$num_row]);
    }
    
    if (count($row) === count($structura)) {
        $i = 0;
        foreach ($structura as $key => $val) {
            if ($i === $val) $result[$key] = $row[$i];
            $i++;
        }
    }
    
    return $result;
}

function my_read_col_file_structura($name_of_col, $dir = '', $filename = 'structura.txt', $no_empty = false) {
    
    $result = array ( );
    
    $structura = my_get_structura_from_file_structura($dir, $filename);
    
    if (count($structura)) {
        
        $file_structura = my_file($filename, $dir);
        $lines = my_file_to_array($file_structura, FALSE);
        
        if (isset($structura[$name_of_col])) {
            foreach ($lines as $line) {
                if (mb_substr($line, 0, 2) !== "-\t") {
                    $elements = explode("\t", $line);
                    if (isset($elements[$structura[$name_of_col]])) $result[ ] = $elements[$structura[$name_of_col]];
                }
            }
        }
    }
    
    if ((count($structura) + count($result)) !== count($lines)) $result = array ( );
    
    if ($no_empty) $result = array_filter($result, 'is_nonzero_hard');
    
    return $result;
}

function my_read_row_where_file_structura($where, $dir = '', $filename = 'structura.txt') {
    
    $result = array ( );
    
    if (is_array($where) && (count($where) === 1)) {
        
        $where_key = array_flip($where);
        $name_of_col = array_shift($where_key);
        
        $val = array_shift($where);
        $val = (string)$val;
        
        $col = my_read_col_file_structura($name_of_col, $dir, $filename);
        
        $check_where = array_keys($col, $val, TRUE);
        
        if (count($check_where) === 1) {
            
            $structura = my_get_structura_from_file_structura($dir, $filename);
            
            if (count($structura)) {
                
                $file_structura = my_file($filename, $dir);
                $lines = my_file_to_array($file_structura, FALSE);
                
                if (isset($structura[$name_of_col])) {
                    foreach ($lines as $line) {
                        if (mb_substr($line, 0, 2) !== "-\t") {
                            $elements = explode("\t", $line);
                            if ($elements[$structura[$name_of_col]] === $val) {
                                if (count($elements) === count($structura)) {
                                    $i = 0;
                                    foreach ($structura as $key => $value) {
                                        if ($i === $value) $result[$key] = $elements[$i];
                                        $i++;
                                    }
                                }
                            }
                        }
                    }
                }
                
                if (count($result) !== count($structura)) {
                    $result = array( );
                }
            }
        }
    }
    
    return $result;
}

function my_read_cell_where_file_structura($where, $name_of_col, $dir = '', $filename = 'structura.txt') {
    
    $result = '';
    
    $structura = my_get_structura_from_file_structura($dir, $filename);
    
    if (count($structura)) {
        $row = my_read_row_where_file_structura($where, $dir, $filename);
        
        if ((count($row) === count($structura)) && isset($structura[$name_of_col])) $result = $row[$name_of_col];
    }
    
    return $result;
}

function my_delete_files($filename, $dir = "cabinet/control/tempdir", $extension = FALSE) {
    
    $result = FALSE;
    $check = array( );
    
    if (mb_strlen($filename)) {
        
        if ((mb_substr($filename, 0, 1) === "/") || (mb_substr($filename, 0, 1) === "\\")) $filename = mb_substr($filename, 1);
        
        if ((mb_strpos($filename, "/") === FALSE) && (mb_strpos($filename, "\\") === FALSE)) {
            if (my_check_tempdir($dir)) {
                if (($extension === FALSE) && (mb_strpos($filename, '.') !== FALSE)) {
                    $pattern_extension = '{\\.?[^\\.]*$}i';
                    $replace = '';
                    $filename = preg_replace($pattern_extension, $replace, $filename);
                }
                
                if (mb_strlen($filename)) {
                    $pattern_files = "{(\\\\|/)$filename((\\.[^\\\\/\\.]+)|$)}i";
                    $pattern_files = htmlentities($pattern_files, ENT_QUOTES, 'utf-8');
                    $files = my_all_files($dir, FALSE, $pattern_files);
                    foreach ($files as $file) {
                        if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
                        $check[ ] = @unlink($file);
                        if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');                        
                    }
                }
            }
        }
    }
    
    if (count($check)) {
        $result = TRUE;
        foreach ($check as $ch) {
            if ($result) {
                $result = $ch;
            }
        }
    }
    
    return $result;
}
