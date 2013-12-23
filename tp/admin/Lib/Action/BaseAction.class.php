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
 * 基础Action
 */
class BaseAction extends Action {
	function initModel(){
//		$this->admin_mod=D('admin');
//		$this->items_cate_mod=D('items_cate');
//		$this->user_mode=D('user');
//		$this->user_info=D('user_info');
//		$this->album_mod=D('album');
//		$this->album_cate_mod=D('album_cate');
//        $this->sendMsg_mod=M('UserMsg');
//        $this->seo_mod = M('seo');
	}
	function _initialize(){
		$this->initModel();		
		$this->site_root="http://".$_SERVER['SERVER_NAME'].($_SERVER['SERVER_PORT']==80?'':':'.$_SERVER['SERVER_PORT']).__ROOT__."/";

		$this->assign('site_root',$this->site_root);
		// 用户权限检查
		$this->checkAuthority();
		//需要登陆
		$admin_info =$_SESSION['admin_info'];
        
		$this->role_mod=D("role");
		//获取用户角色
		$admin_level=$this->role_mod->field('id','name')->where('id='.$_SESSION['admin_info']['role_id'].'')->find();
		
		$this->assign('admin_level',$admin_level);
		$this->assign('my_info', $admin_info);

		// 顶部菜单
		$model	=	M("group");
		$top_menu	=$model->field('id,title')->where('status=1')->order('sort ASC')->select();
		$this->assign('top_menu',$top_menu);

		//获取网站配置信息
		$setting_mod = M('setting');
		$setting = $setting_mod->select();
		foreach ( $setting as $val ) {
			$set[$val['name']] = stripslashes($val['data']);
		}
		$this->setting = $set;   
		
		$this->assign('show_header', true);
		$this->assign('const',get_defined_constants());

		$this->assign('iframe',$_REQUEST['iframe']);
		$def=array(
			'request'=>$_REQUEST
		);	
		$this->assign('def',json_encode($def));
        
	}
	//检查权限
	public function checkAuthority()
	{
		if ((!isset($_SESSION['admin_info']) || !$_SESSION['admin_info']) && !in_array(ACTION_NAME, array('login','verify'))) {
			$this->redirect('Public/login');
		}
		//如果是超级管理员，则可以执行所有操作
		if($_SESSION['admin_info']['id'] == 1) {
			return true;
		}
		if(in_array(ACTION_NAME,array('status','sort_order','ordid'))){
			return true;
		}
		//排除一些不必要的权限检查

		foreach (C('IGNORE_PRIV_LIST') as $key=>$val){
			if(MODULE_NAME==$val['module_name']){
				if(count($val['action_list'])==0)return true;

				foreach($val['action_list'] as $action_item){
					if(ACTION_NAME==$action_item)return true;
				}
			}
		}

		$node_mod = D('node');
		$node_id = $node_mod->where(array('module'=>MODULE_NAME, 'action'=>ACTION_NAME))->getField('id');

		$access_mod = D('access');
		$rel = $access_mod->where(array('node_id'=>$node_id, 'role_id'=>$_SESSION['admin_info']['role_id']))->count();
		
		if ($rel==0) {
			$this->error(L('_VALID_ACCESS_'));
		}
	}	
	//配置V购api基本信息	
	public function miaoApi()
	{
		define('API_CACHETIME','0');  //缓存时间默认为小时   0表示不缓存
		define('API_CACHEPATH','Runtime/Api59miao_cache'); //缓存目录
		define('CHARSET','UTF-8');  //编码
		define('APIURL','http://api.59miao.com/Router/Rest?');  //请求地址		
		define('API_CLEARCACHE','1 23 * *');   //自动清除缓存时间
		vendor('api59miao.init');	
		$appkey = $this->setting['miao_appkey'];
		$appsecret = $this->setting['miao_appsecret'];			
		//引入59秒api文件	
		$AppKeySecret=Api59miao_Toos::GetAppkeySecret($appkey,$appsecret);   //获取appkey appsecret
		$_api59miao=new Api59miao($AppKeySecret);			
		return $_api59miao;
	}
	
