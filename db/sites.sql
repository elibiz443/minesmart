DROP TABLE IF EXISTS sites;

CREATE TABLE sites (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL UNIQUE,
  site_code VARCHAR(50) NOT NULL UNIQUE,
  site_type ENUM('open_pit','underground','quarry','rehabilitation','processing') NOT NULL,
  country VARCHAR(100) NOT NULL DEFAULT 'Kenya',
  county VARCHAR(100) NOT NULL,
  coords JSON NOT NULL,
  elevation_m INT DEFAULT NULL,
  area_hectares DECIMAL(8,2) DEFAULT NULL,
  operational_status ENUM('active','inactive','rehabilitation','closed') NOT NULL DEFAULT 'active',
  risk_profile JSON DEFAULT NULL,
  image_link VARCHAR(255) DEFAULT NULL,
  user_id INT NOT NULL DEFAULT 1,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  INDEX(site_type),
  INDEX(county),
  INDEX(operational_status)
);

INSERT INTO sites (name, site_code, site_type, county, coords, elevation_m, area_hectares, operational_status, risk_profile, image_link) VALUES
('Kwale Titanium Mine','KE-KWL-01','open_pit','Kwale','{\"lng\":39.4532,\"lat\":-4.1736}',120,850.50,'active','{\"primary\":\"slope_instability\",\"secondary\":\"flooding\"}','/assets/images/sites/5.webp'),
('Taita Taveta Quarry','KE-TTV-02','quarry','Taita Taveta','{\"lng\":38.3647,\"lat\":-3.3946}',980,430.20,'active','{\"primary\":\"erosion\",\"secondary\":\"landslide\"}','/assets/images/sites/4.webp'),
('Athi River Limestone','KE-MCH-03','quarry','Machakos','{\"lng\":37.0158,\"lat\":-1.4563}',1520,610.75,'active','{\"primary\":\"dust\",\"secondary\":\"structural\"}','/assets/images/sites/3.webp'),
('Kajiado Marble Works','KE-KJD-04','open_pit','Kajiado','{\"lng\":36.7819,\"lat\":-2.0987}',1700,390.10,'active','{\"primary\":\"slope_instability\"}','/assets/images/sites/2.webp'),
('Narok Gold Prospect','KE-NRK-05','open_pit','Narok','{\"lng\":35.9306,\"lat\":-1.0791}',1850,720.00,'active','{\"primary\":\"landslide\",\"secondary\":\"flooding\"}','/assets/images/sites/1.webp'),
('Migori Gold Mine','KE-MGR-06','underground','Migori','{\"lng\":34.4668,\"lat\":-1.0634}',1380,510.60,'active','{\"primary\":\"subsidence\"}','/assets/images/sites/14.webp'),
('Kakamega Goldfields','KE-KKG-07','underground','Kakamega','{\"lng\":34.7519,\"lat\":0.2827}',1540,460.30,'active','{\"primary\":\"structural_failure\"}','/assets/images/sites/13.webp'),
('Turkana Limestone','KE-TRK-08','quarry','Turkana','{\"lng\":35.3210,\"lat\":2.9745}',620,910.40,'active','{\"primary\":\"erosion\",\"secondary\":\"heat_stress\"}','/assets/images/sites/12.webp'),
('West Pokot Quarry','KE-WPK-09','quarry','West Pokot','{\"lng\":35.1112,\"lat\":1.2386}',1450,375.90,'active','{\"primary\":\"landslide\"}','/assets/images/sites/11.webp'),
('Baringo Fluorspar','KE-BRG-10','open_pit','Baringo','{\"lng\":35.9784,\"lat\":0.4721}',1600,540.80,'active','{\"primary\":\"slope_instability\"}','/assets/images/sites/10.webp'),
('Kitui Coal Block','KE-KTI-11','open_pit','Kitui','{\"lng\":38.0186,\"lat\":-1.3662}',1020,1120.00,'active','{\"primary\":\"rehabilitation\"}','/assets/images/sites/9.webp'),
('Embu Granite Quarry','KE-EMB-12','quarry','Embu','{\"lng\":37.4574,\"lat\":-0.5313}',1480,280.45,'active','{\"primary\":\"erosion\"}','/assets/images/sites/8.webp'),
('Meru Aggregates','KE-MRU-13','quarry','Meru','{\"lng\":37.6558,\"lat\":0.0471}',1510,310.20,'active','{\"primary\":\"slope_instability\"}','/assets/images/sites/7.webp'),
('Laikipia Sand Mine','KE-LKP-14','open_pit','Laikipia','{\"lng\":36.8272,\"lat\":0.2550}',1890,640.70,'active','{\"primary\":\"flooding\"}','/assets/images/sites/6.webp'),
('Nyeri Stone Works','KE-NYR-15','quarry','Nyeri','{\"lng\":36.9553,\"lat\":-0.4196}',1750,295.00,'active','{\"primary\":\"erosion\"}','/assets/images/sites/nyeri.webp'),
('Kilifi Silica Sands','KE-KLF-16','open_pit','Kilifi','{\"lng\":39.8564,\"lat\":-3.6330}',45,880.90,'active','{\"primary\":\"flooding\",\"secondary\":\"coastal_erosion\"}','/assets/images/sites/5.webp'),
('Lamu Coral Quarry','KE-LMU-17','quarry','Lamu','{\"lng\":40.9020,\"lat\":-2.2717}',12,410.30,'active','{\"primary\":\"coastal_instability\"}','/assets/images/sites/4.webp'),
('Isiolo Basalt Quarry','KE-ISL-18','quarry','Isiolo','{\"lng\":37.5833,\"lat\":0.3546}',1080,365.60,'active','{\"primary\":\"heat_stress\"}','/assets/images/sites/3.webp'),
('Marsabit Volcanic Rock','KE-MRS-19','quarry','Marsabit','{\"lng\":37.9945,\"lat\":2.3344}',1340,455.25,'active','{\"primary\":\"erosion\"}','/assets/images/sites/2.webp'),
('Garissa Gypsum Fields','KE-GRS-20','open_pit','Garissa','{\"lng\":39.6456,\"lat\":-0.4532}',140,970.80,'active','{\"primary\":\"flooding\",\"secondary\":\"soil_saturation\"}','/assets/images/sites/1.webp');


