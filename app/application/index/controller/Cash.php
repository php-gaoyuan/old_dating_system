<?php 
namespace app\index\controller;
use app\index\controller\Base;
class Cash extends Base
{
	public function index(){
		$lang_name = cookie('think_var');
		$lang=[];
		switch ($lang_name) {
			case 'en-us':
				$lang=[
					'cash_bm'=>'Please feel assured that we will not disclose your financial information',
					'cash_country'=>'Country/Region',
					'cash_cardnum'=>'Card Number',
					'cash_name'=>'Name',
					'cash_money'=>'Amount of cash',
					'sub_title'=>"Submit",
					'cash_cancel'=>'Cancel',
					'tip' => "Tip",
					'tip_success'=>"Dear {name} pauzzz member, congratulations: {money}USB has arrived in your account successfully. Thank you for using pauzzz!",
					'tip_fail'=>"Dear {name} pauzzz member, I am very sorry for your failure to mention {money} gold coins. Thank you for using pauzzz",
				];
				break;
			case 'jp':
				$lang=[
					'cash_bm'=>'あなたの財務資料を漏らさないよう、安心して入力してください。',
					'cash_country'=>'国/地域',
					'cash_cardnum'=>'帳號',
					'cash_name'=>'勘定番号',
					'cash_money'=>'金貨の数を示す',
					'sub_title'=>"現像を確認する",
					'cash_cancel'=>'取り消す',
					'tip' => "ヒント",
					'tip_success'=>"尊敬している {name} L0VELINGA 会員、おめでとうございます。成功提現の{money}USDはすでにあなたの口座に到着して、あなたが L0VELINGA を使用することに感謝します",
					'tip_fail'=>"尊敬する{name} pauzzz会員、申し訳ございませんが{money}金貨に失敗しました！",
				];
				break;
			case 'kor':
				$lang=[
					'cash_bm'=>'안심하고 입력하십시오. 우리는 당신의 재무 자료를 누설하지 않을 것입니다',
					'cash_country'=>'국가 혹은 지역',
					'cash_cardnum'=>'카드',
					'cash_name'=>'성명',
					'cash_money'=>'현금 인출 금화',
					'sub_title'=>"확정하다",
					'cash_cancel'=>'취소',
					'tip' => "제시",
					'tip_success'=>"존경{name}축하합니다：성공으로 현금을 제기하다{money}USD계정 에 이미 도착했습니다，써줘서 고마워요 pauzzz!",
					'tip_fail'=>"존경하는 {name} 회원, 대단히 죄송합니다, 당신이 현금으로 {money} 금전을 제시할 수 없습니다, 감사합니다!",
				];
				break;
			case 'zh-tw':
				$lang=[
					'cash_bm'=>'請放心輸入，我們不會透漏你的財務資料',
					'cash_country'=>'國家/地區',
					'cash_cardnum'=>'帳號',
					'cash_name'=>'姓名',
					'cash_money'=>'提現金幣數量',
					'sub_title'=>"確認提現",
					'cash_cancel'=>"取消",
					'tip' => "提示",
					'tip_success'=>"尊敬的{name}pauzzz會員，恭喜您：成功提現{money}USB已經到達您的帳戶，感謝您使用pauzzz!",
					'tip_fail'=>"尊敬的{name}pauzzz會員，非常抱歉您提現{money}金幣失败，感謝您使用pauzzz！",
				];
				break;
			case 'zh-cn':
				$lang=[
					'cash_bm'=>'请放心输入，我们不会透漏你的财务资料',
					'cash_country'=>'国家或地区',
					'cash_cardnum'=>'卡号',
					'cash_name'=>'姓名',
					'cash_money'=>'提现金币数',
					'sub_title'=>"确认提现",
					'cash_cancel'=>'取消',
					'tip' => "提示",
					'tip_success'=>"尊敬的{name}pauzzz会员，恭喜您：成功提现{money}USB已经到达您的帐户，感谢您使用pauzzz！",
					'tip_fail'=>"尊敬的{name}pauzzz会员，非常抱歉您提现{money}金币失败，感谢您使用pauzzz！",
				];
				break;
		}
		$this->assign("lang",$lang);
		if(request()->isAjax()){
			$data = [
				'nickname'=>$this->userinfo->user_name,
				'country'=>input('city','','trim,htmlspecialchars'),
				'card_num'=>input('card_code','','trim,htmlspecialchars'),
				'name'=>input('name','','trim,htmlspecialchars'),
				'golds'=>input('money',0,'trim,intval'),
				'status'=>0,
				'create_time'=>time()
			];
			$res = db("cash_logs")->insert($data);
			return json(['code'=>0,'msg'=>$lang['tip_fail'],'url'=>'']);
		}
		
		$this->assign("userinfo",$this->userinfo);
		return $this->fetch();
	}
}