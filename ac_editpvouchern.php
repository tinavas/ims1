<body >
<?php  
		include "config.php";
		include "jquery.php";
		$client = $_SESSION['client'];
		$sdb = $_SESSION['db'];
		
$mode = "";
            $voucher = 'P';
		$tnum = $_GET['id'];
		$q = "select * from ac_gl where transactioncode = '$tnum' AND voucher = '$voucher' order by id ";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		while($qr = mysql_fetch_assoc($qrs))
		{
		  if($mode == "")
		  {
		  $mode = $qr['mode'];
		  }
		 $manual_trnum=$qr['manual_trnum'];
		  $coacode = $qr['bccodeno'];
		  $crtotal = $qr['crtotal'];
		  $drtotal = $qr['drtotal'];
		  $pname = $qr['name'];
		  $pmode = $qr['pmode'];
		  $cheque = $qr['chequeno'];
		  //$stdate = $qr['date'];
		  $vstatus = $qr['vstatus'];
		  $stdate = date("d.m.Y",strtotime($qr['date']));
		  $remarks = $qr['remarks'];
		  //$unitc = $qr['costcenter'];
		   $unitc = $qr['warehouse'];
		   $vno = $qr['vouchernumber'];
		   $empname=$qr['empname'];
		}
		
$q1=mysql_query("SET group_concat_max_len=10000000");
	//for unit
				  if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
      
		$q = "SELECT GROUP_CONCAT( DISTINCT (sector) ORDER BY sector ) as sector FROM tbl_sector WHERE type1 <> 'Warehouse'";
	 
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
		$q = "SELECT GROUP_CONCAT( DISTINCT (sector)  ORDER BY sector ) as sector FROM tbl_sector WHERE type1 <> 'Warehouse'  and sector in ($sectorlist)";
	  
	 }
	 


		$qrs = mysql_query($q,$conn) or die(mysql_error());
		$qr = mysql_fetch_assoc($qrs);
		

		 $sec1=explode(",",$qr["sector"]);	
		 $sector=json_encode($sec1);

	
	
	
	//coa code and descripton	 
		 
		  $q = "select group_concat(code,'@',DESCRIPTION order by code) as cd   FROM ac_coa where controltype in('Cash','Bank')  ";
		  
		
	$qrs = mysql_query($q,$conn) or die(mysql_error());
		$qr = mysql_fetch_assoc($qrs);
		
		
		 $codedesc=explode(",",$qr["cd"]);	
		 $codedesc1=json_encode($codedesc);
	
	
	
		
//iteams and codes

 $q = "SELECT GROUP_CONCAT(code,'@',description ORDER BY code ) AS codedesc from ac_coa where controltype in('','Bank','Cash') and type <> 'Revenue' and schedule not in('Inventories','Inventories Work In Progress','Trade Receivable','Trade Payable','Cost Of Sales /Services','Price Variance','Production Variance')";
		$qrs = mysql_query($q,$conn) or die(mysql_error());
		$r=mysql_fetch_array($qrs);
{
$items=explode(",",$r['codedesc']);

} 
$item=json_encode($items);




//cash code

	   
		  if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   	$q = "select group_concat(code,'@',coacode order by code) as cashcode from ac_bankmasters where mode = 'Cash' and client = '$client'";
		   }
		   else
		   {
		   $sectorlist = $_SESSION['sectorlist'];
		  $q = "select group_concat(code,'@',coacode order by code)   as cashcode from ac_bankmasters where mode = 'Cash' and client = '$client' AND coacode IN (SELECT coacode FROM ac_bankmasters WHERE code IN (SELECT code FROM ac_bankcashcodes WHERE sector In ($sectorlist) ORDER BY code ASC)) ";
		   }
		
	$qrs = mysql_query($q,$conn) or die(mysql_error());
		$qr = mysql_fetch_assoc($qrs);
		
		
		 $cashcodes=explode(",",$qr["cashcode"]);	
		 $cashcodes1=json_encode($cashcodes);
	

