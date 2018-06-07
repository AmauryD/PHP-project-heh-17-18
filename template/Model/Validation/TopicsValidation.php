<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 05-05-18
 * Time: 22:40
 */

namespace Framework\Model\Validation;


use DateTime;

class TopicsValidation extends Validator
{
    public function add()
    {
        $this->registerField("name")->maxLenght(50)->minLenght(5)->allowEmpty(false);
        $this->registerField("content")->minLenght(20)->allowEmpty(false);
        $this->registerField("expires")->custom(function ($date) {
                if (is_null($date)) return true;
                return (DateTime::createFromFormat('Y-d-m h:m', $date) !== false);
            }, 'date is not valid');
    }

    public function edit()
    {
        $this->registerField("name")->maxLenght(50)->minLenght(5)->allowEmpty(false);
        $this->registerField("content")->minLenght(20)->allowEmpty(false);
    }

    /**
     * @return mixed
     */
    public function initialize()
    {
        // TODO: Implement initialize() method.
    }
}