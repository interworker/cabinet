<?php

/* УСТАРЕЛО
function my_curl_request_temp($url, $referer, $User_Agent, $HTTP_Headers, $temp_dir) {
    
    $result = '';
    
    $url = trim($url);
    
    if (mb_strlen($url) && (preg_match('{\s}', $url) === 0)) {
        if (mb_substr($url, 0, 2) === '//') $url = 'http:' . $url;
        if (mb_substr($url, 0, 7) !== 'http://') $url = 'http://' . $url;
        
        $temp_file = my_random_file($temp_dir, 'temp_');
        
        $check = false;
        
        if (mb_strlen($temp_file)) {
            $pattern_host = '{^(http://([^/]+))}i';
            if (preg_match($pattern_host, $url, $match)) {
                $host = $match[2];
                $base_url = $match[1];
                
                if ($referer === 'base_url') $referer = $base_url . '/';
                
                $HTTP_Headers[0] = 'Host: ' . $host;
                
                $temp_file_info   = $temp_file . '.info';
                if (isset($_SERVER['COMSPEC'])) $temp_file_info = mb_convert_encoding($temp_file_info, 'windows-1251', 'UTF-8');
                $f_info = fopen($temp_file_info, 'wt');
                if (isset($_SERVER['COMSPEC'])) $temp_file_info = mb_convert_encoding($temp_file_info, 'UTF-8', 'windows-1251');
                
                $i = 0;
                do {
                    $i++;
                    
                    $temp_file_header = $temp_file . '.header';
                    if (isset ($_SERVER['COMSPEC'])) $temp_file_header = mb_convert_encoding($temp_file_header, 'windows-1251', 'UTF-8');
                    $f_header = fopen($temp_file_header, 'wt');
                    if (isset ($_SERVER['COMSPEC'])) $temp_file_header = mb_convert_encoding($temp_file_header, 'UTF-8', 'windows-1251');
                    
                    $temp_file_error = $temp_file . '.error';
                    if (isset ($_SERVER['COMSPEC'])) $temp_file_error = mb_convert_encoding($temp_file_error, 'windows-1251', 'UTF-8');
                    $f_error = fopen($temp_file_error, 'wt');
                    if (isset ($_SERVER['COMSPEC'])) $temp_file_error = mb_convert_encoding($temp_file_error, 'UTF-8', 'windows-1251');
                    
                    $ch = curl_init($url);
                    
                    if ($referer) curl_setopt($ch, CURLOPT_REFERER, $referer);
                    curl_setopt($ch, CURLOPT_USERAGENT, $User_Agent);
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $HTTP_Headers);
                    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                    curl_setopt($ch, CURLOPT_MAXREDIRS, 77);
                    curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                    curl_setopt($ch, CURLOPT_VERBOSE, true);
                    curl_setopt($ch, CURLOPT_WRITEHEADER, $f_header);
                    curl_setopt($ch, CURLOPT_STDERR, $f_error);
                    curl_setopt($ch, CURLOPT_NOBODY, true);
                    
                    curl_exec($ch);
                    
                    curl_close($ch);
                    
                    fclose($f_header);
                    
                    fclose($f_error);
                    
                    $header_lines = my_file_to_array($temp_file_header);
                    
                    if (count($header_lines)) $check = true;
                    
                    if ($check) {
                        
                        $status = '000';
                        $pattern_status = '{\\s(\\d{3})}';
                        foreach ($header_lines as $header_line) {
                            if (mb_substr($header_line, 0, 5) === 'HTTP/') {
                                if (preg_match($pattern_status, $header_line, $match)) {
                                    $status = $match[1];
                                }
                            }
                        }
                        
                        $charset = '';
                        $content_type = '';
                        $pattern_content_type_header = '{Content-Type:\\s+([a-z0-9-\\./]+)}i';
                        $pattern_charset_header = '{charset\\s*=\\s*(.+)$}i';
                        foreach ($header_lines as $header_line) {
                            if (preg_match($pattern_content_type_header, $header_line, $match)) {
                                $content_type = $match[1];
                                $content_type = trim($content_type);
                                $content_type = mb_strtolower($content_type);
                            }
                            if (preg_match($pattern_charset_header, $header_line, $match)) {
                                $charset = $match[1];
                                $charset = trim($charset);
                                if (mb_strpos($charset, '"') !== FALSE) $charset = str_replace('"', '', $charset);
                                if (mb_strpos($charset, "'") !== FALSE) $charset = str_replace("'", '', $charset);
                                if (mb_strpos($charset, "\\") !== FALSE) $charset = str_replace("\\", '', $charset);
                                
                                $charset = mb_strtolower($charset);
                                $charset = trim($charset);
                            }
                        }
                        
                        $str_info =   'status' . "\t" . $status . "\n"
                                    . 'own_url' . "\t" . $url . "\n"
                                    . 'base_url' . "\t" . $base_url . "\n";
                        
                        if ($referer === false) $referer = 'false';
                        
                        $str_info .= 'referer' . "\t" . $referer . "\n";
                        
                        if (mb_strlen($content_type)) $str_info .= 'content_type' . "\t" . $content_type . "\n";
                        
                        if (mb_strlen($charset)) $str_info .= 'charset' . "\t" . $charset . "\n";
                        
                        fwrite($f_info, $str_info);
                    }
                    
                    $tempfilename_header = basename($tempfile_header);
                    my_delete_files($tempfilename_header, $dir, true);
                }
                while (($check === false) && ($i <= 100));
                
                fclose($f_info);
            }
        }
        
        if ($check) $result = $temp_file;
    }
    
    return $result;
}
*/

/* УСТАРЕЛО */
#function my_curl_request($url, $file, $check_200_OK = FALSE, $check_end = FALSE, $output_type = 'content', $encoding = 'identity', $curl_mode = 't', $ref = '', $repeat = 1, $get_cookie = FALSE, $cookie = '', $post_data = array ( ), $cookie_header = FALSE) {
#    
#    $result = FALSE;
#    
#    $useragent = 'User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:12.0) Gecko/20100101 Firefox/12.0';
#    
#    $pattern_host = '{^(http://)?([^/]+)}i';
#    preg_match($pattern_host, $url, $match);
#    $host = $match[2];
#    $base_url = 'http://' . $match[2];
#    
#    if ($ref === FALSE) {
#        $ref = '';
#    }
#    elseif (mb_strlen($ref) === 0) {
#        $ref = $base_url . '/';
#    }
#    
#    $httpheader = array (
#                            'Host: ' . $host,
#                            'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
#                            'Accept-Language: ru-ru,ru;q=0.8,en-us;q=0.5,en;q=0.3',
#                            'DNT: 1',
#                            'Connection: keep-alive'
#    );
#    
#    if ($cookie_header) $httpheader[ ] = $cookie_header;
#    
#    $pattern_file = '{^(.+?)\\.[^\\.]+$}i';
#    preg_match($pattern_file, $file, $match);
#    $file_header = $match[1] . '.header';
#    $file_info   = $match[1] . '.info';
#    $file_cookie = $match[1] . '.cookie';
#    
#    $i = 0;
#    do {
#        $i++;
#        $check = FALSE;
#        if (isset ($_SERVER['COMSPEC'])) $file_header = mb_convert_encoding($file_header, 'windows-1251', 'UTF-8');
#        $f_header_func = fopen($file_header, 'wt');
#        if (isset ($_SERVER['COMSPEC'])) $file_header = mb_convert_encoding($file_header, 'UTF-8', 'windows-1251');
#        $ch_func = curl_init( );
#        
#        curl_setopt($ch_func, CURLOPT_URL, $url);
#        if (mb_strlen($ref)) curl_setopt($ch_func, CURLOPT_REFERER, $ref);
#        curl_setopt($ch_func, CURLOPT_USERAGENT, $useragent);
#        curl_setopt($ch_func, CURLOPT_HTTPHEADER, $httpheader);
#        curl_setopt($ch_func, CURLOPT_ENCODING, $encoding);
#        curl_setopt($ch_func, CURLOPT_WRITEHEADER, $f_header_func);
#        curl_setopt($ch_func, CURLOPT_HEADER, FALSE);
#        curl_setopt($ch_func, CURLOPT_RETURNTRANSFER, TRUE);
#        if ($curl_mode === 'b') curl_setopt($ch_func, CURLOPT_BINARYTRANSFER, TRUE);
#        if ($get_cookie) {
#            if (isset ($_SERVER['COMSPEC'])) $file_cookie = mb_convert_encoding($file_cookie, 'windows-1251', 'UTF-8');
#            curl_setopt($ch_func, CURLOPT_COOKIEJAR, $file_cookie);
#            if (isset ($_SERVER['COMSPEC'])) $file_cookie = mb_convert_encoding($file_cookie, 'UTF-8', 'windows-1251');
#        }
#        if (mb_strlen($cookie)) {
#            if (isset ($_SERVER['COMSPEC'])) $cookie = mb_convert_encoding($cookie, 'windows-1251', 'UTF-8');
#            curl_setopt($ch_func, CURLOPT_COOKIEFILE, $cookie);
#            if (isset ($_SERVER['COMSPEC'])) $cookie = mb_convert_encoding($cookie, 'UTF-8', 'windows-1251');
#        }
#        if (count($post_data)) {
#            curl_setopt($ch_func, CURLOPT_POST, TRUE);
#            curl_setopt($ch_func, CURLOPT_POSTFIELDS, $post_data);
#        }
#        curl_setopt($ch_func, CURLOPT_AUTOREFERER, TRUE);
#        curl_setopt($ch_func, CURLOPT_FOLLOWLOCATION, TRUE);
#        curl_setopt($ch_func, CURLOPT_MAXREDIRS, 7);
#        curl_setopt($ch_func, CURLOPT_CONNECTTIMEOUT, 600);
#        
#        $content = curl_exec($ch_func);
#        if ($curl_mode === 't') $content_for_charset = my_string_in_line($content);
#        $time = date('Y-m-d H:i:s');
#        curl_close($ch_func);
#        fclose($f_header_func);
#        
#        if (isset ($_SERVER['COMSPEC'])) $file_header = mb_convert_encoding($file_header, 'windows-1251', 'UTF-8');
#        $f_header_func = fopen($file_header, 'rt');
#        $lines = array ( );
#        if (filesize($file_header)) $lines = explode("\n", fread($f_header_func, filesize($file_header)));
#        fclose($f_header_func);
#        if (isset ($_SERVER['COMSPEC'])) $file_header = mb_convert_encoding($file_header, 'UTF-8', 'windows-1251');
#        
#        $charset = '';
#        $content_type = '';
#        $pattern_charset_header = '{charset\\s*=\\s*(.+)$}i';
#        $pattern_content_type_header = '{Content-Type:\\s+([a-z0-9-\\./]+)}i';
#        foreach ($lines as $string) {
#            if (mb_stripos($string, ' 200 OK') !== FALSE) {
#                if ($check_200_OK) $check = TRUE;
#            }
#            else {
#                if (preg_match($pattern_content_type_header, $string, $match)) {
#                    $content_type = $match[1];
#                    $content_type = trim($content_type);
#                    $content_type = mb_strtolower($content_type);
#                }
#                if (preg_match($pattern_charset_header, $string, $match)) {
#                    $charset = $match[1];
#                    $charset = trim($charset);
#                    if (mb_strpos($charset, '"') !== FALSE) $charset = str_replace('"', '', $charset);
#                    if (mb_strpos($charset, "'") !== FALSE) $charset = str_replace("'", '', $charset);
#                    if (mb_strpos($charset, "\\") !== FALSE) $charset = str_replace("\\", '', $charset);
#                    
#                    $charset = mb_strtolower($charset);
#                    $charset = trim($charset);
#                }
#            }
#        }
#        if (!$check_200_OK) $check = TRUE;
#        
#        if (($check_end === TRUE) && ($check === TRUE) && ($curl_mode === 't')) {
#            if (mb_stripos($content_for_charset, '</html>') === FALSE) {
#                $pattern_first_tag = '{<([^\\?\\s>]+)}i';
#                if (preg_match($pattern_first_tag, $content_for_charset, $match)) {
#                    if (mb_strlen($match[1])) {
#                        $pattern_last_tag = '{</' . $match[1] . '>$}i';
#                        if (!preg_match($pattern_last_tag, $content_for_charset)) $check = FALSE;
#                    }
#                }
#            }
#        }
#    }
#    while (($check === FALSE) && ($i <= $repeat));
#    
#    if ($check === TRUE) {
#        if ($curl_mode === 't') {
#            if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
#            $f_func = fopen($file, 'wt');
#            if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
#            
/*
            $pattern_charset_content_html = '{<meta\\s+[^>]*?charset\\s*=\\s*([^>\\s]+)[^>]*?>}i';
*/
#            $pattern_charset_content_xml = '{<\\?xml\\s[^>]*?encoding\\s*=\\s*["\']{0,1}([a-z0-9-]+)["\']{0,1}[^>]*>}i';
#            if (mb_strlen($charset) === 0) {
#                if (preg_match($pattern_charset_content_html, $content_for_charset, $match)) {
#                    $charset = $match[1];
#                    $charset = trim($charset);
#                    if (mb_strpos($charset, '"') !== FALSE) $charset = str_replace('"', '', $charset);
#                    if (mb_strpos($charset, "'") !== FALSE) $charset = str_replace("'", '', $charset);
#                    if (mb_strpos($charset, "\\") !== FALSE) $charset = str_replace("\\", '', $charset);
#                    
#                    $charset = mb_strtolower($charset);
#                    $charset = trim($charset);
#                }
#                elseif (preg_match($pattern_charset_content_xml, $content_for_charset, $match)) {
#                    $charset = $match[1];
#                    $charset = trim($charset);
#                    if (mb_strpos($charset, '"') !== FALSE) $charset = str_replace('"', '', $charset);
#                    if (mb_strpos($charset, "'") !== FALSE) $charset = str_replace("'", '', $charset);
#                    if (mb_strpos($charset, "\\") !== FALSE) $charset = str_replace("\\", '', $charset);
#                    
#                    $charset = mb_strtolower($charset);
#                    $charset = trim($charset);
#                }
#            }
#        }
#        else {
#            if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
#            $f_func = fopen($file, 'wb');
#            if (isset ($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
#        }
#        fwrite($f_func, $content);
#        fclose($f_func);
#        
#        $str_info =   'own_url' . "\t" . $url . "\n"
#                    . 'base_url' . "\t" . $base_url . "\n"
#                    . 'time' . "\t" . $time . "\n";
#        
#        if (mb_strlen($content_type)) $str_info .= 'content_type' . "\t" . $content_type . "\n";
#        
#        if (mb_strlen($charset)) $str_info .= 'charset' . "\t" . $charset . "\n";
#        
#        if (isset ($_SERVER['COMSPEC'])) $file_info = mb_convert_encoding($file_info, 'windows-1251', 'UTF-8');
#        $f_info_func = fopen($file_info, 'wt');
#        if (isset ($_SERVER['COMSPEC'])) $file_info = mb_convert_encoding($file_info, 'UTF-8', 'windows-1251');
#        
#        fwrite($f_info_func, $str_info);
#        fclose($f_info_func);
#    }
#    else {
#        if (isset ($_SERVER['COMSPEC'])) {
#            $file_header = mb_convert_encoding($file_header, 'windows-1251', 'UTF-8');
#            $file_cookie = mb_convert_encoding($file_cookie, 'windows-1251', 'UTF-8');
#        }
#        if (is_file($file_header)) @unlink($file_header);
#        if (is_file($file_cookie)) @unlink($file_cookie);
#        if (isset ($_SERVER['COMSPEC'])) {
#            $file_header = mb_convert_encoding($file_header, 'UTF-8', 'windows-1251');
#            $file_cookie = mb_convert_encoding($file_cookie, 'UTF-8', 'windows-1251');
#        }
#    }
#    
#    if ($check === TRUE) {
#        if (isset ($_SERVER['COMSPEC'])) {
#            $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
#            $file_header = mb_convert_encoding($file_header, 'windows-1251', 'UTF-8');
#            $file_cookie = mb_convert_encoding($file_cookie, 'windows-1251', 'UTF-8');
#            $file_info = mb_convert_encoding($file_info, 'windows-1251', 'UTF-8');
#        }
#        if (file_exists($file)) @chmod($file, 0777);
#        if (file_exists($file_header)) @chmod($file_header, 0777);
#        if (file_exists($file_cookie)) @chmod($file_cookie, 0777);
#        if (file_exists($file_info)) @chmod($file_info, 0777);
#        
#        if (isset ($_SERVER['COMSPEC'])) {
#            $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
#            $file_header = mb_convert_encoding($file_header, 'UTF-8', 'windows-1251');
#            $file_cookie = mb_convert_encoding($file_cookie, 'UTF-8', 'windows-1251');
#            $file_info = mb_convert_encoding($file_info, 'UTF-8', 'windows-1251');
#        }
#        
#        if ($output_type === 'content') {
#            $result = $content;
#        }
#        elseif ($output_type === 'files') {
#            $result = array (
#                                'file'   =>   $file,
#                                'header' =>   $file_header,
#                                'cookie' =>   $file_cookie,
#                                'info'   =>   $file_info
#            );
#        }
#        elseif ($output_type === 'check') {
#            $result = $check;
#        }
#    }
#    else $result = $check;
#    
#    return $result;
#}

