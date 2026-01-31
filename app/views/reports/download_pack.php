<?php
require __DIR__ . '/../../helpers/online_connector.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$asset = $_GET['asset'] ?? '';

if ($id <= 0) { http_response_code(400); exit('Missing id'); }

$st = $pdo->prepare("SELECT * FROM evidence_packs WHERE id=:id LIMIT 1");
$st->bindValue(':id', $id, PDO::PARAM_INT);
$st->execute();
$p = $st->fetch(PDO::FETCH_ASSOC);

if (!$p) { http_response_code(404); exit('Pack not found'); }

$map = [
  'pdf' => ['col'=>'pdf_url','mime'=>'application/pdf','name'=>"evidence_pack_{$id}.pdf"],
  'csv' => ['col'=>'csv_url','mime'=>'text/csv','name'=>"evidence_pack_{$id}.csv"],
  'geojson' => ['col'=>'geojson_url','mime'=>'application/geo+json','name'=>"evidence_pack_{$id}.geojson"],
  'images_zip' => ['col'=>'images_zip_url','mime'=>'application/zip','name'=>"evidence_pack_{$id}_images.zip"],
];

if (!isset($map[$asset])) { http_response_code(400); exit('Invalid asset'); }

$url = $p[$map[$asset]['col']] ?? null;
if (!$url) { http_response_code(404); exit('Asset not available yet'); }

// If your URLs are local paths, you can readfile(). If they are remote URLs, redirect.
if (strpos($url, 'http') === 0) {
    header("Location: ".$url);
    exit;
}

$path = $_SERVER['DOCUMENT_ROOT'] . $url;
if (!file_exists($path)) { http_response_code(404); exit('File missing on server'); }

header('Content-Type: '.$map[$asset]['mime']);
header('Content-Disposition: attachment; filename="'.$map[$asset]['name'].'"');
header('Content-Length: '.filesize($path));
readfile($path);
exit;
