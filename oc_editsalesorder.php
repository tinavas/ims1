<?php //include "jquery.php";
include "config.php"; 
include "timepicker.php"; ?>
<link href="editor/sample.css" rel="stylesheet" type="text/css"/>

<?php 
$so = $_GET['po'];
$query = "SELECT * from oc_salesorder where po = '$so' LIMIT 1";
$result = mysql_query($query,$conn) or die(mysql_error());
$rows = mysql_fetch_assoc($result);
$poincr = $rows['poincr'];
$m = $rows['m'];
$y = $rows['y'];
$po = $rows['po'];
$vendor = $rows['vendor'];
$date = $rows['date'];
$tandc = $rows['tandc'];
$warehouse = $rows['warehouse'];
$salesperson = $rows['salesperson'];
   $empname=$rows['empname'];
   
$q1=mysql_query("SET group_concat_max_len=10000000");
   
   
   
   //contact details

 $query = "SELECT group_concat(distinct(name) order by name) as name FROM contactdetails where type like '%party%'  ";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
	 $names=explode(",",$row["name"]);
}
$name=json_encode($names);
   
   
   
   
   
   //sectors

	    if($_SESSION['sectorall'] == "all" || ($_SESSION['sectorall'] == "" && $_SESSION['sectorlist'] == ""))
	{
         $sectorlist=""; 
	  
	 }
	 else
	 {
	 $sectorlist = $_SESSION['sectorlist'];
	 
	 }
	
		if($sectorlist=="")  
 $q1 = "SELECT GROUP_CONCAT( DISTINCT (sector)  ORDER BY sector ) as sector FROM tbl_sector WHERE type1 =  'warehouse'";
else

 $q1 = "SELECT GROUP_CONCAT( DISTINCT (sector) as sector ORDER BY sector ) as sector FROM tbl_sector WHERE type1 =  'warehouse' and sector in ($sectorlist)";
	 
	  $res1 = mysql_query($q1,$conn); 

$rows1 = mysql_fetch_assoc($res1);
     {
	 
 $sec1=explode(",",$rows1["sector"]);	
			
			
	 }
	 
	 $sector=json_encode($sec1);

   
   
//------------------Cat &Item COdes----------------------

$i=0;
$query="select distinct(cat),group_concat(concat(code,'@',description,'@',cunits)) as cd from ims_itemcodes where  iusage LIKE '%Sale%'  group by cat";

$result=mysql_query($query,$conn);
while($row=mysql_fetch_array($result))
{

$items[$i]=array("cat"=>"$row[cat]","cd"=>"$row[cd]");

$i++;

}

$item=json_encode($items);
   
     //---------------Tax Codes-------------------------------
   $q="select group_concat(code,'@',description,'@',codevalue,'@',mode,'@',rule order by code) as tax FROM ims_taxcodes where type = 'Tax'and (taxflag = 'S'  or taxflag='A')";
  $qrs=mysql_query($q,$conn) or die(mysql_error());
  $qr=mysql_fetch_assoc($qrs);
  $tax=explode(",",$qr['tax']);
  $tax1=json_encode($tax);

 
  
  //---------------------------Standard Cost----------------------
  
  
  	$q="select group_concat(code,'@',fromdate,'@',todate,'@',stdcost order by code) as stdcostdate from ims_standardcosts";
	
	$qrs=mysql_query($q,$conn) or die(mysql_error());
  $qr=mysql_fetch_assoc($qrs);
  $stdcost=explode(",",$qr['stdcostdate']);
  $stdcost1=json_encode($stdcost);
 

   
   ?>
<script type="text/javascript">
var items=<?php if(empty($item)){echo 0;}else{ echo $item; } ?>;
var names=<?php if(empty($name)){echo 0;}else{ echo $name; } ?>;
var taxs=<?php if(empty($tax1)){echo "0";}else{ echo $tax1;}?>;
var discs=<?php if(empty($dis1)){echo "0";}else{ echo $dis1;}?>;
var fris=<?php if(empty($fri1)){echo "0";}else{ echo $fri1;}?>;
var stdcost=<?php if(empty($stdcost1)){echo "0";}else{ echo $stdcost1;}?>;
var sectors1=<?php if(empty($sector)){echo "0";}else{ echo $sector; } ?>;
</script>


