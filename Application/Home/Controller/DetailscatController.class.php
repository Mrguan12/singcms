<?php
/**
 * Created by PhpStorm.
 * User: 96561
 * Date: 2018/7/8
 * Time: 19:17
 */

namespace Home\Controller;

class DetailscatController extends CommonController
{
    public function index(){
        $data['status'] = array('neq',-1);
        $positions = D("Position")->find(1);
        $this->assign('positions',$positions);
        $this->display("Detailscat/detailscat");
    }

    public function save($data) {
        $id = $data['hotel_id'];
        unset($data['hotel_id']);

        try {
            $id = D("Position")->updateById($id,$data);
            if($id === false) {
                return show(0,'更新失败');
            }
            return show(1,'更新成功');
        }catch (Exception $e) {
            return show(0,$e->getMessage());
        }
    }

}