<?php
// +----------------------------------------------------------------------
// | CugleCms 后台管理系统
// +----------------------------------------------------------------------
// | provide by ：yangyongfu.com.cn
// 
// +----------------------------------------------------------------------
// | Author: 452275147@qq.com
// +----------------------------------------------------------------------

/**
 * 工作流Action
 */
class WorkFlowServiceAction extends Action {
	public $defination;
	public $process;
	public $node;
	public $thread;
	public $input; //用户输入的和流程有关的变量
	public $user;
	public $WorkflowProposalHandler;
	public function list_defination()
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
	public function init_process($defination_id)
	{   
		//global $user;
		
		$this->GetHandle($defination_id);//取得$defination，得到业务的handler,例如WorkflowProposalHandler
		
		//$defination_mod=M('wf_defination');
		//$this->defination=$defination_mod->where('defination_id='.$defination_id)->find();

		//$Handler =$this->defination['defination_handler'];//取得$defination，得到业务的handler,例如WorkflowProposalHandler
			
		//if(!isset($Handler)){$Handler='WFProposalHandlerAction.class.php';}
		 
		//include_once(LIB_PATH.Action.'Action/'.$Handler);
		//$this->WorkflowProposalHandler= new WFProposalHandlerAction();
		
		//$this->WorkflowProposalHandler->prepare_input();
		//建立$process行记录
		//插入process行记录，defination_id=$defination_id process_desc current_not_index=0 status=1 start_user=$user[id]
		$process['defination_id']=$defination_id;
		$process['process_desc']='初始化进程';
		$process['current_note_index']='0';
		$process['status']='1';
		$process['context']='';
		$process['start_user']=$_SESSION['admin_info']['id'];
		$process['start_time']=date("Y-m-d H:i:s");
		$process['finish_time']=date("Y-m-d H:i:s");
		$process_mod = M("wf_process"); 
		$process['process_id']=$process_mod -> add($process);
		$this->process=$process;

	}
	public function  start_process()
	{  
		
		$this->process['context']=serialize(array('billid'=>'1'));
		$process_mod = M("wf_process"); 
		$process_mod->execute("update ".C('DB_PREFIX')."wf_process set context='".$this->process['context']."' where process_id=".$this->process['process_id']);
		$this->process=$process_mod->where('process_id='.$this->process['process_id'])->find();
		$this->WorkflowProposalHandler->start($this->process);//新建业务对象，并把业务类的参数例如proposal_id放到$process[‘context’]里面
		
   		$this->init_thread(1);  //默认调用第一个结点
		
		
	}
	public function list_my_thread()
	{  
		//global $user;
		$thread_mod=M('wf_thread');
		$result=$thread_mod->where('executor='.$_SESSION['admin_info']['id'])->select();
		foreach ($result as $key =>$val) {
			$list_rel[]=$val;
			
		}
		print_r($list_rel);
	}
	public function  init_thread($node_index)
	{
	//include_once(LIB_PATH.Action.'Action/'.$Handler);
	//$this->WorkflowProposalHandler= new WFProposalHandlerAction();
	$node_mod=M('wf_node');//取得$node 
	$con=array('node_index'=>$node_index,'defination_id'=>$this->process['defination_id']);
	$this->node=$node_mod->where($con)->find();

	//取得$process
	$this->process['current_note_index']=$node_index;
	$process_mod = M("wf_process"); 
	$process_mod->execute("update ".C('DB_PREFIX')."wf_process set current_note_index='".$node_index."' where process_id=".$this->process['process_id']);//修改$process为运行到当前结点
	
	Switch($this->node['node_type']){
	Case 1: //人工决策
        //建立$thread
		$thread['process_id']=$this->process['process_id'];
		$thread['node_id']=$this->node['node_id'];
		$thread['executor']=$_SESSION['admin_info']['id'];
		$thread['status']=0;//未接收
		$thread_mod = M("wf_thread"); 
		$thread['thread_id']=$thread_mod -> add($thread);
		$this->thread=$thread;
		$this->WorkflowProposalHandler-> init_function ($this->process,$this->node,$this->thread);
       //发送提醒
	   break;
	Case 2: //自动处理
   	 //建立$thread
		$thread['process_id']=$this->process['process_id'];
		$thread['node_id']=$this->node['node_id'];
		$thread['executor']=$_SESSION['admin_info']['id'];
		$thread['status']=0;//未接收
		$thread_mod = M("wf_thread"); 
		$thread['thread_id']=$thread_mod -> add($thread);
		$this->thread=$thread;
		$this->WorkflowProposalHandler-> init_function($this->process,$this->node,$this->thread);
		$this->run_thread($thread['thread_id']);
		
		break;
	Case 3:// 等待外部响应
    //建立$thread
		$thread['process_id']=$this->process['process_id'];
		$thread['node_id']=$this->node['node_id'];
		$thread['executor']=$_SESSION['admin_info']['id'];
		$thread['status']=0;//未接收
		$thread_mod = M("wf_thread"); 
		$thread['thread_id']=$thread_mod -> add($thread);
		$this->thread=$thread;
        $this->WorkflowProposalHandler-> init_function ($process,$node,$thread);
		break;
	Case 4: //分支
		//$subnode;//取得所有分支的子结点
    	//init_thread($subnode);
		break;
	Case 5: //汇总：
    	$subnode;//取得所有前结点，如果所有前结点的Thread都结束了，调出下一结点
       //init_thread($subnode);
	   break;
	Case 6: //结束：直接结束进程process
    //end_process();
	   break;
	}
	}

