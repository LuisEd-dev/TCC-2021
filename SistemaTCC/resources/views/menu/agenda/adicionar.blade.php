@extends('layout')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col col-12">

                <h1 class="text-center"><strong>Adicionar Evento</strong></h1>
                <form action="{{ asset('painel/agenda/adicionar') }}" method="POST">
                    @csrf

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="tituloEvento" class="form-label">Título</label>
                        <input type="text" class="form-control" id="tituloEvento" name="titulo"
                            placeholder="Título do Evento" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="descricaoEvento" class="form-label">Descrição</label>
                        <textarea name="descricao" id="descricaoEvento" rows="5" placeholder="Descrição do Evento"
                            class="form-control" maxlength="255"></textarea>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="dataEvento" class="form-label">Data</label>
                        <input type="date" id="dataEvento" class="form-control" value="{{ $data }}" name="data"
                            required readonly>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="corEvento" class="form-label">Cor</label>
                        <select class="custom-select" id="corEvento" name="cor"
                            onchange="document.getElementById('corEvento').style = 'color:' +document.getElementById('corEvento').options[document.getElementById('corEvento').selectedIndex].dataset.hex">
                            <option value="primary" class="text-primary" data-hex="#007bff">Azul</option>
                            <option value="secondary" class="text-secondary" data-hex="#6c757d">Cinza</option>
                            <option value="success" class="text-success" data-hex="#28a745">Verde</option>
                            <option value="danger" class="text-danger" data-hex="#dc3545">Vermelho</option>
                            <option value="warning" class="text-warning" data-hex="#ffc107">Amarelo</option>
                            <option value="info" class="text-info" data-hex="#17a2b8">Ciano</option>
                        </select>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <a href="{{ asset('painel/agenda') }}" class="btn btn-secondary mr-1"><i
                                class="fas fa-times"></i> Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Adicionar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
