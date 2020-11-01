<?php
function resizeImage($im,$maxwidth,$maxheight,$name,$filetype)
{
    $pic_width = imagesx($im);
    $pic_height = imagesy($im);
	$ratiow="";$ratioh="";

    if(($maxwidth && $pic_width != $maxwidth) || ($maxheight && $pic_height != $maxheight))
    {
        if($maxwidth && $pic_width!=$maxwidth)
        {
            $widthratio = $maxwidth/$pic_width;
            $resizewidth_tag = true;
        }

        if($maxheight && $pic_height!=$maxheight)
        {
            $heightratio = $maxheight/$pic_height;
            $resizeheight_tag = true;
        }

        if($resizewidth_tag && $resizeheight_tag)
        {
			$ratiow = $widthratio;
			$ratioh = $heightratio;
        }

        if($resizewidth_tag && !$resizeheight_tag)
            $ratiow = $widthratio;
        if($resizeheight_tag && !$resizewidth_tag)
            $ratioh = $heightratio;
		if(!empty($ratiow))
			$newwidth = $pic_width * $ratiow;
		else
			$newwidth = $pic_width;
		if(!empty($ratioh))
			$newheight = $pic_height * $ratioh;
		else
			$newheight = $pic_height;

        if(function_exists("imagecopyresampled"))
        {
            $newim = imagecreatetruecolor($newwidth,$newheight);
           imagecopyresampled($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
        }
        else
        {
            $newim = imagecreate($newwidth,$newheight);
           imagecopyresized($newim,$im,0,0,0,0,$newwidth,$newheight,$pic_width,$pic_height);
        }

        $name = $name.$filetype;
        imagejpeg($newim,$name);
        imagedestroy($newim);
    }
    else
    {
        $name = $name.$filetype;
        imagejpeg($im,$name);
    }           
}

function cnsubstr($str,$len)
{
	$tmpstr[] = array();
	$start = 0;
	
	$len = $len * 3;
	
	if ($start < 0 || ($start > strlen($str)))
	{
		return '';
	}

	$strlen = $start + $len - 3;
	for ($i = $start; $i < $strlen; $i++)
	{
		if (ord($str[$i]) > 0x80)
		{
			$tmpstr[]= $str[$i] . $str[++ $i] . $str[++ $i];
		}
		else
		{
			$tmpstr[]= $str[$i];
		}
	}
	$str=array();
	foreach($tmpstr as $tmp)
	{
		if(!empty($tmp))
		{
			if($tmp!="")
				$str[]=$tmp;
		}
	}

	return $str;
}
?>