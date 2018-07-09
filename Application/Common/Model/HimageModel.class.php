<?php
/**
 * Created by PhpStorm.
 * User: 23061
 * Date: 2018/7/8
 * Time: 19:52
 */

namespace Common\Model;


use Think\Model;

class HimageModel extends Model
{
    private $_db = '';
    public function __construct() {
        $this->_db = M('himage');
    }
    public function insert($data = array()) {
        if(!is_array($data) || !$data) {
            return 0;
        }
        return $this->_db->addAll($data);
    }
    public function find($id){
        $data = $this->_db->where('hotel_id='.$id)->select();
        return $data;
    }
}