<?php
session_start();
if(isset($_SESSION['admin_id'])) {
    header("Location: ../admin/index.php");
} else {
    header("Location: ../index.php");
}
session_unset();
session_destroy();
exit;
?>
