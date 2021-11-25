@extends('layout')

@section('conteudo')

    <div class="container">
        <div class="row">
            <div class="col col-12">

                <h1 class="text-center"><strong>Adicionar Fornecedor</strong></h1>
                <form action="{{ asset('painel/fornecedores/adicionar') }}" method="POST">
                    @csrf

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="nomeFornecedor" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="nomeFornecedor" name="nome"
                            placeholder="Nome do Fornecedor" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="pessoaFornecedor" class="form-label">Tipo Pessoa</label>
                        <select class="custom-select" id="pessoaFornecedor" name="tipoPessoa"
                            onchange='trocarTipoDoc("#documentoFornecedor", this.value)'>
                            <option value="PF">Pessoa Física</option>
                            <option value="PJ">Pessoa Jurídica</option>
                        </select>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="documentoFornecedor" class="form-label">CPF / CNPJ</label>
                        <input type="text" class="form-control cpf" id="documentoFornecedor" name="cpfCnpj"
                            placeholder="CPF ou CNPJ do Fornecedor" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="registroFornecedor" class="form-label">RG / IE</label>
                        <input type="number" class="form-control" id="registroFornecedor" name="rgIE"
                            placeholder="RG ou IE do Fornecedor" onKeyPress="if(this.value.length==14) return false;"
                            onchange="if(this.value.length>14){this.value = ''}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="enderecoFornecedor" class="form-label">Endereço</label>
                        <input type="text" class="form-control" id="enderecoFornecedor" name="endereco"
                            placeholder="Endereço do Fornecedor" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="numeroFornecedor" class="form-label">Número</label>
                        <input type="number" class="form-control" id="numeroFornecedor" name="numero"
                            placeholder="Número do Fornecedor" onKeyPress="if(this.value.length==10) return false;"
                            onchange="if(this.value.length>10){this.value = ''}" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="bairroFornecedor" class="form-label">Bairro</label>
                        <input type="text" class="form-control" id="bairroFornecedor" name="bairro"
                            placeholder="Bairro do Fornecedor" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="cidadeFornecedor" class="form-label">Cidade</label>
                        <input type="text" class="form-control" id="cidadeFornecedor" name="cidade"
                            placeholder="Cidade do Fornecedor" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="ufFornecedor" class="form-label">Estado</label>
                        <select class="custom-select" id="ufFornecedor" name="uf">
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
                        <label for="cepFornecedor" class="form-label">CEP</label>
                        <input type="text" class="form-control cep" id="cepFornecedor" name="cep"
                            placeholder="CEP do Fornecedor" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="complementoFornecedor" class="form-label">Complemento</label>
                        <textarea type="text" class="form-control" id="complementoFornecedor" name="complemento"
                            placeholder="Complemento do Fornecedor" maxlength="255"></textarea>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="celularFornecedor" class="form-label">Celular</label>
                        <input type="tel" class="form-control celular" id="celularFornecedor" name="celular"
                            placeholder="Celular do Fornecedor" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="telefoneFornecedor" class="form-label">Telefone</label>
                        <input type="tel" class="form-control telefone" id="telefoneFornecedor" name="telefone"
                            placeholder="Telefone do Fornecedor" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 mt-3 mb-3">
                        <label for="emailFornecedor" class="form-label">Email</label>
                        <input type="email" class="form-control" id="emailFornecedor" name="email"
                            placeholder="Email do Fornecedor" maxlength="255" required>
                    </div>

                    <div class="col col-10 offset-1 col-md-8 offset-md-2 d-flex justify-content-end">
                        <a href="{{ asset('painel/fornecedores') }}" class="btn btn-secondary mr-1"><i
                                class="fas fa-times"></i> Cancelar</a>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-user-plus"></i> Adicionar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

@endsection
