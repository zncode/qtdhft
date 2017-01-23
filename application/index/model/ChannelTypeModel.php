<?php

namespace app\index\model;

use think\Model;

class ChannelTypeModel extends Model
{
    protected $pk = 'id';
    protected $table = 'dede_channeltype';

    function getChannelId($channelName){
     
    	$channelObject = $this->where('typename', $channelName)->find();
    	if($channelObject){
    		return $channelObject->id;
    	}else{
    		return false;
    	}
    }
}
