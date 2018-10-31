<?php

namespace App\Handlers;
use GuzzleHttp\Client;
use Overtrue\Pinyin\Pinyin;
class SlugTranslateHandler{

    public $api = 'http://api.fanyi.baidu.com/api/trans/vip/translate?';
    public $appid = '';
    public $key = '';
    public $from = 'zh';
    public $to = 'en';

    public function __construct()
    {
        $this->appid = config('services.baidu_translate.appid');
        $this->key = config('services.baidu_translate.key');
    }

    public function translate($text){
        $http = new Client;
        if(empty($this->appid) || empty($this->key)){
            //备用方案：生成拼音
            return $this->pinyin($text);
        }

        //接口请求
        $response = $http->get($this->getQuery($text));
        $result = json_decode($response->getBody(), true);

        /**
        获取结果，如果请求成功，dd($result) 结果如下：

        array:3 [▼
            "from" => "zh"
            "to" => "en"
            "trans_result" => array:1 [▼
                0 => array:2 [▼
                    "src" => "XSS 安全漏洞"
                    "dst" => "XSS security vulnerability"
                ]
            ]
        ]

        **/

        if (isset($result['trans_result'][0]['dst'])){
            return str_slug($result['trans_result'][0]['dst']);
        }else{
            //如果百度翻译没有结果，使用拼音作为后备计划
            //照思路这里应该返回报错，翻译API接入有问题
            return $this->pinyin($text);
        }
    }

    /**
     * 组装请求数据
     * @param  [string] $text [待翻译文字]
     * @return [string]       [接口请求地址]
     */
    public function getQuery($text){
        // 根据文档，生成 sign
        // http://api.fanyi.baidu.com/api/trans/product/apidoc
        // appid+q+salt+密钥 的MD5值
        $salt = time();
        $sign = md5($this->appid. $text . $salt . $this->key);

        // 构建请求参数
        $query = http_build_query([
            "q"     =>  $text,
            "from"  => $this->from,
            "to"    => $this->to,
            "appid" => $this->appid,
            "salt"  => $salt,
            "sign"  => $sign,
        ]);
        return $this->api.$query;
    }

    public function pinyin($text)
    {
        return str_slug(app(Pinyin::class)->permalink($text));
    }

}