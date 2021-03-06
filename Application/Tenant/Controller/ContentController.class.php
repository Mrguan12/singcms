<?php
/**
 * 后台Index相关
 */
namespace Tenant\Controller;
use Think\Controller;
use Think\Exception;


/**
 * 文章内容管理
 */
class ContentController extends CommonController {

    public function index() {

        $page = $_REQUEST['p'] ? $_REQUEST['p'] : 1;
        $pageSize = 10;

        $conds = array();
        $this->assign('user','');
        if($_GET['title']) {
            $title = D("User")->getUserByName($_GET['title']);
            $conds['user_id'] = $title["user_id"];
            $this->assign('user',$_GET['title']);
        }
        $this->assign('status',-2);
        if($_GET['catid']=='0'||$_GET['catid']=='1') {
            $conds['status'] = intval($_GET['catid']);
            $this->assign('status',$conds['status']);
        }
        $hotelList=D("Position")->getHotelsById(session("tenantid"));
        $cond=array();
        foreach ($hotelList as $hotel){
            array_push($cond,intval($hotel['hotel_id']));
        }
        echo("<script>console.log('".json_encode($cond)."');</script>");
        $conds['hotel_id'] = array('in',implode(',', $cond));
        $news = D("Order")->getNews($conds,$page,$pageSize);
        $count = D("Order")->getNewsCount();
        $navs=D("User")->getUsers();
        $comment=D("Comment")->getComments();

        foreach($navs as $nav) {
            $navlist[$nav['user_id']] = $nav['user_nickname'];
        }
        C('USER_LIST',$navlist);

        foreach($comment as $com) {
            $comlist[$com['comment_id']] = $com['comment_content'];
        }

        C('COMMENT_LIST',$comlist);

        $res  =  new \Think\Page($count,$pageSize);
        $pageres = $res->show();

        $this->assign('pageres',$pageres);
        $this->assign('news',$news);
        $this->assign('navlist',$navlist);

        $sta1=array();
        $sta1['menu_id']=0;
        $sta1['name']='未接受';
        $sta2=array();
        $sta2['menu_id']=1;
        $sta2['name']='已接受';
        $sta3=array();
        $sta3['menu_id']=-2;
        $sta3['name']='全部';
        $stalist[0]=$sta1;
        $stalist[1]=$sta2;
        $stalist[2]=$sta3;

        $this->assign('webSiteMenu',$stalist);
        $this->display();

    }
    public function add(){
        if($_POST) {
//            if(!isset($_POST['title']) || !$_POST['title']) {
//                return show(0,'标题不存在');
//            }
//            if(!isset($_POST['small_title']) || !$_POST['small_title']) {
//                return show(0,'短标题不存在');
//            }
//            if(!isset($_POST['catid']) || !$_POST['catid']) {
//                return show(0,'文章栏目不存在');
//            }
//            if(!isset($_POST['keywords']) || !$_POST['keywords']) {
//                return show(0,'关键字不存在');
//            }
            $_POST['comment_status']=1;
            if(!isset($_POST['comment_content']) || !$_POST['comment_content']) {
                return show(0,'content不存在');
            }
            if($_POST['comment_id']) {
                return $this->save($_POST);
            }
            $newsId = D("Comment")->insert($_POST);
            if($newsId) {
//                $newsContentData['content'] = $_POST['comment_content'];
//                $newsContentData['news_id'] = $newsId;
//                $cId = D("NewsContent")->insert($newsContentData);
//                if($cId){
                    return show(1,'新增成功');
//                }else{
//                    return show(1,'主表插入成功，副表插入失败');
//                }


            }else{
                return show(0,'新增失败');
            }

        }
        else{

//            $webSiteMenu = D("Menu")->getBarMenus();
//
//            $titleFontColor = C("TITLE_FONT_COLOR");
//            $copyFrom = C("COPY_FROM");
//            $this->assign('webSiteMenu', $webSiteMenu);
//            $this->assign('titleFontColor', $titleFontColor);
//            $this->assign('copyfrom', $copyFrom);

            $this->display();
        }
    }

    public function edit() {
        $newsId = $_GET['id'];
        if(!$newsId) {
            // 执行跳转

            $this->redirect('/admin.php?m=tenant&c=content');
        }
        $news = D("Comment")->find($newsId);
        if(!$news) {
            $this->redirect('/admin.php?m=tenant&c=content&a=add');
        }
//        $newsContent = D("NewsContent")->find($newsId);
//        if($newsContent) {
//            $news['content'] = $newsContent['content'];
//        }

//        $webSiteMenu = D("Menu")->getBarMenus();
//        $this->assign('webSiteMenu', $webSiteMenu);
//        $this->assign('titleFontColor', C("TITLE_FONT_COLOR"));
//        $this->assign('copyfrom', C("COPY_FROM"));

        $this->assign('news',$news);
        $this->display();
    }

    public function save($data) {

        $newsId = $data['comment_id'];
        unset($data['comment_id']);

        try {
            $id = D("Comment")->updateById($newsId, $data);
//            $newsContentData['content'] = $data['content'];
//            $condId = D("NewsContent")->updateNewsById($newsId, $newsContentData);
            if($id === false ) {
                return show(0, '更新失败');
            }
            return show(1, '更新成功');
        }catch(Exception $e) {
            return show(0, $e->getMessage());
        }

    }
    public function setStatus() {
        try {
            if ($_POST) {
                $id = $_POST['id'];
                $status = $_POST['status'];
                if (!$id) {
                    return show(0, 'ID不存在');
                }

                $res = D("Order")->updateStatusById($id, $status);
                if ($res) {
                    return show(1, '操作成功');
                } else {
                    return show(0, '操作失败');
                }
            }
            return show(0, '没有提交的内容');
        }catch(Exception $e) {
            return show(0, $e->getMessage());
        }
    }

    public function listorder() {
        $listorder = $_POST['listorder'];
        $jumpUrl = $_SERVER['HTTP_REFERER'];
        $errors = array();
        try {
            if ($listorder) {
                foreach ($listorder as $newsId => $v) {
                    // 执行更新
                    $id = D("News")->updateNewsListorderById($newsId, $v);
                    if ($id === false) {
                        $errors[] = $newsId;
                    }
                }
                if ($errors) {
                    return show(0, '排序失败-' . implode(',', $errors), array('jump_url' => $jumpUrl));
                }
                return show(1, '排序成功', array('jump_url' => $jumpUrl));
            }
        }catch (Exception $e) {
            return show(0, $e->getMessage());
        }
        return show(0,'排序数据失败',array('jump_url' => $jumpUrl));
    }

    public function push() {
        $jumpUrl = $_SERVER['HTTP_REFERER'];
        $positonId = intval($_POST['position_id']);
        $newsId = $_POST['push'];

        if(!$newsId || !is_array($newsId)) {
            return show(0, '请选择推荐的文章ID进行推荐');

        }
        if(!$positonId) {
            return show(0, '没有选择推荐位');
        }
        try {
            $news = D("News")->getNewsByNewsIdIn($newsId);
            if (!$news) {
                return show(0, '没有相关内容');
            }

            foreach ($news as $new) {
                $data = array(
                    'position_id' => $positonId,
                    'title' => $new['title'],
                    'thumb' => $new['thumb'],
                    'news_id' => $new['news_id'],
                    'status' => 1,
                    'create_time' => $new['create_time'],
                );
                $position = D("PositionContent")->insert($data);
            }
        }catch(Exception $e) {
            return show(0, $e->getMessage());
        }

        return show(1, '推荐成功',array('jump_url'=>$jumpUrl));


    }
}