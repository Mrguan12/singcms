<?php
/**
 * Created by PhpStorm.
 * User: Miu
 * Date: 2018/7/3
 * Time: 19:16
 */
namespace Platformadmin\Controller;
use Home\Controller\CommonController;
use Think\Controller;

class PreorderController extends CommonController{
    public function index(){

        $orders = M('order as a')->join('cms_hotel as b ON a.hotel_id = b.hotel_id')->select();


        $this->assign('orders',$orders);
        $this->assign('nav','预订单列表');

        $this->display();

    }
}