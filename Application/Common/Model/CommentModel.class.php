<?php
/**
 * Created by PhpStorm.
 * User: 23061
 * Date: 2018/7/5
 * Time: 15:59
 */

namespace Common\Model;
use Think\Model;

class CommentModel extends Model
{
    private $_db = '';
    public function __construct() {
        $this->_db = M('comment');
    }

    public function getComments() {
        $list = $this->_db
            ->select();

        return $list;
    }

    public function getNewsCount(){
        $conditions = array();

        $conditions['status'] = array('neq',-1);

        return $this->_db->where($conditions)->count();
    }

    public function find($id){
        $data = $this->_db->where('comment_id='.$id)->find();
        return $data;
    }

    public function insert($data = array()) {
        if(!is_array($data) || !$data) {
            return 0;
        }
        return $this->_db->add($data);
    }

    public function updateById($id, $data) {
        if(!$id || !is_numeric($id) ) {
            throw_exception("ID不合法");
        }
        if(!$data || !is_array($data)) {
            throw_exception('更新数据不合法');
        }

        return $this->_db->where('comment_id='.$id)->save($data);
    }
}