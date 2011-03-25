<?
//вывод текста
include("inc/decode.php");
function msg($msg,$title="- оплата -",$href="0",$time_v=2) {
//	header("Content-type:text/vnd.wap.wml;charset=utf-8");
	header("Content-type:text/vnd.wap.wml");
	echo "<?xml version=\"1.0\"?>";
	echo "\n<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\" \"http://www.wapforum.org/DTD/wml_1.1.xml\">";
	$wml = "\n<wml>";
	$wml.="\n<head>\n <meta forua=\"true\" http-equiv=\"Cache-Control\" content=\"must-revalidate\"/>\n <meta forua=\"true\" http-equiv=\"Cache-Control\" content=\"no-cache\"/>\n <meta forua=\"true\" http-equiv=\"Cache-Control\" content=\"no-store\"/>\n</head>";
	$wml.= "\n<card id=\"m\" title=\"$title\"";
	$time_v = $time_v*10;
	if ( $href=="<back>" ) $wml.= "><onevent type=\"ontimer\"><prev/></onevent>\n<timer value=\"$time_v\"/";
	else if ( $href!="0" ) $wml.= " ontimer=\"$href\">\n<timer value=\"$time_v\"/";
	$wml.= ">";
	if ( substr($msg,strlen($msg)-4)!="</p>" ) $msg.="\n</p>";
	if ( substr($msg,0,2)!="<p" && substr($msg,0,3)!="<do" && substr($msg,0,4)!="<one" ) $msg="<p>\n".$msg;
	$wml.= "\n".$msg."\n</card>";
	$wml.= "\n</wml>";
	$wml = str_replace("&amp;","&",$wml);
	$wml = str_replace("&#","!t_mp!",$wml);
	$wml = str_replace("&nbsp;","!t_mp1!",$wml);
	$wml = str_replace("&gt;","!t_mp2!",$wml);
	$wml = str_replace("&","&amp;",$wml);
	$wml = str_replace("!t_mp2!","&gt;",$wml);
	$wml = str_replace("!t_mp1!","&nbsp;",$wml);
	$wml = str_replace("!t_mp!","&#",$wml);
	$wml = str_replace("<copy>","&#169;",$wml);
	$wml = str_replace("<br/>","<br/>\n",$wml);
	die(toutf($wml));
}
?>