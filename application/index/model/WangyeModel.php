<?php

namespace app\index\model;

use think\Model;

use app\index\model\ArcTypeModel;

class WangyeModel extends Model
{
    protected $pk = 'aid';
    protected $table = 'dede_wangye';

    public function getContent($top, $first){
       	$arcType 	= new ArcTypeModel();
 		$typeId 	= $arcType->getTypeId($top, $first);
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
