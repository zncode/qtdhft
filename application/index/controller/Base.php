<?php
namespace app\index\controller;

use app\index\model\SysConfigModel;

class Base  
{
    public $pageTitle;
    public $pageKeyword;
    public $pageDescription;
    public $pagePowerBy;
    public $pageBeian;

    public function __construct(){
        $this->setPageTitle();
        $this->setPageKeyword();
        $this->setPageDescription();

        $page['title']          = $this->pageTitle;
        $page['keyword']        = $this->pageKeyword;
        $page['description']    = $this->pageDescription;
        $page['powerBy']        = $this->getPagePowerBy();
        $page['beian']          = $this->getPageBeian();

        \think\View::share($page);
    }

    public function getPageTitle(){
        $sysConfig = new SysConfigModel();
        $title = $sysConfig->getSiteName();
        return $title;
    }

    public function getPageKeyword(){
        $sysConfig = new SysConfigModel();
        $keyword = $sysConfig->getSiteKeyword();
        return $keyword;        
    }

    public function getPageDescription(){
        $sysConfig = new SysConfigModel();
        $description = $sysConfig->getSiteDescription();
        return $description;        
    }

    public function getPagePowerBy(){
        $sysConfig = new SysConfigModel();
        $powerBy = $sysConfig->getSitePowerBy();
        return $powerBy;       
    }

    public function getPageBeian(){
        $sysConfig = new SysConfigModel();
        $beian = $sysConfig->getSiteBeian();
        return $beian;        
    }

    public function setPageTitle(){
         $this->pageTitle = $this->getPageTitle();
    }

    public function setPageKeyword(){
        $this->pageKeyword = $this->getPageKeyword();
    }

    public function setPageDescription(){
        $this->pageDescription = $this->getPageDescription();
    }
}
