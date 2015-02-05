
<?php include "jquery.php"; include "config.php"; $i=0;

$i=0;


$q1=mysql_query("SET group_concat_max_len=10000000");
//contact details

 $query = "SELECT group_concat(distinct(name) order by name) as name FROM contactdetails where type like '%vendor%'  ";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
	 $names=explode(",",$row["name"]);
}
$name=json_encode($names);


//item cat codes
$query="select cat,group_concat(concat(code,'@',description,'@',sunits) ) as cd from ims_itemcodes group by cat";
$result=mysql_query($query,$conn);
$i=0;
while($r=mysql_fetch_array($result))
{
$items[$i]=array("cat"=>"$r[cat]","cd"=>"$r[cd]");
$i++;
} 
$item=json_encode($items);

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

 $q1 = "SELECT GROUP_CONCAT( DISTINCT (sector) ORDER BY sector ) as sector FROM tbl_sector WHERE type1 =  'warehouse' and sector in ($sectorlist)";
	 
	  $res1 = mysql_query($q1,$conn); 

$rows1 = mysql_fetch_assoc($res1);
     {
	 
 $sec1=explode(",",$rows1["sector"]);	
			
			
	 }
	 
	 $sector=json_encode($sec1);



 ?>
 
<script type="text/javascript">
var items=<?php if(empty($item)){echo 0;}else{ echo $item; } ?>;
var names=<?php if(empty($name)){echo 0;}else{ echo $name; } ?>;

var sectors1=<?php if(empty($sector)){echo 0;}else{ echo $sector; } ?>;
</script>

<?php // *****************************************************************to get values
$q="select * from pp_purchaseorder where po='$_GET[po]'";
$r=mysql_query($q,$conn);
$a=mysql_fetch_array($r);
$vendor=$a['vendor'];
$vcode=$a['vendorcode'];
$broker=$a['broker'];
$d_date=$a['date'];
$credittermcode=$a['credittermcode'];
$poincr=$a['poincr'];
 $m=$a[m];
$y=$a[y];
$po=$a[po];
$vendorid=$a[vendorid];
$vendor=$a[vendor];
$credittermdescription=$a[credittermdescription];
$credittermvalue=$a[credittermvalue];
$brokerid=$a[brokerid];
$broker=$a[broker];
$date=$a['date'];
$tandc = $a['tandc'];
$aflag = $a['flag'];	//Authorization Flag
do{
$category=$a[category];
$code=$a[code];
$description=$a[description];


$quantity=$a[quantity];
$unit=$a[unit];
$rateperunit=$a[rateperunit];
$deliverydate=$a[deliverydate];
$deliverylocation=$a['deliverylocation'];

$receiver=$a[receiver];
$initiatorid=$a[initatoid];
$initiator=$a[initiator];
$initiatorsector=$a[initiatorsector];
$taxcode=$a[taxcode];
$taxvalue=$a[taxvalue];
$taxformula=$a[taxformula];
$taxie=$a[taxie];
$taxamount=$a[taxamount];
$totalwithtax=$a[totalwithtax];
$freightcode=$a[freightcode];
$freightvalue=$a[freightvalue];
$freightformula=$a[freightformula];
$freightie=$a[freightie];
$freightamount=$a[freightamount];
$totalwithfreight=$a[totalwithfreight];
$brokeragecode=$a[brokeragecode];
$brokeragevalue=$a[brokeragevalue];
$brokerageformula=$a[brokerageformula];
$brokerageie=$a[brokerageie];
$brokerageamount=$a[brokerageamount];
$totalwithbrokerage=$a[totalwithbrokerage];
$discountcode=$a[discountcode];
$discountvalue=$a[discountvalue];
$discountformula=$a[discountformula];
$discountie=$a[discountie];
$discountamount=$a[discountamount];
$totalwithdiscount=$a[totalwithdiscount];
$basic=$a[basic];
$finalcost=$a[finalcost];
$tandccode=$a[tandccode];
$flag=$a[flag];
$geflag=$a[geflag];
$empname=$a[empname];

$conversion = 1;

}while(mysql_num_rows($r)>1&&$a=mysql_fetch_array($r));

