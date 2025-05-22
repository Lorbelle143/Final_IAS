<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "Incident ID not provided.";
    exit();
}

$filename = 'incidents.json';
$incidents = json_decode(file_get_contents($filename), true);
$incident = null;

foreach ($incidents as $item) {
    if ($item['id'] === $_GET['id']) {
        $incident = $item;
        break;
    }
}

if (!$incident) {
    echo "Incident not found.";
    exit();
}
?>

<?php include 'header.php'; ?>
<h2>Incident Detail - <?= $incident['id'] ?></h2>
<ul>
    <li><strong>Name:</strong> <?= htmlspecialchars($incident['name']) ?></li>
    <li><strong>Email:</strong> <?= htmlspecialchars($incident['email']) ?></li>
    <li><strong>Description:</strong> <?= htmlspecialchars($incident['description']) ?></li>
    <li><strong>Impact:</strong> <?= $incident['impact'] ?></li>
    <li><strong>Status:</strong> <?= $incident['status'] ?></li>
    <li><strong>Timestamp:</strong> <?= $incident['timestamp'] ?></li>
</ul>
<a href="dashboard.php">← Back to Dashboard</a>
<?php include 'footer.php'; ?>
