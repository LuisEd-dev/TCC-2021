<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerAgenda extends Controller
{
    public function listarAgenda(Request $request)
    {
        setlocale(LC_ALL, "pt_BR", "pt_BR.iso-8859-1", "pt_BR.utf-8", "portuguese");
        date_default_timezone_set('America/Sao_Paulo');

        $agendas = Agenda::where('tb_usuarios_usr_id', '=', $request->session()->get('usr_id'))->get();

        $mesAtual = isset($request->mes) ? strtotime(date($request->mes)) : strtotime(date('Y-m-1'));
        $mesAnterior = strtotime(date('Y-m-d', strtotime('-1 months', $mesAtual)));
        $mesSeguinte = strtotime(date('Y-m-d', strtotime('+1 months', $mesAtual)));

        $dataInicio = strtotime('last sunday', $mesAtual);

        return view('menu.agenda.listar', compact(['request', 'mesAtual', 'mesAnterior', 'mesSeguinte', 'dataInicio', 'agendas']));
    }

    public function telaAdicionarAgenda(Request $request)
    {
        return view('menu.agenda.adicionar', ['request' => $request, 'data' => $request->data]);
    }

    public function adicionarAgenda(Request $request)
    {
        DB::beginTransaction();

        $agenda = new Agenda;
        $agenda->tb_usuarios_usr_id = $request->session()->get('usr_id');
        $agenda->agd_titulo = $request->titulo;
        $agenda->agd_descricao = $request->descricao;
        $agenda->agd_data = $request->data;
        $agenda->agd_cor = $request->cor;
        $agenda->save();

        DB::commit();

        return redirect()->route('agenda')->with('success', 'Evento adicionado à Agenda!');
    }

    public function editarAgenda(Request $request)
    {
        DB::beginTransaction();

        $agenda = Agenda::find($request->agd_id);
        $agenda->agd_titulo = $request->titulo;
        $agenda->agd_descricao = $request->descricao;
        $agenda->agd_cor = $request->cor;
        $agenda->save();

        DB::commit();

        return redirect()->back()->with('success', 'Evento alterado com sucesso!');
    }

    public function removerAgenda(Request $request)
    {
        DB::beginTransaction();
        Agenda::find($request->agd_id)->delete();
        DB::commit();

        return redirect()->back()->with('success', 'Evento removido da Agenda');
    }
}
