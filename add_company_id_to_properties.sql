-- =============================================================
-- Migration: add company_id to properties
-- File: 2026_05_22_120000_add_company_id_to_properties_table.php
-- Run this on the LIVE database after taking a backup.
-- MySQL / MariaDB
-- =============================================================

-- 1) Add the column (nullable so existing rows are valid).
ALTER TABLE `properties`
    ADD COLUMN `company_id` BIGINT UNSIGNED NULL AFTER `created_by`;

-- 2) Add the foreign key constraint to companies.
ALTER TABLE `properties`
    ADD CONSTRAINT `properties_company_id_foreign`
    FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`)
    ON DELETE SET NULL;

-- 3) Backfill existing rows from the creator's company so historical
--    data stays consistent with the new direct relation.
UPDATE `properties` p
INNER JOIN `users` u ON u.`id` = p.`created_by`
SET p.`company_id` = u.`company_id`
WHERE p.`company_id` IS NULL
  AND u.`company_id` IS NOT NULL;

-- 4) Register the migration as already run so `php artisan migrate`
--    on production does NOT try to apply it again.
--    Adjust the `batch` value if you prefer a different batch number.
INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_05_22_120000_add_company_id_to_properties_table', COALESCE(MAX(`batch`), 0) + 1
FROM `migrations`;

-- =============================================================
-- Rollback (only if you need to revert):
-- ALTER TABLE `properties` DROP FOREIGN KEY `properties_company_id_foreign`;
-- ALTER TABLE `properties` DROP COLUMN `company_id`;
-- DELETE FROM `migrations` WHERE `migration` = '2026_05_22_120000_add_company_id_to_properties_table';
-- =============================================================
