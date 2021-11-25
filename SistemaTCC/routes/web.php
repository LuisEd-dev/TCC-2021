<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (Request $request) {
    if ($request->session()->has('usr_id')) {
        return redirect()->route('menu-principal');
    } else {
        return redirect()->route('login');
    }
})->name('home');

Route::get('/usuario/login', function (Request $request) {
    return view('login.login', compact('request'));
})->name('login');

Route::post('/usuario/login', [App\Http\Controllers\ControllerUsuario::class, 'autenticar']);

Route::get('/sair', function (Request $request) {
    $request->session()->flush();
    return redirect()->route('login');
});

Route::group(['middleware' => ['autenticacao']], function () {

    Route::get('/usuario/editar', function (Request $request) {
        return view('usuario.editar', compact('request'));
    })->name('editar-usuario');

    Route::get('/painel', [App\Http\Controllers\ControllerMenuPrincipal::class, 'menu'])->name('menu-principal');

    Route::get('/painel/usuarios', [App\Http\Controllers\ControllerUsuarios::class, 'listarUsuarios'])->name('menu-usuarios');
    Route::get('/painel/usuarios/adicionar', [App\Http\Controllers\ControllerUsuarios::class, 'telaAdicionarUsuario']);
    Route::post('/painel/usuarios/adicionar', [App\Http\Controllers\ControllerUsuarios::class, 'adicionarUsuario']);
    Route::get('/painel/usuarios/editar/{usr_id}', [App\Http\Controllers\ControllerUsuarios::class, 'telaEditarUsuarios']);
    Route::post('/painel/usuarios/editar/{usr_id}', [App\Http\Controllers\ControllerUsuarios::class, 'editarUsuarios']);
    Route::get('/painel/usuarios/remover/{usr_id}', [App\Http\Controllers\ControllerUsuarios::class, 'removerUsuarios']);
    Route::post('/painel/usuarios/buscar', [App\Http\Controllers\ControllerUsuarios::class, 'buscarUsuarios']);

    Route::get('/painel/clientes', [App\Http\Controllers\ControllerClientes::class, 'listarCliente'])->name('menu-clientes');
    Route::get('/painel/clientes/adicionar', [App\Http\Controllers\ControllerClientes::class, 'telaAdicionarCliente']);
    Route::post('/painel/clientes/adicionar', [App\Http\Controllers\ControllerClientes::class, 'adicionarCliente']);
    Route::get('/painel/clientes/editar/{cli_id}', [App\Http\Controllers\ControllerClientes::class, 'telaEditarCliente']);
    Route::post('/painel/clientes/editar/{cli_id}', [App\Http\Controllers\ControllerClientes::class, 'editarCliente']);
    Route::get('/painel/clientes/remover/{cli_id}', [App\Http\Controllers\ControllerClientes::class, 'removerCliente']);
    Route::post('/painel/clientes/buscar', [App\Http\Controllers\ControllerClientes::class, 'buscarCliente']);

    Route::get('/painel/fornecedores', [App\Http\Controllers\ControllerFornecedores::class, 'listarFornecedor'])->name('menu-fornecedores');
    Route::get('/painel/fornecedores/adicionar', [App\Http\Controllers\ControllerFornecedores::class, 'telaAdicionarFornecedor']);
    Route::post('/painel/fornecedores/adicionar', [App\Http\Controllers\ControllerFornecedores::class, 'adicionarFornecedor']);
    Route::get('/painel/fornecedores/editar/{for_id}', [App\Http\Controllers\ControllerFornecedores::class, 'telaEditarFornecedor']);
    Route::post('/painel/fornecedores/editar/{for_id}', [App\Http\Controllers\ControllerFornecedores::class, 'editarFornecedor']);
    Route::get('/painel/fornecedores/remover/{for_id}', [App\Http\Controllers\ControllerFornecedores::class, 'removerFornecedor']);
    Route::post('/painel/fornecedores/buscar', [App\Http\Controllers\ControllerFornecedores::class, 'buscarFornecedor']);

    Route::get('/painel/produtos', [App\Http\Controllers\ControllerProdutos::class, 'listarProduto'])->name('menu-produtos');
    Route::get('/painel/produtos/adicionar', [App\Http\Controllers\ControllerProdutos::class, 'telaAdicionarProduto']);
    Route::post('/painel/produtos/adicionar', [App\Http\Controllers\ControllerProdutos::class, 'adicionarProduto']);
    Route::get('/painel/produtos/editar/{prod_id}', [App\Http\Controllers\ControllerProdutos::class, 'telaEditarProduto']);
    Route::post('/painel/produtos/editar/{prod_id}', [App\Http\Controllers\ControllerProdutos::class, 'editarProduto']);
    Route::get('/painel/produtos/remover/{prod_id}', [App\Http\Controllers\ControllerProdutos::class, 'removerProduto']);
    Route::post('/painel/produtos/buscar', [App\Http\Controllers\ControllerProdutos::class, 'buscarProduto']);

    Route::get('/painel/insumos', [App\Http\Controllers\ControllerInsumos::class, 'listarInsumo'])->name('menu-insumos');
    Route::get('/painel/insumos/adicionar', [App\Http\Controllers\ControllerInsumos::class, 'telaAdicionarInsumo']);
    Route::post('/painel/insumos/adicionar', [App\Http\Controllers\ControllerInsumos::class, 'adicionarInsumo']);
    Route::get('/painel/insumos/editar/{ins_id}', [App\Http\Controllers\ControllerInsumos::class, 'telaEditarInsumo']);
    Route::post('/painel/insumos/editar/{ins_id}', [App\Http\Controllers\ControllerInsumos::class, 'editarInsumo']);
    Route::get('/painel/insumos/remover/{ins_id}', [App\Http\Controllers\ControllerInsumos::class, 'removerInsumo']);
    Route::post('/painel/insumos/buscar', [App\Http\Controllers\ControllerInsumos::class, 'buscarInsumo']);

    Route::get('/painel/vendas', [App\Http\Controllers\ControllerVendas::class, 'listarVenda'])->name('menu-vendas');
    Route::get('/painel/vendas/adicionar', [App\Http\Controllers\ControllerVendas::class, 'telaAdicionarVenda']);
    Route::post('/painel/vendas/adicionar', [App\Http\Controllers\ControllerVendas::class, 'adicionarVenda']);
    Route::get('/painel/vendas/editar/{ven_id}', [App\Http\Controllers\ControllerVendas::class, 'telaEditarVenda']);
    Route::post('/painel/vendas/editar/{ven_id}', [App\Http\Controllers\ControllerVendas::class, 'editarVenda']);
    Route::get('/painel/vendas/remover/{ven_id}', [App\Http\Controllers\ControllerVendas::class, 'removerVenda']);
    Route::post('/painel/vendas/buscar', [App\Http\Controllers\ControllerVendas::class, 'buscarVenda']);

    Route::post('/painel/produto_venda/adicionar/{ven_id}', [App\Http\Controllers\ControllerProdutosVenda::class, 'adicionarProdutoVenda']);
    Route::get('/painel/produto_venda/remover/{iven_id}', [App\Http\Controllers\ControllerProdutosVenda::class, 'removerProdutoVenda']);

    Route::post('/painel/insumos_produtos/adicionar/{ins_id}', [App\Http\Controllers\ControllerInsumosProdutos::class, 'adicionarInsumoProduto']);
    Route::get('/painel/insumos_produtos/remover/{insprod_id}', [App\Http\Controllers\ControllerInsumosProdutos::class, 'removerInsumoProduto']);

    Route::get('/lgpd/{usr_id}', [App\Http\Controllers\ControllerLgpd::class, 'confirmarLGPD'])->name('lgpd');

    Route::get('/backup', function () {
        include("../app/Http/Controllers/BackupDownload.php");
    })->name('backup');

    Route::get('/painel/contas_receber', [App\Http\Controllers\ControllerContasReceber::class, 'listarContaReceber'])->name('menu-contas-receber');
    Route::get('/painel/contas_receber/adicionar/{ven_id}', [App\Http\Controllers\ControllerContasReceber::class, 'telaAdicionarContaReceber']);
    Route::post('/painel/contas_receber/adicionar', [App\Http\Controllers\ControllerContasReceber::class, 'adicionarContaReceber']);
    Route::get('/painel/contas_receber/editar/{contr_id}', [App\Http\Controllers\ControllerContasReceber::class, 'telaEditarContaReceber']);
    Route::post('/painel/contas_receber/editar/{contr_id}', [App\Http\Controllers\ControllerContasReceber::class, 'editarContaReceber']);
    Route::get('/painel/contas_receber/remover/{ven_id}', [App\Http\Controllers\ControllerContasReceber::class, 'removerContaReceber']);
    Route::post('/painel/contas_receber/buscar', [App\Http\Controllers\ControllerContasReceber::class, 'buscarContaReceber']);
    Route::get('/painel/contas_receber/quitar/{contr_id}', [App\Http\Controllers\ControllerContasReceber::class, 'quitarContaReceber']);

    Route::get('/painel/compras', [App\Http\Controllers\ControllerCompras::class, 'listarCompra'])->name('menu-compras');
    Route::get('/painel/compras/adicionar', [App\Http\Controllers\ControllerCompras::class, 'telaAdicionarCompra']);
    Route::post('/painel/compras/adicionar', [App\Http\Controllers\ControllerCompras::class, 'adicionarCompra']);
    Route::get('/painel/compras/editar/{cmp_id}', [App\Http\Controllers\ControllerCompras::class, 'telaEditarCompra']);
    Route::post('/painel/compras/editar/{cmp_id}', [App\Http\Controllers\ControllerCompras::class, 'editarCompra']);
    Route::get('/painel/compras/remover/{cmp_id}', [App\Http\Controllers\ControllerCompras::class, 'removerCompra']);
    Route::post('/painel/compras/buscar', [App\Http\Controllers\ControllerCompras::class, 'buscarCompra']);

    Route::get('/painel/contas_pagar', [App\Http\Controllers\ControllerContasPagar::class, 'listarContaPagar'])->name('menu-contas-pagar');
    Route::get('/painel/contas_pagar/adicionar/{cmp_id}', [App\Http\Controllers\ControllerContasPagar::class, 'telaAdicionarContaPagar']);
    Route::post('/painel/contas_pagar/adicionar', [App\Http\Controllers\ControllerContasPagar::class, 'adicionarContaPagar']);
    Route::get('/painel/contas_pagar/editar/{contp_id}', [App\Http\Controllers\ControllerContasPagar::class, 'telaEditarContaPagar']);
    Route::post('/painel/contas_pagar/editar/{contp_id}', [App\Http\Controllers\ControllerContasPagar::class, 'editarContaPagar']);
    Route::get('/painel/contas_pagar/remover/{cmp_id}', [App\Http\Controllers\ControllerContasPagar::class, 'removerContaPagar']);
    Route::post('/painel/contas_pagar/buscar', [App\Http\Controllers\ControllerContasPagar::class, 'buscarContaPagar']);
    Route::get('/painel/contas_pagar/quitar/{contp_id}', [App\Http\Controllers\ControllerContasPagar::class, 'quitarContaPagar']);

    Route::post('/painel/insumo_compra/adicionar/{cmp_id}', [App\Http\Controllers\ControllerInsumosCompra::class, 'adicionarInsumosCompra']);
    Route::get('/painel/insumo_compra/remover/{icmp_id}', [App\Http\Controllers\ControllerInsumosCompra::class, 'removerInsumosCompra']);

    Route::get('/painel/agenda', [App\Http\Controllers\ControllerAgenda::class, 'listarAgenda'])->name('agenda');
    Route::get('/painel/agenda/adicionar', [App\Http\Controllers\ControllerAgenda::class, 'telaAdicionarAgenda']);
    Route::post('/painel/agenda/adicionar', [App\Http\Controllers\ControllerAgenda::class, 'adicionarAgenda']);
    Route::post('/painel/agenda/editar/{agd_id}', [App\Http\Controllers\ControllerAgenda::class, 'editarAgenda']);
    Route::get('/painel/agenda/remover/{agd_id}', [App\Http\Controllers\ControllerAgenda::class, 'removerAgenda']);
});
