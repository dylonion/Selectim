<?php
$sandbox="";
#if( @$_COOKIE["CKVARS"]){
#	  $sid=(preg_match('`sid=([^&]*)`',$_COOKIE["CKVARS"],$Ag)?$Ag[1]:"");
#}else{
	$sid=@$_REQUEST['sid'];
#}
$DEBUG=(ISSET($_REQUEST['DEBUG'])?'DEBUG':'');
$passbackinput="<input type=\"hidden\" name=\"custom\" value=\"SID:$sid-lg:fr$DEBUG\">";
$earlybird=<<<eofstr
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="WNWXCJQ8K8VJW">
$passbackinput
<input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal, le réflexe sécurité pour payer en ligne">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
eofstr;
$earlybirdsandbox=<<<eofstr
<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="UUYNN2H7GPLA8">
$passbackinput
<input type="image" src="https://www.paypalobjects.com/fr_FR/FR/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal, le réflexe sécurité pour payer en ligne">
<img alt="" border="0" src="https://www.sandbox.paypal.com/fr_FR/i/scr/pixel.gif" width="1" height="1">
</form>
eofstr;
$oneeuro=<<<eofstr
<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="48N4HMTGQUWV2">
$passbackinput
<input type="image" src="https://www.paypalobjects.com/en_US/FR/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal, le réflexe sécurité pour payer en ligne">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
eofstr;
$button=$earlybirdsandbox;
$btnid=@$_REQUEST['btnid'];
if(!empty($btnid)){
	if($btnid=="earlybird"){
		$button=$earlybird;
	}
	if($btnid=="oneeuro"){
		$button=$oneeuro;
	}
}
$html=<<<BIENSTR
<!DOCTYPE html>
<html lang="">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
</head>
<body>
$button
</body>
</html>
BIENSTR;
print $html;
exit;
?>
