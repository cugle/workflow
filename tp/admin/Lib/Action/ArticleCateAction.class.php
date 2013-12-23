<?php
// +----------------------------------------------------------------------
// | CugleCms 后台管理系统
// +----------------------------------------------------------------------
// | provide by ：yangyongfu.com.cn
// 
// +----------------------------------------------------------------------
// | Author: 452275147@qq.com
// +----------------------------------------------------------------------

class ArticleCateAction extends BaseAction
{

	//分类列表
    function index()
    {
        $article_cate_mod = M('article_cate');
        $article_mod = D('article');
    	$result = $article_cate_mod->order('sort_order ASC')->select();
    	$article_cate_list = array();
    	foreach ($result as $val) {
    	    if ($val['pid']==0) {
//    	    	$cates = $article_cate_mod->where("pid=".$val['id'])->select();
//    	    	$nums = 0;
//    	    	if( $cates ){
//    	    		foreach( $cates as $sval ){ $nums+=$article_mod->where("cate_id=".$sval['id'])->count(); }
//    	    	}else{
//    	    		$nums = $article_mod->where("cate_id=".$val['id'])->count();
//    	    	}
//    	    	$val['nums'] =$nums;
    	        $article_cate_list['parent'][$val['id']] = $val;
    	    } else {
    	    	//$val['nums'] = $article_mod->where("cate_id=".$val['id'])->count();
    	        $article_cate_list['sub'][$val['pid']][] = $val;
    	    }
    	}

    	$this->assign('article_cate_list',$article_cate_list);
		$big_menu = array('javascript:window.top.art.dialog({id:\'add\',iframe:\'?m=ArticleCate&a=add\', title:\''.L('add_cate').'\', width:\'500\', height:\'400\', lock:true}, function(){var d = window.top.art.dialog({id:\'add\'}).data.iframe;var form = d.document.getElementById(\'dosubmit\');form.click();return false;}, function(){window.top.art.dialog({id:\'add\'}).close()});void(0);', L('add_cate'));
		$this->assign('big_menu',$big_menu);
		$this->display();
    }

    //添加分类数据
    function add()
    {
    	if(isset($_POST['dosubmit'])){
			$article_cate_mod = M('article_cate');
	        if( false === $vo = $article_cate_mod->create() ){
		        $this->error( $article_cate_mod->error() );
		    }
		    if($vo['name']==''){
		    	$this->error('分类名称不能为空');exit;
		    }
		    $result = $article_cate_mod->where("name='".$vo['name']."' AND pid='".$vo['pid']."'")->count();
		    if($result != 0){
		        $this->error('该分类已经存在');
		    }
			//保存当前数据
		    $article_cate_id = $article_cate_mod->add();
		    $this->success(L('operation_success'), '', '', 'add');
    	}else{
    		$article_cate_mod = D('article_cate');
	    	$result = $article_cate_mod->order('sort_order ASC')->select();
	    	$article_cate_list = array();
	    	foreach ($result as $val) {
	    	    if ($val['pid']==0) {
	    	        $article_cate_list['parent'][$val['id']] = $val;
	    	    } else {
	    	        $article_cate_list['sub'][$val['pid']][] = $val;
	    	    }
	    	}
	    	$this->assign('article_cate_list',$article_cate_list);
	    	$this->assign('show_header', false);
	        $this->display();
    	}

    }

    function delete()
    {
        if((!isset($_GET['id']) || empty($_GET['id'])) && (!isset($_POST['id']) || empty($_POST['id']))) {
            $this->error('请选择要删除的分类！');
		}
		$article_cate_mod = M('article_cate');
		if (isset($_POST['id']) && is_array($_POST['id'])) {
		    $cate_ids = implode(',', $_POST['id']);
		    $article_cate_mod->delete($cate_ids);
		} else {

		    $cate_id = intval($_GET['id']);
		    $article_cate_mod->delete($cate_id);
		}
		$this->success(L('operation_success'));
    }

    function edit()
    {
    	if(isset($_POST['dosubmit'])){
    		$article_cate_mod = M('article_cate');

	    	$old_cate = $article_cate_mod->where('id='.$_POST['id'])->find();
	        //名称不能重复
	        if ($_POST['name']!=$old_cate['name']) {
	            if ($this->_cate_exists($_POST['name'], $_POST['pid'], $_POST['id'])) {
	            	$this->error('分类名称重复！');exit;
	            }
	        }

	        //获取此分类和他的所有下级分类id
	        $vids = array();
	        $children[] = $old_cate['id'];
	        $vr = $article_cate_mod->where('pid='.$old_cate['id'])->select();
	        foreach ($vr as $val) {
	            $children[] = $val['id'];
	        }
	        if (in_array($_POST['pid'], $children)) {
	            $this->error('所选择的上级分类不能是当前分类或者当前分类的下级分类！');
	        }

	    	$vo = $article_cate_mod->create();
			$result = $article_cate_mod->save();
			if(false !== $result){
				$this->success(L('operation_success'), '', '', 'edit');
			}else{
				$this->error(L('operation_failure'));
			}
    	}else{
    		$article_cate_mod = M('article_cate');
			if( isset($_GET['id']) ){
				$cate_id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error(L('please_select').L('article_name'));
			}
			$article_cate_info = $article_cate_mod->where('id='.$cate_id)->find();

			$result = $article_cate_mod->order('sort_order ASC')->select();
	    	$cate_list = array();
	    	foreach ($result as $val) {
	    	    if ($val['pid']==0) {
	    	        $cate_list['parent'][$val['id']] = $val;
	    	    } else {
	    	        $cate_list['sub'][$val['pid']][] = $val;
	    	    }
	    	}
		    $this->assign('cate_list', $cate_list);
			$this->assign('article_cate_info',$article_cate_info);
			$this->assign('show_header', false);
			$this->display();
    	}

    }


    private function _cate_exists($name, $pid, $id=0)
    {
    	$where = "name='".$name."' AND pid='".$pid."'";
    	if( $id&&intval($id) ){
    		$where .= " AND id<>'".$id."'";
    	}
        $result = M('article_cate')->where($where)->count();
        //echo(M('article_cate')->getLastSql());exit;
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    function sort_order()
    {
    	$article_cate_mod = M('article_cate');
		if (isset($_POST['listorders'])) {
            foreach ($_POST['listorders'] as $id=>$sort_order) {
            	$data['sort_order'] = $sort_order;
                $article_cate_mod->where('id='.$id)->save($data);
            }
            $this->success(L('operation_success'));
        }
        $this->error(L('operation_failure'));
    }
    //修改状态
	function status()
	{
		$article_cate_mod = D('article_cate');
		$flink_mod = D('flink');
		$id 	= intval($_REQUEST['id']);
		$type 	= trim($_REQUEST['type']);
		$sql 	= "update ".C('DB_PREFIX')."article_cate set $type=($type+1)%2 where id='$id'";
		$res 	= $article_cate_mod->execute($sql);
		$values = $article_cate_mod->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}
}
?>