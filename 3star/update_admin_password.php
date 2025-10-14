<?php
require_once 'config.php';
$newHash = password_hash('admin123', PASSWORD_DEFAULT);
mysqli_query($conn, "UPDATE admins SET password='$newHash' WHERE username='admin'");
echo "Admin password updated!";
?>
