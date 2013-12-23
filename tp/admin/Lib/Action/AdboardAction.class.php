<?php
// +----------------------------------------------------------------------
// | CugleCms 后台管理系统
// +----------------------------------------------------------------------
// | provide by ：yangyongfu.com.cn
// 
// +----------------------------------------------------------------------
// | Author: 452275147@qq.com
// +----------------------------------------------------------------------

class AdboardAction extends BaseAction
{
	function index()
	{
		$adboard_mod = D('adboard');
		import("ORG.Util.Page");
		$count = $adboard_mod->count();
		$p = new Page($count,20);
		$adboard_list = $adboard_mod->limit($p->firstRow.','.$p->listRows)->select();
//		$key = 1;
//		foreach($adboard_list as $k=>$val){
//			$adboard_list[$k]['key'] = ++$p->firstRow;
//		}
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=Adboard&a=add\', title:\'添加广告位\', width:\'600\', height:\'300\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', '添加广告位');
		$page = $p->show();
		$this->assign('page',$page);
    	$this->assign('big_menu',$big_menu);
		$this->assign('adboard_list',$adboard_list);
		$this->display();
	}

	function add()
	{
		if(isset($_POST['dosubmit'])){
			$adboard_mod = D('adboard');
	    	$data = array();
	    	$name = isset($_POST['name']) && trim($_POST['name']) ? trim($_POST['name']) : $this->error(L('input').L('flink_name'));
	    	$exist = $adboard_mod->where("name='".$name."'")->count();
			if($exist != 0){
				$this->error('该广告位已经存在');
			}
	    	$data = $adboard_mod->create();
	    	$adboard_mod->add();
	    	$this->success(L('operation_success'), '', '', 'add');

		}else{
		    $adboard_types = $this->get_type_list();
		    $this->assign('adboard_types',$adboard_types);
	        $this->assign('show_header', false);
			$this->display();
		}
	}

	function edit()
	{
		if(isset($_POST['dosubmit'])){
			$adboard_mod = D('adboard');
			$data = $adboard_mod->create();
			$result = $adboard_mod->where("id=".$data['id'])->save($data);
			if(false !== $result){
				$this->success(L('operation_success'), '', '', 'edit');
			}else{
				$this->error(L('operation_failure'));
			}
		}else{
			$adboard_mod = D('adboard');
			if( isset($_GET['id']) ){
				$id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error('请选择要编辑的链接');
			}
			$adboard = $adboard_mod->where('id='.$id)->find();
			$this->assign('adboard',$adboard);

			$adboard_types = $this->get_type_list();
		    $this->assign('adboard_types',$adboard_types);
			$this->assign('show_header', false);
			$this->display();
		}
	}

	function delete()
    {
		$adboard_mod = D('adboard');
		if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择删除项！');
		}
		if( isset($_POST['id'])&&is_array($_POST['id']) ){
			$ids = implode(',',$_POST['id']);
			$adboard_mod->delete($ids);
		}else{
			$id = intval($_GET['id']);
		    $adboard_mod->where('id='.$id)->delete();
		}
		$this->success(L('operation_success'));
    }
    //获取广告位类型
    public function get_type_list()
    {
        $type_files = glob(ROOT_PATH . '/data/adboard/*.config.php');        
        $type_list = array();
        foreach ($type_files as $file) {
            $basefile = basename($file);
            $key = str_replace('.config.php', '', $basefile);
            $type_list[$key] = include_once($file);
            $type_list[$key]['alias'] = $key;
        }       
        return $type_list;
    }
}
?>