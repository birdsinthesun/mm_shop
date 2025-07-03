CREATE TABLE `tl_metamodel` (
  `id` int UNSIGNED NOT NULL,
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tableName` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `translated` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `languages` text COLLATE utf8mb4_unicode_ci,
  `varsupport` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `localeterritorysupport` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT IGNORE INTO `tl_metamodel` VALUES
(1, 1746971884, 256, 'Shop Konfiguration', 'mm_shop', '', NULL, '', ''),
(2, 1747374108, 512, 'Produkte', 'mm_product', '', NULL, '', ''),
(3, 1747702561, 2048, 'Tags Steuer', 'mm_tax', '', NULL, '', ''),
(4, 1747374108, 640, 'Bestellungen', 'mm_order', '', NULL, '', ''),
(7, 1747699619, 768, 'Kundendaten', 'mm_personaldata', '', NULL, '', ''),
(10, 1747702561, 1920, 'Tags Anrede', 'mm_salutation', '', NULL, '', ''),
(11, 1747702561, 1280, 'Versand', 'mm_shipment', '', NULL, '', ''),
(12, 1747702561, 1152, 'Zahlung', 'mm_payment', '', NULL, '', ''),
(13, 1747702561, 1792, 'Tags Condition Produkte', 'mm_product_condition', '', NULL, '', ''),
(14, 1747702561, 1664, 'Tags Availability Produkte', 'mm_product_availability', '', NULL, '', ''),
(17, 1747702561, 1536, 'Kauf Abschluss', 'mm_overview', '', NULL, '', ''),
(18, 1747702561, 1408, 'Kategorien', 'mm_category', '', NULL, '', ''),
(19, 1747702561, 2176, 'Tags Bestellstatus', 'mm_order_status', '', NULL, '', ''),
(20, 1747702595, 896, 'Lieferadresse', 'mm_address_shipment', '', NULL, '', ''),
(21, 1747702561, 1024, 'bestellte Produkte', 'mm_order_product', '', NULL, '', '');

CREATE TABLE `tl_metamodel_attribute` (
  `id` int UNSIGNED NOT NULL,
  `file_filesOnly` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `name` text COLLATE utf8mb4_unicode_ci,
  `description` text COLLATE utf8mb4_unicode_ci,
  `colname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `isvariant` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `isunique` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag_table` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag_column` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag_sorting` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag_where` text COLLATE utf8mb4_unicode_ci,
  `tag_filter` int UNSIGNED NOT NULL DEFAULT '0',
  `tag_filterparams` text COLLATE utf8mb4_unicode_ci,
  `tag_sort` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'asc',
  `check_publish` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `check_inverse` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `check_listview` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `check_listviewicon` blob,
  `check_listviewicondisabled` blob,
  `countries` text COLLATE utf8mb4_unicode_ci,
  `force_alias` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `validAliasCharacters` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slugLocale` varchar(5) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `noIntegerPrefix` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias_prefix` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias_postfix` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alias_fields` blob,
  `file_customFiletree` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `file_multiple` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `file_uploadFolder` blob,
  `file_validFileTypes` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `select_table` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `select_column` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `select_id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `select_alias` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `select_sorting` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `select_sort` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'asc',
  `select_where` text COLLATE utf8mb4_unicode_ci,
  `select_filter` int UNSIGNED NOT NULL DEFAULT '0',
  `select_filterparams` text COLLATE utf8mb4_unicode_ci,
  `timetype` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT IGNORE INTO `tl_metamodel_attribute` VALUES
(1, '', 1, 128, 1746903769, 'text', 'Name', 'Name der Shop Konfiguration', 'name', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(3, '', 3, 128, 1746924567, 'text', 'Name', NULL, 'name', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(4, '', 3, 256, 1746924605, 'alias', 'Alias', NULL, 'alias', '', '1', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '1', '', NULL, '1', '', '', 0x613a313a7b693a303b613a313a7b733a31353a226669656c645f617474726962757465223b733a343a226e616d65223b7d7d, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(5, '', 3, 384, 1746924712, 'decimal', 'Steuersatz in %', NULL, 'tax', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(6, '', 3, 512, 1746924854, 'checkbox', 'MwSt Inklusive', NULL, 'is_inclusive', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(7, '', 10, 128, 1747026931, 'text', 'Anrede', NULL, 'name', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(8, '', 10, 256, 1746924944, 'alias', NULL, NULL, 'alias', '', '1', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '1', '', NULL, '1', '', '', 0x613a313a7b693a303b613a313a7b733a31353a226669656c645f617474726962757465223b733a31303a2273616c75746174696f6e223b7d7d, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(9, '', 12, 128, 1746925009, 'text', 'Name', NULL, 'name', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(10, '', 12, 512, 1751232731, 'decimal', 'Kosten in €', NULL, 'costs', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(11, '', 11, 128, 1746925181, 'text', 'Name', NULL, 'name', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(12, '', 11, 384, 1748548419, 'decimal', 'Kosten in €', NULL, 'costs', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(13, '', 11, 512, 1748548419, 'longtext', 'Beschreibung', NULL, 'description', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(14, '', 12, 640, 1751232731, 'longtext', 'Beschreibung', NULL, 'description', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(15, '', 1, 384, 1747280003, 'text', 'Shop Name', NULL, 'shop_name', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(16, '', 1, 640, 1747280953, 'longtext', 'Shop Beschreibung', NULL, 'shop_description', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(17, '', 1, 896, 1747670905, 'text', 'Ust-Id', NULL, 'owner_ust_id', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(18, '', 1, 1152, 1747670905, 'text', 'Vorname', NULL, 'owner_surname', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(19, '', 1, 1280, 1747670905, 'text', 'Nachname', NULL, 'owner_lastname', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(20, '', 1, 1536, 1747670905, 'text', 'Straße', NULL, 'owner_street', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(21, '', 1, 1664, 1747670905, 'text', 'Nr', NULL, 'owner_street_number', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(22, '', 1, 1792, 1747670905, 'numeric', 'PLZ', NULL, 'owner_plz', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(23, '', 1, 1920, 1747670905, 'text', 'Stadt', NULL, 'owner_city', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(24, '', 1, 2048, 1747670905, 'text', 'Bundesland', NULL, 'owner_state', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(25, '', 1, 2176, 1747670905, 'country', 'Land', NULL, 'owner_country', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(26, '', 7, 256, 1747772115, 'select', 'Anrede', NULL, 'salutation', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'mm_salutation', 'name', '', 'id', 'sorting', 'asc', NULL, 0, NULL, ''),
(27, '', 7, 384, 1746995976, 'text', 'Vorname', NULL, 'surname', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(28, '', 7, 640, 1747256743, 'text', 'Nachname', NULL, 'lastname', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(29, '', 7, 896, 1747288680, 'text', 'Straße', NULL, 'street', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(30, '', 7, 1024, 1747288680, 'text', 'Nr', NULL, 'street_number', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(31, '', 7, 1152, 1747288680, 'numeric', 'PLZ', NULL, 'plz', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(32, '', 7, 1408, 1747288680, 'text', 'Bundesland', NULL, 'state', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(33, '', 7, 1536, 1747288680, 'country', 'Land', NULL, 'country', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(34, '', 7, 1664, 1747288680, 'checkbox', 'Als Lieferadresse benutzen', NULL, 'use_for_shipment', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(35, '', 2, 256, 1747254909, 'text', 'Name', NULL, 'name', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(36, '', 2, 512, 1747254909, 'numeric', 'Artikelnummer', NULL, 'item_number', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(37, '', 2, 896, 1747254909, 'longtext', 'Beschreibung', NULL, 'description', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(38, '', 2, 768, 1747254909, 'longtext', 'Kurze Beschreibung', NULL, 'short_description', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(39, '', 2, 1024, 1747678901, 'text', 'Preis in €', 'Beispiel Einhabeformat: 12,99', 'price', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(40, '', 2, 1152, 1747254909, 'select', 'Mwst', NULL, 'tax', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'mm_tax', 'name', '', 'alias', 'name', 'asc', NULL, 0, NULL, ''),
(41, '', 2, 384, 1747254909, 'alias', 'Alias', NULL, 'alias', '', '1', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '1', '', NULL, '1', '', '', 0x613a313a7b693a303b613a313a7b733a31353a226669656c645f617474726962757465223b733a343a226e616d65223b7d7d, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(42, '', 2, 640, 1747254909, 'file', 'Bilder', NULL, 'images', '', '', 'tl_files', 'name', 'id', 'uuid', 'lastModified', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '1', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(44, '', 2, 1280, 1747254909, 'text', 'Marke', NULL, 'brand', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(45, '', 13, 128, 1746930114, 'text', 'Name', NULL, 'name', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(46, '', 13, 256, 1746930162, 'alias', 'Alias', NULL, 'alias', '', '1', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', 0x613a313a7b693a303b613a313a7b733a31353a226669656c645f617474726962757465223b733a343a226e616d65223b7d7d, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(47, '', 14, 128, 1746930278, 'text', 'Name', NULL, 'name', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(48, '', 14, 256, 1746930323, 'alias', 'Alias', NULL, 'alias', '', '1', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', 0x613a313a7b693a303b613a313a7b733a31353a226669656c645f617474726962757465223b733a343a226e616d65223b7d7d, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(49, '', 2, 1408, 1747254909, 'select', 'Verfügbarkeit', NULL, 'availability', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'mm_product_availability', 'name', '', 'alias', 'sorting', 'asc', NULL, 0, NULL, ''),
(50, '', 2, 1536, 1747254909, 'select', 'Zustand', NULL, 'condition', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'mm_product_condition', 'name', '', 'alias', 'sorting', 'asc', NULL, 0, NULL, ''),
(51, '', 2, 1664, 1747518238, 'checkbox', 'Veröffentlichen', NULL, 'published', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '1', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(56, '', 7, 1280, 1747288680, 'text', 'Stadt', NULL, 'city', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(57, '', 7, 768, 1747288680, 'text', 'Mail', NULL, 'email', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(58, '', 17, 128, 1747258769, 'text', 'Name', NULL, 'name', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(59, '', 17, 256, 1747258794, 'alias', 'Alias', NULL, 'alias', '', '1', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '1', '', NULL, '1', '', '', 0x613a313a7b693a303b613a313a7b733a31353a226669656c645f617474726962757465223b733a343a226e616d65223b7d7d, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(60, '', 17, 384, 1747258828, 'longtext', 'Beschreibung', NULL, 'description', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(61, '', 1, 2304, 1747670905, 'checkbox', 'Eigenes CSS benutzen für das Frontend', NULL, 'use_custom_css', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(62, '', 1, 1408, 1747670905, 'text', 'Email', NULL, 'owner_email', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(63, '', 1, 512, 1747280965, 'file', 'Logo', NULL, 'shop_logo', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(65, '', 1, 3328, 1747692099, 'numeric', 'Persönliche Daten Eingabemaske Id', 'Bitte geben SIe die ID der vorkonfigurierten Eingabemaske für das Frontend an. mm_personal_data', 'checkout_personal_data_dca', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(67, '', 1, 1024, 1747670905, 'text', 'Steuernummer', 'Falls keine Ust-ID vorhanden ist', 'owner_tax_number', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(68, '', 18, 128, 1747374149, 'text', 'Name', NULL, 'name', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(69, '', 18, 256, 1747374182, 'alias', 'Alias', NULL, 'alias', '', '1', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '1', '', NULL, '1', '', '', 0x613a313a7b693a303b613a313a7b733a31353a226669656c645f617474726962757465223b733a343a226e616d65223b7d7d, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(70, '', 2, 128, 1747374786, 'select', 'Kategorie', NULL, 'category', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'mm_category', 'name', '', 'alias', 'sorting', 'asc', NULL, 0, NULL, ''),
(71, '', 18, 512, 1748545888, 'checkbox', 'Veröffentlicht', NULL, 'published', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '1', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(72, '', 19, 128, 1747558393, 'text', 'Name', NULL, 'name', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(73, '', 19, 256, 1747694594, 'alias', 'Alias', NULL, 'alias', '', '1', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', 0x613a313a7b693a303b613a313a7b733a31353a226669656c645f617474726962757465223b733a343a226e616d65223b7d7d, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(74, '', 20, 128, 1747558719, 'text', 'Straße', NULL, 'street', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(75, '', 20, 256, 1747558747, 'text', 'Nr.', NULL, 'street_number', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(76, '', 20, 384, 1747558777, 'numeric', 'PLZ', NULL, 'plz', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(77, '', 20, 512, 1747558799, 'text', 'Stadt', NULL, 'city', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(78, '', 20, 640, 1747558831, 'text', 'Bundesland', NULL, 'state', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(79, '', 20, 768, 1747558861, 'country', 'Land', NULL, 'country', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(80, '', 4, 768, 1751413355, 'select', 'Status', NULL, 'status', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'mm_order_status', 'name', '', 'alias', 'name', 'asc', NULL, 0, NULL, ''),
(81, '', 1, 768, 1747670905, 'checkbox', 'B2B', 'Dann ist die MwSt exclusive dargestellt und berechnet', 'shop_b2b', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(82, '', 1, 2816, 1747722226, 'select', 'Warentkorb Seite', NULL, 'cart_page', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'tl_page', 'title', 'id', 'id', 'sorting', 'asc', NULL, 0, NULL, ''),
(83, '', 1, 3456, 1747722092, 'select', 'Produkte Seite', NULL, 'product_list_page', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'tl_page', 'title', 'id', 'id', 'sorting', 'asc', NULL, 0, NULL, ''),
(84, '', 1, 3712, 1747722275, 'select', 'Produktdetail-Seite', NULL, 'product_detail_page', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'tl_page', 'title', 'id', 'id', 'sorting', 'asc', NULL, 0, NULL, ''),
(85, '', 1, 3072, 1747722250, 'select', 'Kasse-Seite', NULL, 'checkout_page', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'tl_page', 'title', 'id', 'id', 'sorting', 'asc', NULL, 0, NULL, ''),
(86, '', 1, 2944, 1747947855, 'numeric', 'Warenkorb Rendereinstellung Id', 'mm_product', 'cart_rendering', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(87, '', 1, 3584, 1747692099, 'numeric', 'Produkte Rendereinstellung Id', 'mm_product', 'product_list_rendering', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(88, '', 1, 3200, 1747691794, 'numeric', 'Kasse Rendereinstellung Id', 'mm_product', 'checkout_rendering', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(89, '', 1, 3840, 1747692100, 'numeric', 'Produktdetails Rendereinstellung Id', 'mm_product', 'product_detail_rendering', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(90, '', 21, 256, 1747695513, 'text', 'Name', NULL, 'name', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(91, '', 21, 128, 1747695513, 'numeric', 'Produkt Id', NULL, 'product_id', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(92, '', 21, 384, 1747695583, 'numeric', 'Anzahl', NULL, 'count', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(93, '', 21, 640, 1747696661, 'text', 'Preis pro Stück', NULL, 'price', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(94, '', 4, 512, 1751413355, 'timestamp', 'Bestelldatum und -zeit', NULL, 'order_datetime', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, 'date'),
(95, '', 4, 1408, 1751413355, 'checkbox', 'Rechnung versendet', NULL, 'sended_invoice', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(96, '', 4, 640, 1751413355, 'timestamp', 'Zuletzt bearbeitet', NULL, 'updated_datetime', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, 'date'),
(97, '', 4, 256, 1751413355, 'text', 'Bestellnummer', NULL, 'order_number', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(98, '', 4, 1152, 1751413355, 'text', 'Gesamtsumme Brutto', NULL, 'order_total', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(99, '', 21, 512, 1747702824, 'select', 'Steuer', NULL, 'tax', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'mm_tax', 'name', '', 'id', 'name', 'asc', NULL, 0, NULL, ''),
(100, '', 4, 896, 1751413355, 'select', 'Zahlungsart', NULL, 'payment', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'mm_payment', 'name', '', 'alias', 'name', 'asc', NULL, 0, NULL, ''),
(101, '', 4, 1024, 1751413355, 'select', 'Versandart', NULL, 'shipment', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'mm_shipment', 'name', '', 'id', 'name', 'asc', NULL, 0, NULL, ''),
(102, '', 4, 1280, 1751413355, 'text', 'Rechnungsnummer', NULL, 'invoice_name', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(103, '', 4, 384, 1751413355, 'select', 'Kunde', NULL, 'customer_id', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'mm_personaldata', 'email', '', 'id', 'email', 'asc', NULL, 0, NULL, ''),
(104, '', 18, 384, 1748545888, 'longtext', 'Kurze Beschreibung &#40;SEO&#41;', 'Meta-Tags Description', 'short_description', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(105, '', 11, 256, 1748548419, 'select', 'Steuer', NULL, 'tax', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'mm_tax', 'name', '', 'id', 'name', 'asc', NULL, 0, NULL, ''),
(106, '', 12, 384, 1751232731, 'select', 'Steuer', NULL, 'tax', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'mm_tax', 'name', '', 'id', 'name', 'asc', NULL, 0, NULL, ''),
(107, '', 12, 768, 1751232731, 'text', 'Client Id', NULL, 'paypal_client_id', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(108, '', 12, 896, 1751232731, 'text', 'Secret', NULL, 'paypal_secret', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(109, '', 12, 1024, 1751232731, 'text', 'API Base', 'https://api-m.paypal.com oder https://api-m.sandbox.paypal.com', 'paypal_api_base', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(110, '', 12, 256, 1751232731, 'alias', 'Alias', NULL, 'alias', '', '1', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '1', '', NULL, '1', '', '', 0x613a313a7b693a303b613a313a7b733a31353a226669656c645f617474726962757465223b733a343a226e616d65223b7d7d, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(111, '', 4, 1536, 1751413355, 'text', 'PayPal Bestellung Id', NULL, 'paypal_order_id', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(112, '', 4, 128, 1751413355, 'select', 'Shop Konfiguration', NULL, 'shop_config_id', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', 'mm_shop', 'name', '', 'id', 'name', 'asc', NULL, 0, NULL, ''),
(113, '', 4, 1664, 1751417117, 'checkbox', 'AGB akzeptiert', NULL, 'agb_akzeptiert', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(114, '', 4, 1792, 1751417190, 'checkbox', 'Datenschutzerklärung akzeptiert', NULL, 'datenschutzerklaerung_akzeptiert', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, ''),
(115, '', 4, 1920, 1751417246, 'checkbox', 'Newsletter', NULL, 'newsletter', '', '', '', '', '', '', '', NULL, 0, NULL, 'asc', '', '', '', NULL, NULL, NULL, '', '', NULL, '1', '', '', NULL, '', '', NULL, '', '', '', '', '', '', 'asc', NULL, 0, NULL, '');

CREATE TABLE `tl_metamodel_dca` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rendertype` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ptable` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rendermode` varchar(12) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `showColumns` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `backendsection` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `backendicon` blob,
  `backendcaption` text COLLATE utf8mb4_unicode_ci,
  `panelLayout` blob,
  `iseditable` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `iscreatable` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `isdeleteable` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `subheadline` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT IGNORE INTO `tl_metamodel_dca` VALUES
(1, 1, 0, 1746918642, 'Shop Konfiguration', 'standalone', '', 'flat', '1', 'shop', NULL, 'a:1:{i:0;a:3:{s:8:\"langcode\";s:5:\"de_DE\";s:5:\"label\";s:4:\"Shop\";s:11:\"description\";s:18:\"Shop Konfiguration\";}}', 0x6c696d69742c736561726368, '1', '1', '1', ''),
(2, 2, 0, 1746995005, 'Produkte', 'standalone', 'mm_shop', 'flat', '', 'shop', NULL, 'a:1:{i:0;a:3:{s:8:\"langcode\";s:5:\"de_DE\";s:5:\"label\";s:8:\"Produkte\";s:11:\"description\";s:8:\"Produkte\";}}', 0x6c696d69742c66696c7465722c736561726368, '1', '1', '1', ''),
(3, 3, 0, 1747602671, 'Steuer', 'standalone', '', 'flat', '', 'metamodels', NULL, 'a:1:{i:0;a:3:{s:8:\"langcode\";s:5:\"de_DE\";s:5:\"label\";s:10:\"Tag Steuer\";s:11:\"description\";s:10:\"Tag Steuer\";}}', 0x6c696d6974, '1', '1', '', 'Steuerwert der im Produkt ausgewählt werden muss'),
(4, 4, 0, 1747908284, 'Bestellungen', 'standalone', 'mm_shop', 'flat', '1', 'shop', NULL, 'a:1:{i:0;a:3:{s:8:\"langcode\";s:5:\"de_DE\";s:5:\"label\";s:12:\"Bestellungen\";s:11:\"description\";s:12:\"Bestellungen\";}}', 0x6c696d6974, '1', '', '', ''),
(6, 10, 0, 1747027059, 'Tags Anrede', 'standalone', '', 'flat', '', 'metamodels', NULL, 'a:1:{i:0;a:3:{s:8:\"langcode\";s:5:\"de_DE\";s:5:\"label\";s:11:\"Tags Anrede\";s:11:\"description\";s:6:\"Anrede\";}}', 0x6c696d6974, '1', '', '', ''),
(7, 13, 0, 1746997078, 'Tags Zustand Produkte', 'standalone', '', 'flat', '', 'metamodels', NULL, 'a:1:{i:0;a:3:{s:8:\"langcode\";s:5:\"de_DE\";s:5:\"label\";s:12:\"Tags Zustand\";s:11:\"description\";s:21:\"Tags Zustand Produkte\";}}', 0x6c696d6974, '', '', '', ''),
(8, 14, 0, 1746997004, 'Verfügbarkeit', 'standalone', '', 'flat', '', 'metamodels', NULL, 'a:1:{i:0;a:3:{s:8:\"langcode\";s:5:\"de_DE\";s:5:\"label\";s:19:\"Tags Verfügbarkeit\";s:11:\"description\";s:14:\"Verfügbarkeit\";}}', 0x6c696d6974, '', '', '', ''),
(9, 12, 0, 1746966542, 'Zahlungsweg', 'standalone', '', 'flat', '', 'shop', NULL, 'a:1:{i:0;a:3:{s:8:\"langcode\";s:5:\"de_DE\";s:5:\"label\";s:11:\"Zahlungsweg\";s:11:\"description\";s:11:\"Zahlungsweg\";}}', 0x6c696d6974, '1', '1', '1', ''),
(10, 11, 0, 1746966815, 'Versand', 'standalone', '', 'flat', '', 'shop', NULL, 'a:1:{i:0;a:3:{s:8:\"langcode\";s:2:\"ab\";s:5:\"label\";s:7:\"Versand\";s:11:\"description\";s:7:\"Versand\";}}', 0x6c696d6974, '1', '1', '1', ''),
(11, 7, 0, 1747714811, 'Kundendaten', 'standalone', 'mm_order', 'flat', '1', 'shop', NULL, 'a:1:{i:0;a:3:{s:8:\"langcode\";s:5:\"de_DE\";s:5:\"label\";s:11:\"Kundendaten\";s:11:\"description\";s:11:\"Kundendaten\";}}', 0x6c696d69742c66696c7465722c736561726368, '1', '', '', ''),
(13, 7, 0, 1747004354, 'FE Bestellprozess Personendaten', 'standalone', '', 'flat', '', '', NULL, 'a:1:{i:0;a:3:{s:8:\"langcode\";s:5:\"de_DE\";s:5:\"label\";s:13:\"Personendaten\";s:11:\"description\";s:13:\"Personendaten\";}}', 0x6c696d6974, '1', '1', '1', ''),
(14, 17, 0, 1747286579, 'Kauf Abschluss', 'standalone', '', 'flat', '', 'shop', NULL, 'a:1:{i:0;a:3:{s:8:\"langcode\";s:2:\"de\";s:5:\"label\";s:14:\"Kauf Abschluss\";s:11:\"description\";s:14:\"Kauf Abschluss\";}}', 0x6c696d6974, '1', '', '', ''),
(15, 18, 0, 1747374403, 'Kategorien', 'standalone', '', 'flat', '', 'shop', NULL, 'a:1:{i:0;a:3:{s:8:\"langcode\";s:2:\"ab\";s:5:\"label\";s:10:\"Kategorien\";s:11:\"description\";s:10:\"Kategorien\";}}', 0x6c696d6974, '1', '1', '1', ''),
(16, 19, 0, 1747558523, 'Tags Bestellstatus', 'standalone', '', 'flat', '', 'metamodels', NULL, 'a:1:{i:0;a:3:{s:8:\"langcode\";s:5:\"de_DE\";s:5:\"label\";s:18:\"Tags Bestellstatus\";s:11:\"description\";s:18:\"Tags Bestellstatus\";}}', 0x6c696d6974, '1', '1', '1', ''),
(17, 20, 0, 1747721518, 'Lieferadresse', 'ctable', 'mm_order', 'flat', '1', 'metamodels', NULL, 'a:1:{i:0;a:3:{s:8:\"langcode\";s:5:\"de_DE\";s:5:\"label\";s:13:\"Lieferadresse\";s:11:\"description\";s:13:\"Lieferadresse\";}}', 0x6c696d6974, '1', '1', '1', ''),
(18, 21, 0, 1747714758, 'bestellte Produkte', 'ctable', 'mm_order', 'flat', '1', 'metamodels', NULL, 'a:1:{i:0;a:3:{s:8:\"langcode\";s:2:\"ab\";s:5:\"label\";s:18:\"bestellte Produkte\";s:11:\"description\";s:18:\"bestellte Produkte\";}}', 0x6c696d6974, '1', '1', '1', '');

CREATE TABLE `tl_metamodel_dcasetting` (
  `id` int UNSIGNED NOT NULL,
  `tl_class` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'w50',
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `published` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `dcatype` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `attr_id` int UNSIGNED NOT NULL DEFAULT '0',
  `be_template` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `legendhide` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `legendtitle` text COLLATE utf8mb4_unicode_ci,
  `mandatory` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `alwaysSave` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `filterable` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `searchable` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `chosen` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `allowHtml` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `preserveTags` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `decodeEntities` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rte` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tinyMCE',
  `rows` int NOT NULL DEFAULT '0',
  `cols` int NOT NULL DEFAULT '0',
  `trailingSlash` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '2',
  `spaceToUnderscore` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `includeBlankOption` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `submitOnChange` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `readonly` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rgxp` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `tag_as_wizard` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `tag_minLevel` int NOT NULL DEFAULT '0',
  `tag_maxLevel` int NOT NULL DEFAULT '0',
  `file_widgetMode` char(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'normal',
  `select_as_radio` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `select_minLevel` int NOT NULL DEFAULT '0',
  `select_maxLevel` int NOT NULL DEFAULT '0',
  `clear_datetime` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT IGNORE INTO `tl_metamodel_dcasetting` VALUES
(1, 'w50', 1, 128, 1746903945, '1', 'attribute', 1, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(2, 'w50', 8, 128, 1746930539, '1', 'attribute', 47, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(3, 'w50', 8, 256, 1746930574, '1', 'attribute', 48, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(4, 'w50', 7, 128, 1746930677, '1', 'attribute', 45, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(5, 'w50', 7, 256, 1746930699, '1', 'attribute', 46, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(6, 'w50', 9, 128, 1746966579, '1', 'attribute', 9, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(7, 'w50', 9, 1024, 1751233354, '1', 'attribute', 14, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(8, 'w50', 9, 1280, 1751233354, '1', 'attribute', 10, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(9, 'w50', 10, 128, 1746966851, '1', 'attribute', 11, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(10, 'w50', 10, 256, 1746966906, '1', 'attribute', 13, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(11, 'w50', 10, 512, 1748548461, '1', 'attribute', 12, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(12, 'w50', 6, 128, 1746968006, '1', 'attribute', 7, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(13, 'w50', 6, 256, 1746968031, '1', 'attribute', 8, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(14, 'w50', 11, 256, 1746996035, '1', 'attribute', 26, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '', '', '', '', '0', 0, 0, 'normal', '', 0, 0, ''),
(15, 'w50', 11, 384, 1746996035, '1', 'attribute', 27, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(16, 'w50', 11, 512, 1746996035, '1', 'attribute', 28, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(17, 'w50', 11, 640, 1746996035, '1', 'attribute', 29, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(18, 'w50', 11, 768, 1746996035, '1', 'attribute', 30, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(19, 'w50', 11, 896, 1746996035, '1', 'attribute', 31, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(20, 'w50', 11, 1024, 1746996035, '1', 'attribute', 32, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(21, 'w50', 11, 1152, 1746996035, '1', 'attribute', 33, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(22, 'w50', 11, 1280, 1746996325, '', 'attribute', 34, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(23, 'w50', 2, 256, 1747374838, '1', 'attribute', 35, '', '', NULL, '1', '', '', '1', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(24, 'w50', 2, 384, 1747374838, '1', 'attribute', 41, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(25, 'w50', 2, 512, 1747374838, '1', 'attribute', 36, '', '', NULL, '1', '', '', '1', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(26, 'clr widget', 2, 640, 1747374838, '1', 'attribute', 42, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '1', '', '', '2', 0, 0, 'gallery', '0', 0, 0, ''),
(27, 'clr long', 2, 768, 1748548660, '1', 'attribute', 38, '', '', NULL, '1', '', '', '', '', '', '', '', '', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(28, 'clr long', 2, 896, 1747374838, '1', 'attribute', 37, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(29, 'w50', 2, 1024, 1747679171, '1', 'attribute', 39, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', 'extnd', '0', 0, 0, 'normal', '0', 0, 0, ''),
(30, 'w50', 2, 1152, 1747374838, '1', 'attribute', 40, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '', '', '', '', '0', 0, 0, 'normal', '', 0, 0, ''),
(31, 'w50', 2, 1280, 1747374838, '1', 'attribute', 44, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(32, 'w50', 2, 1408, 1747374838, '1', 'attribute', 49, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '', '', '', '', '0', 0, 0, 'normal', '', 0, 0, ''),
(33, 'w50', 2, 1536, 1747374838, '1', 'attribute', 50, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '', '', '', '', '0', 0, 0, 'normal', '', 0, 0, ''),
(34, 'w50', 1, 256, 1746969547, '1', 'attribute', 15, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(35, 'clr long', 1, 512, 1747694188, '1', 'attribute', 16, '', '', NULL, '1', '', '', '', '', '', '', '', '', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(36, 'w50', 1, 896, 1747670952, '1', 'attribute', 17, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(37, 'w50', 1, 1152, 1747670952, '1', 'attribute', 18, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(38, 'w50', 1, 1280, 1747670952, '1', 'attribute', 19, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(39, 'w50', 1, 1536, 1747670952, '1', 'attribute', 20, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(40, 'w50', 1, 1664, 1747670952, '1', 'attribute', 21, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(41, 'w50', 1, 1792, 1747670952, '1', 'attribute', 22, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(42, 'w50', 1, 1920, 1747670952, '1', 'attribute', 23, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(43, 'w50', 1, 2048, 1747670952, '1', 'attribute', 24, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(44, 'w50', 1, 2176, 1747670952, '1', 'attribute', 25, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(45, 'w50', 2, 1664, 1747374838, '1', 'attribute', 51, '', '', NULL, '', '', '1', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(46, 'w50', 3, 128, 1746992848, '1', 'attribute', 3, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(47, 'w50', 3, 256, 1746992872, '1', 'attribute', 4, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(48, 'w50', 3, 384, 1746992922, '1', 'attribute', 5, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(49, 'w50', 3, 512, 1746992982, '1', 'attribute', 6, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(53, 'w50', 13, 128, 1747004487, '1', 'attribute', 26, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '', '', '', '', '0', 0, 0, 'normal', '', 0, 0, ''),
(54, 'w50', 13, 256, 1747004545, '1', 'attribute', 27, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', 'alpha', '0', 0, 0, 'normal', '0', 0, 0, ''),
(55, 'w50', 13, 384, 1747004572, '1', 'attribute', 28, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', 'alpha', '0', 0, 0, 'normal', '0', 0, 0, ''),
(56, 'w50', 13, 640, 1747257030, '1', 'attribute', 29, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', 'alpha', '0', 0, 0, 'normal', '0', 0, 0, ''),
(57, 'w50', 13, 768, 1747257030, '1', 'attribute', 30, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', 'alnum', '0', 0, 0, 'normal', '0', 0, 0, ''),
(58, 'w50', 13, 896, 1747257030, '1', 'attribute', 31, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(59, 'w50', 13, 1152, 1747257030, '1', 'attribute', 32, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', 'alpha', '0', 0, 0, 'normal', '0', 0, 0, ''),
(60, 'w50', 13, 1280, 1747257030, '1', 'attribute', 33, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(61, 'w50', 13, 1408, 1747257030, '1', 'attribute', 34, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(64, 'w50', 13, 1024, 1747257030, '1', 'attribute', 56, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', 'alpha', '0', 0, 0, 'normal', '0', 0, 0, ''),
(65, 'w50', 13, 512, 1747257030, '1', 'attribute', 57, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', 'email', '0', 0, 0, 'normal', '0', 0, 0, ''),
(66, 'w50', 14, 128, 1747259732, '1', 'attribute', 58, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(67, 'w50', 14, 256, 1747259773, '1', 'attribute', 59, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(68, 'w50', 14, 384, 1747259828, '1', 'attribute', 60, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(69, 'w50', 1, 2432, 1747670952, '1', 'attribute', 61, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(70, 'w50', 1, 2304, 1747670952, '1', 'legend', 0, '', '1', 'System-Einstellungen', '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(72, 'w50', 1, 4096, 1747692567, '1', 'attribute', 65, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(74, 'w50', 1, 1024, 1747670952, '1', 'attribute', 67, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(75, 'w50', 1, 768, 1747670952, '1', 'legend', 0, '', '', 'Persönliche Angaben', '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(76, 'w50', 1, 384, 1747281554, '1', 'attribute', 63, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(77, 'w50', 1, 1408, 1747670952, '1', 'attribute', 62, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', 'email', '0', 0, 0, 'normal', '0', 0, 0, ''),
(78, 'w50', 15, 128, 1747374492, '1', 'attribute', 68, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(79, 'w50', 15, 256, 1747374519, '1', 'attribute', 69, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(80, 'w50', 2, 128, 1747374838, '1', 'attribute', 70, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '', 0, 0, ''),
(81, 'w50', 15, 512, 1748545942, '1', 'attribute', 71, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(82, 'w50', 17, 128, 1747559117, '1', 'attribute', 74, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(83, 'w50', 17, 256, 1747559137, '1', 'attribute', 75, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(84, 'w50', 17, 384, 1747559157, '1', 'attribute', 76, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(85, 'w50', 17, 512, 1747559177, '1', 'attribute', 77, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(86, 'w50', 17, 640, 1747559198, '1', 'attribute', 78, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(87, 'w50', 17, 768, 1747559219, '1', 'attribute', 79, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(88, 'w50', 1, 640, 1747670952, '1', 'attribute', 81, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(89, 'w50', 1, 2560, 1747692232, '1', 'legend', 0, '', '', 'Produkte-Seite', '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(90, 'w50', 1, 2688, 1747692858, '1', 'attribute', 83, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '2', 0, 0, ''),
(91, 'w50', 1, 2816, 1747692331, '1', 'attribute', 87, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(92, 'w50', 1, 2944, 1747692363, '1', 'legend', 0, '', '', 'Produktdetail-Seite', '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(93, 'w50', 1, 3072, 1747692401, '1', 'attribute', 84, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '', '', '', '', '0', 0, 0, 'normal', '2', 0, 0, ''),
(94, 'w50', 1, 3200, 1747692420, '1', 'attribute', 89, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(95, 'w50', 1, 3328, 1747692442, '1', 'legend', 0, '', '', 'Warenkorb-Seite', '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(96, 'w50', 1, 3456, 1747692479, '1', 'attribute', 82, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '', '', '', '', '0', 0, 0, 'normal', '2', 0, 0, ''),
(97, 'w50', 1, 3584, 1747692502, '1', 'attribute', 86, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(98, 'w50', 1, 3712, 1747692520, '1', 'legend', 0, '', '', 'Kasse-Seite', '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(99, 'w50', 1, 3840, 1747692547, '1', 'attribute', 85, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '', '', '', '', '0', 0, 0, 'normal', '2', 0, 0, ''),
(100, 'w50', 1, 3968, 1747692567, '1', 'attribute', 88, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(101, 'w50', 16, 128, 1747694299, '1', 'attribute', 72, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(102, 'w50', 16, 256, 1747694319, '1', 'attribute', 73, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(103, 'w50', 4, 128, 1747697575, '1', 'attribute', 97, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '1', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(104, 'w50', 4, 256, 1747697559, '1', 'attribute', 94, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '1', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(105, 'w50', 4, 384, 1747697543, '1', 'attribute', 96, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '1', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(106, 'w50', 4, 512, 1747697610, '1', 'attribute', 80, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '', '', '', '', '0', 0, 0, 'normal', '', 0, 0, ''),
(107, 'w50', 4, 640, 1747697641, '1', 'attribute', 100, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '1', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(108, 'w50', 4, 768, 1747697667, '1', 'attribute', 101, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '1', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(109, 'w50', 4, 896, 1747697698, '1', 'attribute', 98, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '1', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(110, 'w50', 4, 1024, 1747697724, '1', 'attribute', 102, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '1', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(111, 'w50', 4, 1152, 1747697747, '1', 'attribute', 95, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '1', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(112, 'w50', 11, 128, 1747700238, '1', 'attribute', 57, '', '', NULL, '', '', '', '1', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(113, 'w50', 18, 128, 1747703097, '1', 'attribute', 91, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(114, 'clr long', 15, 384, 1748548692, '1', 'attribute', 104, '', '', NULL, '', '', '', '', '', '', '', '', '', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(115, 'w50', 10, 384, 1748548461, '1', 'attribute', 105, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '', '', '', '', '0', 0, 0, 'normal', '', 0, 0, ''),
(116, 'w50', 9, 1152, 1751233354, '1', 'attribute', 106, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '', '', '', '', '0', 0, 0, 'normal', '', 0, 0, ''),
(117, 'w50', 9, 256, 1751232933, '1', 'attribute', 110, '', '', NULL, '1', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(118, 'w50', 9, 512, 1751233324, '1', 'attribute', 107, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(119, 'w50', 9, 768, 1751233324, '1', 'attribute', 108, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(120, 'w50', 9, 640, 1751233324, '1', 'attribute', 109, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(121, 'w50', 9, 384, 1751233324, '1', 'legend', 0, '', '', 'PayPal', '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(122, 'w50', 9, 896, 1751233354, '1', 'legend', 0, '', '', 'Allgemein', '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(123, 'w50', 4, 1280, 1751241046, '1', 'attribute', 111, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(124, 'w50', 4, 1408, 1751419105, '1', 'attribute', 113, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(125, 'w50', 4, 1536, 1751419126, '1', 'attribute', 114, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, ''),
(126, 'w50', 4, 1664, 1751419159, '1', 'attribute', 115, '', '', NULL, '', '', '', '', '', '', '', '', 'tinyMCE', 0, 0, '2', '', '1', '', '', '', '0', 0, 0, 'normal', '0', 0, 0, '');

CREATE TABLE `tl_metamodel_dcasetting_condition` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `settingId` int UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `enabled` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `attr_id` int UNSIGNED NOT NULL DEFAULT '0',
  `value` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

CREATE TABLE `tl_metamodel_dca_combine` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `fe_group` int NOT NULL DEFAULT '0',
  `be_group` int NOT NULL DEFAULT '0',
  `view_id` int UNSIGNED NOT NULL DEFAULT '0',
  `dca_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT IGNORE INTO `tl_metamodel_dca_combine` VALUES
(1, 1, 0, 1746905341, 0, 0, 3, 1),
(2, 2, 0, 1746969513, 0, 0, 10, 2),
(3, 3, 0, 1747602756, 0, 0, 12, 3),
(4, 4, 0, 1747697770, 0, 0, 21, 4),
(6, 14, 0, 1746930641, 0, 0, 4, 8),
(7, 13, 0, 1746930808, 0, 0, 5, 7),
(8, 12, 0, 1746966742, 0, 0, 6, 9),
(9, 11, 0, 1746966974, 0, 0, 7, 10),
(10, 10, 0, 1746968246, 0, 0, 8, 6),
(11, 7, 0, 1747699817, 0, 0, 9, 11),
(13, 17, 0, 1747259918, 0, 0, 17, 14),
(14, 18, 0, 1747374539, 0, 0, 18, 15),
(15, 19, 0, 1747558584, 0, 0, 19, 16),
(16, 21, 0, 1747703133, 0, 0, 22, 18),
(17, 20, 0, 1747721453, 0, 0, 20, 17);

CREATE TABLE `tl_metamodel_dca_sortgroup` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `published` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `isdefault` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ismanualsort` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rendersort` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'asc',
  `rendersortattr` int UNSIGNED NOT NULL DEFAULT '0',
  `rendergrouptype` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'none',
  `rendergroupattr` int UNSIGNED NOT NULL DEFAULT '0',
  `rendergrouplen` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT IGNORE INTO `tl_metamodel_dca_sortgroup` VALUES
(1, 1, 128, 1746904574, '1', 'Name', '1', '', 'asc', 1, 'none', 0, 1),
(2, 8, 128, 1746966398, '1', 'Name', '1', '', 'asc', 47, 'none', 0, 1),
(3, 7, 128, 1746966434, '1', 'Name', '1', '', 'asc', 45, 'none', 0, 1),
(4, 9, 128, 1746966678, '1', 'Name', '1', '', 'asc', 9, 'none', 0, 1),
(5, 6, 128, 1746968110, '1', 'Anrede', '1', '', 'asc', 7, 'none', 0, 1),
(6, 11, 128, 1747699784, '1', 'Mail', '1', '', 'asc', 57, 'none', 28, 1),
(7, 2, 128, 1746969494, '1', 'Name', '1', '', 'asc', 35, 'char', 35, 1),
(9, 10, 128, 1747251393, '1', 'Versand', '1', '', 'asc', 11, 'none', 0, 1),
(10, 14, 128, 1747259898, '1', 'Bestellabschluss', '1', '', 'asc', 58, 'none', 0, 1),
(11, 15, 128, 1747374456, '1', 'Name', '1', '1', 'asc', 68, 'none', 0, 1),
(12, 16, 128, 1747558550, '1', 'Tags Bestellstatus', '1', '', 'asc', 72, 'none', 0, 1),
(13, 17, 128, 1747559081, '1', 'Lieferadresse', '1', '', 'asc', 77, 'none', 0, 1),
(14, 3, 128, 1747602739, '1', 'Steuer', '1', '', 'asc', 3, 'none', 0, 1),
(15, 4, 128, 1747697842, '1', 'Bestellungen', '1', '', 'asc', 94, 'none', 0, 1),
(16, 18, 128, 1747703054, '1', 'Name', '1', '', 'asc', 90, 'none', 0, 1);

CREATE TABLE `tl_metamodel_filter` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT IGNORE INTO `tl_metamodel_filter` VALUES
(1, 1, 1746905431, 'Name'),
(2, 2, 1746994674, 'Name'),
(5, 7, 1747699233, 'Mail');

CREATE TABLE `tl_metamodel_filtersetting` (
  `id` int UNSIGNED NOT NULL,
  `apply_sorting` varchar(24) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `fid` int UNSIGNED NOT NULL DEFAULT '0',
  `type` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `enabled` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `comment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `attr_id` int UNSIGNED NOT NULL DEFAULT '0',
  `all_langs` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `items` text COLLATE utf8mb4_unicode_ci,
  `urlparam` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `predef_param` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `fe_widget` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `customsql` text COLLATE utf8mb4_unicode_ci,
  `allow_empty` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `stop_after_match` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `label` blob,
  `template` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `blankoption` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `onlyused` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `onlypossible` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `skipfilteroptions` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `defaultid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `hide_label` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `label_as_blankoption` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `cssID` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `placeholder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `use_only_in_env` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `ynfield` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `ynmode` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'yes',
  `option_label_param` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `useor` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `show_select_all` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `check_ignorepublished` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `check_allowpreview` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `textsearch` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `delimiter` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `pattern` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT IGNORE INTO `tl_metamodel_filtersetting` VALUES
(1, '', 0, 384, 1747001975, 2, 'text', '1', '', 35, '', NULL, 'name', '', '', 'SELECT id FROM {{table}}\nWHERE 1 = 1', '', '', 0x4e616d65, 'mm_filteritem_default', '1', '1', '1', '', '', '', '', 'a:2:{i:0;s:0:\"\";i:1;s:0:\"\";}', '', '', '1', 'yes', '1', '1', '0', '', '', 'beginswith', '', '%s'),
(4, '', 0, 128, 1747700056, 5, 'text', '1', '', 57, '', NULL, '', '', '', 'SELECT id FROM {{table}}\nWHERE 1 = 1', '', '', NULL, 'mm_filteritem_default', '1', '1', '1', '', '', '', '', 'a:2:{i:0;s:0:\"\";i:1;s:0:\"\";}', '', '', '1', 'yes', '1', '1', '0', '', '', 'all', '', '%s');

CREATE TABLE `tl_metamodel_rendersetting` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `attr_id` int UNSIGNED NOT NULL DEFAULT '0',
  `template` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `additional_class` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `enabled` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `file_sortBy` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `file_showLink` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `file_protectedDownload` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `file_showImage` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `file_imageSize` varchar(128) CHARACTER SET ascii COLLATE ascii_bin NOT NULL DEFAULT '',
  `file_placeholder` blob,
  `timeformat` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT IGNORE INTO `tl_metamodel_rendersetting` VALUES
(1, 3, 0, 1746979899, 1, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(2, 10, 256, 1748466534, 35, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(3, 10, 128, 1748466534, 42, 'mm_attr_file_preview', '', '1', 'name_asc', '', '', '1', 'a:3:{i:2;s:12:\"proportional\";i:0;s:3:\"120\";i:1;s:0:\"\";}', NULL, ''),
(5, 9, 512, 1747698792, 28, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(7, 4, 128, 1746996770, 47, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(8, 5, 128, 1746997044, 45, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(9, 8, 128, 1746997295, 7, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(10, 12, 128, 1746997410, 3, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(11, 13, 256, 1746999292, 35, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(12, 13, 384, 1748488720, 41, 'mm_attr_alias', '', '1', '', '', '', '', '', NULL, ''),
(13, 13, 512, 1746999292, 36, 'mm_attr_numeric', '', '', '', '', '', '', '', NULL, ''),
(14, 13, 640, 1747965275, 42, 'mm_attr_file_preview', '', '1', 'name_asc', '', '', '1', 'a:3:{i:2;s:12:\"proportional\";i:0;s:3:\"300\";i:1;s:0:\"\";}', NULL, ''),
(15, 13, 768, 1747678994, 39, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(16, 13, 896, 1746999292, 40, 'mm_attr_select', '', '1', '', '', '', '', '', NULL, ''),
(17, 13, 128, 1748490574, 44, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(18, 14, 256, 1746999242, 35, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(19, 14, 384, 1746999242, 41, 'mm_attr_alias', '', '1', '', '', '', '', '', NULL, ''),
(20, 14, 640, 1746999273, 36, 'mm_attr_numeric', '', '1', '', '', '', '', '', NULL, ''),
(21, 14, 128, 1748476283, 42, 'mm_attr_file_detail', '', '1', 'name_asc', '1', '', '1', 'a:3:{i:2;s:12:\"proportional\";i:0;s:3:\"600\";i:1;s:0:\"\";}', NULL, ''),
(22, 14, 896, 1746999270, 37, 'mm_attr_longtext', '', '1', '', '', '', '', '', NULL, ''),
(23, 14, 1024, 1747678976, 39, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(24, 14, 1152, 1746999270, 40, 'mm_attr_select', '', '1', '', '', '', '', '', NULL, ''),
(25, 14, 512, 1746999270, 44, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(26, 14, 1280, 1748477352, 49, 'mm_attr_select', '', '', '', '', '', '', '', NULL, ''),
(27, 14, 1408, 1748477350, 50, 'mm_attr_select', '', '', '', '', '', '', '', NULL, ''),
(28, 15, 256, 1747002223, 35, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(29, 15, 384, 1747002223, 41, 'mm_attr_alias', '', '1', '', '', '', '', '', NULL, ''),
(30, 15, 128, 1747958817, 42, 'mm_attr_file_preview', '', '1', 'name_asc', '', '', '1', 'a:3:{i:2;s:12:\"proportional\";i:0;s:3:\"120\";i:1;s:0:\"\";}', NULL, ''),
(32, 16, 256, 1747004038, 26, 'mm_attr_select', '', '1', '', '', '', '', '', NULL, ''),
(33, 16, 384, 1747004055, 27, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(34, 16, 512, 1747004072, 28, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(35, 16, 768, 1747256854, 29, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(36, 16, 896, 1747256854, 30, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(37, 16, 1024, 1747256854, 31, 'mm_attr_numeric', '', '1', '', '', '', '', '', NULL, ''),
(38, 16, 1280, 1747256886, 32, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(39, 16, 1408, 1747256886, 33, 'mm_attr_country', '', '1', '', '', '', '', '', NULL, ''),
(40, 7, 128, 1747251460, 11, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(41, 6, 128, 1747251789, 9, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(43, 16, 640, 1747256854, 57, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(44, 16, 1152, 1747256886, 56, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(45, 17, 128, 1747259632, 58, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(46, 18, 128, 1747374349, 68, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(47, 19, 128, 1747558465, 72, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(48, 20, 512, 1747699016, 77, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(49, 15, 512, 1747667857, 40, 'mm_attr_select', '', '1', '', '', '', '', '', NULL, ''),
(50, 15, 640, 1747678954, 39, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(51, 13, 1024, 1748488723, 70, 'mm_attr_select', '', '1', '', '', '', '', '', NULL, ''),
(52, 21, 128, 1747697183, 97, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(53, 21, 1280, 1747698424, 94, 'mm_attr_timestamp', '', '1', '', '', '', '', '', NULL, 'd.m.Y H:i'),
(54, 21, 384, 1747698424, 96, 'mm_attr_timestamp', '', '1', '', '', '', '', '', NULL, 'd.m.Y H:i'),
(55, 21, 512, 1747698424, 80, 'mm_attr_select', '', '1', '', '', '', '', '', NULL, ''),
(56, 21, 640, 1747701628, 100, 'mm_attr_select', '', '1', '', '', '', '', '', NULL, ''),
(57, 21, 768, 1747701642, 101, 'mm_attr_select', '', '1', '', '', '', '', '', NULL, ''),
(58, 21, 896, 1747698424, 98, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(59, 21, 1024, 1747698424, 102, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(60, 21, 1152, 1747698424, 95, 'mm_attr_checkbox', '', '1', '', '', '', '', '', NULL, ''),
(61, 21, 256, 1747698424, 103, 'mm_attr_select', '', '1', '', '', '', '', '', NULL, ''),
(62, 9, 384, 1747698792, 27, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(63, 9, 128, 1747698792, 57, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(64, 9, 256, 1747698792, 26, 'mm_attr_select', '', '1', '', '', '', '', '', NULL, ''),
(65, 9, 640, 1747698816, 29, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(66, 9, 768, 1747698830, 30, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(67, 9, 896, 1747698843, 31, 'mm_attr_numeric', '', '1', '', '', '', '', '', NULL, ''),
(68, 9, 1024, 1747698868, 56, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(69, 9, 1152, 1747698889, 32, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(70, 9, 1280, 1747698905, 33, 'mm_attr_country', '', '1', '', '', '', '', '', NULL, ''),
(71, 9, 1408, 1747698920, 34, 'mm_attr_checkbox', '', '1', '', '', '', '', '', NULL, ''),
(72, 20, 128, 1747698988, 74, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(73, 20, 256, 1747699000, 75, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(74, 20, 384, 1747699016, 76, 'mm_attr_numeric', '', '1', '', '', '', '', '', NULL, ''),
(75, 20, 640, 1747699046, 78, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(76, 20, 768, 1747699057, 79, 'mm_attr_country', '', '1', '', '', '', '', '', NULL, ''),
(77, 22, 128, 1747702884, 91, 'mm_attr_numeric', '', '1', '', '', '', '', '', NULL, ''),
(78, 22, 256, 1747702899, 90, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, ''),
(79, 22, 384, 1747702917, 92, 'mm_attr_numeric', '', '1', '', '', '', '', '', NULL, ''),
(80, 22, 512, 1747702930, 99, 'mm_attr_select', '', '1', '', '', '', '', '', NULL, ''),
(81, 22, 640, 1747702945, 93, 'mm_attr_text', '', '1', '', '', '', '', '', NULL, '');

CREATE TABLE `tl_metamodel_rendersettings` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `hideEmptyValues` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `hideLabels` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `template` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `format` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `jumpTo` blob,
  `additionalCss` blob,
  `additionalJs` blob
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT IGNORE INTO `tl_metamodel_rendersettings` VALUES
(1, 1, 1746903459, 'Html5', '', '', 'metamodel_prerendered', 'html5', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(3, 1, 1746905325, 'Text', '', '', 'metamodel_prerendered', 'text', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(4, 14, 1746930620, 'Text', '', '', 'metamodel_prerendered', 'text', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(5, 13, 1746930749, 'Text', '', '', 'metamodel_prerendered', 'text', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(6, 12, 1746966723, 'Text', '', '', 'metamodel_prerendered', 'text', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(7, 11, 1746966769, 'Text', '', '', 'metamodel_prerendered', 'text', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(8, 10, 1746968226, 'Text', '', '', 'metamodel_prerendered', 'text', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(9, 7, 1746968269, 'Text', '', '', 'metamodel_prerendered', 'text', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(10, 2, 1748466808, 'Backend Html5', '', '1', 'metamodel_prerendered', 'html5', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(12, 3, 1746997382, 'Text', '', '', 'metamodel_prerendered', 'text', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(13, 2, 1747699154, 'Frontend Liste Html5', '', '1', 'metamodel_prerendered', 'html5', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(14, 2, 1747961115, 'Frontend Detail Html5', '', '1', 'metamodel_prerendered', 'html5', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(15, 2, 1747699173, 'Frontend Liste Warenkorb Html5', '', '1', 'metamodel_prerendered', 'html5', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(16, 7, 1747003986, 'FE Bestellübersicht', '', '', 'metamodel_prerendered', 'html5', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(17, 17, 1747259607, 'Text', '', '', 'metamodel_prerendered', 'text', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(18, 18, 1747374323, 'Text', '', '', 'metamodel_prerendered', 'text', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(19, 19, 1747558440, 'Text', '', '', 'metamodel_prerendered', 'text', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(20, 20, 1747558926, 'Text', '', '', 'metamodel_prerendered', 'text', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(21, 4, 1747697134, 'Text', '', '1', 'metamodel_prerendered', 'text', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d),
(22, 21, 1747702857, 'Text', '', '', 'metamodel_prerendered', 'text', 0x613a313a7b693a303b613a343a7b733a383a226c616e67636f6465223b733a323a227878223b733a343a2274797065223b693a313b733a353a2276616c7565223b733a303a22223b733a363a2266696c746572223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d, 0x613a313a7b693a303b613a323a7b733a343a2266696c65223b733a303a22223b733a393a227075626c6973686564223b733a303a22223b7d7d);

CREATE TABLE `tl_metamodel_searchable_pages` (
  `id` int UNSIGNED NOT NULL,
  `pid` int UNSIGNED NOT NULL DEFAULT '0',
  `tstamp` int UNSIGNED NOT NULL DEFAULT '0',
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `rendersetting` int UNSIGNED NOT NULL DEFAULT '0',
  `filter` int UNSIGNED NOT NULL DEFAULT '0',
  `filterparams` longblob,
  `published` char(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;

INSERT IGNORE INTO `tl_metamodel_searchable_pages` VALUES
(1, 1, 1746905461, 'Name', 3, 1, NULL, '1'),
(2, 2, 1746994917, 'Name', 10, 2, NULL, '1'),
(3, 7, 1747699338, 'Mail', 9, 5, NULL, '1');

CREATE TABLE `tl_metamodel_tag_relation` (
  `id` int UNSIGNED NOT NULL,
  `att_id` int UNSIGNED NOT NULL DEFAULT '0',
  `item_id` int UNSIGNED NOT NULL DEFAULT '0',
  `value_sorting` int UNSIGNED NOT NULL DEFAULT '0',
  `value_id` int UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=DYNAMIC;


ALTER TABLE `tl_metamodel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tablename` (`tableName`);

ALTER TABLE `tl_metamodel_attribute`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pid_colname` (`pid`,`colname`),
  ADD KEY `pid` (`pid`),
  ADD KEY `colname` (`colname`);

ALTER TABLE `tl_metamodel_dca`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

ALTER TABLE `tl_metamodel_dcasetting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

ALTER TABLE `tl_metamodel_dcasetting_condition`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

ALTER TABLE `tl_metamodel_dca_combine`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`),
  ADD KEY `fe_group` (`fe_group`),
  ADD KEY `be_group` (`be_group`);

ALTER TABLE `tl_metamodel_dca_sortgroup`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

ALTER TABLE `tl_metamodel_filter`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

ALTER TABLE `tl_metamodel_filtersetting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

ALTER TABLE `tl_metamodel_rendersetting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

ALTER TABLE `tl_metamodel_rendersettings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

ALTER TABLE `tl_metamodel_searchable_pages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pid` (`pid`);

ALTER TABLE `tl_metamodel_tag_relation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `att_id_item_id_value_id` (`att_id`,`item_id`,`value_id`);


ALTER TABLE `tl_metamodel`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

ALTER TABLE `tl_metamodel_attribute`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

ALTER TABLE `tl_metamodel_dca`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

ALTER TABLE `tl_metamodel_dcasetting`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

ALTER TABLE `tl_metamodel_dcasetting_condition`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `tl_metamodel_dca_combine`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

ALTER TABLE `tl_metamodel_dca_sortgroup`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

ALTER TABLE `tl_metamodel_filter`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

ALTER TABLE `tl_metamodel_filtersetting`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

ALTER TABLE `tl_metamodel_rendersetting`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

ALTER TABLE `tl_metamodel_rendersettings`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

ALTER TABLE `tl_metamodel_searchable_pages`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

ALTER TABLE `tl_metamodel_tag_relation`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;