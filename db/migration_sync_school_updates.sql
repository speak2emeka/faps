-- Sync existing CMS databases with the Primary/Secondary public site updates.
-- Run this after the original db/database.sql has already been imported.

ALTER TABLE `news` ADD COLUMN `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all' AFTER `id`;
ALTER TABLE `events` ADD COLUMN `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all' AFTER `id`;
ALTER TABLE `gallery` ADD COLUMN `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all' AFTER `id`;
ALTER TABLE `sliders` ADD COLUMN `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all' AFTER `id`;
ALTER TABLE `stem_programs` ADD COLUMN `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all' AFTER `id`;
ALTER TABLE `downloads` ADD COLUMN `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all' AFTER `id`;
ALTER TABLE `newsletter_posts` ADD COLUMN `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all' AFTER `id`;
ALTER TABLE `testimonials` ADD COLUMN `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all' AFTER `id`;
ALTER TABLE `users` ADD COLUMN `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all' AFTER `role`;

INSERT INTO `users` (`username`, `email`, `full_name`, `password`, `role`, `school_scope`) VALUES
('primary_admin', 'primary-admin@fapsroyalprestige.edu.ng', 'FAPS Primary Administrator', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'editor', 'primary'),
('secondary_admin', 'secondary-admin@fapsroyalprestige.edu.ng', 'Royal Prestige Secondary Administrator', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'editor', 'secondary')
ON DUPLICATE KEY UPDATE `school_scope` = VALUES(`school_scope`), `full_name` = VALUES(`full_name`);

CREATE TABLE IF NOT EXISTS `facilities` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `school_scope` ENUM('primary', 'secondary') NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `facility_type` ENUM('classroom', 'playground', 'library', 'ict', 'science-lab', 'robotics-lab', 'security', 'transportation', 'sports', 'leadership', 'other') DEFAULT 'other',
  `image` VARCHAR(255),
  `sort_order` INT DEFAULT 0,
  `is_published` BOOLEAN DEFAULT FALSE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `school_scope_idx` (`school_scope`),
  KEY `facility_type_idx` (`facility_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `school_activities` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `school_scope` ENUM('primary', 'secondary') NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `activity_type` ENUM('academics', 'arts', 'sports', 'stem', 'robotics', 'leadership', 'clubs', 'events', 'care', 'other') DEFAULT 'other',
  `image` VARCHAR(255),
  `sort_order` INT DEFAULT 0,
  `is_published` BOOLEAN DEFAULT FALSE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `school_scope_idx` (`school_scope`),
  KEY `activity_type_idx` (`activity_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
