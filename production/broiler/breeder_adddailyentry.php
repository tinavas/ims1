<?php include "getemployee.php"; session_start(); ?>
<?php
             include "config.php"; 
             $query = "SELECT * FROM ims_itemcodes where cat = 'Hatch Eggs' and (iusage='Produced or Sale' OR iusage='Produced' ) and client = '$client'  ORDER BY code ASC ";
             $result = mysql_query($query,$conn); 
              $herows = mysql_num_rows($result);
             $query = "SELECT * FROM ims_itemcodes where cat = 'Eggs' and client = '$client' and (iusage='Produced or Sale' OR iusage='Produced or Rejected' OR iusage='Produced or Sale or Rejected') ORDER BY code ASC ";
             $result = mysql_query($query,$conn); 
              $oerows = mysql_num_rows($result);
                $drows = ($herows * 2) + ($oerows * 2); 
?>

<!-- Pop up -->

	<link rel="stylesheet" href="styles/nyroModal.css" type="text/css" media="screen" />
	<script type="text/javascript" src="js/jquery.nyroModal-1.6.2.pack.js"></script>
	<script type="text/javascript">
	//<![CDATA[
	// Demo NyroModal
	$(function() {
		$.nyroModalSettings({
			debug: false,
			processHandler: function(settings) {
				var url = settings.url;
				if (url && url.indexOf('http://www.youtube.com/watch?v=') == 0) {
					$.nyroModalSettings({
						type: 'swf',
						height: 355,
						width: 425,
						url: url.replace(new RegExp("watch\\?v=", "i"), 'v/')
					});
				}
			},
			endShowContent: function(elts, settings) {
				$('.resizeLink', elts.contentWrapper).click(function(e) {
					e.preventDefault();
					$.nyroModalSettings({
						width: Math.random()*1000,
						height: Math.random()*1000
					});
					return false;
				});
				$('.bgLink', elts.contentWrapper).click(function(e) {
					e.preventDefault();
					$.nyroModalSettings({
						bgColor: '#'+parseInt(255*Math.random()).toString(16)+parseInt(255*Math.random()).toString(16)+parseInt(255*Math.random()).toString(16)
					});
					return false;
				});
			}
		});
		
		$('#manual').click(function(e) {
			e.preventDefault();
			var content = 'Content wrote in JavaScript<br />';
			jQuery.each(jQuery.browser, function(i, val) {
				content+= i + " : " + val+'<br />';
			});
			$.fn.nyroModalManual({
				bgColor: '#3333cc',
				content: content
			});
			return false;
		});
            $(function() {
	           $( ".datepicker" ).datepicker();
            });
		$('#manual2').click(function(e) {
			e.preventDefault();
			$('#imgFiche').nyroModalManual({
				bgColor: '#cc3333'
			});
			return false;
		});

		$('#myValidForm').submit(function(e) {
			e.preventDefault();
			if ($("#myValidForm :text").val() != '') {
				$('#myValidForm').nyroModalManual();
			} else {
				alert("Enter a value before going to " + $('#myValidForm').attr("action"));
			}
			return false;
		});
		$('#block').nyroModal({
			'blocker': '#blocker'
		});
		
		function preloadImg(image) {
			var img = new Image();
			img.src = image;
		}
		
		preloadImg('img/ajaxLoader.gif');
		preloadImg('img/prev.gif');
		preloadImg('img/next.gif');
		
	});
	
	// Page enhancement
	$(function() {
		var allPre = $('pre');
		allPre.each(function() {
			var pre = $(this);
			var link = $('<a href="#" class="showCode">Show Code</a>');
			pre.hide().before(link).before('<br />');
			link.click(function(event) {
					event.preventDefault();
					pre.slideToggle('fast');
					return false;
				});
		});
		var shown = false;
		$('#showAllCodes').click(function(event) {
			event.preventDefault();
			if (shown)
				allPre.slideUp('fast');
			else
				allPre.slideDown('fast');
			shown = !shown;
			return false;
		});
	});
	
	//]]>
	</script>
	<style type="text/css">
		#blocker {
			width: 300px;
			height: 300px;
			background: red;
			padding: 30px;
			border: 5px solid green;
		}
	</style>

<!-- Pop Up End -->


<section class="grid_8">
  <div class="block-border">
     <form class="block-content form" style="height:600px" id="complex_form" method="post" action="breeder_savedailyentry.php" >
<input type="hidden" id="saed" name="saed" value="save" />
	  <h1 id="title1">Daily Entry</h1>
	  
		<div class="block-controls"><ul class="controls-tabs js-tabs"></ul></div>
              <center> (Fields marked <font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> are mandatory)
