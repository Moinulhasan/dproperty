-- =============================================================
-- Migration: add `order` column to locations
-- File: 2026_05_22_150000_add_order_to_locations_table.php
-- Run on the LIVE database after taking a backup.
-- MySQL / MariaDB
-- =============================================================

ALTER TABLE `locations`
    ADD COLUMN `order` INT UNSIGNED NOT NULL DEFAULT 0 AFTER `status`;

ALTER TABLE `locations`
    ADD INDEX `locations_order_index` (`order`);

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_05_22_150000_add_order_to_locations_table', COALESCE(MAX(`batch`), 0) + 1
FROM `migrations`;

-- Rollback:
-- ALTER TABLE `locations` DROP INDEX `locations_order_index`;
-- ALTER TABLE `locations` DROP COLUMN `order`;
-- DELETE FROM `migrations` WHERE `migration` = '2026_05_22_150000_add_order_to_locations_table';
