<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 18-04-18
 * Time: 11:10
 */

namespace Framework\Model\Table;

use Framework\Model\Table;

class ForumsTable extends Table
{
    /**
     * @return mixed
     */
    public function initialize()
    {
        $this->declareColumn('id')
            ->setIsPrimary(true);
        $this->hasMany('categories');
        $this->hasOne('users');
        return;
    }
}