<?php
// +----------------------------------------------------------------------
// | CugleCms 后台管理系统
// +----------------------------------------------------------------------
// | provide by ：yangyongfu.com.cn
// 
// +----------------------------------------------------------------------
// | Author: 452275147@qq.com
// +----------------------------------------------------------------------

class RoleAction extends BaseAction
{
	function index()
	{
		$role_mod = D('role');
		import("ORG.Util.Page");
		$count = $role_mod->count();
		$p = new Page($count,30);

		$role_list = $role_mod->limit($p->firstRow.','.$p->listRows)->select();
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=Role&a=add\', title:\'添加角色\', width:\'400\', height:\'220\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', '添加组');
		$page = $p->show();
		$this->assign('page',$page);
		$this->assign('big_menu',$big_menu);
		$this->assign('role_list',$role_list);
		$this->display();
	}

	function add()
	{
		if(isset($_POST['dosubmit'])){
			$role_mod = D('role');
			if(!isset($_POST['name'])||($_POST['name']=='')){
				$this->error('请填写角色名');
			}
			$result = $role_mod->where("name='".$_POST['name']."'")->count();
			if($result){
				$this->error('角色已经存在');
			}
			$role_mod->create();
			$result = $role_mod->add();
			if($result){
				$this->success(L('operation_success'), '', '', 'add');
			}else{
				$this->error(L('operation_failure'));
			}
		}else{
			$this->assign('show_header', false);
			$this->display();
		}
	}

	public function edit()
	{
		if(isset($_POST['dosubmit'])){
			$role_mod = D('role');
			if (false === $role_mod->create()) {
				$this->error($role_mod->getError());
			}
			$result = $role_mod->save();
			if(false !== $result){
				$this->success(L('operation_success'), '', '', 'edit');
			}else{
				$this->error(L('operation_failure'));
			}
		}else{
			if( isset($_GET['id']) ){
				$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error('参数错误');
			}
			$role_mod = D('role');
			$role_info = $role_mod->where('id='.$id)->find();
			$this->assign('role_info', $role_info);
			$this->assign('show_header', false);
			$this->display();
		}
	}

	function delete()
	{
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
			$this->error('请选择要删除的角色！');
		}
		$role_mod = D('role');
		if (isset($_POST['id']) && is_array($_POST['id'])) {
			$ids = implode(',', $_POST['id']);
			$role_mod->delete($ids);
		} else {
			$id = intval($_GET['id']);
			$role_mod->delete($id);
		}
		$this->success(L('operation_success'));
	}

	//授权
	public function auth()
	{
		$role_id = intval($_REQUEST['id']);
		$node_ids_res = D("access")->where("role_id=".$role_id)->field("node_id")->select();
		$node_ids = array();
		foreach ($node_ids_res as $row) {
			array_push($node_ids,$row['node_id']);
		}
		//取出模块授权
		$modules = D("node")->where("status = 1 and auth_type = 0")->select();
		foreach ($modules as $k=>$v) {
			$modules[$k]['actions'] = D("node")->where("status=1 and auth_type>0 and module='".$v['module']."'")->select();
		}
		foreach ($modules as $k=>$module) {
			if (in_array($module['id'],$node_ids)) {
				$modules[$k]['checked'] = true;
			} else {
				$modules[$k]['checked'] = false;
			}
			foreach ($module['actions'] as $ak=>$action) {
				if(in_array($action['id'],$node_ids)) {
					$modules[$k]['actions'][$ak]['checked'] = true;
				} else {
					$modules[$k]['actions'][$ak]['checked'] = false;
				}
			}
		}		
		$this->assign('access_list',$modules);		
		$this->assign('id',$role_id);
		$this->display();
	}

	public function authSubmit()
	{
		$role_id = intval($_REQUEST['id']);
		$access=D(access);		
		$access->where("role_id=".$role_id)->delete();

		$node_ids = $_REQUEST['access_node'];
		foreach ($node_ids as $node_id) {
			$data=array();
			$data['role_id'] = $role_id;
			$data['node_id'] =$node_id ;			
			$access->add($data);						
		}	
		$this->success(L('operation_success'));
	}
	//修改状态
	function status()
	{
		$role_mod = D('role');
		$id 	= intval($_REQUEST['id']);
		$type 	= trim($_REQUEST['type']);
		$sql 	= "update ".C('DB_PREFIX')."role set $type=($type+1)%2 where id='$id'";
		$res 	= $role_mod->execute($sql);
		$values = $role_mod->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}
}
?>