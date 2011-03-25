//<?
$version = 0.85;
if ($PHP_SELF=='') $PHP_SELF = $_SERVER["PHP_SELF"];			// путь к текущему файлу
$tmp=$QUERY_STRING;if($tmp=='') $tmp=$_SERVER["QUERY_STRING"];	// в зависимости от настроек сервера
parse_str($tmp);

$admin = "user.dr_d00m";								// логин админа, пароль задайте при регистрации

// настройки по умолчанию
$game_title = "World of Death";						// название игры
$game_file = "game1.dat";							// файл для сохранения игры
$time_logout = 5*60;								// если столько секунд клиент не отвечает, считаем его оффлайн
$time_objects_destroy = 20*60;						// таймаут для валяющиюхся предметов, после кот. они уничтожаются
$time_crim = 30*60;								// время, сколько человек остается криминалом
$time_regenerate = 30;								// время регенерации жизни и маны на единицу (без учета навыков регенерации и медитации)
$points_limit_attr = 24;							// лимит очков на str.dex.int
$points_limit_attr_one=10;							// максимальное значение str,dex,int
$points_limit_skills=980;							// лимит очков на скиллы
$points_limit_skills_one=10;							// максим. значение одного скилла
$points_levelup = 5;								// коэфф., на который умножается сумма очков аттрибутов и навыков для перехода на след. уровень. При переходе текущий опыт обнуляется и добавляется 1 очко опыта
$time_defspeed = 4;								// по умолчанию перерыв между атаками монстров 4 секунды
$count_show = 10;									// такое кол-во объектов показывать на экране за раз
$page_size = 1500;								// не более стольких символом должна получиться wml
$journal_count=10;									// кол-во записей в журнале
$page_font=1;

######################### F_GILD.DAT

  $x[50]="Игроки в клане";
  $x[51]="Добавить в клан игрока";
  $x[52]="Поменять игроку статус";
  $x[54]="Убрать из клана игрока!";
  $x[55]="Описание клана";
  $x[56]="Сейчас в игре никого нет";
  $x[57]="Логин игрока";
  $x[58]="Должность";
  $x[59]="новичок";
  $x[60]="лейтенант";
  $x[61]="капитан";
  $x[62]="казначей";
  $x[63]="помошник";
  $x[64]="Добавить";
  $x[65]="В вашем клане уже есть такая должность!";
  $x[66]="зам. главы";
  $x[67]="Не найден игрок";
  $x[68]="или он находится оффлайн";
  $x[69]="Игрок уже и так в гильдии!";
  $x[70]="далее";
  $x[71]="Ваша должность в клане теперь теперь";
  $x[72]="Изменил!";
  $x[73]="Сообщение";
  $x[74]="пока латиницей";
  $x[75]="послать";
  $x[76]="Сообщение от главы клана";
  $x[77]="Отправил";
  $x[78]="Логин пользователя";
  $x[79]="Описание клана";
  $x[80]="Cохранить";
  $x[81]="Сохранили";
  $x[82]="Клан мастер меню";
// обнуляем переменные
$page_main = "";
$page_desc = "";

if (file_exists("flag_update"))  eval(implode('',file("f_update.dat")));

//загружаем переходы по локациям
eval(implode('',file("loc.dat")));

// игнорируем нефатальные ошибки
Error_Reporting(E_ALL & ~E_NOTICE);
function myErrorHandler ($errno, $errstr, $errfile, $errline) {
}
set_error_handler("myErrorHandler");

eval(implode('',file("decode.php")));

if ($login){
	if (substr($login,0,5)!='user.') $login='user.'.$login;
}
else{
	$p='';
	$login='';
	if ( $sid && strpos($sid,',') ){
		$sid_temp=split(',',$sid);
		$login="user.".$sid_temp[0];
		$p=$sid_temp[1];
	}
}

$sid='';
if ($login && $p) $sid=str_replace('user.','',$login).','.$p."&r=".rand(1,99);
$login=str_replace('$','',$login);	// чтобы PHP не принимал за переменные
//remotec($login);

// грузим флаг
$_fnumn = "g.flag";
$_fnumb = fopen($_fnumn,"a+");
flock($_fnumb,2);

function my_time(){
	$t = explode(" ",microtime());
	return ((float)$t[0] + (float)$t[1]);
}
$myt_start = my_time();
if ( file_exists($game_file) ) $game = unserialize(implode('',file($game_file)));
else eval(implode('',file("f_blank.dat")));


if ($site || $tmp=='') eval(implode('',file("f_site.dat"))); // все что касается сайта
if (!$login || !isset($game["players"][$login])) {$site="connect";eval(implode('',file("f_site.dat")));}

$info=split("\|",$game["loc"][$game["players"][$login]][$login]["info"]);
if ($info[0]!=$p) msg("Неправильный пароль<br/><a href=\"$PHP_SELF\">На главную</a><br/>",$game_title,0,'none');


// проверяем на ошибку
if ( !isset($game["loc"]["loc.0"]) || count($game["loc"]["loc.0"])<2 ) eval(implode('',file("f_upgrade.dat")));

$player=&$game["loc"][$game["players"][$login]][$login];
$player["time"]=time();

