<?php
class Customer {
    private $conn;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    // Retrieve all customer data
    public function getAllCustomers() {
        $stmt = $this->conn->prepare("SELECT * FROM customer");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Retrieve customer data including billing
    public function getCustomerWithBilling() {
        $stmt = $this->conn->prepare("SELECT customer.*, billing.* FROM customer LEFT JOIN billing ON customer.id = billing.customer_id");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get the total number of customers
    public function getCustomerCount() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM customer");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Get monthly water usage
    public function getMonthlyWaterUsage() {
        $stmt = $this->conn->prepare("SELECT MONTH(date) AS month, SUM(water_usage) AS total_usage FROM billing");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get monthly water bill
    public function getMonthlyWaterBill() {
        $stmt = $this->conn->prepare("SELECT MONTH(date) AS month, SUM(water_bill) AS total_bill FROM billing");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get monthly electricity usage
    public function getMonthlyElectricityUsage() {
        $stmt = $this->conn->prepare("SELECT MONTH(date) AS month, SUM(kWh_usage) AS total_usage FROM billing");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get monthly electricity bill
    public function getMonthlyElectricityBill() {
        $stmt = $this->conn->prepare("SELECT MONTH(date) AS month, SUM(electric_bill) AS total_bill FROM billing");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get monthly bill
    public function getMonthlyBill() {
        $stmt = $this->conn->prepare("SELECT MONTH(date) AS month, SUM(total_bill) AS total_bill FROM billing");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get total electric and water billing data of the month for chart
    public function getCustomerBillingData() {
        $stmt = $this->conn->prepare("SELECT MONTH(date) AS month, SUM(water_bill) AS water_bill, SUM(electric_bill) AS electric_bill FROM billing GROUP BY MONTH(date)");
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
        }
    }

    // Get customer details by ID
    public function getCustomerById($customerId) {
        $stmt = $this->conn->prepare("SELECT * FROM customer WHERE id = :id");
        $stmt->bindParam(':id', $customerId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Add a new customer
    public function addCustomer($name, $address, $phone) {
        $stmt = $this->conn->prepare("INSERT INTO customer (name, address, phone) VALUES (:name, :address, :phone)");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        return $stmt->execute();
    }

    // Update customer details
    public function updateCustomer($customerId, $name, $address, $phone) {
        $stmt = $this->conn->prepare("UPDATE customer SET name = :name, address = :address, phone = :phone WHERE id = :id");
        $stmt->bindParam(':id', $customerId, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':phone', $phone);
        return $stmt->execute();
    }

    // Delete a customer
    public function deleteCustomer($customerId) {
        $stmt = $this->conn->prepare("DELETE FROM customer WHERE id = :id");
        $stmt->bindParam(':id', $customerId, PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Get billing data from the database for a specific customer
    public function getCustomerBilling($customerId) {
        $stmt = $this->conn->prepare("SELECT MONTH(date) AS month, 
        SUM(water_usage) AS water_usage, 
        SUM(kWh_usage) AS kWh_usage, 
        SUM(water_bill) AS water_bill, 
        SUM(electric_bill) AS electric_bill,
        SUM(total_bill) AS total_bill 
        FROM billing WHERE customer_id = :customer_id");
        $stmt->bindParam(':customer_id', $customerId, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return $billing = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch all billing data for the customer
        } else {
            return null;
        }
    }

    // Get chart billing data for the customer
    public function getChartBillingData($customerId) {
        $stmt = $this->conn->prepare("SELECT MONTH(date) AS month, SUM(water_bill) AS water_bill, SUM(electric_bill) AS electric_bill FROM billing WHERE customer_id = :customer_id GROUP BY MONTH(date)");
        $stmt->bindParam(':customer_id', $customerId, PDO::PARAM_INT);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            $billing = $stmt->fetchAll(PDO::FETCH_ASSOC); // fetch all billing data for the customer
            $dataPoints = []; // initialize dataPoints array for chart data
            foreach ($billing as $bill) {
                $dataPoints[] = ["label" => "Water Bill", "y" => (float)$bill["water_bill"]];
                $dataPoints[] = ["label" => "Electric Bill", "y" => (float)$bill["electric_bill"]];
                return $dataPoints; // return the dataPoints array for chart data
            }
        } else {
            return null;
        }
    }
}
?>
