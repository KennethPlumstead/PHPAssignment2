<?php
include __DIR__ . '/header.php';
?>

<h2 class="mb-4">Main Menu</h2>

<div class="row">
    <div class="col-md-4 mb-4">
        <h3 class="h5">Admin</h3>
        <ul class="list-unstyled">
            <li><a href="views/admin/product_manager.php" class="link-primary">Manage Products</a></li>
            <li><a href="views/admin/manage_technicians.php" class="link-primary">Manage Technicians</a></li>
            <li><a href="views/admin/manage_customers.php" class="link-primary">Manage Customers</a></li>
        </ul>
    </div>

    <div class="col-md-4 mb-4">
        <h3 class="h5">Technicians</h3>
        <ul class="list-unstyled">
            <li><a href="views/technicians/incidents.php" class="link-primary">View/Update Incidents</a></li>
        </ul>
    </div>

    <div class="col-md-4 mb-4">
        <h3 class="h5">Customers</h3>
        <ul class="list-unstyled">
            <li><a href="views/customers/register_product.php" class="link-primary">Register Product</a></li>
        </ul>
    </div>
</div>

<?php
include __DIR__ . '/footer.php';
?>