?>
<link href="editor/sample.css" rel="stylesheet" type="text/css"/>
<center>

<section class="grid_8">
  <div  class="block-border">
     <form class="block-content form" id="complex_form" name="form1" method="post" action="pp_savepurchaseorder.php" onSubmit="return checkform(this);">
	
	  <h1>Purchase Order</h1>
		
		<br />

<b>Purchase Order</b>

<br />
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)<br /><br />
<br />

            <table align="center">
				
              <tr>

             <!-- hidden variables start -->

                <input type="hidden" name="poincr" id="poincr" value="<?php echo $poincr; ?>"/>
                <input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
                <input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>
				<input type="hidden" name="oldpo" id="oldpo" value="<?php echo $po;?>" />
                <input type="hidden" name="taxamount[]" id="taxamount" />
                <input type="hidden" name="freightamount[]" id="freightamount" />
                <input type="hidden" name="brokerageamount[]" id="brokerageamount" />
                <input type="hidden" name="aflag" value="<?php echo $flag; ?>" />
				<input type="hidden" name="saed" value="1" />
<input type="hidden" name="cuser" value="<?php echo $empname;?>" />
             <!-- hidden variables end -->
               
                <td><strong>P.O</strong></td>
                <td>&nbsp;<input type="text" size="14" id="po" name="po" value="<?php echo $_GET[po]; ?>" readonly style="border:0px;background:none" /></td> 
                <td width="20px"></td>

                <td><strong>Vendor</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;
                <select style="width: 160px" name="vendor" id="vendor">
                                   <option value="">-Select-</option>
							     <?php 

	for($i=0;$i<count($names);$i++)
				{ 
?>
   <option value="<?php echo $names[$i];?>" <?php if($vendor == $names[$i]) {?> selected="selected" <?php } ?> title="<?php echo $names[$i];?>"><?php echo $names[$i]; ?></option>
<?php } ?>
               </select>                </td>
                <td width="20px"></td>
                <input type="hidden" name="vendorid" value="0" />
               
                <td><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
                <td>&nbsp;<input type="text" size="15" id="mdate"  class="datepicker" name="date" readonly="TRUE" value="<?php echo date("d.m.Y",strtotime($d_date)); ?>"   onchange="getpo();"></td>
                <td width="20px"></td>
      </tr>
            </table>
			
			
<br />
<br />


<table id="tab1" align="center">
<tr>
 <td><strong>Category</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
 <td width="10px"></td>
 <td><strong>Code</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
 <td width="10px"></td>
 <td><strong>Description</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
 <td width="10px"></td>
 <td><strong>Units</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
 <td width="10px"></td>
 <td><strong>Quantity</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
 <td width="10px"></td>

 <td><strong>Price</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
 <td width="10px"></td>
 
 <td><strong>D. Location</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
 <td width="10px"></td>
 
 <td><strong>Tax</strong></td>
 <td width="10px"></td>
 <td><strong>Freight</strong></td>
 <td width="10px"></td>
 <td><strong>Discount</strong></td>
 <td width="10px"></td>
  <td><strong>Delivery&nbsp;Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
  <td width="10px"></td>
</tr>


