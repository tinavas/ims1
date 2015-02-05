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

<form id="form1" name="form1" method="post" action="Layer/layer_saverearingbookentry.php">
<?php $age=$_POST[age]; ?>
<br />

<center>
<strong>                   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Flock:</strong> &nbsp;&nbsp;&nbsp;
<input type="text"  name="flock" id="flock" value="<?php echo $_POST['flock']; ?>" size="20" />&nbsp;&nbsp;&nbsp;

<br /><br />

<table id="paraID" aling="center">

<tr align="center">
<th width="10px"></th>
<th><strong></strong></th>
<th width="15px"></th>
<th><strong></strong></th>
<th width="10px"></th>
<th><strong></strong></th>
<th width="10px"></th>


        <th><strong></strong></th>
        <th width="10px"></th>

<th ><strong></strong></th>
<th width="10px"></th>
<th><strong></strong></th>
<th width="10px"></th>
<th><strong></strong></th>
<th width="10px"></th>
<!--<th width="10px"></th>
<th ></th>-->
  <th style="text-align:left;" colspan="4"><strong style="color:red"><center>Temperature <br/>IN</center></strong></th>
		 <th style="text-align:left;" colspan="4"><strong style="color:red"><center>Temperature <br/>OUT</center></strong></th>
        <th style="text-align:left"><strong></strong></th>
<th width="10px"></th>
<th><strong></strong></th>

<th style="text-align:left" colspan="4"><strong style="color:red"><center>Consumption</center></strong></th>

<!--<th width="10px"></th>
<th style="text-align:center" colspan="16"><strong style="color:red"><center>Productions</center></strong></th>-->
</tr>

<tr height="10px"><td></td></tr>



<tr align="center">
<th width="10px"></th>
<th><strong>Flock</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="15px"></th>
<th><strong>Age</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th><strong>Date</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>


        <th title="Opening Birds"><strong>Birds</strong></th>
        <th width="10px"></th>

<th title="mortality"><strong>Mort.</strong></th>
<th width="10px"></th>
<th><strong>Culls</strong></th>
<th width="10px"></th>
<th title="Body Weight"><strong>B.Wt</strong></th>
<!--<th width="10px"></th>
<th title="Egg Weight"><strong>E.Wt</strong></th>-->
<th width="10px"></th>
 <th style="text-align:left;"><strong>Min</strong></th>
        <th  width="10px"></th>
        <th style="text-align:left;"><strong>Max</strong></th>
        <th  width="10px"></th>
		 <th style="text-align:left;"><strong>Min</strong></th>
        <th  width="10px"></th>
        <th style="text-align:left;"><strong>Max</strong></th>
        <th  width="10px"></th>
		<th style="text-align:left"><strong>Humidity</strong></th>
        <th width="10px"></th>
<th><strong>Water</strong></strong></th>
<th width="10px"></th>
<th><strong>Feed </strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>
<th width="10px"></th>
<th title="feed consumed"><strong>Kg's</strong><font style="color:red;font-weight:bold;padding-top:10px"><sup>*</sup></font></th>


<?php
            /* include "config.php"; 
             $query = "SELECT * FROM ims_itemcodes where cat = 'Layer Eggs' and client = '$client'  ORDER BY code ASC ";
             $result = mysql_query($query,$conn); 
             while($row1 = mysql_fetch_assoc($result))
             {
        ?>
        <th style="text-align:left" title="<?php echo $row1['description']; ?>"><strong><?php echo substr($row1['code'],3); ?></strong></th>
        <th width="10px"></th>
        <?php }*/ ?>


</tr>

