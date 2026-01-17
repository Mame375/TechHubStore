<?php include 'header.php'; ?>

<?php
if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}
?>

<section class="checkout-section">
    <h2 class="section-title">Checkout</h2>
    <div class="checkout-container">
        <form action="contact.php" method="post" class="contact-form">
            <h3 style="margin-bottom: 20px; color: var(--accent-color); font-family: var(--font-head);">Shipping
                Information</h3>
            <div class="form-group">
                <input type="text" name="name" required>
                <label>Full Name</label>
            </div>
            <div class="form-group">
                <input type="email" name="email" required>
                <label>Email Address</label>
            </div>
            <div class="form-group">
                <textarea name="address" required></textarea>
                <label>Delivery Address</label>
            </div>

            <div style="margin-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); padding-top: 20px;">
                <h3 style="margin-bottom: 20px; font-family: var(--font-head);">Payment Details</h3>
                <!-- Dummy payment fields -->
                <div class="form-group">
                    <input type="text" value="XXXX-XXXX-XXXX-1234 (Dummy)" disabled
                        style="cursor: not-allowed; opacity: 0.6; border-color: var(--text-muted);">
                </div>
            </div>

            <button type="submit" class="cta-button" style="width: 100%; margin-top: 20px;">Place Order</button>
        </form>
    </div>
</section>

<?php include 'footer.php'; ?>