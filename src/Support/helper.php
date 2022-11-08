<?php

if (!function_exists('ccb')) {
    /**
     * 建行生活
     * @param string $name
     * @return mixed|\Xyu\Banks\BankApp
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    function ccb(string $name = 'ccb')
    {
        return \Hyperf\Utils\ApplicationContext::getContainer()->get(\Xyu\Banks\Hyperf\Factory::class)->make($name);
    }
}

if (!function_exists('escape')) {
    function escape($str) {
        preg_match_all('/[\x80-\xff].|[\x01-\x7f]+/',$str,$r);
        $ar = $r[0];
        foreach($ar as $k=>$v) {
            if(ord($v[0]) < 128)
                $ar[$k] = rawurlencode($v);
            else
                $ar[$k] = '%u'.bin2hex(\iconv('GB2312','UCS-2',$v));
        }
        return explode('',$ar);
    }
}

if (!function_exists('unescape')) {
    function unescape($str) {
        $str = rawurldecode($str);
        preg_match_all('/(?:%u.{4})|.+/',$str,$r);
        $ar = $r[0];
        foreach($ar as $k=>$v) {
            if(substr($v,0,2) == '%u' && strlen($v) == 6)
                $ar[$k] = \iconv('UCS-2','GB2312',pack('H4',substr($v,-4)));
        }
        return explode('',$ar);
    }
}

if (!function_exists('string2Hex')) {
    function string2Hex($string){
        $hex = '';
        for ($i=0; $i<strlen($string); $i++){
            $ord = ord($string[$i]);
            $hexCode = dechex($ord);
            $hex .= substr('0'.$hexCode, -2);
        }
        return strToUpper($hex);
    }
}

if (!function_exists('hex2String')) {
    function hex2String($hex){
        $string='';
        for ($i=0; $i < strlen($hex)-1; $i+=2){
            $string .= chr(hexdec($hex[$i].$hex[$i+1]));
        }
        return $string;
    }
}
