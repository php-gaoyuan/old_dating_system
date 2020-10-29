<?php 
//namespace auth;
class Auth{
	public $group=1;//会员等级



	//可以查看多少个该会员
	public function look_member(){
		if($this->group == 1){
			return false;
		}else{
			return true;
		}
	}

}