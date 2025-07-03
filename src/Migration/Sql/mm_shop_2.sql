CREATE TABLE `mm_order_status` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT INTO `mm_order_status` (`id`, `pid`, `sorting`, `tstamp`, `name`, `alias`) VALUES
(1, 0, 0, 1747694668, 'Bezahlt', 'paid'),
(2, 0, 0, 1747694653, 'Noch nicht bezahlt', 'not_paid'),
(3, 0, 0, 1747694694, 'Storniert', 'canceled'),
(4, 0, 0, 1747694720, 'Versendet &#40;abgeschlossen&#41;', 'shipped');

CREATE TABLE `mm_overview` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT INTO `mm_overview` (`id`, `pid`, `sorting`, `tstamp`, `name`, `description`, `alias`) VALUES
(1, 0, 0, 1747260190, 'Datenschutzerklärung', '<p>Ich habe die <a title=\"Zur Datenschutzerklärung \" href=\"#\" target=\"_blank\" rel=\"noopener\">Datenschutzerklärung </a>gelesen</p>', 'datenschutzerklarung'),
(2, 0, 0, 1748558112, 'AGB', '<p>Ich aktzeptiere die <a title=\"Zu den AGBs\" href=\"#\" target=\"_blank\" rel=\"noopener\">AGB</a>.</p>', 'agb'),
(3, 0, 0, 1747260323, 'Newsletter', '<p>Ja ich möchte auf dem Laufenden bleiben.</p>', 'newsletter');

CREATE TABLE `mm_payment` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `costs` double DEFAULT NULL,
  `tax` int DEFAULT NULL,
  `paypal_client_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paypal_secret` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `paypal_api_base` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT INTO `mm_payment` (`id`, `pid`, `sorting`, `tstamp`, `name`, `description`, `costs`, `tax`, `paypal_client_id`, `paypal_secret`, `paypal_api_base`, `alias`) VALUES
(1, 0, 0, 1751246052, 'PayPal', '<p>Nach dem Sie &#34;kostenpflichtig Kaufen&#34; geklickt haben werden Sie an PayPal weitergeleitet.<br><br><a title=\"Weitere Informationen finden sie hier\" href=\"#\" target=\"_blank\" rel=\"noopener\">Weitere Informationen finden sie hier</a></p>', 0, 1, 'AR7fxJdUlnENpZ7vXHmXDZMwrlRBVCeh4ht9i2sMF0ljQwRjFN49xi9zfkfZ7tTSmpSGTJCXK-AU6WeG', 'EFODPxVnIOXZZseDjTxK-grvHfdvat9_AWQBfQUEfoSdVx__PO5e5URxefw3juVcaiezM1A18ROP1pfy', 'https://api-m.sandbox.paypal.com', 'paypal'),
(2, 0, 0, 1751233432, 'Banküberweisung', '<p>Nach dem Sie &#34;kostenpflichtig Kaufen&#34; geklickt haben bekommen Sie eine Bestätigungsmail, in der sich unsere Bank-Verbindungsdaten befinden.<br><br><a title=\"Weitere Informationen finden sie hier\" href=\"#\" target=\"_blank\" rel=\"noopener\">Weitere Informationen finden sie hier</a></p>', 0, 1, NULL, NULL, NULL, 'bankuberweisung');

CREATE TABLE `mm_product_availability` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT INTO `mm_product_availability` (`id`, `pid`, `sorting`, `tstamp`, `name`, `alias`) VALUES
(1, 0, 0, 1746930991, 'verfügbar', 'in stock'),
(2, 0, 0, 1746931037, 'nicht verfügbar', 'out of stock');

CREATE TABLE `mm_product_condition` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT INTO `mm_product_condition` (`id`, `pid`, `sorting`, `tstamp`, `name`, `alias`) VALUES
(1, 0, 0, 1746931088, 'neu', 'new'),
(2, 0, 0, 1746931117, 'generalüberholt', 'refurbished'),
(3, 0, 0, 1746931143, 'gebraucht', 'used');

CREATE TABLE `mm_salutation` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT INTO `mm_salutation` (`id`, `pid`, `sorting`, `tstamp`, `alias`, `name`) VALUES
(1, 0, 0, 1747027072, 'frau', 'Frau'),
(2, 0, 0, 1747027101, 'herr', 'Herr'),
(3, 0, 0, 1747027156, 'divers', 'Divers');

CREATE TABLE `mm_shipment` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `costs` double DEFAULT NULL,
  `tax` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT INTO `mm_shipment` (`id`, `pid`, `sorting`, `tstamp`, `name`, `description`, `costs`, `tax`) VALUES
(1, 0, 0, 1748548910, 'Standard', '<p>Versandkosten 6,50 € inkl. 19% Mwst</p>\n<p><a title=\"Weitere Informationen zum Versand\" href=\"#\" target=\"_blank\" rel=\"noopener\">Weitere Informationen zum Versand</a></p>', 6.5, 1),
(2, 0, 0, 1748548884, 'Abholung', '<p>Wir sind in Berlin.</p>\n<p><a title=\"Hier können Sie die Ware abholen\" href=\"#\" target=\"_blank\" rel=\"noopener\">Hier können Sie die Ware abholen</a></p>', 0, 1);

CREATE TABLE `mm_shop` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_ust_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_surname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_street_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_description` text COLLATE utf8mb4_unicode_ci,
  `owner_country` varchar(2) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `owner_plz` int DEFAULT NULL,
  `use_custom_css` char(1) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT '',
  `owner_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_logo` blob,
  `owner_tax_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `shop_b2b` char(1) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT '',
  `checkout_rendering` int DEFAULT NULL,
  `checkout_personal_data_dca` int DEFAULT NULL,
  `product_list_rendering` int DEFAULT NULL,
  `product_detail_rendering` int DEFAULT NULL,
  `cart_page` int DEFAULT NULL,
  `checkout_page` int DEFAULT NULL,
  `product_list_page` int DEFAULT NULL,
  `product_detail_page` int DEFAULT NULL,
  `cart_rendering` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;



CREATE TABLE `mm_tax` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_inclusive` char(1) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT '',
  `alias` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `tax` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT INTO `mm_tax` (`id`, `pid`, `sorting`, `tstamp`, `name`, `is_inclusive`, `alias`, `tax`) VALUES
(1, 0, 0, 1748477718, 'inkl. 19 % Mwst', '1', 'inkl-19-mwst', 19),
(2, 0, 0, 1748477728, 'inkl. 7 % Mwst', '1', 'inkl-7-mwst', 7),
(3, 0, 0, 1746997225, '7 %', '', '7', 7),
(4, 0, 0, 1747602694, '19 %', '', '19', 19),
(5, 0, 0, 1748477777, '0 % Mwst', '1', '0-mwst', 0);


ALTER TABLE `mm_order_status`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mm_overview`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mm_payment`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mm_product_availability`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mm_product_condition`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mm_salutation`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mm_shipment`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mm_shop`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `mm_tax`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `mm_order_status`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `mm_overview`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `mm_payment`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `mm_product_availability`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `mm_product_condition`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `mm_salutation`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `mm_shipment`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

ALTER TABLE `mm_shop`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0;

ALTER TABLE `mm_tax`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
