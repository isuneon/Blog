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

    public function getUser(Request $request){
        $token = unserialize(base64_decode($request->get('tok')));
        return response()->json(['name' => $token['user_name']." ".$token['user_apellido'],'email' => $token['user_email']]);
    }

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

    public function logins(LoginsUserRequest $request) {

        $client = \DB::select('call ObtenerInformacionClientes(?,?)',array($request->get('email'),hash( 'sha256', $request->get('password') )));

        if($client == null)
            return response()->json( ['logins' => "Usuario y/o clave incorrecta"], 401 );
        else if($client[0]->usuarioInactivo == 1 ){
            return response()->json( ['logins' => "Usuario inactivo comuníquese con soporte"], 500 );
        }
        else
        {
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
}
