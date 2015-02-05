<?php $formtype = "Breeder"; ?>
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.7.1.custom.min.js"></script>
<script type="text/javascript" src="js/selectToUISlider.jQuery.js"></script>
<link rel="stylesheet" href="css/sunny/jquery-ui-1.8.7.custom.css" type="text/css" />
<link rel="Stylesheet" href="css/ui.slider.extras.css" type="text/css" />
<style type="text/css">
	.ui-slider {clear: both; }
</style>
<script type="text/javascript">
	$(function(){
		var abc = $('select#speed').selectToUISlider().next();
		fixToolTipColor();
	});

	function fixToolTipColor(){
		$('.ui-tooltip-pointer-down-inner').each(function(){
			var bWidth = $('.ui-tooltip-pointer-down-inner').css('borderTopWidth');
			var bColor = $(this).parents('.ui-slider-tooltip').css('backgroundColor')
			$(this).css('border-top', bWidth+' solid '+bColor);
		});	
	}
</script>

<script type="text/javascript"> 
function addItemToUsersList(a)
{ 
var check = 0;
 if(a == "feed")
 {
   var a = "feed";
   var a1 = document.getElementById("fdate").value;
   var a2 = document.getElementById("tdate").value;
   var a3 = document.getElementById("fcost").value;
   var a4 = document.getElementById("ccost").value;
   var a5 = document.getElementById("mcost").value;
   var a6 = document.getElementById("ocost").value;
   var a7 = 0;
   
   <?php 
   
   $query1 = "SELECT * from broiler_growingcharges where flag = 'F' ";
   $result1 = mysql_query($query1) ;
   while($qr = mysql_fetch_assoc($result1))
   { 
   
   ?>
   
   <?php
   $fromd = date("d.m.Y",strtotime($qr['fromdate']));
   $tod = date("d.m.Y",strtotime($qr['todate'])); ?>
   
   <?php
	 echo "if(((a1 <= '$tod') && (a1 >= '$fromd')) || ((a2 <= '$tod') && (a2 >= '$fromd'))) {"; 
	 ?>
	 alert("Already Entered for this date span");
	 check = 1;
	 <?php
     echo "}";
   }		 
   
?>
   
}

 if(a == "growing")
 {
   var a = "growing";
   var a1 = document.getElementById("gc_fdate").value;
   var a2 = document.getElementById("gc_tdate").value;
   var a3 = document.getElementById("fcrfrom").value;
   var a4 = document.getElementById("fcrto").value;
   var a5 = document.getElementById("growingcharge").value;
   var a6 = 0;
   var a7 = 0;
   
   <?php 
   
   $query1 = "SELECT * from broiler_growingcharges where flag = 'G' ";
   $result1 = mysql_query($query1) ;
   while($qr = mysql_fetch_assoc($result1))
   { 
   
   ?>
   
   <?php
   $fromd = date("d.m.Y",strtotime($qr['fromdate']));
   $tod = date("d.m.Y",strtotime($qr['todate'])); ?>
   
   <?php
	 echo "if(((a1 <= '$tod') && (a1 >= '$fromd')) || ((a2 <= '$tod') && (a2 >= '$fromd'))) {"; 
	 ?>
	 alert("Already Entered for this date span");
	 check = 1;
	 <?php
     echo "}";
   }		 
   
?>
 }

 if(a == "special")
 {
   var a = "special";
   var a1 = document.getElementById("si_fdate").value;
   var a2 = document.getElementById("si_tdate").value;
   var a3 = document.getElementById("si_fcrfrom").value;
   var a4 = document.getElementById("si_fcrto").value;
   var a5 = document.getElementById("specialincentive").value;
   var a6 = 0;
   var a7 = 0;
   <?php 
   
   $query1 = "SELECT * from broiler_growingcharges where flag = 'S' ";
   $result1 = mysql_query($query1) ;
   while($qr = mysql_fetch_assoc($result1))
   { 
   
   ?>
   
   <?php
   $fromd = date("d.m.Y",strtotime($qr['fromdate']));
   $tod = date("d.m.Y",strtotime($qr['todate'])); ?>
   
   <?php
	 echo "if(((a1 <= '$tod') && (a1 >= '$fromd')) || ((a2 <= '$tod') && (a2 >= '$fromd'))) {"; 
	 ?>
	 alert("Already Entered for this date span");
	 check = 1;
	 <?php
     echo "}";
   }		 
   
?>
 }
 if(a == "sales")
 {
    var a = "sales";
   var a1 = document.getElementById("ssi_fdate").value;
   var a2 = document.getElementById("ssi_tdate").value;
   var a3 = document.getElementById("ssi_saleratefrom").value;
   var a4 = document.getElementById("ssi_salerateto").value;
   var a5 = document.getElementById("ssi_incentive").value;
   var a6 = 0;
   var a7 = 0;
   <?php 
   
   $query1 = "SELECT * from broiler_growingcharges where flag = 'SL' ";
   $result1 = mysql_query($query1) ;
   while($qr = mysql_fetch_assoc($result1))
   { 
   
   ?>
   
   <?php
   $fromd = date("d.m.Y",strtotime($qr['fromdate']));
   $tod = date("d.m.Y",strtotime($qr['todate'])); ?>
   
   <?php
	 echo "if(((a1 <= '$tod') && (a1 >= '$fromd')) || ((a2 <= '$tod') && (a2 >= '$fromd'))) {"; 
	 ?>
	 alert("Already Entered for this date span");
	 check = 1;
	 <?php
     echo "}";
   }		 
   
?>
 }
  if(a == "mortality")
 {
    var a = "mortality";
   var a1 = document.getElementById("mr_fdate").value;
   var a2 = document.getElementById("mr_tdate").value;
   var a3 = document.getElementById("mortalityfirst").value;
   var a4 = document.getElementById("mortalitytotal").value;
   var a5 = document.getElementById("mr_recovery1").value;
   var a6 = document.getElementById("mr_recovery16").value;
   var a7 = document.getElementById("mr_recovery21").value;
   <?php 
   
   $query1 = "SELECT * from broiler_growingcharges where flag = 'M' ";
   $result1 = mysql_query($query1) ;
   while($qr = mysql_fetch_assoc($result1))
   { 
   
   ?>
   
   <?php
   $fromd = date("d.m.Y",strtotime($qr['fromdate']));
   $tod = date("d.m.Y",strtotime($qr['todate'])); ?>
   
   <?php
	 echo "if(((a1 <= '$tod') && (a1 >= '$fromd')) || ((a2 <= '$tod') && (a2 >= '$fromd'))) {"; 
	 ?>
	 alert("Already Entered for this date span");
	 check = 1;
	 <?php
     echo "}";
   }		 
   
?>
 }
if(check == 0){
$.ajax({ 
         'url': 'broiler_savegrowingcharge.php',
         'type': 'GET', 
         'dataType': 'json', 
         'data': {a: a,a1: a1,a2: a2,a3: a3,a4: a4,a5: a5,a6: a6,a7: a7},
         'success': function(data) 
         { 

            if(data.status)
            {
                 if(data.added)
                { 
				   
                   
                   if(a == "feed")
                   { 
				        
					  document.getElementById("complex_form").reset();
					  
                      document.getElementById("notify").innerHTML = "<ul class='message success' id='success' style='width:50%;'><li>Data saved successfully</li><li class='close-bt'></li></ul>";               
                      
                   }
                   if(a == "growing")
                   { 
				       
						document.getElementById("complex_form").reset();
                      document.getElementById("notify1").innerHTML = "<ul class='message success' id='success' style='width:50%;'><li>Data saved success fully</li><li class='close-bt'></li></ul>"; 
                      
						
                   }
                   if(a == "special")
                   { 
 				       
						document.getElementById("complex_form").reset();
                     document.getElementById("notify2").innerHTML = "<ul class='message success' id='success' style='width:50%;'><li>Data saved success fully</li><li class='close-bt'></li></ul>"; 
						
                   }
				     if(a == "sales")
                   { 
 				       
						document.getElementById("complex_form").reset();
                     document.getElementById("notify3").innerHTML = "<ul class='message success' id='success' style='width:50%;'><li>Data saved success fully</li><li class='close-bt'></li></ul>"; 
						
                   }
				    if(a == "mortality")
                   { 
 				       
						document.getElementById("complex_form").reset();
                     document.getElementById("notify4").innerHTML = "<ul class='message success' id='success' style='width:50%;'><li>Data saved success fully</li><li class='close-bt'></li></ul>"; 
						
                   }
                }
				
            }
         }
});
}

}
 </script> 

