<?php
    include_once('koneksi.php');
    if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
        $history_id = $_POST['history_id'];
        // $history_id = 612;
        $status = "normal";
        
        $cek_history_status = mysqli_query($con, "select * from history join user using (user_id) where history_id='$history_id'");
        $d_history_status = mysqli_fetch_array($cek_history_status);
        $history_status = $d_history_status['status'];
        
        $token = array();
        if ( $history_status == $status ) {
            $response->success = 0;
            $response->message = "Korban baik-baik saja";
        } else if ($history_status == "kecelakaan") {
            $response->success = 0;
            $response->message = "Korban mengalami kecelakaan";
        } else if ($history_status == "Dibawa ke Rumah Sakit" ){
           
            $q_u_history = mysqli_query($con, "update history set status='$status' where history_id='$history_id'");
            if ($q_u_history) {
               
                    $s_d_respondent = mysqli_query($con, "select * from respondent");
                    while ($d_respondent = mysqli_fetch_array($s_d_respondent)) {
                        $respondent_phone = $d_respondent['phone'];
                        $user_fam_phone = $d_history_status['family_phone'];
                        
                        if ($respondent_phone == $user_fam_phone) {
                            $token[] = $d_respondent['token'];
                            $data->status = $status;
                        }
                    }
                    
                    $response->success = 1;
                    $response->message = "Korban telah tiba di Rumah Sakit";
                    
                    $name = $d_history_status['name'];
                    $description = "Telah tiba di Rumah Sakit";
                    $datas = json_encode($data);
                    $tokens = json_encode($token);
             
                    // push notifikasi ke cloud message menggunakan firebase
                    $curl = curl_init();
                
                    $header = array(
                      "Content-type: application/json",
                      "Authorization: key=AAAAwum3tGI:APA91bHzysBkIfVFPvlCHqXTD1kaPPJ-oDlGSCV1r0y3SQHRbr2sBOlq6RiFYlOquJ1op4_fznfiMShMMjn9wmO5IC-C2uH3u7DXaz8wzHZesqomrJIqH3TmUBBNuKHoTsDI8e8a4cfg"
                    );
                    $fields = '{
                      "registration_ids": '.$tokens.',
                      "notification": {
                          "title": "'.$name.'",
                          "body": "'.$description.'"
                      },
                      "data": '.$datas.',
                    }';
                    
                    curl_setopt_array($curl, array(
                      CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
                      CURLOPT_RETURNTRANSFER => true,
                      CURLOPT_ENCODING => "",
                      CURLOPT_MAXREDIRS => 10,
                      CURLOPT_TIMEOUT => 0,
                      CURLOPT_FOLLOWLOCATION => true,
                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                      CURLOPT_CUSTOMREQUEST => "POST",
                      CURLOPT_POSTFIELDS => $fields,
                      CURLOPT_HTTPHEADER => $header,
                    ));
                    
                    curl_exec($curl);
                    
                    curl_close($curl);
                    
                
            } else {
                $response->success = 0;
                $response->message = "Update status gagal! Anda tidak dapat membawa korban ke Rumah Sakit";
            }
        } else {
            $response->success = 0;
            $response->message = "Korban tidak terdeteksi";
        }
        
        die(json_encode($response));
        
        mysqli_close($con);
    }
         
?>