$ip=(isset($_SERVER['REMOTE_ADDR']))?$_SERVER['REMOTE_ADDR']:0;
$player['ip']=$ip;
$player['browser']=@$HTTP_USER_AGENT;

// НАСТРОЙКИ
if (isset($player["pd"])){
	$pnas=split("\|",$player["pd"]);
	if ( isset($pnas[1]) ) if ( $pnas[1] ) $count_show = $pnas[1];
	if ( isset($pnas[2]) ) if ( $pnas[2] ) $page_size =$pnas[2];
	if ( isset($pnas[3]) ) if ( $pnas[3]==0 ) $page_font = $pnas[3];
	if ( isset($pnas[4]) ) if ( $pnas[4] ) $points_limit_skills = 1000;
	if ( isset($pnas[5]) ) if ( $pnas[5] ) $journal_count = $pnas[5];
}

// искусственный интелект
ai();

// подгружаемые модули
if ($adm) eval(implode('',file("f_admin.dat")));
if ($look) eval(implode('',file("f_look.dat")));
if ($speak) eval(implode('',file("f_speak.dat")));
if ($HTTP_POST_VARS["say"]) eval(implode('',file("f_say.dat")));
if ($msg) eval(implode('',file("f_msg.dat")));
if ($attack) eval(implode('',file("f_attack.dat")));
if ($take) eval(implode('',file("f_take.dat")));
if ($drop) eval(implode('',file("f_drop.dat")));
if ($use) eval(implode('',file("f_use.dat")));		// $use обязательно раньше $list!
if ($list) {
	if ($list=='skill') eval(implode('',file("f_listskill.dat")));
	if ($list=='magic') eval(implode('',file("f_listmagic.dat")));
	if ($list=='inv') eval(implode('',file("f_listinv.dat")));
	if ($list=='all') eval(implode('',file("f_listall.dat")));
	}
if ($go) eval(implode('',file("f_go.dat")));
if ($set) eval(implode('',file("f_set.dat")));
if ($save) eval(implode('',file("f_save.dat")));
if ($new3) eval(implode('',file("f_news.dat")));
if ($map) eval(implode('',file("f_map.dat")));
if ($npass) eval(implode('',file("f_set_npass.dat")));
if ($gild) eval(implode('',file("f_gild.dat")));
if ($serv) eval(implode('',file("f_serv.dat")));
// собственно игра
//linkИгра
$page_main.="<anchor>[меню]<go href=\"#pers\"><setvar name=\"to\" value=\"$(to)\"/></go></anchor>";
// новые сообщения
$count = 0;
if ( isset($player["msg"]) && count($player["msg"]) ) foreach (array_keys($player["msg"]) as $i) if ( $player["msg"][$i] && isset($game["players"][$i]) ) $count++;
if ($count) $page_main.= "<a href=\"$PHP_SELF?sid=$sid&msg=1\">[л/с:$count]</a>";
// MAIN PAGE
if ($count) $page_main.= "\n"; else $page_main.= "";
$page_main.="<br/>".$player["life"]."/".$player["life_max"]." ".$player["mana"]."/".$player["mana_max"];
if ($player["ghost"]) $page_main.= "<br/>Вы призрак";
if ($player["crim"]) $page_main.= "<br/>Вы преступник (".date("i",$player["time_crim"]-time())." мин.)";
// SOUNDS
$stmp="";
$loc=split("\|",$locations[$player["loc"]]);

$zv=array();
for ($i=3;$i<count($loc);$i++) {
	if (substr($loc[$i],0,4)=='loc.') if (count($game["loc"][$loc[$i]])>0) foreach(array_keys($game["loc"][$loc[$i]]) as $j) if ((substr($j,0,5)=='user.') || substr($j,0,4)=='npc.') { if ( !isset( $zv[$loc[$i]] ) ) $zv[ $loc[$i] ]=''; $zv[ $loc[$i] ].="!";}
};
// FIX: тут надо сортировать: нападающие, нпс, игроки, предметы
// Объекты
$stmp="";
$ind=0; $count=0; if(!$start) $start=0;
if ($game["loc"][$player["loc"]]) foreach (array_keys($game["loc"][$player["loc"]]) as $i) if ($i!=$login) {
	if ($ind>=$start && $ind<$start+$count_show) {	//FIX: может +1?
		// определим видимое название предметов и игроков/npc (включая кол-во и статус)
		if (substr($i,0,5)=='item.') {
			$k=split("\|",$game["loc"][$player["loc"]][$i]);
			if (substr($i,0,11)!='item.stand.' && $k[1]>1) $k=$k[0]." (".$k[1].")"; else $k=$k[0];
		}
		else {
			$k=$game["loc"][$player["loc"]][$i]["title"];
			$ktemp='';
			// if (substr($i,0,5)=="user." && $game["loc"][$player["loc"]][$i]["lag"]!="0") $ktemp="[".$game["loc"][$player["loc"]][$i]["lag"]."]";
			if ($game["loc"][$player["loc"]][$i]["lag"]=="1") $ktemp=" [гор]";
			if ($game["loc"][$player["loc"]][$i]["lag"]=="2") $ktemp=" [раз]";
			if (substr($i,0,5)=="user."){
      if ( isset($game["loc"][$player["loc"]][$i]["gild"]) ){
      $user_infos = split("\|",$game["loc"][$player["loc"]][$i]["gild"]);
      $ktemp=" [".$user_infos[1]."]";
				}
			}
      $k.=$ktemp;
			if ($game["loc"][$player["loc"]][$i]["life_max"]>0) $ltmp=round($game["loc"][$player["loc"]][$i]["life"]*100/$game["loc"][$player["loc"]][$i]["life_max"]);
			$st='';
			if ($ltmp<100) $st.=$ltmp."%";
			if ($game["loc"][$player["loc"]][$i]["ghost"]) $st.=" призрак";
			if (substr($i,0,5)=='user.' && $game["loc"][$player["loc"]][$i]["crim"]) $st.=" преступник";
      $att=$game["loc"][$player["loc"]][$i]["attack"];
			if ($att && isset($game["loc"][$player["loc"]][$att]) && !$game["loc"][$player["loc"]][$att]["ghost"] && !$game["loc"][$player["loc"]][$i]["ghost"]) $st.=" атакует ".$game["loc"][$player["loc"]][$att]["title"];
      if ($st) {if ($st{0}==' ') $st=substr($st,1); $k.=" [".$st."]";}
		}
		$stmp.= "\n<br/><anchor>".$k."<go href=\"#menu\"><setvar name=\"to\" value=\"".$i."\"/></go></anchor>";
	}
	$ind++;
}

