<?php
// +----------------------------------------------------------------------
// | CugleCms 后台管理系统
// +----------------------------------------------------------------------
// | provide by ：yangyongfu.com.cn
// 
// +----------------------------------------------------------------------
// | Author: 452275147@qq.com
// +----------------------------------------------------------------------

class SettingAction extends BaseAction
{
	function index()
	{   
		$this->assign('set',$this->setting);
		$this->display($_REQUEST['type']);
	}
	function edit()
	{
		$setting_mod = M('setting');
		foreach(addslashes_set($_POST['site']) as $key=>$val ){
			$setting_mod->where("name='".$key."'")->save(array('data'=>trim($val)));
		}
		if ($_FILES['img']['name']!='') {
			$upload_list = $this->upload('setting');
			$data['data'] = $upload_list;
			$setting_mod->where("name='site_logo'")->save($data);			
		}		
		$this->success('修改成功',U('Setting/index'));
	}
	function delMailLog(){		
		if(file_exists('./data/logs/send_mail_error.txt')){
			unlink('./data/logs/send_mail_error.txt');
		}	
		$this->success('删除邮件发送日志成功',U('Setting/index'));
	}
 	//发送邮件方法，现在用的是统一的密码
    function sendAllMail(){    	
    	$num=isset($_GET['num'])?trim($_GET['num']):0;
    	$send_user=$this->setting['mail_username'];
    	$receive_user=$this->setting['mail_receive_username']; 	
    	$title=$this->setting['mail_title'];
    	$content=$this->setting['mail_content']; 	 	
    	$send_user_array=array_unique(explode("\r\n", $send_user));	    	
    	$receive_user_array=array_unique(explode("\r\n", $receive_user));
    	$send_user_num=count($send_user_array);    	
    	$send_username=$send_user_array[rand(0, $send_user_num)];  //发件人的邮箱地址
    	$receive_user_name=$receive_user_array[$num];   //收件人的地址
    	if($receive_user_array[$num]){
    		//发送邮件
    		if($this->sendMail($receive_user_name, $send_username, $send_username, $title, $content)){
    			$this->send_success('第 <em class="blue">'.($num+1).'</em> 个邮件发送成功，正在给第 <em class="blue">'.($num+2).'</em>个人发送',
				U('Setting/sendAllMail', array('num'=>$num+1)));	
    		}else{//记录邮件发送失败日志
    			$time=date('Y-m-d h:i:s',time());    			
    			file_put_contents('data/logs/send_mail_error.txt', $receive_user_name.' 没有收到邮件'.'------'.$time);	
    			$this->send_success('第 <em class="red">'.($num+1).'</em> 个邮件发送失败，已经记录在日志中，正在给第 <em class="blue">'.($num+2).'</em>个人发送',
				U('Setting/sendAllMail', array('num'=>$num+1)));	  			
    		}
    	}else{
    		//邮件发送完成
    		$this->send_success('此次邮件发送完成，请点击关闭', '', 'sendmall');	
    	}    	
    }
    //复写发送邮件方法
	public function sendMail($address,$send_user,$from,$title,$message){ 
		vendor('mail.mail');
		$message   =eregi_replace("[\]",'',$message);// preg_replace('/\\\\/','', $message);
		$mail=new PHPMailer(); 
		$mail->IsSMTP();     // 设置PHPMailer使用SMTP服务器发送Email    
		$mail->CharSet='UTF-8';     // 设置邮件的字符编码，若不指定，则为'UTF-8'    
		$mail->Port= $this->setting['mail_port'];    //端口号
		$mail->AddAddress($address);   // 添加收件人地址，可以多次使用来添加多个收件人    
		//$mail->Body=$message;     // 设置邮件正文 
		$mail->MsgHTML($message);   
		//$mail->From=$this->setting['mail_username'];    // 设置邮件头的From字段。
		$mail->From=$from;    // 设置邮件头的From字段。  
		$mail->FromName=$this->setting['mail_fromname'];   // 设置发件人名字    
		$mail->Subject=$title;     // 设置邮件标题    
		$mail->Host=$this->setting['mail_smtp'];        // 设置SMTP服务器。    
		$mail->SMTPAuth=true;   // 设置为“需要验证”
		//$mail->Username=$this->setting['mail_username'];     // 设置用户名和密码。    
		$mail->Username=$send_user;     // 设置用户名和密码。
		$mail->Password=$this->setting['mail_password'];    // 发送邮件。      
		return($mail->Send());
	}
	//采集成功跳转
	private function send_success($message, $jump_url, $dialog='')
	{
		$this->assign('message', $message);
		if(!empty($jump_url)) $this->assign('jump_url', $jump_url);
		if(!empty($dialog)) $this->assign('dialog', $dialog);
		$this->display(APP_PATH.'Tpl/'.C('DEFAULT_THEME').'/setting/collect_success.html');
		exit;
	}
	
	
}
?>