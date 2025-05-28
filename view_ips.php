<?php
$conn = new mysqli("localhost", "username", "password", "database_name");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM ip_logs ORDER BY visit_time DESC");

echo "<h2>Logged IPs</h2>";
echo "<table border='1'><tr><th>ID</th><th>IP Address</th><th>Time</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['id']}</td><td>{$row['ip_address']}</td><td>{$row['visit_time']}</td></tr>";
}

echo "</table>";

$conn->close();
?>