if ($start) {$stmp.= "\n<br/><a href=\"$PHP_SELF?sid=$sid\">^ </a>";}
if ($start+$count_show<count($game["loc"][$player["loc"]])-1) {if (!$start) $stmp.="\n<br/>"; $stmp.= "<a href=\"$PHP_SELF?sid=$sid&start=".($start+$count_show)."\">+ (".(count($game["loc"][$player["loc"]])-1-$start-$count_show).")</a>";}
$page_main.=$stmp;

// EXITS
$page_main.= "\n<br/>---";
$loc=split("\|",$locations[$player["loc"]]);

for ($i=3;$i<count($loc);$i++) {
	if (substr($loc[$i],0,4)=='loc.') {
		if ( !isset($zv[$loc[$i]]) ) $zv[$loc[$i]]='';
		$zv[$loc[$i]]=substr($zv[$loc[$i]],0,3);
		$page_main.= "\n<br/><a href=\"$PHP_SELF?sid=$sid&go=".$loc[$i]."\">[".$loc[$i-1]."]</a> ".$zv[$loc[$i]]."";
	}
};

if (!strpos($player["loc"],"oc.k.") && !strpos($player["loc"],"oc.L.")) $page_main.="<br/><a href=\"$PHP_SELF?sid=$sid&look=2\">[инфо]</a>";
else $page_main.="<br/><a href=\"$PHP_SELF?sid=$sid&map=1\">[карта]</a>";

if ($login==$admin) $page_main.="<br/>---\n<br/><a href=\"$PHP_SELF?sid=$sid&adm=res\">[res]</a>|<a href=\"$PHP_SELF?sid=$sid&adm=1\">[admin]</a>";
if (ereg("сеньор", $player["gild"]) || ereg("зам. главы", $player["gild"])) {
$page_main.="<br/>---\n<br/><a href=\"$PHP_SELF?sid=$sid&gild=menu\">[Меню клана]</a>";
};
//карта персонаж
$page_main.="</p></card><card id=\"pers\" title=\"Персонаж\"><p>
<a href=\"$PHP_SELF?sid=$sid&list=inv\">[персонаж]</a><br/>
<a href=\"$PHP_SELF?sid=$sid\">[обновить]</a><br/>
<a href=\"$PHP_SELF?sid=$sid&list=magic\">[магия]</a><br/>
<a href=\"$PHP_SELF?sid=$sid&msg=1\">[контакты]</a><br/>
<a href=\"$PHP_SELF?sid=$sid&save=1\">[сохранить]</a><br/>
<a href=\"$PHP_SELF?sid=$sid&serv=1\">[сервис]</a>
";
// карта меню чел
$page_main.="</p></card><card id=\"menu\" title=\"меню\">\n<p>
<a href=\"$PHP_SELF?sid=$sid&speak=$(to)\">[говорить]</a>
<br/><a href=\"$PHP_SELF?sid=$sid&attack=$(to)&apl=4\">[атаковать]</a>
<br/>-<anchor>[прицельно]<go href=\"#at\"><setvar name=\"to\" value=\"$(to)\"/></go></anchor>
<br/><a href=\"$PHP_SELF?sid=$sid&to=$(to)&list=inv\">[предмет]</a>
<br/><a href=\"$PHP_SELF?sid=$sid&take=$(to)\">[взять]</a>
<br/><a href=\"$PHP_SELF?sid=$sid&look=$(to)\">[инфо]</a>";
//карта атаковать
$page_main.="</p></card><card id=\"at\" title=\"атаковать\"><p align=\"center\">
	<a href=\"$PHP_SELF?sid=$sid&attack=$(to)&apl=0\">[случ.]</a>
	<br/><a href=\"$PHP_SELF?sid=$sid&attack=$(to)&apl=1\">[голова]</a>
	<br/><a href=\"$PHP_SELF?sid=$sid&attack=$(to)&apl=2\">[п.рука]</a><a href=\"$PHP_SELF?sid=$sid&attack=$(to)&apl=3\">[л.рука]</a>
	<br/><a href=\"$PHP_SELF?sid=$sid&attack=$(to)&apl=4\">[тело]</a>
	<br/><a href=\"$PHP_SELF?sid=$sid&attack=$(to)&apl=5\">[ноги]</a>";
