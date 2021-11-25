@extends('layout')

@section('conteudo')

    <div class="container">

        <form action="{{ asset('painel/insumos/buscar') }}" method="POST">
            @csrf
            <div class="form-group row">
                <label for="inputFiltro" class="col-sm-1 col-form-label">Filtro:</label>
                <div class="col-sm-9">
                    <input value="{{ $request->inputFiltro }}" type="text" class="form-control" id="inputFiltro"
                        name="inputFiltro" placeholder="Nome/Descrição">
                </div>
                <button class="btn btn-primary col-sm-1" type="submit">Buscar</button>
                <button class="btn btn-secondary col-sm-1" onclick="document.querySelector('#inputFiltro').value = ''"
                    type="submit">Limpar</button>
            </div>
        </form>

        <div class="row d-flex flex-row-reverse">
            <a href="{{ asset('painel/insumos/adicionar') }}" class="btn btn-success"><i class="fas fa-user-plus"></i>
                Adicionar</a>
        </div>

        <h3 class="text-center mb-3">Insumos:</h3>

        <ul class="list-group ">

            <li class="list-group-item d-flex align-items-center">
                <div class="col col-3 text-center font-weight-bold ellipsis">
                    <span>Nome</span>
                </div>
                <div class="col col-2 text-center font-weight-bold ellipsis">
                    <span>Preço</span>
                </div>
                <div class="col col-2 text-center font-weight-bold ellipsis">
                    <span>Estoque</span>
                </div>
                <div class="col col-2 text-center font-weight-bold ellipsis">
                    <span>Consumo</span>
                </div>
                <div class="col col-3 text-center font-weight-bold ellipsis">
                    <span>Opções</span>
                </div>
            </li>

            @foreach ($insumos as $insumo)
                <li class="list-group-item d-flex align-items-center">

                    <div class="col col-3 text-center ellipsis">
                        <span>{{ $insumo->ins_nome }}</span>
                    </div>
                    <div class="col col-2 text-center ellipsis">
                        <span>R$ {{ number_format($insumo->ins_preco, 2, ',', '.') }}</span>
                    </div>
                    <div class="col col-2 text-center ellipsis">
                        <span>{{ $insumo->ins_estoque }}</span>
                    </div>
                    <div class="col col-2 text-center ellipsis">
                        <span>{{ $insumo->ins_consumo }}</span>
                    </div>
                    <div class="col col-3 text-center">
                        <div style="word-spacing: 10px">
                            <a href="{{ asset("/painel/insumos/editar/$insumo->ins_id") }}"><i
                                    class="text-warning fas fa-user-edit"></i></a>
                            <a href="#" data-toggle="modal" data-target="#modalInsumo-{{ $insumo->ins_id }}"><i
                                    class="text-danger fas fa-user-times"></i></a>
                        </div>
                    </div>

                </li>
                <!-- Modal -->
                <div class="modal fade" id="modalInsumo-{{ $insumo->ins_id }}" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Remover Insumo</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                Tem certeza que deseja remover o insumo?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                <a href="{{ asset("/painel/insumos/remover/$insumo->ins_id") }}" type="button"
                                    class="btn btn-primary">Confirmar</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </ul>

    </div>


@endsection