<center>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" id="complex_form" method="post" action="oc_savesalesorder.php" onSubmit="return calculate(this);">
	  <h1>Sales Order</h1>
		
		
		<br />
<b>Sales Order</b>
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br />


		
<table align="center">
              <tr>

             <!-- hidden variables start -->

                <input type="hidden" name="poincr" id="poincr" value="<?php echo $poincr; ?>"/>
                <input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
                <input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>
				<input type="hidden" name="saed" id="saed" value="1" />
				<input type="hidden" name="cuser" id="cuser" value="<?php echo $empname;?>" />
				<input type="hidden" name="oldso" id="oldso" value="<?php echo $po; ?>" />

             <!-- hidden variables end -->
               
                <td align="right"><strong>S.O</strong></td>
                <td>&nbsp;<input type="text" size="14" id="po" name="po" value="<?php echo $po; ?>" readonly style="border:0px;background:none" /></td>
                <td width="10px"></td>

                <td align="right"><strong>Party</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;
                <select style="width:180px" name="vendor" id="vendor" >
                             <option value="">-Select-</option>
							 
							 <?php 
 for($j=0;$j<count($names);$j++)
		   {
			$na=explode("@",$names[$j]);
           ?>
<option value="<?php echo $names[$j];?>" title="<?php echo $na[0]; ?>" <?php if($na[0]==$vendor) {?> selected="selected" <?php  } ?>><?php echo $na[0]; ?></option>
<?php } ?>
						

                </select>
                </td>
				<td width="10px"></td>

          
                <td align="right"><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input type="text" size="10" id="mdate" class="datepicker" name="mdate" value="<?php echo date("d.m.o",strtotime($date)); ?>" onchange="getpo();" /></td>
				<td width="10px"></td>
               

			   <td align="right"><strong>Warehouse</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
			   <td>&nbsp;
			    <select id="warehouse" name="warehouse" style="width:120px;">
				<option value="">-Select-</option>
				
				<?php 
 for($j=0;$j<count($sec1);$j++)
		   {
			
           ?>
<option value="<?php echo $sec1[$j];?>" title="<?php echo $sec1[$j]; ?>" <?php if($sec1[$j]==$warehouse){?> selected="selected" <?php } ?>><?php echo $sec1[$j]; ?></option>
<?php } ?>


				</select>
				</td>
		
			
              </tr>
            </table>

		
		
            




<br />





<!-- /////////////////////////////Purchase Order Starts/////////////////////////////////////////// -->

<center>
 <table border="0" id="tab">
    <tr>
        <th style=""><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>
 
        <th style=""><strong>Item Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>
  
        <th style=""><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>
       
	     <th style=""><strong>Units</strong></th>
        
        
        <th width="10px"></th>
        
 <th style=""><strong> Quantity </strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
      
        <th width="10px"></th>

        <th style=""><strong>Price</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
        <th width="10px"></th>
 
 
 
 
  <th><strong>Tax</strong></th>
 <th width="10px"></th>
 
 <th><strong>Freight</strong></th>
 <th width="10px"></th>
 
  <th><strong>Discount</strong></th>
  <th width="10px"></th>
        <th style=""><strong>Delivery Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
		
	
		
     </tr>
	 <tr style="height:20px"></tr>
