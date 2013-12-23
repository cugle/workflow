<?php
// +----------------------------------------------------------------------
// | CugleCms 后台管理系统
// +----------------------------------------------------------------------
// | provide by ：yangyongfu.com.cn
// 
// +----------------------------------------------------------------------
// | Author: 452275147@qq.com
// +----------------------------------------------------------------------

class WFProcessAction extends BaseAction
{
	public function index()
	{
		$Process_mod = D('wf_process');
		$Defination_mod = D('wf_defination');

		//搜索
		$where = '1=1';
		if (isset($_GET['keyword']) && trim($_GET['keyword'])) {
		    $where .= " AND defination_name LIKE '%".$_GET['keyword']."%'";
		    $this->assign('keyword', $_GET['keyword']);
		}

		if (isset($_GET['defination_id']) && intval($_GET['defination_id'])) {
		    $where .= " AND defination_id=".$_GET['defination_id'];
		    $this->assign('defination_id', $_GET['defination_id']);
		}
		import("ORG.Util.Page");
		$Count = $Process_mod->where($where)->count();
		$p = new Page($Count,20);
		$Process_list = $Process_mod->where($where)->limit($p->firstRow.','.$p->listRows)->order('process_id DESC')->select();

		$key = 1;
		foreach($Process_list as $k=>$val){
			$Node_list[$k]['key'] = ++$p->firstRow;
			$Node_list[$k]['defination_name'] = $Defination_mod->field('defination_name')->where('defination_id='.$val['defination_id'])->find();
		}
		$result = $Defination_mod->order('defination_id ASC')->select();
    	$defination_list = array();
    	foreach ($result as $val) {
    	    if ($val['pid']==0) {
    	        $defination_list['parent'][$val['defination_id']] = $val;
    	    } 
    	}
 
		//网站信息/应用资讯
		$page = $p->show();
		$this->assign('page',$page);
    	$this->assign('defination_list', $defination_list);
		$this->assign('Process_list',$Node_list);
		$this->display();
	}

	function edit()
	{
		if(isset($_POST['dosubmit'])){

			$node_mod = D('wf_node');
			$data = $node_mod->create();
			if($data['node_id']==0){
				$this->error('请选择分类');
			}
			$result = $node_mod->save($data);
			if(false !== $result){
				$this->success(L('operation_success'),U('WFNode/index'));
			}else{
				$this->error(L('operation_failure'));
			}
		}else{
			$node_mod = D('wf_node');
			if( isset($_GET['node_id']) ){
				$node_id = isset($_GET['node_id']) && intval($_GET['node_id']) ? intval($_GET['node_id']) : $this->error(L('please_select'));
			}
			$defination_mod = D('wf_defination');
		    $result = $defination_mod->order('defination_id ASC')->select();
		    $defination_list = array();
		    foreach ($result as $val) {
		    	if ($val['pid']==0) {
		    	    $defination_list['parent'][$val['defination_id']] = $val;
		    	}
		    }
			$note_info = $node_mod->where('node_id='.$node_id)->find();
			$this->assign('show_header', false);
	    	$this->assign('defination_list',$defination_list);
			$this->assign('node',$note_info);
			$this->display();
		}


	}

	function add()
	{
		if(isset($_POST['dosubmit'])){
			$node_mod = D('wf_node');
			if($_POST['node_index']==''){
				$this->error(L('input').L('node_index'));
			}
			if(false === $data = $node_mod->create()){
				$this->error($node_mod->error());
			}
 
			$result = $node_mod->add($data);
			if($result){
				
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
			$defination_mod = D('wf_defination');
	    	$result = $defination_mod->order('defination_id ASC')->select();
	    	$defination_list = array();
			 
	    	foreach ($result as $val) {
	    	    if ($val['pid']==0) {
	    	        $defination_list['parent'][$val['defination_id']] = $val;
	    	    }
	    	}
	    	$this->assign('defination_list',$defination_list);
	    	$this->display();
		}
	}

 

	function delete()
    {
		$node_mod = D('wf_node');
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的资讯！');
		}
		if( isset($_POST['id'])&&is_array($_POST['id']) ){
			$node_ids = implode(',',$_POST['id']);

			$node_mod->delete($node_ids);
		}else{
			$node_id = intval($_GET['id']);
		    $node_mod->where('node_id='.$node_id)->delete();
		}
		$this->success(L('operation_success'));
    }

 
    //修改状态
	function status()
	{
		$article_mod = D('wf_node');
		$id 	= intval($_REQUEST['id']);
		$type 	= trim($_REQUEST['type']);
		$sql 	= "update ".C('DB_PREFIX')."wf_defination set $type=($type+1)%2 where defination_id='$id'";

		$res 	= $article_mod->execute($sql);
		$values = $article_mod->field("defination_id,".$type)->where('defination_id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}

}
?>