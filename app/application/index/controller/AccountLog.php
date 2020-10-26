<?php 
namespace app\index\controller;
use app\index\controller\Base;
class AccountLog extends Base
{
	//支付记录
	public function paymentlog(){
		$uid = getUid();
		if(request()->isAjax()){
			$balanceModel = model("balance");
			$cur_page = input("page");
        	$size = 16;
        	$where = ['type'=>1,'uid'=>$uid,'state'=>2];
        	//统计异性会员的数据
	    	$count = $balanceModel->where($where)->count();
	        $pages = ceil($count/$size);


			$list = $balanceModel->where($where)->order('addtime desc')->limit(15)->select();
			foreach ($list as $k => &$val) {
				$val['addtime'] = date('m-d H:i', strtotime($val['addtime']));
			}
			return json(["list"=>$list,"pages"=>$pages]);
		}
		return $this->fetch();
	}


	//消费记录
	public function paylog(){
		$uid = getUid();
		if(request()->isAjax()){
			$balanceModel = model("balance");
			$cur_page = input("page");
        	$size = 16;
        	$where = ['type'=>['neq',1],'uid'=>$uid,'state'=>2];
        	//统计异性会员的数据
	    	$count = $balanceModel->where($where)->count();
	        $pages = ceil($count/$size);


			$list = $balanceModel->where($where)->order('addtime desc')->limit(15)->select();
			foreach ($list as $k => &$val) {
				$val['addtime'] = date('m-d H:i', strtotime($val['addtime']));
			}
			return json(["list"=>$list,"pages"=>$pages]);
		}
		return $this->fetch();
	}
}