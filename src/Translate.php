<?php

namespace Youdao\Translate;


class Translate
{
    private $timeout = 20;
    //翻译入口

    /**
     * @param $query
     * @param $from
     * @param $to
     * @return bool|mixed|string
     */
    public function translate($query, $from, $to)
    {
        $args = array(
            'q' => $query,
            'appKey' => config('youdao.apiKey'),
            'salt' => rand(10000,99999),
            'from' => $from,
            'to' => $to,

        );
        $args['sign'] = $this->buildSign(config('youdao.apiKey'), $query, $args['salt'], config('youdao.apiSecret'));
        $ret = $this->call(config('youdao.apiUrl'), $args);
        // echo $ret;
        $ret = json_decode($ret, true);
        return $ret;
    }

    //加密

    /**
     * @param $appKey
     * @param $query
     * @param $salt
     * @param $secKey
     * @return string
     */
    public function buildSign($appKey, $query, $salt, $secKey)
    {/*{{{*/
        //dd($query);
        $str = $appKey . $query . $salt . $secKey;

        $ret = md5($str);
        return $ret;
    }/*}}}*/

    //发起网络请求
    /**
     * @param $url
     * @param null $args
     * @param string $method
     * @param int $testflag
     * @param int $timeout
     * @param array $headers
     * @return bool|string
     */
    public function call($url, $args=null, $method="post", $testflag = 0, $timeout = 0, $headers=array())
    {/*{{{*/
        $ret = false;
        $i = 0;
        while($ret === false)
        {
            if($i > 1)
                break;
            if($i > 0)
            {
                sleep(1);
            }
            $ret = $this->callOnce($url, $args, $method, false, $this->timeout, $headers);
            $i++;
        }
        return $ret;
    }/*}}}*/

    /**
     * @param $url
     * @param null $args
     * @param string $method
     * @param bool $withCookie
     * @param int $timeout
     * @param array $headers
     * @return bool|string
     */
    public function callOnce($url, $args=null, $method="post", $withCookie = false, $timeout = 0, $headers=array())
    {/*{{{*/
        $timeout = $this->timeout;
        $ch = curl_init();
        if($method == "post")
        {
            $data = $this->convert($args);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_POST, 1);
        }
        else
        {
            $data = $this->convert($args);
            if($data)
            {
                if(stripos($url, "?") > 0)
                {
                    $url .= "&$data";
                }
                else
                {
                    $url .= "?$data";
                }
            }
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(!empty($headers))
        {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        }
        if($withCookie)
        {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $_COOKIE);
        }
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }/*}}}*/

    /**
     * @param $args
     * @return string
     */
    public function convert(&$args)
    {/*{{{*/
        $data = '';
        if (is_array($args))
        {
            foreach ($args as $key=>$val)
            {
                if (is_array($val))
                {
                    foreach ($val as $k=>$v)
                    {
                        $data .= $key.'['.$k.']='.rawurlencode($v).'&';
                    }
                }
                else
                {
                    $data .="$key=".rawurlencode($val)."&";
                }
            }
            return trim($data, "&");
        }
        return $args;
    }/*}}}*/
}