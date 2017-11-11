<?php

if (!function_exists('mm')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed
     * @return void
     */
    function mm()
    {
        array_map(function ($x) {
            (new \Illuminate\Support\Debug\Dumper)->dump($x);
        }, func_get_args());
    }
}

if (!function_exists('is_empty')) {
    function is_empty($obj)
    {
        if (empty($obj)) {
            return true;
        }

        if ($obj instanceof Illuminate\Support\Collection) {
            $items = $obj->all();
            return empty($items);
        }
        return false;
    }
}

/**
 * 保存上传的图片
 * @param $file_field 上传文件字段
 * @param $save_path 保存路径
 * @param $save_url 图片url路径
 * @param $dest_file_name 文件名
 * @param $flag 0 只返回文件名，1返回文件完整路径
 * @return string|void
 */
function saveImage($file_field, $save_path, $save_url, $dest_file_name = "", $flag = 0)
{
    $error = "";
    //$file_url = "";
    //$save_path = DATA_PATH . "/app/live/" . $subdir;
    //$save_url = PUBLISH_PATH . "/app/live/" . $subdir;
    $save_path = rtrim($save_path, '/') . '/';
    $save_url = rtrim($save_url, '/') . '/';
    $ext_arr = array('gif', 'jpg', 'jpeg', 'png', 'bmp');
    $max_size = 1000000;
    if (empty($file_field)) {
        $file_field = "filename";
    }
    //PHP上传失败
    if (!empty($_FILES[$file_field]['error'])) {
        switch ($_FILES[$file_field]['error']) {
            case '1':
                $error = '超过php.ini允许的大小。';
                break;
            case '2':
                $error = '超过表单允许的大小。';
                break;
            case '3':
                $error = '图片只有部分被上传。';
                break;
            case '4':
                $error = '请选择图片。';
                break;
            case '6':
                $error = '找不到临时目录。';
                break;
            case '7':
                $error = '写文件到硬盘出错。';
                break;
            case '8':
                $error = 'File upload stopped by extension。';
                break;
            case '999':
            default:
                $error = '未知错误。';
        }
    }
    //有上传文件时
    $new_file_name = "";
    if (empty($_FILES) === false) {
        if (!file_exists($save_path)) {
            mkdir($save_path, 0777, true);
        }
        //原文件名
        $file_name = $_FILES[$file_field]['name'];
        //服务器上临时文件名
        $tmp_name = $_FILES[$file_field]['tmp_name'];
        //文件大小
        $file_size = $_FILES[$file_field]['size'];
        //检查文件名
        if (!$file_name) {
            $error = "请选择文件。";
        }
        //检查目录
        if (@is_dir($save_path) === false) {
            $error = "上传目录不存在。";
        }

        //检查目录写权限
        if (@is_writable($save_path) === false) {
            $error = "上传目录没有写权限。";
        }
        //检查是否已上传
        if (@is_uploaded_file($tmp_name) === false) {
            $error = "上传失败。";
        }
        //检查文件大小
        if ($file_size > $max_size) {
            $error = "上传文件大小超过限制。";
        }
        //获得文件扩展名
        $temp_arr = explode(".", $file_name);
        $file_ext = array_pop($temp_arr);
        $file_ext = trim($file_ext);
        $file_ext = strtolower($file_ext);

        if (in_array($file_ext, $ext_arr) === false) {
            $error = "上传文件扩展名是不允许的扩展名。\n只允许" . implode(",", $ext_arr) . "格式。";
        }
    }
    if ($error) {
        return;
    }
    //新文件名

    if ($dest_file_name) {
        $new_file_name = $dest_file_name . '.' . $file_ext;
    } else {
        $_nowdate = date("YmdHis");
        $rnd = rand(10000, 99999);
        $new_file_name = $_nowdate . '_' . $rnd . '.' . $file_ext;
    }
    //移动文件
    $file_path = $save_path . $new_file_name;

    if (move_uploaded_file($tmp_name, $file_path) === false) {
        //alert("上传文件失败。");
    }
    if ($flag) {
        return $save_url . $new_file_name;
    } else {
        return $new_file_name;
    }
}

