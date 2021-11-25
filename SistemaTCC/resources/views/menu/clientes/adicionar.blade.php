@extends('layout')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col col-12">

                <h1 class="text-center"><strong>Adicionar Cliente</strong></h1>
                <form action="{{ asset('painel/clientes/adicionar') }}" method="POST">
                    @csrf

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="nomeCliente" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nomeCliente" name="nome" placeholder="Nome do Cliente"
                            maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="pessoaCliente" class="form-label">Tipo Pessoa</label>
                        <select class="custom-select" id="pessoaCliente" name="tipoPessoa"
                            onchange='trocarTipoDoc("#documentoCliente", this.value)'>
                            <option value="PF">Pessoa Física</option>
                            <option value="PJ">Pessoa Jurídica</option>
                        </select>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="documentoCliente" class="form-label">CPF / CNPJ</label>
                        <input type="text" class="form-control cpf" id="documentoCliente" name="cpfCnpj"
                            placeholder="CPF ou CNPJ do Cliente" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="registroCliente" class="form-label">RG / IE</label>
                        <input type="number" class="form-control" id="registroCliente" name="rgIE"
                            placeholder="RG ou IE do Cliente" onKeyPress="if(this.value.length==14) return false;"
                            onchange="if(this.value.length>14){this.value = ''}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="enderecoCliente" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="enderecoCliente" name="endereco"
                            placeholder="Endereço do Cliente" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="numeroCliente" class="form-label">Número</label>
                        <input type="number" class="form-control" id="numeroCliente" name="numero"
                            placeholder="Número do Cliente" onKeyPress="if(this.value.length==10) return false;"
                            onchange="if(this.value.length>10){this.value = ''}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="bairroCliente" class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="bairroCliente" name="bairro"
                            placeholder="Bairro do Cliente" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="cidadeCliente" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidadeCliente" name="cidade"
                            placeholder="Cidade do Cliente" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="ufCliente" class="form-label">Estado</label>
                        <select class="custom-select" id="ufCliente" name="uf">
                            <option value="AC">Acre</option>
                            <option value="AL">Alagoas</option>
                            <option value="AP">Amapá</option>
                            <option value="AM">Amazonas</option>
                            <option value="BA">Bahia</option>
                            <option value="CE">Ceará</option>
                            <option value="DF">Distrito Federal</option>
                            <option value="ES">Espírito Santo</option>
                            <option value="GO">Goiás</option>
                            <option value="MA">Maranhão</option>
                            <option value="MT">Mato Grosso</option>
                            <option value="MS">Mato Grosso do Sul</option>
                            <option value="MG">Minas Gerais</option>
                            <option value="PA">Pará</option>
                            <option value="PB">Paraíba</option>
                            <option value="PR">Paraná</option>
                            <option value="PE">Pernambuco</option>
                            <option value="PI">Piauí</option>
                            <option value="RJ">Rio de Janeiro</option>
                            <option value="RN">Rio Grande do Norte</option>
                            <option value="RS">Rio Grande do Sul</option>
                            <option value="RO">Rondônia</option>
                            <option value="RR">Roraima</option>
                            <option value="SC">Santa Catarina</option>
                            <option value="SP">São Paulo</option>
                            <option value="SE">Sergipe</option>
                            <option value="TO">Tocantins</option>
                        </select>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="cepCliente" class="form-label">CEP</label>
                        <input type="text" class="form-control cep" id="cepCliente" name="cep" placeholder="CEP do Cliente"
                            required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="complementoCliente" class="form-label">Complemento</label>
                        <textarea type="text" class="form-control" id="complementoCliente" name="complemento"
                            placeholder="Complemento do Cliente" maxlength="255"></textarea>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="celularCliente" class="form-label">Celular</label>
                        <input type="tel" class="form-control celular" id="celularCliente" name="celular"
                            placeholder="Celular do Cliente" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="telefoneCliente" class="form-label">Telefone</label>
                        <input type="tel" class="form-control telefone" id="telefoneCliente" name="telefone"
                            placeholder="Telefone do Cliente" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="emailCliente" class="form-label">Email</label>
                        <input type="email" class="form-control" id="emailCliente" name="email"
                            placeholder="Email do Cliente" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <a href="{{ asset('painel/clientes') }}" class="btn btn-secondary mr-1"><i
                                class="fas fa-times"></i> Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Adicionar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
