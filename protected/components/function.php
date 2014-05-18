<?php

function redirectByJs($url) {
    echo '<script type="text/javascript">location.href="' . $url . '";</script>';
    exit;
}

function testsave($data, $file = 'test.txt') {
    $fp = fopen(Yii::app()->basePath . '/runtime/' . $file, 'a+');
    fwrite($fp, "-----------------------------------------------------------------\n" . var_export($data, true) . "\n");
    fclose($fp);
}

function get_http_referer() {
    return $_SERVER['HTTP_REFERER'];
}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0) {
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = & $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = is_numeric($data[$pid]) ? $data[$pid] : strval($data[$pid]);
            if ($root == $parentId) {
                $tree[] = & $list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = & $refer[$parentId];
                    $parent[$child][] = & $list[$key];
                }
            }
        }
    }
    return $tree;
}

//公用函数
function numeric($var) {
    $return = 0;
    if (is_numeric($var) && $var > 0) {
        $return = intval($var);
    }
    return $return;
}

function price_format($price) {
    return sprintf('%.02f', $price);
}

function password($pw) {
    return md5($pw . md5($pw));
}

function safeField($data, $_safeField = array(), $html = '') {
    $return = array();
    if (!is_array($data))
        return $return;
    foreach ($_safeField as $field) {
        if (isset($data[$field]))
            $return[$field] = $data[$field];
    }
    if (is_array($html)) {
        foreach ($html as $key) {
            if (isset($return[$key]))
                $return[$key] = htmlspecialchars_decode($return[$key]);
        }
    }
    return $return;
}

function getArrayField($arr, $field, $key = '') {
    if (!is_array($arr))
        return array();
    $return = array();
    if ($key != '') {
        foreach ($arr as $value) {
            $return[$value[$key]] = $value[$field];
        }
    } else {
        foreach ($arr as $value) {
            if (isset($value[$field]))
                $return[] = $value[$field];
        }
    }
    return $return;
}

function curl_post($url, $data, $https = FALSE) {
    $req = '';
    foreach ($data as $k => $v) {
        $v = urlencode(stripslashes($v));
        $req .= "&{$k}={$v}";
    }
    $req = rtrim($req);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if ($https) {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    }
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

function curl($url, $data = array(), $type = 'get') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    if ($type == 'post') {
        $req = http_build_query($data);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    } else {
        if (!empty($data)) {
            $url = $url . '?' . http_build_query($data);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
    }
    if (substr($url, 0, 5) == 'https') {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    }
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

function curl_direct_post($url, $data = '') {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    if (substr($url, 0, 5) == 'https') {
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    }
    $res = curl_exec($ch);
    curl_close($ch);
    return $res;
}

function showMessage($msg, $url = '', $time = 0) {
    include Yii::app()->getBasePath() . '/views/show_message_tpl.php';
    exit();
}

function toArray($data) {
    return (array) $data;
}

function object2array($object, $keyBy = '') {
    $array = array();
    if (is_array($object)) {
        foreach ($object as $value) {
            if ($keyBy != '')
                $array[$value->$keyBy] = $value->attributes;
            else
                $array[] = $value->attributes;
        }
    }
    return $array;
}

function array_convert_key($key, $array) {
    $array2 = array();
    if (is_array($array)) {
        foreach ($array as $value) {
            $array2[$value[$key]] = $value;
        }
    }
    return $array2;
}

function array2keyname($array, $key_key, $name_key) {
    $array2 = array();
    if (is_array($array)) {
        foreach ($array as $value) {
            $array2[$value[$key_key]] = $value[$name_key];
        }
    }
    return $array2;
}

function array_remove_empty($array) {
    $return = array();
    if (!is_array($array)) {
        return $return;
    }
    foreach ($array as $value) {
        $value = trim($value);
        if (!empty($value)) {
            $return[] = $value;
        }
    }
    return $return;
}

function cutstr($string, $length, $dot = ' ...', $charset = 'utf-8') {
    if (strlen($string) <= $length) {
        return $string;
    }

    $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);

    $strcut = '';
    if (strtolower($charset) == 'utf-8') {

        $n = $tn = $noc = 0;
        while ($n < strlen($string)) {

            $t = ord($string[$n]);
            if ($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                $tn = 1;
                $n++;
                $noc++;
            } elseif (194 <= $t && $t <= 223) {
                $tn = 2;
                $n += 2;
                $noc += 2;
            } elseif (224 <= $t && $t < 239) {
                $tn = 3;
                $n += 3;
                $noc += 2;
            } elseif (240 <= $t && $t <= 247) {
                $tn = 4;
                $n += 4;
                $noc += 2;
            } elseif (248 <= $t && $t <= 251) {
                $tn = 5;
                $n += 5;
                $noc += 2;
            } elseif ($t == 252 || $t == 253) {
                $tn = 6;
                $n += 6;
                $noc += 2;
            } else {
                $n++;
            }

            if ($noc >= $length) {
                break;
            }
        }
        if ($noc > $length) {
            $n -= $tn;
        }

        $strcut = substr($string, 0, $n);
    } else {
        for ($i = 0; $i < $length; $i++) {
            $strcut .= ord($string[$i]) > 127 ? $string[$i] . $string[++$i] : $string[$i];
        }
    }

    $strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

    return $strcut . $dot;
}

function cutstr_html($string, $length, $dot = '', $charset = 'utf-8') {
    $string = cutstr($string, $length, $dot, $charset);
    $string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);
    $tabPos = strrpos($string, '<');
    if ($length - $tabPos < 10) {
        $string = substr($string, 0, $tabPos);
    }
    return closetags($string);
}

