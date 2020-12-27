<?php 
namespace app\index\controller;
use think\Controller;
class Update extends Controller{
	protected $appid = "__W2A__app.missinglovelove.com";
	//protected $appid = "HBuilder";
	protected $version="1.0.0";
	protected $appName="missinglovelove-1.0.0";
	public function index(){
		header("Content-type:text/json");
		$oldappid = input("appid");
		$oldversion = input("version");

		$rsp = array("status" => 0, "title"=>"App update", "note"=>"Fix some bugs","url"=>""); //默认返回值，不需要升级
		if (!empty($oldappid) && !empty($oldappid)) {  
		    if ($oldappid === $this->appid) { //校验appid
		        if ($oldversion !== $this->version) { //这里是示例代码，真实业务上，最新版本号及relase notes可以存储在数据库或文件中
		            $rsp["status"] = 1;

					$agent = strtolower($_SERVER['HTTP_USER_AGENT']);
					if(strpos($agent, 'android')){
						$rsp["url"] = request()->domain()."/apk/".$this->appName.".apk"; //应用升级包下载地址
					}elseif(strpos($agent, 'iphone') || strpos($agent, 'ipad')){
						$rsp["url"] = "https://fir.im/8awu";
					}
		        }  
		    }  
		}
		echo json_encode($rsp);
	}


	//http://app.missinglovelove.com/index/update/down.html
	//http://jyo.henangaodu.com/apk/missinglovelove-1.1.5.apk
	public function down(){
		if(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== false){
			$this->redirect("Index/index");exit;
		}

		$this->assign("version",$this->version);
		$size = file_size("../apk/".$this->appName.".apk");
		$this->assign("size",$size);


		$type = get_device_type();
		$downLoadUrl="";
		if($type=="android" or $type == "other"){
			$downLoadUrl = config('webconfig.pc_url')."apk/$this->appName.apk";
		}elseif($type == "ios"){
			$downLoadUrl="";
		}
		$this->assign("downLoadUrl",$downLoadUrl);
		return $this->fetch();
	}


	//获取苹果下载链接
	private function getIosLink(){
		$link = "";
		$token = file_get_contents("http://api.fir.im/apps/5ca5d569959d69487370853e/download_token?api_token=0126f841107cf344387d045ce60f0956");
		$token = json_decode($token,true);
		$link = "itms-services://?action=download-manifest&url=".urlencode("https://download.fir.im/apps/xxx/install?download_token=".$token["download_token"]);
		return $link;
	}
}