/**
 *
 * @param $picture
 * @param string $save_url 文件保存路径
 * @return string
 */
function getImage($picture, $save_url = "")
{
    if (strtolower(substr($picture, 0, 4)) == "http") {
        return $picture;
    }
    if (strtolower(substr($save_url, 0, 4)) != "http") {
        $save_url = "http://" . $save_url;
    }

    return rtrim($save_url, '/') . "/" . $picture;
}

/*
 * 生成图片缩略图
 * @param $srcpath 原图片完整路径（包括文件名）
 * @param $topath 缩略图完整路径（包括文件名）
 * @param $maxwidth 最大宽度
 * @param $maxheight 最大高度
 * 原图宽高小于最大宽高时，不进行缩略图生成，直接copy原图。
*/
function createThumb($srcpath, $topath, $maxwidth, $maxheight)
{
    if (!file_exists($srcpath)) {
        return false;
    }
    $data = getimagesize($srcpath);
    $img = null;
    switch ($data[2]) {
        case 1:
            if (function_exists("imagecreatefromgif")) {
                $img = imagecreatefromgif($srcpath);
            }
            break;
        case 2:
            if (function_exists("imagecreatefromjpeg")) {
                $img = imagecreatefromjpeg($srcpath);
            }
            break;
        case 3:
            if (function_exists("imagecreatefrompng")) {
                $img = imagecreatefrompng($srcpath);
            }
            break;
    }
    if (!$img) {
        return false;
    }
    $srcw = imagesx($img);
    $srch = imagesy($img);
    if (($maxwidth > 0 && $srcw > $maxwidth) || ($maxheight > 0 && $srch > $maxheight)) {
        $towidth = $srcw;
        $toheight = $srch;
        if ($maxwidth > 0 && ($maxheight == 0 || $srcw / $srch >= $maxwidth / $maxheight)) {
            $towidth = $maxwidth;
            $toheight = $maxwidth * $srch / $srcw;
        } elseif ($maxheight > 0 && ($maxwidth == 0 || $srcw / $srch <= $maxwidth / $maxheight)) {
            $toheight = $maxheight;
            $towidth = $maxheight * $srcw / $srch;
        }
        if (function_exists("imagecreatetruecolor") && function_exists("imagecopyresampled") && @$imgthumb = imagecreatetruecolor(
                $towidth,
                $toheight
            )
        ) {
            imagecopyresampled($imgthumb, $img, 0, 0, 0, 0, $towidth, $toheight, $srcw, $srch);
        } elseif (function_exists("imagecreate") && function_exists("imagecopyresized") && @$imgthumb = imagecreate(
                $towidth,
                $toheight
            )
        ) {
            imagecopyresized($imgthumb, $img, 0, 0, 0, 0, $towidth, $toheight, $srcw, $srch);
        } else {
            return false;
        }
        if (function_exists('imagejpeg')) {
            imagejpeg($imgthumb, $topath, 50);
        } elseif (function_exists('imagepng')) {
            imagepng($imgthumb, $topath);
        }
    } else {
        copy($srcpath, $topath);
    }
    imagedestroy($img);
    if (!file_exists($topath)) {
        return false;
    }
    return true;
}

/**
 * 递归显示当前指定目录下所有文件
 * 使用dir函数
 * @param string $dir 目录地址
 * @param boolean $recursion 是否递归
 * @return array $files 文件列表
 */
function getFiles($dir, $recursion = false)
{
    $files = array();

    if (!is_dir($dir)) {
        return $files;
    }

    $d = dir($dir);
    while (false !== ($file = $d->read())) {
        if ($file != '.' && $file != '..') {
            $filename = $dir . "/" . $file;

            if (is_file($filename)) {
                $files[] = $filename;
            } else {
                if ($recursion) {
                    $files = array_merge($files, getFiles($filename, $recursion));
                }
            }
        }
    }
    $d->close();
    return $files;
}

