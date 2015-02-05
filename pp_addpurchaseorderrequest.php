<?php include "jquery.php"; include "config.php"; ?>
<?php 
$date1 = date("d.m.Y"); $strdot1 = explode('.',$date1); $ignore = $strdot1[0]; $m = $strdot1[1];$y = substr($strdot1[2],2,4);
$query1 = "SELECT MAX(poincr) as poincr FROM pp_purchaseorder  where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $piincr = 0; while($row1 = mysql_fetch_assoc($result1)) { $poincr = $row1['poincr']; }
$poincr = $poincr + 1;
if ($poincr < 10) { $po = 'PO-'.$m.$y.'-000'.$poincr; }
else if($poincr < 100 && $poincr >= 10) { $po = 'PO-'.$m.$y.'-00'.$poincr; }
else { $po = 'PO-'.$m.$y.'-0'.$poincr; }  





//contact details

 $query = "SELECT group_concat(distinct(name) order by name) as name FROM contactdetails where type like '%vendor%'  ";
$result = mysql_query($query,$conn);
while($row = mysql_fetch_assoc($result))
{
	 $names=explode(",",$row["name"]);
}
$name=json_encode($names);



//for getting category
$q1="SELECT distinct cat FROM `pp_purchaseindent` where cat!='' and flag!=1  order by cat";
$q1=mysql_query($q1) or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
$cata[]=array("cat"=>$r1['cat']);
}
$catj=json_encode($cata);

$q1="SELECT distinct(icode),name,units,cat FROM `pp_purchaseindent` where cat!='' and flag!=1 order by cat,icode";
$q1=mysql_query($q1) or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
$cda[]=array("cat"=>$r1['cat'],"icode"=>$r1['icode'],"name"=>$r1['name'],"units"=>$r1['units']);
}
$cdj=json_encode($cda);

$q1="SELECT sector FROM tbl_sector ORDER BY sector ASC";
$q1=mysql_query($q1) or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
$sectora[]=array("sector"=>$r1['sector']);
}
$sectorj=json_encode($sectora);

$q1="SELECT pi,icode,quantity,doffice FROM pp_purchaseindent where  approve=1 and flag!=1 ORDER BY date";
$q1=mysql_query($q1) or die(mysql_error());
while($r1=mysql_fetch_assoc($q1))
{
$alla[]=array("pi"=>$r1['pi'],"icode"=>$r1['icode'],"quantity"=>$r1['quantity'],"doffice"=>$r1['doffice']);
}
$allj=json_encode($alla);

?>
<script type="text/javascript">
var catj=<?php echo $catj;?>;
var cdj=<?php echo $cdj;?>;
var sectorj=<?php echo $sectorj;?>;
var allj=<?php echo $allj;?>;

</script>
  <center>
<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="min-height:600px" id="complex_form" name="form1" method="post" onsubmit="return checkform(this)" action="pp_savepurchaseorderrequest.php" >
	  <h1 id="title1">Purchase Order</h1>
		

<br />
<b>Purchase Order with Request</b>
<br />

(Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
         
                <input type="hidden" name="poincr" id="poincr" value="<?php echo $poincr; ?>"/>
                <input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
                <input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>
				
				
				<br />
<br />
<br />

				<br />

				
		  <table border="0" align="center"> 
			<tr>
			<td><b><input type="radio" name="complex-switch-on" id="withpr"  onclick="change('withpr');"  checked="checked"/>With&nbsp;Purchase&nbsp;Request&nbsp;</b></td>
<td><b><input type="radio" name="complex-switch-on" id="withpr1"  onclick="change('withpr1');" />Without&nbsp;Purchase&nbsp;Request&nbsp;</b></td>			
			
			</tr>
			
		</table>
		
		<br />
<br />


	  
<table align="center">
<tr>
<td><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
<td width="5px"></td>
<td><input type="text" name="date" id="date" class="datepicker" value="<?php echo date("d.m.Y"); ?>" size="10" readonly="true"  onchange="getpo();" /> </td>
<td width="10px"></td>
<td><strong>PO #</strong></td>
<td width="5px"></td>
<td><input type="text" size="14" id="po" name="po" value="<?php echo $po; ?>" readonly style="border:0px;background:none" /> </td>

<td width="10px"></td>
<td><strong>Vendor</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
<td width="5px"></td>
<td><select style="width: 180px" name="vendor" id="vendor" >
   <option value="">-Select-</option>
	  
<?php 
				for($i=0;$i<count($names);$i++)
				{ 
				?>
				
                <option value="<?php echo $names[$i];?>" title="<?php echo $names[$i];?>"><?php echo $names[$i]; ?></option>
                <?php } ?>
                </select></td>
				
<td width="10px"></td>
				

 
</tr>
</table>
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
 <td><strong>PR #</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
 
 
 <td width="10px"></td>
 <td><strong>Quantity</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
 <td width="10px"></td>
 <td><strong>Price</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
 <td width="10px"></td>
 <!--<td><strong>D. Date</strong></td>
 <td width="10px"></td>-->
 <td><strong>D. Location</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></td>
 <td width="10px"></td>
 <!--<td><strong>Receiver</strong></td>
 <td width="10px"></td>-->
 <td><strong>Tax</strong></td>
 <td width="10px"></td>
 <td><strong>Freight</strong></td>
 <td width="10px"></td>

 <td><strong>Discount</strong></td>
</tr>
<tr height="10px"></tr>
<tr>
  <td>
  <select name="category[]" id="type@1" onchange="fun(this.id,this.value);" style="width:90px;">
           <option value="">-Select-</option>
           <?php
               
              $query = "SELECT distinct(cat) FROM pp_purchaseindent WHERE flag = 0 AND approve = 1 ORDER BY cat ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['cat']; ?>"><?php echo $row1['cat']; ?></option>
           <?php } ?>         </select> </td>
 <td width="10px"></td>
       <td style="text-align:left;">
         <select name="code[]" id="code@1" onchange="seldescription(this.id,this.value);" style="width:80px;">
           <option value="">-Select-</option>
         </select>       </td>

 <td width="10px"></td>
 <td>
        <select name="desc[]" id="desc@1" onchange="selcode(this.id,this.value);" style="width:120px;">
           <option value="">-Select-</option>
         </select> </td>	
		  <td width="10px"></td>
 
 <td><input type="text" name="units[]" id="units@1"  size="5" readonly style="background:none; border:0px;" /></td>
		 	 
 <td width="10px"></td>
 <td>
        <select name="pr[]" id="pr@1" onchange="loadqty(this.id,this.value);" style="width:95px;">
           <option value="">-Select-</option>
         </select> </td>		 

 <td width="10px"></td>
 <td><input type="text" name="qty[]" id="qty@1"  size="5" style="text-align: right" value="0" onkeypress="return num(event.keyCode)" /></td>
 <td width="10px"></td>
 <td><input type="text" name="rate[]" id="rate@1" size="5" style="text-align: right" onblur="makeForm()" onkeypress="return num(event.keyCode)"/></td>

 <td width="10px"></td>
         <td>
<select name="doffice[]" id="doffice@1" style="width:120px;">
<option value="">-Select-</option>
</select>

      </td>
 
 <td  width="10px"></td>
<td>
           <select name="tax[]" id="tax@1"  style="width:80px;">
             <option value="0@0@0@0">-Select-</option>
             <?php
                 
                $query = "SELECT * FROM ims_taxcodes where (taxflag = 'P'  ) ORDER BY code DESC ";
                $result = mysql_query($query,$conn); 
                while($row1 = mysql_fetch_assoc($result)) 
                {
             ?>
             <option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['mode']."@".$row1['rule']; ?>"><?php echo $row1['code']; ?></option>
             <?php } ?>
           </select>         </td> 
 <td width="10px"></td>
         <td>
            <select name="freight[]" id="freight@1"  style="width:100px;">
			
			
			<option value="">--Select--</option>
			<option value="Exclude Paid By Supplier">Exclude Paid By Supplier</option>
			<option value="Exclude">Exclude</option>
			<option value="Include">Include</option>
			
			