<?php
$index = 0;
$q = "SELECT * FROM pp_purchaseorder WHERE po = '$po' ORDER BY id";
$re = mysql_query($q,$conn) or die(mysql_error());
while($rr = mysql_fetch_assoc($re))
{ $index++;
?>
<tr height="10px"></tr>
<tr>
  <td>
  <select name="category[]" id="type@<?php echo $index; ?>" onchange="fun(this.id,this.value);" style="width:90px;">
  <option value="">--Select--</option>
    <?php
  for($i=0;$i<count($items);$i++)
	{
  ?>
  <option value="<?php echo $items[$i]["cat"]; ?>" title="<?php echo $items[$i]["cat"]; ?>" <?php if($items[$i]["cat"] == $rr['category']) { ?> selected="selected" <?php } ?>><?php echo $items[$i]["cat"]; ?></option>
 <?php } ?>   
         </select> </td>
 <td width="10px"></td>
       <td style="text-align:left;">
         <select name="code[]" id="code@<?php echo $index; ?>" onchange="seldescription(this.id,this.value);" style="width:80px;">
		 <option value="">--Select--</option>
		  <?php 
  for($i=0;$i<count($items);$i++)
	{ if($items[$i]["cat"] == $rr['category']) {	
	$cd1=explode(",",$items[$i]["cd"]);
	for($k=0;$k<count($cd1);$k++)
	{
		$cd2=explode("@",$cd1[$k]);
	?>
           <option value="<?php echo $cd1[$k]; ?>" title="<?php echo $cd2[1]; ?>" <?php if($cd2[0] == $rr['code']) { ?> selected="selected" <?php } ?>><?php echo $cd2[0]; ?></option>
	<?php } } } ?>	  
         </select>       </td>

 <td width="10px"></td>
 <td>
        <select name="desc[]" id="desc@<?php echo $index; ?>" onchange="selcode(this.id,this.value);" style="width:120px;">
		<option value="">--Select--</option>
		
			  <?php 
  for($i=0;$i<count($items);$i++)
	{ if($items[$i]["cat"] == $rr['category']) {	
	$cd1=explode(",",$items[$i]["cd"]);
	for($k=0;$k<count($cd1);$k++)
	{
		$cd2=explode("@",$cd1[$k]);
	?>
           <option value="<?php echo $cd1[$k]; ?>" title="<?php echo $cd2[1]; ?>" <?php if($cd2[0] == $rr['code']) { ?> selected="selected" <?php } ?>><?php echo $cd2[1]; ?></option>
	<?php } } } ?>	
         </select> </td>		 
		 
 <td width="10px"></td>
 
 <td><input type="text" name="units[]" id="units@<?php echo $index; ?>"  size="5" value="<?php echo $rr['unit']; ?>" readonly style="background:none; border:0px;" /></td>
 <td width="10px"></td>
 <td><input type="text" name="qty[]" id="qty@<?php echo $index; ?>"  size="5" style="text-align: right" value="<?php echo $rr['quantity']; ?>" onkeypress="return num(event.keyCode)" /></td>
 <td width="10px"></td>
 
 <td><input type="text" name="rate[]" id="rate@<?php echo $index; ?>" size="5" style="text-align: right" value="<?php echo $rr['rateperunit']; ?>" onBlur="makeForm(this.id)" onkeypress="return num(event.keyCode)"/></td>
 <td width="10px"></td>
         <td>
<select name="doffice[]" id="doffice@<?php echo $index; ?>" style="width:120px;">
<option value="">-Select-</option>
 <?php
 for($m1=0;$m1<count($sec1);$m1++) 
{
	
?>
<option value="<?php echo $sec1[$m1]; ?>" title="<?php echo $sec1[$m1]; ?>" <?php if($sec1[$m1] == $rr['deliverylocation']) { ?> selected="selected" <?php } ?>  ><?php echo $sec1[$m1]; ?></option>
<?php } ?>
</select>          </td>
 
 <td width="10px"></td>
<td>
           <select name="tax[]" id="tax@<?php echo $index; ?>"  style="width:80px;">
             <option value="0@0@0@0">-Select-</option>
             <?php
                 
                $query = "SELECT * FROM ims_taxcodes where  (taxflag = 'P' ) ORDER BY code DESC ";
                $result = mysql_query($query,$conn); 
                while($row1 = mysql_fetch_assoc($result)) 
                {
             ?>
             <option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['mode']."@".$row1['rule']; ?>" <?php if($row1['code'] == $rr['taxcode']) { ?> selected="selected" <?php } ?>><?php echo $row1['code']; ?></option>
             <?php } ?>
           </select> 
		    </td> 
 <td width="10px"></td>
         <td>
            <select name="freight[]" id="freight@<?php echo $index; ?>"  style="width:100px;">
			
			
			<option value="">--Select--</option>
			<option value="Exclude Paid By Supplier" <?php if($rr['freightie']=="Exclude Paid By Supplier") { ?> selected="selected" <?php  } ?>>Exclude Paid By Supplier</option>
			<option value="Exclude" <?php if($rr['freightie']=="Exclude") { ?> selected="selected" <?php  } ?>>Exclude</option>
			<option value="Include" <?php if($rr['freightie']=="Include") { ?> selected="selected" <?php  } ?>>Include</option>
			
			
           </select>          </td>
 
 <td width="10px"></td>

         <td>
           <input type="text" name="disc[]"	 id="disc@<?php echo $index; ?>" size="8" value="<?php echo $rr['discountvalue'];?>" />
		   	  </td>
		  	 <td width="10px"></td>
<td><input type="text" name="ddate[]" id="ddate<?php echo $index; ?>" class="datepicker" value="<?php echo date("d.m.Y"); ?>" size="10"  /> </td>
		  
		<input type="hidden" name="taxamount[]" id="taxamount@<?php echo $index; ?>" value = "<?php echo $rr['totalwithtax']; ?>"/>
		<input type="hidden" name="freightamount[]" id="freightamount@<?php echo $index; ?>" value="<?php echo $rr['totalwithfreight']; ?>"/>
		
		<input type="hidden" name="discountamount[]" id="discountamount@<?php echo $index; ?>" value="<?php echo $rr['totalwithdiscount']; ?>" />
		  
         
		 
</tr>
<?php } ?>

 </table>
