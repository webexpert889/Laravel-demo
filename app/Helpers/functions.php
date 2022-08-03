<?php

if (!function_exists('getDateTimeFormatWithHtml')) {
    function getDateTimeFormatWithHtml($date,$withbr = false)
    {
        $dateOnly = \Carbon\Carbon::parse($date)->format('m/d/Y');
        $timeOnly = \Carbon\Carbon::parse($date)->format('g:iA');
        $timestamp = \Carbon\Carbon::parse($date)->timestamp;
        $date = '<span class="d-none">'.$timestamp.'</span>'.$dateOnly.' <small class="text-muted">'.$timeOnly.'</small>';
        return $date;
    }
}

if (!function_exists('getDateFormatWithHtml')) {
    function getDateFormatWithHtml($date,$withbr = false)
    {
        $dateOnly = \Carbon\Carbon::parse($date)->format('m/d/Y');
        $timestamp = \Carbon\Carbon::parse($date)->timestamp;
        $date = '<span class="d-none">'.$timestamp.'</span>'.$dateOnly;
        return $date;
    }
}
if (!function_exists('generateRandomString')) {
    function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}

if (!function_exists('getDateTimeFormat')) {
    function getDateTimeFormat($date)
    {
        $date = \Carbon\Carbon::parse($date)->format('m/d/Y g:iA');
        return $date;
    }
}
if (!function_exists('getflatpickerFormat')) {
    function getflatpickerFormat($date)
    {
        $date = \Carbon\Carbon::parse($date)->format('m-d-Y');
        return $date;
    }
}
if (!function_exists('converDateFormat')) {
    function converDateFormat($date,$oldformat,$newformat)
    {
        $date = \carbon\Carbon::CreateFromFormat($oldformat,$date)->format($newformat);
        return $date;
    }
}