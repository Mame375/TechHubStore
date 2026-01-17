
SET FOREIGN_KEY_CHECKS = 0;


-- Table structure for table `users`

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL UNIQUE,
  `email` VARCHAR(100) NOT NULL UNIQUE,
  `password_hash` VARCHAR(255) NOT NULL,
  `first_name` VARCHAR(50) DEFAULT NULL,
  `last_name` VARCHAR(50) DEFAULT NULL,
  `address` TEXT DEFAULT NULL,
  `city` VARCHAR(50) DEFAULT NULL,
  `postal_code` VARCHAR(20) DEFAULT NULL,
  `country` VARCHAR(50) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `products`

DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `description` TEXT,
  `price` DECIMAL(10, 2) NOT NULL,
  `stock_quantity` INT NOT NULL DEFAULT 0,
  `image_url` VARCHAR(255) DEFAULT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `orders`

DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` INT UNSIGNED NOT NULL,
  `total_amount` DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
  `status` ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_orders_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Table structure for table `order_items`

DROP TABLE IF EXISTS `order_items`;
CREATE TABLE `order_items` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `order_id` INT UNSIGNED NOT NULL,
  `product_id` INT UNSIGNED NOT NULL,
  `quantity` INT UNSIGNED NOT NULL DEFAULT 1,
  `price_at_purchase` DECIMAL(10, 2) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_order_items_orders` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_order_items_products` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;

-- Seed Data for Products
INSERT INTO products (name, price, description, image_url) VALUES 
('Apple AirPods Pro 3', 249.00, 'Active Noise Cancellation and Spatial Audio.', 'images/Apple AirPods pro 3.jpg'),
('Apple iPhone 15 Pro Max', 1199.00, 'Titanium design, A17 Pro chip.', 'images/Apple iPhone 15 pro max.jpg'),
('Apple iPhone 16 Pro Max', 1299.00, 'The future of iPhone.', 'images/Apple iPhone 16 pro max.jpg'),
('Apple iPhone 17 Pro Max', 1399.00, 'Upcoming generation prototype.', 'images/Apple iPhone 17 pro max.jpg'),
('MacBook Pro', 1599.00, 'Supercharged by M3 chips.', 'images/Apple labtop.jpg'),
('Apple Watch Series 11', 499.00, 'Advanced health sensors.', 'images/Apple smart watch series 11.jpg'),
('Google Pixel 10 Pro', 999.00, 'The smartest Pixel yet.', 'images/Google Pixel 10 Pro.jpg'),
('Google Pixel Watch 3', 399.00, 'Help by Google, health by Fitbit.', 'images/Google Pixel Watch 3.jpg'),
('Premium Headphones', 199.00, 'Crystal clear audio.', 'images/Headphone.jpg'),
('Wireless Headphones', 149.00, 'All-day battery life.', 'images/Headphone1.jpg'),
('Sony PlayStation 5', 499.00, 'Play Has No Limits.', 'images/Playstation 5 console.jpg'),
('Samsung Galaxy Z Fold 7', 1799.00, 'Unfold your world.', 'images/Samsung Galaxy Z Fold7.jpg'),
('Fitness Smart Watch', 99.00, 'Track your fitness goals.', 'images/Smart watch.jpg'),
('Hexnode Laptop', 899.00, 'Enterprise ready performance.', 'images/hexnode labtop.jpg'),
('HP Pavilion Laptop', 749.00, 'Work and play anywhere.', 'images/hp labtop.jpg'),
('Samsung Galaxy S23 Ultra', 1199.00, 'Epic photography.', 'images/samsung galaxy S23 ultra 5G.jpg'),
('Samsung Galaxy S25 Ultra', 1299.00, 'Next gen Galaxy.', 'images/samsung galaxy S25 ultra 5G.jpg'),
('Samsung Galaxy Buds3 Pro', 229.00, 'Immersive sound.', 'images/samsung galaxy buds3 pro.jpg'),
('Samsung Galaxy S24 Ultra', 1299.00, 'Galaxy AI is here.', 'images/samsung galaxy ultra 24.jpg'),
('Samsung Galaxy Watch 5', 279.00, 'Sleep tracking and wellness.', 'images/samsung galaxy watch 5.jpg');

-- Seed Data for Users (Password: password123)
-- calculated hash locally
INSERT INTO `users` (`username`, `email`, `password_hash`, `first_name`, `last_name`) VALUES
('testuser', 'test@example.com', '$2y$10$abcdefghijklmnopqrstuvwxyz0123456789', 'Test', 'User');

-- Seed Data for Orders
INSERT INTO `orders` (`user_id`, `total_amount`, `status`) VALUES
(1, 1450.00, 'processing');

-- Seed Data for Order Items (Linking User Order to Product)
INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `price_at_purchase`) VALUES
(1, 1, 1, 1450.00);


