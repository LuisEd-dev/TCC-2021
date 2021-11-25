@extends('layout')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col col-12">

                <h1 class="text-center"><strong>Adicionar Produto</strong></h1>
                <form action="{{ asset('painel/produtos/adicionar') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="nomeProduto" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nomeProduto" name="nome" placeholder="Nome do Produto"
                            maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="vendaProduto" class="form-label">Preço Venda</label>
                        <input type="text" class="form-control money" id="vendaProduto" name="venda"
                            placeholder="Preço de Venda" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="custoProduto" class="form-label">Preço Custo</label>
                        <input type="text" class="form-control money" id="custoProduto" name="custo"
                            placeholder="Preço de Custo" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="descricaoProduto" class="form-label">Descrição</label>
                        <textarea type="text" class="form-control" id="descricaoProduto" name="descricao"
                            placeholder="Descrição do Produto" maxlength="255" required></textarea>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="imagem1Produto font-weight-bold">Imagem 1:</label>
                        <div class="row d-flex align-items-center">
                            <div class="col col-6">
                                <input type="file" class="form-control-file" id="imagem1Produto" name="img1" accept="image/x-png,image/gif,image/jpeg" required>
                            </div>
                            <div class="col col-6 d-flex justify-content-center"><img id="preview-image-1"
                                    src="{{ asset('images/sem_imagem.png') }}" alt="preview image" style="width: 100px;">
                            </div>
                        </div>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="imagem2Produto">Imagem 2:</label>
                        <div class="row d-flex align-items-center">
                            <div class="col col-6">
                                <input type="file" class="form-control-file" id="imagem2Produto" name="img2" accept="image/x-png,image/gif,image/jpeg">
                            </div>
                            <div class="col col-6 d-flex justify-content-center"><img id="preview-image-2"
                                    src="{{ asset('images/sem_imagem.png') }}" alt="preview image" style="width: 100px;">
                            </div>
                        </div>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="imagem3Produto font-weight-bold">Imagem 3:</label>
                        <div class="row d-flex align-items-center">
                            <div class="col col-6">
                                <input type="file" class="form-control-file" id="imagem3Produto" name="img3" accept="image/x-png,image/gif,image/jpeg">
                            </div>
                            <div class="col col-6 d-flex justify-content-center"><img id="preview-image-3"
                                    src="{{ asset('images/sem_imagem.png') }}" alt="preview image" style="width: 100px;">
                            </div>
                        </div>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <a href="{{ asset('painel/produtos') }}" class="btn btn-secondary mr-1"><i
                                class="fas fa-times"></i> Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Adicionar</button>
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
