<?php

class func
{
    public static function randomLink()
    {
        $string = "QWERTYUIOPASDFGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm1234567890";
        $s = '';
        $r_new = '';
        $r_old = '';

        for ($i = 0; $i < 8; $i++) {
            while ($r_new == $r_old) {
                $r_new = rand(0, strlen($string) - 1);
            }
            $r_old = $r_new;
            $s .= $string[$r_new];
        }

        return $s;
    }
}