//bank code

	if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
		   {
		   	$q = "select group_concat(acno,'@',coacode  order by acno) as bankcode from ac_bankmasters where mode = 'Bank' and client = '$client' order by acno";
		   }
		   else
		   {
		    $sectorlist = $_SESSION['sectorlist'];
			$q = "select group_concat(acno,'@',coacode  order by acno) as bankcode from ac_bankmasters where mode = 'Bank' and client = '$client' AND coacode IN (SELECT coacode FROM ac_bankmasters WHERE code IN (SELECT code FROM ac_bankcashcodes WHERE sector In ($sectorlist) ORDER BY code ASC)) order by acno";
		   }



$qrs = mysql_query($q,$conn) or die(mysql_error());
		$qr = mysql_fetch_assoc($qrs);
		
		
		 $bankcodes=explode(",",$qr["bankcode"]);	
		 $bankcodes1=json_encode($bankcodes);



		
	
?>



<script type="text/javascript">


var items=<?php if(empty($item)){echo 0;} else{ echo $item; }?>;

var sectors=<?php if(empty($sector)){echo 0;} else{ echo $sector; }?>;

var cashbankcodes=<?php if(empty($cashbankcodes)){echo 0;} else{ echo $cashbankcodes; }?>;
var bankcodes=<?php if(empty($bankcodes1)){echo 0;} else{ echo $bankcodes1; }?>;
var cashcodes=<?php if(empty($cashcodes1)){echo 0;} else{ echo $cashcodes1; }?>;
var codedesc=<?php if(empty($codedesc1)){echo 0;} else{ echo $codedesc1; }?>;
var chequeno=<?php if(empty($chequeno)){echo 0;} else{ echo $chequeno; }?>;


</script>


<center>
<section class="grid_8">
  <div class="block-border">


<form id="form1" name="form1" method="post" action="ac_updatepvouchern.php"  class="block-content form" onSubmit="return checkform1(this);">

<input type="hidden" id="mode" name="mode" value="<?php echo $_GET['mode']; ?>" />
<h1>Payment Voucher</h1>
<br />

<b>Payment Voucher</b> 

<br />
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/>
<br/><br />



<input type="hidden" name="cuser" id="cuser" value="<?php echo $empname;?>"/>
<input type="hidden" id="mode" name="mode" value="<?php echo $mode; ?>" />
<input type="hidden" id="saed" name="saed" value="1">


<table border="0" align="center">
 

<tr>

<td width="30px"></td>
<td><strong>Transaction No.</strong>&nbsp;&nbsp;&nbsp;</td>
<td><input type="text" id="tno" name="tno" size="6" value="<?php echo $tnum; ?>" readonly style="border:0px;background:none"  /></td>

 <td width="10px"></td>
 <td>&nbsp;&nbsp;&nbsp;<strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
 <td width="10px"></td>
 <td><input type="text" size="15" id="date" class="datepicker" name="date" onChange="check_totamt(this);" value="<?php echo $stdate; ?>"/></td>
  <td style="width:20px "></td>

   <td>&nbsp;&nbsp;&nbsp;<strong>Location<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></td>
 <td width="10px"></td>

 <td>
 <select id="unitc" name="unitc" style="width:150px;" >
<option value="">-Select-</option>
<?php 
       
 for($j=0;$j<count($sec1);$j++)
		   {
			
           ?>
<option value="<?php echo $sec1[$j];?>"  <?php if($unitc==$sec1[$j]) { ?> selected="selected" <?php }?> title="<?php echo $sec1[$j]; ?>"><?php echo $sec1[$j]; ?></option>
<?php } ?>
</select>

 </td>
 <td width="10px"></td>

 </tr>
<tr height="10px"><td></td></tr>
</table>



<table align="center">


<td width="40px"></td>

