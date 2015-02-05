<!DOCTYPE html>
<html lang="en">
<head>
	<title>Tulasi Technologies - PMS</title>
	<meta charset="utf-8">
	<link href="css/reset.css" rel="stylesheet" type="text/css">
      <link href="css/common.css" rel="stylesheet" type="text/css">
	<link href="css/form.css" rel="stylesheet" type="text/css">
	<link href="css/standard.css" rel="stylesheet" type="text/css">
	<link href="css/960.gs.fluid.css" rel="stylesheet" type="text/css">
	<link href="css/simple-lists.css" rel="stylesheet" type="text/css">
	<link href="css/block-lists.css" rel="stylesheet" type="text/css">
	<link href="css/planning.css" rel="stylesheet" type="text/css">
	<link href="css/table.css" rel="stylesheet" type="text/css">
	<link href="css/calendars.css" rel="stylesheet" type="text/css">
	<link href="css/wizard.css" rel="stylesheet" type="text/css">
	<link href="css/gallery.css" rel="stylesheet" type="text/css">


	<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	<link rel="icon" type="image/png" href="favicon-large.png">
	
	<script type="text/javascript" src="js/html5.js"></script>
	<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="js/old-browsers.js"></script>
	<script type="text/javascript" src="js/jquery.accessibleList.js"></script>
	<script type="text/javascript" src="js/searchField.js"></script>
	<script type="text/javascript" src="js/common.js"></script>
	<script type="text/javascript" src="js/standard.js"></script>
	<script type="text/javascript" src="js/jquery.tip.js"></script>
	<script type="text/javascript" src="js/jquery.hashchange.js"></script>
	<script type="text/javascript" src="js/jquery.contextMenu.js"></script>
	<script type="text/javascript" src="js/jquery.modal.js"></script>
	<script type="text/javascript" src="js/list.js"></script>

	<link rel="stylesheet" href="js/base/jquery-ui-1.8.6.custom.css">

	<script src="js/jquery.ui.core.js"></script>
	<script src="js/jquery.ui.datepicker.js"></script>


	<!--[if lte IE 8]><script type="text/javascript" src="js/standard.ie.js"></script><![endif]-->
	
	<script  type="text/javascript" src="js/jquery.dataTables.min.js"></script>
	<script  type="text/javascript" src="js/jquery.datepick/jquery.datepick.min.js"></script>
	
	<!--<script type="text/javascript" src="http://www.google.com/jsapi"></script>
	<script type="text/javascript">
	
		google.load('visualization', '1', {'packages':['corechart']});
		
	</script>-->
	

</head>

