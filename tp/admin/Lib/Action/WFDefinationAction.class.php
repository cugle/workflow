<?php
// +----------------------------------------------------------------------
// | CugleCms 后台管理系统
// +----------------------------------------------------------------------
// | provide by ：yangyongfu.com.cn
// 
// +----------------------------------------------------------------------
// | Author: 452275147@qq.com
// +----------------------------------------------------------------------

class WFDefinationAction extends BaseAction
{
	public function index()
	{
		$Defination_mod = D('wf_defination');
		$Defination_cate_mod = D('wf_defination_cate');

		//搜索
		$where = '1=1';
		if (isset($_GET['keyword']) && trim($_GET['keyword'])) {
		    $where .= " AND defination_name LIKE '%".$_GET['keyword']."%'";
		    $this->assign('keyword', $_GET['keyword']);
		}

		if (isset($_GET['defination_cate_id']) && intval($_GET['defination_cate_id'])) {
		    $where .= " AND defination_cate_id=".$_GET['defination_cate_id'];
		    $this->assign('defination_cate_id', $_GET['defination_cate_id']);
		}
		import("ORG.Util.Page");
		$Count = $Defination_mod->where($where)->count();
		$p = new Page($Count,20);
		$Defination_list = $Defination_mod->where($where)->limit($p->firstRow.','.$p->listRows)->order('defination_id DESC')->select();

		$key = 1;
		foreach($Defination_list as $k=>$val){
			$Defination_list[$k]['key'] = ++$p->firstRow;
			$Defination_list[$k]['defination_cate_name'] = $Defination_cate_mod->field('defination_cate_name')->where('defination_cate_id='.$val['defination_cate_id'])->find();
		}
		$result = $Defination_cate_mod->order('defination_cate_id ASC')->select();
    	$defination_cate_list = array();
    	foreach ($result as $val) {
    	    if ($val['pid']==0) {
    	        $defination_cate_list['parent'][$val['defination_cate_id']] = $val;
    	    } else {
    	        $defination_cate_list['sub'][$val['pid']][] = $val;
    	    }
    	}
		//网站信息/应用资讯
		$page = $p->show();
		$this->assign('page',$page);
    	$this->assign('defination_cate_list', $defination_cate_list);
		$this->assign('defination_list',$Defination_list);
		$this->display();
	}

	function edit()
	{
		if(isset($_POST['dosubmit'])){
			$defination_mod = D('wf_defination');
			$data = $defination_mod->create();
			if($data['defination_cate_id']==0){
				$this->error('请选择分类');
			}
			$result = $defination_mod->save($data);
			if(false !== $result){
				$this->success(L('operation_success'),U('WFDefination/index'));
			}else{
				$this->error(L('operation_failure'));
			}
		}else{
			$defination_mod = D('wf_defination');
			if( isset($_GET['defination_id']) ){
				$defination_id = isset($_GET['defination_id']) && intval($_GET['defination_id']) ? intval($_GET['defination_id']) : $this->error(L('please_select'));
			}
			$article_cate_mod = D('wf_defination_cate');
		    $result = $article_cate_mod->order('defination_cate_id ASC')->select();
		    $defination_cate_list = array();
		    foreach ($result as $val) {
		    	if ($val['pid']==0) {
		    	    $defination_cate_list['parent'][$val['defination_cate_id']] = $val;
		    	} else {
		    	    $defination_cate_list['sub'][$val['pid']][] = $val;
		    	}
		    }
			$defination_info = $defination_mod->where('defination_id='.$defination_id)->find();
			$this->assign('show_header', false);
	    	$this->assign('defination_cate_list',$defination_cate_list);
			$this->assign('defination',$defination_info);
			$this->display();
		}


	}

	function add()
	{
		if(isset($_POST['dosubmit'])){
			
			$defination_mod = D('wf_defination');
			if($_POST['defination_name']==''){
				$this->error(L('input').L('article_title'));
			}
			if(false === $data = $defination_mod->create()){
				$this->error($defination_mod->error());
			}
 
			$result = $defination_mod->add($data);
			if($result){
				
				$this->success('添加成功');
			}else{
				$this->error('添加失败');
			}
		}else{
			$article_cate_mod = D('wf_defination_cate');
	    	$result = $article_cate_mod->order('defination_cate_id ASC')->select();
	    	$cate_list = array();
			 
	    	foreach ($result as $val) {
	    	    if ($val['pid']==0) {
	    	        $cate_list['parent'][$val['defination_cate_id']] = $val;
	    	    } else {
	    	        $cate_list['sub'][$val['pid']][] = $val;
	    	    }
	    	}
	    	$this->assign('cate_list',$cate_list);
	    	$this->display();
		}
	}

 

	function delete()
    {
		$defination_mod = D('wf_defination');
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的资讯！');
		}
		if( isset($_POST['id'])&&is_array($_POST['id']) ){
			$defination_ids = implode(',',$_POST['id']);

			$defination_mod->delete($defination_ids);
		}else{
			$defination_id = intval($_GET['id']);
		    $defination_mod->where('defination_id='.$defination_id)->delete();
		}
		$this->success(L('operation_success'));
    }

 
    //修改状态
	function status()
	{
		$article_mod = D('wf_defination');
		$id 	= intval($_REQUEST['id']);
		$type 	= trim($_REQUEST['type']);
		$sql 	= "update ".C('DB_PREFIX')."wf_defination set $type=($type+1)%2 where defination_id='$id'";

		$res 	= $article_mod->execute($sql);
		$values = $article_mod->field("defination_id,".$type)->where('defination_id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}

}
?>