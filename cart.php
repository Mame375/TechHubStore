<?php

session_start();

include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['product_id'];
    $name = $_POST['product_name'];
    $price = $_POST['product_price'];

    // Initialize cart if not exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add or increment item
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity']++;
        // Self-healing: Update image if it was missing (e.g. added before image fix)
        if (empty($_SESSION['cart'][$id]['image']) && isset($_POST['product_image'])) {
            $_SESSION['cart'][$id]['image'] = $_POST['product_image'];
        }
    } else {
        $image = $_POST['product_image'] ?? ''; // Get image from POST
        $_SESSION['cart'][$id] = [
            'name' => $name,
            'price' => $price,
            'image' => $image,
            'quantity' => 1
        ];
    }

    // Redirect to prevent form resubmission
    header("Location: cart.php");
    exit;
}

// Remove item logic
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    unset($_SESSION['cart'][$id]);
    header("Location: cart.php");
    exit;
}
?>

<section class="cart-section">
    <h2 class="section-title">Your Gear</h2>
    <div class="cart-container">
        <?php if (!empty($_SESSION['cart'])): ?>
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th class="center-align">Quantity</th>
                        <th class="right-align">Price</th>
                        <th class="right-align">Total</th>
                        <th class="center-align">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $grand_total = 0;
                    foreach ($_SESSION['cart'] as $id => $item):
                        $line_total = $item['price'] * $item['quantity'];
                        $grand_total += $line_total;
                        ?>
                        <?php
                        $encoded_img = '';
                        if (!empty($item['image'])) {
                            $parts = explode('/', $item['image']);
                            $encoded_parts = array_map('rawurlencode', $parts);
                            $encoded_img = implode('/', $encoded_parts);
                        }
                        ?>
                        <tr>
                            <td style="display: flex; align-items: center; gap: 15px;">
                                <?php if ($encoded_img): ?>
                                    <img src="<?php echo $encoded_img; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>"
                                        style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                <?php endif; ?>
                                <?php echo htmlspecialchars($item['name']); ?>
                            </td>
                            <td class="qty-col"><?php echo $item['quantity']; ?></td>
                            <td class="price-col">$<?php echo number_format($item['price'], 2); ?></td>
                            <td class="total-col">$<?php echo number_format($line_total, 2); ?></td>
                            <td class="action-col">
                                <a href="cart.php?remove=<?php echo $id; ?>" class="remove-btn">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="cart-summary">
                <h3 class="cart-total-price">Total: <span>$<?php echo number_format($grand_total, 2); ?></span></h3>
                <a href="checkout.php" class="cta-button">Proceed to Checkout</a>
            </div>
        <?php else: ?>
            <p class="empty-cart-msg">Your cart is currently empty.</p>
            <div style="text-align: center; margin-top: 20px;">
                <a href="Index.php" class="cta-button">Browse Gear</a>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'footer.php'; ?>