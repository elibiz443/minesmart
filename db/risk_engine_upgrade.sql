CREATE TABLE risk_types (
  id INT AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(64) NOT NULL UNIQUE,
  name VARCHAR(128) NOT NULL,
  layer ENUM('satellite','edge','fusion') NOT NULL,
  unit VARCHAR(32) DEFAULT NULL,
  description TEXT DEFAULT NULL,
  severity_weight DECIMAL(6,3) NOT NULL DEFAULT 1.000,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE site_runs (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  site_id INT NOT NULL,
  run_type ENUM('scheduled','event_based','manual') NOT NULL DEFAULT 'scheduled',
  triggered_by VARCHAR(64) DEFAULT NULL,
  trigger_reason VARCHAR(255) DEFAULT NULL,
  run_status ENUM('queued','running','completed','failed') NOT NULL DEFAULT 'queued',
  started_at DATETIME DEFAULT NULL,
  completed_at DATETIME DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (site_id) REFERENCES sites(id) ON DELETE CASCADE,
  INDEX idx_site_runs_site_time (site_id, created_at),
  INDEX idx_site_runs_status (run_status)
);

CREATE TABLE satellite_observations (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  site_id INT NOT NULL,
  run_id BIGINT DEFAULT NULL,
  observed_at DATETIME NOT NULL,
  product_source VARCHAR(64) DEFAULT 'Copernicus',
  ndvi DECIMAL(10,6) DEFAULT NULL,
  evi DECIMAL(10,6) DEFAULT NULL,
  ndvi_drop_30d_pct DECIMAL(8,3) DEFAULT NULL,
  evi_drop_30d_pct DECIMAL(8,3) DEFAULT NULL,
  insar_deformation_mm_mo DECIMAL(10,3) DEFAULT NULL,
  rainfall_anomaly_pct DECIMAL(10,3) DEFAULT NULL,
  soil_moisture_proxy_trend DECIMAL(10,4) DEFAULT NULL,
  geojson LONGTEXT DEFAULT NULL,
  raw_payload LONGTEXT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (site_id) REFERENCES sites(id) ON DELETE CASCADE,
  FOREIGN KEY (run_id) REFERENCES site_runs(id) ON DELETE SET NULL,
  INDEX idx_sat_obs_site_time (site_id, observed_at)
);

CREATE TABLE edge_observations (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  site_id INT NOT NULL,
  run_id BIGINT DEFAULT NULL,
  observed_at DATETIME NOT NULL,
  device_id VARCHAR(64) DEFAULT NULL,
  image_url VARCHAR(512) DEFAULT NULL,
  veg_cover_pct DECIMAL(8,3) DEFAULT NULL,
  erosion_area_pct DECIMAL(8,3) DEFAULT NULL,
  crack_score DECIMAL(10,3) DEFAULT NULL,
  wetness_pct DECIMAL(8,3) DEFAULT NULL,
  humidity_pct DECIMAL(8,3) DEFAULT NULL,
  ai_payload LONGTEXT DEFAULT NULL,
  sensor_payload LONGTEXT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (site_id) REFERENCES sites(id) ON DELETE CASCADE,
  FOREIGN KEY (run_id) REFERENCES site_runs(id) ON DELETE SET NULL,
  INDEX idx_edge_obs_site_time (site_id, observed_at)
);

CREATE TABLE risk_events (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  site_id INT NOT NULL,
  run_id BIGINT DEFAULT NULL,
  started_at DATETIME NOT NULL,
  ended_at DATETIME DEFAULT NULL,
  status ENUM('open','acknowledged','resolved') NOT NULL DEFAULT 'open',
  level ENUM('info','warning','critical') NOT NULL DEFAULT 'info',
  system_decision ENUM('Normal State','Monitor/Re-scan','Confirmed Event','Local Anomaly') NOT NULL DEFAULT 'Normal State',
  final_risk_score DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  satellite_risk_score DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  edge_risk_score DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  confidence_score DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  summary VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (site_id) REFERENCES sites(id) ON DELETE CASCADE,
  FOREIGN KEY (run_id) REFERENCES site_runs(id) ON DELETE SET NULL,
  INDEX idx_risk_events_site_status (site_id, status),
  INDEX idx_risk_events_site_time (site_id, started_at)
);

CREATE TABLE risk_event_factors (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  event_id BIGINT NOT NULL,
  risk_type_id INT NOT NULL,
  layer ENUM('satellite','edge','fusion') NOT NULL,
  raw_value DECIMAL(14,6) DEFAULT NULL,
  normalized_score DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  risk_level ENUM('low','medium','high') NOT NULL DEFAULT 'low',
  threshold_low DECIMAL(14,6) DEFAULT NULL,
  threshold_medium DECIMAL(14,6) DEFAULT NULL,
  threshold_high DECIMAL(14,6) DEFAULT NULL,
  evidence_url VARCHAR(512) DEFAULT NULL,
  note VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (event_id) REFERENCES risk_events(id) ON DELETE CASCADE,
  FOREIGN KEY (risk_type_id) REFERENCES risk_types(id) ON DELETE RESTRICT,
  INDEX idx_ref_event (event_id),
  INDEX idx_ref_event_layer (event_id, layer)
);

CREATE TABLE site_risk_snapshots (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  site_id INT NOT NULL,
  event_id BIGINT DEFAULT NULL,
  snapshot_at DATETIME NOT NULL,
  satellite_risk_score DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  edge_risk_score DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  final_risk_score DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  confidence_score DECIMAL(6,2) NOT NULL DEFAULT 0.00,
  system_decision ENUM('Normal State','Monitor/Re-scan','Confirmed Event','Local Anomaly') NOT NULL DEFAULT 'Normal State',
  last_sync TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (site_id) REFERENCES sites(id) ON DELETE CASCADE,
  FOREIGN KEY (event_id) REFERENCES risk_events(id) ON DELETE SET NULL,
  INDEX idx_snap_site_time (site_id, snapshot_at)
);

CREATE TABLE alerts (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,

  user_id INT NOT NULL,
  site_id INT DEFAULT NULL,
  event_id BIGINT DEFAULT NULL,

  mail_from VARCHAR(100) NOT NULL,

  alert_level ENUM('info','warning','critical') NOT NULL DEFAULT 'info',
  channel ENUM('web','email','sms','api') NOT NULL DEFAULT 'web',

  title VARCHAR(255) NOT NULL,
  content TEXT NOT NULL,

  is_read TINYINT(1) NOT NULL DEFAULT 0,

  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
  FOREIGN KEY (site_id) REFERENCES sites(id) ON DELETE SET NULL,
  FOREIGN KEY (event_id) REFERENCES risk_events(id) ON DELETE SET NULL,

  INDEX idx_alert_user_read_time (user_id, is_read, created_at),
  INDEX idx_alert_site_time (site_id, created_at),
  INDEX idx_alert_level (alert_level)
);

CREATE TABLE evidence_packs (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  site_id INT NOT NULL,
  event_id BIGINT DEFAULT NULL,
  status ENUM('queued','building','ready','failed') NOT NULL DEFAULT 'queued',
  pdf_url VARCHAR(512) DEFAULT NULL,
  geojson_url VARCHAR(512) DEFAULT NULL,
  csv_url VARCHAR(512) DEFAULT NULL,
  images_zip_url VARCHAR(512) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (site_id) REFERENCES sites(id) ON DELETE CASCADE,
  FOREIGN KEY (event_id) REFERENCES risk_events(id) ON DELETE SET NULL,
  INDEX idx_evidence_site_time (site_id, created_at)
);

CREATE OR REPLACE VIEW v_site_latest_snapshot AS
SELECT
  s.site_id,
  s.id AS snapshot_id,
  s.snapshot_at,
  s.satellite_risk_score,
  s.edge_risk_score,
  s.final_risk_score,
  s.confidence_score,
  s.system_decision,
  s.event_id
FROM site_risk_snapshots s
JOIN (
  SELECT site_id, MAX(snapshot_at) AS mx
  FROM site_risk_snapshots
  GROUP BY site_id
) t ON t.site_id = s.site_id AND t.mx = s.snapshot_at;

INSERT INTO risk_types
(code, name, layer, unit, description, severity_weight)
VALUES
('NDVI_DROP_30D','NDVI Drop (30 days)','satellite','%','Vegetation decline indicator (rehabilitation risk).',1.100),
('EVI_DROP_30D','EVI Drop (30 days)','satellite','%','Alternate vegetation decline indicator.',0.900),
('INSAR_DEFORMATION_MM_MO','InSAR Deformation','satellite','mm/month','Ground deformation / slope instability.',1.250),
('RAINFALL_ANOMALY_PCT','Rainfall Anomaly','satellite','%','Rainfall departure from baseline.',1.200),
('SOIL_MOISTURE_PROXY_TREND','Soil Moisture Proxy Trend','satellite','index','Soil saturation trend.',1.150),
('EDGE_VEG_COVER_PCT','Edge Vegetation Cover','edge','%','Local vegetation cover.',0.950),
('EDGE_EROSION_AREA_PCT','Edge Erosion Area','edge','%','Detected erosion/exposed soil.',1.200),
('EDGE_CRACK_SCORE','Edge Crack Score','edge','score','Crack and erosion severity.',1.250),
('EDGE_WETNESS_PCT','Edge Wetness','edge','%','Surface wetness pooling.',1.100),
('EDGE_HUMIDITY_PCT','Edge Humidity','edge','%','Local humidity context.',0.800)
ON DUPLICATE KEY UPDATE
name = VALUES(name),
layer = VALUES(layer),
unit = VALUES(unit),
description = VALUES(description),
severity_weight = VALUES(severity_weight);

INSERT INTO site_runs
(site_id, run_type, triggered_by, trigger_reason, run_status, started_at, completed_at)
SELECT v.site_id, v.run_type, v.triggered_by, v.trigger_reason, v.run_status, v.started_at, v.completed_at
FROM (
  SELECT 1 AS site_id,'scheduled' AS run_type,'system' AS triggered_by,'48h satellite ingestion' AS trigger_reason,'completed' AS run_status,NOW()-INTERVAL 2 DAY AS started_at,NOW()-INTERVAL 2 DAY + INTERVAL 6 MINUTE AS completed_at UNION ALL
  SELECT 2,'event_based','satellite','NDVI anomaly','completed',NOW()-INTERVAL 1 DAY,NOW()-INTERVAL 1 DAY + INTERVAL 8 MINUTE UNION ALL
  SELECT 3,'event_based','edge','crack detection','completed',NOW()-INTERVAL 10 HOUR,NOW()-INTERVAL 9 HOUR UNION ALL
  SELECT 4,'scheduled','system','routine scan','completed',NOW()-INTERVAL 3 DAY,NOW()-INTERVAL 3 DAY + INTERVAL 5 MINUTE UNION ALL
  SELECT 5,'manual','admin','compliance inspection','completed',NOW()-INTERVAL 5 DAY,NOW()-INTERVAL 5 DAY + INTERVAL 12 MINUTE
) v
LEFT JOIN site_runs r
  ON r.site_id = v.site_id
  AND r.run_type = v.run_type
  AND r.started_at = v.started_at
WHERE r.id IS NULL;

INSERT INTO satellite_observations
(site_id, run_id, observed_at, ndvi, evi, ndvi_drop_30d_pct, evi_drop_30d_pct, insar_deformation_mm_mo, rainfall_anomaly_pct, soil_moisture_proxy_trend)
SELECT v.site_id, r.id, v.observed_at, v.ndvi, v.evi, v.ndvi_drop_30d_pct, v.evi_drop_30d_pct, v.insar_deformation_mm_mo, v.rainfall_anomaly_pct, v.soil_moisture_proxy_trend
FROM (
  SELECT 1 AS site_id,NOW()-INTERVAL 2 DAY AS started_at,NOW()-INTERVAL 2 DAY AS observed_at,0.42 AS ndvi,0.31 AS evi,22.5 AS ndvi_drop_30d_pct,18.1 AS evi_drop_30d_pct,2.1 AS insar_deformation_mm_mo,110.0 AS rainfall_anomaly_pct,0.78 AS soil_moisture_proxy_trend UNION ALL
  SELECT 2,NOW()-INTERVAL 1 DAY,NOW()-INTERVAL 1 DAY,0.38,0.29,28.0,24.4,1.2,145.0,0.82 UNION ALL
  SELECT 3,NOW()-INTERVAL 10 HOUR,NOW()-INTERVAL 10 HOUR,0.35,0.27,31.2,29.5,6.8,160.0,0.91 UNION ALL
  SELECT 4,NOW()-INTERVAL 3 DAY,NOW()-INTERVAL 3 DAY,0.55,0.44,5.0,4.2,0.4,98.0,0.45 UNION ALL
  SELECT 5,NOW()-INTERVAL 5 DAY,NOW()-INTERVAL 5 DAY,0.47,0.39,12.8,10.1,1.9,120.0,0.66
) v
JOIN site_runs r
  ON r.site_id = v.site_id
  AND r.started_at = v.started_at
LEFT JOIN satellite_observations s
  ON s.site_id = v.site_id
  AND s.observed_at = v.observed_at
WHERE s.id IS NULL;

INSERT INTO edge_observations
(site_id, run_id, observed_at, device_id, image_url, veg_cover_pct, erosion_area_pct, crack_score, wetness_pct, humidity_pct)
SELECT v.site_id, r.id, v.observed_at, v.device_id, v.image_url, v.veg_cover_pct, v.erosion_area_pct, v.crack_score, v.wetness_pct, v.humidity_pct
FROM (
  SELECT 1 AS site_id,NOW()-INTERVAL 2 DAY AS started_at,NOW()-INTERVAL 2 DAY AS observed_at,'EDGE-001' AS device_id,'/assets/images/site1.webp' AS image_url,62.0 AS veg_cover_pct,12.5 AS erosion_area_pct,18.0 AS crack_score,45.0 AS wetness_pct,72.0 AS humidity_pct UNION ALL
  SELECT 2,NOW()-INTERVAL 1 DAY,NOW()-INTERVAL 1 DAY,'EDGE-002','/assets/images/site2.webp',55.0,18.2,22.5,58.0,78.0 UNION ALL
  SELECT 3,NOW()-INTERVAL 10 HOUR,NOW()-INTERVAL 10 HOUR,'EDGE-003','/assets/images/site3.webp',48.0,25.1,41.8,66.0,82.0 UNION ALL
  SELECT 4,NOW()-INTERVAL 3 DAY,NOW()-INTERVAL 3 DAY,'EDGE-004','/assets/images/site4.webp',78.0,4.2,3.5,22.0,60.0 UNION ALL
  SELECT 5,NOW()-INTERVAL 5 DAY,NOW()-INTERVAL 5 DAY,'EDGE-005','/assets/images/site5.webp',69.0,9.8,12.1,39.0,68.0
) v
JOIN site_runs r
  ON r.site_id = v.site_id
  AND r.started_at = v.started_at
LEFT JOIN edge_observations e
  ON e.site_id = v.site_id
  AND e.observed_at = v.observed_at
WHERE e.id IS NULL;

INSERT INTO risk_events
(site_id, run_id, started_at, status, level, system_decision, final_risk_score, satellite_risk_score, edge_risk_score, confidence_score, summary)
SELECT v.site_id, r.id, v.started_at, v.status, v.level, v.system_decision, v.final_risk_score, v.satellite_risk_score, v.edge_risk_score, v.confidence_score, v.summary
FROM (
  SELECT 1 AS site_id,NOW()-INTERVAL 2 DAY AS run_started_at,NOW()-INTERVAL 2 DAY AS started_at,'open' AS status,'warning' AS level,'Monitor/Re-scan' AS system_decision,54.2 AS final_risk_score,58.0 AS satellite_risk_score,48.0 AS edge_risk_score,82.0 AS confidence_score,'Vegetation degradation trend detected' AS summary UNION ALL
  SELECT 2,NOW()-INTERVAL 1 DAY,NOW()-INTERVAL 1 DAY,'open','warning','Monitor/Re-scan',61.5,66.0,54.0,80.0,'Rainfall anomaly + erosion risk' UNION ALL
  SELECT 3,NOW()-INTERVAL 10 HOUR,NOW()-INTERVAL 10 HOUR,'open','critical','Confirmed Event',83.4,78.0,89.0,88.0,'Crack formation with ground deformation' UNION ALL
  SELECT 4,NOW()-INTERVAL 3 DAY,NOW()-INTERVAL 3 DAY,'resolved','info','Normal State',18.2,20.0,15.0,90.0,'Stable conditions' UNION ALL
  SELECT 5,NOW()-INTERVAL 5 DAY,NOW()-INTERVAL 5 DAY,'acknowledged','warning','Local Anomaly',46.0,42.0,50.0,75.0,'Localized erosion detected'
) v
JOIN site_runs r
  ON r.site_id = v.site_id
  AND r.started_at = v.run_started_at
LEFT JOIN risk_events ev
  ON ev.site_id = v.site_id
  AND ev.started_at = v.started_at
WHERE ev.id IS NULL;

INSERT INTO risk_event_factors
(event_id, risk_type_id, layer, raw_value, normalized_score, risk_level, threshold_low, threshold_medium, threshold_high, evidence_url, note)
SELECT ev.id, rt.id, v.layer, v.raw_value, v.normalized_score, v.risk_level, v.threshold_low, v.threshold_medium, v.threshold_high, v.evidence_url, v.note
FROM (
  SELECT 1 AS site_id,NOW()-INTERVAL 2 DAY AS event_started_at,'NDVI_DROP_30D' AS risk_code,'satellite' AS layer,22.5 AS raw_value,65.0 AS normalized_score,'medium' AS risk_level,10.0 AS threshold_low,20.0 AS threshold_medium,30.0 AS threshold_high,NULL AS evidence_url,'NDVI decline' AS note UNION ALL
  SELECT 1,NOW()-INTERVAL 2 DAY,'EDGE_VEG_COVER_PCT','edge',62.0,48.0,'medium',70.0,60.0,50.0,NULL,'Reduced vegetation' UNION ALL
  SELECT 2,NOW()-INTERVAL 1 DAY,'RAINFALL_ANOMALY_PCT','satellite',145.0,70.0,'medium',110.0,130.0,150.0,NULL,'Rainfall anomaly' UNION ALL
  SELECT 2,NOW()-INTERVAL 1 DAY,'EDGE_EROSION_AREA_PCT','edge',18.2,55.0,'medium',5.0,15.0,25.0,NULL,'Erosion detected' UNION ALL
  SELECT 3,NOW()-INTERVAL 10 HOUR,'INSAR_DEFORMATION_MM_MO','satellite',6.8,88.0,'high',1.0,3.0,5.0,NULL,'Ground deformation' UNION ALL
  SELECT 3,NOW()-INTERVAL 10 HOUR,'EDGE_CRACK_SCORE','edge',41.8,92.0,'high',10.0,25.0,40.0,NULL,'Severe cracks' UNION ALL
  SELECT 4,NOW()-INTERVAL 3 DAY,'NDVI_DROP_30D','satellite',5.0,15.0,'low',10.0,20.0,30.0,NULL,'Stable vegetation' UNION ALL
  SELECT 5,NOW()-INTERVAL 5 DAY,'EDGE_EROSION_AREA_PCT','edge',9.8,52.0,'medium',5.0,15.0,25.0,NULL,'Localized erosion'
) v
JOIN risk_events ev
  ON ev.site_id = v.site_id
  AND ev.started_at = v.event_started_at
JOIN risk_types rt
  ON rt.code = v.risk_code
LEFT JOIN risk_event_factors f
  ON f.event_id = ev.id
  AND f.risk_type_id = rt.id
  AND f.layer = v.layer
WHERE f.id IS NULL;

INSERT INTO site_risk_snapshots
(site_id, event_id, snapshot_at, satellite_risk_score, edge_risk_score, final_risk_score, confidence_score, system_decision)
SELECT v.site_id, ev.id, v.snapshot_at, v.satellite_risk_score, v.edge_risk_score, v.final_risk_score, v.confidence_score, v.system_decision
FROM (
  SELECT 1 AS site_id,NOW()-INTERVAL 2 DAY AS event_started_at,NOW()-INTERVAL 2 DAY AS snapshot_at,58.0 AS satellite_risk_score,48.0 AS edge_risk_score,54.2 AS final_risk_score,82.0 AS confidence_score,'Monitor/Re-scan' AS system_decision UNION ALL
  SELECT 2,NOW()-INTERVAL 1 DAY,NOW()-INTERVAL 1 DAY,66.0,54.0,61.5,80.0,'Monitor/Re-scan' UNION ALL
  SELECT 3,NOW()-INTERVAL 10 HOUR,NOW()-INTERVAL 10 HOUR,78.0,89.0,83.4,88.0,'Confirmed Event' UNION ALL
  SELECT 4,NOW()-INTERVAL 3 DAY,NOW()-INTERVAL 3 DAY,20.0,15.0,18.2,90.0,'Normal State' UNION ALL
  SELECT 5,NOW()-INTERVAL 5 DAY,NOW()-INTERVAL 5 DAY,42.0,50.0,46.0,75.0,'Local Anomaly'
) v
JOIN risk_events ev
  ON ev.site_id = v.site_id
  AND ev.started_at = v.event_started_at
LEFT JOIN site_risk_snapshots s
  ON s.site_id = v.site_id
  AND s.snapshot_at = v.snapshot_at
WHERE s.id IS NULL;

INSERT INTO alerts
(user_id, site_id, event_id, mail_from, alert_level, channel, title, content, is_read)
SELECT v.user_id, v.site_id, ev.id, v.mail_from, v.alert_level, v.channel, v.title, v.content, v.is_read
FROM (
  SELECT 1 AS user_id,1 AS site_id,NOW()-INTERVAL 2 DAY AS event_started_at,'system@minesmart.co.ke' AS mail_from,'warning' AS alert_level,'web' AS channel,'Vegetation Risk Escalation' AS title,'NDVI decline exceeded 20% over 30 days. Site flagged for re-scan.' AS content,0 AS is_read UNION ALL
  SELECT 1,2,NOW()-INTERVAL 1 DAY,'system@minesmart.co.ke','warning','web','Rainfall & Erosion Risk','Rainfall anomaly and erosion detected. Monitor drainage stability.',0 UNION ALL
  SELECT 1,3,NOW()-INTERVAL 10 HOUR,'alerts@minesmart.co.ke','critical','web','Confirmed Ground Failure','InSAR deformation and crack detection confirm slope instability.',0 UNION ALL
  SELECT 1,5,NOW()-INTERVAL 5 DAY,'compliance@minesmart.co.ke','warning','web','Local Erosion Anomaly','Localized erosion detected during compliance inspection.',1
) v
JOIN risk_events ev
  ON ev.site_id = v.site_id
  AND ev.started_at = v.event_started_at
LEFT JOIN alerts a
  ON a.user_id = v.user_id
  AND a.site_id = v.site_id
  AND a.event_id = ev.id
  AND a.title = v.title
WHERE a.id IS NULL;

INSERT INTO evidence_packs
(site_id, event_id, status, pdf_url, geojson_url, csv_url, images_zip_url)
SELECT v.site_id, ev.id, v.status, v.pdf_url, v.geojson_url, v.csv_url, v.images_zip_url
FROM (
  SELECT 1 AS site_id,NOW()-INTERVAL 2 DAY AS event_started_at,'ready' AS status,'/evidence/site1.pdf' AS pdf_url,'/geo/site1.json' AS geojson_url,'/csv/site1.csv' AS csv_url,'/images/site1.zip' AS images_zip_url UNION ALL
  SELECT 2,NOW()-INTERVAL 1 DAY,'ready','/evidence/site2.pdf','/geo/site2.json','/csv/site2.csv','/images/site2.zip' UNION ALL
  SELECT 3,NOW()-INTERVAL 10 HOUR,'building',NULL,NULL,NULL,NULL UNION ALL
  SELECT 5,NOW()-INTERVAL 5 DAY,'queued',NULL,NULL,NULL,NULL
) v
JOIN risk_events ev
  ON ev.site_id = v.site_id
  AND ev.started_at = v.event_started_at
LEFT JOIN evidence_packs p
  ON p.site_id = v.site_id
  AND p.event_id = ev.id
WHERE p.id IS NULL;
