<?php
include 'header.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $message = isset($_POST["message"]) ? htmlspecialchars($_POST["message"]) : "Order placed";

    // In a real app, save to DB or send email here.
    // Order placement logic could also go here if redirected from checkout.

    // Clear cart if this was an order
    if (isset($_POST['address'])) { // Simple check if it came from checkout
        unset($_SESSION['cart']);
        $title = "Order Placed!";
        $msg = "Thank you for your purchase, $name. We will ship to the provided address soon.";
    } else {
        $title = "Message Sent!";
        $msg = "Thank you for contacting us, $name. We will get back to you shortly.";
    }
} else {
    // Direct access redirect
    header("Location: Index.php");
    exit;
}
?>

<section class="success-section">
    <div class="success-container">
        <i class="fas fa-check-circle" style="font-size: 5rem; color: #4caf50; margin-bottom: 25px;"></i>
        <h2 style="font-family: var(--font-head); margin-bottom: 20px; color: var(--accent-color);">
            <?php echo $title; ?></h2>
        <p style="font-size: 1.1rem; color: var(--text-muted); margin-bottom: 40px;"><?php echo $msg; ?></p>
        <a href="Index.php" class="cta-button">Continue Shopping</a>
    </div>
</section>

<?php include 'footer.php'; ?>