<body>
<!--[if lt IE 9]><div class="ie"><![endif]-->
<!--[if lt IE 8]><div class="ie7"><![endif]-->
	
	<header><div class="container_12">
		
		<p id="skin-name"><small>Tulasi Technologies<br> P.M.S</small> <strong>2.0</strong></p>
		<!-- <div class="server-info">Server: <strong>Apache (unknown)</strong></div>
		<div class="server-info">Php: <strong>5.2.14</strong></div> -->
		
	</div></header>
	
	<nav id="main-nav">
		
		<ul class="container_12">
			<li class="home current"><a href="javascript:void(0)" title="Home">Home</a>
				<ul>
					<li class="current"><a href="javascript:void(0)" title="Dashboard">Dashboard</a></li>
					<li><a href="javascript:void(0)" title="My profile">My profile</a></li>
					<li><a href="javascript:void(0)" title="My settings">settings</a></li>
                              <li><a href="dashboard.php?page=home_logo" title="Report Header">Logo</a></li>
				</ul>
			</li>
			<li class="write"><a href="javascript:void(0)" title="Layer">Layer</a>
				<ul>
				  <li class="with-menu"><a href="javascript:void(0)" title="Layer">Layer</a>
						<div class="menu">
						  <img src="images/menu-open-arrow.png" width="16" height="16">
							<ul>
								<li class="icon_masters"><a href="javascript:void(0)">Masters</a>
									<ul>
										<li><a href="dashboard.php?page=breeder_breedermaster&m=farm" title="Farm Creation">Create Farm</a></li>
										<li><a href="dashboard.php?page=breeder_breedermaster&m=unit" title="Unit creation under a farm">Create Unit</a></li>
										<li><a href="dashboard.php?page=breeder_breedermaster&m=shed" title="Shed creation under a unit">Create Shed</a></li>
										<li><a href="dashboard.php?page=breeder_breedermaster&m=flock" title="Flock creation under a shed">Create Flock</a></li>
									</ul>
								</li>
								<li class="icon_masters"><a href="javascript:void(0)">Transactions</a>
									<ul>
										<li><a href="dashboard.php?page=breeder_bom" title="Bill Of Material">BOM</a></li>
										<li><a href="dashboard.php?page=breeder_workorder" title="Work Order">Work Order</a></li>
										<li><a href="dashboard.php?page=breeder_dailyconsumption" title="Daily Consumption">Daily Consumption</a></li>
										<li><a href="dashboard.php?page=breeder_dailyproduction" title="Daily Production">Daily Production</a></li>
										<li><a href="dashboard.php?page=breeder_pstandards" title="Production Standards">P.Standards</a></li>
										<li><a href="javascript:void(0)" title="Lighting">Lighting</a></li>
										<li><a href="javascript:void(0)" title="P.Objective">P.Objective</a></li>
										<li><a href="javascript:void(0)" title="Dis-Infection Details">Dis-Infection Details</a></li>
									</ul>
								</li>
								<li class="icon_masters"><a href="javascript:void(0)">Processing</a>
									<ul>
										<li><a href="javascript:void(0)" title="Flock Transfer">Flock Transfer</a></li>
									</ul>
								</li>
								<li class="icon_masters"><a href="javascript:void(0)">Reports</a>
									<ul>
										<li><a href="production/farmsmry.php" title="Farm Details" target="_NEW">Farm Details</a></li>
										<li><a href="production/unitsmry.php" title="Unit Details" target="_NEW">Unit Details</a></li>
										<li><a href="production/shedreportsmry.php" title="Shed Details" target="_NEW">Shed Details</a></li>
										<li><a href="production/flockreportsmry.php" title="Flock Details" target="_NEW">Flock Details</a></li>
										<li><a href="production/bomsmry.php" title="Bill Of Material" target="_NEW">Bill Of Material</a></li>
										<li><a href="production/workordersmry.php" title="Work Order" target="_NEW">Work Order</a></li>
										<li><a href="production/breedconsumptionsmry.php" title="Daily Consumption" target="_NEW">Daily Consumption</a></li>
										<li><a href="production/Productionsmry.php" title="Daily Production" target="_NEW">Daily Production</a></li>
										<li><a href="production/dailyreport.php" title="Daily Entry Report" target="_NEW">Daily Entry Report</a></li>
									</ul>
								</li>
						   </ul>
						</div>
                   </li>
				</ul>
			</li>
			
			<li class="feedmill"><a href="javascript:void(0)" title="Feedmill">Feedmill</a>
				<ul>
					<li><a href="dashboard.php?page=feed_feedformula" title="Feed Formula">Feed Formula</a></li>
					<li><a href="dashboard.php?page=feed_productionunit" title="Production Unit">Production Unit</a></li>
					<li><a href="dashboard.php?page=feed_nutrientstandards" title="Nutrient Standards">Nutrient Standards</a></li>
				</ul>
						
<!-- Accounts --->			
			<li class="accounts"><a href="javascript:void(0)" title="Accounts">Accounts</a>
				<ul>
					<li class="with-menu"><a href="javascript:void(0)" title="General Ledger">General Ledger</a>
							<div class="menu">
							<img src="images/menu-open-arrow.png" width="16" height="16">
							<ul>
								<li class="icon_masters"><a href="javascript:void(0)">Masters</a>
									<ul>
									  <li class="icon_blog"><a href="dashboard.php?page=ac_definefy">Define Financial Year</a></li>
                                      <li class="icon_blog"><a href="dashboard.php?page=ac_schedule">Define Schedule</a></li>
									  <li class="icon_building"><a href="dashboard.php?page=ac_coa">Chart of Accounts</a></li>
									  <li class="icon_computer"><a href="dashboard.php?page=ac_bankcashmasters">Bank/Cash Masters</a></li>
									  <li class="icon_computer"><a href="dashboard.php?page=ac_bankcashcoamapping">Bank / CoA Mapping</a></li>
									  <li class="icon_building"><a href="dashboard.php?page=ac_chequeseries">Cheque Series</a></li>
									</ul>
								</li>



								<li class="icon_transactions"><a href="javascript:void(0)">Transactions</a>
									<ul>
										<li class="icon_blog"><a href="dashboard.php?page=ac_pvoucher">Payment Voucher</a></li>
												<li class="icon_building"><a href="dashboard.php?page=ac_rvoucher">Receipt Voucher</a></li>
												<li class="icon_computer"><a href="dashboard.php?page=ac_jvoucher">Journal Voucher(Regular)</a></li>
												<li class="icon_building"><a href="javascript:void(0)">Journal Voucher(Recurring)</a></li>
									</ul>
								</li>
                                <li class="icon_processing"><a href="javascript:void(0)">Processing</a>
									<ul>
										<li class="icon_blog"><a href="dashboard.php?page=ac_bankreconciliation">Bank Reconciliation</a></li>
												<!--<li class="icon_building"><a href="javascript:void(0)">Bulk Authorization</a></li>
												<li class="icon_computer"><a href="javascript:void(0)">Cheque Printing</a></li>
												<li class="icon_building"><a href="javascript:void(0)">Cheque Reprinting</a></li>
												<li class="icon_computer"><a href="javascript:void(0)">Cheque Void/Bounce</a></li>-->
									</ul>
								</li>

								<li class="icon_reports"><a href="javascript:void(0)">Reports</a>
									<ul>
										<li class="icon_blog"><a href="dashboard.php?page=ac_balancesheet">Balance Sheet</a></li>
												<li class="icon_building"><a href="dashboard.php?page=ac_profitloss">Profit &amp; Loss</a></li>
												<li class="icon_computer"><a href="dashboard.php?page=ac_trialbalance">Trial Balance</a></li>
												<li class="icon_building"><a href="dashboard.php?page=ac_ledgerbalance">Ledger</a></li>
												<li class="icon_computer"><a href="production/coalist.php" target="_new">CoA List</a></li>
												<li class="icon_computer"><a href="javascript:void(0)">Journal Register</a></li>
									</ul>
								</li>
							</ul>
						</div>
                              </li>
                	</ul>
                  </li>
