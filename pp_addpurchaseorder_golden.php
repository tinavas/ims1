<?php include "jquery.php"; include "config.php"; ?>
<link href="editor/sample.css" rel="stylesheet" type="text/css"/>
<?php 
$date1 = date("d.m.Y"); $strdot1 = explode('.',$date1); $ignore = $strdot1[0]; $m = $strdot1[1];$y = substr($strdot1[2],2,4);
$query1 = "SELECT MAX(poincr) as poincr FROM pp_purchaseorder  where m = '$m' AND y = '$y' ORDER BY date DESC";
$result1 = mysql_query($query1,$conn); $piincr = 0; while($row1 = mysql_fetch_assoc($result1)) { $poincr = $row1['poincr']; }
$poincr = $poincr + 1;
if ($poincr < 10) { $po = 'PO-'.$m.$y.'-000'.$poincr; }
else if($poincr < 100 && $poincr >= 10) { $po = 'PO-'.$m.$y.'-00'.$poincr; }
else { $po = 'PO-'.$m.$y.'-0'.$poincr; }  
?>
<script type="text/javascript">
$(document).ready(function()
{  	
	$("#lastpoid").click(function()
	{
	 
	 $.post("ajax_lastpo.php",{ vname:$("#codevendor").val() },function(data)
        { 
		//alert(data);
		var po=data.split('@');	
		for(i=0;i<po.length;i++)
		 { 
		  po[i]=po[i].split('#'); 
		if(i==0) {
		 var div_lastpo  = document.getElementById('div_lastpo');
		 div_lastpo.innerHTML="";
		 var tab_lastpo  = document.createElement('table'); 
		 var tr_lastpo = document.createElement('tr'); 
		 
		 var td_lastpo = document.createElement('th'); 
		 myspace= document.createTextNode('Type');
		 td_lastpo.style.color='#3399d8';
		 td_lastpo.appendChild(myspace);
		 tr_lastpo.appendChild(td_lastpo);	 
		 
 		 var td_lastpo = document.createElement('th'); 
		 myspace= document.createTextNode('\u00a0');
		 td_lastpo.appendChild(myspace);
		 tr_lastpo.appendChild(td_lastpo);
		 
		 var td_lastpo = document.createElement('th'); 
		 myspace= document.createTextNode('Code');td_lastpo.style.color='#3399d8';
		 td_lastpo.appendChild(myspace);
		 tr_lastpo.appendChild(td_lastpo);	
		 
		 var td_lastpo = document.createElement('th'); 
		 myspace= document.createTextNode('\u00a0');
		 td_lastpo.appendChild(myspace);
		 tr_lastpo.appendChild(td_lastpo);
		 
		 var td_lastpo = document.createElement('th'); 
		 myspace= document.createTextNode('Description');td_lastpo.style.color='#3399d8';
		 td_lastpo.appendChild(myspace);
		 tr_lastpo.appendChild(td_lastpo);	
		 
		 var td_lastpo = document.createElement('th'); 
		 myspace= document.createTextNode('\u00a0');
		 td_lastpo.appendChild(myspace);
		 tr_lastpo.appendChild(td_lastpo);
		 
		 var td_lastpo = document.createElement('th'); 
		 myspace= document.createTextNode('Quantity');td_lastpo.style.color='#3399d8';
		 td_lastpo.appendChild(myspace);
		 tr_lastpo.appendChild(td_lastpo);	
		 
		 var td_lastpo = document.createElement('th'); 
		 myspace= document.createTextNode('\u00a0');
		 td_lastpo.appendChild(myspace);
		 tr_lastpo.appendChild(td_lastpo);
		 
		 var td_lastpo = document.createElement('th'); 
		 myspace= document.createTextNode('Rate Per Unit');td_lastpo.style.color='#3399d8';
		 td_lastpo.appendChild(myspace);
		 tr_lastpo.appendChild(td_lastpo);	
		 
		 tab_lastpo.appendChild(tr_lastpo);
        } // if end
		
		 var tr_lastpo = document.createElement('tr'); 
		 tr_lastpo.height='10px';
		 tab_lastpo.appendChild(tr_lastpo);
 		 var tr_lastpo = document.createElement('tr');  
		
		 input=document.createElement("input");
  	     input.type='text';
		 input.style.border='';
		 input.style.background='';
		 input.value=po[i][0];
 		 var td_lastpo = document.createElement('td'); 
		 td_lastpo.appendChild(input);
		 tr_lastpo.appendChild(td_lastpo);	 
		 
 		 var td_lastpo = document.createElement('td'); 
		 myspace= document.createTextNode('\u00a0');
		 td_lastpo.appendChild(myspace);
		 tr_lastpo.appendChild(td_lastpo);
		 
		 input=document.createElement("input");
  	     input.type='text';
		 input.style.border='';
		 input.style.background='';
		 input.value=po[i][1];
		 input.size='10';
 		 var td_lastpo = document.createElement('td'); 
		 td_lastpo.appendChild(input);
		 tr_lastpo.appendChild(td_lastpo);
		 
		 var td_lastpo = document.createElement('td'); 
		 myspace= document.createTextNode('\u00a0');
		 td_lastpo.appendChild(myspace);
		 tr_lastpo.appendChild(td_lastpo);
		 
		 input=document.createElement("input");
  	     input.type='text';
		 input.style.border='';
		 input.style.background='';
		 input.value=po[i][2];
 		 var td_lastpo = document.createElement('td'); 
		 td_lastpo.appendChild(input);
		 tr_lastpo.appendChild(td_lastpo);
		 
		 var td_lastpo = document.createElement('td'); 
		 myspace= document.createTextNode('\u00a0');
		 td_lastpo.appendChild(myspace);
		 tr_lastpo.appendChild(td_lastpo);
		 
		 input=document.createElement("input");
  	     input.type='text';
		 input.style.border='';
		 input.style.background='';
		 input.style.textAlign='right';
		 input.size='10';
		 input.value=po[i][3];
 		 var td_lastpo = document.createElement('td'); 
		 td_lastpo.appendChild(input);
		 tr_lastpo.appendChild(td_lastpo);
		 
		 var td_lastpo = document.createElement('td'); 
		 myspace= document.createTextNode('\u00a0');
		 td_lastpo.appendChild(myspace);
		 tr_lastpo.appendChild(td_lastpo);
		 
		 input=document.createElement("input");
  	     input.type='text';
		 input.style.border='';
		 input.style.background='';
		 input.style.textAlign='right';
		 input.value=po[i][4];
		 input.size='10';
 		 var td_lastpo = document.createElement('td'); 
		 td_lastpo.appendChild(input);
		 tr_lastpo.appendChild(td_lastpo);
		 
		 tab_lastpo.appendChild(tr_lastpo);
		 } // for end
	 
		div_lastpo.appendChild(tab_lastpo);
		});
	});
});	
</script>

<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" id="complex_form" name="form1" method="post" action="pp_savepurchaseorder_golden.php" onSubmit="return calculate(this);">
	  <h1>Purchase Order</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
		
            <table>
              <tr>

             <!-- hidden variables start -->

                <input type="hidden" name="poincr" id="poincr" value="<?php echo $poincr; ?>"/>
                <input type="hidden" name="m" id="m" value="<?php echo $m; ?>"/>
                <input type="hidden" name="y" id="y" value="<?php echo $y; ?>"/>
                <input type="hidden" name="taxamount[]" id="taxamount" />
                <input type="hidden" name="freightamount[]" id="freightamount" />
                <input type="hidden" name="brokerageamount[]" id="brokerageamount" />
                <input type="hidden" name="discountamount[]" id="discountamount" />
				<input type="hidden" id="selcodes" name="selcodes" value="" />
				<input type="hidden" id="codevendor" name="codevendor" value="" />
             <!-- hidden variables end -->
               
                <td><strong>P.O</strong></td>
                <td>&nbsp;<input type="text" size="14" id="po" name="po" value="<?php echo $po; ?>" readonly style="border:0px;background:none" /></td>
                <td width="20px"></td>

                <td><strong>Vendor</strong></td>
                <td>&nbsp;
                <select style="width: 180px" onchange="document.getElementById('codevendor').value = document.getElementById('selcodes').value+'#'+document.getElementById('vendor').value;" name="vendor" id="vendor" >
                                                       <option value="">-Select-</option>
                                                   <?php 	
	                      $query = "SELECT distinct(name) FROM contactdetails where type = 'vendor' ORDER BY name ASC";
		                  $result = mysql_query($query,$conn);
 		                    while($row = mysql_fetch_assoc($result))
		                                       {
                                          ?>
                                                         <option value="<?php echo $row['name'];?>"><?php echo $row['name']; ?></option>
                <?php } ?>
                </select>
                </td>
                <td width="20px"></td>


                <td><strong>Broker</strong></td>
                <td>&nbsp;
                <select style="width: 160px" name="broker" id="broker">
                                   <option value="">-Select-</option>
							   <?php 
										
	                                             $query = "SELECT distinct(name) FROM contactdetails where type = 'broker' ORDER BY name ASC";
		                                         $result = mysql_query($query,$conn);
 		                                         while($row = mysql_fetch_assoc($result))
		                                              {
                                          ?>
                                                         <option value="<?php echo $row['name'];?>"><?php echo $row['name']; ?></option>
                <?php } ?>
               </select>                </td>
                <td width="20px"></td>
                <input type="hidden" name="vendorid" value="0" />
                <input type="hidden" name="brokerid" value="0" />

                <td><strong>Date</strong></td>
                <td>&nbsp;<input type="text" size="15" id="mdate" class="datepicker" name="mdate" value="<?php echo date("d.m.Y"); ?>" onChange="getpo();" ></td>
                <td width="20px"></td>
                <td><strong>Credit&nbsp;Term</strong></td>
                <td>&nbsp;
                <select style="width: 100px" name="creditterm" id="creditterm">
                                   <option value="0@0@0">-Select-</option>
							   <?php 	
	                                             $query = "SELECT distinct(code),description,value FROM ims_creditterm ORDER BY code ASC";
		                                         $result = mysql_query($query,$conn);
 		                                         while($row = mysql_fetch_assoc($result))
		                                              {
                                          ?>
                                                         <option value="<?php echo $row['code'].'@'.$row['description'].'@'.$row['value'];?>"><?php echo $row['code']; ?></option>
                <?php } ?>
               </select>                </td>
			   </tr>
			   <tr height="10px"></tr>
			   <tr>
                <td><strong>Placed By</strong></td>
                <td>&nbsp;
                <select style="width: 100px" name="placedby" id="placedby">
                                   <option value="">-Select-</option>
							   <?php 	
	                                             $query = "SELECT distinct(employeeid),name FROM hr_employee ORDER BY name ASC";
		                                         $result = mysql_query($query,$conn);
 		                                         while($row = mysql_fetch_assoc($result))
		                                              {
                                          ?>
                                                         <option  value="<?php echo $row['name'];?>"><?php echo $row['name'];?></option>
                <?php } ?>
               </select>                </td>
              </tr>
            </table>







		<div class="columns">
			<div class="col200pxL-left">
				<h2>&nbsp;</h2><br /><br />
				<p class="one-line-input grey-bg small-margin">
					<label for="complex-switch-on" class="float-left" id="prtext">With Out Purchase Request</label><br /><br />
					<span class="float-left"><input type="checkbox" name="complex-switch-on" id="complex-switch-on" value="1" class="switch" onClick="change('withpr');"></span>
                               <br /><br />
				</p>

				<ul class="side-tabs js-tabs same-height">
					<li><a href="#tab-po" title="Item Details">Item Details</a></li>
					<li><a href="#tab-delivery" title="Delivery Details">Delivery Details</a></li>
					<li><a href="#tab-taxes" title="Taxes">Taxes</a></li>
     				      <li><a href="#tab-charges" title="Charges">Charges</a></li>
					<li><a href="#tab-discounts" title="Discounts">Discounts</a></li>
					<li><a href="#tab-tandc" title="Terms &amp; Conditions">Terms &amp; Conditions</a></li>
					<li id="lastpoid"><a  href="#lastpo" title="Latest Purchase Order">Latest Purchase Order</a></li>
				</ul>				
						
			</div>




		<div class="col200pxL-right">