<td><strong>Voucher No.</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>

<td><input type="text" id="vno" name="vno" value="<?php echo $vno;?>" size="15"/></td>
<td width="40px"></td>

<td >
<strong id="codename">Cash/Bank Codes</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
<td><select id="cno" name="cno" onChange="codecoa();">
<option value="">--Select--</option>
 <?php
  

 
       
 for($j=0;$j<count($cashcodes);$j++)
		   {
			$cashcodes1=explode('@',$cashcodes[$j]);
		
           ?>
<option value="<?php echo $cashcodes1[0];?>"  <?php if($cashcodes1[0]==$coacode){ ?> selected="selected" <?php  } ?> title="<?php echo $cashcodes1[0]; ?>"><?php echo $cashcodes1[0]; ?></option>
<?php } 


  
	
	for($j=0;$j<count($bankcodes);$j++)
		   {
			$bankcodes1=explode('@',$bankcodes[$j]);
           ?>
<option value="<?php echo $bankcodes1[0];?>"  <?php if($bankcodes1[0]==$coacode){ ?> selected="selected" <?php  } ?> title="<?php echo $bankcodes1[0]; ?>"><?php echo $bankcodes1[0]; ?></option>
<?php } 
	

  ?>
</select></td>

</tr>
<tr height="10px"><td></td></tr>
</table>

<br />
<div style="height:auto">
<table border="0" cellpadding="2" cellspacing="2" id="mytable" align="center">
<thead>
<th><strong>S.No.</strong></th>
<th></th>
<th><strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th></th>
<th><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th></th>
<th><strong>Dr/Cr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</th>
<th></th>
<th><strong>Dr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</th>
<th></th>
<th><strong>Cr</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</th>
<th></th>
<th><strong>Narration</strong></th>
</thead>


<tr height="10px"><td></td></tr>

<script type="text/javascript">
var index = 0;
</script>
<?php 
	$i = 1;
	
	$q = "select * from ac_gl where transactioncode = '$tnum' AND voucher = '$voucher' order by id ";
	$qrs = mysql_query($q,$conn) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	
?>
<script type="text/javascript">
index = index + 1;
</script>
<tr>

<td style="text-align:left">
<input type="text"  id="sno<?php echo $i; ?>" name="sno" value="<?php echo $i; ?>" readonly style="border:0px;background:none" size="2"/></td>
<td width="10px"></td>
<td><select id="code<?php echo $i; ?>" name="code[]" onChange="getdesc(<?php echo $i; ?>);"  style="width:100px">
  <option value="">Select</option>
<?php if($i==1)
{?>
  <option value="<?php echo $qr['code']?>" selected="selected"><?php echo $qr['code'] ?></option>

<?php } else {?>


<?php
     
	 
	for($j=0;$j<count($items);$j++)
							{ 
							
							$code1=explode("@",$items[$j]);
							
					?>
					<option title="<?php echo $code1[1];?>" <?php if($code1[0]==$qr['code']) { ?> selected="selected" <?php }?> value="<?php echo $code1[0];?>"><?php echo $code1[0]; ?></option>
					<?php   }   ?>


<?php } ?>

</select></td>
<td width="10px"></td>
<td>

<select id="desc<?php echo $i; ?>" name="desc[]" onChange="getcode(<?php echo $i; ?>);"  style="width:170px">
<option value="">Select</option>
<?php if($i==1)
{?>
<option value="<?php echo $qr['description']?>" selected="selected"><?php echo $qr['description'] ?></option>
<?php } else {?>

<?php


for($j=0;$j<count($items);$j++)
							{ $desc1=explode("@",$items[$j]);
					?>
	
					<option title="<?php echo $desc1[1];?>" <?php if($desc1[1]==$qr['description']) { ?> selected="selected" <?php }?>  value="<?php echo $desc1[0];?>"><?php echo $desc1[1]; ?></option>
					<?php   }   ?> 

<?php } ?>

