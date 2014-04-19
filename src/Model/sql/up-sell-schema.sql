
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- product
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `shoplo_product_id` INTEGER NOT NULL,
    `shop_domain` VARCHAR(255) NOT NULL,
    `name` TEXT NOT NULL,
    `img_url` TEXT NOT NULL,
    `original_price` FLOAT NOT NULL,
    `url` TEXT NOT NULL,
    `thumbnail` TEXT,
    `sku` FLOAT,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `shoplo_product_id` (`shoplo_product_id`, `shop_domain`)
) ENGINE=InnoDB CHARACTER SET='utf8';

-- ---------------------------------------------------------------------
-- product_in_cart
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `product_in_cart`;

CREATE TABLE `product_in_cart`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `up_sell_id` INTEGER NOT NULL,
    `product_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `up_sell_id` (`up_sell_id`, `product_id`),
    CONSTRAINT `product_in_cart_ibfk_1`
        FOREIGN KEY (`up_sell_id`)
        REFERENCES `up_sell` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- related_product
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `related_product`;

CREATE TABLE `related_product`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `up_sell_id` INTEGER NOT NULL,
    `product_id` INTEGER NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `up_sell_id` (`up_sell_id`, `product_id`),
    CONSTRAINT `related_product_ibfk_1`
        FOREIGN KEY (`up_sell_id`)
        REFERENCES `up_sell` (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- up_sell
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `up_sell`;

CREATE TABLE `up_sell`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `shop_domain` VARCHAR(255) NOT NULL,
    `order` INTEGER NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `headline` TEXT NOT NULL,
    `description` TEXT NOT NULL,
    `price_from` FLOAT,
    `price_to` FLOAT,
    `use_price_range` enum('0','1') DEFAULT '1' NOT NULL,
    `created_at` DATETIME NOT NULL,
    `status` enum('active','disabled') DEFAULT 'active' NOT NULL,
    `discount_type` enum('none','percent','amount') DEFAULT 'none' NOT NULL,
    `discount_amount` FLOAT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB CHARACTER SET='utf8';

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
