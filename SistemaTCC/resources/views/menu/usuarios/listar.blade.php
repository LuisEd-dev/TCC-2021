@extends('layout')

@section('conteudo')

    <div class="container">

        <form action="{{ asset('painel/usuarios/buscar') }}" method="POST">
            @csrf
            <div class="form-group row">
                <label for="inputFiltro" class="col-sm-1 col-form-label">Filtro:</label>
                <div class="col-sm-9">
                    <input value="{{ $request->inputFiltro }}" type="text" class="form-control" id="inputFiltro"
                        name="inputFiltro" placeholder="Nome/Email">
                </div>
                <button class="btn btn-primary col-sm-1" type="submit">Buscar</button>
                <button class="btn btn-secondary col-sm-1" onclick="document.querySelector('#inputFiltro').value = ''"
                    type="submit">Limpar</button>
            </div>
        </form>

        <div class="row d-flex flex-row-reverse">
            <a href="{{ asset('painel/usuarios/adicionar') }}" class="btn btn-success"><i class="fas fa-user-plus"></i>
                Adicionar</a>
        </div>

        <h3 class="text-center mb-3">Usuários:</h3>

        <ul class="list-group">

            <li class="list-group-item d-flex align-items-center">
                <div class="col col-3 text-center font-weight-bold ellipsis">
                    <span>Status</span>
                </div>
                <div class="col col-3 text-center font-weight-bold ellipsis">
                    <span>Nome</span>
                </div>
                <div class="col col-3 text-center font-weight-bold ellipsis">
                    <span>E-mail</span>
                </div>
                <div class="col col-3 text-center font-weight-bold ellipsis">
                    <span>Opções</span>
                </div>
            </li>
            @foreach ($usuarios as $usuario)

                <li class="list-group-item d-flex align-items-center">
                    <div class="col col-3 text-center ellipsis">
                        @if ($usuario->usr_status == 'A')
                            Ativo <i class="text-primary fas fa-user"></i>
                        @elseif ($usuario->usr_status == "I")
                            Inativo <i class="text-danger fas fa-user-slash"></i>
                        @endif
                    </div>
                    <div class="col col-3 text-center ellipsis">
                        <span>{{ $usuario->usr_nome }}</span>
                    </div>
                    <div class="col col-3 text-center ellipsis">
                        <span>{{ $usuario->usr_email }}</span>
                    </div>
                    <div class="col col-3 text-center">
                        <div style="word-spacing: 10px" class="text-nowrap">
                            <a href="{{ asset("/painel/usuarios/editar/$usuario->usr_id") }}"><i
                                    class="text-warning fas fa-user-edit"></i></a>
                            <a href="#" data-toggle="modal" data-target="#modalUsuario-{{ $usuario->usr_id }}"><i
                                    class="text-danger fas fa-user-times"></i></a>
                        </div>
                    </div>
                </li>

                <!-- Modal -->
                <div class="modal fade" id="modalUsuario-{{ $usuario->usr_id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Remover Usuário</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Tem certeza que deseja remover o usuário?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <a href="{{ asset("/painel/usuarios/remover/$usuario->usr_id") }}" type="button"
                                    class="btn btn-primary">Confirmar</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>

    </div>


@endsection
