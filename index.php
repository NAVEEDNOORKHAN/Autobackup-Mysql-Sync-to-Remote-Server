<?php
include("settings.php");

// Settings
$backupDir = __DIR__ . '/backups/';
$moveToDir = __DIR__ . '/archive/';
$timestamp = date('Ymd_His');
$sqlFile = $backupDir . "db_backup_$timestamp.sql";
$zipFile = $backupDir . "db_backup_$timestamp.zip";

// Ensure backup directory exists
if (!is_dir($backupDir)) mkdir($backupDir, 0777, true);
if (!is_dir($moveToDir)) mkdir($moveToDir, 0777, true);

// Create SQL dump
$command = "mysqldump --user=$dbUser --password=$dbPassword --host=$dbHost $dbName > $sqlFile";
system($command, $output);

// Zip the SQL file
$zip = new ZipArchive();
if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
    $zip->addFile($sqlFile, basename($sqlFile));
    $zip->close();
    unlink($sqlFile); // remove unzipped file
} else {
    die("Failed to create zip file.");
}

// Email the zip file
$to = 'user@website.com'; // Replace with your email
$subject = "Your Database Backup - $timestamp";
$message = "Auto backup";
$headers = "From: username@website.com";

// Read zip content
$content = chunk_split(base64_encode(file_get_contents($zipFile)));
$uid = md5(uniqid(time()));
$name = basename($zipFile);

$header = "From: username@website.com\r\n";
$header .= "MIME-Version: 1.0\r\n";
$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";
$body = "--".$uid."\r\n";
$body .= "Content-type:text/plain; charset=iso-8859-1\r\n";
$body .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
$body .= $message."\r\n\r\n";
$body .= "--".$uid."\r\n";
$body .= "Content-Type: application/zip; name=\"".$name."\"\r\n";
$body .= "Content-Transfer-Encoding: base64\r\n";
$body .= "Content-Disposition: attachment; filename=\"".$name."\"\r\n\r\n";
$body .= $content."\r\n\r\n";
$body .= "--".$uid."--";

// Send email
if (mail($to, $subject, $body, $header)) {
    echo "Backup and email sent successfully.";
} else {
    echo "Failed to send email.";
}

// Move zip to archive directory
rename($zipFile, $moveToDir . basename($zipFile));
?>
