<?php 
//钱包功能
namespace app\index\controller;
use app\index\controller\Base;
class Wallet extends Base
{
	public function index(){
		$this->assign("userinfo",$this->userinfo);
		return $this->fetch();
	}
}