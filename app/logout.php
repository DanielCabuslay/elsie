<?php
session_start(); 
# Destroy the session, this is for the current request
session_destroy();
header('Location: ../index.php');
?>