msg($page_main,$loc[0],1,'main');
// служебные функции
/////////////////////////////////

function mailadmin($text){
  mail("gladk0w@mail.ru","ERROR",$text);
	msg("<p align=\"center\">Неожиданная ошибка<br/><anchor>[назад]<prev/></anchor>","error",0,'none');
}
function savegame(){				// сохранение игры
	global $game,$_fnumb,$game_file,$myt_start,$admin,$login;
	$fnum = fopen($game_file,"w+");
	fputs($fnum,serialize($game));
	fclose($fnum);
	// снимаем блок
}

function getrandname() {			// генерирует случайное имя
	eval(implode('',file("f_getrandname.dat")));
	return $stmp;
	}

function addjournal($to,$msg) {		// добавляет в журнал и следит, чтоб не переполнился
	global $game,$journal_count;
	if (isset($game["players"][$to])) {
		$j=&$game["loc"][$game["players"][$to]][$to]["journal"];
		$j[]=$msg;
		if (count($j)>$journal_count) array_splice($j,count($j)-$journal_count);	// оставляем только n последних записей
		}
	}
function addjournalall($loc,$msg,$no1="",$no2="") {		// добавляет запись всем в журнал, кроме $no1 и $no2
	global $game;
	if ($game["loc"][$loc]) foreach (array_keys($game["loc"][$loc]) as $i) if ($i!=$no1 && $i!=$no2) if (isset($game["players"][$i])) addjournal($i,$msg);
	}

function msg($msg,$title='World of Death',$journal=1,$menu='') {//linkMsg		// вывод текста и выход
	// journal==1, то выведем карту с алертами
	// menu=='', кнопка "В игру" и "Назад"
	// menu=='none', без кнопок
	// menu=='main', основное меню
	global $page_font,$game,$login,$page_size,$page_desc,$page_main,$debug,$PHP_SELF,$sid,$player,$page_size;

	$wml = "\n<wml>";
	$wml.="\n<head>\n<meta forua=\"true\" http-equiv=\"Cache-Control\" content=\"must-revalidate\"/>\n<meta forua=\"true\" http-equiv=\"Cache-Control\" content=\"no-cache\"/>\n<meta forua=\"true\" http-equiv=\"Cache-Control\" content=\"no-store\"/>\n</head>";
	// ЖУРНАЛ
	if ($journal==1 && $player["journal"] && count($player["journal"])>0) {		// FIX: почему-то даже пустой массив имеет count=1
		$page_journal=implode("<br/>",$player["journal"]);
		$wml.= "\n<card title=\"Журнал\">\n<do type=\"accept\" label=\"[дальше]\"><go href=\"#";
		if ($page_desc) $wml.= "desc";else $wml.= "main";
		$wml.= "\"/></do>\n<p>\n".$page_journal."<br/><a href=\"$PHP_SELF?sid=$sid#main\">[в игру]</a>\n</p>\n</card>";
		$player["journal"]=array();
		}

	$sizeok=1; 
	if ($player["look"]==$player["loc"]) {unset($player["look"]);$page_desc=0;}	// FIX: чтобы большое описание не вешало игрока
	if ($page_desc) {
		$player["look"]=$player["loc"];
		eval(implode('',file("f_desc.dat")));
		if (strlen($wml.$msg.$desc[$player["loc"]])>$page_size) $sizeok=0;
		$wml.= "\n<card id=\"desc\" title=\"".$title."\">\n<do type=\"accept\" label=\"[дальше]\"><go href=\"";
		if ($sizeok) $wml.= "#main"; else $wml.= "$PHP_SELF?sid=$sid";
		$wml.= "\"/></do>\n<p>\n".$desc[$player["loc"]]."<br/><a href=\"$PHP_SELF?sid=$sid#main\">[дальше]</a>\n</p>\n</card>";
		}
	if ( $menu!='break' ) savegame();									// чтобы пока выводится клиенту, другие могли играть
	// ОСНОВНОЙ ЭКРАН
	if ($sizeok) {		// только если размер меньше или равен
	$wml.= "\n<card id=\"main\" title=\"".$title."\""; 
	if ($menu=='main') $wml.= " ontimer=\"$PHP_SELF?sid=$sid\"><timer value=\"600\"/";
	$wml.= ">";
  	if ($menu=='') {
		$wml.= "\n<do name=\"o1\" type=\"options\" label=\"[в игру]\"><go href=\"$PHP_SELF?sid=$sid\"/></do>";
		$wml.= "\n<do name=\"a1\" type=\"accept\" label=\"[назад]\"><prev/></do>";
}
	if ($menu=='main') {
		$wml.= "\n<do name=\"o2\" type=\"options\" label=\"[персонаж]\"><go href=\"$PHP_SELF?sid=$sid&list=inv\"/></do>";
		$wml.= "\n<do name=\"o2\" type=\"options\" label=\"[обновить]\"><go href=\"$PHP_SELF?sid=$sid\"/></do>";
		$wml.= "\n<do name=\"o3\" type=\"options\" label=\"[магия]\"><go href=\"$PHP_SELF?sid=$sid&list=magic\"/></do>";
		$wml.= "\n<do name=\"o5\" type=\"options\" label=\"[контакты]\"><go href=\"$PHP_SELF?sid=$sid&msg=1\"/></do>";
		$wml.= "\n<do name=\"xco6\" type=\"options\" label=\"[сохранить]\"><go href=\"$PHP_SELF?sid=$sid&save=1\"/></do>";
		$wml.= "\n<do name=\"xco7\" type=\"options\" label=\"[сервис]\"><go href=\"$PHP_SELF?sid=$sid&serv=1\"/></do>";	
    }  if (substr($msg,strlen($msg)-4)!="</p>") $msg.="\n</p>";
	if ( substr($msg,0,2)!="<p" && substr($msg,0,3)!="<do" && substr($msg,0,4)!="<one" ) $msg = "\n<p>\n".$msg;
	$wml.= "\n".$msg."\n</card>";
	};// if sizeok

	$wml.= "</wml>";
	$wml=str_replace("&amp;","&",$wml);		// чтобы привести к одному виду
	$wml=str_replace("&#","!t_mp!",$wml);
	$wml=str_replace("&","&amp;",$wml);
	$wml=str_replace("!t_mp!","&#",$wml);
	if ($page_font){
		$wml=str_replace("<p>","<p><small>",$wml);
		$wml=str_replace("<p align=\"center\">","<p align=\"center\"><small>",$wml);	
		$wml=str_replace("</p>","</small></p>",$wml);
		$wml=ereg_replace("(<input[[:print:]]*/>)","</small>\\1<small>",$wml);
		$wml=ereg_replace("(<select.*</select>)","</small>\\1<small>",$wml);
	}
	header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0, max-age=86400');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Pragma: no-cache');
	header("Content-type: text/vnd.wap.wml");
	echo "<?xml version=\"1.0\"?>";
	echo "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\" \"http://www.wapforum.org/DTD/wml_1.1.xml\">";
	echo toutf($wml);
	exit;
}

