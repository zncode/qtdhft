<?php
namespace app\index\controller;

use app\index\model\WangyeModel;
use app\index\model\ArcTypeModel;

class News extends Base
{

    public function index()
    {
        $wangye = new WangyeModel();
        $part_1['综合'] 	  = $wangye->getCategoryContent('新闻', '综合');
        $part_1['官方']       = $wangye->getCategoryContent('新闻', '官方');
        $part_1['地方']       = $wangye->getCategoryContent('新闻', '地方');
        $part_1['国际']       = $wangye->getCategoryContent('新闻', '国际');
        $part_1['新媒体'] 	  = $wangye->getCategoryContent('新闻', '新媒体');
        $part_1['自媒体']     = $wangye->getCategoryContent('新闻', '自媒体');
        $part_1['报刊']       = $wangye->getCategoryContent('新闻', '报刊');
        $part_1['专栏']       = $wangye->getCategoryContent('新闻', '专栏');

        $params['one'] 		=  $part_1;

        return view('news/news', $params);
    }

    public function setPageTitle(){
        $arcType = new ArcTypeModel();
        $type = $arcType->where('typename', '新闻')->where('topid',0)->where('channeltype', '-17')->find();
        $this->pageTitle = $type['seotitle'];
    }

    public function setPageKeyword(){
        $arcType = new ArcTypeModel();
        $type = $arcType->where('typename', '新闻')->where('topid',0)->where('channeltype', '-17')->find();
        $this->pageKeyword = $type['keywords'];
    }

    public function setPageDescription(){
        $arcType = new ArcTypeModel();
        $type = $arcType->where('typename', '新闻')->where('topid',0)->where('channeltype', '-17')->find();
        $this->pageDescription = $type['description'];
    }
}
