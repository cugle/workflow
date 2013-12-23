<?php
// +----------------------------------------------------------------------
// | CugleCms 后台管理系统
// +----------------------------------------------------------------------
// | provide by ：yangyongfu.com.cn
// 
// +----------------------------------------------------------------------
// | Author: 452275147@qq.com
// +----------------------------------------------------------------------


class NavAction extends BaseAction{	
	private $nav_mod;
	function __construct(){
		parent::__construct();
		$this->nav_mod=M('nav');
	}
	public function index()
	{		
		$nav_list = $this->nav_mod->order('sort_order ASC')->select();
		$list_rel=array();
		foreach ($nav_list as $value){			
			$list_rel[]=$value;
		}	
		$this->assign('nav_list',$list_rel);
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=Nav&a=add\', title:\'添加导航\', width:\'540\', height:\'510\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);','添加导航');
		$this->assign('big_menu',$big_menu);
		$this->assign('show_header', true);
		$this->display();
	}
	function add()
	{
		if(isset($_POST['dosubmit'])){
			if( false === $vo = $this->nav_mod->create() ){
				$this->error( $this->nav_mod->error() );
			}
			if($vo['name']==''){
				$this->error('导航名称不能为空');
			}
			$result = $this->nav_mod->where("pid=".$vo['pid']." AND name='".$vo['name']."'")->count();
			if($result != 0){
				$this->error('该导航已经存在');
			}
			//保存当前数据
			$app_cate_id = $this->nav_mod->add();
			$this->success('添加成功', '', '', 'add');
		}else{			
			$this->assign('show_header', false);
			$this->display();
		}
	}

	function edit()
	{
		if(isset($_POST['dosubmit'])){
			if( false === $vo = $this->nav_mod->create() ){
				$this->error( $this->nav_mod->error() );
			}

			$old_nav = $this->nav_mod->where('id='.$_POST['id'])->find();

			//导航不能重复
			if ($_POST['name'] != $old_nav['name']) {
				if ($this->_cate_exists($_POST['name'], $_POST['id'])) {
					$this->error('导航名称重复！');
				}
			}

			$app_cate_id = $this->nav_mod->save($vo);
			$this->success('修改成功', '', '', 'edit');
		}else{
			$id = isset($_REQUEST['id'])&&intval($_REQUEST['id'])?intval($_REQUEST['id']):$this->error('请选择分类');
			$nav = $this->nav_mod->where('id='.$id)->find();			
			//print_r($nav);
			$this->assign('nav',$nav);			
			$this->assign('show_header', false);
			$this->display();
		}
	}

	private function _cate_exists($name,$id=0)
	{
		$result = M('nav')->where("name='".$name."' AND id<>'".$id."'")->count();
		if ($result) {
			return true;
		} else {
			return false;
		}
	}

	function delete()
	{
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
			$this->error('请选择要删除的导航！');
		}
		$old_nav = $this->nav_mod->where('id='.$_REQUEST['id'])->find();
		if( $old_nav['system']=='1' ){
			$this->error('您无权删除');
		}
		if (isset($_POST['id']) && is_array($_POST['id'])) {
			$cate_ids = implode(',', $_POST['id']);
			$this->nav_mod->delete($cate_ids);
		} else {
			$cate_id = intval($_GET['id']);
			$this->nav_mod->delete($cate_id);
		}
		$this->success('已成功删除');
	}

	function sort_order()
	{
		if (isset($_POST['listorders'])) {
			foreach ($_POST['listorders'] as $id=>$sort_order) {
				$data['sort_order'] = $sort_order;
				$this->nav_mod->where('id='.$id)->save($data);
			}
			$this->success('排序已完成');
		}
		$this->error('排序失败');
	}

	//修改状态
	function status()
	{
		$id 	= intval($_REQUEST['id']);
		$type 	= trim($_REQUEST['type']);
		$sql 	= "update ".C('DB_PREFIX')."nav set $type=($type+1)%2 where id='$id'";
		$res 	= $this->nav_mod->execute($sql);
		$values = $this->nav_mod->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);

	}

}
?>