function closetags($html) {
    /* 截取最后一个 < 之前的内容，确保字符串中所有HTML标签都以 > 结束 */
    $html = preg_replace("~<[^<>]+?$~i", "", $html);
    /* 自动匹配补齐未关闭的HTML标签 */
    #put all opened tags into an array
    preg_match_all("#<([a-z]+)( .*[^/])?(?!/)>#iU", $html, $result);
    $openedtags = $result[1];
    #put all closed tags into an array
    preg_match_all("#</([a-z]+)>#iU", $html, $result);
    $closedtags = $result[1];
    $len_opened = count($openedtags);
    # all tags are closed
    if (count($closedtags) == $len_opened) {
        return $html;
    }
    $openedtags = array_reverse($openedtags);
    # close tags
    for ($i = 0; $i < $len_opened; $i++) {
        if (!in_array($openedtags[$i], $closedtags)) {
            if (strtolower($openedtags[$i]) != 'img') {
                $html .= '</' . $openedtags[$i] . '>';
            }
        } else {
            unset($closedtags[array_search($openedtags[$i], $closedtags)]);
        }
    }
    return $html;
}

function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    $ckey_length = 4;
    $key = md5($key != '' ? $key : getglobal('authkey'));
    $keya = md5(substr($key, 0, 16));
    $keyb = md5(substr($key, 16, 16));
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length) : substr(md5(microtime()), -$ckey_length)) : '';

    $cryptkey = $keya . md5($keya . $keyc);
    $key_length = strlen($cryptkey);

    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0) . substr(md5($string . $keyb), 0, 16) . $string;
    $string_length = strlen($string);

    $result = '';
    $box = range(0, 255);

    $rndkey = array();
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }

    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }

    for ($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }

    if ($operation == 'DECODE') {
        if ((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26) . $keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        return $keyc . str_replace('=', '', base64_encode($result));
    }
}

function fileext($filename) {
    return substr(strrchr($filename, '.'), 1);
}

// 循环创建目录
function mk_dir($dir, $mode = 0777) {
    if (is_dir($dir) || @mkdir($dir, $mode))
        return true;
    if (!mk_dir(dirname($dir), $mode))
        return false;
    return @mkdir($dir, $mode);
}

function getUniqid() {
    return str_replace('.', '', uniqid('', true));
}

