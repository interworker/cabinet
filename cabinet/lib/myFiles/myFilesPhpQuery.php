<?php

function my_string_in_file($string, $file) {
    
    $result = FALSE;
    
    if (isset($document)) unset($document);
    
    $document = phpQuery::newDocument($string);
    $lines = my_string_to_array($document);
    unset($document);
    
    $string = '';
    for ($i = 0; $i < count($lines); $i++) {
        $string .= $lines[$i];
        if ($i < (count($lines) - 2)) $string .= PHP_EOL;
    }
    
    if (mb_strlen($string)) {
        if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
        $f = fopen($file, 'wt');
        if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
        if (fwrite($f, $string)) $result = TRUE;
        fclose($f);
    }
    
    return $result;
}

/* УСТАРЕЛО */
function my_file_in_utf8_4phpquery($file_in, $charset, $file_out = '') {
    
    $result = FALSE;
    
    if (mb_strlen($file_out) === 0) {
        $file_out = $file_in;
    }
    
    $page_str = my_file_in_line($file_in);
    
    if (mb_strtolower($charset) !== 'utf-8') $page_str = mb_convert_encoding($page_str, 'utf-8', $charset);
    
    $pattern1 = '{<!DOCTYPE[^>]+>}i';
    $replace1 = '';
    $pattern2 = '{^.*?(<html[\\s>])}i';
    $replace2 = '$1';
    $pattern3 = '{<html[^>]*?>}i';
    $replace3 = '<html>';
    $pattern4 = '{<meta[^>]*?http-equiv\\s*=\\s*["\']?content-type["\']?[^>]*>}i';
    $replace4 = '';
    $pattern5 = '{<meta[^>]*?charset\\s*=\\s*[^>]+>}i';
    $replace5 = '';
    $pattern6 = '{<script[^>]*>.*?</script>}i';
    $replace6 = '';
    $pattern7 = '{<link[^>]+?type\\s*=\\s*["\']?text/css["\']?[^>]*>}i';
    $replace7 = '';
    $pattern8 = '{<link[^>]+?rel\\s*=\\s*["\']?stylesheet["\']?[^>]*>}i';
    $replace8 = '';
    $pattern9 = '{<style[^>]*>.*?</style>}i';
    $replace9 = '';
    $pattern10 = '{<!--.*?-->}i';
    $replace10 = '';
    $pattern11 = '{<noscript>.*?</noscript>}i';
    $replace11 = '';
    
    if (preg_match($pattern1, $page_str)) $page_str = preg_replace($pattern1, $replace1, $page_str);
    if (preg_match($pattern2, $page_str)) $page_str = preg_replace($pattern2, $replace2, $page_str);
    if (preg_match($pattern3, $page_str)) $page_str = preg_replace($pattern3, $replace3, $page_str);
    if (preg_match($pattern4, $page_str)) $page_str = preg_replace($pattern4, $replace4, $page_str);
    if (preg_match($pattern5, $page_str)) $page_str = preg_replace($pattern5, $replace5, $page_str);
    if (preg_match($pattern6, $page_str)) $page_str = preg_replace($pattern6, $replace6, $page_str);
    if (preg_match($pattern7, $page_str)) $page_str = preg_replace($pattern7, $replace7, $page_str);
    if (preg_match($pattern8, $page_str)) $page_str = preg_replace($pattern8, $replace8, $page_str);
    if (preg_match($pattern9, $page_str)) $page_str = preg_replace($pattern9, $replace9, $page_str);
    if (preg_match($pattern10, $page_str)) $page_str = preg_replace($pattern10, $replace10, $page_str);
    if (preg_match($pattern11, $page_str)) $page_str = preg_replace($pattern11, $replace11, $page_str);
    
    if (my_string_in_file($page_str, $file_out)) {
        $result = TRUE;
        $pattern_file = '{^(.+?)\\.[^\\.]+$}i';
        $file_info_in = '';
        $file_info_out = '';
        if (preg_match($pattern_file, $file_in, $match)) $file_info_in = $match[1] . '.info';
        if (preg_match($pattern_file, $file_out, $match)) $file_info_out = $match[1] . '.info';
        
        if (mb_strlen($file_info_in) && mb_strlen($file_info_out) && ($file_info_out !== $file_info_in)) {
            if (isset ($_SERVER['COMSPEC'])) {
                $file_info_in = mb_convert_encoding($file_info_in, 'windows-1251', 'UTF-8');
                $file_info_out = mb_convert_encoding($file_info_out, 'windows-1251', 'UTF-8');
            }
            if (file_exists($file_info_in)) copy($file_info_in, $file_info_out);
            if (isset ($_SERVER['COMSPEC'])) {
                $file_info_in = mb_convert_encoding($file_info_in, 'UTF-8', 'windows-1251');
                $file_info_out = mb_convert_encoding($file_info_out, 'UTF-8', 'windows-1251');
            }
        }
        
        if (mb_strtolower($charset) !== 'utf-8') {
            if (isset ($_SERVER['COMSPEC'])) $file_info_out = mb_convert_encoding($file_info_out, 'windows-1251', 'UTF-8');
            $f_func = fopen($file_info_out, 'a+t');
            if (isset ($_SERVER['COMSPEC'])) $file_info_out = mb_convert_encoding($file_info_out, 'UTF-8', 'windows-1251');
            $str = 'encoding' . "\t" . 'utf-8' . "\n";
            fwrite($f_func, $str);
            fclose($f_func);
        }
    }
    
    return $result;
}

