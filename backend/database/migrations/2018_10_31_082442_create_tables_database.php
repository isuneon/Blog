<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTablesDatabase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $clientes = \DB::select('select a.*,b.* FROM clientes AS a INNER JOIN licencias AS b ON a.co_cli  = b.co_cli where a.borrado = 0 and b.borrado = 0');
        $defaultConnection = $this->getDatabaseConfigArray();
        foreach ($clientes as $cliente) {
            $this->setDatabaseFromClient($cliente);
            Schema::create('blog', function (Blueprint $table) {
                $table->increments('id');
                $table->string('nombre', 100);
                $table->string('descripcion', 255);
            });
            \DB::unprepared("DROP PROCEDURE IF EXISTS `ObtenerInformacionBlog`;
                            CREATE PROCEDURE `ObtenerInformacionBlog`(IN idBlog INTEGER(11))
                            NOT DETERMINISTIC
                            SQL SECURITY DEFINER
                            COMMENT ''
                            BEGIN
                                SELECT * from `blog` WHERE id = idBlog;
                            END;");
            \DB::unprepared("DROP PROCEDURE IF EXISTS `ObtenerInformacionBlogs`;
                            CREATE PROCEDURE `ObtenerInformacionBlogs`()
                            NOT DETERMINISTIC
                            SQL SECURITY DEFINER
                            COMMENT ''
                            BEGIN
                                SELECT * FROM `blog`;
                            END;");
            $this->setDatabaseFromArray($defaultConnection);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $clientes = \DB::select('select a.*,b.* FROM clientes AS a INNER JOIN licencias AS b ON a.co_cli  = b.co_cli where a.borrado = 0 and b.borrado = 0');
        $defaultConnection = $this->getDatabaseConfigArray();
        foreach ($clientes as $cliente) {
            $this->setDatabaseFromClient($cliente);
            Schema::dropIfExists('blog');
            \DB::unprepared("DROP PROCEDURE IF EXISTS `ObtenerInformacionBlog`;");
            \DB::unprepared("DROP PROCEDURE IF EXISTS `ObtenerInformacionBlogs`;");
            $this->setDatabaseFromArray($defaultConnection);
        }
        
    }

    public static function getDatabaseConfigArray()
    {
        $connection = config('database.default');

        return [
            'host' => config("database.connections.$connection.host"),
            'port' => config("database.connections.$connection.port"),
            'username' => config("database.connections.$connection.username"),
            'password' => config("database.connections.$connection.password"),
            'database' => config("database.connections.$connection.database"),
        ];
    }

    public static function setDatabaseFromClient($client)
    {
        \DB::disconnect();
        self::setDatabase($client->dw_server, $client->dw_port, $client->dw_user, $client->dw_pass, $client->dw_dbname,true);
    }

    public static function setDatabase($host, $port, $username, $password, $database_name)
    {
        $connection = config('database.default');

        config([
            "database.connections.$connection.database" => $database_name,
            "database.connections.$connection.host" => $host,
            "database.connections.$connection.port" => $port,
            "database.connections.$connection.username" => $username,
            "database.connections.$connection.password" => $password,
        ]);
    }

    public static function setDatabaseFromArray($array)
    {
        self::setDatabase($array['host'], $array['port'], $array['username'], $array['password'], $array['database'], true);
        \DB::disconnect();
    }
}
