<?php
$Versiondbs=2;
$dbsfile="../bin/dbs$Versiondbs.php";
$DoThis="INIT,DB";require $dbsfile;
// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-synch';
$DEBUG=0;
####################
#$sandbox="sandbox";#
$sandbox="";
####################
$pp_hostname = "www.".($sandbox=="sandbox"?"sandbox.":"")."paypal.com";
$tx_token = $_GET['tx'];
if(!ISSET($tx_token)){
	 http_response_code(404);
	 exit;
}
$date=date('Y-m-d');
#$auth_token = "yx6hyp51LI5jB7AF06gR6ZuK7dd7kunBh-Ec8te6Nf0EbjZivTReahmipLC";#SANDBOX AUTH
$auth_token = "1SM7jE45T3NPLl96W3HqZE0Y-dt2kxLjWAMUJqracP5lOyr05PQ4Ru-YeHi";#REAL AUTH
$req .= "&tx=$tx_token&at=$auth_token";
$lg='en';
global $itemtype,$itemcost,$buyer_email,$transac_time,$userlink;
$style=<<<STYLESTR
<style>
.pp-details{
	border:1px solid black;
	margin:10px;
	padding:10px;
	display:inline-block;
	text-align:left;
}
.pp-details ul{
	list-style:none;
	padding:0;
}
</style>
STYLESTR;
$header=<<<EEOOLL
<div style="position:absolute;right:46px;width:12%;height:26px;vertical-align:top;line-height:26px;color:#5b7ab1;font-size:14px;padding-top:0;padding-bottom:0;margin-top:0;margin-bottom:0;">
	<span style="font-size:18px;font-weight:bold;letter-spacing:+0.5em;color:#7BABE2;padding-left:0px;padding-right:8px">Selectim
		<span style="padding-left:0px;letter-spacing:0px;font-size:14px;font-weight:normal;color:#7BABE2;">
			<br>
			<a href="mailto:jrocheman@gmail.com" style="font-size:14px;color:#7BABE2;">jrocheman@gmail.com</a>
			<br>+33972424600<br>&nbsp;
		</span>
	</span>
</div>
EEOOLL;
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://$pp_hostname/cgi-bin/webscr");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
//set cacert.pem verisign certificate path in curl using 'CURLOPT_CAINFO' field here,
//if your server does not bundled with default verisign certificates.
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: $pp_hostname"));
$res = curl_exec($ch);
curl_close($ch);
if(!$res){
	//HTTP ERROR
	echo ("HTTP ERROR");
}else{
	 // parse the data
	$resb=urldecode($res);
	#if(preg_match('`charset=([^\s]*)\s`',$resb,$Ag)){
	#	$resc=mb_convert_encoding($resb,"ISO-8859-15",$Ag[1]);	
	#}
	#$lines = explode("\n", $resc);
	$lines = explode("\n", $resb);
	$A = array();
	if (strcmp ($lines[0], "SUCCESS") == 0) {
		for ($i=1; $i<count($lines);$i++){
			list($key,$val) = explode("=", $lines[$i]);
			$A[$key] = $val;
		}
		$paid_amount=	(!empty($A['mc_gross'])?$A['mc_gross']:
				(!empty($A['gross'])?$A['gross']:
				(!empty($A['Gross'])?$A['Gross']:0)));
		if(ISSET($A['custom'])){
			$custom = explode('-',$A['custom']);
			for($i=0;$i<count($custom);$i++){
				if(preg_match('`lg:([a-z]+)`',$custom[$i],$Ag)){
					$lg=$Ag[1];
				}
				if($custom[$i]=="DEBUG"){
					$DEBUG=1;
				}
				if(preg_match('`SID:([0-9]+)`',$custom[$i],$Ag)){
					$sid=$Ag[1];
					$sq="select sp1,sa,snom,grid,ssup from sup where id=$sid";
					$r = my_query($sq);
					if(is_resource($r) || is_object($r) ){
						$row = mysql_fetch_array($r,MYSQL_ASSOC);
						if(count($row)>0){
							$userlink="?nom=$row[snom]&grp=$row[ssup]&sa=$row[sa]";
						}else{
							echo("user not found");
							exit;
						}
					}
				}
			}
			$new_pid=false;
			my_query("insert commfix set sid=$sid ,txn=\"".@$A['txn_id']."\",lst=NOW(),fst=NOW(),prx=\"$paid_amount\",art=1 ,status=".($x=(@$A['payment_status']=='Completed'?3:(@$A['payment_status']=='Pending'?2:0)))." ,nf=0 "
			."ON DUPLICATE KEY UPDATE pid=pid,lst=NOW(),prx=\"$paid_amount\",art=1,status=\"$x\"" 
			)&&mysql_affected_rows($dblink)&&($new_pid=mysql_insert_id($dblink));
			
			@my_query("insert ignore commsav set pid=\N,psid=$sid,txn_id=\"".@$A['txn_id']."\"
				,fst=now(),lst=now(),info=\"".preg_replace('`"`','`',print_r($A,true))."\"
				,payment_status=\"".@$A['payment_status']."\""
			);
# ON DUPLICATE UPDATE
		}
		if(@$A['payment_status']=='Completed'||@$A['payment_status']=='Pending'){
		$title='<h3>Merci pour votre achat</h3>';
		$lg=='en'&&$title='<h3>Thank you for your purchase</h3>';
		$lg=='pt'&&$title='<h3>Obrigado por sua compra</h3>';
		
		$itemtext='Article';
		$lg=='en'&&$itemtext='Item';
		$lg=='pt'&&$itemtext='Item';
		$item_pp=@$A['item_name'];
		$itemtype="<li>$itemtext: $item_pp</li>";
		
		$cost=@$A['mc_gross'];
		$currencytext='$';
		if(@$A['mc_currency']=='EUR'){
			$currencytext='&euro;';
		}
		$costtext='Payé';
		$lg=='en'&&$costtext='Paid';
		$lg=='pt'&&$costtext='Pago';
		$itemcost="<li>$costtext: $currencytext$cost</li>";
		
		$show_email=@$A['payer_email'];
		$payer_email="<li>Email: $show_email</li>";
		
		$timetext='Date';
		$lg=='pt'&&$timetext='a data';
		$pptime=@$A['payment_date'];
		$transac_time="<li>$timetext: $pptime</li>";
	}else if(@$A['payment_status']=="Denied"||@$A['payment_status']=="Expired"||@$A['payment_status']=="Failed"||@$A['payment_status']=="Reversed"||@$A['payment_status']=="Voided"){
		#####
		$details=<<<EEOOSS
		<div class="pp-details">
		Il y a eu un problème avec votre transaction. Vous pouvez essayer à nouveau ou contacter Paypal.
		</div>
EEOOSS;
	}
	$returnlink="<div><a href=\"https://selectim.com/$userlink\">Return to Selectim</a></div>";
		$details=<<<BIENSTR
		<div class="pp-details">
			<ul>
				$itemtype
				$itemcost
				$payer_email
				$transac_time
			</ul>
		</div>
BIENSTR;
	}else if (strcmp ($lines[0], "FAIL") == 0) {
		// log for manual investigation
		echo ("fail");
	}
}
echo($style);
echo($header);
echo('<div style="text-align:center">');
echo($title);
echo($details);
echo($returnlink);
echo('</div>');
exit;
?>