/* УСТАРЕЛО */
function my_file_in_utf8_4phpquery_2($file_in, $charset, $file_out = '') {
    
    $result = FALSE;
    
    if (mb_strlen($file_out) === 0) {
        $file_out = $file_in;
    }
    
    $page_str = my_file_in_line($file_in);
    
    if (mb_strtolower($charset) !== 'utf-8') $page_str = mb_convert_encoding($page_str, 'utf-8', $charset);
    
    $pattern1 = '{<!DOCTYPE[^>]+>}i';
    $replace1 = '';
    $pattern2 = '{^.*?(<html[\\s>])}i';
    $replace2 = '$1';
    $pattern3 = '{<html[^>]*?>}i';
    $replace3 = '<html>';
    $pattern4 = '{<meta[^>]*?http-equiv\\s*=\\s*["\']?content-type["\']?[^>]*>}i';
    $replace4 = '';
    $pattern5 = '{<meta[^>]*?charset\\s*=\\s*[^>]+>}i';
    $replace5 = '';
    $pattern6 = '{<script[^>]*>.*?</script>}i';
    $replace6 = '';
    $pattern7 = '{<link[^>]+?type\\s*=\\s*["\']?text/css["\']?[^>]*>}i';
    $replace7 = '';
    $pattern8 = '{<link[^>]+?rel\\s*=\\s*["\']?stylesheet["\']?[^>]*>}i';
    $replace8 = '';
    $pattern9 = '{<style[^>]*>.*?</style>}i';
    $replace9 = '';
    $pattern10 = '{<!--.*?-->}i';
    $replace10 = '';
    $pattern11 = '{<noscript>.*?</noscript>}i';
    $replace11 = '';
    
    if (preg_match($pattern1, $page_str))  $page_str = preg_replace($pattern1, $replace1, $page_str);
    if (preg_match($pattern2, $page_str))  $page_str = preg_replace($pattern2, $replace2, $page_str);
    if (preg_match($pattern3, $page_str))  $page_str = preg_replace($pattern3, $replace3, $page_str);
    if (preg_match($pattern4, $page_str))  $page_str = preg_replace($pattern4, $replace4, $page_str);
    if (preg_match($pattern5, $page_str))  $page_str = preg_replace($pattern5, $replace5, $page_str);
    if (preg_match($pattern6, $page_str))  $page_str = preg_replace($pattern6, $replace6, $page_str);
    if (preg_match($pattern7, $page_str))  $page_str = preg_replace($pattern7, $replace7, $page_str);
    if (preg_match($pattern8, $page_str))  $page_str = preg_replace($pattern8, $replace8, $page_str);
    if (preg_match($pattern9, $page_str))  $page_str = preg_replace($pattern9, $replace9, $page_str);
    if (preg_match($pattern10, $page_str)) $page_str = preg_replace($pattern10, $replace10, $page_str);
    if (preg_match($pattern11, $page_str)) $page_str = preg_replace($pattern11, $replace11, $page_str);
    
    if (my_string_in_file($page_str, $file_out)) {
        $result = TRUE;
        
        $file_info_in = $file_in . '.info';
        $file_info_out = $file_out . '.info';
        
        if ($file_info_out !== $file_info_in) {
            if (isset($_SERVER['COMSPEC'])) {
                $file_info_in = mb_convert_encoding($file_info_in, 'windows-1251', 'UTF-8');
                $file_info_out = mb_convert_encoding($file_info_out, 'windows-1251', 'UTF-8');
            }
            if (file_exists($file_info_in)) copy($file_info_in, $file_info_out);
            if (isset($_SERVER['COMSPEC'])) {
                $file_info_in = mb_convert_encoding($file_info_in, 'UTF-8', 'windows-1251');
                $file_info_out = mb_convert_encoding($file_info_out, 'UTF-8', 'windows-1251');
            }
        }
        
        if (mb_strtolower($charset) !== 'utf-8') {
            if (isset($_SERVER['COMSPEC'])) $file_info_out = mb_convert_encoding($file_info_out, 'windows-1251', 'UTF-8');
            $f = fopen($file_info_out, 'at');
            if (isset ($_SERVER['COMSPEC'])) $file_info_out = mb_convert_encoding($file_info_out, 'UTF-8', 'windows-1251');
            $str = 'encoding' . "\t" . 'utf-8' . "\n";
            fwrite($f, $str);
            fclose($f);
        }
    }
    
    return $result;
}