	//截取中文字符串
	public function mubstr($str,$start,$length)
	{
		import('ORG.Util.String');
		$a = new String();
		$b = $a->msubstr($str,$start,$length);
		return($b);
	}
	//失败页面重写
	protected function error($message, $url_forward='',$ms = 3, $dialog=false, $ajax=false, $returnjs = '')
	{
		//$this->jumpUrl = $url_forward;
		$this->waitSecond = $ms;
		$this->assign('dialog',$dialog);
		$this->assign('returnjs',$returnjs);
		parent::error($message,$url_forward,$ajax);
	}
	//成功页面重写
	protected function success($message, $url_forward='',$ms = 3, $dialog=false, $ajax=false, $returnjs = '')
	{
		//$this->jumpUrl = $url_forward;
		$this->waitSecond = $ms;
		$this->assign('dialog',$dialog);
		$this->assign('returnjs',$returnjs);
		parent::success($message,$url_forward,$ajax);
	}	
	/*
	 * 通用删除操作
	 * */
	public function delete(){
		$mod=D(MODULE_NAME);
		if (isset($_POST['id']) && is_array($_POST['id'])) {
			$ids = implode(',', $_POST['id']);
			$result=$mod->delete($ids);
		} else {
			$id = intval($_GET['id']);
			$result=$mod->delete($id);
		}
		if($result){
			$this->success(L('operation_success'));
		}else{
			$this->error(L('operation_failure'));
		}
	}	
	/*
	 * 通用改变状态
	 * */
	public function status(){
		$mod = D(MODULE_NAME);
		$id     = intval($_REQUEST['id']);
		$type   = trim($_REQUEST['type']);
		$sql    = "update ".C('DB_PREFIX').MODULE_NAME." set $type=($type+1)%2 where id='$id'";
		$res    = $mod->execute($sql);
		$values = $mod->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}
	/*
	 * 通用排序方法单个排序
	 * */
	public function sort(){
		$mod = D(MODULE_NAME);
		$id     = intval($_REQUEST['id']);
		$type   = trim($_REQUEST['type']);
		$num=trim($_REQUEST['num']);
		if(!is_numeric($num)){
			$values = $mod->where('id='.$id)->find();			
			$this->ajaxReturn($values[$type]);
			exit;
		}
		$sql    = "update ".C('DB_PREFIX').MODULE_NAME." set $type=$num where id='$id'";
        
		$res    = $mod->execute($sql);
		$values = $mod->where('id='.$id)->find();
		$this->ajaxReturn($values[$type]);
	}	
	
	/*
	 * 通用排序,用于提交后排序
	 * */
	public function sortOrder(){
		$mod = D(MODULE_NAME);
		if (isset($_POST['listorders'])) {
			foreach ($_POST['listorders'] as $id=>$sort_order) {
				$data['sort_order'] = $sort_order;
				$mod->where('id='.$id)->save($data);
			}
			$this->success(L('operation_success'));
		}
		$this->error(L('operation_failure'));
	}
	//返回分页信息
	public function pager($count,$pagesize=20){
		import("ORG.Util.Page");
		$pager=new Page($count,$pagesize);
		$this->assign('page', $pager->show());
		return $pager;
	}
	public function append_user($res){
		foreach($res as $key=>$val){
			$res[$key]['user']=$this->user_mode->where('id='.$val['uid'])->find();
		}
		return $res;
	}	
	//公共上传图片方法
	public function upload($savePath)
	{		
		import("ORG.Net.UploadFile");
		$upload = new UploadFile();
		//设置上传文件大小
		$upload->maxSize = 32922000;
		$upload->allowExts = explode(',', 'jpg,gif,png,jpeg');
		$upload->savePath = ROOT_PATH.'/data/'.$savePath.'/';
		$upload->saveRule = uniqid;
		if(!file_exists($upload->savePath)){
			@mkdir($upload->savePath, 0777); 
		}
		if (!$upload->upload()) {
			//捕获上传异常
			$this->error($upload->getErrorMsg());
		} else {
			//取得成功上传的文件信息
			$uploadList = $upload->getUploadFileInfo();
		}
		$uploadList='./data/'.$savePath.'/'.$uploadList['0']['savename'];		
		return $uploadList;
	}
	//发送邮件
	/*address 表示收件人地址
	 *title 表示邮件标题
	 *message表示邮件内容
	 * 
	 * */
	public function sendMail($address,$title,$message){ 
		vendor('mail.mail');
		$message   = preg_replace('/\\\\/','', $message);
		$mail=new PHPMailer(); 
		$mail->IsSMTP();     // 设置PHPMailer使用SMTP服务器发送Email    
		$mail->CharSet='UTF-8';     // 设置邮件的字符编码，若不指定，则为'UTF-8'    
		$mail->Port= $this->setting['mail_port'];    //端口号
		$mail->AddAddress($address);   // 添加收件人地址，可以多次使用来添加多个收件人    
		$mail->Body=$message;     // 设置邮件正文    
		$mail->From=$this->setting['mail_username'];    // 设置邮件头的From字段。  
		$mail->FromName=$this->setting['mail_fromname'];   // 设置发件人名字    
		$mail->Subject=$title;     // 设置邮件标题    
		$mail->Host=$this->setting['mail_smtp'];        // 设置SMTP服务器。    
		$mail->SMTPAuth=true;   // 设置为“需要验证”
		$mail->Username=$this->setting['mail_username'];     // 设置用户名和密码。    
		$mail->Password=$this->setting['mail_password'];    // 发送邮件。   
		return($mail->Send());
	}  
    
}
?>
