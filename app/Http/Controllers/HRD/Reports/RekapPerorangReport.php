<?php

namespace App\Http\Controllers\HRD\Reports;
use \koolreport\processes\Filter;
use \koolreport\processes\ColumnMeta;
use \koolreport\pivot\processes\Pivot;
use \koolreport\processes\Map;
use \koolreport\processes\Sort;
use \koolreport\processes\CalculatedColumn;
use \koolreport\processes\AggregatedColumn;
use \koolreport\processes\Transpose;
use \koolreport\processes\Transpose2;
use \koolreport\processes\ColumnRename;
use \koolreport\processes\Group;
use \koolreport\processes\RemoveColumn;
use DateTime;
use DB;

require_once dirname(__FILE__)."/../../../../../vendor/koolreport/core/autoload.php";

class RekapPerorangReport extends \koolreport\KoolReport {
    use \koolreport\laravel\Friendship;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    use \koolreport\cloudexport\Exportable;

    public $start_date_param = NULL;
    public $end_date_param = NULL;
    public $project_param = NULL;
    public $employee_param = NULL;
    public $nik_param = NULL;
    public $where_param = "";

    function settings()
    {
        $host = env('DB_HOST');
        $database = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        // return array(
        //     "dataSources"=>array(
        //         "sqlDataSources"=>array(
        //             "connectionString"=>"sqlsrv:Server = $host;Database = $database;Encrypt = true;TrustServerCertificate = true;",
        //             "username"=>$username,
        //             "password"=>$password
        //         ),
        //     )
        // );

        return array(
            "dataSources"=>array(
                "sqlDataSources"=>array(
                    "connectionString"=>"dblib:host=$host;dbname=$database;Encrypt=true;TrustServerCertificate=true;",
                    "username"=>$username,
                    "password"=>$password,
                    "charset"=>"utf8"
                ),
            )
        );

        // return array(
        //     "dataSources" => array(
        //         "sqlDataSources"=>array(
        //             'host' => ''.$host.'',
        //             'username' => ''.$username.'',
        //             'password' => ''.$password.'',
        //             'dbname' => ''.$database.'',
        //             'class' => "\koolreport\datasources\SQLSRVDataSource"
        //         ),
        //     )
        // );
    }

    function setup()
    {
        $this->start_date_param = $this->params["start_date_param"];
        $this->end_date_param = $this->params["end_date_param"];        
        $this->project_param = $this->params["project"];
        $this->employee_param = $this->params["employee"];
        $this->nik_param = $this->params["nik"];

        if ($this->start_date_param <> '' && $this->end_date_param <> '') {
            $this->where_param .= "and b.comDate between '".$this->start_date_param."' and '".$this->end_date_param."'";
        }

        if ($this->employee_param <> '') {
//            $this->where_param .= "and (a.emp_firstname+' '+a.emp_middle_name+' '+a.emp_lastname) like '%".$this->employee_param."%'";
        }

        if ($this->nik_param <> '') {
            $this->where_param .= "and b.comNIP = '".$this->nik_param."'";
        }

        if ($this->project_param > 0) {
            $this->where_param .= "and a.location_id = ".$this->project_param."";
        }

        $this->rekapperorangantable1();
    }

