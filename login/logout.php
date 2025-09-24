<?php
session_start();
session_destroy();
header("Location: /votacao-filme/login/login.php");
exit;