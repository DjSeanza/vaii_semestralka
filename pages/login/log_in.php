<?php
include "../../database/Connection.php";
include "../../database/Authentication.php";

$auth = new Authentication();
$conn = new Connection();

header("Location: ../../index.php");