<br />





<!-- /////////////////////////////Purchase Order Starts/////////////////////////////////////////// -->

<div id="tab-po" class="tabs-content" style="height:450px">
<center>

<div id="div-pr" style="position:absolute; visibility:hidden">
 <table border="0" id="table-pr">
     <tr>
        <th style=""><strong>Category</strong></th>
        <th width="10px"></th>
 
        <th style=""><strong>Item Code</strong></th>
        <th width="10px"></th>
  
        <th style=""><strong>Description</strong></th>
        <th width="10px"></th>

        <th style=""><strong>PR #</strong></th>
        <th width="10px"></th>

        <th style=""><strong>Quantity</strong></th>
        <th width="10px"></th>
 
        <th style=""><strong>Units</strong></th>
        <th width="10px"></th>

        <th style=""><strong>Rate/Unit</strong></th>
        <th width="10px"></th>
 
        <th style=""><strong>Delivery Date</strong></th>
     </tr>

     <tr style="height:20px"></tr>

     <tr>
 
       <td style="text-align:left;">
         <select name="prcategory[]" id="prtype" onChange="fun(this.id,'pr');" style="width:90px;">
           <option>-Select-</option>
           <?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemtypes ORDER BY type ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['type']; ?>"><?php echo $row1['type']; ?></option>
           <?php } ?>
         </select>
       </td>
       <td width="10px"></td>

       <td style="text-align:leftl;">
         <select name="prcode[]" id="prcode" onChange="seldescription(this.id,'pr');" style="width:70px;">
           <option>-Select-</option>
         </select>
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <select name="prdesc[]" id="prdescing" onChange="selcode(this.id,'pr');" style="width:140px;">
           <option>-Select-</option>
         </select>
         <input type="hidden" name="prdescription[]" id="pring" readonly size="15"  /> 
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <select name="prnum[]" id="prnum" onChange="prdetails(this.id);" style="width:90px;">
           <option>-Select-</option>
         </select>
       </td>
       <td width="10px"></td>


       <td style="text-align:left;">
         <input type="text" name="prquantity[]" id="pringweight"  size="8" onKeyUp="getvalues(this.id)" onBlur="getvalues(this.id)"  />
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" name="prunits[]" id="prmunit"  size="8"  />
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" name="prrate[]" id="prunit"  onfocus = "makeForm('pr')" size="7" />
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" size="11" id="prrdate" name="prrdate[]" class="datepicker" value="<?php echo date("d.m.Y"); ?>">
       </td>
    </tr>
   </table>
   <br /> 
   <input type="submit" value="Save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_purchaseorder';">
</div>




<div id="div-po" style="position:absolute;">
 <table border="0" id="table-po">
     <tr>
        <th style=""><strong>Category</strong></th>
        <th width="10px"></th>
 
        <th style=""><strong>Item Code</strong></th>
        <th width="10px"></th>
  
        <th style=""><strong>Description</strong></th>
        <th width="10px"></th>

        <th style=""><strong>Quantity</strong></th>
        <th width="10px"></th>
 
        <th style=""><strong>Units</strong></th>
        <th width="10px"></th>

        <th style=""><strong>Rate/Unit</strong></th>
        <th width="10px"></th>
 
        <th style=""><strong>Delivery Date</strong></th>
     </tr>

     <tr style="height:20px"></tr>

     <tr>
 
       <td style="text-align:left;">
         <select name="category[]" id="type" onChange="fun(this.id,'');" style="width:90px;">
           <option>-Select-</option>
           <?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemtypes ORDER BY type ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option value="<?php echo $row1['type']; ?>"><?php echo $row1['type']; ?></option>
           <?php } ?>
         </select>
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <select name="code[]" id="code" onChange="seldescription(this.id,'');" style="width:80px;">
           <option>-Select-</option>
         </select>
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
      
         <select name="desc[]" id="descing" onChange="selcode(this.id,'');" style="width:140px;">
           <option>-Select-</option>
         </select>
     
         <input type="hidden" name="description[]" id="ing" readonly size="25"  /> 
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" name="quantity[]" id="ingweight"  size="8" onfocus = "makeForm('')" onKeyUp="getvalues(this.id)" onBlur="getvalues(this.id)"  />
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" name="units[]" id="munit"  size="8"  />
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" name="rate[]" id="unit"  size="8" />
       </td>
       <td width="10px"></td>

       <td style="text-align:left;">
         <input type="text" size="15" id="rdate" name="rdate[]" class="datepicker" value="<?php echo date("d.m.Y"); ?>">
       </td>
    </tr>
   </table>
   <br /> 
   <input type="submit" value="Save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_purchaseorder';">
</div>



 </center>
</div>

<!-- /////////////////////////////Purchase Order Ends/////////////////////////////////////////// -->

		



<!-- /////////////////////////////Purchase delivery Start/////////////////////////////////////////// -->

<div id="tab-delivery" class="tabs-content">
  <!-- <p class="one-line-input grey-bg small-margin">
	<label for="complex-switch-on" class="float-left" id="taxtext">Different Tax for each item</label>
      <span class="float-left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="complex-switch-on" id="tax-switch-on" value="1" class="mini-switch" checked="checked" onclick="change('taxes');"></span>
      <br /><br />
   </p>
   <br /> -->

   <center>
      <table border="0" id="table-delivery">
        <tr>
          <th style="text-align:left"><strong>Type</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Code</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Description</strong></th>
          <th width="10px"></th>

          <th style="text-align:left"><strong>Quantity</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Units</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>D.Location</strong></th>
          <th width="10px"></th>
		  
          <th style="text-align:left"><strong>Flock</strong></th>
          <th width="10px"></th>
		  
          <th style="text-align:left"><strong>Receiver</strong></th>
        </tr>

        <tr style="height:20px"></tr>
 
        <tr>
         <td style="text-align:left;">
           <input type="text" name=""  id="delivery-type" readonly style="border:0px;background:none;cursor:hand" size="15"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="delivery-code" readonly style="border:0px;background:none;cursor:hand" size="10"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input  type="text" name="" title="" size="10" id="delivery-ing" readonly style="border:0px;background:none;cursor:hand"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="delivery-ingweight" readonly style="border:0px;background:none;cursor:hand"  size="8"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="delivery-munit" readonly style="border:0px;background:none;cursor:hand"  size="8"  />
         </td>
         <td width="10px"></td>

          <td>
<select name="doffice[]" id="doffice" onchange = "getemp(this.id);" style="width:80px;">
<option value="">-Select-</option>
 <?php
          
           $query = "SELECT * FROM tbl_sector ORDER BY sector ASC";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
           ?>
<option value="<?php echo $row1['sector']; ?>" title="<?php echo $row1['sector']; ?>" ><?php echo $row1['sector']; ?></option>
<?php } ?>
</select>
          </td>
          <td width="10px"></td>
		  
		  <td>
<select name="flock[]" id="flock" onchange = "" style="width:80px;">
<option value="">-Select-</option>
 <?php
           
           $query = "SELECT distinct(flkmain) From breeder_flock where cullflag=0 ORDER BY flkmain";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
           ?>
<option value="<?php echo $row1['flkmain']; ?>" title="<?php echo $row1['flkmain']; ?>" ><?php echo $row1['flkmain']; ?></option>
<?php } ?>
</select>
          </td>
          <td width="10px"></td>

          <td>
<select name="demp[]" id="demp"  style="width:80px;">
<option value="">-Select-</option>
 </select>
          </td>
       </tr>
     </table>
   <br />
   <input type="submit" value="Save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_purchaseorder';">
  </center>
</div>


<!-- /////////////////////////////Purchase Delivery Ends/////////////////////////////////////////// -->



				
	
<!-- /////////////////////////////Purchase Taxes Start/////////////////////////////////////////// -->

<div id="tab-taxes" class="tabs-content">
  <!-- <p class="one-line-input grey-bg small-margin">
	<label for="complex-switch-on" class="float-left" id="taxtext">Different Tax for each item</label>
      <span class="float-left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="complex-switch-on" id="tax-switch-on" value="1" class="mini-switch" checked="checked" onclick="change('taxes');"></span>
      <br /><br />
   </p>
   <br /> -->

   <center>
      <table border="0" id="table-taxes">
        <tr>
          <th style="text-align:left"><strong>Type</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Code</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Description</strong></th>
          <th width="10px"></th>

          <th style="text-align:left"><strong>Quantity</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Units</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Tax</strong></th>
        </tr>

        <tr style="height:20px"></tr>
 
        <tr>
         <td style="text-align:left;">
           <input type="text" name="" id="tax-type" readonly style="border:0px;background:none;cursor:hand" size="20"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="tax-code" readonly style="border:0px;background:none;cursor:hand" size="15"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="tax-ing" readonly style="border:0px;background:none;cursor:hand" size="25"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="tax-ingweight" readonly style="border:0px;background:none;cursor:hand"  size="8"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="tax-munit" readonly style="border:0px;background:none;cursor:hand"  size="8"  />
         </td>
         <td width="10px"></td>

         <td>
           <select name="tax[]" id="tax"  style="width:80px;">
             <option value="0@0@0@0">-Select-</option>
             <?php
                include "config.php"; 
                $query = "SELECT * FROM ims_taxcodes where type='Tax' and taxflag = 'P' ORDER BY code DESC ";
                $result = mysql_query($query,$conn); 
                while($row1 = mysql_fetch_assoc($result)) 
                {
             ?>
             <option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['formula']."@".$row1['rule']; ?>"><?php echo $row1['code']; ?></option>
             <?php } ?>
           </select>
         </td>
       </tr>
     </table>
   <br />
   <input type="submit" value="Save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_purchaseorder';">
  </center>
