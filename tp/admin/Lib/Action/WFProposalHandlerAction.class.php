<?php
// +----------------------------------------------------------------------
// | CugleCms 后台管理系统
// +----------------------------------------------------------------------
// | provide by ：yangyongfu.com.cn
// 
// +----------------------------------------------------------------------
// | Author: 452275147@qq.com
// +----------------------------------------------------------------------

class WFProposalHandlerAction extends BaseAction
{
	public function start(){
	echo "WFProposalHandlerAction->start<br/>";
	}
	public function prepare_input() //准备用户输入变量，从$_POST收集
	{
	}
	public function init_function () //线程建立后调用的默认函数，当流程的执行者由程序生成时，在此函数内更改$thread的executor，例如直接赋值user[2]
	{
	echo "WFProposalHandlerAction->init_function<br/>";
	}
	public function run_function () //线程运行化时候调用的默认函数
	{
	echo "WFProposalHandlerAction->run_function<br/>";
	}
	public function save_function () //保存运行信息
	{
	echo "WFProposalHandlerAction->save_function<br/>";
	}
	public function transit_function () //执行流转
	{
	echo "WFProposalHandlerAction->transit_function<br/>";
	}

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