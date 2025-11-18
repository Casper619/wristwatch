-- Бүх SQL скрипт / засварлагдсан
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Хэрэглэгчийн төрөл
CREATE TABLE `user_type` (
  `user_type_code` VARCHAR(20) NOT NULL,
  `user_type_name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`user_type_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `user_type` (`user_type_code`, `user_type_name`) VALUES
  ('admin', 'Админ'),
  ('consumer', 'Хэрэглэгч');

-- Хэрэглэгчийн мэдээлэл
CREATE TABLE `user` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(20) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `user_type_code` VARCHAR(20) NOT NULL,
  `email` VARCHAR(30) NOT NULL,
  `owog` VARCHAR(50) DEFAULT NULL,
  `ner` VARCHAR(50) DEFAULT NULL,
  `utasnii_dugaar` VARCHAR(20) DEFAULT NULL,
  `register_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`),
  FOREIGN KEY (`user_type_code`) REFERENCES `user_type`(`user_type_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `user` (`username`, `password`, `user_type_code`, `email`, `owog`, `ner`, `utasnii_dugaar`) VALUES
  ('admin', 'admin@123', 'admin', 'Raizen@gmail.com', 'Алтанцоож', 'Мөнхтөр', '95927050'),
  ('User', 'user@123', 'consumer', 'User123@gmail.com', 'Бат', 'Болд', '87654321'),
  ('user3', 'user3@123', 'consumer', 'user3@gmail.com', 'Ганбат', 'Баяр', '98765432');

-- Бүтээгдэхүүн
CREATE TABLE `product` (
  `item_id` INT(11) NOT NULL AUTO_INCREMENT,
  `item_brand` VARCHAR(200) NOT NULL,
  `item_name` VARCHAR(255) NOT NULL DEFAULT '',
  `item_price` DECIMAL(10,2) NOT NULL,
  `item_image` VARCHAR(255) NOT NULL,
  `item_register` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `Place` VARCHAR(20) NOT NULL DEFAULT 'arrival',
  `subject` VARCHAR(20) NOT NULL,
  `item_description` TEXT,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `product` (`item_name`, `item_brand`, `item_description`, `item_price`, `item_image`, `item_register`, `Place`, `subject`) VALUES 
  ('Calendrier', 'Citizen', '', 850000.00, './assets/products/w1.png', NOW(), 'featured', 'Эмэгтэй'), 
  ('Sport Luxury', 'Citizen', '', 850000.00, './assets/products/w2.png', NOW(), 'featured', 'Эмэгтэй'), 
  ('Citizen L Mae', 'Citizen', '', 850000.00, './assets/products/w3.png', NOW(), 'featured', 'Эмэгтэй'), 
  ('Corso Diamond', 'Citizen', '', 850000.00, './assets/products/w4.png', NOW(), 'featured', 'Эмэгтэй'), 
  ('Corso Diamond G', 'Citizen', '', 850000.00, './assets/products/w5.png', NOW(), 'arrival', 'Эмэгтэй'), 
  ('Promaster Dive', 'Citizen', '', 750000.00, './assets/products/w6.png', NOW(), 'arrival', 'Эмэгтэй'), 
  ('Sport Luxury', 'Citizen', '', 850000.00, './assets/products/w7.png', NOW(), 'arrival', 'Эмэгтэй'), 
  ('Citizen L Mae G', 'Citizen', '', 850000.00, './assets/products/w8.png', NOW(), 'arrival', 'Эмэгтэй'), 
  ('Empowered Minnie Mouse', 'Citizen', '', 850000.00, './assets/products/w9.png', NOW(), 'arrival', 'Эмэгтэй'), 
  ('Bianca', 'Citizen', '', 850000.00, './assets/products/w10.png', NOW(), 'arrival', 'Эмэгтэй'), 
  ('Tsuki-yomi A-T', 'Citizen', '', 900000.00, './assets/products/1.png', NOW(), 'arrival', 'Эрэгтэй'), 
  ('Promaster Dive', 'Citizen', '', 740000.00, './assets/products/2.png', NOW(), 'arrival', 'Эрэгтэй'), 
  ('Peyten', 'Citizen', '', 650000.00, './assets/products/3.png', NOW(), 'arrival', 'Эрэгтэй'), 
  ('Series8 890', 'Citizen', '', 780000.00, './assets/products/4.png', NOW(), 'arrival', 'Эрэгтэй'), 
  ('Series9 890', 'Citizen', '', 740000.00, './assets/products/5.png', NOW(), 'arrival', 'Эрэгтэй'), 
  ('TSUYOSA', 'Citizen', '', 740000.00, './assets/products/6.png', NOW(), 'arrival', 'Эрэгтэй'), 
  ('TSUYOSA', 'Citizen', '', 560000.00, './assets/products/7.png', NOW(), 'featured', 'Эрэгтэй'), 
  ('HAKUTO-R', 'Citizen', '', 360000.00, './assets/products/8.png', NOW(), 'featured', 'Эрэгтэй'), 
  ('Promaster Skyhawk A-T', 'Citizen', '', 740000.00, './assets/products/10.png', NOW(), 'arrival', 'Эрэгтэй'), 
  ('Promaster Altichron', 'Citizen', '', 890000.00, './assets/products/9.png', NOW(), 'arrival', 'Эрэгтэй'), 
  ('Astron', 'Tissot', 'Astron T122: 40 мм-ийн диаметртэй, 80 цагийн энергийн нөөцтэй, шилэн арын тагтай, Швейцарийн автомат хөдөлгүүртэй. Tissot Astron цагнууд нь өндөр чанар, нарийн хийц, удаан эдэлгээ зэргээрээ алдартай.', 800000.00, './assets/products/astron.png', NOW(), 'featured', 'Эрэгтэй');

-- Сагс
CREATE TABLE `cart` (
  `cart_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `item_id` INT(11) NOT NULL,
  PRIMARY KEY (`cart_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE,
  FOREIGN KEY (`item_id`) REFERENCES `product`(`item_id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `cart` (`user_id`, `item_id`) VALUES
  (1, 1),
  (3, 11),
  (1, 16);

-- Захиалгын хүснэгт (orders)
DROP TABLE IF EXISTS `orders`;
CREATE TABLE `orders` (
  `order_id` INT(11) NOT NULL AUTO_INCREMENT,
  `item_id` INT(11) NOT NULL,
  `user_id` INT(11) NOT NULL,
  `status` VARCHAR(20) NOT NULL DEFAULT 'confirmed',
  `phone` VARCHAR(20) NOT NULL,
  `address` TEXT NOT NULL,
  `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `cart_id` INT(11) DEFAULT NULL,
  `checked` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`order_id`),
  FOREIGN KEY (`user_id`) REFERENCES `user`(`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`item_id`) REFERENCES `product`(`item_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`cart_id`) REFERENCES `cart`(`cart_id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `orders` (`item_id`, `status`, `user_id`, `date`, `cart_id`) VALUES
  (17, 'confirmed', 2, '2024-04-02', NULL),
  (2, 'confirmed', 1, '2024-04-06', NULL),
  (3, 'confirmed', 3, '2024-04-08', NULL),
  (3, 'confirmed', 2, '2024-04-09', NULL),
  (3, 'confirmed', 1, '2024-04-13', NULL);

-- Сэтгэгдэл (Reviews)
CREATE TABLE `reviews` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `image` VARCHAR(255) DEFAULT NULL,
  `comment` TEXT NOT NULL,
  `rating` TINYINT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;