<?php
namespace Admin\Controller;
use Think\Controller;

/**
 * use Common\Model 这块可以不需要使用，框架默认会加载里面的内容
 */
class LoginController extends Controller {

    public function index(){
        $ret = $_SESSION['adminUser'];
        if($ret){
//            if($ret['admin_identity'] == 'admin') {
//                $this->redirect('/admin.php?c=index');
//            }
//            else if($ret['admin_identity'] == 'platformadmin') {
//                $this->redirect('/admin.php?m=platformadmin&c=index');
//            }
//            else if($ret['admin_identity'] == 'platformadmin'){
//                $this->redirect('https://www.baidu.com');
//            }
//            else{
//                $this->redirect('https://www.bilibili.com');
//            }
            $this->redirect('/admin.php?m=index&c=index');
        }

        // admin.php?c=index
        $this->display();
    }

    public function check() {

        $username = $_POST['username'];
        $password = $_POST['password'];
        if(!trim($username)) {
            return show(0,'用户名不能为空');
        }
        if(!trim($password)) {
            return show(0,'密码不能为空');
        }

        $ret = D('Admin')->getAdminByUsername($username);
        if(!$ret || $ret['status'] !=1) {
            return show(0,'该用户不存在或已被禁止登陆');
        }

        if($ret['password'] != getMd5Password($password)) {
            return show(0,'密码错误');
        }
        D("Admin")->updateByAdminId($ret['admin_id'],array('lastlogintime'=>time()));

        session('adminUser', $ret);
        if($ret['identity'] == 'admin'){
            return show(1,'登陆成功');
        }
        else if($ret['identity'] == 'platformadmin'){
            return show(2,'登陆成功');
        }
        else if($ret['identity'] == 'lessor'){
            return show(3,'登陆成功');
        }
        else{
            return show(4,'登陆成功');
        }
    }

    public function loginout() {
        session('adminUser', null);
        $this->redirect('/admin.php?m=index&c=index');
    }

}