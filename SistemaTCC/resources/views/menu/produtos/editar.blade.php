@extends('layout')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col col-12">

                <h1 class="text-center"><strong>Alterar Produto</strong></h1>
                <form action="{{ asset("painel/produtos/editar/$produto->prod_id") }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="nomeProduto" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nomeProduto" name="nome" placeholder="Nome do Produto"
                            value="{{ $produto->prod_nome }}" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="vendaProduto" class="form-label">Preço Venda</label>
                        <input type="text" class="form-control money" id="vendaProduto" name="venda"
                            placeholder="Preço de Venda" value="{{ $produto->prod_preco_venda }}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="custoProduto" class="form-label">Preço Custo</label>
                        <input type="text" class="form-control money" id="custoProduto" name="custo"
                            placeholder="Preço de Custo" value="{{ $produto->prod_preco_custo }}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="descricaoProduto" class="form-label">Descrição</label>
                        <textarea type="text" class="form-control" id="descricaoProduto" name="descricao"
                            placeholder="Descrição do Produto" maxlength="255"
                            required> {{ $produto->prod_descricao }}</textarea>
                    </div>

                    @for ($i = 1; $i <= 3; $i++)
                        <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                            <label for="imagem{{ $i }}Produto font-weight-bold">Imagem
                                {{ $i }}:</label>

                            <div class="row d-flex align-items-center">
                                <div class="col col-6 d-flex justify-content-center"><img
                                        id="preview-image-{{ $i }}"
                                        src="{{ $produto->imagens->where('pimg_index', '=', $i)->count() == 1 ? asset($produto->imagens->where('pimg_index', '=', $i)->first()->pimg_url) : asset('images/sem_imagem.png') }}"
                                        alt="preview image" style="width: 50%;">
                                </div>
                                <div class="col col-6">
                                    <input type="file" class="form-control-file" id="imagem{{ $i }}Produto"
                                        name="img{{ $i }}" accept="image/x-png,image/gif,image/jpeg">
                                </div>
                            </div>
                        </div>
                    @endfor

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <ul class="list-group">
                            <li class="list-group-item active">Insumos Relacionados</li>
                            @foreach ($insumosProduto as $insumo)
                                <li class="list-group-item d-flex justify-content-between">
                                    {{ $insumo->insumo->ins_nome }} -
                                    Consumo: {{ $insumo->insumo->ins_consumo }} - Estoque:
                                    {{ $insumo->insumo->ins_estoque }}
                                    <div style="word-spacing: 10px">
                                        <a href="{{ asset('/painel/insumos/editar/' . $insumo->insumo->ins_id) }}"><i
                                                class="text-warning fas fa-user-edit"></i></a>
                                        <a data-toggle="modal"
                                            data-target="#modalInsumoProduto-{{ $insumo->insprod_id }}"><i
                                                class="text-danger fas fa-user-times"></i></a>
                                    </div>
                                </li>

                                <!-- Modal -->
                                <div class="modal fade" id="modalInsumoProduto-{{ $insumo->insprod_id }}"
                                    tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel-{{ $insumo->insprod_id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"
                                                    id="exampleModalLabel-{{ $insumo->insprod_id }}">Remover Insumo</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Fechar">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Tem certeza que deseja desvincular o insumo?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Fechar</button>
                                                <a href="{{ asset("/painel/insumos_produtos/remover/$insumo->insprod_id") }}"
                                                    type="button" class="btn btn-primary">Confirmar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <a href="{{ asset('painel/produtos') }}" class="btn btn-secondary mr-1"><i
                                class="fas fa-times"></i>
                            Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Editar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(e) {
            $('.form-control-file').each(function() {
                console.log($('#preview-image-' + ($('.form-control-file').index(this) + 1)));
                $(this).change(function() {
                    let reader = new FileReader();
                    reader.onload = (e) => {
                        $($('#preview-image-' + ($('.form-control-file').index(this) + 1)))
                            .attr('src', e
                                .target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                });
            });
        });
    </script>

@endsection