function calcser($s) {return "s:".strlen($s).":\"".$s."\";";}

function savepl($pls,$names){				//сохраняет игроков в save
	if ( isset($pls["info"]) ){
		$file1="save/$names.dat";
		$file2="save1/$names.dat";
		if ( file_exists($file1) ) if ( filesize($file1)!=0 ){
			$data1=implode("",file($file1));
			$f_s3 = fopen ($file2, "w");
			fputs($f_s3,$data1);
			fclose ($f_s3);
		}
		$filesave2 = fopen ($file1, "w");
		$pls["macros"]=array(); //удаляем макросы
		$s=serialize($pls);
		$s=preg_replace('/s:(?:\d+):"(.*?)";/e',"calcser('\\1')",$s);
		fputs($filesave2,$s);
		fclose ($filesave2);
	}
}
function ai() {		// новый AI			//linkAI
	global $game,$locations,$login,$player,$time_logout;
	// проверим список онлайн и поудаляем кого долго не было
	if (time()>$game["lastai"]+60) {
		foreach(array_keys($game["players"]) as $j) if ($j!=$login) { 	// раз в минуту
			if (time()>$game["loc"][$game["players"][$j]][$j]["time"]+$time_logout) {
				if (isset($game["loc"][$game["players"][$j]][$j])) {
					// в оффлайн

					$gtemp=$game["loc"][$game["players"][$j]][$j];
					$gtemp["journal"]=array();
					$gtemp["loc"]=$game["players"][$j];
					savepl($gtemp,$j);
	
					unset($game["loc"][$game["players"][$j]][$j]);
	        if ($info[2]=='f') {addjournalall($game["players"][$j],$gtemp["title"]." исчезла",$j);} else {addjournalall($game["players"][$j],$gtemp["title"]." исчез",$j);}
          unset($game["players"][$j]);

				} else unset($game["players"][$j]);
			}
		}
		$game["lastai"]=time();
	}

	if (!$login || !$player) return;	// это когда только смотрят список онлайн

	// проверяем только текущую и соседние локации
	doai($player["loc"]);
	$ok=array($player["loc"]=>1);	// эту проверили
	$loc=split("\|",$locations[$player["loc"]]);
	for ($i=3;$i<count($loc);$i++) if (substr($loc[$i],0,4)=='loc.') {
		doai($loc[$i]);
		$ok[$loc[$i]]=1;
		$loc1=split("\|",$locations[$loc[$i]]);
		for ($j=3;$j<count($loc1);$j++) if (substr($loc1[$j],0,4)=='loc.') if (!isset($ok[$loc1[$j]])) {doai($loc1[$j]); $ok[$loc1[$j]]=1;}
	}
}

