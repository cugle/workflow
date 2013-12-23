<?php
// +----------------------------------------------------------------------
// | CugleCms 后台管理系统
// +----------------------------------------------------------------------
// | provide by ：yangyongfu.com.cn
// 
// +----------------------------------------------------------------------
// | Author: 452275147@qq.com
// +----------------------------------------------------------------------

class SellerListAction extends BaseAction
{	//显示列表
	public function index()
	{
		$seller_list_mod = D('seller_list');	
		$cate_list_mod = D('seller_cate');
		$seller_list_cate_mod = D('seller_list_cate');
		$cate_list=$cate_list_mod->where("status=1")->order("sort DESC")->select();		
		$cate_list=set_array_form_item($cate_list, 'id', 'name');		
		$keyword=isset($_GET['keyword'])?trim($_GET['keyword']):'';	
		$cate_id=isset($_GET['cate_id']) && intval($_GET['cate_id']) &&($_GET['cate_id']!=0)?intval($_GET['cate_id']):'';	
		//搜索
		$where = '1=1';
		if ($keyword!='') {
			$where .= " AND name LIKE '%".$keyword."%'";
			$this->assign('keyword', $keyword);
		}
		if($cate_id){				
			$seller_list_id=$seller_list_cate_mod->where("cate_id='{$cate_id}'")->field('list_id')->select();
			$str='';
			foreach ($seller_list_id as $value){
				$str.=$value['list_id'].',';
			}
			$str=substr($str,0,-1);			
			$where .= " AND id in ($str)";		
			$this->assign('cate_id', $cate_id);
		}		
		import("ORG.Util.Page");
		$count = $seller_list_mod->where($where)->count();
		$p = new Page($count,20);
		$seller_list_list = $seller_list_mod->where($where)->limit($p->firstRow.','.$p->listRows)->order('sort asc')->select();
		$page = $p->show();
		$this->assign('cate_list',$cate_list);
		$this->assign('page',$page);	
		$this->assign('seller_list_list',$seller_list_list);
		$this->display();
	}
	//修改
	public function edit()
	{
		$seller_list_mod = D('seller_list');
		if( isset($_GET['id']) ){
			$seller_list_id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error(L('please_select'));
		}		
		$seller_list_info = $seller_list_mod->where('id='.$seller_list_id)->find();
		
		
		//所有分类
		$cate_list_mod = D('seller_cate');
		$cate_list=$cate_list_mod->where("status=1")->order("sort DESC")->select();	
		$cate_list=set_array_form_item($cate_list,'id','name');  //所有分类
		//选中分类
		$seller_list_cate_mod = D('seller_list_cate');
		$seller_list_cate=$seller_list_cate_mod->where("list_id=$seller_list_id")->select();
		
		//筛选出选中分类的id以及名称
		$sellect_cate_list='';
		foreach ($seller_list_cate as $key=>$val){
			if(array_key_exists($val['cate_id'] , $cate_list)){				
				$sellect_cate_list.=$val['cate_id'].',';
			}
		}	
		$sellect_cate_list=substr($sellect_cate_list,0,-1);	
		$sellect_cate_list=explode(',',$sellect_cate_list);	
		$cate_str='';
		foreach ($cate_list as $key=>$value){
			if(in_array($key, $sellect_cate_list)){
				$cate_str.=' <input type="checkbox" value="'.$key.'" name="cate_id[]" checked="checked"> '.$value.'';
			}else{
				$cate_str.=' <input type="checkbox" value="'.$key.'" name="cate_id[]"> '.$value.'';
			}
		}		
		
		$this->assign('show_header', false);
		//所有分类
		$this->assign('cate_str',$cate_str);
				
		$this->assign('seller_list_info',$seller_list_info);
		$this->display();
	}
	//更新
	public function update()
	{				
		if((!isset($_POST['id']) || empty($_POST['id']))) {
			$this->error('请选择要编辑的数据');
		}
		$id=intval($_POST['id']);
		$seller_list_mod = D('seller_list');
		$seller_list_cate_mod = D('seller_list_cate');
		//获取原图片			
		$old_img=$seller_list_mod->where("id=$id")->getField('site_img');			
		if(false === $data = $seller_list_mod->create()){
			$this->error($seller_list_mod->error());
		}
		if ($_FILES['img']['name']!='') {
			$upload_list = $this->_upload('seller_list');
			$data['site_logo'] = $upload_list;
			//删除老图片
			$img_dir=$old_img;
			if(file_exists($img_dir)){
				@unlink($img_dir);
			}
		}
		$result = $seller_list_mod->where("id=$id")->save($data);	
		
		$seller_list_cate_mod->where("list_id=".$id)->delete();		
		$cate_id = $_REQUEST['cate_id'];
		foreach ($cate_id as $v) {
			$data=array();
			$data['list_id'] = $id;
			$data['cate_id'] =$v ;			
			$seller_list_cate_mod->add($data);						
		}	
		
		if(false !== $result){
			$this->success(L('operation_success'), '', '', 'edit');
		}else{
			$this->error(L('operation_failure'));
		}
	}
	//增加
	public function add()
	{		
				//所有分类
		$cate_list_mod = D('seller_cate');
		$cate_list=$cate_list_mod->where("status=1")->order("sort DESC")->select();	
		$cate_list=set_array_form_item($cate_list,'id','name');  //所有分类
		//选中分类
		$seller_list_cate_mod = D('seller_list_cate');
		$seller_list_cate=$seller_list_cate_mod->where("list_id=$seller_list_id")->select();
		
		//筛选出选中分类的id以及名称
		$sellect_cate_list='';
		foreach ($seller_list_cate as $key=>$val){
			if(array_key_exists($val['cate_id'] , $cate_list)){				
				$sellect_cate_list.=$val['cate_id'].',';
			}
		}	
		$sellect_cate_list=substr($sellect_cate_list,0,-1);	
		$sellect_cate_list=explode(',',$sellect_cate_list);	
		$cate_str='';
		foreach ($cate_list as $key=>$value){
			if(in_array($key, $sellect_cate_list)){
				$cate_str.=' <input type="checkbox" value="'.$key.'" name="cate_id[]" checked="checked"> '.$value.'';
			}else{
				$cate_str.=' <input type="checkbox" value="'.$key.'" name="cate_id[]"> '.$value.'';
			}
		}
		
		$this->assign('cate_str',$cate_str);
		$this->display();
	}
	//插入数据
	public function insert()
	{		
		$seller_list_mod = D('seller_list');	
		if(false === $data = $seller_list_mod->create()){
			$this->error($seller_list_mod->error());
		}		
		if ($_FILES['img']['name']!='') {
			$upload_list = $this->_upload('seller_list');
			$data['site_logo'] = $upload_list;
		}		
		$result = $seller_list_mod->add($data);
		if($result){
			$seller_list_cate_mod = D('seller_list_cate');
			$cate_id = $_REQUEST['cate_id'];
			foreach ($cate_id as $v) {
				$data=array();
				$data['list_id'] = $result;
				$data['cate_id'] =$v ;			
				$seller_list_cate_mod->add($data);						
			}
			
			$this->success(L('operation_success'), '', '', 'add');
		}else{
			$this->error(L('operation_failure'),'', '', 'edit');
		}
	}
	//addb2cdata增加b2c数据
	public function addB2cData(){
		$miao_api=miao_client($this->setting['miao_appkey'],$this->setting['miao_appsecret']);	  //初始化api接口
		$seller_list=D('seller_list');	  //商家列表	
		$seller_cate=D('seller_cate');	  //商家列表
		$seller_list_cate=D('seller_list_cate');	  //商家对应分类		
		$page_size=20;
		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;//当前页	
		$date = isset($_GET['date']) && intval($_GET['date']) ? intval($_GET['date']) : date('Ymd',time());	//当前更新的时间		
		//调取数据入库
		$data=$this->shopListGet($miao_api, $page, $page_size);   //获取api商家数据		
		$data=addslashes_set($data);		 //对数组进行转义		
		if(isset($data[0])){
			foreach ($data as $k=>$v){
				//$cid=$value['cid'];				
				$sid=$v['sid'];						
				$name=$v['name'];			
				$net_logo=$v['logo'];
				//如果不是二维数组，转换为二维数组
				if(is_two_array($v['sellercats']['sellercat'])){
					$v['sellercats']['sellercat']=array($v['sellercats']['sellercat']);
				}	
				$cid='';
				$_where =("sid=$sid");	
				$has_data='';
				$has_data=$seller_list->where($_where)->find();
				//print_r($v['sellercats']['sellercat']);
				
				if(empty($has_data)){    //判断数据是否存在如果存在则不插入数据库		
					if(count($v['sellercats']['sellercat'])>0){
						foreach ($v['sellercats']['sellercat'] as $value){		
								$Auto_increment_id=$seller_list->query('SHOW TABLE STATUS LIKE \''.C('DB_PREFIX').'seller_list\'');					
								$cate_id= $seller_cate->where("cid='{$value['cid']}'")->field('id')->find();  //分类id							
								$list_cate_data=array(
									'list_id'=>$Auto_increment_id[0]['Auto_increment'],
									'cate_id'=>$cate_id['id']
								);							
								$seller_list_cate->add($list_cate_data);											
						}	
					}
				}				
				$click_url=$v['click_url'];
				$sort=10;
				$desc=$v['desc'];
				if(is_array($desc)){
					$desc=$name;
				}						
				$status=1;
				//是否免费送货 
				if($v['freeshipment']=='False'){
					$freeshipment=0; 
				}
				else{
					$freeshipment=1;
				}
				//是否支持分期付款 
				if($v['installment']=='False'){
					$installment=0;
				}
				else{
					$installment=1;
				}
				//是否有发票
				if($v['has_invoice']=='False'){
					$has_invoice=0; 
				}
				else{
					$has_invoice=1;
				}
				$cash_back_rate=$v['cashbacks']['cashback']['scope'];
				
				$_updateData=array(
					'sid'=>$sid,							
					'name'=>$name,
					'net_logo'=>$net_logo,					
					'click_url'=>$click_url,											
					'status'=>$status,
					'sort'=>$sort,	
					'description'=>$desc,
					'freeshipment'=>$freeshipment,
					'installment'=>$installment,
					'has_invoice'=>$has_invoice,
					'cash_back_rate'=>$cash_back_rate,
					'update_time'=>$date								
				);								
				if(count($has_data)>0){   //如果有数据执行更新操作操作
					$seller_list->where($_where)->save($_updateData);				
				}
				else{				//如果有数据执行增加操作
					$seller_list->where($_where)->add($_updateData);
				}
			}
			$this->_collect_success('正在采集第 <em class="blue">'.$page.'</em> 页，请稍后',
			U('SellerList/addB2cData', array('page'=>$page+1,'date'=>$date)));		
		}
		else{		
			//采集完成删除下架商家
			$seller_list_mod=D('seller_list');
			$seller_list_cate_mod=D('seller_list_cate');
			$rel=$seller_list_mod->where("update_time!='{$date}'")->select();
			$ids='';
			foreach ($rel as $value){
				$ids.=$value['id'].',';
				$seller_list_cate_mod->where("list_id='{$value['id']}'")->delete();          //删除商家信息
			}
			$ids=substr($ids, 0,-1);
			$result=$seller_list_mod->delete($ids);
			$this->_collect_success('数据同步完成', '', 'addb2cdata');			
		}	
	}
	private function shopListGet($miao_api,$page_no,$page_size){
		$data = $miao_api->ListShopListGet('',Array('page_no' =>$page_no, 'page_size' =>$page_size));
		return $data['shops']['shop'];
	}
	//采集成功跳转
	private function _collect_success($message, $jump_url, $dialog='')
	{
		$this->assign('message', $message);
		if(!empty($jump_url)) $this->assign('jump_url', $jump_url);
		if(!empty($dialog)) $this->assign('dialog', $dialog);
		$this->display(APP_PATH.'Tpl/'.C('DEFAULT_THEME').'/SellerList/collect_success.html');
		exit;
	}
	public function delete(){
		$mod=D(MODULE_NAME);
		$seller_list_cate_mod=D('seller_list_cate');

		if (isset($_POST['id']) && is_array($_POST['id'])) {
			$ids = implode(',', $_POST['id']);
			$id_array=$_POST['id'];
			for ($i=0;$i<count($id_array);$i++){
				$seller_list_cate_mod->where("list_id='{$id_array[$i]}'")->delete();          //删除商家信息
			}			
			$result=$mod->delete($ids);
			
		} else {
			$id = intval($_GET['id']);
			$result=$mod->delete($id);
			$seller_list_cate_mod->where("list_id='{$id}'")->delete();
		}
		if($result){
			$this->success(L('operation_success'));
		}else{
			$this->error(L('operation_failure'));
		}
	}
}
?>