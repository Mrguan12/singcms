<?php
/**
 * Created by PhpStorm.
 * User: 23061
 * Date: 2018/7/4
 * Time: 14:51
 */

namespace Common\Model;
use Think\Model;

class OrderModel extends Model
{
    private $_db = '';

    public function __construct() {
        $this->_db = M('order');
    }

    public function getNews($data,$page,$pageSize=10) {
        $conditions = $data;

        if(isset($data['status']) || $data['status']==0)  {
        }
        else{
            $conditions['status'] = array('neq',-1);
        }

        $offset = ($page - 1) * $pageSize;
        $list = $this->_db->where($conditions)
            ->order('order_id desc')
            ->limit($offset,$pageSize)
            ->select();

        return $list;
    }

    public function getNewsCount(){
        $conditions = array();

        $conditions['status'] = array('neq',-1);

        return $this->_db->where($conditions)->count();
    }

    public function updateStatusById($id, $status) {
        if(!is_numeric($status)) {
            throw_exception('status不能为非数字');
        }
        if(!$id || !is_numeric($id)) {
            throw_exception('id不合法');
        }
        $data['status'] = $status;

        return $this->_db->where('order_id='.$id)->save($data);
    }
}