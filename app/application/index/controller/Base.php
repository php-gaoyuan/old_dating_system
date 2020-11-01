<?php 
namespace app\index\controller;
use think\Controller;
use think\Db;
class Base extends Controller{
	public $userinfo=[];
	public function _initialize(){
		$no_login = ["Recharge","upload_img"];
		if(!in_array(request()->controller(), $no_login)){
			if(!in_array(request()->action(), $no_login)){
				$user_id=0;
				if(cookie("?user_id")){
					$user_id = cookie("user_id");
				}else{
					$user_id = session("user_id");
				}
				if($user_id<=0){
					$this->redirect("index/index");exit;
				}else{
					$this->userinfo = model("Users")->get_user_info(["user_id"=>$user_id]);
					$userinfo = [
						"user_id"=>$this->userinfo["user_id"],
						"user_name"=>$this->userinfo["user_name"],
						"user_sex"=>$this->userinfo["user_sex"],
						"user_ico"=>$this->userinfo["user_ico"],
						"user_group"=>$this->userinfo["user_group"],
						"golds"=>$this->userinfo["golds"],
					];
					//p($userinfo);
					$this->assign("userinfo", json_encode($userinfo));
				}
			}
				
		}
		$this->assign("is_h5_plus",is_h5_plus());

		$this->get_lang();
		$this->get_log_message();
		$this->insert_online();
		$this->assign("act",strtolower(request()->controller()));
	}

	//插入上线记录
	public function insert_online(){
		$user_id = cookie("user_id");

		$this->userinfo = model("Users")->get_user_info(["user_id"=>$user_id]);
		$data=array(
			"user_id"=>$user_id,
			"user_name"=>$this->userinfo["user_name"],
			"user_sex"=>$this->userinfo["user_sex"],
			"user_ico"=>$this->userinfo["user_ico"],
			"active_time"=>time(),
			"hidden"=>0
			);

		$online_info = db("online")->where(["user_id"=>$user_id])->find();
		if(empty($online_info)){
			db("online")->insert($data);
		}else{
			db("online")->where(['user_id'=>$user_id])->update($data);
		}
	}


	//获取有几条未读消息
	public function get_log_message(){
		$user_id = cookie("user_id");
		$count = db()->table("chat_log")->where(["toid"=>$user_id,"is_read"=>0])->fetchSql(0)->count();
		//halt($count);
		$count = !$count ? 0 : $count;
		$this->assign("log_messages",$count);
	}

	public function get_lang(){
		$lang = cookie("think_var");
        if(empty($lang)){
            $lang = "en-us";
            cookie("think_var","en-us");
        }
        $this->assign("lang",$lang);
	}

	//获取聊天需要的信息
	public function chat_info(){
		$pals_id = input("pals_id");
		$pals_info = model("Users")->where("user_id",$pals_id)->field("user_id,user_name,user_ico")->find();
		$pals_info["user_ico"] = img_path($pals_info["user_ico"]);
		$this->assign("pals_info",$pals_info);
	}




	public function addFriend($uid){
		$self_uid = cookie("user_id");
		//halt($self_uid);
		if($uid == $self_uid){
			return "自己不能添加自己为好友";
		}

		$model = model("PalsMine");

		//检查好友列表里面是否已经有该好友
		$res = $model->where(function($query)use($self_uid,$uid){
			$query->where(["user_id"=>$self_uid,"pals_id"=>$uid]);
		})->whereOr(function($query)use($self_uid,$uid){
			$query->where(["pals_id"=>$self_uid,"user_id"=>$uid]);
		})->fetchSql(0)->find();
		//halt($res);
		if(!empty($res)){
			return "你们已经是好朋友啦";
		}

		//获取好友信息
		$pals_info = model("Users")->field("user_id,user_name,user_sex,user_ico")->find($uid);

		//开始添加好友
		$data=[
			"user_id"=>$self_uid,
			"pals_id"=>$uid,
			"pals_name"=>$pals_info["user_name"],
			"pals_sex"=>$pals_info["user_sex"],
			"pals_ico"=>$pals_info["user_ico"]
		];
		$res = $model->save($data);
		if($res){
			return "添加好友成功";
		}else{
			return "添加好友失败";
		}
		
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