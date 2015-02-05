<?php 
include "jquery.php"; 

include "getemployee.php";



$q1="SELECT warehouse,group_concat(distinct producttype,'@',productdesc separator '$') as cd FROM `product_formula` group by warehouse";
$q1=mysql_query($q1) or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
$allcode[]=array("warehouse"=>$r1['warehouse'],"cd"=>$r1['cd']);
 }

$allcodej=json_encode($allcode);


$q1="SELECT producttype,group_concat(distinct name separator '$') as cd,warehouse FROM `product_formula` group by producttype,warehouse";
$q1=mysql_query($q1) or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
$allname[]=array("producttype"=>$r1['producttype'],"cd"=>$r1['cd'],"warehouse"=>$r1['warehouse']);
}

$allnamej=json_encode($allname);

if($_GET['date']<>"")
{
$date=$_GET['date'];
}
else
{
$date=date("d.m.Y");
}

if($_GET['producttype']<>"")
{

$producttype=$_GET['producttype'];

}
if($_GET['warehouse']<>"")
{

$warehouse=$_GET['warehouse'];

}



?>
<script type="text/javascript">

var allcodej=<?php echo $allcodej;?>;
var allnamej=<?php echo $allnamej;?>;
</script>
<script type="text/javascript">
function changediv(b)
{
 var producttype = document.getElementById("producttype").value; 
 var formula =  document.getElementById("formula").value; 
var warehouse=document.getElementById("warehouse").value;
 var date =  document.getElementById("date1").value; 
 var a=document.getElementById("batches").value
 var b =  producttype + "?" + formula + "?" + date +"?"+warehouse+"?"+a;

 getdiv('getdata',b,'production_productionframe.php?data=');
}

function getformula(a) {
var wh=document.getElementById("warehouse").value;
removeAllOptions(document.getElementById("formula"));
myselect1 = document.getElementById("formula");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
alert(a);


for(i=0;i<allnamej.length;i++)
{
//alert( allnamej[i].warehouse+"="+wh);
if(allnamej[i].producttype==a && allnamej[i].warehouse==wh )
{

var val=allnamej[i].cd.split("$");

for(j=0;j<val.length;j++)
{

var op=new Option(val[j],val[j]);
op.title=val[j];
myselect1.add(op);

}
}

}



}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		//selectbox.options.remove(i);
		selectbox.remove(i);
	}
}

function getproducttype(warehouse)
{

removeAllOptions(document.getElementById("formula"));
removeAllOptions(document.getElementById("producttype"));

myselect1 = document.getElementById("formula");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

myselect1 = document.getElementById("producttype");
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
//alert(warehouse);
for(i=0;i<allcodej.length;i++)
{
if(allcodej[i].warehouse==warehouse)
{
var val=allcodej[i].cd.split("$");
for(i=0;i<val.length;i++)
{
val1=val[i].split('@');
var op=new Option(val1[0],val1[0]);
op.title=val1[1];
myselect1.add(op);
}
}
}

}

function calc(A,B,SUM,D,E,F,G,H,I,J,K,L) {}
 function calc1(A,B,SUM,D,E,F,G) 
 {}
 function ca(A,B,SUM,D,E,F,G) {}

function getcapacity(bagtype)
{

}

function calculatevalues()
{

var shrinkage=parseFloat(document.getElementById("shrinkage").value);
var pproduction=parseFloat(document.getElementById("pproduction").value);

var materialcost=parseFloat(document.getElementById("materialcost").value);


if(shrinkage>pproduction)
{
alert("shrinkage should not be grtaer than output");
document.getElementById("shrinkage").value="";
document.getElementById("shrinkage").focus();
return false;
}

var actualoutput=pproduction-shrinkage;

document.getElementById("production").value=actualoutput;

document.getElementById("costperunit").value=roundNumber((materialcost/parseFloat(document.getElementById("production").value)),5);


document.getElementById("shrinkageper").value=Math.round((shrinkage/pproduction)*100,5);

if(isNaN(document.getElementById("production").value))
{
document.getElementById("production").value=0;
}


if(isNaN(document.getElementById("costperunit").value))
{
document.getElementById("costperunit").value=0;
}


if(isNaN(document.getElementById("shrinkageper").value))
{
document.getElementById("shrinkageper").value=0;
}


}


function roundNumber(num, dec) {
	var result = Math.round(num*Math.pow(10,dec))/Math.pow(10,dec);
	return result;
}
</script>