<?php /*?>              <option value="0@0@0@0">-Select-</option>
              <?php
                  
                $query = "SELECT * FROM ims_taxcodes where type='Charges' and ctype='Freight' and (taxflag = 'P' or taxflag='A') ORDER BY code DESC ";
                 $result = mysql_query($query,$conn); 
                 while($row1 = mysql_fetch_assoc($result))
                 {
              ?>
              <option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['mode']."@".$row1['rule']; ?>"><?php echo $row1['code']; ?></option>
              <?php } ?> <?php */?>   
           </select>       </td>
 
 <td width="10px"></td>

         <td>
           <input type="text" name="disc[]"	 id="disc@1" size="8" value="0" />
		    </td>
		  
                <input type="hidden" name="taxamount[]" id="taxamount@1" value = "0"/>
                <input type="hidden" name="freightamount[]" id="freightamount@1" value="0"/>
               
                <input type="hidden" name="discountamount[]" id="discountamount@1" value="0" />        
</tr>
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
            ?>
                  <option value="<?php echo $row1['code'].'@'.$row1['description']; ?>"><?php echo $row1['code']; ?></option>
            <?php } ?>
          </select>
		  </td>
		  <td width="10px"></td>
		  <td>
<textarea rows="8" cols="80" id="tandcdesc" type="html" name="tandcdesc" ></textarea>
		</td>
		</tr>
</table>

<br />
<center>
<input type="submit" value="Save" id="Save" />&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_purchaseorder';">
</center>
<br />


</form>
</div>
</section></center>

		


<script type="text/javascript">



function change(a)
{
 if(a == "withpr1")
 {
   if(document.getElementById("withpr").checked==true)
   {
    
	document.location="dashboardsub.php?page=pp_addpurchaseorderrequest";
	
   
        
   }
   else
   {
   
   	 document.location="dashboardsub.php?page=pp_addpurchaseorder";
   	  
      
   }
 }

}





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

index = 1;
function num(b)
{
if((b<48 || b>57) &&(b!=46))
{
event.keyCode=false;
return false;
}

}
function makeForm()
{
 if(document.getElementById('pr@'+index).value != "" && parseInt(document.getElementById('qty@'+index).value) > 0)
 {
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
  var op1=new Option("-Select-","");
  myselect1.options.add(op1);
  
  
  for(i=0;i<catj.length;i++)
  {
  var op1=new Option(catj[i].cat,catj[i].cat);
  op1.title=catj[i].cat;
  myselect1.add(op1);
  
  
 }
  
  
  td1.appendChild(myselect1);
  
  var td2 = document.createElement('td');
  myselect1 = document.createElement("select");
  myselect1.id = "code@" + index;
  myselect1.name = "code[]";
  myselect1.style.width = "80px";
  myselect1.onchange = function() { seldescription(this.id,this.value); };
 var op1=new Option("-Select-","");
myselect1.options.add(op1);
  td2.appendChild(myselect1);
  
  var td3 = document.createElement('td');
  myselect1 = document.createElement("select");
  myselect1.id = "desc@" + index;
  myselect1.name = "desc[]";
  myselect1.style.width = "120px";
  myselect1.onchange = function() { selcode(this.id,this.value); };
 var op1=new Option("-Select-","");
 myselect1.options.add(op1);
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
  

  var td4 = document.createElement('td');
  myselect1 = document.createElement("select");
  myselect1.id = "pr@" + index;
  myselect1.name = "pr[]";
  myselect1.style.width = "95px";
  myselect1.onchange = function() { loadqty(this.id,this.value); };
 var op1=new Option("-Select-","");
 myselect1.options.add(op1);
  td4.appendChild(myselect1);



  var td6 = document.createElement('td');
  var input = document.createElement("input");
  input.type = "text";
  input.id = "qty@" + index;
  input.name = "qty[]";
  input.value = "0";
  input.onkeypress = function() {return num(Event.keyCode); }
  input.style.textAlign = "right";
  input.size = "5";
  td6.appendChild(input);
  

  
  var td7 = document.createElement('td');
  var input = document.createElement("input");
  input.type = "text";
  input.id = "rate@" + index;
  input.name = "rate[]";
  input.value = "0";
  input.style.textAlign = "right";
  input.onblur = function() { makeForm(); }
  
  input.onkeypress = function() {return num(event.keyCode); }
  input.size = "5";
  td7.appendChild(input);
  
  var td8 = document.createElement('td');
  myselect1 = document.createElement("select");
  myselect1.id = "doffice@" + index;
  myselect1.name = "doffice[]";
  myselect1.style.width = "120px";
  var op1=new Option("-Select-","");
  myselect1.options.add(op1);

  td8.appendChild(myselect1);

  var td9 = document.createElement('td');
  myselect1 = document.createElement("select");
  myselect1.id = "tax@" + index;
  myselect1.name = "tax[]";
  myselect1.style.width = "80px";
  var op1=new Option("-Select-","0@0@0@0");
  myselect1.options.add(op1);
 
 <?php            
           $query = "SELECT * FROM ims_taxcodes where  (taxflag = 'P' ) ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		 var theOption=new Option("<?php echo $row1['code']; ?>","<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['mode']."@".$row1['rule'];?>");
		
theOption.title="<?php echo $row1['description']; ?>";
myselect1.options.add(theOption);
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
 <?php            
           $query = "SELECT * FROM ims_taxcodes where type = 'Charges' and ctype = 'Freight' and (taxflag = 'P' or taxflag='A') ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		  var theOption=new Option("<?php echo $row1['code']; ?>","<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['mode']."@".$row1['rule'];?>");
		
theOption.title="<?php echo $row1['description']; ?>";
myselect1.options.add(theOption);
  
		<?php } ?><?php */?>
  td10.appendChild(myselect1);



  var td12 = document.createElement('td');
  myselect1 = document.createElement("input");
  myselect1.id = "disc@" + index;
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
  
  tr.appendChild(td1);
  tr.appendChild(e1);
  tr.appendChild(td2);
  tr.appendChild(e2);
  tr.appendChild(td3);
  tr.appendChild(e3);
  tr.appendChild(td5);
  tr.appendChild(e4);
  tr.appendChild(td4);
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
  tr.appendChild(e10);
 
  tr.appendChild(td12);
  tr.appendChild(td13);
  tr.appendChild(td14);

  tr.appendChild(td16);
  
  table.appendChild(tr);
 }
}

