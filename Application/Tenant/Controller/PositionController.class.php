<?php
/**
 * 后台推荐位相关
 */

namespace Tenant\Controller;
use Think\Controller;
class PositionController extends CommonController {
    const UPLOAD = 'upload';

    public function index()
    {
        $conds = array();
        $hotel_city = $_GET['hotel_city'];
        $hotel_type=$_GET['hotel_type'];
        if($hotel_city) {
            $conds['hotel_city'] = $hotel_city;
        }
        if($hotel_type) {
            $conds['hotel_type'] = $hotel_type;
        }


        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = 10;
        $news = D("Position")->getNews($conds,$page,$pageSize);
        $count = D("Position")->getNewsCount($conds);
        $res  =  new \Think\Page($count,$pageSize);
        $pageres = $res->show();
        $this->assign('pageres',$pageres);
        $this->assign('positions',$news);
        $this->assign('webSiteMenu',D("Menu")->getBarMenus());
        $this->display();



//        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
//        $pageSize = 10;
//        $news = D("Position")->getNews($page,$pageSize);
//        $count = D("Position")->getNewsCount();
//        $res  =  new \Think\Page($count,$pageSize);
//        $pageres = $res->show();
//        $this->assign('pageres',$pageres);
//        $this->assign('positions',$news);
//        $this->assign('webSiteMenu',D("Menu")->getBarMenus());
//        $this->display();

    }


    public function edithh()
    {
        if (IS_POST) {
            if (!isset($_POST['hotel_city']) || !$_POST['hotel_city']) {
                return show(0, '房源的房间所在城市为空');
            }
            if (!isset($_POST['hotel_county']) || !$_POST['hotel_county']) {
                return show(0, '房源的房间所在县城为空');
            }
            if (!isset($_POST['hotel_street']) || !$_POST['hotel_street']) {
                return show(0, '房源的房间所在街道为空');
            }
            if (!isset($_POST['hotel_size']) || !$_POST['hotel_size']) {
                return show(0, '房源的房间规模为空');
            }
            if (!isset($_POST['hotel_type']) || !$_POST['hotel_type']) {
                return show(0, '房源的房间类型为空');
            }
            if (!isset($_POST['hotel_cost']) || !$_POST['hotel_cost']) {
                return show(0, '房源的房间价格为空');
            }
            if (!isset($_POST['status'])) {
                return show(0, '房源状态为空');
            }
            if ($_POST['status'] != 0 && $_POST['status'] != 1) {
                return show(0, '房源状态输入错误！');
            }

            D("Himage")->deleteById($_POST['hotel_id']);
            $urlList=explode(' ',$_POST['hotel_image']);
            $data=array();
            $dataList=array();
            $data['hotel_id']=$_POST['hotel_id'];
            $data['status']=1;
            foreach ($urlList as $url){
                if($url){
                    $data['url']=$url;
                    $dataList[count($dataList)]=$data;
                }
            }
            D('Himage')->insert($dataList);
            try {
                $id = D("Position")->updateById($_POST);
                if($id === false) {
                    return show(0,'更新失败');
                }
                return show(1,'更新成功');
            }catch (Exception $e) {
                return show(0,$e->getMessage());
            }
        } else {
            $this->display();
        }

    }

    public function add() {
        if(IS_POST) {

            if (!isset($_POST['hotel_id']) || !$_POST['hotel_id']) {
                return show(0, '房源的房间号为空');
            }
            if(D("Hotel")->select($_POST['hotel_id'])){
                return show(0, '房源的房间号已存在！');
            }
            if (!isset($_POST['hotel_city']) || !$_POST['hotel_city']) {
                return show(0, '房源的房间所在城市为空');
            }
            if (!isset($_POST['hotel_county']) || !$_POST['hotel_county']) {
                return show(0, '房源的房间所在县城为空');
            }
            if (!isset($_POST['hotel_street']) || !$_POST['hotel_street']) {
                return show(0, '房源的房间所在街道为空');
            }
            if (!isset($_POST['hotel_size']) || !$_POST['hotel_size']) {
                return show(0, '房源的房间规模为空');
            }
            if (!isset($_POST['hotel_type']) || !$_POST['hotel_type']) {
                return show(0, '房源的房间类型为空');
            }
            if (!isset($_POST['hotel_cost']) || !$_POST['hotel_cost']) {
                return show(0, '房源的房间价格为空');
            }
            if (!isset($_POST['status'])) {
                return show(0, '房源状态为空');
            }
            if ($_POST['status']!=0&&$_POST['status']!=1) {
                return show(0, '房源状态输入错误！');
            }

            $urlList=explode(' ',$_POST['hotel_image']);
            $data=array();
            $dataList=array();
            $data['hotel_id']=$_POST['hotel_id'];
            $data['status']=1;
            foreach ($urlList as $url){
                if($url){
                    $data['url']=$url;
                    $dataList[count($dataList)]=$data;
                }
            }
            D('Himage')->insert($dataList);
            try {
                $id=D("Position")->insert($_POST);
                return show(1,'新增成功',$id);
            }catch(Exception $e) {
                return show(0, $e->getMessage());
            }
            return show(0, '新增失败',$newsId);
        }else {
            $this->display();
        }

    }
    /**
     * 编辑页面
     */
    public function edit() {


        $id = $_GET['id'];
        $position = D("Position")->find($id);
        $image=D("Himage")->find($id);
        echo("<script>console.log('".json_encode($image[0])."');</script>");
        $this->assign('vo', $position);
        $this->assign('image',$image);
        $this->display();

    }
    public function save($data) {

        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './'.self::UPLOAD.'/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件
        $info   =   $upload->upload();
//        if(!$info) {// 上传错误提示错误信息
//            $this->error($upload->getError());
//        }else{// 上传成功
//            $this->success('上传成功！');
//        }
//

//        $upload = D("UploadImage");
//        $res = $upload->imageUpload();
//        $data['hotel_image']=$res;
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
    /**
     * 设置状态
     * status=1 正常 0关闭 -1删除
     */
    public function setStatus(){
        try {
            if ($_POST) {
                $id = $_POST['id'];
                $status = $_POST['status'];
                $res = D("Position")->updateStatusById($id, $status);
                if ($res) {
                    return show(1, '操作成功');
                } else {
                    return show(0, '操作失败');
                }

            }
        }catch (Exception $e) {
            return show(0, $e->getMessage());
        }

        return show(0, '没有提交的内容');
    }

    public function upload(){
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     3145728 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
        $upload->rootPath  =     './'.self::UPLOAD.'/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息
            $this->error($upload->getError());
        }else{// 上传成功
            $this->success('上传成功！');
        }
    }



}