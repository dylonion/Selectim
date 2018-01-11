<?php
#+++++++==explain section
#!!!!!!!==Fix section
$Versiondbs=2;
$z=0;$dbsfile="../bin/dbs$Versiondbs.php";
$PAYS=(@$_REQUEST['PAYS']?@$_REQUEST['PAYS']:'fr');
$cmdname=(!empty($_REQUEST['cmdname'])?$_REQUEST['cmdname']:"");
$isodate=date('Y-m-d');
$GoDB=false;
$C_DS=0;
$C_Debug=@$TSid&&@$_GET['debug'];#$Deb="";
$user_error='';
$err_discon="Ooops! Vous êtes déconnecté - Merci de vous reconnecter";
$sid=$SNOM=$nom=$SCNX='';
$DoThis="INIT";require $dbsfile;
$a_json = array();
$b_json = array();
$a_json_row = array();
$a_json_invalid = array(array("id" => "#", "value" => "json_invalid", "label" => "Only letters and digits are permitted..."));
$json_invalid = json_encode($a_json_invalid);
$R2c="(?i:A[bglmnrvz]|B[aeor]|C[aehioru]|E[lnsv]|F[aeioru]|G[aoru]|H[o]|[IÍ][dl]|L[aeio]|M[aeéiou]|N[aeio]|O[bdeluv]|P[aeior]|R[ei]|S[aãeio]|T[aeor]|V[aeio])";
$R2cFrLoc="(?i:A[A-DF-JL-PR-Z]|B[AEILORUY]|C[AEHILORUY]|D[- 'AEHIORUYZ]|E[A-IL-VXYZ]|F[AEILORUY]|G[AEHILORUY]|H[AEIOUY]|I[BCDFGHLMNPRSTVWZ]|J[AEOU]|K[AEILNORU]|L[- 'AEHILOUY]|M[- 'AEHIOUY]|N[AEIOUY]|O[B-IL-PR-VXYZ]|P[AEFHILORUY]|QU|R[AEHIOUY]|S[ACEILMOPQTUY]|T[AEHIORSU]|U[aBCEFGHLMNPRSTVXZ]|V[AEIORUY]|W[AEIOUY]|X[AEIOUY]|Y[AC-GMO-VZ]|Z[AEIOU])";
$R2cFrLoc4="(?i:A[A-DF-JL-PR-Z]|B[AEILORUY]|C[AEHILORUY]|D[- 'AEHIORUZ]|E[A-IL-VXYZ]|F[AEILORU]|G[AEHILORUY]|H[AEIOUY]|I[BCDFGHLMNPRSTVWZ]|J[AEOU]|K[AEILNORU]|L[- 'AEHILOUY]|M[- 'AEHIOUY]|N[AEIOUY]|O[B-IL-PR-VXYZ]|P[AEFHILORUY]|QU|R[AEHIOUY]|S[ACEILMOPQTUY]|T[AEHIORSU]|U[aBCEFGHLMNPRSTVXZ]|V[AEIORUY]|W[AEIOUY]|X[AEIOU]|Y[AC-GMO-VZ]|Z[AEIOU])";
$Support=!empty($_REQUEST['description'])||!empty($_REQUEST['respond'])||!empty($_REQUEST['supportlist'])||!empty($_REQUEST['unviewed'])||!empty($_REQUEST['viewed'])||!empty($_REQUEST['close'])||!empty($_REQUEST['support']);
$Bookmarks=!empty($_REQUEST['bookmark'])||!empty($_REQUEST['bookmarks']);
#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

function finish(){
	global $a_json,$b_json;$a_json=array_merge($a_json,$b_json);static $DeS;
	$x=Array();
	$z=Array();
#  $pritab=Array();$prii=Array();$pritabmax=3;$priM=-1;$prI=-1;
#  for($i=0;$i<count($a_json);$i++){
#        #for($j=0;$j<$pritabmax;$j++){ if(@$pritab[$j]<$json[$i]['pri']){$prii[$j]=$i;$pritab[$j]=$json[$i]['pri'];} }
#          if($priM<$json[$i]['pri']){$priI=$i;$priM=$json[$i]['pri'];}
#  }
#  if(@$a_json[5]){$a_json[5]['dis']=preg_replace('`(?:/.* tada)?(</td></tr>)`','/'.$priI.'-'.$priM.' tada$1',$a_json[5]['dis']);}
	for($i=0;$i<count($a_json);$i++){
		while(list($k,$v) = each($a_json[$i])){

  if(isset($_REQUEST['De'])&&$k=='dis'){print (isset($DeS)?"":
'<html><head><style type="text/css"><script type="text/css">
//<!--
HTML,BODY {margin:0;padding:0;}
BODY {  
                color:#666666;
                overflow:none;
                font-family:Arial, Verdana;
                font-size: 10px;
                margin:0 0 0 0;
                padding:0px 0 0 0;
}
TABLE { #border-width:4px;
}
td {            font-size: 12px;
                border:solid;
                border-width:1px;
                border-color:#900;
}
//-->
</style>
'
."</head><body><table style=\"border:solid;border:color:#600\">").preg_replace('`(</td></tr>)`',".{$a_json[$i]['pri']}.$i$1\n",$v);
@$DeS++;
}

			#print "$i,$k,$v=<BR>\n";
			if(is_string($v)){$a_json[$i][$k]=mb_convert_encoding($v,"UTF-8","ISO-8859-15");}#utf8_encode($v);}
			#print "$i,$k,".$a_json[$i][$k]."|<BR>\n";
			}
  	}
	if(isset($_REQUEST['De'])){print "</table></body></html>\n";exit;}
	 print json_encode($a_json);
	exit;
} 
function Certain($n='?'){static $D,$C;if($n!='?'){$C=$n;return true;}elseif(!empty($C)&&!isset($D)){$D=true;return $C;}else{return '';}}
function upperrangeratio($v,$r=1.5){return (($Z=(preg_match('`(0*)$`',$v,$z)?'1'.$z[1]:'1'))?round($r*$v/$Z)*$Z:'Error');}
function upperrange($v,$r=1.5){return (($Z=(preg_match('`(0+)$`',$v,$z)?'1'.$z[1]:false))?$v+($r>1?$Z:-$Z):false);}
function lowerrange($v,$r=0.5){return (($Z=(preg_match('`(0+)$`',$v,$z)?'1'.$z[1]:false))?$v+($r>1?$Z:-$Z):false);}
function formatnum($x,$s=' ',$d=','){return number_format($x,0,$d,$s);}
function format2num($x,$y,$s=' ',$d=','){return number_format($x,0,$d,$s).'-'.number_format($y,0,$d,$s);}
function formatrange($PAK,$u=''){$u=$u?" $u":"";return preg_replace(
	Array('`\b([0-9]+)([0-9]{3})([0-9]{3})(?=[^0-9]|$)`'
		,'`\b([0-9]+)([0-9]{3})(?=[^0-9]|$)`'
		,'`^[0 ]*-([0-9]+)$`'
		,'`-$`'
	),Array("$1 $2 $3"
		,"$1 $2$u"
		,"$1$u ou moins"
		,"$u ou plus"
	),$PAK);}