<br /><br/>
<table align="center">
 <tr>
	<td style="vertical-align:middle">
		 <strong>Terms &amp; Conditions</strong><br/><br/>
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
<br />
<center>
<input name="submit" type="submit" id="save" value="Update" />
&nbsp;
<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_purchaseorder';">

</center>
<br />
<br />


</form>
</div>
</section>
</center>



		

<br />


<script type="text/javascript">

function getdescr(a)
{
  var out = "";
  document.getElementById("tandcdesc").innerHTML = "";
  for (var i = 0; i < document.getElementById("tandccode").options.length; i++) 
   {
      if( document.getElementById("tandccode").options[i].selected)
      {
        var test = document.getElementById("tandccode").options[i].value.split('@');
        out += test[1]+',\n';
       
      }
   }

  document.getElementById("tandcdesc").value = out;
}

index = <?php echo $index; ?>;


function num(b)
{
if((b<48 || b>57) &&(b!=46))
{
event.keyCode=false;
return false;
}

}

function makeForm(id)
{
id=id.substr(5,id.length);

for(k=1;k<=index;k++)
{
	if(k==1)
	{
	
	
	var type= document.getElementById("type@"+k).value;
	var code= document.getElementById("code@"+k).value;
	var qty= document.getElementById("qty@"+k).value;
	var rate= document.getElementById("rate@"+k).value;


	if(type=="" || code=="" || qty=="" || rate=="")
	{

		return false;
	
	
	}


	
	}
else if(k<index)
{
	
	var type= document.getElementById("type@"+k).value;
	var code= document.getElementById("code@"+k).value;
	var qty= document.getElementById("qty@"+k).value;
	var rate= document.getElementById("rate@"+k).value;
	
	if(type=="" || code=="" || qty=="" || rate=="")
	{
		return false;
	
	
	}
	
	if(document.getElementById('doffice@' + k).value == "")
	 {
	  
	  return false;
	 }
	
	

	 }
	 }

if(id!=index)
return false;
  index = index + 1;
  var table = document.getElementById('tab1');
  var tr0 = document.createElement('tr');
  tr0.height="10px";
  table.appendChild(tr0);
  var tr = document.createElement('tr');
  
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
  myselect1.id = "type@" + index;
  myselect1.name = "category[]";
    myselect1.style.width = "90px";
  myselect1.onchange = function() { fun(this.id,this.value); };
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.value = "";
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
    for(i=0;i<items.length;i++)
{

 var theOption=new Option(items[i].cat,items[i].cat);
		
		
myselect1.options.add(theOption);

} 
  td1.appendChild(myselect1);
  
  var td2 = document.createElement('td');
  myselect1 = document.createElement("select");
  myselect1.id = "code@" + index;
  myselect1.name = "code[]";
  myselect1.style.width = "80px";
  myselect1.onchange = function() { seldescription(this.id,this.value); };
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.value = "";
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  td2.appendChild(myselect1);
  
  var td3 = document.createElement('td');
  myselect1 = document.createElement("select");
  myselect1.id = "desc@" + index;
  myselect1.name = "desc[]";
  myselect1.style.width = "120px";
  myselect1.onchange = function() { selcode(this.id,this.value); };
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.value = "";
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  td3.appendChild(myselect1);

 var td5 = document.createElement('td');
  var input = document.createElement("input");
  input.type = "text";
  input.id = "units@" + index;
  input.name = "units[]";
  input.size = "5";
  input.style.background="none";
  input.style.border="0px";
  input.setAttribute("readonly",true);
  td5.appendChild(input);
  

  var td6 = document.createElement('td');
  var input = document.createElement("input");
  input.type = "text";
  input.id = "qty@" + index;
  input.name = "qty[]";
  input.value = "0";
  input.style.textAlign = "right";
  input.onkeypress=function() { return num(event.keyCode); };
  input.size = "5";
  td6.appendChild(input);
  
  
  var td7 = document.createElement('td');
  var input = document.createElement("input");
  input.type = "text";
  input.id = "rate@" + index;
  input.name = "rate[]";
  input.value = "0";
  input.style.textAlign = "right";
  input.onblur = function() { makeForm(this.id); }
  input.onkeypress=function() { return num(event.keyCode); };
  input.size = "5";
  td7.appendChild(input);
  
  var td8 = document.createElement('td');
  myselect1 = document.createElement("select");
  myselect1.id = "doffice@" + index;
  myselect1.name = "doffice[]";
  myselect1.style.width = "120px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.value = "";
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  
            for(j=0;j<sectors1.length;j++)
		   {
		 
		   
		   	var theOption=new Option(sectors1[j],sectors1[j]);
			myselect1.options.add(theOption);
		
}

  td8.appendChild(myselect1);

  var td9 = document.createElement('td');
  myselect1 = document.createElement("select");
  myselect1.id = "tax@" + index;
  myselect1.name = "tax[]";
  myselect1.style.width = "80px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.value = "0@0@0@0";
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
 <?php            
           $query = "SELECT * FROM ims_taxcodes where  (taxflag = 'P' ) ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['code']; ?>");
		theOption.appendChild(theText);
           theOption.title = "<?php echo $row1['description']; ?>";
	theOption.value = "<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['mode']."@".$row1['rule'];?>";

		myselect1.appendChild(theOption);
	<?php } ?>	
  td9.appendChild(myselect1);
  
  var td10 = document.createElement('td');
  myselect1 = document.createElement("select");
  myselect1.id = "freight@" + index;
  myselect1.name = "freight[]";
  myselect1.style.width = "100px";
  
	  var op1=new Option("-Select-","");
	  myselect1.options.add(op1);
    var op1=new Option("Exclude Paid By Supplier","Exclude Paid By Supplier");
   myselect1.options.add(op1);
     var op1=new Option("Exclude","Exclude");
   myselect1.options.add(op1);
     var op1=new Option("Include","Include");
   myselect1.options.add(op1);
  
