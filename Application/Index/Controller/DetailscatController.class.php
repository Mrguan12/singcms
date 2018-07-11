<?php
/**
 * Created by PhpStorm.
 * User: 96561
 * Date: 2018/7/8
 * Time: 19:17
 */

namespace Index\Controller;
use Home\Controller\CommonController;
use Think\Controller;

class DetailscatController extends CommonController
{
    public function index(){
        $id = $_GET['id'];


//        $data['status'] = array('neq',-1);
//        $data['hotel_id'] = $id;
        $positions = M("hotel as a")->join('cms_admin as b ON a.owner_id = b.admin_id')->join('cms_hotel as c ON c.hotel_id = '.$id)->find();
        $this->assign('positions',$positions);
        $this->display();
    }

//    public function save($data) {
//        $id = $data['hotel_id'];
//        unset($data['hotel_id']);
//
//        try {
//            $id = D("Position")->updateById($id,$data);
//            if($id === false) {
//                return show(0,'更新失败');
//            }
//            return show(1,'更新成功');
//        }catch (Exception $e) {
//            return show(0,$e->getMessage());
//        }
//    }

}
