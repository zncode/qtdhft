<?php

namespace app\index\model;

use think\Model;

class ArcTypeModel extends Model
{
    protected $pk = 'id';
    protected $table = 'dede_arctype';

    function getTypeId($top, $first){
    	$topObject = $this->where('typename', $top)->find();
    	if($topObject){
    		$topId = $topObject->id;
    		$firstObject = $this->where('typename', $first)->where('topid', $topId)->find();
    		if($firstObject){
    			return $firstObject->id;
    		}else{
    			return false;
    		}
    	}else{
    		return false;
    	}
    }
}
