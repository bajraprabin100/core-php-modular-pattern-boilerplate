<?php

if (!function_exists('dd')) {
    /**
     * Dump the passed variables and end the script.
     *
     * @param  mixed  $args
     * @return void
     */
    function dd(...$args)
    {
        echo '<pre>';
        foreach ($args as $arg) {
            print_r($arg); // Using print_r for more readable output
        }
        echo '</pre>';
        die(1);
    }
}
    if (!function_exists('getTimezoneName')) {
    
    function getTimezoneName($dateTime)
    {
        $startDateTime = '2024-06-01T10:30:00-07:00';
        $dateTime = new DateTime($startDateTime);
        $timezone = $dateTime->getTimezone();
        $timezoneName = $timezone->getName();
        echo $timezoneName;
    }
}
    if (!function_exists('convertDateTimeFormat')) {
    
        function convertDateTimeFormat($dateTime)
        {
            $dateTime = new DateTime($dateTime);
            return $dateTime->format('Y-m-d\TH:i:s');
        }
        
    
}
