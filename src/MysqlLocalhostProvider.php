<?php

namespace Mdhesari\MysqlLocalhost;

use Exception;
use Illuminate\Support\ServiceProvider;
use PDO;

class MysqlLocalhostProvider extends ServiceProvider
{
    public function boot(): void
    {
        dd('hello from mysql host');
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'mysql-localhost');

        if ($this->app->environment(['local', 'testing'])) {
            $connection = config('database.default');
            if ($connection == 'mysql') {
                $config = config('database.connections.mysql');
                try {

                    new PDO(sprintf("mysql:dbname=%s;host=%s;port=%s", $config['database'], $config['host'], $config['port']), $config['username'], $config['password']);
                } catch (Exception $e) {
                    config(['database.connections.mysql.host' => '127.0.0.1']);
                }
            }
        }
    }
}