    function rekapperorangantable1() {
        $node = $this->src('sqlDataSources');
//        $node->query("
//            ;with t1 as (
//                select b.comNIP,(a.emp_firstname+' '+a.emp_middle_name+' '+a.emp_lastname) as comDisplayName,
//                FORMAT (b.comDate, 'yyyy-MM-dd') as comDate,
//                convert(char(8),convert(time(0),b.comIn)) as comIn,
//                convert(char(8),convert(time(0),b.comOut)) as comOut,
//                b.comIjin,termination_id,(DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1) AS workingHours, a.job_title_code,
//                FORMAT (cast(b.comDate as date), 'dddd') AS HARI,
//                CASE WHEN (FORMAT (cast(b.comDate as date), 'dddd') = 'Saturday' OR FORMAT (cast(b.comDate as date), 'dddd') = 'Sunday') AND a.job_title_code <= 4 AND b.is_claim_ot = 1
//                    THEN 1
//                WHEN (FORMAT (cast(b.comDate as date), 'dddd') = 'Saturday' OR FORMAT (cast(b.comDate as date), 'dddd') = 'Sunday') AND a.job_title_code > 4 AND DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) >= 4
//                    THEN 1
//                WHEN ((a.job_title_code = '11' OR a.job_title_code = '12' OR a.job_title_code = '13' OR a.job_title_code = '14' OR a.job_title_code = '15' OR a.job_title_code = '16' OR a.job_title_code = '17' OR a.job_title_code = '18') AND (b.comIjin IS NULL OR b.comIjin = '')) -- VICE GENERAL MANAGER Ke Atas
//                    THEN 1
//                WHEN (b.comIjin IS NULL OR b.comIjin = '') AND b.comIn <= '09:00:00' AND ((DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1) < 8 AND (DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1) >= 0)
//                    THEN 1
//                WHEN b.comIjin = 'CT CS'
//                    THEN 0.5
//                WHEN b.comIjin = 'CB' OR b.comIjin = 'CB CS' OR b.comIjin = 'TL' OR b.comIjin = 'PV' OR b.comIjin = 'L'
//                    THEN 1
//                WHEN ((b.comIjin IS NULL OR b.comIjin = '') AND b.comIn <= '09:00:00' AND (DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1) >= 8)
//                    THEN 1
//                ELSE
//                    0
//                END
//                AS hadir,
//                CASE WHEN b.comIjin = 'CT CS' OR b.comIjin = 'CB CS'
//                    THEN 0.5
//                ELSE
//                    1
//                END
//                AS hitung
//                from employee as a LEFT JOIN com_absensi_inout as b ON trim(a.employee_id) = b.comNIP
//                where a.termination_id = 0
//                and b.comNIP IS NOT NULL
//                and a.emp_status IN (1,2,5)
//                ".$this->where_param."
//            )
//
//            select b.comNIP,(a.emp_firstname+' '+a.emp_middle_name+' '+a.emp_lastname) as comDisplayName,COUNT(b.comNIP) AS JUMLAH_HARI,
//            (SELECT ISNULL(SUM(hadir), 0) FROM t1 WHERE comNIP = b.comNIP) AS TOTAL_KEHADIRAN,
//            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE (comIjin IS NULL OR comIjin = '') AND comNIP = b.comNIP AND workingHours < 8 AND HARI NOT IN ('Saturday','Sunday')) AS LESS_8_HOUR,
//            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'S' AND comNIP = b.comNIP) AS S,
//            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'I' AND comNIP = b.comNIP) AS I,
//            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'TL' AND comNIP = b.comNIP) AS TL,
//            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE (comIjin = 'CT' OR comIjin = 'CT CS') AND comNIP = b.comNIP) AS CT,
//            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'L' AND comNIP = b.comNIP) AS L,
//            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'CL' AND comNIP = b.comNIP) AS CL,
//            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE (comIjin = 'CB' OR comIjin = 'CB CS') AND comNIP = b.comNIP) AS CB,
//            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'OFF' AND comNIP = b.comNIP) AS [OFF],
//            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'CS' AND comNIP = b.comNIP) AS CS,
//            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'CH' AND comNIP = b.comNIP) AS CH,
//            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'CK' AND comNIP = b.comNIP) AS CK,
//            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'PV' AND comNIP = b.comNIP) AS PV
//            from employee as a LEFT JOIN com_absensi_inout as b ON trim(a.employee_id) = b.comNIP
//            where a.termination_id = 0
//            and b.comNIP IS NOT NULL
//            and a.emp_status IN (1,2,5)
//            ".$this->where_param."
//            GROUP BY b.comNIP, a.emp_firstname, a.emp_middle_name, a.emp_lastname, a.job_title_code
//            ORDER BY b.comNIP
//        ")
        $node->query("
            ;with t1 as (
                select b.comNIP,a.emp_firstname,a.emp_middle_name,a.emp_lastname,
                FORMAT (b.comDate, 'yyyy-MM-dd') as comDate,
                convert(char(8),convert(time(0),b.comIn)) as comIn,
                convert(char(8),convert(time(0),b.comOut)) as comOut,
                b.comIjin,termination_id,(DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1) AS workingHours, a.job_title_code,
                FORMAT (cast(b.comDate as date), 'dddd') AS HARI,
                CASE WHEN (FORMAT (cast(b.comDate as date), 'dddd') = 'Saturday' OR FORMAT (cast(b.comDate as date), 'dddd') = 'Sunday') AND a.job_title_code <= 4 AND b.is_claim_ot = 1
                    THEN 1
                WHEN (FORMAT (cast(b.comDate as date), 'dddd') = 'Saturday' OR FORMAT (cast(b.comDate as date), 'dddd') = 'Sunday') AND a.job_title_code > 4 AND DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) >= 4
                    THEN 1
                WHEN ((a.job_title_code = '11' OR a.job_title_code = '12' OR a.job_title_code = '13' OR a.job_title_code = '14' OR a.job_title_code = '15' OR a.job_title_code = '16' OR a.job_title_code = '17' OR a.job_title_code = '18') AND (b.comIjin IS NULL OR b.comIjin = '')) -- VICE GENERAL MANAGER Ke Atas
                    THEN 1
                WHEN (b.comIjin IS NULL OR b.comIjin = '') AND b.comIn <= '09:00:00' AND ((DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1) < 8 AND (DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1) >= 0)
                    THEN 1
                WHEN b.comIjin = 'CT CS'
                    THEN 0.5
                WHEN b.comIjin = 'CB' OR b.comIjin = 'CB CS' OR b.comIjin = 'TL' OR b.comIjin = 'PV' OR b.comIjin = 'L'
                    THEN 1
                WHEN ((b.comIjin IS NULL OR b.comIjin = '') AND b.comIn <= '09:00:00' AND (DATEPART(HOUR, CONVERT(TIME, b.comTotalHours)) - 1) >= 8)
                    THEN 1
                ELSE
                    0
                END
                AS hadir,
                CASE WHEN b.comIjin = 'CT CS' OR b.comIjin = 'CB CS'
                    THEN 0.5
                ELSE
                    1
                END
                AS hitung
                from employee as a LEFT JOIN com_absensi_inout as b ON trim(a.employee_id) = b.comNIP
                where a.termination_id = 0
                and b.comNIP IS NOT NULL
                and a.emp_status IN (1,2,5)
                ".$this->where_param."
            )

            select b.comNIP,a.emp_firstname,a.emp_middle_name,a.emp_lastname,COUNT(b.comNIP) AS JUMLAH_HARI,
            (SELECT ISNULL(SUM(hadir), 0) FROM t1 WHERE comNIP = b.comNIP) AS TOTAL_KEHADIRAN,
            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE (comIjin IS NULL OR comIjin = '') AND comNIP = b.comNIP AND workingHours < 8 AND HARI NOT IN ('Saturday','Sunday')) AS LESS_8_HOUR,
            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'S' AND comNIP = b.comNIP) AS S,
            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'I' AND comNIP = b.comNIP) AS I,
            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'TL' AND comNIP = b.comNIP) AS TL,
            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE (comIjin = 'CT' OR comIjin = 'CT CS') AND comNIP = b.comNIP) AS CT,
            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'L' AND comNIP = b.comNIP) AS L,
            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'CL' AND comNIP = b.comNIP) AS CL,
            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE (comIjin = 'CB' OR comIjin = 'CB CS') AND comNIP = b.comNIP) AS CB,
            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'OFF' AND comNIP = b.comNIP) AS [OFF],
            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'CS' AND comNIP = b.comNIP) AS CS,
            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'CH' AND comNIP = b.comNIP) AS CH,
            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'CK' AND comNIP = b.comNIP) AS CK,
            (SELECT ISNULL(SUM(hitung), 0) FROM t1 WHERE comIjin = 'PV' AND comNIP = b.comNIP) AS PV
            from employee as a LEFT JOIN com_absensi_inout as b ON trim(a.employee_id) = b.comNIP
            where a.termination_id = 0
            and b.comNIP IS NOT NULL
            and a.emp_status IN (1,2,5)
            ".$this->where_param."
            GROUP BY b.comNIP, a.emp_firstname, a.emp_middle_name, a.emp_lastname, a.job_title_code
            ORDER BY b.comNIP
        ")
        ->pipe(new Map(array(
            '{value}' => function($row, $metaData) {
            
                $emp_name = '';
//               dd($row);
                if($row['emp_firstname'] != ''){
                    $emp_name .= $row['emp_firstname'];
                }
                if($row['emp_middle_name'] != ''){
                    $emp_name .= ' '.$row['emp_middle_name'];
                }
                if($row['emp_lastname'] != ''){
                    $emp_name .= ' '.$row['emp_lastname'];
                }
                $row['comDisplayName'] = $emp_name;
                if($this->employee_param != ''){
                    if(str_contains(strtolower($emp_name),strtolower($this->employee_param))) {
                        return array($row);
                    }
                }else{
                    return array($row);
                }  
            },
        )))
        ->pipe($this->dataStore('rekap_perorang_table1'));
    }
}