<table border="0" id="inputs">
     <tr height="20px"><td></td></tr>
     <tr>
        <th  style="text-align:left"><strong></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left" colspan="3"><strong style="color:red"><center>Female</center></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left;"><strong style="color:red"><center>Male</center></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left;"><strong></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left" colspan="<?php echo $drows; ?>"><strong style="color:red"><center>Productions</center></strong></th>
     </tr>

     <tr style="height:20px"></tr>

     <tr>
        <th  style="text-align:left"><strong>Flock<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong>Date<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong>Age<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong>Mort</strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong>Culls</strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong>B.Wt</strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong>Feed<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font> </strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong>Kg's<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong>Mort </strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong>Culls</strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong>B.Wt</strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong>Feed</strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong>Kg's</strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong>E.Wt</strong></th>
        <th width="10px"></th>
        <th  style="text-align:left"><strong>Water</strong></th>
        <th width="10px"></th>
        <?php
             include "config.php"; 
             $query = "SELECT * FROM ims_itemcodes where cat = 'Hatch Eggs' and (iusage='Produced or Sale' OR iusage='Produced' ) and client = '$client'  ORDER BY code ASC ";
             $result = mysql_query($query,$conn); 
             while($row1 = mysql_fetch_assoc($result))
             {
        ?>
        <th  style="text-align:left" title="<?php echo $row1['description']; ?>"><strong><?php echo substr($row1['code'],2); ?></strong></th>
        <th width="10px"></th>
        <?php } ?>

        <?php
             include "config.php"; 
             $query = "SELECT * FROM ims_itemcodes where cat = 'Eggs' and client = '$client' and (iusage='Produced or Sale' OR iusage='Produced or Rejected' OR iusage='Produced or Sale or Rejected') ORDER BY code ASC ";
             $result = mysql_query($query,$conn); 
             while($row1 = mysql_fetch_assoc($result))
             {
        ?>
        <th  style="text-align:left" title="<?php echo $row1['description']; ?>"><strong><?php echo substr($row1['code'],2); ?></strong></th>
        <th width="10px"></th>
        <?php } ?>
     </tr>

     <tr style="height:20px"></tr>

   <tr>
 
       <td style="text-align:left;">
         <select name="flock[]" id="flock0" style="width:68px;" onchange="getflock(this.value,0,this.id);">
           <option>-Select-</option>
           <?php
              include "config.php"; 
              $query = "select * from breeder_flock where client = '$client' and cullflag = 0 order by flockcode asc";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
                   $query1a = "select distinct(wo) as 'wo',flock from breeder_woinputs where flock='$row1[flockcode]' and client = '$client'  ORDER BY wo ASC ";
                   $result1a = mysql_query($query1a,$conn);  
                   if(mysql_num_rows($result1a)) 
                   {
                      while($row11a = mysql_fetch_assoc($result1a))
                      {
                         $wo = $row11a['wo'];
                      }
                   }
                   else
                   {
                         $wo = $row1['flockcode'];
                   }

                   include "config.php"; 
                   $query1 = "SELECT * FROM breeder_consumption where flock = '$row1[flockcode]' and client = '$client'  ORDER BY date2 asc";
                   $result1 = mysql_query($query1,$conn); 
				   
                   if(mysql_num_rows($result1))
                   {
                      while($row11 = mysql_fetch_assoc($result1))
                      {
                        $nextdate = $row11['date2'];
                        $t = strtotime($nextdate) + (24 * 60 * 60);
                        $nextdate = date("j.m.Y",$t);
                        $age = $row11['age'] + 1;
                        $nrSeconds = $age * 24 * 60 * 60;
                        $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
                        $nrWeeksPassed = floor($nrSeconds / 604800); 
                        $nrYearsPassed = floor($nrSeconds / 31536000); 
                      }
                  }
                  else
                  {
                        $query1 = "SELECT * FROM breeder_flock where flockcode = '$row1[flockcode]' and client = '$client' ";
                        $result1 = mysql_query($query1,$conn); 
                        while($row11 = mysql_fetch_assoc($result1))
                        {
                           $nextdate = $row11['startdate'];
                           $age = $row11['age'];
                           $nrSeconds = $age * 24 * 60 * 60;
                           $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
                           $nrWeeksPassed = floor($nrSeconds / 604800); 
                           $nrYearsPassed = floor($nrSeconds / 31536000); 
                        }
                  }

             $q = "select * from breeder_flock where flockcode = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening = $qr['femaleopening'];
             }

            include "config.php";
            $q = "select * from breeder_flock where flockcode = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
               $q1 = "select * from breeder_shed where shedcode = '$qr[shedcode]' and client = '$client'  "; 
     		   $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
 		   while($qr1 = mysql_fetch_assoc($qrs1))
 		   {
                  $shedtype = $qr1['shedtype'];
               }
             }

             $q = "select * from breeder_flock where flockcode = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening = $qr['femaleopening'];
             }
             $nexttdate1 = date("Y-m-d",strtotime($nextdate));
			
           $q123 = "select * from ims_stocktransfer where towarehouse =  '$row1[flockcode]' and date > '$nexttdate1'  "; 
    		 $qrs = mysql_query($q123,$conn);
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $datedummy = strtotime($qr['date']) + (24 * 60 * 60);
				$nextdate = date("d.m.Y",$datedummy);
				
				$q1 = "select max(age) as maxage from breeder_consumption where flock =  '$qr[fromwarehouse]'  "; 
    		 $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		 while($qr1 = mysql_fetch_assoc($qrs1))
		 {
		 $age = $qr1['maxage'] + 1;
		 
		 }
				
             }
 
             $minus = 0; 
             $q = "select distinct(date2),fmort,fcull from breeder_consumption where flock = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus = $minus + $qr['fmort'] + $qr['fcull'];
             }


             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Birds' and fromwarehouse = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 

             $q = "select sum(quantity) as 'quantity' from oc_cobi where flock = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tsale = $qr['quantity'];
               }
             }
             else
             {
                $tsale = 0;
             } 


             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Birds' and towarehouse = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 

             $remaining = ($fopening - $minus - $ftransfer + $ttransfer) - $tsale;



           ?>
           <option value="<?php echo $row1['flockcode']."@".$nextdate."@".$age."@".$wo."@".$remaining; ?>" title="<?php if($_SESSION['client'] == "MRPF") { echo $row1['flockcode']."-".$row1['shedcode']; } else { echo $row1['flockcode']; } ?>"><?php if($_SESSION['client'] == "MRPF") { echo $row1['flockcode']."-".$row1['shedcode']; } else { echo $row1['flockcode']; } ?></option>
           <?php } ?>
         </select>
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="date[]" id="date0" value="" size="10" /> 
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="age[]" id="age0" value="" size="3" /> 
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="fmort[]" id="value0" value="" size="3" /> 
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="fcull[]" id="fcull0" value="" size="3" /> 
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="fweight[]" id="value0" value="" size="3" /> 
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <select name="feedtype[]" id="feedtype0" style="width:68px;">
           <option value="">-Select-</option>
           <?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemcodes where cat = 'Female Feed' and client = '$client'  ORDER BY code ASC ";
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
         <input type="text" name="feedqty[]" id="value0" value="" size="3" /> 
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="mmort[]" id="value0" value="" size="3" onfocus="makeform();" /> 
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="mcull[]" id="mcull0" value="" size="3" /> 
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="mweight[]" id="value0" value="" size="3" /> 
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <select name="feedtype1[]" id="feedtype0" style="width:68px;">
           <option value="">-Select-</option>
           <?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemcodes where cat = 'Male Feed' and client = '$client'  ORDER BY code ASC ";
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
         <input type="text" name="feedqty1[]" id="value0" value="" size="3" /> 
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="eggwt[]" id="value0" value="" size="3" /> 
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="water[]" id="value0" value="" size="4" /> 
       </td>
       <td width="10px"></td>
       <?php
             include "config.php"; 
             $query = "SELECT * FROM ims_itemcodes where cat = 'Hatch Eggs' and (iusage='Produced or Sale' OR iusage='Produced') and client = '$client'  ORDER BY code ASC ";
             $result = mysql_query($query,$conn); 
             while($row1 = mysql_fetch_assoc($result))
             {
        ?>
       <td style="text-align:left;">
         <input type="text" name="<?php echo $row1['code']; ?>[]" id="value10" value="" size="3" /> 
       </td>
       <td width="10px"></td>
       <?php } ?>

        <?php
             include "config.php"; 
             $query = "SELECT * FROM ims_itemcodes where cat = 'Eggs' and client = '$client' and (iusage='Produced or Sale' OR iusage='Produced or Rejected' OR iusage='Produced or Sale or Rejected') ORDER BY code ASC ";
             $result = mysql_query($query,$conn); 
             while($row1 = mysql_fetch_assoc($result))
             {
        ?>
       <td style="text-align:left;">
         <input type="text" name="<?php echo $row1['code']; ?>[]" id="value0" value="" size="3" /> 
       </td>
       <td width="10px"></td>
       <?php } ?>
    </tr>

 