function doai($i) {				// искусственный интеллект, проверяем локацию с именем $i
	global $game,$locations,$time_logout,$time_regenerate,$time_objects_destroy,$time_crim;

	$loc=split("\|",$locations[$i]);

	// таймеры локации
	if (isset($game["loc_del"][$i])) foreach (array_keys($game["loc_del"][$i]) as $j) {
		if (time()>$game["loc_del"][$i][$j]) {	// удаление предмета/npc
			if ($info[2]=='f') {if (substr($j,0,4)=='npc.') addjournalall($i,$game["loc"][$i][$j]["title"]." исчезла");} else {if (substr($j,0,4)=='npc.') addjournalall($i,$game["loc"][$i][$j]["title"]." исчез");}
			unset($game["loc"][$i][$j]);
			unset($game["loc_del"][$i][$j]);
			if (count($game["loc_del"][$i])==0) unset($game["loc_del"][$i]);
			}
		}
	if (isset($game["loc_add"][$i])) foreach (array_keys($game["loc_add"][$i]) as $j) {
		if (time()>$game["loc_add"][$i][$j]["time"]) {	// добавление предмета/npc
			if ($game["loc_add"][$i][$j]["respawn"]) {
				$respawn=split("\|",$game["loc_add"][$i][$j]["respawn"]);
				$game["loc_add"][$i][$j]["time"]=time()+rand($respawn[0],$respawn[1]);
				if ($respawn[2] && $respawn[3] && substr($j,0,5)=='item.') {	// обновим кол-во
					$item=split("\|",$game["loc_add"][$i][$j]["item"]);
					$item[1]=rand($respawn[2],$respawn[3]);
					$game["loc_add"][$i][$j]["item"]=implode("|",$item);
					}
				}
			$game["loc"][$i][$j]=$game["loc_add"][$i][$j]["item"];
			if (substr($j,0,4)=='npc.') {
				addjournalall($i,"Появился ".$game["loc_add"][$i][$j]["item"]["title"]);
				unset($game["loc_add"][$i][$j]);	// npc удаляем, для предметов только обновляем время
				if (count($game["loc_add"][$i])==0) unset($game["loc_add"][$i]); 
				}
			}
		}

	// удалим стражу, если вышло время
	if ($game["loc"][$i]) foreach (array_keys($game["loc"][$i]) as $j) if (substr($j,0,9)=='npc.guard') if (time()>$game["loc"][$i][$j]["delete"]) {unset($game["loc"][$i][$j]); addjournalall($i,$game["loc"][$i][$j]["title"]." исчез");}

	// есть ли лекарь, есть ли гарды, список кримов (монстры и крим игроки) и список игроков
	$crim=array();
	$users=array();
	if ($game["loc"][$i]) foreach (array_keys($game["loc"][$i]) as $j) if (substr($j,0,5)=='user.' || substr($j,0,4)=='npc.') {
		if ($game["loc"][$i][$j]["healer"]) $healer=$game["loc"][$i][$j]["title"];
		if (substr($j,0,9)=='npc.crim.' || $game["loc"][$i][$j]["crim"]) if (!$game["loc"][$i][$j]["ghost"]) $crim[]=$j;	// кримов-призраков не добавляем
		if (substr($j,0,9)=="npc.guard") $guard=1;
		if (substr($j,0,5)=="user." && !$game["loc"][$i][$j]["ghost"]) $users[]=$j;
		}
	// добавляем стражу от 1 до 3 гардов
	if ($loc[1] && count($crim)>0 && !$guard) for ($k=0;$k<rand(1,3);$k++) {	
		srand ((float) microtime() * 10000000);
		$id = "npc.guard.".rand(5,9999);
		$title = getrandname()." [стража]";
		$game["loc"][$i][$id]=array("title"=>$title,"life"=>"1000","life_max"=>"1000","speak"=>"npc.guard","war"=>"100|100|100|2|0|10|20|0|0|10|30|40|алебардой|0||","delete"=>time()+$time_logout);
		//$game["loc_del"][$i][$id]=time()+$time_logout;	// когда удалить стражу
		addjournalall($i,"Появился ".$title);
		}

	// теперь обработаем игроков и npc
	if ($game["loc"][$i]) foreach (array_keys($game["loc"][$i]) as $j) if (isset($game["loc"][$i][$j]) && (substr($j,0,5)=='user.' || substr($j,0,4)=='npc.')) {
		// восстановим жизнь и ману согласно прошедшему времени
		$tm=time()-$game["loc"][$i][$j]["time_regenerate"];
		if ($tm>$time_regenerate && !$game["loc"][$i][$j]["ghost"]) {
			$life=0; $mana=0;
			if (substr($j,0,5)=='user.') {	// проверим скиллы регенерация и медитация
				$skills=split("\|",$game["loc"][$i][$j]["skills"]);
				$life=$skills[16];
				$mana=$skills[5];
				}
			$game["loc"][$i][$j]["life"]+=round($tm/($time_regenerate-$life));
			$game["loc"][$i][$j]["mana"]+=round($tm/($time_regenerate-$mana));
			if ($game["loc"][$i][$j]["life"]>$game["loc"][$i][$j]["life_max"]) $game["loc"][$i][$j]["life"]=$game["loc"][$i][$j]["life_max"];
			if ($game["loc"][$i][$j]["mana"]>$game["loc"][$i][$j]["mana_max"]) $game["loc"][$i][$j]["mana"]=$game["loc"][$i][$j]["mana_max"];
			$game["loc"][$i][$j]["time_regenerate"]=time();
			}

		// игроки
		if (substr($j,0,5)=="user.") {
			// проверим, не прошло ли время крима
			if (time()>$game["loc"][$i][$j]["time_crim"]) {unset($game["loc"][$i][$j]["crim"]); unset($game["loc"][$i][$j]["time_crim"]);}
			// если есть лекарь, то воскресимся...
			if ($game["loc"][$i][$j]["ghost"] && $healer) {addjournalall($i,$healer.": Возвращайся к живым, ".$game["loc"][$i][$j]["title"]."!");ressurect($j);}
			}

		// NPC
		if (substr($j,0,4)=='npc.') {
			$b=0;	// надо ли continue, если ушли в др. локацию
			// первым делом следуем за хозяином
			$owner=$game["loc"][$i][$j]["owner"];
			$follow=$game["loc"][$i][$j]["follow"];
			$guard=$game["loc"][$i][$j]["guard"];
			$attack=$game["loc"][$i][$j]["attack"];
			if ($owner) {
				// хозяин крима тоже крим
				if ($game["loc"][$i][$j]["crim"] && isset($game["loc"][$i][$owner])) docrim($owner);
				// если вышло время служения
				if (time()>$game["loc"][$i][$j]["time_owner"]) {
					addjournal($owner,$game["loc"][$i][$j]["title"]." покинул вас");
					if ($game["loc"][$i][$j]["destroyonfree"]) {addjournalall($i,$game["loc"][$i][$j]["title"]." исчез"); unset($game["loc"][$i][$j]); continue;}	// дальше не обрабатываем его 
						else {unset($game["loc"][$i][$j]["time_owner"]); unset($game["loc"][$i][$j]["owner"]);unset($game["loc"][$i][$j]["follow"]); unset($game["loc"][$i][$j]["guard"]);}
					}
				}
			if ($follow && !isset($game["loc"][$i][$follow])) for ($k=3;$k<count($loc);$k++) if (substr($loc[$k],0,4)=='loc.' && isset($game["loc"][$loc[$k]][$follow])) {
				// нашли в соседней локации $follow, идем туда
				$game["loc"][$loc[$k]][$j] = $game["loc"][$i][$j];
				unset($game["loc"][$i][$j]);
				unset($game["loc"][$k][$j]["attack"]);
				addjournalall($i,$game["loc"][$loc[$k]][$j]["title"]." ушел ".$loc[$k-1]);
				addjournalall($loc[$k],"Пришел ".$game["loc"][$loc[$k]][$j]["title"]);
				$b=1;	// больше не обрабатывать в текущей локации
				break;
				}
			if ($b) continue;		//$j ушел из этой локации

			// пытаемся преследовать (если ни за кем не следуем)
			if ($attack && !$game["loc"][$i][$j]["follow"] && !isset($game["loc"][$i][$attack])) for ($k=3;$k<count($loc);$k++) if (substr($loc[$k],0,4)=='loc.' && isset($game["loc"][$loc[$k]][$attack])) {	// нашли!
				// хорошие не будут преследовать в неохраняему зону, а плохие не сунутся в гард зону, а гарды всегда преследуют!
				$crimj=$game["loc"][$i][$j]["crim"] || substr($j,0,9)=='npc.crim.';

				$loc1=split("\|",$locations[$loc[$k]]);
				$b=0;	
				if (($crimj && !$loc1[1]) || (!$crimj && $loc1[1]) || substr($j,0,9)=="npc.guard") $b=1;	// продолжить погоню
				// проверим скилл игрока skill.hiding, может спрятался (от гардов не действует)
				if (substr($attack,0,5)=='user.' && !substr($j,0,9)=="npc.guard") {
					$skills=split("\|",$game["loc"][$loc[$k]][$attack]["skills"]);
					if (rand(0,100)<=($skills[17]+$skills[1])*5) {$b=0;addjournal($attack,"Вы скрылись от погони!");}
					}

/*mod*/				// if ($b) if ( substr($j,0,4)=="npc." && !isset($game["loc"][$i][$j]["move"]) ) $b=0;

				if ($b) {	// погоня!
					$game["loc"][$loc[$k]][$j] = $game["loc"][$i][$j];
					unset($game["loc"][$i][$j]);
					addjournalall($i,$game["loc"][$loc[$k]][$j]["title"]." ушел ".$loc[$k-1]);
					addjournalall($loc[$k],"Пришел ".$game["loc"][$loc[$k]][$j]["title"]);
					} else unset($game["loc"][$i][$j]["attack"]);
				break;
				}
			if ($b) continue;		//$j ушел из этой локации
			// если атакуемый ушел далеко, уберем атаку
			if ($attack && !$game["loc"][$i][$j]["follow"] && !isset($game["loc"][$i][$attack])) unset($game["loc"][$i][$j]["attack"]);

			// если на того, кого охраняем guard=id кто-то нападает, атакуем его
			if ($guard && isset($game["loc"][$i][$guard])) {
				if ($game["loc"][$i]) foreach (array_keys($game["loc"][$i]) as $k) if ($game["loc"][$i][$k]["attack"]==$guard) {$game["loc"][$i][$j]["attack"]=$k; break;}
				}

			// гарды атакуют кримов, кримы игроков
			if (!$game["loc"][$i][$j]["attack"]) {
				if (substr($j,0,9)=="npc.guard" && count($crim)>0) $game["loc"][$i][$j]["attack"]=$crim[rand(0,count($crim)-1)];
				if (($game["loc"][$i][$j]["crim"] || substr($j,0,9)=='npc.crim.') && count($users)>0) {
					$b=0;
					$attack=$users[rand(0,count($users)-1)];
					if (substr($attack,0,5)=='user.') {$skills=split("\|",$game["loc"][$i][$attack]["skills"]); if (rand(0,100)<=$skills[1]*2) {$b=1;addjournal($attack,"Вы укрылись от атаки ".$game["loc"][$i][$j]["title"]);}}
					if (!$b) $game["loc"][$i][$j]["attack"]=$attack;
					}

      }

			// проверяем случайное движение NPC
			if (!$game["loc"][$i][$j]["attack"] && $game["loc"][$i][$j]["move"]) {
				$move=split("\|",$game["loc"][$i][$j]["move"]);
				$b=0;
				if (time()>$game["loc"][$i][$j]["time_nextmove"]) {	// идем...
					$k=$loc[2+2*rand(0,(count($loc)-2)/2-1)+1];	// случайный выход
					// плохие не идут в гард зону, а хорошие из нее
					$crimj=$game["loc"][$i][$j]["crim"] || substr($j,0,9)=='npc.crim.';
					$loc1=split("\|",$locations[$loc[$k]]);
					if (($crimj && !$loc1[1]) || (!$crimj && $loc1[1])) $b=1;	// идти
					if ($k==$i) $b=0;
					if ($b) {
						// переход
						$game["loc"][$k][$j]=$game["loc"][$i][$j];
						unset($game["loc"][$i][$j]);
						addjournalall($k,"Пришел ".$game["loc"][$k][$j]["title"]);
						$s=$game["loc"][$k][$j]["title"]." ушел ";
						if (array_search($k,$loc)) $s.=$loc[array_search($k,$loc)-1];
						addjournalall($i,$s);
						$game["loc"][$k][$j]["time_nextmove"]=time()+rand($move[1],$move[2]);	// след. ход
						}
					}
				}
			if ($b) continue;		//$j ушел из этой локации
			// проверяем атаку NPC
			if ($game["loc"][$i][$j]["attack"] && $game["loc"][$i][$game["loc"][$i][$j]["attack"]]["ghost"]) unset($game["loc"][$i][$j]["attack"]);
			if ($game["loc"][$i][$j]["attack"]) attack($i,$j,$game["loc"][$i][$j]["attack"]);
			}//npc		
		}//foreach user & npc
	}

