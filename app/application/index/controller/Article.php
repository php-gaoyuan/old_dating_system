<?php 
namespace app\index\controller;
use think\Controller;
class Article extends Controller
{
    public function index($item){
        $lang = cookie("think_var");
        switch($lang){
            case "zh-cn":
                $lang = "zh";
            break;
            case "en-us":
                $lang = "en";
            break;
            case "zh-tw":
                $lang = "fanti";
            break;
            case "jp":
                $lang = "ri";
            break;
            case "kor":
                $lang = "han";
            break;
        }
        switch($item){
            case "about":
                $title = "about us";
            break;
            case "terms":
                $title = "tiaokuan";
            break;
            case "privacy":
                $title = "privacy";
            break;
            case "safe":
                $title = "jysafe";
            break;
            case "help":
                $title = "help center";
            break;
            case "contact":
                $title = "contact us";
            break;
        }
        $this->assign("title",$title);
        $this->assign("item",$item);
        $this->assign("is_h5_plus",is_h5_plus());
        $tpl_name = "article_{$lang}";
        //halt($tpl_name);
        return $this->fetch($tpl_name);
    }
}