<?php
$i=-1;
$query= "select * from oc_salesorder where po = '$so' ORDER BY id";
$result = mysql_query($query,$conn) or die(mysql_error());
$numr=mysql_num_rows($result);
while($rows = mysql_fetch_assoc($result))
{$i++;
?>

     <tr>
 
       <td style="text-align:left;">
         <select name="category[]" id="type<?php echo $i;?>" onchange="fun(this.id);" style="width:90px;">
           <option value="">-Select-</option>
		   
		   
		   	      <?php 
	 
	  
for($c=0;$c<count($items);$c++)
{
?>
<option value="<?php echo $items[$c]["cat"]; ?>" <?php  if ($items[$c]["cat"] ==  $rows['category']){?> selected="selected"<?php } ?> ><?php echo $items[$c]["cat"]; ?></option>
<?php } ?>

         </select>
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <select name="code[]" id="code<?php echo $i;?>" onchange="description(this.id)" style="width:80px;">
           <option value="">-Select-</option>
		   
		   						  <?php 
for($c=0;$c<count($items);$c++)
{
if($items[$c]["cat"]==$rows['category'])
  {
  $cd=$items[$c]["cd"];
  $cd2=explode(',',$cd);
  for($j=0;$j<count($cd2);$j++)
  {
  $cd1=explode('@',$cd2[$j]);
?>
<option value="<?php echo $cd2[$j]; ?>" <?php  if ($cd1[0] ==$rows['code']){?> selected="selected"<?php } ?> ><?php echo $cd1[0]; ?></option>
<?php }} }?>
		   

         </select>
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="description[]" id="desc<?php echo $i;?>" readonly size="15" value="<?php echo $rows['description']; ?>"  /> 
       </td>
       <td width="10px"></td>
	   
	    
		
	  
       <td style="text-align:left;">
         <input type="text" name="units[]" id="munit<?php echo $i;?>" readonly size="8" value="<?php echo $rows['unit']; ?>" style="background:none; border:none"  />
       </td>
       <td width="10px"></td> 
	   
	   
	   
	   

       <td style="text-align:left;">
         <input type="text" name="quantity[]" id="qtys<?php echo $i;?>"  size="8" value="<?php echo $rows['quantity']; ?>"  onkeyup="getvalues(this.id)" onfocus="return makeForm(this.id)" onblur="checknum(this.value,this.id)"/>
       </td>
       <td width="10px"></td>
 

       <td style="text-align:center;">
         <input type="text" name="rate[]" id="unit<?php echo $i;?>"  size="8" value="<?php echo $rows['rateperunit']; ?>" onkeyup="checknum(this.value,this.id)" />
       </td>
       <td width="10px"></td>
	   
	   
	   
	   
	   <td>
           <select name="tax[]" id="tax<?php echo $i;?>"  style="width:80px;">
             <option value="0">-Select-</option>
			 
			  <?php 
	     for($t=0;$t<count($tax);$t++)
           {
		     $tx=explode('@',$tax[$t]);
     ?>
             <option title="<?php echo $tx[1]; ?>" value="<?php echo $tx[0]."@".$tx[2]."@".$tx[3]."@".$tx[4]; ?>"<?php if($tx[0]==$rows['taxcode']){?> selected="selected"<?php } ?>><?php echo $tx[0]; ?></option>
     <?php } ?>
			 

           </select>
		   
		<td width="10px"></td>
         <td>
            <select name="freight[]" id="freight@<?php echo $index; ?>"  style="width:100px;">
			
			
			<option value="">--Select--</option>
			<option value="Include Paid By Customer" <?php if($rows['freightie']=="Include Paid By Customer") { ?> selected="selected" <?php  } ?>>Include Paid By Customer</option>
			<option value="Exclude" <?php if($rows['freightie']=="Exclude") { ?> selected="selected" <?php  } ?>>Exclude</option>
			<option value="Include" <?php if($rows['freightie']=="Include") { ?> selected="selected" <?php  } ?>>Include</option>
			
			
           </select>          </td>
 
 <td width="10px"></td>

         <td>
           <input type="text" name="disc[]"	 id="disc@<?php echo $index; ?>" size="8" value="<?php echo $rows['discountvalue'];?>" />
		   	  </td>
		  	 <td width="10px"></td>
		 
		
       <td style="text-align:center;">
       <input type="text" size="10" id="rdate<?php echo $i;?>" name="rdate[]" class="datepicker" value="<?php echo date("d.m.o",strtotime($rows['deliverydate'])); ?>">
       </td>
<td width="10px"></td>

	   
	</tr>
<?php

}
?>
   </table>
   <br /> 



