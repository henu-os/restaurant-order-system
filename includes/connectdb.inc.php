<?php
$conn = mysqli_connect($dblocation, $dbuser, $dbpass, $dbname);

if (!$conn) {
    die("<h1>Database connection failed</h1>" . mysqli_connect_error());
}
?>