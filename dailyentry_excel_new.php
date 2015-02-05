<html>
<title>B.I.M.S</title>
<body bgcolor="#ECF1F5" >
<?php

 ini_set('display_errors', 0);
 ini_set('log_errors', 0);
 ini_set('error_reporting', E_ALL);

include 'ExcelExplorer2.php';
include "getemployee.php";
include "config.php";
$query = "";
if( $_FILES['excel_file'] &&
   ($_FILES['excel_file']['tmp_name'] != '') ) {

 $fsz = filesize($_FILES['excel_file']['tmp_name']);
 $fh = @fopen ($_FILES['excel_file']['tmp_name'],'rb');
 if( !$fh || ($fsz==0) )
  die('No file uploaded');
 $file = fread( $fh, $fsz );
 @fclose($fh);
 if( strlen($file) < $fsz )
  die('Cannot read the file');
} else {
 die('No file uploaded');
}

$ee = new ExcelExplorer;

switch ($ee->Explore($file)) {
 case 0:
  break;
 case 1:
  die('File corrupted or not in Excel 5.0 and above format');
 case 2:
  die('Unknown or unsupported Excel file version');
 default:
  die('ExcelExplorer give up');
}
 ?>
<form id="form1" name="form1" method="post" action="breeder_savebookentry_male.php">


<center> 
<strong>                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Flock:</strong> &nbsp;&nbsp;&nbsp;
<input type="text"  name="flock" id="flock"  size="20" />&nbsp;&nbsp;&nbsp;
</center>
<br /><br /> 
<table>
 <tr height="20px">
    <td></td>
  </tr>
  <tr>
    <th style=""><strong></strong></th>
    <th width="10px"></th>
    <th style=""><strong></strong></th>
    <th width="10px"></th>
    <th style=""><strong></strong></th>
    <th width="10px"></th>
    <th style=""><strong></strong></th>
    <th width="10px"></th>
    <th style="" colspan="3"><strong style="color:red">
      <center>
        Female
      </center>
    </strong></th>
    <th width="10px"></th>
    <th style=""><strong></strong></th>
    <th width="10px"></th>
    <th style=""><strong></strong></th>
    <th width="10px"></th>
    <th style=""><strong></strong></th>
    <th width="10px"></th>
    <th style=""><strong style="color:red">
      <center>
        Male
      </center>
    </strong></th>
    <th width="10px"></th>
   
    <th style=""><strong></strong></th>
    <th width="10px"></th>
    <th style=""><strong></strong></th>
    <th width="10px"></th>
    <th style=""><strong></strong></th>
    <th width="10px"></th>
	<th style=""><strong></strong></th>
    <th width="10px"></th>
    
	<th style="" style="text-align:center" colspan="16"><strong style="color:red"><center>Productions</center></strong></th>
<th width="10px"></th>
  </tr>
  
  <tr align="center">
    <th colspan="16"></th>
    <th style="font-size:10px"> 
    <th> 
    <th style="font-size:10px"> 
    <th> 
    <th  style="font-size:10px">&nbsp;</th>
    <!--<th></th>
