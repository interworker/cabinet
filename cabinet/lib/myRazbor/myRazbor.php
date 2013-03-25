<?php
/* УСТАРЕЛО
function my_normalize_url_all($url, $base_url, $substring = '', $url_parent = '' , $no_img = FALSE) {
    
    $result = '';
    
    $url = trim($url);
    $base_url = trim($base_url);
    $substring = trim($substring);
    $url_parent = trim($url_parent);
    
    $domen = '';
    $pattern_host = '{([^/]+)/?$}';
    if (preg_match($pattern_host, $base_url, $match)) {
        $domen = $match[1];
        $pattern_domen = '{^.+?\\.([^\\.]+\\.[^\\.]+)$}';
        $replace_domen = '$1';
        if (preg_match($pattern_domen, $domen)) $domen = preg_replace($pattern_domen, $replace_domen, $domen);
    }
    
    if (mb_strlen($domen)) {
*/
#       $pattern_base_url = "{^[^/]*//[^/]*?$domen}i";
/*
        $pattern_email = "{([\w-\.]+)@((?:[\w]+\.)+)([a-zA-Z]{2,4})}";
        
        if ($url === '/') {
            echo '$url === /', PHP_EOL, '<BR>', PHP_EOL;
            $result = $base_url;
        }
        elseif ($url === '#') {
            echo '$url === #', PHP_EOL, '<BR>', PHP_EOL;
            if (mb_strlen($url_parent)) {
                $result = $url_parent;
            }
            else {
                $result = '';
            }
        }
        elseif ((mb_substr($url, 0, 13) === 'javascript://') || (mb_substr($url, 0, 7) === 'mailto:') || preg_match($pattern_email, $url)) {
            echo '$url === mailto:', PHP_EOL, '<BR>', PHP_EOL;
            $result = '';
        }
        elseif (mb_strpos($url, '?') !== FALSE) {
            $result = '';
        }
        elseif (preg_match($pattern_base_url, $url)) {
            echo '$url - вариант 1', PHP_EOL, '<BR>', PHP_EOL;
            $result = $url;
        }
        elseif ((mb_strlen($url) > 1) && (mb_substr($url, 0, 1) === '/') && (mb_substr($url, 1, 2) !== '/')) {
            echo '$url = $base_url . $url', PHP_EOL, '<BR>', PHP_EOL;
            $result = $base_url;
            if (mb_substr($result, -1) === '/') $result = mb_substr($result, 0, -1);
            $result .= $url;
        }
        elseif (mb_substr($url, 0, 3) === '../') {
            echo '$url = $url_parent . $url - вариант 1', PHP_EOL, '<BR>', PHP_EOL;
            if (mb_strlen($url_parent)) {
                $url = mb_substr($url, 2);
                $pattern_rel_folder = '{^(.+?)/[^/]+/[^/]*$}';
                $replace_rel_folder = '$1';
                if (preg_match($pattern_rel_folder, $url_parent)) {
                    $result = preg_replace($pattern_rel_folder, $replace_rel_folder, $url_parent);
                    if (mb_stripos($result, $base_url) === false) {
                        $result = $base_url;
                        if (mb_substr($result, -1) === '/') $result = mb_substr($result, 0, -1);
                    }
                    $result .= $url;
                }
            }
            else {
                $result = '';
            }
        }
        elseif ((mb_strlen($url) > 0) && (mb_substr($url, 0, 1) !== '/') && (mb_strpos($url, ':') === FALSE)) {
            echo '$url = $url_parent . $url - вариант 2', PHP_EOL, '<BR>', PHP_EOL;
            if (mb_strlen($url_parent)) {
                echo '$url_parent = ', $url_parent, PHP_EOL, '<BR>', PHP_EOL;
                $pattern_rel_folder = '{^(.+?/)[^/]*$}';
                $replace_rel_folder = '$1';
                if (preg_match($pattern_rel_folder, $url_parent)) {
                    $result = preg_replace($pattern_rel_folder, $replace_rel_folder, $url_parent);
                    if (mb_stripos($result, $base_url) === false) {
                        $result = $base_url;
                        if (mb_substr($result, -1) !== '/') $result .= '/';
                    }
                    $result .= $url;
                }
            }
            else {
                $result = '';
            }
        }
        else {
            echo '$url - вариант 2', PHP_EOL, '<BR>', PHP_EOL;
            $result = $url;
        }
        
        echo 'до $result = ', $result, PHP_EOL, '<BR>', PHP_EOL;
        if (mb_strlen($substring)) {
            if (mb_stripos($result, $substring) === FALSE) $result = '';
        }
        echo 'после $result = ', $result, PHP_EOL, '<BR>', PHP_EOL;
        
        if ($no_img && mb_strlen($result)) {
            $pattern_image = '{\\.(jpg|gif|png)$}i';
            if (preg_match($pattern_image, $result)) $result = '';
        }
    }
    
    return $result;
}
*/

