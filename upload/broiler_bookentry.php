
 <?php include "config.php";
       include "jquery.php";

	 $notr = 0; $notc = 0; $nobde = 0; $culled =""; $notc1 = 0; $nobde1 = 0; $culled1 =""; $nobde2 = 0; $culled2 ="";
	 $notc2 = 0; $nobde3 = 0; $culled3 =""; $nobde4 = 0; $culled4 =""; $ToFlock = ""; $newflock = ""; $newflock1 = "";
	 $bdeflock = ""; $bdeflock1 = "";
	 $farmer1 = $_GET['farmer'];
       $farmer2 = explode('@',$farmer1);
       $farmer = $farmer2[0];
       $place = $farmer2[1];
	 $supervisor = $_GET['supervisor'];
	 $displayflock = "";
	 $displayage = "";
	 $displaydate = "";
	 $warning = "";
	$c1=0;$c2=0; 
	
$query="select count(*) as c1 from ims_stocktransfer where cat = 'Broiler Chicks' AND towarehouse ='$farmer'  AND client = '$client'";
$result=mysql_query($query,$conn);
while($rows=mysql_fetch_array($result))
{
$c1=$rows['c1'];
}
$query1="select count(*) as c2 from pp_sobi where description = 'Broiler Chicks' AND warehouse='$farmer'  AND client = '$client'";
$result1=mysql_query($query1,$conn);
while($rows1=mysql_fetch_array($result1))
{
$c2=$rows1['c2'];
}
if(($c1 >= 0) && ($c2 == 0))
{
 $newflock =""; $ToFlock="";$maxflock = "";$displayflock="";$displayage="";$displaydate="";$notr1 = 0; $notc1 = 0;$notc =0;$notr=0;
  $q1 = mysql_query("select distinct(flock) as ToFlock, aflock, date as Date, towarehouse as Farmer1 from ims_stocktransfer where towarehouse ='$farmer' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 	$notr = mysql_num_rows($q1);
		
	   if($nt1 = mysql_fetch_assoc($q1))
        $ToFlocknum = $nt1['ToFlock'];
		$ToFlock = $nt1['aflock'];
		
$q2 = mysql_query("select distinct(flock) as newflock,aflock,date,towarehouse as farmer from ims_stocktransfer where towarehouse = '$farmer' AND (cat = 'Broiler Chicks' or cat = 'Broiler Day Old Chicks') AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 	$notc = mysql_num_rows($q2);
		
		if($nt2 = mysql_fetch_assoc($q2))
		$newflocknum = $nt2['newflock'];
		$newflock = $nt2['aflock'];
		
		if($newflocknum>0 && $ToFlocknum >0 && $newflocknum > $ToFlocknum)
		$maxflock = $newflock;
		else
		$maxflock = $ToFlock;
				
		$sq1 = mysql_query("select distinct(aflock) as ToFlock,date as Date,towarehouse as Farmer1 from ims_stocktransfer where towarehouse = '$farmer' and aflock = '$maxflock' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		$notr1 = mysql_num_rows($sq1);
		if($sq1r = mysql_fetch_assoc($sq1))
		$trdate = $sq1r['Date'];
	
		$sq2 = mysql_query("select distinct(aflock) as newflock,date,towarehouse as farmer from ims_stocktransfer where towarehouse = '$farmer' and aflock = '$maxflock' AND (cat = 'Broiler Chicks' or cat = 'Broiler Day Old Chicks') AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		$notc1 = mysql_num_rows($sq2);
		if($sq2r = mysql_fetch_assoc($sq2))
		$tcdate = $sq2r['date']; 

		if($notr1 != 0 && $notc1 != 0)
		$finaldate = $tcdate;
		else if($notr1 != 0 && $notc1 == 0)
		$finaldate = $trdate;
		else if($notr1 == 0 && $notc1 != 0)
		$finaldate = $tcdate;
		$culled = "";
		$nobde = 0;
			
if($notr1 != 0 && $notc1 != 0)
{	
	$q3 = mysql_query("select distinct(flock) as flock,cullflag,age,entrydate from broiler_daily_entry where farm ='$farmer' and flock = '$maxflock' and client = '$client' order by entrydate DESC",$conn) or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	$culled = $q3r['cullflag'];
	$entrydate = $q3r['entrydate'];
	$age = $q3r['age'];
	$currflock = $q3r['flock'];
	}
	
	if($nobde != 0)
	{
		if($culled == 1)
		{
			$displayflock = "";
			$displayage = "";
			$displaydate = "";
			
			$warning = "Flock " . $maxflock . " has been culled";
		}
		else if($culled == 0)
		{
			$displayflock = $maxflock;
			$displayage = $age + 1;
			$displaydate = date("d.m.Y",strtotime($entrydate) + 86400);
		}
	}
	else if($nobde == 0)
	{
		$displayflock = $maxflock;
		$displayage = 1;
		$displaydate = date("d.m.Y",strtotime($finaldate));
	}
}
else
{
	if($notc1 == 0 && $notr1 != 0)
	{
	$displaydate = date("d.m.Y");
	$warning = "Please do Chicks Transfer for the Flock: " . $maxflock;
	}
	else if($notr1 == 0 && $notc1 != 0)
	{
	$displaydate = date("d.m.Y");
	$warning = "Please do Feed Transfer for the Flock: " . $maxflock;
	}
	else
	{
	$displaydate = date("d.m.Y");
	$warning = "Please do Chicks Transfer & Feed Transfer";
	}
	
}	 
	 
}
else if(($c1 == 0) && ($c2 >0))
{
$newflock =""; $ToFlock="";$maxflock = "";$displayflock="";$displayage="";$displaydate="";$notr1 = 0; $notc1 = 0;$notc =0;$notr=0;
$q1 = mysql_query("select distinct(aflock) as ToFlock, date as Date, towarehouse as Farmer1 from ims_stocktransfer where towarehouse ='$farmer' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 $notr = mysql_num_rows($q1);
		
	   if($nt1 = mysql_fetch_assoc($q1))
        $ToFlock = $nt1['ToFlock'];
		$feedtrdate = $nt1['date'];
	 
	
	  $q2 = mysql_query("select distinct(flock) as newflock,date,warehouse as farmer from pp_sobi where warehouse = '$farmer' AND description = 'Broiler Chicks' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 $notc = mysql_num_rows($q2);
		
		if($nt2 = mysql_fetch_assoc($q2))
		$newflock = $nt2['newflock'];
		$chkpurdate = $nt2['date'];

		
		if($newflock == $ToFlock)
		{
		$maxflock = $newflock;
		}
		else
		{
		$maxflock = $ToFlock;
		}
		
		$sq1 = mysql_query("select distinct(aflock) as ToFlock,date as Date,towarehouse as Farmer1 from ims_stocktransfer where towarehouse = '$farmer' and aflock = '$maxflock' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		
		$notr1 = mysql_num_rows($sq1);
		if($sq1r = mysql_fetch_assoc($sq1))
		$trdate = $sq1r['Date'];
	
		$sq2 = mysql_query("select distinct(flock) as newflock,date,warehouse as farmer from pp_sobi where warehouse = '$farmer' and flock = '$maxflock' AND description = 'Broiler Chicks' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		$notc1 = mysql_num_rows($sq2);
		if($sq2r = mysql_fetch_assoc($sq2))
		$tcdate = $sq2r['date']; 
		$chickspurdate = $tcdate;
		
		if($notr1 != 0 && $notc1 != 0)
		$finaldate = $tcdate;
		else if($notr1 != 0 && $notc1 == 0)
		$finaldate = $trdate;
		else if($notr1 == 0 && $notc1 != 0)
		$finaldate = $tcdate;
		$culled = "";
		$nobde = 0;
  
if($notr1 != 0 && $notc1 != 0)
{

	$q3 = mysql_query("select distinct(flock) as flock,cullflag,age,entrydate from broiler_daily_entry where farm ='$farmer' and flock = '$maxflock' and client = '$client' order by entrydate DESC",$conn) or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	$culled = $q3r['cullflag'];
	$entrydate = $q3r['entrydate'];
	$age = $q3r['age'];
	$currflock = $q3r['flock'];
	}
	
	if($nobde != 0)
	{
		if($culled == 1)
		{
			$displayflock = "";
			$displayage = "";
			$displaydate = "";
			
			$warning = "Flock " . $maxflock . " has been culled";
		}
		else if($culled == 0)
		{
			$displayflock = $maxflock;
			$displayage = $age + 1;
			$displaydate = date("d.m.Y",strtotime($entrydate) + 86400);
		}
	}
	else if($nobde == 0)
	{
	
		$displayflock = $maxflock;
		$displayage = 1;
		$displaydate = date("d.m.Y",strtotime($finaldate));
	}
}
else
{

	if($notc1 == 0 && $notr1 != 0)
	{
	$displaydate1 = date("d.m.Y");
	$warning = "Please do Chicks Purchase for the Flock: " . $maxflock;
	}
	else if($notr1 == 0 && $notc1 != 0)
	{
	$displaydate1 = date("d.m.Y");
	$warning = "Please do Feed Transfer for the Flock: " . $maxflock;
	}
	else
	{
	$displaydate1 = date("d.m.Y");
	$warning = "Please do Chicks Purchase & Feed Transfer";
	}
	
}
}

else if(($c1 > 0) && ($c2 >0))
{
$newflock =""; $ToFlock="";$maxflock = "";$displayflock11="";$displayage11="";$displaydate11="";$notr1 = 0; $notc1 = 0;$notc =0;$notr=0;
$dispflk ="";$dispage = "";$dispdate = "";
$dispflk1 ="";$dispage1 = "";$dispdate1 = "";
$dispflk2 ="";$dispage2 = "";$dispdate2 = "";
$trc ="";$prc = "";
$q1 = mysql_query("select distinct(flock) as ToFlock, aflock, date as Date, towarehouse as Farmer1 from ims_stocktransfer where towarehouse ='$farmer' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 	$notr = mysql_num_rows($q1);
		
	   if($nt1 = mysql_fetch_assoc($q1))
        $ToFlocknum = $nt1['ToFlock'];
		$ToFlock = $nt1['aflock'];
		
$q2 = mysql_query("select distinct(flock) as newflock,aflock,date,towarehouse as farmer from ims_stocktransfer where towarehouse = '$farmer' AND (cat = 'Broiler Chicks' or cat = 'Broiler Day Old Chicks') AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 	$notc = mysql_num_rows($q2);
		
		if($nt2 = mysql_fetch_assoc($q2))
		$newflocknum = $nt2['newflock'];
		$newflock = $nt2['aflock'];
		
		if($newflocknum>0 && $ToFlocknum >0 && $newflocknum > $ToFlocknum)
		$maxflock = $newflock;
		else
		$maxflock = $ToFlock;
				
		$sq1 = mysql_query("select distinct(aflock) as ToFlock,date as Date,towarehouse as Farmer1 from ims_stocktransfer where towarehouse = '$farmer' and aflock = '$maxflock' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		$notr1 = mysql_num_rows($sq1);
		if($sq1r = mysql_fetch_assoc($sq1))
		$trdate = $sq1r['Date'];
	
		$sq2 = mysql_query("select distinct(aflock) as newflock,date,towarehouse as farmer from ims_stocktransfer where towarehouse = '$farmer' and aflock = '$maxflock' AND (cat = 'Broiler Chicks' or cat = 'Broiler Day Old Chicks') AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		$notc1 = mysql_num_rows($sq2);
		if($sq2r = mysql_fetch_assoc($sq2))
		$tcdate = $sq2r['date']; 

		if($notr1 != 0 && $notc1 != 0)
		$finaldate = $tcdate;
		else if($notr1 != 0 && $notc1 == 0)
		$finaldate = $trdate;
		else if($notr1 == 0 && $notc1 != 0)
		$finaldate = $tcdate;
		$culled = "";
		$nobde = 0;
			
if($notr1 != 0 && $notc1 != 0)
{	
	$q3 = mysql_query("select distinct(flock) as flock,cullflag,age,entrydate from broiler_daily_entry where farm ='$farmer' and flock = '$maxflock' and client = '$client' order by entrydate DESC",$conn) or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	$culled = $q3r['cullflag'];
	$entrydate = $q3r['entrydate'];
	$age = $q3r['age'];
	$currflock = $q3r['flock'];
	}
	
	if($nobde != 0)
	{
		if($culled == 1)
		{
			$displayflock11 = "";
			$displayage11 = "";
			$displaydate11 = "";
			
			$warning = "Flock " . $maxflock . " has been culled";
		}
		else if($culled == 0)
		{
			$displayflock11 = $maxflock;
			$displayage11 = $age + 1;
			$displaydate11 = date("d.m.Y",strtotime($entrydate) + 86400);
		}
	}
	else if($nobde == 0)
	{
		$displayflock11 = $maxflock;
		$displayage11 = 1;
		$displaydate11 = date("d.m.Y",strtotime($finaldate));
	}
}
else
{
	if($notc1 == 0 && $notr1 != 0)
	{
	$displaydate11 = date("d.m.Y");
	$warning = "Please do Chicks Transfer for the Flock: " . $maxflock;
	}
	else if($notr1 == 0 && $notc1 != 0)
	{
	$displaydate11 = date("d.m.Y");
	$warning = "Please do Feed Transfer for the Flock: " . $maxflock;
	}
	else
	{
	$displaydate11 = date("d.m.Y");
	$warning = "Please do Chicks Transfer & Feed Transfer";
	}
	
}
$dispflock = $displayflock11;
$dispage = $displayage11;
$dispdate = $displaydate11;
$trc1 = $chickstrdate;


$newflock =""; $ToFlock="";$maxflock = "";$displayflock12="";$displayage12="";$displaydate12="";$notr1 = 0; $notc1 = 0;$notc =0;$notr=0;

      $q1 = mysql_query("select distinct(aflock) as ToFlock, date as Date, towarehouse as Farmer1 from ims_stocktransfer where towarehouse ='$farmer' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 $notr = mysql_num_rows($q1);
		
	   if($nt1 = mysql_fetch_assoc($q1))
        $ToFlock = $nt1['ToFlock'];
		$feedtrdate = $nt1['date'];
	 
	
	  $q2 = mysql_query("select distinct(flock) as newflock,date,warehouse as farmer from pp_sobi where warehouse = '$farmer' AND description = 'Broiler Chicks' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
	 $notc = mysql_num_rows($q2);
		
		if($nt2 = mysql_fetch_assoc($q2))
		$newflock = $nt2['newflock'];
		$chkpurdate = $nt2['date'];

		
		if($newflock == $ToFlock)
		{
		$maxflock = $newflock;
		}
		else
		{
		$maxflock = $ToFlock;
		}
		
		$sq1 = mysql_query("select distinct(aflock) as ToFlock,date as Date,towarehouse as Farmer1 from ims_stocktransfer where towarehouse = '$farmer' and aflock = '$maxflock' AND cat = 'Broiler Feed' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		
		$notr1 = mysql_num_rows($sq1);
		if($sq1r = mysql_fetch_assoc($sq1))
		$trdate = $sq1r['Date'];
	
		$sq2 = mysql_query("select distinct(flock) as newflock,date,warehouse as farmer from pp_sobi where warehouse = '$farmer' and flock = '$maxflock' AND description = 'Broiler Chicks' AND client = '$client' order by date DESC",$conn) or die(mysql_error());
		$notc1 = mysql_num_rows($sq2);
		if($sq2r = mysql_fetch_assoc($sq2))
		$tcdate = $sq2r['date']; 
		$chickspurdate = $tcdate;
		
		if($notr1 != 0 && $notc1 != 0)
		$finaldate = $tcdate;
		else if($notr1 != 0 && $notc1 == 0)
		$finaldate = $trdate;
		else if($notr1 == 0 && $notc1 != 0)
		$finaldate = $tcdate;
		$culled = "";
		$nobde = 0;
 
if($notr1 != 0 && $notc1 != 0)
{
//echo $notr1.$notc1;
	$q3 = mysql_query("select distinct(flock) as flock,cullflag,age,entrydate from broiler_daily_entry where farm ='$farmer' and flock = '$maxflock' and client = '$client' order by entrydate DESC",$conn) or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	$culled = $q3r['cullflag'];
	$entrydate = $q3r['entrydate'];
	$age = $q3r['age'];
	$currflock = $q3r['flock'];
	}
	
	if($nobde != 0)
	{
		if($culled == 1)
		{
			$displayflock12 = "";
			$displayage12 = "";
			$displaydate12 = "";
			
			$warning = "Flock " . $maxflock . " has been culled";
		}
		else if($culled == 0)
		{
			$displayflock12 = $maxflock;
			$displayage12 = $age + 1;
			$displaydate12 = date("d.m.Y",strtotime($entrydate) + 86400);
		}
	}
	else if($nobde == 0)
	{
	
		$displayflock12 = $maxflock;
		$displayage12 = 1;
		$displaydate12 = date("d.m.Y",strtotime($finaldate));
	}
}
else
{

	if($notc1 == 0 && $notr1 != 0)
	{
	$displaydate12 = date("d.m.Y");
	$warning = "Please do Chicks Purchase for the Flock: " . $maxflock;
	}
	else if($notr1 == 0 && $notc1 != 0)
	{
	$displaydate12 = date("d.m.Y");
	$warning = "Please do Feed Transfer for the Flock: " . $maxflock;
	}
	else
	{
	$displaydate12 = date("d.m.Y");
	$warning = "Please do Chicks Purchase & Feed Transfer";
	}
	
}
$dispflock1 = $displayflock12;
$dispage1 = $displayage12;
$dispdate1 = $displaydate12;
$prc1 = $chickspurdate;

if(($dispflock != "") && ($dispflock1 == ""))
{
$dispflk2 =$dispflock;
$dispage2 = $dispage;
$dispdate2 = $dispdate;
}
else if(($dispflock == "") && ($dispflock1 != ""))
{
$dispflk2 =$dispflock1;
$dispage2 = $dispage1;
$dispdate2 = $dispdate1;
}
else if(($dispflock != "") && ($dispflock1 != ""))
{
if($prc1 > $trc1)
{
$dispflk2 =$dispflock1;
$dispage2 = $dispage1;
$dispdate2 = $dispdate1;
}
else
{
$dispflk2 =$dispflock;
$dispage2 = $dispage;
$dispdate2 = $dispdate;
}
}
$displayflock = $dispflk2;
$displayage = $dispage2;
$displaydate = $dispdate2;

}

?>






<br /><br />

<center>
<h1>Broiler Book Entry</h1>
</center>
</head>
<body bgcolor="#ECF1F5">
<br />
<form id="form1" name="form1" method="post" action="broiler_savebookentry.php" target="_parent">
<br />
<center>
<strong>Supervisor:</strong> &nbsp;&nbsp;&nbsp;
<input type="text" style="border:none;background:none" name="supervisor" id="supervisor" value="<?php echo $_GET['supervisor']; ?>" readonly size="12" />&nbsp;&nbsp;&nbsp;
<strong>Farm:</strong> &nbsp;&nbsp;&nbsp;
<input type="text" style="border:none;background:none" name="farmer" id="farmer" value="<?php echo $farmer; ?>" readonly size="18" />&nbsp;&nbsp;&nbsp;
<strong>Place:</strong> &nbsp;&nbsp;&nbsp;
<input type="text" style="border:none;background:none" name="place" id="place" value="<?php echo $place; ?>" readonly size="25" />&nbsp;&nbsp;&nbsp;
</center>
<br /><br />

<table id="paraID" aling="center">
<tr align="center">
<th width="10px"></th>
<th><strong>Flock</strong></th>
<th width="10px"></th>
<th><strong>Age</strong></th>
<th width="10px"></th>
<th><strong>Date</strong></th>
<th width="10px"></th>
<th title="mortality"><strong>Mort.</strong></th>
<th width="10px"></th>
<th><strong>Cull</strong></th>
<th width="10px"></th>
<th><strong>Feed Type</strong></th>
<th width="10px"></th>
<th title="feed consumed"><strong>Feed Cons.</strong></th>
<th width="10px"></th>
<th title="average weight"><strong>Avg. Wt.</strong></th>
<th width="10px"></th>
<th><strong>Water</strong></th>
<th width="10px"></th>
<th><strong>Medicine</strong></th>
<th width="10px"></th>
<th><strong>Quantity</strong></th>
<th width="10px"></th>
<th><strong>Vaccine</strong></th>
<th width="10px"></th>
<th><strong>Quantity</strong></th>
<th width="10px"></th>
<th><strong>Remarks</strong></th>
<th width="10px"></th>
</tr>

<tr align="center">
<th colspan="13"></th>
		<?php session_start();
		if($_SESSION['client'] == 'KWALITY')
		{
		?><th style="font-size:10px">(In Bag's)<th><?php
		}
		else
		{
		?><th style="font-size:10px">(In Kg's)<th><?php
		}
		?>


<th style="font-size:10px">(In Gram's)<th>
<th style="font-size:10px">(In Lt's)<th>
<th width="10px"></th>
<!--<th></th>
<th width="10px"></th>
<th></th>
<th width="10px"></th>
<th></th>
<th width="10px"></th>
<th></th>
<th width="10px"></th>-->
</tr>

<tr height="10px"><td></td></tr>

<tr  align="center">
<td width="10px"></td>
<td><input type="text" name="flock[]" id="flock" size="16" value="<?php echo $displayflock;?>" readonly /></td>
<td width="10px"></td>
<td><input type="text" name="age[]" id="age" size="1" value="<?php echo $displayage;?>" readonly/></td>
<td width="10px"></td>
<td><input type="text" name="date1[]" id="date1" size="10" value="<?php echo $displaydate;?>" readonly /></td>
<td width="10px"></td>
<td><input type="text" name="mort[]" id="mort" size="1" value="0" /></td>
<td width="10px"></td>
<td><input type="text" name="cull[]" id="cull" size="1" value="0"/></td>
<td width="10px"></td>
<td><select name="feedtype[]" id="feedtype">
<option value="">-Select-</option>
	    <?php 
			     include "config.php";
	             $query = "SELECT distinct(code),description FROM ims_itemcodes WHERE cat = 'Broiler Feed' AND client = '$client' ORDER BY code ASC";
		         $result = mysql_query($query,$conn);
 		         while($row = mysql_fetch_assoc($result))
		         {
            ?>
	 <option value="<?php echo $row['code'];?>" title="<?php echo $row['description']; ?>"><?php echo $row['code']; ?></option>
	        <?php } ?>
</select>
</td>
<td width="10px"></td>
<td><input type="text" name="consumed[]" id="consumed" size="4" value="0"/></td>
<td width="10px"></td>
<td><input type="text" name="weight[]" id="weight" size="4" value="0"/></td>
<td width="10px"></td>
<td><input type="text" name="water[]" id="water" value="0"  size="4" /></td>
<td width="10px"></td>
<td><select name="medicine[]" id="medicine"><option value="">-Select-</option>
<?php
$query = "SELECT distinct(code),description FROM ims_itemcodes WHERE cat = 'Medicines' AND client = '$client' ORDER BY code ASC";
		         $result = mysql_query($query,$conn);
 		         while($row = mysql_fetch_assoc($result))
		         {
            ?>
	 <option value="<?php echo $row['code'];?>" title="<?php echo $row['description']; ?>"><?php echo $row['code']; ?></option>
	        <?php } ?>
</td>
<td width="10px"></td>
<td><input type="text" name="mquantity[]" id="mquantity" value="0"  size="3" /></td>
<td width="10px"></td>
<td><select name="vaccine[]" id="vaccine"><option value="">-Select-</option>
<?php
$query = "SELECT distinct(code),description FROM ims_itemcodes WHERE cat = 'Vaccines' AND client = '$client' ORDER BY code ASC";
		         $result = mysql_query($query,$conn);
 		         while($row = mysql_fetch_assoc($result))
		         {
            ?>
	 <option value="<?php echo $row['code'];?>" title="<?php echo $row['description']; ?>"><?php echo $row['code']; ?></option>
	        <?php } ?>
</td>
<td width="10px"></td>
<td><input type="text" name="vquantity[]" id="vquantity"size="3" value="0" /></td>
<td width="10px"></td>
<td><input type="text" name="remarks[]" id="remarks"size="10" onfocus = "makeForm();" /></td>
<td width="10px"></td>
<input type="hidden" name="birds[]"  id="birds" value="0"/>
</tr>
</table>


<center>
<br /><br /><br />

<h4 style="color:red">Other Items Consumed</h4><br />

<table border="0px" id="inputs1">


     <tr>
         <th style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Flock</strong></th>
        <th width="20px"></th>
        <th style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Date</strong></th>
        <th width="20px"></th>
        <th style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Item</strong></th>
        <th width="20px"></th>
 <th style="text-align:left">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Description</strong></th>
        <th width="20px"></th>
        <th style="text-align:left">&nbsp;&nbsp;<strong>Quantity</strong></th>
     </tr>

     <tr style="height:20px"></tr>

   <tr>
 
       <td style="text-align:left;">
        <input type="text" name="flocko[]" id="flocko" size="16" value="<?php echo $displayflock;?>" readonly />
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="dateo[]" id="dateo" class="datepicker" value="" size="10" /> 
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <select name="itemo[]" id="item@-1" style="width:80px;" onChange="getdesc(this.id);" >
           <option value="">-Select-</option>
           <?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemcodes where cat <> 'Eggs' and cat <> 'Feed' and cat <> 'Birds' and client = '$client'  ORDER BY code ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['code']; ?>" title="<?php echo $row1['description']; ?>"><?php echo $row1['code']; ?></option>
           <?php } ?>
         </select>
       </td>
<td width="10px"></td>
       <td style="text-align:left;">
         <select name="desc[]" id="desc@-1" style="width:200px;" onChange="getcode(this.id);">
           <option value="">-Select-</option>
           <?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemcodes where cat <> 'Eggs' and cat <> 'Feed' and cat <> 'Birds' and client = '$client'  ORDER BY description ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>

           <option value="<?php echo $row1['description']; ?>" title="<?php echo $row1['code']; ?>"><?php echo $row1['description']; ?></option>
           <?php } ?>
         </select>
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="qtyo[]" id="qtyo" value="" size="8" onFocus="makeform1();" /> 
       </td>
    </tr>

 
</table>
<br /><br />

<input type="submit" value="Save" id="Save" <?php if($warning != "") { ?> disabled="disabled" <?php } ?>/>&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=broiler_dailyentry';">


</center>
</form>
<br />
<script type="text/javascript">
function getcode(codeid)
{
temp = codeid.split("@");
var index12 = temp[1];
var code1 = document.getElementById("desc@" + index12).value;
<?php
$q = "select distinct(description) from ims_itemcodes";
$qrs = mysql_query($q) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
echo "if(code1 == '$qr[description]') {";
$q1 = "select distinct(code),sunits from ims_itemcodes where description = '$qr[description]' order by code";
$q1rs = mysql_query($q1) or die(mysql_error());
if($q1r = mysql_fetch_assoc($q1rs))
{
?>
document.getElementById("item@" + index12).value = "<?php echo $q1r['code'];?>";
<?php
}
echo "}";
}
?>

}
function getdesc(codeid)
{
temp = codeid.split("@");
var index11 = temp[1];

var code1=document.getElementById("item@" + index11).value;
<?php 
$q = "select distinct(code) from ims_itemcodes";
$qrs = mysql_query($q) or die(mysql_error());
while($qr = mysql_fetch_assoc($qrs))
{
echo "if(code1 == '$qr[code]') {";
$q1 = "select distinct(description),sunits from ims_itemcodes where code = '$qr[code]' order by description";
$q1rs = mysql_query($q1) or die(mysql_error());
if($q1r = mysql_fetch_assoc($q1rs))
{
?>
document.getElementById('desc@' + index11).value = "<?php echo $q1r['description'];?>";
<?php
}
echo "}";
}
?>
}</script>
<script type="text/javascript">
function script1() {
window.open('BroilerHelp/help_t_addbookentry.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
}
</script>

	<footer>
		<div class="float-left">
			<a href="#" class="button" onClick="script1()">Help</a>
			<a href="javascript:void(0)" class="button">About</a>
		</div>


		
		<div class="float-right">
			<a href="#top" class="button"><img src="images/icons/fugue/navigation-090.png" width="16" height="16"> Page top</a>
		</div>
		
	</footer>
</body> 
<?php 
include "broiler_bookentry1.php"; 
?>
<script type="text/javascript">
var index1a =0;
function makeform1()
{
  index1a = index1a + 1;
  var t1a  = document.getElementById('inputs1');
  var r1a = document.createElement('tr'); 

 
  mybox1=document.createElement("input");
  mybox1.size="16";
  mybox1.type="text";
  mybox1.name="flocko[]";
  mybox1.value="<?php echo $displayflock;?>";
  mybox1.id="date1" +  index1a;
  var ba1a = document.createElement('td');
  ba1a.appendChild(mybox1);

  var b1a = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b1a.appendChild(myspace2);



  mybox1=document.createElement("input");
  mybox1.size="10";
  mybox1.type="text";
  mybox1.name="dateo[]";
  mybox1.id="dateo" +  index1a;
  var c = "datepicker" + index;
  mybox1.setAttribute("class",c);
  var ba2a = document.createElement('td');
  ba2a.appendChild(mybox1);

  var b2a = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b2a.appendChild(myspace2);


  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="ageo[]";
  mybox1.id="ageo" +  index1a;
  var ba3a = document.createElement('td');
  ba3a.appendChild(mybox1);

  var b3a = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b3a.appendChild(myspace2);


  myselect1 = document.createElement("select");
  myselect1.style.width = "80px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "itemo[]";
  myselect1.id = "item@" + index1a;
myselect1.onchange= function() { getdesc(this.id); };
  <?php
           include "config.php"; 
           $query = "SELECT * FROM ims_itemcodes where cat <> 'Eggs' and cat <> 'Feed' and cat <> 'Birds' and client = '$client'  ORDER BY code ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['code']; ?>");
		theOption.appendChild(theText);
            theOption.title = "<?php echo $row1['description']; ?>";
		theOption.value = "<?php echo $row1['code']; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>
  var ba11a = document.createElement('td');
  ba11a.appendChild(myselect1);
  var b11a = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b11a.appendChild(myspace2);


myselect1 = document.createElement("select");
  myselect1.style.width = "200px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "desc[]";
  myselect1.id = "desc@" + index1a;
myselect1.onchange= function() { getcode(this.id); };

  <?php
           include "config.php"; 
           $query = "SELECT * FROM ims_itemcodes where cat <> 'Eggs' and cat <> 'Feed' and cat <> 'Birds' and client = '$client'  ORDER BY description ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['description']; ?>");
		theOption.appendChild(theText);
            theOption.title = "<?php echo $row1['code']; ?>";
		theOption.value = "<?php echo $row1['description']; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>
  var ba13a = document.createElement('td');
  ba13a.appendChild(myselect1);
  var b13a = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b13a.appendChild(myspace2);



  mybox1=document.createElement("input");
  mybox1.size="8";
  mybox1.type="text";
  mybox1.name="qtyo[]";
  mybox1.onfocus= function() { makeform1(); };
  var ba12a = document.createElement('td');
  ba12a.appendChild(mybox1);

  var b12a = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b12a.appendChild(myspace2);

  
      r1a.appendChild(ba1a);
      r1a.appendChild(b1a);
      r1a.appendChild(ba2a);
      r1a.appendChild(b2a);
      r1a.appendChild(ba11a);
      r1a.appendChild(b11a);

r1a.appendChild(ba13a);
      r1a.appendChild(b13a);
      r1a.appendChild(ba12a);
      r1a.appendChild(b12a);
      t1a.appendChild(r1a);


$(function() {
	$( "." + c ).datepicker();
  });

}

</script>

<script type="text/javascript">

<?php /*?>function fun(b) 
{
if(index == -1)
var a = "";
else
var a = index;
document.getElementById('flock' + a).value = "";
document.getElementById('age' + a).value = "";
document.getElementById('date1' + a).value = "";

if(document.getElementById('farm' + a ).value == "")
{
document.getElementById('flock' + a).value = "";
document.getElementById('age' + a).value = "";
document.getElementById('date1' + a).value = "";
document.getElementById('Save').disabled = true;
document.getElementById('vquantity' + a).onfocus = "";
alert("Please select Farm");
return;
}
var i1,j1;
for(var i = -1;i<=index;i++)
{
	for(var j = -1;j<=index;j++)
	{
		if(i == -1)
		i1 = "";
		else
		i1=i;
		
		if(j == -1)
		j1 = "";
		else
		j1=j;
		
		if( i != j)
		{
			if(document.getElementById('farm' + i1).value == document.getElementById('farm' + j1).value)
			{
				document.getElementById('Save').disabled = true;
				document.getElementById('flock' + a).value = "";
				document.getElementById('age' + a).value = "";
				document.getElementById('date1' + a).value = "";
				document.getElementById('vquantity' + a).onfocus = "";
				alert("Please select differen combination");
				return;
			}
		}
	}
}
document.getElementById('Save').disabled = false;
document.getElementById('vquantity' + a).onfocus = function ()  {  makeForm(); };


 <?php
	 $notr = 0; $notc = 0; $nobde = 0; $culled =""; $notc1 = 0; $nobde1 = 0; $culled1 =""; $nobde2 = 0; $culled2 ="";
	 $notc2 = 0; $nobde3 = 0; $culled3 =""; $nobde4 = 0; $culled4 =""; $ToFlock = ""; $newflock = ""; $newflock1 = "";
	 $bdeflock = ""; $bdeflock1 = "";
	 
     $q = mysql_query("select distinct(farm) as name from broiler_farm where client = '$client' ORDER BY name ASC");
	 
     while($nt = mysql_fetch_assoc($q))
	 {
     echo "if(document.getElementById('farm' + a).value == '$nt[name]') { ";
	 session_start();
if($_SESSION['db'] == "bims")
 {
    $q3 = mysql_query("select distinct(flock) as flock,cullflag,age,entrydate from broiler_daily_entry where farm ='$nt[name]' AND client = '$client' order by entrydate") or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	$culled = $q3r['cullflag'];
	$entrydate = $q3r['entrydate'];
	$age = $q3r['age'];
	$currflock = $q3r['flock'];
	}
	if($nobde != 0)
	{
		if($culled == 1)
		{
			?>
			alert("Please enter new flock");
			document.getElementById('flock' + a).value = "";
			document.getElementById('age' + a).value = "";
			document.getElementById('date1' + a).value = "";
			//document.getElementById('vquantity' + a).onfocus = "";
			//document.getElementById('Save').disabled = true;
			return;
			<?php
		}
		else if($culled == 0)
		{
			?>
			document.getElementById('flock' + a).value = "<?php echo $currflock; ?>";
			document.getElementById('age' + a).value = "<?php echo $age + 1; ?>";
			document.getElementById('date1' + a).value = "<?php echo date("d.m.Y",strtotime($entrydate) + 86400); ?>";
			<?php	
		}
	}
	else if($nobde == 0)
	{
		?>
		document.getElementById('flock' + a).value = "<?php echo "New Flock"; ?>";
		document.getElementById('age' + a).value = "<?php echo 1; ?>";
		document.getElementById('date1' + a).value = "<?php echo date("d.m.Y"); ?>";
		<?php	
	}
}
else
{
     $q1 = mysql_query("select distinct(flock) as ToFlock,date as Date,towarehouse as Farmer1 from ims_stocktransfer where towarehouse ='$nt[name]' AND cat = 'Broiler Feed'  AND client = '$client' order by date DESC") or die(mysql_error());
	 	$notr = mysql_num_rows($q1);
		
	   if($nt1 = mysql_fetch_assoc($q1))
       $ToFlock = $nt1['ToFlock'];
	 
	 $q2 = mysql_query("select distinct(flock) as newflock,date,towarehouse from ims_stocktransfer where towarehouse = '$nt[name]' AND (cat = 'Broiler Chicks' or cat = 'Broiler Day Old Chicks') AND client = '$client' order by date DESC") or die(mysql_error());
	 	$notc = mysql_num_rows($q2);
		
		if($nt2 = mysql_fetch_assoc($q2))
		$newflock = $nt2['newflock'];
		if($newflock > $ToFlock)
		$maxflock = $newflock;
		else
		$maxflock = $ToFlock;
		
		$sq1 = mysql_query("select distinct(flock) as ToFlock,date as Date,towarehouse as Farmer1 from ims_stocktransfer where towarehouse = '$nt[name]' and AND cat = 'Broiler Feed' AND client = '$client' AND flock = '$maxflock' order by date DESC") or die(mysql_error());
		$notr1 = mysql_num_rows($sq1);
		if($sq1r = mysql_fetch_assoc($sq1))
		$trdate = $sq1r['Date']; 
	
		$sq2 = mysql_query("select distinct(flock) as newflock,date,towarehouse as farmer from ims_stocktransfer where towarehouse = '$nt[name]' and flock = '$maxflock' AND (cat = 'Broiler Chicks' or cat = 'Broiler Day Old Chicks') AND client = '$client' order by date DESC") or die(mysql_error());
		$notc1 = mysql_num_rows($sq2);
		if($sq2r = mysql_fetch_assoc($sq2))
		$tcdate = $sq2r['date']; 

		if($notr1 != 0 && $notc1 != 0)
		$finaldate = $tcdate;
		else if($notr1 != 0 && $notc1 == 0)
		$finaldate = $trdate;
		else if($notr1 == 0 && $notc1 != 0)
		$finaldate = $tcdate;
		$culled = "";
		$nobde = 0;
  if($notr1 != 0 && $notc1 != 0)
  {
	$q3 = mysql_query("select distinct(flock) as flock,cullflag,age,entrydate from broiler_daily_entry where farm ='$nt[name]' and flock = '$maxflock' AND client = '$client' order by entrydate DESC") or die(mysql_error());
	$nobde = mysql_num_rows($q3);
	if($q3r = mysql_fetch_assoc($q3))
	{
	$culled = $q3r['cullflag'];
	$entrydate = $q3r['entrydate'];
	$age = $q3r['age'];
	$currflock = $q3r['flock'];
	}
	if($nobde != 0)
	{
		if($culled == 1)
		{
			?>
			alert("Flock : <?php echo $maxflock; ?> has been culled");
			document.getElementById('flock' + a).value = "";
			document.getElementById('age' + a).value = "";
			document.getElementById('date1' + a).value = "";
			document.getElementById('vquantity' + a).onfocus = "";
			document.getElementById('Save').disabled = true;
			return;
			<?php
		}
		else if($culled == 0)
		{
			?>
			document.getElementById('flock' + a).value = "<?php echo $maxflock; ?>";
			document.getElementById('age' + a).value = "<?php echo $age + 1; ?>";
			document.getElementById('date1' + a).value = "<?php echo date("d.m.Y",strtotime($entrydate) + 86400); ?>";
			<?php	
		}
	}
	else if($nobde == 0)
	{
		?>
		document.getElementById('flock' + a).value = "<?php echo $maxflock; ?>";
		document.getElementById('age' + a).value = "<?php echo 1; ?>";
		document.getElementById('date1' + a).value = "<?php echo date("d.m.Y",strtotime($finaldate)); ?>";
		<?php	
	}
}
else
{
	if($notc1 == 0 && $notr1 != 0)
	{
	?>
	alert("Plese do chicks transfer for the Flock : <?php echo $maxflock; ?>");
	document.getElementById('flock' + a).value = "";
	document.getElementById('age' + a).value = "";
	document.getElementById('date1' + a).value = "<?php echo date("d.m.Y");?>";
	document.getElementById('vquantity' + a).onfocus = "";
	document.getElementById('Save').disabled = true;
	return;
	<?php
	}
	else if($notr1 == 0 && $notc1 != 0)
	{
	?>
	alert("Plese do feed transfer for the Flock : <?php echo $maxflock; ?>");
	document.getElementById('flock' + a).value = "";
	document.getElementById('age' + a).value = "";
	document.getElementById('date1' + a).value = "<?php echo date("d.m.Y");?>";
	document.getElementById('vquantity' + a).onfocus = "";
	document.getElementById('Save').disabled = true;
	return;
	<?php
	}
	else
	{
	?>
	alert("Plese do feed & chicks transfer");
	document.getElementById('flock' + a).value = "";
	document.getElementById('age' + a).value = "";
	document.getElementById('date1' + a).value = "<?php echo date("d.m.Y");?>";
	document.getElementById('vquantity' + a).onfocus = "";
	document.getElementById('Save').disabled = true;
	return;
	<?php
	}
	
}	

}	
   echo "}";
 }
?>
}
<?php */?>




</script>


</html>