/**
 * 图片压缩
 * @param $file压缩的图片
 * @param int $max 图片最大宽度
 * @param int $quality 压缩质量
 * @return array 返回宽高
 */
function imageCompression($file, $max = 1400, $quality = 85)
{
    $img = \Intervention\Image\Facades\Image::make($file);
    $width = $img->width();
    $height = $img->height();
    //图片最大宽度大于max值则压缩
    if ($width > $max) {
        $newHeight = intval(($max / $width) * $height);
        $img->resize($max, $newHeight);
        $width = $max;
        $height = $newHeight;
    }
    $img->save($file, $quality);
    $img->destroy();
    return array($width, $height);
}

/**
 * 如果路径不存在，自动创建
 * @param $filePath
 * User: zzp
 * Date: 2017-03-13
 * @return bool
 */
function autoMakeDir($filePath)
{
    if (!file_exists($filePath)) {
        mkdir($filePath, 0777, true);
    }
}

function curl($url, $type = 0, $postData = [])
{
    if (!$url) {
        return false;
    }

    if ($type == 0) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果把这行注释掉的话，就会直接输出
    } elseif ($type == 1) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    }

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}

/**
 * 获取语义化的时间
 * @param  int $timeStamp 时间戳,正为将来的时间,负为以前的时间
 * @return [string]
 * User lyf
 */
function getSemanticTime($timeStamp)
{
    $state = (($timeStamp = intval($timeStamp)) > 0) ? '后' : '前';
    $time = $timeStamp > 0 ? $timeStamp : -1 * $timeStamp;
    if ($time < 3600) {
        return $timeStamp > 0 ? date('G:i:s', $time) : date('i分钟前', $time);
    } elseif ($time < 24 * 3600) {
        return $timeStamp > 0 ? date('G:i:s', $time) : date('g小时i分钟前', $time);
    } else {
        return $time < 31 * 24 * 3600 ? date('d天' . $state, $time) : date('m月' . $state, $time);
    }
}

/**
 * 获取IP地址
 * 由于服务器nginx代理的缘故 先通过 header 拿到真实ip
 * User: Howard
 * Date: 2017-05-23
 * @return string
 */
function getClientIp()
{
    if (isset($_SERVER['HTTP_X_REAL_IP'])) {
        return $_SERVER['HTTP_X_REAL_IP'];
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    }

    return request()->getClientIp();
}

function makeSalt()
{
    return substr(uniqid(rand()), -6);
}

function makePassword($password, $salt)
{
    if (strlen($password) == 32) {
        return md5($password . $salt);
    }

    return md5(md5($password) . $salt);
}

function isEmail($input)
{
    return preg_match('/(^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+)|(^$)/', $input) ? true : false;
}

// 判断两个时间段是否有重叠
// https://jjyy.de/post/judge-two-date-range-is-overlap.html
function timeIsOverlap($timeAStart, $timeAEnd, $timeBStart, $timeBEnd)
{
    return !($timeAEnd < $timeBStart || $timeBEnd < $timeAStart);
}

/**
 * 文章的分享内容
 * @param $str
 * @param $length
 * User: Howard
 * Date: 2016-10-19
 * @return mixed|string
 */
function getShareContent($str, $length = 0)
{
    $str = html_entity_decode(strip_tags($str));
    $str = str_replace(PHP_EOL, '', $str);
    if (empty($length)) {
        $str = mb_substr($str, 0, 80, 'utf-8') . "...";
    }
    $strArray = array(" ", "　", "\t", "\n", "\r", "&hellip;", "&mdash;");
    $str = str_replace($strArray, '', $str);
    $str = str_replace("'", '"', $str);
    return $str;
}