	public function run_thread($thread_id)
	{
		$thread_mod = M("wf_thread"); 
		$this->thread=$thread_mod -> where('thread_id='.$thread_id)->find(); //取得$thread 
		//$node_mod = M("wf_node");
		//$this->node=$node_mod -> where('node_id='.$this->thread['node_id'])->find();  //取得$node
		//$process_mod = M("wf_process");
		//$this->process=$process_mod -> where('process_id='.$this->thread['process_id'])->find();//取得$process
	
		//$this->Get_WorkFlow_Parameters($thread_id);////取得$thread  $node $process
	
		$run_function=$this->node['run_function'];
		Switch($this->node['node_type']){
		Case 1: //人工决策
			
			$thread_mod->execute("update ".C('DB_PREFIX')."wf_thread set status='1' where thread_id=".$this->thread['thread_id']); //修改$thread为已接收
			//$this->WorkflowProposalHandler-> run_function ($this->$process,$this->$node,$this->$thread);// 显示表单
			$this->WorkflowProposalHandler-> $run_function($this->$process,$this->$node,$this->$thread);
			 break;
		Case 2: //自动处理
			$thread_mod->execute("update ".C('DB_PREFIX')."wf_thread set status='1' where thread_id=".$this->thread['thread_id']); //修改$thread为已接收
			//$next_node_index=$this->WorkflowProposalHandler-> run_function ($process,$node,$thread);
			$this->WorkflowProposalHandler-> $run_function($this->$process,$this->$node,$this->$thread);
			$this->transit_thread($this->thread['thread_id'],$this->node['next_node_index']);//调用transit_thread(thread_id, $next_node_index)
			break;
		Case 3: //等待外部响应
			$thread_mod->execute("update ".C('DB_PREFIX')."wf_thread set status='1' where thread_id=".$this->thread['thread_id']); //修改$thread为已接收
			//$next_node_index=$this->WorkflowProposalHandler-> run_function ($process,$node,$thread);
			$this->WorkflowProposalHandler-> $run_function($this->$process,$this->$node,$this->$thread);
			$this->transit_thread($this->thread['thread_id'],$this->node['next_node_index']);
			 break;
		Case 4: //分支
			break;
		Case 5: //汇总：
			 break;
		Case 6: //结束：
			 break;
		}
		echo "run_thread_end";
	
	}
	public function save_thread($thread_id)
	{  //保存结点数据
	//$this->Get_WorkFlow_Parameters($thread_id);////取得$thread  $node $process
		
	echo "save_thread";

	Switch($this->node['node_type']){
	Case 1: //人工决策
		
		$this->WorkflowProposalHandler-> save_function ($process,$node,$thread);// 保存表单
		$this->WorkflowProposalHandler-> run_function ($process,$node,$thread);// 显示表单
		break;
	Case 2: //自动处理
		
		break;
	Case 3: //等待外部响应
		break;
	Case 4: //分支
		break;
	Case 5: //汇总：
		break;
	Case 6: //结束：
		break;
	}
	}

