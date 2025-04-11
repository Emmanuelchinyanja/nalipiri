<?php
include 'database.php';

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
?>