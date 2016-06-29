<?php

abstract class Integer2TextConverter
{
    const MIN_VALUE = 0;
    const MAX_VALUE = 999999999;

    protected $result = '';

    /**
     * Возвращает текстовую метку числа.
     *
     * @param int $number
     *
     * @return string
     */
    abstract protected function getUnits($number);

    /**
     * Возвращает текстовую метку десятка.
     *
     * @param int $number
     *
     * @return string
     */
    abstract protected function getTens($number);

    /**
     * Возвращает текстовую метку сотни.
     *
     * @param int $number
     *
     * @return string
     */
    abstract protected function getHundreds($number);

    /**
     * Получить список разрядов, на которые будем делить число.
     *
     * @return array
     */
    abstract protected function getDivisions();

    /**
     * Добавить в результат текстовую метку разряда.
     *
     * @param mixed $label
     * @param int   $number
     *
     * @return void
     */
    abstract protected function setDivisionLabel($label, $number);

    /**
     * Метод возвращает текстовый эквивалент указанного числа.
     *
     * @param int $number число.
     *
     * @return string Текстовое описание числа.
     */
    public function convert($number)
    {
        if (
            !is_integer($number)
            || $number < self::MIN_VALUE
            || $number > self::MAX_VALUE
        ) {
            exit('Error: number must be an integer between ' . self::MIN_VALUE . ' and ' . self::MAX_VALUE);
        }

        return $this->process((int)$number);
    }

    /**
     * Обработка числа и возврат результата.
     *
     * @param int $number
     *
     * @return string
     */
    protected function process($number)
    {
        // костыль для нуля)
        if ($number == 0) {
            return $this->getUnits(0);
        }

        $remainer = $number;
        // прогнать число по разрядам (млн, тыс, whatever)
        foreach ($this->getDivisions() as $division => $divisionLabel) {

            $divisionNumber = (int)($remainer / $division);

            if (!empty($divisionNumber)) {
                $remainer = $remainer % $division;
                $this->processDivision($divisionNumber, $divisionLabel);
            }
        }

        return $this->result;
    }

    /**
     * Разбор числа на сотни/десятки/единицы, их перевод для заданного языка и сохранение результата.
     *
     * @param int    $number        число.
     * @param string $divisionLabel текстовая метка разряда (миллион, тысяча и т.п.).
     *
     * @return void
     */
    protected function processDivision($number, $divisionLabel)
    {
        $remainer = $number;

        if ($number >= 100) {
            $hundreds = (int)($number / 100);
            $this->addResult($this->getHundreds($hundreds));
            $remainer = $number % 100;
        }

        if ($remainer > 19) {
            $tens = (int)($remainer / 10);
            $this->addResult($this->getTens($tens));

            $remainer = $remainer % 10;
        }

        if ($remainer > 0) {
            $this->addResult($this->getUnits($remainer));
        }

        if (!empty($divisionLabel)) {
            $this->setDivisionLabel($divisionLabel, $number);
        }

    }

    /**
     * Дополнение результирующей строки новыми данными.
     *
     * @param string $string
     * @param string $delimiter
     */
    protected function addResult($string, $delimiter = ' ')
    {
        $this->result .= !empty($this->result)
            ? $delimiter . $string
            : $string;
    }

    /**
     * Определение правильной формы существительного (©копипащено с одного из прошлых проектов)
     *
     * @param int   $number    число.
     * @param array $wordForms список форм существительного.
     *
     * @return mixed
     */
    public function plural($number, array $wordForms)
    {
        if (count($wordForms) < 3) {
            $wordForms[2] = $wordForms[1];
        }
        $number = (int)$number;
        $remainer = $number % 100;
        if ($remainer >= 5 && $remainer <= 20) {
            $result = $wordForms[2];
        } else {
            $remainer = $remainer % 10;
            if ($remainer == 1) {
                $result = $wordForms[0];
            } elseif ($remainer >= 2 && $remainer <= 4) {
                $result = $wordForms[1];
            } else {
                $result = $wordForms[2];
            }
        }

        return $result;
    }
}