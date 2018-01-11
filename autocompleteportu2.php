<?php
$user_error='';
$err_discon="Ooops! Voce esta desconectado - reconecte por favor";
$isodate=date('Y-m-d');
$C_DS=0;
$C_Debug=@$TSid&&@$_GET['debug'];

$sid=$SNOM=$nom=$SCNX='';
$Versiondbs=2;
$z=0;$DBSFILE="../bin/dbs$Versiondbs.php";
if($C_Debug){print @$_SERVER['SCRIPT_FILENAME'].", $DBSFILE<BR>\n";}
###############################################################
$DoThis="INIT";require $DBSFILE;
###############################################################

// contains utility functions mb_stripos_all() and apply_highlight()
//require_once 'local_utils.php';

// prevent direct access
/*$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) AND
strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
if(!$isAjax) {
  $user_error = 'Access denied - not an AJAX request...';
  trigger_error($user_error, E_USER_ERROR);
}*/
 
// get what user typed in autocomplete input
#if(preg_match('`[\xc0-\xc5][\x7f-\xbf]`',@$_GET['term'])){
#  $_GET['term']=preg_replace(
#	Array('`([\xC3\xC2])([\x80-\xBF])`e'
#	#),Array('(("$1"=="\xC2")?"$2":sprintf("%1s",chr(ord("$2")+64)))'),$_GET['term']);
#	),Array('(("$1"=="\xC2")?"$2":chr(ord("$2")+64))'),$_GET['term']);
#}
foreach($_GET as $k => $v) {
	$_GET[$k] = mb_convert_encoding($v,"ISO-8859-15","UTF-8");
}
foreach($_REQUEST as $k => $v) {
	$_REQUEST[$k] = mb_convert_encoding($v,"ISO-8859-15","UTF-8");
}

#$_GET['term']=preg_replace('`&([gl]t);`ie','mb_strtolower(substr("$1",0,1))=="l"?"<":">"',mb_convert_encoding(@$_GET['term'],"ISO-8859-15","UTF-8"));
#$_GET['msg']=preg_replace('`&([gl]t);`ie','mb_strtolower(substr("$1",0,1))=="l"?"<":">"',mb_convert_encoding(@$_GET['msg'],"ISO-8859-15","UTF-8"));
#if(preg_match('`[\xC2-\xC3][\x7F-\xBF]`',@$_GET['term'])){print "ERREURUTF8\n";exit;}
$IsQuote=strpos(' '.@$_GET['term'],'"');
$term=@$_GET['term'];$term=preg_replace('`^[ ]+`','',$term);
if($C_Debug){print "term_iso_urlencoded=".rawurlencode($term)."<BR>\n";}
if($C_Debug){print "term_iso_----------=".$term."<BR>\n";}
#$TERM=mb_convert_encoding(preg_replace(Array('`^[a-z]/`','`[\x22]`'),Array('/',''),@$_GET['term']),"ISO-8859-15","UTF-8");
$TERM=preg_replace(Array('`^[a-z]/`','`[\x22]`'),Array('/',''),@$_GET['term']);
$TERMdeac=preg_replace(Array(
                '`[à-å]`i',
                '`[æ]`i',
                '`[ç]`i',
                '`[ñ]`i',
                '`[è-ë]`i',
                '`[ì-ï]`i',
                '`[ò-ö]`i',
                '`[ù-ü]`i',
                '`[ýÿ]`'
        ),Array(
                'a',
                'ae',
                'c',
                'n',
                'e',
                'i',
                'o',
                'u',
                'y'
        ),$TERM);

$termlower=@mb_strtolower($term,"iso-8859-15");
$cmds = clean_cmds(@$_REQUEST['cmds']);
$R2c="(?i:A[bglmnrvz]|B[aeor]|C[aehioru]|E[lnsv]|F[aeioru]|G[aoru]|H[o]|[IÍ][dl]|L[aeio]|M[aeéiou]|N[aeio]|O[bdeluv]|P[aeior]|R[ei]|S[aãeio]|T[aeor]|V[aeio])";
$Support=!empty($_REQUEST['description'])||!empty($_REQUEST['respond'])||!empty($_REQUEST['supportlist'])||!empty($_REQUEST['unviewed'])||!empty($_REQUEST['viewed'])||!empty($_REQUEST['close'])||!empty($_REQUEST['support']);
$Bookmarks=!empty($_REQUEST['bookmark'])||!empty($_REQUEST['bookmarks']);

###############################################################
if($show&&(
		  $Support||$Bookmarks
		||!empty($_REQUEST['support'])
		||preg_match('`^'.$R2c.'$`',$TERMdeac)
		||preg_match('/^([0-9]{4})(?=[-]|$)(?:[-.]([0-9]{3})$)?/',$TERMdeac,$Agcp)
		||preg_match('/^(?:([0-9]{4})(?=[-]|$)(?:[-.]([0-9]{3})$)?[ ]*)?([a-zA-Zà-ÿÀ-Ü]+(?:-[a-zA-Zà-ÿÀ-Ü]*)*)[ ]*(?:\x28([^\x28\x29]*)\x29?)?$/',$TERMdeac,$Agcp)&&(($Agloc=Array(1,$Agcp[3]=str_replace('-',' ',@$Agcp[3])))||true)
	#&&((!@$Ag[1]&&!@$Ag[2]&&@$Ag[3]&&"ville"==@$_REQUEST['cmdname']&&($term=str_replace('-',' ',$Ag[3])))||true)
		||strlen($TERMdeac)>2 && !preg_match('`[-+\x22]|(^|[^0-9])([0-9]{1,2}|[0-9]{5,})(?=[^0-9]|$)`',$term)
			&& (empty($_REQUEST['cmdname'])||$_REQUEST['cmdname']=="ville")
			&& preg_match('`^([a-zA-Zà-ÿÀ-Ü]{1,}(?![ ]*\x22|[a-zA-Zà-ÿÀ-Ü])([-/.\x27 ]{1,2}[a-zA-Zà-ÿÀ-Ü]+)*)$`',$TERMdeac,$Agloc)
			&& preg_match('`[a-zA-Zà-ÿÀ-Ü]{3}`',$Agloc[1])
	)&&($DoThis="DB"))
{
require $DBSFILE;
if(     (@$mycopycnx2&&@$dblink2||@$mycopycnx3&&@$dblink3||@$mycopycnx4&&@$dblink4)
        &&($fromalert&&getenv('HTTP_HOST')=='127.0.0.1'||($HOST_DB_2||$HOST_DB_3||$HOST_DB_4)&&!@$dblink)
){
        $ECRIT_DB=0;
        $HOST_DB_1=$dblink2?$HOST_DB_2:$HOST_DB_3;
        $HOST_DB_2="---";
        $HOST_DB_3="+++";
        $mycnx1 =@$dblink2?$mycopycnx2:(@$dblink3?$mycopycnx3:$mycopycnx4);
        @$dblink=@$dblink2?$dblink2   :(@$dblink3?   $dblink3:$dblink4   );
        $mycopycnx2=$mycopycnx3=$mycopycnx4='';$dblink2=$dblink3=$dblink4='';
}
}
###############################################################
$a_json = array();
$a_json_row = array();
$a_json_invalid = array(array("id" => "#", "value" => "json_invalid", "label" => "Only letters and digits are permitted..."));
$json_invalid = json_encode($a_json_invalid);

if( @$_COOKIE["CKVARS"]){
	  ($sid=(preg_match('`sid=([^&]*)`',$_COOKIE["CKVARS"],$Ag)?$Ag[1]:""))
	&&($nom=$SNOM=(preg_match('`nom=([^&]*)`',$_COOKIE["CKVARS"],$Ag)?$Ag[1]:""))
	&&($grp=$SSUP=(preg_match('`grp=([^&]*)`',$_COOKIE["CKVARS"],$Ag)?$Ag[1]:""))
	&&($cnx=$SCNX=(preg_match('`cnx=([^&]*)`',$_COOKIE["CKVARS"],$Ag)?$Ag[1]:""));
}
function querysdb($ex){
  global $PAYS,$a_json,$Cnt,$cmds,$HASHcmds,$term,$sid,$nom,$grp,$top,$mel,$tel,$cnx,$isodate,$err_discon,$C_Debug;
  global $STATICSCNX;
  if(!isset($STATICSCNX)){
    $STATICSCNX=1;#sprintf("%08x-%s",crc32($HTTP_USER_AGENT.$HTTP_ACCEPT.$HTTP_ACCEPT_LANGUAGE),$ip);
    if(!($sid&&$nom&&$grp&&$cnx
	&&($sq="select id "
        .",md5(concat(\"$isodate\",MID(s.scnx,1,8),s.ssup,s.snom,s.sa)) as c "
        .",top,sp1 as mel,stelp as tel "
        ." from sup as s "
        ." where id=$sid and "
        .(false||((getenv('HTTP_HOST')=='127.0.0.1')&&($cnx=1))
                ?"1"
                :""
                        ."snom=\"$nom\" and ssup=\"$grp\" and "
                        ."FIND_IN_SET(\"$cnx\","
                        ."concat("
                        ."md5(concat(\"$isodate\",MID(s.scnx,1,8),s.ssup,s.snom,s.sa)),"
                        ."\",\","
                        ."md5(concat(\"$isodate\",MID(s.scnx,1,8),s.ssup,s.snom,md5(concat(s.sp,\",fromenter=1\"))))"
                        .")"
                .")"
        ))
	&&($C_Debug&&(print $sq."<BR>\n")||true)
	&&(($r=my_query($sq))&&is_resource($r)||$C_Debug&&(print "MYSQL:".my_error()."\n")&&false)
                &&($row = mysql_fetch_array($r,MYSQL_ASSOC))
                && is_array($row)
                &&(@$row['id']==$sid)
		&&(($top=@$row['top'])||true)
		&&(($mel=@$row['mel'])||true)
		&&(($tel=@$row['tel'])||true)
    )){
        $I="";#}else{   
        $a_json=Array();
        add_P_R_N_P_C_D("99999","REP","DISCON",$x=$err_discon,"1","<div class=sys14>&nbsp;$x&nbsp;&nbsp;</div>"
        #."<BR>$cnx"
        #."<BR>$nom"
        #."<BR>XXX/".@$row['id']."/"
        );
        finish();
	($C_Debug&&(print "TERMINE ex=$ex<BR>\n")||true);
        exit;
    }
    add_P_R_N_P_C_D("00000","REP","DISCON",$x="conexão ativa","1","<span style=\"text-align: right;color:#373\">$x</span>");
  }

  if(@$_REQUEST['supportlist']){
	($C_Debug&&(print "LISTE SUPPORT ex=$ex<BR>\n")||true);
    if(($rs = my_query($ex))&&is_resource($rs)||$C_Debug&&(print "MYSQL:".my_error()."\n")&&false){
        $AR=Array();$RO=Array();$AL=Array();$rnum=-1;
        while($RO = mysql_fetch_array($rs,MYSQL_ASSOC)){  $AR[++$rnum]=$RO; if($C_Debug){print "SUPPORT n=$rnum<BR>\n";}}
        if(@$_REQUEST['unviewed']){
		$a_json=Array($AR,$AL);
		finish2();exit;
	}

	$ex="select rec,alerte,sel,recnote,rec.tim from rec where nid=$sid";
	($C_Debug&&(print "LISTE ALERTES ex=$ex<BR>\n")||true);
    	if(($rs = my_query($ex))&&is_resource($rs)||$C_Debug&&(print "MYSQL:".my_error()."\n")&&false){
   	    $AL=Array();$RO=Array();$rnum=-1;
    	    while($RO = mysql_fetch_array($rs,MYSQL_ASSOC)){
		if(is_array($RO)&&!empty($RO['sel'])){
                        $RO['sel']=preg_replace(Array('`%([0-9a-f]{2})`ie'
                        ,'`(")?[0-9]+[ ]?(Jo?u?r?s?|mo?i?s?|se?m?a?i?n?e?s?|an?s?|/[0-9]{1,2}(?:-[0-9]{1,2}/[0-9]{1,2})?)[ ]?(?(1)"[ ]*)<=date\b`i'
                        ,'`(\w+<=(\w+)) AND (\2<=\w+)`i'
                        ,'`=<`'
                        ,'`(TERR(AIN)?|PRIX|SURFA?C?E?|(NB ?(DE ?)?)?PIECE?S?) *NULL?E?S?=(OUI|NON)`i'
                        ,'`^([ ]|AND)+|([ ]|AND)*[\x28]([ ]|AND)*[\x29]|( AND)+(?= AND\b|[\x29])|([ ]|AND)+$`'
			,'`(=<)([A-ZÀ-Üà-ÿ][A-ZÀ-Üà-ÿ_0-9]*)\b`i'
                        ),Array('pack("H*","$1")'
                        ,''
                        ,'$1 and $3'
                        ,'='
                        ,''
                        ,''
			,"$1\"$2\""
			),$RO['sel']);
		}
		if(is_array($RO)&&empty($RO['recnote']) || strpos($RO['recnote'],':')===false){
			$RO['recnote']=posttranslate(cmds2PAK(@$RO['sel'],false));
		}
		$AL[++$rnum]=$RO;
		if($C_Debug){print "ex=$ex<BR>\n";}
	    }
	    $a_json=Array($AR,$AL);
	    finish2();exit;
        }else{
            return @$rs;
        }
    }else{
        return @$rs;
    }
    return;
  }
  if($C_Debug&&$term){print "ex=$ex<BR>\nterm=$term<BR>\n\n";}
  if(($rs = my_query($ex))&&(is_resource($rs))){
    
    $AR=Array();$RO=Array();$rnum=-1;
    while($RO = mysql_fetch_array($rs,MYSQL_NUM)){ $AR[++$rnum]=$RO; }
    
    if($rnum==-1){return false;}
    return $AR;
  }else{
    ($rs===false)&&(print "autocomplete ERROR:<BR>\n$ex<BR>\n".my_error()."<BR>\n");
    return @$rs;
  }
}
$Cnt=10000;
function add_P_R_N_P_C_D($pri,  $REP_APP_XCL,   $cmdname,       $PAK,   $cmd,   $dis){
  global $Cnt,$a_json,$C_Debug,$Column_Number,$RowsToMerge;$Cnt--;$Column_Number=10;!isset($RowsToMerge)&&$RowsToMerge=0;
  if(strlen($dis)>4&&!preg_match('`.rea .til|conexão|Desconect|^(?:&nbsp;|[^a-zA-Zà-üÀ-Ü0-9])*$|<b\b[^>]*>[ ]*[A-Za-zà-ü][^:]*:`i',$dis)){
    if(preg_match('`Solo [0-9]{4}\b`i',$dis)){$dis=preg_replace('`^`','<b>Localidade: </b>',$dis);}
    elseif(preg_match('`[0-9]{4}-[0-9]{3}\b`i',$dis)){$dis=preg_replace('`^`','<b>Localização precisa: </b>',$dis);}
    else{$dis=preg_replace('`^`','<b>Condição: </b>',$dis);}
  }
  $dis=preg_replace(Array('`^(?!<tr\b)`i'
                        ,'`(<tr\b[^>]*>)(?!<td\b|[|])|[|]`i' #(
                        ,'`(<td\b|$)`i'                         #)(
                        ,'`(<tr\b[^>]*>)</td>`i'                #^)
                        ,'`(?:(</td>)|<td[^>]*>)(?:</td>)+`i'
                        ,'`(</td>)$`i'
                  ),Array('<tr>'
                        ,'$1<td>'
                        ,'</td>$1'
                        ,'$1'
                        ,'$1'
                        ,'$1</tr>'
                  ),$dis);
  $NbCols=count(preg_split('`</td><td\b`i',$dis));
  $x=Array(
    "pri"               => sprintf("%07u",floor($pri?$pri:429495)).sprintf("%04u",$Cnt),
    "REP_APP_XCL"       => $REP_APP_XCL,
    "cmdname"           => $cmdname,
    "PAK"               => $PAK,
    "cmd"               => $cmd,
    "dis"               => preg_match('`colspan=`i',$dis)
                                ?$dis   
                                :preg_replace('`<td\b([^>]*>(?:(?!<td\b).)*)$`','<td colspan='
                                .($Column_Number+($RowsToMerge&&$RowsToMerge--?0:0)+1-$NbCols#count(preg_split('`</td><td\b`i',$dis))
                                )       
                                .'$1'           
                                ,preg_match('``',$dis)?$dis:preg_replace($dis))
  );
  if(preg_match('`rowspan=[\x22]?([0-9]+)`',$dis,$Ag)){$RowsToMerge+=$Ag[1];}

  array_push($a_json, $x);
}
if(!$SCNX){
   add_P_R_N_P_C_D("99999","REP","DISCON",$x=$err_discon,"1","<p class=sys14>&nbsp;$x&nbsp;&nbsp;</p>");
   finish();
   exit;
}elseif(strlen($term)<3){
   add_P_R_N_P_C_D(preg_match('`^desc`i',$term)?"90000":"00000","REP","DISCON",$x="",'',"&nbsp;$x&nbsp;");
   add_P_R_N_P_C_D(preg_match('`^desc`i',$term)?"90000":"00000","REP","DISCON",$x="Desconectar $nom",'&cnx=&',""
	."<span style=\"text-align: right;color:#933\">"
	#."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
	."$x&nbsp;</span>");
   #add_P_R_N_P_C_D(preg_match('`^desc`i',$term)?"90000":"01000","REP","DISCON",$x="Desconectar $nom",'&cnx=&',"<div class=\"sys18 syh10\" style=\"width=100%;text-align:right\">&nbsp;$x&nbsp;&nbsp;</div>");
}

