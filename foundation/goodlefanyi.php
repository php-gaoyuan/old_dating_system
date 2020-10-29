<?php
header("Content-Type:text/html; charset=utf-8");
/* Google翻译PHP接口
 * 官成文 2009-03-28
 * 修改时间 2011-11-04
 * 修改人 阿杜
 * http://blog.csdn.net/aprin/
 * 注意：如果翻译文本为UTF-8编码，则要删去mb_convert_encoding函数
 */
class Google_API_translator {
	public $url = "http://translate.google.com/translate_t";
	public $text = "";//翻译文本
	public $out = ""; //翻译输出
	public $from = ""; //源语言
	public $to = ""; //目标语言
	public $Lang = array(
			"中文(繁体)"=>"zh-TW",
			"中文(简体)"=>"zh-CN",
			"阿尔巴尼亚语"=>"sq",
			"阿拉伯语"=>"ar",
			"爱尔兰语"=>"ga",
			"爱沙尼亚语"=>"et",
			"白俄罗斯语"=>"be",
			"保加利亚语"=>"bg",
			"冰岛语"=>"is",
			"波兰语"=>"pl",
			"波斯语"=>"fa",
			"布尔文(南非荷兰语)"=>"af",
			"丹麦语"=>"da",
			"德语"=>"de",
			"俄语"=>"ru",
			"法语"=>"fr",
			"菲律宾语"=>"tl",
			"芬兰语"=>"fi",
			"海地克里奥尔语 ALPHA"=>"ht",
			"韩语"=>"ko",
			"荷兰语"=>"nl",
			"加利西亚语"=>"gl",
			"加泰罗尼亚语"=>"ca",
			"捷克语"=>"cs",
			"克罗地亚语"=>"hr",
			"拉脱维亚语"=>"lv",
			"立陶宛语"=>"lt",
			"罗马尼亚语"=>"ro",
			"马耳他语"=>"mt",
			"马来语"=>"ms",
			"马其顿语"=>"mk",
			"挪威语"=>"no",
			"葡萄牙语"=>"pt",
			"日语"=>"ja",
			"瑞典语"=>"sv",
			"塞尔维亚语"=>"sr",
			"斯洛伐克语"=>"sk",
			"斯洛文尼亚语"=>"sl",
			"斯瓦希里语"=>"sw",
			"泰语"=>"th",
			"土耳其语"=>"tr",
			"威尔士语"=>"cy",
			"乌克兰语"=>"uk",
			"西班牙语"=>"es",
			"希伯来语"=>"iw",
			"希腊语"=>"el",
			"匈牙利语"=>"hu",
			"意大利语"=>"it",
			"意第绪语"=>"yi",
			"印地语"=>"hi",
			"印尼语"=>"id",
			"英语"=>"en",
			"越南语"=>"vi",
			"自动检测"=>"auto",
		);
	function setText($text, $from, $to){
		$this->text = $text;
		$this->from = $from;
		$this->to = $to;
		$this->setLang();
	}
	function translate() {
		$this->out = "";
		$gphtml = $this->postPage($this->url, $this->text, $this->from, $this->to);
		//提取翻译结果
		$str="'";
		preg_match_all('/this.style.backgroundColor='.$str.'#fff'.$str.'">([^<]+)</',$gphtml,$rs);
		$out=implode('',$rs[1]); 
		$this->out = $out;
		return $this->out;
	}

	function postPage($url, $text, $from, $to) {
		$raw ='';
		$fields = array("hl=zh-CN", "langpair=".$from."|".$to."","text=".urlencode($text));
		$fields = implode('&', $fields);
		$url.="?".$fields;
		$ch = curl_init($url);  // 初始化，返回一个handler
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // 设置选项，有返回值
		curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.cn/');  // 设置选项，来源页，这意味着可以伪造referer达到不可告人的目的
		curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; .NET CLR 1.1.4322)');  // 设置选项，浏览器信息
		$raw = curl_exec($ch);  // 执行
		curl_close($ch);  // 关闭handler
		//echo $raw;  // 输出结果
		return $raw;
	}

	/**********************************
	语言代码
	**********************************/
	function setLang()
	{
		if(!in_array($this->from, $this->Lang))
		{
			echo '尚不支持您要翻译的语种！';
			exit();
		}elseif(!in_array($this->to, $this->Lang))
		{
			echo '尚不支持您要翻译的目标语种！';
			exit();
		}
	}
}
?>