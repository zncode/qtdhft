<?php

namespace app\index\model;

use think\Model;

use app\index\model\ArcTypeModel;

class WangyeModel extends Model
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
}
