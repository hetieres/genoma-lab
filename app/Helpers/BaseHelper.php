<?php
namespace App\Helpers;

class BaseHelper {
    public static function functionModel($params) {
        echo '<pre>';
        print_r($params);
        echo '</pre>';
    }

    public static function limitChar($string, $limit=500, $delimiter=' <span class="limit">[...]</span>')
    {
        // strip tags to avoid breaking any html
        $string = strip_tags($string);
        if (strlen($string) > $limit) {
            // truncate string
            $stringCut = substr($string, 0, $limit);
            $endPoint  = strrpos($stringCut, ' ');

            //if the string doesn't contain any space then it will cut without word basis.
            $string    = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string   .= $delimiter;
        }

        return $string;
    }
}