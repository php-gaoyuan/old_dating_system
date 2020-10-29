<?php 
namespace app\index\controller;
use think\Controller;
use think\Db;
class Download extends Controller
{
	//http://app.puivip.com/index/download/index.html
	//http://www.puivip.com/apk/puivip-1.1.5.apk
	public function index(){
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false){
			$this->redirect("Index/index");exit;
		}


		$version = "1.1";
		$this->assign("version",$version);


		$size = file_size("../apk/puivip-".$version.".apk");
		$this->assign("size",$size);



		$type = get_device_type();
		$downLoadUrl="";
		if($type=="android" or $type == "other"){
			$downLoadUrl = config('webconfig.pc_url')."apk/puivip-$version.apk";
		}elseif($type == "ios"){
			$downLoadUrl="";
		}
		$this->assign("downLoadUrl",$downLoadUrl);


		return $this->fetch();
	}
}