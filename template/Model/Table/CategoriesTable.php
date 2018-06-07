<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 23-04-18
 * Time: 12:27
 */

namespace Framework\Model\Table;


use Framework\Model\Table;

class CategoriesTable extends Table
{

    /**
     * @return mixed
     */
    public function initialize()
    {
        $this->declareColumn('id')
            ->setIsPrimary(true)
            ->setLenght(11);
        $this->hasOne('Forums');
    }


}