<?php /*?>  
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.value = "0@0@0@0";
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
 <?php            
           $query = "SELECT * FROM ims_taxcodes where type = 'Charges' and ctype = 'Freight' and (taxflag = 'P' or taxflag='A') ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['code']; ?>");
		theOption.appendChild(theText);
            theOption.title = "<?php echo $row1['description']; ?>";
	theOption.value = "<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['mode']."@".$row1['rule'];?>";
		myselect1.appendChild(theOption);
		<?php } ?><?php */?>
		
  td10.appendChild(myselect1);

 
 var td12 = document.createElement('td');
  myselect1 = document.createElement("input");
  myselect1.id = "disc@"+index;
  myselect1.name = "disc[]";
  myselect1.size="8";
  myselect1.value="0";

  td12.appendChild(myselect1); 


  var td13 = document.createElement('td');
  input = document.createElement('input');
  input.type = "hidden";
  input.id = "taxamount@"+index;
  input.name="taxamount[]";
  input.value = "0";
  td13.appendChild(input);
  
  var td14 = document.createElement('td');
  input = document.createElement('input');
  input.type = "hidden";
  input.id = "freightamount@"+index;
  input.name="freightamount[]";
  input.value = "0";
  td14.appendChild(input);
  

  var td16 = document.createElement('td');
  input = document.createElement('input');
  input.type = "hidden";
  input.id = "discountamount@"+index;
  input.name="discountamount[]";
  input.value = "0";
  td16.appendChild(input);
  
  
  var ca5 = document.createElement('td');  
