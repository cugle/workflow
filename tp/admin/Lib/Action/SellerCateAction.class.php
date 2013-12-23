<?php
// +----------------------------------------------------------------------
// | CugleCms 后台管理系统
// +----------------------------------------------------------------------
// | provide by ：yangyongfu.com.cn
// 
// +----------------------------------------------------------------------
// | Author: 452275147@qq.com
// +----------------------------------------------------------------------

class SellerCateAction extends BaseAction
{	//显示列表
	public function index()
	{
		$seller_cate_mod = D('seller_cate');	
		$keyword=isset($_GET['keyword'])?trim($_GET['keyword']):'';		
		//搜索
		$where = '1=1';
		if ($keyword!='') {
			$where .= " AND name LIKE '%".$keyword."%'";
			$this->assign('keyword', $keyword);
		}		
		import("ORG.Util.Page");
		$count = $seller_cate_mod->where($where)->count();
		$p = new Page($count,20);
		$seller_cate_list = $seller_cate_mod->where($where)->limit($p->firstRow.','.$p->listRows)->order('sort asc')->select();
		$page = $p->show();
		$this->assign('page',$page);	
		$this->assign('seller_cate_list',$seller_cate_list);
		$this->display();
	}
	//修改
	public function edit()
	{
		$seller_cate_mod = D('seller_cate');
		if( isset($_GET['id']) ){
			$seller_cate_id = isset($_GET['id']) && intval($_GET['id']) ? intval($_GET['id']) : $this->error(L('please_select'));
		}		
		$seller_cate_info = $seller_cate_mod->where('id='.$seller_cate_id)->find();
		$this->assign('show_header', false);	
		$this->assign('seller_cate_info',$seller_cate_info);
		$this->display();
	}
	//更新
	public function update()
	{		
		if((!isset($_POST['id']) || empty($_POST['id']))) {
			$this->error('请选择要编辑的数据');
		}
		$seller_cate_mod = D('seller_cate');
		//获取原图片	
		if(false === $data = $seller_cate_mod->create()){
			$this->error($seller_cate_mod->error());
		}		
		$result = $seller_cate_mod->save($data);
		if(false !== $result){
			$this->success(L('operation_success'), '', '', 'edit');
		}else{
			$this->error(L('operation_failure'));
		}
	}
	//增加
	public function add()
	{		
		$this->display();
	}
	//插入数据
	public function insert()
	{
		$seller_cate_mod = D('seller_cate');	
		if(false === $data = $seller_cate_mod->create()){
			$this->error($seller_cate_mod->error());
		}		
		$result = $seller_cate_mod->add($data);
		if($result){
			$this->success(L('operation_success'), '', '', 'add');
		}else{
			$this->error(L('operation_failure'));
		}
	}
	//addb2ccate增加b2c数据
	public function addB2cCate(){			
		$seller_cate_mode=D('seller_cate');
		$miao_api=miao_client($this->setting['miao_appkey'],$this->setting['miao_appsecret']);	  //初始化api接口
		$allcate=$this->getShopCats($miao_api);			
		$status=1;
		$sort=10;	
		foreach ($allcate as $value){			
			$cid=$value['cid'];
			$name=$value['name'];			
			$count=$value['count'];			
			$_updateData=array(
				'cid'=>$cid,
				'name'=>$name,
				'count'=>$count,
				'status'=>$status,
				'sort'=>$sort
			);
			$_where = array();	
			$data='';
			$data=$seller_cate_mode->where("cid=$cid")->find();				
			if(count($data)>0){
				$seller_cate_mode->where("cid=$cid")->save($_updateData);			
			}
			else{				
				$seller_cate_mode->add($_updateData);		
			}
		}
		$this->success(L('operation_success'));
	}
	//获取商家分类
	public function getShopCats($miao_api){			
		$fields = 'cid,name,count';		
		$data = $miao_api->ListShopCatsGet($fields);
		$shop_cats = $data['shop_cats']['shop_cat'];		
		return $shop_cats;		
	}		
}
?>