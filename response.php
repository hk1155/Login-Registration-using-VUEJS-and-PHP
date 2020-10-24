<?php
$con =  mysqli_connect("localhost", "root", "", "myadmin");

$data = array();

$data = json_decode(file_get_contents("php://input"));
$request = $data->request;
if ($request == 1) {
    $username = $data->username;
    $password = $data->password;

    $sql = "select * from tbl_user where email='$username' and password='$password'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

    $email = $row['email'];
    $pwd = $row['password'];



    if ($username == $email && $password == $pwd) {
        $response[] = array('status' => 1);
    } else {
        $response[] = array('status' => 0);
    }
    echo json_encode($response);
    //exit;
}
