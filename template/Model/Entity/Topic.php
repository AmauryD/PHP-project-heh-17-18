<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 02-05-18
 * Time: 10:38
 */

namespace Framework\Model\Entity;


use Framework\Model\Entity;

class Topic extends Entity
{
    /**
     * @param EntityProperty $property
     * @return mixed
     */
    protected function onPropertySet(EntityProperty &$property)
    {

    }

    protected function onPropertyGet(EntityProperty &$property)
    {
        $value = $property->value();

        if (is_string($value))
            $value = htmlspecialchars($value);

        if ($property->getName() == 'content')
            $value = nl2br($value);

        return $value;
    }
}