<th width="10px"></th>
<th></th>
<th width="10px"></th>
<th></th>
<th width="10px"></th>
<th></th>
<th width="10px"></th>-->
  </tr>
  <tr>
    <th style=""><strong>Flock</strong></th>
    <th width="10px"></th>
    <th style=""><strong>Date</strong></th>
    <th width="10px"></th>
    <th style=""><strong>Age</strong></th>
    <th width="10px"></th>
    <th style=""><strong>Mort</font></strong></th>
    <th width="10px"></th>
    <th style=""><strong>Culls</strong></th>
    <th width="10px"></th>
    <th style=""><strong>B.Wt</strong></th>
    <th width="10px"></th>
    <th style=""><strong>Feed<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></th>
    <th width="10px"></th>
    <th style=""><strong>Kg's<font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></strong></th>
    <th width="10px"></th>
    <th style=""><strong>Mort</strong></th>
    <th width="10px"></th>
    <th style=""><strong>Culls</strong></th>
    <th width="10px"></th>
    <th style=""><strong>B.Wt</strong></th>
    <th width="10px"></th>
    <th style=""><strong>Feed</strong></th>
    <th width="10px"></th>
    <th style=""><strong>Kg's</strong></th>
    <th width="10px"></th>
    <th style=""><strong>E.Wt</strong></th>
    <th width="10px"></th>
    <th style=""><strong>Water</strong></th>
    <th width="10px"></th>
    <?php
             include "config.php"; 
             $query = "SELECT * FROM ims_itemcodes where cat = 'Hatch Eggs' and (iusage='Produced or Sale' OR iusage='Produced' ) and client = '$client'  ORDER BY code ASC ";
             $result = mysql_query($query,$conn); 
             while($row1 = mysql_fetch_assoc($result))
             {
        ?>
    <th style="" title="<?php echo $row1['description']; ?>"><strong><?php echo substr($row1['code'],2); ?></strong></th>
    <th width="10px"></th>
    <?php } ?>
    <?php
             include "config.php"; 
             $query = "SELECT * FROM ims_itemcodes where cat = 'Eggs' and client = '$client' and (iusage='Produced or Sale' OR iusage='Produced or Rejected' OR iusage='Produced or Sale or Rejected') ORDER BY code ASC ";
             $result = mysql_query($query,$conn); 
             while($row1 = mysql_fetch_assoc($result))
             {
        ?>
    <th style="" title="<?php echo $row1['description']; ?>"><strong><?php echo substr($row1['code'],2); ?></strong></th>
    <th width="10px"></th>
    <?php } ?>
  </tr>
