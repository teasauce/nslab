<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: /nslab/login.php");
    exit;
}