<table border="0" align="center">
<tr>
<td style="vertical-align:middle"><strong>Terms&nbsp;Conditions</strong>

<br/>
<br/>
<select name="tandccode[]" id="tandccode"  style="width:150px;" multiple onclick="getdescr(this.value)">
             <option disabled>-Select-</option>
             <?php
                   
                  $query = "SELECT * FROM ims_terms ORDER BY code DESC ";
                  $result = mysql_query($query,$conn); 
                  while($row1 = mysql_fetch_assoc($result))
                  {
				  if(strlen(strstr($tandc,$row1['description']))>0)
				    $selected = "selected='selected'";
				   else
				    $selected = "";	
            ?>
                  <option value="<?php echo $row1['code'].'@'.$row1['description']; ?>" <?php echo $selected; ?>><?php echo $row1['code']; ?></option>
            <?php } ?>
          </select>
 </td>
		  <td width="10px"></td>
		  <td>
<textarea rows="8" cols="80" id="tandcdesc" type="html" name="tandcdesc" ><?php echo $tandc; ?></textarea>
</td>
</tr>
</table>




   <br />
  <center>
   <input type="submit" value="Update" id="save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onclick="document.location='dashboardsub.php?page=oc_salesorder';">
  </center>

						
			
			</form></div>
		</section>
		
		</center>


<br />










<script type="text/javascript">





function getdescr(a)
{
  var out = "";
  var temp = "";
  document.getElementById("tandcdesc").innerHTML = "";
  for (var i = 0; i < document.getElementById("tandccode").options.length; i++) 
   {
      if( document.getElementById("tandccode").options[i].selected)
      {
	    temp = document.getElementById("tandccode").options[i].value.split("@");
        out += temp[1] + '\n';
      }
   }

  document.getElementById("tandcdesc").value = out;
}







function getpo()
{
  var date1 = document.getElementById('mdate').value;
  var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2].substr(2,4);
     var mon = new Array();
     var yea = new Array();
     var poincr = new Array();
    var po = "";
  <?php 
    
   $query1 = "SELECT MAX(poincr) as poincr,m,y FROM oc_salesorder GROUP BY m,y ORDER BY date DESC";
   $result1 = mysql_query($query1,$conn);
   $k = 0; 
   while($row1 = mysql_fetch_assoc($result1))
   {
?>
     mon[<?php echo $k; ?>] = <?php echo $row1['m']; ?>;
     yea[<?php echo $k; ?>] = <?php echo $row1['y']; ?>;
     poincr[<?php echo $k; ?>] = <?php if($row1['poincr'] < 0) { echo 0; } else { echo $row1['poincr']; } ?>;

<?php $k++; } ?>

var m1= Number(m);
var y1= Number(y);

if(m1!="<?php echo $m;?>" || y1!="<?php echo $y;?>")
{
for(var l = 0; l <= <?php echo $k; ?>;l++)
{
 if((yea[l] == y) && (mon[l] == m))
  { 
   if(poincr[l] < 10)
     po = 'SO'+'-'+m+y+'-000'+parseInt(poincr[l]+1);
   else if(poincr[l] < 100 && poincr[l] >= 10)
     po = 'SO'+'-'+m+y+'-00'+parseInt(poincr[l]+1);
   else
     po = 'SO'+'-'+m+y+'-0'+parseInt(poincr[l]+1);
     document.getElementById('poincr').value = parseInt(poincr[l] + 1);
  break;
  }
 else
  {
   po = 'SO'+'-'+m+y+'-000'+parseInt(1);
   document.getElementById('poincr').value = 1;
  }
}
document.getElementById('po').value = po;
document.getElementById('m').value = m;
document.getElementById('y').value =y;




}

