<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 06-05-18
 * Time: 16:09
 */

namespace Framework\Helpers;


trait HtmlTrait
{
    /**
     * @param array $options
     * @param array $exceptions
     * @return string
     */
    private function buildAttributes($options = [], $exceptions = [])
    {
        $attr = [];

        foreach ($options as $option => $value) {
            if (is_bool($value)) {
                $boolean = ($value) ? 'true' : 'false';
                $attr[] = "$option=$boolean";
                continue;
            }
            $attr[] = "$option='$value'";
        }

        return $this->checkEscape(implode(' ', $attr), $options);
    }

    /**
     * @param $string
     * @param $options
     * @return string
     */
    private function checkEscape($string, $options)
    {
        $string = $this->canUnescape($options) ? $string : htmlspecialchars($string);
        return $string;
    }

    /**
     * @param $options
     * @return bool
     */
    private function canUnescape($options)
    {
        if (isset($options['unescape']))
            if ($options['unescape'] === true)
                return true;
        return false;
    }
}