</select>

</td>
<td width="10px"></td>
<td><select id="crdr<?php echo $i; ?>" name="crdr[]"  onchange="enabledrcr('<?php echo $i; ?>');" style="width:50px">
  <option value="">Select</option>
<?php if($i==1)
{?>
    <option value="Cr" selected="selected">Cr</option>
	
	<?php } else {?>
	
	  <?php
   if ( $qr['crdr'] == "Cr" ) { ?>
  <option value="Cr" selected="selected">Cr</option>
  <?php } else { ?>
  <option value="Cr">Cr</option>
  <?php } ?>
  <?php if ( $qr['crdr'] == "Dr" ) { ?>
  <option value="Dr" selected="selected">Dr</option>
  <?php } else { ?>
  <option value="Dr" >Dr</option>
  <?php } 
  ?>
	
	<?php }?>

</select></td>
<td width="10px"></td>
<td>
<input type="text"  align="right" id="dramount<?php echo $i; ?>"  name="dramount[]" <?php if ( $qr['crdr'] == "Cr" ) { ?> readonly="" <?php  } ?> value="<?php echo $qr['dramount']; ?>"  onkeyup="total();check_totamt(this);"  size="8" style="text-align:right" /></td>
<td width="10px"></td>
<td>
<input type="text" align="right" id="cramount<?php echo $i; ?>"  name="cramount[]" <?php if ( $qr['crdr'] == "Dr" ) {?> readonly <?php  } ?> value="<?php echo $qr['cramount']; ?>"   onkeyup="total();check_totamt(this);" size="8" style="text-align:right"  /></td>



<td width="10px"></td>
<td><textarea rows="2" cols="30" id="remarks" name="remarks[]"><?php echo $qr['rremarks'];?></textarea></td>


</tr>
<?php $i++; } ?>
</table>
<br />
</div>

<br />
<table cellpadding="5" cellspacing="5" align="center" border="0">
<tr>
<td>
<input type="text" style="visibility:hidden" size="8"/>
</td>
<td>
<input type="text" style="visibility:hidden" size="12"/>
</td>



<td width="150px" align="right">
<strong>Total</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
</td>
<td align="left">
<input type="text" id="drtotal" name="drtotal" value="<?php echo $drtotal; ?>" size="8" readonly style="border:0px;background:none; text-align:right;" />
</td>
<td align="left">
<input type="text" id="crtotal" name="crtotal" value="<?php echo $crtotal; ?>" size="8" readonly style="border:0px;background:none; text-align:right;"/>
</td>
<td>
<input type="text" style="visibility:hidden" size="14"/>
</td>
</tr>
</table>

<br />

<table align="center">
<tr>
<td width="250px"></td>
<td>
<strong>Payee Name</strong></td>
<td width="10px"></td>
<td><input type="text" name="pname" id="pname" value="<?php echo $pname; ?>" /></td>
<td width="10px"></td>
<td>
<strong>Payment Mode</strong></td>
<td width="10px"></td>
<td>
<select id="pmode" name="pmode" onChange="chequeenable();">
<option value="">Select</option>
<option value="Cheque"<?php if( $pmode == "Cheque" ) { ?>selected="selected" <?php } ?>>Cheque</option>
<option value="Others"<?php if( $pmode == "Others" ) { ?>selected="selected" <?php } ?>>Others</option>
</select></td>
<td width="10px"></td>
<td  id="chtd" <?php if($pmode != "Cheque") { ?> style="visibility:hidden;" <?php } ?> >
<strong>Cheque No.</strong></td>
<td width="10px"></td>
<td  <?php if($pmode != "Cheque") { ?> style="visibility:hidden;" <?php } ?>>
<input type="text" id="chno" name="chno" value="<?php echo $cheque; ?>" <?php if($cheque == "") { ?>  style="visibility:hidden" <?php } ?>/></td>

