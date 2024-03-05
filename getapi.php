<?php

require('dbconn.php');

if($_SERVER['REQUEST_METHOD'] == 'GET'){
    $sql = 'SELECT * FROM business_permit';

    $result = mysqli_query($conn, $sql);

    $data = array(); // Initialize an empty array to store the results

    while($row = mysqli_fetch_assoc($result)){
        $data[] = $row;
    }

    $result_bp = array('status' => 200, 'data' => $data);
    echo json_encode($result_bp);
}
?>
