<?php
include_once "koneksi.php";
if ($_SERVER['REQUEST_METHOD'] =='POST'){
    
	class usr{}
	$token = $_POST["token"];
	$phone = $_POST["phone"];
	$password = md5($_POST["password"]);

	mysqli_query($con, "UPDATE respondent SET token='null' WHERE token='$token'");

	$query = mysqli_query($con, "SELECT * FROM respondent WHERE phone='$phone' AND password='$password'");
	$row = mysqli_fetch_array($query);

	if (!empty($row)){
	    $q_utoken = mysqli_query($con, "UPDATE respondent SET token='$token' WHERE phone='$phone'");
	    if ($q_utoken) {
    		$response = new usr();
    		$response->success = "1";
    		$response->message = "Berhsil Login";
    		$response->id = $row['respondent_id'];
    		$response->name = $row['name'];
    		$response->phone = $row['phone'];
    		$response->password = $row['password'];
    		$response->token = $row['token'];
    		die(json_encode($response));
	    }
	} else {
		$response = new usr();
		$response->success = 0;
		$response->message = "Telepon atau password salah";
		die(json_encode($response));
	}

	mysqli_close($con);
}
?>