</table>


<br /><br /><br />

<h4 style="color:red">Other Items Consumed</h4><br />

<table border="0px" id="inputs1">


     <tr>
         <th  style="text-align:left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Flock</strong></th>
        <th width="20px"></th>
        <th  style="text-align:left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Date</strong></th>
        <th width="20px"></th>
        <th  style="text-align:left"><strong>&nbsp;Age</strong></th>
        <th width="20px"></th>
<th  style="text-align:left"><strong>&nbsp;Category</strong></th>
        <th width="20px"></th>

        <th  style="text-align:left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;Item</strong></th>
        <th width="20px"></th>
	 <th  style="text-align:left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Description</strong></th>
        <th width="20px"></th>

        <th  style="text-align:left"><strong>&nbsp;Quantity</strong></th>
     </tr>

     <tr style="height:20px"></tr>

   <tr>
 
       <td style="text-align:left;">
         <select name="flock1[]" id="flock10" style="width:68px;" onchange="getflock1(this.value,0,this.id);">
           <option>-Select-</option>
           <?php
              include "config.php"; 
              $query = "select * from breeder_flock where client = '$client' and cullflag = 0 order by flockcode asc";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
                   $query1a = "select distinct(wo) as 'wo',flock from breeder_woinputs where flock='$row1[flockcode]' and client = '$client'  ORDER BY wo ASC ";
                   $result1a = mysql_query($query1a,$conn);  
                   if(mysql_num_rows($result1a)) 
                   {
                      while($row11a = mysql_fetch_assoc($result1a))
                      {
                         $wo = $row11a['wo'];
                      }
                   }
                   else
                   {
                         $wo = $row1['flockcode'];
                   }

                   include "config.php"; 
                   $query1 = "SELECT * FROM breeder_consumption where flock = '$row1[flockcode]' and client = '$client'  ORDER BY date2 asc";
                   $result1 = mysql_query($query1,$conn); 
                   if(mysql_num_rows($result1))
                   {
                      while($row11 = mysql_fetch_assoc($result1))
                      {
                        $nextdate = $row11['date2'];
                        $t = strtotime($nextdate) + (24 * 60 * 60);
                        $nextdate = date("j.m.Y",$t);
                        $age = $row11['age'] + 1;
                        $nrSeconds = $age * 24 * 60 * 60;
                        $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
                        $nrWeeksPassed = floor($nrSeconds / 604800); 
                        $nrYearsPassed = floor($nrSeconds / 31536000); 
                      }
                  }
                  else
                  {
                        $query1 = "SELECT * FROM breeder_flock where flockcode = '$row1[flockcode]' and client = '$client' ";
                        $result1 = mysql_query($query1,$conn); 
                        while($row11 = mysql_fetch_assoc($result1))
                        {
                           $nextdate = $row11['startdate'];
                           $age = $row11['age'];
                           $nrSeconds = $age * 24 * 60 * 60;
                           $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
                           $nrWeeksPassed = floor($nrSeconds / 604800); 
                           $nrYearsPassed = floor($nrSeconds / 31536000); 
                        }
                  }

             $q = "select * from breeder_flock where flockcode = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening = $qr['femaleopening'];
             }

            include "config.php";
            $q = "select * from breeder_flock where flockcode = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
               $q1 = "select * from breeder_shed where shedcode = '$qr[shedcode]' and client = '$client'  "; 
     		   $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
 		   while($qr1 = mysql_fetch_assoc($qrs1))
 		   {
                  $shedtype = $qr1['shedtype'];
               }
             }

             $q = "select * from breeder_flock where flockcode = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening = $qr['femaleopening'];
             }
             
           $nexttdate1 = date("Y-m-d",strtotime($nextdate));
			
           $q123 = "select * from ims_stocktransfer where towarehouse =  '$row1[flockcode]' and date > '$nexttdate1'  "; 
    		 $qrs = mysql_query($q123,$conn);
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $datedummy = strtotime($qr['date']) + (24 * 60 * 60);
				$nextdate = date("d.m.Y",$datedummy);
				
				$q1 = "select max(age) as maxage from breeder_consumption where flock =  '$qr[fromwarehouse]'  "; 
    		 $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		 while($qr1 = mysql_fetch_assoc($qrs1))
		 {
		 $age = $qr1['maxage'] + 1;
		 
		 }
				
             }
 
             $minus = 0; 
             $q = "select distinct(date2),fmort,fcull from breeder_consumption where flock = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus = $minus + $qr['fmort'] + $qr['fcull'];
             }


             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Birds' and fromwarehouse = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 

             $q = "select sum(quantity) as 'quantity' from oc_cobi where flock = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tsale = $qr['quantity'];
               }
             }
             else
             {
                $tsale = 0;
             } 


             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Birds' and towarehouse = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 

             $remaining = ($fopening - $minus - $ftransfer + $ttransfer) - $tsale;



           ?>
           <option value="<?php echo $row1['flockcode']."@".$nextdate."@".$age."@".$wo."@".$remaining; ?>" title="<?php if($_SESSION['client'] == "MRPF") { echo $row1['flockcode']."-".$row1['shedcode']; } else { echo $row1['flockcode']; } ?>"><?php if($_SESSION['client'] == "MRPF") { echo $row1['flockcode']."-".$row1['shedcode']; } else { echo $row1['flockcode']; } ?></option>
           <?php } ?>
         </select>
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="date1[]" id="date10" value="" size="10" /> 
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="age1[]" id="age10" value="" size="3" /> 
       </td>