<tr height="10px"><td></td></tr>

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
        /*  if ($col == "10") { $data10 = htmlentities($data, ENT_QUOTES); }
        if ($col == "11") { $data11 = htmlentities($data, ENT_QUOTES); }
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
           
          $totalcol = "9";
        
                if ($col == $totalcol)
                { ?>
				<tr  align="center">
<td width="10px"></td>
<td><input type="text" name="flock[]" id="flock0" size="16" value="<?php echo $_POST['flock'];?>" readonly /></td>
<td width="10px"></td>

 <?php if($_SESSION['client'] == "MRPF" || $_SESSION['client'] == "NITISHA") {
	   $displayage = $nrWeeksPassed.".".$nrDaysPassed; 
	   
	   }  ?>
<td><input type="text" name="age[]" id="age0" size="5" value="<?php echo $age++;?>" readonly/></td>

<td width="3"></td>
<td><input type="text" name="date0[]" id="date0" size="10" value="<?php echo date('d.m.Y',strtotime($data2));?>" readonly /></td>
<td width="10px"></td>

	   <td style="text-align:left;">
         <input type="text" name="obirds0[]" id="obirds0" value="<?php echo $remaining; ?>" size="5" readonly /> 
       </td>
       <td width="10px"></td>

<td><input type="text" name="fmort[]" id="fmort0" size="5" value="<?php echo $data3 ?>" /></td>
<td width="10px"></td>
<td><input type="text" name="fcull[]" id="fcull0" size="5" value="<?php echo $data4; ?>"  /></td>
<td width="10px"></td>
   
<td ><input type="text" name="fweight[]" id="fweight0" value="" size="5"/> </td>
<?php /*?><td width="10px"></td>
<td ><input type="text" name="eggwt[]" id="eggwt0" value="" size="5" /> </td><?php */?>
 <td width="10px"></td>
 
       <td style="text-align:left;">
         <input type="text" name="tempinmin[]" id="tempinmin0" value="<?php echo $data7; ?>" size="3" /> 
       </td>
       <td width="10px"  ></td>
       <td style="text-align:left;">
         <input type="text" name="tempinmax[]" id="tempinmax0" value="<?php echo $data8; ?>" size="3" /> 
       </td>
       <td width="10px"></td>
	    <td style="text-align:left;">
         <input type="text" name="tempoutmin[]" id="tempoutmin0" value="<?php echo $data7; ?>" size="3" /> 
       </td>
       <td width="10px" ></td>
       <td style="text-align:left;">
         <input type="text" name="tempoutmax[]" id="tempoutmax0" value="<?php echo $data8; ?>" size="3" /> 
       </td>
	   <td width="10px"></td>
       <td >
         <input type="text" name="humidity[]" id="humidity0" value="" size="5" /> 
       </td>
<td width="10px"></td>
<td><input type="text" name="water[]" id="water0" value="<?php echo $data9; ?>"  size="5" /></td>
<td width="10px"></td>
<td><select name="feedtype[]" id="feedtype0">
<option value="">-Select-</option>
	    
		<?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemcodes where cat = 'Layer Feed' and client = '$client'  ORDER BY code ASC ";
              $result = mysql_query($query,$conn); 
              while($row1 = mysql_fetch_assoc($result))
              {
           ?>
           <option <?php if($data5==$row1['code'])  echo 'selected="selected"'; ?> value="<?php echo $row1['code']; ?>" title="<?php echo $row1['description']; ?>"><?php echo $row1['code']; ?></option>
           <?php } ?>
		
</select>
</td>
<td width="10px"></td>
<td><input type="text" name="feedqty[]" id="feedqty0" size="5" value="<?php echo $data6; ?>"/></td>

<?php
             /*include "config.php"; 
             $query = "SELECT * FROM ims_itemcodes where cat = 'Layer Eggs' and client = '$client'  ORDER BY code ASC ";
             $result = mysql_query($query,$conn); 
             while($row1 = mysql_fetch_assoc($result))
             {
        ?>
       <td style="text-align:left;">
         <input type="text" name="<?php echo $row1['code']; ?>[]" id="value0" value="" size="5" /> 
       </td>
       <td width="10px"></td>
       <?php }*/ ?>


</tr> 

<?php }
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
        <th>&nbsp;</th>
		<th  style="text-align:left"><strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Description</strong></th>
        <th width="20px"></th>
		<th><strong>Quantity</strong></th>
     </tr>

     <tr style="height:20px"></tr>

   <tr>
 
       
         <td><input type="text" name="flock[]" id="flockp0" size="16" value="<?php echo $_GET['flock'];?>" readonly /></td>
      
       <td width="10px"></td>
       <td >
         <input type="text" name="date1[]" class="datepicker" id="datep0" value="<?php echo $displaydate;?>" size="10" /> 
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
         <select name="item1[]" id="itemp@0" style="width:90px;"  onchange="getdesc(this.id);">
           <option value="">-Select-</option>
           <?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemcodes where cat <> 'Layer Eggs' and cat <> 'Layer Feed' and cat <> 'Birds' and client = '$client'  ORDER BY code ASC ";
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
         <select name="description[]" id="description@0" style="width:170px;" onChange="selectcode(this.id);">
           <option value="">-Select-</option>
		   <?php
              include "config.php"; 
              $query = "SELECT * FROM ims_itemcodes where cat <> 'Eggs' and cat <> 'Feed' and cat <> 'Birds' and client = '$client'  ORDER BY code ASC ";
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
         <input type="text" name="qty1[]" id="qtyp0" value="" size="8" onFocus="makeform1();" /> 
       </td>
    </tr>

 
</table>
</center>
<br /><br />



<input type="submit" value="Save" id="Save" />&nbsp;&nbsp;&nbsp;<input type="button" value="Cancel" onClick="document.location='dashboardsub.php?page=tallysales';">


</center>
</form>
</body>
</html>