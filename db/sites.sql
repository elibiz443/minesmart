SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE sites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL UNIQUE,
  coords JSON DEFAULT NULL,
  image_link VARCHAR(255) DEFAULT NULL,
  user_id INT NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO sites (name, coords, image_link, user_id, created_at, updated_at) VALUES
('KATANI', '[37.0327, -1.3675]', '/assets/images/sites/1.webp', 1, NOW(), NOW()),
('MLOLONGO', '[36.9547, -1.4383]', '/assets/images/sites/2.webp', 1, NOW(), NOW()),
('NGURUNGA', '[36.7525, -1.2088]', '/assets/images/sites/3.webp', 1, NOW(), NOW()),
('NAKURU', '[36.0673, -0.2747]', '/assets/images/sites/4.webp', 1, NOW(), NOW()),
('NYAHURURU', '[36.3638, 0.0324]', '/assets/images/sites/5.webp', 1, NOW(), NOW()),
('TURBO', '[35.2533, 0.7536]', '/assets/images/sites/6.webp', 1, NOW(), NOW()),
('ELDORET', '[35.2708, 0.5167]', '/assets/images/sites/7.webp', 1, NOW(), NOW()),
('KOKOTONI', '[39.5933, -3.9333]', '/assets/images/sites/8.webp', 1, NOW(), NOW()),
('GANDINI', '[39.9500, -3.3500]', '/assets/images/sites/9.webp', 1, NOW(), NOW()),
('JARIBUNI', '[39.7000, -3.6000]', '/assets/images/sites/10.webp', 1, NOW(), NOW()),
('NDOVU', '[36.5000, -2.0000]', '/assets/images/sites/11.webp', 1, NOW(), NOW()),
('KYUSO', '[37.9500, -1.7500]', '/assets/images/sites/12.webp', 1, NOW(), NOW()),
('AWASI', '[35.0333, -0.1333]', '/assets/images/sites/13.webp', 1, NOW(), NOW()),
('BISIL', '[36.9333, -2.0333]', '/assets/images/sites/14.webp', 1, NOW(), NOW());

COMMIT;
