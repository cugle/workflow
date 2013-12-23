<?php
// +----------------------------------------------------------------------
// | CugleCms 后台管理系统
// +----------------------------------------------------------------------
// | provide by ：yangyongfu.com.cn
// 
// +----------------------------------------------------------------------
// | Author: 452275147@qq.com
// +----------------------------------------------------------------------

class AdminAction extends BaseAction
{
	function index()
	{
		$admin_mod = D('admin');
		import("ORG.Util.Page");
		$prex = C('DB_PREFIX');
		$count = $admin_mod->count();
		$p = new Page($count,30);
		$admin_list = $admin_mod->field($prex.'admin.*,'.$prex.'role.name as role_name')->join('LEFT JOIN '.$prex.'role ON '.$prex.'admin.role_id = '.$prex.'role.id ')->limit($p->firstRow.','.$p->listRows)->order($prex.'admin.add_time DESC')->select();
		$key = 1;
		foreach($admin_list as $k=>$val){
			$admin_list[$k]['key'] = ++$p->firstRow;
		}
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=Admin&a=add\', title:\'添加管理员\', width:\'480\', height:\'250\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', '添加管理员');
		$page = $p->show();
		$this->assign('page',$page);
		$this->assign('big_menu',$big_menu);
		$this->assign('admin_list',$admin_list);
		$this->display();
	}

	function add()
	{
	    if(isset($_POST['dosubmit'])){
	    	$admin_mod = D('admin');
			if(!isset($_POST['user_name'])||($_POST['user_name']=='')){
				$this->error('用户名不能为空');
			}
			if($_POST['password'] != $_POST['repassword']){
				$this->error('两次输入的密码不相同');
			}
			$result = $admin_mod->where("user_name='".$_POST['user_name']."'")->count();
			if($result){
			    $this->error('管理员'.$_POST['user_name'].'已经存在');
			}
			unset($_POST['repassword']);
			$_POST['password'] = md5($_POST['password']);
			$admin_mod->create();
			$admin_mod->add_time = time();
			$admin_mod->last_time = time();
			$result = $admin_mod->add();
			if($result){
				$this->success(L('operation_success'), '', '', 'add');
			}else{
				$this->error(L('operation_failure'));
			}

	    }else{
		    $role_mod = D('role');
		    $role_list = $role_mod->where('status=1')->select();
		    $this->assign('role_list',$role_list);

		    $this->assign('show_header', false);
			$this->display();
	    }
	}

	function edit()
	{
		if(isset($_POST['dosubmit'])){
			$admin_mod = D('admin');
			$count=$admin_mod->where("id!=".$_POST['id']." and user_name='".$_POST['user_name']."'")->count();
			if($count>0){
				$this->error('用户名已经存在！');
			}
			//print_r($count);exit;
			if ($_POST['password']) {
			    if($_POST['password'] != $_POST['repassword']){
				    $this->error('两次输入的密码不相同');
			    }
			    $_POST['password'] = md5($_POST['password']);
			} else {
			    unset($_POST['password']);
			}
			unset($_POST['repassword']);
			if (false === $admin_mod->create()) {
				$this->error($admin_mod->getError());
			}

			$result = $admin_mod->save();
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
		    $role_list = $role_mod->where('status=1')->select();
		    $this->assign('role_list',$role_list);

		    $admin_mod = D('admin');
			$admin_info = $admin_mod->where('id='.$id)->find();
			$this->assign('admin_info', $admin_info);
			$this->assign('show_header', false);
			$this->display();
		}
	}

	function delete()
	{
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的会员！');
		}
		$admin_mod = D('admin');
		if (isset($_POST['id']) && is_array($_POST['id'])) {
		    $ids = implode(',', $_POST['id']);
		    $admin_mod->delete($ids);
		} else {
			$id = intval($_GET['id']);
			$admin_mod->delete($id);
		}
		$this->success(L('operation_success'));
	}

	public function ajaxCheckUsername()
	{
	    $user_name = $_GET['user_name'];
        $id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : '';
        
        $where = "user_name='$user_name'";       
        $id = D('Admin')->where($where)->getField('id');        
        if (!$id) {
        	//不存在
            echo '1';
        } else {
        	//存在
            echo '0';
        }
        exit;
	}
    function ajax_check_used(){
    	$admin_mod = D('admin');
    	$count=$admin_mod->where("id!=".$_get['id']." and user_name='".$_get['user_name']."'")->count();
    	echo $count;exit;
    	if($count>0){
    		echo "0";
    	}else{
    		echo "1";
    	}
    }
	//修改状态
	function status()
	{
		$admin_mod = D('admin');
		$id 	= intval($_REQUEST['id']);
		$type 	= trim($_REQUEST['type']);
		$sql 	= "update ".C('DB_PREFIX')."admin set $type=($type+1)%2 where id='$id'";
		$res 	= $admin_mod->execute($sql);
		$values = $admin_mod->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}
}
?>