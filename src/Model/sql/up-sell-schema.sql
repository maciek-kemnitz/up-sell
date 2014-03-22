
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- product
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `product`;

CREATE TABLE `product`
(
    `id` INTEGER NOT NULL,
    `up_sell_id` INTEGER NOT NULL,
    `name` TEXT NOT NULL,
    `img_url` TEXT NOT NULL,
    `original_price` DECIMAL(10,0) NOT NULL,
    `url` TEXT NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE INDEX `id` (`id`, `up_sell_id`),
    INDEX `up_sell_id` (`up_sell_id`),
    CONSTRAINT `product_ibfk_1`
        FOREIGN KEY (`up_sell_id`)
        REFERENCES `up_sell` (`id`)
) ENGINE=InnoDB;

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
    `name` VARCHAR(255) NOT NULL,
    `headline` TEXT NOT NULL,
    `description` TEXT NOT NULL,
    `price_from` FLOAT,
    `price_to` FLOAT,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
