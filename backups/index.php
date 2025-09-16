<?php
$backupDir = __DIR__ . '/';

// Get all files except . and .. and exclude .php files
$allFiles = array_diff(scandir($backupDir), ['.', '..']);
$files = array_filter($allFiles, function($file) use ($backupDir) {
    return pathinfo($file, PATHINFO_EXTENSION) !== 'php';
});

if (isset($_GET['action']) && isset($_GET['file'])) {
    $file = basename($_GET['file']);
    $filePath = $backupDir . $file;

    if ($_GET['action'] === 'delete' && file_exists($filePath)) {
        unlink($filePath);
        header("Location: index.php?msg=Deleted: $file");
        exit;
    }

    if ($_GET['action'] === 'download' && file_exists($filePath)) {
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Backup Dashboard</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f4f4f4; }
        table { width: 100%; border-collapse: collapse; background: #fff; box-shadow: 0 2px 8px #ccc; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: left; }
        th { background: #333; color: white; }
        a.button { padding: 5px 10px; margin-right: 5px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; }
        a.button.delete { background: #dc3545; }
        .message { margin-bottom: 20px; color: green; }
    </style>
</head>
<body>
    <h1>Backup Dashboard</h1>
    <?php if (isset($_GET['msg'])): ?>
        <div class="message"><?= htmlspecialchars($_GET['msg']) ?></div>
    <?php endif; ?>
    <table>
        <thead>
            <tr>
                <th>File</th>
                <th>Size</th>
                <th>Last Modified</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($files as $file): 
                $path = $backupDir . $file;
            ?>
            <tr>
                <td><?= htmlspecialchars($file) ?></td>
                <td><?= round(filesize($path) / 1024, 2) ?> KB</td>
                <td><?= date("Y-m-d H:i:s", filemtime($path)) ?></td>
                <td>
                    <a class="button" href="?action=download&file=<?= urlencode($file) ?>">Download</a>
                    <a class="button delete" href="?action=delete&file=<?= urlencode($file) ?>" onclick="return confirm('Delete this backup?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php if (empty($files)): ?>
            <tr><td colspan="4">No backups found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