function my_get_base_url($url) {
    
    $result = '';
    
    $url = trim($url);
    
    $pattern_base_url = '{^(http://([^/]+))}i';
    if (preg_match($pattern_base_url, $url, $match)) {
        $result = $match[1];
    }
    
    return $result;
}

function my_curl_request($url, $User_Agent, $HTTP_Headers, $request_mode /* 'temp' || 'normal' */, $file_place /* array('temp_dir' => '', 'file' => '') */, $referer = false /* 'base_url' || $url */, $curl_mode = '' /* 't' || 'b' */, $output_type = 'files' /* 'check' || 'content' */, $temp_file_info = '', $get_cookie = false, $cookie = '', $post_data = array( ), $cookie_header = false) {
    
    $result = false;
    
    $check = false;
    
    $error = false;
    $error_log = array( );
    
    $info = array( );
    
    $url = trim($url);
    
    if (mb_strlen($url) && (preg_match('{\s}', $url) === 0)) {
        
        $file = '';
        
        if ($request_mode === 'temp') {
            if (mb_strlen($file_place['temp_dir'])) {
                $file = my_random_file($file_place['temp_dir'], 'temp_');
            }
            else {
                $error = true;
                $error_log[ ] = 'При REQUEST_MODE равном TEMP передано пустое имя директории TEMP_DIR для сохранения файлов';
            }
        }
        elseif ($request_mode === 'normal') {
            if (mb_strlen($file_place['file'])) {
                $file = $file_place['file'];
            }
            else {
                $error = true;
                $error_log[ ] = 'При REQUEST_MODE равном NORMAL передано пустое имя файла FILE';
            }
        }
        else {
            $error = true;
            $error_log[ ] = 'REQUEST_MODE может быть равен только TEMP или NORMAL';
        }
        
        if (mb_strlen($file)) {
            
            $file_header = $file . '.header';
            $file_error = $file . '.error';
            $file_cookie = $file . '.cookie';
            $file_info = $file . '.info';
            
            if (mb_substr($url, 0, 7) === 'http://') {
                
                $pattern_host = '{^(http://([^/]+))}i';
                if (preg_match($pattern_host, $url, $match)) {
                    $host = $match[2];
                    $base_url = $match[1];
                    
                    if ($referer === 'base_url') $referer = $base_url . '/';
                    
                    $HTTP_Headers[0] = 'Host: ' . $host;
                    if ($cookie_header) $HTTP_Headers[ ] = $cookie_header;
                    
                    $i = 0;
                    do {
                        $i++;
                        
                        if (isset($_SERVER['COMSPEC'])) $file_header = mb_convert_encoding($file_header, 'windows-1251', 'UTF-8');
                        $f_header = fopen($file_header, 'wt');
                        if (isset($_SERVER['COMSPEC'])) $file_header = mb_convert_encoding($file_header, 'UTF-8', 'windows-1251');
                        
                        if (isset($_SERVER['COMSPEC'])) $file_error = mb_convert_encoding($file_error, 'windows-1251', 'UTF-8');
                        $f_error = fopen($file_error, 'wt');
                        if (isset($_SERVER['COMSPEC'])) $file_error = mb_convert_encoding($file_error, 'UTF-8', 'windows-1251');
                        
                        $ch = curl_init($url);
                        
                        if ($referer) curl_setopt($ch, CURLOPT_REFERER, $referer);
                        curl_setopt($ch, CURLOPT_USERAGENT, $User_Agent);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $HTTP_Headers);
                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                        curl_setopt($ch, CURLOPT_MAXREDIRS, 77);
                        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
                        curl_setopt($ch, CURLOPT_HEADER, false);
                        curl_setopt($ch, CURLOPT_WRITEHEADER, $f_header);
                        curl_setopt($ch, CURLOPT_VERBOSE, true);
                        curl_setopt($ch, CURLOPT_STDERR, $f_error);
                        if ($request_mode === 'temp') {
                            curl_setopt($ch, CURLOPT_NOBODY, true);
                        }
                        elseif ($request_mode === 'normal') {
                            curl_setopt($ch, CURLOPT_ENCODING, 'identity');
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            if ($curl_mode === 'b') curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
                            if ($get_cookie) {
                                if (isset($_SERVER['COMSPEC'])) $file_cookie = mb_convert_encoding($file_cookie, 'windows-1251', 'UTF-8');
                                curl_setopt($ch, CURLOPT_COOKIEJAR, $file_cookie);
                                if (isset($_SERVER['COMSPEC'])) $file_cookie = mb_convert_encoding($file_cookie, 'UTF-8', 'windows-1251');
                            }
                            if (mb_strlen($cookie)) {
                                if (isset($_SERVER['COMSPEC'])) $cookie = mb_convert_encoding($cookie, 'windows-1251', 'UTF-8');
                                curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
                                if (isset($_SERVER['COMSPEC'])) $cookie = mb_convert_encoding($cookie, 'UTF-8', 'windows-1251');
                            }
                            if (count($post_data)) {
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
                            }
                        }
                        
                        $content = curl_exec($ch);
                        
                        curl_close($ch);
                        
                        fclose($f_header);
                        
                        fclose($f_error);
                        
                        $header_lines = my_file_to_array($file_header);
                        
                        if (count($header_lines)) $check = true;
                        
                        if ($check) {
                            $status = '000';
                            $pattern_status = '{\\s(\\d{3})}';
                            foreach ($header_lines as $header_line) {
                                if (mb_substr($header_line, 0, 5) === 'HTTP/') {
                                    if (preg_match($pattern_status, $header_line, $match)) $status = $match[1];
                                }
                            }
                            
                            $charset = '';
                            $content_type = '';
                            $pattern_content_type_header = '{Content-Type:\\s+([a-z0-9-\\./]+)}i';
                            $pattern_charset_header = '{charset\\s*=\\s*(.+)$}i';
                            foreach ($header_lines as $header_line) {
                                if (preg_match($pattern_content_type_header, $header_line, $match)) {
                                    $content_type = $match[1];
                                    $content_type = trim($content_type);
                                    $content_type = mb_strtolower($content_type);
                                }
                                if (preg_match($pattern_charset_header, $header_line, $match)) {
                                    $charset = $match[1];
                                    $charset = trim($charset);
                                    if (mb_strpos($charset, '"') !== FALSE) $charset = str_replace('"', '', $charset);
                                    if (mb_strpos($charset, "'") !== FALSE) $charset = str_replace("'", '', $charset);
                                    if (mb_strpos($charset, "\\") !== FALSE) $charset = str_replace("\\", '', $charset);
                                    
                                    $charset = mb_strtolower($charset);
                                    $charset = trim($charset);
                                }
                            }
                            
                            $info['status'] = $status;
                            $info['own_url'] = $url;
                            $info['base_url'] = $base_url;
                            if ($referer !== false) $info['referer'] = $referer;
                            if (mb_strlen($content_type)) $info['content_type'] = $content_type;
                            if (mb_strlen($charset)) $info['charset_header'] = $charset;
                            
                            if ($request_mode === 'temp') {
                                my_array_to_file($info, $file_info);
                            }
                            elseif ($request_mode === 'normal') {
                                
                                $check_info = true;
                                
                                if (mb_strlen($temp_file_info)) {
                                    $temp_info = my_info_array($temp_file_info);
                                    if (($info['status'] !== $temp_info['status']) || ($info['own_url'] !== $temp_info['own_url'])) $check_info = false;
                                }
                                
                                if ($check_info) {
                                    my_array_to_file($info, $file_info);
                                    
                                    if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
                                    if ($curl_mode === 't') {
                                        $f = fopen($file, 'wt');
                                    }
                                    else {
                                        $f = fopen($file, 'wb');
                                    }
                                    if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
                                    
                                    fwrite($f, $content);
                                    fclose($f);
                                }
                            }
                        }
                    }
                    while (($check === false) && ($i <= 100));
                    
                    if ($check === false) {
                        $error = true;
                        $error_log[ ] = 'Похоже, нет выхода в сеть';
                    }
                }
            }
            else {
            /* возможно придется данную часть приспосабливать для работы с 'https://' или другими протоколами */
                $error = true;
                $error_log[ ] = 'Ссылка передается по протоколу, отличному от HTTP://';
            }
        }
        else {
            $error = true;
            $error_log[ ] = 'В программу передано пустое имя файла FILE';
        }
    }
    
    if ($check) {
/*
        if (isset($_SERVER['COMSPEC'])) {
            $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
            $file_header = mb_convert_encoding($file_header, 'windows-1251', 'UTF-8');
            $file_error = mb_convert_encoding($file_error, 'windows-1251', 'UTF-8');
            $file_cookie = mb_convert_encoding($file_cookie, 'windows-1251', 'UTF-8');
            $file_info = mb_convert_encoding($file_info, 'windows-1251', 'UTF-8');
        }
        
        if (file_exists($file)) @chmod($file, 0777);
        if (file_exists($file_header)) @chmod($file_header, 0777);
        if (file_exists($file_error)) @chmod($file_error, 0777);
        if (file_exists($file_cookie)) @chmod($file_cookie, 0777);
        if (file_exists($file_info)) @chmod($file_info, 0777);
        
        if (isset($_SERVER['COMSPEC'])) {
            $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
            $file_header = mb_convert_encoding($file_header, 'UTF-8', 'windows-1251');
            $file_error = mb_convert_encoding($file_error, 'UTF-8', 'windows-1251');
            $file_cookie = mb_convert_encoding($file_cookie, 'UTF-8', 'windows-1251');
            $file_info = mb_convert_encoding($file_info, 'UTF-8', 'windows-1251');
        }
*/
        if ($output_type === 'files') {
            $result = array (
                             'file'         =>   $file,
                             'file_header'  =>   $file_header,
                             'file_error'   =>   $file_error,
                             'file_cookie'  =>   $file_cookie,
                             'file_info'    =>   $file_info
                            );
        }
        elseif ($output_type === 'check') {
            $result = $check; /* TRUE */
        }
        elseif ($output_type === 'content') {
            $result = $content;
        }
    }
    
