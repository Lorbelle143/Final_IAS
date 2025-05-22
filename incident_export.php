<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$filename = 'incidents.json';
$incidents = json_decode(file_get_contents($filename), true);

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename="incident_export.csv"');

$output = fopen("php://output", "w");
fputcsv($output, ['ID', 'Name', 'Email', 'Description', 'Impact', 'Status', 'Timestamp']);

foreach ($incidents as $incident) {
    fputcsv($output, [
        $incident['id'] ?? '',
        $incident['name'] ?? '',
        $incident['email'] ?? '',
        $incident['description'] ?? '',
        $incident['impact'] ?? '',
        $incident['status'] ?? '',
        $incident['timestamp'] ?? ''
    ]);
}

fclose($output);
exit();