<td width="10px"></td>
       <td style="text-align:left;">
<select style="Width:100px" name="cat[]" id="cat@-1" onchange="loadcodes(this.id);">
     <option>-Select-</option>
     <?php 
	     $query = "SELECT distinct(type) FROM ims_itemtypes where type <> 'Broiler Birds' ORDER BY type ASC";
           $result = mysql_query($query,$conn);
           while($row = mysql_fetch_assoc($result))
           {
     ?>
             <option value="<?php echo $row['type'];?>"><?php echo $row['type']; ?></option>
     <?php } ?>
</select>
       </td>

      <td width="10px"></td>
       <td style="text-align:left;">
         <select name="item1[]" id="item@-1" style="width:75px;" onchange="getdesc(this.id);" >
           <option value="">-Select-</option>
         </select>
       </td>
    <td width="10px"></td>
       <td style="text-align:left;">
         <select name="description[]" id="description@-1" style="width:170px;" onchange="selectcode(this.id);">
           <option value="">-Select-</option>
         </select>
       </td>
       <td width="10px"></td>
       <td style="text-align:left;">
         <input type="text" name="qty1[]" id="value10" value="" size="8" onfocus="makeform1();" /> 
       </td>
    </tr>

 
</table>
<br /><br />

<table align="center" border="0">


<tr>
<td colspan="5" align="center">
<center>
<input type="submit" value="Save" />&nbsp;&nbsp;&nbsp;
<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=breeder_dailyentry';">

</center>
</td>
</tr>
</table>
</form>
<script type="text/javascript">
function script1() {
window.open('BREEDERHELP/help_t_addbreederdailyentry.php','BIMS','width=500,height=600,toolbar=no,menubar=yes,scrollbars=yes,resizable=yes');
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

<script type="text/javascript">
function getflock(a,b,c)
{
 var det = a.split("@");
 var b = c.substring(5);
 document.getElementById("date" + b).value = det[1];
 document.getElementById("age" + b).value = det[2];
 document.getElementById("obirds" + b).value = det[4];
}

function getflock1(a,b,c)
{
 var det = a.split("@");
 var b = c.substring(6);
 document.getElementById("date1" + b).value = det[1];
 document.getElementById("age1" + b).value = det[2];
}

var index = 0;
var index1 = 0;

function makeform()
{
if((document.getElementById('feedtype' + index).value != "")&&(document.getElementById('feedtype' + index).value != "-Select-") && (document.getElementById('age' + index).value != "0") && (document.getElementById('age' + index).value != ""))
{
  index = index + 1;
  var t1  = document.getElementById('inputs');
  var r1 = document.createElement('tr'); 

 
  myselect1 = document.createElement("select");
  myselect1.style.width = "68px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "flock[]";
  myselect1.id = "flock" + index;
  myselect1.onchange = function() { getflock(this.value,index,this.id); };
  <?php
           include "config.php"; 
           $query = "select * from breeder_flock where client = '$client' and cullflag = 0 order by flockcode asc";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
                   $query1a = "select distinct(wo) as 'wo',flock from breeder_woinputs where flock='$row1[flockcode]' and client = '$client'  ORDER BY wo ASC ";
                   $result1a = mysql_query($query1a,$conn);  
                   if(mysql_num_rows($result1a)) 
                   {
                      while($row11a = mysql_fetch_assoc($result1a))
                      {
                         $wo = $row11a['wo'];
                      }
                   }
                   else
                   {
                         $wo = $row1['flockcode'];
                   }

                   include "config.php"; 
                   $query1 = "SELECT * FROM breeder_consumption where flock = '$row1[flockcode]' and client = '$client'  ORDER BY date2 asc";
                   $result1 = mysql_query($query1,$conn); 
                   if(mysql_num_rows($result1))
                   {
                      while($row11 = mysql_fetch_assoc($result1))
                      {
                        $nextdate = $row11['date2'];
                        $t = strtotime($nextdate) + (24 * 60 * 60);
                        $nextdate = date("j.m.Y",$t);
                        $age = $row11['age'] + 1;
                        $nrSeconds = $age * 24 * 60 * 60;
                        $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
                        $nrWeeksPassed = floor($nrSeconds / 604800); 
                        $nrYearsPassed = floor($nrSeconds / 31536000); 
                      }
                  }
                  else
                  {
                        $query1 = "SELECT * FROM breeder_flock where flockcode = '$row1[flockcode]' and client = '$client' ";
                        $result1 = mysql_query($query1,$conn); 
                        while($row11 = mysql_fetch_assoc($result1))
                        {
                           $nextdate = $row11['startdate'];
                           $age = $row11['age'];
                           $nrSeconds = $age * 24 * 60 * 60;
                           $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
                           $nrWeeksPassed = floor($nrSeconds / 604800); 
                           $nrYearsPassed = floor($nrSeconds / 31536000); 
                        }
                  }
             $q = "select * from breeder_flock where flockcode = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening = $qr['femaleopening'];
             }

            include "config.php";
            $q = "select * from breeder_flock where flockcode = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
               $q1 = "select * from breeder_shed where shedcode = '$qr[shedcode]' and client = '$client'  "; 
     		   $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
 		   while($qr1 = mysql_fetch_assoc($qrs1))
 		   {
                  $shedtype = $qr1['shedtype'];
               }
             }

             $q = "select * from breeder_flock where flockcode = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening = $qr['femaleopening'];
             }
             
