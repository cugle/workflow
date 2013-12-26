<?php
class IndexAction extends Action {
	public $APPID='wxdfe16ecbb096f06b';
	public $APPSECRET='95f0b9bd441d6065baa8988940a44ad7';
	public $ACCESS_TOKEN;
	public function index(){
	define("TOKEN", "weixin");
	if (isset($_GET['echostr'])) {
		$this->valid();
	}else{
		$this->responseMsg();
	}
	}
	public function valid()
    {
        $echoStr = $_GET["echostr"];
        if($this->checkSignature()){
            echo $echoStr;
			
            exit;
        }
    }

    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $tmpStr == $signature ){
            return true;
        }else{
            return false;
        }
    }
	public function responseMsg()
    {
        
		$receivedata=$this->receivedata();//接受数据
		$data=$this->Process($receivedata);//处理进程
				 
        if ($data){  
		$resultStr=$this->formatdata($receivedata);	//格式化数据 
		echo $resultStr;
        }else{
            echo "";
            exit;
        }
    }
	public function Process($receivedata){//数据处理调用进程
	
		if($receivedata['MsgType']=='event'&&$receivedata['Event']=='subscribe'){//第一次关注
		
		$this->regmember($receivedata['FromUserName']);//注册user
		}else{
		//获得用户状态
		//判断系统中是否记录了这个用户
		//登记每个微信用户，记录状态
		if(1==1){//检测用户状态，是否在进程当中，
		//如果在进程之中，调用工作流处理。
		$resdata=$receivedata;
		}else if(1==1){//如果不在进程之中，判断是否进入流程。
		$resdata=$receivedata;
		}else{//如果都不是则不调用工作流，另作处理。
		$resdata=$receivedata;
		}
		}
		return $resdata;
	}
	public function getaccess_token(){
		$jsondata=file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$this->APPID."&secret=".$this->APPSECRET);
		$weixindata=json_decode($jsondata);
		$this->ACCESS_TOKEN=$weixindata->access_token;
		return $this->ACCESS_TOKEN;
	}
	public function getuserinfo($OPENID){
		$this->ACCESS_TOKEN=$this->ACCESS_TOKEN?$this->ACCESS_TOKEN:$this->getaccess_token();
		$jsondata=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->ACCESS_TOKEN."&openid=".$OPENID);
		$userinfo=json_decode($jsondata);
		
		return $userinfo;
	}	
	public function regmember($OPENID){

		$userinfo=$this->getuserinfo($OPENID);
		$user_mod=M('user');//取得$user 
 
		$userrow=$user_mod -> where('name="'.$userinfo->nickname.'"')->count(); //取得$thread 
 
		if($userrow<1){
		$user['name']=$userinfo->nickname;
		$user['sex']=$userinfo->sex;
		$user['add_time']=$userinfo->subscribe_time;
		$user['ip']='140.206.160.191';
		$user['last_ip']='140.206.160.191';
		$user['last_time']=$userinfo->subscribe_time;
		$user['status']='0';
		$user['status']='1';
		$user['weixinstatus']='0';
		$user['id']=$user_mod -> add($user);
		}else{
		return false;
		}
	}
	public function receivedata(){
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		$parameter['text']=array('ToUserName','FromUserName','CreateTime','MsgType','Content','MsgId');
		$parameter['image']=array('ToUserName','FromUserName','CreateTime','MsgType','PicUrl','MediaId','MsgId');
		$parameter['voice']=array('ToUserName','FromUserName','CreateTime','MsgType','Format','MediaId','MsgId');
		$parameter['video']=array('ToUserName','FromUserName','CreateTime','MsgType','ThumbMediaId','MediaId','MsgId');
		$parameter['location']=array('ToUserName','FromUserName','CreateTime','MsgType','Location_X','Location_Y','Scale','Label','MsgId');
		$parameter['link']=array('ToUserName','FromUserName','CreateTime','MsgType','Title','Description','Url','MsgId');
		$parameter['event']=array('ToUserName','FromUserName','CreateTime','MsgType','Event','EventKey','Ticket');
		if (!empty($postStr)){
            $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
			$data['MsgType'] = trim($postObj->MsgType);
			$MsgType=$data['MsgType'];
			$array=$parameter[$MsgType];
			
			foreach($array as $value){  
			$data[$value] = trim($postObj->$value);
			
			} 
			
            $data['CreateTime'] = time();

			return $data;
		}else{
		 	return false;
		}
	}
	public function formatdata($data){//将数据输出成xml格式，$data为数组格式，其中$data['newsitem']同为数组格式
            $Tpl['text'] = <<<EOF
			<xml>
			<ToUserName><![CDATA[%s]]></ToUserName>
			<FromUserName><![CDATA[%s]]></FromUserName>
			<CreateTime>%s</CreateTime>
			<MsgType><![CDATA[%s]]></MsgType>
			<Content><![CDATA[%s]]></Content>
			<FuncFlag>0</FuncFlag>
			</xml> 
EOF;
//回复图片模板
		   $Tpl['image'] =<<<EOF
			<xml>
			<ToUserName><![CDATA[toUser]]></ToUserName>
			<FromUserName><![CDATA[fromUser]]></FromUserName>
			<CreateTime>12345678</CreateTime>
			<MsgType><![CDATA[image]]></MsgType>
			<Image>
			<MediaId><![CDATA[media_id]]></MediaId>
			</Image>
			</xml>
EOF;
		   $Tpl['news']=
						'<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[news]]></MsgType>
						<ArticleCount>%s</ArticleCount>
						<Articles>
						%s
						</Articles>
						</xml> ';//回复图文模板
		 $Tpl['newsitem']='<Title><![CDATA[%s]]></Title>
						<Description><![CDATA[%s]]></Description>
						<PicUrl><![CDATA[%s]]></PicUrl>
						<Url><![CDATA[%s]]></Url>
						</item>';
		  $Tpl['voice']='<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Voice>
						<MediaId><![CDATA[%s]]></MediaId>
						</Voice>
						</xml>'; //回复语音模板
		  $Tpl['video']='
						<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Video>
						<MediaId><![CDATA[%s]]></MediaId>
						<Title><![CDATA[%s]]></Title>
						<Description><![CDATA[%s]]></Description>
						</Video> 
						</xml>';//回复视频模板
		  $Tpl['music'] ='
						<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Music>
						<Title><![CDATA[%s]]></Title>
						<Description><![CDATA[%s]]></Description>
						<MusicUrl><![CDATA[%s]]></MusicUrl>
						<HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
						<ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
						</Music>
						</xml>';//回复音乐模板
						

		
		switch($data['MsgType']){//根据回复类型格式化数据
		case 'text':
			$resultStr = sprintf($Tpl[$data['MsgType']],$data['ToUserName'],$data['FromUserName'],$data['CreateTime'],$data['MsgType'],$data['Content']);
			break;
		case 'image':
			$resultStr = sprintf($Tpl[$data['MsgType']],$data['ToUserName'],$data['FromUserName'],$data['CreateTime'],$data['MsgType'],$data['PicUrl'],$data['MediaId']);
			break;
		case 'news':
			if(isset($data['newsitem'])){//多图文项目
			foreach($data['newsitem'] as $value){
				 $newstiem.=sprintf($Tpl['newsitem'],$value['Title'],$value['Description'],$value['PicUrl'],$value['Url']);
			}
			$data['newsitem']=$newstiem;
			}
			$resultStr = sprintf($Tpl[$data['MsgType']],$data['FromUserName'],$data['ToUserName'],$data['CreateTime'],$data['MsgType'],$data['ArticleCount'],$data['newstiem']);
			break;
		case 'voice':
			$resultStr = sprintf($Tpl[$data['MsgType']],$data['ToUserName'],$data['FromUserName'],$data['CreateTime'],$data['MsgType'],$data['Format'],$data['MediaId']);
			break;
		case 'video':
			$resultStr = sprintf($Tpl[$data['MsgType']],$data['ToUserName'],$data['FromUserName'],$data['CreateTime'],$data['MsgType'],$data['ThumbMediaId'],$data['MediaId']);
			break;
		case 'music':
			$resultStr = sprintf($Tpl[$data['MsgType']],$data['ToUserName'],$data['FromUserName'],$data['CreateTime'],$data['MsgType'],$data['Title'],$data['Description'],$data['MusicUrl'],$data['HQMusicUrl'],$data['ThumbMediaId']);
			break;
		}
        
			  
		return $resultStr;	
	}
	public	function HTTP_Post($URL,$data,$cookie, $referrer="")//有些服务器可能需要通过此方式
	{
				$URL_Info=parse_url($URL);
				// making string from $data
				// Find out which port is needed - if not given use standard (=80)
				if(!isset($URL_Info["port"])){
					$URL_Info["port"]=80;
				}
				// building POST-request:
				$request.="POST ".$URL_Info["path"]." HTTP/1.1\n";
				$request.="Host: ".$URL_Info["host"]."\n";
				$request.="Referer: $referer\n";
				$request.="Content-type: application/x-www-form-urlencoded\n";
				$request.="Content-length: ".strlen($data)."\n";
				$request.="Connection: close\n";
				$request.="Cookie:   $cookie\n";
				$request.="\n";
				$request.=$data."\n";
				$fp = fsockopen($URL_Info["host"],$URL_Info["port"]);
				fputs($fp, $request);
				while(!feof($fp)) {
					$result .= fgets($fp, 1024);
				}
				fclose($fp);
			$result = preg_replace (array ("'HTTP/1[\w\W]*<xml>'i","'</xml>[\w\W]*0'i"),array ("<xml>","</xml>"),$result);
			return trim($result);
	}
	
public	function vcurl($url, $post = '', $cookie = '', $cookiejar = '', $referer = ''){
			$tmpInfo = '';
			$cookiepath = getcwd().'./'.$cookiejar;
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, $url);
			curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
			if($referer) {
			curl_setopt($curl, CURLOPT_REFERER, $referer);
			} else {
			curl_setopt($curl, CURLOPT_AUTOREFERER, 1);
			}
			if($post) {
			curl_setopt($curl, CURLOPT_POST, 1);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
			}
			if($cookie) {
			curl_setopt($curl, CURLOPT_COOKIE, $cookie);
			}
			if($cookiejar) {
			curl_setopt($curl, CURLOPT_COOKIEJAR, $cookiepath);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $cookiepath);
			}
			//curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
			curl_setopt($curl, CURLOPT_TIMEOUT, 5);
			curl_setopt($curl, CURLOPT_HEADER, 0);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			$tmpInfo = curl_exec($curl);
			if (curl_errno($curl)) {
			 return curl_error($curl);
			}
			curl_close($curl);
			return $tmpInfo;
	} 

}   
?>