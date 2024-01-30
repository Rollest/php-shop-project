<?php
session_start();
session_destroy();
header("Location: http://shop-project/index.php");
die();
