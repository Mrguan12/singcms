<?php
/**
 * Created by PhpStorm.
 * User: 23061
 * Date: 2018/7/5
 * Time: 10:42
 */

namespace Common\Model;
use Think\Model;

class UserModel extends Model
{
    private $_db = '';

    /**
     * TenantModel constructor.构造函数，与tenant表绑定
     */
    public function __construct() {
        $this->_db = M('user');
    }

    public function getUsers(){


        $list = $this->_db
            ->select();

        return $list;
    }
}