<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\User;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Requests\BlogAddRequest;
use App\Http\Requests\BlogUpdateRequest;
use App\Http\Requests\LoginsUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

class UsersController extends Controller
{
    /*****Funcion getUser para obtener los datos en la seccion del usuario autenticado******/
    public function getUser(Request $request){
        /****decodificar los datos guardados en la seccion y devolverlos****/
        $token = unserialize(base64_decode($request->get('tok')));
        return response()->json(['name' => $token['user_name']." ".$token['user_apellido'],'email' => $token['user_email']]);
    }

    /***** fin funcion getUser ****/

    /******funciones para cambiar la conexion de los clientes**********/

    public function getUserDB(Request $request){
        $token = unserialize(base64_decode($request->get('tok')));
        $cliente = \DB::select('select a.*,b.* FROM clientes AS a INNER JOIN licencias AS b ON a.co_cli  = b.co_cli 
                                where a.borrado = 0 and b.borrado = 0 and a.email = :email',['email' => $token['user_email']]);

        \DB::disconnect();
        $connection = config('database.default');

        config([
            "database.connections.$connection.database" => $cliente[0]->dw_dbname,
            "database.connections.$connection.host" => $cliente[0]->dw_server,
            "database.connections.$connection.port" => $cliente[0]->dw_port,
            "database.connections.$connection.username" => $cliente[0]->dw_user,
            "database.connections.$connection.password" => $cliente[0]->dw_pass,
        ]);
        return response()->json(['name' => $token['user_name']." ".$token['user_apellido'],'email' => $token['user_email']]);
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

    /*******fin funciones para cambiar conexion de los cientes*****/

    /*****funcion getBlogs para listar los blogs *******/

    public function getBlogs(Request $request){
        $token = unserialize(base64_decode($request->get('tok')));
        $cliente = \DB::select('select a.*,b.* FROM clientes AS a INNER JOIN licencias AS b ON a.co_cli  = b.co_cli 
                                where a.borrado = 0 and b.borrado = 0 and a.email = :email',['email' => $token['user_email']]);

        $defaultConnection = $this->getDatabaseConfigArray();
        $this->setDatabaseFromClient($cliente[0]);
        $blogs = \DB::select('call ObtenerInformacionBlogs()');
        $this->setDatabaseFromArray($defaultConnection);
        $listado = [];
        $i = 0;
        foreach ($blogs as $blog) {
            $listado[$i] = [$blog->id,$blog->nombre,$blog->descripcion];
            $i++;
        }
        return response()->json($listado);
    }

    /******fin funcion getBlogs *********/

    /*****funcion getBlog para mostrarlos datos del blog en editar *******/

    public function getBlog(Request $request, $id)
    {
        $token = unserialize(base64_decode($request->get('tok')));
        $cliente = \DB::select('select a.*,b.* FROM clientes AS a INNER JOIN licencias AS b ON a.co_cli  = b.co_cli 
                                where a.borrado = 0 and b.borrado = 0 and a.email = :email',['email' => $token['user_email']]);

        $defaultConnection = $this->getDatabaseConfigArray();
        $this->setDatabaseFromClient($cliente[0]);
        $blog = \DB::select('call ObtenerInformacionBlog(?)',array($id));
        $this->setDatabaseFromArray($defaultConnection);

        return $blog;
    }

    /************fin funcion getBlog*********/

    /***********funcion updateblog para actualizar los datos del blog*****************/

    public function updateBlog(BlogUpdateRequest $request, $id)
    {
        $token = unserialize(base64_decode($request->input('tok')));
        $cliente = \DB::select('select a.*,b.* FROM clientes AS a INNER JOIN licencias AS b ON a.co_cli  = b.co_cli 
                                where a.borrado = 0 and b.borrado = 0 and a.email = :email',['email' => $token['user_email']]);

        $defaultConnection = $this->getDatabaseConfigArray();
        $this->setDatabaseFromClient($cliente[0]);
        \DB::update('update blog set nombre = :nombre, descripcion = :descripcion where id = :id', 
                            [
                                'nombre' => $request->input('nombre'),
                                'descripcion' => $request->input('descripcion'),
                                'id' => $id
                            ]);
        $this->setDatabaseFromArray($defaultConnection);

        return response()->json('Blog Actualizado', 200 );
    }

    /*************fin funcion update blog********************/

    /*************delete blog para elminar el blog seleccionado********************/

    public function deleteBlog(Request $request)
    {
        $token = unserialize(base64_decode($request->input('tok')));
        $cliente = \DB::select('select a.*,b.* FROM clientes AS a INNER JOIN licencias AS b ON a.co_cli  = b.co_cli 
                                where a.borrado = 0 and b.borrado = 0 and a.email = :email',['email' => $token['user_email']]);

        $defaultConnection = $this->getDatabaseConfigArray();
        $this->setDatabaseFromClient($cliente[0]);
        \DB::delete('delete from blog where id = :id', ['id' => $request->input('id')]);
        $this->setDatabaseFromArray($defaultConnection);

        return response()->json('Blog Eliminado', 200 );
    }

    /**************fin delete blog******************/

    /**************create blog para crear un blog*****************/

    public function createBlog(BlogAddRequest $request)
    {
        $token = unserialize(base64_decode($request->input('tok')));
        $cliente = \DB::select('select a.*,b.* FROM clientes AS a INNER JOIN licencias AS b ON a.co_cli  = b.co_cli 
                                where a.borrado = 0 and b.borrado = 0 and a.email = :email',['email' => $token['user_email']]);

        $defaultConnection = $this->getDatabaseConfigArray();
        $this->setDatabaseFromClient($cliente[0]);
        \DB::insert('insert into blog (nombre, descripcion) values (:nombre, :descripcion)', ['nombre' => $request->input('nombre'), 'descripcion' => $request->input('descripcion')]);
        $this->setDatabaseFromArray($defaultConnection);
        
        return response()->json('Blog creado', 200 );
    }

    /*************fin crear blog**********************/

    /**************funcion logins para la autenticacion de los usuarios***********************/

    public function logins(LoginsUserRequest $request) {

        $client = \DB::select('call ObtenerInformacionClientes(?,?)',array($request->get('email'),hash( 'sha256', $request->get('password') )));

        if($client == null)
            return response()->json( ['logins' => "Usuario y/o clave incorrecta"], 401 );
        else if($client[0]->usuarioInactivo == 1 ){
            return response()->json( ['logins' => "Usuario inactivo comuníquese con soporte"], 500 );
        }
        else
        {
            /********codificar los datos del usuario autenticado en una seccion*******************/
            return response()->json( [
                'token' => base64_encode(serialize([
                    '_token' => $request->header('X-CSRF-TOKEN'), 
                    'expires_in' => Carbon::now()->subMinutes(120)->getTimestamp(),
                    'user_id' => $client[0]->id,
                    'user_name' => $client[0]->nombre,
                    'user_apellido' => $client[0]->apellido,
                    'user_email' => $client[0]->email]))
                    
                ], 200 );
        }
    }

    /******************fin logins**************************/

    /******************get licencia para obtener los dias que le quedan a la licencia*******************/
    public function getLicencia(Request $request){
        $token = unserialize(base64_decode($request->get('tok')));
        $cliente = \DB::select('select a.*,b.*,c.* FROM clientes AS a INNER JOIN licencias AS b ON a.co_cli  = b.co_cli 
                                INNER JOIN licenciasDetalle AS c ON b.id = c.id_licencia 
                                where a.borrado = 0 and b.borrado = 0 and c.borrado = 0 and a.email = :email',['email' => $token['user_email']]);
        $hoy = Carbon::now();
        $licencia = Carbon::parse($cliente[0]->fe_fin);
        $diff = $hoy->diffInDays($licencia);
        return response()->json($diff);
    }

    /******************fin get licencia***************************/
}
