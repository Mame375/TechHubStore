<?php include 'header.php'; ?>

<section id="home" class="hero">
    <div class="hero-content">
        <h2>Future of Tech</h2>
        <p>Experience the latest in high-performance gear.</p>
        <a href="#products" class="cta-button">Shop Now</a>
    </div>
</section>

<section id="products">
    <h2 class="section-title">Featured Gear</h2>
    <div class="cards">
        <?php
        require 'db.php';
        try {
            $stmt = $pdo->query("SELECT * FROM products");
            while ($p = $stmt->fetch()) {
                $img_path = $p['image_url'];
                if (file_exists($img_path)) {
                    // Encode path parts (directories and filename) to handle spaces
                    $parts = explode('/', $img_path);
                    $encoded_parts = array_map('rawurlencode', $parts);
                    $img = implode('/', $encoded_parts);
                } else {
                    $img = 'https://via.placeholder.com/300x200/00bcd4/ffffff?text=' . urlencode($p['name']);
                }

                echo "<div class='card'>
                        <div class='card-image'>
                            <img src='{$img}' alt='{$p['name']}' />
                        </div>
                        <div class='card-content'>
                            <h3>{$p['name']}</h3>
                            <p class='desc'>{$p['description']}</p>
                            <div class='price'>\${$p['price']}</div>
                             <form method='post' action='cart.php'>
                                <input type='hidden' name='product_id' value='{$p['id']}'>
                                <input type='hidden' name='product_name' value='{$p['name']}'>
                                <input type='hidden' name='product_price' value='{$p['price']}'>
                                <input type='hidden' name='product_image' value='{$p['image_url']}'>
                                <button type='submit' class='add-to-cart-btn'>
                                    <i class='fas fa-cart-plus'></i> Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>";
            }
        } catch (PDOException $e) {
            echo "<p>Error fetching products: " . $e->getMessage() . "</p>";
        }
        ?>
    </div>
</section>

<section id="services">
    <h2 class="section-title">Premium Services</h2>
    <div class="service-grid">
        <div class="service-item">
            <i class="fas fa-tools"></i>
            <h3>Expert Repair</h3>
            <p>Diagnostics and hardware fixes.</p>
        </div>
        <div class="service-item">
            <i class="fas fa-download"></i>
            <h3>Software Hub</h3>
            <p>Installation and troubleshooting.</p>
        </div>
        <div class="service-item">
            <i class="fas fa-headset"></i>
            <h3>24/7 Support</h3>
            <p>Always online for your tech needs.</p>
        </div>
    </div>
</section>

<section id="contact">
    <h2 class="section-title">Get in Touch</h2>
    <form action="contact.php" method="post" class="contact-form">
        <div class="form-group">
            <input type="text" name="name" required>
            <label>Your Name</label>
        </div>
        <div class="form-group">
            <input type="email" name="email" required>
            <label>Your Email</label>
        </div>
        <div class="form-group">
            <textarea name="message" required></textarea>
            <label>Your Message</label>
        </div>
        <button type="submit" class="cta-button">Send Message</button>
    </form>
</section>

<?php include 'footer.php'; ?>