/* УСТАРЕЛО */
function my_file_in_utf8_4phpquery_soft($file_in, $charset, $file_out = '') {
    
    $result = FALSE;
    
    if (mb_strlen($file_out) === 0) {
        $file_out = $file_in;
    }
    
    $page_str = my_file_in_line($file_in);
    
    if (mb_strtolower($charset) !== 'utf-8') $page_str = mb_convert_encoding($page_str, 'utf-8', $charset);
    
    $pattern1 = '{<!DOCTYPE[^>]+>}i';
    $replace1 = '';
    $pattern2 = '{^.*?(<html[\\s>])}i';
    $replace2 = '$1';
    $pattern3 = '{<html[^>]*?>}i';
    $replace3 = '<html>';
    $pattern4 = '{<meta[^>]*?http-equiv\\s*=\\s*["\']?content-type["\']?[^>]*>}i';
    $replace4 = '';
    $pattern5 = '{<meta[^>]*?charset\\s*=\\s*[^>]+>}i';
    $replace5 = '';
    $pattern6 = '{<!--.*?-->}i';
    $replace6 = '';
    
    if (preg_match($pattern1, $page_str)) $page_str = preg_replace($pattern1, $replace1, $page_str);
    if (preg_match($pattern2, $page_str)) $page_str = preg_replace($pattern2, $replace2, $page_str);
    if (preg_match($pattern3, $page_str)) $page_str = preg_replace($pattern3, $replace3, $page_str);
    if (preg_match($pattern4, $page_str)) $page_str = preg_replace($pattern4, $replace4, $page_str);
    if (preg_match($pattern5, $page_str)) $page_str = preg_replace($pattern5, $replace5, $page_str);
    if (preg_match($pattern6, $page_str)) $page_str = preg_replace($pattern6, $replace6, $page_str);
    
    if (my_string_in_file($page_str, $file_out)) {
        $result = TRUE;
        $pattern_file = '{^(.+?)\\.[^\\.]+$}i';
        $file_info_in = '';
        $file_info_out = '';
        if (preg_match($pattern_file, $file_in, $match)) $file_info_in = $match[1] . '.info';
        if (preg_match($pattern_file, $file_out, $match)) $file_info_out = $match[1] . '.info';
        
        if (mb_strlen($file_info_in) && mb_strlen($file_info_out) && ($file_info_out !== $file_info_in)) {
            if (isset ($_SERVER['COMSPEC'])) {
                $file_info_in = mb_convert_encoding($file_info_in, 'windows-1251', 'UTF-8');
                $file_info_out = mb_convert_encoding($file_info_out, 'windows-1251', 'UTF-8');
            }
            if (file_exists($file_info_in)) copy($file_info_in, $file_info_out);
            if (isset ($_SERVER['COMSPEC'])) {
                $file_info_in = mb_convert_encoding($file_info_in, 'UTF-8', 'windows-1251');
                $file_info_out = mb_convert_encoding($file_info_out, 'UTF-8', 'windows-1251');
            }
        }
        
        if (mb_strtolower($charset) !== 'utf-8') {
            if (isset ($_SERVER['COMSPEC'])) $file_info_out = mb_convert_encoding($file_info_out, 'windows-1251', 'UTF-8');
            $f_func = fopen($file_info_out, 'a+t');
            if (isset ($_SERVER['COMSPEC'])) $file_info_out = mb_convert_encoding($file_info_out, 'UTF-8', 'windows-1251');
            $str = 'encoding' . "\t" . 'UTF-8' . "\n";
            fwrite($f_func, $str);
            fclose($f_func);
        }
    }
    
    return $result;
}

