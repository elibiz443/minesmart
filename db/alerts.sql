SET time_zone = "+00:00";

CREATE TABLE alerts (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  mail_from VARCHAR(100) NOT NULL,
  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,
  is_read BOOLEAN NOT NULL DEFAULT FALSE,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

INSERT INTO `alerts` (`user_id`, `mail_from`, `title`, `content`, `is_read`, `created_at`) VALUES
(1, 'system@minesmart.co.ke', 'Non-Compliance Alert: Migori Gold Fields', 'Satellite analysis indicates active excavation outside of the permitted bond area at Migori Gold Fields. Immediate inspection required.', 0, NOW()),
(1, 'compliance@minesmart.co.ke', 'Evidence Pack Generated: Kwale Titanium', 'An audit-grade evidence pack for the period of Dec 2025 - Jan 2026 has been generated and is ready for download.', 0, NOW()),
(1, 'alerts@minesmart.co.ke', 'High Risk Detected: Marsabit Fluorite', 'Unrehabilitated land at the Marsabit site has exceeded 50 hectares. Risk score updated to 82 (Critical).', 0, NOW()),
(1, 'system@minesmart.co.ke', 'Rainfall Warning: Kakamega Reserve', 'Predictive AI forecasts heavy rainfall (>100mm) over Kakamega Gold Reserve. Soil saturation levels indicate high mudslide risk.', 0, NOW()),
(1, 'billing@minesmart.co.ke', 'Subscription Renewal: MineSmart Sentinel', 'Your Global Admin subscription for JavaNco is expiring in 5 days. Please update your payment details to maintain monitoring.', 0, NOW()),
(1, 'security@minesmart.co.ke', 'New Login Detected', 'A new login to the supreme_admin account was detected from a new IP address in Nairobi at 08:45 AM.', 1, NOW()),
(1, 'support@minesmart.co.ke', 'Site Inspection Assigned', 'You have been assigned as the guest inspector for the Turkana Mineral Sands site. Please complete the field survey by Friday.', 0, NOW()),
(1, 'system@minesmart.co.ke', 'Baseline Update: Turkana Site', 'New Copernicus Sentinel-2 data has been ingested. The baseline vegetation index for Turkana Mineral Sands has been updated.', 1, NOW()),
(1, 'compliance@minesmart.co.ke', 'Bond Risk Alert: Kwale Site', 'Current rehabilitation progress is 15% behind schedule. Financial bond recovery is at risk if milestones are not met by Q1.', 0, NOW()),
(1, 'system@minesmart.co.ke', 'System Maintenance Notice', 'MineSmart Sentinel will undergo scheduled maintenance on Sunday, Jan 11th, between 02:00 and 04:00 UTC.', 0, NOW());
