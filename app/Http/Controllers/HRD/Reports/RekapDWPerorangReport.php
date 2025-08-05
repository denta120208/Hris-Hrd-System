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

class RekapDWPerorangReport extends \koolreport\KoolReport {
    use \koolreport\laravel\Friendship;
    use \koolreport\export\Exportable;
    use \koolreport\excel\ExcelExportable;
    use \koolreport\cloudexport\Exportable;

    public $start_date_param = NULL;
    public $end_date_param = NULL;
    public $project_param = NULL;

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

        $this->rekapdwperorangantable1();
    }

    function rekapdwperorangantable1() {
        $node = $this->src('sqlDataSources');
        $node->query("
            EXEC sp_absen_employee_DW_summary @rt_start = :start_date, @rt_end = :end_date, @project_no = :project
        ")
        ->params(array(
            ":project"=>$this->params["project"],
            ":start_date"=>$this->params["start_date_param"],
            ":end_date"=>$this->params["end_date_param"]
        ))
        ->pipe(new Map(array(
            '{value}' => function($row, $metaData) {
                return array($row);
            },
        )))
        ->pipe($this->dataStore('rekap_dw_perorang_table1'));
    }
}