SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(255) DEFAULT NULL,
  username VARCHAR(50) NOT NULL UNIQUE,
  role ENUM('global_admin', 'admin', 'guest') DEFAULT 'guest',
  status ENUM('pending', 'active', 'inactive', 'suspended') DEFAULT 'pending',
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  prof_pic VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


INSERT INTO `users` (
  `id`, 
  `full_name`, 
  `username`, 
  `role`, 
  `status`, 
  `email`, 
  `password`, 
  `created_at`, 
  `updated_at`
) VALUES
(1, 'E37 Tech', 'supreme_admin', 'global_admin', 'active', 'info@ezktech.com', '$2y$10$elg5kNNryJh/YZxTjcxIy.m5HnLyEvtyAb1wv/g8MF5rOUVHHGFeC', NOW(), NOW()),
(2, 'Elly Ambet', 'eli', 'admin', 'active', 'elly@e37tech.com', '$2y$10$elg5kNNryJh/YZxTjcxIy.m5HnLyEvtyAb1wv/g8MF5rOUVHHGFeC', NOW(), NOW()),
(3, 'John Doe', 'doe', 'guest', 'active', 'doe@e37tech.com', '$2y$10$elg5kNNryJh/YZxTjcxIy.m5HnLyEvtyAb1wv/g8MF5rOUVHHGFeC', NOW(), NOW());

COMMIT;
