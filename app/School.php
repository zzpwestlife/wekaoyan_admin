<?php

namespace App;

class School extends Model
{
    protected $table = "schools";

    public static $provinces = [
        "beijing" => "北京市",
        "tianjin" => "天津市",
        "hebei" => "河北省",
        "shanxi" => "山西省",
        "neimenggu" => "内蒙古自治区",
        "liaoning" => "辽宁省",
        "jilin" => "吉林省",
        "heilongjiang" => "黑龙江省",
        "shanghai" => "上海市",
        "jiangsu" => "江苏省",
        "zhejiang" => "浙江省",
        "anhui" => "安徽省",
        "fujian" => "福建省",
        "jiangxi" => "江西省",
        "shandong" => "山东省",
        "henan" => "河南省",
        "hubei" => "湖北省",
        "hunan" => "湖南省",
        "guangdong" => "广东省",
        "guangxi" => "广西壮族自治区",
        "hainan" => "海南省",
        "chongqing" => "重庆市",
        "sichuan" => "四川省",
        "guizhong" => "贵州省",
        "yunnan" => "云南省",
        "xizang" => "西藏自治区",
        "shaanxi" => "陕西省",
        "gansu" => "甘肃省",
        "qinghai" => "青海省",
        "ningxia" => "宁夏回族自治区",
        "xinjiang" => "新疆维吾尔自治区",
        "taiwan" => "台湾省",
        "xianggang" => "香港特别行政区",
        "aomen" => "澳门特别行政区"
    ];

    public function major()
    {
        return $this->hasMany('\App\Major', 'school_id', 'id');
    }

    public function getMajorCountAttribute()
    {
        return Major::whereNull('deleted_at')->where('school_id', $this->id)->count();
    }
}
