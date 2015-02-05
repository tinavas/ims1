<html lang="en">
<head>
  <meta charset="utf-8">
  <title>jQuery UI Dialog - Modal form</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <script src="//code.jquery.com/jquery-1.10.2.js"></script>
  <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css">
  <style>
    body { font-size: 62.5%; }
    label, input { display:block; }
    input.text { margin-bottom:12px; width:95%; padding: .4em; }
    fieldset { padding:0; border:0; margin-top:25px; }
    h1 { font-size: 1.2em; margin: .6em 0; }
    div#users-contain { width: 350px; margin: 20px 0; }
    div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
    div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
    .ui-dialog .ui-state-error { padding: .3em; }
    .validateTips { border: 1px solid transparent; padding: 0.3em; }
  </style>
  <script>
  $(function() {
    var dialog, form,
 
      // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
      emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
      name = $( "#name" ),
      email = $( "#email" ),
      password = $( "#password" ),
      allFields = $( [] ).add( name ).add( email ).add( password ),
      tips = $( ".validateTips" );
 
    function updateTips( t ) {
      tips
        .text( t )
        .addClass( "ui-state-highlight" );
      setTimeout(function() {
        tips.removeClass( "ui-state-highlight", 1500 );
      }, 500 );
    }
 
    function checkLength( o, n, min, max ) {
      if ( o.val().length > max || o.val().length < min ) {
        o.addClass( "ui-state-error" );
        updateTips( "Length of " + n + " must be between " +
          min + " and " + max + "." );
        return false;
      } else {
        return true;
      }
    }
 
    function checkRegexp( o, regexp, n ) {
      if ( !( regexp.test( o.val() ) ) ) {
        o.addClass( "ui-state-error" );
        updateTips( n );
        return false;
      } else {
        return true;
      }
    }
 
    function addUser() {
      var valid = true;
      allFields.removeClass( "ui-state-error" );
 
      valid = valid && checkLength( name, "username", 3, 16 );
      valid = valid && checkLength( email, "email", 6, 80 );
      valid = valid && checkLength( password, "password", 5, 16 );
 
      valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter." );
      valid = valid && checkRegexp( email, emailRegex, "eg. ui@jquery.com" );
      valid = valid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );
 
      if ( valid ) {
        $( "#users tbody" ).append( "<tr>" +
          "<td>" + name.val() + "</td>" +
          "<td>" + email.val() + "</td>" +
          "<td>" + password.val() + "</td>" +
        "</tr>" );
        dialog.dialog( "close" );
      }
      return valid;
    }
 
    dialog = $( "#dialog-form" ).dialog({
      autoOpen: false,
      height: 300,
      width: 350,
      modal: true,
      buttons: {
        "Create an account": addUser,
        Cancel: function() {
          dialog.dialog( "close" );
        }
      },
      close: function() {
        form[ 0 ].reset();
        allFields.removeClass( "ui-state-error" );
      }
    });
 
    form = dialog.find( "form" ).on( "submit", function( event ) {
      event.preventDefault();
      addUser();
    });
 
    $( "#create-user" ).button().on( "click", function() {
      dialog.dialog( "open" );
    });
  });
  </script>
</head>
<body>
 
<div id="dialog-form" title="Create new user">
 
  <form>
    <fieldset>
	
<table align="center">
<tr>
<td><strong>Trnum</strong></td>
<td width="10px"></td>
<td><strong>Itemcode</strong></td>
<td width="10px"></td>
<td><strong>Quantity</strong></td>
<td width="10px"></td>
<td><strong>Amount</strong></td>
<td width="10px"></td>
<td><strong>CrDr</strong></td>
<td width="10px"></td>
<td><strong>Coacode</strong></td>
<td width="10px"></td>
<td><strong>Venname</strong></td>
<td width="10px"></td>
<td><strong>Warehouse</strong></td>
</tr>
<tr height="10px">
<?php 
echo $date=$_GET['date'];
 $wh=$_GET['warehouse'];
