<?php
// File Ini berada di server 200.14 dir cron_job
$dbhost = '192.168.200.6\MLCRM';
$dbuser = 'loyalty';
$dbpass = 'm3tl4nd';
$dbname = 'ml_HRIS';
$link = mssql_connect($dbhost,$dbuser,$dbpass)or die('Error connecting to the SQL Server database.');
mssql_select_db($dbname,$link);

try{
	$now = date('Y-m-d H:i:s');
	$date_param = '2022-01-01';
	$nilai_cuti = '12';
    $query = "
        select emp_number, employee_id, DATEDIFF(DAY, joined_date, '".$date_param."') as diff, YEAR(joined_date) as years,joined_date
		FROM employee
		where termination_id IS NULL AND joined_date IS NOT NULL
		AND DATEDIFF(DAY, joined_date, '2022-01-01') >= '365'
    ";
    $result = mssql_query($query);
	
	if(mssql_num_rows($result) > 0){
		while($row = mssql_fetch_array($result)){
			$insert = "
				INSERT INTO leave_entitlement( emp_number, no_of_days, days_used, leave_type_id, from_date, to_date, credited_date, entitlement_type, created_by_id, created_by_name)
				VALUES('".$row['emp_number']."', '".$nilai_cuti."','0','1','2022-01-01 00:00:00', '2023-12-31 23:59:59', '".$now."', '1','1','System')
			";
			mssql_query($insert);
		}
	}
} catch (Exception $ex) {
    echo "Unsuccess with error ".$e;
}


?>