<?php

namespace app\index\model;

use think\Model;

class SysConfigModel extends Model
{
    protected $pk = 'aid';
    protected $table = 'dede_sysconfig';

    public function getSiteName(){
         $object = $this->where('varname', 'cfg_webname')->find();
         return $object['value'];
    }

    public function getSiteKeyword(){
         $object = $this->where('varname', 'cfg_keywords')->find();
         return $object['value'];
    }

    public function getSiteDescription(){
         $object = $this->where('varname', 'cfg_description')->find();
         return $object['value'];
    }

    public function getSitePowerBy(){
         $object = $this->where('varname', 'cfg_powerby')->find();
         return $object['value'];
    }

    public function getSiteBeian(){
         $object = $this->where('varname', 'cfg_beian')->find();
         return $object['value'];
    }

}
