<?php

require_once '_guards.php';
Guard::cashierOnly();

$products = Product::all();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>omen</title>
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link rel="stylesheet" type="text/css" href="./css/admin.css">
    <link rel="stylesheet" type="text/css" href="./css/cashier.css">
    <link rel="stylesheet" type="text/css" href="./css/util.css">

    <script src="./js/main.js"></script>
    <script src="./js/cashier.js"></script>
    
    <!-- Datatables  Library -->
    <link rel="stylesheet" type="text/css" href="./css/datatable.css">
    <script src="./js/datatable.js"></script>

    <!-- AlpineJS Library -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body {
            opacity: 0;
            animation: fadeInPage 1s forwards;
        }

        @keyframes fadeInPage {
            to {
                opacity: 1;
            }
        }

        a.text-green-300 {
            transition: transform 0.3s ease, color 0.3s ease;
        }

        a.text-green-300:hover {
            transform: scale(1.1);
            color: #48BB78; 
        }

        a.text-green-300:active {
            transform: scale(0.95);
        }

        #productsTable tr {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        #productsTable tr:hover {
            background-color: #F0FDF4; 
           
        }

        .cart-item {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeIn 0.5s forwards;
            transition: transform 0.3s ease;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cart-item-buttons button {
            transition: transform 0.2s ease, background-color 0.2s ease;
            
        }

        .cart-item-buttons button:hover {
            transform: scale(1.04);
            background-color: #48BB78; 
        }

        input[type="text"], input[type="number"] {
            transition: box-shadow 0.3s ease, border-color 0.3s ease;
        }

        input[type="text"]:focus, input[type="number"]:focus {
            border-color: #48BB78;
            box-shadow: 0 0 10px rgba(72, 187, 120, 0.5);
        }

        input[type="number"] {
            margin-bottom: 20px;
            width: 30%;
            padding: 12px 16px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 8px;
            background-color: #f9fafb;
            color: #333;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
        }

        input[type="number"]:focus {
            border-color: #48BB78;  
            box-shadow: 0 0 5px rgba(72, 187, 120, 0.5);  
            outline: none;  
        }

        input[type="number"]::placeholder {
            color: #aaa;
            font-style: italic;
        }

        label[for="payment"] {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
            display: block;
            font-weight: bold;
        }

        input[type="customername"] {
            margin-bottom: 20px;
            width: 80%;
            padding: 12px 16px;
            font-size: 16px;
            border: 2px solid #ddd;
            border-radius: 8px;
            background-color: #f9fafb;
            color: #333;
            transition: border-color 0.3s ease, box-shadow 0.3s ease, transform 0.2s ease;
        }

        input[type="customername"]:focus {
            border-color: #48BB78; 
            box-shadow: 0 0 5px rgba(72, 187, 120, 0.5); 
            transform: scale(1.01);  
            outline: none; 
        }

        input[type="text"]::placeholder {
            color: #aaa;
            font-style: italic;
        }

        label[for="customer_name"] {
            font-size: 14px;
            color: #555;
            margin-bottom: 8px;
            display: block;
            font-weight: bold;
        }

    </style>

</head>
<body>

    <div class="flex">
        
        <main x-data='products(<?= json_encode($products) ?>)'>
            <div class="flex h-full">
                <div class="products">
                    <div class="subtitle">PRODUCTS</div>
                    <hr/>

                    <?php displayFlashMessage('transaction') ?>

                    <table id="productsTable">
                        <thead>
                            <tr>
                                <th>PRODUCT ID</th>
                                <th>PRODUCT NAME</th>
                                <th>CATEGORY</th>
                                <th>AVAILABLE STOCKS</th>
                                <th>PRICE</th>
                                <th>ADD TO CART</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $skuCounter = 1; ?>
                            <?php foreach ($products as $product) : ?>
                            <tr>
                                
                                <td>SKU<?= str_pad($skuCounter++, 3, '0', STR_PAD_LEFT) ?></td>
                                <td><?= $product->name ?></td>
                                <td><?= $product->category->name ?></td>
                                <td><?= $product->quantity ?></td>
                                <td>₱<?= $product->price ?></td>
                                <td>
                                    <a @click="addToCart(<?= $product->id ?>)" href="#" class="text-green-300">ADD</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                </div>
                <div class="forms">
                    <div class="flex flex-col h-full">
                        <div>
                            <div class="subtitle">CART</div>
                            <hr/>
                        </div>

                        <div id="cardItemsContainer" class="flex-grow" style="overflow-y: auto;">
                            <template x-for="cart in carts">
                                <div class="cart-item">
                                    <span class="left" x-text="cart.product.name"></span>
                                    <span class="left" x-text="'₱'+cart.product.price"></span>
                                    <div class="middle">
                                        <div class="cart-item-buttons">
                                            <button @click="subtractQuantity(cart)">-</button>
                                            <span x-text="cart.quantity"></span>
                                            <button @click="addQuantity(cart)">+</button>
                                        </div>
                                    </div>
                                    <span class="right" x-text="'₱'+(cart.quantity * cart.product.price)"></span>
                                </div>                                
                            </template>
                        </div>

                        <form action="function/cashier_controller.php" method="POST" @submit="validate">
                            <input type="hidden" name="action" value="proccess_order">

                            <template x-for="(cart,i) in carts" :key="cart.product.id">
                                <div>
                                    <input type="hidden" :name="`cart_item[${i}][id]`" :value="cart.product.id">
                                    <input type="hidden" :name="`cart_item[${i}][quantity]`" :value="cart.quantity">
                                </div>
                            </template>

                            <div>
                                <label for="customer_name">Customer Name:</label>
                                <input type="customername" id="customer_name" name="customer_name" required placeholder="Enter customer name" />
                            </div>

                            <div>
                                <label for="payment">Payment:</label>
                                <input type="number" x-model="payment" step="0.25" name="payment" id="payment" required placeholder="Enter amount" />
                            </div>

                            <div>
                                <span>SubTotal Amount: </span>
                                <span class="font-bold" x-text="'₱'+totalPrice"></span>
                            </div>
                            
                            <div>
                                <span>Tax (12%): </span>
                                <span class="font-bold" x-text="'₱'+(totalPrice * 0.12).toFixed(2)"></span>
                            </div>

                            <div>
                                <span>Total Amount: </span>
                                <span class="font-bold" x-text="'₱'+(totalPrice + (totalPrice * 0.12)).toFixed(2)"></span>
                            </div>

                            <button class="btn btn-primary mt-16 w-full">Check Out</button>
                        </form>

                    </div>
                </div>
            </div>
        </main>
    </div>
    <button class="nav-links-item" onclick="location.href='function/logout_controller.php'">
          
          <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
      </svg>
      <span>Logout</span>
  </button>


    <script type="text/javascript">
        var dataTable = new simpleDatatables.DataTable("#productsTable");

        
        function addToCart(productId) {
            const cartItem = document.createElement("div");
            cartItem.classList.add("cart-item", "fade-in");
            
            document.getElementById("cardItemsContainer").appendChild(cartItem);

            setTimeout(() => {
                cartItem.classList.remove("fade-in");
            }, 500);
        }
    </script>

</body>
</html>
