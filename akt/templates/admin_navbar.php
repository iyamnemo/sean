<aside class="nav-sidebar">
  <div class="nav-links">
    <!-- Inventory -->
    <button class="nav-links-item" onclick="location.href='admin_home.php'">
      <i class="fas fa-box"></i>
      <span>Inventory</span>
    </button>

    <!-- Add Item -->
    <button class="nav-links-item" onclick="location.href='admin_add_item.php'">
      <i class="fas fa-plus-circle"></i>
      <span>Add/Delete Product</span>
    </button>

    <!-- Category -->
    <button class="nav-links-item" onclick="location.href='admin_category.php'">
      <i class="fas fa-tags"></i>
      <span>Product Category</span>
    </button>

    <!-- Sales -->
    <button class="nav-links-item" onclick="location.href='admin_sales.php'">
      <i class="fas fa-chart-line"></i>
      <span>Sales Report</span>
    </button>

    <!-- Transactions -->
    <button class="nav-links-item" onclick="location.href='transactions.php'">
      <i class="fas fa-receipt"></i>
      <span>Transactions</span>
    </button>

    <!-- Logout -->
    <button class="nav-links-item" onclick="location.href='function/logout_controller.php'">
      <i class="fas fa-sign-out-alt"></i>
      <span>Logout</span>
    </button>
  </div>
</aside>

<!-- Font Awesome Icon Library -->
<link
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
  rel="stylesheet"
/>
<style>
    /* Reset */
body {
  margin: 0;
  font-family: Arial, sans-serif;
}

.nav-sidebar {
  position: fixed;
  top: 0;
  left: 0;
  width: 200px;
  height: 100%;
  background-color: #2c3e50;
  color: white;
  display: flex;
  flex-direction: column;
  box-shadow: 2px 0 5px rgba(0, 0, 0, 0.2);
}

.nav-links {
  margin: 0;
  padding: 0;
  list-style: none;
  width: 100%;
}

.nav-links-item {
  background: none;
  border: none;
  color: white;
  width: 100%;
  padding: 15px 20px;
  text-align: left;
  display: flex;
  align-items: center;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease, padding-left 0.3s ease;
}

.nav-links-item i {
  font-size: 20px;
  margin-right: 15px;
}

.nav-links-item span {
  opacity: 1;
  transition: opacity 0.3s ease;
}

.nav-links-item:hover {
  background-color: #34495e; /* Slightly lighter shade */
  padding-left: 30px;
}

.nav-links-item:active {
  background-color: #1abc9c; /* Highlight green */
}

.nav-links-item:focus {
  outline: none;
}

/* Animation: Smooth slide-in effect */
.nav-sidebar {
  animation: slide-in 0.5s ease-in-out;
}

@keyframes slide-in {
  from {
    transform: translateX(-100%);
  }
  to {
    transform: translateX(0);
  }
}

</style>