<?php
require __DIR__ . '/../../helpers/online_connector.php';

$type = $_GET['type'] ?? 'custom_audit_request';
$site_id = isset($_GET['site_id']) ? (int)$_GET['site_id'] : 0;

$site = null;
if ($site_id > 0) {
  $st = $pdo->prepare("SELECT id,name FROM sites WHERE id=:id LIMIT 1");
  $st->bindValue(':id', $site_id, PDO::PARAM_INT);
  $st->execute();
  $site = $st->fetch(PDO::FETCH_ASSOC);
}

$names = [
  'custom_audit_request' => 'Custom Audit Request Form',
  'incident_escalation' => 'Incident Escalation Form',
  'rehabilitation_attestation' => 'Rehabilitation Attestation Form',
  'data_access_request' => 'Data Access Request Form',
];

$title = $names[$type] ?? 'MineSmart Form';
$filename = preg_replace('/[^a-z0-9_]+/i','_', strtolower($title)) . '.pdf';

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="'.$filename.'"');
header('X-Content-Type-Options: nosniff');

$html = "
<!doctype html>
<html>
<head>
  <meta charset='utf-8'>
  <style>
    body{font-family: Arial, sans-serif; padding: 24px; color:#0f172a}
    h1{font-size: 18px; margin: 0 0 6px}
    .meta{font-size: 11px; color:#334155; margin-bottom: 16px}
    .box{border:1px solid #cbd5e1; padding: 14px; border-radius: 10px; margin: 12px 0}
    .row{display:flex; gap:12px}
    .field{flex:1}
    .label{font-size:10px; color:#475569; font-weight:700; text-transform:uppercase; letter-spacing:.08em}
    .value{margin-top:6px; min-height:18px; border-bottom:1px dashed #cbd5e1}
    .sig{margin-top:26px; display:flex; justify-content:space-between; gap:24px}
  </style>
</head>
<body>
  <h1>{$title}</h1>
  <div class='meta'>Generated: ".gmdate('Y-m-d H:i:s')." UTC • System: MineSmart Sentinel • Site: ".($site ? htmlspecialchars($site['name'])." (#{$site['id']})" : "ALL")."</div>

  <div class='box'>
    <div class='row'>
      <div class='field'><div class='label'>Requesting Organization</div><div class='value'></div></div>
      <div class='field'><div class='label'>Contact Person</div><div class='value'></div></div>
    </div>
    <div class='row' style='margin-top:10px'>
      <div class='field'><div class='label'>Email</div><div class='value'></div></div>
      <div class='field'><div class='label'>Phone</div><div class='value'></div></div>
    </div>
    <div class='row' style='margin-top:10px'>
      <div class='field'><div class='label'>Site / Permit Reference</div><div class='value'></div></div>
      <div class='field'><div class='label'>Date Range Requested</div><div class='value'></div></div>
    </div>
  </div>

  <div class='box'>
    <div class='label'>Purpose / Details</div>
    <div class='value' style='min-height:110px'></div>
  </div>

  <div class='box'>
    <div class='label'>Requested Deliverables</div>
    <div style='margin-top:8px; font-size:12px'>
      ☐ Evidence Pack (PDF) &nbsp;&nbsp; ☐ CSV Export &nbsp;&nbsp; ☐ GeoJSON &nbsp;&nbsp; ☐ Images ZIP &nbsp;&nbsp; ☐ Full Bundle ZIP
    </div>
  </div>

  <div class='sig'>
    <div class='field'><div class='label'>Authorized Signature</div><div class='value'></div></div>
    <div class='field'><div class='label'>Date</div><div class='value'></div></div>
  </div>
</body>
</html>
";

echo $html;
exit;