$nexttdate1 = date("Y-m-d",strtotime($nextdate));
			
           $q123 = "select * from ims_stocktransfer where towarehouse =  '$row1[flockcode]' and date > '$nexttdate1'  "; 
    		 $qrs = mysql_query($q123,$conn);
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $datedummy = strtotime($qr['date']) + (24 * 60 * 60);
				$nextdate = date("d.m.Y",$datedummy);
				
				$q1 = "select max(age) as maxage from breeder_consumption where flock =  '$qr[fromwarehouse]'  "; 
    		 $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		 while($qr1 = mysql_fetch_assoc($qrs1))
		 {
		 $age = $qr1['maxage'] + 1;
		 
		 }
				
             }
 
             $minus = 0; 
             $q = "select distinct(date2),fmort,fcull from breeder_consumption where flock = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus = $minus + $qr['fmort'] + $qr['fcull'];
             }


             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Birds' and fromwarehouse = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 

             $q = "select sum(quantity) as 'quantity' from oc_cobi where flock = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tsale = $qr['quantity'];
               }
             }
             else
             {
                $tsale = 0;
             } 


             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Birds' and towarehouse = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 

             $remaining = ($fopening - $minus - $ftransfer + $ttransfer) - $tsale;

  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php if($_SESSION['client'] == "MRPF") { echo $row1['flockcode']."-".$row1['shedcode']; } else { echo $row1['flockcode']; } ?>");
		theOption.appendChild(theText);
            theOption.title = "<?php if($_SESSION['client'] == "MRPF") { echo $row1['flockcode']."-".$row1['shedcode']; } else { echo $row1['flockcode']; } ?>";
		theOption.value = "<?php echo $row1['flockcode']."@".$nextdate."@".$age."@".$wo."@".$remaining; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>
  var ba1 = document.createElement('td');
  ba1.appendChild(myselect1);
  var b1 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b1.appendChild(myspace2);



  mybox1=document.createElement("input");
  mybox1.size="10";
  mybox1.type="text";
  mybox1.name="date[]";
  mybox1.id="date" +  index;
  var ba2 = document.createElement('td');
  ba2.appendChild(mybox1);

  var b2 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b2.appendChild(myspace2);


  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="age[]";
  mybox1.id="age" +  index;
  var ba3 = document.createElement('td');
  ba3.appendChild(mybox1);

  var b3 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b3.appendChild(myspace2);

  mybox1=document.createElement("input");
  mybox1.size="5";
  mybox1.type="text";
  mybox1.name="obirds[]";
  mybox1.id="obirds" +  index;
  var ba14 = document.createElement('td');
  ba14.appendChild(mybox1);

  var b14 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b14.appendChild(myspace2);


  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="fmort[]";
  //mybox1.onfocus = function() { makeform(); };
  //mybox1.id="age" +  index;
  var ba4 = document.createElement('td');
  ba4.appendChild(mybox1);

  var b4 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b4.appendChild(myspace2);


  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="fcull[]";
  mybox1.id="fcull" +  index;
  var ba5 = document.createElement('td');
  ba5.appendChild(mybox1);

  var b5 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b5.appendChild(myspace2);
    

  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="fweight[]";
  //mybox1.id="age" +  index;
  var ba6 = document.createElement('td');
  ba6.appendChild(mybox1);

  var b6 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b6.appendChild(myspace2);

  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="eggwt[]";
  //mybox1.id="age" +  index;
  var ba7 = document.createElement('td');
  ba7.appendChild(mybox1);

  var b7 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b7.appendChild(myspace2);

  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="tempmin[]";
  //mybox1.id="age" +  index;
  var ba8 = document.createElement('td');
  ba8.appendChild(mybox1);

  var b8 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b8.appendChild(myspace2);

  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="tempmax[]";
  //mybox1.id="age" +  index;
  var ba9 = document.createElement('td');
  ba9.appendChild(mybox1);

  var b9 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b9.appendChild(myspace2);

  mybox1=document.createElement("input");
  mybox1.size="4";
  mybox1.type="text";
  mybox1.name="water[]";
  //mybox1.id="age" +  index;
  var ba10 = document.createElement('td');
  ba10.appendChild(mybox1);

  var b10 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b10.appendChild(myspace2);

  myselect1 = document.createElement("select");
  myselect1.style.width = "68px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "feedtype[]";
  myselect1.id = "feedtype" + index;
  <?php
           include "config.php"; 
           $query = "SELECT * FROM ims_itemcodes where cat = 'Female Feed' and client = '$client'  ORDER BY code ASC ";
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
  var ba11 = document.createElement('td');
  ba11.appendChild(myselect1);
  var b11 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b11.appendChild(myspace2);

  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="feedqty[]";
  //mybox1.id="age" +  index;
  var ba12 = document.createElement('td');
  ba12.appendChild(mybox1);

  var b12 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b12.appendChild(myspace2);



  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="mmort[]";
  mybox1.onfocus = function() { makeform(); };
  //mybox1.id="age" +  index;
  var ba13 = document.createElement('td');
  ba13.appendChild(mybox1);

  var b13 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b13.appendChild(myspace2);


  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="mcull[]";
  mybox1.id="mcull" +  index;
  var ba14 = document.createElement('td');
  ba14.appendChild(mybox1);

  var b14 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b14.appendChild(myspace2);
    

  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="mweight[]";
  //mybox1.id="age" +  index;
  var ba15 = document.createElement('td');
  ba15.appendChild(mybox1);

  var b15 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b15.appendChild(myspace2);


  myselect1 = document.createElement("select");
  myselect1.style.width = "68px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "feedtype1[]";
  myselect1.id = "feedtype" + index;
  <?php
           include "config.php"; 
           $query = "SELECT * FROM ims_itemcodes where cat = 'Male Feed' and client = '$client'  ORDER BY code ASC ";
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
  var ba16 = document.createElement('td');
  ba16.appendChild(myselect1);
  var b16 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b16.appendChild(myspace2);

  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="feedqty1[]";
  //mybox1.id="age" +  index;
  var ba17 = document.createElement('td');
  ba17.appendChild(mybox1);

  var b17 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b17.appendChild(myspace2);


