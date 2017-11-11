<?php

namespace App;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Model extends EloquentModel
{
    use SoftDeletes;
    public $timestamps = true;

    protected $guarded = [];
    // 有效
    const STATUS_VALID = 1;
    // 无效
    const STATUS_INVALID = 0;

    public function getAppends()
    {
        return $this->getArrayableAppends();
    }

    /**
     * @comment 文件上传
     * @param $path
     * @param $file
     * @param $fileName
     * @return array
     * @author zzp
     * @date 2017-11-11
     */
    public static function uploadFile($path, $file, $fileName)
    {

        $fileInfo = [];
        $fileExt = trim(substr(strrchr($file['name'], '.'), 1));
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($file['tmp_name']);
//        $fileExt = '';
//        switch ($mimeType) {
//            case 'image/jpeg':
//                $fileExt = 'jpg';
//                break;
//            case 'image/png':
//                $fileExt = 'png';
//                break;
//            case 'image/gif':
//                $fileExt = 'gif';
//                break;
//        }

        $fileName = sprintf('post_%s.%s', $fileName, $fileExt);
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        $filePath = sprintf("%s/%s", rtrim($path, " \t\n\r\0\x0B/"), $fileName);

        if (move_uploaded_file($file['tmp_name'], $filePath)) {
//            list($pictureWidth, $pictureHeight) = getimagesize($filePath);
            // gif 动图不压缩，两张图名字相同，指向同一张图片
//            if ($fileExt == 'gif') {
//                createthumb($filePath, $filePath, $pictureWidth, $pictureHeight);
//            } else {
//                createthumb($filePath, $filePath, $pictureWidth / 2, $pictureHeight / 2);
//            }
            $fileInfo = [
                'fileName' => $fileName,
//                'pictureWidth' => $pictureWidth,
//                'pictureHeight' => $pictureHeight,
            ];
        }

        return $fileInfo;
    }
}
