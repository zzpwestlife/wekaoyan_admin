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
 * 生成图片缩略图
 * @param $srcPath 原图片完整路径（包括文件名）
 * @param $toPath 缩略图完整路径（包括文件名）
 * @param $maxWidth 最大宽度
 * @param $maxHeight 最大高度
 * @param $quality
 * 原图宽高小于最大宽高时，不进行缩略图生成，直接copy原图。
 */
function createThumb($srcPath, $toPath, $maxWidth, $maxHeight, $quality = 75)
{
    if (!file_exists($srcPath)) {
        return false;
    }
    $data = getimagesize($srcPath);
    $img = null;
    switch ($data[2]) {
        case 1:
            if (function_exists("imagecreatefromgif")) {
                $img = imagecreatefromgif($srcPath);
            }
            break;
        case 2:
            if (function_exists("imagecreatefromjpeg")) {
                $img = imagecreatefromjpeg($srcPath);
            }
            break;
        case 3:
            if (function_exists("imagecreatefrompng")) {
                $img = imagecreatefrompng($srcPath);
            }
            break;
    }
    if (!$img) {
        return false;
    }
    $srcW = imagesx($img);
    $srcH = imagesy($img);
    if (($maxWidth > 0 && $srcW > $maxWidth) || ($maxHeight > 0 && $srcH > $maxHeight)) {
        $toWidth = $srcW;
        $toHeight = $srcH;
        if ($maxWidth > 0 && ($maxHeight == 0 || $srcW / $srcH >= $maxWidth / $maxHeight)) {
            $toWidth = $maxWidth;
            $toHeight = $maxWidth * $srcH / $srcW;
        } elseif ($maxHeight > 0 && ($maxWidth == 0 || $srcW / $srcH <= $maxWidth / $maxHeight)) {
            $toHeight = $maxHeight;
            $toWidth = $maxHeight * $srcW / $srcH;
        }
        if (function_exists("imagecreatetruecolor") && function_exists("imagecopyresampled") && @$imgThumb = imagecreatetruecolor(
                $toWidth,
                $toHeight
            )
        ) {
            imagecopyresampled($imgThumb, $img, 0, 0, 0, 0, $toWidth, $toHeight, $srcW, $srcH);
        } elseif (function_exists("imagecreate") && function_exists("imagecopyresized") && @$imgThumb = imagecreate(
                $toWidth,
                $toHeight
            )
        ) {
            imagecopyresized($imgThumb, $img, 0, 0, 0, 0, $toWidth, $toHeight, $srcW, $srcH);
        } else {
            return false;
        }
        if (function_exists('imagejpeg')) {
            imagejpeg($imgThumb, $toPath, $quality);
        } elseif (function_exists('imagepng')) {
            imagepng($imgThumb, $toPath, $quality);
        }
    } else {
        copy($srcPath, $toPath);
    }
    imagedestroy($img);
    if (!file_exists($toPath)) {
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
 * @param object $file
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

// 判断两个时间段是否有重叠
// https://jjyy.de/post/judge-two-date-range-is-overlap.html
function timeIsOverlap($timeAStart, $timeAEnd, $timeBStart, $timeBEnd)
{
    return !($timeAEnd < $timeBStart || $timeBEnd < $timeAStart);
}

/**
 * @comment 上传图片
 * @param object $file
 * @param string $dirName
 * @param bool $isWangEditor
 * @return array
 * @author zzp
 * @date 2017-11-03
 */
function imageUpload($file, $dirName, $isWangEditor = false)
{
    $returnData = [
        'errno' => -1,
        'msg' => '',
        'data' => ''
    ];

    $yearMonth = sprintf('%s%s', \Carbon\Carbon::now()->year, \Carbon\Carbon::now()->month);
    $path = sprintf('%s/uploads/%s/%s/', DATA_ROOT, $dirName, $yearMonth);
    autoMakeDir($path);

//        var_dump($file->getError()); // 0
//        var_dump($file->getFilename()); // php3R7aUM
//        var_dump($file->getExtension());
//        var_dump($file->getClientMimeType()); // image/png
//        var_dump($file->getClientOriginalExtension()); // png
//        var_dump($file->getClientOriginalName()); // bef3df8aly1fbx05q2ra1j20b40b4mxi.png
//        var_dump($file->getErrorMessage()); // The file "bef3df8aly1fbx05q2ra1j20b40b4mxi.png" was not uploaded due to an unknown error.
//        var_dump($file->getBasename()); // php3R7aUM
//        var_dump($file->getPath()); // /tmp
//        var_dump($file->getPathname()); // /tmp/php3R7aUM
//        var_dump($file->getType()); // file
//        var_dump($file->getRealPath()); // /tmp/php3R7aUM

    $error = $file->getError();
    if ($error != 0) {
        $returnData['msg'] = $file->getErrorMessage();
    } else {
        $fileExt = $file->getClientOriginalExtension();
        // 新图片名
        $newFilename = sprintf('%s_%s.%s', time(), rand(10000, 99999), $fileExt);
        $filePath = sprintf('%s/uploads/%s/%s/', DATA_ROOT, $dirName, $yearMonth) . $newFilename;
        $fileUrl = sprintf('%s/uploads/%s/%s/', DATA_URL, $dirName, $yearMonth) . $newFilename;
        $file->move($path, $newFilename);
        // 压缩图片
        list($pictureWidth, $pictureHeight) = getimagesize($filePath);
        $maxWidth = config('image.max_width');
        if ($pictureWidth > $maxWidth) {
            createthumb($filePath, $filePath, $maxWidth, $pictureWidth / 500 * $pictureHeight);
        }

        $returnData['errno'] = 0;
        // http://wekaoyan_admin.dev.com/posts/11/1510388528_47787.jpg
        if ($isWangEditor) {
            $returnData['data'] = [$fileUrl];
        } else {
            $returnData['data'] = $newFilename;
        }
    }

    return $returnData;
}

/**
 * @comment 上传文件 图片和文件按理应该分开
 * @param object $file
 * @param string $dirName
 * @return array
 * @author zzp
 * @date 2017-11-03
 */
function fileUpload($file, $dirName)
{
    $returnData = [
        'errno' => -1,
        'msg' => '',
        'data' => ''
    ];

    $yearMonth = sprintf('%s%s', \Carbon\Carbon::now()->year, \Carbon\Carbon::now()->month);
    $path = sprintf('%s/uploads/%s/%s/', DATA_ROOT, $dirName, $yearMonth);
    autoMakeDir($path);

//        var_dump($file->getError()); // 0
//        var_dump($file->getFilename()); // php3R7aUM
//        var_dump($file->getExtension());
//        var_dump($file->getClientMimeType()); // image/png
//        var_dump($file->getClientOriginalExtension()); // png
//        var_dump($file->getClientOriginalName()); // bef3df8aly1fbx05q2ra1j20b40b4mxi.png
//        var_dump($file->getErrorMessage()); // The file "bef3df8aly1fbx05q2ra1j20b40b4mxi.png" was not uploaded due to an unknown error.
//        var_dump($file->getBasename()); // php3R7aUM
//        var_dump($file->getPath()); // /tmp
//        var_dump($file->getPathname()); // /tmp/php3R7aUM
//        var_dump($file->getType()); // file
//        var_dump($file->getRealPath()); // /tmp/php3R7aUM

    $error = $file->getError();
    if ($error != 0) {
        $returnData['msg'] = $file->getErrorMessage();
    } else {
        $fileExt = $file->getClientOriginalExtension();
        // 新文件名
        $originalFilename = $file->getClientOriginalName();
        $realFilename = rtrim($originalFilename, '.' . $fileExt);
        $newFilename = sprintf('%s_%s_%s.%s', $realFilename, time(), rand(10000, 99999), $fileExt);
        $fileHash = hash_file('md5', $file->getPathname());
        // 不允许重复上传相同的文件
        $fileExist = \App\File::where('hash', $fileHash)->count();
        if ($fileExist) {
            $returnData['msg'] = '该文件已存在 请选择其他文件上传';
            $returnData['errno'] = 123;
        } else {
            // 移动文件
            $file->move($path, $newFilename);
            $returnData['errno'] = 0;
            $fileUri = sprintf('/uploads/%s/%s/', $dirName, $yearMonth) . $newFilename;
            $returnData['data'] = [
                'path' => $path . $newFilename,
                'uri' => $fileUri,
                'filename' => $newFilename,
                'original_filename' => $originalFilename,
                'file_hash' => $fileHash,
            ];
        }
    }

    return $returnData;
}

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