function my_normalize_url_all_2($url, $parent_url, $base_url, $no_other = true) {
    
    $result = '';
    
    $url = trim($url);
    $parent_url = trim($parent_url);
    $base_url = trim($base_url);
    
    if ((mb_strpos($parent_url, '://') !== false) && (mb_strpos($base_url, '://') !== false)
     && (mb_strlen($url) && (preg_match('{\s}', $url) === 0))
     && (mb_strlen($parent_url) && (preg_match('{\s}', $parent_url) === 0))
     && (mb_strlen($base_url) && (preg_match('{\s}', $base_url) === 0))) {
        
        $domen = '';
        $pattern_host = '{([^/]+)/?$}';
        if (preg_match($pattern_host, $base_url, $match)) {
            $domen = $match[1];
            $pattern_domen = '{^.+?\\.([^\\.]+\\.[^\\.]+)$}';
            $replace_domen = '$1';
            if (preg_match($pattern_domen, $domen)) $domen = preg_replace($pattern_domen, $replace_domen, $domen);
        }
        
        if (mb_strlen($domen)) {
            
            $pattern_base_url = "{^[^/]*//[^/]*?$domen}i";
            $pattern_email = "{([\w-\.]+)@((?:[\w]+\.)+)([a-zA-Z]{2,4})}";
            
            if ((mb_substr($url, -1) === '?') || (mb_substr($url, -1) === '#')) $url = mb_substr($url, 0, -1);
            
            if (mb_strlen($url) === 0) {
                $result = $parent_url;
            }
            elseif ($url === '/') {
                $result = $base_url;
            }
            elseif ((mb_substr($url, 0, 7) === 'mailto:') || preg_match($pattern_email, $url)) {
                $result = '';
            }
            elseif (preg_match($pattern_base_url, $url)) {
                $result = $url;
            }
            elseif ((mb_strlen($url) > 1) && (mb_substr($url, 0, 1) === '/') && (mb_substr($url, 0, 2) !== '//')) {
                $result = $base_url;
                if (mb_substr($result, -1) === '/') $result = mb_substr($result, 0, -1);
                $result .= $url;
            }
            elseif (mb_substr($url, 0, 3) === '../') {
                $url = mb_substr($url, 2);
                $pattern_rel_folder = '{^(.+?)/[^/]+/[^/]*$}';
                $replace_rel_folder = '$1';
                if (preg_match($pattern_rel_folder, $parent_url)) {
                    $result = preg_replace($pattern_rel_folder, $replace_rel_folder, $parent_url);
                    if (mb_stripos($result, $base_url) === false) {
                        $result = $base_url;
                        if (mb_substr($result, -1) === '/') $result = mb_substr($result, 0, -1);
                    }
                    $result .= $url;
                }
            }
            elseif ((mb_strlen($url) > 0) && (mb_substr($url, 0, 1) !== '/') && (mb_strpos($url, ':') === FALSE)) {
                $pattern_rel_folder = '{^(.+?/)[^/]*$}';
                $replace_rel_folder = '$1';
                if (preg_match($pattern_rel_folder, $parent_url)) {
                    $result = preg_replace($pattern_rel_folder, $replace_rel_folder, $parent_url);
                    if (mb_stripos($result, $base_url) === false) {
                        $result = $base_url;
                        if (mb_substr($result, -1) !== '/') $result .= '/';
                    }
                    $result .= $url;
                }
            }
            else {
                $result = $url;
            }
            
            if ($no_other && (mb_strpos($result, '//') !== false)) {
                if (mb_stripos($result, $base_url) === FALSE) $result = '';
            }
        }
    }
    
    return $result;
}

/* УСТАРЕЛО
function my_cleaned_text($text) {
    
    $string_in_line = '';
    
    $arr_util = explode("\n", $text);
    
    for ($i = 0; $i < count($arr_util); $i++) {
		if (mb_strlen($arr_util[$i]) > 0) {
            $str_func = trim($arr_util[$i]);
            if (mb_strlen($str_func) > 0) {
                $string_in_line .= ' ' . $str_func;
            }
        }
    }
        
    $arr_util = explode("\r", $string_in_line);
    
    if (count($arr_util) > 1) {
        $string_in_line = '';
        for ($i = 0; $i < count($arr_util); $i++) {
            if (mb_strlen($arr_util[$i]) > 0) {
                $str_func = trim($arr_util[$i]);
                if (mb_strlen($str_func) > 0) {
                    $string_in_line .= ' ' . $str_func;
                }
            }
        }
    }
    
    $text = $string_in_line;
    
    if (mb_strpos($text, '&nbsp;') !== FALSE) $text = str_replace('&nbsp;', ' ', $text);
    if (mb_strpos($text, "\t") !== FALSE) $text = str_replace("\t", ' ', $text);
    while (mb_strpos($text, '  ') !== FALSE) $text = str_replace('  ', ' ', $text);
    
    $text = trim($text);
    
    return $text;
}
*/

function my_info_array($file, $delimiter = "\t", $put_files = TRUE) {
    
    $info_array = array ( );
    
    $pattern_file = '{^(.+?)\\.[^\\.]+$}i';
    preg_match($pattern_file, $file, $match);
    $file_info = $match[1] . '.info';
    
    if (isset ($_SERVER['COMSPEC'])) $file_info = mb_convert_encoding($file_info, 'windows-1251', 'UTF-8');
    if (is_file($file_info) && filesize($file_info)) {
        if (isset ($_SERVER['COMSPEC'])) $file_info = mb_convert_encoding($file_info, 'UTF-8', 'windows-1251');
        $lines = my_file_to_array($file_info);
        for ($i = 0; $i < count($lines); $i++) {
            if (mb_strlen($lines[$i]) > 0) {
                $elements = explode($delimiter, $lines[$i]);
                if (count($elements) === 2) $info_array[$elements[0]] = $elements[1];
            }
        }
        if ($put_files) $info_array['file_info'] = $file_info;
    }
    
    return $info_array;
}

function my_urls_array_diff($array_urls_in_keys, $array_urls_in_val) {
    
    $result = array( );
    
    if (count($array_urls_in_keys) && count($array_urls_in_val)) {
        foreach ($array_urls_in_keys as $key => $val) {
            $cut_key = $key;
            if (mb_substr($cut_key, -1) === '/') $cut_key = mb_substr($cut_key, 0, -1);
            if ((array_search($key, $array_urls_in_val) !== false) || (array_search($cut_key, $array_urls_in_val) !== false)) unset($array_urls_in_keys[$key]);
        }
    }
    
    $result = $array_urls_in_keys;
    
    return $result;
}