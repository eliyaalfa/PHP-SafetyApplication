<?php
include_once "koneksi.php";
 class usr{}

 $nama = $_POST["nama"];
 $no_telp = $_POST["no_telp"];
 $no_keluarga = $_POST["no_keluarga"];
 $password = $_POST["password"];
 $confirm_password = $_POST["confirm_password"];

 if ((empty($nama))) {
 	$response = new usr();
 	$response->success = 0;
 	$response->message = "Kolom nama tidak boleh kosong";
 	die(json_encode($response));
 } else if ((empty($no_telp))) {
 	$response = new usr();
 	$response->success = 0;
 	$response->message = "Kolom Nomor Telepon tidak boleh kosong";
 	die(json_encode($response));
 }else if ((empty($no_keluarga))) {
 	$response = new usr();
 	$response->success = 0;
 	$response->message = "Kolom password tidak boleh kosong";
 	die(json_encode($response));
 }else if ((empty($password))) {
 	$response = new usr();
 	$response->success = 0;
 	$response->message = "Kolom password tidak boleh kosong";
 	die(json_encode($response));
 } else if ((empty($confirm_password)) || $password != $confirm_password) {
 	$response = new usr();
 	$response->success = 0;
 	$response->message = "Konfirmasi password tidak sama";
 	die(json_encode($response));
 } else {
 if (!empty($nama) && $password == $confirm_password){
 	$num_rows = mysqli_num_rows(mysqli_query($con, "SELECT * FROM user WHERE name='".$nama."'"));

	 	if ($num_rows == 0){
	 		$query = mysqli_query($con, "INSERT INTO user (user_id, name, phone, family_phone, password) VALUES('','".$nama."','".$no_telp."','".$no_keluarga."','".$password."')");

	 		if ($query){
	 			$response = new usr();
	 			$response->success = 1;
	 			$response->message = "Registrasi berhasil, silahkan login.";
	 			die(json_encode($response));

	 		} else {
	 			$response = new usr();
	 			$response->success = 0;
	 			$response->message = "Username sudah ada";
	 			die(json_encode($response));
	 		}
	 	} else {
	 		$response = new usr();
	 		$response->success = 0;
	 		$response->message = "Username sudah ada";
	 		die(json_encode($response));
	 	}
	 }
	}

	mysqli_close($con);
?>	