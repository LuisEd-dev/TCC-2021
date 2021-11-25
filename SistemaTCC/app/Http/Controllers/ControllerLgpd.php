<?php

namespace App\Http\Controllers;

use App\Models\LGPD;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerLgpd extends Controller
{
    public function confirmarLGPD(Request $request)
    {
        date_default_timezone_set('America/Sao_Paulo');

        DB::beginTransaction();
        $lgpd = new LGPD;
        $lgpd->tb_usuarios_usr_id = $request->usr_id;
        $lgpd->lgpd_data = date('Y-m-d H:i:s');
        $lgpd->save();
        DB::commit();

        $request->session()->put('lgpd', $lgpd->lgpd_id);
        return back();
    }
}
