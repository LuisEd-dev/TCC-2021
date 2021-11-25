<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ControllerUsuario extends Controller
{
    public function autenticar(Request $request)
    {

        $usuario = Usuario::where('usr_email', '=', $request->email)->where("usr_senha", "=", $request->password)->where("usr_status", "=", "A")->first();

        if ($usuario == null || !$usuario->exists()) {
            return view('login.nao_encontrado', compact('request'));
        } else {
            $request->session()->put('usr_id', $usuario->usr_id);
            $request->session()->put('nome', $usuario->usr_nome);

            if ($usuario->lgpd != null) {
                $request->session()->put('lgpd', $usuario->lgpd->lgpd_id);
            }

            include("BackupServer.php");
            return redirect()->route('menu-principal');
        }
    }

}
