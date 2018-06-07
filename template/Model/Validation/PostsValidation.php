<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 05-05-18
 * Time: 22:40
 */

namespace Framework\Model\Validation;


class PostsValidation extends Validator
{
    public function add()
    {
        $this->registerField("content")->minLenght(20)->allowEmpty(false);
    }

    public function edit()
    {
        $this->registerField("content")->minLenght(20)->allowEmpty(false);
    }
}