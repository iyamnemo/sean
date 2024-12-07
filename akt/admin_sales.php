<?php
//Guard
require_once '_guards.php';
Guard::adminOnly();

$todaySales = Sales::getTodaySales();
$totalSales = Sales::getTotalSales();
$weeklySales = Sales::getWeeklySales(); 
$monthlySales = Sales::getMonthlySales(); 
$transactions = OrderItem::all();
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>omen</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
    <link rel="stylesheet" type="text/css" href="./css/util.css">

    <!-- Datatables Library -->
    <link rel="stylesheet" type="text/css" href="./css/datatable.css">
    <script src="./js/datatable.js"></script>
    <script src="./js/main.js"></script>
</head>

<body>
    <?php require 'templates/admin_header.php' ?>

    <div class="flex">
        <?php require 'templates/admin_navbar.php' ?>
        <main>

            <div class="flex">
                <div style="flex: 2; padding: 16px;">
                    <div class="subtitle">Sales Report</div>
                    <hr />

                    <!-- Cards for displaying sales -->
                    <div class="card" id="dailySalesCard">
                        <div class="card-header">
                            <div class="card-title">Today's Sales</div>
                        </div>
                        <div class="card-content">
                            <?= $todaySales ?> PHP
                        </div>
                    </div>

                    <div class="card mt-16" id="weeklySalesCard">
                        <div class="card-header">
                            <div class="card-title">Weekly Sales</div>
                        </div>
                        <div class="card-content">
                            <?= $weeklySales ?> PHP
                        </div>
                    </div>

                    <div class="card mt-16" id="monthlySalesCard">
                        <div class="card-header">
                            <div class="card-title">Monthly Sales</div>
                        </div>
                        <div class="card-content">
                            <?= $monthlySales ?> PHP
                        </div>
                    </div>

                    <div class="card mt-16" id="totalSalesCard">
                        <div class="card-header">
                            <div class="card-title">Total Sales</div>
                        </div>
                        <div class="card-content">
                            <?= $totalSales ?> PHP
                        </div>
                    </div>
                </div>

                <div style="flex: 5; padding: 16px">
                    <div class="subtitle">Product Sales</div>
                    <hr />

                    <table id="transactionsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>SubTotal</th>
                                <th>Total w Tax</th>
                                <th>Date and Time</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php $counter = 1; ?>
                            <?php foreach ($transactions as $transaction): 
                                $priceWithTax = $transaction->price * 1.12; 
                                $subtotal = $transaction->quantity * $transaction->price; 
                                $subtotalWithTax = $transaction->quantity * $priceWithTax; 
                                $taxAmount = $subtotalWithTax - $subtotal; 
                                $taxsub =  0.12 * $subtotal;
                            ?>
                                <tr>
                                    <td><?= sprintf('%05d', $counter++) ?></td>
                                    <td><?= htmlspecialchars($transaction->product_name) ?></td>
                                    <td><?= htmlspecialchars($transaction->quantity) ?></td>
                                    <td>₱<?= number_format($transaction->quantity * $transaction->price) ?></td> 
                                    <td>₱<?= htmlspecialchars($subtotal + $taxsub) ?></td>
                                    <td><?= htmlspecialchars($transaction->created_at) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </main>
    </div>


<script>
    // Function to update the sales display based on the selected period
    document.getElementById('salesPeriod').addEventListener('change', function() {
        const selectedPeriod = this.value;

        // Hide all sales cards initially
        document.getElementById('dailySalesCard').style.display = 'none';
        document.getElementById('weeklySalesCard').style.display = 'none';
        document.getElementById('monthlySalesCard').style.display = 'none';
        document.getElementById('totalSalesCard').style.display = 'none';

        // Show the selected sales card
        if (selectedPeriod === 'daily') {
            document.getElementById('dailySalesCard').style.display = 'block';
        } else if (selectedPeriod === 'weekly') {
            document.getElementById('weeklySalesCard').style.display = 'block';
        } else if (selectedPeriod === 'monthly') {
            document.getElementById('monthlySalesCard').style.display = 'block';
        } else if (selectedPeriod === 'total') {
            document.getElementById('totalSalesCard').style.display = 'block';
        }
    });

    // Trigger change event on page load to ensure the correct sales card is shown
    document.getElementById('salesPeriod').dispatchEvent(new Event('change'));
</script>


<style>
    /* Combo Box Styling */
    #salesPeriod {
    width: 200px; /* Set a fixed width for consistency */
    padding: 8px 12px; /* Add padding for better spacing */
    font-size: 14px; /* Use a smaller font size for better alignment */
    font-family: Arial, sans-serif; /* Consistent font with the rest of the design */
    border: 1px solid #bfae8f; /* Soft brown border for a natural look */
    border-radius: 4px; /* Slight rounding for a soft appearance */
    background-color: #f1f1f1; /* Light holographic white background */
    color: #4d4d4d; /* Dark gray text for readability */
    box-sizing: border-box; /* Ensure padding is included in width */
    transition: border-color 0.3s ease, box-shadow 0.3s ease; /* Smooth transition on focus */
    background: linear-gradient(145deg, #f9f9f9, #d1c6b1); /* Light gradient for holographic feel */
}

/* Combo Box Focus Style */
#salesPeriod:focus {
    outline: none; /* Remove the default focus outline */
    border-color: #5e8d4f; /* Soft green border to match the theme */
    box-shadow: 0 0 5px rgba(94, 141, 79, 0.6); /* Soft green shadow for better focus indication */
    background: linear-gradient(145deg, #d4e2c1, #f1f1f1); /* Subtle holographic green gradient */
}

/* Combo Box Option Styling */
#salesPeriod option {
    padding: 10px; /* Add padding inside the options for better readability */
    font-size: 14px; /* Ensure consistency in font size */
    background-color: #f1f1f1; /* Light background for options */
    color: #4d4d4d; /* Dark text for options */
    border: none; /* Remove border for a clean look */
}

/* Hover effect for options */
#salesPeriod option:hover {
    background-color: #d1e1d1; /* Light green hover effect for better user interaction */
    color: #333; /* Darker text on hover for better contrast */
}

/* Optional: Styling for the combo box in the container */
.container {
    width: 80%;
    margin: 0 auto;
    padding-top: 50px; /* Add padding to position the combo box nicely */
    text-align: center;
    font-family: 'Arial', sans-serif;
    background-color: #f9f9f9; /* Harmonize the background with the combo box */
}

h2 {
    color: #4d4d4d; /* Dark gray text for the heading */
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
}



</style>

</body>

</html>