if(!empty($_GET['bookmark'])){
$BM_name=(empty($_REQUEST['name'])?false:preg_replace('`[\x22]`','',$_REQUEST['name']));
if(!empty($_GET['del'])&&$BM_name){
  $ex="delete from rec where nid=$sid and rec=\"$BM_name\"";
} elseif(isset($_GET['al'])&&$BM_name&&preg_match('`^[0-9]+$`',$_GET['al'])){
  $ex="update rec set alerte=\"".$_GET['al']."\" where nid=$sid and rec=\"$BM_name\"";
} else { print "ERREUR bookmark command not known al=/".print_r($_GET['al'],true)."/<BR>name=/$BM_name/\n";exit;}
  print querysdb($ex);exit;
}
if(!empty($_GET['support'])){
if(!empty($_REQUEST['supportlist'])){

if(preg_match('`^72(9(27|39|41|56)|235)$`',$sid) && @$_REQUEST['unviewed']){
  $ex='select count(*)as nb from sups where not viewed and sid!='.$sid;querysdb("select 0 as a");exit;
}elseif(preg_match('`^45|32|72(9(27|39|41|56)|235)$`',$sid)){
  $ex='select t as msgid,if(tref,tref,t)as ticket,top,if(mel,mel,sp1) as mel,if(tel,tel,stelp) as tel,ver,fst,viewed,cls,urg,sub,msg,url,cmds,ua,ip,id,grid,snom,ssup,sp2p,sp2,sp1,stelp,sp3,stel from sups left join sup on id=sid where not isnull(grid) and grid>1';
}elseif(@$_REQUEST['unviewed']){
  $ex='select count(r.t) as nb from sups as r left join sups as t on t.t=r.tref where r.viewed=0 and t.sid='.$sid.' and not r.sid='.$sid;
}else{
  $ex='select t as msgid,if(tref,tref,t)as ticket,top,if(mel,mel,sp1) as mel,if(tel,tel,stelp) as tel,ver,fst,viewed,cls,urg,sub,msg from sup left join sups on id=sid where id='.$sid;
}
querysdb($ex);exit;
}elseif(!empty($_REQUEST['viewed'])&&!empty($_REQUEST['msgid'])&&!empty($_REQUEST['tref'])){
 $ex='update sups as s,sups as g set s.viewed=now() where g.tref=0 and g.t=s.tref and s.tref='.$_REQUEST['tref'].' and s.t='.$_REQUEST['msgid'].' and g.sid='.@$sid.'';
 $x=querysdb($ex);if($x==='false'||!$x){$x='ERROR '.my_error().". MYSQL:".mysql_error($dblink)."\n";}
 elseif(!mysql_affected_rows($dblink)){$x="ZERO MODIFIED ROWS! ex=".$ex."\n";}
 $C_Debug&&(print "viewed ex=$ex<BR>gives answer x=$x;\n");
 print json_encode(Array("RESULT"=>"".$x));
 exit;
}elseif(isset($_REQUEST['description'])){
#print "_POST = <BR>\n".preg_replace('`(?=\r?\n)`','<BR>',print_r($_POST,true))."<BR><BR>\n\n";
#print "JUST READ a ticket : \"".$_POST['ticket']."\"\n";
#$ticket=json_decode(preg_replace('`[\\]?[";]`','',$_POST['ticket']));
#$ticket=json_decode(@$_POST['ticket']);
#print "JUST READ a ticket : \"".preg_replace('`(?=\r?\n)`','<BR>',print_r($ticket,true))."\"<BR>\n";
#$ticket=Array();
$ex="insert sups set sid=$sid"
.(empty($_REQUEST['tref'])?"":",tref=\"".preg_replace('`[\x22;]`','',@$_REQUEST['tref'])."\"")
.(empty($_REQUEST['close'])?"":",cls=NOW()")
.",mel=\"".preg_replace('`[\x22;]`','',@$_REQUEST['email'])."\""
.",tel=\"".preg_replace('`[\x22;]`','',@$_REQUEST['tel'])."\""
.",ver=\"".$PAYS."\""
.",err=\"".preg_replace('`[\x22;]`','',@$_REQUEST['typeof'])."\""
.",urg=\"".preg_replace('`[\x22;]`','',@$_REQUEST['urgency'])."\""
.",sub=\"".preg_replace('`[\x22;]`','',@$_REQUEST['subject'])."\""
.",msg=\"".preg_replace(Array('`\x22`'
	,'`&nbsp;`'
	,'`;`'
	,'`;;,</?(?![abip]|strong|small|table|tr|td|tbody|div|span|li|[uo]l|br)\b[^>]*`i','`\bsrc=[^ >]*`'
	),Array('~'
	,'``'
	,"\xa0"
	,''
	,''),@$_REQUEST['description'])."\""
.",url=\"".preg_replace('`[\x22;]`','',@$_REQUEST['openURL'])."\""
.",cmds=\"".preg_replace('`[\x22;]`','',@$_REQUEST['openCMDS'])."\""
.",ua=\"".preg_replace('`[\x22;]`','',"ua=".getenv("HTTP_USER_AGENT")."|la=".getenv('HTTP_ACCEPT_LANGUAGE')."|ac=".getenv('HTTP_ACCEPT'))."\""
.",ip=\"".preg_replace('`[\x22;]`','',$ip)."\""
;
print "Hi! I read a ticket and built this sql=".preg_replace('`(?=[,\n])`','<BR>',$ex)."\n<br>\n";
print "".querysdb($ex);
}else{
print "I DIDN'T SEE ANY TICKET THERE\n";
}
exit;
}
# ########################## DBS ANALYSE OF CMDS ####################################
$HASHcmds=ParseCmds($cmds);
# ########################## END ANALYSE OF CMDS ####################################

if(@$TSid&&$C_Debug){print preg_replace('`(?=\r?\n)`',"<BR>\n","cmds=$cmds\nListcmds=".print_r($Listcmds,true)."\nHASHcmds=".print_r($HASHcmds,true)."\n");}
#$cmds=preg_replace(Array('`((?:^|\bAND\b)(?:(?!\bAND\b)[^\x22])*?\x22(?:(?![ ]?\bAND\b)[^\x22])*?)([ ]\bAND\b|^)`','`([ ]?\bAND\b)*[ ]?$`'),Array('$1"$2',''),$cmds);
 $cp4s=(preg_match('`ville="(?:(?![0-9]{4}\b)[^\x22])*([0-9]{4}(?:[ ][0-9]{4})*)`',@$HASHcmds['ville'],$Ag)?" AND floor(cp) in(".$Ag[1].")":"");
 $cnal=(preg_match('`ville="([^0-9,<=>]+)"`',@$HASHcmds['ville'],$Ag)?" AND cn in(\"".($CNAL=$Ag[1])."\")":($CNAL=""));
 $cnallower=($cnal?@mb_strtolower($CNAL,"iso-8859-15"):"");
 
// replace multiple spaces with one
$term = preg_replace(Array('/^\s+|\s+$/','/\s+/'),Array('',' '), $term);

#******************************************************************************
#* SECURITY HOLE allow space, any unicode letter and digit, underscore and dash
# if(preg_match("/[^\040\pL\pN_-]/u", $term)) { print $json_invalid; exit; }
#******************************************************************************
function formatrange($PAK){return preg_replace(Array('`\b([0-9]+)([0-9]{3})([0-9]{3})(?=[^0-9]|$)`','`\b([0-9]+)([0-9]{3})(?=[^0-9]|$)`','`^[0 ]*-([0-9]+)$`','`-$`'),Array("$1 $2 $3","$1 $2","$1 ou menos"," ou mais"),$PAK);}
function fixrange($Frm,$Tto){
	global $Deb;
	if($Frm&&$Tto&&($Lto=strlen($Tto))<($Lfr=strlen($Frm))){
		if($Tto==substr($Frm,0,$Lto)){
			$Tto.=substr($Frm,$Lto,1);
			(($x=substr($Frm,0,$Lto+1)-$Tto)>=0)&&($Tto+=$x+1);
		}
		$Tto.=substr('0000000000000',0,$Lfr-$Lto-1);
		if($Frm&&$Tto&&$Tto<$Frm){$Tto=$Tto*10;}
		$Deb.="/fr=$Frm/to=$Tto";
	}
  	if($Frm&&$Tto&&$Tto<$Frm){$Tto=$Tto*10;}
	return Array($Frm,$Tto);
}
function kilo($Frm,$Tto,$K){
  $K&&($Frm!==false)&&($Frm=$Frm*1000);
  $K&&($Tto!==false)&&($Tto=$Tto*1000);
  return Array($Frm,$Tto);
}
function fixranges($Frm,$Tto,$K,$opt=""){
	$rep=Array();static $Nloop=0;
	if($K){list($Frm,$Tto)=kilo($Frm,$Tto,$K);}
		if(!$Nloop++&&($Frm&&preg_match('`lessfirst`',$opt))){array_unshift($rep, list($f,$t)=fixrange(0,$Frm));}
        if(!$Frm){array_push($rep, fixrange(0,$Tto ));return $rep;}
	$Lfr=strlen($Frm);
	$L=($Lfr>0?1:0);$Dig=substr($Frm,$L,1);$Dig=(($Dig>0 && $Dig<9)?0:1);
		($Tto||!preg_match('`nomore`',$opt))&&array_push($rep, list($f,$t)=fixrange($Frm,$Tto) );
		($Frm&&$Tto&&preg_match('`yesless`',$opt))&&array_push($rep, list($f,$t)=fixrange(0,$Tto) );
	if(!$Tto){
		preg_match('`yesless`',$opt)&&array_push($rep, fixrange(0,$Frm));
		array_push($rep, fixrange($Frm,$Dig+substr($Frm,0,$L)) );
	}
return $rep;	
}

function finish(){
	global $a_json;
	$x=Array();
	$z=Array();
	for($i=0;$i<count($a_json);$i++){
		while(list($k,$v) = each($a_json[$i])){
			#print "$i,$k,$v=<BR>\n";
			if(is_string($v)){$a_json[$i][$k]=mb_convert_encoding($v,"UTF-8","ISO-8859-15");}#utf8_encode($v);}
			#print "$i,$k,".$a_json[$i][$k]."|<BR>\n";
			}
	} print json_encode($a_json);
	exit;
} 
function finish2(){
	global $a_json;
	$x=Array();
	$z=Array();
	for($I=0;$I<count($a_json);$I++){
	for($i=0;$i<count($a_json[$I]);$i++){
		while(list($k,$v) = each($a_json[$I][$i])){
			#print "$i,$k,$v=<BR>\n";
			if(is_string($v)){$a_json[$I][$i][$k]=mb_convert_encoding($v,"UTF-8","ISO-8859-15");}
			#print "$i,$k,".$a_json[$i][$k]."|<BR>\n";
			}
	}} print json_encode($a_json);
	exit;
} 
function utf8($x){
	# BETTER TO DO NOTHING UNTIL finish() AND THEN utf8_encode ALL STRINGS : ALLOWS COMPARE (AND print FOR DEBUG)
	#return is_string($x)?utf8_encode($x):$x;
	return $x;
}
#$term=preg_replace('`"`','',$term); 
$parts = explode(' ', $term);
$p = count($parts);
$term_is_pak=(preg_match('`^(Palavras|[AaÁá]rea(?:[- ]?[uú](?:ti?l?)?)?|Quarto|Tipo|Preco|Terra|Nota|telefono|telemovil|An(?:u(?:n(?:c(?:i(?:a(?:d(?:or?)?)?)?)?)?)?)?|De(?:s(?:de?)?)?|Publicado?|Apart(?:a(?:m(?:e(?:n(?:to?)?)?)?)?)?|Casa|Moradia)s?$`i',strtolower($TERMdeac),$Ag)?$Ag[1]:"");
$term_is_pak_L=strlen($term_is_pak);
 