<!-- End of Accounts --->				  

<!-- P2P ---> 
     <li class="p2p"><a href="javascript:void(0)" title="Procure To Pay">P2P</a>
				<ul>
					<li class="with-menu"><a href="javascript:void(0)" title="Procure To Pay">Procure To Pay</a>
							<div class="menu">
							<img src="images/menu-open-arrow.png" width="16" height="16">
							<ul>
								<li class="icon_masters"><a href="javascript:void(0)">Masters</a>
									<ul>
                        				   <li class="icon_blog"><a href="dashboard.php?page=pp_supplier">Create Supplier</a></li>
                                                   <li class="icon_blog"><a href="dashboard.php?page=pp_taxmasters">Tax Masters</a></li>
                                                   <li class="icon_blog"><a href="dashboard.php?page=pp_vendorgroup">Vendor Group</a></li>
									</ul>
								</li>
								<li class="icon_transactions"><a href="javascript:void(0)">Transactions</a>
									<ul>
	                                  <li class="icon_address"><a href="dashboard.php?page=pp_purchaseindent">Purchase Request</a></li>
                					<li class="icon_address"><a href="dashboard.php?page=pp_purchaseorder">Purchase Order</a></li>
						            <li class="icon_address"><a href="dashboard.php?page=pp_gateentry">Gate Entry</a></li>
             						<li class="icon_address"><a href="dashboard.php?page=pp_qc">Quality Control</a></li>
 						            <li class="icon_address"><a href="dashboard.php?page=pp_goodsreceipt">Goods Receipt</a></li>
									<li class="icon_building"><a href="dashboard.php?page=pp_sobi">Supplier Order Invoice</a></li>
									<li class="icon_building"><a href="dashboard.php?page=pp_directpurchase">Direct Purchase</a></li>
									</ul>
								</li>
                                <li class="icon_processing"><a href="javascript:void(0)">Processing</a>
									<ul>
 										<li class="icon_computer"><a href="dashboard.php?page=pp_purchasereturn">Purchase Return</a></li>
										<li class="icon_building"><a href="dashboard.php?page=pp_payment">Payment</a></li>
										<li class="icon_computer"><a href="dashboard.php?page=pp_receipt">Receipt</a></li>
										<li class="icon_building"><a href="dashboard.php?page=pp_creditnote&type=Credit">Credit Note</a></li>
										<li class="icon_computer"><a href="dashboard.php?page=pp_creditnote&type=Debit">Debit Note</a></li>
									</ul>
								</li>

								<li class="icon_reports"><a href="javascript:void(0)">Reports</a>
									<ul>
										<li class="icon_blog"><a href="dashboard.php?page=pp_vendorstatement">Supplier Statement of Ac</a></li>
												<li class="icon_building"><a href="dashboard.php?page=pp_vendorledger">Supplier Ledger</a></li>
												<li class="icon_computer"><a href="dashboard.php?page=pp_vendorageing">Ageing Analysis</a></li>
									
									</ul>
								</li>
							</ul>
						</div>
                              </li>
                	</ul>
                  </li>


