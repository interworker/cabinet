<?php

function my_string_in_file($string, $file) {
    
    $result = FALSE;
    
    if (mb_strlen($string)) {
        $document = phpQuery::newDocument($string);
        $lines = explode("\n", $document);
        unset ($document);
        
        $string = '';
        for ($i = 0; $i < count($lines); $i++) {
            if (mb_strlen($lines[$i]) > 0) {
                $string .= $lines[$i];
                if ($i < (count($lines) - 2)) $string .= "\n";
            }
        }
        
        if (mb_strlen($string)) {
            if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
            $f = fopen($file, 'wt');
            if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
            if (fwrite($f, $string)) $result = TRUE;
            fclose($f);
        }
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
            $str = 'encoding' . "\t" . 'utf-8' . "\n";
            fwrite($f_func, $str);
            fclose($f_func);
        }
    }
    
    return $result;
}

function my_file_in_utf8_4phpquery_soft_2($file_in, $charset, $file_out = '') {
    
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

function my_string_in_utf8_4phpquery($string, $charset) {
    
    $page_str = my_string_in_line($string);
    
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
    
    return $page_str;
}

/* УСТАРЕЛО
function my_get_meta($file) {
    
    $meta_array = array ( );
    
    $info = my_info_array($file);
    $charset = '';
    if (isset ($info['encoding'])) {
        $charset = $info['encoding'];
    }
    elseif (isset ($info['charset'])) {
        $charset = $info['charset'];
    }
    
    if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
    if (is_file($file) && filesize($file) && mb_strlen($charset)) {
        if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
        if (my_file_in_utf8_4phpquery($file, $charset)) {
            if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
            $document = phpQuery::newDocumentFile($file);
            if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
            $title = '';
            $title = $document->find("title")->text( );
            $title = trim($title);
            if (mb_strpos($title, "\t") !== FALSE) $title = str_replace("\t", ' ', $title);
            if (mb_strpos($title, "\r\n") !== FALSE) $title = str_replace("\r\n", ' ', $title);
            if (mb_strpos($title, "\r") !== FALSE) $title = str_replace("\r", ' ', $title);
            if (mb_strpos($title, "\n") !== FALSE) $title = str_replace("\n", ' ', $title);
            while (mb_strpos($title, '  ') !== FALSE) $title = str_replace('  ', ' ', $title);
            if (mb_strlen($title)) $meta_array['title'] = $title;
            
            $metas = $document->find("meta");
            foreach ($metas as $meta) {
                $meta = pq($meta);
                $key = '';
                $key = $meta->attr("name");
                $val = $meta->attr("content");
                if (mb_strlen($key) && !isset ($meta_array[$key])) {
                    $key = mb_strtolower($key);
                    $meta_array[$key] = $val;
                }
            }
            
            if (isset ($meta_array['description'])) {
                $meta_array['description'] = trim($meta_array['description']);
                if (mb_strpos($meta_array['description'], "\t") !== FALSE) $meta_array['description'] = str_replace("\t", ' ', $meta_array['description']);
                if (mb_strpos($meta_array['description'], "\r\n") !== FALSE) $meta_array['description'] = str_replace("\r\n", ' ', $meta_array['description']);
                if (mb_strpos($meta_array['description'], "\r") !== FALSE) $meta_array['description'] = str_replace("\r", ' ', $meta_array['description']);
                if (mb_strpos($meta_array['description'], "\n") !== FALSE) $meta_array['description'] = str_replace("\n", ' ', $meta_array['description']);
                while (mb_strpos($meta_array['description'], '  ') !== FALSE) $meta_array['description'] = str_replace('  ', ' ', $meta_array['description']);
            }
            if (isset ($meta_array['keywords'])) {
                $meta_array['keywords'] = trim($meta_array['keywords']);
                if (mb_strpos($meta_array['keywords'], "\t") !== FALSE) $meta_array['keywords'] = str_replace("\t", ' ', $meta_array['keywords']);
                if (mb_strpos($meta_array['keywords'], "\r\n") !== FALSE) $meta_array['keywords'] = str_replace("\r\n", ' ', $meta_array['keywords']);
                if (mb_strpos($meta_array['keywords'], "\r") !== FALSE) $meta_array['keywords'] = str_replace("\r", ' ', $meta_array['keywords']);
                if (mb_strpos($meta_array['keywords'], "\n") !== FALSE) $meta_array['keywords'] = str_replace("\n", ' ', $meta_array['keywords']);
                while (mb_strpos($meta_array['keywords'], '  ') !== FALSE) $meta_array['keywords'] = str_replace('  ', ' ', $meta_array['keywords']);
            }
        }
    }
    
    return $meta_array;
}
*/

function my_get_urls_2($file, $content_type, $parent_url, $base_url) {
/* НЕ НАШЕЛ МАЛЕНЬКОГО ТРЕУГОЛЬНИЧКА ИЗ JAVASCRIPT -- СМОТРИ HTTP://WWW.SCORVET.MPI.RU И HTTP://WWW.SCORVET.RU, обратив внимание на выпадающее меню */
    $result = array( );
    
    if ($content_type === 'text/html') {
        
        if (isset($document)) unset($document);
        $document = phpQuery::newDocumentFile($file);
        
        $link_tags = $document->find("link");
        foreach ($link_tags as $link_tag) {
            $link_tag = pq($link_tag);
            $rel = $link_tag->attr("rel");
            if ($rel === 'stylesheet') {
                $href = $link_tag->attr("href");
                if (mb_strlen($href)) $href = my_normalize_url_all_2($href, $parent_url, $base_url);
                if (mb_strlen($href)) $result[$href] = '';
            }
        }
        
        $script_tags = $document->find("script");
        foreach ($script_tags as $script_tag) {
            $script_tag = pq($script_tag);
            $src = $script_tag->attr("src");
            if (mb_strlen($src)) $src = my_normalize_url_all_2($src, $parent_url, $base_url);
            if (mb_strlen($src)) $result[$src] = '';
        }
        
        $img_tags = $document->find("img");
        foreach ($img_tags as $img_tag) {
            $img_tag = pq($img_tag);
            $src = $img_tag->attr("src");
            if (mb_strlen($src)) $src = my_normalize_url_all_2($src, $parent_url, $base_url);
            if (mb_strlen($src)) $result[$src] = '';
        }
        
        $a_tags = $document->find("a");
        foreach ($a_tags as $a_tag) {
            $a_tag = pq($a_tag);
            $href = $a_tag->attr("href");
            if (mb_strlen($href)) $href = my_normalize_url_all_2($href, $parent_url, $base_url);
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
    }
    elseif ($content_type === 'text/css') {
        
        $page = file_get_contents($file);
        $page = my_string_in_line($page);
        
        $pattern_comments = '{(?=/\\*).*(?<=\\*/)}';
        $replace_comments = '';
        
        if (preg_match($pattern_comments, $page)) $page = preg_replace($pattern_comments, $replace_comments, $page);
        
        $pattern_import_css = '{@import[^;]+?"([^"]+)"}im';
        if (preg_match_all($pattern_import_css, $page, $matches)) {
            if (count($matches[1])) {
                foreach ($matches[1] as $href) {
                    if (mb_strlen($href)) $href = my_normalize_url_all_2($href, $parent_url, $base_url);
                    if (mb_strlen($href)) $result[$href] = '';
                }
            }
        }
        
        $pattern_url_css = '{url\\(["\']?([^\\)]+?)["\']?\\)}im';
        if (preg_match_all($pattern_url_css, $page, $matches)) {
            if (count($matches[1])) {
                foreach ($matches[1] as $src) {
                    if (mb_strlen($src)) $src = my_normalize_url_all_2($src, $parent_url, $base_url);
                    if (mb_strlen($src)) $result[$src] = '';
                }
            }
        }
    }
    elseif ($content_type === 'text/xml') {
        $pattern_check_sitemap = '{(^|//)[^/]+/sitemap\\.xml$}i';
        if (preg_match($pattern_check_sitemap, $parent_url)) {
            
            if (isset($document)) unset($document);
            $document = phpQuery::newDocumentFileXML($file);
            
            $locs = $document->find('loc');
            foreach ($locs as $loc) {
                $loc = pq($loc);
                $href = $loc->text( );
                $result[$href] = '';
            }
        }
    }
    
    return $result;
}

/* УСТАРЕЛО
function my_get_urls($file, $only_html_files = FALSE, $substring = '', $no_img = FALSE, $parts_regexp = FALSE, $parts_phpquery = FALSE) {
    
    $result = array ( );
    
    $a = array ( );
    $img = array ( );
    $css = array ( );
    
    $info = my_info_array($file);
    
    if ((mb_strlen($substring) === 0) && isset($info['base_url'])) $substring = $info['base_url'];
    
    $charset = '';
    if (isset ($info['content_type'])) {
        if ($info['content_type'] === 'text/html') {
            if (isset ($info['encoding'])) {
                $charset = $info['encoding'];
            }
            elseif (isset ($info['charset'])) {
                $charset = $info['charset'];
            }
            if (mb_strlen($charset)) {
                if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
                if (is_file($file) && filesize($file) && mb_strlen($charset)) {
                    if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
                    if (my_file_in_utf8_4phpquery($file, $charset)) {
                        
                        $check_parts = TRUE;
                        
                        if ($parts_regexp || $parts_phpquery) {
                            
                            $check_parts = FALSE;
                            
                            $mainpart = my_file_in_line($file);
                            
*/
/* BEGIN REGULAR EXPRESSIONS *//*
                            if ($parts_regexp) {
                                $pattern_mainpart = '{^.*?((?=<body[\s>]).*(?<=</body>)).*?$}i';
                                $replace_mainpart = '$1';
                                if (preg_match($pattern_mainpart, $mainpart)) $mainpart = preg_replace($pattern_mainpart, $replace_mainpart, $mainpart);
                            }
*/
/* END REGULAR EXPRESSIONS */
                            
                            
/* BEGIN PHPQUERY */
/*
                            if ($parts_phpquery && mb_strlen($mainpart)) {
                                $document = phpQuery::newDocument($mainpart);
                                
                                $mainpart = $document->find("body")->html( );
                                $mainpart = my_string_in_line($mainpart);
                            }
*/
/* END PHPQUERY *//*
                            
                            if (mb_strlen($mainpart)) $check_parts = my_string_in_file($mainpart, $file);
                        }
                        
                        if ($check_parts) {
                            if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
                            $document = phpQuery::newDocumentFile($file);
                            if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
                            $anchors = $document->find("a");
                            foreach ($anchors as $anchor) {
                                $anchor = pq($anchor);
                                $href = '';
                                $href = $anchor->attr("href");
                                if (mb_strlen($href) && isset($info['base_url']) && isset($info['own_url']))
                                  $href = my_normalize_url_all($href, $info['base_url'], $substring, $info['own_url'], $no_img);
                                if (mb_strlen($href)) {
                                    if (!isset($a[$href])) {
                                        $text = $anchor->text( );
                                        if (mb_strlen($text)) {
                                            $text = trim($text);
                                            if (mb_strpos($text, "\t") !== FALSE) $text = str_replace("\t", ' ', $text);
                                            if (mb_strpos($text, "\r\n") !== FALSE) $text = str_replace("\r\n", ' ', $text);
                                            if (mb_strpos($text, "\r") !== FALSE) $text = str_replace("\r", ' ', $text);
                                            if (mb_strpos($text, "\n") !== FALSE) $text = str_replace("\n", ' ', $text);
                                            while (mb_strpos($text, '  ') !== FALSE) $text = str_replace('  ', ' ', $text);
                                        }
                                        $a[$href] = $text;
                                    }
                                }
                            }
                            if ($no_img === FALSE) {
                                $images = $document->find("[src]");
                                foreach ($images as $image) {
                                    $image = pq($image);
                                    $src = '';
                                    $src = $image->attr("src");
                                    if (mb_strlen($src) && isset($info['base_url']) && isset($info['own_url']))
                                      $src = my_normalize_url_all($src, $info['base_url'], $info['base_url'], $info['own_url'], $no_img);
                                    if (mb_strlen($src)) {
                                        if (!isset($img[$src])) $img[$src] = '';
                                    }
                                }
                            }
                        }
                    }
                }
                else {
                    if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
                }
            }
        }
        elseif (($info['content_type'] === 'text/css') && ($only_html_files === FALSE)) {
            $page_string = my_file_in_line($file);
            $pattern_import_css = '{@import[^;]+?"([^"]+)"}i';
            if (preg_match_all($pattern_import_css, $page_string, $matches)) {
                if (count($matches[1])) {
                    foreach ($matches[1] as $href) {
                        if (mb_strlen($href) && isset($info['base_url']) && isset($info['own_url'])) {
                            $href = my_normalize_url_all($href, $info['base_url'], $info['base_url'], $info['own_url'], $no_img);
                            if (mb_strlen($href)) {
                                if (!isset($css[$href])) $css[$href] = '';
                            }
                        }
                    }
                }
            }
            
            $pattern_url_css = '{url\\(["\']?([^\\)]+?)["\']?\\)}i';
            if (preg_match_all($pattern_url_css, $page_string, $matches)) {
                if (count($matches[1])) {
                    foreach ($matches[1] as $src) {
                        if (mb_strlen($src) && isset($info['base_url']) && isset($info['own_url'])) {
                            $src = my_normalize_url_all($src, $info['base_url'], $info['base_url'], $info['own_url'], $no_img);
                            if (mb_strlen($src)) {
                                if (!isset($img[$src])) $img[$src] = '';
                            }
                        }
                    }
                }
            }
        }
    }
    
    $result = array (
                        'anchors' => $a,
                        'images'  => $img,
                        'css'     => $css
    );
    
    return $result;
}
*/

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
