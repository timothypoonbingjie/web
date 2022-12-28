<nav class="navbar sticky-top bg-body-tertiary navbar-expand-lg navbar-light bg-info">

    <a class="navbar-brand bg-success rounded-4 m-3 p-2 text-white" href="index.php">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse m-3 justify-content-center" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item dropdown m-2">
                <a class="nav-link dropdown-toggle bg-primary rounded-3 text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Customer
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="create_customers.php">create customer</a></li>
                    <li><a class="dropdown-item" href="customers_read.php">read customer</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown m-2">
                <a class="nav-link dropdown-toggle bg-primary rounded-3 text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Order
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="create_new_order.php">create order</a></li>
                    <li><a class="dropdown-item" href="order_summary">order summary</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown bg-primary rounded-3 m-2">
                <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Product
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="product_create.php">create product</a></li>
                    <li><a class="dropdown-item" href="product_read.php">read product</a></li>
                </ul>
            </li>
            <li class="nav-item bg-primary rounded-3 m-2">
                <a class="nav-link text-white" href="contact_us.php">Contact Us</a>
            </li>
        </ul>
    </div>
    <div class="px-3">
        <a href="log_out.php">Log Out</a>
        <a href="index.php" class="p-3"><img src="image/TP.jpg" height="50px"></a>
    </div>
</nav>