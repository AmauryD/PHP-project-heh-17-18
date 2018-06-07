<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 05-05-18
 * Time: 22:40
 */

namespace Framework\Model\Validation;


class CategoriesValidation extends Validator
{
    public function add()
    {
        $this->registerField("name")->maxLenght(50)->minLenght(5)->allowEmpty(false);
    }

    public function edit()
    {
        $this->registerField("name")->maxLenght(50)->minLenght(5)->allowEmpty(false);
    }
}