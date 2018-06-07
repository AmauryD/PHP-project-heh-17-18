<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 05-05-18
 * Time: 22:40
 */

namespace Framework\Model\Validation;


class UsersValidation extends Validator
{

    public function initialize()
    {

    }

    public function changePassword()
    {

    }

    public function edit()
    {
        $this->registerField("firstname")->maxLenght(30)->minLenght(2)->allowEmpty(false);
        $this->registerField("name")->maxLenght(30)->minLenght(2)->allowEmpty(false);
    }

    public function add()
    {
        $this->registerField("firstname")->maxLenght(30)->minLenght(2)->allowEmpty(false);
        $this->registerField("name")
            ->maxLenght(30)
            ->minLenght(2)
            ->allowEmpty(false);
        $this->registerField("password")
            ->minLenght(6)
            ->maxLenght(50)
            ->allowEmpty(false);
        $this->registerField("email")->custom(function ($email) {
                return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
            }, 'email format is not valid')
            ->maxLenght(255)
            ->allowEmpty(false);
    }
}