echo  $trnum=$_GET['trnum'];
echo $tr11=$_GET['type'];
$emp=$_GET['emp'];
$module=$_GET['module'];
if( $tr11!="")
{

//echo $tr11;

if($tr11=='Stock Transfer')
{
$type='STR';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select id from ims_stocktransfer where empname='$emp') and type='$type' and trnum='$trnum' order by date";
}
else if($tr11=='Stock Receive')
{
$type='SRC';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from ims_stockreceive where empname='$emp') and type='$type' and trnum='$trnum' order by date";
}
else if($tr11=='Stock Adjustment' && $module=='Inventory')
{
$type='STA';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select trnum from ims_stockadjustment where empname='$emp') and type='$type' order by date";
}
else if($tr11=='Intermediate Receipt')
{
$type='IR';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select trnum from ims_intermediatereceipt where riflag='R' and empname='$emp') and trnum='$trnum'  and type='$type' order by date";
}
else if($tr11=='Intermediate Issue')
{
$type='II';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select trnum from ims_intermediatereceipt where riflag='I' and empname='$emp') and type='$type' and trnum='$trnum'   order by date";
}
else if($tr11=='Payment Voucher')
{
$type='PV';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select transactioncode from ac_gl where voucher='P' and empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Receipt Voucher')
{
$type='RV';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select transactioncode from ac_gl where voucher='R' and empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Journal Voucher(Regular)')
{
$type='JV';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select transactioncode from ac_gl where voucher='J' and empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Direct Purchase')
{
$type='SOBI';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select so from pp_sobi where empname='$emp') and type='$type' and trnum='$trnum'   order by date";
}
else if($tr11=='Purchase Return')
{
$type='PRTN';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select trid from pp_purchasereturn where empname='$emp') and trnum='$trnum'  and type='$type' order by date";
}
else if($tr11=='Payment' && $module=='Procure To Pay')
{
$type='PMT';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from pp_payment where empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Receipt' && $module=='Procure To Pay')
{
$type='PPRCT';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from pp_receipt where empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Credit Note' && $module=='Procure To Pay')
{
$type='VCN';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from ac_crdrnote where mode='VCN' and empname='$emp') and type='$type' and trnum='$trnum'   order by date";
}
else if($tr11=='Debit Note' && $module=='Procure To Pay')
{
$type='VDN';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from ac_crdrnote where mode='VDN' and empname='$emp') and type='$type' and trnum='$trnum'   order by date";
}
else if($tr11=='Direct Sales')
{
$type='COBI';
 $q2="select * from ac_financialpostings where date='$date' and trnum in (select invoice from oc_cobi where empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Sales Return')
{
$type='SR';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select trid from oc_salesreturn where empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Payment' && $module=='Order To Cash')
{
$type='OCPMT';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from oc_payment where empname='$emp') and type='$type'  and trnum='$trnum'  order by date";
}
else if($tr11=='Receipt' && $module=='Order To Cash')
{
$type='RCT';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from oc_receipt where empname='$emp') and type='$type'  and trnum='$trnum'  order by date";
}
else if($tr11=='Credit Note' && $module=='Order To Cash')
{
$type='CCN';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from ac_crdrnote where mode='CCN' and empname='$emp') and type='$type' and trnum='$trnum'   order by date";
}
else if($tr11=='Debit Note' && $module=='Order To Cash')
{
$type='CDN';
$q2="select * from ac_financialpostings where date='$date' and trnum in (select tid from ac_crdrnote where mode='CDN' and empname='$emp') and type='$type' and trnum='$trnum'  order by date";
}
else if($tr11=='Production Unit')
{
 $q2="select * from ac_financialpostings where date='$date' and trnum in (select formula from product_productionunit where empname='$emp') and type in ('product Produced') and trnum='$trnum'   order by date,trnum";
}
else if($tr11=='Daily Packing')
{
 $q2="select * from ac_financialpostings where date='$date' and trnum in (select trnum from packing_dailypacking where addempname='$emp') and type in ('DPACK') and trnum='$trnum'  order by date";
}
else if($tr11=='Sales Receipt')
{
$q2="select * from ac_financialpostings where date='$date' and trnum in (select trnum from distribution_salesreceipt where addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp')) and type in ('DCOBIR') and trnum='$trnum'  order by date";
}
else if($tr11=='Receipt From Distributor')
{
$q2="select * from distribution_financialpostings where date='$date' and trnum in (select tid from distribution_receipt where addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp')) and type in ('DRCT') and trnum='$trnum'  order by date";
}
else if($tr11=='Stock Issue To Distributor')
{
$q2="select * from distribution_financialpostings where date='$date' and trnum in (select trnum from distribution_stockissuetodistributor where addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp')) and type in ('STDT') and trnum='$trnum'   order by date";
}
else if($tr11=='Stock Return From Distributor')
{
$q2="select * from distribution_financialpostings where date='$date' and trnum in (select trnum from distribution_stockreturnfromdistributor where addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp')) and type in ('RTDT') and trnum='$trnum'  order by date";
}
else if($tr11=='C&F Opening Stock')
{
$q2="select trnum,'CNF Opening Stock' as type,date, superstockist as warehouse from distribution_cnfopeningstock where date='$date' and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp'))  and trnum='$trnum'  order by date";
}
else if($tr11=='Sales Man Visits')
{
$q2="select trnum,'Sales Man Visits' as type,date, superstockist as warehouse from distribution_salesmanvisits where date='$date' and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp')) and trnum='$trnum'   order by date";
}
else if($tr11=='Stock Adjustment' && $module=='Distribution')
{
$q2="select trnum,'Stock Adjustment' as type,date, superstockist as warehouse from distribution_stockadjustment where date='$date' and trnum='$trnum'  and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp'))  order by date";
}
else if($tr11=='Distributor Stocks')
{
$q2="select trnum,'Distributor Stocks' as type,date, superstockist as warehouse from distribution_distributorstock where date='$date' and trnum='$trnum'  and (addempname='$emp' or addempname=(select employeename from common_useraccess where username='$emp'))  order by date";
}
else
{
$q2="select * from ac_financialpostings where date='$date' and empname='$emp' and type='$tr11' and trnum='$trnum' ";
}
$q2=mysql_query($q2,$conn1) or die(mysql_error());
while($r2=mysql_fetch_array($q2))
{ 
?>
<tr>
<td><?php echo $r2[trnum];?></td>
<td width="10px"></td>
<?php if($r2[itemcode]<>""){?>
<td><?php echo $r2[itemcode];?></td>
<td width="10px"></td>
<td><?php echo $r2[quantity];?></td>
<td width="10px"></td>
<?php } else {?>
<td>&nbsp;</td>
<td width="10px"></td>
<td>&nbsp;</td>
<td width="10px"></td><?php }?>
<td><?php echo $r2[amount];?></td>
<td width="10px"></td>
<td><?php echo $r2[crdr];?></td>
<td width="10px"></td>
<td><?php echo $r2[coacode];?></td>
<td width="10px"></td>
<td><?php echo $r2[venname];?></td>
<td width="10px"></td>
<td><?php echo $r2[warehouse];?></td>


</tr>
<?php

}
}
?>
</table>
    </fieldset>
  </form>
</div>
 

 
 
</body>
</html>