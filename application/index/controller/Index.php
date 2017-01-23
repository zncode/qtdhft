<?php
namespace app\index\controller;

use app\index\model\WangyeModel;

class Index
{
    public function index()
    {
    	$wangye 	= new WangyeModel();
    	$wangye 	= $wangye->getContent('新闻');

    	return view('index/index', ['wangye'=>$wangye]);
    }
}
