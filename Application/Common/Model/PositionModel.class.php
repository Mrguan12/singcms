<?php
namespace Common\Model;
use Think\Model;

/**
 * 推荐位wmodel操作
 * @author  singwa
 */
class PositionModel extends Model {
	private $_db = '';

	public function __construct() {
		$this->_db = M('hotel');
	}

	public function select($data = array()) {

		$conditions = $data;
		$list = $this->_db->where($conditions)->order('hotel_id')->select();
		return $list;
	}

	public function find($id) {
		$data = $this->_db->where('hotel_id='.$id)->find();
		return $data;
	}


	public function getCount($data=array()) {
		$conditions = $data;
		$list = $this->_db->where($conditions)->count();

		return $list;
	}
    /**
    * 插入相关数据
    * @param  array  $data [description]
    * @return intval
    */
    public function insert($res=array()) {
    	if(!$res || !is_array($res)) {
    		return 0;
    	}
    	return $this->_db->add($res);
    }

	/**
	 * 通过id更新的状态
	 * @param $id
	 * @param $status
	 * @return bool
	 */
	public function updateStatusById($id, $status) {
		if(!is_numeric($status)) {
			throw_exception("status不能为非数字");
		}
		if(!$id || !is_numeric($id)) {
			throw_exception("ID不合法");
		}
		$data['status'] = $status;
		return  $this->_db->where('hotel_id='.$id)->save($data); // 根据条件更新记录

	}

	public function updateById($data) {

		return  $this->_db->where('hotel_id='.$data['hotel_id'])->save($data); // 根据条件更新记录
	}
	// 获取正常的推荐位内容
	public function getNormalPositions() {
		$conditions = array('status'=>1);
		$list = $this->_db->where($conditions)->order('hotel_id')->select();
		return $list;
	}

    public function getNews($data,$page,$pageSize=10) {
        $conditions = $data;
        if(isset($data['hotel_type']) && $data['hotel_type']) {
            $conditions['hotel_type'] = $data['hotel_type'];
        }
        if(isset($data['hotel_city']) && $data['hotel_city'])  {
            $conditions['hotel_city'] = $data['hotel_city'];
        }
        if(isset($data['owner_id']) && $data['owner_id'])  {
            $conditions['owner_id'] = $data['owner_id'];
        }
        $conditions['status'] = array('neq',-1);
        echo("<script>console.log('".json_encode($conditions)."');</script>");
        $offset = ($page - 1) * $pageSize;
        $list = $this->_db->where($conditions)
            ->order('hotel_id desc')
            ->limit($offset,$pageSize)
            ->select();
        return $list;

    }

    public function getNewsCount($data = array()){
        $conditions = $data;
        if(isset($data['hotel_type']) && $data['hotel_type']) {
            $conditions['hotel_type'] = $data['hotel_type'];
        }
        if(isset($data['hotel_city']) && $data['hotel_city'])  {
            $conditions['hotel_city'] = $data['hotel_city'];
        }
        if(isset($data['owner_id']) && $data['owner_id'])  {
            $conditions['owner_id'] = $data['owner_id'];
        }
        $conditions['status'] = array('neq',-1);

        return $this->_db->where($conditions)->count();
    }

    public function getHotelsById($id){
        return $this->_db->where('owner_id='.$id)->select();
    }

}
