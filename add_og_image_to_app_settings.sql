-- =============================================================
-- Migration: add `og_image` column to app_settings
-- File: 2026_05_22_140000_add_og_image_to_app_settings_table.php
-- Run on the LIVE database after taking a backup.
-- MySQL / MariaDB
-- =============================================================

ALTER TABLE `app_settings`
    ADD COLUMN `og_image` VARCHAR(255) NULL AFTER `favicon`;

INSERT INTO `migrations` (`migration`, `batch`)
SELECT '2026_05_22_140000_add_og_image_to_app_settings_table', COALESCE(MAX(`batch`), 0) + 1
FROM `migrations`;

-- Rollback:
-- ALTER TABLE `app_settings` DROP COLUMN `og_image`;
-- DELETE FROM `migrations` WHERE `migration` = '2026_05_22_140000_add_og_image_to_app_settings_table';