mybox=document.createElement("input");
mybox.type="text";
mybox.name="ddate[]";
mybox.id = "ddate" + index;
var c = "datepicker" + index;
mybox.value="<?php echo date("d.m.o"); ?>";
mybox.size="10";
mybox.setAttribute("class",c);

ca5.appendChild(mybox);
  
  tr.appendChild(td1);
  tr.appendChild(e1);
  tr.appendChild(td2);
  tr.appendChild(e2);
  tr.appendChild(td3);
  tr.appendChild(e3);

  tr.appendChild(td5);
  tr.appendChild(e5);
  tr.appendChild(td6);
  tr.appendChild(e6);
  tr.appendChild(td7);
  tr.appendChild(e7);
  tr.appendChild(td8);
  tr.appendChild(e8);
  tr.appendChild(td9);
  tr.appendChild(e9);
  tr.appendChild(td10);
  tr.appendChild(e11);
  tr.appendChild(td12);
  tr.appendChild(td13);
  tr.appendChild(ca5);
  tr.appendChild(td14);
 
  tr.appendChild(td16);
  
  table.appendChild(tr);
 
}

function removeAllOptions(selectbox)
{
	for(var i=selectbox.options.length-1;i>0;i--)
		selectbox.remove(i);
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
	var c=0;


  <?php 
    
   $query1 = "SELECT MAX(poincr) as poincr,m,y FROM pp_purchaseorder GROUP BY m,y ORDER BY date DESC";
   $result1 = mysql_query($query1,$conn);
   $k = 0; 
   while($row1 = mysql_fetch_assoc($result1))
   {
?>

if(m==<?php echo $m;?> && y== <?php echo $y; ?>)
c=1;

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
     po = 'PO'+'-'+m+y+'-000'+parseInt(poincr[l]+1);
   else if(poincr[l] < 100 && poincr[l] >= 10)
     po = 'PO'+'-'+m+y+'-00'+parseInt(poincr[l]+1);
   else
     po = 'PO'+'-'+m+y+'-0'+parseInt(poincr[l]+1);
     document.getElementById('poincr').value = parseInt(poincr[l] + 1);
  break;
  }
 else
  {
   po = 'PO'+'-'+m+y+'-000'+parseInt(1);
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

function fun(b,f) 
{
 var temp = b.split('@');
 var tindex = temp[1];

removeAllOptions(document.getElementById('code@' + tindex));
	 
removeAllOptions(document.getElementById('desc@' + tindex));	

var x= document.getElementById('type@'+ tindex).value; 

 document.getElementById('qty@'+tindex).value = "0";
 document.getElementById('units@'+tindex).value = "";
	var l=items.length;		  
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

var op2=new Option(expp[1],ll[j]);
op2.title=expp[1];
document.getElementById('code@' + tindex).options.add(op1);
document.getElementById('desc@' + tindex).options.add(op2);
}
}
}
 
 
			  

}



function seldescription(a,b)
{
 var temp = a.split('@');
 var tindex = temp[1];
 var temp = b.split('@');
 var code = temp[0];
 var units = temp[2];
 
 if(b=="")
 {
 document.getElementById('desc@' + tindex).value="";
 document.getElementById("units@" + tindex).value="";
 document.getElementById('code@' + tindex).value="";
return false;
 
 }
 

    for(j=1;j<=index;j++)
  {
  
 

 
if(document.getElementById('code@' + tindex).value==document.getElementById('code@' + j).value && (tindex!=j))
{

alert("Please select dfferent combinations");
 document.getElementById('code@' + tindex).value="";
  document.getElementById('desc@' + tindex).value="";
   document.getElementById("units@" + tindex).value="";
 return false;

  }
  
  
  }
 
 

    document.getElementById("desc@"+ tindex).selectedIndex = document.getElementById("code@" +tindex).selectedIndex;
	document.getElementById("units@" +tindex).value=units;

}