</div>


<!-- /////////////////////////////Purchase Taxes Ends/////////////////////////////////////////// -->



<!-- /////////////////////////////Purchase Charges Starts/////////////////////////////////////////// -->


<div id="tab-charges" class="tabs-content">
  <!-- <p class="one-line-input grey-bg small-margin">
	<label for="complex-switch-on" class="float-left" id="taxtext">Different Tax for each item</label>
      <span class="float-left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="complex-switch-on" id="tax-switch-on" value="1" class="mini-switch" checked="checked" onclick="change('taxes');"></span>
      <br /><br />
   </p>
   <br /> -->

   <center>
      <table border="0" id="table-charges">
        <tr>
          <th style="text-align:left"><strong>Type</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Code</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Description</strong></th>
          <th width="10px"></th>

          <th style="text-align:left"><strong>Quantity</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Units</strong></th>
          <th width="10px"></th>
 
          <th title="included/exluded" style="text-align:center"><strong>I/E</strong></th>
          <th width="10px"></th>

          <th title="Freight Amount" style="text-align:left"><strong>Amount</strong></th>
          <th width="10px"></th>
		  
		  <th title="CoA to be charged" style="text-align:left"><strong>CoA</strong></th>
          <th width="10px"></th>

          <th style="text-align:left"><strong>Brokerage</strong></th>
        </tr>

        <tr style="height:20px"></tr>
 
        <tr>
         <td style="text-align:left;">
           <input type="text" name="" id="charges-type" readonly style="border:0px;background:none;cursor:hand" size="15"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="charges-code" readonly style="border:0px;background:none;cursor:hand" size="10"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="charges-ing" readonly style="border:0px;background:none;cursor:hand" size="10"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="charges-ingweight" readonly style="border:0px;background:none;cursor:hand"  size="8"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="charges-munit" readonly style="border:0px;background:none;cursor:hand"  size="8"  />
         </td>
         <td width="10px"></td>
		 
		 
		   <td>
            <select name="frtype[]" id="frtype"  style="width:60px;">
              <option title="Included" value="included">Included</option>
              <option title="Excluded" value="excluded">Excluded</option>   
           </select>
          </td>
          <td width="10px"></td>
		  
		    <td>
            <input type="text" size="10" name="framt[]" id="framt" > 
          </td>
          <td width="10px"></td>

          <td>
            <select name="frcoa[]" id="frcoa"  style="width:60px;">
              <option value="">-Select-</option>
              <?php
                
                $query = "select distinct(code),description from ac_coa where (controltype = '' or controltype is NULL) and type = 'Expense' and schedule = 'INDIRECT EXPENSES' and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code";
                 $result = mysql_query($query,$conn); 
                 while($row1 = mysql_fetch_assoc($result))
                 {
              ?>
              <option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']; ?>"><?php echo $row1['code']; ?></option>
              <?php } ?>
           </select>
          </td>
          <td width="10px"></td>

          <td>
            <select name="brokerage[]" id="brok"  style="width:80px;">
              <option value="0@0@0@0">-Select-</option>
              <?php
                 include "config.php"; 
                $query = "SELECT * FROM ims_taxcodes where type='Charges' and ctype='Brokerage' and taxflag = 'P' ORDER BY code DESC ";
                 $result = mysql_query($query,$conn); 
                 while($row1 = mysql_fetch_assoc($result))
                 {
              ?>
              <option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['formula']."@".$row1['rule']; ?>"><?php echo $row1['code']; ?></option>
              <?php } ?>
            </select>
          </td>
       </tr>
     </table>
   <br />
   <input type="submit" value="Save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_purchaseorder';">
  </center>

</div>


<!-- /////////////////////////////Purchase Charges Ends/////////////////////////////////////////// -->


<!-- /////////////////////////////Purchase Discount Starts/////////////////////////////////////////// -->


						
<div id="tab-discounts" class="tabs-content">


  <!-- <p class="one-line-input grey-bg small-margin">
	<label for="complex-switch-on" class="float-left" id="taxtext">Different Tax for each item</label>
      <span class="float-left">&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="complex-switch-on" id="tax-switch-on" value="1" class="mini-switch" checked="checked" onclick="change('taxes');"></span>
      <br /><br />
   </p>
   <br /> -->

   <center>
      <table border="0" id="table-discounts">
        <tr>
          <th style="text-align:left"><strong>Type</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Code</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Description</strong></th>
          <th width="10px"></th>

          <th style="text-align:left"><strong>Quantity</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Units</strong></th>
          <th width="10px"></th>
 
          <th style="text-align:left"><strong>Discount</strong></th>
        </tr>

        <tr style="height:20px"></tr>
 
        <tr>
         <td style="text-align:left;">
           <input type="text" name="" id="discounts-type" readonly style="border:0px;background:none;cursor:hand" size="20"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="discounts-code" readonly style="border:0px;background:none;cursor:hand" size="15"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="discounts-ing" readonly style="border:0px;background:none;cursor:hand" size="25"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="discounts-ingweight" readonly style="border:0px;background:none;cursor:hand"  size="8"  />
         </td>
         <td width="10px"></td>

         <td style="text-align:left;">
           <input type="text" name="" id="discounts-munit" readonly style="border:0px;background:none;cursor:hand"  size="8"  />
         </td>
         <td width="10px"></td>

         <td>
           <select name="discount[]" id="disc"  style="width:80px;">
             <option value="0@0@0@0">-Select-</option>
             <?php
                  include "config.php"; 
                $query = "SELECT * FROM ims_taxcodes where type='Discount' and taxflag = 'P' ORDER BY code DESC ";
                  $result = mysql_query($query,$conn); 
                  while($row1 = mysql_fetch_assoc($result))
                  {
            ?>
                  <option title="<?php echo $row1['description']; ?>" value="<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['formula']."@".$row1['rule']; ?>"><?php echo $row1['code']; ?></option>
            <?php } ?>
          </select>
         </td>
       </tr>
     </table>
   <br />
   <input type="submit" value="Save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_purchaseorder';">
  </center>


</div>
						

<!-- /////////////////////////////Purchase Discount Ends/////////////////////////////////////////// -->





<!-- /////////////////////////////Purchase Terms & Conditions Starts/////////////////////////////////////////// -->


<div id="tab-tandc" class="tabs-content">

           <select name="disc[]" id="tandccode"  style="width:150px;" multiple onclick="getdescr(this.value)">
             <option disabled>-Select-</option>
             <?php
                  include "config.php"; 
                  $query = "SELECT * FROM ims_terms ORDER BY code DESC ";
                  $result = mysql_query($query,$conn); 
                  while($row1 = mysql_fetch_assoc($result))
                  {
            ?>
                  <option value="<?php echo $row1['code'].'@'.$row1['description']; ?>"><?php echo $row1['code']; ?></option>
            <?php } ?>
          </select><br /><br /><br />
<textarea rows="14" cols="110" id="tandcdesc" type="html" name="tandcdesc" ></textarea>
<br /><br />
<strong>Purpose</strong>&nbsp;&nbsp;<textarea rows="3" cols="80" id="purpose" type="html" name="purpose" ></textarea>
   <br />
  <center>
   <input type="submit" value="Save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_purchaseorder';">
  </center>

</div>
						
<!-- /////////////////////////////Purchase Terms & Conditions Ends/////////////////////////////////////////// -->
<!-- /////////////////////////////Latest PO start/////////////////////////////////////////// -->

<div id="lastpo" class="tabs-content">
<div id="div_lastpo"></div>
<center>
   <input type="submit" value="Save" style="margin-top:10px;" />
   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
   <input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=pp_purchaseorder';">
  </center>
</div>

<!-- /////////////////////////////Latest Po Ends/////////////////////////////////////////// -->

					</div>
					
					<!-- <div class="col200pxL-bottom">
						<p class="one-line-input grey-bg small-margin">
							<label for="complex-switch-on" class="float-left">Small switch on</label>
							<input type="checkbox" name="complex-switch-on" id="complex-switch-on" value="1" class="mini-switch" checked="checked">
						</p>
						<p class="one-line-input grey-bg clearfix">
							<label for="complex-switch-off" class="float-left">Small switch off</label>
							<input type="checkbox" name="complex-switch-off" id="complex-switch-off" value="1" class="mini-switch">
						</p>
					</div> -->
				</div>
				
			</form></div>
		</section>
		
		<div class="clear"></div>


<br />





<!-- Javascripts -->





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
        //out += document.getElementById("tandccode").options[i].value + '\n';
      }
   }

  document.getElementById("tandcdesc").value = out;
}


<!-- Change of Text Starts -->




function change(a)
{
 if(a == "withpr")
 {
   if(document.getElementById("complex-switch-on").checked)
   {
      document.getElementById("prtext").innerHTML="With Out Purchase Request"; 
      document.getElementById("div-pr").style.visibility="hidden";
      document.getElementById("div-po").style.visibility="visible";
      //document.getElementById("complex-switch-on").disabled = "true";
      var index = -1;
   }
   else
   {
      document.getElementById("prtext").innerHTML="With Purchase Request";
      document.getElementById("div-pr").style.visibility="visible";
      document.getElementById("div-po").style.visibility="hidden";
      var index = -1;
   }
 }
 if(a == "taxes")
 {
   if(document.getElementById("tax-switch-on").checked)
   {
      document.getElementById("taxtext").innerHTML="Same Tax for all items"; 
   }
   else
   {
      document.getElementById("taxtext").innerHTML="Different Tax for each item";
   }
 }
 if(a == "brokerage")
 {
   if(document.getElementById("brokerage-switch-on").checked)
   {
      document.getElementById("brokeragetext").innerHTML="Same Brokerage for all items"; 
   }
   else
   {
      document.getElementById("brokeragetext").innerHTML="Different Brokerage for each item";
   }
 }
 if(a == "freight")
 {
   if(document.getElementById("freight-switch-on").checked)
   {
      document.getElementById("freighttext").innerHTML="Same Freight for all items"; 
   }
   else
   {
      document.getElementById("freighttext").innerHTML="Different Freight for each item";
   }
 }
 if(a == "discounts")
 {
   if(document.getElementById("tax-switch-on").checked)
   {
      document.getElementById("taxtext").innerHTML="Same Tax for all items"; 
   }
   else
   {
      document.getElementById("taxtext").innerHTML="Different Tax for each item";
   }
 }

}




