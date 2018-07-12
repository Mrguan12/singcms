<?php
/**
 * Created by PhpStorm.
 * User: 96561
 * Date: 2018/7/11
 * Time: 16:35
 */

namespace Common\Model;
use Think\Model;


class AreaModel extends Model{
    private $_db = '';
    public function __construct() {
        $this->_db = M('area');
    }

    public function getMenu(){
//        $data = array(
//            'parentid' => 0,
//        );
        $data['parentid']=0;
        return $this->_db->where($data)->select();
    }

    public function getCounty($codeid){
        if(!$codeid || !is_numeric($codeid)) {
            return array();
        }
        $a=strval($codeid*10000);
        $b=strval(($codeid+1)*10000);
        $map['codeid'] = array('BETWEEN',$a.','.$b);
        return $this->_db->where($map)->select();
    }
//
//    public function find($codeid){
//        if(!$codeid || !is_numeric($codeid)) {
//            return array();
//        }
//        return $this->_db->where('codeid='.$codeid)->find();
//    }
//    public function updateMenuById($id, $data) {
//        if(!$id || !is_numeric($id)) {
//            throw_exception('ID不合法');
//        }
//
//        if(!$data || !is_array($data)) {
//            throw_exception('更新的数据不合法');
//        }
//
//        return $this->_db->where('menu_id='.$id)->save($data);
//
//    }
//
//    public function updateStatusById($id, $status) {
//        if(!is_numeric($id) || !$id) {
//            throw_exception("ID不合法");
//        }
//        if(!is_numeric($status) || !$status) {
//            throw_exception("状态不合法");
//        }
//
//        $data['status'] = $status;
//        return $this->_db->where('menu_id='.$id)->save($data);
//    }
//    public function updateMenuListorderById($id, $listorder) {
//        if(!$id || !is_numeric($id)) {
//            throw_exception('ID不合法');
//        }
//
//        $data = array(
//            'listorder' => intval($listorder),
//        );
//
//        return $this->_db->where('menu_id='.$id)->save($data);
//    }
//
//    public function getAdminMenus() {
//        $data = array(
//            'status' => array('neq',-1),
//            'type' => 1,
//        );
//
//        return $this->_db->where($data)->order('listorder desc,menu_id desc')->select();
//    }
//
//    public function getBarMenus() {
//        $data = array(
//            'status' => 1,
//            'type' => 0,
//        );
//
//        $res = $this->_db->where($data)
//            ->order('listorder desc,menu_id desc')
//            ->select();
//        return $res;
//    }
//
//    public function getAdminMenu() {
//        $data = array(
//            'status' => 2,
//            'type' => 0,
//        );
//
//        return $this->_db->where($data)->select();
//    }
}