#    if ($error) $result = array( 'error' => $error, 'error_log' => $error_log );
    
    return $result;
}

/* УСТАРЕЛО */
function my_curl_request_deeper($num_of_row, $structura_file, $filename_temp = TRUE) {
    
    $result = $num_of_row + 1;
    
    $index = $num_of_row - 1;
    $refer_index = $index - 1;
    
    $dir = dirname($structura_file);
    
    if (file_exists($structura_file) && filesize($structura_file)) {
        $structura = my_check_structura_file($structura_file);
        if (($num_of_row > 0) && count($structura) && isset ($structura['url'])) {
            $strs = my_read_row_structura_file($structura_file, $num_of_row);
            $urls = my_read_col_structura_file($structura_file, $structura['url']);
            $new_strs = array ( );
            $new_strs_index = 0;
            if (count($urls) && isset ($urls[$index])) {
                
                if (isset ($structura['id'])) $strs['id'] = $num_of_row;
                
                $url = $urls[$index];
                
                if ($refer_index < 0) {
                    $refer = FALSE;
                }
                else $refer = $urls[$refer_index];
                
                if ($filename_temp) {
                    $filename = 'temp.html';
                }
                else {
                    $pattern_filename1 = '{([^/]+htm)l?$}i';
                    $replace_filename1 = '$1l';
                    $pattern_filename2 = '{(^|/)([^/]+)/?$}i';
                    $filename = 'page_unknown.html';
                    if (preg_match($pattern_filename1, $url, $match)) {
                        if (mb_strlen($match[1])) $filename = preg_replace($pattern_filename1, $replace_filename1, $match[1]);
                    }
                    elseif (preg_match($pattern_filename2, $url, $match)) {
                        if (mb_strlen($match[2])) {
                            $filename = str_replace('.', '__DOT__', $match[2]);
                            $filename .= '.html';
                        }
                    }
                    if (mb_strpos($filename, '%') !== FALSE) $filename = urldecode($filename);
                    if (mb_strpos($filename, ' ') !== FALSE) $filename = str_replace(' ', '_', $filename);
                    if (isset ($_SERVER['COMSPEC'])) $filename = mb_convert_encoding($filename, 'windows-1251');
                }
                $file = $dir . DIRECTORY_SEPARATOR . $filename;
                
                if (isset ($structura['filename'])) $strs['filename'] = $filename;
                if (isset ($structura['file'])) $strs['file'] = $file;
                
                if (my_curl_request($url, $file, TRUE, TRUE, 'content', 'identity', 't', $refer, 10)) {
                    
                    $info = my_info_array($file);
                    
                    $charset = 'utf-8';
                    if (isset ($info['encoding'])) {
                        $charset = $info['encoding'];
                    }
                    elseif (isset ($info['charset'])) {
                        $charset = $info['charset'];
                    }
                    
                    if (my_file_in_utf8_4phpquery($file, $charset)) {
                        if (isset ($document)) unset ($document);
                        $document = phpQuery::newDocumentFile($file);
                        $title_tag = $document->find('title');
                        $title = '';
                        foreach ($title_tag as $title_tag) {
                            $title_tag = pq($title_tag);
                            $title = $title_tag->text( );
                        }
                        if (mb_strlen($title)) {
                            if (mb_strpos($title, "\t") !== FALSE) $title = str_replace("\t", ' ', $title);
                            if (isset ($structura['title'])) $strs['title'] = $title;
                            if (isset ($structura['anchor'])) {
                                if (mb_strlen($strs['anchor']) === 0) $strs['anchor'] = $title;
                            }
                        }
/* ---------------   начало редактируемой части   --------------- */
                        $pattern_counting = '{\\(?(\\d+)\\)?}';
                        if (isset ($document)) unset ($document);
                        $document = phpQuery::newDocumentFile($file);
                        if (isset ($structura['counting'])) {
                            $headers = $document->find('h2.news');
                            foreach ($headers as $header) {
                                $header = pq($header);
                                $text = $header->text( );
                                if (mb_substr($text, 0, 13) === 'Каталог фирм ') {
                                    $strs['counting'] = 0;
                                    $ps = $header;
                                    do {
                                        $ps = $ps->next('p');
                                        foreach ($ps as $p) {
                                            $p = pq($p);
                                            $text = $p->text( );
                                            if (preg_match($pattern_counting, $text, $match)) {
                                                if (mb_strlen($match[1])) $strs['counting'] += (int)$match[1];
                                            }
                                        }
                                    }
                                    while (count($ps));
                                }
                            }
                        }
                        $mainpart = $document->find('table[cellspacing="20"] td[width="180"]');
                        $mainpart = (string)$mainpart;
                        $mainpart = my_string_in_line($mainpart);
                        $pattern_mainpart = '{((?=<p><a).*(?=<ul>))}i';
                        if (preg_match($pattern_mainpart, $mainpart, $match)) {
                            if (mb_strlen($match[1])) {
                                if (isset ($document)) unset ($document);
                                $document = phpQuery::newDocument($match[1]);
                                $anchors = $document->find('a');
/* особое внимание */           foreach ($anchors as $anchor) {
                                    $anchor = pq($anchor);
                                    $href = $anchor->attr('href');
                                    $href = my_normalize_url($href, $info['base_url'], TRUE, $info['base_url']);
                                    if (array_search($href, $urls) === FALSE) {
                                        $text = $anchor->text( );
                                        if (mb_strpos($text, "\t") !== FALSE) $text = str_replace("\t", ' ', $text);
                                        $p = $anchor->parent('p');
                                        foreach ($p as $p) {
                                            $p = pq($p);
                                            $p = $p->text( );
                                            if (preg_match($pattern_counting, $p, $match)) {
                                                if (mb_strlen($match[1])) {
                                                    if (isset ($structura['counting'])) $new_strs[$new_strs_index]['counting'] = (int)$match[1];
                                                }
                                            }
                                        }
                                        if (isset ($structura['level']) && ($strs['level'] >= 0)) $new_strs[$new_strs_index]['level'] = $strs['level'] + 1;
                                        if (isset ($structura['parent']) && mb_strlen($strs['id'])) $new_strs[$new_strs_index]['parent'] = $strs['id'];
                                        if (isset ($structura['url']) && mb_strlen($href)) $new_strs[$new_strs_index]['url'] = $href;
                                        if (isset ($structura['anchor']) && mb_strlen($text)) $new_strs[$new_strs_index]['anchor'] = $text;
                                        $new_strs_index++;
                                    }
                                }
                            }
                        }
/* ---------------   конец редактируемой части   --------------- */
                    }
                }
            }
            
            $data_rewrite = array ( );
            if (count($strs)) $data_rewrite[ ] = $strs;
            if (count($data_rewrite)) my_write_structura_file($structura_file, $num_of_row, $data_rewrite);
            
            if (count($new_strs)) my_write_structura_file($structura_file, $num_of_row, $new_strs, 'write');
        }
    }
    
    return $result;
}

