<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 18-04-18
 * Time: 11:10
 */

namespace Framework\Model\Table;

use Framework\Model\Table;
use PDO;

class UsersTable extends Table
{
    /**
     * @return mixed
     */
    public function initialize()
    {
        $this->declareColumn('id')
            ->setLenght(50)
            ->setDataType(PDO::PARAM_STR)
            ->setIsPrimary(true);
        $this->declareColumn('firstname')->setIsKey(true);
        $this->declareColumn('name')->setIsKey(true);
        $this->declareColumn('email')
            ->setIsKey(true);

        $this->hasMany('topics');
        $this->hasMany('posts');
        $this->hasMany('categories');
        $this->hasMany('forums');
        return;
    }

}