function my_file_in_utf8_4phpquery_soft_2($file_in, $file_info_in, $file_out = '', $file_info_out = '') {
    
    $result = FALSE;
    
    if (isset($_SERVER['COMSPEC'])) $file_in = mb_convert_encoding($file_in, 'windows-1251', 'UTF-8');
    if (isset($_SERVER['COMSPEC'])) $file_info_in = mb_convert_encoding($file_info_in, 'windows-1251', 'UTF-8');
    if (@filesize($file_in) && @filesize($file_info_in)) {
        if (isset($_SERVER['COMSPEC'])) $file_in = mb_convert_encoding($file_in, 'UTF-8', 'windows-1251');
        if (isset($_SERVER['COMSPEC'])) $file_info_in = mb_convert_encoding($file_info_in, 'UTF-8', 'windows-1251');
        
        if (mb_strlen($file_out) === 0) {
            $file_out = $file_in;
            $file_info_out = $file_info_in;
        }
        else {
            if (mb_strlen($file_info_out) === 0) $file_info_out = $file_out . '.info';
        }
        
        $info = my_info_array($file_info_in);
        
        $charset = my_get_charset_from_info($info);
        
        $string = my_file_in_line_2($file_in, false);
        
        if (mb_strlen($charset) && (mb_strtoupper($charset) !== 'UTF-8')) $string = mb_convert_encoding($string, 'UTF-8', $charset);
        
        $pattern1 = '{<!DOCTYPE[^>]+>}i';
        $replace1 = '';
        $pattern2 = '{^.*?(<html[\\s>])}i';
        $replace2 = '$1';
        $pattern3 = '{<html[^>]*?>}i';
        $replace3 = '<html>';
        $pattern4 = '{<meta[^>]*?http-equiv\\s*=\\s*["\']?content-type["\']?[^>]*>}i';
        $replace4 = '';
        $pattern5 = '{<meta[^>]*?charset\\s*=\\s*[^>]+>}i';
        $replace5 = '';
        $pattern6 = '{<!--.*?-->}i';
        $replace6 = '';
        
        if (preg_match($pattern1, $string)) $string = preg_replace($pattern1, $replace1, $string);
        if (preg_match($pattern2, $string)) $string = preg_replace($pattern2, $replace2, $string);
        if (preg_match($pattern3, $string)) $string = preg_replace($pattern3, $replace3, $string);
        if (preg_match($pattern4, $string)) $string = preg_replace($pattern4, $replace4, $string);
        if (preg_match($pattern5, $string)) $string = preg_replace($pattern5, $replace5, $string);
        if (preg_match($pattern6, $string)) $string = preg_replace($pattern6, $replace6, $string);
        
        if (my_string_in_file($string, $file_out)) {
            
            $result = TRUE;
            
            if ($file_info_out !== $file_info_in) {
                if (isset($_SERVER['COMSPEC'])) $file_info_in = mb_convert_encoding($file_info_in, 'windows-1251', 'UTF-8');
                if (isset($_SERVER['COMSPEC'])) $file_info_out = mb_convert_encoding($file_info_out, 'windows-1251', 'UTF-8');
                copy($file_info_in, $file_info_out);
                if (isset($_SERVER['COMSPEC'])) $file_info_in = mb_convert_encoding($file_info_in, 'UTF-8', 'windows-1251');
                if (isset($_SERVER['COMSPEC'])) $file_info_out = mb_convert_encoding($file_info_out, 'UTF-8', 'windows-1251');
            }
            
            $info_add = array( );
            if (mb_strlen($charset)) {
                if (mb_strtoupper($charset) !== 'UTF-8') $info_add['encoding'] = 'UTF-8';
            }
            else {
                $info_add['error'] = 'не определена кодировка файла';
            }
            if (count($info_add)) my_info_to_file_info($info_add, $file_info_out, 'add');
        }
    }
    else {
        if (isset($_SERVER['COMSPEC'])) $file_in = mb_convert_encoding($file_in, 'UTF-8', 'windows-1251');
        if (isset($_SERVER['COMSPEC'])) $file_info_in = mb_convert_encoding($file_info_in, 'UTF-8', 'windows-1251');
    }
    
    return $result;
}

/* УСТАРЕЛО */
function my_string_in_utf8_4phpquery($string, $charset) {
    
    $page_str = my_string_in_line($string);
    
    if (mb_strtoupper($charset) !== 'UTF-8') $page_str = mb_convert_encoding($page_str, 'UTF-8', $charset);
    
    $pattern1 = '{<!DOCTYPE[^>]+>}i';
    $replace1 = '';
    $pattern2 = '{^.*?(<html[\\s>])}i';
    $replace2 = '$1';
    $pattern3 = '{<html[^>]*?>}i';
    $replace3 = '<html>';
    $pattern4 = '{<meta[^>]*?http-equiv\\s*=\\s*["\']?content-type["\']?[^>]*>}i';
    $replace4 = '';
    $pattern5 = '{<meta[^>]*?charset\\s*=\\s*[^>]+>}i';
    $replace5 = '';
    $pattern6 = '{<script[^>]*>.*?</script>}i';
    $replace6 = '';
    $pattern7 = '{<link[^>]+?type\\s*=\\s*["\']?text/css["\']?[^>]*>}i';
    $replace7 = '';
    $pattern8 = '{<link[^>]+?rel\\s*=\\s*["\']?stylesheet["\']?[^>]*>}i';
    $replace8 = '';
    $pattern9 = '{<style[^>]*>.*?</style>}i';
    $replace9 = '';
    $pattern10 = '{<!--.*?-->}i';
    $replace10 = '';
    $pattern11 = '{<noscript>.*?</noscript>}i';
    $replace11 = '';
    
    if (preg_match($pattern1, $page_str)) $page_str = preg_replace($pattern1, $replace1, $page_str);
    if (preg_match($pattern2, $page_str)) $page_str = preg_replace($pattern2, $replace2, $page_str);
    if (preg_match($pattern3, $page_str)) $page_str = preg_replace($pattern3, $replace3, $page_str);
    if (preg_match($pattern4, $page_str)) $page_str = preg_replace($pattern4, $replace4, $page_str);
    if (preg_match($pattern5, $page_str)) $page_str = preg_replace($pattern5, $replace5, $page_str);
    if (preg_match($pattern6, $page_str)) $page_str = preg_replace($pattern6, $replace6, $page_str);
    if (preg_match($pattern7, $page_str)) $page_str = preg_replace($pattern7, $replace7, $page_str);
    if (preg_match($pattern8, $page_str)) $page_str = preg_replace($pattern8, $replace8, $page_str);
    if (preg_match($pattern9, $page_str)) $page_str = preg_replace($pattern9, $replace9, $page_str);
    if (preg_match($pattern10, $page_str)) $page_str = preg_replace($pattern10, $replace10, $page_str);
    if (preg_match($pattern11, $page_str)) $page_str = preg_replace($pattern11, $replace11, $page_str);
    
    return $page_str;
}

