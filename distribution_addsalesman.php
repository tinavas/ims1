<?php

include "timepicker.php";

if($_GET['fromdate']<>"")
{
$fromdate=date("d.m.Y",strtotime($_GET['fromdate']));
}

else
{
$fromdate=date("d.m.Y");
}

if($_GET['todate']<>"")
{
$todate=date("d.m.Y",strtotime($_GET['todate']));
}

else
{
$todate=date("d.m.Y");
}

if($_GET['salesman']<>"")
{
$salesman=$_GET['salesman'];
}

else
{
$salesman="";
}

if($_GET['superstockist']<>"")
{
$superstockist=$_GET['superstockist'];
}

else
{
$superstockist="";
}



?>
<html>
<body>

<head>

  
 
    
    <link rel="stylesheet" type="text/css" href="DataTables/media/css/jquery.dataTables.css">
<link rel="stylesheet" type="text/css" href="DataTables/examples/resources/syntax/shCore.css">
<link rel="stylesheet" type="text/css" href="DataTables/examples/resources/demo.css">
    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
  
   <!-- <script type="text/javascript" language="javascript" src="DataTables/media/js/jquery.js"></script>-->
	<script type="text/javascript" language="javascript" src="DataTables/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="DataTables/examples/resources/syntax/shCore.js"></script>
	<script type="text/javascript" language="javascript" src="DataTables/examples/resources/demo.js"></script>
    <script type="text/javascript" src="dataTables.dateFormat.js"></script>
    
  
    <script type="text/javascript" language="javascript" class="init">

<?php

if($_GET['superstockist']!="")
{
?>

//display table pagination--------------
var oTable;

$(document).ready(function()
 {
 
             var table=$('#datatable').dataTable(
	 {
	
		"order": [[ 3, "desc" ]],
		"iDisplayLength": 4,
		"bSort": false
	
	} 
	
	);
	//-------------------------------------------------------
	
	//collect the all ckecked nodes in form 
	
	$('#salesnman').submit( function() {
	
	var i=0;
	var checkbox_value=[];

var rowcollection =  table.$(".allareacodes:checked", {"page": "all"});

rowcollection.each(function(index,elem){
     checkbox_value[i++]= $(elem).val();
    
	});
	
	//alert(checkbox_value);
	
	document.getElementById("allcheckvalues").value=checkbox_value.join('$');
	
	//alert(document.getElementById("allcheckvalues").value);
	
	if(checkbox_value.length=="" || checkbox_value.length==0)
	{
	alert("Select Atlest One");
	
	return false;
	}
	
	document.getElementById("save").disabled="true";
document.getElementById("cancel").disabled="true";

	
} );




//---------------------------


} );


<?php }?>



</script>

</head>



<div align="center">
<br/><br/>
<h1>Add Sales Man</h1>
(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<br/><br/><br/><br/>
<form  method="post" action="distribution_savesalesman.php"  name="salesnman" id="salesnman" onSubmit="return checkform()">

<input type="hidden" name="allcheckvalues" id="allcheckvalues" />

<strong>From Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="fromdate" id="fromdate" style="width:100px" value="<?php echo $fromdate;?>" class="datepicker"  onChange="comparedate('fromdate')" />&nbsp;&nbsp;&nbsp;

<strong>To Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<input type="text" name="todate" id="todate" style="width:100px" value="<?php echo $todate;?>" class="datepicker" onChange="comparedate('todate')"/>&nbsp;&nbsp;&nbsp;


<strong>Sales Man<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="salesman" id="salesman">
<option value="">-Select-</option>
<?php

$q1="select name from hr_employee where designation like '%Sales Man%' and name not in (SELECT distinct salesman FROM `distribution_salesman`) ";

$q1=mysql_query($q1,$conn) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))

{

?>

<option value="<?php echo $r1['name'];?>" <?php if($salesman==$r1['name']){?> selected="selected" <?php }?>><?php echo $r1['name'];?></option>

<?php }?>

</select>&nbsp;&nbsp;&nbsp;


<strong>CNF/Super Stockist<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong>
<select name="superstockist" id="superstockist" onChange="reloadpage()">
<option value="">-Select-</option>
<?php

$q1="SELECT distinct superstockist FROM `distribution_area`";

$q1=mysql_query($q1,$conn) or die(mysql_error());

