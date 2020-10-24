<?php 
namespace app\common\model;
use think\Model;
class Gift extends Model{
	protected $table="gift_shop";

	//获取礼物详情 2普通礼物3高级礼物4真实礼物
	public function get_list($type){
		$list = $this->where("typeid",$type)->select();
		foreach ($list as $k => &$vo) {
			$patch = explode("|", $vo["patch"]);
			$vo["patch"] = config("webconfig.pc_url").$patch[0];
			$yuanpatch = explode("|", $vo["yuanpatch"]);
			$vo["yuanpatch"] = config("webconfig.pc_url").$yuanpatch[0];
		}
		return $list;
	}


	public function get_info($id){
		$info = $this->find($id);
		$list = explode("|", $info["yuanpatch"]);
		$imgs = [];
		foreach ($list as $k => $vo) {
			$imgs[] = config("webconfig.pc_url").$vo;
		}
		$info["imgs"] = $imgs;
		$info["desc"] = img_add_url($info["desc"]);
		return $info;
	}
}