function my_string_in_utf8_4phpquery_soft_2($string) {
/*
 * Для работы функции обязательно нужно, чтобы кодировка строки была UTF-8
 */
    $string = my_string_in_line_2($string, false);
    
    $pattern1 = '{<!DOCTYPE[^>]+>}i';
    $replace1 = '';
    $pattern2 = '{^.*?(<html[\\s>])}i';
    $replace2 = '$1';
    $pattern3 = '{<html[^>]*?>}i';
    $replace3 = '<html>';
    $pattern4 = '{<meta[^>]*?http-equiv\\s*=\\s*["\']?content-type["\']?[^>]*>}i';
    $replace4 = '';
    $pattern5 = '{<meta[^>]*?charset\\s*=\\s*[^>]+>}i';
    $replace5 = '';
    $pattern6 = '{<!--.*?-->}i';
    $replace6 = '';
    
    if (preg_match($pattern1, $string)) $string = preg_replace($pattern1, $replace1, $string);
    if (preg_match($pattern2, $string)) $string = preg_replace($pattern2, $replace2, $string);
    if (preg_match($pattern3, $string)) $string = preg_replace($pattern3, $replace3, $string);
    if (preg_match($pattern4, $string)) $string = preg_replace($pattern4, $replace4, $string);
    if (preg_match($pattern5, $string)) $string = preg_replace($pattern5, $replace5, $string);
    if (preg_match($pattern6, $string)) $string = preg_replace($pattern6, $replace6, $string);
    
    return $string;
}