</tr>
</table>
<br>
<br>

<center>
<input type="submit" value="Update" id="Update" name="Update"/>&nbsp;&nbsp;&nbsp;<input name="button" type="button"  onClick="document.location='dashboardsub.php?page=ac_pvoucher';" value="Cancel"> 
</center>
<br/>
<br/>
</form>
</div>
</section>
</center>
<br/>



<script type="text/javascript">

function check_totamt(dis)
{
	var dt=document.getElementById("date").value;
	dt=dt.split(".");
	dt=dt[2]+"-"+dt[1]+"-"+dt[0];
	var fl=0;

}

function descriptionf()
{

 var myselect1=document.getElementById('desc1');


 var code=document.getElementById('code1').value;
 
 for(j=0;j<codedesc.length;j++)
 {
 
 	codedesc1=codedesc[j].split("@");
	
	if(codedesc1[0]==code)
	{
	  	var theOption=new Option(codedesc1[1],codedesc1[0]);
			
		theOption.title=codedesc1[1];
		theOption.selected=true;
			myselect1.options.add(theOption);
			
			}
 
 
 }

}


function getdesc(z)
{





if(document.getElementById('code' +z).value=="")
{
		document.getElementById('code' + z).value = "";
		document.getElementById('desc' + z).value="";
		return false;
}

for(i=1;i<=index;i++)
{

if((document.getElementById('code' +z).value==document.getElementById('code' + i).value)&&(i!=z))

{

alert("Please select different code");
document.getElementById('code' + z).value = "";
document.getElementById('desc' + z).value="";
return false;

}


}



document.getElementById("desc"+z).value=document.getElementById("code"+z).value;



}


function getcode(z)
{



if(document.getElementById('desc' + z).value=="")
{
		
		document.getElementById('code' + z).value = "";
		document.getElementById('desc' + z).value="";
		return false;
}


for(i=1;i<=index;i++)
{

if((document.getElementById('desc' + z).value==document.getElementById('desc' + i).value)&&(i!=z))

{

alert("Please select different description");
document.getElementById('desc' + z).value="";
document.getElementById('code' + z).value="";
return false;

}

}


document.getElementById("code"+z).value=document.getElementById("desc"+z).value;


}


function codecoa()
{
document.getElementById("code1").options.length=1;
document.getElementById("crdr1").options.length=1;
document.getElementById("desc1").options.length=1;



  document.getElementById('crtotal').value = document.getElementById('crtotal').value-document.getElementById('cramount1').value;
document.getElementById('drtotal').value = document.getElementById('drtotal').value-document.getElementById('dramount1').value;
document.getElementById('cramount1').value=0;
document.getElementById('dramount1').value=0;

 var code = document.getElementById('cno').value;
  myselect1=document.getElementById("code1");
  
  
   
 for(i=0;i<cashcodes.length;i++)
 {

 	cashbank1=cashcodes[i].split("@");
	

	if(cashbank1[0]==code)
	
	{
	
	  var op1=new Option(cashbank1[1],cashbank1[1]);
		op1.selected = "true";
		
			myselect1.options.add(op1);
	}
 
 
 }
 


for(i=0;i<bankcodes.length;i++)
 {
 
 
 	cashbank1=bankcodes[i].split("@");
	
	
	
	
	
	if(cashbank1[0]==code)
	
	{
	
	  var op1=new Option(cashbank1[1],cashbank1[1]);
		op1.selected = "true";
		
			myselect1.options.add(op1);
	}
 
 
 }
 

			
		descriptionf();     
         myselect2 = document.getElementById("crdr1");
		var op1=new Option("Cr","Cr");
		op1.selected = "true";
		
			myselect2.options.add(op1);
			
			
			
	document.getElementById('cramount1').readOnly=false;
document.getElementById('dramount1').readOnly=true;
	if(Number(document.getElementById('crtotal').value)!=Number(document.getElementById('drtotal').value))
	document.getElementById('Update').disabled=true;	

}