function my_dynamic_link_transform($link) {
    
    $result = '';
    
    if ((mb_substr($link, -1) === '?') || (mb_substr($link, -1) === '#')) $link = mb_substr($link, 0, -1);
    
    $pattern_dynamic_link = '{(\\?)|(\\|)|(\\\\)|(:[^/])|(\\*)|(\")|(<)|(>)}';
    if (preg_match($pattern_dynamic_link, $link)) {
        
        $pattern_colon = '{:([^/])}';
        $replace_colon = '__CLN__$1';
        if (preg_match($pattern_colon, $link)) $link = preg_replace($pattern_colon, $replace_colon, $link);
        
        if (mb_strpos($link, '?') !== FALSE) $link = str_replace('?', '__QES__', $link);
        if (mb_strpos($link, '|') !== FALSE) $link = str_replace('|', '__VLN__', $link);
        if (mb_strpos($link, "\\") !== FALSE) $link = str_replace("\\", '__BSL__', $link);
        if (mb_strpos($link, '*') !== FALSE) $link = str_replace('*', '__ATR__', $link);
        if (mb_strpos($link, '"') !== FALSE) $link = str_replace('"', '__QTT__', $link);
        if (mb_strpos($link, '<') !== FALSE) $link = str_replace('<', '__LES__', $link);
        if (mb_strpos($link, '>') !== FALSE) $link = str_replace('>', '__GRT__', $link);
    }
    
    $result = $link;
    
    return $result;
}

/* УСТАРЕЛО */
function my_curl_request_folder($url, $dir, $etalon = true) {
    
    $result = array (
                     'base_dir' => '',
                     'temp_dir' => '',
                     'base_dir_etalon' => '',
                     'site_dir' => '',
                     'site_dir_etalon' => ''
/*
                     ,
                     'filename' => ''
*/
                    );
    
    $dir = my_path($dir);
    
    if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'windows-1251', 'UTF-8');
    if (file_exists($dir) && is_dir($dir)) {
        if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
        
        $url = trim($url);
        
        if (mb_strlen($url) && (preg_match('{\s}', $url) === 0)) {
            
            $pattern_host = '{^(((https?:)?//)?([^/]+))}i';
            $base_folder = '';
            if (preg_match($pattern_host, $url, $match)) $base_folder = $match[1];
            
            if (mb_strlen($base_folder)) {
                $pattern_site_folder = '{([^/]+)$}';
                if (preg_match($pattern_site_folder, $base_folder, $match)) {
                    $domen = $match[1];
                    $base_dir = $dir . DIRECTORY_SEPARATOR . $domen;
                    $base_dir = my_make_dirs($base_dir);
                    $site_dir = $base_dir;
                    $temp_dir = $dir . DIRECTORY_SEPARATOR . $domen . '__temp';
                    $temp_dir = my_make_dirs($temp_dir);
                    
                    if ($etalon) {
                        $base_dir_etalon = $dir . DIRECTORY_SEPARATOR . $domen . '__etalon';
                        $base_dir_etalon = my_make_dirs($base_dir_etalon);
                        $site_dir_etalon = $base_dir_etalon;
                    }
                    
                    $base_folder_length = mb_strlen($base_folder);
                    $link = mb_substr($url, $base_folder_length);
/*
                    if (mb_strpos($link, '?') !== FALSE) $link = str_replace('?', '__QES__', $link);
                    if (mb_strpos($link, '=') !== FALSE) $link = str_replace('=', '__EQU__', $link);
                    if (mb_strpos($link, '&') !== FALSE) $link = str_replace('&', '__AMP__', $link);
                    if (mb_strpos($link, '#') !== FALSE) $link = str_replace('#', '__OKT__', $link);
                    if (mb_strpos($link, '+') !== FALSE) $link = str_replace('+', '__PLS__', $link);
*/
                    $filename = '';
                    $dirpath = '';
                    $pattern_dir_end = '{/[^/\\.]+$}i';
                    
                    if (mb_strlen($link) <= 1 ) {
                        $filename = 'index.html';
                    }
                    elseif ((mb_substr($link, -1) === '/') && (mb_strlen($link) > 2)) {
                        $filename = 'index.html';
                        $dirpath = mb_substr($link, 1, -1);
                    }
                    elseif (preg_match($pattern_dir_end, $link)) {
                        $filename = 'index.html';
                        $dirpath = mb_substr($link, 1);
                    }
                    else {
                        $pattern_dynamic_link = '{\\?|=|&|#|\\+}';
                        if (preg_match($pattern_dynamic_link, $link) === 0) {
                            $pattern_filename = '{([^/]+)$}i';
                            if (preg_match($pattern_filename, $link, $match)) {
                                $filename = $match[1];
                                $filename_length = -1*(mb_strlen($filename) + 1);
                                $dirpath = mb_substr($link, 1, $filename_length);
                            }
                        }
#                       else { необходимо придумать, что делать с динамическими страницами }
                    }
                    
                    if (mb_strlen($dirpath)) {
                        if (mb_strlen($site_dir)) $site_dir = my_make_dirs($site_dir, $dirpath);
                        if ($etalon && mb_strlen($site_dir_etalon)) $site_dir_etalon = my_make_dirs($site_dir_etalon, $dirpath);
                    }
                    
                    if (mb_strlen($site_dir)) {
                        $result['base_dir'] = $base_dir;
                        $result['temp_dir'] = $temp_dir;
                        $result['site_dir'] = $site_dir;
                        if ($etalon) {
                            if (mb_strlen($base_dir_etalon)) $result['base_dir_etalon'] = $base_dir_etalon;
                            if (mb_strlen($site_dir_etalon)) $result['site_dir_etalon'] = $site_dir_etalon;
                        }
#                        if (mb_strlen($filename)) $result['filename'] = $filename;
                    }
                }
            }
        }
    }
    else {
        if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
    }
    
    return $result;
}

/* УСТАРЕЛО */
function my_curl_request_filename($url, $content_type, $site_dir, $site_dir_etalon = '') {
    
    $result = array (
                     'file' => '',
                     'curl_mode' => '',
                     'error' => false,
                     'warning' => '',
                     'file_etalon' => ''
                    );
    
    $file = '';
    $curl_mode = '';
    $error = false;
    $warning = '';
    $file_etalon = '';
    
    $pattern_content_type = '{^([^/]+)/([^/]+)$}';
    $extension = '.';
    if (preg_match($pattern_content_type, $content_type, $match)) {
        if ($match[1] === 'text') {
            $curl_mode = 't';
        }
        else {
            $curl_mode = 'b';
        }
        if ($content_type === 'text/plain') {
            $extension .= 'txt';
        }
        else {
            if ($match[2] === 'jpeg') {
                $extension .= 'jpg';
            }
            elseif (mb_substr($match[2], -10) === 'javascript') {
                $curl_mode = 't';
                $extension .= 'js';
            }
            else {
                $extension .= $match[2];
            }
        }
    }
    else {
        $curl_mode = 'b';
        $extension .= 'unknown';
        $error = true;
        $warning = 'Не определен curl_mode или не найден тип-расширение файла';
    }
    
    $url = trim($url);
    
    if (mb_strlen($url) && (preg_match('{\s}', $url) === 0)) {
        $pattern_host = '{^(((https?:)?//)?([^/]+))}i';
        if (preg_match($pattern_host, $url, $match)) {
            
            $base_url = $match[1];
            
            $base_url_length = mb_strlen($base_url);
            $link = mb_substr($url, $base_url_length);
            
            $filename = '';
            $pattern_dir_end = '{/[^/\\.]+$}i';
            
            if ((mb_strlen($link) <= 1) || ((mb_substr($link, -1) === '/') && (mb_strlen($link) > 2)) || preg_match($pattern_dir_end, $link)) {
                $filename = 'index' . $extension;
                if ($extension !== '.html') {
                    $error = true;
                    $warning = 'Ожидалось расширение файла .html';
                }
            }
            else {
                $pattern_dynamic_link = '{\\?|=|&|#|\\+|,}';
                if (preg_match($pattern_dynamic_link, $link) === 0) {
                    $pattern_filename = '{([^/]+)$}i';
                    if (preg_match($pattern_filename, $link, $match)) {
                        $filename = $match[1];
                        $pattern_filename_extension = '{(\\.[^\\.]+)$}';
                        if (preg_match($pattern_filename_extension, $filename, $match)) {
                            $match[1] = mb_strtolower($match[1]);
                            if ($match[1] !== $extension) {
                                $error = true;
                                $warning = 'Реальное расширение файла не совпадает с данными Content-Type в Заголовках';
                            }
                        }
                    }
                }
                else {
                    $error = true;
                    $warning = 'Внимание! Используется динамическая ссылка';
                    
                    $pattern_filename = '{([^/]+)$}i';
                    if (preg_match($pattern_filename, $link, $match)) {
                        
                        $filename = $match[1];
                        
                        if (mb_strpos($filename, '.') !== FALSE) $filename = str_replace('.', '__PNT__', $filename);
                        if (mb_strpos($filename, '?') !== FALSE) $filename = str_replace('?', '__QES__', $filename);
                        if (mb_strpos($filename, '=') !== FALSE) $filename = str_replace('=', '__EQU__', $filename);
                        if (mb_strpos($filename, '&') !== FALSE) $filename = str_replace('&', '__AMP__', $filename);
                        if (mb_strpos($filename, '#') !== FALSE) $filename = str_replace('#', '__OKT__', $filename);
                        if (mb_strpos($filename, '+') !== FALSE) $filename = str_replace('+', '__PLS__', $filename);
                        if (mb_strpos($filename, ',') !== FALSE) $filename = str_replace(',', '__CMM__', $filename);
                    }
                    
                    if (mb_strlen($filename)) $filename .= $extension;
                }
            }
            
            if (mb_strlen($filename)) {
                $file = $site_dir . DIRECTORY_SEPARATOR . $filename;
                if (mb_strlen($site_dir_etalon)) $file_etalon = $site_dir_etalon . DIRECTORY_SEPARATOR . $filename;
            }
            else {
                $file = my_random_file($site_dir, 'temp_');
                if (mb_strlen($file)) $file .= $extension;
                $error = true;
                $warning = 'Имя файла из ссылки не определено и сгенерировано случайным образом';
            }
        }
    }
    
    $result['file'] = $file;
    $result['curl_mode'] = $curl_mode;
    $result['error'] = $error;
    if ($error) $result['warning'] = $warning;
    if (mb_strlen($file_etalon)) $result['file_etalon'] = $file_etalon;
    
    return $result;
}

