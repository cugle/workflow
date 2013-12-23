<?php
// +----------------------------------------------------------------------
// | CugleCms 后台管理系统
// +----------------------------------------------------------------------
// | provide by ：yangyongfu.com.cn
// 
// +----------------------------------------------------------------------
// | Author: 452275147@qq.com
// +----------------------------------------------------------------------
include_once(LIB_PATH.Action.'Action/WorkFlowServiceAction.class.php');
class WorkFlowAction extends BaseAction
{
	public $WorkflowService;
	public function WorkFlowAction(){//构造函数
			$this->WorkflowService=new WorkFlowServiceAction;
	
	}
	public function list_defination(){
			$this->WorkflowService->list_defination();
	}
	public function start_process(){
			$defination_id=$_GET['defination_id']?$_GET['defination_id']:$_POST['defination_id'];
			$this->WorkflowService->init_process($defination_id);
			$this->WorkflowService->start_process();
	}
	public function list_my_thread(){
			$this->WorkflowService->list_my_thread();
	}
	public function run_thread(){
			//参数：thread_id
			$thread_id=$_GET['thread_id']?$_GET['thread_id']:$_POST['thread_id'];
			$this->WorkflowService->Get_WorkFlow_Parameters($thread_id);////取得$thread  $node $process
			$this->WorkflowService->run_thread($thread_id);
	}
	public function save_thread(){
			$thread_id=$_GET['thread_id']?$_GET['thread_id']:$_POST['thread_id'];//参数：thread_id
			$this->WorkflowService->Get_WorkFlow_Parameters($thread_id);////取得$thread  $node $process
			$this->WorkflowService -> input = $_POST;//把input收集起来（所有的变量以 f_ 开头），赋给WorkflowService的Input，另外还要获得thread_id
			$this->WorkflowService->save_thread($thread_id);
	}
	public function transit_thread(){
			$thread_id=$_GET['thread_id']?$_GET['thread_id']:$_POST['thread_id'];//参数：thread_id
			$next_node_index=$_GET['next_node_index']?$_GET['next_node_index']:$_POST['next_node_index'];//参数：thread_id
			//把input收集起来，赋给WorkflowService的Input，另外还要获得thread_id
			$this->WorkflowService -> input = $_POST;
			//$next_node_index =$next_node_index?$next_node_index:$this->WorkflowService -> get_next_node_index($thread_id); //得到用户选择的下一结点id
			$this->WorkflowService->Get_WorkFlow_Parameters($thread_id);////取得$thread  $node $process
			$next_node_index = $this->WorkflowService->node['next_node_index'];
			$this->WorkflowService -> transit_thread($thread_id,$next_node_index);
	}
	public function list_my_process(){
			$this->WorkflowService->list_my_process(); 
	}
	public function list_all_process(){
			 $this->WorkflowService->list_all_process(); 
	}
	public function view_process($process_id){
			 $this->WorkflowService->view_process($process_id); 	 
	}
	
	
	
	/*public function Index($op){
	
		$WorkflowService=new WorkFlowServiceAction;
		switch($op){
		case 'list_defination':
			// 参数：无
			$WorkflowService->list_defination();
			break;
		case 'start_process' : //启动
			//$defination_id='';//参数：defination_id
			$defination_id=$_GET['defination_id']?$_GET['defination_id']:$_POST['defination_id'];
			$WorkflowService->init_process($defination_id);
			$WorkflowService->start_process();
			break;
		case 'list_my_thread': //待处理的列表
			$WorkflowService->list_my_thread();
			break;
		case 'run_thread' : 
			//参数：thread_id
			$thread_id=$_GET['thread_id']?$_GET['thread_id']:$_POST['thread_id'];
			$WorkflowService->Get_WorkFlow_Parameters($thread_id);////取得$thread  $node $process
			$WorkflowService->run_thread($thread_id);
			break;
		case 'save_thread':
			$thread_id=$_GET['thread_id']?$_GET['thread_id']:$_POST['thread_id'];//参数：thread_id
			$WorkflowService->Get_WorkFlow_Parameters($thread_id);////取得$thread  $node $process
			//把input收集起来（所有的变量以 f_ 开头），赋给WorkflowService的Input，另外还要获得thread_id
			$WorkflowService->save_thread($thread_id);
			break;
		case 'transit_thread':
			$thread_id=$_GET['thread_id']?$_GET['thread_id']:$_POST['thread_id'];//参数：thread_id
			$next_node_index=$_GET['next_node_index']?$_GET['next_node_index']:$_POST['next_node_index'];//参数：thread_id
			//把input收集起来，赋给WorkflowService的Input，另外还要获得thread_id
			$WorkflowService -> input = $_POST;
			//$next_node_index =$next_node_index?$next_node_index:$WorkflowService -> get_next_node_index($thread_id); //得到用户选择的下一结点id
			$WorkflowService->Get_WorkFlow_Parameters($thread_id);////取得$thread  $node $process
			$next_node_index = $WorkflowService->node['next_node_index'];
			$WorkflowService -> transit_thread($thread_id,$next_node_index);
			break;
		case 'list_my_process':// 所有我发起的流程
			$WorkflowService-> list_my_process();
			break;
		case 'list_all_process': //所有我发起的流程
			break;
		case 'view_process':
			break;
		}

	}*/

}
?>