<?php
for( $sheet=0; $sheet<$ee->GetWorksheetsNum(); $sheet++ ) {
  print 'Sheet: '.$ee->AsHTML($ee->GetWorksheetTitle($sheet))."<br>\n";
$bank = $ee->AsHTML($ee->GetWorksheetTitle($sheet));
$bank = substr_replace($bank,"",-4); 
?>
<?php

if( !$ee->IsEmptyWorksheet($sheet) ) {

 for($row=0; $row<=$ee->GetLastRowIndex($sheet); $row++) {
 
  if( !$ee->IsEmptyRow($sheet,$row) ) {

   for($col=0; $col<=$ee->GetLastColumnIndex($sheet); $col++) {

    if( !$ee->IsEmptyColumn($sheet,$col) ) {

     $data = $ee->GetCellData($sheet,$col,$row);
     $type = '';

     switch( $ee->GetCellType($sheet,$col,$row) ) {
      case 0:
       $type = 'Empty';
       break;
      case 7:
       $type = 'Blank';
       break;
      case 8:
       $type = 'Merged';
       break;
      case 1:
       $type = 'Number';
       break;
      case 3:
       $type = 'Text';
       $data = $ee->AsHTML($data);
       break;
      case 2:
       $type = 'Percentage';
       $data = (100*$data).'%';
       break;
      case 4:
       $type = 'Boolean';
       $data = ($data ? 'TRUE' : 'FALSE');
       break;
      case 5:
       $type = 'Error';
       switch( $data ) {
        case 0x00:
         $data = "#NULL!";
         break;
        case 0x07:
         $data = "#DIV/0";
         break;
        case 0x0F:
         $data = "#VALUE!";
         break;
        case 0x17:
         $data = "#REF!";
         break;
        case 0x1D:
         $data = "#NAME?";
         break;
        case 0x24:
         $data = "#NUM!";
         break;
        case 0x2A:
         $data = "#N/A!";
         break;
        default:
         $data = "#UNKNOWN";
         break;
       }
       break;
      case 6:
       $data = $data['string'];
       $type = 'Date';
       break;
      default:
       break;
     }
	 
if ( $row > 0 )
       {  
	  
	   
        if ($col == "0") { $data0 = htmlentities($data, ENT_QUOTES); }
        if ($col == "1") { $data1 = htmlentities($data, ENT_QUOTES); }
        if ($col == "2") { $data2 = htmlentities($data, ENT_QUOTES); }
        if ($col == "3") { $data3 = htmlentities($data, ENT_QUOTES); }
        if ($col == "4") { $data4 = htmlentities($data, ENT_QUOTES); }
        if ($col == "5") { $data5 = htmlentities($data, ENT_QUOTES); }
		if ($col == "6") { $data6 = htmlentities($data, ENT_QUOTES); }
		if ($col == "7") { $data7 = htmlentities($data, ENT_QUOTES); } 
		if ($col == "8") { $data8 = htmlentities($data, ENT_QUOTES); }
        if ($col == "9") { $data9= htmlentities($data, ENT_QUOTES); }
        if ($col == "10") { $data10 = htmlentities($data, ENT_QUOTES); }
      /*  if ($col == "11") { $data11 = htmlentities($data, ENT_QUOTES); }
        if ($col == "12") { $data12 = htmlentities($data, ENT_QUOTES); }
        if ($col == "13") { $data13 = htmlentities($data, ENT_QUOTES); }
		if ($col == "14") { $data14 = htmlentities($data, ENT_QUOTES); }
		if ($col == "15") { $data15 = htmlentities($data, ENT_QUOTES); }
		
		
       
	   if ($col == "16") { $data16 = htmlentities($data, ENT_QUOTES); } 
	   if ($col == "17") { $data17 = htmlentities($data, ENT_QUOTES); }
        if ($col == "18") { $data18 = htmlentities($data, ENT_QUOTES); }
        if ($col == "19") { $data19 = htmlentities($data, ENT_QUOTES); }
        if ($col == "20") { $data20 = htmlentities($data, ENT_QUOTES); }
        if ($col == "21") { $data21 = htmlentities($data, ENT_QUOTES); }
		if ($col == "22") { $data22 = htmlentities($data, ENT_QUOTES); }
		if ($col == "23") { $data23 = htmlentities($data, ENT_QUOTES); }   */
           
          $totalcol = "10";
        
                if ($col == $totalcol)
                {
				 // echo $data0.'<br>';	?>	 
				 
				 
				 
				   <tr  align="center">
       <td><input type="text" name="flock[]" id="flock0" size="16" value="<?php echo $data0 ?>" readonly /></td>
       <td width="10px"></td>
        <td style="text-align:left;"><input type="text" name="date[]" id="date0" value="<?php echo date('d.m.Y',strtotime($data1)); ?>" size="10" /></td>
    <td width="10px"></td>
    <td style="text-align:left;"><input type="text" name="age[]" id="age0" value="<?php echo $data2 ?>" size="3" />    </td>
    <td width="10px"></td>
    <td style="text-align:left;"><input type="text" name="fmort[]"  id="fmort0" value="<?php echo $data3 ?>" size="3" />    </td>
    <td width="10px"></td>
    <td style="text-align:left;"><input type="text" name="fcull[]" id="fcull0" value="<?php echo $data4 ?>" size="3" />    </td>
    <td width="10px"></td>
    <td style="text-align:left;"><input type="text" name="fweight[]" id="fweight0" value="" size="3" />    </td>
    <td width="10px"></td>
    <td style="text-align:left;"><select name="ffeedtype[]" id="ffeedtype0" >
      <option value="">-Select-</option>
      <?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemcodes where cat = 'Female Feed' and client = '$client'  ORDER BY code ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
      <option <?php if($row1['code']=='FD100' &&  $data6 !='' && $data6 > 0) echo 'selected="selected"'; ?> value="<?php echo $row1['code']; ?>" title="<?php echo $row1['description']; ?>"><?php echo $row1['code']; ?></option>
      <?php } ?>
    </select>    </td>
    <td ID='PAVAN' width="10px"></td>
    <td style="text-align:left;"><input type="text" name="ffeedqty[]" id="ffeedqty0" value="<?php echo $data6; ?>" size="3" />    </td>
    <td width="10px"></td>
    <td style="text-align:left;"><input type="text" name="mmort[]" id="mmort0" value="<?php echo $data7 ?>" size="3" onFocus="makeForm();" />    </td>
    <td width="10px"></td>
    <td style="text-align:left;"><input type="text" name="mcull[]" id="mcull0" value="<?php echo $data8 ?>" size="3" />    </td>
    <td width="10px"></td>
    <td style="text-align:left;"><input type="text" name="mweight[]" id="mweight0" value="" size="3" />    </td>
    <td width="10px"></td>
    <td style="text-align:left;"><select name="mfeedtype[]" id="mfeedtype0" >
      <option value="">-Select-</option>
      <?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemcodes where cat = 'Male Feed' and client = '$client'  ORDER BY code ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
      <option <?php if($row1['code']=='FD106' &&  $data10 !='' && $data10 > 0) echo 'selected="selected"'; ?> value="<?php echo $row1['code']; ?>" title="<?php echo $row1['description']; ?>"><?php echo $row1['code']; ?></option>
      <?php } ?>
    </select>    </td>
    <td width="10px"></td>
    <td style="text-align:left;"><input type="text" name="mfeedqty[]" id="mfeedqty0" value="<?php echo $data10 ?>" size="3" />    </td>
    <td width="10px"></td>
    <td style="text-align:left;"><input type="text" name="eggwt[]" id="eggwt0" value="" size="3" />    </td>
    <td width="10px"></td>
    <td style="text-align:left;"><input type="text" name="water[]" id="water0" value="" size="4" />    </td>
    <td width="10px"></td>
    <?php
             
             $query = "SELECT * FROM ims_itemcodes where cat = 'Hatch Eggs' and (iusage='Produced or Sale' OR iusage='Produced' ) and client = '$client'  ORDER BY code ASC ";
             $result = mysql_query($query,$conn); 
			 $i=10;
             while($row1 = mysql_fetch_assoc($result))
             {
			   
        ?>
    <td style="text-align:left;"><input type="text"  name="<?php echo $row1['code']; ?>[]" id="value0" value="" size="3" />   </td>
    <td width="10px"></td>
    <?php } ?>
    <?php
             
             $query = "SELECT * FROM ims_itemcodes where cat = 'Eggs' and client = '$client' and (iusage='Produced or Sale' OR iusage='Produced or Rejected' OR iusage='Produced or Sale or Rejected') ORDER BY code ASC ";
             $result = mysql_query($query,$conn); 
             while($row1 = mysql_fetch_assoc($result))
             { $data='data'.$i++;
        ?>
    <td style="text-align:left;"><input type="text" name="<?php echo $row1['code']; ?>[]" id="value10" value="" size="3" />   </td>
    <td width="10px"></td>
    <?php } ?>
  </tr>
				 
				 
	<?php 
				 
				}
}

    // print "Column: $col, row: $row, type: \"$type\", value: \"$data\"<br>\n";
     
          
        }
    }

   }

  }
  
  
 }
 else {
 // print "Empty sheet<br>\n";
} 

