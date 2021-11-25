@extends('layout')

@section('conteudo')

    <div class="container">

        <form action="{{ asset('painel/clientes/buscar') }}" method="POST">
            @csrf
            <div class="form-group row">
                <label for="inputFiltro" class="col-sm-1 col-form-label">Filtro:</label>
                <div class="col-sm-9">
                    <input value="{{ $request->inputFiltro }}" type="text" class="form-control" id="inputFiltro"
                        name="inputFiltro" placeholder="Nome/Email/Documento">
                </div>
                <button class="btn btn-primary col-sm-1" type="submit">Buscar</button>
                <button class="btn btn-secondary col-sm-1" onclick="document.querySelector('#inputFiltro').value = ''"
                    type="submit">Limpar</button>
            </div>
        </form>

        <div class="row d-flex flex-row-reverse">
            <a href="{{ asset('painel/clientes/adicionar') }}" class="btn btn-success"><i class="fas fa-user-plus"></i>
                Adicionar</a>
        </div>

        <h3 class="text-center mb-3">Clientes:</h3>

        <ul class="list-group ">
            <li class="list-group-item d-flex align-items-center">
                <div class="col col-3 text-center font-weight-bold ellipsis">
                    <span>Nome</span>
                </div>
                <div class="col col-3 text-center font-weight-bold ellipsis">
                    <span>Email</span>
                </div>
                <div class="col col-3 text-center font-weight-bold ellipsis">
                    <span>CPF/CNPJ</span>
                </div>
                <div class="col col-3 text-center font-weight-bold ellipsis">
                    <span>Opções</span>
                </div>
            </li>
            @foreach ($clientes as $cliente)
                <li class="list-group-item d-flex align-items-center">
                    <div class="col text-center ellipsis">
                        <span>{{ $cliente->cli_nome }}</span>
                    </div>
                    <div class="col text-center ellipsis">
                        <span>{{ $cliente->cli_email }}</span>
                    </div>
                    <div class="col text-center ellipsis">
                        <span>{{ $cliente->cli_cpf_cnpj }}</span>
                    </div>
                    <div class="col text-center">
                        <div style="word-spacing: 10px">
                            <a href="{{ asset("/painel/clientes/editar/$cliente->cli_id") }}"><i
                                    class=" text-warning fas fa-user-edit"></i></a>
                            <a href="#" data-toggle="modal" data-target="#modalCliente-{{ $cliente->cli_id }}"><i
                                    class=" text-danger fas fa-user-times"></i></a>
                        </div>
                    </div>
                </li>
                <!-- Modal -->
                <div class="modal fade" id="modalCliente-{{ $cliente->cli_id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Remover Cliente</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Tem certeza que deseja remover o cliente?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <a href="{{ asset("/painel/clientes/remover/$cliente->cli_id") }}" type="button"
                                    class="btn btn-primary">Confirmar</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>

    </div>


@endsection
