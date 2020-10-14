<?php
if ($_SERVER['REQUEST_METHOD'] =='POST'){
include_once "koneksi.php";

	class usr{}
	$token = $_POST["token"];
	$name = addslashes($_POST["name"]);
	$phone = $_POST["phone"];
	$password = md5($_POST["password"]);
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];

	$num_rows = mysqli_num_rows(mysqli_query($con, "SELECT * FROM respondent WHERE phone='".$phone."'"));

	if ($num_rows > 0){
		$response = new usr();
		$response->success = 0;
		$response->message = "Nomor telepon sudah ada";
		die(json_encode($response));
	} else {
	    $q_user = mysqli_query($con, "INSERT INTO respondent (respondent_id, name, phone, password, latitude, longitude, token, distance_new, process_time_new) VALUES('','".$name."','".$phone."','".$password."','$latitude','$longitude', '".$token."','','')");
		if ($q_user) {
			$response = new usr();
			$response->success = 1;
			$response->message = "Register berhasil, silahkan login.";
			die(json_encode($response));
		} else {
			$response = new usr();
			$response->success = 0;
			$response->message = "Registrasi gagal!";
			die(json_encode($response));
		}
    }

	mysqli_close($con);
}
  ?>
