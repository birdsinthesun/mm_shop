SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `mm_address_shipment` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plz` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;


CREATE TABLE `mm_category` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `published` char(1) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT '',
  `short_description` text COLLATE utf8mb4_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;



CREATE TABLE `mm_order` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `status` int DEFAULT NULL,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order_total` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `invoice_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sended_invoice` char(1) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT '',
  `order_datetime` bigint DEFAULT NULL,
  `updated_datetime` bigint DEFAULT NULL,
  `customer_id` int DEFAULT NULL,
  `payment` int DEFAULT NULL,
  `shipment` int DEFAULT NULL,
  `paypal_order_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_config_id` int DEFAULT NULL,
  `agb_akzeptiert` char(1) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT '',
  `datenschutzerklaerung_akzeptiert` char(1) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT '',
  `newsletter` char(1) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE `mm_order_product` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `product_id` int DEFAULT NULL,
  `count` int DEFAULT NULL,
  `tax` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;


CREATE TABLE `mm_personaldata` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `plz` int DEFAULT NULL,
  `salutation` int DEFAULT NULL,
  `use_for_shipment` char(1) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT '',
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE `mm_product` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `short_description` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_number` int DEFAULT NULL,
  `tax` int DEFAULT NULL,
  `brand` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `availability` int DEFAULT NULL,
  `condition` int DEFAULT NULL,
  `images` blob,
  `images__sort` blob,
  `category` int DEFAULT NULL,
  `published` char(1) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;


ALTER TABLE `mm_address_shipment`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mm_category`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mm_order`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mm_order_product`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mm_personaldata`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mm_product`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `mm_address_shipment`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `mm_category`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `mm_order`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `mm_order_product`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `mm_personaldata`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `mm_product`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
