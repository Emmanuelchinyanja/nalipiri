<?php
session_start();
require '../php/database.php'; // connect to db to get data
require '../php/customer.php'; // get customer data from the database

// Check admin session
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

echo "<h2>Water & Electricity Usage Report</h2>";

// Example table and columns — adjust these based on your database
// Assuming: 
// - customer table: id, full_name
// - customer table: customer_id, water_usage, kWh_usage, date

$query = "SELECT customer.username, 
                 SUM(billing.water_usage) AS total_water, 
                 SUM(billing.kWh_usage) AS total_electricity
          FROM customer
          INNER JOIN billing ON customer.id = billing.customer_id
          GROUP BY customer.username";

$result = mysqli_query($conn, $query);

// Check if the query worked
if (!$result) {
    echo "Error in query: " . mysqli_error($conn);
    exit();
}

echo "<table border='1'>
<tr>
<th>Customer Name</th>
<th>Total Water Used (Liters)</th>
<th>Total Electricity Used (kWh)</th>
</tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>";
    echo "<td>" . $row['full_name'] . "</td>";
    echo "<td>" . $row['total_water'] . "</td>";
    echo "<td>" . $row['total_electricity'] . "</td>";
    echo "</tr>";
}
echo "</table>";
?>