function selcode(a,b)
{
 var temp = a.split('@');
 var tindex = temp[1];
 var temp = b.split('@');
 var code = temp[0];
 var units = temp[2];
 
 
  if(b=="")
 {
 document.getElementById('desc@' + tindex).value="";
 document.getElementById("units@" + tindex).value="";
 document.getElementById('code@' + tindex).value="";
return false;
 }
 
 
 
    for(j=1;j<=index;j++)
  {
  
 
  var a=document.getElementById('desc@' + tindex).value;

  var b=document.getElementById('desc@' + j).value;
 
if(document.getElementById('desc@' + tindex).value==document.getElementById('desc@' + j).value && (tindex!=j))
{
alert("Please select dfferent combinations");
document.getElementById('desc@' + tindex).value="";
document.getElementById('code@' + tindex).value="";
document.getElementById('units@' + tindex).value="";
return false;

  }
  
  
  }
 
 

	document.getElementById('units@' + tindex).value=units;

}

function checkform()
{ 




  if(document.getElementById("vendor").value == "")
  
	 {
	  alert("Please select Vendor");
	  document.getElementById('vendor').focus();
	  return false;
	 }


 var date=document.getElementById("mdate").value;
  for(var k = 1;k<=index;k++)
  
  
  
  {	
	
	 <!-- Tax Start -->
var withtax=0;
       var a1 = document.getElementById("tax@" + k).value;
       //alert(a1);
       a1 = a1.split('@');
       <?php
             
           $query = "SELECT * FROM ims_taxcodes where type='Tax' and (taxflag = 'P' or taxflag='A') ORDER BY code DESC";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a1[1]);
       <?php } ?>
       var mode = a1[2];
	   var taxval=a1[1];
	  
	   var rule=a1[3];
	   
       var A = parseFloat(document.getElementById("qty@" + k).value * document.getElementById("rate@" + k).value);
	   
	   if(mode=="Percent" &&rule=="Exclude" )
	   {
	   
	    withtax=Number(A)+Number((A*taxval)/100);
	   
	   }
	   else  if(rule=="Exclude"&&mode=="Flat" )
	   {
	 
	 
	   withtax =Number(A)+Number(taxval);
	   
	   }
	   
	   else
	  if(rule=="Include")
	  {
	   withtax = Number(A);
	  
	  }
	
       document.getElementById("taxamount@" + k).value = withtax;
		
	
		
		
       document.getElementById("freightamount@" + k).value = 0;

    
	
	
	
     <!-- Discount Start -->
 var withdiscount=0;
       var a4 =Number(document.getElementById("disc@" + k).value);
       
  
	  
       var A = parseFloat(document.getElementById("qty@" + k).value * document.getElementById("rate@" + k).value);
	   
	 
	  withdiscount =Number(A)-Number(a4);
	   
	 
	   
     document.getElementById("discountamount@" + k).value = withdiscount;
		
		

	if(k==1)
	{
	
	
	var type= document.getElementById("type@"+k).value;
	var code= document.getElementById("code@"+k).value;
	var qty= document.getElementById("qty@"+k).value;
	var rate= document.getElementById("rate@"+k).value;

 

	if(type=="" || code=="" || qty=="" || rate=="")
	{

		return false;
	
	
	}

	if(document.getElementById('doffice@' + k).value == "")
	 {
	  alert("Please select Delivery Location");
	  document.getElementById('doffice@' + k).focus();
	  return false;
	 }
	
	}
else if(k<index)
{
	
	var type= document.getElementById("type@"+k).value;
	var code= document.getElementById("code@"+k).value;
	var qty= document.getElementById("qty@"+k).value;
	var rate= document.getElementById("rate@"+k).value;

	if(type=="" || code=="" || qty=="" || rate=="")
	{
		return false;
	
	
	}
	
	if(document.getElementById('doffice@' + k).value == "")
	 {
	  alert("Please select Delivery Location");
	  document.getElementById('doffice@' + k).focus();
	  return false;
	 }
	
	

	 
	 }
  }
  
  
 
document.getElementById('save').disabled=true;
 return true;
}
</script>
<div class="clear"></div>
<br />

<script type="text/javascript">
function script1() {
//window.open('BroilerHelp/help_t_finalization.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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
</html>
