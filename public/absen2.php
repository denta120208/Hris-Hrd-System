<?php
date_default_timezone_set("Asia/Jakarta");
$servername = "192.168.200.51";
$username = "invent";
$password = "metland#123";
$databse = "websen_dbase";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $databse);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
try{
    $date = date('Y-m-d'); //'2019-08-20'
    $time = date('H');
        $absen = "
            SELECT DISTINCT comNIP, comDate,MIN(comTime) AS times, MIN(TIMESTAMP(comDate,comTime)) as dtTime
            FROM absen
            WHere comDate =  '".$date."' AND comTime >= '00:00:00' AND comTime <= '23:59:59' AND comNIP > 1
			AND comNIP = '1411010'
            GROUP BY comNIP
        ";
        $result = $conn->query($absen);
		$newTime = '08:'.rand(30,58).':'.rand(10,58);
		print_r($newTime); die;
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
				if($row['times'] >= '09:00:00'){
					/* $conn->query("
						update com_absensi_zk set comDateTime = '".$date." ".$newTime."' WHERE comNIP = '1411010' AND comDateTime = '".$row['dtTime']."'
					");	 */				
				}
            }
        }
    echo "Update Success";
}  catch (Exception $e){
    echo "Update Unsuccess with error ".$e;
}

?>
