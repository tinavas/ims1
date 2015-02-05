   <?php


include("createxslfromtable.php");
include("mainconfig.php");
session_start();
$_SESSION['db'] = "";
$_SESSION['sectorall'] = "";
$_SESSION['sectorlist'] = "";
$_SESSION['sectorwarelist'] = "";
$_SESSION['superadmin']="";
$_SESSION['superstockistlist']="";


// due users list
$duearray[1]='alpine';
$duedb[1] = 'suriya';
 $user=$_POST['username'];
 $pass=$_POST['pass'];
 

$get_entriess = "select * from tbl_users where username='$user' and password='$pass' order by id desc ";
$get_entriess_res1 = mysql_query($get_entriess,$conn) or die(mysql_error());
$n=mysql_num_rows($get_entriess_res1);
if($n>0)
{
 while ($post_info = mysql_fetch_array($get_entriess_res1)) {
 
$flag=0;
/*$u="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$url=parse_url($u);
$url1=$post_info['url'];

 if($url['host']==$url1)
 $flag=0;
 else
 $flag=1;*/
 
if($flag==0)
{
      $uname = $post_info['username'];
	  $email = $post_info['email'];
      $password = $post_info['password'];
      $client = $post_info['client'];
      $db = $post_info['dbase']; 
	  $sectorr = $post_info['sectortype'];
	  $currency = $post_info['currency'];
	   $millionformate=$post_info['millionformate'];
	  $authorizesectors=$post_info['authorizesectors'];
	  $country = $post_info['country'];
	  $admin=$post_info['admin'];
	   $superadmin=$post_info['superadmin'];
	    $superstockist=$post_info['authorizesuperstockists'];
	  
	
	  // due payment condition
	  if(in_array($uname,$duearray) || in_array($db,$duedb) ) 
	    { 
		header('Location:alert.html');
		exit;
		}
	  
//$sectorlist = "'dummy'";$sectorlist1 = "'dummy'";
//$sectorrwarelist = "'dummy'";
$sectorlist = "";$sectorlist1 = "";
$sectorrwarelist = "";
$sectorarr = "";
$df = 0;
$sectorcnt = 0;
$query = "SELECT count(*) as c1 FROM tbl_users WHERE username = '$uname' and sectortype = 'all'";
$result = mysql_query($query,$conn); 
if($row1 = mysql_fetch_assoc($result))
{ 
  $sectorcnt = $row1['c1'];
}
if($sectorcnt > 0)
{
$sectorall = "all";
$_SESSION['sectorall'] = $sectorall;
}
else
{
	$sectorall = "";
	$_SESSION['sectorall'] = $sectorall;
	 $query = "SELECT distinct(sectortype) as  sectortype FROM tbl_users WHERE username = '$uname'";
	$result = mysql_query($query,$conn); 
	while($row1 = mysql_fetch_assoc($result))
	{ 
	if($df == 0)
	{
	$sectorlist = "'dummy'";$sectorlist1 = "'dummy'";
	$sectorrwarelist = "'dummy'";
	}
	$sectorarray = "";$j = 0;
	$sectorarray = explode(',',$row1['sectortype']);
	for($j=0;$j<count($sectorarray);$j++)
	{
	$sectorarr[$df] = $sectorarray[$j];
	$df++;
	}
	$sectortype = str_replace(',',"','",$row1['sectortype']);
							
	  $sectorlist1 = $sectorlist1 . ",'" . $sectortype . "'";
	  
	  $sectorlist = $sectorlist . ",'" . $sectortype . "'";
	  
	}
	
}
	  
if ($user == $uname and $pass == $password )
 {
  $_SESSION['valid_user'] = $user;
  $_SESSION['valid_email'] = $email;
  $_SESSION['sectorr'] = $sectorr;
  $_SESSION['client'] = $client;
  $_SESSION['authorizesectors'] = $authorizesectors;
  $_SESSION['admin']=$admin;
  $_SESSION['superadmin']=$superadmin;
  
   $_SESSION['millionformate']=$millionformate;
   
   $_SESSION['superstockistlist']= $superstockist;
  
  $query5 = "SELECT * FROM countries WHERE country = '$country'";
  $result5 = mysql_query($query5,$conn) or die(mysql_error());
  $rows5 = mysql_fetch_assoc($result5);
  $_SESSION['country'] = $country;
  $_SESSION['currency'] = $rows5['currency'];
  //$_SESSION['millionformate'] = $rows5['millionformat'];
  $_SESSION['datephp'] = $rows5['dateformat'];
  $_SESSION['datejava'] = $rows5['dateformat2'];
  $_SESSION['weight'] = $rows5['weight'];
  $_SESSION['idcard'] = $rows5['idcard'];
  $_SESSION['tax'] = $rows5['tax'];
  
  if($_REQUEST['company'] == "0") {  
   $_SESSION['db'] = $db; } 
  else { 
  	$_SESSION['db'] = $_REQUEST['company'];
	if($_SESSION['db'] == 'medivet') $_SESSION['client'] = 'MEDIVET';
	elseif($_SESSION['db'] == 'ncf') $_SESSION['client'] = 'NCF';
	elseif($_SESSION['db'] == 'mlcf') $_SESSION['client'] = 'MLCF';
	elseif($_SESSION['db'] == 'tnm') $_SESSION['client'] = 'TNM';
	elseif($_SESSION['db'] == 'mbcf') $_SESSION['client'] = 'MBCF';
  } 
  
  include "config.php"; 
  if($sectorcnt > 0)
  {
  $query2 = "SELECT * FROM tbl_sector";
  $result2 = mysql_query($query2,$conn); 
  while($row2 = mysql_fetch_assoc($result2))
  {
	 $sectorrwarelist = $sectorrwarelist.",'". $row2['warehouse']. "'";
	 $sectorlist = $sectorlist.",'". $row2['sector']. "'";
  }
    $_SESSION['sectorlist'] = substr($sectorlist,1);
    $_SESSION['sectorwarelist'] = substr($sectorrwarelist,1); 
  }
  else
  {
  for($i = 0;$i<count($sectorarr);$i++)
  {
  $sect = $sectorarr[$i];
  $query2 = "SELECT * FROM tbl_sector where sector = '$sect'";
  $result2 = mysql_query($query2,$conn); 
  while($row2 = mysql_fetch_assoc($result2))
  {
	 $sectorrwarelist = $sectorrwarelist.",'". $row2['warehouse']. "'";
  }
  }
  $sectorlist = $sectorlist.",".$sectorrwarelist;
  $_SESSION['sectorlist'] = $sectorlist;
  $_SESSION['sectorwarelist'] = $sectorrwarelist; 
  }
  
  
  include "config.php"; 
$q1=mysql_query("select employeeid,employeename from common_useraccess where username='$user'")  or die(mysql_error());
 $r1=mysql_fetch_array($q1);
 $sessionempid=$r1['employeeid'];
 $sessionempname=$r1['employeename'];
 $ddate=date("Y-m-d");
 //$ddate="2015-01-31";
$prev=mysql_query("select date_sub('$ddate',interval 1 month) as dd;") or die(mysql_error()) ;
$pv=mysql_fetch_array($prev);
$pdate=$pv['dd'];
$ppd=explode("-",$pdate);
 $ddform=$ppd[0]."_".$ppd[1]."_".$ppd[2]."_".$db.".xls";

 $exp=explode("-",$ddate);
 $dateform=$exp[0]."-".$exp[1];
 $filename=$exp[0].$exp[1].$exp[2].".sql";
 $ccfile=$exp[0].$exp[1].$exp[2].".xls";
 $dbfile=$filename;
 $q5=mysql_num_rows(mysql_query("select * from logregister where monthyear='$dateform'"));

 if($q5=="")
 {
 createxsl($db,"localhost","tulA0#s!","poultry",$ddform);
 
 //$flag=backup_tables($dbfile,'localhost','poultry','tulA0#s!',$db);
// if($flag==1)
 //{
 include "config.php";
 $q6=mysql_query("insert into logregister(date,empid,empname,filename,monthyear,amy) values('$ddate','$sessionempid','$sessionempname','$ddform','$dateform','$pdate')") or die(mysql_error());
 $q7=mysql_query("delete from logdetails")or die(mysql_error());
 //}
 }
 
 

/* $q2=mysql_num_rows(mysql_query("select * from logdetails where date='$ddate' and empname='$sessionempname'"));
 if($q2=="")
 {
 $logno=1;
 }
 else
 {
 $logno=$q2+1;
 }
 $sessionid=$ddate."-".$sessionempid."-".$logno;
 //$timee=date("H:i:s"); 
 $sql=mysql_query("select time(now()) as currenttime;") or die(mysql_error());
 $q=mysql_fetch_array($sql);
 $timee=$q['currenttime'];
 $_SESSION['sessionid']=$sessionid;
 
 $q3=mysql_query("insert into logdetails (date,sessionid,empname,empid,sessionstarttime) values('$ddate','$sessionid','$sessionempname','$sessionempid','$timee')") or die(mysql_error());
 
 
 
 
 //Getting the information of the user starts here

$iplocid=mysql_connect("localhost","root","tulA0#s!");

mysql_select_db("users",$iplocid);

$real_client_ip_address=$_SERVER['REMOTE_ADDR'];

//get the inforamtion from geoip plugin

$alldata=unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$real_client_ip_address));

$locusename=$user;
$dbname=$db;
$continentcode=$alldata['geoplugin_continentCode'];
$countrycode=$alldata['geoplugin_countryCode'];
$countryname=$alldata['geoplugin_countryName'];
$cityname=$alldata['geoplugin_city'];
$regionname=$alldata['geoplugin_region'];
$citylattitude=$alldata['geoplugin_latitude'];
$citylongitude=$alldata['geoplugin_longitude'];
$remote_addr=$_SERVER['REMOTE_ADDR'];
$http_forwarded=$_SERVER['HTTP_X_FORWARDED_FOR'];
//-----
//--infomation from website

$context = stream_context_create(array('http' => array('header'=>'Connection: close\r\n')));
$html=file_get_contents("http://www.ipaddresslocation.org/ip-address-locator.php?lookup=$real_client_ip_address",false,$context);
	 preg_match_all("/<b>.*<\/b>/",$html,$val);
	$val1=$val[0];
	unset($val1[0]);
	unset($val1[1]);
	$impinfo=strip_tags(implode("/",$val1));
	
	//-------------------
	
	//--------------------

$ipinfo=file_get_contents("http://ipinfo.io/$real_client_ip_address");
//---------------------------


  $locsql="INSERT INTO `users_locations` ( `username`, `dbname`,sessionid, `ipaddress`, `continentcode`, `countrycode`, `countryname`, `regionname`, `cityname`, `citylattitude`, `citylongitude`,  `http_forwarded`, `impinformation`, `ipinfodata`) VALUES ('$locusename', '$dbname','$sessionid' ,'$real_client_ip_address', '$continentcode', '$countrycode', '$countryname', '$regionname', '$cityname', '$citylattitude', '$citylongitude',  '$http_forwarded', '$impinfo', '$ipinfo');";
  
  
$locsql=mysql_query($locsql,$iplocid) or die(mysql_error());
mysql_close($iplocid);
*/
//end of getting the user information

 
 
 
 
 
 
 
 
 
include "mainconfig.php";


 $a="select attempts from  blockedusers where  uname='$user'";
 $q1=mysql_query($a,$conn) or die(mysql_error());
$r1=mysql_fetch_array($q1);
$r1[attempts];
if(intval($r1[attempts])>=3) 
{
echo $r1[attempts];
$a=mysql_query("select now() as n,DATE_ADD(updated, INTERVAL '0 24' DAY_HOUR) as d from blockedusers ",$conn) or die(mysql_error());
$a1=mysql_fetch_array($a);
if(strtotime($a1[n])>=strtotime($a1[d]))
{
$q=mysql_query("delete from blockedusers where  uname='$user'");
 echo "<script type='text/javascript'>";
echo "document.location='dashboard.php?page='";
echo "</script>";
}
else
{
 echo "<script type='text/javascript'>";
echo "alert('Please Try Login after Some time');";
unset($_SESSION[db]);
echo "document.location='blocked.php?uname='$user";
echo "</script>"; 
}
}
else  
{
 echo "<script type='text/javascript'>";
echo "document.location='dashboard.php?page='";
echo "</script>";
  }
 }
 }
}
}
else
{
$dt=date("Y-m-d");
$q1=mysql_query("select attempts from  blockedusers where uname='$user'") or die(mysql_error());
$r1=mysql_fetch_array($q1);
if($r1[attempts]>0)
$q=mysql_query("update blockedusers set attempts=attempts+1 where uname='$user'");
else
$q=mysql_query("insert into blockedusers(date,uname,pwd,attempts) values('$dt','$user','$pass',1)") or die(mysql_error());
$q2=mysql_query("select attempts from  blockedusers where  uname='$user'");
$r2=mysql_fetch_array($q2);
if($r2['attempts']>=3) 
{
 echo "<script type='text/javascript'>";
echo "alert('Please Try Login after Some time');";
echo "document.location='blocked.php?uname=$user'";
echo "</script>"; 
}
 echo "<script type='text/javascript'>";
echo "document.location='index.php?wrong=yes'";
echo "</script>"; 

}

?>