<!-- End of P2P --->  				  
<!-- O2C --->  	


    <li class="o2c"><a href="javascript:void(0)" title="Order To Cash">O2C</a>
				<ul>
					<li class="with-menu"><a href="javascript:void(0)" title="Order To Cash">Order To Cash</a>
							<div class="menu">
							<img src="images/menu-open-arrow.png" width="16" height="16">
							<ul>
								<li class="icon_masters"><a href="javascript:void(0)">Masters</a>
									<ul>
                        				<li class="icon_blog"><a href="dashboard.php?page=oc_customer">Create Customer</a></li>
                                                <li class="icon_blog"><a href="dashboard.php?page=oc_taxmasters">Tax Masters</a></li>
                                                <li class="icon_blog"><a href="dashboard.php?page=oc_customergroup">Customer Group</a></li>
									</ul>
								</li>
								<li class="icon_transactions"><a href="javascript:void(0)">Transactions</a>
									<ul>
	                                 <li class="icon_address"><a href="dashboard.php?page=oc_salesorder">Sales Order</a></li>
								<li class="icon_address"><a href="dashboard.php?page=packslip">Pack Slip</a></li>
								<li class="icon_building"><a href="dashboard.php?page=cobi">Customer Order Invoice</a></li>
								<li class="icon_building"><a href="dashboard.php?page=oc_directsales">Direct Sales</a></li>
									</ul>
								</li>
                                <li class="icon_processing"><a href="javascript:void(0)">Processing</a>
									<ul>
 										<li class="icon_computer"><a href="dashboard.php?page=oc_salesreturn">Sales Return</a></li>
												<li class="icon_building"><a href="dashboard.php?page=oc_payment">Payment</a></li>
												<li class="icon_computer"><a href="dashboard.php?page=oc_receipt">Receipt</a></li>
												<li class="icon_building"><a href="dashboard.php?page=oc_creditnote&type=Credit">Credit Note</a></li>
												<li class="icon_computer"><a href="dashboard.php?page=oc_creditnote&type=Debit">Debit Note</a></li>
									</ul>
								</li>

								<li class="icon_reports"><a href="javascript:void(0)">Reports</a>
									<ul>
										<li class="icon_blog"><a href="dashboard.php?page=">Customer Statement of Ac</a></li>
												<li class="icon_building"><a href="dashboard.php?page=oc_customerledger">Customer Ledger</a></li>
												<li class="icon_computer"><a href="dashboard.php?page=pp_vendorageing">Ageing Analysis</a></li>
									
									</ul>
								</li>
							</ul>
						</div>
                              </li>
                	</ul>
                  </li>
  
						    
<!-- End of O2C --->  				 
<!-- IMS --->  		
            <li class="ims"><a href="javascript:void(0)" title="Inventory Management System">IMS</a>
				<ul>
					<li class="with-menu"><a href="javascript:void(0)" title="Inventory">Inventory</a>
							<div class="menu">
							<img src="images/menu-open-arrow.png" width="16" height="16">
							<ul>
								<li class="icon_masters"><a href="javascript:void(0)">Masters</a>
									<ul>
                        				<li class="icon_address"><a href="dashboard.php?page=ims_itemcodes">Item Masters</a></li>
										<li class="icon_address"><a href="dashboard.php?page=admin_office">Offices</a></li>
									</ul>
								</li>
								<li class="icon_transactions"><a href="javascript:void(0)">Transactions</a>
									<ul>
	                                 <li class="icon_address"><a href="javascript:void(0)">Stock Reconcilation</a>
<li class="icon_blog"><a href="dashboard.php?page=ims_stocktransfer">Stock Transfer</a></li>
									 <li class="icon_blog"><a href="javascript:void(0)">Stock Adjustment</a></li>
									 <li class="icon_building"><a href="dashboard.php?page=ims_intermediatereceipt">Intermediate Receipt</a></li>
									 <li class="icon_computer"><a href="dashboard.php?page=ims_intermediateissue">Intermediate Issue</a></li>
									</ul>
								</li>
								<li class="icon_reports"><a href="javascript:void(0)">Reports</a>
									<ul>
									  <li class="icon_building"><a href="dashboard.php?page=ims_itemledger">Item Ledger</a></li>
  	 					<!--			 <li class="icon_blog"><a href="dashboard.php?page=imsselect1">Item wise by quantity</a></li>
									  <li class="icon_building"><a href="dashboard.php?page=imsselect1">Item wise by value</a></li>
									  <li><a href="production/stockreport1smry.php" title="Stock Report" target="_NEW">Stock Report</a></li>
									  <li class="icon_computer"><a href="javascript:void(0)">Reconcilation</a></li>-->
									</ul>
								</li>
							</ul>
						</div>
                              </li>
                	</ul>
                  </li>
  		
