<?php
/**
 * basic基本设置
 */
namespace Admin\Controller;
use Think\Controller;
use Think\Exception;

class BasicController extends CommonController
{

    public function index()
    {
        $result = D("Basic")->select();
        $this->assign('vo', $result);
        $this->assign('type', 1);
        $this->display();
    }

    public function add()
    {
        if ($_POST) {
            if (!$_POST['username']) {
                return show(0, '请输入名字');
            }
            if (!$_POST['password']) {
                return show(0, '请输入密码');
            }
            if (!$_POST['password2']) {
                return show(0, '请输入密码');
            }
            if ($_POST['password'] != $_POST['password2']) {
                return show(0, '两次的密码不一样');
            }
            $temp = D("Admin")->getAdminByUsername($_POST['username']);
            if (!$temp) {
                return show(0, '找不到用户');
            }
            D("Admin")->updatePasswordByName($temp['admin_id'], $_POST['password']);
            return show(1, '配置成功');
        } else {
            return show(0, '没有提交的数据');
        }
    }

    /**
     * 缓存管理
     */
    public function cache()
    {
        $this->assign('type', 2);
        $this->display();
    }
}