function my_curl_create_base_dirs($url, $dir, $etalon = true, $remove_dirs = false) {
    
    $result = array (
                     'base_url' => '',
                     'base_dir' => '',
                     'temp_dir' => '',
                     'base_dir_etalon' => ''
                    );
    
    $result_base_url = '';
    $result_base_dir = '';
    $result_temp_dir = '';
    $result_base_dir_etalon = '';
    
    $dir = my_path($dir);
    
    if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'windows-1251', 'UTF-8');
    if (file_exists($dir) && is_dir($dir)) {
        if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
        
        $url = trim($url);
        
        if (mb_strlen($url) && (preg_match('{\s}', $url) === 0)) {
            
            $pattern_host = '{^(((https?:)?//)?([^/]+))}i';
            if (preg_match($pattern_host, $url, $match)) $result_base_url = $match[1];
            
            if (mb_strlen($result_base_url)) {
                $pattern_site_folder = '{([^/]+)$}';
                if (preg_match($pattern_site_folder, $result_base_url, $match)) {
                    
                    $domen = $match[1];
                    
                    $base_dir = $dir . DIRECTORY_SEPARATOR . $domen;
                    
                    if ($remove_dirs) my_remove_dir($base_dir, $dir);
                    
                    if (isset($_SERVER['COMSPEC'])) $base_dir = mb_convert_encoding($base_dir, 'windows-1251', 'UTF-8');
                    if (!file_exists($base_dir)) {
                        if (isset($_SERVER['COMSPEC'])) $base_dir = mb_convert_encoding($base_dir, 'UTF-8', 'windows-1251');
                        
                        $result_base_dir = my_make_dirs($base_dir);
                    }
                    else {
                        if (isset($_SERVER['COMSPEC'])) $base_dir = mb_convert_encoding($base_dir, 'UTF-8', 'windows-1251');
                        $result_base_dir = $base_dir;
                    }
                    
                    $temp_dir = $dir . DIRECTORY_SEPARATOR . $domen . '__temp';
                    
                    if ($remove_dirs) my_remove_dir($temp_dir, $dir);
                    
                    if (isset($_SERVER['COMSPEC'])) $temp_dir = mb_convert_encoding($temp_dir, 'windows-1251', 'UTF-8');
                    if (!file_exists($temp_dir)) {
                        if (isset($_SERVER['COMSPEC'])) $temp_dir = mb_convert_encoding($temp_dir, 'UTF-8', 'windows-1251');
                        $result_temp_dir = my_make_dirs($temp_dir);
                    }
                    else {
                        if (isset($_SERVER['COMSPEC'])) $temp_dir = mb_convert_encoding($temp_dir, 'UTF-8', 'windows-1251');
                        $result_temp_dir = $temp_dir;
                    }
                    
                    if ($etalon) {
                        $base_dir_etalon = $dir . DIRECTORY_SEPARATOR . $domen . '__etalon';
                        
                        if ($remove_dirs) my_remove_dir($base_dir_etalon, $dir);
                        
                        if (isset($_SERVER['COMSPEC'])) $base_dir_etalon = mb_convert_encoding($base_dir_etalon, 'windows-1251', 'UTF-8');
                        if (!file_exists($base_dir_etalon)) {
                            if (isset($_SERVER['COMSPEC'])) $base_dir_etalon = mb_convert_encoding($base_dir_etalon, 'UTF-8', 'windows-1251');
                            $result_base_dir_etalon = my_make_dirs($base_dir_etalon);
                        }
                        else {
                            if (isset($_SERVER['COMSPEC'])) $base_dir_etalon = mb_convert_encoding($base_dir_etalon, 'UTF-8', 'windows-1251');
                            $result_base_dir_etalon = $base_dir_etalon;
                        }
                    }
                }
            }
        }
    }
    else {
        if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
    }
    
    if (mb_strlen($result_base_url) && mb_strlen($result_base_dir) && mb_strlen($result_temp_dir)) {
        $result['base_url'] = $result_base_url;
        $result['base_dir'] = $result_base_dir;
        $result['temp_dir'] = $result_temp_dir;
        $result['base_dir_etalon'] = $result_base_dir_etalon;
    }
    
    return $result;
}

function my_curl_request_dir_filename($url, $content_type, $dir, $etalon = true) {
    
    $result = array (
                     'site_dir' => '',
                     'site_dir_etalon' => '',
                     'filename' => '',
                     'dirpath' => '',
                     'curl_mode' => '',
                     'error' => false,
                     'error_log' => ''
                    );
    
    $result_site_dir = '';
    $result_site_dir_etalon = '';
    $result_filename = '';
    $result_dirpath = '';
    $result_curl_mode = '';
    $result_error = false;
    $result_error_log = array( );
    
    $dir = my_path($dir);
    
    if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'windows-1251', 'UTF-8');
    if (file_exists($dir) && is_dir($dir)) {
        if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
        
        $url = trim($url);
        
        if (mb_strlen($url) && (preg_match('{\s}', $url) === 0)) {
            $base_dirs = my_curl_create_base_dirs($url, $dir, $etalon);
            if (mb_strlen($base_dirs['base_url']) && mb_strlen($base_dirs['base_dir'])) {
                $base_url_length = mb_strlen($base_dirs['base_url']);
                if (mb_substr($url, 0, $base_url_length) === $base_dirs['base_url']) {
                    
                    $result_site_dir = $base_dirs['base_dir'];
                    $result_site_dir_etalon = $base_dirs['base_dir_etalon'];
                    
                    $link = mb_substr($url, $base_url_length);
                    $link = my_dynamic_link_transform($link);
                    
                    $pattern_content_type = '{^([^/]+)/([^/]+)$}';
                    $cont_ext = '.';
                    if (preg_match($pattern_content_type, $content_type, $match)) {
                        if ($match[1] === 'text') {
                            $result_curl_mode = 't';
                        }
                        else {
                            $result_curl_mode = 'b';
                        }
                        
                        if ($content_type === 'text/plain') {
                            $cont_ext .= 'txt';
                        }
                        else {
                            if ($match[2] === 'jpeg') {
                                $cont_ext .= 'jpg';
                            }
                            elseif (mb_substr($match[2], -10) === 'javascript') {
                                $result_curl_mode = 't';
                                $cont_ext .= 'js';
                            }
                            else {
                                $cont_ext .= $match[2];
                            }
                        }
                    }
                    else {
                        $result_curl_mode = 'b';
                        $cont_ext .= 'unknown';
                        
                        $result_error = true;
                        $result_error_log[ ] = 'Передан нестандартный CURL_MODE';
                    }
                    
                    $pattern_dir_end = '{/[^/\\.]+$}';
                    $pattern_filename_extension = '{(\\.[^\\.]+)$}';
                    $pattern_filename = '{([^/]+)$}';
                    
                    if (mb_strlen($link) < 2) {
                        if ((mb_strlen($link) === 0) || ($link === '/')) {
                            $result_filename = 'index' . $cont_ext;
                            
                            if ($cont_ext !== '.html') {
                                $result_error = true;
                                $result_error_log[ ] = 'Ожидалось расширение файла .html, а получено другое расширение файла';
                            }
                        }
                        else {
                            $result_error = true;
                            $result_error_log[ ] = 'Очень подозрительная ссылка, файл обработан по экзотическому варианту';
                            
                            if (mb_strpos($link, '/') !== false) $link = str_replace('/', '__SLSH__', $link);
                            $result_filename = $link;
                            if (preg_match($pattern_filename_extension, $result_filename, $match)) {
                                $match[1] = mb_strtolower($match[1]);
                                if ($match[1] !== $cont_ext) {
                                    if (mb_strpos($result_filename, '.') !== false) $result_filename = str_replace('.', '__DOT__', $result_filename);
                                    $result_filename .= $cont_ext;
                                    
                                    $result_error = true;
                                    $result_error_log[ ] = 'Реальное расширение файла не совпадает с данными Content-Type в Заголовках';
                                }
                            }
                            else {
                                $result_filename .= $cont_ext;
                            }
                        }
                    }
                    elseif ((mb_strlen($link) >= 2) && (mb_substr($link, 0, 1) === '/')) {
                        if (mb_substr($link, -1) === '/') {
                            $result_filename = 'index' . $cont_ext;
                            $result_dirpath = mb_substr($link, 1, -1);
                            
                            if ($cont_ext !== '.html') {
                                $result_error = true;
                                $result_error_log[ ] = 'Ожидалось расширение файла .html, а получено другое расширение файла';
                            }
                        }
                        elseif (preg_match($pattern_dir_end, $link)) {
                            if ($cont_ext === '.html') {
                                $result_filename = 'index' . $cont_ext;
                                $result_dirpath = mb_substr($link, 1);
                            }
                            else {
                                if (preg_match($pattern_filename, $link, $match)) {
                                    $result_filename = $match[1];
                                    
                                    $result_filename_length = -1*(mb_strlen($result_filename) + 1);
                                    $result_dirpath = mb_substr($link, 1, $result_filename_length);
                                    
                                    $result_filename .= $cont_ext;
                                }
                                else {
                                    $result_error = true;
                                    $result_error_log[ ] = 'Очень подозрительная ссылка, файл обработан по экзотическому варианту';
                                    
                                    if (mb_strpos($link, '/') !== false) $link = str_replace('/', '__SLSH__', $link);
                                    $result_filename = $link;
                                    if (preg_match($pattern_filename_extension, $result_filename, $match)) {
                                        $match[1] = mb_strtolower($match[1]);
                                        if ($match[1] !== $cont_ext) {
                                            if (mb_strpos($result_filename, '.') !== false) $result_filename = str_replace('.', '__DOT__', $result_filename);
                                            $result_filename .= $cont_ext;
                                            
                                            $result_error = true;
                                            $result_error_log[ ] = 'Реальное расширение файла не совпадает с данными Content-Type в Заголовках';
                                        }
                                    }
                                    else {
                                        $result_filename .= $cont_ext;
                                    }
                                }
                            }
                        }
                        else {
                            if (preg_match($pattern_filename, $link, $match)) {
                                $result_filename = $match[1];
                                
                                $result_filename_length = -1*(mb_strlen($result_filename) + 1);
                                $result_dirpath = mb_substr($link, 1, $result_filename_length);
                                
                                if (preg_match($pattern_filename_extension, $result_filename, $match)) {
                                    $match[1] = mb_strtolower($match[1]);
                                    if ($match[1] !== $cont_ext) {
                                        if (mb_strpos($result_filename, '.') !== false) $result_filename = str_replace('.', '__DOT__', $result_filename);
                                        $result_filename .= $cont_ext;
                                        
                                        $result_error = true;
                                        $result_error_log[ ] = 'Реальное расширение файла не совпадает с данными Content-Type в Заголовках';
                                    }
                                }
                                else {
                                    if (mb_strpos($result_filename, '.') !== false) $result_filename = str_replace('.', '__DOT__', $result_filename);
                                    $result_filename .= $cont_ext;
                                    
                                    $result_error = true;
                                    $result_error_log[ ] = 'Внимание - подозрительное имя файла';
                                }
                            }
                            else {
                                $result_error = true;
                                $result_error_log[ ] = 'Очень подозрительная ссылка, файл обработан по экзотическому варианту';
                                
                                if (mb_strpos($link, '/') !== false) $link = str_replace('/', '__SLSH__', $link);
                                $result_filename = $link;
                                if (preg_match($pattern_filename_extension, $result_filename, $match)) {
                                    $match[1] = mb_strtolower($match[1]);
                                    if ($match[1] !== $cont_ext) {
                                        if (mb_strpos($result_filename, '.') !== false) $result_filename = str_replace('.', '__DOT__', $result_filename);
                                        $result_filename .= $cont_ext;
                                        
                                        $result_error = true;
                                        $result_error_log[ ] = 'Реальное расширение файла не совпадает с данными Content-Type в Заголовках';
                                    }
                                }
                                else {
                                    $result_filename .= $cont_ext;
                                }
                            }
                        }
                    }
                    else {
                        $result_error = true;
                        $result_error_log[ ] = 'Очень подозрительная ссылка, файл обработан по экзотическому варианту';
                        
                        if (mb_strpos($link, '/') !== false) $link = str_replace('/', '__SLSH__', $link);
                        $result_filename = $link;
                        if (preg_match($pattern_filename_extension, $result_filename, $match)) {
                            $match[1] = mb_strtolower($match[1]);
                            if ($match[1] !== $cont_ext) {
                                if (mb_strpos($result_filename, '.') !== false) $result_filename = str_replace('.', '__DOT__', $result_filename);
                                $result_filename .= $cont_ext;
                                
                                $result_error = true;
                                $result_error_log[ ] = 'Реальное расширение файла не совпадает с данными Content-Type в Заголовках';
                            }
                        }
                        else {
                            $result_filename .= $cont_ext;
                        }
                    }
                    
                    if (mb_strlen($result_dirpath)) {
                        if (mb_strlen($result_site_dir)) $result_site_dir = my_make_dirs($result_site_dir, $result_dirpath);
                        if ($etalon && mb_strlen($result_site_dir_etalon)) $result_site_dir_etalon = my_make_dirs($result_site_dir_etalon, $result_dirpath);
                    }
                }
            }
        }
    }
    else {
        if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
    }
    
    if (mb_strlen($result_site_dir) && mb_strlen($result_filename)) {
        $result['site_dir'] = $result_site_dir;
        $result['site_dir_etalon'] = $result_site_dir_etalon;
        $result['filename'] = $result_filename;
        $result['dirpath'] = $result_dirpath;
        $result['curl_mode'] = $result_curl_mode;
        $result['error'] = $result_error;
        if ($result['error'] && count($result_error_log)) {
            $result['error_log'] = '';
            foreach ($result_error_log as $error_log) $result['error_log'] .= $error_log . ' => ';
            if (mb_substr($result['error_log'], -4) === ' => ') $result['error_log'] = mb_substr($result['error_log'], 0, -4);
        }
    }
    
    return $result;
}

