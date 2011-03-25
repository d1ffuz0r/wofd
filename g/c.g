<?php
function k2u($string)  {
$string = ereg_replace("А","&#x0410;",$string);
$string = ereg_replace("Б","&#x0411;",$string);
$string = ereg_replace("В","&#x0412;",$string);
$string = ereg_replace("Г","&#x0413;",$string);
$string = ereg_replace("Д","&#x0414;",$string);
$string = ereg_replace("Е","&#x0415;",$string);
$string = ereg_replace("Ё","&#x0415;",$string);
$string = ereg_replace("Ж","&#x0417;",$string);
$string = ereg_replace("З","&#x0417;",$string);
$string = ereg_replace("И","&#x0418;",$string);
$string = ereg_replace("Й","&#x0418;",$string);
$string = ereg_replace("К","&#x041A;",$string);
$string = ereg_replace("Л","&#x041B;",$string);
$string = ereg_replace("М","&#x041C;",$string);
$string = ereg_replace("Н","&#x041D;",$string);
$string = ereg_replace("О","&#x041E;",$string);
$string = ereg_replace("П","&#x041F;",$string);
$string = ereg_replace("Р","&#x0420;",$string);
$string = ereg_replace("С","&#x0421;",$string);
$string = ereg_replace("Т","&#x0422;",$string);
$string = ereg_replace("У","&#x0423;",$string);
$string = ereg_replace("Ф","&#x0424;",$string);
$string = ereg_replace("Х","&#x0425;",$string);
$string = ereg_replace("Ц","&#x0426;",$string);
$string = ereg_replace("Ч","&#x0427;",$string);
$string = ereg_replace("Ш","&#x0428;",$string);
$string = ereg_replace("Щ","&#x0449;",$string);
$string = ereg_replace("Ь","&#x042C;",$string);
$string = ereg_replace("Ы","&#x044B;",$string);
$string = ereg_replace("Ъ","'",$string);
$string = ereg_replace("Э","&#x042D;",$string);
$string = ereg_replace("Ю","&#x042e;",$string);
$string = ereg_replace("Я","&#x042f;",$string);
$string = ereg_replace("а","&#x0430;",$string);
$string = ereg_replace("б","&#x0431;",$string);
$string = ereg_replace("в","&#x0432;",$string);
$string = ereg_replace("г","&#x0433;",$string);
$string = ereg_replace("д","&#x0434;",$string);
$string = ereg_replace("е","&#x0435;",$string);
$string = ereg_replace("ё","&#x0435;",$string);
$string = ereg_replace("ж","&#x0436;",$string);
$string = ereg_replace("з","&#x0437;",$string);
$string = ereg_replace("и","&#x0438;",$string);
$string = ereg_replace("й","&#x0439;",$string);
$string = ereg_replace("к","&#x043A;",$string);
$string = ereg_replace("л","&#x043B;",$string);
$string = ereg_replace("м","&#x043C;",$string);
$string = ereg_replace("н","&#x043D;",$string);
$string = ereg_replace("о","&#x043E;",$string);
$string = ereg_replace("п","&#x043F;",$string);
$string = ereg_replace("р","&#x0440;",$string);
$string = ereg_replace("с","&#x0441;",$string);
$string = ereg_replace("т","&#x0442;",$string);
$string = ereg_replace("у","&#x0443;",$string);
$string = ereg_replace("ф","&#x0424;",$string);
$string = ereg_replace("х","&#x0445;",$string);
$string = ereg_replace("ц","&#x0446;",$string);
$string = ereg_replace("ч","&#x0447;",$string);
$string = ereg_replace("ш","&#x0448;",$string);
$string = ereg_replace("щ","&#x0449;",$string);
$string = ereg_replace("ь","&#x044C;",$string);
$string = ereg_replace("ы","&#x044B;",$string);
$string = ereg_replace("ъ","'",$string);
$string = ereg_replace("э","&#x044d;",$string);
$string = ereg_replace("ю","&#x044E;",$string);
$string = ereg_replace("я","&#x044F;",$string);
return $string;
}
// проверка email
       function check_email_addr($email) {
    if (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+'. '@'.'[-!#$%&\'*+\\/0-9=?A-Z^_`a-z{|}~]+\.'.'[-!#$%&\'*+\\./0-9=?A-Z^_`a-z{|}~]+$', $email)) {
        return 1;  }else{ return 0;  } }

        // Функции
   function error($error) {
 print " <card id=\"error\" title=\"MAIL\">
         <p>$error
         </p>
       </card></wml>\n";
                   exit;
         }
//Конфигурация скрипта
 //Режим работы:
 //1- работает как "Обратная связь" с администратором сайта
 $mode = '1';
   // Если утановлен режим обратной связи ( $mode = 1):
      //Адрес Email администратора
        $admin_email=k2u("gladk0w@mail.ru");
      // Заголовок страницы
        $title_fb=k2u("Написать админу");
      //Тема сообщения
        $add_topic=k2u("From my World of Death:");
      // Сообщения посетителю:
        $your_email=k2u("Ваш Email");
        $your_topic=k2u("Тема сообщения");
        $message=k2u("Текст сообщения");
// Поддерживает ли сервер функцию iconv (конвертация юникода в кириллицу).
//Если при отправке сообщения сообщается об ошибке, то поменяйте на "no"
$support_icov = 'no';

// Системные сообщения
$main=k2u("На главную");
$back=k2u("Назад");
$home='wap.domen.ru';
$own_error=k2u("Сервис недоступен. Пожалуйста, сообщите администратору: gladk0w@mail.ru <br/> <a href=$home>$main</a>");
$send=k2u("Отправить");
$no_body=k2u("Сообщение отсутствует! <br/> <do type=\"prev\" lable=\"$back\"> <prev/></do>");
$no_email=k2u("Отсутствует Email! <br/> <do type=\"prev\" lable=\"$back\"> <prev/></do>");
$fuck_email=k2u("Email неверен!<br/> <do type=\"prev\" lable=\"$back\"> <prev/></do>");
$good=k2u("Сообщение успешно отправлено! <br/> <a href=\"$home\">$main</a>");





//Начало WML-страницы
Header("Content-type: text/vnd.wap.wml");
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
print "<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.1//EN\"\n";
print "\"http://www.wapforum.org/DTD/wml_1.1.xml\">\n";
print "<wml>\n";
// Если не указан режим работы скрипта
   if(!@$mode) {
        error($own_error);
               }

// Если форма отправлена
if(isset($go)) {
  // Действия при режиме "Обратной связи"
  if($mode == '1') {
    // Если не указан Email
    if(!@$from)$from='no@email.ru';
    // Если не указана тема сообщения
    if(!@$topic)$topic='no topic';
    // Если отсутствует текст сообщения
    if(!@$body) { error($no_body); }

$subject=$add_topic.$topic;
$message=$body;
 // Перекодировка Юникод->1251
$subject = iconv("UTF-8", "CP1251", "$subject");
$message = iconv("UTF-8", "CP1251", "$message");

mail($admin_email, $subject, $message, "From: $from");
error($good);

          }
  // Действия при режиме "Отправка Email"
  if($mode == '2') {
     // Если не указан Email
    if(!@$to) { error($no_email); }
    // Если Email ошибочен
    if (check_email_addr($email) == 1) {
          error($fuck_email);
            }
    // Если не указана тема сообщения
    if(!@$topic)$topic='no topic';
    // Если отсутствует текст сообщения
    if(!@$body) { error($no_body); }

$subject=$topic;
$message=$body;
$message .=$adding;

 // Перекодировка Юникод->1251
$subject = iconv("UTF-8", "CP1251", "$subject");
$message = iconv("UTF-8", "CP1251", "$message");

mail($to, $subject, $message, "From: WAP");
Unset($go);
error($good);
          }
        }
// Если указан режим "Обратная связь" ($mode = 1)
   if($mode == '1')  {
print "<card id=\"feedback\" title=\"$title_fb\">
              <p>
      $your_email:<br/>
      <input type=\"text\" name=\"from\"/><br/>
      $your_topic:<br/>
      <input type=\"text\" name=\"topic\"/><br/>
      $message:<br/>
      <input type=\"text\" name=\"body\"/><br/>
      </p><do type=\"accept\" label=\"$send\">
            <go href=\"c.g\" accept-charset=\"UTF-8\" method=\"post\">
                <postfield name=\"from\" value=\"$(from)\"/>
                <postfield name=\"topic\" value=\"$(topic)\"/>
                <postfield name=\"body\" value=\"$(body)\"/>
                <postfield name=\"go\" value=\"go\"/>
            </go>
        </do>
         </card></wml>\n";
 exit;
           }
?>