function my_get_urls_2($file, $file_info /* $content_type */, $parent_url, $base_url, $all_links /* true || false */, $another /* true || false */) {
/*
    1. НЕ НАШЕЛ МАЛЕНЬКОГО ТРЕУГОЛЬНИЧКА ИЗ JAVASCRIPT -- СМОТРИ HTTP://WWW.SCORVET.MPI.RU И HTTP://WWW.SCORVET.RU, обратив внимание на выпадающее меню
*/
    $result = array( );
    
    if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
    if (isset($_SERVER['COMSPEC'])) $file_info = mb_convert_encoding($file_info, 'windows-1251', 'UTF-8');
    if (@filesize($file) && @filesize($file_info)) {
        if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
        if (isset($_SERVER['COMSPEC'])) $file_info = mb_convert_encoding($file_info, 'UTF-8', 'windows-1251');
        
        $info = my_info_array($file_info);
        
        if (isset($info['content_type'])) {
            
            if ($info['content_type'] === 'text/html') {
                
                if (my_file_in_utf8_4phpquery_soft_2($file, $file_info)) {
                    
                    if (isset($document)) unset($document);
                    if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
                    $document = phpQuery::newDocumentFile($file);
                    if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
                    
                    $a_tags = $document->find("a");
                    foreach ($a_tags as $a_tag) {
                        $a_tag = pq($a_tag);
                        $href = $a_tag->attr("href");
                        if (mb_strlen($href)) $href = my_normalize_url_all_2($href, $parent_url, $base_url, $another);
                        if (mb_strlen($href)) {
                            $anchor = $a_tag->text( );
                            $anchor = my_string_in_line_2($anchor);
                            if (mb_strpos($anchor, "\t") !== FALSE) $anchor = str_replace("\t", " ", $anchor);
                            while (mb_strpos($anchor, '  ') !== FALSE) $anchor = str_replace('  ', ' ', $anchor);
                            if (isset($result[$href])) {
                                if (mb_strlen($anchor) > mb_strlen($result[$href])) $result[$href] = $anchor;
                            }
                            else {
                                $result[$href] = $anchor;
                            }
                        }
                    }
                    
                    if ($all_links) {
                        
                        $link_tags = $document->find("link");
                        foreach ($link_tags as $link_tag) {
                            $link_tag = pq($link_tag);
                            $rel = $link_tag->attr("rel");
                            if ($rel === 'stylesheet') {
                                $href = $link_tag->attr("href");
                                if (mb_strlen($href)) $href = my_normalize_url_all_2($href, $parent_url, $base_url, $another);
                                if (mb_strlen($href)) $result[$href] = '';
                            }
                        }
                        
                        $script_tags = $document->find("script");
                        foreach ($script_tags as $script_tag) {
                            $script_tag = pq($script_tag);
                            $src = $script_tag->attr("src");
                            if (mb_strlen($src)) $src = my_normalize_url_all_2($src, $parent_url, $base_url, $another);
                            if (mb_strlen($src)) $result[$src] = '';
                        }
                        
                        $img_tags = $document->find("img");
                        foreach ($img_tags as $img_tag) {
                            $img_tag = pq($img_tag);
                            $src = $img_tag->attr("src");
                            if (mb_strlen($src)) $src = my_normalize_url_all_2($src, $parent_url, $base_url, $another);
                            if (mb_strlen($src)) $result[$src] = '';
                        }
                    }
                }
            }
            elseif ($info['content_type'] === 'text/xml') {
                
                $pattern_check_sitemap = '{(^|//)[^/]+/sitemap\\.xml$}i';
                if (preg_match($pattern_check_sitemap, $parent_url)) {
                    
                    if (isset($document)) unset($document);
                    if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
                    $document = phpQuery::newDocumentFileXML($file);
                    if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
                    
                    $locs = $document->find('loc');
                    foreach ($locs as $loc) {
                        $loc = pq($loc);
                        $href = $loc->text( );
                        $result[$href] = '';
                    }
                }
            }
            
            if ($all_links) {
                
                if ($info['content_type'] === 'text/css') {
                    
                    $page = file_get_contents($file);
                    $page = my_string_in_line($page);
                    
                    $pattern_comments = '{(?=/\\*).*(?<=\\*/)}';
                    $replace_comments = '';
                    
                    if (preg_match($pattern_comments, $page)) $page = preg_replace($pattern_comments, $replace_comments, $page);
                    
                    $pattern_import_css = '{@import[^;]+?"([^"]+)"}im';
                    if (preg_match_all($pattern_import_css, $page, $matches)) {
                        if (count($matches[1])) {
                            foreach ($matches[1] as $href) {
                                if (mb_strlen($href)) $href = my_normalize_url_all_2($href, $parent_url, $base_url, $another);
                                if (mb_strlen($href)) $result[$href] = '';
                            }
                        }
                    }
                    
                    $pattern_url_css = '{url\\(["\']?([^\\)]+?)["\']?\\)}im';
                    if (preg_match_all($pattern_url_css, $page, $matches)) {
                        if (count($matches[1])) {
                            foreach ($matches[1] as $src) {
                                if (mb_strlen($src)) $src = my_normalize_url_all_2($src, $parent_url, $base_url, $another);
                                if (mb_strlen($src)) $result[$src] = '';
                            }
                        }
                    }
                }
                elseif ($info['content_type'] === 'text/javascript') {
/* ПРОДОЛЖИТЬ ЗДЕСЬ */
                }
            }
        }
    }
    else {
        if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
        if (isset($_SERVER['COMSPEC'])) $file_info = mb_convert_encoding($file_info, 'UTF-8', 'windows-1251');
    }
    
    return $result;
}