function fixrange($Frm,$Tto){
	global $Deb;
	if($Frm&&$Tto&&($Lto=strlen($Tto))<($Lfr=strlen($Frm))){
		if($Tto==substr($Frm,0,$Lto)){
			$Tto.=substr($Frm,$Lto,1);
			(($x=substr($Frm,0,$Lto+1)-$Tto)>=0)&&($Tto+=$x+1);
		}
		$Tto.=substr('0000000000000',0,$Lfr-$Lto-1);
		if($Frm&&$Tto&&$Tto<$Frm){$Tto=$Tto*10;}
		#$Deb.="/fr=$Frm/to=$Tto";
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
	list($Frm,$Tto)=kilo($Frm,$Tto,$K);
		if(!$Nloop++&&($Frm&&preg_match('`lessfirst`',$opt))){array_unshift($rep, list($f,$t)=fixrange(0,$Frm));}
        if(!$Frm){array_push($rep, fixrange(0,$Tto,$K) );return $rep;}
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

#++++++++++Convert Get Requests to ISO encoding+++++++++++++++++++++
foreach($_GET as $k => $v) {
	$_GET[$k] = mb_convert_encoding($v,"ISO-8859-15","UTF-8");
}
foreach($_REQUEST as $k => $v) {
	#$_REQUEST[$k] = mb_convert_encoding(preg_replace(Array("\x0a\xa4"),Array("EURO"),$v),"ISO-8859-15","UTF-8");
	$_REQUEST[$k] = mb_convert_encoding($v,"ISO-8859-15","UTF-8");
}
#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$TERM_0=$_GET['term'];
$Term=trim($TERM_0);
$is_euro=strpos(' '.$Term,"\xa4");#if(substr($Term,0,1)==' '){$Term=bin2hex($Term);}
$oldpak=@$_GET['oldpak'];
$Deacoldpak=Deac($oldpak,true,true);
$oldcmd=@$_GET['oldcmd'];
#+++++++++Clean up white spaces and irregular characters++++++++++++
$LxA=$LxB=$LxC=$LxD=$LxE="";$NbA=$NbB=$NbC=$NbD="";
# - - - - - - - 1        2               3           4               5           6          7           8       9
if(preg_match('`([^0-9]*)([1-9][0-9]*)(?:([^0-9]+)(?:([1-9][0-9]*)(?:([^0-9]+)(?:([0-9]+)(?:([^0-9]+)(?:([0-9]+)([^0-9].*))?)?)?)?)?)?$`',$Term,$Nb)){
	$LxA=$Nb[1];$NbA=$Nb[2];$LxB=@$Nb[3];$NbB=@$Nb[4];$LxC=@$Nb[5];$NbC=@$Nb[6];$LxD=@$Nb[7];$NbD=@$Nb[8];$LxE=@$Nb[9];
}
$IsQuote=strpos(' '.$Term,'"');
$termquote=$term=preg_replace(Array('`^[ ]+`'),Array(''),$Term);
$TERMdeacquote=$DeacL=$TERMdeac=preg_replace('`^([0-9]+)[ ]\x28.*$`','$1',$Deac=Deac($termquote,true,true)); # remove accents keep case keep hyphen 
#$TERMdeacquote=$DeacL=$TERMdeac=preg_replace(Array(	'`^([0-9]+)[ ]\x28.*$`',
#                '`[à-å]`i',
#                '`[æ]`i',
#                '`[ç]`i',
#                '`[ñ]`i',
#                '`[è-ë]`i',
#                '`[ì-ï]`i',
#                '`[ò-ö]`i',
#                '`[ù-ü]`i',
#                '`[ýÿ]`'
#        ),Array(	'$1',
#                'a',
#                'ae',
#                'c',
#                'n',
#                'e',
#                'i',
#                'o',
#                'u',
#                'y'
#        ),$termquote);//term without accents
$NbQuote=substr_count($TERMdeacquote,'"')%2;
$NbPar=substr_count($TERMdeacquote,'(')-substr_count($TERMdeacquote,')');
$myterm=($NbPar<0?substr("((((((((((((((((((((",0,-$NbPar):"")
	.($NbQuote&&substr(str_replace('(','',$TERMdeacquote),0,1)!='"'?'"':'')
	.$TERMdeacquote
	.($NbQuote&&substr(str_replace('(','',$TERMdeacquote),0,1)=='"'?'"':'')
	.($NbPar>0?substr("))))))))))))))))))))",0,$NbPar):"");
$termquote=($NbPar<0?substr("((((((((((((((((((((",0,-$NbPar):"").$termquote.($NbPar>0?substr("))))))))))))))))))))",0,$NbPar):"");
$TERM=$term=preg_replace('`[\x22]`','',$Term);
$DeacL=$TERMdeac=preg_replace('`[\x22]`','',$TERMdeacquote);
if(preg_match('`(?:(v|cp?)[ ]*(?=[0-9]|$))?([^\x28\x29]*?)[ ]{0,2}\x28([^\x28\x29]+)\x29[\s\t ,:\r\n]*`',$TERMdeac,$Ag)){list($x,$vcp,$DeacL,$DeacR)=$Ag;$TERMdeac=$DeacL;}else{$vcp=$DeacR="";}
$cmds = clean_cmds(@$_REQUEST['cmds']);#----Replace 
#+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


$DEPARTEMENTS=Array("01"=>"Ain","02"=>"Aisne","03"=>"Allier", "04"=>"Alpes de Haute Provence", "05"=>"Hautes Alpes", "06"=>"Alpes Maritimes",
	"07"=>"Ardèche", "08"=>"Ardennes", "09"=>"Ariège", "10"=>"Aube", "11"=>"Aude", "12"=>"Aveyron", "13"=>"Bouches du Rhône", 
	"14"=>"Calvados", "15"=>"Cantal", "16"=>"Charente", "17"=>"Charente Maritime", "18"=>"Cher", "19"=>"Corrèze", #"20"=>"Corse du Sud",
	"20"=>"Corse", "21"=>"Côte d'Or", "22"=>"Côtes d'Armor", "23"=>"Creuse", "24"=>"Dordogne", "25"=>"Doubs", "26"=>"Drôme", "27"=>"Eure", 
	"28"=>"Eure et Loir", "29"=>"Finistère", "30"=>"Gard", "31"=>"Haute Garonne", "32"=>"Gers", "33"=>"Gironde", "34"=>"Hérault", "35"=>"Ille et Vilaine", 
	"36"=>"Indre", "37"=>"Indre et Loire", "38"=>"Isère", "39"=>"Jura", "40"=>"Landes", "41"=>"Loir et Cher", "42"=>"Loire", "43"=>"Haute Loire", 
	"44"=>"Loire Atlantique", "45"=>"Loiret", "46"=>"Lot", "47"=>"Lot et Garonne", "48"=>"Lozère", "49"=>"Maine et Loire", "50"=>"Manche", "51"=>"Marne", 
	"52"=>"Haute Marne", "53"=>"Mayenne", "54"=>"Meurthe et Moselle", "55"=>"Meuse", "56"=>"Morbihan", "57"=>"Moselle", "58"=>"Nièvre", "59"=>"Nord", 
	"60"=>"Oise", "61"=>"Orne", "62"=>"Pas de Calais", "63"=>"Puy de Dôme", "64"=>"Pyrénées Atlantiques", "65"=>"Hautes Pyrénées", "66"=>"Pyrénées Orientales", 
	"67"=>"Bas Rhin", "68"=>"Haut Rhin", "69"=>"Rhône", "70"=>"Haute Saône", "71"=>"Saône et Loire", "72"=>"Sarthe", "73"=>"Savoie", "74"=>"Haute Savoie", 
	"75"=>"Paris", "76"=>"Seine Maritime", "77"=>"Seine et Marne", "78"=>"Yvelines", "79"=>"Deux Sèvres", "80"=>"Somme", "81"=>"Tarn", "82"=>"Tarn et Garonne", 
	"83"=>"Var", "84"=>"Vaucluse", "85"=>"Vendée", "86"=>"Vienne", "87"=>"Haute Vienne", "88"=>"Vosges", "89"=>"Yonne", "90"=>"Territoire de Belfort", "91"=>"Essonne", 
	"92"=>"Hauts de Seine", "93"=>"Seine Saint Denis", "94"=>"Val de Marne", "95"=>"Val d'Oise",
	"97"=>"D.O.M.","98"=>"Mayotte Wallis Papeete Nouméa");
$DEP=$DEPARTEMENTS;
#{++++++++++++If conditions are met, open database connections+++++++
if($show&&(
		  $Support||$Bookmarks
		||!empty($_REQUEST['support'])
		||preg_match('`\b'.$R2cFrLoc4.'[- a-z]{2}`i',$Deac)
	#&&add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK=print_r($row,true)." (debug)","ville=<\"$DeacL\"" ,"<b>Ville:</b> <b>OUI! Nom Localité DEBUG </b> ".($x="<td class=\"bgcefefef\">")."\xa0term=$term\xa0Term=$Term\xa0loc=$loc")
		||preg_match('`^([A-Z][a-z]*(?:[- \x27][A-Za-z][a-z]*)*)[-\x27]?$`i',$Deac,$Ag)
			&&($Ag[1]=preg_replace(Array('`[ \x22]+`','`\bsaint\b`i'),Array('-','st'),$Ag[1]))&&(($Len=strlen($Ag[1]))>3)
	#&&add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK=print_r($row,true)." (debug)","ville=<\"$DeacL\"" ,"<b>Ville:</b> <b>OUI! DEBUG </b> ".($x="<td class=\"bgcefefef\">")."\xa0term=$term\xa0Term=$Term\xa0loc=$loc")
		||preg_match('`^(?:(?:v|cp?)[ ]*)?((?:(?:01|1[347]|2[0159]|3[03458]|4[0249]|5[479]|6[0234789]|7[15-8]|8[039]|9[78])[0-9]{3}|(?:0[1-9]|[1-8][0-9]|9[1-578])(?:[0-9]{2}0)?)(?:[, ](?:(?:01|1[347]|2[0159]|3[03458]|4[0249]|5[479]|6[0234789]|7[15-8]|8[039]|9[78])[0-9]{3}|(?:0[1-9]|[1-8][0-9]|9[1-578])(?:[0-9]{2}0)?))*)[ ]*(?:[A-Za-z]+(?:[-\x27/ ][A-Za-z]+)*)*[- ]*$`',$Deac,$Agcp)&&(!$cmdname||$cmdname=="ville")
	#&&add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK=print_r($row,true)." (debug)","ville=<\"$DeacL\"" ,"<b>Ville:</b> <b>OUI! cp localité DEBUG </b> ".($x="<td class=\"bgcefefef\">")."\xa0term=$term\xa0Term=$Term\xa0loc=$loc")
		||preg_match('`^(?:(v|cp?)(?=[ ]+[0-9a-zA-Z]|[A-Z0-9])[ ]*)?(?:('.$R2cFrLoc4.'[- A-Za-z]+(?:[-\x27/ ][A-Za-z]+)*)[ ]*)?(?:((?:(?:(?:01|1[347]|2[0159]|3[03458]|4[0249]|5[479]|6[0234789]|7[15-8]|8[039]|9[78])[0-9]{3}|(?:0[1-9]|[1-8][0-9]|9[1-578])[0-9]{2}0)[, ]*)+|(?(2)$|;))|(0[1-9]|[1-8][0-9]|9[1-578])(?![0-9]))$`',$Deac,$Agcploc)
		||$TSidi && preg_match('`[a-zA-Z]{3}@`',$Deac)
	#&&add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK=print_r($row,true)." (debug)","ville=<\"$DeacL\"" ,"<b>Ville:</b> <b>OUI! localité cp DEBUG </b> ".($x="<td class=\"bgcefefef\">")."\xa0term=$term\xa0Term=$Term\xa0loc=$loc")
	)&&($DoThis="DB"))
{
#print "NOW GET DB ********\n";
require $dbsfile;
$GoDB=is_resource($dblink);
#print "I GOT THE DB dblink=$dblink ********\n";
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
#}+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


#++++++++++++++++++Set variables for identifying user from cookie++++++
if( @$_COOKIE["CKVARS"]){
	  ($sid=(preg_match('`sid=([^&]*)`',$_COOKIE["CKVARS"],$Ag)?$Ag[1]:""))
	&&($nom=$SNOM=(preg_match('`nom=([^&]*)`',$_COOKIE["CKVARS"],$Ag)?$Ag[1]:""))
	&&($grp=$SSUP=(preg_match('`grp=([^&]*)`',$_COOKIE["CKVARS"],$Ag)?$Ag[1]:""))
	&&($cnx=$SCNX=(preg_match('`cnx=([^&]*)`',$_COOKIE["CKVARS"],$Ag)?$Ag[1]:""));
}
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


#++++++++MAKE A NEW SUGGESTION LIST ITEM add Priority, REP(??), Name(cmdname),Pak(text that user sees), Cmd(database cmnd), Dis(display html)++
$Cnt=10000;
function add_P_R_N_P_C_D($pri,	$REP_APP_XCL,	$CMDNAME,	$PAK,	$CMD,	$dis,$NResShown=0){
  global $MultiVille,$Deac,$DeacToContinue,$DeacSearchLoc,$Deacoldpak,$PLACE_cmds,$AUTO_PAK,$cmdname,$PREFIX_cmds,$Term,$Cnt,$a_json,$b_json,$C_Debug,$Column_Number,$ToDoLasti,$TERMdeac;
  $Cnt--;
  static $RowsToMerge,$Nbcolrowspan,$DeS,$DeR;$x=!empty($PREFIX_cmds[$CMDNAME])?$PREFIX_cmds[$CMDNAME]:"";
  $MULTI_ROW=$NResShown;
  $VILLEFIT=(($prefx=preg_replace('` `','',$PREFIX_cmds['ville']))&&preg_match("`^$prefx\\b`",$TERMdeac));
  if($cmdname=='ville'||$VILLEFIT){if($CMDNAME=='cp'||$CMDNAME=='de'){$CMDNAME='ville';}}
  if($cmdname&&$cmdname!=$CMDNAME){$pri=floor($pri/100);}#$dis.="|($cmdname!=$CMDNAME)";}#elseif($cmdname){$dis.="|$cmdname";}
  elseif($x&&preg_match('`^'.$x.'`',$Term)){$pri=floor($pri*10);}#$dis.="|($cmdname!=$CMDNAME)";}#elseif($cmdname){$dis.="|$cmdname";}
  if($x){$PAK=preg_replace("`^(?=[a-z]{1,2}[ ])$x`","",$PAK);}

  if(!isset($RowsToMerge)&&$MULTI_ROW&&$MULTI_ROW>0){$RowsToMerge=$MULTI_ROW;}
  if(isset($RowsToMerge)&&!$MULTI_ROW){unset($RowsToMerge);$Nbcolrowspan=0;}
  if($CMDNAME=='ville'&&$DeacToContinue&&strpos($PAK,'=')==false){
	$d=(($Deacoldpak&&($x=strlen($Deacoldpak))<strlen($Deac)&&substr($Deac,0,$x)==$Deacoldpak)?$Deacoldpak
	:($DeacSearchLoc&&($x=strlen($DeacSearchLoc))&&$DeacSearchLoc==substr($Deac,-$x)&&preg_match('`^([0-9]{5}|[0-9]{2})([, ]*([0-9]{5}|[0-9]{2}))*[ ]*(?:[A-Za-z]+(?:[-\x27][A-Za-z]+)*[ ]+)*`',substr($Deac,0,strlen($Deac)-$x))?substr($Deac,0,strlen($Deac)-$x):$Deac
	));
	$d=preg_replace(Array('`^[a-z](?=[ 0-9A-Z])[ ]*`'
			,'`[(]([^()]*)[)]`e'
			,'`([0-9]{5})([a-z]+)`'
			,'`^[, ]+|[, ]+$`'
			),Array(''
			,'"(".preg_replace("`[, ]`","~",""."$1").")"'
			,'$1 $2'
			,''
			),$d);
	#$rp='`^(?!'.preg_replace(Array('`^[^-()A-Z0-9]|[^-()A-Z0-9]$`i','`[^-()A-Z0-9]+`i','`[(]`','`[)]`') ,Array('','$|','\x28','\x29'),$PAK).'$)`';
	$ar=preg_grep('`(?!^V *$)`i',preg_split('`[, ]+`',$d));
	#array_pop($ar);
	sort($ar);
	#array_push($ar,$PAK);
	
	$PAK=preg_replace('`(?:^|(?<= ))([a-z0-9][-\x270-9a-z]*) \1(?:(?=[ ])|$)`i','$1',implode(' ',$ar).' '.$PAK);
	#preg_grep($rp,$ar));
	#$a=implode(' x ',preg_grep('`\b(?!'.$rp.'\b)`',sort(explode(' ',$DeacToContinue))));
	if(true){
	#$PAK=str_replace('Gvvobv ','',ucwords($a.$PAK));
	#if( preg_match('`\b[0-9]{5}\b.*?\b[0-9]{5}\b`',$PAK)&&strpos($PAK,'"')===false && preg_match('`ville=<?\"([^\x22]+)\"`',$CMD,$r)){
	if( preg_match('`\b[0-9]{5}\b`',$PAK)&&strpos($PAK,'"')===false){
		preg_match('`ville=<?\"([^\x22]+)\"`',$CMD,$r);
		$x=preg_replace(
		  Array( '`([(]([~a-z]*[0-9]+[^()]*)[)])`i'
			,'`([(]([-\x27a-z]+)[)])`i'
			,'`(?<=\b[cdjlmnst])-`i'
			,'`\b[v]\b`'
		),Array('$1','$1',"'",'')
		,$PAK.(@$r[1]?' '.$r[1]:'')
		);
		preg_match_all('`(?:^|[, ]+)(?:([0-9]{5}|[0-9]{2})[.]?|([a-z]+(?:[-~\x27][a-z]+)*(?:[ ]*[.])?)|([(]([-~a-z]*[0-9]+[^()]*)[)][.]?)|([(]([-~\x27a-z]+)[)][.]?))(?:(?=[, ]+)|$)`i',$x,$A);
		$y=$z=$p=$t=$c=$sep='';$icp=$ilo=$iplo=$ico=0;$uniq=Array();$c='';
		if(is_array($A[1])){
			for($i=0;$i<count($A[1]);$i++){$cp=$A[1][$i];if($cp&&empty($uniq[$cp])){$uniq[$cp]=1;$icp++;$c.=$sep.$cp;$sep=' ';}} 
		}
		if(is_array($A[2])){
			for($i=0;$i<count($A[2]);$i++){$loc=ucwords($A[2][$i]);if($loc&&empty($uniq[$loc])){$uniq[$loc]=1;$ilo++;$z.=$sep.$loc;$sep=' ';}}
		}
		if(is_array($A[5])){
			for($i=0;$i<count($A[5]);$i++){$ploc=ucwords($A[5][$i]);if($ploc&&empty($uniq[$ploc])){$uniq[$ploc]=1;$iplo++;$p.=$sep.$ploc;$sep=' ';}}
		}
		if(is_array($A[3])){
			for($i=0;$i<count($A[3]);$i++){$com=ucwords($A[3][$i]);if($com&&empty($uniq[$com])){$uniq[$com]=1;$ico++;$t.=$sep.$com;$sep=' ';}}
		}
		$y=$c;
		if($p&&$z){$p=preg_replace('`[()]|[ ]\b[a-z]\b|\b[a-z]\b[ ]?`i','',$p);}
		if($icp&&$icp<=$ilo&&$z){$y.=$z;}
		elseif($z&&$icp&&$ilo&&$icp<=$ilo+$iplo){$z.=$p;$p='';$y.=$z;}
		else{$p="$z$p";$z='';}
		$p=preg_replace(Array('`~`','`^'.$sep.'|[()]|[ ]\b[v]\b|\b[v]\b[ ]?`i','`(^|[ ])(\w+(?:-\w+)*)\b(.*?)[ ]\2\b(?!-)`i'),Array(' ','','$1$2$3'),$p);
		$z=preg_replace(Array('`~`','`^'.$sep.'|[()]|[ ]\b[v]\b|\b[v]\b[ ]?`i','`(^|[ ])(\w+(?:-\w+)*)\b(.*?)[ ]\2\b(?!-)`i'),Array(' ','','$1$2$3'),$z);
		$ModeCodepostal=($icp?($icp<2?" Code postal":" Codes postaux"):"");
		$y&&($PAK=$y.((!$icp||$ilo&&!$p)?" ":" (".($p?$p:($icp?"$icp$ModeCodepostal":"")).")")
		#." ($ilo,$iplo,$d:$z:$p)"
		);
		$y&&($CMD="ville=<\"$z $c\""); # FAILS IF TWICE SAME WORD IN TWO NAMES
		#&&($CMD="ville=<\"".preg_replace('`[(]?\b([a-z]+(?:[-\x27][a-z]+)+)\b[)]?`ie','"`".str_replace("-"," ","$1")."`"',$y)."\"");
	}
	}
  }
  $Column_Number=10;
  if(strlen($dis)>4&&!preg_match('`Codes postaux:|.rea .til|conexão|Desconect|^(?:&nbsp;|[^a-zA-Zà-üÀ-Ü0-9])*$|<b\b[^>]*>[ ]*[A-ZÀ-Üa-zà-ü][^:]*:`i',$dis)){
    if(preg_match('`Solo [0-9]{4}\b`i',$dis)){$dis=preg_replace('`^`','<b>Localidade: </b>',$dis);}
    elseif(preg_match('`\b[0-9]{4}-[0-9]{3}\b`i',$dis)){$dis=preg_replace('`^`','<b>Localização precisa: </b>',$dis);}
    else{$dis=preg_replace('`^`','<b>Condition: </b>',$dis);}
  }
  $NoColumn=preg_match('`<td\b|[|]`i',$dis)?false:true;
	#$dis=str_replace(' ','-',preg_replace('` <b>((?:(?!</?b>)[^<>])*)`ie','" <b>".ucwords("$1")."</b>"',str_replace('-',' ',$dis)));
  $dis=preg_replace(Array('`^(?!<tr\b)`i'
			,'`(<tr\b[^>]*>)(?!<td\b|[|])|[|]`i' #(
			,'`(<td\b|$)`i'				#)(
			,'`(<tr\b[^>]*>)</td>`i'		#^)
			,'`(?:(</td>)|<;td[^>]*>)(?:</td>)+`i'
			,'`(<td[^>]*>)(</td>)+`i'
			,'`(</tr>)?$`i'
			,'`(</td>)$`i'
		  ),Array('<tr>'
			,'$1<td>'
			,'</td>$1'
			,'$1'
			,'$1'
			,'$1&nbsp;$2' #,'$1&nbsp;'.$MULTI_ROW."/".$RowsToMerge.'$2'
			#,"<td class=rig>\xa0|\xa0</td>"
			,""
			,'$1</tr>'
		  ),$dis);
  $NBCols=count(preg_split('`</td><td\b`i',$dis))-1;
  if($NoColumn){$dis=preg_replace('`^((?:(?!<td\b).)*)<td\b`i','$1<td colspan='.($Column_Number-$NBCols),$dis);}
  if($x=count(preg_split('`rowspan=`i',$dis))-1){$Nbcolrowspan=$x;}
  $Row2tolast=!empty($RowsToMerge)&&$MULTI_ROW>$RowsToMerge;!empty($RowsToMerge)&&$RowsToMerge--;
  #if(!preg_match('`\b(cp|ville)\b`',$CMDNAME)){$dis=preg_replace('`<td\b`i','<td colspan=2',$dis);}
  $dis=preg_match('`colspan=`i',$dis)||$NoColumn
				?$dis
				:preg_replace('`<td\b([^>]*>)((?:(?!<td\b).)*)$`','<td colspan='
				.($x=$Column_Number-$NBCols-($Row2tolast?$Nbcolrowspan:0)
				#.($x=$Column_Number+1-$NBCols-($MULTI_ROW>=$RowsToMerge&&$RowsToMerge--?0:$Nbcolrowspan)
				#.($x=$Column_Number+($MULTI_ROW>$RowsToMerge&&$RowsToMerge--?-$Nbcolrowspan:0)+1-$NBCols
				#.($x=$Column_Number+($MULTI_ROW>$RowsToMerge&&$RowsToMerge--?-$Nbcolrowspan:0)+1-$NBCols#count(preg_split('`</td><td\b`i',$dis))
				)
				."$1$2"
				#."$1!$x/$RowsToMerge!$2"
				#,preg_match('``',$dis)?$dis:preg_replace($dis))
				,$dis);
  #$dis=preg_replace('`(colspan=([0-9]+)\b[^>]*>)`',"$1cols=$2($NBCols/$Column_Number,$MULTI_ROW>$RowsToMerge,$Nbcolrowspan) ",$dis);
  $dis=preg_replace('`<td((?:(?!</td|style=")[^<>])*(style=("))?)`ie','"<td"."$1".("$2"?"":" style=\\"")."white-space:nowrap".("$2"?";":"\\"")',$dis);
  $x=Array(
#"pri"               => (strpos($pri,'/')!==false?$pri.($pri=preg_replace('`^.*/`','',$pri)?'':''):'').sprintf("%07u",floor($pri?$pri:429495)).sprintf("%04u",$pri&&$pri!="00000"?$Cnt:0),
    "pri"		=> sprintf("%07u",floor($pri?$pri:4294)).sprintf("%04u",$pri&&$pri!="00000"?$Cnt:0),
    "REP_APP_XCL"	=> $REP_APP_XCL,
    "cmdname"		=> (@$PLACE_cmds[$CMDNAME]?$CMDNAME:"index_".$CMDNAME),
    "PAK"		=> $PAK,
    "cmd"		=> $CMD,
    "dis"		=> $dis,
    "cat"		=> (@$PLACE_cmds[$CMDNAME]?$PLACE_cmds[$CMDNAME]:$PLACE_cmds["Index"]),
#    "aut"		=> $PLACE_cmds[$CMDNAME];#$AUTO_PAK[$CMDNAME],
  );
  #if(preg_match('`rowspan=[\x22]?([0-9]+)`',$dis,$Ag)){$RowsToMerge+=$Ag[1];}

  if($pri&&$pri!="00000"){array_push($a_json, $x);}
  else	  {array_push($b_json, $x);}

  return 1;
}
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


#++++++++++++If no registered user connection detected:+++++++++++++++++++++++++++++++++
if(!$SCNX){
   add_P_R_N_P_C_D("99999","REP",empty($_REQUEST['excl'])?"DISCON":"ville",$x=$err_discon,"1","<p class=sys14>&nbsp;$x&nbsp;&nbsp;</p>");
   finish();
   exit;
}#elseif(strlen($DeacL)<3){ add_P_R_N_P_C_D(preg_match('`^d[eé]co`i',$DeacL)?"90000":"00000","REP","DISCON",$x="",'',"&nbsp;$x&nbsp;"); add_P_R_N_P_C_D(preg_match('`^d[eé]co`i',$DeacL)?"90000":"00000","REP","DISCON",$x="Déconnecté $nom",'&cnx=&',"" ."<span style=\"text-align: right;color:#933\">" ."$x&nbsp;</span>"); }
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
function searchdb($ex,$pri_degrade=0,$Mem=""){
  global $PAYS,$a_json,$Cnt,$cmdname,$cmds,$HASHcmds,$Term,$term,$vcp,$Deac,$DeacL,$DeacR,$isodate,$sid,$nom,$grp,$cnx,$top,$mel,$tel,$err_discon,$HTTP_HOST,$C_Debug,$dblink,$dblink2,$dblink3,$dblink4,$DEP,$MultiVille,$DeacToContinue,$DeacSearchLoc,$MultiVilleUniq,$TSid,$TSidi;
  global $STATICSCNX,$uniqcploc;
  $Cntselect=0;if(!is_array($uniqcploc)){$uniqcploc=Array();}
  if(!$Mem){
  if(empty($dblink)&& empty($dblink2)){#print "srchdb: NO DB OPENED\n";
    add_P_R_N_P_C_D("99999","REP",empty($_REQUEST['excl'])?"DISCON":"ville","DB not opened","1","<b>Error:</b> No db opened for $Deac: ".substr($ex,0,16));return 1;
  }

 if(!isset($STATICSCNX)){
    $STATICSCNX=1;#sprintf("%08x-%s",crc32($HTTP_USER_AGENT.$HTTP_ACCEPT.$HTTP_ACCEPT_LANGUAGE),$ip);
    #$pawd=date('Y-m-d').substr($STATICSCNX,0,8).$grp.$nom.($s?$awd:md5($awd));$ckwe=time();
    #$cnx=md5($pawd);
#No select id ,md5(concat("2016-09-19",MID(s.scnx,1,8),s.ssup,s.snom,s.sa)) as c ,top,sp1 as mel,stelp as tel  
# from sup as s  
# where id=45 and snom="rjf" and ssup="superselectim" 
# and FIND_IN_SET("ccee0632f16b8f9bf20e7f3b9c7612e2",concat(md5(concat("2016-09-19",MID(s.scnx,1,8),s.ssup,s.snom,s.sa)),",",md5(concat("2016-09-19",MID(s.scnx,1,8),s.ssup,s.snom,md5(concat(s.sp,",fromenter=1"))))))<BR>
    $FullID=false;
    $DbG=false;
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
        &&(false&&(print $sq."<BR>\n")||true)
        &&(($r=my_query($sq))&&is_resource($r)||$C_Debug&&(print "sid=$sid, selectim: r n'est pas une ressource, type=".gettype($r)." r='$r'<BR>\nMsg frm my_:".my_error()."\n<BR>\nMsg frm MYSQL:".mysql_error()."<BR>\n")&&false)
                &&($row = mysql_fetch_array($r,MYSQL_ASSOC)) && is_array($row)
                &&(@$row['id']==$sid)
                &&(($top=@$row['top'])||true)
                &&(($mel=@$row['mel'])||true)
                &&(($tel=@$row['tel'])||true)
		&&($FullID=true)#&&($DbG&&(print "Hoooo$TSidi/$sid.".$sq."<BR>\n")||true)
    )){
	# NEGATIVE - FAILED ID
        $I="";if($DbG){print "No ".$sq."<BR>\n";}
        $a_json=Array();
        add_P_R_N_P_C_D("99999","REP",empty($_REQUEST['excl'])?"DISCON":"ville",$x=$err_discon,"1","<div class=sys14>&nbsp;$x&nbsp;&nbsp;</div>");
        finish();
        exit;
    }
    if($FullID){$TSid=@$TSidi&&(@$sid==45||@$sid==32);$DbG&&(print "Hoooo$TSidi$TSid.$sid.".$sq."<BR>\n");
    }# SUCCESS !
    if($cmdname!='ville'&&!preg_match('`@`',$_REQUEST['term'])){add_P_R_N_P_C_D("00000","REP","DISCON",$x="connexion active.","1","<span style=\"text-align: right;color:#373\">$x</span>");}
  }
  }
  #($C_Debug)&&(print "srchdb PAYS=$PAYS term=/$term/ cmds=/$cmds/<BR>\nex=$ex<BR>\n\n");
  $ex=str_replace(',)',')',$ex);
  $RESULT=Array();$LOCcps=Array();$LOCncp=Array();$CPnloc=Array();$CPlocs=Array();
  if($Mem ||($rs = my_query($ex))){
  while($Mem&& preg_match('`^([^-,]+)-([^-,]+),?`',$Mem,$Ag)||!$Mem && isset($rs) && is_resource($rs)&&($row = mysql_fetch_array($rs,MYSQL_ASSOC))){
    if($Mem){
      $Mem=substr($Mem,strlen($Ag[0]));
      $row=Array('loc'=>$ex,'ncp'=>$Ag[1],'cp'=>$Ag[2],'pri'=>'99999');
    }
    $RESULT[$Cntselect++]=$row;#$loc=@$row['loc'];print "ncp={$row['ncp']}, loc={$row['loc']}, cp={$row['cp']}, LOCcps={$LOCcps[$loc]}, LOCncp={$LOCncp[$loc]}\n";
    if(@$row['clics']&&$FullID){
	add_P_R_N_P_C_D(99999,"REP","i",@$row['grid']." ".@$row['id']." ".@$row['sp1'].' '.@$row['clics']
	,"sp1=\"$PAK\""
	,"<b>Clics:</b>".@$row['sp1'].($x="<td>")."\xa0".@$row['mois']."<td class=bgcefefef>\xa0".@$row['clics']);
	continue;
    }
    if(@$row['lien']&&$FullID){
	add_P_R_N_P_C_D(99999,"REP","i",@$row['grid']." ".@$row['id']." ".@$row['sp1']."\xa0".@$row['tel']."\xa0".@$row['sp']." ".@$row['lien']
	,@$row['tel']?'pr3=<'.preg_replace('`[^0-9]`','',$row['tel']):'MOT="'.str_replace('@','',$TERMdeac).'"'
	,"<b>Email:</b>".@$row['grid']." ".@$row['id']." ".@$row['sp1'].($x="<td class=\"bgcefefef\">")."\xa0".@$row['tel']);
	continue;
    }
    $cp=@$row['cp'];
    if(($loc=ucwords(@strtolower(preg_replace('`[- ][0-9]+$`','',@$row['loc']))))&&$cp){
    if(empty($LOCcps[$loc])?($LOCcps[$loc]=$cp)&&($LOCncp[$loc]=1):substr($LOCcps[$loc],0,2)==substr($cp,0,2)&&($LOCcps[$loc].=' '.$cp)&&(++$LOCncp[$loc])){
	   #add_P_R_N_P_C_D($pri,"REP","ville",$PAK="$loc (".($LOCncp[$loc]>3?"Les {$LOCncp[$loc]} Codes postaux":$LOCcps[$loc]).")","ville=<\"{$LOCncp[$loc]}\""
	   #,"<b>BUILD:</b> $loc |(".($LOCncp[$loc]>3?"Les {$LOCncp[$loc]} Codes postaux":$LOCcps[$loc]).")\xa0\xa0|");
      #
    }}
#    if(is_resource($rs) && count($row)>0){
#	add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK=print_r($row,true)." (debug)","ville=<\"$Deac\"" ,"<b>Ville:</b> <b>$PAK</b> ".($x="<td class=\"bgcefefef\">")."\xa0term=$term\xa0Term=$Term\xa0loc=$loc");
#Array(    [bycp] => 2    [cp] => 21390    [loc] => AISY-SOUS-THIL    [pri] => 35000    [c10] => 3000083620    [ncp] => 15    [NResShown] => 15) (debug)
#    }
    $MultiCpGiven=(($cp&&preg_match("`[0-9][-, ]*{$cp}\\b|\\b{$cp}[-, ]*[0-9]`",$Deac))?true:false);
    if(@$row['bycp']==1&&(($ncp=@$row['ncp'])>1)&&!$MultiCpGiven){
      if(!$CPnloc){$mpri=(($Term===$cp)?99999:@$row['pri']);
      #$den=@$row['den'];
      #$hab=@$row['hab'];
	add_P_R_N_P_C_D($mpri,"REP","ville" ,$PAK="$cp ($ncp communes)","ville=<\"$cp\"" 
	,"<b>Code postal:</b>".$PAK#." ".preg_replace('`^.*\bin[ ]*(\x28[0-9]{5}[^\x29]*\x29).*$`','$1',$ex)
		.($x="<td class=\"bgcefefef\">")."\xa0$cp {$x}Les $ncp communes"
	."<td class=myclick><a class=\"myclick pd6px fg008 lien\""
	." href=\"clic.php?q=".rawurlencode(base64_encode(gzcompress('maps.google.com/maps?q='.rawurlencode("$cp, ".CountryName()),5)))."\""
	." target=blank class=lien>Carte</a>");
      $CPnloc['$cp']=1;$CPlocs['$cp']=$loc;
      }
      $CPnloc['$cp']++;$CPlocs['$cp'].=', '.$loc;
    }
  
  }
  } 
  if(is_array($RESULT)
	&& ($nbres=count($RESULT))){
  $Multirow=0;
  for($ires=0;$ires<$nbres;$ires++){
    $row=$RESULT[$ires];
    #++$Cntselect;
    if(!isset($PAYS) or $PAYS=="fr"){
      #$den=@$row['den'];
      #$hab=@$row['hab'];
      $loc=ucwords(@strtolower(@$row['loc']));
      $NResShown=($MultiCpGiven?0:@$row['NResShown']);
      #$unq=@$row['unq'];
      $pri=(isset($_REQUEST['De'])?@$row['c10'].'/'.@$row['pri']:@$row['pri']-$pri_degrade);
      $cp=@$row['cp'];	
      $uncp=preg_replace('`^.*[^0-9](?=[0-9])`','',@$row['cp']);	
	if($cps=@$row['cps']){
	  $km=@$row['km'];
	  $L=@$row['L'];
	  ($L>1)&&add_P_R_N_P_C_D($pri,"REP","ville",$PAK="cp $uncp {$km}Km alentour","ville=<\"$cps\"","<b>Ville:</b> cp $uncp {$km}km autour <td class=bgcffefef> ".($km<10?"\xa0":"")."$km\xa0Km\xa0alentours:\xa0|\xa0($L codes postaux)");
	  return $Cntselect;
	}
      $de=substr($cp,0,2);
      $dep=@$DEP["$de"];
      $ncp=@$row['ncp'];$pad="\xa0\xa0\xa0\xa0";#$pad.=$pad;$pad.=$pad;#$x=substr($pad,8,strlen($pad)-round(1.25*strlen($loc)));
      #if($ncp==1 || preg_match('`^(Marseille|Nice|Paris|Lille|Lyon)$`',$loc)||!empty($LOCcps[$loc])&&preg_match('`^(?:([0-9]{2})[0-9]+)(?: \1[0-9]+)+$`',$LOCcps)){
      if($ncp==1 || !empty($LOCcps[$loc])&&preg_match('`^([0-9]{2})[0-9]+(?: \1[0-9]+)+$`',$LOCcps[$loc])){
	if(!empty($LOCcps[$GrandeVille=preg_replace('`[- ]*[0-9]+$`','',$loc)])&&$LOCncp[$GrandeVille]>1){
	   if(empty($uniqcploc[$LOCncp[$GrandeVille].$GrandeVille])){$uniqcploc[$LOCncp[$GrandeVille].$GrandeVille]=1;
	   add_P_R_N_P_C_D($cp===$Term?99999:$pri,"REP","ville"
	   #,$PAK="$GrandeVille (".($LOCncp[$GrandeVille]>3?"Ses {$LOCncp[$GrandeVille]} Codes postaux":$LOCcps[$GrandeVille]).")"
	   ,$PAK=$LOCcps[$GrandeVille]." ($GrandeVille)"
	   ,"ville=<\"{$LOCcps[$GrandeVille]}\""
	   #,"<b>Ville:</b> $GrandeVille |(".($LOCncp[$GrandeVille]>5?substr($LOCcps[$GrandeVille],0,6*5)."...":$LOCcps[$GrandeVille]).")\xa0\xa0|Les {$LOCncp[$GrandeVille]} Codes postaux"
	   ,"<b>Ville:</b> ".($LOCncp[$GrandeVille]>5?substr($LOCcps[$GrandeVille],0,6*5)."...":$LOCcps[$GrandeVille])." |<b>($GrandeVille)</b>\xa0Les {$LOCncp[$GrandeVille]} Codes postaux|\xa0"
	   ."<td class=myclick><a class=\"myclick pd6px fg008 lien\" href=\"clic.php?q="
	   .rawurlencode(base64_encode(gzcompress('maps.google.com/maps?q='.rawurlencode("$loc, $dep, ".CountryName()),5)))."\" target=blank class=lien>Carte</a>"
	   );
	  $LOCcps[$GrandeVille]='';
	  }
	  }
	   if($cp&&$loc&&empty($uniqcploc[$cp.$loc])){$uniqcploc[$cp.$loc]=1;
	   add_P_R_N_P_C_D($cp===$Term?99999:$pri,"REP","ville",$PAK="$cp ($loc)"
	   ,"ville=<\"$cp\""
	   ,"<b>Ville:</b> $cp <td class=bgcffefef><b>($loc)</b>\xa0|\xa0($dep)".(false&&$Deac==$cp?"*":"")
	   ."<td class=myclick><a class=\"myclick pd6px fg008 lien\" href=\"clic.php?q="
	   .rawurlencode(base64_encode(gzcompress('maps.google.com/maps?q='.rawurlencode("$cp, ".CountryName()),5)))."\" target=blank class=lien>Carte</a>"
	   );
	   }
      }
      else{
	if($cp&&$loc&&empty($uniqcploc[$cp.$loc])){$uniqcploc[$cp.$loc]=1;$mpri=($cp===substr($Term,-5)?99999:$pri);
	#add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="cp $cp loc $loc (debug)","ville=<\"$Deac\"" ,"<b>Ville:</b> <b>$PAK</b> ".($x="<td class=\"bgcefefef\">")."pri=$mpri\xa0term=$term\xa0Term=$Term\xa0loc=$loc");
	add_P_R_N_P_C_D($mpri,"REP","ville",$PAK="$loc $cp","ville=<\"$cp ".preg_replace('`[-/\x27 ]`','-',$loc)."\""
		,(!$ncp||empty($row['bycp'])||$row['bycp']>1
		?"<b>Ville:</b>\xa0<b>$loc</b>\xa0\xa0|$cp\xa0|\xa0($dep)"
		:"<b>Ville:</b>\xa0$loc$pad"
			.($NResShown&&$Multirow++
			?""#.";text-align: center"
			:"<td ".($NResShown>1?" rowspan=$NResShown":"")." class=\"nohover pd6px bgcefefef fgdarkgreen mid\">$cp\xa0"
			."<td ".($NResShown>1?" rowspan=$NResShown":"")." class=\"nohover pd6px bgcffefef fgdarkgreen mid\">($dep)"
			)
			#."<td class=myclick><div class=\"myclick fg008\" onclick=\"window.open('clic.php?q=".rawurlencode(base64_encode(gzcompress("maps.google.com/maps?q=".rawurlencode($cp)."%2C%20".CountryName(),5)))."\">Voir Carte</div>"
		)
		#."<td class=myclick>Carte"
		."<td class=myclick><a class=\"myclick pd6px fg008 lien\" href=\"clic.php?q=".rawurlencode(base64_encode(gzcompress('maps.google.com/maps?q='.rawurlencode("$cp, $loc, ".CountryName()),5)))."\" target=blank class=lien>Carte</a>"
	,($NResShown>1?$NResShown:0)
	);}
	}
      #add_P_R_N_P_C_D($pri,"REP","ville",$PAK="$loc $cp","ville=<\"$cp $loc\"","<b>Ville:</b> {$row['cp1000']},{$row['cp100']},{$row['cp10']},$PAK".($dep?" ($dep)":""));
    }
  }
  }elseif($rs === false) {
    $user_error = 'Wrong SQL: ' . $ex . 'Error: ' . my_error() . ' ';
    trigger_error($user_error, E_USER_ERROR);
  }
  return $Cntselect;
}

#++++++++If get request has cmd list, recognize and sort them++++++++++
$HASHcmds=ParseCmds($cmds);
 #!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 #!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 $cp4s=(preg_match('`ville="(?:(?![0-9]{4}\b)[^\x22])*([0-9]{4}(?:[ ][0-9]{4})*)`',@$HASHcmds['ville'],$Ag)?" AND floor(cp) in(".$Ag[1].")":"");
 $cnal=(preg_match('`ville="([^0-9,<=>]+)"`',@$HASHcmds['ville'],$Ag)?" AND cn in(\"".($CNAL=$Ag[1])."\")":($CNAL=""));
 #!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 #!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 $cnallower=($cnal?@mb_strtolower($CNAL,"iso-8859-15"):"");
 
// replace multiple spaces with one
#print "TS=$TSid\n<BR>\n";
if($TSid && ($sid==45||$sid==32) && preg_match('`^clics (20[0-9]{2}(?:-[0-9]{0,2}(?:-[0-9]{0,2})?)?)(?: ([a-z].*))?`i',$_REQUEST['term'],$Ag)){
	$ex="select grid,id,concat(sp1,' ',grid,' ',id)as sp1,stelp as tel,count(n)as clics,mid(lst,1,7)as mois
	from dbgfix inner join sup on i=id where grid>999 and !sfax and mid(lst,1,".strlen(@$Ag[1]).")=\"".@$Ag[1]."\"
	and sp1 like \"%".preg_replace('`clics `','',$Ag[2])."%\" group by grid,id,mid(lst,1,7) limit 60";#print "$ex\n";exit;
	searchdb($ex);
	finish();
	exit;
}
if($TSidi && ($sid==45||$sid==32) && @$TERMdeac  && preg_match('`@`',$TERMdeac)){#print "i\n";exit;
	searchdb($ex="select grid,id,sp1,stelp as tel,concat(\"http://selectim.com?nom=\",snom,\"&grp=\",ssup,\"&sa=\",sa)as lien,sp from sup where grid>1 and top<=3
	and sp1 like \"%".preg_replace('`@`','%@%',$TERMdeac)."%\"limit 60");
	finish();
	exit;
}#else{print "No$TSidi?t$TSid/$sid\n";}
$term = preg_replace(Array('/^\s+|\s+$/','/\s+/'),Array('',' '), $DeacL);
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
      #($cmdname=='ville'||preg_match('`^(v|cp)[ ]?(?=[0-9]|(?-i:[A-Z]))`',$TERMdeac))&& add_P_R_N_P_C_D(99999,"REP","ville",$PAK=$TERMdeac,"ville=<\"".preg_replace('`[-/\x27]+`','-',$TERMdeac)."\"","<b>Ville:</b> {$TERMdeac} AS TYPED ");

if(empty($_REQUEST['excl'])&&($cmdname=='ville'||preg_match('`^(v|cp?)[ ]?(?=[0-9]|\b|(?-i:[A-Z]))`',$TERMdeac))
	&&preg_match('`^(?-i:(v|cp)(?=[ 0-9A-Z])[ ]?)?((?:\b(?:[a-z]+(?:[- \x27][a-z]+)*|[0-9]{2}|(?:(?:01|1[347]|2[0159]|3[03458]|4[0249]|5[479]|6[0234789]|7[15-8]|8[039]|9[78])[0-9]{3}|(?:0[1-9]|[1-8][0-9]|9[1-578])(?:[0-9]{2}0)?))\b[ ]?)+)$`i',$TERMdeac,$Ag)
	&&($Ag[2]=preg_replace(Array('`^v([ ]|(?=[A-Z0-9]))`','`[ \x22]+`','`\b(saint|st)[- ]\b`i'),Array('',' ','st-'),$Ag[2]))&&(($Len=strlen($Ag[2]))>2)
	#&&preg_match('`^(?:(v|cp)[ ]?(?=[0-9]|(?-i:[A-Z])))?((?:\b(?:[a-z]+(?:[- \x27][a-z]+)*|[0-9]{2}|[0-9]{5})\b[ ]?)+)$`i',$TERMdeac,$Ag)
){
	$locs=$Ag[2];
	$x='';preg_match_all('`\b([0-9]{2})\b`',$Ag[2],$r)&&is_array($r)&&is_array($r[1])&&(count($r[1])>0)
		&&($x=' and de in('.implode($r[1],',').')')&&($locs=preg_replace('`\b([0-9]{2})\b[ ]*|[ ]+$`','',$Ag[2]));
	#add_P_R_N_P_C_D(99999,"REP","ville",$PAK=$Ag[2],"ville=<\"".preg_replace('`[-/\x27]+`','-',$locs)."\"".($x?$x:'') ,"<b>Ville:</b> <b>{$Ag[2]}</b> (Vos Noms de lieux et codes postaux)");
}
if(preg_match('`^(?!(?-i:[a-z][A-Z]))(?:(v|cp?)[ ]?(?=[0-9]|(?-i:[A-Z])))?([A-Z][a-z]*(?:[- \x27][A-Za-z][a-z]*)*)[-\x27]?$`i',$TERMdeac,$Ag)&&($Ag[2]=preg_replace(Array('`[ \x22]+`','`\bsaint\b`i'),Array('-','st'),$Ag[2]))&&(($Len=strlen($Ag[2]))>0)){
	$vcp=@$Ag[1];
	$maxNResShown=$MaxResParLoc=45;
$Donebyloc=false;
if($Len<4){
	#add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="$ex (debug)","ville=<\"$Deac\"" ,"<b>Ville:</b> <b>$PAK</b> ".($x="<td class=\"bgcefefef\">")."\xa0$term|\xa0".print_r($Ag,true));
$ShortLoc=Array( # 157 lines
 "acq"=>"5-62144" ,"acy"=>"26-02200" ,"ade"=>"36-65100" ,"afa"=>"10-20167" ,"agy"=>"32-14400" ,"aix"=>"21-19200,10-59310" ,"alo"=>"1-98610" ,"amy"=>"22-60310" ,"apt"=>"10-84400" ,"ars"=>"7-23480,12-16130" ,"arx"=>"7-40310" ,"avy"=>"21-17800" ,"ay"=>"9-51160" ,"ayn"=>"5-73470" ,"aze"=>"17-71260,26-41100,16-53200" ,"azy"=>"10-18220" ,"bar"=>"8-19800" ,"bax"=>"16-31310" ,"bay"=>"12-08290,17-70150" ,"bey"=>"8-71620,10-01290" ,"bio"=>"17-46500" ,"boe"=>"1-47550" ,"bou"=>"4-45430" ,"boz"=>"12-01190" ,"bru"=>"31-88700" ,"bry"=>"8-59144" ,"bu"=>"11-28410" ,"buc"=>"5-90800,1-78530" ,"bue"=>"18-18300" ,"bun"=>"27-65400" ,"bus"=>"14-62124" ,"by"=>"31-25440" ,"cos"=>"25-09000" ,"cox"=>"14-31480" ,"cre"=>"7-72200" ,"cry"=>"5-89390" ,"cuq"=>"8-47220" ,"cuy"=>"22-60310,18-89140" ,"dax"=>"19-40180,1-40100" ,"die"=>"15-26150" ,"don"=>"1-59272" ,"dry"=>"5-45370" ,"dun"=>"16-09600" ,"dye"=>"8-89360" ,"dyo"=>"22-71800" ,"eix"=>"30-55400" ,"ens"=>"15-65170" ,"eps"=>"15-62134" ,"erp"=>"12-09200" ,"err"=>"6-66800" ,"eth"=>"8-59144" ,"eu"=>"17-76260" ,"eup"=>"24-31440" ,"eus"=>"15-66500" ,"eve"=>"4-60330" ,"eze"=>"1-06360" ,"fa"=>"5-11260" ,"fay"=>"10-61390,6-72550,36-80200" ,"fel"=>"25-61160" ,"fey"=>"33-57420" ,"fos"=>"24-31440,10-34320" ,"fry"=>"15-76780" ,"fye"=>"9-72490,18-89800" ,"gan"=>"6-64290" ,"gap"=>"9-05000" ,"gas"=>"7-28320" ,"gee"=>"8-49250" ,"ger"=>"2-50850,5-64530,36-65100" ,"geu"=>"36-65100" ,"gex"=>"8-01170" ,"gez"=>"27-65400" ,"gy"=>"25-70700" ,"gye"=>"7-54113" ,"ham"=>"19-80400" ,"hao"=>"1-98767" ,"hem"=>"2-59510" ,"his"=>"18-31260" ,"ifs"=>"3-14123" ,"ige"=>"18-61130,16-71960" ,"ize"=>"10-53160" ,"izy"=>"18-45480" ,"jas"=>"15-42110" ,"jax"=>"18-43230" ,"job"=>"1-63990" ,"kaw"=>"1-97353" ,"lay"=>"4-42470" ,"laz"=>"4-29520" ,"lee"=>"6-64320" ,"ley"=>"15-57810" ,"lez"=>"24-31440" ,"llo"=>"6-66800" ,"lor"=>"17-02190" ,"luc"=>"5-12450,26-65190,4-48250" ,"lue"=>"5-40210" ,"lux"=>"5-71100,20-31290,22-21120" ,"lye"=>"8-36600" ,"lys"=>"14-64260,20-58190"
,"mee"=>"9-53400" ,"mer"=>"14-41500" ,"mey"=>"6-57070" ,"mun"=>"28-65350" ,"mus"=>"1-30121" ,"nay"=>"12-50190" ,"ney"=>"34-39300" ,"noe"=>"13-89320,10-31410" ,"oey"=>"35-55500" ,"ogy"=>"21-57530" ,"oms"=>"5-66400" ,"oo"=>"32-31110" ,"ore"=>"19-31510" ,"ors"=>"4-17480,13-59360" ,"orx"=>"9-40230" ,"ota"=>"2-20150" ,"our"=>"30-39700" ,"oye"=>"22-71800" ,"oze"=>"11-05400" ,"pau"=>"1-64000" ,"pey"=>"15-40300" ,"pia"=>"1-66380" ,"pin"=>"17-70150" ,"pis"=>"12-32500" ,"py"=>"18-66360" ,"pys"=>"35-80300" ,"rai"=>"12-61270" ,"ri"=>"22-61210" ,"ris"=>"8-63290,4-65590" ,"rix"=>"12-58500,27-39250" ,"rom"=>"10-79120" ,"rue"=>"14-80120" ,"ruy"=>"20-38300" ,"ry"=>"9-76116" ,"rye"=>"29-39230" ,"sai"=>"12-61200" ,"sem"=>"10-09220" ,"son"=>"30-08300" ,"sor"=>"27-09800" ,"sos"=>"12-47170" ,"sus"=>"28-64190" ,"sy"=>"13-08390" ,"tox"=>"12-20270" ,"ur"=>"10-66760" ,"urs"=>"14-09310" ,"urt"=>"9-64240" ,"ury"=>"15-77760" ,"us"=>"15-95450" ,"uz"=>"27-65400" ,"uza"=>"6-40170" ,"vay"=>"7-44170" ,"ver"=>"14-50450" ,"vez"=>"5-60117" ,"vif"=>"5-38450" ,"vix"=>"5-85770,29-21400" ,"vou"=>"10-37240" ,"vry"=>"13-57640" ,"vue"=>"5-44640" ,"we"=>"16-08110"
,"y"=>"20-80190"
);
if($v=@$ShortLoc[$Loc=strtolower($Ag[2])]){
	searchdb($Loc,0,$v);
	$Donebyloc=true;
}
}else{


#drop table c1;create table c1(cp mediumint(5) unsigned zerofill NOT NULL,ins char(6) NOT NULL,ncp tinyint unsigned NOT NULL,c10 int unsigned NOT NULL,loc char(64) NOT NULL,L mediumint(8) unsigned NOT NULL,primary key (L),unique key cp(cp,loc),key loc(loc,cp),key c10(c10),FULLTEXT KEY `loc_2` (`loc`))DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;insert ignore c1 (select cp,insee,0,10000*(1-bur)+100000*cp10+1000*cp100+cp1000+3000000000,loc,L from c where !cedex);update c1,(select cp,count(loc)as N from c1 group by cp having N>0)as g set ncp=N,c10=c10-if(N=1 and c10>=3000000000,1000000000,0) where g.cp=c1.cp;update c1,(select cp,count(i)as N from baser group by cp having N>0)as g set c10=1000000000-N where g.cp=c1.cp and c1.c10>=30000000;update c1 set loc="MARSEILLE",c10=999985000+cp where loc regexp "^MARSEILLE( [0-9]+)?$";update c1 set loc="LYON",c10=999987000+mid(cp,3,3) where loc regexp "^LYON( [0-9]+)?$";
#update c1 set c10=999987000+mid(cp,3,3) where loc regexp "^(MARSEILLE|PARIS|LYON|NICE|TOULOUSE|NANTES|RENNES|CHARTRES)( [0-9]+)?$";update c1 set c10=999987000+mid(cp,3,3) where mid(cp,1,2)=33 and loc regexp "^BORDEAUX( [0-9]+)?$";
#update c1,(select cp,count(i)as N from baser group by cp having N>0)as g set c10=c10-N where g.cp=c1.cp;
#drop table c1;create table c1(cp mediumint(5) unsigned zerofill NOT NULL,ins char(6) NOT NULL,ncp tinyint unsigned NOT NULL,c10 int unsigned NOT NULL,loc char(64) NOT NULL,L mediumint(8) unsigned NOT NULL,primary key (L),unique key cp(cp,loc),key loc(loc,cp),key c10(c10),FULLTEXT KEY `loc_2` (`loc`))DEFAULT CHARSET=latin1 ROW_FORMAT=FIXED;insert ignore c1 (select cp,insee,0,100*(1-bur)+1000000*cp10+1000*cp100+cp1000+3000000000,loc,L from c where !cedex order by 100*(1-bur)+10000*cp10+100*cp100+cp1000+3000000000);update c1,(select cp,count(loc)as N from c1 group by cp having N>0)as g set ncp=N,c10=c10-if(N=1 and c10>=3000000000,1000000000,0)/100 where g.cp=c1.cp;update c1 set c10=999987000+mid(cp,3,3) where loc regexp "^(MARSEILLE|PARIS|LYON|NICE|TOULOUSE|NANTES|RENNES|CHARTRES)( [0-9]+)?$";update c1 set c10=999987000+mid(cp,3,3) where mid(cp,1,2)=33 and loc regexp "^BORDEAUX( [0-9]+)?$";update c1,ci set c10=if(!isnull(hab),if(c10>1000*den,c10-1000*den,0),c10) where ins=i;

	searchdb($ex="select cp,replace(loc,' ','-')as loc,if(ncp=1 AND length(loc)=$Len,99999,55000+3000*$Len)as pri,c10,ncp,if($maxNResShown>ncp,ncp,$maxNResShown)as NResShown "
	."from c1 where ".(preg_match('`^paris?$`i',$DeacL)?"cp not like \"75%\"and ":"")."loc like \"".preg_replace('`-`',' ',$Ag[2])."%\" "
	."order by c10,length(loc) limit $maxNResShown")&&($Donebyloc=true);
	#add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="$ex (debug)","ville=<\"$Deac\"" ,"<b>Ville:</b> <b>$PAK</b> ".($x="<td class=\"bgcefefef\">")."\xa0$term|\xa0".print_r($Ag,true));
}}
# de      | tinyint(2) unsigned zerofill   | NO   | MUL | 00      
# cp      | mediumint(5) unsigned zerofill | NO   | MUL | 00000   
# insee   | char(6)                        | NO   | MUL |         
# cedex   | smallint(1) unsigned           | NO   | MUL | 0       
# cp10    | tinyint(3) unsigned            | NO   | MUL | 0       
# cp100   | tinyint(3)                     | NO   |     | 0       
# cp1000  | smallint(3)                    | NO   |     | 0       
# bur     | tinyint(1)                     | NO   | MUL | 0      
# loc     | char(64)                       | NO   | MUL | NULL    
# len     | tinyint(3) unsigned            | NO   | MUL | 0       
# unq     | char(48)                       | NO   | MUL | NULL    
# noms    | char(45)                       | NO   | MUL | NULL    
# ambigus | char(45)                       | NO   | MUL |         
# L       | mediumint(8) unsigned          | NO   | PRI | NULL    
#++++++++++++++++++++++Add a zipcode search suggestion WITHOUT DB search+++++++++++++++++++++++++++++++
$k='';$Codepostal=false;
#if(preg_match('`^(?:(v|cp?)(?=[ ]+[0-9a-zA-Z]|[A-Z0-9])[ ]*)?(?:([A-Za-z]+(?:[-\x27/ ][A-Za-z]+)*\b)[ ]*)?((?:(?:0[1-9]|[1-8][0-9]|9[1-578])[0-9]{3}[, ]*)+|(?(2)$))$`',$Deac,$Ag)){

#}
$de='';$prefixville=$WCp=$WDe=$Cp=$L1=$Lo='';$MultiVille=1;$MultiVilleUniq='';
	$DeacNoPar=preg_replace(Array('`[ ]*[(] *Toute?s\b [^)]*[)][ ]*|[ ]*[(][- :?,\/@!.\x27a-z]*[0-9]+[- .\x27a-z]*[)][ ]*`i','`[( ]+|[) ]+|[ ]{2,}`'),Array(' ',' '),$Deac);
	$DeacToContinue=preg_replace(Array(
					'`[ ]*[(](?:Codes p|Toute?s\b|(?:Les )?[0-9])[^)]*[)][ ]*|[ ]*[(][- :?,\/@!.\x27a-z]*[0-9]+[- .\x27a-z]*[)][ ]*`i'
					,'`[ ]{2,}|[ ]*\b[\w][^() ]*[ ]*$`i'
					,'`[( ]+|[) ]+|[ ]{2,}`'
					),Array(' ',' ',' '),$Deac);
	#add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="de/$de/ cp/$Cp/ loc/$loc/(debug search k=$k,L$loc, c($cp))","ville=<\"$DeacNoPar\"" ,"<b>Ville:</b> <b>$term\xa0/");
if($GoDB&&
(
        $MultiVille&&(
        preg_match('`\b(?:^(v|cp?)(?=[ ]+[0-9a-zA-Z]|[A-Z0-9])[ ]*)?((?:(?:(?:01|1[347]|2[0159]|3[03458]|4[0249]|5[479]|6[0234789]|7[15-8]|8[039]|9[78])[0-9]{3}|(?:0[1-9]|[1-8][0-9]|9[1-578])(?:[0-9]{2}0)?[, ]*)?)+)(?:(?:[A-Za-z]+(?:[-\x27][A-Za-z]+)*[ ]+)*(?='.$R2cFrLoc.'|[a-zA-Z]$)([A-Za-z]+(?:[-\x27/ ][A-Za-z]+)*)[- ]*)?$`',$DeacNoPar,$Ag)
        &&(($Lo=@$Ag[3])||true)&&(($prefixville=@$Ag[1])||true)
        #&&add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="(debug)","ville=<\"$DeacNoPar\"" ,"<b>Ville:</b> <b>cp-n-n/$DeacNoPar, Cp=$Cp de=$de Lo=$Lo</b>")
	)
#||	preg_match('`'.(!$MultiVille?'^(?:(v|cp?)(?=[ ]+[0-9a-zA-Z]|[A-Z0-9])[ ]*)?':'(?:^|[ ]|\b(v)(?=[A-Z]))').'(?:(?='.$R2cFrLoc.'|[a-zA-Z]$)([A-Za-z]+(?:[-\x27/ ][A-Za-z]+)*)[- ]*)?(?:((?:(?:0[1-9]|[1-8][0-9]|9[1-578])[0-9]{3}[, ]*)+|(?(2)$|;))|(0[1-9]|[1-8][0-9]|9[1-578]))$`',$DeacNoPar,$Ag)
||	preg_match('`'.(!$MultiVille?'^(?:(v|cp?)(?=[ ]+[0-9a-zA-Z]|[A-Z0-9])[ ]*)?':'(?:^|[ ]|\b(v)(?=[A-Z]))').'(?:(?='.$R2cFrLoc.'|[a-zA-Z]$)([A-Za-z]+(?:[-\x27/ ][A-Za-z]+)*)[- ]*)?((?:(?:(?:01|1[347]|2[0159]|3[03458]|4[0249]|5[479]|6[0234789]|7[15-8]|8[039]|9[78])[0-9]{3}|(?:0[1-9]|[1-8][0-9]|9[1-578])(?:[0-9]{2}0)?)[, ]*)+)$`',$DeacNoPar,$Ag)
        &&(($Lo=@$Ag[2])||true)
        #&&add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="(debug)","ville=<\"$DeacNoPar\"" ,"<b>Ville:</b> <b>n-cp/$DeacNoPar, Cp=$Cp de=$de Lo=$Lo</b>")
	&&((substr($Lo,0,1)=='v')&&($Lo=preg_replace('`^v([ ]|(?=[A-Z0-9]))`','',$Lo))||true)
||	($k=(preg_match('`^(?:^(v|cp?)(?=[ ]+[0-9a-zA-Z]|[A-Z0-9])[ ]*)?((?=[0-9]))((?:(?:01|1[347]|2[0159]|3[03458]|4[0249]|5[479]|6[0234789]|7[15-8]|8[039]|9[78])[0-9]{3}|(?:0[1-9]|[1-8][0-9]|9[1-578])[0-9]{2}0)) ?(?:et|ou|[- ])([1-4])0km? ?a?[ul]e?n?t?o?u?r?s?$`',$term,$Ag)||preg_match('`(((^)))([1-4])0Km autour de ([0-9]{5})$`',$term,$Ag)&&($Cp=$Ag[5])?$Ag[4]:""))
)
   &&(preg_match_all('`\b(?:([0-9]{2})|([0-9]{5}))\b`',@$Ag[0],$r)
	&&(count($r[1])&&($de=implode(' ',$r[1]))&&($WDe="mid(cp,1,2) IN(\"".implode('\",\"',$r[1])."\")")||true)
	&&(count($r[2])&&($CP=array_unique($r[2]))&&($Cp=preg_replace('`^[, ]|[, ]+$`','',implode(' ',$CP)))&&($WCp="cp IN(".preg_replace('`^[, ]|[, ]+$`','',implode(',',$CP)).")"))
	||true)
 #&&add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="$MultiCP (debug search k=$k,L$loc, c($cp))","ville=<\"$DeacNoPar\"" ,"<b>Ville:</b> <b>$DeacNoPar:\xa0/d=$de/c=$Cp/L=$loc/r=".print_r($r[1],true))
   &&(  preg_match('`^'.$R2cFrLoc.'|^[a-z]?$`i',@$Lo)
      ||preg_match('`\b(?:(?:01|1[347]|2[0159]|3[03458]|4[0249]|5[479]|6[0234789]|7[15-8]|8[039]|9[78])[0-9]{3}|(?:0[1-9]|[1-8][0-9]|9[1-578])[0-9]{2}0)?\b`',@$Cp)
      ||preg_match('`\b(?:0[1-9]|[1-8][0-9]|9[1-578])\b`',@$de)
     )
        #&&add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="(debug)","ville=<\"$DeacNoPar\"" ,"<b>Ville:</b> <b> VALIDE/$Lo/ Cp=$Cp de=$de Lo=$Lo</b>")
  ){
	$maxNResShown=$MaxResParCp=(@$Lo||$cmdname=='ville'||$prefixville?54:2);$mat='';
	if($DeacSearchLoc=$loc=@$Lo){
	#add_P_R_N_P_C_D(999999,"REP","ville",$PAK="$loc (debug)","ville=<\"debug\"","<b>Ville:</b> <b>$Lo/$loc/$Cp/$cp/$MultiCP/</b> ".($x="<td class=\"bgcefefef\">")."\xa0$term|\xa0debug");
        #add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="".print_r($Ag,true)." (debug)","ville=<\"$Deac\"" ,"<b>Ville:</b> <b>LocCp:$PAK</b> ".($x="<td class=\"bgcefefef\">")."\xa0/$term/|\xa0".print_r($Ag,true));
	    $loc=$Lo;
	    if(strpos($loc,'-')===false&&strpos($loc,'`')===false&&strpos($loc,'"')===false&&preg_match('`\b(saint|sur|[ld]es|aux|sous|[a-z]{1,2})\b`i',$loc)){
			$loc=preg_replace('`[-\x22 ]+`','-',$loc);
	    }
	    if(strpos($loc,'`')===false&&strpos($loc,'"')===false){
		$LOC=array_unique($LOC0=explode(' ',$loc)); $nloc=count($LOC);
		$mat='match(loc) against("';$cmdloc=$sqlloc='';$cmdsep='';$qu=$sqlsep='\"';
		for($i=0;$i<$nloc;$i++){
		    $cmdloc.=$cmdsep.$LOC[$i];
		    $sqlloc.=$sqlsep.preg_replace('`[-\x22 ]+`',' ',$LOC[$i]);
		    $cmdsep=' ';
		    $sqlsep='\" \"';
		}
		if($sqlloc){
		    $sqlloc.=$qu;
		    $mat.=$sqlloc.'" IN BOOLEAN MODE)';
		}
	    }
	}else{
		$loc=false;
	}
	#$cp=preg_replace(Array('`[^0-9]+(?=[0-9])`','`^,+|,+$`'),Array(',',''),@$Cp);$CP=array_unique($CP0=explode(',',$cp));
	$MultiCP='';
#	if($MultiVille&&
#	(	preg_match('`\b(?:([A-Za-z]+(?:[-\x27][A-Za-z]+)*)[ ]+)?((?:(?:01|1[347]|2[0159]|3[03458]|4[0249]|5[479]|6[0234789]|7[15-8]|8[039]|9[78])[0-9]{3}|(?:0[1-9]|[1-8][0-9]|9[1-578])[0-9]{2}0)(?:[-, ]*(?:(?:01|1[347]|2[0159]|3[03458]|4[0249]|5[479]|6[0234789]|7[15-8]|8[039]|9[78])[0-9]{3}|(?:0[1-9]|[1-8][0-9]|9[1-578])(?:[0-9]{2}0)?))*)[ ]+([A-Za-z]+(?:[-\x27][A-Za-z]+)*)[- ]?$`',$DeacNoPar,$r)
#		&&strlen($r[1])>2
#	||preg_match('`((?:(?:01|1[347]|2[0159]|3[03458]|4[0249]|5[479]|6[0234789]|7[15-8]|8[039]|9[78])[0-9]{3}|(?:0[1-9]|[1-8][0-9]|9[1-578])[0-9]{2}0)(?:[-, ]*(?:(?:01|1[347]|2[0159]|3[03458]|4[0249]|5[479]|6[0234789]|7[15-8]|8[039]|9[78])[0-9]{3}|(?:0[1-9]|[1-8][0-9]|9[1-578])(?:[0-9]{2}0)?))*)[ ]+\b(?:[A-Za-z]+(?:[-\x27][A-Za-z]+)*[ ]+)*?(?:([A-Za-z]+(?:[-\x27][A-Za-z]+)*)[ ]+)?([A-Za-z]+(?:[-\x27][A-Za-z]+)*)[- ]?$`',$DeacNoPar,$r)
#		&&(($r[0]=$r[1])||true)
#		&&(($r[4]=$r[3])||true)
#		&&(($r[1]=(@$r[2]?$r[2]:@$r[3]))||true)
#		&&(($r[2]=$r[0])||true)
#	)
#	&&($r[2]=preg_replace('`[0-9]{5}(?=[0-9]{5})`','$1,',$r[2]))
#	&&strlen($r[1])>0&&($privil=99999)
#	#&&add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="$MultiCP (debug search k=$k,L$loc, c($cp))","ville=<\"$Deac\"" ,"<b>Ville:</b> <b>Multi ville\xa0/".print_r($r,true))
#	)
	#add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="de/$de/ cp/$Cp/ loc/$loc/(debug search k=$k,L$loc, c($cp))","ville=<\"$DeacNoPar\"" ,"<b>Ville:</b> <b>$term\xa0/");
	if($MultiVille&&($CPkm=($Cp?($Lastcp=substr($Cp,-5)):($de?$de."00".($de=="75"||$de=="69"||$de=="13"?"1":"0"):""))))
	{
		$sq="select cps from ce_30km_cp where cp IN($CPkm)";
	#add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="$MultiCP (debug search k=$k,L$loc, c($cp))","ville=<\"$DeacNoPar\"" ,"<b>Ville:</b> <b>$term\xa0/$sq");
		(($r=my_query($sq))&&is_resource($r)||$C_Debug&&(print "sid=$sid, selectim: r n'est pas une ressource, type=".gettype($r)." r='$r'<BR>\nMsg frm my_:".my_error()."\n<BR>\nMsg frm MYSQL:".mysql_error()."<BR>\n")&&false)
                &&($row = mysql_fetch_array($r,MYSQL_ASSOC))
                && is_array($row)
                &&($MultiCP=@$row['cps']);
	}


	$cp=$Cp;$Wzone=($WCp?$WCp:($WDe?$WDe:""));
	#$cp=preg_replace(Array('`[^0-9]+(?=[0-9])`','`^,+|,+$`'),Array(',',''),@$Cp);$CP=array_unique($CP0=explode(',',$cp));$Lastcp=substr($cp,-5);
	if($cmdname=="ville"||$k||$cp){$pribycp="99999";}else{$pribycp="35000";}

	if($cp||$loc&&($mat||$de)){
	$ex="select ".($loc?"2":"1")." as bycp,cp,replace(loc,' ','-')as loc,$pribycp".($Cp?"-if($WCp,0,99900)":"")." as pri"
	.",c10,ncp,if($maxNResShown>ncp,ncp,$maxNResShown)as NResShown "
	." from c1 where ".($MultiCP?"cp in ($MultiCP)":($Wzone?"$Wzone ":($de?"MID(cp,1,2) IN($de) ":"1 "))).($mat?"and $mat ":"")
	."order by ".($Cp?"if(".($mat||$loc?"cp=$Lastcp":$WCp).",0,1)asc,":"")."c10,loc limit $maxNResShown";
	#add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK=$ex,"ville=<\"$DeacNoPar\"" ,"<b>Ville:</b> <b>$term\xa0/$mat");
#romag select 1 as bycp,cp,replaceas loc,99999 as pri,c10,ncp,if(54>ncp,ncp,54)as NResShown  from c1 where cp IN(86700) order by c10,loc limit 54 (debug)
		if($Codepostal=searchdb($ex)&&$loc){$DeacSearchLoc=$loc;};
	}
	if(!$k&&!$Codepostal && ($Cp ||$loc&&!@$Donebyloc && strpos($loc,' ')===false)){
	#if(!$k&& ($cp ||$loc&&!@$Donebyloc && strpos($loc,' ')===false)){
	#if( ($cp ||$loc )){
	#if((strpos($loc,' ')===false)&&(strpos($loc,'`')===false)&&(strpos($loc,'"')===false)&&(strlen($loc)>4)){
	if((strpos($loc,'`')===false)&&(strpos($loc,'"')===false)&&(strlen($loc)>($MultiCP||$cp?0:($de?3:4)))){
	$ex="select ".($loc?"2":"1")." as bycp,cp,replace(loc,' ','-')as loc,"
	.($pribycp=($cmdname=="ville"?"99999":($loc||floor($cp/1000)*1000<$cp?"35000":"35000")))." as pri,c10,ncp,if($maxNResShown>ncp,ncp,$maxNResShown)as NResShown "
	." from c1 where  ".($MultiCP?"cp in ($MultiCP)":($cp?"cp IN(".(($mat||$loc)?$cp:$Lastcp).") ":($de?"MID(cp,1,2) IN($de) ":"1 "))).($loc?"and loc like "
		."\"".preg_replace(Array('`^p(a(ri?)?)?$`i','`[-\x22 ]+`'),Array(';',' '),$loc)."%\""
		.($Codepostal?" and length(loc)>".strlen($loc)." ":""):"")
	."order by c10,loc limit $maxNResShown";
	#add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK=$ex,"ville=<\"$DeacNoPar\"" ,"<b>Ville:</b> <b>$term\xa0/$mat");
	if($Codepostal=searchdb($ex)&&$loc){$DeacSearchLoc=$loc;};
	#add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="$ex","ville=<\"$Deac\"" ,"<b>Debug:</b> $ex");
#select 2 as bycp,cp,replace(loc,' ','-')as loc,35000 as pri,c10,ncp,if(54>ncp,ncp,54)as NResShown  from c1 where  cp IN(21390) and loc like 
#"Aisy sous t%"
#order by c10,loc limit 54
#+------+-------+----------------+-------+------------+-----+-----------+
#| bycp | cp    | loc            | pri   | c10        | ncp | NResShown |
#+------+-------+----------------+-------+------------+-----+-----------+
#|    2 | 21390 | AISY-SOUS-THIL | 35000 | 3000083620 |  15 |        15 |
#+------+-------+----------------+-------+------------+-----+-----------+

#select 2 as bycp,cp,replace(loc,' ','-')as loc,35000 as pri,c10,ncp,if(54>ncp,ncp,54)as NResShown  from c1 where  cp IN(21390) and loc like 
#"Aisy Sous thil%" and length(loc)>14 
#order by c10,loc limit 54 ;
	#add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="$ex (debug)","ville=<\"$Deac\"" ,"<b>Ville:</b> <b>$PAK</b> ".($x="<td class=\"bgcefefef\">")."\xa0$term|\xa0".print_r($Ag,true));
	}}
	#($Codepostal>1)&& add_P_R_N_P_C_D(0,"REP","ville" ,$PAK="$Deac ($Codepostal communes)","ville=<\"$Deac\"" ,"<b>Code postal:</b> ".($x="<td class=\"bgcefefef\">")."\xa0$term {$x}Les $Codepostal communes" ."<td class=myclick><a class=\"myclick pd6px fg008 lien\" href=\"clic.php?q=".rawurlencode(base64_encode(gzcompress('maps.google.com/maps?q='.rawurlencode("$term, ".CountryName()),5)))."\" target=blank class=lien>Carte</a>");
	if(!$loc&&$cp&&(($de=substr($cp,0,2))!=75) && ($de < 92 || $de > 95)){
	##$Codepostal&&($x=searchdb($ex="select floor((length(cps)+1)/6) as L,5 as km,group_concat(cp)as cp,group_concat(cps) as cps,$pribycp as pri from ce_05km_cp where cp IN($cp"));
	($Codepostal||$k==1)&&($x=searchdb($ex="select floor((length(cps)+1)/6) as L,10 as km,group_concat(cp)as cp,group_concat(cps) as cps,$pribycp as pri from ce_10km_cp where cp IN($cp)"));
	($Codepostal||$k==2)&&($x=searchdb($ex="select floor((length(cps)+1)/6) as L,20 as km,group_concat(cp)as cp,group_concat(cps) as cps,$pribycp as pri from ce_20km_cp where cp IN($cp)"));
	($Codepostal||$k>=3)&&($x=searchdb($ex="select round((length(cps)+1)/6) as L,40 as km,group_concat(cp)as cp,group_concat(cps) as cps,$pribycp as pri from ce_30km_cp where cp IN($cp)"));
	}
	if(!empty($CP)&&(($x=count($CP))>1)&&($cp=implode(',',$CP))){
	   $y=substr($Cp,0,29);if(strlen($y)<strlen($Cp)){$y.="...";}
	   add_P_R_N_P_C_D($vcp?99999:99999,"REP","ville",$PAK="$Cp","ville=<\"$Cp\"","<b>Ville:</b> <span title=\"$z\">$y </span>|(liste de $x Codes postaux)"
	   );
	}
}
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
#49000 49070 49080 49100 49112 49124 49125 49130 49140 49170 49190 49220 49240 49250 49320 49330 49370 49380 49430 49460
# 59000,59100,59110,59112,59113,59115,59116,59117,59118,59119,59120,59126,59128,59130,59133,59134,59136,59139,59147,59148,59150,59152,59155,59160,59162,59166,59167,59170,59175,59178,59181,59184,59185,59193,59194,59200,59211,59221,59223,59226,59230,59235,59236,59237,59239,59242,59246,59249,59250,59251,59253,59260,59261,59262,59263,59270,59272,59273,59274,59280,59283,59286,59290,59310,59320,59350,59370,59390,59420,59480,59491,59493,59496,59510,59520,59551,59553,59560,59650,59660,59700,59710,59777,59780,59790,59800,59810,59830,59840,59850,59870,59890,59910,59930,59940,59950,59960,62110,62119,62136,62138,62141,62149,62218,62220,62221,62300,62320,62400,62410,62420,62430,62440,62590,62640,62660,62680,62710,62740,62750,62790,62820,62840,62880,62950,62970,62980
# 59000 59100 59110 59112 59113 59115 59116 59117 59118 59119 59120 59126 59128 59130 59133 59134 59136 59139 59147 59148 59150 59152 59155 59160 59162 59166 59167 59170 59175 59178 59181 59184 59185 59193 59194 59200 59211 59221 59223 59226 59230 59235 59236 59237 59239 59242 59246 59249 59250 59251 59253 59260 59261 59262 59263 59270 59272 59273 59274 59280 59283 59286 59290 59310 59320 59350 59370 59390 59420 59480 59491 59493 59496 59510 59520 59551 59553 59560 59650 59660 59700 59710 59777 59780 59790 59800 59810 59830 59840 59850 59870 59890 59910 59930 59940 59950 59960 62110 62119 62136 62138 62141 62149 62218 62220 62221 62300 62320 62400 62410 62420 62430 62440 62590 62640 62660 62680 62710 62740 62750 62790 62820 62840 62880 62950 62970 62980
#++++++++++++Recognize a direct Index command in term++++++++++++++++++
if(empty($_REQUEST['excl'])&&preg_match('`^(?!(?:Ha|[AatTeE])[0-9]+(?:-[0-9]*)?$)
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
	$`xi',$termquote,$Ag)){
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
	(!preg_match('`drop|update|truncate`i',@$Ag[1].@$Ag[2].@$V.(@$x?' and '.$x:""))&&(preg_match('`^(d?e|cp|[spi]|ville|KF|nat|an|e[qt]|asr|ja|tel|info|annonce|quartier|age|pro[0-5]|prix|clea?|libre_le|dat(e|10))$`i',$Ag[1])||$sid==45||$sid==32||$sid==4085))&&
	add_P_R_N_P_C_D(99999,"REP",$Ag[1] ,$PAK=$Ag[1].$Ag[2].($V=preg_replace('`^([a-zà-ÿÀ-Ü0-9][a-zà-ÿÀ-Ü][a-zà-ÿÀ-Ü0-9]*)$`','"$1"',$Ag[5])).($x?', '.$x:"") 
		,$Ag[1].$Ag[2].$V.($x?' and '.$x:"")
		,
#		"<b>".$Ag[1].":</b>".
		"<b>Index {$Ag[1]}:</b>".$PAK."");
}
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

$parts = explode(' ', $term);
$p = count($parts);
$term_is_pak=(preg_match('`^(Mot|Surface|Pi[èe]ces|Bien|Prix|Terrain|Note|t[ée]l[eé]phone|cellulaire|agence|Date|Appartement|Maison|immeuble)s?$`i',strtolower($TERMdeac),$Ag)?$Ag[1]:"");
$term_is_pak_L=strlen($term_is_pak);


#{+++++++++++++++++++Suggest Telephone number search++++++++++++++++++++
$pripr3=(!empty($HASHcmds['pr3'])?60001:60001);
if(empty($_REQUEST['excl'])&&preg_match('`^(?:[+\x28][1-9]|00?)[-./\x29 ]?[1-9](?:[-./\x29 ]?[0-9]){8,}$`',$term,$Ag)){
	if($IsQuote){$pripr3=99999;}
	$x=preg_replace(Array('`[^+0-9]+`','`^[+]33`','`^[+]`','`[+]`'),Array('','0','00',''),$term);
	add_P_R_N_P_C_D($pripr3,"REP","pr3" ,$PAK="$x" ,"pr3=$x" ,"<b>Téléphone:</b> Annonces liées au téléphone <b>".($x?$x:"téléphone")."</b>");
}
#}++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

#{++++++++++++++++++Suggest Surface area search+++++++++++++++++++++++++
function DRange($CMD="ja"
	,$PAKNAME="Surface du terrain"
	,$UNIT="m\xb2"
	,$UnitRgxL='([tKam]|ha?)'
	,$UnitRgxR='(K|K?t|h(e(ct?)?)?(a(r(es?)?)?)?|a(r(es?)?)?|m([eèê](t(r(es?))?)?)?)'
	,$PREFIX='t '
	,$PrefixRgx='(h?[htsam][\xb2]?)?'
	,$PLUSMOINS="plus"
	,$MaxPri="400-30000"
	,$MaxFit="10000000"
	,$NoRgx='`^[b-gi-ln-su-z]|ha[a-qs-z]|^a[a-z][a-qs-z]|[1-9][0-9]*[ ]?[e]|[$¤/\x28\x29\x22\x27]`i'
	,$YesRgx='`^[tha]a?[ ]?([-1-9]|$)|[\xb2]|m2\b|\bm\b([-1-9]|$)|[[1-9][0-9]*[ ](h(e(ct?)?)?(a(r(es?)?)?)?|a(r(es?)?)?|m([eèê](t(r(es?))?)?)?)\b`i'
	,$NCok=""
	,$NC_SW="ja"
	,$NC_text="surface"
	){
#$CMD="ja";$PAKNAME="Surface du terrain"; $UNIT="m\xb2";$PREFIX='t';$PLUSMOINS="plus"; $NC=$NCok="";$NC_SW="surface";$NC_text="surface";
global $cmdname,$term,$termquote,$TERMdeac,$TERMdeacquote,$LxA,$LxB,$LxC,$LxD,$LxE,$NbA,$NbB,$NbC,$NbD;
	#add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="$CMD $PAKNAME /  (debug)","DRang=\"$term\"" ,"<b>DEBUG:</b> <b>$PAK</b> $LxA $NbA-$LxB-$NbB $LxC".($x="<td class=\"bgcefefef\">")."\xa0$term|\xa0");
if($cmdname=='ville'||!empty($_REQUEST['excl'])||!$LxA&&!$NbA||$NbC||strlen($LxA)>4&&strlen($NbA)<2||preg_match('`^(cp? ?[0-9]|64 pau$)`i',$termquote)){return '';}
if($NbA>0&&$NbA<6&&($CMD=='s'||$CMD=='M2')){return '';}
if(($NbA>0&&$NbA<30||$NbA>100000000)&&($CMD=='prix'||$CMD=='M2')){return '';}
	#add_P_R_N_P_C_D($priCMD,"REP",$CMD, $PAK="Debug $LxA/=$NbA/$LxB;=$NbB/$LxC".$x.($p?$NC:"") ,$x="$i<=$CMD and $CMD<=$i" ,"<b>$PAKNAME:</b> $CMD <b>$PAK</b> $x");
if($NbA>5000&&($CMD=='p'||$CMD=='ch')){return '';}
if($NbA>200&&($CMD=='et')){return '';}
$priCMD=2500;$NC="";List($Min,$Max)=explode('-',$MaxPri);List($x,$Default)=fixrange($Min,max($Min,min(1000,floor($Max/4))));$fit=false;
$feminin=(substr($NC_text,-1)=='e'?'e':'');
$NoCMD=preg_match($NoRgx,$TERMdeacquote);
$YesCMD=preg_match($YesRgx,$TERMdeacquote);
$LandUnit=false;
$Unit=( ( preg_match('`^('.$UnitRgxL.')[ ]?(?:[0-9]+|$)`i',$TERMdeac,$Ag)
	||preg_match('`[0-9][ ]?('.$UnitRgxR.')`i',$TERMdeac,$Ag)
	)
	&&preg_match('`^K`i',@$Ag[1])?1000:(($LandUnit=preg_match('`^h`i',@$Ag[1]))?10000:(($LandUnit=preg_match("`^(a(r(es?)?)?)\b`i",@$Ag[1]))?100:1)));
if($Unit==1){$Unit=(preg_match('`(-|[0-9])[ ]?K`i',$term)?1000:(preg_match('`(-|[0-9])[ ]?[h]`i',$term)?10000:(preg_match('`(-|[0-9])[ ]?[a]`i',$term)?100:1)));}
if($LandUnit){
	if($CMD=="ja"){$YesCMD=1;}else{if($CMD!="ARE"){$NoCMD=1;}$Unit=1;}
}
$UG=@$Ag[1];
#$Unit=(preg_match('`K`i',$term)?1000:(preg_match('`(\b|[0-9])[h]`i',$term)?10000:(preg_match("`(^a|^[^a-z\xa4/][0-9])[ ]?[a]`i",$TERMdeac)?100:1)));
$i=($NbA?$Unit*$NbA:$Default);$j=($NbB?$NbB:upperrange($i));
$plus=$moins="";
if($PLUSMOINS=="moins"){
  $MOINSMOINS="plus";
  $plus=(preg_match('`[1-9][0-9]*[ ]?('.$UnitRgxL.'[ ]?)?([-+][ ]?)?((ou?|et) ?)?pl(us?)?|[+][0-9]|^[^0-9]*[+][1-9][0-9]+[^0-9]*$|^[^0-9]*[1-9][0-9]+[+][^0-9]*$`',$term)?" ou plus":"");
  !$plus&&($moins=preg_match('`[1-9][0-9]*[ ]?('.$UnitRgxL.'[ ]?)?([-+][ ]?)?((ou?|et) ?)?m(o(i(ns?)?)?)?`',$term)?" ou moins":"");
}else{
  $MOINSMOINS="moins";
  $moins=(preg_match('`^(?:(?!plus|-[1-9])[^0-9])*-[1-9]|[1-9][0-9]*[ ]?('.$UnitRgxL.'[ ]?)?([-+][ ]?)?((ou?|et) ?)'.(strpos($UnitRgxL,'m')===false?'?':'').'m(o(i(ns?)?)?)?`',$term)?" ou moins":"");
  !$moins&&($plus=preg_match('`[1-9][0-9]*[ ]?('.$UnitRgxL.'[ ]?)?([-+][ ]?)?((ou?|et) ?)?pl(us?)?|[+][0-9]|^[^0-9]*[+][1-9][0-9]+[^0-9]*$|^[^0-9]*[1-9][0-9]+[+][^0-9]*$`',$term)?" ou plus":"");
}
!$$MOINSMOINS&&!$NbB&&($$PLUSMOINS=" ou ".$PLUSMOINS);$TRa="1";
if(preg_match('`^'.$PrefixRgx.'[ ]?-?([1-9][0-9]{0,7})[ ]?('.$UnitRgxL.'[ ]?)?[-+]?(\b[1-9][0-9]*)?[ ]?('.$UnitRgxR.'[ ]?)?((ou?|et)? ?(p(l(us?)?)?|m(o(i(ns?)?)?)?|NC?)?)?$`i',$term,$Ag)){
	$TRa.="2";
	if(!empty($Ag[1])&&$NoCMD){$fit=true;$priCMD=99999;Certain("*");}
	elseif($YesCMD&&!$NoCMD&&$Min<=$i&&$i<=$Max&&!(!$LxA&&$i>9&&$i<=98&&$i!=96&&!$LxB)){$priCMD=99999;Certain("*");}
	elseif($YesCMD||!$NoCMD&&$Min<=$i&&$i<=$Max&&!(!$LxA&&$i>9&&$i<=98&&$i!=96&&!$LxB)){$priCMD=60000;Certain("");}
	else{$priCMD=24000;Certain("");}
}else{
	$TRa.="3";
	$i=substr($i,0,strlen($MaxFit));$j=($NbB?substr($NbB,0,strlen($MaxFit)):upperrange($i));
	!$YesCMD&&($priCMD=($priCMD>26000?26000:($NoCMD?2000:$priCMD)));if(!$NoCMD&&$Min<=$i&&$i<=$Max){$priCMD=99999;}
	elseif($YesCMD){$TRa.="4";$priCMD=99999;Certain("*");}
	elseif(!$NoCMD&&$Min<=$i&&$i<=$Max){$priCMD=99999;} else{$priCMD=24000;Certain("");}
	#if($YesCMD||(!$cmdname||$cmdname=="$CMD")&&$i<=$Max||$Min<=$i&&$i<=$Max){$priCMD=99999;} else{$priCMD=24000;}
}
if($priCMD>22000&&$NoCMD){$TRa.="5";$priCMD=22000;}
$NCok&&($NC=(preg_match('`[-+0-9][ ]?(ou?|et)? ?NC?`i',$term)?"nc":""));
#$j=$j&&$j>=$i?$j:round(1.3*($i+1));
$DEB="";#"($NbA $NbB $NbC $NbD)";#"$YesCMD:".$priCMD.":".bin2hex($term);
if($i>$j){list($i,$j)=fixrange($i,$j);}#$DEB.=", $i..$j";
if($priCMD>=99999&&($fit||$YesCMD&&!$NoCMD&&$Min<=$i&&$i<=$Max)){$priCMD=99999;}
elseif($priCMD>=60000&&$fit&&$YesCMD||!$NoCMD&&$Min<=$i&&$i<=$Max){$priCMD=60000;}
elseif($fit||$YesCMD||!$NoCMD&&$Min<=$i&&$i<=$Max){$priCMD=40000;}
elseif(!$NoCMD){$priCMD=$priCMD=40000-($d=($i&&$Min>$i?($CMD=="prix"?200:0)+floor(10000*log(($Max-$i)/($Max-$Min))):($i>$Max?floor(10000*log(($i-$Min)/($Max-$Min))):0)));if($priCMD<20000){$priCMD=20000;}}
	else{$TRa.="6";$priCMD=2400;}
	if($NoCMD&&$priCMD>20000){$priCMD=20000;}
	if($priCMD<200){$priCMD=200;}
$MMOINS=$$MOINSMOINS;$OuvreParenthese=($NC_SW?"\x28":"");
if(!function_exists("nc")){
    function nc($i,$NC,$par="\x29"){global $NC_SW,$NC_text,$CMD;$OuvreParenthese="\x28";$FermeParenthese="\x29";if(!$NC_SW){return '';}
	if($NC_SW=='prix'&&$par!="\x29"){return "PRIX NUL=".(!$NC?"NON":"OUI")." and ";}
	if($NC_SW=='et'&&$par!="\x29" &&!$NC){return "et!=126 and ";}
	return "";
	if($par!="\x29"){
		return ($i&&$NC?$OuvreParenthese:"");
	}else{
		return ($i&&$NC
		?" or $NC_SW=0$FermeParenthese  and $NC_text nul=NON and prix nul=NON"
		:"$FermeParenthese and $NC_SW and $NC_text nul=NON and prix nul=NON" #.($CMD=="ARE"?$NC_SW:($CMD=="M2"?$NC_SW:""));
		);
	}
}}
($PLUSMOINS=="plus"&&$moins||$PLUSMOINS=="moins"&&$plus)&&($y=$x=" ou $MOINSMOINS")||($y=" ou $PLUSMOINS")&&($x="");
$p=$plus&&!$moins||(!$plus&&!$moins&&!($plus&&$moins))&&$PLUSMOINS=="plus";
!$NbB&&!$NC&&
	add_P_R_N_P_C_D($priCMD,"REP",$CMD, $PAK="$PREFIX$i".$x.($p?$NC:"")#.($MMOINS?$MMOINS:$NC)
	,$x=$p?nc($i,$NC,"(")."$i<=$CMD".nc($i,$NC):"$CMD<=$i"
	,"<b>$PAKNAME:</b> <b>$PAK</b>"
#." F$fit, (Y$YesCMD, $NoCMD), $Min<=$i<=$Max,p=".$priCMD."-LxA=/".strlen($LxA)."/".$NbA*2
	."|".formatnum($i)." $UNIT $y"#." ($x, $priCMD $Max)"
#.'|'.$priCMD."(Y$YesCMD, $NoCMD)"."/$Min<=$i<=$Max/"
	.($i>0&&$p&&$NC?" et inclure si $NC_text non communiqué$feminin":"")
	.Certain()."$DEB")
	;
!$NC&&$i!=$j&&Certain("");
if($NbA&&!$NbB&&$moins){$j=$i;$i=lowerrange($i);}
($NbB||!$$MOINSMOINS&&$PLUSMOINS=="plus")&&
	add_P_R_N_P_C_D($priCMD,"REP",$CMD ,$PAK="$PREFIX$i-".($j?$j:$i).$NC
	,nc($i,$NC,"(").($i==$j||!$j?"$CMD=$i":"$i<=$CMD").($i==$j||!$j?"":" and $CMD<=$j").nc($i,$NC)
	,"<b>$PAKNAME:</b> <b>$PAK</b>"
#." Unit=$Unit UG=$UG."
#." ~$fit, (Y$YesCMD N$NoCMD,U$Unit), $Min<=$i<=$Max,p=".$priCMD."--"#.str_replace('|',';',$NoRgx)."--".$TERMdeacquote
	."|".formatnum($i).($i==$j||!$j?" $UNIT exactement":" à ".formatnum($j)." $UNIT")." $NC".($i&&$NC?" ou $NC_text inconnu$feminin":"").Certain()."$DEB");

$NCok&&!$NC&&$i!=$j&&$i&&($NC="nc")&&
	add_P_R_N_P_C_D($priCMD,"REP",$CMD, $PAK="$PREFIX$i-$j$NC"
	,nc($i,$NC,"(")."$i<=$CMD and $CMD<=$j".nc($i,$NC)
	,"<b>$PAKNAME:</b> <b>$PAK</b>"."|".formatnum($i).($i==$j?"":" à ".formatnum($j))." $UNIT".($i&&$NC?" ou $NC_text inconnu$feminin":"").Certain()."$DEB");

!$NbA&&($i=90000);
#Glut si priorité à plus et term fini par -
#if($i&&!$NbB&&$PLUSMOINS=="plus"&&substr($term,-1)=='-'){$PLUSMOINS="moins";$$MOINSMOINS='';$NbB=1;}
!$NC&&!$$MOINSMOINS&&$i&&$i!=$j&&$NbB&&
	add_P_R_N_P_C_D($priCMD,"REP",$CMD, $PAK="$PREFIX$i$NC"
	,$PLUSMOINS=="moins"?"$CMD<=$i":nc($i,$NC,"(")."$i<=$CMD".nc($i,$NC)
	,"<b>$PAKNAME:</b> <b>$PAK</b> ou $PLUSMOINS"
	."|".formatnum($i)." $UNIT  ou $PLUSMOINS".($NC?" ou $NC_text inconnu$feminin":"")
	."$DEB");
} #END DRange
DRange($CMD='p',$PAKNAME='Pièces',$UNIT='pièces'
	,$UnitRgxL='(p(i([eè](c(es?)?)?)?)?)?'
	,$UnitRgxR='(p(i([eè](c(es?)?)?)?)?)?'
	,$PREFIX='F'
	,$PrefixRgx='(f|p(i([eè](c(es?)?)?)?)?)?'
	,$PLUSMOINS='plus'
	,$MaxPri='1-19',$MaxFit='1000'
	,$NoRgx="`^[/a-eg-oq-su-z]|[1-9][0-9]{4,}|^[a-z]{2}|[0-9][/a-oq-z]|[/abdghj-oqrt-z\xa4$\xb2]|(?-i:^T)`i"
	,$YesRgx='`^[fp][ ]?[-1-9](?:[- etoumoinsplusnc0-9]*)?$|^(([1-4][0-9]{0,3}|[5-9][0-9]{0,2})\b(-[1-4][0-9]{0,3}\b|[5-9][0-9]{0,3}\b)?|-[1-9][0-9]{0,3}\b)[ ]?(p(i([eè](c(es?)?)?)?)?)?\b[ oumoinsplusnc]*$`i'
	,$NCok='',$NC_SW='p',$NC_text='piece');
DRange($CMD='ch',$PAKNAME='Chambres',$UNIT='chambres'
	,$UnitRgxL='(ch(a(m(b(r(es?)?)?)?)?)?)'
	,$UnitRgxR='(ch(a(m(b(r(es?)?)?)?)?)?)'
	,$PREFIX='ch '
	,$PrefixRgx='(ch(a(m(b(r(es?)?)?)?)?)?)'
	,$PLUSMOINS='plus'
	,$MaxPri='1-19',$MaxFit='1000'
	,$NoRgx="`[3-9][0-9]{3,}|[0-9]{5,}|^[^c 0-9]|c[^h 0-9]|ch[ ]?[^0-9 ]|^[a-z]{3}|[0-9][ ]?([^c 0-9]|c[^h 0-9])|[\xa4$\xb2]|(?-i:^T)`i"
	,$YesRgx='`^(ch)[ ]?[-1-9](?:[- etoumoinsplusnc0-9]*)?$|^(([1-4][0-9]{0,3}\b|[5-9][0-9]{0,2}\b)(-[1-4][0-9]{0,3}\b|[5-9][0-9]{0,3}\b)?|(-[1-4][0-9]{0,3}\b|[5-9][0-9]{0,3}\b))[ ]?'.$UnitRgxR.'\b[ oumoinsplusnc]*$`i'
	,$NCok='',$NC_SW='ch',$NC_text='chambre');
DRange($CMD='et',$PAKNAME='Étage',$UNIT="\xb0 étage"
	,$UnitRgxL="(([\xb0]|&deg;)([ ]?[eé](t(a(ge)?)?)?)?|[éÉ](t(a(ge)?)?)?|et(a(ge)?)?)"
	,$UnitRgxR="(([\xb0]|&deg;)([ ]?[eé](t(a(ge)?)?)?)?|[éÉ](t(a(ge)?)?)?|et(a(ge)?)?)"
	,$PREFIX='et '
	,$PrefixRgx="(([\xb0]|&deg;)([ ]?[eé](t(a(ge)?)?)?)?|[éÉ](t(a(ge)?)?)?|et(a(ge)?)?)"
	,$PLUSMOINS='plus'
	,$MaxPri='1-9',$MaxFit='127'
	,$NoRgx="`[3-9][0-9]{2,}|[0-9]{4,}|^[/a-df-z]|^[a-z]{2}|[0-9][/a-oq-z]|[/bcdfh-su-z\xa4$\xb2]|(?-i:^T)`i"
	,$YesRgx='`^(et|[\xb0]|&deg;|é)[ ]?[-1-9](?:[- \xb0éetagoumoinsplusnc0-9]*)?$|^([1-4][0-9]{,2}\b|[5-9][0-9]?\b)?(-[1-4][0-9]{,2}\b|[5-9][0-9]?\b\b)?[ ]?(([\xb0]|&deg;)([ ]?[eé](t(a(ge)?)?)?)?|é(t(a(ge)?)?)?|et(a(ge)?)?)\b[ oumoinsplusnc]*$`i'
	,$NCok='',$NC_SW='et',$NC_text='étage');
DRange($CMD="prix" ,$PAKNAME="Prix" ,$UNIT="&euro;"
	,$UnitRgxL='(k?[e¤$]|k)'
	,$UnitRgxR='(k?[e¤$](u(r(os?)?)?)?|k)'
	,$PREFIX='e '
	,$PrefixRgx='(k?[e\xa4¤$]|k)'
	,$PLUSMOINS="moins"
	,$MaxPri="10000-99000000" ,$MaxFit="99000000"
        ,$NoRgx="`^e[/a-z]|^0[0-9]|(?:(?:01|1[347]|2[0159]|3[03458]|4[0249]|5[479]|6[0234789]|7[15-8]|8[039]|9[78])[0-9]{3}|(?:0[1-9]|[1-8][0-9]|9[1-578])[0-9]{2}0)[ ](?!eur|oum)[a-z]{3}|^[0-9]([/a-jl-z]|$)|[/\xb2,;.\x22\x27*\x28\x29@~?<>]|^[a-df-jl-z]|[1-9][0-9]*[ ]?([pmha]|[e¤][/am])`i"
        ,$YesRgx="`^e[ ]?([-1-9])|[$\xa4](?!/|[ma]\b)|\\b[1-9]([0-9]+[ ]?e|[0-9]*[ ]?k)(?![/ma])`i"
	,$NCok="1" ,$NC_SW="prix" ,$NC_text="prix"
	);
DRange(	 $CMD="s" ,$PAKNAME="Surface" ,$UNIT="m\xb2"
	,$UnitRgxL="(s|m(\xb2|2(?![0-9]))?)"
	,$UnitRgxR="(s|m([eêè](t(r(es?)?)?)?)?(\xb2|2(?![0-9]))?)"
	,$PREFIX="s "
	,$PrefixRgx='([sm][\xb2]?)?'
	,$PLUSMOINS="plus"
	,$MaxPri="20-400" ,$MaxFit="10000"
        ,$NoRgx='`^[a-ln-rt-z]|[1-9][0-9]*[ ]?([a-df-lnp-rt-z]|et)|[$¤/\x28\x29\x22\x27]`i'
        ,$YesRgx="`^[sm][ ]?([-1-9]|$)|[\xb2]|m2\\b|\\bm\\b|[[1-9][0-9]*[ ](m(\xb2|[eèê](t(r(es?))?)?\\b)?)`i"
	,$NCok="" ,$NC_SW="s" ,$NC_text="surface"
);
DRange();
DRange($CMD="M2" ,$PAKNAME="Prix/m\xb2" ,$UNIT="&euro;/m\xb2"
	,$UnitRgxL='((k?[e¤$]|k)(/|/?m(\xb2|2\b)?))'
	,$UnitRgxR='((k?[e¤$](u(r(os?)?)?)?|k)(/|/?m(\xb2|2\b)?))'
	,$PREFIX='e/m '
	,$PrefixRgx='((k?[e\xa4¤$]|k)/?m(\xb2|2\b)?)'
	,$PLUSMOINS="moins"
	,$MaxPri="500-20000" ,$MaxFit="99000"
        ,$NoRgx='`^(k?e|k)/?[a-ln-z]|^[a-df-jl-z]|[$\xa4]/?a|[0-9]/[0-9]|[1-9][0-9]*[ ]?([pmha])`i'
        ,$YesRgx="`^(k?e|k)(?:m|/m?)[ ]?([-1-9])|[$\xa4](/(?!a)|m)|\\b[1-9][0-9]*[ ]?[ke][/m]`i"
	,$NCok="1" ,$NC_SW="s" ,$NC_text="surface"
	);
DRange($CMD="ARE" ,$PAKNAME="Prix/Ca" ,$UNIT="&euro;/m\xb2 de terrain (centiare)"
	,$UnitRgxL='((k?[e¤$]|k)(/|/?(ca?|a)))'
	,$UnitRgxR='((k?[e¤$]|k)(/|/?(c(e(n(t(i(a(r(es?)?)?)?)?)?)?)?|a(r(es?)?)?)?))'
	#,$UnitRgxR='((k?[e¤$](u(r(os?)?)?)?|k)/c(a(r(es?)?)?)?)'
	,$PREFIX='e/c '
	,$PrefixRgx='((k?[e\xa4¤$]|k)/?c(a(r(es?)?)?)?)'
	,$PLUSMOINS="moins"
	,$MaxPri="10-9000" ,$MaxFit="99000"
        ,$NoRgx='`^[e¤]/?[bd-z]|^ch|^[abdf-z]`i'#'`^(k?e|k)/?m|^e/?(ca?)[a-z]|^[a-bdf-jl-z]|[$\xa4]/?m|[0-9]/[0-9]|[1-9][0-9]*[ ]?(e/?m|[pmha])`i'
        ,$YesRgx="`^(k?e|k)/?(ca?|a)[ ]?([-1-9])|[$\xa4]/?a|\\b[1-9][0-9]*[ ]?k?e/?a`i"
	,$NCok="1" ,$NC_SW="ja" ,$NC_text="surface"
	);
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

#+++++++++++++++++++++Suggest Transaction, property type,professional/private listing,Elevator option++++++++++++++++++++++++++++++++
if($cmdname!='ville'&& empty($_REQUEST['excl'])&&!$NbA){
$pribiens=(($cmdname!="BIENS")&&!empty($HASHcmds['BIENS'])?1000:30000);
#add_P_R_N_P_C_D(99999,"REP","BIENS" ,$PAK="BIENBIENS",            "BIENS in(\"Appt\")"   ,"<b>Biens:</b> <b>Biens</b> |..".print_r($Ag,true));
$is_BIENS=$LoopBiens=$LoopNotBiens=0;$Loopterm=$term;$BienPAK=$BienA=$BienCMD=$sep='';$maxscan=10;
$BiencmdA=Array('',' Loft Dupl Trpl Surf','',' Trpl',' Ferm Chal Mobi',' Surf','',' Surf','','','','','','','');
$Biencmds=Array('Park','Appt',        'Appt','Dupl', 'Mais',            'Grng','Imbl','Comm','Terr','Ferm','Chal','Mobi','Hotl','Loft','park');
$Bienpaks=Array('Parking','Appartement','Studio','Duplex','Maison','Grange','Immeuble','Commerce','Terrain','Ferme','Châlet','Mobil-home','Château','Loft','parking');
$BienpakA=Array(', boxe',', studio, loft, duplex, triplex, surface','',', triplex',', ferme, chalet, mobil-home',', ruine','',', bureau, entrepot','','','','',', hôtel-particulier','',', boxe');
while($Loopterm&&--$maxscan>0){$iBien=$is_BIENS=0;
if(preg_match('`^[ ]*(?:b(?-i:[ ]|(?=[A-Z])))'.($cmdname=="BIENS"?'?':'').'(?:'
.'(Ap?p?(?:r?t|a(?:r(?:t(?:e(?:m(?:e(?:nt?s?)?)?)?)?)?)?)?)'					#1
.'|(St?(?:u(?:d(?:io)?)?)?)'									#2
.'|(Du?(?:p(?:l(?:ex?)?)?)?|Tr(?:i(?:p(?:l(?:ex?)?)?)?)?)'					#3
.'|(Pa?(?:v(?:i(?:l(?:l(?:on?s?)?)?)?)?)?|Ma?(?:i(?:s(?:on?s?)?)?)?|Vi?l?l?a?)'			#4
.'|(Ru?i?n?e?|Gr?(?:a(?:n(?:ge?s?)?)?)?)'							#5
.'|(Im?m?(?:eu?)?(?:b(?:le?s?)?)?)'								#6
.'|(Bu?(?:r(?:e(?:a(?:ux?)?)?)?)?|Co?(?:mm?(?:e(?:r(?:ce?s?)?)?)?)?|Bu(?:s(?:i(?:n(?:e(?:ss?)?)?)?)?)?)'#7
.'|(Te?(?:r(?:r(?:a(?:in?)?)?)?)?)'								#8
.'|(Fe?(?:r(?:me?)?)?)'										#9
.'|(Ch?(?:[aâ](?:l(?:et?)?)?)?)'								#10
.'|(Mo(?:b(?:il?)?)?(?:[- ](?:h(?:o(?:me?)?)?)?)?)'						#11
.'|(H[ôo](?:t(?:el?|l)?[ ]?(?:p(?:a(?:r(?:t(?:i(?:c(?:u(?:l(?:i(?:er?)?)?)?)?)?)?)?)?)?)?)?|Ch[aâ]t(?:e(?:au?)?)?|Man(?:o(?:ir?)?)?)'#12
.'|(Lo(?:ft?)?|Surfa?c?e?)'									#13
.'|(Par(?:ki?n?g?)?|box)'									#14
.')\b`i',$Loopterm,$Ag)){!$sep&&($pribiens=99999);$iBien=$is_BIENS=count($Ag)-1;$Loopterm=trim(substr($Loopterm,strlen($Ag[0])));}
elseif(preg_match('`^[ ]*(?:'
.'(App?(?:r?t|a(?:r(?:t(?:e(?:m(?:e(?:nt?s?)?)?)?)?)?)?)?)'					#1
.'|(Stu(?:d(?:io)?)?)' 										#2
.'|(Dup(?:l(?:ex?)?)?|Tri(?:p(?:l(?:ex?)?)?)?)'							#3
.'|(Pav(?:i(?:l(?:l(?:on?s?)?)?)?)?|Ma(?:i(?:s(?:on?s?)?)?)?|Villa)'				#4
.'|(Ruine|Gr(?:a(?:n(?:ge?s?)?)?)?)'								#5
.'|(Imm?(?:eu?)?(?:b(?:le?s?)?)?)'								#6
.'|(Bur(?:e(?:a(?:ux?)?)?)?|Comm?(?:e(?:r(?:ce?s?)?)?)?|Bus(?:i(?:n(?:e(?:ss?)?)?)?)?)'		#7
.'|(Ter(?:r(?:a(?:in?)?)?)?)'									#8
.'|(Fer(?:me?)?)'										#9
.'|(Ch[aâ](?:l(?:et?)?)?)'									#10
.'|(Mob(?:il?)?(?:[- ](?:h(?:o(?:me?)?)?)?)?)'							#11
.'|(H[ôo]t(?:el?|l)?[ ]?(?:p(?:a(?:r(?:t(?:i(?:c(?:u(?:l(?:i(?:er?)?)?)?)?)?)?)?)?)?)?|Ch[aâ]t(?:e(?:au?)?)?|Man(?:o(?:ir?)?)?)'#12
.'|(Loft|Surface)'										#13
.'|(Parki?n?g?|box)'										#14
.')\b`i',$Loopterm,$Ag)){$iBien=$is_BIENS=count($Ag)-1;if(false&&strlen($Ag[$is_BIENS])>=4){Certain("*");}$Loopterm=trim(substr($Loopterm,strlen($Ag[0])));}
else{$iBien=$maxscan=0;if(preg_match('`\w`',$Loopterm)){$is_BIENS=($cmdname=="BIENS");($pribiens<=99900)&&($pribiens=20000);}$Loopterm='';}
  if($iBien&&$pribiens<=99900){$pribiens=$sep?99999:99900;}
  if(@$Biencmds[$iBien]&&!preg_match('`'.$Biencmds[$iBien].'`i',$BienCMD)){
  $BienPAK.=$sep.$Bienpaks[$iBien];
  $BienA.=($sep?', ':'').$Bienpaks[$iBien].$BienpakA[$iBien];
  $BienCMD.=$sep.$Biencmds[$iBien].$BiencmdA[$iBien];
  $sep=' ';
  }
}
if($sep&&$BienPAK&&$iBien){
  add_P_R_N_P_C_D($pribiens,"REP","BIENS",$PAK=$BienPAK, 'BIENS="'.str_replace(' ',' ',$BienCMD).'"'   ,"<b>Bien:</b> <b>$BienA</b>");
  $Ag=Array();
}
if($sep&&$BienPAK&&$pribiens>99900||!$BienPAK&&$pribiens<99900){$pribiens=$is_BIENS&&count($Ag)>1?99900:20000;}
           #add_P_R_N_P_C_D($x=@$Ag[1]?99999:$pribiens,"REP","BIENS" ,$PAK="Appart",	"BIENS=\"Appt Loft Dupl Trpl Surf\""   ,"<b>Bien:</b> <b>Appartement</b> |(ou duplex, studio etc..)".($x?Certain():""));
           add_P_R_N_P_C_D($x=@$Ag[1]?99999:$pribiens,"REP","BIENS" ,$PAK="Appart",	"BIENS=\"Appt Dupl Trpl\""   ,"<b>Bien:</b> <b>Appartement</b> |(ou duplex, triplex)".($x?Certain():""));
#$is_BIENS&&add_P_R_N_P_C_D(($x=@$Ag[2])?99999:$pribiens,"REP","BIENS" ,$PAK="Studio",	"BIENS=Appt" and p=1"   	,"<b>Bien:</b> Studio".($x?Certain():""));
$is_BIENS&&add_P_R_N_P_C_D(($x=@$Ag[3])?99999:$pribiens,"REP","BIENS" ,$PAK="Duplex Triplex","BIENS=\"Dupl Trpl\"","<b>Bien:</b> Duplex |(ou triplex)".($x?Certain():""));
           add_P_R_N_P_C_D(($x=@$Ag[4])?99999:$pribiens,"REP","BIENS" ,$PAK="Maison",	"BIENS=\"Mais Ferm Chal Mobi\""   ,"<b>Bien:</b> <b>Maison</b> |(ou ferme châlet mobil)".($x?Certain():""));
$is_BIENS&&add_P_R_N_P_C_D(($x=@$Ag[9])?99999:$pribiens,"REP","BIENS" ,$PAK="Ferme",	"BIENS=\"Ferm\""  	,"<b>Bien:</b> Ferme");
$is_BIENS&&add_P_R_N_P_C_D(($x=@$Ag[5])?99999:$pribiens,"REP","BIENS" ,$PAK="Grange",	"BIENS=\"Grng Surf\"","<b>Bien:</b> Grange |(ou surface)");
$is_BIENS&&add_P_R_N_P_C_D(($x=@$Ag[10])?99999:$pribiens,"REP","BIENS" ,$PAK="Châlet",	"BIENS=\"Chal\""   	,"<b>Bien:</b> Châlet");
$is_BIENS&&add_P_R_N_P_C_D(($x=@$Ag[11])?99999:$pribiens,"REP","BIENS" ,$PAK="Mobil-home","BIENS=\"Mobi\""	,"<b>Bien:</b> Mobil-home");
	   add_P_R_N_P_C_D(($x=@$Ag[6])?99999:$pribiens,"REP","BIENS" ,$PAK="Immeuble",	"BIENS=\"Imbl\"" 	 	,"<b>Bien:</b> <b>Immeuble</b>".($x?Certain():""));
	   add_P_R_N_P_C_D(($x=@$Ag[7])?99999:$pribiens,"REP","BIENS" ,$PAK="Commerce",	"BIENS=\"Comm\"" 		,"<b>Bien:</b> <b>Commerce</b>".($x?Certain():""));
           add_P_R_N_P_C_D(($x=@$Ag[8])?99999:$pribiens,"REP","BIENS" ,$PAK="Terrain",	"BIENS=\"Terr\""		,"<b>Bien:</b> <b>Terrain</b>".($x?Certain():""));
           add_P_R_N_P_C_D(($x=@$Ag[12])?99999:$pribiens,"REP","BIENS" ,$PAK="Hôtel particulier","BIENS=\"Hotl\""	,"<b>Bien:</b> <b>$PAK</b>".($x?Certain():""));
           add_P_R_N_P_C_D(($x=@$Ag[13])?99999:$pribiens,"REP","BIENS" ,$PAK="Parking"	,"BIENS=\"Park\""		,"<b>Bien:</b> <b>$PAK, Boxe</b>".($x?Certain():""));
#Chateau|Hotel BIENS=Hotl


$priowner=($cmdname=="OWNER"?99999:(($cmdname!="OWNER")&&!empty($HASHcmds['OWNER'])?1000:(preg_match('`^(?:a )?(age|pro|(par))`i',$term,$Ag)?50000:20000)));
add_P_R_N_P_C_D(($x=preg_match('`^Part(i(c(u(l(i(er?s?)?)?)?)?)?)?$`i',$term))&&Certain("*")?99999:$priowner+(@$Ag[2]?1:0)
	,"REP","OWNER" ,$PAK="Particulier", "PART","<b>Annonceur:</b> <b>Particulier</b>".Certain());
add_P_R_N_P_C_D(($x=preg_match('`^Proff?(e(ss?(i(o(nn?(el?)?)?)?)?)?)?$|^Age(\b|n(t|ce)s?)$`i',$term))&&Certain("*")?99999:$priowner
	,"REP","OWNER" ,$PAK="Professionnel","AGENCE" ,"<b>Annonceur:</b> <b>Professionnel</b>".Certain());
#add_P_R_N_P_C_D($priowner,"REP","OWNER" ,$PAK="Imobiliária e Particular","1" 	 ,"<b>Annonceur:</b> Todos");

$pritrans=(($cmdname!="e")&&!empty($HASHcmds['e'])?1000:20000);
add_P_R_N_P_C_D(($x=preg_match('`^[AÀ]? ??Ve(n(t(e(s)?)?$|^d([rs]?e?)?)?)?$`i',$term,$Ag)&&(@$Ag[3]&&!@$Ag[4]||@$Ag[5]||@$Ag[6]))&&Certain("*")?99999:(@$Ag[4]?99999:$pritrans)
	,"REP","e" ,$PAK="Vente", "VENTE","<b>Transaction:</b> <b>Vente</b> - A vendre".($x&&strlen($term)>4?Certain():""));
add_P_R_N_P_C_D(($x=preg_match('`^[AÀ]? ?(l(o(u(er?)?)?)?)?$|^Lo(c(a(t(i(on?)?)?)?)?)?$`i',$term,$Ag)&&(@$Ag[4]||@$Ag[7]))&&Certain("*")?99999:$pritrans
	,"REP","e" ,$PAK="Location", "LOCATION","<b>Transaction:</b> <b>Locations</b> - A louer".($x&&strlen($term)>4?Certain():""));
add_P_R_N_P_C_D(($x=preg_match('`^Ac(h([ea](t(e(u(rs?)?)?)?)?)?)?$|^Co(m(p(r(a(d(o(r(es?)?)?)?)?)?)?)?)?$`i',$term,$Ag)&&(@$Ag[3]||@$Ag[11]))&&Certain("*")?99999:$pritrans
	,"REP","e" ,$PAK="Acheteurs", "ACHETEURS","<b>Transaction:</b> <b>Acheteurs</b> - Annonces d'acheteurs".($x&&strlen($term)>6?Certain():""));
add_P_R_N_P_C_D(($x=preg_match('`^Vi(a(g(er?)?)?)?$`i',$term,$Ag)&&@$Ag[2])&&Certain("*")?99999:$pritrans
	,"REP","e" ,$PAK="Viager", "VIAGER","<b>Transaction:</b> <b>Viager</b> - Vente avec capital + rente".($x&&strlen($term)>4?Certain():""));

$priasr=(($cmdname!="asr")&&(!empty($HASHcmds['asr'])?20000:30000));
if(!$NbA&&($x=preg_match('`^Sans(?: a(?:s(?:c(?:e(?:n(?:s(?:e(?:ur)?)?)?)?)?)?)?)?|(asce?n?s?e?u?r?:? ?)?((?:diff(?:e(?:rr?e?(?:nt?)?)?)?(?: ?de?)?|exc(?:l(?:u(?:re)?)?)?(?: ?le?s? ?(?:a(?:nn?(?:o(?:n(?:c(?:es?)?)?)?)?) ?)? ?)?(?: ?precisant| ?indiquant)?) ?s?a?n?s? ?a?s?c?e?n?s?e?u?r?|pas d?[\x27 ]?|non )?'
		.'(?(2)$|)?(?:(sans)|(avec))?(?(1)| (a?s?c?)e?n?s?e?u?r? ?(i?n?d?i?q?u?e?))?$`i',$TERMdeac,$Ag))){
	if((@$Ag[1]||@$Ag[2]||@$Ag[5])&&(@$Ag[3]||@$Ag[4])){Certain("*");$priasr=99999;}
	!@$Ag[1]&&!@$Ag[2]&&!@$Ag[3]&&!@$Ag[4]&&!@$Ag[5]&&!@$Ag[6]&&
		add_P_R_N_P_C_D((preg_match('`^sans a(s(ce?)?)?n?s?e?u?r?$`i',$Deac)?99999:$priasr+10000),"REP","asr",$PAK="Sans ascenseur","asr=\"sans\"","<b>Ascenseur:</b> $PAK uniquement");

	!@$Ag[2]&&(@$Ag[4]||!@$Ag[3])&&add_P_R_N_P_C_D((preg_match('`^(avec)? ?asce?n?s?e?u?r? ?p?r?e?c?i?s?e?.?$`i',$Deac)?99999:$priasr+10000)
	,"REP","asr" ,$PAK="Ascenseur",              "asr=\"asc\""   ,"<b>Ascenseur:</b> Seules les annonces indiquant qu'il y a un  ascenseur".Certain());
	!@$Ag[4]&&add_P_R_N_P_C_D((preg_match('`^((avec)? ?asce?n?s?e?u?r?|exclure ?(le?s? ?(a(nn?(o(n(c(es?)?)?)?)?)?)? ?)?(s(a(n(s ?(a(sc?)?)?)?)?)?)?.*)$`i',$Deac)?99999:$priasr+10000)
	,"REP","asr"
	,$PAK= (@$Ag[3]
		?(@$Ag[2]?"Exclure ":"")."sans "
		:(@$Ag[2]&&!$Ag[4]?"Exclure sans":"exclure sans")
		)." asc"
	,"asr".(@$Ag[3]
		?(@$Ag[2]?"!":"")
		:(@$Ag[2]?"!":"!"))."=\"sans\""
	,"<b>Ascenseur:</b> "
		.(@$Ag[3]
		?@$Ag[2]?"Exclure les annonces \"sans ascenseur\"":"Seules les annonces indiquant \"sans ascenseur\""
		:"Exclure les annonces \"sans ascenseur\""
		).Certain());
}

$prian=(($cmdname!="an")&&(!empty($HASHcmds['an'])?20000:30000));
if($x=preg_match('`^(anci)(?:e(n)?)?|(mod)(?:e(?:r(?:n(e)?)?)?)?$`i',$TERMdeac,$Ag)){
	if(@$Ag[2]||@$Ag[4]){Certain("*");$prian=99999;}
	add_P_R_N_P_C_D($prian+10000
	,"REP","an" ,$PAK=(@$Ag[1]?"Ancien":"Moderne"),					'an="'.(@$Ag[1]?'an':'mo').'"'   ,"<b>Style:</b> $PAK".Certain());
	add_P_R_N_P_C_D($prian+10000
	,"REP","an" ,$PAK=(@$Ag[3]?"Éliminer style ancien":"Éliminer style moderne"),	'an!='.(@$Ag[3]?'an':'mo').'"'   ,"<b>Style:</b> $PAK".Certain());
}
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
}

#++++++++++++++++++++++++Add date suggestion++++++++++++++++++++++++++++	
if($cmdname!='ville'){
$pridate=(($cmdname!="date")&&!empty($HASHcmds['date'])?20000:30000);
$RgxDat='(?<=[DdJj]|\b)(0?[1-9]|[12][0-9]|3[01])/(0?[1-9]|1[012])?';#(/(?:20)?('.sprintf("(%02u|%02u)",date("y")-1,date("y")).'))?';
$RgxDat='(0[1-9]|[12][0-9]?|3[01]?|[4-9])/(0[1-9]|1[012]?|[2-9])?';#(/(?:20)?('.sprintf("(%02u|%02u)",date("y")-1,date("y")).'))?';
	if($x=preg_match('`^[DdJj][0-9]+([-/][0-9]+)*[-/]?(?:[DdJj][ayieour]s?)?$|^[0-9]+(/[0-9]{0,2})`',$term)){$pridate=99999;}
	#if(preg_match('`([0-9]{1,2})/([0-9]{1,2})?`',$term)){$pridate=99999;}
  $d2=date("d",time());
  $m2=date("m",time());
  $y2=date("y",time());
  $y4=date("Y",time());
  $m2d2="$m2-$d2";
function submon($m,$nm){return sprintf("%02u",$m-$nm+($m>$nm?0:12));}
function addmon($m,$nm){return sprintf("%02u",$m+$nm+($m+$nm<=12?0:-12));}
#if(preg_match('`[DdJj]?([12][0-9][0-9]?|36[0-5]|3[0-5][0-9]|3[0-9]?|[4-9][0-9]?)`',$term,$Ag)){
#	add_P_R_N_P_C_D($pridate,"REP","date" ,$PAK=$Ag[1]."Jours",	"21J<=date"   ,"<b>Depuis:</b> publiée depuis ".$Ag[1]." jours");
#}elseif(preg_match('`'.$RgxDat.'(-(([0-9])$|(0?[1-9]|[12][0-9]|3[01])(/(0)$|(0?[1-9]|1[012]))?)?)`',$term,$Ag)){
#}
				
if(preg_match('`^(j)?[ ]?([0-9]{1,3})[ ]?J(?:o(?:u(?:rs?)?)?)?$`i',$Deac,$Ag)){$D=$Ag[2];
	add_P_R_N_P_C_D(99999,"REP","date" ,$PAK="$D Jours",              "{$D}J<=date"   ,"<b>Depuis:</b> <b>$PAK</b> |<b>Annonces publiées depuis $PAK</b>");
}elseif(preg_match('`^j? ?(?:1[0-2]?|[2-9]) ?M'.($x=$NbA>0&&$NbA<=6?'(?:o(?:is?)?)?':'o(?:is?)?').'$|^(J(?:o(?:u(?:rs?)?)?)?[ ]?|De?(?:puis|s(?:de?)?:? ?)[ ]?)?0?([1-9][0-9]{0,2}) *([DdJj][iaeours]*)?$`i',$term,$Ag)&&(($D=$Ag[2])<=365)&&((preg_match('`^[DJ]|(J(?:o(?:u(?:rs?)?)?)?|M'.$x.')$`i',$LxA.';'.$LxB)&&($pridate=99999))||true)){
	(@$Ag[1]||@$Ag[3]&&($Term='j '.$NbA))&&$NbA&&($pridate=99999); # BIG CHEAT if Ag3 rewrite demande Term
	#add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="$n, $cmdname /  (debug)","DRang=\"$term\"" ,"<b>DEBUG:</b> <b>$PAK</b> $LxA $NbA-$LxB-$NbB $LxC".($x="<td class=\"bgcefefef\">")."\xa0$term|\xa0$pridate\xa0".print_r($Ag,true));
	if(!@$Ag[2]&&$NbA>0&&$NbA<=12){$D=$NbA;
	add_P_R_N_P_C_D($pridate,"REP","date" ,$PAK="$D Mois",              "{$D}M<=date"   ,"<b>Depuis:</b> <b>$PAK</b> |<b>Annonces publiées depuis $PAK</b>".($D>1?" (Temps de réponse parfois excessifs)":"")."");
	}
	@$Ag[2]&&add_P_R_N_P_C_D($pridate,"REP","date" ,$PAK="$D Jours",              "{$D}J<=date"   ,"<b>Depuis:</b> <b>$PAK</b> |<b>Annonces publiées depuis $PAK</b>");
}
if(preg_match('`(0[1-9]|[12][0-9]?|3[01]?|[4-9])/(0[1-9]|1[012]?|[2-9])?(?:-(0[1-9]|[12][0-9]?|3[01]?|[4-9])(?:/(0[1-9]|1[012]?|[2-9])?)?)?`i',$term,$Ag)){
	#for($i=0;$i<count($Ag);$i++){print $Ag[$i]."Check";}exit;
	$pridate=99999;
  $d0=sprintf("%02u",$Ag[1]);
  $d1=sprintf("%02u",!empty($Ag[3])?$Ag[3]:0);
  $m0=sprintf("%02u",!empty($Ag[2])?$Ag[2]:($d2>16?$m2:submon($m2,1)));
  $m1=sprintf("%02u",!empty($Ag[4])?$Ag[4]:0);
  $m =sprintf("%02u",!empty($Ag[4])?$Ag[4]:($m0?(($d0&&$d0<16||$m0==$m2)?$m0:addmon($m0,1)):$m2));
  $m0=sprintf("%02u",$m0?$m0:($d0>$d1?submon($m,1):$m));
  $m1=sprintf("%02u",!empty($Ag[4])?$Ag[4]:(($d0<$d1||$m0>=$m2)?$m0:addmon($m0,1)));
	#add_P_R_N_P_C_D($pridate,"REP","date" ,$PAK="$d0/$m0-$d1/$m1", "\"$PAK\"<=date"   ,"<b>Depuis $d0/$m0 a $d1/$m1:</b> T- publicado entre $d0/$m0 e $d1/$m1".($C_Debug?"&lt;":"<")."img class=datepicker src=\"/body_a/pencil.png\">");
  if($d0>0 && $d1>0 && $m0>0){
	add_P_R_N_P_C_D($pridate,"REP","date" ,$PAK="$d0/$m0-$d1/$m1", "\"$PAK\"<=date"   ,"<b>Depuis:</b> <b>le $d0/$m0 jusqu'au $d1/$m1</b> | (publiées entre le $d0/$m0 et le $d1/$m1).");#> d1=$d1 m=$m ".print_r($Ag,true));
  }
}
if(preg_match('`^(?:D(?:e(?:s(?:de?)?:? ?)?)?)?[DdJj]?'.$RgxDat.'-?$`i',$term,$Ag)){
	$pridate=99999;
	$D0=sprintf("%01u/%01u",$d0,$m0);
	$I=sprintf("%02u-%02u",$m0,$d0);$D=sprintf("20%02u-%02u-%02u",$I>$m2d2?$y2-1:$y2,@$Ag[2],$Ag[1]);
	$tim0=strtotime($D);
	$tim1=(time()-$tim0>86400*15?86400*15+$tim0:time());
	$D1=preg_replace('`\b0+`','',date("d/m",$tim1));
	#add_P_R_N_P_C_D($pridate,"REP","date" ,$PAK="$D0-$D1",              "\"$PAK\"<=date"   ,"<table class=syh1e style=\"width:100%\"><tr><td style=\"width:90%\"><b>Depuis:</b> $D0 a $D1 A- publicado entre $D0 e $D1&nbsp;</td><td style=\"text-align:right;width=10%\">".($C_Debug?"&lt;":"<")."img class=datepicker src=\"/body_a/pencil.png\"></td></tr><table>");
	add_P_R_N_P_C_D($pridate,"REP","date" ,$PAK="$D0-$D1",              "\"$PAK\"<=date"   ,"<b>Depuis:</b> <b>le $D0 jusqu'au $D1.</b> |Publiées entre le $D0 et le $D1");
}
if(@$D!=21){
	add_P_R_N_P_C_D($pridate-1,"REP","date" ,$PAK="21 Jours",		"21J<=date"   ,"<b>Depuis:</b> <b>21 Jours</b>| <b>Annonces publiées il y 21 jours ou moins</b> (par défaut)");
}
}
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

#+++++++++++++++++++++++++Department Suggestion++++++++++++++++++++++++
if(	($pri=30000)
	&&(!$cmdname
	||($cmdname=="de"||$cmdname=="ville")&&($pri=99999)
  	)
){
    $N=$term;$I=$J=0;
    if(preg_match('`'.($cmdname=="ville"?'\b':'^(?-i:(?:v|de?)[ ]*(?=[0-9A-Z]|$))?').'(0[1-9]|[1-8][0-9]|9[0-578])[ ]*(?:\x28[^\x28\x29]*\x29[ ]*)?$`i',$Deac,$Ag1)){
	$N=$I=$J=$Ag1[1];
	}
	elseif(preg_match('`^(?-i:(?:v|de?)[ ]*(?=[0-9A-Z]|$))?([A-Z][- .\x27A-Za-z]*)$|^(?=[- .\x27A-Za-z]{3})(?:de?[ ])?(?!de?[ ]?[A-Z])([A-Za-z][- .\x27A-Za-z]*)$`',$Deac,$Ag1)){
		$I=1;$J=98;
		$N=preg_replace(Array('`([a-z0-9])[^.a-z0-9]+`i','`[.]`')
				,Array('$1[^a-z0-9]','\.'),@$Ag1[1].@$Ag1[2]);
    }
    for($i=$I;$i<=$J;$i++){
	$n=$i;$fit=false;$Ag=Array(false,false,false);
	if($i<10){$n=sprintf("%02u",$i);}
	#add_P_R_N_P_C_D(999999,"REP","ville" ,$PAK="$n, $cmdname /  (debug)","DRang=\"$term\"" ,"<b>DEBUG:</b> <b>$PAK</b> $LxA $NbA-$LxB-$NbB $LxC".($x="<td class=\"bgcefefef\">")."\xa0$term|\xa0");
	if((!empty($DEPARTEMENTS[$n])&&($dep=$DEPARTEMENTS[$n])&&($depd=Deac($dep,true,false)))#||((print "ERREUR $n ($N)\n"))
	&&(
	    ($fit=(($n===$N)?" OK1 ":""))
	    ||($fit=(((strlen($TERMdeac)>1)&&(preg_match("`\b$N`i",$depd)||preg_match("`\b$N`i",$n.' '.$depd)))?" OK2 ":""))
	)){$DeacSearchLoc=$n;
	$DeacToContinue=$Deac;
		add_P_R_N_P_C_D($x=$fit&&($n===$N||strlen($TERMdeac)>3)?99999:$pri
			,"REP","ville"
			,$PAK=(@$Ag[2]&&$Ag[2]!=$dep?"$n {$Ag[2]} ($dep)":"$n ($dep)")
			#,$PAK=(@$Ag[2]&&$Ag[2]!=$dep?"$n {$Ag[2]} ($dep)":"$n ($dep)")
			,"ville=\"$i".(@$Ag[2]?" ".preg_replace('`[-/\x27 ]`',' ',$Ag[2])."":"")."\""
			#,"de=\"$i\"".(@$Ag[2]?" and ville=<\"".preg_replace('`[-/\x27 ]`',' ',$Ag[2])."\"":"")
			,"<b>Ville:</b> <b>Département $n".(@$Ag[2]&&$Ag[2]!=$dep?"<span title=\"($dep)\"> {$Ag[2]}</span>":"")." |($dep)"
			);
	}
    }
}
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		

#+++++++++++++++++++++Add a word search suggestion if it is explicitly requested+++++++++++++++++++++
$prinote=(($cmdname!="NOTES")&&!empty($HASHcmds['NOTES'])?1000:20000);
	#add_P_R_N_P_C_D($prinote,"REP","NOTES" ,$PAK="NOTAS" ,"NOTES" ,"<b>Notas</b>: Annonces em que <b>sua equipe</b> escreveu uma nota");
if(!preg_match('`\b(exclure|annonces?)\b|^j? ?[1-9][0-9]{1,2}[ ]?(Jo?u?r?s?|Mo?i?s?)|^(?-i:[a-z][ A-Z])|^[a-zà-ÿÀ-ÜA-Z\xa4](/?[a-zà-ÿÀ-ÜA-Z\xb2]|/)?[ ]|^(et|ch|[eéstfm\xb0]|cp|k?[a-z]/[a-z]?)[ -]?[0-9]|[=]`i',$termquote)){
$PAKname="Mots";$PAKname_L=strlen($PAKname);$MinPakNameTerm=($PAKname_L<$term_is_pak_L?$PAKname_L:$term_is_pak_L);
$NOprimots=(
	!	($YESprimots=!preg_match('`^0[1-9]|^([a-z]/?[ma]?)?[1-9][0-9]*(-([1-9][0-9]*)?)? ?ou? ?(mo?i?n?|pl?u?)s?$|9[0-578][ ]?(\x28.*)?$|[0-9a-z][-+\x28]`i',$myterm)
	 		&&preg_match('`^[-"+\x28]|^(?=.*[a-z])[-+\x28\x29\x22 a-z0-9]{14,}$`i',$myterm)
		)
	 	&&(@$Agcp[3]||@$cmdname&&$cmdname!='MOT')
	?1
	:0);
$primots=(!$YESprimots&&(!(substr($term,0,1)=='"'||substr($term,0,1)=='+')&&($cmdname!="MOT")&&$term_is_pak&&substr($PAKname,$MinPakNameTerm)!=substr($term_is_pak,0,$MinPakNameTerm) 
	||(!empty($HASHcmds['MOT'])&&$cmdname!='MOT'||preg_match('`^(Ha|[pasmtTFf])[1-9]|^[1-9][0-9]*(t|m2?)\b|^[^? ]{0,2}$|(^|k?[emt])[ ]?(?:[1-9][0-9]?[ ]?(?:[0-9]{3}[ ]?)?)?[0-9]00(?:-|$)`',$term))
	  )?12000:29000);
if(preg_match('`^""?[^"].+$|(^)(?![0-9]{1,3}0*$|[stea]?[0-9]+[- ]ou (?:plus|moins))([a-z0-9]{1,50}(?:[ ][a-z0-9]{1,50})*)`i',$myterm,$AgMots)&&preg_match('`[a-z0-9]([^a-z0-9]*[a-z0-9]){2,}`i',$TERMdeac)){
	$x=preg_replace(
	  Array('`\b(drop|truncate|delete|system)\b`'
	 ,'`^"((?:[-+]?(?:"[^-+"]+"|\b[A-Z0-9]+\b)[ ]?)+)"?$`i' #No accent
	 ,'`;;;\b([a-z0-9]+)(\x29?[-+]|\x29?[^-+a-z0-9\x22])[^-+a-z0-9\x22]*\x28?(?:(?=[a-z0-9])|$)`i'
	 ,'`[ ]$`'
	 ,'`^"?((?:[A-Z0-9]+[^A-Z0-9]+)*'
		.'\b([A-Z0-9]{1,2}'
		.'|avenue|boulevard|cour|mur|fond|appartement|une|des|les'
		.'|rue|route|ville|vue|mer|place|quai|sainte?|elle|comme|quand'
		.'|maison|piece|salon|cuisine|sdb|salle|bain|fai|immo|I@D'
		.'|chambre|sous|dans|sur|pre|km|metre|euro|val|lac'
		.')s?\b'
		.'(?:[,. ]+(?:[A-Z0-9]+))*'
	    .')"?$`i'
	),Array(''
	 ,'"$1"'
	 ,'$1 '
	 ,''
	 ,'"$1"'
	),$myterm);
	$Str=$x;if(strlen($x)>80){$x=substr($x,0,47).'...';}
	empty($_REQUEST['excl'])&& add_P_R_N_P_C_D($y=preg_match('`(^"|"$|[ ][-+]"?[a-z])|^(?!saint|st)[a-z]+[ ][a-z]`',@$TERMdeacquote,$Ag)&&$YESprimots?(count($Ag)?99999:99900):$primots,"REP","MOT"
	,$Str
	,"MOT=\"".preg_replace(Array('`("vue) +(?:(?:su?$|sur)(?: l[ae]s?)?\b ?)?((?:(?:[a-z]{1,26}\b)[^"]*")+)`i','`"`','`(?=[-+]+)`'),Array('$1 $2 $1 sur $2 $1 sur la $2 $1 sur le $2 $1 sur les $2','`',' '),$Str)."\""
	,"<b>Mots: </b> <span title=\"$Str\">$x</span> dans l'annonce"
	#.$y
	);
}elseif(preg_match('`^(?:Mots:|([-+]))[ ]*([^ ].*)$`i',$myterm,$AgMots)){
if(!isset($AgMots[1])
&&preg_match('`^([\x60\x22])?[^\x60\x22]*(?(1)\1?)$`',$AgMots[2],$AgQ)
&&preg_match('`(^|[^a-zA-ZÀ-Üà-ÿ0-9])[a-zA-ZÀ-Üà-ÿ0-9]{1,2}([^a-zA-ZÀ-Üà-ÿ0-9]|$)`',$AgMots[2])){$AgMots[2]='+'.($x=($AgQ[1]?'':'"')).$AgMots[2].($x);}
	add_P_R_N_P_C_D(99999-$NOprimots,"REP","MOT",$x=@$AgMots[1].$AgMots[2],"MOT=\"".preg_replace(Array('`"`','`(?=[-+]+)`'),Array('`',' '),$x)."\"","<b>Mots: </b> <b>$x</b> dans le texte" 
);}     
}
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


#{++++++++++++++++++++++Adding a word search suggestion+++++++++++++++++++++++++++++++
elseif(("MOT"==$cmdname||"pr3"==$cmdname||"NOTA"==$cmdname||"NOTES"==$cmdname)
  &&(preg_match('`^(?![0-9]0{0,3}(?:[- ]|$)|^[0-9a-zà-ÿA-ZÀ-Ü][0-9]+-)((?i:Mo(?:ts?)?\b: ?)?)([-?+ ,\x60\x22\x27\x28\x29/0-9a-zA-Zà-ÿÀ-Ü]*|[0-9]{9})$`',$term,$Ag)
		||(@$cmdname=="MOT")&&$Ag=Array('ok',''))
	&&((@$Ag[1]||(@$cmdname=="MOT")||preg_match('`[-+\x28\x22]`',$term))&&($primots=99999-$NOprimots)||true)
	&&(preg_match('`^[^-+\x22]*$`',$Ag[2])
		&&preg_match('`(^|[^0-9a-zA-Zà-ÿÀ-Ü\x22])((?i:[0-9]+|surface|pour|sont|Saint|Rue|Boulevard|Tour|Ville|d[eu]s)|[0-9a-zA-Zà-ÿÀ-Ü]{1,2})([^0-9a-zA-Zà-ÿÀ-Ü\x22]|$)`',$Ag[2])
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

	#add_P_R_N_P_C_D(preg_match('`[^ ]-|\b(?![1-9]{1,3}0{2,}\b)(?:([1-9][0-9]{4,7})|[0-9]{1,4})\b`',$term,$r)?(@$r[1]?30000:26000):$primots,"REP","MOT" ,$PAK=preg_match('`"[^\x22]*"`',$x)?$x:"$x" ,"MOT=\"".preg_replace(Array('`"`','`(?=[-+]+)`'),Array('`',' '),$x)."\"" ,"<b>Mots: </b> Annonces avec <b>".($x?$x:"Ces mots")."</b> dans le texte de l'annonce");
        add_P_R_N_P_C_D(preg_match('`[^ ]-|\b(?![1-9]{1,2}0{1,}\b)([1-9][0-9]{4,7})\b|(?![1-9]{1,3}0{2,}\b)[0-9]{1,6}\b`',$term,$r)?(@$r[1]?30000:28000):$primots,"REP","MOT" ,$PAK=preg_match('`"[^\x22]*"`',$x)?$x:"$x" ,"MOT=\"".preg_replace(Array('`"`','`(?=[-+]+)`'),Array('`',' '),$x)."\"" ,"<b>Mots: </b> Annonces avec <b>".($x?$x:"Ces mots")."</b> dans le texte de l'annonce");

	#(strlen($term)<6)&& add_P_R_N_P_C_D($primots,"REP","MOT" ,($PAK=$y=" +piscina -\"piscina publica\"") ,"MOT=\"".preg_replace('`"`','`',$y)."\"" ,"<b>Palavras: </b> $y Annonces com piscina particular no texto do anúncio");
	if(preg_match('`^ascenseur`',$term)){
	add_P_R_N_P_C_D($primots,"REP","MOT" ,($PAK=$y=" +$x -\"sans $x\"") ,"MOT=\"".preg_replace('`"`','`',$y)."\"" ,"<b>Mots: </b> $y Annonces contenant : <b>\"$x\"</b> mais pas : <b>\"sans $x\"</b> dans le texte.");
	}}
#}++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

#++++++++++++++++++Adding search notes suggestion+++++++++++++++++++++++++++++++++++++

if($SNOM&&$sid&&preg_match('`^(?:Voir)?(?: ?le)?(?: ?contenu(?: ?du)?)? ?(((?i:c(?i:a(?:d(?:d(?:ie?)?)?)?)?))$|[Nn](?:o(t(?:es?)?)?)?(:)?"?[ ]?)((?:([A-Z])|[a-z0-9])[a-zA-Z0-9]*?(?:[- \x27]\w+)*)?[- \x27"]*$`',$TERMdeacquote,$Ag)&&(!$cmdname||"MOT"==$cmdname||"pr3"==$cmdname||"NOTA"==$cmdname||"NOTE"==$cmdname)
  ){
	$x=($C_Debug?"&lt;":"<")."img src=\"/body_a/pencil.png\">";
	if($C_Debug){print "************ /".$_COOKIE["CKVARS"]."/\nterm=$term<BR>\n\n";}
if(@$Ag[1]
	&&(	(@$Ag[1]==$TERMdeacquote||@$Ag[6]||@$Ag[3]||@$Ag[4]||@$cmdname=='NOTES')&&($prinote=99999)
		||(@$Ag[5]||!$term_is_pak)&&(($prinote=$primots-1)||1)
	)
){
	if($monot=strtolower(($c=!empty($Ag[2]))?'Caddie':@$Ag[5])){
	add_P_R_N_P_C_D($prinote,"REP","NOTA" ,$PAK=($c?"Caddie":"n".ucwords($monot)) ,"NOTES=\"$SNOM\" and NOTA=\"".$monot."\" and 365J<=date" 
	,$c?"<b>Caddie:</b> <b>Caddie</b> |Contenu de votre caddie"
	   :"<b>Notes:</b> <b>$PAK</b> |Annonces annotées avec le mot clé <b>\"$monot\"</b>");
	}
#($SNOM=querysdb("select snom from sup where sid=\"".str_replace('"','',$_REQUEST['sid'])."\""))){
	if(!$c){
	add_P_R_N_P_C_D($prinote,"REP","NOTES" ,$PAK="notes" ,"NOTES=\"$SNOM\"" ,"<b>Notes:</b> <b>Notes</b> prises par $SNOM| Voir les annonces que j'ai annotées ou mises en caddie\xa0<b>($x Compte selectim: $SNOM $x)</b>");
	}
}
}
#++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
finish();
?>
