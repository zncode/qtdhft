<?php
namespace app\index\controller;

use app\index\model\WangyeModel;
use app\index\model\ArcTypeModel;

class Index
{
    public function index()
    {
        $arcType = new ArcTypeModel();
        $wangye = new WangyeModel();
        $types = $arcType->where('channeltype','-17')->where('topid',0)->select();
        foreach($types as $type)
        {
            $params['wangye'][$type->typename] = $wangye->getContent($type->typename);
        }
        return view('index/index', $params);
    }

    public function updateContent(){
        $wangye 	= new WangyeModel();
        $contents   = $wangye::all();
        foreach($contents as $content){
            $url 	= $content->url;	
            $id 	= $content->aid;

            // $meta_tags = get_meta_tags($url);
            $meta_tags = $this->getUrlData($url);
            print_r($url);
            echo '<br>';
            print_r($meta_tags);
            echo '<br>';
            // $keywords 		= $meta_tags['keywords'];
            // $description 	= $meta_tags['description'];
            // $wangyeUpdate = WangyeModel::get($id);

            // $wangyeUpdate->save([
            //     'keyword' => $keywords,
            //     'content' => $description,
            // ],['id' => $id]);
            // die();
        }

        $icoApi = 'http://favicon.byi.pw/?url=';


        return '';
    }

    public function getUrlData($url, $raw=false) // $raw - enable for raw display
    {
        $result = false;

        $contents = $this->getUrlContents($url);

        // print_r($contents);
        if (isset($contents) && is_string($contents))
        {
            $title = null;
            $metaTags = null;
            $metaProperties = null;

            preg_match('/<title>([^>]*)<\/title>/si', $contents, $match );

            if (isset($match) && is_array($match) && count($match) > 0)
            {
                $title = strip_tags($match[1]);
            }

            preg_match_all('/<[\s]*meta[\s]*(name|property)="?' . '([^>"]*)"?[\s]*' . 'content="?([^>"]*)"?[\s]*[\/]?[\s]*>/si', $contents, $match);

            if (isset($match) && is_array($match) && count($match) == 4)
            {
                $originals = $match[0];
                $names = $match[2];
                $values = $match[3];

                if (count($originals) == count($names) && count($names) == count($values))
                {
                    $metaTags = array();
                    $metaProperties = $metaTags;
                    if ($raw) {
                        if (version_compare(PHP_VERSION, '5.4.0') == -1)
                            $flags = ENT_COMPAT;
                        else
                            $flags = ENT_COMPAT | ENT_HTML401;
                    }

                    for ($i=0, $limiti=count($names); $i < $limiti; $i++)
                    {
                        if ($match[1][$i] == 'name')
                            $meta_type = 'metaTags';
                        else
                            $meta_type = 'metaProperties';
                        if ($raw)
                            ${$meta_type}[$names[$i]] = array (
                                'html' => htmlentities($originals[$i], $flags, 'UTF-8'),
                                'value' => $values[$i]
                            );
                        else
                            ${$meta_type}[$names[$i]] = array (
                                'html' => $originals[$i],
                                'value' => $values[$i]
                            );
                    }
                }
            }
            // print_r($title);


            $result = array (
                'title' => $title,
                'metaTags' => $metaTags,
                'metaProperties' => $metaProperties,
            );
        }

        return $result;
    }

    public function getUrlContents($url, $maximumRedirections = null, $currentRedirection = 0)
    {
        $result = false;
        ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; .NET CLR 1.1.4322)');

        header('Content-Type:text/html;charset=utf-8' ); 

        $file = fopen($url, "rb");   
        //只读2字节  如果为(16进制)1f 8b (10进制)31 139则开启了gzip ; 
        $bin = fread($file, 2);  
        fclose($file);   
        $strInfo = @unpack("C2chars", $bin);   
        $typeCode = intval($strInfo['chars1'].$strInfo['chars2']);   
        $isGzip = 0;   
        switch ($typeCode)   
        { 
        case 31139:       
            //网站开启了gzip 
            $isGzip = 1; 
            break; 
        default:   
            $isGzip = 0; 
        }   
        $url = $isGzip ? "compress.zlib://".$url:$url; // 三元表达式 

        $contents = @file_get_contents($url);

        // $contents = curl_get($url, true);
        if(! mb_check_encoding($contents, 'utf-8')) {
            $contents = mb_convert_encoding($contents,'UTF-8','gbk');
        }
        // Check if we need to go somewhere else

        if (isset($contents) && is_string($contents))
        {
            preg_match_all('/<[\s]*meta[\s]*http-equiv="?REFRESH"?' . '[\s]*content="?[0-9]*;[\s]*URL[\s]*=[\s]*([^>"]*)"?' . '[\s]*[\/]?[\s]*>/si', $contents, $match);

            if (isset($match) && is_array($match) && count($match) == 2 && count($match[1]) == 1)
            {
                if (!isset($maximumRedirections) || $currentRedirection < $maximumRedirections)
                {
                    return getUrlContents($match[1][0], $maximumRedirections, ++$currentRedirection);
                }

                $result = false;
            }
            else
            {
                $result = $contents;
            }
        }

        return $contents;
    }

    public function get_sitemeta($url) {

        $data = file_get_contents($url);

        $meta = array();
        if (!empty($data)) {
            #Title
            preg_match('/<TITLE>([\w\W]*?)<\/TITLE>/si', $data, $matches);
            if (!empty($matches[1])) {
                $meta['title'] = $matches[1];
            }

            #Keywords
            preg_match('/<META\s+name="keywords"\s+content="([\w\W]*?)"/si', $data, $matches);         
            if (empty($matches[1])) {
                preg_match("/<META\s+name='keywords'\s+content='([\w\W]*?)'/si", $data, $matches);              
            }
            if (empty($matches[1])) {
                preg_match('/<META\s+content="([\w\W]*?)"\s+name="keywords"/si', $data, $matches);              
            }
            if (empty($matches[1])) {
                preg_match('/<META\s+http-equiv="keywords"\s+content="([\w\W]*?)"/si', $data, $matches);              
            }
            if (!empty($matches[1])) {
                $meta['keywords'] = $matches[1];
            }

            #Description
            preg_match('/<META\s+name="description"\s+content="([\w\W]*?)"/si', $data, $matches);         
            if (empty($matches[1])) {
                preg_match("/<META\s+name='description'\s+content='([\w\W]*?)'/si", $data, $matches);              
            }
            if (empty($matches[1])) {
                preg_match('/<META\s+content="([\w\W]*?)"\s+name="description"/si', $data, $matches);                        
            }
            if (empty($matches[1])) {
                preg_match('/<META\s+http-equiv="description"\s+content="([\w\W]*?)"/si', $data, $matches);              
            }
            if (!empty($matches[1])) {
                $meta['description'] = $matches[1];
            }
        }

        return $meta;
    }
}
