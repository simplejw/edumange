<?php

namespace app\components;

class Helper
{

    /**
     * 生成随机码
     *
     * @access public
     * @param  boolean $number 是否是全数字
     * @param  integer $length 长度
     * @return string
     */
    public static function generateVerifyCode($number = false, $length = 5)
    {
        $letters = 'bcdfghjklmnpqrstvwxyz123456789';
        $vowels = 'aeiou';
        $code = '';

        if ($number)
        {
            for($i = 0; $i < $length; $i++) {
                $code .= mt_rand(0, 9);
            }
        }
        else
        {
            for($i = 0; $i < $length; ++$i)
            {
                if($i % 2 && mt_rand(0,10) > 2 || !($i % 2) && mt_rand(0,10) > 9)
                    $code.=$vowels[mt_rand(0,4)];
                else
                    $code.=$letters[mt_rand(0,29)];
            }
        }

        return $code;
    }



    /**
     * 格式化参数格式化成url参数
     */
    public function ToUrlParams()
    {
        $buff = "";
        foreach ($this->values as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     * 模糊字符串
     * @access public
     * @param string $string
     * @return string
     */
    public static function breviary($string)
    {
        $_str = '';
        preg_match_all("/./us", $string, $match);
        $pos = count($match[0]);
        $_suf = '';

        if ($pos === false) $_str = $string;
        else
        {
            $_str = mb_substr($string, 0, $pos);
            $_suf = mb_substr($string, $pos);
        }

        $avg = round($pos / 3);
        return mb_substr($_str, 0, $avg) . str_repeat('*', $avg) . mb_substr($_str, $avg * 2) . $_suf;
    }

    /**
     * 格式化价格
     * @access public
     * @param  string $string
     * @return float
     **/
    public static function priceFormat($string)
    {
        return number_format(floatval($string), 2, '.', '');
    }

    /**
     * 获取缩略图
     * @access public
     * @param string $string
     * @param type string
     * @return string
     */
    public static function thumb($string, $type = 't')
    {
        $to = '';
        switch ($type)
        {
            case 's':
                $to = 's';
                break;
            case 'm':
                $to = 'm';
                break;
            case 't':
                $to = 't';
                break;
        }

        return $string . '!' . $to;
    }

    /**
     * 创建订单号
     *
     * @access public
     * @return string
     */
    public static function CreateSn()
    {
        mt_srand((double) microtime() * 1000000);
        return intval(date('ymd')) * 2 . str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
    }

    /**
     * 通过http请求数据
     * @access public
     * @param  string $url 网址
     * @param  string $method 请求方式 默认GET
     * @param  array  $args 请求参数
     * @param  array  $header 头部
     * @param  integer $timeout 超时时间 默认30秒
     * @return string
     */
    public static function curlContents($url, $method = 'GET', $args = array(), $header = array(), $timeout = 30)
    {
        $response = '';

        if (filter_var($url, FILTER_VALIDATE_URL))
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36');

            if ($method == 'POST')
            {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
            }

            $response = curl_exec($ch);
            curl_close($ch);
        }

        return $response;
    }

    /**
     * 分页数据
     * @param $pagination
     * @return array
     */
    public static function pagination($pagination)
    {
        return [
            'totalCount' => (int) $pagination->totalCount,
            'pageCount' => $pagination->getPageCount(),
            'currentPage' => $pagination->getPage() + 1,
            'perPage' => $pagination->getPageSize(),
        ];

    }
}
