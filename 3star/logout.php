<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Delete remember me cookie if it exists
if (isset($_COOKIE['remember_token'])) {
    setcookie('remember_token', '', time() - 3600, "/");
}

// Redirect to home page
header("Location: index.php?logout=success");
exit();
?>
