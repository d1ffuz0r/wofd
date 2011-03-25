<?
header("Content-Type: text/vnd.wap.wml");
echo"<?xml version=\"1.0\"?>"; ?>
<!DOCTYPE wml PUBLIC "-//WAPFORUM//DTD WML 1.1//EN"
			"http://www.wapforum.org/DTD/wml_1.1.xml">
<wml>			
<?
$wap_title="You Site Name"; // Your Sites Name
$to = "you@yoursite.com"; // Your Email Address
if ($pass == "")
{
    $title="Contact $wap_title";
	}
else 
{    
    $title="Thank You";
	$msg .= "From:\n$name\n$email\n\nMessage:\n$message\n";
    $subject = "WAP Enquiry\n";
    $mailheaders = "From: $name<$email> \n";
    $mailheaders .= "Reply-To: $name<$email>\n\n";
    mail($to, $subject, $msg, $mailheaders);	
	print("<card id=\"thanks\" title= \"$title\" >");
	print("<p align=\"center\">Thank You $name,<br />your Enquiry has been sent to $wap_title</p>");
	print("</card>");  
 }  	
?>
<card id="contact" title="<? echo $title ?>">
<do type="accept" label="send">
<go method="post" href="<? echo "$PHP_SELF"; ?>">
<postfield name="name" value="$name"/>
<postfield name="email" value="$email"/>
<postfield name="message" value="$message"/>
<postfield name="pass" value="1"/>
</go>
</do>
<p>
Name 
<input title="name" name="name"/><br/>
Email
<input title="email" name="email"/><br/>
Message
<input title="message" name="message"/>
</p>
</card>
</wml> 