<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:500px" id="complex_form" method="post" action="#" onSubmit="return calculate(this);">
	  <h1 id="title1">Feed Cost Settings</h1>
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
          <center>
		<div class="columns" style="font-size:90%;width:75%;">
			<select name="speed" id="speed" style="visibility:hidden" onChange="getdetails(this.value);">
				<option value="Feed&nbsp;Cost&nbsp;Settings" <?php if($_GET['m'] == "feed") { ?>selected="selected"<?php } ?> >Feed Cost Settings</option>
				<option value="Growing&nbsp;Charges" <?php if($_GET['m'] == "growing") { ?>selected="selected"<?php } ?> >Growing Charges</option>
				<option value="Special&nbsp;Incentives" <?php if($_GET['m'] == "special") { ?>selected="selected"<?php } ?> >Special Incentives</option>
				<option value="Sales&nbsp;Incentives" <?php if($_GET['m'] == "sales") { ?>selected="selected"<?php } ?> >Sales Incentives</option>
				<option value="Mortality&nbsp;Recovery" <?php if($_GET['m'] == "mortality") { ?>selected="selected"<?php } ?> >Mortality Recovery</option>
				
			</select>
            </div>
            <br />
          



       <!-- Feed Cost Div Starts -->  

       <div id="div0" style="position:absolute;width:100%;visibility:hidden;">
            <br />
            <p style="font-family:verdana;font-size:12px;color:#333333;font-weight:bold">Feed Cost Setings</p>
            (Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
            <br/><br/><br />
            <div id="notify"></div>

            <table>
            <tr>
              <td style="text-align:right;"><strong>From Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
              <td align="left"><input class="datepicker" type="text" size="15" id="fdate" name="fdate" value="<?php echo date("d.m.Y"); ?>" >
			  <br />
			  <span id="supervisor1span" style="color:red;"></span></td>
			  
			<td style="text-align:right;"><strong>To Date</strong>&nbsp;&nbsp;&nbsp;</td>
			<td align="left"><input class="datepicker" type="text" size="15" id="tdate" name="tdate" value="<?php echo date("d.m.Y"); ?>" >&nbsp;</td>
            </tr>
			
			<tr height="10px"><td></td></tr>
			<tr>
  
			<td style="text-align:right;vertical-align:middle"><strong>Feed Cost/Kg</strong>&nbsp;&nbsp;&nbsp;</td>
			<td align="left" style="text-align:right;vertical-align:middle"><input type="text" name="fcost" id="fcost" size="15" />&nbsp;</td>

			<td style="text-align:right;;vertical-align:middle"><strong>Chick Cost/Bird</strong>&nbsp;&nbsp;&nbsp;</td>
			<td align="left"><input type="text" name="ccost" id="ccost" size="15" />&nbsp;</td>
			</tr>
			<tr height="10px"><td></td></tr>
			<tr>
  
			<td style="text-align:right;vertical-align:middle"><strong>Management Cost/Kg</strong>&nbsp;&nbsp;&nbsp;</td>
			<td align="left" style="text-align:right;vertical-align:middle"><input type="text" name="mcost" id="mcost" size="15" />&nbsp;</td>

			<td style="text-align:right;;vertical-align:middle"><strong>Overhead Cost/Bird</strong>&nbsp;&nbsp;&nbsp;</td>
			<td align="left"><input type="text" name="ocost" id="ocost" size="15" />&nbsp;</td>
			</tr>
           
			
            <tr height="20px"><td></td></tr>
     
            <tr>
              <td colspan="4">
                <center>
                  <input type="button" value="Save" onClick="addItemToUsersList('feed')" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="javascript: history.go(-1)">
                </center>
              </td>
            </tr> 
         </table>
      </div> 

         <!-- Feed Cost Div Ends -->







         <!-- Growing Charges Div Starts -->

            <div id="div1" style="position:absolute;width:100%;visibility:hidden">
            <br />
            <p style="font-family:verdana;font-size:12px;color:#333333;font-weight:bold">Growing Charges</p>
            (Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
            <br/><br/><br />
            <div id="notify1"></div>
<table>
<tr>

  <td style="text-align:right;"><strong>From Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input class="datepicker" type="text" size="15" id="gc_fdate" name="gc_fdate" value="<?php echo date("d.m.Y"); ?>" >
 <br />
  <span id="supervisor2span" style="color:red;"></span>&nbsp;</td>
 <td style="text-align:right;"><strong>To Date</strong>&nbsp;&nbsp;&nbsp;</td>
			<td align="left"><input class="datepicker" type="text" size="15" id="gc_tdate" name="gc_tdate" value="<?php echo date("d.m.Y"); ?>" >&nbsp;</td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
  <td style="text-align:right;"><strong>FCR From</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input type="text" name="fcrfrom" id="fcrfrom" size="15" /><br />
	<span id="place1span" style="color:red;"></span>&nbsp;</td>
	<td style="text-align:right;"><strong>FCR To</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input type="text" name="fcrto" id="fcrto" size="15" /><br />
	<span id="place1span" style="color:red;"></span></td>
</tr>

<tr height="10px"><td></td></tr>

<tr>
  <td style="text-align:right;"><strong>Growing Charge/Kg</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input type="text" name="growingcharge" id="growingcharge" size="15" /><br />
	<span id="place1span" style="color:red;"></span></td>
	
</tr>

<tr height="20px"><td></td></tr>
<tr>
   <td colspan="5" align="center">
     <br />
  <center>
       <input type="button" value="Save" onClick="addItemToUsersList('growing')" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="javascript: history.go(-1)">
   </center>
   </td>
</tr>
</table>
            </div> 

         <!-- Growing Charge Div Ends -->
         <!-- Special Incentives Div Starts --> 

            <div id="div2" style="position:absolute;width:100%;visibility:hidden">
              <br />
            <p style="font-family:verdana;font-size:12px;color:#333333;font-weight:bold">Special Incentives</p>
            (Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
            <br/><br/><br />
            <div id="notify2"></div>
<table>
<tr>

   <td style="text-align:right;"><strong>From Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input class="datepicker" type="text" size="15" id="si_fdate" name="si_fdate" value="<?php echo date("d.m.Y"); ?>" >
 <br />
  <span id="supervisor2span" style="color:red;"></span>&nbsp;</td>
 <td style="text-align:right;"><strong>To Date</strong>&nbsp;&nbsp;&nbsp;</td>
			<td align="left"><input class="datepicker" type="text" size="15" id="si_tdate" name="si_tdate" value="<?php echo date("d.m.Y"); ?>" >&nbsp;</td>
   
</tr>

<tr height="10px"><td></td></tr>

<tr>
  <td style="text-align:right;"><strong>FCR From</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input type="text" name="si_fcrfrom" id="si_fcrfrom" size="15" />
  <br />
  <span id="farm1span" style="color:red;"></span></td>
  
  <td style="text-align:right;"><strong>FCR To</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input type="text" name="si_fcrto" id="si_fcrto" size="15" /><br />
<span id="farmer1span" style="color:red;"></span></td>
  
</tr>
<tr height="10px"><td></td></tr>
<tr>
  <td style="text-align:right;"><strong>Special Incentive/Kg</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input type="text" name="specialincentive" id="specialincentive" size="15" /><br />
	<span id="place1span" style="color:red;"></span></td>
	
</tr>



<tr height="20px"><td></td></tr>
<tr>
   <td colspan="5" align="center">
     <br />
  <center>
       <input type="button" value="Save" onClick="addItemToUsersList('special')" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="javascript: history.go(-1)">
   </center>
   </td>
</tr>
</table>

            </div> 


   
         <!-- Special Incentive Div Ends -->

          <!-- Sales Special Incentive Starts -->
		 <div id="div3" style="position:absolute;width:100%;visibility:hidden">
              <br />
            <p style="font-family:verdana;font-size:12px;color:#333333;font-weight:bold">Sales Special Incentives</p>
            (Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
            <br/><br/><br />
            <div id="notify3"></div>
<table>
<tr>

   <td style="text-align:right;"><strong>From Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input class="datepicker" type="text" size="15" id="ssi_fdate" name="ssi_fdate" value="<?php echo date("d.m.Y"); ?>" >
 <br />
  <span id="supervisor2span" style="color:red;"></span>&nbsp;</td>
 <td style="text-align:right;"><strong>To Date</strong>&nbsp;&nbsp;&nbsp;</td>
			<td align="left"><input class="datepicker" type="text" size="15" id="ssi_tdate" name="ssi_tdate" value="<?php echo date("d.m.Y"); ?>" >&nbsp;</td>
   
</tr>

<tr height="10px"><td></td></tr>

<tr>
  <td style="text-align:right;"><strong>Sale Rate/Kg From</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input type="text" name="ssi_saleratefrom" id="ssi_saleratefrom" size="15" />
  <br />
  <span id="farm1span" style="color:red;"></span></td>
  
  <td style="text-align:right;"><strong>Sale Rate/Kg To</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input type="text" name="ssi_salerateto" id="ssi_salerateto" size="15" /><br />
<span id="farmer1span" style="color:red;"></span></td>
  
</tr>
<tr height="10px"><td></td></tr>
<tr>
  <td style="text-align:right;"><strong>Sales Incentive/Kg</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input type="text" name="ssi_incentive" id="ssi_incentive" size="15" /><br />
	<span id="place1span" style="color:red;"></span></td>
	
</tr>



<tr height="20px"><td></td></tr>
<tr>
   <td colspan="5" align="center">
     <br />
  <center>
       <input type="button" value="Save" onClick="addItemToUsersList('sales')" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="javascript: history.go(-1)">
   </center>
   </td>
</tr>
</table>

            </div>  
		  
		  <!-- Sales Special Incentive Ends -->
<!-- Mortality Recovery Div Starts Here -->
 <div id="div4" style="position:absolute;width:100%;visibility:hidden">
              <br />
            <p style="font-family:verdana;font-size:12px;color:#333333;font-weight:bold">Mortality Recovery Details</p>
            (Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
            <br/><br/><br />
            <div id="notify4"></div>
<table>
<tr>

   <td style="text-align:right;"><strong>From Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input class="datepicker" type="text" size="15" id="mr_fdate" name="mr_fdate" value="<?php echo date("d.m.Y"); ?>" >
 <br />
  <span id="supervisor2span" style="color:red;"></span>&nbsp;</td>
 <td style="text-align:right;"><strong>To Date</strong>&nbsp;&nbsp;&nbsp;</td>
			<td align="left"><input class="datepicker" type="text" size="15" id="mr_tdate" name="mr_tdate" value="<?php echo date("d.m.Y"); ?>" >&nbsp;</td>
   
</tr>

<tr height="10px"><td></td></tr>

<tr>
  <td style="text-align:right;"><strong>Mortalit % Limit(1st Week)</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input type="text" name="mortalityfirst" id="mortalityfirst" size="15" />
  <br />
  <span id="farm1span" style="color:red;"></span></td>
  
  <td style="text-align:right;"><strong>Mortality % Limit(Overall)</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input type="text" name="mortalitytotal" id="mortalitytotal" size="15" /><br />
<span id="farmer1span" style="color:red;"></span></td>
  
</tr>
<tr height="10px"><td></td></tr>
<tr>
  <td style="text-align:right;"><strong>Recovery Rate For Birds(1-15 daye)</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input type="text" name="mr_recovery1" id="mr_recovery1" size="15" />
  <br />
  <span id="farm1span" style="color:red;"></span></td>
  
  <td style="text-align:right;"><strong>Recovery Rate For Birds(16-20 Days)</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input type="text" name="mr_recovery16" id="mr_recovery16" size="15" /><br />
<span id="farmer1span" style="color:red;"></span></td>
  
</tr>
<tr height="10px"><td></td></tr>
<tr>
  <td style="text-align:right;"><strong>Recovery Rate For Birds(> 21 Days)</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font>&nbsp;&nbsp;&nbsp;</td>
  <td align="left"><input type="text" name="mr_recovery21" id="mr_recovery21" size="15" /><br />
	<span id="place1span" style="color:red;"></span></td>
	
</tr>



<tr height="20px"><td></td></tr>
<tr>
   <td colspan="5" align="center">
     <br />
  <center>
       <input type="button" value="Save" onClick="addItemToUsersList('mortality')" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="javascript: history.go(-1)">
   </center>
   </td>
</tr>
</table>

            </div>  
<!-- Mortality Recovery Div Ends -->




          </center>
          
	</form>
  </div>
</section>
		
<script type="text/javascript">
       function getdetails(a)
       {
         document.getElementById("title1").innerHTML = document.getElementById("speed").options[a].value;
         for(i = 0;i <= 4;i++)
         {
            if(i == a)
             document.getElementById("div" + i).style.visibility = "visible";
            else
             document.getElementById("div" + i).style.visibility = "hidden";
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
</script>


<div class="clear"></div>
<br />

<script type="text/javascript">
function script1() {
window.open('BroilerHelp/help_m_growingcharges.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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



