<?php 
namespace app\index\controller;
use think\Controller;
class Check extends Controller{
	public function update(){
		$new_version = "1.1";


		$appid = $_GET['appid'];
		$version = $_GET['version'];//客户端版本号
		$rsp = array('status' => 0);//默认返回值，不需要升级
		if (isset($appid) && isset($version)) {
		    if($appid=="__W2A__app.dsrramtcys.com"){//校验appid
		        //这里是示例代码，真实业务上，最新版本号及relase notes可以存储在数据库或文件中
		        if($version !== $new_version){
		            $rsp['status'] = 1;
		            $rsp['title'] = "APP UPDATE";
		            $rsp['note'] = "Repair APP without chat record ；\nAnd other bug;";//release notes，支持换行
		            $rsp['url'] = config('webconfig.pc_url')."apk/dsrramtcys-$new_version.apk";//应用升级包下载地址
		        }
		    }
		}
		return json($rsp);
	}
}