<!-- Change of Text Ends -->







var index = -1;
function makeForm(a) {
//alert(a);
  index = index + 1;
  var i,b;
  if(a == "pr")
  {
    var t1  = document.getElementById('table-pr');
  }
  else
  {
    var t1  = document.getElementById('table-po');
  }
  var r  = document.createElement('tr');

  var t2  = document.getElementById('table-taxes');
  var r1 = document.createElement('tr'); 

  var t3  = document.getElementById('table-charges');
  var r2 = document.createElement('tr'); 

  var t4  = document.getElementById('table-discounts');
  var r3 = document.createElement('tr'); 

  var t5  = document.getElementById('table-delivery');
  var r4 = document.createElement('tr'); 



<!-- Hidden Variables Start -->

  mybox31=document.createElement("input");
  mybox31.size="10";
  mybox31.type="hidden";
  mybox31.name="taxamount[]";
  mybox31.id="taxamount" + index;

  mybox41=document.createElement("input");
  mybox41.size="10";
  mybox41.type="hidden";
  mybox41.name="freightamount[]";
  mybox41.id="freightamount" + index;

  mybox51=document.createElement("input");
  mybox51.size="10";
  mybox51.type="hidden";
  mybox51.name="brokerageamount[]";
  mybox51.id="brokerageamount" + index;

  mybox61=document.createElement("input");
  mybox61.size="10";
  mybox61.type="hidden";
  mybox61.name="discountamount[]";
  mybox61.id="discountamount" + index;


<!-- Hidden Variables End -->


  
<!-- First TD Start -->

//for po

  var cca = document.createElement('td');
  myselect1 = document.createElement("select");
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  if(a == "pr")
  {
    myselect1.style.width = "90px";
    myselect1.name = "prcategory[]";
    myselect1.id = "prtype/" +  index;
    myselect1.onchange = function ()  {  fun(this.id,'pr'); };
  }
  else
  {
    myselect1.style.width = "90px";
    myselect1.name = "category[]";
    myselect1.id = "type/" +  index;
    myselect1.onchange = function ()  {  fun(this.id,''); };
  }
  <?php
           include "config.php"; 
           $query = "SELECT * FROM ims_itemtypes ORDER BY type ASC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>

		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['type']; ?>");
		theOption.appendChild(theText);
		theOption.value = "<?php echo $row1['type']; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>
  var c1ca = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  c1ca.appendChild(myspace2);
  var ca = document.createElement('td');
  ca.appendChild(myselect1);
  ca.appendChild(mybox31);
  ca.appendChild(mybox41);
  ca.appendChild(mybox51);
  ca.appendChild(mybox61);




//for taxes

  mybox1=document.createElement("input");
  mybox1.size="20";
  mybox1.type="text";
  mybox1.id="tax-type/" +  index;
  mybox1.readonly = true;
  mybox1.style.border = 0;
  mybox1.style.background = "none";
  mybox1.style.cursor = "hand";
  var ba1 = document.createElement('td');
  ba1.appendChild(mybox1);

  var b1 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b1.appendChild(myspace2);




//for charges

  a1mybox1=document.createElement("input");
  a1mybox1.size="15";
  a1mybox1.type="text";
  a1mybox1.id="charges-type/" +  index;
  a1mybox1.readonly = true;
  a1mybox1.style.border = 0;
  a1mybox1.style.background = "none";
  a1mybox1.style.cursor = "hand";
  var a1ba1 = document.createElement('td');
  a1ba1.appendChild(a1mybox1);

  var a1b1 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a1b1.appendChild(myspace2);



//for delivery

  a3mybox1=document.createElement("input");
  a3mybox1.size="15";
  a3mybox1.type="text";
  a3mybox1.id="delivery-type/" +  index;
  a3mybox1.readonly = true;
  a3mybox1.style.border = 0;
  a3mybox1.style.background = "none";
  a3mybox1.style.cursor = "hand";
  var a3ba1 = document.createElement('td');
  a3ba1.appendChild(a3mybox1);

  var a3b1 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a3b1.appendChild(myspace2);



//for discounts

  a2mybox1=document.createElement("input");
  a2mybox1.size="20";
  a2mybox1.type="text";
  a2mybox1.id="discounts-type/" +  index;
  a2mybox1.readonly = true;
  a2mybox1.style.border = 0;
  a2mybox1.style.background = "none";
  a2mybox1.style.cursor = "hand";
  var a2ba1 = document.createElement('td');
  a2ba1.appendChild(a2mybox1);

  var a2b1 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a2b1.appendChild(myspace2);


<!-- First TD End -->




<!-- Second TD Start -->


//for po

  var cca1 = document.createElement('td');
  myselect1 = document.createElement("select");
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  if(a == "pr")
  {
    myselect1.style.width = "70px";
    myselect1.name = "prcode[]";
    myselect1.id = "prcode" + index;
    myselect1.onchange = function ()  {  seldescription(this.id,'pr'); };
  }
  else
  {
    myselect1.style.width = "80px";
    myselect1.name = "code[]";
    myselect1.id = "code" + index;
    myselect1.onchange = function ()  {  seldescription(this.id,''); };
  }
  var ca1 = document.createElement('td');
  ca1.appendChild(myselect1);
  var c2ca = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  c2ca.appendChild(myspace2);


//for taxes

  mybox1=document.createElement("input");
  mybox1.size="15";
  mybox1.type="text";
  mybox1.readonly = true;
  mybox1.style.border = 0;
  mybox1.style.background = "none";
  mybox1.style.cursor = "hand";
  mybox1.id = "tax-code" + index;
  var ba2 = document.createElement('td');
  ba2.appendChild(mybox1);

  var b2 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b2.appendChild(myspace2);


//for charges

  a1mybox1=document.createElement("input");
  a1mybox1.size="10";
  a1mybox1.type="text";
  a1mybox1.readonly = true;
  a1mybox1.style.border = 0;
  a1mybox1.style.background = "none";
  a1mybox1.style.cursor = "hand";
  a1mybox1.id = "charges-code" + index;
  var a1ba2 = document.createElement('td');
  a1ba2.appendChild(a1mybox1);

  var a1b2 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a1b2.appendChild(myspace2);


//for delivery

  a3mybox1=document.createElement("input");
  a3mybox1.size="10";
  a3mybox1.type="text";
  a3mybox1.readonly = true;
  a3mybox1.style.border = 0;
  a3mybox1.style.background = "none";
  a3mybox1.style.cursor = "hand";
  a3mybox1.id = "delivery-code" + index;
  var a3ba2 = document.createElement('td');
  a3ba2.appendChild(a3mybox1);

  var a3b2 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a3b2.appendChild(myspace2);



//for discounts

  a2mybox1=document.createElement("input");
  a2mybox1.size="15";
  a2mybox1.type="text";
  a2mybox1.readonly = true;
  a2mybox1.style.border = 0;
  a2mybox1.style.background = "none";
  a2mybox1.style.cursor = "hand";
  a2mybox1.id = "discounts-code" + index;
  var a2ba2 = document.createElement('td');
  a2ba2.appendChild(a2mybox1);

  var a2b2 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a2b2.appendChild(myspace2);

<!-- Second TD End -->




<!-- Third TD Start -->

//for po



  myselect1 = document.createElement("select");
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  if(a == "pr")
  {
    myselect1.style.width = "140px";
    myselect1.name = "desc[]";
    myselect1.id = "prdescing" + index;
    myselect1.onchange = function ()  {  selcode(this.id,'pr'); };
  }
  else
  {
    myselect1.style.width = "140px";
    myselect1.name = "desc[]";
    myselect1.id = "descing" + index;
    myselect1.onchange = function ()  {  selcode(this.id,''); };
  }



  var cca2 = document.createElement('td');
  mybox1=document.createElement("input");
  mybox1.type="hidden";
  if(a == "pr")
  {
    mybox1.size="15";
    mybox1.name="prdescription[]";
    mybox1.id = "pring" + index;
  }
  else
  {
    mybox1.size="25";
    mybox1.name="description[]";
    mybox1.id = "ing" + index;
  }
  var c3ca = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  c3ca.appendChild(myspace2);


//for taxes

  mybox2=document.createElement("input");
  mybox2.size="25";
  mybox2.type="text";
  mybox2.id = "tax-ing" + index;
  mybox2.readonly = true;
  mybox2.style.border = 0;
  mybox2.style.background = "none";
  mybox2.style.cursor = "hand";
  var ba3 = document.createElement('td');
  ba3.appendChild(mybox2);

  var b3 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b3.appendChild(myspace2);


//for charges

  a1mybox2=document.createElement("input");
  a1mybox2.size="10";
  a1mybox2.type="text";
  a1mybox2.id = "charges-ing" + index;
  a1mybox2.readonly = true;
  a1mybox2.style.border = 0;
  a1mybox2.style.background = "none";
  a1mybox2.style.cursor = "hand";
  var a1ba3 = document.createElement('td');
  a1ba3.appendChild(a1mybox2);

  var a1b3 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a1b3.appendChild(myspace2);


//for delivery

  a3mybox2=document.createElement("input");
  a3mybox2.size="10";
  a3mybox2.type="text";
  a3mybox2.id = "delivery-ing" + index;
  a3mybox2.readonly = true;
  a3mybox2.style.border = 0;
  a3mybox2.style.background = "none";
  a3mybox2.style.cursor = "hand";
  var a3ba3 = document.createElement('td');
  a3ba3.appendChild(a3mybox2);

  var a3b3 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a3b3.appendChild(myspace2);



//for discounts

  a2mybox2=document.createElement("input");
  a2mybox2.size="25";
  a2mybox2.type="text";
  a2mybox2.id = "discounts-ing" + index;
  a2mybox2.readonly = true;
  a2mybox2.style.border = 0;
  a2mybox2.style.background = "none";
  a2mybox2.style.cursor = "hand";
  var a2ba3 = document.createElement('td');
  a2ba3.appendChild(a2mybox2);

  var a2b3 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a2b3.appendChild(myspace2);


<!-- Third TD End -->



<!-- For PR Start-->


if(a == "pr")
{
  myselect1 = document.createElement("select");
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.style.width = "90px";
  myselect1.name = "prnum[]";
  myselect1.id = "prnum" + index;
  myselect1.onchange = function ()  {  prdetails(this.id); };
  var ca19 = document.createElement('td');
  ca19.appendChild(myselect1);
  var c29ca = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  c29ca.appendChild(myspace2);
}



<!-- For PR End -->


<!-- Fourth TD Start -->

//for po

  var ca4 = document.createElement('td');
  ca4.appendChild(myselect1);
  ca4.appendChild(mybox1);
  mybox1=document.createElement("input");
  mybox1.type="text";
  if(a == "pr")
  {
    mybox1.size="8";
    mybox1.name="prquantity[]";
    mybox1.id = "pringweight" + index;
  }
  else
  {
    mybox1.size="8";
    mybox1.name="quantity[]";
    mybox1.id = "ingweight" + index;
  }
  if(a != "pr")
  mybox1.onfocus = function ()  {  makeForm(a); };
  mybox1.onkeyup = function ()  {  getvalues(this.id); };
  mybox1.onblur = function ()  {  getvalues(this.id); };



//for taxes

  mybox2=document.createElement("input");
  mybox2.size="8";
  mybox2.type="text";
  mybox2.readonly = true;
  mybox2.style.border = 0;
  mybox2.style.background = "none";
  mybox2.style.cursor = "hand";
  mybox2.id = "tax-ingweight" + index;
  var ba4 = document.createElement('td');
  ba4.appendChild(mybox2);

  var b4 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b4.appendChild(myspace2);


//for charges

  a1mybox2=document.createElement("input");
  a1mybox2.size="8";
  a1mybox2.type="text";
  a1mybox2.readonly = true;
  a1mybox2.style.border = 0;
  a1mybox2.style.background = "none";
  a1mybox2.style.cursor = "hand";
  a1mybox2.id = "charges-ingweight" + index;
  var a1ba4 = document.createElement('td');
  a1ba4.appendChild(a1mybox2);

  var a1b4 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a1b4.appendChild(myspace2);

//for delivery

  a3mybox2=document.createElement("input");
  a3mybox2.size="8";
  a3mybox2.type="text";
  a3mybox2.readonly = true;
  a3mybox2.style.border = 0;
  a3mybox2.style.background = "none";
  a3mybox2.style.cursor = "hand";
  a3mybox2.id = "delivery-ingweight" + index;
  var a3ba4 = document.createElement('td');
  a3ba4.appendChild(a3mybox2);

  var a3b4 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a3b4.appendChild(myspace2);


//for discounts

  a2mybox2=document.createElement("input");
  a2mybox2.size="8";
  a2mybox2.type="text";
  a2mybox2.readonly = true;
  a2mybox2.style.border = 0;
  a2mybox2.style.background = "none";
  a2mybox2.style.cursor = "hand";
  a2mybox2.id = "discounts-ingweight" + index;
  var a2ba4 = document.createElement('td');
  a2ba4.appendChild(a2mybox2);

  var a2b4 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a2b4.appendChild(myspace2);

<!-- Fourth TD End -->



<!-- Fifth TD Start -->

//for po

  var ca5 = document.createElement('td');
  ca5.appendChild(mybox1);
  mybox1=document.createElement("input");
  mybox1.type="text";
  if(a == "pr")
  {
    mybox1.size="8";
    mybox1.name="prunits[]";
    mybox1.id = "prmunit" + index;
  }
  else
  {
    mybox1.size="8";
    mybox1.name="units[]";
    mybox1.id = "munit" + index;
  }
  mybox1.readonly = true;
  var c4ca = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  c4ca.appendChild(myspace2);

//for taxes

  mybox2=document.createElement("input");
  mybox2.size="8";
  mybox2.type="text";
  mybox2.id = "tax-munit" + index;
  mybox2.readonly = true;
  mybox2.style.border = 0;
  mybox2.style.background = "none";
  mybox2.style.cursor = "hand";
  var ba5 = document.createElement('td');
  ba5.appendChild(mybox2);

  var b5 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b5.appendChild(myspace2);

//for charges

  a1mybox2=document.createElement("input");
  a1mybox2.size="8";
  a1mybox2.type="text";
  a1mybox2.id = "charges-munit" + index;
  a1mybox2.readonly = true;
  a1mybox2.style.border = 0;
  a1mybox2.style.background = "none";
  a1mybox2.style.cursor = "hand";
  var a1ba5 = document.createElement('td');
  a1ba5.appendChild(a1mybox2);

  var a1b5 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a1b5.appendChild(myspace2);

//for delivery

  a3mybox2=document.createElement("input");
  a3mybox2.size="8";
  a3mybox2.type="text";
  a3mybox2.id = "delivery-munit" + index;
  a3mybox2.readonly = true;
  a3mybox2.style.border = 0;
  a3mybox2.style.background = "none";
  a3mybox2.style.cursor = "hand";
  var a3ba5 = document.createElement('td');
  a3ba5.appendChild(a3mybox2);

  var a3b5 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a3b5.appendChild(myspace2);


//for discounts

  a2mybox2=document.createElement("input");
  a2mybox2.size="8";
  a2mybox2.type="text";
  a2mybox2.id = "discounts-munit" + index;
  a2mybox2.readonly = true;
  a2mybox2.style.border = 0;
  a2mybox2.style.background = "none";
  a2mybox2.style.cursor = "hand";
  var a2ba5 = document.createElement('td');
  a2ba5.appendChild(a2mybox2);

  var a2b5 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a2b5.appendChild(myspace2);


<!-- Fifth TD End -->


<!-- Sixth TD Start -->

//for po

  var ca8 = document.createElement('td');
  ca8.appendChild(mybox1);
  mybox1=document.createElement("input");
  mybox1.type="text";
  if(a == "pr")
  {
     mybox1.size="7";
     mybox1.name="prrate[]"; 
     mybox1.id = "prunit" + index;
     mybox1.onfocus = function ()  {  makeForm(a); };
  }
  else
  {
     mybox1.size="8";
     mybox1.name="rate[]"; 
     mybox1.id = "unit" + index;
  }
  //mybox1.onkeyup = function ()  {  getvalues(this.id); };
  var c5ca = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  c5ca.appendChild(myspace2);

//for taxes


  myselect1 = document.createElement("select");
  myselect1.style.width = "80px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  theOption1.value = "0@0@0@0";
  myselect1.appendChild(theOption1);
  myselect1.name = "tax[]";
  myselect1.id = "tax" + index;
  <?php
           include "config.php"; 
           $query = "SELECT * FROM ims_taxcodes where type = 'Tax' and taxflag = 'P' ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['code']; ?>");
		theOption.appendChild(theText);
            theOption.title = "<?php echo $row1['description']; ?>";
		theOption.value = "<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['formula']."@".$row1['rule']; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>



  var ba6 = document.createElement('td');
  ba6.appendChild(myselect1);

 
  var b6 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b6.appendChild(myspace2);

