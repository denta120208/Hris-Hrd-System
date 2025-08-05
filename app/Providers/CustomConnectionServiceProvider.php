<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Database\CustomSqlServerConnection;
use Illuminate\Support\Facades\DB;

class CustomConnectionServiceProvider extends ServiceProvider {
    public function register() {
        $hostSqlsrv = config('database.connections.sqlsrv.host');
        $hostSqlsrv = preg_replace('/\\\\mlcrm/i', '', $hostSqlsrv);
        $portSqlsrv = env("DB_PORT");
        $databaseSqlsrv = config('database.connections.sqlsrv.database');
        $usernameSqlsrv = config('database.connections.sqlsrv.username');
        $passwordSqlsrv = config('database.connections.sqlsrv.password');
        $pdoSqlsrv = new \PDO("dblib:host=$hostSqlsrv:$portSqlsrv;dbname=$databaseSqlsrv", $usernameSqlsrv, $passwordSqlsrv);
        
        DB::extend('sqlsrv', function ($config, $name) use ($pdoSqlsrv) {
            return new CustomSqlServerConnection(
                $pdoSqlsrv,
                $config['database'],
                empty($config['prefix']) ? "" : $config['prefix'],
                $config
            );
        });
        
        $hostSqlsrv_sso = config('database.connections.sqlsrv_sso.host');
        $hostSqlsrv_sso = preg_replace('/\\\\mlcrm/i', '', $hostSqlsrv_sso);
        $portSqlsrv_sso = env("DB_PORT_SSO");
        $databaseSqlsrv_sso = config('database.connections.sqlsrv_sso.database');
        $usernameSqlsrv_sso = config('database.connections.sqlsrv_sso.username');
        $passwordSqlsrv_sso = config('database.connections.sqlsrv_sso.password');
        $pdoSqlsrv_sso = new \PDO("dblib:host=$hostSqlsrv_sso:$portSqlsrv_sso;dbname=$databaseSqlsrv_sso", $usernameSqlsrv_sso, $passwordSqlsrv_sso);
        
        DB::extend('sqlsrv_sso', function ($config, $name) use ($pdoSqlsrv_sso) {
            return new CustomSqlServerConnection(
                $pdoSqlsrv_sso,
                $config['database'],
                empty($config['prefix']) ? "" : $config['prefix'],
                $config
            );
        });
        
        $hostSqlsrv_adms = config('database.connections.adms.host');
        $hostSqlsrv_adms = preg_replace('/\\\\mlcrm/i', '', $hostSqlsrv_adms);
        $portSqlsrv_adms = env("DB_PORT_ADMS");
        $databaseSqlsrv_adms = config('database.connections.adms.database');
        $usernameSqlsrv_adms = config('database.connections.adms.username');
        $passwordSqlsrv_adms = config('database.connections.adms.password');
        $pdoSqlsrv_adms = new \PDO("dblib:host=$hostSqlsrv_adms:$portSqlsrv_adms;dbname=$databaseSqlsrv_adms", $usernameSqlsrv_adms, $passwordSqlsrv_adms);
        
        DB::extend('adms', function ($config, $name) use ($pdoSqlsrv_adms) {
            return new CustomSqlServerConnection(
                $pdoSqlsrv_adms,
                $config['database'],
                empty($config['prefix']) ? "" : $config['prefix'],
                $config
            );
        });
    }
}
