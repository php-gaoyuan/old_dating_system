<?php 
namespace app\index\controller;
use think\Controller;
class Api extends Controller{
    public function index(){
        return "ok";
    }
	public function upload_img(){
		$file = request()->file('file');
        if( $file->getInfo()['size'] > 3145728){
            // 上传失败获取错误信息
            return json( ['code' => -2, 'msg' => '文件超过3M', 'data' => ''] );
        }
        // 移动到框架应用根目录/public/uploads/ 目录下
        //exit(ROOT_PATH . 'public' . DS . 'uploads' . DS . "chat");
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads' . DS . "chat");
        if($info){
            $src =  '/public/uploads/chat/'. date('Ymd') . '/' . $info->getFilename();
            return json( ['code' => 0, 'msg' => '', 'data' => ['src' => config("webconfig.pc_url")."app".$src ] ] );
        }else{
            // 上传失败获取错误信息
            return json( ['code' => -1, 'msg' => $file->getError(), 'data' => ''] );
        }
	}

}