//for charges

  myselect1 = document.createElement("select");
  myselect1.style.width = "60px";
  
  myselect1.name = "frtype[]";
  myselect1.id = "frtype" + index;
  
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('Included');
  theOption1.value="included";
  theOption.title = "";
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  
  theOption=document.createElement("OPTION");
  theText=document.createTextNode("Excluded");
  theOption.appendChild(theText);
  theOption.title = "excluded";
  theOption.value = "excluded";

  myselect1.appendChild(theOption);
		
  var a1ba62 = document.createElement('td');
  a1ba62.appendChild(myselect1);
  var a1b62 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a1b62.appendChild(myspace2);

  myselect1 = document.createElement("input");
  myselect1.type='text';
  myselect1.size='10';
  myselect1.name='framt[]';
  myselect1.id = "framt" + index;
  
  var a1ba63 = document.createElement('td');
  a1ba63.appendChild(myselect1);
  var a1b63 = document.createElement('td');
  myspace3= document.createTextNode('\u00a0');
  a1b63.appendChild(myspace2);


 


  myselect1 = document.createElement("select");
  myselect1.style.width = "60px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.value="";
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "frcoa[]";
  myselect1.id = "frcoa" + index;

  <?php
           
           $query = "select distinct(code),description from ac_coa where (controltype = '' or controltype is NULL) and type = 'Expense' and schedule = 'INDIRECT EXPENSES' and code not like 'CG%' and code not like  'PV%' and code not like  'PR%' and code not like 'WP%' order by code ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['code']; ?>");
		theOption.appendChild(theText);
        theOption.title = "<?php echo $row1['description']; ?>";
		theOption.value = "<?php echo $row1['code']?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>


  var a1ba6 = document.createElement('td');
  a1ba6.appendChild(myselect1);
  var a1b6 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a1b6.appendChild(myspace2);

//for delivery

  myselect1 = document.createElement("select");
  myselect1.style.width = "80px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
   theOption1.value="";
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "doffice[]";
  myselect1.id = "doffice/" + index;
  myselect1.onchange = function ()  {  getemp(this.id); };

  <?php
           include "config.php"; 
           $query = "SELECT * FROM tbl_sector ORDER BY sector ASC";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['sector']; ?>");
		theOption.appendChild(theText);
		theOption.value = "<?php echo $row1['sector']; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>


  var a3ba6 = document.createElement('td');
  a3ba6.appendChild(myselect1);
  var a3b6 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a3b6.appendChild(myspace2);


//for flock

  myselect1 = document.createElement("select");
  myselect1.style.width = "80px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
   theOption1.value="";
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "flock[]";
  myselect1.id = "flock/" + index;
  myselect1.onchange = function ()  {  getemp(this.id); };

  <?php
           $query = "SELECT distinct(flkmain) From breeder_flock where cullflag=0 ORDER BY flkmain";
           $result = mysql_query($query,$conn);  
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1[flkmain]; ?>");
		theOption.appendChild(theText);
		theOption.value = "<?php echo $row1[flkmain]; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>


  var a3ba62 = document.createElement('td');
  a3ba62.appendChild(myselect1);
  var a3b62 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a3b62.appendChild(myspace2);

//for discounts


  myselect1 = document.createElement("select");
  myselect1.style.width = "80px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.value ="0@0@0@0";
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "discount[]";
  myselect1.id = "disc" + index;


  <?php
           include "config.php"; 
           $query = "SELECT * FROM ims_taxcodes where type = 'Discount' and taxflag = 'P' ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['code']; ?>");
		theOption.appendChild(theText);
            theOption.title = "<?php echo $row1['description']; ?>";
		theOption.value = "<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['formula']."@".$row1['rule']; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>

  var a2ba6 = document.createElement('td');
  a2ba6.appendChild(myselect1);

 
  var a2b6 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a2b6.appendChild(myspace2);

<!-- Sixth TD End -->



<!-- Seventh TD Start -->

