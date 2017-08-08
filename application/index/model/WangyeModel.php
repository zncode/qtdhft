<?php

namespace app\index\model;

use think\Model;
use app\index\model\BaseModel;
use app\index\model\ArcTypeModel;

class WangyeModel extends BaseModel
{
    protected $pk = 'aid';
    protected $table = 'dede_wangye';
    protected $channel = '网页';

    public function getContent($top, $first=NULL){
        $arcType 	= new ArcTypeModel();
        $typeId 	= $arcType->getTypeId($this->channel, $top);
        if($typeId){
            $content = $this->where('typeid', $typeId)->select();

            if($content){
                return $content;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function getIndexContent($first, $second){
        $arcType      = new ArcTypeModel();
        $secondId     = $arcType->getTypeId($this->channel, $first, $second);
        if($secondId){
            $content = $this->where('typeid', $secondId)->where('flag', 'c')->select();
            if($content){
                foreach($content as $key => $value){
                    if($value['favicon']){
                        $content[$key]['favicon'] = $this->getImageUrl($value['favicon']);
                    }
                    if($value['logo']){
                        $content[$key]['logo'] = $this->getImageUrl($value['logo']);
                    }
                }    
                return $content;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function getCategoryContent($first, $second){
        $arcType      = new ArcTypeModel();
        $secondId     = $arcType->getTypeId($this->channel, $first, $second);
        if($secondId){
            $content = $this->where('typeid', $secondId)->select();
            if($content){
                return $content;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
