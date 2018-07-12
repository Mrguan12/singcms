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

class RentController extends CommonController{
    public function index(){
        $search = $_POST["search"];
        $maxprice = intval($_POST["maxprice"]);
        $minprice = intval($_POST["minprice"]);
        $price = $_POST["price"];
        $address = $_POST["address"];
        
        if(!empty($search)){

            $where['hotel_city'] = array('like','%'.$search.'%');
            $where['hotel_county'] = array('like','%'.$search.'%');
            $where['hotel_street'] = array('like','%'.$search.'%');
            $where['hotel_type'] = array('like','%'.$search.'%');
            $where['_logic']='OR';
            }
                 
            
        if($address != null){
            $x['hotel_county']=array('eq',$address);
            
            $where['_complex'] = $x;
            if($minprice !=null && $maxprice !=null){
                
                
                $hotel = M('hotel')->where("hotel_cost >= $minprice and hotel_cost <= $maxprice")->where($where)->order('hotel_id DESC')->select();    

            }else{
                  
                  $hotel = M('hotel')->where($where)->order('hotel_id DESC')->select();     
                 }
                
        }
        else{
                
            if($minprice !=null && $maxprice !=null){
                
                
                $hotel = M('hotel')->where("hotel_cost >= $minprice and hotel_cost <= $maxprice")->order('hotel_id DESC')->select();    
                                      
            }else{
                  $hotel = M('hotel')->order('hotel_id DESC')->where($where)->select();
                 }
            
              
        }
        

        $data = M('hotel as a')->order('a.hotel_id DESC')->find();
        $info = M('hotel as a')->order('a.hotel_id DESC')->limit(3)->select();
        $hotel1 = M('hotel as a')->order('a.hotel_id DESC')->limit('3,5')->select();
        $hotels = M('hotel as a')->order('rand()')->limit(4)->select();
        $this->assign('hotel1',$hotel1);
        $this->assign('data',$data);
        $this->assign('info',$info);
        $this->assign('hotel',$hotel);
        $this->assign('hotels',$hotels);


        $ret = $_SESSION['adminUser'];
        if($_SESSION['adminUser']['identity'] == 'admin'){
            $url = '/admin.php?c=admin&a=personal';
        }
        else if($_SESSION['adminUser']['identity'] == 'platformadmin'){
            $url = '/admin.php?m=platformadmin&c=index&a=personal';
        }
        else if($_SESSION['adminUser']['identity'] == 'lessor'){
            $url = '/admin.php?m=tenant&c=index&a=personal';
        }
        else{
            $url = '/admin.php?m=lessor&c=index&a=personal';
        }
        if($ret){
            $words = '<a href="#" class="dropdown-toggle sel" data-toggle="dropdown">' .getLoginUsername(). '<b class="caret"></b></a>
      <ul class="dropdown-menu">
        <li>
          <a href="'.$url.'"><i class="fa fa-fw fa-user"></i> 个人中心</a>
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