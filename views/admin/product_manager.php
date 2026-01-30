<?php
// views/admin/product_manager.php

require_once __DIR__ . '/../../models/product_model.php';

$action = $_POST['action'] ?? $_GET['action'] ?? 'list';
$error = '';
$edit_product = null;

// Handle actions
switch ($action) {
    case 'add_product':
        $code         = trim($_POST['productCode'] ?? '');
        $name         = trim($_POST['name'] ?? '');
        $version      = trim($_POST['version'] ?? '');
        $release_date = trim($_POST['releaseDate'] ?? '');

        if ($code === '' || $name === '' || $version === '' || $release_date === '') {
            $error = 'All fields are required to add a product.';
        } else {
            try {
                add_product($code, $name, $version, $release_date);
                header('Location: product_manager.php');
                exit;
            } catch (PDOException $e) {
                $error = 'Error adding product: ' . $e->getMessage();
            }
        }
        break;

    case 'show_edit':
        $code = $_GET['productCode'] ?? '';
        if ($code !== '') {
            $edit_product = get_product($code);
            if (!$edit_product) {
                $error = 'Product not found.';
            }
        } else {
            $error = 'No product code provided for edit.';
        }
        break;

    case 'update_product':
        $code         = trim($_POST['productCode'] ?? '');
        $name         = trim($_POST['name'] ?? '');
        $version      = trim($_POST['version'] ?? '');
        $release_date = trim($_POST['releaseDate'] ?? '');

        if ($code === '' || $name === '' || $version === '' || $release_date === '') {
            $error = 'All fields are required to update a product.';
        } else {
            try {
                update_product($code, $name, $version, $release_date);
                header('Location: product_manager.php');
                exit;
            } catch (PDOException $e) {
                $error = 'Error updating product: ' . $e->getMessage();
            }
        }
        break;

    case 'delete_product':
        $code = $_POST['productCode'] ?? '';
        if ($code !== '') {
            try {
                delete_product($code);
                header('Location: product_manager.php');
                exit;
            } catch (PDOException $e) {
                $error = 'Error deleting product: ' . $e->getMessage();
            }
        } else {
            $error = 'No product code provided for delete.';
        }
        break;

    case 'list':
    default:
        break;
}

// Always get the current product list
$products = get_products();

// Include shared header
include __DIR__ . '/../../header.php';
?>

<h2>Product Manager</h2>
<p><a href="/PHPAssignment2/index.php">Back to Home</a></p>

<?php if ($error): ?>
    <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<h3>Product List</h3>
<table border="1" cellspacing="0" cellpadding="6">
    <thead>
        <tr>
            <th>Code</th>
            <th>Name</th>
            <th>Version</th>
            <th>Release Date</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
    <?php if ($products): ?>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?php echo htmlspecialchars($product['productCode']); ?></td>
                <td><?php echo htmlspecialchars($product['name']); ?></td>
                <td><?php echo htmlspecialchars($product['version']); ?></td>
                <td><?php echo htmlspecialchars($product['releaseDate']); ?></td>
                <td>
                    <a href="product_manager.php?action=show_edit&productCode=<?php
                        echo urlencode($product['productCode']);
                    ?>">Edit</a>
                </td>
                <td>
                    <form action="product_manager.php" method="post" style="display:inline;">
                        <input type="hidden" name="action" value="delete_product">
                        <input type="hidden" name="productCode"
                               value="<?php echo htmlspecialchars($product['productCode']); ?>">
                        <button type="submit" onclick="return confirm('Delete this product?');">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="6">No products found.</td></tr>
    <?php endif; ?>
    </tbody>
</table>

<hr>

<?php if ($edit_product): ?>
    <h3>Edit Product</h3>
    <form action="product_manager.php" method="post">
        <input type="hidden" name="action" value="update_product">

        <label>
            Product Code:
            <input type="text" name="productCode"
                   value="<?php echo htmlspecialchars($edit_product['productCode']); ?>"
                   readonly>
        </label><br>

        <label>
            Name:
            <input type="text" name="name"
                   value="<?php echo htmlspecialchars($edit_product['name']); ?>" required>
        </label><br>

        <label>
            Version:
            <input type="text" name="version"
                   value="<?php echo htmlspecialchars($edit_product['version']); ?>" required>
        </label><br>

        <label>
            Release Date:
            <input type="date" name="releaseDate"
                   value="<?php echo htmlspecialchars($edit_product['releaseDate']); ?>" required>
        </label><br><br>

        <button type="submit">Update Product</button>
    </form>
<?php else: ?>
    <h3>Add Product</h3>
    <form action="product_manager.php" method="post">
        <input type="hidden" name="action" value="add_product">

        <label>
            Product Code:
            <input type="text" name="productCode" required>
        </label><br>

        <label>
            Name:
            <input type="text" name="name" required>
        </label><br>

        <label>
            Version:
            <input type="text" name="version" required>
        </label><br>

        <label>
            Release Date:
            <input type="date" name="releaseDate" required>
        </label><br><br>

        <button type="submit">Add Product</button>
    </form>
<?php endif; ?>

<?php
// Include shared footer
include __DIR__ . '/../../footer.php';
?>