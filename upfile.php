<?php

$savePath = 'uploadfiles/avatar/'.date("Ymd").'/';  //图片存储路径
if (!file_exists($savePath)){make_dir($savePath); } 
$savePicName = time().mt_rand(100,999);  //图片存储名称


$file_src = $savePath.$savePicName."_src.jpg";
$filename162 = $savePath.$savePicName."_162.jpg"; 
$filename48 = $savePath.$savePicName."_48.jpg"; 
$filename20 = $savePath.$savePicName."_20.jpg";    

$src=base64_decode($_POST['pic']);
$pic1=base64_decode($_POST['pic1']);   
$pic2=base64_decode($_POST['pic2']);  
$pic3=base64_decode($_POST['pic3']);  

if($src) {
	file_put_contents($file_src,$src);
}

file_put_contents($filename162,$pic1);
//file_put_contents($filename48,$pic2);
//file_put_contents($filename20,$pic3);

$rs['status'] = 1;
$rs['picUrl'] = $savePath.$savePicName;

print json_encode($rs);

function make_dir($folder)//检查路径
{
    $reval = false;
    if (!file_exists($folder))
    {
        @umask(0);
        preg_match_all('/([^\/]*)\/?/i', $folder, $atmp);
        $base = ($atmp[0][0] == '/') ? '/' : '';
        foreach ($atmp[1] AS $val)
        {
            if ('' != $val)
            {
                $base .= $val;
                if ('..' == $val || '.' == $val)
                {
                    $base .= '/';
                    continue;
                }
            }
            else
            {
                continue;
            }
            $base .= '/';
            if (!file_exists($base))
            {
                if (@mkdir(rtrim($base, '/'), 0777))
                {
                    @chmod($base, 0777);
                    $reval = true;
                }
            }
        }
    }
    else
    {
        $reval = is_dir($folder);
    }
    clearstatcache();
    return $reval;
}
?>