function removeAllOptions(selectbox)
{
	for(var i=selectbox.options.length;i>0;i--)
		selectbox.remove(i);
}



function getpo()
{
  var date1 = document.getElementById('date').value;
  var strdot1 = date1.split('.');
  var ignore = strdot1[0];
  var m = strdot1[1];
  var y = strdot1[2].substr(2,4);
     var mon = new Array();
     var yea = new Array();
     var poincr = new Array();
    var po = ""; 
  <?php 
    
   $query1 = "SELECT MAX(poincr) as poincr,m,y FROM pp_purchaseorder GROUP BY m,y ORDER BY date DESC";
   $result1 = mysql_query($query1,$conn);
   $k = 0; 
   while($row1 = mysql_fetch_assoc($result1))
   {
?>
     mon[<?php echo $k; ?>] = <?php echo $row1['m']; ?>;
     yea[<?php echo $k; ?>] = <?php echo $row1['y']; ?>;
     poincr[<?php echo $k; ?>] = <?php if($row1['poincr'] < 0) { echo 0; } else { echo $row1['poincr']; } ?>;

<?php $k++; } ?>

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

function fun(b,f) 
{
 var temp = b.split('@');
 var tindex = temp[1];
 var myselect1 = document.getElementById('code@' + tindex);
 var myselect2 = document.getElementById('desc@' + tindex);
 var myselect3 = document.getElementById('pr@' + tindex);
 var myselect4 = document.getElementById('doffice@' + tindex);
  document.getElementById('units@' + tindex).value = "";
 removeAllOptions(myselect1);
 removeAllOptions(myselect2);
 removeAllOptions(myselect3);
 removeAllOptions(myselect4);
 
 document.getElementById('qty@'+tindex).value = "0";
 for(i=0;i<cdj.length;i++)
 {
 if(cdj[i].cat==f)
 {
 var op1=new Option(cdj[i].icode,cdj[i].icode+'@'+cdj[i].name+'@'+cdj[i].units);
 op1.title=cdj[i].name;
 
 var op2=new Option(cdj[i].name,cdj[i].icode+'@'+cdj[i].name+'@'+cdj[i].units);
 op2.title=cdj[i].name;
  myselect1.add(op1);
  myselect2.add(op2);
 
 
 
}
}


}

function loadqty(a,b)
{
 var temp1 = a.split('@');
 var tindex = temp1[1];
 var temp = b.split('@');
 var qty = temp[1];
 
  var myselect1 = document.getElementById('doffice@'+tindex);
 removeAllOptions(myselect1);
 


 
 for(i=1;i<=index;i++)
 {
  for(j=1;j<=index;j++)
  {
  
  if(i!=j)
  {
  
  var p=document.getElementById('pr@' +i).value;
  
  var q=document.getElementById('pr@' +j).value;
  
  var code1=document.getElementById('code@' +i).value;
  
  var code2=document.getElementById('code@' +j).value;
  
  t1=p.split("@");
  t2=q.split("@");
 
  
  
 if((t1[0]==t2[0]) && (code1==code2))
     {
	 
	 alert("Please select dfferent combinations");
	 document.getElementById('pr@' + tindex).value="";
 	 return false;

	 
	 }
  
  }
  
  }
  }
  
  
 
 
  theOption1=document.createElement("OPTION");

			  theText1=document.createTextNode(temp[2]);

			  theOption1.value = temp[2];

			  theOption1.title = temp[2];

			  theOption1.appendChild(theText1);

			  myselect1.appendChild(theOption1);  

 
 
 
 document.getElementById('qty@'+tindex).value = qty;
 document.getElementById('doffice@'+tindex).value = temp[2];
 

 
 
 
 
}

function seldescription(a,b)
{


 var temp = a.split('@');
 var tindex = temp[1];
 var temp = b.split('@');
 var code = temp[0];
 var units = temp[2];
 if(b=="")
 units="";
 document.getElementById('desc@' + tindex).value = b;
 document.getElementById('units@' + tindex).value = units;
 document.getElementById('qty@' + tindex).value = 0;
 
  var myselect2 = document.getElementById('doffice@'+tindex);
 removeAllOptions(myselect2);
 var myselect1 = document.getElementById('pr@'+tindex);
 removeAllOptions(myselect1);
 var cc1=document.getElementById('code@' + tindex).value.split('@');
 var code=cc1[0];

 
 
 for(i=0;i<allj.length;i++)
 {
 if(allj[i].icode==code)
 {
 
 var op1=new Option(allj[i].pi,allj[i].pi+'@'+allj[i].quantity+'@'+allj[i].doffice);
 op1.title=allj[i].pi;
 myselect1.add(op1);
 
 
 }
 }
}

function selcode(a,b)
{
 var temp = a.split('@');
 var tindex = temp[1];
 var temp = b.split('@');
 var code = temp[0];
 var units = temp[2];
  if(b=="")
 units="";
 document.getElementById('code@' + tindex).value = b;
 document.getElementById('units@' + tindex).value = units;
 document.getElementById('qty@' + tindex).value = 0;
 
 
  var myselect2 = document.getElementById('doffice@'+tindex);
 removeAllOptions(myselect2);
 var myselect1 = document.getElementById('pr@'+tindex);
 removeAllOptions(myselect1);
 var cc1=document.getElementById('code@' + tindex).value.split('@');
 var code=cc1[0];
 
 
 for(i=0;i<allj.length;i++)
 {
 if(allj[i].icode==code)
 {
 
 var op1=new Option(allj[i].pi,allj[i].pi+'@'+allj[i].quantity+'@'+allj[i].doffice);
 op1.title=allj[i].pi;
 myselect1.add(op1);
 
 
 }
 }
}

function checkform()
{ 



  if(document.getElementById("vendor").value == "")
  
	 {
	  alert("Please select Vendor");
	  document.getElementById('vendor').focus();
	  return false;
	 }
  
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
	if(document.getElementById('pr@' + k).value != "")
	if(document.getElementById('doffice@' + k).value == "")
	 {
	  alert("Please select Delivery Location");
	  document.getElementById('doffice@' + k).focus();
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
  
  
  
  for(j=1;j<=index;j++)
  {
  
    for(k=1;k<=index;k++)
	
		{
		
			if((document.getElementById("code@"+j).value==document.getElementById("code@"+k).value)&&(document.getElementById('doffice@' + k).value==document.getElementById('doffice@' + j).value) && (j!=k))	
			
			{
			
			if((document.getElementById("freight@" + k).value!=document.getElementById("freight@" + j).value) )
			{
			
			alert("same warehouse and same item doesn't contain different freight");
			  return false;
			
			
			}
			}
		
		
		}
		
		
	
	}
  
  
  
document.getElementById("Save").disabled=true;  

 return true;
}




</script>
<div class="clear"></div>
<br />

<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_m_addpurchaseorderrequest.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=no');
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
