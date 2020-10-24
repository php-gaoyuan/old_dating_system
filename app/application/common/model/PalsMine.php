<?php 
namespace app\common\model;
use think\Model;
class PalsMine extends Model{
	// 定义时间戳字段名
    protected $createTime = 'add_time';
    protected $updateTime = 'active_time';
    protected $autoWriteTimestamp = 'datetime';



    //读取好友列表
    public function get_pals($uid){
    	$list = $this->where(["user_id"=>$uid])->select();
    	foreach ($list as $key => &$value) {
    		$value["pals_ico"] = model("Users")->get_user_info(["user_id"=>$value['pals_id']],"user_ico");
    	}
    	return $list;
    }
}