function chequeenable()
{
	if(document.getElementById('pmode').value == "Cheque")
	{
	document.getElementById('chno').style.visibility = "visible";
	document.getElementById('chtd').style.visibility = "visible";
        

	}
	else
	{

	document.getElementById('chtd').style.visibility = "hidden";
	document.getElementById('chno').style.visibility = "hidden";
	}
	
}

function total()
{
    var ctot = 0;
	var dtot = 0;
	for (var i = 1;i<=index;i++)
	{
		
		
		
		if(document.getElementById('cramount' + i).value=="")
		document.getElementById('cramount' + i).value=0;
		if(document.getElementById('dramount' + i).value=="")
		document.getElementById('dramount' + i).value=0;
		
	    ctot+=parseFloat(document.getElementById('cramount' + i).value);
		dtot+=parseFloat(document.getElementById('dramount' + i).value);
	}
	
	document.getElementById('crtotal').value = ctot;
	document.getElementById('drtotal').value = dtot;
	if( document.getElementById('crtotal').value != document.getElementById('drtotal').value )
	{
		document.getElementById('Update').disabled = true;
	}
	else
	{
			document.getElementById('Update').disabled = false;
	}
}

function enabledrcr(x)
{document.getElementById('crtotal').value = document.getElementById('crtotal').value-document.getElementById('cramount' + x).value;
document.getElementById('drtotal').value = document.getElementById('drtotal').value-document.getElementById('dramount' + x).value;
document.getElementById('cramount' + x).value = 0;
document.getElementById('dramount' + x).value = 0;
//document.getElementById('crtotal').value = 0;
//document.getElementById('drtotal').value = 0;
	if(document.getElementById('crdr' + x).value == "Cr")
	{
	document.getElementById('cramount' + x).removeAttribute('readonly','readonly');
	document.getElementById('dramount' + x).setAttribute('readonly',true);
	}
	else if(document.getElementById('crdr' + x).value == "Dr")
	{
	document.getElementById('dramount' + x).removeAttribute('readonly','readonly');
	document.getElementById('cramount' + x).setAttribute('readonly',true);
	}
	else
	{
	document.getElementById('dramount' +x).setAttribute('readonly',true);
	document.getElementById('cramount' +x).setAttribute('readonly',true);
	}
	
	
	if(Number(document.getElementById('crtotal').value)!=Number(document.getElementById('drtotal').value))
	
	document.getElementById('Update').disabled = true;
	
	
}
</script>



<script type="text/javascript">


function checkform1(form)
{
if(form.unitc.value == "")
{
alert("Please Select Unit");
 form.unitc.focus();
return false;
}




if(form.cno.value == "")

{
alert("Please code ");

return false;
}


for(j=1;j<=index;j++)
{


k=j;

if(Number(document.getElementById('cramount' + k).value >0)  ||Number(document.getElementById('dramount' + k).value >0))
{
if(document.getElementById('code'+k).value=="" || document.getElementById('crdr'+k).value=="" || document.getElementById('desc'+k).value=="")
{


	alert("Select code for row"+j);
	
	return false;

}


}


for(p=1;p<=index;p++)
{

if((document.getElementById('code'+k).value==document.getElementById('code'+p).value)&& (p!=k)&& (document.getElementById('code'+k).value=!""))
{
document.getElementById('code'+k).value=document.getElementById('code' +p).value
	document.getElementById('code' +p).value="";
	document.getElementById('desc' + p).value="";

	alert("Select different code for row "+(p));

	return false;
}



}





}

document.getElementById('Update').disabled=true;	
}

</script>





<script type="text/javascript">
function script1() {
window.open('GLHelp/help_t_addpaymentvoucher.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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

<!--[if lt IE 8]></div><![endif]-->
<!--[if lt IE 9]></div><![endif]-->
</body>
</html>

