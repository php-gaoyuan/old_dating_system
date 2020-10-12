<?php 
//心情动态
namespace app\index\controller;
use app\index\controller\Base;
use think\Db;
class Mood extends Base {
    public function index() {
        if (request()->isAjax()) {
            $data = model("RecentAffair")->get_new_list();
            return json($data);
        } else {
            return $this->fetch();
        }
    }
    //发布心情
    public function add() {
        if (request()->isAjax()) {
            $data = input("post.");
            unset($data["file"]);
            $mood_pic = input("mood_pic");
            $mood_pic = isset($mood_pic) ? $mood_pic : "";
            $uid = cookie("user_id");
            $userinfo = model("users")->field("user_id,user_name,user_sex,user_ico")->find($uid);
            $insert_data = array("user_id" => $userinfo["user_id"], "user_name" => $userinfo["user_name"], "user_ico" => $userinfo["user_ico"], "mood" => $data["mood"], "add_time" => date("Y-m-d H:i:s"), "mood_pic" => $mood_pic);
            $res = db("mood")->insertGetId($insert_data);
            if ($res) {
                //插入动态
                db("recent_affair")->insert(["type_id" => 1, "title" => "Update the mood", "content" => $data["mood"], "user_id" => cookie("user_id"), "user_name" => cookie("user_name"), "user_ico" => cookie("user_ico"), "date_time" => date("Y-m-d H:i:s"), "update_time" => date("Y-m-d H:i:s"), "for_content_id" => $res, "mod_type" => 6]);
                return json(array("code" => 0, "msg" => "success"));
            } else {
                return json(array("code" => 1, "msg" => "fail"));
            }
        } else {
            return $this->fetch();
        }
    }
    public function up_mood_pic() {
        $file = request()->file('file');
        if ($file->getInfo() ['size'] > 3145728000) {
            // 上传失败获取错误信息
            return json(['code' => - 2, 'msg' => '文件超过3M', 'data' => '']);
        }
        $target_path = ROOT_PATH . '../uploadfiles/mood_pic';
        // 移动到框架应用根目录/public/uploads/ 目录下
        //exit(ROOT_PATH . 'public' . DS . 'uploads' . DS . "chat");
        $info = $file->move($target_path);
        if ($info) {
            $src = "uploadfiles/mood_pic/" . date('Ymd') . '/' . $info->getFilename();
            return json(['code' => 0, 'msg' => '', 'data' => ['src' => config("webconfig.pc_url") . $src, '_src' => $src]]);
        } else {
            // 上传失败获取错误信息
            return json(['code' => - 1, 'msg' => $file->getError(), 'data' => '']);
        }
    }
}
