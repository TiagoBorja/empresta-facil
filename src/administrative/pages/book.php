<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body" style="text-align: center; border-bottom: 1px solid #d4d4d4;">
                <h5 class="card-title mb-0">Catálogo de Livros</h5>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Nome</th>
                            <th scope="col">Autor</th>
                            <th scope="col">Ano de Publicação</th>
                            <th scope="col">Editora</th>
                            <th scope="col">Quantidade</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Status</th>
                            <th scope="col">Ativo/Desabilitado</th>
                        </tr>
                    </thead>
                    <tbody class="customtable">
                        <tr>
                            <th>
                                <label>
                                    <input type="radio" class="form-check-input" name="book" />
                                </label>
                            </th>
                            <td>Trident</td>
                            <td>Internet Explorer 4.0</td>
                            <td>Win 95+</td>
                            <td>Blablabla</td>
                            <td>4</td>
                            <td><span class="badge rounded-pill bg-success">Lacrado</span></td>
                            <td><span class="badge rounded-pill bg-danger">Indisponível</span></td>
                            <td><span class="badge rounded-pill bg-success">Ativo</span></td>
                        </tr>
                        <tr>
                            <th>
                                <label>
                                    <input type="radio" class="form-check-input" name="book" />
                                </label>
                            </th>
                            <td>Uva</td>
                            <td>Em bananada</td>
                            <td>Win 95+</td>
                            <td>Blablabla</td>
                            <td>4</td>
                            <td><span class="badge rounded-pill bg-warning">Usado</span></td>
                            <td><span class="badge rounded-pill bg-success">Disponível</span></td>
                            <td><span class="badge rounded-pill bg-danger">Desabilitado</span></td>
                        </tr>


                    </tbody>
                </table>
                <div class="text-center">
                    <button class="btn btn-outline-success rounded-0 d-inline-flex align-items-center">
                        <i class="mdi mdi-plus d-flex align-items-center"
                            style="font-size: inherit; line-height: 1;"></i>
                        <span class="ms-1">Adicionar</span>
                    </button>
                    <button class="btn btn-outline-primary rounded-0 d-inline-flex align-items-center">
                        <i class="mdi mdi-refresh d-flex align-items-center"
                            style="font-size: inherit; line-height: 1;"></i>
                        <span class="ms-1">Atualizar</span>
                    </button>
                    <button class="btn btn-outline-danger rounded-0 d-inline-flex align-items-center">
                        <i class="mdi mdi-close d-flex align-items-center"
                            style="font-size: inherit; line-height: 1;"></i>
                        <span class="ms-1">Desabilitar</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>