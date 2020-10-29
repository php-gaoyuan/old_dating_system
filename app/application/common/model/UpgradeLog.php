<?php 
namespace app\common\model;
use think\Model;
class UpgradeLog extends Model{
	//升级后改变到期时间
	public function upgrade_change_date($uid,$day,$groups){
		$info = $this->where(["mid"=>$uid])->find();
		if(!empty($info)){
			if($groups==$info['groups']){
				$nowtime=$info['endtime'];
			}else{
				$nowtime=date("Y-m-d");
			}
			//以前的记录失效
			$this->where(["mid"=>$uid])->update(["state"=>1]);
		}else{
			$nowtime=date("Y-m-d");
		}

		
		file_put_contents("upgrade_log.txt", "uid:{$uid};howtime:{$day}\n\n",FILE_APPEND);
		//插入新纪录
		$end=date("Y-m-d",strtotime($nowtime)+$day*24*3600);
		$this->insert([
			"mid"=>$uid,
			"groups"=>$groups,
			"howtime"=>$day,
			"state"=>0,
			"endtime"=>$end,
			"addtime"=>time()
			]);
		//更新用户级别
		return model("Users")->where(['user_id'=>$uid])->update(['user_group'=>$groups]);
	}
}