//for po

  var ca6 = document.createElement('td');
  ca6.appendChild(mybox1);
  if(a == "pr")
  {
    ca6.align="left";
  }
  mybox=document.createElement("input");
  mybox.type="text";
  if(a == "pr")
  {
    mybox.size="11"; 
    mybox.name="prrdate[]";
    mybox.id = "prrdate" + index;
  }
  else
  {
    mybox.size="15"; 
    mybox.name="rdate[]";
    mybox.id = "rdate" + index;
  }
  var c = "datepicker" + index;
  mybox.value="<?php echo date("d.m.Y"); ?>";
  mybox.setAttribute("class",c);
  var c6ca = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  c6ca.appendChild(myspace2);
  var ca7 = document.createElement('td');
  ca7.appendChild(mybox);
  if(a == "pr")
  {
    ca7.align="left";
  }
  var cca5 = document.createElement('td');


//for charges

  myselect1 = document.createElement("select");
  myselect1.style.width = "80px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  theOption1.value = "0@0@0@0";
  myselect1.appendChild(theOption1);
  myselect1.name = "brokerage[]";
  myselect1.id = "brok" + index;

  <?php
           include "config.php"; 
           $query = "SELECT * FROM ims_taxcodes where type = 'Charges' and ctype = 'Brokerage' and taxflag = 'P' ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php echo $row1['code']; ?>");
		theOption.appendChild(theText);
            theOption.title = "<?php echo $row1['description']; ?>";
		theOption.value = "<?php echo $row1['code']."@".$row1['codevalue']."@".$row1['formula']."@".$row1['rule']; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>

  var a1ba7 = document.createElement('td');
  a1ba7.appendChild(myselect1);
  var a1b7 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a1b7.appendChild(myspace2);


//for delivery

  myselect1 = document.createElement("select");
  myselect1.style.width = "80px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  theOption1.value = "";
  myselect1.appendChild(theOption1);
  myselect1.name = "demp[]";
  myselect1.id = "demp" + index;

  var a3ba7 = document.createElement('td');
  a3ba7.appendChild(myselect1);
  var a3b7 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  a3b7.appendChild(myspace2);



<!-- Seventh TD End -->

      r.appendChild(ca);
      r.appendChild(c1ca);
      r.appendChild(ca1);
      r.appendChild(c2ca);
      r.appendChild(ca4);
      r.appendChild(c3ca);
      if(a == "pr")
      {
      r.appendChild(ca19);
      r.appendChild(c29ca); 
      } 
      r.appendChild(ca5);
      r.appendChild(c4ca);
      r.appendChild(ca8);
      r.appendChild(c5ca);
      r.appendChild(ca6);
      r.appendChild(c6ca);
 	r.appendChild(ca7);
      t1.appendChild(r);

      r1.appendChild(ba1);
      r1.appendChild(b1);
      r1.appendChild(ba2);
      r1.appendChild(b2);
      r1.appendChild(ba3);
      r1.appendChild(b3);
      r1.appendChild(ba4);
      r1.appendChild(b4);
      r1.appendChild(ba5);
      r1.appendChild(b5);
      r1.appendChild(ba6);
      r1.appendChild(b6);
      t2.appendChild(r1);

      r2.appendChild(a1ba1);
      r2.appendChild(a1b1);
      r2.appendChild(a1ba2);
      r2.appendChild(a1b2);
      r2.appendChild(a1ba3);
      r2.appendChild(a1b3);
      r2.appendChild(a1ba4);
      r2.appendChild(a1b4);
      r2.appendChild(a1ba5);
      r2.appendChild(a1b5);
	  r2.appendChild(a1ba62);
      r2.appendChild(a1b62);
	  r2.appendChild(a1ba63);
      r2.appendChild(a1b63);
      r2.appendChild(a1ba6);
      r2.appendChild(a1b6);
      r2.appendChild(a1ba7);
      r2.appendChild(a1b7);
      t3.appendChild(r2);

      r3.appendChild(a2ba1);
      r3.appendChild(a2b1);
      r3.appendChild(a2ba2);
      r3.appendChild(a2b2);
      r3.appendChild(a2ba3);
      r3.appendChild(a2b3);
      r3.appendChild(a2ba4);
      r3.appendChild(a2b4);
      r3.appendChild(a2ba5);
      r3.appendChild(a2b5);
      r3.appendChild(a2ba6);
      r3.appendChild(a2b6);
      t4.appendChild(r3);

      r4.appendChild(a3ba1);
      r4.appendChild(a3b1);
      r4.appendChild(a3ba2);
      r4.appendChild(a3b2);
      r4.appendChild(a3ba3);
      r4.appendChild(a3b3);
      r4.appendChild(a3ba4);
      r4.appendChild(a3b4);
      r4.appendChild(a3ba5);
      r4.appendChild(a3b5);
      r4.appendChild(a3ba6);
      r4.appendChild(a3b6);
	  r4.appendChild(a3ba62);
      r4.appendChild(a3b62);
      r4.appendChild(a3ba7);
      r4.appendChild(a3b7);
      t5.appendChild(r4);



  $(function() {
	$( "." + c ).datepicker();
  });


//alert(document.getElementById("rdate0").getAttribute("class"));
}




///Loading Codes 
function fun(b,f) 
{

  var second = b.split('/');
  var comp = second[1];
  if(comp >= 0){ var a = comp; } else { var a = ""; }

 if(f == "pr")
  removeAllOptions(document.getElementById("prnum" + a));

  document.getElementById(f + 'ing'+ a).value = "";
  document.getElementById(f + 'ingweight'+ a).value = "";
  document.getElementById(f + 'munit'+ a).value = "";
  document.getElementById(f + 'unit'+ a).value = "";

  document.getElementById('tax-code'+ a).value = "";
  document.getElementById('tax-ing'+ a).value = "";
  document.getElementById('tax-ingweight'+ a).value = "";
  document.getElementById('tax-munit'+ a).value = "";

  document.getElementById('charges-code'+ a).value = "";
  document.getElementById('charges-ing'+ a).value = "";
  document.getElementById('charges-ingweight'+ a).value = "";
  document.getElementById('charges-munit'+ a).value = "";


  document.getElementById('delivery-code'+ a).value = "";
  document.getElementById('delivery-ing'+ a).value = "";
  document.getElementById('delivery-ingweight'+ a).value = "";
  document.getElementById('delivery-munit'+ a).value = "";

  document.getElementById('discounts-code'+ a).value = "";
  document.getElementById('discounts-ing'+ a).value = "";
  document.getElementById('discounts-ingweight'+ a).value = "";
  document.getElementById('discounts-munit'+ a).value = "";

  removeAllOptions(document.getElementById(f + "code" + a));
  myselect1 = document.getElementById(f + "code" + a);
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode("-Select-");
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
			  
 
  removeAllOptions(document.getElementById(f + "descing" + a));
  myselect2 = document.getElementById(f + "descing" + a);
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode("-Select-");
  theOption1.appendChild(theText1);
  myselect2.appendChild(theOption1);
 

  if ( a == "")  {   }  else { a = "/" + a; }


   <?php

      $q2=mysql_query("select distinct(cat) from ims_itemcodes order by code ASC");
      while($nt2=mysql_fetch_array($q2)){
      echo mysql_num_rows($nt2);
      echo "if(document.getElementById(f + 'type'+ a).value == '$nt2[cat]'){";
      $q3=mysql_query("select * from ims_itemcodes where cat ='$nt2[cat]' and (source = 'Purchased' or source = 'Produced or Purchased') order by code ASC");
      while($nt3=mysql_fetch_array($q3))
	 { 
   ?>
 
       theOption1=document.createElement("OPTION");
       theText1=document.createTextNode("<?php echo $nt3['code']; ?>");
	 theOption1.value = "<?php echo $nt3['code']; ?>";
       theOption1.appendChild(theText1);
       myselect1.appendChild(theOption1);

     
       theOption1=document.createElement("OPTION");
       theText1=document.createTextNode("<?php echo $nt3['description']; ?>");
	 theOption1.value = "<?php echo $nt3['code']; ?>";
	 theOption1.title = "<?php echo $nt3['description']; ?>";
       theOption1.appendChild(theText1);
       myselect2.appendChild(theOption1);		
 
			 
   <?php   } echo "}"; }  ?>

 getvalues(b);
}
///End of Loading Codes










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
   include "config.php"; 
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













///Filling Description from code ///////
function description(b,f)
{



 var y = b.substr(0,6);
 var x = b.substr(0,4);
 if(y == "prcode" || x == "code")
 {
  if(f == "pr")
    a = b.substr(6);
  else
    a = b.substr(4);
 if(f == "pr")
  removeAllOptions(document.getElementById("prnum" + a));

  document.getElementById(f + 'ing'+ a).value = "";
  document.getElementById(f + 'ingweight'+ a).value = "";
  document.getElementById(f + 'munit'+ a).value = "";
  document.getElementById(f + 'unit'+ a).value = "";

  document.getElementById('tax-code'+ a).value = "";
  document.getElementById('tax-ing'+ a).value = "";
  document.getElementById('tax-ingweight'+ a).value = "";
  document.getElementById('tax-munit'+ a).value = "";

  document.getElementById('charges-code'+ a).value = "";
  document.getElementById('charges-ing'+ a).value = "";
  document.getElementById('charges-ingweight'+ a).value = "";
  document.getElementById('charges-munit'+ a).value = "";


  document.getElementById('delivery-code'+ a).value = "";
  document.getElementById('delivery-ing'+ a).value = "";
  document.getElementById('delivery-ingweight'+ a).value = "";
  document.getElementById('delivery-munit'+ a).value = "";

  document.getElementById('discounts-code'+ a).value = "";
  document.getElementById('discounts-ing'+ a).value = "";
  document.getElementById('discounts-ingweight'+ a).value = "";
  document.getElementById('discounts-munit'+ a).value = "";
}






   if(index == -1) { var a = ""; var j = 0; } else { var a = index;  var j = index;   }
   var i1,j1;
//alert(f);
if(f != "pr")
{
}
else
{
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
			if(document.getElementById(f + 'code' + i1).value == document.getElementById(f + 'code' + j1).value)
			{
				document.getElementById(f + 'ing' + a).value = "";
				alert("Please select different combination");
				return;
			}
		}
	}
   }
}
 



  for ( var i = -1;i<=index;i++)
   {
     if ( i == -1)
      var j = "";
     else
	var j = i;
	






   <?php
 	 $q = "select * from ims_itemcodes order by code";
	 $qrs = mysql_query($q) or die(mysql_error());
 	 while($qr = mysql_fetch_assoc($qrs))
	 { 
		echo "if(document.getElementById(f + 'code' + j).value == '$qr[code]') { ";
   ?>
	
   
	
            document.getElementById(f + 'ing' + j).value = "<?php echo $qr['description']; ?>";
 	      document.getElementById(f + 'munit' + j).value = "<?php echo $qr['sunits']; ?>";
		
    <?php echo " } "; }?>








		

if(f == "pr")
{
 var y = b.substr(0,6);
 if(y == "prcode")
 {
  a = b.substr(6);
  //alert(a);



  removeAllOptions(document.getElementById("prnum" + a));
  myselect1 = document.getElementById("prnum" + a);
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode("-Select-");
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);


   <?php
 	 $q = "select * from pp_purchaseindent where approve = 0 order by icode";
	 $qrs = mysql_query($q) or die(mysql_error());
 	 while($qr = mysql_fetch_assoc($qrs))
	 { 
		echo "if(document.getElementById('prcode' + a).value == '$qr[icode]') { ";
   ?>
	
   
	
       theOption1=document.createElement("OPTION");
       theText1=document.createTextNode("<?php echo $qr['pi']; ?>");
	 theOption1.value = "<?php echo $qr['pi']; ?>";
       theOption1.appendChild(theText1);
       myselect1.appendChild(theOption1);

		
    <?php echo " } "; }?>
  }

}


   }