<?php
        $n = 0;
        include "config.php"; 
        $query = "SELECT * FROM ims_itemcodes where cat = 'Hatch Eggs' and (iusage='Produced or Sale' OR iusage='Produced') and client = '$client' ORDER BY code ASC ";
        $result = mysql_query($query,$conn); 
        while($row1 = mysql_fetch_assoc($result))
        {
 ?>
          mybox1=document.createElement("input");
          mybox1.size="3";
          mybox1.type="text";
          mybox1.name="<?php echo $row1['code']; ?>[]";
          //mybox1.id="age" +  index;
          var ma<?php echo $n; ?> = document.createElement('td');
          ma<?php echo $n; ?>.appendChild(mybox1);
   
          var m<?php echo $n; ?> = document.createElement('td');
          myspace2= document.createTextNode('\u00a0');
          m<?php echo $n; ?>.appendChild(myspace2);
 <?php $n = $n + 1; } ?>

 <?php
        $k = 0;
        include "config.php"; 
        $query = "SELECT * FROM ims_itemcodes where cat = 'Eggs' and client = '$client' and  (iusage='Produced or Sale' OR iusage='Produced or Rejected' OR iusage='Produced or Sale or Rejected') ORDER BY code ASC ";
        $result = mysql_query($query,$conn); 
        while($row1 = mysql_fetch_assoc($result))
        {
 ?>
          mybox1=document.createElement("input");
          mybox1.size="3";
          mybox1.type="text";
          mybox1.name="<?php echo $row1['code']; ?>[]";
          //mybox1.id="age" +  index;
          var la<?php echo $k; ?> = document.createElement('td');
          la<?php echo $k; ?>.appendChild(mybox1);
   
          var l<?php echo $k; ?> = document.createElement('td');
          myspace2= document.createTextNode('\u00a0');
          l<?php echo $k; ?>.appendChild(myspace2);
 <?php $k = $k + 1; } ?>

 
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
      r1.appendChild(ba11);
      r1.appendChild(b11);
      r1.appendChild(ba12);
      r1.appendChild(b12);
      r1.appendChild(ba13);
      r1.appendChild(b13);
      r1.appendChild(ba14);
      r1.appendChild(b14);
      r1.appendChild(ba15);
      r1.appendChild(b15);
      r1.appendChild(ba16);
      r1.appendChild(b16);
      r1.appendChild(ba17);
      r1.appendChild(b17);
      r1.appendChild(ba7);
      r1.appendChild(b7);
      r1.appendChild(ba10);
      r1.appendChild(b10);

      <?php for($m = 0;$m < $n;$m++) { ?>
      r1.appendChild(ma<?php echo $m; ?>);
      r1.appendChild(m<?php echo $m; ?>);
      <?php } ?>

      <?php for($i = 0;$i < $k;$i++) { ?>
      r1.appendChild(la<?php echo $i; ?>);
      r1.appendChild(l<?php echo $i; ?>);
      <?php } ?>
      t1.appendChild(r1);
}
}

function removeAllOptions(selectbox)
{
	var i;
	for(i=selectbox.options.length-1;i>=0;i--)
	{
		selectbox.options.remove(i);
		selectbox.remove(i);
	}
}

function loadcodes(cat)
{

var cat1 = document.getElementById(cat).value;
temp = cat.split("@");
tempindex = temp[1];
removeAllOptions(document.getElementById('item@' + tempindex));
		  var code2 = document.getElementById('item@' + tempindex);
		  theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
              theOption1.appendChild(theText1);
              code2.appendChild(theOption1);
removeAllOptions(document.getElementById('description@' + tempindex)); 
	var description = document.getElementById('description@' + tempindex); 
	theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("-Select-");
              theOption1.appendChild(theText1);
              description.appendChild(theOption1);
<?php 
			$q = "select distinct(type) from ims_itemtypes";
			$qrs = mysql_query($q) or die(mysql_error());
			while($qr = mysql_fetch_assoc($qrs))
			{
			echo "if(cat1 == '$qr[type]') {";

			$q1 = "select distinct(code),description from ims_itemcodes where cat = '$qr[type]' and (source = 'Purchased' or source = 'Produced or Purchased') order by code";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{
	?>
 theOption1=document.createElement("OPTION");
              theText1=document.createTextNode("<?php echo $q1r['code'];?>");
              theOption1.appendChild(theText1);
	        theOption1.value = "<?php echo $q1r['code'];?>";
	        theOption1.title = "<?php echo $q1r['description'];?>";
              code2.appendChild(theOption1);
<?php }

$q1 = "select distinct(code),description from ims_itemcodes where cat = '$qr[type]' and (source = 'Purchased' or source = 'Produced or Purchased') order by description";
			$q1rs = mysql_query($q1) or die(mysql_error());
			while($q1r = mysql_fetch_assoc($q1rs))
			{

?>
             theOption1=document.createElement("OPTION");
            theText1=document.createTextNode("<?php echo $q1r['description'];?>")
		     theOption1.appendChild(theText1);
	        theOption1.value = "<?php echo $q1r['description'];?>";
	        theOption1.title = "<?php echo $q1r['description'];?>";
              description.appendChild(theOption1);
<?php
			}
			echo "}";
			}
	?>


}

