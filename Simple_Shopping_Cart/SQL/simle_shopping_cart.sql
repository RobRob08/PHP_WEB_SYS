CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `role` enum('Member','Admin') NOT NULL DEFAULT 'Member',
  `first_name` varchar(255) NOT NULL DEFAULT '',
  `last_name` varchar(255) NOT NULL DEFAULT '',
  `country` varchar(50) NOT NULL DEFAULT '',
  `street_address_1` varchar(255) NOT NULL DEFAULT '',
  `street_address_2` varchar(255) NOT NULL DEFAULT '',
  `city` varchar(255) NOT NULL DEFAULT '',
  `state` varchar(255) NOT NULL DEFAULT '',
  `zip` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `accounts` (`id`, `email`, `password`, `role`, `first_name`, `last_name`, `country`, `street_address_1`, `street_address_2`, `city`, `state`, `zip`) VALUES
	(1, 'admin@example.com', '$2y$10$pEHRAE4Ia0mE9BdLmbS.ueQsv/.WlTUSW7/cqF/T36iW.zDzSkx4y', 'Admin', 'John', 'Doe', 'US', '123 Main Street', '', 'Anytown', 'NY', '12345');


CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sku` varchar(50) DEFAULT NULL,
  `name` varchar(255) NOT NULL DEFAULT '',
  `price` decimal(7,2) NOT NULL,
  `image` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `sku` (`sku`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `products` (`id`, `sku`, `name`, `price`, `image`) VALUES
	(43, '7000', 'Camera C430W 4k', 699.00, 'product-2.webp'),
	(44, '7001', 'Tablet Air 3 WiFi 64GB', 429.00, 'product-3.webp'),
	(45, '7002', 'Pendrive USB 3.0 Flash 64 GB', 99.00, 'product-9.webp'),
	(46, '7003', 'White Tablet S2 WiFi 62GB LTE', 385.00, 'product-1.webp'),
	(47, '7004', 'Clear View Cover Case', 215.00, 'product-5.webp'),
	(48, '7005', 'Wireless Charger 2040 White', 249.00, 'product-7.webp'),
	(49, '7006', 'Wireless Audio System 360', 79.00, 'product-10.webp'),
	(50, '7007', 'Printer LaserJet Pro M452dn', 499.95, 'product-4.webp'),
	(51, '7008', 'White Solo 2 Wireless', 29.99, 'product-6.webp'),
	(53, '7009', 'Smartwatch 2.0 LTE Wifi', 199.00, 'product-8.webp');


CREATE TABLE IF NOT EXISTS `transactions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txn_id` varchar(50) NOT NULL,
  `order_id` varchar(50) DEFAULT NULL,
  `payer_id` varchar(50) DEFAULT NULL,
  `account_id` int(11) DEFAULT NULL,
  `payer_name` varchar(255) DEFAULT NULL,
  `payer_email` varchar(255) DEFAULT NULL,
  `payer_country` varchar(20) DEFAULT NULL,
  `merchant_id` varchar(255) DEFAULT NULL,
  `merchant_email` varchar(50) DEFAULT NULL,
  `paid_amount` float(10,2) NOT NULL,
  `paid_amount_currency` varchar(10) NOT NULL,
  `payment_source` varchar(50) DEFAULT NULL,
  `payment_status` varchar(25) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `email` varchar(255) NOT NULL,
  `pay_method` varchar(50) NOT NULL,
  `shipping_name` varchar(255) NOT NULL,
  `shipping_country` varchar(50) NOT NULL,
  `shipping_address_line` varchar(255) NOT NULL,
  `shipping_city` varchar(255) NOT NULL,
  `shipping_state` varchar(255) NOT NULL,
  `shipping_zip` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transaction_id` (`txn_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `transactions_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `txn_id` varchar(50) NOT NULL,
  `sku` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(10,2) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `currency_code` varchar(10) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

