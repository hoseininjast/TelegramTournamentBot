<?php

namespace App\Classes;

class Number2Word
{

    protected $digit1 = array("0"=>"zero","1"=>"one","2"=>"two","3"=>"three","4"=>"four","5"=>"five","6"=>"six","7"=>"seven","8"=>"eight","9"=>"nine");
    protected $digit1_5 = array("0"=>"ten","1"=>"eleven","2"=>"twelve","3"=>"thirteen","4"=>"fourteen","5"=>"fifteen","6"=>"sixteen","7"=>"seventeen","8"=>"eighteen","9"=>"nineteen");
    protected $digit2 =array("1"=>"ten","2"=>"twenty","3"=>"thirty","4"=>"forty","5"=>"fifty","6"=>"sixty","7"=>"seventy","8"=>"eighty","9"=>"ninety");
    protected $digit3 = array(
        1 => 'صد',
        2 => 'دویست',
        3 => 'سیصد',
        4 => 'چهارصد',
        5 => 'پانصد',
        6 => 'ششصد',
        7 => 'هفتصد',
        8 => 'هشتصد',
        9 => 'نهصد',
    );
    protected $steps = array(
        1 => 'هزار',
        2 => 'میلیون',
        3 => 'بیلیون',
        4 => 'تریلیون',
        5 => 'کادریلیون',
        6 => 'کوینتریلیون',
        7 => 'سکستریلیون',
        8 => 'سپتریلیون',
        9 => 'اکتریلیون',
        10 => 'نونیلیون',
        11 => 'دسیلیون',
    );
    protected $t = array(
        'and' => 'و',
    );

    function number_format($number, $decimal_precision = 0, $decimals_separator = '.', $thousands_separator = ',') {
        $number = explode('.', str_replace(' ', '', $number));
        $number[0] = str_split(strrev($number[0]), 3);
        $total_segments = count($number[0]);
        for ($i = 0; $i < $total_segments; $i++) {
            $number[0][$i] = strrev($number[0][$i]);
        }
        $number[0] = implode($thousands_separator, array_reverse($number[0]));
        if (!empty($number[1])) {
            $number[1] = round($number[1], $decimal_precision);
        }
        return implode($decimals_separator, $number);
    }

    protected function groupToWords($group) {
        $d3 = floor($group / 100);
        $d2 = floor(($group - $d3 * 100) / 10);
        $d1 = $group - $d3 * 100 - $d2 * 10;

        $group_array = array();

        if ($d3 != 0) {
            $group_array[] = $this->digit3[$d3];
        }

        if ($d2 == 1 && $d1 != 0) { // 11-19
            $group_array[] = $this->digit1_5[$d1];
        } else if ($d2 != 0 && $d1 == 0) { // 10-20-...-90
            $group_array[] = $this->digit2[$d2];
        } else if ($d2 == 0 && $d1 == 0) { // 00
        } else if ($d2 == 0 && $d1 != 0) { // 1-9
            $group_array[] = $this->digit1[$d1];
        } else { // Others
            $group_array[] = $this->digit2[$d2];
            $group_array[] = $this->digit1[$d1];
        }

        if (!count($group_array)) {
            return FALSE;
        }

        return $group_array;
    }

   /* public function numberToWords($number) {
        $formated = $this->number_format($number, 0, '.', ',');
        $groups = explode(',', $formated);

        $steps = count($groups);

        $parts = array();
        foreach ($groups as $step => $group) {
            $group_words = self::groupToWords($group);
            if ($group_words) {
                $part = implode(' ' . $this->t['and'] . ' ', $group_words);
                if (isset($this->steps[$steps - $step - 1])) {
                    $part .= ' ' . $this->steps[$steps - $step - 1];
                }
                $parts[] = $part;
            }
        }
        return implode(' ' . $this->t['and'] . ' ', $parts);
    }*/

    public function numToWordForStages($number) {
        $units = array('', 'one', 'two', 'three', 'four',
            'five', 'six', 'seven', 'eight', 'nine');

        $tens = array('', 'ten', 'twenty', 'thirty', 'forty',
            'fifty', 'sixty', 'seventy', 'eighty',
            'ninety');

        $special = array('eleven', 'twelve', 'thirteen',
            'fourteen', 'fifteen', 'sixteen',
            'seventeen', 'eighteen', 'nineteen');

        $words = '';


        if ($number < 10) {
            $words .= $units[$number];
        } elseif ($number < 20) {
            $words .= $special[$number - 11];
        } else {
            $words .= $tens[(int)($number / 10)] . ' '
                . $units[$number % 10];
        }


        return $words;
    }

    function numberToWords($number): string
    {
        $words = array(
            0 => 'zero', 1 => 'one', 2 => 'two',
            3 => 'three', 4 => 'four', 5 => 'five',
            6 => 'six', 7 => 'seven', 8 => 'eight',
            9 => 'nine', 10 => 'ten', 11 => 'eleven',
            12 => 'twelve', 13 => 'thirteen',
            14 => 'fourteen', 15 => 'fifteen',
            16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen',
            19 => 'nineteen', 20 => 'twenty', 30 => 'thirty',
            40 => 'forty', 50 => 'fifty', 60 => 'sixty',
            70 => 'seventy', 80 => 'eighty',
            90 => 'ninety'
        );

        if ($number < 20) {
            return $words[$number];
        }

        if ($number < 100) {
            return $words[10 * floor($number / 10)] .
                ' ' . $words[$number % 10];
        }

        if ($number < 1000) {
            return $words[floor($number / 100)] . ' hundred '
                . $this->numToWordsRec($number % 100);
        }

        if ($number < 1000000) {
            return $this->numToWordsRec(floor($number / 1000)) .
                ' thousand ' . $this->numToWordsRec($number % 1000);
        }

        return $this->numToWordsRec(floor($number / 1000000)) .
            ' million ' . $this->numToWordsRec($number % 1000000);
    }


}