function my_get_urls_from_string($string, $content_type, $parent_url, $base_url, $all_links /* true || false */, $another /* true || false */) {
/*
 * Для работы функции обязательно нужно, чтобы кодировка строки была UTF-8
 */
    
/* Доработать
 * 1. НЕ НАШЕЛ МАЛЕНЬКОГО ТРЕУГОЛЬНИЧКА ИЗ JAVASCRIPT -- СМОТРИ HTTP://WWW.SCORVET.MPI.RU И HTTP://WWW.SCORVET.RU, обратив внимание на выпадающее меню
 */
    $result = array( );
    
    $string = my_string_in_line_2($string);
    
    if ($content_type === 'text/html') {
        if (my_string_in_utf8_4phpquery_soft_2($string)) {
            
            if (isset($document)) unset($document);
            $document = phpQuery::newDocument($string);
            
            $a_tags = $document->find("a");
            foreach ($a_tags as $a_tag) {
                $a_tag = pq($a_tag);
                $href = $a_tag->attr("href");
                if (mb_strlen($href)) $href = my_normalize_url_all_2($href, $parent_url, $base_url, $another);
                if (mb_strlen($href)) {
                    $anchor = $a_tag->text( );
                    $anchor = my_string_in_line_2($anchor);
                    if (mb_strpos($anchor, "\t") !== FALSE) $anchor = str_replace("\t", " ", $anchor);
                    while (mb_strpos($anchor, '  ') !== FALSE) $anchor = str_replace('  ', ' ', $anchor);
                    if (isset($result[$href])) {
                        if (mb_strlen($anchor) > mb_strlen($result[$href])) $result[$href] = $anchor;
                    }
                    else {
                        $result[$href] = $anchor;
                    }
                }
            }
            
            if ($all_links) {
                $link_tags = $document->find("link");
                foreach ($link_tags as $link_tag) {
                    $link_tag = pq($link_tag);
                    $rel = $link_tag->attr("rel");
                    if ($rel === 'stylesheet') {
                        $href = $link_tag->attr("href");
                        if (mb_strlen($href)) $href = my_normalize_url_all_2($href, $parent_url, $base_url, $another);
                        if (mb_strlen($href)) $result[$href] = '';
                    }
                }
                
                $script_tags = $document->find("script");
                foreach ($script_tags as $script_tag) {
                    $script_tag = pq($script_tag);
                    $src = $script_tag->attr("src");
                    if (mb_strlen($src)) $src = my_normalize_url_all_2($src, $parent_url, $base_url, $another);
                    if (mb_strlen($src)) $result[$src] = '';
                }
                
                $img_tags = $document->find("img");
                foreach ($img_tags as $img_tag) {
                    $img_tag = pq($img_tag);
                    $src = $img_tag->attr("src");
                    if (mb_strlen($src)) $src = my_normalize_url_all_2($src, $parent_url, $base_url, $another);
                    if (mb_strlen($src)) $result[$src] = '';
                }
            }
        }
    }
    elseif ($content_type === 'text/xml') {
        $pattern_check_sitemap = '{(^|//)[^/]+/sitemap\\.xml$}i';
        if (preg_match($pattern_check_sitemap, $parent_url)) {
            
            if (isset($document)) unset($document);
            $document = phpQuery::newDocumentXML($string);
            
            $locs = $document->find('loc');
            foreach ($locs as $loc) {
                $loc = pq($loc);
                $href = $loc->text( );
                $result[$href] = '';
            }
        }
    }
    
    if ($all_links) {
        if ($content_type === 'text/css') {
            
            $pattern_comments = '{(?=/\\*).*(?<=\\*/)}';
            $replace_comments = '';
            
            if (preg_match($pattern_comments, $string)) $string = preg_replace($pattern_comments, $replace_comments, $string);
            
            $pattern_import_css = '{@import[^;]+?"([^"]+)"}i';
            if (preg_match_all($pattern_import_css, $string, $matches)) {
                if (count($matches[1])) {
                    foreach ($matches[1] as $href) {
                        if (mb_strlen($href)) $href = my_normalize_url_all_2($href, $parent_url, $base_url, $another);
                        if (mb_strlen($href)) $result[$href] = '';
                    }
                }
            }
            
            $pattern_url_css = '{url\\(["\']?([^\\)]+?)["\']?\\)}i';
            if (preg_match_all($pattern_url_css, $string, $matches)) {
                if (count($matches[1])) {
                    foreach ($matches[1] as $src) {
                        if (mb_strlen($src)) $src = my_normalize_url_all_2($src, $parent_url, $base_url, $another);
                        if (mb_strlen($src)) $result[$src] = '';
                    }
                }
            }
        }
        elseif ($content_type === 'text/javascript') {
/* ПРОДОЛЖИТЬ ЗДЕСЬ */
        }
    }
    
    if (isset($document)) unset($document);
    return $result;
}

