<?php
/**
 * Created by PhpStorm.
 * User: Miu
 * Date: 2018/7/3
 * Time: 19:16
 */
namespace Index\Controller;
use Home\Controller\CommonController;
use Think\Controller;

class IndexController extends CommonController{
    public function index(){
        $data = M('hotel as a')->join('cms_himage as b ON b.hotel_id = a.hotel_id')->order('a.hotel_id DESC')->find();
        $info = M('hotel as a')->join('cms_himage as b ON b.hotel_id = a.hotel_id')->order('a.hotel_id DESC')->limit(3)->select();
        $hotel = M('hotel as a')->join('cms_himage as b ON b.hotel_id = a.hotel_id')->order('a.hotel_id DESC')->limit('3,5')->select();
        $hotels = M('hotel as a')->join('cms_himage as b ON b.hotel_id = a.hotel_id')->order('rand()')->limit(4)->select();
        $this->assign('data',$data);
        $this->assign('info',$info);
        $this->assign('hotel',$hotel);
        $this->assign('hotels',$hotels);

        $ret = $_SESSION['adminUser'];
        if($ret){
            $words = '<a href="#" class="dropdown-toggle sel" data-toggle="dropdown">' .getLoginUsername(). '<b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li>
          <a href="/admin.php?m=platformadmin&c=index&a=personal"><i class="fa fa-fw fa-user"></i> 个人中心</a>
        </li>
       
        <li class="divider"></li>
        <li>
          <a href="/admin.php?c=login&a=loginout"><i class="fa fa-fw fa-power-off"></i> 退出</a>
        </li>
      </ul>';
            $this->assign('words',$words);
        }
        else{
            $words = '<a href="/admin.php?m=admin&c=login" class="sel"><i class="fa fa-user"></i> 登录 </a>';
            $this->assign('words',$words);
        }

        $this->display();
    }
}