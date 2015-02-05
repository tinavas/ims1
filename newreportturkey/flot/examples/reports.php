<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>B.I.M.S</title>

<script src="sorttable.js" type="text/javascript"></script>
<style type="text/css">
body{font-family:"Lucida Sans Unicode", "Lucida Grande", Verdana, Arial, Helvetica, sans-serif; font-size:12px; color:#555555;}
div.main{margin:30px auto; overflow:auto; width:700px;height:300px}
table.sortable{border:0; padding:0; margin:0;}
table.sortable td{padding:4px; width:120px; border-bottom:solid 1px #DEDEDE;}
table.sortable th{padding:4px;}
table.sortable thead{background:#e3edef; color:#333333; text-align:left;}
table.sortable tfoot{font-weight:bold; }
table.sortable tfoot td{border:none;}
</style>
</head>

<body>
<br />
<ol type="1">
<?php if($_GET['id'] == "admin") { ?>
<h2>Reports</h2>
<li ><a href="report/Banksmry.php" target="_new" style="text-decoration:none;color:#0D677F">Bank Details</a></li>
<li ><a href="report/Quest2smry.php" target="_new" style="text-decoration:none;color:#0D677F">Bank Statement</a></li>
<li ><a href="report/breedsmry.php" target="_new" style="text-decoration:none;color:#0D677F">Breed Details</a></li>
<li ><a href="report/contactdetailsrpt.php" target="_new" style="text-decoration:none;color:#0D677F">Contact Details</a></li>
<li ><a href="report/Expensessmry.php" target="_new" style="text-decoration:none;color:#0D677F">Expenditure Details</a></li>
<li ><a href="report/Fforsmry.php" target="_new" style="text-decoration:none;color:#0D677F">Feed Formulae Details</a></li>
<li ><a href="report/Ingsmry.php" target="_new" style="text-decoration:none;color:#0D677F">Ingredients Details</a></li>
<li ><a href="report/Medsmry.php" target="_new" style="text-decoration:none;color:#0D677F">Medicine Details</a></li>
<li ><a href="report/Composmry.php" target="_new" style="text-decoration:none;color:#0D677F">Nutrition Composition Details</a></li>
<li ><a href="report/Standsmry.php" target="_new" style="text-decoration:none;color:#0D677F">Nutrition Standards Details</a></li>
<li ><a href="report/Incomesmry.php" target="_new" style="text-decoration:none;color:#0D677F">Income Type Details</a></li>
<li ><a href="report/Prostansmry.php" target="_new" style="text-decoration:none;color:#0D677F">Production Standard Details</a></li>
<li ><a href="report/Paymentsmry.php" target="_new" style="text-decoration:none;color:#0D677F">Payment Report</a></li>
<li ><a href="report/Sale1smry.php" target="_new" style="text-decoration:none;color:#0D677F">Sale Report</a></li>
<li ><a href="report/Stocksmry.php" target="_new" style="text-decoration:none;color:#0D677F">Stock Report</a></li>
<?php } ?>
<?php if($_GET['id'] == "feedmill") { ?>
<h2>Reports</h2>
<li ><a href="report/Feed_Millsmry.php" target="_new" style="text-decoration:none;color:#0D677F">Feed Mill</a></li>
<li ><a href="report/feedconsumptionsmry.php" target="_new" style="text-decoration:none;color:#0D677F">Feed wise ingredient consumed Report</a></li>
<li ><a href="report/Productionsmry.php" target="_new" style="text-decoration:none;color:#0D677F">Production Report</a></li>
<li ><a href="report/LabReportsmry.php" target="_new" style="text-decoration:none;color:#0D677F">Lab Report</a></li>
<?php } ?>
<?php if($_GET['id'] == "breeder") { ?>
<h2>Reports</h2>
<li ><a href="report/Daily_Entrysmry34.php" target="_new" style="text-decoration:none;color:#0D677F">Breeder Daily Entry</a></li>
<li ><a href="report/daily.php" target="_new" style="text-decoration:none;color:#0D677F">Breeder Daily Entry Date Wise</a></li>
<li ><a href="report/cvanalysisreport1smry.php" target="_new" style="text-decoration:none;color:#0D677F">C.V.Analysis</a></li>
<li ><a href="report/disinfectionsmry.php" target="_new" style="text-decoration:none;color:#0D677F">Disinfection Details</a></li>
<?php } ?>
<?php if($_GET['id'] == "broiler") { ?>
<h2>Reports</h2>
<li ><a href="report/broiler/dailyentry.php" target="" style="text-decoration:none;color:#0D677F">Broiler Daily Entry</a></li>
<li ><a href="report/broiler/daywisefeedsmry.php" target="_new" style="text-decoration:none;color:#0D677F">Day Wise Feed Remaining</a></li>
<li ><a href="report/broiler/daywisefeedmortality1smry.php" target="_new" style="text-decoration:none;color:#0D677F">Day Wise Feed & Mortality</a></li>
<!--<li ><a href="report/broiler/feedissued.php" target="_new" style="text-decoration:none;color:#0D677F">Feed Issued</a></li>-->
<li ><a href="report/broiler/freturnsmry.php" target="_new" style="text-decoration:none;color:#0D677F">Feed Return</a></li>
<li ><a href="report/broiler/ftransfersmry.php" target="_new" style="text-decoration:none;color:#0D677F">Feed Transfer</a></li>
<li ><a href="report/broiler/flocksale.php" target="_new" style="text-decoration:none;color:#0D677F">Flock Sale</a></li>
<li ><a href="report/broiler/medvacdetailssmry.php" target="_new" style="text-decoration:none;color:#0D677F">Medicine/Vaccine Details</a></li>
<li ><a href="report/broiler/mortalitysmry.php" target="_new" style="text-decoration:none;color:#0D677F">Mortality Summary</a></li>
<li ><a href="report/broiler/flockidentificationsmry.php" target="_new" style="text-decoration:none;color:#0D677F">Parent Flock Identification</a></li>
<li ><a href="realization.php" target="" style="text-decoration:none;color:#0D677F">Realization Cost/Farmer</a></li>
<li ><a href="report/broiler/traderwise.php" target="_new" style="text-decoration:none;color:#0D677F">Trade Wise Report</a></li>
<li ><a href="report/broiler/unusualmortality11smry.php" target="_new" style="text-decoration:none;color:#0D677F">Unusaul Mortality</a></li>
<li ><a href="report/broiler/vaccinesch.php" target="_new" style="text-decoration:none;color:#0D677F">Vaccination Schedule</a></li>
<li ><a href="report/broiler/weeksmry.php" target="_new" style="text-decoration:none;color:#0D677F">Weekly Body Weight Report</a></li>
<li ><a href="report/broiler/weightcmp.php" target="_new" style="text-decoration:none;color:#0D677F">Weight Comparision Report</a></li>
<?php } ?>
<?php if($_GET['id'] == "hatchery") { ?>
<h2>Reports</h2>
<li ><a href="report/Tray_Settingssmry.php" target="_new" style="text-decoration:none;color:#0D677F">Tray Settings</a></li>
<li ><a href="report/Hatch_Record_Reportsmry.php" target="_new" style="text-decoration:none;color:#0D677F">Hatch Record</a></li>
<?php } ?>
</ol>

<ol type="1">
<?php if($_GET['id'] == "admingraph") { ?>
<h2>Graphs</h2>
<li ><a href="report/flot/examples/dual-axis1.php" target="_new" style="text-decoration:none;color:#0D677F">Comparision of BodyWeights</a></li>
<li ><a href="report/flot/examples/productionstandardgraph.php" target="_new" style="text-decoration:none;color:#0D677F">Production Graph</a></li>
<li ><a href="report/flot/examples/fcrweight.php" target="" style="text-decoration:none;color:#0D677F">F.C.R & Average Body Weight Graph</a></li>
<?php } ?>
<?php if($_GET['id'] == "feedmillgraph") { ?>
<h2>Graphs</h2>
<?php } ?>
<?php if($_GET['id'] == "breedergraph") { ?>
<h2>Graphs</h2>
<li ><a href="report/flot/examples/dual-axis1.php" target="_new" style="text-decoration:none;color:#0D677F">Comparision of BodyWeights</a></li>
<li ><a href="report/flot/examples/productionstandardgraph.php" target="_new" style="text-decoration:none;color:#0D677F">Production Graph</a></li>
<?php } ?>
<?php if($_GET['id'] == "broilergraph") { ?>
<h2>Graphs</h2>
<li ><a href="report/flot/examples/fcrweight.php" target="" style="text-decoration:none;color:#0D677F">F.C.R & Average Body Weight Graph</a></li>
<?php } ?>
<?php if($_GET['id'] == "hatcherygraph") { ?>
<h2>Graphs</h2>
<li ><a href="hatchgraphs.php?graph=float/examples/flocks.php" target="_new" style="text-decoration:none;color:#0D677F">Flock Performance Report</a></li>
<?php } ?>

</ol>
</body>
</html>