getvalues(b);
}
///End Of Description from code /////






function getvalues(b)
{
 var f = b.substr(0,2);
 if(f == "pr") { b = b.substr(2); c = f + b; d = "pr"; } else { c = b; d = "";}
 var type = b.substr(0,4);
 var num = b.substr(4);
 document.getElementById("tax-" + b).value = document.getElementById(c).value;
 document.getElementById("charges-" + b).value = document.getElementById(c).value;
 document.getElementById("delivery-" + b).value = document.getElementById(c).value;
 document.getElementById("discounts-" + b).value = document.getElementById(c).value;

 if(type == "code")
 {
  document.getElementById("tax-ing" + num).value = document.getElementById(d + "ing" + num).value;
  document.getElementById("tax-munit" + num).value = document.getElementById(d + "munit" + num).value;

  document.getElementById("charges-ing" + num).value = document.getElementById(d + "ing" + num).value;
  document.getElementById("charges-ing" + num).title = document.getElementById(d + "ing" + num).value;
  document.getElementById("charges-munit" + num).value = document.getElementById(d + "munit" + num).value;

  document.getElementById("delivery-ing" + num).value = document.getElementById(d + "ing" + num).value;
  document.getElementById("delivery-ing" + num).title = document.getElementById(d + "ing" + num).value;
  document.getElementById("delivery-munit" + num).value = document.getElementById(d + "munit" + num).value;

  document.getElementById("discounts-ing" + num).value = document.getElementById(d + "ing" + num).value;
  document.getElementById("discounts-munit" + num).value = document.getElementById(d + "munit" + num).value;


 if(f == "pr")
 {

   <?php
 	 $q = "select * from pp_purchaseindent where approve = 0 order by icode";
	 $qrs = mysql_query($q) or die(mysql_error());
 	 while($qr = mysql_fetch_assoc($qrs))
	 { 
		echo "if(document.getElementById('prcode' + num).value == '$qr[icode]') { ";
   ?>
	
    if(num == "")
     document.getElementById("doffice" + num).value = "<?php echo $qr['doffice']; ?>";
    else
     document.getElementById("doffice/" + num).value = "<?php echo $qr['doffice']; ?>";
   
     getemp("doffice/" + num)
     document.getElementById("demp" + num).value = "<?php echo $qr['receiver']; ?>";


		
    <?php echo " } "; }?>
  }
 }
}










function prdetails(b)
{
   if(index == -1) { var a = ""; var j = 0; } else { var a = index;  var j = index;   }
   var i1,j1;
   for ( var i = -1;i<=index;i++)
   {
     if ( i == -1)
      var j = "";
     else
	var j = i;
    <?php
 	 $q = "select * from pp_purchaseindent where approve = 0 order by icode";
	 $qrs = mysql_query($q) or die(mysql_error());
 	 while($qr = mysql_fetch_assoc($qrs))
	 { 
		echo "if(document.getElementById('prnum' + j).value == '$qr[pi]') { ";
    ?>
	
            document.getElementById('pringweight' + j).value = "<?php echo $qr['quantity']; ?>";
            document.getElementById('prrdate' + j).value = "<?php echo $qr['rdate']; ?>";

            document.getElementById('tax-ingweight' + j).value = "<?php echo $qr['quantity']; ?>";
            document.getElementById('discounts-ingweight' + j).value = "<?php echo $qr['quantity']; ?>";
            document.getElementById('charges-ingweight' + j).value = "<?php echo $qr['quantity']; ?>";
            document.getElementById('delivery-ingweight' + j).value = "<?php echo $qr['quantity']; ?>";
		
    <?php echo " } "; }?>
   }
}








function getemp(b)
{
var second = b.split('/');
var comp = second[1];
if(comp >= 0){
var a = comp;
}
else {
var a = "";
}

removeAllOptions(document.getElementById("demp" + a));
			 myselect1 = document.getElementById("demp" + a);
              theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
              theOption1.appendChild(theText1);
               myselect1.appendChild(theOption1);
			   
			   if ( a == "")
			  {
			  
			   }
			  else
			  {
			   a = "/" + a;
			  }
 <?php
     $q2=mysql_query("select distinct(sector) from employee ORDER BY sector ASC ");
     while($nt2=mysql_fetch_array($q2)){
     echo "if(document.getElementById('doffice'+a).value == '$nt2[sector]'){";
     $q3=mysql_query("select distinct(name) from employee where sector='$nt2[sector]' ORDER BY name ASC ");
	  
     while($nt3=mysql_fetch_array($q3))
	 { ?>
             //echo "document.getElementById('place').value = '$nt3[place]';";
			 

              theOption1=document.createElement("OPTION");
			  theText1=document.createTextNode("<?php echo $nt3['name']; ?>");
			  theOption1.value = "<?php echo $nt3['name']; ?>";
			  theOption1.title = "<?php echo $nt3['name']; ?>";
			  theOption1.appendChild(theText1);
			  myselect1.appendChild(theOption1);

    <?php   } // end of while loop
      echo "}"; // end of JS if condition
     }
  ?>
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

function calculate(a)
{
 if(index == -1)
 {
   if(document.getElementById("type").value != "")
   {

     <!-- Tax Start -->

       var a1 = document.getElementById("tax").value;
       a1 = a1.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a1[1]);
       <?php } ?>
       var formula = a1[2];
       var A = parseFloat(document.getElementById("ingweight").value * document.getElementById("unit").value);
       var withtax = eval(formula);
       document.getElementById("taxamount").value = withtax;

     <!-- Freight Start -->

      /* var a2 = document.getElementById("frght").value;
       a2 = a2.split('@');
       <?php
          // include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
          // $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a2[1]);
       <?php } ?>
       var formula2 = a2[2];
       var withfreight = eval(formula2);
       document.getElementById("freightamount").value = withfreight;*/

     <!-- Brokerage Start -->

       var a3 = document.getElementById("brok").value;
       a3 = a3.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a3[1]);
       <?php } ?>
       var formula3 = a3[2];
       var withbrokerage = eval(formula3);
       document.getElementById("brokerageamount").value = withbrokerage;

     <!-- discount Start -->

       var a4 = document.getElementById("disc").value;
       a4 = a4.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a4[1]);
       <?php } ?>
       var formula4 = a4[2];
       var withdiscount = eval(formula4);
       document.getElementById("discountamount").value = withdiscount;

   }
 }
 else
 {
  for(var k = 0;k<=index;k++)
  { 

   if(document.getElementById("type").value != "")
   {

     <!-- Tax Start -->

       var a1 = document.getElementById("tax").value;
       a1 = a1.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a1[1]);
       <?php } ?>
       var formula = a1[2];
       var A = parseFloat(document.getElementById("ingweight").value * document.getElementById("unit").value);
       var withtax = eval(formula);
       document.getElementById("taxamount").value = withtax;


     <!-- Freight Start -->

     /*  var a2 = document.getElementById("frght").value;
       a2 = a2.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
          // $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a2[1]);
       <?php } ?>
       var formula2 = a2[2];
       var withfreight = eval(formula2);
       document.getElementById("freightamount").value = withfreight;*/

     <!-- Brokerage Start -->

       var a3 = document.getElementById("brok").value;
       a3 = a3.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a3[1]);
       <?php } ?>
       var formula3 = a3[2];
       var withbrokerage = eval(formula3);
       document.getElementById("brokerageamount").value = withbrokerage;

     <!-- Discount Start -->

       var a4 = document.getElementById("disc").value;
       a4 = a4.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a4[1]);
       <?php } ?>
       var formula4 = a4[2];
       var withdiscount = eval(formula4);
       document.getElementById("discountamount").value = withdiscount;


   }

   if(document.getElementById("type/" + k).value != "")
   {

     <!-- Tax Start -->

       var a1 = document.getElementById("tax" + k).value;
       //alert(a1);
       a1 = a1.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a1[1]);
       <?php } ?>
       var formula = a1[2];
       var A = parseFloat(document.getElementById("ingweight" + k).value * document.getElementById("unit" + k).value);
       var withtax = eval(formula);
       document.getElementById("taxamount" + k).value = withtax;


     <!-- Freight Start -->

       var a2 = document.getElementById("frght" + k).value;
       a2 = a2.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a2[1]);
       <?php } ?>
       var formula2 = a2[2];
       var withfreight = eval(formula2);
       document.getElementById("freightamount" + k).value = withfreight;

     <!-- Brokerage Start -->

       var a3 = document.getElementById("brok" + k).value;
       a3 = a3.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a3[1]);
       <?php } ?>
       var formula3 = a3[2];
       var withbrokerage = eval(formula3);
       document.getElementById("brokerageamount" + k).value = withbrokerage;

     <!-- Discount Start -->

       var a4 = document.getElementById("disc" + k).value;
       a4 = a4.split('@');
       <?php
           include "config.php";  
           $query = "SELECT * FROM ims_taxcodes ORDER BY code DESC ";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {
       ?>
              var <?php echo $row1['code']; ?> = parseFloat(a4[1]);
       <?php } ?>
       var formula4 = a4[2];
       var withdiscount = eval(formula4);
       document.getElementById("discountamount" + k).value = withdiscount;


   }
  }
 }

if((document.getElementById("type").value != "") && (document.getElementById("doffice").value == ""))
 {
 alert("Please select appropriate Delivery Location in Delivery Details section");
 return false;
 }
 else
 {
  for(var k = 0;k<=index;k++)
  {
  if((document.getElementById("type/"+k).value != "") && (document.getElementById("doffice/"+k).value == ""))
  {
   alert("Please select appropriate Delivery Location in Delivery Details section");
   return false;
  }
  }
 }

if(confirm('Are u sure you want to save the entry'))
{
  return true;
}
else
{
  return false; 
}
}




