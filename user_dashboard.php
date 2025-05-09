<?php
session_start(); // start session to access save data
require 'php/database.php'; // connect to db to get data
require 'php/customer.php'; // get customer data from the database

// check if the user logged in properly
if (!isset($_SESSION['logged'])) {
    echo "<script>alert('You are not authorized')</script>";
    header("Location: index.php");
    exit;
}

if (isset($_SESSION['customer_id']) && !empty($_SESSION['customer_id'])) {
	$customer_id = $_SESSION['customer_id']; // get customer_id from session
	$customer = new Customer($conn); // create a new customer object
	$billing = $customer->getCustomerBilling($customer_id); // Get billing data from the database
	$chartData = $customer->getChartBillingData($customer_id); // Get chart data from the database
} else {
    echo "<script>alert('Illegal system entry');</script>";
}

?>
<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<div class="dashboard">
	<aside class="search-wrap">
		<div class="search">
			<label for="search">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M10 18a7.952 7.952 0 0 0 4.897-1.688l4.396 4.396 1.414-1.414-4.396-4.396A7.952 7.952 0 0 0 18 10c0-4.411-3.589-8-8-8s-8 3.589-8 8 3.589 8 8 8zm0-14c3.309 0 6 2.691 6 6s-2.691 6-6 6-6-2.691-6-6 2.691-6 6-6z"/></svg>
				<input type="text" id="search">
			</label>
		</div>
		<!-- User actions -->
		<div class="user-actions">
			<button>
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M13.094 2.085l-1.013-.082a1.082 1.082 0 0 0-.161 0l-1.063.087C6.948 2.652 4 6.053 4 10v3.838l-.948 2.846A1 1 0 0 0 4 18h4.5c0 1.93 1.57 3.5 3.5 3.5s3.5-1.57 3.5-3.5H20a1 1 0 0 0 .889-1.495L20 13.838V10c0-3.94-2.942-7.34-6.906-7.915zM12 19.5c-.841 0-1.5-.659-1.5-1.5h3c0 .841-.659 1.5-1.5 1.5zM5.388 16l.561-1.684A1.03 1.03 0 0 0 6 14v-4c0-2.959 2.211-5.509 5.08-5.923l.921-.074.868.068C15.794 4.497 18 7.046 18 10v4c0 .107.018.214.052.316l.56 1.684H5.388z"/></svg>
			</button>
			<a href="php/logout.php"><button>
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 21c4.411 0 8-3.589 8-8 0-3.35-2.072-6.221-5-7.411v2.223A6 6 0 0 1 18 13c0 3.309-2.691 6-6 6s-6-2.691-6-6a5.999 5.999 0 0 1 3-5.188V5.589C6.072 6.779 4 9.65 4 13c0 4.411 3.589 8 8 8z"/><path d="M11 2h2v10h-2z"/></svg>
			</button>
            </a>
		</div>
	</aside>
	
	<header class="menu-wrap">
		<figure class="user">
			<div class="user-avatar">
				<img src="https://images.unsplash.com/photo-1440589473619-3cde28941638?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=42ebdb92a644e864e032a2ebccaa25b6&auto=format&fit=crop&w=100&q=80" alt="Amanda King">
			</div>
			<figcaption>
                <?php echo $_SESSION['username']; ?>
			</figcaption>
		</figure>
	
		<nav>
		
			<section class="tools">
				<h3>Tools</h3>
				<ul>
					<li>
						<a href="user_dashboard.php" class="active">
						<svg width="24" height="24" viewBox="0 0 24.00 24.00" fill="none" xmlns="http://www.w3.org/2000/svg" stroke="#b6bbc6" stroke-width="0.00024000000000000003"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round" stroke="#CCCCCC" stroke-width="0.048"></g><g id="SVGRepo_iconCarrier"> <path fill-rule="evenodd" clip-rule="evenodd" d="M21.4498 10.275L11.9998 3.1875L2.5498 10.275L2.9998 11.625H3.7498V20.25H20.2498V11.625H20.9998L21.4498 10.275ZM5.2498 18.75V10.125L11.9998 5.0625L18.7498 10.125V18.75H14.9999V14.3333L14.2499 13.5833H9.74988L8.99988 14.3333V18.75H5.2498ZM10.4999 18.75H13.4999V15.0833H10.4999V18.75Z" fill="#b6bbc6"></path> </g></svg>
							Home
						</a>
					</li>
					     
					<li>
						<a href="messages.php">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21 4H3a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V5a1 1 0 0 0-1-1zm-1 14H4V9.227l7.335 6.521a1.003 1.003 0 0 0 1.33-.001L20 9.227V18zm0-11.448l-8 7.11-8-7.111V6h16v.552z"/></svg>
							Messages
						</a>
					</li>
					<li>
						<a href="invoice.php">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M21,3h-4V2h-2v1H9V2H7v1H3C2.447,3,2,3.447,2,4v17c0,0.553,0.447,1,1,1h18c0.553,0,1-0.447,1-1V4C22,3.447,21.553,3,21,3z M7,5v1h2V5h6v1h2V5h3v3H4V5H7z M4,20V10h16v10H4z"/><path d="M11,15.586l-1.793-1.793l-1.414,1.414l2.5,2.5C10.488,17.902,10.744,18,11,18s0.512-0.098,0.707-0.293l5-5l-1.414-1.414 L11,15.586z"/></svg>
							Invoice
						</a>
					</li>
				</ul>
			</section>

		</nav>
	</header>
	
	<main class="content-wrap">
		<div class="content">
			<section class="info-boxes">
			<div class="info-box">
					<div class="box-icon">
						<svg fill="#99a0b0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill-rule="evenodd" d="M16.168 2.924L4.51 13.061a.25.25 0 00.164.439h5.45a.75.75 0 01.692 1.041l-2.559 6.066 11.215-9.668a.25.25 0 00-.164-.439H14a.75.75 0 01-.687-1.05l2.855-6.526zm-.452-1.595a1.341 1.341 0 012.109 1.55L15.147 9h4.161c1.623 0 2.372 2.016 1.143 3.075L8.102 22.721a1.149 1.149 0 01-1.81-1.317L8.996 15H4.674c-1.619 0-2.37-2.008-1.148-3.07l12.19-10.6z"></path></g></svg>
					</div>
					
					<div class="box-content">
						<span class="big"><?php foreach ($billing as $bill) { echo $bill['kWh_usage']; } ?></span>
						Electricity usage (kWh)
					</div>
				</div>

				<div class="info-box">
					<div class="box-icon">
					<svg fill="#99a0b0" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path fill-rule="evenodd" d="M16.168 2.924L4.51 13.061a.25.25 0 00.164.439h5.45a.75.75 0 01.692 1.041l-2.559 6.066 11.215-9.668a.25.25 0 00-.164-.439H14a.75.75 0 01-.687-1.05l2.855-6.526zm-.452-1.595a1.341 1.341 0 012.109 1.55L15.147 9h4.161c1.623 0 2.372 2.016 1.143 3.075L8.102 22.721a1.149 1.149 0 01-1.81-1.317L8.996 15H4.674c-1.619 0-2.37-2.008-1.148-3.07l12.19-10.6z"></path></g></svg>
					</div>
					
					<div class="box-content">
						<span class="big"><?php foreach ($billing as $bill) { echo $bill['electric_bill']; } ?></span>
						Electric Bill (MWK)
					</div>
				</div>

				<div class="info-box">
					<div class="box-icon">
						<svg fill="#99a0b0" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 371.409 371.409" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M270.265,149.448c-36.107-47.124-70.38-78.948-73.439-141.372c0-1.836-0.612-3.06-1.836-4.284 c-0.612-3.06-3.672-4.896-6.732-3.06c-3.672,0-6.731,2.448-6.731,6.732c-77.112,83.232-207.468,294.372-43.452,354.959 c74.052,27.541,157.896-9.791,172.584-90.576C318.614,228.396,295.969,182.497,270.265,149.448z M138.686,323.256 c-17.748-10.404-28.764-31.211-34.272-49.572c-2.448-9.18-3.672-18.359-3.06-27.539c3.672-15.912,8.568-31.213,14.076-46.512 c3.06,13.463,9.18,26.928,17.748,36.719c19.584,21.422,59.364,34.273,70.38,61.201c6.732,16.523-19.584,30.6-30.6,34.271 C161.33,335.496,148.477,329.377,138.686,323.256z"></path> </g> </g></svg>
					</div>
					
					<div class="box-content">
						<span class="big"><?php foreach ($billing as $bill) { echo $bill['water_usage']; } ?></span>
						Water usage (L)
					</div>
				</div>
				
				<div class="info-box">
					<div class="box-icon">
					<svg fill="#99a0b0" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" viewBox="0 0 371.409 371.409" xml:space="preserve"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path d="M270.265,149.448c-36.107-47.124-70.38-78.948-73.439-141.372c0-1.836-0.612-3.06-1.836-4.284 c-0.612-3.06-3.672-4.896-6.732-3.06c-3.672,0-6.731,2.448-6.731,6.732c-77.112,83.232-207.468,294.372-43.452,354.959 c74.052,27.541,157.896-9.791,172.584-90.576C318.614,228.396,295.969,182.497,270.265,149.448z M138.686,323.256 c-17.748-10.404-28.764-31.211-34.272-49.572c-2.448-9.18-3.672-18.359-3.06-27.539c3.672-15.912,8.568-31.213,14.076-46.512 c3.06,13.463,9.18,26.928,17.748,36.719c19.584,21.422,59.364,34.273,70.38,61.201c6.732,16.523-19.584,30.6-30.6,34.271 C161.33,335.496,148.477,329.377,138.686,323.256z"></path> </g> </g></svg>
					</div>
					
					<div class="box-content">
						<span class="big"><?php foreach ($billing as $bill) { echo $bill['water_bill']; } ?></span>
						Water Bill (MWK)
					</div>
				</div>
				
				<div class="info-box">
					<div class="box-icon">
						<svg width="24px" height="24px" viewBox="0 0 1024 1024" class="icon" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="#96a0b0" stroke="#96a0b0"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M917.52 369.86L594.24 98.59l-98.62 117.52-181.15-67.54-124.33 290.24h-80.28V914h804.57V438.81h-54.78l57.87-68.95zM603.24 201.62l211.25 177.23-50.33 59.96H404.21l199.03-237.19z m-248.99 39.84l91.47 34.1-136.98 163.25h-39.01l84.52-197.35z m487.04 599.39H183.01v-328.9H841.3v328.9z" fill="99A0B0"></path><path d="M621.68 640.96h146.29v73.14H621.68z" fill="99A0B0"></path></g></svg>	
					</div>
					
					<div class="box-content">
						<span class="big"><?php foreach ($billing as $bill) { echo $bill['total_bill']; } ?></span>
						Total bill (MWK)
					</div>
				</div>
				
				<div class="info-box">
					<div class="box-icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 3C6.486 3 2 6.364 2 10.5c0 2.742 1.982 5.354 5 6.678V21a.999.999 0 0 0 1.707.707l3.714-3.714C17.74 17.827 22 14.529 22 10.5 22 6.364 17.514 3 12 3zm0 13a.996.996 0 0 0-.707.293L9 18.586V16.5a1 1 0 0 0-.663-.941C5.743 14.629 4 12.596 4 10.5 4 7.468 7.589 5 12 5s8 2.468 8 5.5-3.589 5.5-8 5.5z"/></svg>
					</div>
					
					<div class="box-content">
						<span class="big">24</span>
						Conversations
					</div>
				</div>
			</section>
		
			<section class="charts">
				<div class="chart">
					<h3>Water and Electric Usage</h3>
					<div id="chartContainer" style="height: 370px; width: 100%;"></div>
						<script>
							window.onload = function () {
							
							var chart = new CanvasJS.Chart("chartContainer", {
								animationEnabled: true,
								exportEnabled: true,
								theme: "light1", // "light1", "light2", "dark1", "dark2"
								// title:{
								// 	text: "Billing Data"
								// },
								axisY:{
									includeZero: true
								},
								data: [{
									type: "doughnut", //change type to bar, line, area, pie, etc
									//indexLabel: "{y}", //Shows y value on all Data Points
									indexLabelFontColor: "#5A5757",
									indexLabelPlacement: "outside",   
									dataPoints: <?php echo json_encode($chartData, JSON_NUMERIC_CHECK); ?>
								}]
							});
							chart.render();
							
							}
						</script>
						<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
					</canvas>
				</div>
			</section>
		</div>
	</main>
</div>
<!-- partial -->
  
</body>
</html>
