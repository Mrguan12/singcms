<?php
/**
 * Created by PhpStorm.
 * User: 23061
 * Date: 2018/7/4
 * Time: 11:20
 */

namespace Common\Model;
use Think\Model;

class TenantModel extends Model
{
    private $_db = '';

    /**
     * TenantModel constructor.构造函数，与tenant表绑定
     */
    public function __construct() {
        $this->_db = M('tenant');
    }

    /**
     * @param string $username根据用户名查找出租者
     * @return mixed返回查找结果
     */
    public function getAdminByUsername($username='') {
        $res = $this->_db->where('tenant_nickname="'.$username.'"')->find();
        return $res;
    }

    public function getAdminByAdminId($adminId=0) {
        $res = $this->_db->where('tenant_id='.$adminId)->find();
        return $res;
    }

}