///Filling Description from code ///////
function seldescription(b,f)
{

 var y = b.substr(0,6);
 var x = b.substr(0,4);
 if(y == "prcode" || x == "code")
 {
  if(f == "pr")
    a = b.substr(6);
  else
    a = b.substr(4);
 if(f == "pr")
  removeAllOptions(document.getElementById("prnum" + a));

  document.getElementById(f + 'ing'+ a).value = "";
  document.getElementById(f + 'descing'+ a).value = "";
  document.getElementById(f + 'ingweight'+ a).value = "";
  document.getElementById(f + 'munit'+ a).value = "";
  document.getElementById(f + 'unit'+ a).value = "";

  document.getElementById('tax-code'+ a).value = "";
  document.getElementById('tax-ing'+ a).value = "";
  document.getElementById('tax-ingweight'+ a).value = "";
  document.getElementById('tax-munit'+ a).value = "";

  document.getElementById('charges-code'+ a).value = "";
  document.getElementById('charges-ing'+ a).value = "";
  document.getElementById('charges-ingweight'+ a).value = "";
  document.getElementById('charges-munit'+ a).value = "";


  document.getElementById('delivery-code'+ a).value = "";
  document.getElementById('delivery-ing'+ a).value = "";
  document.getElementById('delivery-ingweight'+ a).value = "";
  document.getElementById('delivery-munit'+ a).value = "";

  document.getElementById('discounts-code'+ a).value = "";
  document.getElementById('discounts-ing'+ a).value = "";
  document.getElementById('discounts-ingweight'+ a).value = "";
  document.getElementById('discounts-munit'+ a).value = "";
}






   if(index == -1) { var a = ""; var j = 0; } else { var a = index;  var j = index;   }
   var i1,j1;
//alert(f);
if(f != "pr")
{
}
else
{
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
			if(document.getElementById(f + 'code' + i1).value == document.getElementById(f + 'code' + j1).value)
			{
				document.getElementById(f + 'ing' + a).value = "";
				document.getElementById(f + 'descing' + a).value = "";
				alert("Please select different combination");
				return;
			}
		}
	}
   }
}
 
selectcode = ""; 
for(var i = -1; i <= index; i++)
{ 
 if(i==-1)
   i1 = "";
  else
   i1 = i;
 selectcode += document.getElementById('code'+i1).value+"@";
} 
document.getElementById('selcodes').value = selectcode;
document.getElementById('codevendor').value = selectcode+'#'+document.getElementById('vendor').value;

  for ( var i = -1;i<=index;i++)
   {
     if ( i == -1)
      var j = "";
     else
	var j = i;
	






   <?php
 	 $q = "select * from ims_itemcodes order by code";
	 $qrs = mysql_query($q) or die(mysql_error());
 	 while($qr = mysql_fetch_assoc($qrs))
	 { 
		echo "if(document.getElementById(f + 'code' + j).value == '$qr[code]') { ";
   ?>
	
   
	
            document.getElementById(f + 'ing' + j).value = "<?php echo $qr['description']; ?>";
            document.getElementById(f + 'descing' + j).value = "<?php echo $qr['code']; ?>";
 	      document.getElementById(f + 'munit' + j).value = "<?php echo $qr['sunits']; ?>";
		
    <?php echo " } "; }?>








		

if(f == "pr")
{
 var y = b.substr(0,6);
 if(y == "prcode")
 {
  a = b.substr(6);
  //alert(a);



  removeAllOptions(document.getElementById("prnum" + a));
  myselect1 = document.getElementById("prnum" + a);
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode("-Select-");
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);


   <?php
 	 $q = "select * from pp_purchaseindent where approve = 0 order by icode";
	 $qrs = mysql_query($q) or die(mysql_error());
 	 while($qr = mysql_fetch_assoc($qrs))
	 { 
		echo "if(document.getElementById('prcode' + a).value == '$qr[icode]') { ";
   ?>
	
   
	
       theOption1=document.createElement("OPTION");
       theText1=document.createTextNode("<?php echo $qr['pi']; ?>");
	 theOption1.value = "<?php echo $qr['pi']; ?>";
       theOption1.appendChild(theText1);
       myselect1.appendChild(theOption1);

		
    <?php echo " } "; }?>
  }

}


   }

getvalues(b);
}
///End Of Description from code /////




///Filling Code From Description ///////
function selcode(b,f)
{



 var y = b.substr(0,9);
 var x = b.substr(0,7);
 if(y == "prdescing" || x == "descing")
 {
  if(f == "pr")
    a = b.substr(9);
  else
    a = b.substr(7);
 if(f == "pr")
  removeAllOptions(document.getElementById("prnum" + a));

  document.getElementById(f + 'ing'+ a).value = "";
  document.getElementById(f + 'code'+ a).value = "";
  document.getElementById(f + 'ingweight'+ a).value = "";
  document.getElementById(f + 'munit'+ a).value = "";
  document.getElementById(f + 'unit'+ a).value = "";

  document.getElementById('tax-code'+ a).value = "";
  document.getElementById('tax-ing'+ a).value = "";
  document.getElementById('tax-ingweight'+ a).value = "";
  document.getElementById('tax-munit'+ a).value = "";

  document.getElementById('charges-code'+ a).value = "";
  document.getElementById('charges-ing'+ a).value = "";
  document.getElementById('charges-ingweight'+ a).value = "";
  document.getElementById('charges-munit'+ a).value = "";


  document.getElementById('delivery-code'+ a).value = "";
  document.getElementById('delivery-ing'+ a).value = "";
  document.getElementById('delivery-ingweight'+ a).value = "";
  document.getElementById('delivery-munit'+ a).value = "";

  document.getElementById('discounts-code'+ a).value = "";
  document.getElementById('discounts-ing'+ a).value = "";
  document.getElementById('discounts-ingweight'+ a).value = "";
  document.getElementById('discounts-munit'+ a).value = "";
}






   if(index == -1) { var a = ""; var j = 0; } else { var a = index;  var j = index;   }
   var i1,j1;
//alert(f);
if(f != "pr")
{
}
else
{
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
			if(document.getElementById(f + 'code' + i1).value == document.getElementById(f + 'code' + j1).value)
			{
				document.getElementById(f + 'ing' + a).value = "";
				document.getElementById(f + 'code' + a).value = "";
				alert("Please select different combination");
				return;
			}
		}
	}
   }
}
 
selectcode = ""; 
for(var i = -1; i <= index; i++)
{ 
 if(i==-1)
   i1 = "";
  else
   i1 = i;
 selectcode += document.getElementById('code'+i1).value+"@";
} 
document.getElementById('selcodes').value = selectcode;
document.getElementById('codevendor').value = selectcode+'#'+document.getElementById('vendor').value;

  for ( var i = -1;i<=index;i++)
   {
     if ( i == -1)
      var j = "";
     else
	var j = i;
	






   <?php
 	 $q = "select * from ims_itemcodes order by code";
	 $qrs = mysql_query($q) or die(mysql_error());
 	 while($qr = mysql_fetch_assoc($qrs))
	 { 
		echo "if(document.getElementById(f + 'descing' + j).value == '$qr[code]') { ";
   ?>
	
   
	
            document.getElementById(f + 'ing' + j).value = "<?php echo $qr['description']; ?>";
            document.getElementById(f + 'code' + j).value = "<?php echo $qr['code']; ?>";
 	      document.getElementById(f + 'munit' + j).value = "<?php echo $qr['sunits']; ?>";
		
    <?php echo " } "; }?>








		

if(f == "pr")
{
 var y = b.substr(0,6);
 if(y == "prcode")
 {
  a = b.substr(6);
  //alert(a);



  removeAllOptions(document.getElementById("prnum" + a));
  myselect1 = document.getElementById("prnum" + a);
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode("-Select-");
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);


   <?php
 	 $q = "select * from pp_purchaseindent where approve = 0 order by icode";
	 $qrs = mysql_query($q) or die(mysql_error());
 	 while($qr = mysql_fetch_assoc($qrs))
	 { 
		echo "if(document.getElementById('prcode' + a).value == '$qr[icode]') { ";
   ?>
	
   
	
       theOption1=document.createElement("OPTION");
       theText1=document.createTextNode("<?php echo $qr['pi']; ?>");
	 theOption1.value = "<?php echo $qr['pi']; ?>";
       theOption1.appendChild(theText1);
       myselect1.appendChild(theOption1);

		
    <?php echo " } "; }?>
  }

}


   }

getvaluesdesc(b);
}
///End Of Code From Description /////


function getvaluesdesc(b)
{
 var f = b.substr(0,2);
 if(f == "pr") { b = b.substr(2); c = f + b; d = "pr"; } else { c = b; d = "";}
 var type = b.substr(0,7);
 var num = b.substr(7);
 document.getElementById("tax-code" + num).value = document.getElementById(c).value;
 document.getElementById("charges-code" + num).value = document.getElementById(c).value;
 document.getElementById("delivery-code" + num).value = document.getElementById(c).value;
 document.getElementById("discounts-code" + num).value = document.getElementById(c).value;

 if(type == "descing")
 {
  document.getElementById("tax-ing" + num).value = document.getElementById(d + "ing" + num).value;
  document.getElementById("tax-munit" + num).value = document.getElementById(d + "munit" + num).value;

  document.getElementById("charges-ing" + num).value = document.getElementById(d + "ing" + num).value;
  document.getElementById("charges-munit" + num).value = document.getElementById(d + "munit" + num).value;

  document.getElementById("delivery-ing" + num).value = document.getElementById(d + "ing" + num).value;
  document.getElementById("delivery-munit" + num).value = document.getElementById(d + "munit" + num).value;

  document.getElementById("discounts-ing" + num).value = document.getElementById(d + "ing" + num).value;
  document.getElementById("discounts-munit" + num).value = document.getElementById(d + "munit" + num).value;


 if(f == "pr")
 {

   <?php
 	 $q = "select * from pp_purchaseindent where approve = 0 order by icode";
	 $qrs = mysql_query($q) or die(mysql_error());
 	 while($qr = mysql_fetch_assoc($qrs))
	 { 
		echo "if(document.getElementById('prcode' + num).value == '$qr[icode]') { ";
   ?>
	
    if(num == "")
     document.getElementById("doffice" + num).value = "<?php echo $qr['doffice']; ?>";
    else
     document.getElementById("doffice/" + num).value = "<?php echo $qr['doffice']; ?>";
   
     getemp("doffice/" + num)
     document.getElementById("demp" + num).value = "<?php echo $qr['receiver']; ?>";


		
    <?php echo " } "; }?>
  }
 }
}



</script>

<script type="text/javascript">
function script1() {
window.open('P2PHelp/help_addpurchaseorder.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=no');
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

