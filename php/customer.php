<?php
require '../php/database.php'; // connect to db to get data
// Get customer data from the database
function getCustomerData($conn) {
    $stmt = $conn->prepare("SELECT * FROM customer");
    $stmt->execute();
    
    if ($stmt->rowCount() > 0) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return null;
    }
}
// Get customer count
function getCustomerCount($conn) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM customer");
    $stmt->execute();
    
    return $stmt->fetchColumn();
}
// Get monthly water usage
function getMonthlyWaterUsage($conn) {
    $stmt = $conn->prepare("SELECT MONTH(date) AS month, SUM(water_usage) AS total_usage FROM billing GROUP BY MONTH(date)");
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Get monthly water bill
function getMonthlyWaterBill($conn) {
    $stmt = $conn->prepare("SELECT MONTH(date) AS month, SUM(water_bill) AS total_bill FROM billing GROUP BY MONTH(date)");
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Get monthly electricity usage
function getMonthlyElectricityUsage($conn) {
    $stmt = $conn->prepare("SELECT MONTH(date) AS month, SUM(kWh_usage) AS total_usage FROM billing GROUP BY MONTH(date)");
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Get monthly electricity bill
function getMonthlyElectricityBill($conn) {
    $stmt = $conn->prepare("SELECT MONTH(date) AS month, SUM(electric_bill) AS total_bill FROM billing GROUP BY MONTH(date)");
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Get monthly bill
function getMonthlyBill($conn) {
    $stmt = $conn->prepare("SELECT MONTH(date) AS month, SUM(total_bill) AS total_bill FROM billing GROUP BY MONTH(date)");
    $stmt->execute();
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
// Get total electric and water billing data of the month for chart
function getCustomerBillingData($conn) {
    $stmt = $conn->prepare("SELECT MONTH(date) AS month, SUM(water_bill) AS water_bill, SUM(electric_bill) AS electric_bill FROM billing GROUP BY MONTH(date)");
    // $stmt = $conn->prepare("SELECT * FROM billing");
    $stmt->execute();

    $billing = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch all billing data for the customer
	$dataPoints = []; // initialize dataPoints array for chart data

    // check if the billing data is not empty
    if (!empty($billing)) {
		// loop through the billing data and add it to the dataPoints array		
		foreach ($billing as $bill) {
            $dataPoints[] = ["label" => "Water Bill", "y" => (float)$bill["water_bill"]];
            $dataPoints[] = ["label" => "Electric Bill", "y" => (float)$bill["electric_bill"]];
            return $dataPoints; // return the dataPoints array for chart data
        }
    } else {
        // code here incase of no billing data...
    }
    
    // return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>