function getdesc(d)
{


var temp = d.split("@");
var tempindex = temp[1];
var item2=document.getElementById("cat@" + tempindex).value;
var item1 = document.getElementById(d).value;
 //alert(t);
removeAllOptions(document.getElementById("description@" + tempindex));
myselect1 = document.getElementById("description@" + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
myselect1.name = "description[]";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

myselect1.style.width = "170px";
<?php 
	     $query1 = "SELECT code,description,cat FROM ims_itemcodes ORDER BY code ";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
		   ?>
     	 <?php echo "if(item2 == '$row1[cat]') {"; ?>
		   theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['description']; ?>");
theOption1.value = "<?php echo $row1['description']; ?>";
theOption1.title = "<?php echo $row1['code']; ?>";

<?php echo "if(item1 == '$row1[code]') {"; ?>			
theOption1.selected = true;

<?php echo "}"; ?>
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

<?php echo "}"; ?>

<?php }  ?>
}


function selectcode(c)
{

var temp = c.split("@");
var tempindex = temp[1];
var item2 = document.getElementById("cat@" + tempindex).value;
var item1 = document.getElementById(c).value;


removeAllOptions(document.getElementById("item@" + tempindex));
myselect1 = document.getElementById("item@" + tempindex);
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
myselect1.name = "item[]";
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);

myselect1.style.width = "75px";
<?php 
	     $query1 = "SELECT code,description,cat FROM ims_itemcodes ORDER BY code ";
           $result1 = mysql_query($query1,$conn);
           while($row1 = mysql_fetch_assoc($result1))
           {
		   ?>
		   <?php echo "if(item2 == '$row1[cat]') {"; ?>
		   theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['code']; ?>");
theOption1.value = "<?php echo $row1['code']; ?>";
theOption1.title = "<?php echo $row1['description']; ?>";


     	<?php echo "if(item1 == '$row1[description]') {"; ?>
			
theOption1.selected = true;
<?php echo "}"; ?>
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
<?php echo "}"; ?>


<?php }  ?>
}



function makeform1()
{
if((document.getElementById('age1' + index1).value != "")&&(document.getElementById('age1' + index1).value != "0"))
{
  index1 = index1 + 1;
  var t1  = document.getElementById('inputs1');
  var r1 = document.createElement('tr'); 

 
  myselect1 = document.createElement("select");
  myselect1.style.width = "68px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "flock1[]";
  myselect1.id = "flock1" + index1;
  myselect1.onchange = function() { getflock1(this.value,index,this.id); };
  <?php
           include "config.php"; 
           $query = "select * from breeder_flock where client = '$client' and cullflag = 0 order by flockcode asc";
           $result = mysql_query($query,$conn); 
           while($row1 = mysql_fetch_assoc($result))
           {   
                   $query1a = "select distinct(wo) as 'wo',flock from breeder_woinputs where flock='$row1[flockcode]' and client = '$client'  ORDER BY wo ASC ";
                   $result1a = mysql_query($query1a,$conn);  
                   if(mysql_num_rows($result1a)) 
                   {
                      while($row11a = mysql_fetch_assoc($result1a))
                      {
                         $wo = $row11a['wo'];
                      }
                   }
                   else
                   {
                         $wo = $row1['flockcode'];
                   }

                   include "config.php"; 
                   $query1 = "SELECT * FROM breeder_consumption where flock = '$row1[flockcode]' and client = '$client'  ORDER BY date2 asc";
                   $result1 = mysql_query($query1,$conn); 
                   if(mysql_num_rows($result1))
                   {
                      while($row11 = mysql_fetch_assoc($result1))
                      {
                        $nextdate = $row11['date2'];
                        $t = strtotime($nextdate) + (24 * 60 * 60);
                        $nextdate = date("j.m.Y",$t);
                        $age = $row11['age'] + 1;
                        $nrSeconds = $age * 24 * 60 * 60;
                        $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
                        $nrWeeksPassed = floor($nrSeconds / 604800); 
                        $nrYearsPassed = floor($nrSeconds / 31536000); 
                      }
                  }
                  else
                  {
                        $query1 = "SELECT * FROM breeder_flock where flockcode = '$row1[flockcode]' and client = '$client' ";
                        $result1 = mysql_query($query1,$conn); 
                        while($row11 = mysql_fetch_assoc($result1))
                        {
                           $nextdate = $row11['startdate'];
                           $age = $row11['age'];
                           $nrSeconds = $age * 24 * 60 * 60;
                           $nrDaysPassed = floor($nrSeconds / 86400) % 7; 
                           $nrWeeksPassed = floor($nrSeconds / 604800); 
                           $nrYearsPassed = floor($nrSeconds / 31536000); 
                        }
                  }
             $q = "select * from breeder_flock where flockcode = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening = $qr['femaleopening'];
             }

            include "config.php";
            $q = "select * from breeder_flock where flockcode = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
               $q1 = "select * from breeder_shed where shedcode = '$qr[shedcode]' and client = '$client'  "; 
     		   $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
 		   while($qr1 = mysql_fetch_assoc($qrs1))
 		   {
                  $shedtype = $qr1['shedtype'];
               }
             }

             $q = "select * from breeder_flock where flockcode = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $fopening = $qr['femaleopening'];
             }
             
       $nexttdate1 = date("Y-m-d",strtotime($nextdate));
			
           $q123 = "select * from ims_stocktransfer where towarehouse =  '$row1[flockcode]' and date > '$nexttdate1'  "; 
    		 $qrs = mysql_query($q123,$conn);
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $datedummy = strtotime($qr['date']) + (24 * 60 * 60);
				$nextdate = date("d.m.Y",$datedummy);
				
				$q1 = "select max(age) as maxage from breeder_consumption where flock =  '$qr[fromwarehouse]'  "; 
    		 $qrs1 = mysql_query($q1,$conn) or die(mysql_error());
		 while($qr1 = mysql_fetch_assoc($qrs1))
		 {
		 $age = $qr1['maxage'] + 1;
		 
		 }
				
             }
 
             $minus = 0; 
             $q = "select distinct(date2),fmort,fcull from breeder_consumption where flock = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
		 while($qr = mysql_fetch_assoc($qrs))
		 {
                $minus = $minus + $qr['fmort'] + $qr['fcull'];
             }


             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Birds' and fromwarehouse = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ftransfer = $qr['quantity'];
               }
             }
             else
             {
                $ftransfer = 0;
             } 

             $q = "select sum(quantity) as 'quantity' from oc_cobi where flock = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $tsale = $qr['quantity'];
               }
             }
             else
             {
                $tsale = 0;
             } 


             $q = "select sum(quantity) as 'quantity' from ims_stocktransfer where cat = 'Birds' and towarehouse = '$row1[flockcode]' and client = '$client'  "; 
    		 $qrs = mysql_query($q,$conn) or die(mysql_error());
             if(mysql_num_rows($qrs))
             {
		   while($qr = mysql_fetch_assoc($qrs))
    		   {
                $ttransfer = $qr['quantity'];
               }
             }
             else
             {
                $ttransfer = 0;
             } 

             $remaining = ($fopening - $minus - $ftransfer + $ttransfer) - $tsale;

  ?>
		theOption=document.createElement("OPTION");
		theText=document.createTextNode("<?php if($_SESSION['client'] == "MRPF") { echo $row1['flockcode']."-".$row1['shedcode']; } else { echo $row1['flockcode']; } ?>");
		theOption.appendChild(theText);
            theOption.title = "<?php if($_SESSION['client'] == "MRPF") { echo $row1['flockcode']."-".$row1['shedcode']; } else { echo $row1['flockcode']; } ?>";
		theOption.value = "<?php echo $row1['flockcode']."@".$nextdate."@".$age."@".$wo."@".$remaining; ?>";
		myselect1.appendChild(theOption);
		
  <?php } ?>
  var ba1 = document.createElement('td');
  ba1.appendChild(myselect1);
  var b1 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b1.appendChild(myspace2);



  mybox1=document.createElement("input");
  mybox1.size="10";
  mybox1.type="text";
  mybox1.name="date1[]";
  mybox1.id="date1" +  index1;
  var ba2 = document.createElement('td');
  ba2.appendChild(mybox1);

  var b2 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b2.appendChild(myspace2);


  mybox1=document.createElement("input");
  mybox1.size="3";
  mybox1.type="text";
  mybox1.name="age1[]";
  mybox1.id="age1" +  index1;
  var ba3 = document.createElement('td');
  ba3.appendChild(mybox1);

  var b3 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b3.appendChild(myspace2);

