<?php

class Helper
{
    public static function cleanData($data)
    {
        $data = trim($data);
        $data = htmlentities($data, ENT_QUOTES);
        return $data;
    }
}