//End Of Feed Sales Import

// print "<hr>\n";
}
	/*	$fp = fopen ("production/importsales.sql","a");
		fwrite ($fp,$query);
		fclose ($fp); */

?>

</table>
<br />
<br /><br />
<center>
<h4 style="color:red">Other Items Consumed</h4><br />

<table border="0px" id="inputs1">


     <tr>
        
        <th width="20px"><strong>Flock</strong></th>
        
        <th width="20px"></th>
        
        <th><strong>Date</strong></th>
        <th width="20px"></th>
       <!-- <th><strong>Age</strong></th>
        <th width="20px"></th>-->
		<th><strong>Item</strong></th>

<th width="20px"></th>
	<th><strong>Description</strong></th>
        <th>&nbsp;</th>
		<th><strong>Quantity  </strong></th>
     </tr>

     <tr style="height:20px"></tr>

   <tr>
 
       
         <td><input type="text" name="flockp[]" id="flockp0" size="16" value="<?php echo $_GET['flock'];?>" readonly /></td>
      
       <td width="10px"></td>
       <td >
         <input type="text" name="datep[]" class="datepicker" id="datep0" value="<?php echo $displaydate;?>" size="10" /> 
       </td>
       <td width="10px"></td>
	   
	   
	   <?php
	   // if($_SESSION['client'] == "MRPF" || $_SESSION['client'] == "NITISHA") {
	  //$displayage = $nrWeeksPassed.".".$nrDaysPassed;
	   //}
	   ?>
	  

<!--<td  style="text-align:left;"><input type="text" name="age1[]" id="agep0" size="5" value="<?php /*?><?php echo $displayage;?><?php */?>" readonly/></td>

              <td width="10px"></td>-->
       <td style="text-align:left;">
         <select name="item1[]" id="item@-1" style="width:90px;" onChange="getdesc(this.id);" >

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
         <input type="text" name="qtyp[]" id="qtyp0" value="" size="8" onFocus="makeform1();" /> 
       </td>
    </tr>

 
</table>


<center>
<br />
<br />
<input type="submit" value="Save" id="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=tallysales';">


</center>
</form>
</body>
</html>