<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:600px" id="complex_form" method="post" action="product_saveproductionunit.php" onsubmit="return checkform()">
	  <h1 id="title1"> Production</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center>
			  (Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
			  
<table>
<tr height="5px"></tr>
<tr>
<td>
<strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
<input type="text" name="date1" id="date1" class="datepickerPR" value="<?php echo $date; ?>"  size="10" onchange="reloadpage()"  /> 
</td>
<td width="10px"></td>
<td>
<strong>Warehouse</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
         <select name="warehouse" id="warehouse" style="width:128px;" onchange="reloadpage()" >
           <option>-Select-</option>
           <?php
		   
		    if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
	 
	 if($sectorlist=="")   
				
				$query = "SELECT distinct(sector) FROM tbl_sector where type1='Warehouse'  ORDER BY sector ASC";
				
				else
				
				$query = "SELECT distinct(sector) FROM tbl_sector where type1='Warehouse' and sector in ($sectorlist) ORDER BY sector ASC";
           
                
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['sector']; ?>" title="<?php echo $row1['sector']; ?>" <?php if($row1['sector']==$_GET['warehouse']){?> selected="selected" <?php }?>><?php echo $row1['sector']; ?></option>
           <?php } ?>
         </select>
</td>
<td width="10px"></td>

<td width="10px"></td>
<td>
<strong> Product code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
         <select name="producttype" id="producttype" style="width:100px;" onchange="document.getElementById('producttypedesc').options[document.getElementById('producttype').options.selectedIndex].selected='selected';reloadpage();">
         <option>-Select-</option>
     	 
      <?php
	  $q1="SELECT distinct producttype,productdesc FROM `product_formula`";
	  $q1=mysql_query($q1,$conn) or die(mysql_error());
	  while($r1=mysql_fetch_assoc($q1))
{
?>

<option value="<?php echo $r1['producttype'];?>" <?php if($r1['producttype']==$_GET['producttype']){?> selected="selected" <?php }?>><?php echo $r1['producttype'];?></option>

<?php }?>         
         
         
         </select>
</td>
<td width="10px"></td>
<td>
<strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
         <select name="producttypedesc" id="producttypedesc" style="width:100px;" onchange="document.getElementById('producttype').options[document.getElementById('producttypedesc').options.selectedIndex].selected='selected';reloadpage();">
         <option>-Select-</option>
     	 
      <?php
	  $q1="SELECT distinct producttype,productdesc FROM `product_formula`";
	  $q1=mysql_query($q1,$conn) or die(mysql_error());
	  while($r1=mysql_fetch_assoc($q1))
{
?>

<option value="<?php echo $r1['productdesc'];?>" title="<?php echo $r1['productdesc'];?>"<?php if($r1['productdesc']==$_GET['producttypedesc']){?> selected="selected" <?php }?>><?php echo $r1['productdesc'];?></option>

<?php }?>         
         
         
         </select>
</td>

<td width="10px"></td>
<td>
<strong>Formula.#</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>
         <select name="formula" id="formula" style="width:180px;"  onchange="reloadpage();"  >
         <option value="">-Select-</option>
         <?php
		 
		 $q1="select distinct name from product_formula where producttype='$producttype' and warehouse='$warehouse'";
		 
		 $q1=mysql_query($q1) or die(mysql_error());
		 
		 while($r1=mysql_fetch_assoc($q1))
		 {?>
         
         <option value="<?php echo $r1['name'];?>"<?php if($r1['name']==$_GET['formula']){?> selected="selected" <?php }?>><?php echo $r1['name'];?></option>
         <?php }?>
         
         
         
         </select>
</td>
<td width="10px"></td>

<td>


</td>

<td width="10px"></td>

<td>
<strong>Batches</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>

<?php

$date2=date("Y-m-d",strtotime($date));

 $q1="SELECT sum(packets) as packets FROM `packing_dailypacking` where location='$warehouse' and date='$date2' and code='$producttype'";

$q1=mysql_query($q1) or die(mysql_error());

$r1=mysql_fetch_assoc($q1);

$packets=$r1['packets'];

?>

<input type="text" name="batches" id="batches" value="<?php echo $packets;?>" size="5"  readonly="readonly" /> 

<?php
if(isset($_GET['formula']) && $_GET['formula']<>"")
{
?>
<script type="text/javascript">

changediv('value');

</script>


<?php

}
?>



</td>

</tr>
<tr height="30px"><td></td></tr>
</table>
<div id="getdata">
</div>

             </center>
     </form>
  </div>
</section>

		


<div class="clear"></div>
<br />

<?php 

