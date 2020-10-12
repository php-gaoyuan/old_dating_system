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


    //http://app.pauzzz.com/index/api/do_send_email
    public function do_send_email(){
        $flag = $this->sendMail('meng_a_happy@outlook.com','xgaoyuan1224','我是发件人','347356860@qq.com','我是收件人','pauzzz好友消息','好久没联系，还好吗？请打开<a href="http://www.pauzzz.com" target="_blank">打开网站，聊天吧！</a>');
        if($flag){
            echo "发送邮件成功！";
        }else{
            echo "发送邮件失败！";
        }
    }


    /*发送邮件方法
     *@param $to：接收者 $title：标题 $content：邮件内容
     *@return bool true:发送成功 false:发送失败
     */

    public function sendMail($from_addr,$password,$from_name,$to_addr,$to_name,$title,$content){
        //引入PHPMailer的核心文件 使用require_once包含避免出现PHPMailer类重复定义的警告
        import("phpmailer.PHPMailerAutoload",EXTEND_PATH);
        //实例化PHPMailer核心类
        $mail = new \PHPMailer();

        //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        $mail->SMTPDebug = 0;
        //使用smtp鉴权方式发送邮件
        $mail->isSMTP();
        //smtp需要鉴权 这个必须是true
        $mail->SMTPAuth=true;
        //发件人使用的smtp服务地址
        //$mail->Host = 'ssl://smtp.qq.com:465';
        $mail->Host = 'tls://smtp.office365.com:587';
        $mail->CharSet = 'utf-8';

        //smtp登录的账号 这里填入字符串格式的qq号即可
        $mail->Username = $from_addr;
        //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
        //$mail->Password = 'tlzhztngksxwbgce';
        $mail->Password = $password;//'xgaoyuan1224';



        //发件人地址和姓名
        $mail->setFrom($from_addr, $from_addr);
        //收件人地址和姓名
        $mail->addAddress($to_addr, $to_name);//对方用户名



        //添加发送邮件标题
        $mail->Subject = $title;
        //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
        $mail->isHTML(true); 
        //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
        $mail->Body = $content;

        //为该邮件添加附件 该方法也有两个参数 第一个参数为附件存放的目录（相对目录、或绝对目录均可） 第二参数为在邮件附件中该附件的名称
        // $mail->addAttachment('./d.jpg','mm.jpg');
        //同样该方法可以多次调用 上传多个附件
        // $mail->addAttachment('./Jlib-1.1.0.js','Jlib.js');

        $status = $mail->send();
        //简单的判断与提示信息
        if($status) {
            return true;
        }else{
            return false;
        }
    }
}