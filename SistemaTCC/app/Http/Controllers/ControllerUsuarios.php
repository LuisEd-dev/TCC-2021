<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ControllerUsuarios extends Controller
{
    public function listarUsuarios(Request $request)
    {
        return view('menu.usuarios.listar', ["usuarios" => Usuario::all(), "request" => $request]);
    }

    public function telaEditarUsuarios(Request $request)
    {
        return view('menu.usuarios.editar', ["usuario" => Usuario::where('usr_id', $request->usr_id)->first(), "request" => $request]);
    }

    public function editarUsuarios(Request $request)
    {
        DB::beginTransaction();
        if (Str::of($request->password)->trim()->isNotEmpty() && Str::of($request->confirmacao)->trim()->isNotEmpty()) {
            if ($request->password != $request->confirmacao) {
                return redirect()->back()->with('failed', 'As senhas informadas não são iguais!');
            } else {
                $usuario = Usuario::find($request->usr_id);
                $usuario->usr_nome = $request->nome;
                $usuario->usr_senha = $request->password;
                $usuario->usr_status = $request->status;
                $usuario->save();

                if ($usuario->usr_id == $request->session()->get("usr_id")) {
                    $request->session()->put('nome', $request->nome);
                }
            }
        } else {
            $usuario = Usuario::find($request->usr_id);
            $usuario->usr_nome = $request->nome;
            $usuario->usr_status = $request->status;
            $usuario->save();

            if ($usuario->usr_id == $request->session()->get("usr_id")) {
                $request->session()->put('nome', $request->nome);
            }
        }
        DB::commit();

        return redirect()->route('menu-usuarios')->with('success', 'Usuário alterado com sucesso!');
    }

    public function removerUsuarios(Request $request)
    {
        DB::beginTransaction();

        $usuario = Usuario::find($request->usr_id);
        $usuario->delete();

        if ($usuario->usr_id == $request->session()->get("usr_id")) {
            $request->session()->flush();
        }

        DB::commit();

        return redirect()->route('menu-usuarios')->with('success', 'Usuário removido com sucesso!');
    }

    public function buscarUsuarios(Request $request)
    {
        $usuarios = Usuario::where('usr_nome', 'LIKE', '%' . $request->inputFiltro . '%')
            ->orWhere('usr_email', 'LIKE', '%' . $request->inputFiltro . '%')
            ->get();

        return view('menu.usuarios.listar', ["usuarios" => $usuarios, "request" => $request]);
    }

    public function telaAdicionarUsuario(Request $request)
    {
        return view('menu.usuarios.adicionar', compact('request'));
    }

    public function adicionarUsuario(Request $request)
    {
        if ($request->password != null && $request->confirmacao != null) {
            if ($request->password == $request->confirmacao) {
                DB::beginTransaction();
                $usuario = new Usuario;
                $usuario->usr_nome = $request->nome;
                $usuario->usr_email = $request->email;
                $usuario->usr_senha = $request->confirmacao;
                $usuario->usr_status = $request->status;
                $usuario->save();
                DB::commit();

                return redirect()->route('menu-usuarios')->with('success', 'Usuário adicionado com sucesso!');
            } else {
                return redirect()->back()->with('failed', 'As senhas informadas não são iguais!');
            }
        }
    }
}
