<?php
/**
 * Created by PhpStorm.
 * User: AmauryD
 * Date: 18-04-18
 * Time: 11:07
 */

namespace Framework\Controller;

use Framework\Database\QueryBuilder\QueryBuilder;
use template\Controller\BaseController;

class ForumsController extends BaseController
{
    /**
     * @throws \Exception
     */
    public function index()
    {
        $forums = $this->model->select(
            QueryBuilder::select()->columns(['categories.id', 'forums.name', 'categories.name', 'forums.id'])
                ->join('categories', 'forums.id', 'categories.forum_id', 'LEFT')
                ->join('topics', 'categories.id', 'topics.category_id', 'LEFT')
        );
        $this->view->set('forums', $forums);
    }
}