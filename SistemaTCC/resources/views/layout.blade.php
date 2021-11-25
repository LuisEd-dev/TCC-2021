<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Suco do Artur - Sistema</title>
    <link rel="stylesheet" href="{{ asset('src/css/app.css') }}">
    <link href="{{ asset('src/css/bootstrap.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/8411b7fba2.js" crossorigin="anonymous"></script>
    <script src="{{ asset('src/js/jquery.js') }}"></script>
    <link rel="icon" href="{{ asset('images/icon.png') }}">

</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="modalLGPD" tabindex="-1" role="dialog" aria-labelledby="modalLGPDLabel"
        aria-hidden="true" @if ($request->session()->has('usr_id') && !$request->session()->has('lgpd')) data-backdrop="static" @endif>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLGPDLabel">Lei Geral de Proteção de Dados Pessoais</h5>
                </div>
                <div class="modal-body">
                    <strong> Termo de Consentimento de Uso de Dados</strong> <br>

                    O Cliente fica ciente e autoriza a coleta, o armazenamento, o uso, a recepção, o acesso, o
                    processamento e o arquivamento dos dados pessoais solicitados.<br>

                    Também autoriza que seus dados pessoais sejam utilizados pela área Comercial da empresa
                    Idealize.<br>

                    O cliente poderá entrar em contato com o (DPO) dpo@idealize.com.br, para solicitar a remoção de seus
                    dados ou vir pessoalmente à sede da empresa.
                </div>
                <div class="modal-footer">
                    @if ($request->session()->has('usr_id') && !$request->session()->has('lgpd'))
                        <a type="button" class="btn btn-primary"
                            href="{{ asset('/lgpd/' . $request->session()->get('usr_id') . '') }}">Aceitar</a>
                        <a type="button" class="btn btn-danger" href="{{ asset('/sair') }}">Sair</a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark h-100 d-flex justify-content-between sticky-top">
        @if ($request->session()->has('usr_id'))
            <div class="col col-12 col-md-1 d-flex justify-content-center justify-content-md-start"><button
                    class="btn btn-secondary btn-block" onclick="openNav()"><em class="fas fa-bars"></em></button>
            </div>
            <div class="col col-12 col-md-4 offset-md-3 d-flex justify-content-center"><a class="navbar-brand"
                    href="{{ asset('/') }}">Suco do
                    Artur </a></div>
            <div class="col col-12 col-md-4 d-flex justify-content-center justify-content-md-end">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle btn-block" type="button" id="dropdownMenuButton"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <em class="far fa-user-circle"></em> {{ substr($request->session()->get('nome'), 0, 20) }}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        @php
                            $idUsuario = $request->session()->get('usr_id');
                        @endphp
                        <a class="dropdown-item" href={{ asset("painel/usuarios/editar/$idUsuario") }}>Editar</a>
                        <a class="dropdown-item" style="color: red; font-weight: bold;"
                            href="{{ asset('/sair') }}">Sair</a>
                    </div>
                </div>
            </div>
        @else
            <a class="navbar-brand" href="{{ asset('/') }}">Suco do Artur </a>
            <div><a class="btn btn-outline-success" href="{{ asset('usuario/login') }}">Entrar</a></div>
        @endif
    </nav>

    <div id="main">
        <div id="mySidenav" class="sidenav">
            <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"
                style="text-decoration: none">&times;</a>
            <a href="{{ asset('/') }}">Painel</a>
            <a href="{{ asset('painel/agenda') }}">Agenda</a>
            <hr style="background-color: #818181">
            <a href="{{ asset('painel/usuarios') }}">Usuários</a>
            <a href="{{ asset('painel/clientes') }}">Clientes</a>
            <a href="{{ asset('painel/fornecedores') }}">Fornecedores</a>
            <a href="{{ asset('painel/insumos') }}">Insumos</a>
            <a href="{{ asset('painel/produtos') }}">Produtos</a>
            <hr style="background-color: #818181">
            <a href="{{ asset('painel/vendas') }}">Vendas</a>
            <a href="{{ asset('painel/compras') }}">Compras</a>
            <hr style="background-color: #818181">
            <a href="{{ asset('painel/contas_receber') }}" class="text-nowrap">Contas a Receber</a>
            <a href="{{ asset('painel/contas_pagar') }}" class="text-nowrap">Contas a Pagar</a>
            <hr style="background-color: #818181">
            <a href="{{ asset('/backup') }}">Backup</a>
            <a href="#" onclick="showModal()" class="text-nowrap">LGPD</a>
        </div>

        @if ($message = Session::get('success'))
            <div class="col col-10 offset-1 col-md-6 offset-md-3 alert alert-success alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif
        @if ($message = Session::get('failed'))
            <div class="col col-6 offset-3 alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                <strong>{{ $message }}</strong>
            </div>
        @endif

        @yield('conteudo')
    </div>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">Realizado por <a href="https://forticorp.com.br/idealize/">Idealize &copy;</a></p>
        <p> 2021 </p>
    </footer>

</body>

<script src="{{ asset('src/js/bootstrap.js') }}"></script>
<script src="{{ asset('src/js/main.js') }}"></script>
<script src="{{ asset('src/js/mask.js') }}"></script>

@if ($request->session()->has('usr_id') && !$request->session()->has('lgpd'))
    <script>
        $(document).ready(showModal());
    </script>
@endif

<script>
    $(function() {
        $('[data-toggle="popover"]').popover()
    })
</script>

</html>
