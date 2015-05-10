<?php


namespace THack2015\Infrastructure\Cache;

class CacheAccess
{

    public function get($key)
    {

        $cachePath = "../cache/" . md5($key);

        if (!file_exists($cachePath)) {
            return null;
        }

        $data = json_decode($cachePath);

        if ($data['expire'] < time()) {
            unlink($cachePath);
            return null;
        }

        return $data['data'];
    }

    public function set($key, $value, $expiry = 60)
    {

        $f = fopen('../cache/'.md5($key),'w+');


        fwrite($f,json_encode(

                [
                    'data' => $value,
                    'expire' => time() + $expiry

                ]

            ));

        fclose($f);
    }
}