else
{
document.getElementById('po').value="<?php echo $po;?>";

}



}












var index =<?php echo $i;?>;
function makeForm(id) 
{


var id=id.substr(4,id.length);


for(k=0;k<=index;k++)
{

	if(k==0)
	{
	
	var type= document.getElementById("type"+k).value;
	var code= document.getElementById("code"+k).value;
	
	if(type=="" || code=="" )
	{
		return false;
	
	
	}

	
	}
else if(k<index)
{
	
	var type= document.getElementById("type"+k).value;
	var code= document.getElementById("code"+k).value;
	var qtys=document.getElementById("qtys"+k).value;

	if(type=="" || code=="" || Number(qtys)==0 )
	{
		return false;
	
	
	}
	

	 }
  }
if(id!=index)
return false;




  index = index + 1;
  
  

  var i,b;
  var t1  = document.getElementById('tab');
  var tr  = document.createElement('tr');


  
  
  
  
    var e1 = document.createElement('td');
  myspace= document.createTextNode('\u00a0');
  e1.appendChild(myspace);
  
  var e2 = document.createElement('td');
  myspace= document.createTextNode('\u00a0');
  e2.appendChild(myspace);
  
  var e3 = document.createElement('td');
  myspace= document.createTextNode('\u00a0');
  e3.appendChild(myspace);
  
  var e4 = document.createElement('td');
  myspace= document.createTextNode('\u00a0');
  e4.appendChild(myspace);
  
  var e5 = document.createElement('td');
  myspace= document.createTextNode('\u00a0');
  e5.appendChild(myspace);
  
  var e6 = document.createElement('td');
  myspace= document.createTextNode('\u00a0');
  e6.appendChild(myspace);
  
  var e7 = document.createElement('td');
  myspace= document.createTextNode('\u00a0');
  e7.appendChild(myspace);
  
  var e8 = document.createElement('td');
  myspace= document.createTextNode('\u00a0');
  e8.appendChild(myspace);
  
  var e9 = document.createElement('td');
  myspace= document.createTextNode('\u00a0');
  e9.appendChild(myspace);
  
  var e10 = document.createElement('td');
  myspace= document.createTextNode('\u00a0');
  e10.appendChild(myspace);
  
  var e11 = document.createElement('td');
  myspace= document.createTextNode('\u00a0');
  e11.appendChild(myspace);
  
  
  
  
    var td1 = document.createElement('td');
  myselect1 = document.createElement("select");
  myselect1.id = "type" + index;
  myselect1.name = "category[]";
    myselect1.style.width = "90px";
  myselect1.onchange = function() { fun(this.id,this.value); };
 var op1=new Option("-Select-","");
myselect1.options.add(op1);
    for(i=0;i<items.length;i++)
{

 var theOption=new Option(items[i].cat,items[i].cat);
		
		
myselect1.options.add(theOption);

} 
  td1.appendChild(myselect1);
  
  
  
  
    
  var td2 = document.createElement('td');
  myselect1 = document.createElement("select");
  myselect1.id = "code" + index;
  myselect1.name = "code[]";
  myselect1.style.width = "80px";
  myselect1.onchange = function() { description(this.id,this.value); };
  var op1=new Option("-Select-","");
myselect1.options.add(op1);
  td2.appendChild(myselect1);
  
  
  

  
  
  
  var td3 = document.createElement('td');
  myselect1 = document.createElement("input");
  myselect1.id = "desc" + index;
  myselect1.name = "description[]";
  myselect1.size=15;
   myselect1.setAttribute("readonly",true);

  td3.appendChild(myselect1);

  
    var td5 = document.createElement('td');
  var input = document.createElement("input");
  input.type = "text";
  input.id = "munit" + index;
  input.name = "units[]";
  input.style.background="none";
  input.style.border="0px";
  input.size = "8";
  input.setAttribute("readonly",true);
  td5.appendChild(input);
  
  
  
  
  
  var td6 = document.createElement('td');
  var input = document.createElement("input");
  input.type = "text";
  input.id = "qtys" + index;
  input.name = "quantity[]";
  input.value = "0";
 input.onblur=function(){checknum(this.value,this.id)};
  input.onfocus = function ()  {  makeForm(this.id); };
  input.size = "8";
  td6.appendChild(input);
  
  
  
  
   var td7 = document.createElement('td');
  var input = document.createElement("input");
  input.type = "text";
  input.id = "unit" + index;
  input.name = "rate[]";
  input.value = "0";
  input.style.textAlign = "right";
   input.onkeyup=function(){checknum(this.value,this.id)};
  
  input.size = "8";
  td7.appendChild(input);
  
  
  
  
  
   var td8 = document.createElement('td');
  myselect1 = document.createElement("select");
  myselect1.id = "tax" + index;
  myselect1.name = "tax[]";
  myselect1.style.width = "80px";
  var op1=new Option("-Select-","0@0@0@0");
  myselect1.options.add(op1);
 
 <?php            
           $query = "SELECT * FROM ims_taxcodes where  (taxflag = 'S') ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
  var theOption=new Option("<?php echo $row1['code']; ?>","<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['mode']."@".$row1['rule'];?>");
		
theOption.title="<?php echo $row1['description']; ?>";
myselect1.options.add(theOption);
  

	<?php } ?>	
  td8.appendChild(myselect1);
  
  var td9 = document.createElement('td');
  myselect1 = document.createElement("select");
  myselect1.id = "freight" + index;
  myselect1.name = "freight[]";
  myselect1.style.width = "100px";
  var op1=new Option("-Select-","");
   myselect1.options.add(op1);
   
     var op1=new Option("Include Paid By Customer","Include Paid By Customer");
   myselect1.options.add(op1);
     var op1=new Option("Exclude","Exclude");
   myselect1.options.add(op1);
     var op1=new Option("Include","Include");
   myselect1.options.add(op1);
  

  td9.appendChild(myselect1);

 

  var td10 = document.createElement('td');
  myselect1 = document.createElement("input");
  myselect1.id = "disc" + index;
  myselect1.name = "discount[]";
  myselect1.size="8";
  myselect1.value="0";

  td10.appendChild(myselect1); 

 
  
  