	public function transit_thread($thread_id, $next_node_index)
	{ 
	//$this->Get_WorkFlow_Parameters($thread_id);////取得$thread  $node $process
	
	
		$thread_mod = M("wf_thread"); 
		$this->thread=$thread_mod -> where('thread_id='.$thread_id)->find(); //取得$thread 
		//$node_mod = M("wf_node");
		//$this->node=$node_mod -> where('node_id='.$this->thread['node_id'])->find();  //取得$node
		//$process_mod = M("wf_process");
		//$this->process=$process_mod -> where('process_id='.$this->thread['process_id'])->find();//取得$process
	
		Switch($this->node['node_type']){
		Case 1: //人工决策
			$this->WorkflowProposalHandler->transit_function($process,$node,$thread,$next_node_index) ; 
			$thread_mod->execute("update ".C('DB_PREFIX')."wf_thread set status='2' where thread_id=".$this->thread['thread_id']); //修改$thread为已完成
			if($next_node_index < $this->process['current_note_index']) { //回退
				//删除所有大于$next_node_index的Thread
			}
	 		
			$this->init_thread($next_node_index);
			break;
		Case 2: //自动处理
		   $thread_mod->execute("update ".C('DB_PREFIX')."wf_thread set status='2' where thread_id=".$this->thread['thread_id']); //修改$thread为已完成
		   if($next_node_index < $this->process['current_note_index']) { //回退
				//删除所有大于$next_node_index的Thread
			}
	
			$this->init_thread($next_node_index);
			break;
		Case 3: //等待外部响应
			$thread_mod->execute("update ".C('DB_PREFIX')."wf_thread set status='2' where thread_id=".$this->thread['thread_id']); //修改$thread为已完成
			if($next_node_index < $this->process['current_note_index']) { //回退
				//删除所有大于$next_node_index的Thread
				}
			$this->init_thread($next_node_index);
				break;
		Case 4: //分支
				break;
		Case 5: //汇总：
				break;
		Case 6: //结束：
				break;
			}
	}
	public function end_process(){
	}
	public function list_my_process(){
		$this->GetUser();
		$process_mod=M('wf_process');
		$where = 'start_user='.$this->user['id'];
		import("ORG.Util.Page");
		$Count = $process_mod->where($where)->count();
		$p = new Page($Count,20);
		$Process_list = $process_mod->where($where)->limit($p->firstRow.','.$p->listRows)->order('process_id DESC')->select();
		$Defination_mod=M('wf_defination');
		foreach($Process_list as $k=>$val){
			$Process_list[$k]['key'] = ++$p->firstRow;
			$Process_list[$k]['defination_name'] = $Defination_mod->field('defination_name')->where('defination_id='.$val['defination_id'])->find();
		}

		$this->assign('process_list',$Process_list);
		$this->display();

		
	}
	public function view_process($process_id){//查看某个进程运行状态
		$this->GetUser();
		$thread_mod=M('wf_thread');
		$where = 'process_id='.$process_id;
		import("ORG.Util.Page");
		$Count = $thread_mod->where($where)->count();
		$p = new Page($Count,20);
		$Thread_list = $thread_mod->where($where)->limit($p->firstRow.','.$p->listRows)->order('thread_id DESC')->select();
		$Process_mod=M('wf_process');
		$Process_mod->where('process_id='.$process_id)->find();
		$Node_mod=M('wf_node');
		foreach($Thread_list as $k=>$val){
			$Thread_list[$k]['key'] = ++$p->firstRow;
			$Thread_list[$k]['node_index'] = $Node_mod->field('node_index')->where('node_id='.$val['node_id'])->find();
		}

		$this->assign('thread_list',$Thread_list);
		$this->display();
		
		
	}
	
	
	
	public function get_next_node_index($thread_id){
	
		$thread_mod = M("wf_thread"); 
		$this->thread=$thread_mod -> where('thread_id='.$thread_id)->find(); //取得$thread 
		 
		$node_mod = M("wf_node"); 

		$node=$node_mod -> where('node_id='.$this->thread['node_id'])->find(); //取得$thread 

		return $node['next_node_index'];
		
	}
	
	public function Get_WorkFlow_Parameters($thread_id){
		$thread_mod = M("wf_thread"); 
		$this->thread=$thread_mod -> where('thread_id='.$thread_id)->find(); //取得$thread 
		$node_mod = M("wf_node");
		$this->node=$node_mod -> where('node_id='.$this->thread['node_id'])->find();  //取得$node
		$process_mod = M("wf_process");
		$this->process=$process_mod -> where('process_id='.$this->thread['process_id'])->find();//取得$process
		
		$this->GetHandle($this->node['defination_id']);
	}
	public function GetHandle($defination_id){
		$defination_mod = M("wf_defination");
		$this->defination=$defination_mod->where('defination_id='.$defination_id)->find();
		$Handler =$this->defination['defination_handler'];//取得$defination，得到业务的handler,例如WorkflowProposalHandler
		if(!isset($Handler)){$Handler='WFProposalHandlerAction.class.php';} 
		include_once(LIB_PATH.Action.'Action/'.$Handler);
		$this->WorkflowProposalHandler= new WFProposalHandlerAction();
		//$this->user['id']=$_SESSION['admin_info']['id'];
		$this->GetUser();
		
	}
	public function GetUser(){
		$this->user=$_SESSION['admin_info'];
	}
	//发送邮件
	/*address 表示收件人地址
	 *title 表示邮件标题 
	 *message表示邮件内容
	 * 
	 * */
 
    
}
?>