function my_get_charset_from_file_regex($file, $file_info) {
    
    $result = false;
    
    $charset = '';
    if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
    if (@filesize($file)) {
        if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
        $info = array( );
        if (isset($_SERVER['COMSPEC'])) $file_info = mb_convert_encoding($file_info, 'windows-1251', 'UTF-8');
        if (file_exists($file_info)) {
            if (isset($_SERVER['COMSPEC'])) $file_info = mb_convert_encoding($file_info, 'UTF-8', 'windows-1251');
            $info = my_info_array($file_info);
        }
        else {
            if (isset($_SERVER['COMSPEC'])) $file_info = mb_convert_encoding($file_info, 'UTF-8', 'windows-1251');
        }
        
        if (!isset($info['charset_file']) || (@mb_strlen($info['charset_file']) === 0)) {
            if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
            $string = file_get_contents($file);
            if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
            
            $pattern_charset_content_html = '{<meta\\s+[^>]*?charset\\s*=\\s*([^>\\s]+)[^>]*?>}im';
            $pattern_charset_content_xml = '{<\\?xml\\s[^>]*?encoding\\s*=\\s*["\']{0,1}([a-z0-9-]+)["\']{0,1}[^>]*>}im';
            if (preg_match($pattern_charset_content_html, $string, $match)) {
                $charset = $match[1];
                $charset = trim($charset);
                if (mb_strpos($charset, '"') !== FALSE) $charset = str_replace('"', '', $charset);
                if (mb_strpos($charset, "'") !== FALSE) $charset = str_replace("'", '', $charset);
                if (mb_strpos($charset, "\\") !== FALSE) $charset = str_replace("\\", '', $charset);
                
                $charset = mb_strtolower($charset);
                $charset = trim($charset);
            }
            elseif (preg_match($pattern_charset_content_xml, $string, $match)) {
                $charset = $match[1];
                $charset = trim($charset);
                if (mb_strpos($charset, '"') !== FALSE) $charset = str_replace('"', '', $charset);
                if (mb_strpos($charset, "'") !== FALSE) $charset = str_replace("'", '', $charset);
                if (mb_strpos($charset, "\\") !== FALSE) $charset = str_replace("\\", '', $charset);
                
                $charset = mb_strtolower($charset);
                $charset = trim($charset);
            }
            
            $info['charset_file'] = $charset;
            
            if (my_array_to_file($info, $file_info) === false) $charset = false;
        }
        else {
            $charset = $info['charset_file'];
        }
    }
    else {
        if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
        $charset = false;
    }
    
    if ($charset !== false) {
        if (mb_strlen($charset)) $result = $charset;
    }
    
    return $result;
}

function my_curl_download_all($parent_id, $start_id, $own_url, $method /* 'one_dir' || 'one_link' || 'all_from_one_link' || 'algorithm' */, $dir_structura, $filename_structura) {
    
    $download = 0;
    
    $where['id'] = $start_id;
    $start_url = my_read_cell_where_file_structura($where, 'url', $dir_structura, $filename_structura);
    
    if (($method === 'one_dir')
     || ($method === 'one_link')
     || ($method === 'all_from_one_link')
     || ($method === 'algorithm')) {
        
        if ((int)$parent_id === (int)$start_id) $download = 1;
        
        if ($download !== 1) {
            
            if ($method === 'all_from_one_link') {
                $where['id'] = $parent_id;
                $parent_parent_id = my_read_cell_where_file_structura($where, 'parent', $dir_structura, $filename_structura);
                
                if ((int)$parent_parent_id === (int)$start_id) $download = 1;
            }
            elseif ($method === 'one_dir') {
                
                $where['id'] = $start_id;
                $start_url = my_read_cell_where_file_structura($where, 'url', $dir_structura, $filename_structura);
                
                $where['id'] = $parent_id;
                $parent_url = my_read_cell_where_file_structura($where, 'url', $dir_structura, $filename_structura);
                
                if (mb_substr($start_url, -1) === '/') $start_url = mb_substr($start_url, 0, -1);
                
                if (!preg_match('{^([^/]*//)?[^/]+$}', $start_url) && !preg_match('{/[^/\\.]+$}', $start_url)) $start_url = preg_replace('{/[^/]+$}', '', $start_url);
                
                if ((mb_stripos($own_url, $start_url) !== false) || (mb_stripos($parent_url, $start_url) !== false)) $download = 1;
            }
        }
    }
    
    return $download;
}

function my_curl_download_SGML($own_id, $start_id, $own_content_type, $only_SGML /* true || false */, $method /* 'one_dir' || 'one_link' || 'all_from_one_link' || 'algorithm' */, $dir_structura, $filename_structura) {
    
    $download = 1;
    
    if (($method === 'one_dir')
     || ($method === 'one_link')
     || ($method === 'all_from_one_link')
     || ($method === 'algorithm')) {
        
        if ($only_SGML && ($own_content_type !== 'text/html') && ($own_content_type !== 'text/xml')) $download = 0;
        
        if ($download === 1) {
            
            if ((int)$own_id !== (int)$start_id) {
                
                $download = 0;
                
                $where['id'] = $own_id;
                $parent_id = my_read_cell_where_file_structura($where, 'parent', $dir_structura, $filename_structura);
                
                if ($method === 'one_link') {
                    if (!$only_SGML && ($own_content_type !== 'text/html') && ($own_content_type !== 'text/xml')) {
                        if ((int)$parent_id === (int)$start_id) $download = 1;
                    }
                }
                elseif ($method === 'all_from_one_link') {
                    
                    if ((int)$parent_id === (int)$start_id) $download = 1;
                    
                    if ($download !== 1) {
                        if (!$only_SGML && ($own_content_type !== 'text/html') && ($own_content_type !== 'text/xml')) {
                            
                            $where['id'] = $parent_id;
                            $parent_parent_id = my_read_cell_where_file_structura($where, 'parent', $dir_structura, $filename_structura);
                            
                            if ((int)$parent_parent_id === (int)$start_id) $download = 1;
                        }
                    }
                }
                elseif ($method === 'one_dir') {
                    
                    $where['id'] = $start_id;
                    $start_url = my_read_cell_where_file_structura($where, 'url', $dir_structura, $filename_structura);
                    
                    $where['id'] = $own_id;
                    $own_url = my_read_cell_where_file_structura($where, 'url', $dir_structura, $filename_structura);
                    
                    if (mb_substr($start_url, -1) === '/') $start_url = mb_substr($start_url, 0, -1);
                    
                    if (!preg_match('{^([^/]*//)?[^/]+$}', $start_url) && !preg_match('{/[^/\\.]+$}', $start_url)) $start_url = preg_replace('{/[^/]+$}', '', $start_url);
                    
                    if (mb_stripos($own_url, $start_url) !== false) $download = 1;
                    
                    if ($download !== 1) {
                        if (!$only_SGML && ($own_content_type !== 'text/html') && ($own_content_type !== 'text/xml')) {
                            
                            $where['id'] = $parent_id;
                            $parent_url = my_read_cell_where_file_structura($where, 'url', $dir_structura, $filename_structura);
                            
                            if (mb_stripos($parent_url, $start_url) !== false) $download = 1;
                        }
                    }
                }
            }
        }
    }
    else {
        $download = 0;
    }
    
    return $download;
}