$q = "select distinct(code) from ims_bagdetails";
$qrs = mysql_query($q,$conn) or die(mysql_error());
$count = mysql_num_rows($qrs);
?>



<script type="text/javascript">
	function roundof( N ) {

		if ((navigator.appName.indexOf('Microsoft')>-1)
			&& (navigator.appVersion.indexOf('3.0')>-1) )
		{
			return N;
		}
		S = new String( N );
		var i = S.indexOf('.');
		if (i != -1) {
			S = S.substr( 0, i+3 );
			if (S.length-i < 3)
				S = S + '0';
		}
		return S;
	}

function script1() {
window.open('FeedmillHelp/help_p_addproduction.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=no,resizable=no');
}

var index = 0;
function getRow()
{
if((parseFloat(index) + 1) == "<?php echo $count; ?>")
{
	return;
}
	index = index + 1;
	mytable = document.getElementById('tableid');
	
	mytr = document.createElement('tr');
	mytr.height = "10px";
	
	mytd = document.createElement('td');
	mytr.appendChild(mytd);
	
	mytr = document.createElement('tr');
		
	mytd = document.createElement('td');
	myselect1 = document.createElement("select");
	myselect1.id = "ebagtype@" + index;
	myselect1.name = "ebagtype[]";
	myselect1.onchange = function () { checkcodes(); };
	
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("-Select-");
    theOption1.appendChild(theText1);
	theOption1.value = "";
    myselect1.appendChild(theOption1);
	
	<?php 
	$q = "select distinct(code),description from ims_bagdetails order by code";
	$qrs = mysql_query($q) or die(mysql_error());
	while($qr = mysql_fetch_assoc($qrs))
	{
	?>
    theOption1=document.createElement("OPTION");
    theText1=document.createTextNode("<?php echo $qr['code']; ?>");
    theOption1.appendChild(theText1);
	theOption1.value = "<?php echo $qr['code']; ?>";
	theOption1.title = "<?php echo $qr['description']; ?>";
    myselect1.appendChild(theOption1);
	<?php } ?>	
	mytd.appendChild(myselect1);
	
	mytr.appendChild(mytd);
	
	mytd = document.createElement('td');
	mytd.width = "10px";
	mytr.appendChild(mytd);
	
	mytd = document.createElement('td');
	input = document.createElement("input");
	input.type = "text";
	input.id = "enoofbags@" + index;
	input.name = "enoofbags[]";
	input.onchange = function () { getRow(); };
	input.size = "7";
	mytd.appendChild(input);
	mytr.appendChild(mytd);
	
	mytable.appendChild(mytr);
}

function checkcodes()
{

	for(var i = 0; i <= index; i++)
	{
		for(var j = 0; j <= index; j++)
		{
			if( i!= j && document.getElementById('ebagtype@' + i).value == document.getElementById('ebagtype@' + j).value)
			{
				alert("Please select different combination");
				document.getElementById('ebagtype@' + j).selectedIndex = 0;
				return;
			}
		}
	}

}

function reloadpage()
{
var date=document.getElementById("date1").value;

var warehouse=document.getElementById("warehouse").value;

var producttype=document.getElementById("producttype").value;

var producttypedesc=document.getElementById("producttypedesc").value;

var formula=document.getElementById("formula").value;


document.location='dashboardsub.php?page=product_addproduction&date='+date+'&warehouse='+encodeURIComponent(warehouse)+'&producttype='+encodeURIComponent(producttype)+'&producttypedesc='+encodeURIComponent(producttypedesc)+'&formula='+encodeURIComponent(formula);


}

function checkform()
{
if(document.getElementById("date1").value=="")
{
 alert("Plese Select Date");
 document.getElementById("date1").focus();
 return false;
}

if(document.getElementById("warehouse").value=="")
{
 alert("Plese Select Warehouse");
 document.getElementById("warehouse").focus();
 return false;
}

if(document.getElementById("producttype").value=="")
{
 alert("Plese Select Code");
 document.getElementById("wareproducttypehouse").focus();
 return false;
}


if(document.getElementById("formula").value=="")
{
 alert("Plese Select Formula");
 document.getElementById("formula").focus();
 return false;
}

if(document.getElementById("batches").value=="")
{
 alert("Batches should not be empty");
 document.getElementById("batches").focus();
 return false;
}


if(document.getElementById("pproduction").value=="" || document.getElementById("pproduction").value=="0")
{
 alert("Enter Output Value");
 document.getElementById("pproduction").focus();
 return false;
}



document.getElementById('save').disabled=true;

document.getElementById('cancel').disabled=true;

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