myselect1 = document.createElement("select");
myselect1.name = "cat[]";
myselect1.id = "cat@" + index1;
myselect1.style.width = "100px";
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("-Select-");
theOption1.appendChild(theText1);
myselect1.appendChild(theOption1);
myselect1.onchange = function () { loadcodes(this.id); };
<?php 
                       $query = "SELECT distinct(type) FROM ims_itemtypes where type <> 'Broiler Birds' ORDER BY type";
                       $result = mysql_query($query); 
                       while($row1 = mysql_fetch_assoc($result))
                       {
?>
theOption1=document.createElement("OPTION");
theText1=document.createTextNode("<?php echo $row1['type']; ?>");
theOption1.appendChild(theText1);
theOption1.value = "<?php echo $row1['type']; ?>";
myselect1.appendChild(theOption1);
<?php } ?>
var type = document.createElement('td');
type.appendChild(myselect1);


 var b4 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b4.appendChild(myspace2);

  myselect1 = document.createElement("select");
  myselect1.style.width = "75px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "item1[]";
  myselect1.id = "item@" + index1;
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
  var ba11 = document.createElement('td');
  ba11.appendChild(myselect1);
  var b11 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b11.appendChild(myspace2);



myselect1 = document.createElement("select");
  myselect1.style.width = "170px";
  theOption1=document.createElement("OPTION");
  theText1=document.createTextNode('-Select-');
  theOption1.appendChild(theText1);
  myselect1.appendChild(theOption1);
  myselect1.name = "description[]";
  myselect1.id = "description@" + index1;
myselect1.onchange= function() { selectcode(this.id); };

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
  var ba13 = document.createElement('td');
  ba13.appendChild(myselect1);
  var b13 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b13.appendChild(myspace2);

  mybox1=document.createElement("input");
  mybox1.size="8";
  mybox1.type="text";
  mybox1.name="qty1[]";
  mybox1.onfocus= function() { makeform1(); };
  var ba12 = document.createElement('td');
  ba12.appendChild(mybox1);

  var b12 = document.createElement('td');
  myspace2= document.createTextNode('\u00a0');
  b12.appendChild(myspace2);

  
      r1.appendChild(ba1);
      r1.appendChild(b1);
      r1.appendChild(ba2);
      r1.appendChild(b2);
      r1.appendChild(ba3);
      r1.appendChild(b3);
r1.appendChild(type);
r1.appendChild(b4);
      r1.appendChild(ba11);
      r1.appendChild(b11);

r1.appendChild(ba13);
      r1.appendChild(b13);
      r1.appendChild(ba12);
      r1.appendChild(b12);
      t1.appendChild(r1);

}
}
</script>
</body>
</html>

