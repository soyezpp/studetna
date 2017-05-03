<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function pre($array = array(), $die = FALSE)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
    if ($die)
        die();
}

function detectUTF8($string)
{
    return preg_match('%(?:
        [\\xC2-\\xDF][\\x80-\\xBF] # non-overlong 2-byte
        |\\xE0[\\xA0-\\xBF][\\x80-\\xBF] # excluding overlongs
        |[\\xE1-\\xEC\\xEE\\xEF][\\x80-\\xBF]{2} # straight 3-byte
        |\\xED[\\x80-\\x9F][\\x80-\\xBF] # excluding surrogates
        |\\xF0[\\x90-\\xBF][\\x80-\\xBF]{2} # planes 1-3
        |[\\xF1-\\xF3][\\x80-\\xBF]{3} # planes 4-15
        |\\xF4[\\x80-\\x8F][\\x80-\\xBF]{2} # plane 16
        )+%xs', $string);
}

if (!function_exists('mb_ucfirst'))
{

    function mb_ucfirst($str, $encoding = "UTF-8", $lower_str_end = false)
    {
        $first_letter = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding);
        $str_end      = "";
        if ($lower_str_end)
        {
            $str_end = mb_strtolower(mb_substr($str, 1, mb_strlen($str, $encoding), $encoding), $encoding);
        }
        else
        {
            $str_end = mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
        }
        $str = $first_letter.$str_end;
        return $str;
    }

}