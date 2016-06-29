<?php

class ConverterRus extends Integer2TextConverter
{
    /** @var array Словарь уникальных чисел */
    protected $units
        = [
            0  => 'ноль',
            1  => 'один',
            2  => 'два',
            3  => 'три',
            4  => 'четыре',
            5  => 'пять',
            6  => 'шесть',
            7  => 'семь',
            8  => 'восемь',
            9  => 'девять',
            10 => 'десять',
            11 => 'одиннадцать',
            12 => 'двенадцать',
            13 => 'тринадцать',
            14 => 'четырнадцать',
            15 => 'пятнадцать',
            16 => 'шестнадцать',
            17 => 'семнадцать',
            18 => 'восемнадцать',
            19 => 'девятнадцать',
        ];

    /** @var array Словарь десяток */
    protected $tens
        = [
            2 => 'двадцать',
            3 => 'тридцать',
            4 => 'сорок',
            5 => 'пятьдесят',
            6 => 'шестьдесят',
            7 => 'семьдесят',
            8 => 'восемьдесят',
            9 => 'девяносто',
        ];
    /** @var array Словарь сотен */
    protected $hundreds
        = [
            1 => 'сто',
            2 => 'двести',
            3 => 'триста',
            4 => 'четыреста',
            5 => 'пятьсот',
            6 => 'шестьсот',
            7 => 'семьсот',
            8 => 'восемьсот',
            9 => 'девятьсот',
        ];

    protected function getUnits($index)
    {
        return $this->units[$index];
    }

    protected function getTens($index)
    {
        return $this->tens[$index];
    }

    protected function getHundreds($index)
    {
        return $this->hundreds[$index];
    }

    protected function getDivisions()
    {
        return [
            1000000 => array('миллион', 'миллиона', 'миллионов'),
            1000    => array('тысяча', 'тысячи', 'тысяч'),
            1       => array(),
        ];
    }

    protected function setDivisionLabel($title, $number = 0)
    {
        $this->addResult($this->plural($number, $title));
        $this->fixGender();
    }

    /**
     * Костыль для слова тысяча. Приводит числительные "один" и "два" в форму женского рода.
     */
    protected function fixGender()
    {
        $this->result = str_replace(['один тысяча', 'два тысячи'], ['одна тысяча', 'две тысячи'], $this->result);
    }
}