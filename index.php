<?
Error_Reporting(E_ALL & ~E_NOTICE);
header("Content-type:text/vnd.wap.wml;charset=utf-8");
function win2unicode ( $s ) { if ( (ord($s)>=192) & (ord($s)<=255) ) $hexvalue=dechex(ord($s)+848); if ($s=="Ё") $hexvalue="401"; if ($s=="ё") $hexvalue="451"; return("&#x0".$hexvalue.";");} 
function translate($s) {return(preg_replace("/[А-яЁё]/e","win2unicode('\\0')",$s));} 
ob_start("translate");
print "<?xml version=\"1.0\" encoding=\"utf-8\"?><!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.2//EN\" \"http://www.wapforum.org/DTD/wml12.dtd\"><wml><card id=\"index\" title=\"World of Death\"><p align=\"center\"><b>World of Death</b><br/>---<br/>Добро пожаловать!!!<br/>***<br/><a href=\"http://wapi32v.playfon.ru/?d=79804173\">Картинки</a>|<a href=\"http://wapt32v.playfon.ru/?d=79804173\">Реалтоны</a>|<br/><a href=\"http://wapm32v.playfon.ru/?d=79804173\">Полифония</a>|<a href=\"http://wapth32v.playfon.ru/?d=79804173\">Темы</a>|<br/><a href=\"http://wapv32v.playfon.ru/?d=79804173\">Видео</a>|<a href=\"http://wapg32v.playfon.ru/?d=79804173\">Java-игры</a>|<br/><a href=\"http://wap.dating.playfon.ru/?d=79804173\">Знакомства</a>|<br/><a href=\"http://wapb2b.playfon.ru/p/jkatalog.wml?d=79804173\">Бесплатные каталоги</a><br/>***<br/><a href=\"g/\">World of Death</a><br/>---<br/><a href=\"http://wtd.pdwap.org\">Форум</a><br/>---<br/><b><small>site by dr_d00m</small></b></p></card></wml>";
?>