var td11 = document.createElement('td');  
mybox=document.createElement("input");
mybox.type="text";
mybox.name="rdate[]";
mybox.id = "rdate" + index;
var c = "datepicker" + index;
mybox.value="<?php echo date("d.m.o"); ?>";
mybox.size="10";
mybox.setAttribute("class",c);

td11.appendChild(mybox);



  tr.appendChild(td1);
  tr.appendChild(e1);
  tr.appendChild(td2);
  tr.appendChild(e2);
  tr.appendChild(td3);

  tr.appendChild(e3);
  tr.appendChild(td5);
  tr.appendChild(e4);
  tr.appendChild(td6);
  tr.appendChild(e5);
  tr.appendChild(td7);
  tr.appendChild(e6);
  tr.appendChild(td8);
  tr.appendChild(e7);
  tr.appendChild(td9);
  tr.appendChild(e9);
  tr.appendChild(td10);
   tr.appendChild(e10);
   tr.appendChild(td11);
 

  t1.appendChild(tr);
 



  $(function() {
	$( "." + c ).datepicker();
  });



}



function fun(b) {


var a=b.substr(4,b.length);


document.getElementById('code'+ a).options.length=1;

 myselect11=document.getElementById('code'+ a);

document.getElementById('desc'+ a).value="";
   
   document.getElementById('munit'+ a).value="";
   
   
   	var l=items.length;
var x=document.getElementById("type" + a).value;
	for(i=0;i<l;i++)
	{
		if(items[i].cat == x)
		{
			var ll=items[i].cd.split(",");
			
			for(j=0;j<ll.length;j++)
			{ 
				var expp=ll[j].split("@");
				var op1=new Option(expp[0],ll[j]);
				op1.title=expp[0];
				myselect11.options.add(op1);
			}
		 
		}
	}		

   
   



 
 
 
}
///End of Loading Codes














