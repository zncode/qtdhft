<?php

namespace app\index\model;

use think\Model;
use app\index\model\ChannelTypeModel;

class ArcTypeModel extends Model
{
    protected $pk = 'id';
    protected $table = 'dede_arctype';

    function getTypeId($channel, $top, $first=NULL){

        $channelObject = new ChannelTypeModel();
        $channelId = $channelObject->getChannelId($channel);

        if($channelId){
            $topObject = $this->where('channeltype', $channelId)->where('typename', $top)->find();
            if($topObject){
                $topId = $topObject->id;
                if($first){
                    $firstObject = $this->where('typename', $first)->where('topid', $topId)->find();
                    if($firstObject){
                        return $firstObject->id;
                    }else{
                        return false;
                    }	    			
                }else{
                    return $topId;
                }

            }else{
                return false;
            }
        }else{
            return false;
        }
    }
}
