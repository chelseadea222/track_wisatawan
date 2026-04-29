<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear all session variables
session_unset();
session_destroy();

header("Location: landing_page.php");
exit;
?>