<!-- End of IMS --->			
<!-- HR --->	
             <li class="users"><a href="javascript:void(0)" title="Human Resources">HR</a>
				<ul>
					<li class="with-menu"><a href="javascript:void(0)" title="Human Resources">HR</a>
							<div class="menu">
							<img src="images/menu-open-arrow.png" width="16" height="16">
							<ul>
								<li class="icon_masters"><a href="javascript:void(0)">Masters</a>
									<ul>
                        				<li class="icon_address"><a href="dashboard.php?page=hr_employee">Create Employee</a></li>
  										<li class="icon_address"><a href="dashboard.php?page=hr_salaryparameters">Salary Parameters</a></li>
  										<li class="icon_address"><a href="dashboard.php?page=hr_holidays">Holidays</a></li>
									</ul>
								</li>
								<li class="icon_transactions"><a href="javascript:void(0)">Transactions</a>
									<ul>
									<li class="icon_address"><a href="dashboard.php?page=hr_attendance">Attendance</a>
									</ul>
								</li>
                                <li class="icon_processing"><a href="javascript:void(0)">Processing</a>
									<ul>
	                                 <li class="icon_address"><a href="dashboard.php?page=hr_salpayment">Salary Payment</a>
									</ul>
								</li>

								<li class="icon_reports"><a href="javascript:void(0)">Reports</a>
									<ul>
  	 								  <li class="icon_blog"><a href="javascript:void(0)">Attendance</a></li>
									  <li class="icon_building"><a href="javascript:void(0)">Driving License Holder</a></li>
									  <li class="icon_computer"><a href="javascript:void(0)">Employee</a></li>
									  <li class="icon_computer"><a href="javascript:void(0)">PAN Card Holder</a></li>
									  <li class="icon_computer"><a href="javascript:void(0)">Salary Parameters</a></li>
									  <li class="icon_computer"><a href="javascript:void(0)">Salary</a></li>
									  <li class="icon_computer"><a href="javascript:void(0)">Vehicle Holder</a></li>
									</ul>
								</li>
							</ul>
						</div>
                              </li>
                	</ul>
			</li> 
<!-- End of HR ---> 			
			<li class="comments"><a href="javascript:void(0)" title="Chat">Chat</a></li>
			<li class="backup"><a href="javascript:void(0)" title="Backup">Backup</a></li>
		</ul>
	</nav>
	<div id="sub-nav"><div class="container_12">
		
		<a href="javascript:void(0)" title="Help" class="nav-button"><b>Help</b></a>
	
		<form id="search-form" name="search-form" method="post" action="search.php">
			<input type="text" name="s" id="s" value="" title="Search admin..." autocomplete="off">
		</form>
	
	</div></div>
	<div id="status-bar"><div class="container_12">
	
		<ul id="status-infos">
			<li class="spaced">Logged as: <strong>Admin</strong></li>
			<li>
				<a href="javascript:void(0)" class="button" title="5 messages"><img src="images/icons/fugue/mail.png" width="16" height="16"> <strong>5</strong></a>
				<div id="messages-list" class="result-block">
					<span class="arrow"><span></span></span>
					
					<ul class="small-files-list icon-mail">
						<li>
							<a href="javascript:void(0)"><strong>Today</strong> Test<br>
							<small>From: Tulasi</small></a>
						</li>
					</ul>
					
					<p id="messages-info" class="result-info"><a href="javascript:void(0)">Go to inbox &raquo;</a></p>
				</div>
			</li>
			<li>
				<a href="javascript:void(0)" class="button" title="25 comments"><img src="images/icons/fugue/balloon.png" width="16" height="16"> <strong>25</strong></a>
				<div id="comments-list" class="result-block">
					<span class="arrow"><span></span></span>
					
					<ul class="small-files-list icon-comment">
						<li>
							<a href="javascript:void(0)"><strong>Today</strong> Test<br>
							<small>From: Tulasi</small></a>
						</li>
					</ul>
					
					<p id="comments-info" class="result-info"><a href="javascript:void(0)">Manage comments &raquo;</a></p>
				</div>
			</li>
			<li><a href="logout.php" class="button red" title="Logout"><span class="smaller">LOGOUT</span></a></li>
		</ul>
		
		<ul id="breadcrumb">
			<li><a href="javascript:void(0)" title="Home">Home</a></li>
			<li><a href="javascript:void(0)" title="Dashboard">Dashboard</a></li>
		</ul>
	
	</div></div>
	
	<div id="header-shadow"></div>

