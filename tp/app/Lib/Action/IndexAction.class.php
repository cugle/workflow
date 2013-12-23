<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
	$Article_mod = M('article');
	 $this->data  = $Article_mod->limit(0,15)->select();
 
     $this->display();
    }
	 public function request(){
        for ($i=0;$i<6;$i++){
            $res[$i] = rand(100, 400);
        }
        $this->ajaxReturn($res);
    }
	
	public function getMore(){
	 
	$page = isset($_GET['page'])?(int)$_GET['page']:0;
	$num = isset($_GET['requestNum'])?(int)$_GET['requestNum']:5;
	$startNum = $page*$num;
	$Article_mod = M('article');
	$this->Data = $Article_mod->limit($startNum,$num)->select();
	echo json_encode($this->Data);
	 
	}
 }