function thumb($image, $thumbname, $type = '', $maxWidth = 200, $maxHeight = 50, $interlace = true) {
    // 获取原图信息
    $info = getimagesize($image);
    if ($info !== false) {
        $srcWidth = $info[0];
        $srcHeight = $info[1];
        $type = empty($type) ? fileext($image) : $type;
        $type = strtolower($type);

        $thumbType = fileext($thumbname); //modify生成缩略图格式
        $thumbType = !empty($thumbType) ? strtolower($thumbType) : 'jpg';
        $thumbType = in_array($thumbType, array('jpg', 'gif', 'png'));
        $interlace = $interlace ? 1 : 0;
        unset($info);
        $scale = min($maxWidth / $srcWidth, $maxHeight / $srcHeight); // 计算缩放比例
        if ($scale >= 1) {
            // 超过原图大小不再缩略
            $width = $srcWidth;
            $height = $srcHeight;
        } else {
            // 缩略图尺寸
            $width = (int) ($srcWidth * $scale);
            $height = (int) ($srcHeight * $scale);
        }

        // 载入原图
        $createFun = 'ImageCreateFrom' . ($type == 'jpg' || $type == 'jpeg' ? 'jpeg' : $type);
        $srcImg = $createFun($image);
        //imagesavealpha($srcImg,true);//modify保留PNG透明效果
        //创建缩略图
        if ($type != 'gif' && function_exists('imagecreatetruecolor'))
            $thumbImg = imagecreatetruecolor($width, $height);
        else
            $thumbImg = imagecreate($width, $height);

        //modify保留PNG透明效果
        //imagealphablending($thumbImg,false);
        //imagesavealpha($thumbImg,true);
        //modify
        // 复制图片
        if (function_exists("ImageCopyResampled"))
            imagecopyresampled($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
        else
            imagecopyresized($thumbImg, $srcImg, 0, 0, 0, 0, $width, $height, $srcWidth, $srcHeight);
        if ('gif' == $type || 'png' == $type) {
            imagealphablending($thumbImg, false); //取消默认的混色模式
            imagesavealpha($thumbImg, true); //设定保存完整的 alpha 通道信息
            $background_color = imagecolorallocate($thumbImg, 0, 255, 0);  //  指派一个绿色
            imagecolortransparent($thumbImg, $background_color);  //  设置为透明色，若注释掉该行则输出绿色的图
        }

        // 对jpeg图形设置隔行扫描
        if ('jpg' == $type || 'jpeg' == $type)
            imageinterlace($thumbImg, $interlace);

        //$gray=ImageColorAllocate($thumbImg,255,0,0);
        //ImageString($thumbImg,2,5,5,"ThinkPHP",$gray);
        // 生成图片
        $imageFun = 'image' . ($thumbType == 'jpg' ? 'jpeg' : $thumbType);
        $imageFun = 'imagejpeg'; //modify
        $imageFun($thumbImg, $thumbname);
        imagedestroy($thumbImg);
        imagedestroy($srcImg);
        return $thumbname;
    }
    return false;
}

function getImageUrl($url, $size = '') {
    $ext = '';
    if (!empty($size) && in_array($size, array('small', 'middle', 'large', 'xlarge'))) {
        $ext = '_' . $size . '.' . fileext($url);
    }
    return $url . $ext;
}

function auto_charset($fContents, $from = 'gbk', $to = 'utf-8') {
    $from = strtoupper($from) == 'UTF8' ? 'utf-8' : $from;
    $to = strtoupper($to) == 'UTF8' ? 'utf-8' : $to;
    if (strtoupper($from) === strtoupper($to) || empty($fContents) || (is_scalar($fContents) && !is_string($fContents))) {
        //如果编码相同或者非字符串标量则不转换
        return $fContents;
    }
    if (is_string($fContents)) {
        if (function_exists('mb_convert_encoding')) {
            return mb_convert_encoding($fContents, $to, $from);
        } elseif (function_exists('iconv')) {
            return iconv($from, $to, $fContents);
        } else {
            return $fContents;
        }
    } elseif (is_array($fContents)) {
        foreach ($fContents as $key => $val) {
            $_key = auto_charset($key, $from, $to);
            $fContents[$_key] = auto_charset($val, $from, $to);
            if ($key != $_key)
                unset($fContents[$key]);
        }
        return $fContents;
    }
    else {
        return $fContents;
    }
}

function my_json_encode(array $data) {
    $s = array();
    foreach ($data as $k => $v) {
        if (is_array($v)) {
            $v = my_json_encode($v);
            if (is_numeric($k)) {
                $s[] = $v;
            } else {
                $s[] = "\"$k\":$v";
            }
        } else {
            $v = addslashes(str_replace(array("\n", "\r"), '', $v));
            if (is_numeric($k)) {
                $s[] = $v;
            } else {
                $s[] = "\"$k\":\"$v\"";
            }
        }
    }
    return '{' . implode(', ', $s) . '}';
}

function get_absolute_url($url) {
    return realpath('./../') . $url;
}

function file_not_ext($filename) {
    return str_replace(strrchr($filename, '.'), "", $filename);
}

//业务员编号，将ID变成8位
function get_worker_id($id) {
    return sprintf("%08d", $id);
}

//简历编号
function get_resume_id($id) {
    return sprintf("%08d", $id);
}

//专题页面链接
function get_subject_url($id) {
    return Yii::app()->controller->createUrl('/groupon_subject/index', array('id' => $id, 'filter' => '0-0-0-0-iasc'));
}

//生成订单号
function get_order_sn() {
    /* 选择一个随机的方案 */
    mt_srand((double) microtime() * 1000000);
    return date('Ymd') . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);
}

?>
