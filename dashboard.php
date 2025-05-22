<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: admin_login.php");
    exit();
}

$filename = 'incidents.json';
$incidents = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];

// Update incident
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_id'])) {
    foreach ($incidents as &$incident) {
        if (isset($incident['id']) && $incident['id'] === $_POST['update_id']) {
            if (isset($_POST['name'])) $incident['name'] = $_POST['name'];
            if (isset($_POST['email'])) $incident['email'] = $_POST['email'];
            if (isset($_POST['description'])) $incident['description'] = $_POST['description'];
            if (isset($_POST['impact'])) $incident['impact'] = $_POST['impact'];
            if (isset($_POST['new_status'])) $incident['status'] = $_POST['new_status'];
            $incident['timestamp'] = date('Y-m-d H:i:s');

            $log = fopen("incident_log.txt", "a");
            fwrite($log, "[{$incident['timestamp']}] Incident {$incident['id']} updated\n");
            fclose($log);
            break;
        }
    }
    file_put_contents($filename, json_encode($incidents, JSON_PRETTY_PRINT));
    header("Location: dashboard.php");
    exit();
}

// Delete incident
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_id'])) {
    $incidents = array_filter($incidents, function($incident) {
        return isset($incident['id']) && $incident['id'] !== $_POST['delete_id'];
    });
    file_put_contents($filename, json_encode(array_values($incidents), JSON_PRETTY_PRINT));
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents("incident_log.txt", "[$timestamp] Incident {$_POST['delete_id']} deleted\n", FILE_APPEND);
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Incident Dashboard</title>
    <style>
        /* === PROFESSIONAL CLEAN STYLE === */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h2 {
            margin-bottom: 25px;
            font-weight: 700;
            font-size: 28px;
            color: #222;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px; /* space between rows */
        }

        th, td {
            padding: 14px 20px;
            text-align: left;
            vertical-align: middle;
        }

        th {
            background-color: #007bff;
            color: white;
            font-weight: 600;
            border-radius: 8px 8px 0 0;
        }

        tr {
            background: #fafafa;
            box-shadow: 0 1px 3px rgb(0 0 0 / 0.1);
            border-radius: 8px;
        }

        tr:hover {
            background: #e9f1ff;
        }

        td {
            background: white;
            border-radius: 8px;
            box-shadow: 0 1px 2px rgb(0 0 0 / 0.05);
        }

        input[type="text"], input[type="email"], select, textarea {
            width: 95%;
            padding: 8px 12px;
            border: 1.5px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus, input[type="email"]:focus, select:focus, textarea:focus {
            border-color: #007bff;
            outline: none;
            background: #f0f8ff;
        }

        textarea {
            resize: vertical;
            min-height: 60px;
        }

        button {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-right: 5px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .action-buttons button.delete {
            background-color: #dc3545;
        }

        .action-buttons button.delete:hover {
            background-color: #a71d2a;
        }

        .action-buttons {
            white-space: nowrap;
        }

        form.inline {
            display: inline-block;
            margin: 0;
        }

        td form {
            margin: 0;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Admin Incident Dashboard</h2>

    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Description</th><th>Impact</th><th>Status</th><th>Actions</th><th>Timestamp</th>
        </tr>

        <?php foreach ($incidents as $incident): ?>
            <?php if (!isset($incident['id'])) continue; ?>
        <tr class="<?= strtolower($incident['impact'] ?? 'low'); ?>">
            <form method="POST">
                <td><?= htmlspecialchars($incident['id']) ?></td>
                <td><input type="text" name="name" value="<?= htmlspecialchars($incident['name'] ?? '') ?>" required></td>
                <td><input type="email" name="email" value="<?= htmlspecialchars($incident['email'] ?? '') ?>" required></td>
                <td><textarea name="description" required><?= htmlspecialchars($incident['description'] ?? '') ?></textarea></td>
                <td>
                    <select name="impact" required>
                        <option value="Low" <?= ($incident['impact'] ?? '') === 'Low' ? 'selected' : '' ?>>Low</option>
                        <option value="Medium" <?= ($incident['impact'] ?? '') === 'Medium' ? 'selected' : '' ?>>Medium</option>
                        <option value="High" <?= ($incident['impact'] ?? '') === 'High' ? 'selected' : '' ?>>High</option>
                    </select>
                </td>
                <td>
                    <select name="new_status" required>
                        <option <?= ($incident['status'] ?? '') === 'Pending' ? 'selected' : '' ?>>Pending</option>
                        <option <?= ($incident['status'] ?? '') === 'Investigating' ? 'selected' : '' ?>>Investigating</option>
                        <option <?= ($incident['status'] ?? '') === 'Resolved' ? 'selected' : '' ?>>Resolved</option>
                    </select>
                </td>
                <td class="action-buttons">
                    <input type="hidden" name="update_id" value="<?= htmlspecialchars($incident['id']) ?>">
                    <button type="submit">Update</button>
            </form>
            <form method="POST" onsubmit="return confirm('Delete this incident?');" class="inline">
                <input type="hidden" name="delete_id" value="<?= htmlspecialchars($incident['id']) ?>">
                <button type="submit" class="delete">Delete</button>
            </form>
                </td>
                <td><?= htmlspecialchars($incident['timestamp'] ?? '') ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</div>
</body>
</html>
