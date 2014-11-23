
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- cross_sell
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `cross_sell`;

CREATE TABLE `cross_sell`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `shop_domain` VARCHAR(255),
    `name` VARCHAR(255),
    `headline` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `order` INTEGER NOT NULL,
    `status` enum('active','disabled') DEFAULT 'active' NOT NULL,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- gatekeeper
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `gatekeeper`;

CREATE TABLE `gatekeeper`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `shop_domain` VARCHAR(255) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

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
    `original_price` DOUBLE NOT NULL,
    `current_price` DOUBLE NOT NULL,
    `availability` TINYINT NOT NULL,
    `url` TEXT NOT NULL,
    `thumbnail` TEXT NOT NULL,
    `sku` VARCHAR(255) NOT NULL,
    `description` TEXT,
    `variants` TEXT,
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
    `variant_selected` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `up_sell_id` (`up_sell_id`, `product_id`, `variant_selected`),
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
    `variant_selected` INTEGER,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `up_sell_id` (`up_sell_id`, `product_id`, `variant_selected`),
    INDEX `product_id` (`product_id`),
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
    `shop_id` INTEGER NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `headline` TEXT NOT NULL,
    `description` TEXT NOT NULL,
    `price_from` DOUBLE,
    `price_to` DOUBLE,
    `order` INTEGER NOT NULL,
    `use_price_range` enum('0','1') DEFAULT '1' NOT NULL,
    `created_at` DATETIME NOT NULL,
    `status` enum('active','disabled') DEFAULT 'active' NOT NULL,
    `discount_type` enum('none','percent','amount') DEFAULT 'none' NOT NULL,
    `discount_amount` FLOAT,
    `placement` enum('product','cart') DEFAULT 'product' NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `shop_id` (`shop_domain`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- widget_stats
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `widget_stats`;

CREATE TABLE `widget_stats`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `shop_domain` VARCHAR(255) NOT NULL,
    `up_sell_id` INTEGER NOT NULL,
    `variant_id` INTEGER,
    `placement` enum('product','cart') DEFAULT 'product' NOT NULL,
    `user_key` VARCHAR(255),
    `status` enum('new','calculated') DEFAULT 'new' NOT NULL,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `shop_id` (`shop_domain`),
    INDEX `widget_stats_FI_1` (`up_sell_id`),
    INDEX `widget_stats_FI_2` (`variant_id`),
    CONSTRAINT `widget_stats_FK_1`
        FOREIGN KEY (`up_sell_id`)
        REFERENCES `up_sell` (`id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT `widget_stats_FK_2`
        FOREIGN KEY (`variant_id`)
        REFERENCES `product` (`shoplo_product_id`)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- up_sell_stats
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `up_sell_stats`;

CREATE TABLE `up_sell_stats`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `shop_domain` VARCHAR(255) NOT NULL,
    `full_value` DOUBLE NOT NULL,
    `up_sell_value` DOUBLE,
    `placement` enum('product','cart') DEFAULT 'product' NOT NULL,
    `order_id` INTEGER,
    `created_at` DATETIME NOT NULL,
    PRIMARY KEY (`id`),
    INDEX `shop_domain` (`shop_domain`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- tmp_request
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `tmp_request`;

CREATE TABLE `tmp_request`
(
    `id` INTEGER NOT NULL AUTO_INCREMENT,
    `data` TEXT,
    `shop_id` INTEGER NOT NULL,
    `status` enum('new','calculated') DEFAULT 'new' NOT NULL,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
