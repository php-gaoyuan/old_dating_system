<?php 
namespace app\index\controller;
use think\Controller;
use think\Db;
class Tr extends Controller{
	public function index(){
		$data = [
	//公共变量
		//语言
		"zh-cn"=>"简体中文",
		"zh-tw"=>"繁体中文",
		"en-us"=>"英文",
		"kor"=>"韩文",
		"jp"=>"日文",

		//性别
		"male"=>"男",
		"female"=>"女",

		//年月日
		"year"=>"年",
		"month"=>"月",
		"day"=>"日",
		"month2"=>"个月",

		//底部导航
		"footer_nav1"=>"在线",
		"footer_nav2"=>"消息",
		"footer_nav3"=>"动态",
		"footer_nav4"=>"好友",
		"footer_nav5"=>"我",

		//操作部分
		"ok"=>"操作成功",
		"fail"=>"操作失败",
		"submit"=>"提交",

		"yongjiu"=>"永久",
		"need recharge"=>"金币不足，请充值",
		"no friend"=>"好友不存在",
		"friend_name"=>"好友名称",
		"golds"=>"金币",
		"banben"=>"版本",
		"about us"=>"关于我们",
		"help center"=>"帮助中心",
		"tiaokuan"=>"使用条款",
		"jiaoyou"=>"安全交友",
		"gengxin"=>"检查更新",
		"guanwang"=>"官网",
	/*******************************************************/


		

		

		


		//login
		"login_username_placeholder"=>"请输入您的用户名",
		"login_pass_placeholder"=>"请输入密码",
		"login_forget_pass"=>"忘记密码？",
		"login_reg_account"=>"注册账号",
		"login_sub_btn"=>"登录",
		"login_footer"=>"全球最专业的大型翻译社交平台",

		//reg
		"reg_title"=>"用户注册",
		"reg_user_name"=>"用户名",
		"reg_user_name_place"=>"请输入你的用户名",
		"reg_pass"=>"密码",
		"reg_pass_place"=>"请输入密码",
		"reg_email"=>"邮箱",
		"reg_email_place"=>"请输入你的邮箱",
		"reg_confirm_pass"=>"密码",
		"reg_confirm_pass_place"=>"请确认密码",
		"reg_user_sex"=>"性别",
		"reg_user_birthday"=>"生日",
		"reg_xiyi_tip"=>"点击注册表示您已阅读服务条款",
		"reg_sub_btn"=>"免费注册",

		//forget_pass
		"wj_title"=>"找回密码",
		"wj_input_email"=>"输入注册邮箱",

		//main
		"main_title"=>"partyings全球最专业的大型翻译社交平台",
		"main_title2"=>"在线用户",

		//search
		"search_place"=>"搜索好友",

		//upgrade
		"upgrade_title"=>"升级会员",
		"vip_member"=>"VIP会员",
		"vip_yj_member"=>"VIP永久会员",
		"upgrade_sub_btn"=>"点击升级",
		
		"upgrade_desc1"=>"使用全站大部分功能",
		"upgrade_desc2"=>"交友沟通无限制,人工免费翻译,在线等级2倍加速",
		"upgrade_desc3"=>"使用全站所有功能",

		"upgrade_order_title"=>"升级订单",
		"order_info"=>"订单信息",
		"need_golds"=>"应付金额",
		"select_upgrade"=>"选择为谁升级",
		"upgrade_foy_youself"=>"为我自己",
		"upgrade_foy_others"=>"为我的好友",
		"select_pay_type"=>"选择支付方式",
		"upgrade_act_btn"=>"升级",
		"need upgrade"=>"您不是VIP用户不能使用即时聊天，请充值升级",


		//news
		"news_title"=>"消息",

		//mood
		"mood_title"=>"朋友圈",
		"fabiao"=>"发表",

		//home
		"home_title"=>"个人主页",
		"news"=>"信息",
		"mood"=>"心情",
		"photos"=>"相册",
		"nickname"=>"昵称",
		"sex"=>"性别",

		//用户中心
		"user_title"=>"我",
		"vip"=>"VIP",
		"gift"=>"礼物",
		"wallet"=>"钱包",
		"help"=>"帮助和反馈",
		"set"=>"设置",

		//gift shop
		"gift shop"=>"礼物商城",
		"real gift"=>"真实礼物",
		"greet card"=>"电子贺卡",
		"gift detail"=>"礼物详情",
		"gift name"=>"名称",
		"gift price"=>"价格",
		"member price"=>"会员价格",
		"yunfei"=>"运费",
		"free"=>"免费",
		"buy"=>"购买",
		"pay"=>"支付",
		"select_pay"=>"选择为谁支付",
		"zengyan"=>"赠言",


		"balance"=>"金币余额",
		"upgrade"=>"充值",
		"pay_record"=>"支付记录",
		"xiaofei_record"=>"消费记录",

		//set
		"set pass"=>"密码设置",
		"set lang"=>"语言设置",
		"about"=>"关于partyings",
		"clear cache"=>"清除缓存",
		"logout"=>"退出",
		"old pass"=>"原密码",
		"new pass"=>"新密码",
		"new pass2"=>"确定密码",
		"no empty"=>"选项不能为空",

		//recharge
		"recharge"=>"充值",
		"recharge_way"=>"充值方式",
		"select_recharge"=>"选择充值",
		"recharge golds"=>"充值金额(最少$5)",
		"recharge low"=>"最小充值金额$5",



		//error
		"error_user_lock"=>"用户处于锁定状态",
		"error_pass_error"=>"用户名或密码错误",
		"error_username_no_empty"=>"用户名不能为空",
		"error_pass_no_empty"=>"密码不能为空",
		"error_user_cunzai"=>"用户已经存在",
		"error_user_nocunzai"=>"用户不存在",

		"error_email"=>"邮箱格式不正确",
		"error_pass2"=>"两次密码输入不一致",
		"error_select_sex"=>"请选择性别",
		"error_conpass_no_empty"=>"确认密码不能为空",
		"friend name no empty"=>"请输入好友名称",

	];
		require("transapi.php");
		foreach ($data as $key => $value) {
			$tr_txt = translate($value,"auto","cht");
			$tr_txt = $tr_txt["trans_result"][0]["dst"];
			$data2[$key] = $tr_txt;
		}
		file_put_contents("zh-tw.php", "<?php return ".var_export($data2,1).";");
		echo "<pre>";halt($data2);
	}
		

}