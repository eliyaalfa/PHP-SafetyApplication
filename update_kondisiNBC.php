<?php 

 /*
 
 penulis: Muhammad yusuf
 website: https://www.kodingindonesia.com/
 
 */

$start = microtime(true);

	if($_SERVER['REQUEST_METHOD']=='POST'){
		//MEndapatkan Nilai Dari Variable 
		$id = $_POST['id'];
		$aktivitas = $_POST['kondisi'];
		$time = $_POST['time'];
		
		
		//import file koneksi database 
		require_once('koneksi.php');
		
		//Membuat SQL Query
		
		$end = microtime(true);
		$waktuu = ($end-$start);

		$timee = $waktuu + $time;

		$sql = mysqli_query($con, "INSERT INTO aktivitasNBC (id_kondisi, user_id, kondisi, waktuklasifikasi) VALUES('','".$id."','".$aktivitas."','".$timee."')");
		
		//Meng-update Database 
		if(mysqli_query($con,$sql)){
			echo 'Berhasil Update Data ';
		}else{
			echo 'Gagal Update Data ';
		}
		
		mysqli_close($con);
	}
?>