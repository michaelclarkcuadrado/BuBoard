<?php
/**
 * Created by PhpStorm.
 * User: mike
 * Date: 9/20/17
 * Time: 1:31 PM
 */
require_once 'config.php';
echo "Hello World! <br> <br>";

echo "Data will be below if the database is working: <br> <br>";

$data = mysqli_query($mysqli, "DESCRIBE buboard_profiles");
while($row = mysqli_fetch_assoc($data)){
    print_r($row);
    echo "<br>";
}
?>