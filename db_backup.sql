CREATE TABLE IF NOT EXISTS `customers` (
  `customer_id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `dob` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT '',
  `sex` enum('Male','Female', 'Other') NOT NULL,
  `lead_source` int(191) NOT NULL,
  `other_lead_source` varchar(256) CHARACTER SET utf8 COLLATE utf8_bin NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`customer_id`) REFERENCES users(`id`) ON DELETE CASCADE

) ENGINE=InnoDB DEFAULT CHARSET=latin1;