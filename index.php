<?php
$string = file_get_contents('input.txt');

$start = "do()";
$stop = "don't()";
$string2 = startStop($string, $start, $stop);

echo 'The results of the multiplications: ' . validMuls($string) . '<br>';
echo 'The results of the enabled multiplications: ' . validMuls($string2) . '<br>';

function validMuls($string) {
    $sum = 0;
    // get valid mul
    preg_match_all('/mul\(\d+\,\d+\)/', $string, $matches);

    foreach ($matches[0] as $match) {
        // extract the numbers
        preg_match_all('/\d+/', $match, $numbers);
        $numbers = $numbers[0];
        $no1 = $numbers[0];
        $no2 = $numbers[1];

        $sum += $no1*$no2;
    }

    return $sum;
}

function startStop($string, $start, $stop) {
    $newString = '';
    $firstPart = strstr($string, $stop, true);
    $newString .= $firstPart;
    // remove first part from string
    $string = str_replace($firstPart.$stop,'',$string);

    while (!empty($string)) {
        // remove string before START
        $beforeStart = strstr($string, $start, true);
        $string = str_replace($beforeStart.$start,'',$string);

        // if no STOP left
        if (strpos($string, $stop) === false) {
            $newString .= $string;
            $string = false;
        }

        // get the substring before STOP and assign to the new string
        $beforeStop = strstr($string, $stop, true);
        $newString .= $beforeStop;

        // remove before stop substring from string
        $string = str_replace($beforeStop.$stop,'',$string);
        
        // if no START left
        if (strpos($string, $start) === false) {
            $string = false;
        }
    }
    
    return $newString;
}