function ressurect($to) {
	eval(implode('',file("f_ressurect.dat")));
	}
function docrim($login) {
	eval(implode('',file("f_docrim.dat")));
	}
function calcparam($login) {
	eval(implode('',file("f_calcparam.dat")));
	};

function attack($loc,$fromid,$toid,$magic='',$answer=1) {//linkAttack		// answer=1 - обороняющийся отвечает, 0 -нет
	global $attackf,$apl;
	global $game,$locations,$login,$time_crim,$points_levelup,$time_objects_destroy,$time_logout,$time_defspeed;
	if (!$attackf) $attackf=implode('',file("f_attackf.dat"));
	eval($attackf);
	}

function view($file) {eval(implode('',file("f_view.dat")));}

function tsdecode($s) {
	if ($s!='') {
		$s1=$s;
		$s = str_replace("%D0%81","Ё",$s);
		$s = str_replace("%d0%81","Ё",$s);
		$s = str_replace("%D1%91","ё",$s);
		$s = str_replace("%d1%91","ё",$s);
		for ($i=144;$i<192;$i++) {$stmp = "%D0".urlencode(chr($i)); $s = str_replace(strtoupper($stmp),chr($i+48),$s); $s = str_replace(strtolower($stmp),chr($i+48),$s);}
		for ($i=128;$i<144;$i++) {$stmp = "%D1".urlencode(chr($i)); $s = str_replace(strtoupper($stmp),chr($i+112),$s);$s = str_replace(strtolower($stmp),chr($i+112),$s);}
		$s = urldecode($s);
		}
	return $s;
	}
function get_age($btime){
	$date0 = getdate($btime);
	$date1 = getdate(time());
	$age = $date1["year"] - $date0["year"];
	if ( $date1["mon"]<$date0["mon"] ) return $age-1;
	if ( $date1["mon"]>$date0["mon"] ) return $age;
	// если месяцы равны...
	if ( $date1["mday"]>=$date0["mday"] ) return $age;
	return $age-1;
}

//?>
