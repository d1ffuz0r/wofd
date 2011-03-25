//<?
function toutf($input)
{
$string=$input;

$string = str_replace(chr(208),'P',$string);        # Ð
$string = str_replace(chr(192),'A',$string);        # À
$string = str_replace(chr(193),'&#x0411;',$string); # Á
$string = str_replace(chr(194),'B',$string);        # Â
$string = str_replace(chr(195),'&#x0413;',$string); # Ã
$string = str_replace(chr(196),'&#x0414;',$string); # Ä
$string = str_replace(chr(197),'E',$string);        # Å
$string = str_replace(chr(168),'E',$string);        # ¨
$string = str_replace(chr(198),'&#x0416;',$string); # Æ
$string = str_replace(chr(199),'3',$string);        # Ç
$string = str_replace(chr(200),'&#x0418;',$string); # È
$string = str_replace(chr(201),'&#x0419;',$string); # É
$string = str_replace(chr(202),'K',$string);        # Ê
$string = str_replace(chr(203),'&#x041B;',$string); # Ë
$string = str_replace(chr(204),'M',$string);        # Ì
$string = str_replace(chr(205),'H',$string);        # Í
$string = str_replace(chr(206),'O',$string);        # Î
$string = str_replace(chr(207),'&#x041F;',$string); # Ï
$string = str_replace(chr(209),'C',$string);        # Ñ
$string = str_replace(chr(210),'T',$string);        # Ò
$string = str_replace(chr(211),'&#x0423;',$string); # Ó
$string = str_replace(chr(212),'&#x0424;',$string); # Ô
$string = str_replace(chr(213),'X',$string);        # Õ
$string = str_replace(chr(214),'&#x0426;',$string); # Ö
$string = str_replace(chr(215),'&#x0427;',$string); # ×
$string = str_replace(chr(216),'&#x0428;',$string); # Ø
$string = str_replace(chr(217),'&#x0429;',$string); # Ù
$string = str_replace(chr(218),'&#x042A;',$string); # Ú
$string = str_replace(chr(219),'&#x042B;',$string); # Û
$string = str_replace(chr(220),'b',$string);        # Ü
$string = str_replace(chr(221),'&#x042D;',$string); # Ý
$string = str_replace(chr(222),'&#x042E;',$string); # Þ
$string = str_replace(chr(223),'&#x042F;',$string); # ß
$string = str_replace(chr(224),'a',$string);        # à
$string = str_replace(chr(225),'&#x0431;',$string); # á
$string = str_replace(chr(226),'&#x0432;',$string); # â
$string = str_replace(chr(227),'&#x0433;',$string); # ã
$string = str_replace(chr(228),'&#x0434;',$string); # ä
$string = str_replace(chr(229),'e',$string);        # å
$string = str_replace(chr(184),'e',$string);        # ¸
$string = str_replace(chr(230),'&#x0436;',$string); # æ
$string = str_replace(chr(231),'&#x0437;',$string); # ç
$string = str_replace(chr(232),'&#x0438;',$string); # è
$string = str_replace(chr(233),'&#x0439;',$string); # é
$string = str_replace(chr(234),'k',$string);        # ê
$string = str_replace(chr(235),'&#x043B;',$string); # ë
$string = str_replace(chr(236),'&#x043C;',$string); # ì
$string = str_replace(chr(237),'&#x043D;',$string); # í
$string = str_replace(chr(238),'o',$string);        # î
$string = str_replace(chr(239),'&#x043F;',$string); # ï
$string = str_replace(chr(240),'p',$string);        # ð
$string = str_replace(chr(241),'c',$string);        # ñ
$string = str_replace(chr(242),'&#x0442;',$string); # ò
$string = str_replace(chr(243),'y',$string);        # ó
$string = str_replace(chr(244),'&#x0444;',$string); # ô
$string = str_replace(chr(245),'x',$string);        # õ
$string = str_replace(chr(246),'&#x0446;',$string); # ö
$string = str_replace(chr(247),'&#x0447;',$string); # ÷
$string = str_replace(chr(248),'&#x0448;',$string); # ø
$string = str_replace(chr(249),'&#x0449;',$string); # ù
$string = str_replace(chr(250),'&#x044A;',$string); # ú
$string = str_replace(chr(251),'&#x044B;',$string); # û
$string = str_replace(chr(252),'&#x044C;',$string); # ü
$string = str_replace(chr(253),'&#x044D;',$string); # ý
$string = str_replace(chr(254),'&#x044E;',$string); # þ
$string = str_replace(chr(255),'&#x044F;',$string); # ÿ
return $string;

}
//?>