///Filling Description from code ///////
function description(b)
{

var id=b.substr(4,b.length);

 document.getElementById('unit' + id).value="";
 var rate= document.getElementById('unit' + id);
 document.getElementById('unit' + id).readOnly=false;

   var val=document.getElementById(b).value;
   if(val=="")
   {
   
  				 document.getElementById('code' + id).value="";
				document.getElementById('desc' + id).value="";
				document.getElementById('munit'+id).value="";
				return false;
   
   }
   
 

   for(var i = 0;i<=index;i++) 
   {
	for(var j = 0;j<=index;j++)
	{
		
		
		if( i != j)
		{
			if(document.getElementById('code' + i).value == document.getElementById('code' + j).value)
			{
				//document.getElementById('ing' + a).value = "";
				alert("Please select different combination");
				document.getElementById('code' + id).value="";
				document.getElementById('desc' + id).value="";
				document.getElementById('munit'+id).value="";
				return false;
			}
		}
	}
   }

  var val1=val.split("@");
	document.getElementById('desc' +id).value= val1[1];
	 document.getElementById('munit' +id).value=val1[2];


 
var date1=document.getElementById("mdate").value;
 var strdot1 = date1.split('.');
  var dd= strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2];
  var d1=y+"-"+m+"-"+dd;

   
   
   
   for(j=0;j<=stdcost.length;j++)
   {
   
   var cost=stdcost[j].split("@");
   if((document.getElementById('code' + id).value==cost[0]) && (d1<=cost[2]) && (d1>=cost[1]))
   
     {
		
		var rate=document.getElementById('unit' + id);
		document.getElementById('unit' + id).value=cost[3];
		 rate.setAttribute('readonly', 'readonly'); 
		}
   
   
   
   }
   


}
///End Of Description from code /////
function checknum(value,id)
{
var p=new RegExp("^[0-9\.]+$");
if(value != "")
{
if(!p.test(value))
{
alert("Enter Numbers Only");
document.getElementById(id).value="";

document.getElementById(id).focus();
}
}
}










function calculate(a)
{




 var warehouse = document.getElementById('vendor').value;
 if(warehouse == "")
 {
  alert("Please select the party");
  document.getElementById("vendor").focus();
  return false;
 }

 var warehouse = document.getElementById('warehouse').value;
 if(warehouse == "")
 {
  alert("Please select the warehouse");
  document.getElementById("warehouse").focus();
  return false;
 }

 
  var qua = Number(document.getElementById('qtys0').value);
 if(qua <=0)
 {
  alert("Please Enter the quantity");
  document.getElementById("qtys0").focus();
  return false;
 }
 var rat = Number(document.getElementById('unit0').value);
 if(rat <=0)
 {
  alert("Please Enter the rate");
  document.getElementById("unit0").focus();
  return false;
 }
  
 if(document.getElementById('code0').value=="")
 {
  alert("Please select code");
  document.getElementById("code0").focus();
  return false;
 }

 for(var i=0;i<index;i++)
{
if(document.getElementById('code'+i).value!="" && document.getElementById('desc'+i).value!=""  )
{
if(document.getElementById('qtys'+i).value=="")
{
alert("please Enter Quantity");
document.getElementById('qtys'+i).focus();
return false;

}

if(document.getElementById('unit'+i).value=="")
{
alert("please Enter Unit");
document.getElementById('unit'+i).focus();
return false;

}




}
}
 document.getElementById("save").disabled=true;
  return true;


}

</script>
<script type="text/javascript">
function script1() {
window.open('O2CHelp/help_addsalesorder.php','IMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=no');
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

