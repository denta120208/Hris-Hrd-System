<?php
date_default_timezone_set("Asia/Jakarta");
$servername = "192.168.200.51";
$username = "invent";
$password = "metland#123";
$databse = "websen_dbase";

$dbhost = '192.168.200.6\MLCRM';
$dbuser = 'sa';
$dbpass = 'metland#123';
$dbname = 'ml_HRIS';

$link = mssql_connect($dbhost,$dbuser,$dbpass)or die('Error connecting to the SQL Server database.');
mssql_select_db($dbname,$link);

// Create connection
$conn = mysqli_connect($servername, $username, $password, $databse);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
try{
    $date = date('Y-m-d'); //'2019-08-20'
    $time = date('H');
    if($time <= 11){ // Ambil Absen Pagi
        $absen = "
            SELECT DISTINCT comNIP, comDate,MIN(comTime) AS times, MIN(TIMESTAMP(comDate,comTime)) as dtTime
            FROM absen
            WHere comDate =  '".$date."' AND comTime >= '00:00:00' AND comTime <= '23:59:59' AND comNIP > 1
            GROUP BY comNIP
        ";
        $result = $conn->query($absen);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
            mssql_query("
                INSERT INTO attendance_record(employee_id,punch_in_utc_time,punch_in_user_time) VALUES
                ('".$row['comNIP']."', '".$row['dtTime']."', '".$row['dtTime']."')
            ");
            }
        }
    }else{ // Ambil Absen Sore
        $absen = "
            SELECT DISTINCT comNIP, comDate, MAX(comTime) AS times, MAX(TIMESTAMP(comDate,comTime)) as dtTime
            FROM absen
            WHere comDate =  '".$date."' AND comTime >= '00:00:00' AND comTime <= '23:59:59' AND comNIP > 1
            GROUP BY comNIP
        ";
        $result = $conn->query($absen);
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
            mssql_query("
                UPDATE attendance_record SET punch_out_utc_time = '".$row["dtTime"]."', punch_out_user_time = '".$row["dtTime"]."'
                WHERE CAST(punch_in_utc_time AS date) = '".$date."' AND employee_id = '".$row["comNIP"]."'
            ");
            }
        }
    }
    echo "Update Success";
}  catch (Exception $e){
    echo "Update Unsuccess with error ".$e;
}

?>
