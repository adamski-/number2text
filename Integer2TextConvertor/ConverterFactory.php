<?php

/**
 * Created by PhpStorm.
 * User: denis
 * Date: 27.06.2016
 * Time: 17:14
 */
abstract class ConverterFactory
{
    /**
     * @param string $language
     * @return Integer2TextConverter
     * @throws Exception
     */
    public static function getConverter($language)
    {
        $className = 'Converter' . ucfirst(strtolower($language));

        try {
            if (!class_exists($className)) {
                throw new Exception ("Class '$className' not found'");
            }

            $object = new $className;

            if (!($object instanceof Integer2TextConverter)) {
                throw new Exception ("Class '$className' is incorrect'");
            }

            return $object;
            
        } catch (Exception $e) {
            exit($e->getMessage());
        }

    }
}