while($r1=mysql_fetch_assoc($q1))

{

?>

<option value="<?php echo $r1['superstockist'];?>" <?php if($superstockist==$r1['superstockist']){?> selected="selected" <?php }?>><?php echo $r1['superstockist'];?></option>

<?php }?>

</select>&nbsp;&nbsp;&nbsp;

</br></br></br>

<?php

$extracell=0;
$str="<td></td><td></td><td></td><td></td><td></td><td></td>";

$totcount=0;

 $str="";
         $j=0;
		 $q1="select areacode,areaname from distribution_area where  superstockist='$superstockist' and areacode not in (SELECT distinct areacode FROM `distribution_salesman`)";
$q1=mysql_query($q1) or die(mysql_error());
$totcount=mysql_num_rows($q1);
 $extracell=ceil($totcount/6)*6-$totcount;
while($r1=mysql_fetch_assoc($q1))

		 {
		 if($j==6)
		 {
		$str=$str."</tr><tr>";
		 $j=0;
		 }
      
     $str=$str."<td title=\"$r1[areaname]\" style='text-align:left'>&nbsp;&nbsp;<input type=\"checkbox\" name=\"areacode[]\" title=\"$r1[areaname]\" value='$r1[areacode]' class='allareacodes'>".$r1['areacode']."(".$r1['areaname'].")"."</td>";
         $j++;
		 }
if($totcount==0)
{
$extracell=6;
}

?>
<section>
	<div class="container" id="container" >
	
	<table id="datatable" class="display" cellspacing="0" width="100%">
				<thead>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</thead>

				<tfoot>
					<tr>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
					</tr>
				</tfoot>
       <tbody>
         <tr>
      
      <?php
	   for($i=0;$i<$extracell;$i++)
	  {
	  $str=$str."<td></td>";
	  }
	  
	  echo $str;
	  
	 
	  
	  ?>
      

         
         </tr></tbody></table>
        
    
			</div>
	
	</section>


<input type="submit" value="Save"  id="save" />&nbsp;&nbsp;
<input type="button" value="Cancel"  onclick="document.location='dashboardsub.php?page=distribution_salesman'" id="cancel"/>



</form>

<br />
<script type="text/javascript">

function reloadpage()
{

var fromdate=document.getElementById("fromdate").value;

var todate=document.getElementById("todate").value;

var salesman=document.getElementById("salesman").value;

var superstockist=document.getElementById("superstockist").value;


document.location="dashboardsub.php?page=distribution_addsalesman&fromdate="+fromdate+"&todate="+todate+"&salesman="+salesman+"&superstockist="+superstockist;


}

function checkform()
{

if(document.getElementById("fromdate").value=="")
{
alert("Enter From Date");
document.getElementById("fromdate").focus();
return false;
}

if(document.getElementById("todate").value=="")
{
alert("Enter To Date");
document.getElementById("todate").focus();
return false;
}


if(document.getElementById("salesman").value=="")
{
alert("Select Sales Man");
document.getElementById("salesman").focus();
return false;
}

if(document.getElementById("superstockist").value=="")
{
alert("Select superstockist");
document.getElementById("superstockist").focus();
return false;
}



}



function comparedate(value)
{

var fromdate=document.getElementById("fromdate").value;

var todate=document.getElementById("todate").value;

if(fromdate!="" && todate!="")
 {
 
   var fdate=fromdate.split(".");
   
   var formfdate=fdate[2]+"/"+fdate[1]+"/"+fdate[0];
   
   var tdate=todate.split(".");
   
   var formtdate=tdate[2]+"/"+tdate[1]+"/"+tdate[0];

  var ff=new Date(formfdate);
  
  var tt=new Date(formtdate);
  
  if(ff.getTime()>tt.getTime() || tt.getTime()<ff.getTime() )
  {
  if(value=="fromdate")
   {
   alert("Todate Should be greater Than fromdate");
   
   document.getElementById("fromdate").value="";
   
    document.getElementById("fromdate").focus();
	
	return false;
	}
	
	if(value=="todate")
   {
    alert("Todate Should be greater Than fromdate");
	
   document.getElementById("todate").value="";
   
    document.getElementById("todate").focus();
	
	return false;
	}
   
   
   }
  }
 }





</script>


</div>

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