if(preg_match('`^(?!(?:Ha|[AatTeE])[0-9]+(?:-[0-9]*)?$)
	([a-z][a-z_0-9]*)[ ]*
	(	(	(<)
		|	 >
		)=?
	|	(?:	[!]?=[<]?|<=>
		|	[ ](?:not[ ]*)?\b(?:like|regexp|match|in)\b
		)
	[ ]*
	)
		(""|(["\`]?)(?:[0-9]+|[a-zà-ÿÀ-Ü0-9]*[a-zà-ÿÀ-Ü][a-zà-ÿÀ-Ü0-9]*)\6?|(?:(["\`])|[\x28])(?(7)(?:(?![\\\\]?\7).|[\\\\]\7)*\7|[^\x28\x29]*\x29))
	(?(3)(?:[ ]+(?:and|e)[ ]+|[-, ]+)?
	    (?:
		(
			(?:[0-9]+|"[^"]*")
			(?:\3=?|$)
		)
		(?:\1)?	
	     |
		[ ]*(?:\1[ ]*)?
		(
			(?(4)	>
			|	<
			)=?
			(?:[0-9]+|"[^"]*")
		)
	    )?
	)
	$`xi',$term,$Ag)){
	$x=(@$Ag[9]
		?$Ag[1].$Ag[9]
		:(@$Ag[8]
			?$Ag[8]
				.((strpos($Ag[8],$Ag[3])===false||($z=''))
					&&(($y=strlen($Ag[5])-($z=strlen($Ag[8])))||true)
					&&((($z=substr('00000000000000',0,$y))?"":"")||true)
					?$z.$Ag[2]:""
				)
				.$Ag[1]
			:""
		)
	  );
	add_P_R_N_P_C_D(99999,"REP",$Ag[1] ,$PAK=$Ag[1].$Ag[2].($V=preg_replace('`^([a-zà-ÿÀ-Ü0-9][a-zà-ÿÀ-Ü][a-zà-ÿÀ-Ü0-9]*)$`','"$1"',$Ag[5])).($x?', '.$x:"") 
		,$Ag[1].$Ag[2].$V.($x?' and '.$x:"")
		,
#		"<b>".$Ag[1].":</b>".
		"<b>Index {$Ag[1]}:</b>".$PAK);
}

$prinote=(empty($_REQUEST['cmdname'])||$_REQUEST['cmdname']!="NOTES")&&!empty($HASHcmds['NOTES'])?1000:20000;
	#add_P_R_N_P_C_D($prinote,"REP","NOTES" ,$PAK="NOTAS" ,"NOTES" ,"<b>Notas</b>: Anúncios em que <b>sua equipe</b> escreveu uma nota");
$PAKname="Palavras";$PAKname_L=strlen($PAKname);$MinPakNameTerm=($PAKname_L<$term_is_pak_L?$PAKname_L:$term_is_pak_L);
$NOprimots=((@$Agcp[3]||@$_REQUEST['cmdname']&&$_REQUEST['cmdname']!='MOT')?1:0);
$NOsurfmots=(preg_match('`^(ha|[ate¤]|m(2|\xb2)?)?[ 0-9]+(-[0-9]*)?((1)|Ha|[m¤](2\b|\xb2)?)$`i',$term)?40000:0);
$primots=(!(substr($term,0,1)=='"'||substr($term,0,1)=='+')&&(empty($_REQUEST['cmdname'])||$_REQUEST['cmdname']!="MOT")&&$term_is_pak&&substr($PAKname,$MinPakNameTerm)!=substr($term_is_pak,0,$MinPakNameTerm) 

	||(!empty($HASHcmds['MOT'])||preg_match('`^[^? ]{0,2}$|(^|k?[emt])[ ]?(?:[1-9][0-9]?[ ]?(?:[0-9]{3}[ ]?)?)?[0-9]00(?:-|$)`',$term))?1200:60000);
if(preg_match('`^(?:Palavras:|([-+]))[ ]*([^ ].*)$`i',$term,$AgP)){
if(!isset($AgP[1])
&&preg_match('`^([\x60\x22])?[^\x60\x22]*(?(1)\1?)$`',$AgP[2],$AgQ)
&&preg_match('`(^|[^a-zA-ZÀ-Üà-ÿ0-9])[a-zA-ZÀ-Üà-ÿ0-9]{1,2}([^a-zA-ZÀ-Üà-ÿ0-9]|$)`',$AgP[2])){$AgP[2]='+'.($x=($AgQ[1]?'':'"')).$AgP[2].($x);}
add_P_R_N_P_C_D(99999-$NOprimots-$NOsurfmots,"REP","MOT",$x=@$AgP[1].$AgP[2],"( MOT=\"".preg_replace(Array('`"`','`(?=[-+]+)`'),Array('`',' '),$x)."\" )","<b>Palavras:</b> $x" 
);}        
#if(preg_match('`^([\x22])?([-?+ \x60\x22\x27\x28\x29/0-9a-zA-Zà-ÿÀ-Ü]*|[0-9]{9})$`',$term,$Ag)
#if(preg_match('`^([\x22](?=[^\x22]*$|[^-+\x22]*[ ][-+]|(?:[^-+\x22]*\x22){2,}))?([-?+ \x60\x22\x27\x28\x29/0-9a-zA-Zà-ÿÀ-Ü]*|[0-9]{9})$`',$term,$Ag)
if((empty($_REQUEST['cmdname'])||"MOT"==$_REQUEST['cmdname']||"pr3"==$_REQUEST['cmdname']||"NOTA"==$_REQUEST['cmdname'])
  &&(preg_match('`^(?![0-9a-zà-ÿA-ZÀ-Ü][0-9]+-)((?i:Pa(?:l(?:a(?:v(?:r(?:as?)?)?)?)?)?\b: ?)?)([-?+ ,\x60\x22\x27\x28\x29/0-9a-zA-Zà-ÿÀ-Ü]*|[0-9]{9})$`',$term,$Ag)
		||(@$_REQUEST['cmdname']=="MOT")&&$Ag=Array('ok',''))
	&&((@$Ag[1]||(@$_REQUEST['cmdname']=="MOT")||preg_match('`[-+\x28\x22]`',$term))&&($primots=99999-$NOprimots)||true)
	&&(preg_match('`^[^-+\x22]*$`',$Ag[2])
		&&preg_match('`(^|[^0-9a-zA-Zà-ÿÀ-Ü\x22])((?i:[0-9]+|area|por|para|S[aã]o|Sant[ao]|Rua|Avenida|Praceta|Passeio|Vila|d[ao]s)|[0-9a-zA-Zà-ÿÀ-Ü]{1,2})([^0-9a-zA-Zà-ÿÀ-Ü\x22]|$)`',$Ag[2])
		&&($Ag[2]='"'.$Ag[2].'"')
	||true
	)
	&&(($Qterm=preg_replace(  Array( '`[ ,:\t]+`'
					,'`([-+]|^)((?:[0-9a-zA-Zà-ÿÀ-Ü]{3,}[ ]+)*[0-9a-zA-Zà-ÿÀ-Ü]{1,2}(?:[ ]+[0-9a-zA-Zà-ÿÀ-Ü]+)*)(?:(?=[ ]?[-+\x22])|$)`'
					,'`([-+]|^)([0-9a-zA-Zà-ÿÀ-Ü]+(?:[ ]+[0-9a-zA-Zà-ÿÀ-Ü]+)*)"$`','`^("[^"]*)$`'
					,'`^("[^"]*)$`'
				),Array( ' '
					,'$1"$2"'
					,'$1"$2"'
					,'$1"'
				),$Ag[2]))||true)
	&& preg_match('`^(?:'#.'(?i:Pa(?:l(?:a(?:v(?:r(?:as?)?)?)?)?)?\b:? ?)?'
	    .'(?:([-]{1,3}|[+]{1,3})[ ]*)?'
	.'('
	      .'[0-9a-zA-Zà-ÿÀ-Ü]+|"[- \x27/0-9a-zA-Zà-ÿÀ-Ü]+(?:"|$)'
	  .'|\x28[ ]*(?![ ])'
	  .'(?:'
	    .'(?:([-]{1,3}|[+]{1,3})[ ]*)?'
	    .'('
	      .'[0-9a-zA-Zà-ÿÀ-Ü]+|"[- \x27/0-9a-zA-Zà-ÿÀ-Ü]+"|("[- \x27/0-9a-zA-Zà-ÿÀ-Ü]+)$'
            .')[ ]*'
	  #.')+(?(5)|\x29)'
	  .')+\x29?'
	.')[ ]*)*([\x22])?$`',$Qterm,$Endquote)
){
	if($IsQuote){$primots=99999-$NOprimots;}if(@$Endquote[6]){$Qterm=@$Endquote[1].@$Endquote[2];}#elseif(@$Endquote[5]){$Qterm.='"';}
	$Qterm=preg_replace('`(\x28[^\x28\x22\x29]*(\x22[^\x22\x29]*)?(?:\x22[^\x22\x28\x29]*\x22|[^\x22\x28\x29]+)*)$`e','"$1".("$2"?"\"":"").")"',$Qterm);
	$x=Deac($Qterm,true,true);

	if(preg_match('`^"?(vista|vue) ((sur l[ea]|d[eo]|para( [o])?) )?m[ea]?r?"?$`i',$x)){$term="vista de mar";$X="\"vista de mar\"";$x='"vue mer" "vue sur la mer" "vista mar" "vista de mar" "vista do mar" "vista para mar" "vista para o mar"';
	add_P_R_N_P_C_D(preg_match('`[^ ]-|\b[0-9]{1,4}\b`',$term)?25000:$primots-$NOsurfmots,"REP","MOT" ,$PAK=preg_match('`"[^\x22]*"`',$X)?$X:"$X" ,"( MOT=\"".preg_replace(Array('`"`','`(?=[-+]+)`'),Array('`',' '),$x)."\"" ,"<b>Palavras:</b> Anúncios com <b>$X</b> (".Deac($Qterm,true,true).")");

	}elseif(preg_match('`^"?vista (?:(?:d[eoa]s?|para(?: [oa]s?)?) )?([A-Za-zÀ-Üà-ÿ]{3,})"?$`i',$x,$Agw)){$X="vista ".$Agw[1];
	$x='"vista '.$Agw[1].'" "vista de '.$Agw[1].'" "vista do '.$Agw[1].'" "vista para '.$Agw[1].'" "vista para o '.$Agw[1].'"';
	$x.=' "vista da '.$Agw[1].'" "vista dos '.$Agw[1].'" "vista para a '.$Agw[1].'"';
	$x.=' "vista das '.$Agw[1].'" "vista para as '.$Agw[1].'"';
	add_P_R_N_P_C_D(preg_match('`[^ ]-|\b[0-9]{1,4}\b`',$term)?25000:$primots-$NOsurfmots,"REP","MOT" ,$PAK=preg_match('`"[^\x22]*"`',$X)?$X:"$X" ," MOT=\"".preg_replace(Array('`"`','`(?=[-+]+)`'),Array('`',' '),$x)."\""
	#.' and annonce regexp "[[:<:]]vista ((d[eoa]s?|para( [oa]s?)?) )?'.$Agw[1].'[[:>:]]" '
	 ,"<b>Palavras:</b> Anúncios com <b>$X</b>");
	}else{
	$x=preg_replace(Array('`^("vista de ma?r?"?)$`'
			),Array('"vista mar" "vista de mar" "vista do mar" "vista para mar" "vista para o mar"'
			),$x);
	add_P_R_N_P_C_D(preg_match('`[^ ]-|\b[0-9]{1,4}\b`',$term)?25000:$primots-$NOsurfmots,"REP","MOT" ,$PAK=preg_match('`"[^\x22]*"`',$x)?$x:"$x" ,"( MOT=\"".preg_replace(Array('`"`','`(?=[-+]+)`'),Array('`',' '),$x)."\" )" ,"<b>Palavras:</b> Anúncios que têm <b>".($x?$x:"suas palavras")."</b> no texto do anúncio");
	#(strlen($term)<6)&& add_P_R_N_P_C_D($primots,"REP","MOT" ,($PAK=$y=" +piscina -\"piscina publica\"") ,"( MOT=\"".preg_replace('`"`','`',$y)."\" )" ,"<b>Palavras: </b> $y Anúncios com piscina particular no texto do anúncio");
	if(!preg_match('`[-+\x28\x29]| ou m[ea]`',$term)&&strlen($x)==8){
	add_P_R_N_P_C_D($primots-$NOsurfmots,"REP","MOT" ,($PAK=$y=" +$x -\"sem $x\"") ,"( MOT=\"".preg_replace('`"`','`',$y)."\" )" ,"<b>Palavras: </b> $y Anúncios com $x e sem contendo <b>".($y?$y:"suas palavras")."</b> no texto do anúncio/");
	}}
}

#CKVARS=nom%3Dtestjfr%26grp%3Diadportugal%26sx%3D1436%26sy%3D877%26PAYS%3Dpt%26lgdef%3DPt%26r%3Dpause%26cnx%3Dbc5cb99f4b0f6555209622ae16321045%26sid%3D72939%26gid%3D72925; js3ck=wa1428692922wb1428690937wc1428693277wd0we0wf1; 
# "js2ck=ih822wx1415wy822; CKVARS=nom%3Dtestjfr%26grp%3Diadportugal%26sx%3D1436%26sy%3D877%26PAYS%3Dpt%26lgdef%3DPt%26r%3Dpause%26cnx%3Dbc5cb99f4b0f6555209622ae16321045%26sid%3D72939%26gid%3D72925; js3ck=wa1428690937wb0wc1428690938wd0we0wf1; CRVARS=1428690938"
	#&& ($AR=querysdb("select snom from sup where id=\"".str_replace('"','',$sid)."\""))
	#&& ($SNOM=$AR[0][0])
if((empty($_REQUEST['cmdname'])||"MOT"==$_REQUEST['cmdname']||"pr3"==$_REQUEST['cmdname']||"NOTA"==$_REQUEST['cmdname']||"NOTE"==$_REQUEST['cmdname'])
  &&$SNOM&&$sid){
	if($C_Debug){print "************ /".$_COOKIE["CKVARS"]."/\nterm=$term<BR>\n\n";}
if(false && preg_match('`^[? ]{0,3}$|^(Notas?:)?([a-zA-Zà-ÿÀ-Ü]+[ ?\x27a-zA-Zà-ÿÀ-Ü0-9]{2,})$`',$term,$Ag)
	&&(	  (@$Ag[1]||@$_REQUEST['cmdname']=='NOTES')&&($prinote=99999)
		||!$term_is_pak&&(($prinote=$primots-1)||1)
	)
){
	$monot=@$Ag[2];
	add_P_R_N_P_C_D($prinote,"REP","NOTA" ,$PAK="\"$monot\" nas notas" ,"NOTES=\"$SNOM\" and NOTA=\"".$monot."\"" ,"<b>Notas:</b> ".($C_Debug?"&lt;":"<")."img src=\"/body_a/pencil.png\"> Anúncios com notas de $SNOM que tem palavras <b>\"$monot\"</b>");
}
#($SNOM=querysdb("select snom from sup where sid=\"".str_replace('"','',$_REQUEST['sid'])."\""))){
	@$TSid && add_P_R_N_P_C_D($prinote,"REP","NOTES" ,$PAK="Notas de todos" ,"NOTES" ,"<b>Notas:</b> ".($C_Debug?"&lt;":"<")."img src=\"/body_a/pencil.png\"> Anúncios em que alguém da equipe escreveu uma nota com icon ".($C_Debug?"&lt;":"<")."img src=\"/body_a/pencil.png\">");
	add_P_R_N_P_C_D($prinote,"REP","NOTES" ,$PAK="Notas de $SNOM" ,"NOTES=\"$SNOM\"" ,"<b>Notas:</b> ".($C_Debug?"&lt;":"<")."img src=\"/body_a/pencil.png\"> Anúncios em que <b>user $SNOM</b> escreveu uma nota com icon ".($C_Debug?"&lt;":"<")."img src=\"/body_a/pencil.png\">");

}

$pripr3=(!empty($HASHcmds['pr3'])?60001:60001);
if(preg_match('`^(?![0-9]{4}0{5})[0-9]{9,}$`',$term,$Ag)){
	if($IsQuote){$pripr3=99999;}
	$x=preg_replace('`[?\x22]+`','`',$term);
	add_P_R_N_P_C_D($pripr3,"REP","pr3" ,$PAK="$x" ,"pr3=$x" ,"<b>Telefone:</b> Anúncios que que estão ligados a este <b>".($x?$x:"telephone")."</b>");
}
if(preg_match('`^([1-9][0-9]{3}((?:[, ]*[1-9][0-9]{3})*))[, ]*$`',$term,$Ag)){
     $x=preg_replace('`[, ][, ]+`',',',implode(',',preg_split('`[^0-9]*(?<!^)(?=(?:[0-9]{4})+\b)`',$Ag[1])));
     add_P_R_N_P_C_D(99999,"REP","ville" ,$PAK=$x ,"ville=\"".preg_replace(Array('`[", ]+`','`^[ ]|[ ]$`'),Array(' ',''),$x)."\"" ,"<b>Codigos postais:</b> $x*");
  #if(empty($Ag[2])){$y=$x+100;$x.=' '.$y;
  #   add_P_R_N_P_C_D(99999,"REP","ville" ,$PAK=$x ,"ville=\"".preg_replace('`, *`',' ',$x)."\"" ,"<b>Codigos postais:</b> $x");
	#$priprix=$prizip=99999;
  #}
}elseif(preg_match('`^((?:[1-9][0-9]{3}(-[0-9]{3})?\b[ ]*)+)[, ]*((?:[A-ZÀ-Üà-ÿ]+(?:[- \x27/][A-ZÀ-Üà-ÿ]+)*))?$`i',$term,$Ag)){
     $x=preg_replace(Array('`-000\b`'),Array(''),$term);
     $y=preg_replace(Array('`-000\b`','`(-[0-9]{3})[^0-9]+(?=[ ][0-9]|$)`','/["`]/'),Array('','$1','`'),$term);
     add_P_R_N_P_C_D(99999,"REP","ville" ,$PAK=$x ,"ville=\"$y\"" ,"<b>".(preg_match('`^([1-9][0-9]{3}-[0-9]{3}\b[^0-9]*)+$`',$x)?"Localização precisa":"Codigos postais").":</b> $x*");
}
$prisurf=(empty($_REQUEST['cmdname'])||$_REQUEST['cmdname']!="s")&&!empty($HASHcmds['s'])?25000:30000;
$Sdata=false;
#if(!preg_match('`[/\xe2\x82\xacE]|^[\x22\x60+][a-z]$`',$term)&&preg_match('`^[ ]*(K?)(m[ ]*(?:\xb2|&2;)?|a ?(?=$|[0-9])|s(?:u(?:r(?:fa?c?e?)?)?)?|area(?:[- ]?u(?:t(?:il?)?)?)?:? ?m?(?:2|&2;)? ?)(?:(?:([0-9]+)(K?)(-([0-9]*)(K?)| *(?:ou *mai?s?|-?[ ]*[+]| ou men?o?s?))?)|(-([1-9]*)(K?)| *(?:ou *mai?s?|-?[ ]*[+]| ou men?o?s?))$)`i',$term,$Ag)){
 # $EU="m ";#"\xe2\x82\xac";
if(!preg_match('`[/\xe2\x82\xacE]|^[\x22\x60+][a-z]$`',$term)&&preg_match('`^[ ]*(K?)(?:(m[ ]*(?:2\b|&2;|\xb2)?|a ?(?=$|[0-9])|(?:s(?:u(?:r(?:fa?c?e?)?)?)?|hab(?:i(?:t(?:ab?l?)?)?)?|area(?:[- ]?u(?:t(?:il?)?)?)?)?:? ?(?:m[ ]?(?:2\b|&2;|\xb2)?)? ?))?(?:(?:([0-9]+)(K?)(-([0-9]*)(K?)(?(1)|m(?:2\b|\xb2|&2;)?)| *(?:ou *(?:plu|mai)s?|-?[ ]*[+]| ou (?:moi?n?|men?o?)s?))?)|(-([1-9]*)(K?)(?(1)|m[ ]?(?:[2\xb2]|&2;)?)| *(?:ou *(?:plu|mai)s?|-?[ ]*[+]| ou (?:moi?n?|men?o?)s?))$)`i',$term,$Ag)){
  $EU="m\xb2 ";#"\xe2\x82\xac";

  $more=preg_match('`[+a]`i',@$Ag[5]);
  $less=preg_match('`[e]`i',@$Ag[5].@$Ag[8]);
  ($Tto=($less?$Ag[3]:(isset($Ag[6])&&strlen($Ag[6])>0?$Ag[6]:(isset($Ag[9])&&strlen($Ag[9])>0?$Ag[9]:false)))) && ($Sdata=true);
  ($Frm=($less?0:(isset($Ag[3])&&strlen($Ag[3])>0?$Ag[3]:false))) && ($Sdata=true);
  if($less){$Tto=$Frm;unset($Frm);}
  #($Tto=(isset($Ag[6])&&strlen($Ag[6])>0?$Ag[6]:(isset($Ag[9])&&strlen($Ag[9])>0?$Ag[9]:false))) && ($Sdata=true);
  #($Frm=(isset($Ag[3])&&strlen($Ag[3])>0?$Ag[3]:false)) && ($Sdata=true);
  $Keu=((!empty($Ag[1])||!empty($Ag[4])||!empty($Ag[7])||!empty($Ag[10]))?"K":"");
  #if($Frm&&$Tto&&($Lto=strlen($Tto))<($Lfr=strlen($Frm))){$Tto.=substr($Frm,$Lto,1);(($x=substr($Frm,0,$Lto+1)-$Tto)>=0)&&($Tto+=$x+1);$Tto.=substr('0000000000000',0,$Lfr-$Lto-1);$Deb.="/fr=$Frm/to=$Tto";}
  $F0=$Frm;
  $T0=$Tto;
  #$ranges=fixranges($Frm,$Tto,$Keu,'yesmore');
  $ranges=fixranges($Frm,$Tto,0,'yesmore');
 for($i=0;$i<count($ranges);$i++){ 
  list($Frm,$Tto)=$ranges[$i];
  $Keu&&($Frm!==false)&&($Frm=$Frm*1000);
  $Keu&&($Tto!==false)&&($Tto=$Tto*1000);
  $PAK=($Frm!==false?$Frm:"")."-".($Tto!==false?$Tto:"");
  $K=(preg_match('`000$`',$Frm)&&preg_match('`000$`',$Tto)?'K':'');
     ($Frm>31||$Tto>9||preg_match('`^[AÁ]rea`i',$term))&&($Frm<1000&&$Tto<1000&&$prisurf=99000)&&($Frm<500&&$Tto<500&&$prisurf=99999);
     if(!@$Ag[2] && $Frm>="500"){$prisurf=30000;} 

	add_P_R_N_P_C_D($prisurf-(($x=((
                                (($Tto&&$F0||!$Tto&&!$F0)&&
                                 ($Frm&&$T0||!$Frm&&!$T0))||
                                (($Tto&&$T0||!$Tto&&!$T0)&&
                                 ($Frm&&$F0||!$Frm&&!$F0))
                                )&&!preg_match('`[0-9]{6}`i',$term)
                                &&preg_match('`([0-9]|\b)m(2?\b|\xb2|&2;)`i',$term)))?0:(!preg_match('`[0-9]{4}`i',$term)?2:20000)),"REP","s"
	,$K."$EU".($PAK=preg_replace(Array('`000'.($K?'':';').'(?=[^0-9]|$)`','`^[0 ]*-([0-9]+)$`','`-$`'),Array('','$1 ou menos',' ou mais'),$PAK))
	,"$Frm<=s".($Tto?" and s<=$Tto":"")
	#,"<b>Área útil:</b> m\xb2 ".formatrange($PAK).($Frm>31&&$Tto>9?"*":"")
        ,"<b>Área útil:</b> m\xb2 ".formatrange($PAK).""
        .(!@$GotHotSpace&&$Frm<1000&&$Tto<1000&&$x?($GotHotSpace="*"):"")
    	);
 }
}
  if(!$Sdata){
$i=40;add_P_R_N_P_C_D($prisurf,"REP","s", $PAK="m$i ou menos",            "s<=$i" , "<b>Área útil:</b> m-$i ou menos de $i m\xb2 ");
$i=90;add_P_R_N_P_C_D($prisurf,"REP","s", $PAK="m$i ou mais",           "$i<=s",    "<b>Área útil:</b> m$i ou mais de $i m\xb2");
$i=300;add_P_R_N_P_C_D($prisurf,"REP","s", $PAK="m300-400",    "300<=s and s<=400", "<b>Área útil:</b> m300-400 m\xb2 ");
  }
$prieupm=(empty($_REQUEST['cmdname'])||$_REQUEST['cmdname']!="KF")&&!empty($HASHcmds['KF'])?25000:30000;
$Mdata=false;
$Eupm=false;
#if(!preg_match('`^K?(E(?:uro)?|\xe2\x82\xac)?[/mha]`i',$term)&&preg_match('`^[ ]*(K?)(E(?:uro)?|\xe2\x82\xac)?(?:(?:([0-9]+)(K?)(-([0-9]*)[ ]*(K?)[ ]*| *(?:ou *mai?s?|-?[ ]*[+]| ou men?o?s?))?)|(-([0-9]*)[ ]*(K?)[- ]*(?:ou *(men?o?s?|mai?s?))?)[ ]*$)?$`i',$term,$Ag)){
$term=preg_replace('`^(K?[E¤])?([0-9]{2,9}) (o(u( (m(e(n(os?)?)?)?)?)?)?)?$`','$1-$2',$term);
$priprix=(!empty($priprix)?$priprix:(empty($_REQUEST['cmdname'])||$_REQUEST['cmdname']!="prix")&&!empty($HASHcmds['prix'])?25000:30000);
$Edata=false;
$Euro=false;
#if($C_Debug){print "****************************term=/$term/ cmds=/$cmds/<BR>\n\n";}
#if(preg_match('`^(?:(?:e(?:u(?:r(?:os)?)?)?|¤)[ ]?)?([0-9]{3,8})(?:-([0-9]{3,8}))[ ]?(e(?:u(?:r(?:os)?)?)?|¤)?$`i',$term,$Ag)&&$Ag[1]&&(!empty($Ag[2])&&$Ag[2]>=$Ag[1]||!empty($Ag[3]))){
#add_P_R_N_P_C_D(99999,"REP","prix", $PAK="¤{$Ag[1]}-{$Ag[2]}",  "{$Ag[1]}<=prix and prix<={$Ag[2]}",       "<b>Preço:</b> ¤{$Ag[1]}".($Ag[2]?"-".$Ag[2]:"")." *");
#}
if(@$_REQUEST['cmdname']!="ville" && preg_match('`^[ ]*(K?)([E¤](?:uro)?|\xe2\x82\xac)?(?:/m|(?i:M))?(?:(?:([0-9]{1,3}(?:[ ]?[0-9]{3})?|[0-9]{1,2}(?:[ ]?[0-9]{3}){2})(K?)¤?(-([0-9]{0,3}(?:[ ]?[0-9]{3})?|[0-9]{1,2}(?:[ ]?[0-9]{3}){2])[ ]*(K?)¤?[ ]*| *(?:ou *mai?s?|-?[ ]*[+]| ou men?o?s?))?)|(-([0-9]*)[ ]*(K?)¤?[- ]*(?:ou *(men?o?s?|mai?s?))?)[ ]*$)?$`i',$term,$Ag)){
  $Eurosign=preg_match('`[¤]|(\b|[0-9])k?[e](u(r(os?)?)?)?(\b|(?=[0-9]))`i',$term);
  $M2sign=preg_match('`m2\b|m\xb2`i',$term);
  $Cmd=$NomCmd="prix";$Star=$Pmin=$Pmax=$PM2="";
  if(preg_match('`^K?(E(?:uro)?|\xe2\x82\xac)?[/mha]`i',$term)){$NomCmd="KF";$Cmd="M2";$EU="/m";$PM2="/m\xb2 ";$Eupm=true;}else{$Cmd=$NomCmd="prix";$PM2="";$EU="¤";$Euro=true;}
  if(!empty($Ag[3])){$Pmin=$Ag[3]=str_replace(' ','',$Ag[3]);}
  if(!empty($Ag[6])){$Pmax=$Ag[6]=str_replace(' ','',$Ag[6]);}
#$C_Debug&&(print "xxxxxxxxxxxxxxxxxSxxExCxOxNxDx xCHxAxNxCE<BR>\n");
#if(preg_match('`^[ ]*(K?)(E(?:uro)?|\xe2\x82\xac)(?:(?:([0-9]+)(K?)(-([0-9]*)(K?)))|(-([1-9]*)(K?))$)`i',$term,$Ag)){
  $Short=false;#"\xe2\x82\xac";
  $more=preg_match('`[+a]`i',@$Ag[5]);
  $less=preg_match('`[e]`i',@$Ag[5].@$Ag[8]);
  ($Tto=($less?$Ag[3]:(isset($Ag[6])&&strlen($Ag[6])>0?$Ag[6]:(isset($Ag[9])&&strlen($Ag[9])>0?$Ag[9]:false)))) && ($Edata=true);
  ($Frm=($less?0:(isset($Ag[3])&&strlen($Ag[3])>0?$Ag[3]:false))) && ($Edata=true);
  if($less){$Tto=$Frm;unset($Frm);}
  if($Frm>=1&&$Frm<5){$Frm.='00';$Short=true;}
  if($Frm>=5&&$Frm<10){$Frm.='0';$Short=true;}
  if($Frm>=10&&$Frm<50){$Frm.='0';$Short=true;}
  if($priprix!=99999){$priprix=((empty($HASHcmds['prix'])||@$Ag[2]&&$Edata)?(($Edata||$Frm)?99990+(preg_match('`[¤]`',$term)?10:0):75000):10000);}
  #if($Frm&&$Tto&&($Lto=strlen($Tto))<($Lfr=strlen($Frm))){if($Tto==substr($Frm,0,$Lto)){$Tto.=substr($Frm,$Lto,1);(($x=substr($Frm,0,$Lto+1)-$Tto)>=0)&&($Tto+=$x+1);}$Tto.=substr('0000000000000',0,$Lfr-$Lto-1);if($Frm&&$Tto&&$Tto<$Frm){$Tto=$Tto*10;}$Deb.="/fr=$Frm/to=$Tto";}
  #if($Frm&&$Tto&&$Tto<$Frm){$Tto=$Tto*10;}
  $Keu=($Short&&$Euro||(!empty($Ag[1])||!empty($Ag[4])||!empty($Ag[7])||!empty($Ag[10]))?"K":"");
	#add_P_R_N_P_C_D(99999,"REP","prix","ESSAI","ESSAI","ESSAI!$Frm&&$Tto,{$Ag[2]},{$Ag[3]},{$Ag[4]},{$Ag[5]},{$Ag[6]},{$Ag[7]},{$Ag[8]},{$Ag[9]},{$Ag[10]}/");
 $ranges=fixranges($Frm,$Tto,$Keu,@$Ag[5]&&!$more?"":"yesless");#,"nomore");
 for($i=0;$i<count($ranges);$i++){ 
  list($Frm,$Tto)=$ranges[$i];
     $R='';
     ($K=($Short&&$Euro||$Euro&&(($Frm||$Tto)&&!@$H&&(!$Frm||preg_match('`000$`',$Frm))&&(!$Tto||preg_match('`000$|^$`',$Tto))&&($R='3'))?'K':''));
     ($Frm>199||$Tto>199)&&(@$Ag[2] || $Frm>="500"&&!$Short)&&$priprix=99999;
     if($priprix!=99999){$priprix=(
	!@$Ag[2]&&!@$Ag[1]&&strlen($Frm)==4
	&&(strlen(@$Ag[6])==3||substr(@$Ag[6],0,1)=='0'||$Tto*10<$Frm)
		?10000
		:$priprix
      );}
     if($priprix==99999&&@$prizip==$priprix){$priprix-=2;}
     ($Frm&&!$Tto)&&$priprix--;
     if( !$Frm>31 && $Tto>31 ){
	$Keu&&($Tto=$Tto*1000);$K=($Keu||preg_match('`000$`',$Tto)?'K':'');
	$PAK="-".$Tto;
	add_P_R_N_P_C_D("prix"!=@$_REQUEST['cmdname']&&!@$Ag[2]&&!@$Ag[1]&&$strlen($Frm)==4&&(strlen(@$Ag[6])==3||substr(@$Ag[6],0,1)=='0'||$Tto*10<$Frm)?10000:99999,"REP",$NomCmd
	,$K."$EU".($K?preg_replace(Array('`000(?=[^0-9]|$)`'),Array(''),$PAK):$PAK)
	,"$Cmd<=$Tto"
	,"<b>Preço$PM2:</b> $K&euro;$PM2".formatrange($PAK)
	." (".formatrange($PAK)." &euro;$PM2),"
	);
     }elseif($Tto>199){
        $PAK=($Frm!==false?$Frm:"")."-".($Tto!==false?$Tto:"");
  #$K=(preg_match('`000$`',$Frm)&&preg_match('`000$`',$Tto)?'K':'');
        ($Frm>"200000000")&&$priprix=10000;
	($Frm||$Tto)&&add_P_R_N_P_C_D($priprix,"REP",$NomCmd
	#,$K."$EU".($KPAK=preg_replace(Array('`000'.($K?'':';').'(?=[^0-9]|$)`','`^[0 ]*-([0-9]+)$`','`-$`'),Array('','$1 ou menos',' ou mais'),$PAK))
	,$K."$EU".formatrange($KPAK=preg_replace('`000'.($K?'':';').'(?=[^0-9]|$)`','',$PAK))
	,($Frm?"$Frm<=$Cmd":"").($Frm && $Tto!==false?" and ":"").($Tto!==false?"$Cmd<=$Tto":"")
	,"<b>Preço$PM2:</b> $K&euro;$PM2".formatrange($KPAK)
	." ".($Frm&&$Tto?"&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;":"")."(".formatrange($PAK)." &euro;$PM2)"
	.(!$Star&&$Pmin&&($Eurosign&&!$M2sign||!(strlen($Pmin)==4&&(strlen($Pmax)==3||empty($Pmax))))?$Star="*":"")
    	);
     }else{
        $PAK=($Frm!==false?$Frm:"")."-".($Tto!==false?$Tto:"");
        ($Frm>"200000000")&&$priprix=10000;
	$x=$K."$EU".($KPAK=preg_replace(Array('`000'.($K?'':';').'(?=[^0-9]|$)`','`^[0 ]*-([0-9]+)$`','`-$`'),Array('','$1 ou menos',' ou mais'),$PAK));
	($Frm>31||$Tto>99)&&add_P_R_N_P_C_D($priprix-(preg_match('`mais`',$x)?1:0),"REP",$NomCmd
	,$x
	,($Frm?"$Frm<=$Cmd":"").($Frm && $Tto!==false?" and ":"").($Tto!==false?"$Cmd<=$Tto":"")
	,"<b>Preço$PM2:</b> $K&euro;$PM2".formatrange($KPAK)
	." (".formatrange($PAK)." &euro;$PM2)."
    	);
	$K=$Keu?"K":"";
      if($Frm===false && $Tto===false){
	$f=1000;$t=$f+1000;if($K){$f=$f*1000;$t=$t*1000;};$PAK="$f-$t";
	add_P_R_N_P_C_D($Eupm?5000:$priprix,"REP","prix"
	,$K."$EU".($K?preg_replace(Array('`000(?=[^0-9]|$)`'),Array(''),$PAK):$PAK)
	,($f?"$f<=prix and ":"")."prix<=$t"
	,"<b>preço:</b> $K&euro;".formatrange($PAK)
	."."
	#." (***)"
    	);
	$f=100;$t=$f+100;if($K){$f=$f*1000;$t=$t*1000;};$PAK="$f-$t";
	add_P_R_N_P_C_D($Eupm?5000:$priprix,"REP","prix"
	,$K."$EU".($K?preg_replace(Array('`000(?=[^0-9]|$)`'),Array(''),$PAK):$PAK)
	,($f?"$f<=prix and ":"")."prix<=$t"
	,"<b>preço:</b> $K&euro;".formatrange($PAK)
	."."
    	);
       if($K){
	$f=10;$t=$f+10;if($K){$f=$f*1000;$t=$t*1000;};$PAK="$f-$t";
	add_P_R_N_P_C_D($Eupm?5000:$priprix,"REP","prix"
	,$K."$EU".($K?preg_replace(Array('`000(?=[^0-9]|$)`'),Array(''),$PAK):$PAK)
	,($f?"$f<=prix and ":"")."prix<=$t"
	,"<b>preço:</b> $K&euro;".formatrange($PAK)
	."."
    	);
	$f=1;$t=$f+1;if($K){$f=$f*1000;$t=$t*1000;};$PAK="$f-$t";
	add_P_R_N_P_C_D($Eupm?5000:$priprix,"REP","prix"
	,$K."$EU".($K?preg_replace(Array('`000(?=[^0-9]|$)`'),Array(''),$PAK):$PAK)
	,($f?"$f<=prix and ":"")."prix<=$t"
	,"<b>preço:</b> $K&euro;".formatrange($PAK)
	."."
    	);
       }
      }
}
  if(!$Edata){
$i=40000;add_P_R_N_P_C_D($priprix,"REP","prix", $PAK="E$i ou menos",            "prix<=$i" ,      	"<b>Preço:</b> Ke40 ou menos &nbsp;(40 000 &euro; ou menos)");
$i=10;add_P_R_N_P_C_D($priprix,"REP","prix", $PAK="Ke100-120",    	"$i<=prix and prix<=".($i+1),	"<b>Preço:</b> Ke100-120 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(100 000-120 000 &euro;)");
$i=900000;add_P_R_N_P_C_D($priprix,"REP","prix", $PAK="E$i ou mais",           "$i<=prix",       	"<b>Preço:</b> Ke900 ou mais &nbsp;&nbsp;(900 000 &euro; ou mais)");

$i=2000;add_P_R_N_P_C_D($prieupm,"REP","KF", $PAK="/m$i ou menos",            "M2<=$i" ,      	"<b>Preço/m\xb2:</b> /m1000 ou menos &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(1000 &euro;/m\xb2 ou menos)");
$i=1000;add_P_R_N_P_C_D($prieupm,"REP","KF", $PAK="/m1000-2000",    	"1000<=M2 and M2<=2000","<b>Preço/m\xb2:</b> /m1000-2000 &euro;/m\xb2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(1000-2000 &euro;/m\xb2)");
$i=9000;add_P_R_N_P_C_D($prieupm,"REP","KF", $PAK="/m$i ou mais",           "$i<=M2",       	"<b>Preço/m\xb2:</b> /m9000 ou mais &euro;/m\xb2&nbsp;&nbsp;(9000 &euro;/m\xb2 ou mais)");
  }
  }
  }
$pripiec=(empty($_REQUEST['cmdname'])||$_REQUEST['cmdname']!="p")&&!empty($HASHcmds['p'])?1000:30000;
  $Tdata=false;
if(preg_match('`Q(u(a(r(t(os?)?)?)?)?)?:?$`i',$term)||(!$term_is_pak&&preg_match('`^(?:[?T])$|^[?]?(?:(?i:q(?:u(?:a(?:r(?:t(?:os?)?)?)?)?)?:? ?)T?|T)[ ]*(?:([Tt]o?d?o?s?)$|(?:([0-9]+)(-([0-9]*))?)|(-([1-9]*)))?$`i',$term,$Ag))){
   $SpaceBoxed=preg_match('`^[T[0-9]{1,2}(-[0-9]{1,2})?$`i',$term)?"*":"";
     $pripiec=99999;if(preg_match('`\bt([0-9]{2,})?\b`',$term)){$pripiec-=1;}
  ($Tto=(isset($Ag[4])&&strlen($Ag[4])>0?$Ag[4]:(isset($Ag[6])&&strlen($Ag[6])>0?$Ag[6]:false))) && ($Tdata=true);
  ($Frm=(isset($Ag[2])&&strlen($Ag[2])>0?$Ag[2]:false)) && ($Tdata=true); if($Frm>100){$pripiec=20000;}
  list($Frm,$Tto)=fixrange($Frm,$Tto);
  
  if(isset($Ag[1])||isset($Ag[2])||isset($Ag[5])){
     !empty($Ag[1])&&add_P_R_N_P_C_D($pripiec,"REP","p" ,$PAK="T".(!empty($Ag[1])?" Todos":"") ,"1", "<b>Quartos</b>: T todos");
     if($Frm!==false&&!($Frm==0&&$Tto>0)){
	if(!isset($Ag[3])||$Tto===$Frm){
	  add_P_R_N_P_C_D($pripiec,"REP","p" ,$PAK="T$Frm" ,$Frm."=p",				"<b>Quartos:</b> $PAK".($Frm<7?$SpaceBoxed:""));
        }
      if($Tto===false){
	add_P_R_N_P_C_D($pripiec,"REP","p" ,$PAK="T$Frm-".($x=$Frm+1) ,$Frm."<=p and p<=$x",	"<b>Quartos:</b> $PAK");
	add_P_R_N_P_C_D($pripiec,"REP","p" ,$PAK="T$Frm-".($x=$Frm+2) ,$Frm."<=p and p<=$x",	"<b>Quartos:</b> $PAK");
	add_P_R_N_P_C_D($pripiec,"REP","p" ,$PAK="T$Frm-" ,$Frm."<=p",				"<b>Quartos:</b> $PAK e mais.");
      }elseif($Tto!==$Frm){
	add_P_R_N_P_C_D($pripiec,"REP","p" ,$PAK="T$Frm-$Tto" ,$Frm."<=p and p<=$Tto", 	"<b>Quartos:</b> ".$PAK.($Frm<20?$SpaceBoxed:""));
      }
     }elseif($Tto!==false){
	add_P_R_N_P_C_D($pripiec,"REP","p" ,$PAK="T-".$Tto    ,"p<=".$Tto, 	"<b>Quartos:</b> menos de $Tto T0-$Tto");
     }
  }
}
  if(!$Tdata){
$i=-1;add_P_R_N_P_C_D($pripiec,"REP","p", $PAK="T todos", 	"1", 		"<b>Quartos:</b> T todos");
$i=0;add_P_R_N_P_C_D($pripiec,"REP","p", $PAK="T$i", 		"$i=p", 	"<b>Quartos:</b> T$i não quarto");
     add_P_R_N_P_C_D($pripiec,"REP","p", $PAK="T1-2",		"1<=p and p<=2","<b>Quartos:</b> $PAK");
$i=3;add_P_R_N_P_C_D($pripiec,"REP","p", $PAK="T$i-", 		"$i<=p", 	"<b>Quartos:</b> T$i ou mais de $i quartos");
  }
$prijard=(empty($_REQUEST['cmdname'])||$_REQUEST['cmdname']!="ja")&&(!empty($HASHcmds['ja'])?25000:30000);
if(@$_REQUEST['cmdname']=="ja" && preg_match('`^[0-9]+(-[0-9]*)?|-[0-9]*$`',$term)){$term='t'.$term;}
$Jdata=false;$Deb='';
$unit=Array("m\xb2"=>"","A"=>"1 Are = 100 m\xb2","Km"=>"1 Km\xb2 = 100 Ha","Ha"=>"1 Ha=100 Ares = 10 000 m\xb2",);
$unitz=Array('','','A','Km','Ha');
$unit['']=$unit["t"]=$unit["T"]=$unit["m"]=$unit["m\xb2"];
$unit['Kt']=$unit['kt']=$unit['KT']=$unit['kT']=$unit['KM']=$unit['kM']=$unit['km']=$unit['Km'];
$unit['a']=$unit['A'];
$unit['ha']=$unit['hA']=$unit['HA']=$unit['Ha'];
if(preg_match('`^[ ]*(?:[Tt](?:e(?:r(?:ra?)?)?)?:? ?)?(KT|[Kk]?t|[Hh]?[aA](?=re?s?\b|\b|(?=[0-9])))?[ ]*(?:(erra)[ ]*)?(?:(?:([0-9]+)([Kk]?)(-([0-9]*)([Kk]?)[Mm]?| *(?:ou *mai?s?|-?[ ]*[+]| ou men?o?s?))?)?|(-([1-9]*)([Kk]?)[Mm]?| *(?:ou *mai?s?|-?[ ]*[+]| ou men?o?s?))$)?`',$term,$Ag)
	&&(@$Ag[1]||preg_match('`(Ha|m(2|\xb2)?)$`',$term,$r)&&($Ag[1]=$r[1]))){
  $SpaceBoxed=(preg_match('`^((?:H?a(?:r(?:es?)?)?)|k?tk?[ ]*)?([0-9]{2,})(?:-([0-9]*))?(?:[ ]*(Ha?|ar?e?s?|t))?$`i',$term,$r)&&(@$r[1]||@$r[4])&&$r[2]?"*":"");
  $prijard=99998;
  $EU=$Ag[1];$K=preg_match('`K`i',$EU);$H=preg_match('`Ha`i',$EU);$Ares=(!$H&&preg_match('`a`i',$EU)?'a':'');$Terr=($K||$H||$Ares?"":"t");
  $more=preg_match('`[+a]`i',@$Ag[5]);
  $less=preg_match('`[e]`i',@$Ag[5].@$Ag[8]);
  ($Tto=($less?$Ag[3]:(isset($Ag[6])&&strlen($Ag[6])>0?$Ag[6]:(isset($Ag[9])&&strlen($Ag[9])>0?$Ag[9]:false)))) && ($Jdata=true);
  ($Frm=($less?0:(isset($Ag[3])&&strlen($Ag[3])>0?$Ag[3]:false))) && ($Jdata=true);
  if($less){$Tto=$Frm;$Frm="0";}
  $Pk="$Frm-$Tto";
  #($Tto=(isset($Ag[6])&&strlen($Ag[6])>0?$Ag[6]:(isset($Ag[9])&&strlen($Ag[9])>0?$Ag[9]:false))) && ($Jdata=true);
  #($Frm=(isset($Ag[3])&&strlen($Ag[3])>0?$Ag[3]:false)) && ($Jdata=true);
  #if($Frm&&$Tto&&($Lto=strlen($Tto))<($Lfr=strlen($Frm))){$Tto.=substr($Frm,$Lto,1);(($x=substr($Frm,0,$Lto+1)-$Tto)>=0)&&($Tto+=$x+1);$Tto.=substr('0000000000000',0,$Lfr-$Lto-1);$Deb.="/fr=$Frm/to=$Tto";}
  #if($Frm&&$Tto&&$Tto<$Frm){$Tto=$Tto*10;}
  #list($Frm,$Tto)=fixrange($Frm,$Tto);
  $Keu=(($K||!empty($Ag[4])||!empty($Ag[7])||!empty($Ag[10]))?"K":"");
  $ranges=fixranges($Frm,$Tto,$Keu,'yesless');
 for($i=0;$i<count($ranges);$i++){ 
  list($Frm,$Tto)=$ranges[$i];
  #$Keu&&($Frm!==false)&&($Frm=$Frm*1000);
  #$Keu&&($Tto!==false)&&($Tto=$Tto*1000);
  #$PAK=($Frm!==false?$Frm:"")."-".($Tto!==false?$Tto:"");
  if($Frm&&$Tto&&$Tto<$Frm){$Jdata=false;}
  $Ares&&($Frm!==false)&&($Frm=$Frm*100);$Ares&&($Tto!==false)&&($Tto=$Tto*100);
  $Keu&&($Frm!==false)&&($Frm=$Frm*1000);$Keu&&($Tto!==false)&&($Tto=$Tto*1000);
  $H&&($Frm!==false)&&($Frm=$Frm*10000);$H&&($Tto!==false)&&($Tto=$Tto*10000);
  #$PAK=($Frm!==false?$Frm:"")."-".($Tto!==false?$Tto:"");
  $PAK="$Frm-$Tto";

  $A=$H=$K=$U=$R='';

    ($H=((($Frm||$Tto)&&(!$Frm||preg_match('`0000$`',$Frm))&&(!$Tto||preg_match('`0000$|^$`',$Tto))&&($R='4'))?'Ha':''))
  #||($K=((($Frm||$Tto)&&!$H&&(!$Frm||preg_match('`000$`',$Frm))&&(!$Tto||preg_match('`000$|^$`',$Tto))&&($R='3'))?'Kt':''))
  #||($A=((($Frm||$Tto)&&!$H&&!$K&&(!$Frm||preg_match('`00$`',$Frm))&&(!$Tto||preg_match('`00$|^$`',$Tto))&&($R='2'))?'A':''))
  ||($U='t')
  ;
  $U=$U.$A.$K.$H; $U=($U?$U:'t');
  #if(!$KPAK){$KPAK=$U.$PAK;}
  $KPAK=$U.preg_replace(Array('`'.($R>'0'?'0':';').'{'.$R.'}(?=[^0-9]|$)`','`^[0 ]*-([0-9]+)$`','`[ ]*-$`'),Array('','$1 ou menos',' ou mais'),$PAK);
  if($Jdata && $Frm!=$Tto){
     $prijard=99999;
	add_P_R_N_P_C_D($prijard,"REP","ja"
	,$KPAK
	,($Frm?"$Frm<=ja":"").($Frm&&$Tto?" and ":"").($Tto?"ja<=$Tto":"")
	,"<b>Terra:</b> $KPAK (".preg_replace(Array('`\b([0-9]+)([0-9]{3})([0-9]{3})(?=[^0-9]|$)`','`\b([0-9]+)([0-9]{3})(?=[^0-9]|$)`'),Array("$1 $2 $3","$1 $2"),$PAK)
		." m\xb2 ".($U=='t'?"":" ".(@$unit[$U]?"<i><small>".$unit[$U]."</small></i> ":(($x=@$unitz[$R])?(($y=@$unit[$x])?$y:$x):"err:/$PAK/$U/$R/"))).').'.$SpaceBoxed.($SpaceBoxed="")#.$KPAK."=$PAK+|$Frm|$Tto|".$Deb
    	);
  }
}
}
  if(!$Jdata){
$i=1200;add_P_R_N_P_C_D($prijard,"REP","ja", $PAK="t$i ou menos",            "ja<=$i" ,        	"<b>Terra:</b> t-$i ou menos de $i m\xb2 ");
$i=2;add_P_R_N_P_C_D($prijard,"REP","ja", $PAK="Ha{$i}-".($j=$i+1),    "{$i}0000<=ja and ja<={$j}0000", "<b>Terra:</b> Ha $i-$j Ha (m\xb2: ".($i*10000)."-".($j*10000).")");
$i=400;add_P_R_N_P_C_D($prijard,"REP","ja", $PAK="t$i ou mais",           "{$i}<=ja",                "<b>Terra:</b> mais de $i m\xb2");
  }
if(false&&!$Jdata){
        list($x,$min,$max)=Array("Ha1-2",1,2);
        $min.="0000";$max.="0000";$PAK="$min-$max";
        add_P_R_N_P_C_D($prijard,"REP","ja"
        ,preg_replace(Array('`\b([1-9][0-9]{1,4}?)((?:00)?)(00)(?:m[2\xb2])?(?=[^0-9]|$)`e'),Array('"$1".("$2"?"Ha":"Ares")'),$PAK."m\xb2")
        ,"$min<=ja and ja<=$max"
        ,"terr : ".preg_replace('`\b([0-9]*)((?:[0-9]{3})*)([0-9]{3})(?=[^0-9]|$)`e','("$1"?"$1 $2 $3":("$2"?"$2 $1":"$1"))',$PAK)." m\xb2"
        );
}

$pribiens=(((@$_REQUEST['cmdname']!="BIENS")&&!empty($HASHcmds['BIENS']))?1000:20100);
	add_P_R_N_P_C_D(($x=preg_match('`^Ap(a(r(t(a(m(e(n(t(os?)?)?)?)?)?)?)?)?)?$`i',$term))?99999:$pribiens,"REP","BIENS" ,$PAK="Apartamento", "nat in(\"Appt\",\"Loft\",\"Dupl\",\"Trpl\",\"Surf\")"   ,"<b>Tipo:</b> Apartamento".($x&&strlen($term)>2?"*":""));
	add_P_R_N_P_C_D(($x=preg_match('`^Qu(i(n(t(as?)?)?)?)?$|^He(r(d(a(d(es?)?)?)?)?)?$|^Fa(z(e(n(d(as?)?)?)?)?)?$|^F[ea](r(ms?)?)?$`i',$term))?99999:($pribiens-1),"REP","BIENS" ,$PAK="Quinta",		"nat in(\"Ferm\")"   ,"<b>Tipo:</b> Herdade ou Quinta ou Fazenda".($x&&strlen($term)>3?"*":""));
	add_P_R_N_P_C_D(($x=preg_match('`(^Ca(s(as?)?)?$|^Mo(r(a(d(i(as?)?)?)?)?)?$)|^fa(z(e(n(da?)?)?)?)?$|^he(r(d(a(de?)?)?)?)?$|^vi(i(v(e(n(da?)?)?)?)?)?$`i',$term,$r))?99999:$pribiens,"REP","BIENS" ,$PAK="Casa",		"nat in(\"Mais\",\"Ferm\",\"Chal\",\"Mobi\")"   ,"<b>Tipo:</b> Moradia, Herdade e todos os tipos de casas...".($x&&@$r[1]&&strlen($term)>4?"*":""));
	add_P_R_N_P_C_D(($x=preg_match('`Ruinas?|^Ce(l(e(i(r(os?)?)?)?)?)?$`i',$term))?99999:($pribiens-1),"REP","BIENS" ,$PAK="Celeiro","nat in(\"Grng\",\"Surf\",\"Mobi\")"   ,"<b>Tipo:</b> Celeiros e outros bens diversos");
	add_P_R_N_P_C_D(($x=preg_match('`^Pr([eé](d(i(os?)?)?)?)?$`i',$term))?99999:$pribiens,"REP","BIENS" ,$PAK="Prédio",	"nat=\"Imbl\""   ,"<b>Tipo:</b> Prédio".($x&&strlen($term)>4?"*":""));
	add_P_R_N_P_C_D(($x=preg_match('`^Te(r(r(e(n(os)?)?)?)?)?$`i',$term))?99999:$pribiens,"REP","BIENS" ,$PAK="Terreno","nat=\"Terr\""   ,"<b>Tipo:</b> Terreno".($x&&strlen($term)>3?"*":""));
	add_P_R_N_P_C_D(($x=preg_match('`^Bu?i?([sz]i?(n(e(ss?e?s?)?)?)?)?$`i',$term))?99999:$pribiens,"REP","BIENS" ,$PAK="Business","nat=\"Comm\""   ,"<b>Tipo:</b> Business".($x&&strlen($term)>3?"*":""));
$priowner=(empty($_REQUEST['cmdname'])||$_REQUEST['cmdname']!="OWNER")&&(!empty($HASHcmds['OWNER'])?1000:20000);
	add_P_R_N_P_C_D(($x=preg_match('`^Pa(r(t(i(c(u(l(ar?e?s?)?)?)?)?)?)?)?$`i',$term))?99999:$priowner,"REP","OWNER" ,$PAK="Particular", "PART","<b>Anunciador:</b> Particular".($x&&strlen($term)>3?"*":""));
	add_P_R_N_P_C_D(($x=preg_match('`^Im(o(b(i(l(iá?(ri?a?s?)?)?)?)?)?)?$`i',$term))?99999:$priowner,"REP","OWNER" ,$PAK="Imobiliária","AGENCE" ,"<b>Anunciador:</b> Imobiliária".($x&&strlen($term)>4?"*":""));
	#add_P_R_N_P_C_D($priowner,"REP","OWNER" ,$PAK="Imobiliária e Particular","1" 	 ,"<b>Anunciador:</b> Todos");

$pritrans=(empty($_REQUEST['cmdname'])||$_REQUEST['cmdname']!="e")&&(!empty($HASHcmds['e'])?1000:20000);
	add_P_R_N_P_C_D(($x=preg_match('`^(V(e(n(d([ea]r?)?)?)?)?)?$`i',$term,$Ag)&&(@$Ag[1]||@$Ag[8]))?99999:$pritrans,"REP","e" ,$PAK="Vender", "VENTES","<b>Transação:</b> Venda".($x&&strlen($term)>3?"*":""));
	add_P_R_N_P_C_D(($x=preg_match('`^((A(l([ue](g([ae][sr]?([- ](se?)?)?)?)?)?)?)?|(Ar?)?R(e(n(d([ea]r?)?)?)?)?)?$`i',$term,$Ag)&&(@$Ag[1]||@$Ag[8]))?99999:$pritrans,"REP","e" ,$PAK="Arrendar", "LOCATIONS","<b>Transação:</b> Aluga-se - Arrendar".($x&&strlen($term)>4?"*":""));
	add_P_R_N_P_C_D(($x=preg_match('`^(P(r(o(c(u(r(ar?)?)?)?)?)?)?|C(o(m(p(r(a(d(o(r(es?)?)?)?)?)?)?)?)?)?)?$`i',$term,$Ag)&&(@$Ag[1]||@$Ag[8]))?99999:$pritrans,"REP","e" ,$PAK="Compradores", "ACHETEURS","<b>Transação:</b> Procura - anúncios dos compradores".($x&&strlen($term)>4?"*":""));
$pridate=(empty($_REQUEST['cmdname'])||$_REQUEST['cmdname']!="date")&&(!empty($HASHcmds['date'])?20000:30000);
$RgxDat='(?<=[DdJj]|\b)(0?[1-9]|[12][0-9]|3[01])/(0?[1-9]|1[012])?';#(/(?:20)?('.sprintf("(%02u|%02u)",date("y")-1,date("y")).'))?';
$RgxDat='(0[1-9]|[12][0-9]?|3[01]?|[4-9])/(0[1-9]|1[012]?|[2-9])?';#(/(?:20)?('.sprintf("(%02u|%02u)",date("y")-1,date("y")).'))?';
	if(($x=preg_match('`^[DdJj][0-9]+([-/][0-9]+)*[-/]?(?:[DdJj][ayieour]s?)?$|^[0-9]+(/[0-9]{0,2})`',$term))){$pridate=99999;}
	#if(preg_match('`([0-9]{1,2})/([0-9]{1,2})?`',$term)){$pridate=99999;}
  $d2=date("d",time());
  $m2=date("m",time());
  $y2=date("y",time());
  $y4=date("Y",time());
  $m2d2="$m2-$d2";
function submon($m,$nm){return sprintf("%02u",$m-$nm+($m>$nm?0:12));}
function addmon($m,$nm){return sprintf("%02u",$m+$nm+($m+$nm<=12?0:-12));}
#if(preg_match('`[DdJj]?([12][0-9][0-9]?|36[0-5]|3[0-5][0-9]|3[0-9]?|[4-9][0-9]?)`',$term,$Ag)){
#	add_P_R_N_P_C_D($pridate,"REP","date" ,$PAK=$Ag[1]."Dias",	"21J<=date"   ,"<b>Desde:</b> publicado desde ".$Ag[1]." dias");
#}elseif(preg_match('`'.$RgxDat.'(-(([0-9])$|(0?[1-9]|[12][0-9]|3[01])(/(0)$|(0?[1-9]|1[012]))?)?)`',$term,$Ag)){
#}
$DoneDates=0;
if(preg_match('`(0[1-9]|[12][0-9]?|3[01]?|[4-9])/(0[1-9]|1[012]?|[2-9])?(?:-(0[1-9]|[12][0-9]?|3[01]?|[4-9])(?:/(0[1-9]|1[012]?|[2-9])?)?)?`i',$term,$Ag)){
	$pridate=99999;
  $d0=sprintf("%02u",$Ag[1]);
  $d1=sprintf("%02u",!empty($Ag[3])?$Ag[3]:0);
  $m0=sprintf("%02u",!empty($Ag[2])?$Ag[2]:($d2>16?$m2:submon($m2,1)));
  $m1=sprintf("%02u",!empty($Ag[4])?$Ag[4]:0);
  $m =sprintf("%02u",!empty($Ag[4])?$Ag[4]:($m0?(($d0&&$d0<16||$m0==$m2)?$m0:addmon($m0,1)):$m2));
  $m0=sprintf("%02u",$m0?$m0:($d0>$d1?submon($m,1):$m));
  $m1=sprintf("%02u",!empty($Ag[4])?$Ag[4]:(($d0<$d1||$m0>=$m2)?$m0:addmon($m0,1)));
  if($d0>0 && $d1>0 && $m0>0){ $DoneDates=1;
	add_P_R_N_P_C_D($pridate,"REP","date" ,$PAK="$d0/$m0-$d1/$m1", "\"$PAK\"<=date"   ,"<b>Desde:</b> $d0/$m0 a $d1/$m1 (publicado entre $d0/$m0 e $d1/$m1).*");
  }
}
if(!$DoneDates && preg_match('`^[DdJj]?'.$RgxDat.'-?$`i',$term,$Ag)){
	$pridate=99998;
	$D0=sprintf("%01u/%01u",$d0,$m0);
	$I=sprintf("%02u-%02u",$m0,$d0);$D=sprintf("20%02u-%02u-%02u",$I>$m2d2?$y2-1:$y2,@$Ag[2],$Ag[1]);
	$tim0=strtotime($D);
	$tim1=(time()-$tim0>86400*15?86400*15+$tim0:time());
	$D1=preg_replace('`\b0+`','',date("d/m",$tim1));
	#add_P_R_N_P_C_D($pridate,"REP","date" ,$PAK="$D0-$D1",              "\"$PAK\"<=date"   ,"<table class=syh1e style=\"width:100%\"><tr><td style=\"width:90%\"><b>Desde:</b> $D0 a $D1 A- publicado entre $D0 e $D1&nbsp;</td><td style=\"text-align:right;width=10%\">".($C_Debug?"&lt;":"<")."img class=datepicker src=\"/body_a/pencil.png\"></td></tr><table>");
	add_P_R_N_P_C_D($pridate,"REP","date" ,$PAK="$D0-$D1",              "\"$PAK\"<=date"   ,"<b>Desde:</b> $D0 a $D1. Publicado entre $D0 e $D1 *");
}
elseif(preg_match('`^([1-9][0-9]{0,2}) *(?:(D(ia?)?|J(o(ur?)?)?))?$`i',$term,$Ag)
		&&(($D=$Ag[1])<=365)&&((preg_match('`^[DJ]`i',@$Ag[2])&&($pridate=99999))||true)){
	add_P_R_N_P_C_D($pridate,"REP","date" ,$PAK="$D Dias",              "{$D}J<=date"   ,"<b>Desde:</b> $PAK. Publicado desde $PAK ".(@$Ag[2]?"*":""));
}
else{
	add_P_R_N_P_C_D($pridate,"REP","date" ,$PAK="21 Dias",		"21J<=date"   ,"<b>Desde:</b> Anúncios publicados há 21 dias ou menos (padrão)");
}
#if(preg_match('`'.$RgxDat.'(-(([0-9])$|(0?[1-9]|[12][0-9]|3[01])(/(0)$|(0?[1-9]|1[012]))))`',$term,$Ag)){
	#$D0=sprintf("%02u/%02u",$Ag[1],$Ag[2]);
	#$D1=sprintf("%02u/%02u",$Ag[6],$Ag[9]);
#if(preg_match('`^[DdJj]?'.$RgxDat.'-'.$RgxDat.'`i',$term,$Ag)){
#	$pridate=99999;
#	$D0=sprintf("%01u/%01u",$d0,$m0);
#	$D1=sprintf("%01u/%01u",$d1,$m1);
#	#add_P_R_N_P_C_D($pridate,"REP","date" ,$PAK="$D0-$D1",              "\"$PAK\"<=date"   ,"<b>Desde:</b> $D0 a $D1 B- publicado entre $D0 e $D1");
#}

############# impossible date ################################
#elseif(preg_match('`'.$RgxDat.'(-(([0-9])$|(0?[1-9]|[12][0-9]|3[01])(/(0)$|(0?[1-9]|1[012]))?)?)`',$term,$Ag)){ if((!@$Ag[4]||$Ag[4]==$y2) && @$Ag[2]<$m2 && @$Ag[8]&& @$Ag[9]){ $a_json_row["PAK"]=sprintf("%02u/%02u-%02u/%02u",$Ag[1],$Ag[2],$Ag[8],$Ag[9]); } elseif((!@$Ag[4]||$Ag[4]==$y2) && @$Ag[2]<$m2 && @$Ag[8]          ){ $a_json_row["PAK"]=sprintf("%02u/%02u-%02u/%02u",$Ag[1],$Ag[2],$Ag[8],$Ag[1]+($Ag[8]>$Ag[1]?0:1),$Ag[2]); } if((!@$Ag[4]||$Ag[4]==$y2) && @$Ag[2]<$m2){ $a_json_row["PAK"]=sprintf("%02u/%02u-%02u/%02u",$Ag[1],$Ag[2],$Ag[8],$Ag[9]); } if(preg_match('`^([0-9])$|(0?[1-9]|[12][0-9]|3[01])(/(0)$|(0?[1-9]|1[012]))?`',$term,$Ag)){ if(!empty($Ag[2])){ $wacjnaweocj=0; }else{ $wacjnaweocj=0; } } }
############# searchdb ville ################################
$priasr=(empty($_REQUEST['cmdname'])||$_REQUEST['cmdname']!="asr")&&(!empty($HASHcmds['asr'])?20000:30000);
if(preg_match('`^(eleva?d?o?r?:? ?)?(?:(n[aã]o|sem)|(com))?(?(1)| eleva?d?o?r?)$`',$TERMdeac,$Ag)){
	!@$Ag[3]&&add_P_R_N_P_C_D($priasr+40000,"REP","asr" ,$PAK=(@$Ag[2]?"sem ":"")."elevador",              "asr".(@$Ag[2]?"":"!")."=\"sans\""   ,"<b>Elevador:</b> ".(@$Ag[2]?"sòmente anúncios sem elevador":"anúncios que não dizem que não há elevador"));
	(@$Ag[3]||!@$Ag[2])&&add_P_R_N_P_C_D($priasr+40000,"REP","asr" ,$PAK="com elevador",              "asr=\"asc\""   ,"<b>Elevador:</b> sòmente anúncios com elevador");
}

function searchdb($ex){
  global $PAYS,$a_json,$Cnt,$cmds,$HASHcmds,$term,$isodate,$sid,$nom,$grp,$cnx,$top,$mel,$tel,$err_discon,$HTTP_HOST,$C_Debug,$dblink,$dblink2,$dblink3,$dblink4;
  global $STATICSCNX;
  $Cntselect=0;
  if(empty($dblink)&&empty($dblink2)&&empty($dblink3)&&empty($dblink4)){print "ERREUR PAS DE DB\n";exit;}
  if(!isset($STATICSCNX)){
    $STATICSCNX=1;#sprintf("%08x-%s",crc32($HTTP_USER_AGENT.$HTTP_ACCEPT.$HTTP_ACCEPT_LANGUAGE),$ip);
    #$pawd=date('Y-m-d').substr($STATICSCNX,0,8).$grp.$nom.($s?$awd:md5($awd));$ckwe=time();
    #$cnx=md5($pawd);
    if(!($sid&&$nom&&$grp&&$cnx
	&&($sq="select id "
        .",md5(concat(\"$isodate\",MID(s.scnx,1,8),s.ssup,s.snom,s.sa)) as c "
        .",top,sp1 as mel,stelp as tel "
        ." from sup as s "
        ." where id=$sid and "
        .(false||((getenv('HTTP_HOST')=='127.0.0.1')&&($cnx=1))
                ?"1"
                :""
                        ."snom=\"$nom\" and ssup=\"$grp\" and "
                        ."FIND_IN_SET(\"$cnx\","
                        ."concat("
                        ."md5(concat(\"$isodate\",MID(s.scnx,1,8),s.ssup,s.snom,s.sa)),"
                        ."\",\","
                        ."md5(concat(\"$isodate\",MID(s.scnx,1,8),s.ssup,s.snom,md5(concat(s.sp,\",fromenter=1\"))))"
                        .")"
                .")"
        ))
	&&($C_Debug&&(print $sq."<BR>\n")||true)
	&&(($r=my_query($sq))&&is_resource($r)||$C_Debug&&(print "sid=$sid, selectim: r n'est pas une ressource, type=".gettype($r)." r='$r'<BR>\nMsg frm my_:".my_error()."\n<BR>\nMsg frm MYSQL:".mysql_error()."<BR>\n")&&false)
                &&($row = mysql_fetch_array($r,MYSQL_ASSOC))
                && is_array($row)
                &&(@$row['id']==$sid)
		&&(($top=@$row['top'])||true)
		&&(($mel=@$row['mel'])||true)
		&&(($tel=@$row['tel'])||true)
    )){
	$I="";
	$a_json=Array();
	add_P_R_N_P_C_D("99999","REP","DISCON",$x=$err_discon,"1","<div class=sys14>&nbsp;$x&nbsp;&nbsp;</div>"
	); 
	finish();
	exit;
    }
    add_P_R_N_P_C_D("00000","REP","DISCON",$x="conexão ativa","1","<span style=\"text-align: right;color:#373\">$x</span>"); 
  }
  if($C_Debug){print "searchdb PAYS=$PAYS term=/$term/ cmds=/$cmds/<BR>\nex=$ex<BR>\n\n";}
  if($rs = my_query($ex)){
  $pndiv="<div class=\"sys9 syh12 syi12\">";$labelcpn=utf8("Designação Postal ");
  $libtnex="<div class=\"divin exbtn\" title=\"".utf8("Excluir este codigo postal")."\">";$labelex="X";$libtnclose="</div>";
  $libtnre="<div class=\"divin rebtn\" title=\"".utf8("Substituí-lo como a localizacão")."\">";$labelre="R";
  $Localidade='';

  while($row = mysql_fetch_array($rs,MYSQL_ASSOC)){
    
    $a_json_row=Array();++$Cntselect;$a_json_row["dis"]='';$Fbpref='';
	$a_json_row['cmdname']='ville';
    if(!isset($PAYS) or $PAYS=="pt"){

      $CPDISPLAY = preg_replace('`[.]`','-',@$row['cp']);
      $CP        = preg_replace('`[-]([0-9]{0,2}|[0-9]{5,})$`','',$CPDISPLAY);
      $CN=@$row['cn'];$cn=mb_strtolower($CN,"iso-8859-15");
      $DETAILS="";
      $TodoCN=false;$DNinfo="";
      $a_json_row["dis"].= ($CPDISPLAY?$CPDISPLAY:"").($CPDISPLAY && $CN?" ":"").utf8(@$row['cn'].' ('.($DNinfo=@$row['dn']).')'); 
      $DNinfo && ($CP || ($TodoCN=true) && false)&& $DNinfo="";
      
      $DNcode=($DNinfo?"("
	.((($x=strlen($DNinfo))==($y=24))
	?substr($DNinfo,0,1)
       	:($x==$y+1?substr($DNinfo,0,2)   
       	:($x>$y+1?substr($DNinfo,0,1).".":""))).substr($DNinfo,-$y+1).")":"");

      if($CN && !$CP && !@$row['cpn']){$a_json_row["dis"]="<b class=bpref>Concelho: </b>".$a_json_row["dis"];}
      elseif($CP && @$row['ref']&&($Localidade=@$row[$row['ref']])){$a_json_row["dis"]="<b class=bpref>Localidade:</b> <b>".$Localidade."</b> ".$a_json_row["dis"];}
      elseif($CP){$Fbpref="<b class=bpref style=\"display:none\">cp: </b>";}#$a_json_row["dis"]="<b class=bpref>cp: </b>".$a_json_row["dis"];}

      $C_Debug && (print $a_json_row["dis"]."<BR>CPDISPLAY\"$CPDISPLAY\",CP=\"".@$row['cp']."\"<BR>\n");

      $a_json_row['cmd'] = 'ville="'.($CP?($CP && @$row['ref']&&$Localidade?$CP.'" and MOT="`'.str_replace('-',' ',$Localidade).'`':'"'.$CP):($CN?utf8(str_replace(' ','-',$CN)):'')).'"';
      $Fdiv="";
      if($x=utf8(@$row['cpn'])){$a_json_row["dis"].= ($Fdiv=$pndiv).$labelcpn.$x;}
      if(($x=utf8(@$row['ppn'])) && (mb_strtolower($row['ppn'],"iso-8859-15") != mb_strtolower(@$row['cpn'],"iso-8859-15"))){
          $a_json_row["dis"].= ($Fdiv?" ":($Fdiv=$pndiv)).$x;
         $DETAILS=$row['ppn'];
      }
      if($Fdiv){$a_json_row["dis"].= "</div>";}

      if($x=utf8(@$row['aa'])){
          $a_json_row["dis"].= $pndiv.$x."</div>";
         (strlen($CP)==8) && $DETAILS=$row['aa'];
      }
      $details=mb_strtolower($DETAILS,"iso-8859-15");
      $ZONE=($CP?$CP:$CN);$zone=mb_strtolower($ZONE,"iso-8859-15");
      $NAMES=($DETAILS && ($details!=$zone)?$DETAILS:($CN && $cn!=$zone?$CN:""));

      $a_json_row["PAK"] = utf8(($Localidade&&$CP?"$Localidade $CP $CN":preg_replace('`\b[ ]\b`','-',$ZONE.$DNcode).($NAMES?" ":"").preg_replace('`\b[ ]\b`','-',$NAMES)));
      if($CN && $CP && (!$DETAILS||$details==$cn)){$a_json_row["dis"].=$pndiv."Solo $CP no concelho $CN</div>";}

      if((strlen($CP)==8)# && (preg_match('`ville="(?:(?![0-9]{4}\b)[^\x22])*(?:[0-9]{4}[^-]|")`',@$HASHcmds['ville']))
       ||(strlen($CP)==4)# && (preg_match('`ville="(?:(?![0-9]{4}\b)[^\x22])+"`',@$HASHcmds['ville'])))
      ){
	 $a_json_row["dis"]=$Fbpref
#."<table style=\"display:inline\"><tr><td><div class=\"rebtn sys9 syh12 syi12\" title=\"".utf8("Substituí-lo como a localizacão")."\">S</div>" ."<div class=\"exbtn sys9 syh12 syi12\" title=\"".utf8("Excluir este codigo postal")."\">X</div></td><td>"
	.$a_json_row["dis"]
#	."</td></tr></table>"
	;
      }#elseif((strlen($CP)==4) && (preg_match('`ville="(?:(?!\b[0-9]{4}\b)[^\x22])*(?:\b[0-9]{4}\b)`',@$HASHcmds['ville']))){
	 #$a_json_row["dis"]="<table><tr><td><div class=\"rebtn sys9 syh12 syi12\" title=\"".utf8("Substituí-lo como a localizacão")."\">S</div>" ."<div class=\"exbtn sys9 syh12 syi12\" title=\"".utf8("Coloque na pesquisa")."\">+</div></td><td>".$a_json_row["dis"]."</td></tr></table>";
      #}
      if(($x=@$row['pri'])){$a_json_row["pri"] = utf8(strtolower(($CPDISPLAY==$term||($CP!=$CPDISPLAY&&($l=strlen($term))>4&&substr($CPDISPLAY,0,$l)==$term))?99999:$x));}

    }else{ $a_json_row["dis"] = utf8(@$row['de'].' ('.@$row['dep'].')'); }
    $a_json_row["REP_APP_XCL"]=(isset($a_json_row["REP_APP_XCL"])?$a_json_row["REP_APP_XCL"]:"REP");
    add_P_R_N_P_C_D($a_json_row["pri"],$a_json_row["REP_APP_XCL"],$a_json_row["cmdname"],$a_json_row["PAK"],$a_json_row["cmd"],$a_json_row["dis"]);
    $C_Debug && (print "$Cnt dis=\"".$a_json_row["dis"]."\"<BR>\n$Cnt<BR>\n".preg_replace('`(?=\r?\n)`','<BR>',print_r($a_json_row,true)."\n")
	.@$row['den'].",m=".@$row['m']." =Z=$ZONE=N=$NAMES=======<BR>\n");
  }
  }elseif($rs === false) {
    $user_error = 'Wrong SQL: ' . $ex . 'Error: ' . my_error() . ' ';
    trigger_error($user_error, E_USER_ERROR);
  }
  return $Cntselect;
}
############# END searchdb ville #########################################
$switchcp = "no";

#$R2c="(?i:A[bglmnrvz]|B[aeor]|C[aehioru]|E[lnsv]|F[aeioru]|G[aoru]|H[o]|[IÍ][dl]|L[aeio]|M[aeéiou]|N[aeio]|O[bdeluv]|P[aeior]|R[ei]|S[aãeio]|T[aeor]|V[aeio])";
if(!(empty($dblink)&&empty($dblink2)&&empty($dblink3)&&empty($dblink4))){
    if(preg_match('`^[A-ZÀ-Üa-zà-ÿ]+([- ][A-ZÀ-Üa-zà-ÿ]+)*[- ]?$`',$term)&&strlen($term)>4){
      $te=str_replace('-',' ',$term);
      searchdb("select distinct dn,cn,floor(cp)as cp,ppn,cpn,den,if(ppn=\"$te\",99000+den,50000+den) as pri,\"ppn\"as ref from ptcp left join ptcd on dci=ci where ppn like \"$te%\" and ppn!=cn group by den desc,dn,cn,floor(cp),ppn,cpn limit 20")
	||
      searchdb("select distinct dn,cn,floor(cp)as cp,ppn,cpn,den,if(cpn=\"$te\",99000+den,50000+den) as pri,\"cpn\"as ref from ptcp left join ptcd on dci=ci where cpn like \"$te%\" and cpn!=cn and cpn!=ppn group by den desc,dn,cn,floor(cp),cpn,ppn limit 20");
    }
}

    $term=(@$_REQUEST['cmdname']=="MOT"?"":$TERMdeac);
if(strlen($term)==2 && preg_match('`^'.$R2c.'$`',$term)){
      searchdb($ex="select distinct ci,dn,cn,den,if(\"$term\"=cn,90000,70000)+den as pri from ptfast where cn like \"$term%\"");
}elseif(!empty($Agcp[1])&&($cp=$Agcp[1].(isset($Agcp[2])?".".$Agcp[2]:""))){
    $switchcp = "LONG CP";
    if(strlen($cp)==8){
      searchdb("select distinct dn,cn,cp,ppn,aa,cpn,den,19000+den/10".($cnal?"-18500":"")." as pri from ptcp left join ptcd on dci=ci where cp=\"$cp\" $cp4s $cnal order by den desc limit 20");
    }elseif(strlen($cp)==7){
      searchdb("select distinct dn,cn,cp,ppn,aa,cpn,den,100+den/10 as pri from ptcp left join ptcd on dci=ci where cp >=\"{$cp}0\" and cp<\"".($term +1)."0\" $cp4s $cnal order by den desc limit 20");
    }elseif(strlen($cp)==6){
      searchdb("select distinct dn,cn,cp,ppn,aa,cpn,den,100+den/10 as pri from ptcp left join ptcd on dci=ci where cp >=\"{$cp}00\" and cp<\"".($term +1)."00\" $cp4s $cnal order by den desc limit 50");
    }elseif(strlen($cp)==4){
      searchdb("select distinct dn,cn,floor(cp)as cp,den,1500+den/10 as pri from ptcp left join ptcd on dci=ci where floor(cp)=\"$cp\" $cnal order by den desc limit 20");
    }elseif(strlen($cp)==3){
      searchdb("select distinct dn,cn,floor(cp)as cp,den,1400+den/10 as pri from ptcp left join ptcd on dci=ci where floor(cp)>=\"{$cp}0\" and floor(cp)<\"".($term +1)."0\" $cnal order by den desc limit 50");
    }elseif(strlen($cp)==2){
      searchdb("select distinct dn,cn,floor(cp)as cp,den,1400+den/10 as pri from ptcp left join ptcd on dci=ci where floor(cp)>=\"{$cp}00\" and floor(cp)<\"".($term +1)."00\" $cnal order by den desc limit 50");
#    }else{
#      searchdb("select distinct dn,cn,floor(cp)as cp,den from ptcp left join ptcd on dci=ci where floor(cp) like \"$term%\" order by den desc limit 10");
    }
}elseif(strlen($term)>2 && !empty($Agloc[1]) && !preg_match('`^(vista|art) `i',$term)){

  if($cp4s||$cnal){
      searchdb("select distinct dn,cn,if(ppn!=cn,ppn,\"\")as ppn,aa,if(cpn!=cn and cpn!=ppn,cpn,\"\")as cpn,cp"
        .",den,match(ppn,aa,al,cpn,cli) against(\"$term\") as m,".($cp4s?"27":($cnal?"20":""))."200+den/100+50*match(ppn,aa,al,cpn,cli) against(\"$term\") as pri "
        ."from ptcp left join ptcd on dci=ci where match(ppn,aa,al,cpn,cli) against(\"$term\") $cnal $cp4s order by den desc limit 200");
    if($termlower!=$cnallower){
      searchdb("select distinct dn,cn,if(ppn!=cn,ppn,\"\")as ppn,aa,if(cpn!=cn and cpn!=ppn,cpn,\"\")as cpn,cp"
        .",den,".($cp4s?"17":($cnal?"10":""))."200+den/100 as pri "
        ."from ptcp left join ptcd on dci=ci where ppn like \"$term%\" $cnal $cp4s order by den desc limit 200")
      ||
      searchdb("select distinct dn,cn,if(ppn!=cn,ppn,\"\")as ppn,aa,if(cpn!=cn and cpn!=ppn,cpn,\"\")as cpn,cp"
        .",den,".($cp4s?"17":($cnal?"10":""))."200+den/100 as pri "
        ."from ptcp left join ptcd on dci=ci where cpn like \"$term%\" $cnal $cp4s order by den desc limit 200");
      searchdb("select distinct dn,cn,if(ppn!=cn,ppn,\"\")as ppn,aa,if(cpn!=cn and cpn!=ppn,cpn,\"\")as cpn,cp"
        .",den,".($cp4s?"17":($cnal?"10":""))."200+den/100 as pri "
        ."from ptcp left join ptcd on dci=ci where aa like \"$term%\" $cnal $cp4s order by den desc limit 200");
    }
  }

  if(preg_match('`^'.$R2c.'`',$term)){
  $cnterm=true;$cnfound=0;$term=str_replace('-',' ',$term);$term=preg_replace('` *\x28.*`','',$term);
  if(preg_match('`^[a-zA-Zà-ÿÀ-Ü]{3}$`',$term)){
      $cnfound=searchdb($ex="select distinct ci,dn,cn,den,70000+den as pri from ptfast where cn like \"$term%\"");
  }elseif(preg_match('`^[a-zA-Zà-üÀ-Ü]{3}[a-zA-Zà-üÀ-Ü ]{1,3}$`',$term)){
      $cnfound=searchdb($ex="select distinct ci,dn,cn,den,if(cn=\"$term\",99999,79990+den) as pri from ptfast where cn like \"$term%\"");
  }elseif(strlen($term)>6){
      $cnfound=searchdb($ex="select distinct ci,dn,cn,den,if(cn=\"$term\",99999,80999+den) as pri from ptfast where cn like \"$term%\"");
  }
  if($cnfound && !($cp4s||$cnal)){
      searchdb("select distinct ptfast.cn,ptfast.dn,cpn,floor(cp) as cp,den,den/5+if(ptfast.cn=\"$term\",30000,28000)as pri from ptfast left join ptcp on dci=ci where ptfast.cn like \"$term%\" order by den desc limit 20");
  }
  }
  if(!($cp4s||$cnal)){
      searchdb("select distinct dn,cn,if(ppn!=cn,ppn,\"\")as ppn,aa,if(cpn!=cn and cpn!=ppn,cpn,\"\")as cpn,cp"
	.",den,match(ppn,aa,al,cpn,cli) against(\"$term\") as m,".($cp4s?"25":"")."200+den/100+500*match(ppn,aa,al,cpn,cli) against(\"$term\") as pri "
	."from ptcp left join ptcd on dci=ci where match(ppn,aa,al,cpn,cli) against(\"$term\") $cp4s order by den desc limit 200");
  }
}

finish();

?>