/* УСТАРЕЛО */
function my_get_mapsite($site, $dir, $filetype = 'mapsite', $delimiter = "\t--DELIM--\t", $page_begin = -1, $page_end = -1) {
    
	$result = array ( );
    
    $filetype = mb_strtolower($filetype);
	
    if (($filetype === 'mapsite') || ($filetype === 'sitemap')) {
        
        if (mb_substr($site, -1) === '/') $site = mb_substr($site, 0, -1);
        $url = $site . '/' . $filetype;
        if ($filetype === 'mapsite'): $url .= '.html';
        elseif ($filetype === 'sitemap'): $url .= '.xml';
        endif;
        
        $pattern_filename = '{(http://)?((www\.)?[a-z0-9-\.]+)}i';
        $filename = $filetype;
        if ($filetype === 'mapsite'): $filename .= '.html';
        elseif ($filetype === 'sitemap'): $filename .= '.xml';
        endif;
        if (preg_match($pattern_filename, $url, $match)) {
            if (mb_strlen($match[2])) {
                $pristavka = str_replace('.', '__DOT__', $match[2]);
                $filename = $pristavka . '___' . $filename;
            }
        }
        $file = $dir . DIRECTORY_SEPARATOR . $filename;
        
        $i = 1;
        $pages = array ( );
        do {
            $ref = $site . '/';
            $check_curl_exec = my_curl_request($url, $file, TRUE, TRUE, 'check', 'identity', 't', $ref);
            $i++;
            if ($check_curl_exec) {
                $info = my_info_array($file);
                $charset = 'windows-1251';
                if (isset ($info['charset'])) $charset = $info['charset'];
                
                $pattern_pagenum = '{page(\d+)\.html?$}i';
                if ($filetype === 'mapsite') {
                    if (my_file_in_utf8_4phpquery($file, $charset)) {
                        $document = phpQuery::newDocumentFile($file);
                        $anchors = $document -> find('ol a');
                        foreach ($anchors as $anchor) {
                            $anchor = pq($anchor);
                            $href = $anchor->attr('href');
                            $title = $anchor->text( );
                            if (mb_strpos($title, "\t") !== FALSE) $title = str_replace("\t", ' ', $title);
                            $title = trim($title);
                            if (preg_match($pattern_pagenum, $href, $match) && mb_strlen($title)) {
                                $pages[$match[1]] = $title;
                            }
                        }
                        unset($document);
                    }
                }
                elseif (($filetype === 'sitemap') && ($charset === 'utf-8')) {
                    $dir_sitemap = $dir . DIRECTORY_SEPARATOR . $pristavka;
                    if (!is_dir($dir_sitemap)) @mkdir($dir_sitemap, 0777);
                    $file_sitemap_info = $dir_sitemap . DIRECTORY_SEPARATOR . $pristavka . '.info';
                    $pages_buffer = array ( );
                    if (is_file($file_sitemap_info) && filesize($file_sitemap_info)) $pages_buffer = my_info_array($file_sitemap_info, $delimiter, FALSE);
                    
                    $document = phpQuery::newDocumentFileXML($file);
                    $locs = $document->find('loc');
                    foreach ($locs as $loc) {
                        $loc = pq($loc);
                        $href = $loc->text( );
                        if (!isset ($pages_buffer[$href])) {
                            $pattern_filename1 = '{([^/]+htm)l?$}i';
                            $replace_filename1 = '$1l';
                            $filename = 'page_unknown.html';
                            if (preg_match($pattern_filename1, $href, $match)) {
                                if (mb_strlen($match[1])) $filename = preg_replace($pattern_filename1, $replace_filename1, $match[1]);
                            }
                            $file = $dir_sitemap . DIRECTORY_SEPARATOR . $filename;
                            
                            $ref = $url;
                            if (my_curl_request($href, $file, TRUE, TRUE, 'check', 'identity', 't', $ref)) {
                                $info = my_info_array($file);
                                $charset = 'windows-1251';
                                if (isset ($info['charset'])) $charset = $info['charset'];
                                $page_str = my_file_in_line($file);
                                if ($charset !== 'utf-8') $page_str = mb_convert_encoding($page_str, 'utf-8', $charset);
                                $pattern_title = '{<title[^>]*>([^<]*)</title>}i';
                                if (preg_match($pattern_title, $page_str, $match)) {
                                    if (mb_strlen($match[1])) {
                                        $title = $match[1];
                                        if (mb_strpos($title, "\t") !== FALSE) $title = str_replace("\t", ' ', $title);
                                        $title = trim($title);
                                        if (mb_strlen($title)) $pages_buffer[$href] = $title;
                                    }
                                }
                            }
                        }
                    }
                    unset ($document);
                    
                    $pages_page_in_url = array ( );
                    $pages_no_page_in_url = array ( );
                    foreach ($pages_buffer as $href => $title) {
                        if (preg_match($pattern_pagenum, $href, $match)) {
                            $pagenum = $match[1];
                            $pages_page_in_url[$pagenum] = array ($href, $title);
                        }
                        else {
                            $pages_no_page_in_url[ ] = array ($href, $title);
                        }
                    }
                    ksort($pages_page_in_url);
                    
                    $string = '';
                    foreach ($pages_no_page_in_url as $value) {
                        $string .= $value[0] . $delimiter . $value[1] . "\n";
                    }
                    foreach ($pages_page_in_url as $value) {
                        $string .= $value[0] . $delimiter . $value[1] . "\n";
                    }
                    
                    if (mb_strlen($string)) {
                        $f = fopen($file_sitemap_info, 'wt');
                        fwrite($f, $string);
                        fclose($f);
                    }
                    
                    if (is_file($file_sitemap_info) && filesize($file_sitemap_info)) {
                        $pages_buffer = my_info_array($file_sitemap_info, $delimiter, FALSE);
                        if (count($pages_buffer)) {
                            foreach ($pages_buffer as $href => $title) {
                                if (preg_match($pattern_pagenum, $href, $match) && mb_strlen($title)) {
                                    $pages[$match[1]] = $title;
                                }
                            }
                        }
                    }
                }
            }
        }
        while (($check_curl_exec === FALSE) && ($i <= 10));
        
        if (count($pages)) {
            ksort($pages);
            $result = $pages;
            if ($page_begin > 0) {
                foreach ($result as $key => $value) {
                    if ($key < $page_begin) unset ($result[$key]);
                }
            }
            if ($page_end > 0) {
                foreach ($result as $key => $value) {
                    if ($key > $page_end) unset ($result[$key]);
                }
            }
        }
    }
    
	return $result;
}
