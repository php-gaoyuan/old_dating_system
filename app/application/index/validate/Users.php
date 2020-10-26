<?php 
namespace app\index\validate;
use think\Validate;
class Users extends Validate{
	protected $rule = [
		"username"=>"require",
		"email"=>"email",
		"pass"=>"require",
		"confirm_pass"=>"require|confirm:pass",
		"user_sex"=>"require",
	];
	protected $message   = [
		"username.require"=>"{%username_no_empty}",
		"email.email"=>"{%error_email}",
		"pass.require"=>"{%error_pass_no_empty}",
		"confirm_pass.require"=>"{%error_conpass_no_empty}",
		"confirm_pass.confirm"=>"{%error_pass2}",
		"user_sex.require"=>"{%error_select_sex}",
	];
	// protected $scene = [
 //        'act_login'  =>  ['username','pass'],
 //    ];
}
