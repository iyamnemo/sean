<?php

require_once __DIR__.'/../_init.php';

// Define the function to get the database connection
function getDbConnection() {
    // Using constants defined for DB connection
    $conn = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

    // Check if the connection was successful
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}

if (post('action') === 'proccess_order') {
    // Get customer name and payment
    $customerName = post('customer_name');
    $payment = (float) post('payment');
    $totalPrice = 0;
    $receiptData = [];

    // Create a new order
    $order = Order::create();

    foreach ($_POST['cart_item'] as $item) {
        // Add each item to the order
        $orderItem = OrderItem::add($order->id, $item);

        // Fetch product details for the receipt
        $product = Product::find($item['id']);
        $quantity = $item['quantity'];
        $subtotal = $product->price * $quantity;

        // Calculate total price
        $totalPrice += $subtotal;

        // Add product details to the receipt data
        $receiptData[] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $quantity,
            'subtotal' => $subtotal,
        ];
    }

    // Calculate tax and total with tax
    $tax = $totalPrice * 0.12;
    $totalWithTax = $totalPrice + $tax;

    // Calculate change
    $changeAmount = $payment - $totalWithTax;  // Changed "change" to "changeAmount"

    // Save transaction details in the database
    $db = getDbConnection();  // Assuming this is a function that returns your DB connection
    $stmt = $db->prepare("INSERT INTO transactions (customer_name, total_price, tax, total_with_tax, payment, change_amount) 
                          VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('sdddds', $customerName, $totalPrice, $tax, $totalWithTax, $payment, $changeAmount); // Changed "change" to "changeAmount"
    $stmt->execute();
    $transactionId = $stmt->insert_id;  // Get the ID of the last inserted transaction

    // Generate the receipt HTML
    ob_start();
    ?>
    <div id="receipt">
        <h2>Receipt</h2>
        <p>Date: <?= date('Y-m-d H:i:s') ?></p>
        <p>Customer Name: <strong><?= htmlspecialchars($customerName) ?></strong></p>
        <table border="1" cellpadding="5" cellspacing="0">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($receiptData as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= number_format($item['price'], 2) ?> PHP</td>
                    <td><?= htmlspecialchars($item['quantity']) ?></td>
                    <td><?= number_format($item['subtotal'], 2) ?> PHP</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <p><strong>Total: <?= number_format($totalPrice, 2) ?> PHP</strong></p>
        <p><strong>Tax (12%): <?= number_format($tax, 2) ?> PHP</strong></p>
        <p><strong>Total with Tax: <?= number_format($totalWithTax, 2) ?> PHP</strong></p>
        <p><strong>Payment: <?= number_format($payment, 2) ?> PHP</strong></p>
        <p><strong>Change: <?= number_format($changeAmount, 2) ?> PHP</strong></p>
    </div>
    <?php
    $receiptHtml = ob_get_clean();

    // Flash success message and include receipt in the session
    flashMessage(
        'transaction',
        'Successful transaction. <br>' . $receiptHtml,
        FLASH_SUCCESS
    );

    // Redirect back to the cashier page
    redirect('../index.php');
}
?>
