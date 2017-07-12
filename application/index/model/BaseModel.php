<?php

namespace app\index\model;
use think\Model;

class BaseModel extends Model
{
    public function getImageUrl($str){
        $pos = strpos($str, '}');
        $str = substr($str, $pos+1);
        $pos = strpos($str, '{');
        $str = trim(substr($str, 0, $pos-1));
        if($_SERVER['HTTP_HOST'] == 'localhost'){
            $url = 'http://'.$_SERVER['HTTP_HOST'].'/qtdhbk'.$str;
        }else{
            $url = 'http://bk.qingting360.com'.$str;
        }
        
        return $url;
    }
}
