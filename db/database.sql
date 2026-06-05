-- FAPS and Royal Prestige School CMS Database Schema
-- For MySQL 5.7+

CREATE DATABASE IF NOT EXISTS `faps_cms` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `faps_cms`;

-- Users Table (Admin)
CREATE TABLE `users` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `username` VARCHAR(50) UNIQUE NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `full_name` VARCHAR(100),
  `role` ENUM('admin', 'editor', 'viewer') DEFAULT 'editor',
  `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all',
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `last_login` TIMESTAMP NULL,
  `is_active` BOOLEAN DEFAULT TRUE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- News & Announcements Table
CREATE TABLE `news` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all',
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) UNIQUE NOT NULL,
  `content` LONGTEXT NOT NULL,
  `excerpt` TEXT,
  `category` ENUM('announcement', 'news', 'event', 'stem', 'robotics') DEFAULT 'news',
  `featured_image` VARCHAR(255),
  `author_id` INT,
  `is_published` BOOLEAN DEFAULT FALSE,
  `published_date` DATETIME,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`author_id`) REFERENCES `users`(`id`) ON DELETE SET NULL,
  KEY `published_idx` (`is_published`),
  KEY `category_idx` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Events Table
CREATE TABLE `events` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all',
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) UNIQUE NOT NULL,
  `description` LONGTEXT,
  `event_date` DATETIME NOT NULL,
  `location` VARCHAR(255),
  `category` ENUM('academic', 'sports', 'cultural', 'stem', 'robotics', 'other') DEFAULT 'academic',
  `image` VARCHAR(255),
  `is_published` BOOLEAN DEFAULT FALSE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `event_date_idx` (`event_date`),
  KEY `category_idx` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Gallery (Photos & Videos)
CREATE TABLE `gallery` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all',
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `media_file` VARCHAR(255) NOT NULL,
  `media_type` ENUM('image', 'video') NOT NULL,
  `category` ENUM('school-life', 'academics', 'stem', 'robotics', 'sports', 'events', 'facilities') DEFAULT 'school-life',
  `thumbnail` VARCHAR(255),
  `is_published` BOOLEAN DEFAULT FALSE,
  `upload_date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `category_idx` (`category`),
  KEY `type_idx` (`media_type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- School Facilities
CREATE TABLE `facilities` (
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

-- School Activities
CREATE TABLE `school_activities` (
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

-- Homepage Sliders/Banners
CREATE TABLE `sliders` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all',
  `title` VARCHAR(255) NOT NULL,
  `subtitle` TEXT,
  `image` VARCHAR(255) NOT NULL,
  `button_text` VARCHAR(100),
  `button_link` VARCHAR(255),
  `sort_order` INT DEFAULT 0,
  `is_active` BOOLEAN DEFAULT TRUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `sort_idx` (`sort_order`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- STEM & Robotics Programs
CREATE TABLE `stem_programs` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all',
  `title` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) UNIQUE NOT NULL,
  `description` LONGTEXT,
  `program_type` ENUM('coding', 'robotics', 'engineering', 'science-lab', 'competitions') DEFAULT 'coding',
  `target_level` ENUM('pre-nursery', 'nursery', 'primary', 'jss', 'sss', 'all') DEFAULT 'all',
  `featured_image` VARCHAR(255),
  `content` LONGTEXT,
  `is_published` BOOLEAN DEFAULT FALSE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `type_idx` (`program_type`),
  KEY `level_idx` (`target_level`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Downloadable Documents/Links
CREATE TABLE `downloads` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all',
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `file_path` VARCHAR(255) NOT NULL,
  `category` ENUM('admission-forms', 'policies', 'curriculum', 'schedules', 'resources', 'other') DEFAULT 'resources',
  `file_type` VARCHAR(50),
  `download_count` INT DEFAULT 0,
  `is_available` BOOLEAN DEFAULT TRUE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `category_idx` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Newsletter Subscribers
CREATE TABLE `newsletter_subscribers` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `email` VARCHAR(100) UNIQUE NOT NULL,
  `name` VARCHAR(100),
  `subscribed_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `is_active` BOOLEAN DEFAULT TRUE,
  KEY `email_idx` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Newsletter Updates / Posts
CREATE TABLE `newsletter_posts` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all',
  `title` VARCHAR(255) NOT NULL,
  `content` LONGTEXT NOT NULL,
  `category` ENUM('newsletter', 'announcement', 'stem', 'robotics', 'admissions') DEFAULT 'newsletter',
  `featured_image` VARCHAR(255),
  `is_published` BOOLEAN DEFAULT FALSE,
  `published_date` DATETIME,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `category_idx` (`category`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Testimonials
CREATE TABLE `testimonials` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `school_scope` ENUM('all', 'primary', 'secondary') DEFAULT 'all',
  `name` VARCHAR(100) NOT NULL,
  `position` VARCHAR(100),
  `content` TEXT NOT NULL,
  `image` VARCHAR(255),
  `rating` INT DEFAULT 5,
  `is_published` BOOLEAN DEFAULT FALSE,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contact Form Submissions
CREATE TABLE `contact_submissions` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `name` VARCHAR(100) NOT NULL,
  `email` VARCHAR(100) NOT NULL,
  `phone` VARCHAR(20),
  `subject` VARCHAR(255) NOT NULL,
  `message` LONGTEXT NOT NULL,
  `is_read` BOOLEAN DEFAULT FALSE,
  `response` LONGTEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  KEY `email_idx` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin users. Demo password for all: admin123
INSERT INTO `users` (`username`, `email`, `full_name`, `password`, `role`, `school_scope`) VALUES 
('admin', 'admin@fapsroyalprestige.edu.ng', 'Super Administrator', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'all'),
('primary_admin', 'primary-admin@fapsroyalprestige.edu.ng', 'FAPS Primary Administrator', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'editor', 'primary'),
('secondary_admin', 'secondary-admin@fapsroyalprestige.edu.ng', 'Royal Prestige Secondary Administrator', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'editor', 'secondary');

-- Insert sample sliders
INSERT INTO `sliders` (`title`, `subtitle`, `image`, `button_text`, `button_link`, `sort_order`, `is_active`) VALUES 
('Excellence in Education', 'From Early Childhood to Secondary', 'slider-1.jpg', 'Learn More', '/about', 0, TRUE),
('STEM & Innovation', 'Building Tomorrow\'s Leaders', 'slider-2.jpg', 'Explore STEM', '/academics#stem', 1, TRUE),
('Join Our Community', 'Quality Education for All', 'slider-3.jpg', 'Admissions', '/admissions', 2, TRUE);

-- Insert sample STEM programs
INSERT INTO `stem_programs` (`title`, `slug`, `description`, `program_type`, `target_level`, `is_published`) VALUES 
('Coding for Beginners', 'coding-for-beginners', 'Introduction to programming basics using Scratch and Python', 'coding', 'primary', TRUE),
('Robotics Club', 'robotics-club', 'Build and program robots using LEGO Mindstorms and Arduino', 'robotics', 'jss', TRUE),
('Science Lab Experiments', 'science-lab-experiments', 'Hands-on scientific experiments in our modern laboratory', 'science-lab', 'all', TRUE);