function my_curl($url, $dir, $method = 'one_dir' /* 'one_link' || 'all_from_one_link' || 'algorithm' */, $only_SGML = false, $etalon = true, $link_mode = 'none' /* 'cut' || 'transform' */, $link_transform = '', $proxy = false) {
    
/* Массив с именем структурированного файла и номером скачанной строки (для режима ALGORITHM) или номером строки равным -1, если работа идет до упора, при ошибке COUNT($RESULT) равно 0 */
    $result = array( );
    
/**********/
    $User_Agent = 'User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:18.0) Gecko/20100101 Firefox/18.0';
    $HTTP_Headers = array   (
                             1 => 'Accept: */*',
                             2 => 'Accept-Language: ru-RU,ru;q=0.8,en-US;q=0.5,en;q=0.3',
                             3 => 'Accept-Encoding: identity',
                             4 => 'DNT: 1',
                             5 => 'Connection: keep-alive'
                            );
/**********/
    
    $base_dirs = my_curl_create_base_dirs($url, $dir, $etalon, true);
    
    if (mb_strlen($base_dirs['base_dir'])) {
        $structura_filename = basename($base_dirs['base_dir']) . '.txt';
        $structura_file = my_file($structura_filename, $base_dirs['base_dir']);
        $structura = array  (
                             'id' => 1,
                             'level' => 2,
                             'parent' => 3,
                             'url' => 4,
                             'download' => 5,
                             'status' => 6,
                             'temp_file_info' => 7,
                             'content_type' => 8,
                             'curl_mode' => 9,
                             'file' => 10,
                             'file_etalon' => 11,
                             'anchor' => 12,
                             'title' => 13,
                             'error' => 14,
                             'error_log' => 15,
                             'done' => 16
                            );
        
        $structura = my_create_file_structura($structura, $base_dirs['base_dir'], $structura_filename);
        
        if (count($structura)) {
            
            $num_row = 1;
            $id = 1;
            
            $data_rewrite[0] = array ('id' => $id, 'level' => 0, 'parent' => 0, 'url' => $url, 'download' => 1, 'done' => 0);
            
            if (my_write_file_structura($data_rewrite, $num_row, 'rewrite', $base_dirs['base_dir'], $structura_filename)) {
                
                $start_id = 1;
                
                do {
                    $task = my_read_row_file_structura($num_row, $base_dirs['base_dir'], $structura_filename);
                    $data_rewrite[0] = $task;
                    
                    if ($task['download']) {
                        
                        if ($task['parent'] === 0) {
                            $referer = false;
                        }
                        else {
                            $where['id'] = $task['parent'];
                            $referer = my_read_cell_where_file_structura($where, 'url', $base_dirs['base_dir'], $structura_filename);
                        }
                        
                        $temp_file_info = '';
                        if (@mb_strlen($task['url'])) {
                            $temp_files = my_curl_request($task['url'], $User_Agent, $HTTP_Headers, 'temp', array('temp_dir' => $base_dirs['temp_dir'], 'file' => ''), $referer);
                            if ($temp_files !== false) $temp_file_info = $temp_files['file_info'];
                        }
                        
                        $info = array( );
                        if (mb_strlen($temp_file_info)) {
                            if (isset($_SERVER['COMSPEC'])) $temp_file_info = mb_convert_encoding($temp_file_info, 'windows-1251', 'UTF-8');
                            if (@file_exists($temp_file_info) && @filesize($temp_file_info)) {
                                if (isset($_SERVER['COMSPEC'])) $temp_file_info = mb_convert_encoding($temp_file_info, 'UTF-8', 'windows-1251');
                                $info = my_info_array($temp_file_info);
                            }
                            else {
                                if (isset($_SERVER['COMSPEC'])) $temp_file_info = mb_convert_encoding($temp_file_info, 'UTF-8', 'windows-1251');
                            }
                        }
                        
                        if (count($info)) {
                            if (isset($info['status'])) $data_rewrite[0]['status'] = $info['status'];
                            $data_rewrite[0]['temp_file_info'] = $temp_file_info;
                            if (isset($info['status'])) {
                                $status = intval($info['status']);
                                if ($status === 200) {
                                    $data_rewrite[0]['content_type'] = $info['content_type'];
                                }
                                else {
                                    $data_rewrite[0]['download'] = 0;
                                    $data_rewrite[0]['error'] = '***ERROR***';
                                    $data_rewrite[0]['error_log'] = 'Сервер вместо файла прислал ошибку со статусом ' . $info['status'];
                                }
                            }
                            else {
                                $data_rewrite[0]['download'] = 0;
                                $data_rewrite[0]['error'] = '***ERROR***';
                                $data_rewrite[0]['error_log'] = 'Сервер вместо файла прислал ошибку с неизвестным статусом';
                            }
                            
                            if (my_write_file_structura($data_rewrite, $num_row, 'rewrite', $base_dirs['base_dir'], $structura_filename)) {
                                
                                $task = my_read_row_file_structura($num_row, $base_dirs['base_dir'], $structura_filename);
                                
                                if ($task['download']) {
                                    
                                    $data_rewrite[0]['download'] = my_curl_download_SGML($task['id'], $start_id, $task['content_type'], $only_SGML, $method, $base_dirs['base_dir'], $structura_filename);
                                    
                                    if (my_write_file_structura($data_rewrite, $num_row, 'rewrite', $base_dirs['base_dir'], $structura_filename)) {
                                        
                                        $task = my_read_row_file_structura($num_row, $base_dirs['base_dir'], $structura_filename);
                                        
                                        if ($task['download']) {
                                            
                                            $dirs_files = my_curl_request_dir_filename($task['url'], $task['content_type'], $dir, $etalon);
                                            
                                            $data_rewrite[0]['curl_mode'] = $dirs_files['curl_mode'];
                                            $data_rewrite[0]['file'] = $dirs_files['site_dir'] . DIRECTORY_SEPARATOR . $dirs_files['filename'];
                                            if (mb_strlen($dirs_files['site_dir_etalon'])) $data_rewrite[0]['file_etalon'] = $dirs_files['site_dir_etalon'] . DIRECTORY_SEPARATOR . $dirs_files['filename'];
                                            
                                            if ($dirs_files['error']) {
                                                $data_rewrite[0]['error'] = '***ERROR***';
                                                $data_rewrite[0]['error_log'] = $dirs_files['error_log'];
                                            }
                                            
                                            if (my_write_file_structura($data_rewrite, $num_row, 'rewrite', $base_dirs['base_dir'], $structura_filename)) {
                                                
                                                $task = my_read_row_file_structura($num_row, $base_dirs['base_dir'], $structura_filename);
                                                
                                                $files = my_curl_request($task['url'], $User_Agent, $HTTP_Headers, 'normal', array('temp_dir' => '', 'file' => $task['file']), $referer, $task['curl_mode'], 'files', $task['temp_file_info']);
                                                if ($files !== false) {
                                                    
                                                    $data_rewrite[0]['done'] = 1;
                                                    if (my_write_file_structura($data_rewrite, $num_row, 'rewrite', $base_dirs['base_dir'], $structura_filename)) $task = my_read_row_file_structura($num_row, $base_dirs['base_dir'], $structura_filename);
                                                    
                                                    if (($task['content_type'] === 'text/html') || ($task['content_type'] === 'text/xml')) {
                                                        $charset_file = my_get_charset_from_file_regex($files['file'], $files['file_info']);
                                                        $charset = '';
                                                        if ($charset_file !== false) $charset = $charset_file;
                                                        
                                                        $info = my_info_array($files['file_info']);
                                                        if ((mb_strlen($charset) === 0) && isset($info['charset_header'])) $charset = $info['charset_header'];
                                                        
                                                        $info['charset'] = $charset;
                                                        if (my_array_to_file($info, $files['file_info'], 'write', 'with_keys', "\t")) $info = my_info_array($files['file_info']);
                                                    }
                                                    
                                                    if (mb_strlen($dirs_files['site_dir_etalon'])) {
                                                        foreach ($files as $file) {
                                                            if (mb_strlen($file)) {
                                                                if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
                                                                if (@file_exists($file)) {
                                                                    if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
                                                                    $file_etalon = $dirs_files['site_dir_etalon'] . DIRECTORY_SEPARATOR . basename($file);
                                                                    if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
                                                                    if (isset($_SERVER['COMSPEC'])) $file_etalon = mb_convert_encoding($file_etalon, 'windows-1251', 'UTF-8');
                                                                    copy($file, $file_etalon);
                                                                    if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
                                                                    if (isset($_SERVER['COMSPEC'])) $file_etalon = mb_convert_encoding($file_etalon, 'UTF-8', 'windows-1251');
                                                                }
                                                                else {
                                                                    if (isset($_SERVER['COMSPEC'])) $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
                                                                }
                                                            }
                                                        }
                                                    }
                                                    
                                                    if ($info['content_type'] === 'text/html') {
                                                        if (mb_strlen($info['charset'])) {
                                                            if (my_file_in_utf8_4phpquery_soft_2($files['file'], $info['charset'])) {
                                                                
                                                                $meta = array( );
                                                                
                                                                if (isset($document)) unset($document);
                                                                $document = phpQuery::newDocumentFile($files['file']);
                                                                
                                                                $title = $document->find("title")->text( );
                                                                if (mb_strlen($title)) {
                                                                    $title = my_string_in_line_2($title);
                                                                    if (mb_strpos($title, "\t") !== FALSE) $title = str_replace("\t", " ", $title);
                                                                    while (mb_strpos($title, '  ') !== FALSE) $title = str_replace('  ', ' ', $title);
                                                                    
                                                                    if (mb_strlen($title)) {
                                                                        $data_rewrite[0]['title'] = $title;
                                                                        if (mb_strlen($task['anchor']) === 0) $data_rewrite[0]['anchor'] = $title;
                                                                        
                                                                        if (my_write_file_structura($data_rewrite, $num_row, 'rewrite', $base_dirs['base_dir'], $structura_filename)) $task = my_read_row_file_structura($num_row, $base_dirs['base_dir'], $structura_filename);
                                                                        
                                                                        $meta['title'] = $title;
                                                                    }
                                                                }
                                                                
                                                                $description = $document->find("meta[name=description]")->attr("content");
                                                                if (mb_strlen($description)) {
                                                                    $description = my_string_in_line_2($description);
                                                                    if (mb_strpos($description, "\t") !== FALSE) $description = str_replace("\t", " ", $description);
                                                                    while (mb_strpos($description, '  ') !== FALSE) $description = str_replace('  ', ' ', $description);
                                                                    
                                                                    if (mb_strlen($description)) $meta['description'] = $description;
                                                                }
                                                                
                                                                $keywords = $document->find("meta[name=keywords]")->attr("content");
                                                                if (mb_strlen($keywords)) {
                                                                    $keywords = my_string_in_line_2($keywords);
                                                                    if (mb_strpos($keywords, "\t") !== FALSE) $keywords = str_replace("\t", " ", $keywords);
                                                                    while (mb_strpos($keywords, '  ') !== FALSE) $keywords = str_replace('  ', ' ', $keywords);
                                                                    
                                                                    if (mb_strlen($keywords)) $meta['keywords'] = $keywords;
                                                                }
                                                                
                                                                if (count($meta)) {
                                                                    $file_meta = $files['file'] . '.meta';
                                                                    if (mb_strlen($dirs_files['site_dir_etalon'])) $file_meta_etalon = $dirs_files['site_dir_etalon'] . DIRECTORY_SEPARATOR . basename($file_meta);
                                                                    if (my_array_to_file($meta, $file_meta) && mb_strlen($dirs_files['site_dir_etalon'])) {
                                                                        if (isset($_SERVER['COMSPEC'])) $file_meta = mb_convert_encoding($file_meta, 'windows-1251', 'UTF-8');
                                                                        if (isset($_SERVER['COMSPEC'])) $file_meta_etalon = mb_convert_encoding($file_meta_etalon, 'windows-1251', 'UTF-8');
                                                                        copy($file_meta, $file_meta_etalon);
                                                                        if (isset($_SERVER['COMSPEC'])) $file_meta = mb_convert_encoding($file_meta, 'UTF-8', 'windows-1251');
                                                                        if (isset($_SERVER['COMSPEC'])) $file_meta_etalon = mb_convert_encoding($file_meta_etalon, 'UTF-8', 'windows-1251');
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                    
                                                    $urls = my_get_urls_2($files['file'], $info['content_type'], $info['own_url'], $info['base_url']);
                                                    
                                                    $already_urls = my_read_col_file_structura('url', $base_dirs['base_dir'], $structura_filename);
                                                    
                                                    $urls = my_urls_array_diff($urls, $already_urls);
                                                    
                                                    $data_write = array( );
                                                    foreach ($urls as $url => $anchor) {
                                                        $id++;
                                                        $level = $task['level'] + 1;
                                                        $parent_id = $task['id'];
                                                        
                                                        $download = my_curl_download_all($parent_id, $start_id, $url, $method, $base_dirs['base_dir'], $structura_filename);
                                                        
                                                        $data_write[ ] = array('id' => $id, 'level' => $level, 'parent' => $parent_id, 'url' => $url, 'download' => $download, 'anchor' => $anchor, 'done' => 0);
                                                    }
                                                    
                                                    if (count($data_write)) my_write_file_structura($data_write, $num_row, 'write', $base_dirs['base_dir'], $structura_filename);
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    
                    $num_rows = count(my_file_to_array($structura_file)) - count($structura);
                    
                    $num_row++;
                }
                while ($num_row <= $num_rows);
            }
        }
    }
    
    return $result;
}

function my_get_sitemap($url /* $base_url */, $dir, $interstol = false) {
    
    $result = false;
    
    $url = my_get_base_url($url);
    
    if (mb_strlen($url)) {
        if ($interstol) {
            $url .= '/mapsite.html';
            
            $rez = my_curl($url, $dir, 'one_link', true, false);
            
            
            
            $result = true;
        }
        
        if ($result === false) {
            $url .= '/sitemap.xml';
            
            $rez = my_curl($url, $dir, 'all_from_one_link', true, false);
            
            
            
            $result = true;
        }
    }
    
    return $result;
}

/* УСТАРЕЛО
function my_getsite($url, $dir, $etalon = TRUE, $dop_folder = '', $refer = '', $check_end = FALSE) {
    
    $result = array (
                        'file'         =>  '',
                        'file_etalon'  =>  ''
    );
    
    $url = trim($url);
    if (mb_strlen($dir)) $dir = trim($dir);
    if (mb_strlen($dop_folder)) $dop_folder = trim($dop_folder);
    
    $pattern_url = '{^(http://)?([^\\s]+?\\.[^\\s]+?)$}i';
    if (preg_match($pattern_url, $url, $match)) {
        $url = 'http://' . $match[2];
    }
    else {
        $url = '';
    }
    
    if (mb_strlen($url)) {
        
        $dir = my_path($dir);
        
        if (isset ($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'windows-1251', 'UTF-8');
        if (file_exists($dir) && is_dir($dir)) {
            if (isset ($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
            
            $tempdir = my_path('cabinet/control/tempdir');
            if ((mb_strlen($dir) >= mb_strlen($tempdir)) && (mb_stripos($dir, $tempdir) !== FALSE)) {
                $pattern_domen = '{http://([^/]+)}i';
                if (preg_match($pattern_domen, $url, $match)) {
                    $domen = $match[1];
                    $folder = str_replace('.', '__', $domen);
                    $folder_length = -1*(mb_strlen($folder));
                    if (mb_substr($dir, $folder_length) !== $folder) {
                        $dir .= DIRECTORY_SEPARATOR . $folder;
                        $dir = my_make_dirs($dir);
                    }
                    if (mb_strlen($dir)) {
                        if (mb_strlen($dop_folder)) {
                            $pattern_split = '{\\\\|/}';
                            $dop_folder = preg_split($pattern_split, $dop_folder);
                            if (count($dop_folder) === 1) {
                                $dir .= DIRECTORY_SEPARATOR . $dop_folder[0];
                                $dir = my_make_dirs($dir);
                            }
                        }
                    }
                    $dir_etalon = '';
                    if (mb_strlen($dir)) {
                        if ($etalon === TRUE) {
                            $dir_etalon = $dir . DIRECTORY_SEPARATOR . 'etalon';
                            $dir_etalon = my_make_dirs($dir_etalon);
                        }
                    }
                    
                    $site_length = mb_strlen('http://' . $domen);
                    
                    $link = mb_substr($url, $site_length);
                    
                    if (mb_strpos($link, '?') !== FALSE) $link = str_replace('?', '__QES__', $link);
                    if (mb_strpos($link, '=') !== FALSE) $link = str_replace('=', '__EQU__', $link);
                    if (mb_strpos($link, '&') !== FALSE) $link = str_replace('&', '__AMP__', $link);
                    if (mb_strpos($link, '#') !== FALSE) $link = str_replace('#', '__OKT__', $link);
                    if (mb_strpos($link, '+') !== FALSE) $link = str_replace('+', '__PLS__', $link);
                    
                    $filename = '';
                    $dirpath = '';
                    $pattern_dir_end = '{/[^/\\.]+$}i';
                    
*/
                    /* по условиям регулярки  mb_substr($link, 0, 1) === 1 *//*
                    if (mb_strlen($link) <= 1 ) {
                        $filename = 'index.html';
                    }
                    elseif ((mb_substr($link, -1) === '/') && (mb_strlen($link) > 2)) {
                        $filename = 'index.html';
                        $dirpath = mb_substr($link, 1, -1);
                    }
                    elseif (preg_match($pattern_dir_end, $link)) {
                        $filename = 'index.html';
                        $dirpath = mb_substr($link, 1);
                    }
                    else {
                        $pattern_filename = '{([^/]+)$}i';
                        if (preg_match($pattern_filename, $link, $match)) {
                            $pattern_symb = '{\\.[^\\.]*?(__QES__|__EQU__|__AMP__|__OKT__|__PLS__)[^\\.]*$}';
                            if (preg_match($pattern_symb, $match[1])) {
                                $filename = str_replace('.', '__DOT__', $match[1]);
                                $filename .= '.html';
                            }
                            else $filename = $match[1];
                            
                            $filename_length = -1*(mb_strlen($match[1]) + 1);
                            $dirpath = mb_substr($link, 1, $filename_length);
                        }
                    }
                    
                    $file = '';
                    if (mb_strlen($filename)) {
                        if (mb_strlen($dirpath)) {
                            if (mb_strlen($dir)) $dir = my_make_dirs($dir, $dirpath);
                            if (($etalon === TRUE) && mb_strlen($dir_etalon)) $dir_etalon = my_make_dirs($dir_etalon, $dirpath);
                        }
                        if (mb_strlen($dir)) $file = $dir . DIRECTORY_SEPARATOR . $filename;
                    }
                    
                    if (mb_strlen($file)) {
                        $pattern_check_html = '{\\.(d?html?|php|asp)$}i';
                        if (preg_match($pattern_check_html, $file)) {
*/
/* параметр № 3 = TRUE *//*   $check = my_curl_request($url, $file, FALSE, $check_end, 'check', 'identity', 't', $refer, 10);
                        }
                        else {
                            $check = my_curl_request($url, $file, FALSE, FALSE, 'check', 'identity', 'b', $refer, 10);
                        }
                        if ($check === TRUE) $result['file'] = $file;
                        if (mb_strlen($result['file']) && ($etalon === TRUE) && mb_strlen($dir_etalon)) {
                            $pattern_filename = '{^(.+?)\\.[^\\.]+$}';
                            if (preg_match($pattern_filename, $filename, $match)) {
                                $filename = $match[1];
                                $pattern_files = "{(\\\\|/)$filename\\.[^\\\\/]+$}";
                                $pattern_files = htmlentities($pattern_files, ENT_QUOTES, 'utf-8');
                                $files = my_all_files($dir, FALSE, $pattern_files);
                                $check = TRUE;
                                foreach ($files as $filename => $file) {
                                    $file_etalon = $dir_etalon . DIRECTORY_SEPARATOR . $filename;
                                    if (isset ($_SERVER['COMSPEC'])) {
                                        $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
                                        $file_etalon = mb_convert_encoding($file_etalon, 'windows-1251', 'UTF-8');
                                    }
                                    if ($check) $check = @copy($file, $file_etalon);
                                    if (isset ($_SERVER['COMSPEC'])) {
                                        $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
                                        $file_etalon = mb_convert_encoding($file_etalon, 'UTF-8', 'windows-1251');
                                    }
                                }
                                if ($check) $result['file_etalon'] = $dir_etalon . DIRECTORY_SEPARATOR . basename($result['file']);
                            }
                        }
                    }
                }
            }
        }
    }
    
    return $result;
}
*/

/* УСТАРЕЛО
function my_getsite_tempfile($tempfile, $dir = '', $etalon = true, $del_files = FALSE) {
    
    $curl_result = array();
    
    $info = my_info_array($tempfile);
    
    $dir = my_path($dir);
    
    if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'windows-1251', 'UTF-8');
    if (file_exists($dir) && is_dir($dir)) {
        if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
        $pattern_site_folder = '{([^/]+)$}i';
        if (preg_match($pattern_site_folder, $info['base_url'], $match)) {
            $domen = $match[1];
            $site_dir = $dir . DIRECTORY_SEPARATOR . $domen;
            $site_dir = my_make_dirs($site_dir);
            
            if ($etalon) {
                $site_dir_etalon = $dir . DIRECTORY_SEPARATOR . $domen . '__etalon';
                $site_dir_etalon = my_make_dirs($site_dir_etalon);
            }
            
            $base_url_length = mb_strlen($info['base_url']);
            $link = mb_substr($info['own_url'], $base_url_length);
*//*
                    if (mb_strpos($link, '?') !== FALSE) $link = str_replace('?', '__QES__', $link);
                    if (mb_strpos($link, '=') !== FALSE) $link = str_replace('=', '__EQU__', $link);
                    if (mb_strpos($link, '&') !== FALSE) $link = str_replace('&', '__AMP__', $link);
                    if (mb_strpos($link, '#') !== FALSE) $link = str_replace('#', '__OKT__', $link);
                    if (mb_strpos($link, '+') !== FALSE) $link = str_replace('+', '__PLS__', $link);
*//*
            $filename = '';
            $dirpath = '';
            $pattern_dir_end = '{/[^/\\.]+$}i';
            
            if (mb_strlen($link) <= 1 ) {
                $filename = 'index.html';
            }
            elseif ((mb_substr($link, -1) === '/') && (mb_strlen($link) > 2)) {
                $filename = 'index.html';
                $dirpath = mb_substr($link, 1, -1);
            }
            elseif (preg_match($pattern_dir_end, $link)) {
                $filename = 'index.html';
                $dirpath = mb_substr($link, 1);
            }
            else {
                $pattern_dynamic_link = '{\\?|=|&|#|\\+}';
                if (preg_match($pattern_dynamic_link, $link) === 0) {
                    $pattern_filename = '{([^/]+)$}i';
                    if (preg_match($pattern_filename, $link, $match)) {
                        $filename = $match[1];
                        $filename_length = -1*(mb_strlen($filename) + 1);
                        $dirpath = mb_substr($link, 1, $filename_length);
                    }
                }
            }
            
            if (mb_strlen($filename)) $info['filename'] = $filename;
            if (mb_strlen($dirpath)) $info['dirpath'] = $dirpath;
            
            if (mb_substr($info['content_type'], 0, 5) === 'text/') {
                $info['curl_mode'] = 'text';
            }
            else {
                $info['curl_mode'] = 'binary';
            }
            
            $file = '';
            if (isset($info['filename'])) {
                if (isset($info['dirpath'])) {
                    if (mb_strlen($site_dir)) $site_dir = my_make_dirs($site_dir, $info['dirpath']);
                    if ($etalon && mb_strlen($site_dir_etalon)) $site_dir_etalon = my_make_dirs($site_dir_etalon, $info['dirpath']);
                }
                if (mb_strlen($site_dir)) $file = $site_dir . DIRECTORY_SEPARATOR . $info['filename'];
            }
            
            if (mb_strlen($file)) {
                $info['file'] = $file;
                
                if ($info['curl_mode'] === 'text') {
                    $curl_mode = 't';
                }
                elseif ($info['curl_mode'] === 'binary') {
                    $curl_mode = 'b';
                }
                if ($info['status'] === '200') $curl_result = my_curl_request($info['own_url'], $info['file'], FALSE, FALSE, 'files', 'identity', $curl_mode, $info['refer'], 10);
                
                if (mb_strlen($curl_result['file']) && $etalon && mb_strlen($site_dir_etalon)) {
                    $pattern_filename = '{^(.+?)\\.[^\\.]+$}';
                    if (preg_match($pattern_filename, $info['filename'], $match)) {
                        $filename = $match[1];
                        $pattern_files = "{(\\\\|/)$filename\\.[^\\\\/]+$}";
                        $pattern_files = htmlentities($pattern_files, ENT_QUOTES, 'utf-8');
                        $files = my_all_files($site_dir, FALSE, $pattern_files);
                        $check = TRUE;
                        foreach ($files as $filename => $file) {
                            $file_etalon = $site_dir_etalon . DIRECTORY_SEPARATOR . $filename;
                            if (isset($_SERVER['COMSPEC'])) {
                                $file = mb_convert_encoding($file, 'windows-1251', 'UTF-8');
                                $file_etalon = mb_convert_encoding($file_etalon, 'windows-1251', 'UTF-8');
                            }
                            if ($check) $check = @copy($file, $file_etalon);
                            if (isset ($_SERVER['COMSPEC'])) {
                                $file = mb_convert_encoding($file, 'UTF-8', 'windows-1251');
                                $file_etalon = mb_convert_encoding($file_etalon, 'UTF-8', 'windows-1251');
                            }
                        }
                        if ($check) $curl_result['file_etalon'] = $site_dir_etalon . DIRECTORY_SEPARATOR . basename($curl_result['file']);
                    }
                }
            }
        }
    }
    else {
        if (isset($_SERVER['COMSPEC'])) $dir = mb_convert_encoding($dir, 'UTF-8', 'windows-1251');
    }
    
    $tempfilename = basename($tempfile);
    my_delete_files($tempfilename, 'cabinet/control/tempdir');
    
    return $curl_result;
}
*/
