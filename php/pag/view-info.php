<style>
    #commentText {
        font-size: 16px;
        padding: 10px;
        border: 2px solid #adb5bd;
        border-radius: 5px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    #commentText:focus {
        border-color: #adb5bd;
        box-shadow: 0 0 8px rgba(0, 123, 255, 0.5);
        outline: none;
    }
</style>

<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="row g-0">
            <div class="col-md-4 d-flex align-items-center">
                <div class="row el-element-overlay">
                    <div class="el-card-item">
                        <div class="el-card-avatar el-overlay-1">
                            <img src="../assets/images/big/img1.jpg" class="img-fluid rounded-start p-2"
                                alt="Capa do livro">
                            <div class="el-overlay">
                                <ul class="list-style-none el-info">
                                    <li class="el-item">
                                        <a class="btn default btn-outline image-popup-vertical-fit el-link"
                                            href="../assets/images/big/img1.jpg">
                                            <i class="mdi mdi-magnify-plus"></i>
                                        </a>
                                    </li>
                                    <li class="el-item">
                                        <a class="btn default btn-outline el-link" href="javascript:void(0);">
                                            <i class="mdi mdi-heart-outline"></i>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card-body">
                    <h1 class="card-title text-center text-dark">A abelha Zarelha</h1>
                    <hr>
                    <h5 class="text-dark"><strong>Autor:</strong> <span class="text-danger">Raquel Patriarca</span></h5>
                    <h5 class="text-dark"><strong>Ano de Lançamento:</strong> <span class="text-danger">2025</span></h5>
                    <h5 class="text-dark"><strong>Idioma:</strong> <span class="text-danger">Português</span></h5>
                    <h5 class="text-dark"><strong>ISBN:</strong> <span class="text-danger">9789898657916</span></h5>
                    <h5 class="text-dark"><strong>Editora:</strong> <span class="text-danger">Família</span></h5>
                    <h5 class="text-dark"><strong>Sinopse:</strong> <span class="text-danger">Vila do Conde</span></h5>
                    <h5 class="text-dark"><strong>Avaliação:</strong> <span class="text-danger">4.73</span></h5>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#localTab" role="tab" aria-selected="true">
                        <span class="hidden-sm-up"></span>
                        <span class="hidden-xs-down">Localização</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#commentsTab" role="tab" aria-selected="false">
                        <span class="hidden-sm-up"></span>
                        <span class="hidden-xs-down">Comentários</span>
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content tabcontent-border">
                <!-- Localização -->
                <div class="tab-pane active" id="localTab" role="tabpanel">
                    <div id="localContent">
                        <table class="table table-bordered table-striped text text-center">
                            <thead>
                                <tr>
                                    <th>Biblioteca</th>
                                    <th>Quantidade Disponível</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Biblioteca Central</td>
                                    <td>4</td>
                                </tr>
                                <tr>
                                    <td>Biblioteca de Gaia</td>
                                    <td>3</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="tab-pane p-3" id="commentsTab" role="tabpanel">
                    <div id="commentContent">

                        <div id="commentsList" class="mt-4">

                            <div class="d-flex align-items-center">
                                <img src="../assets/images/users/1.jpg" alt="Ícone de perfil" class="rounded-circle"
                                    width="31">
                                <div class="d-flex align-items-center ms-2">
                                    <p class="mb-0">
                                        <strong>João Silva:</strong> Ótima leitura para crianças!
                                    </p>
                                </div>
                            </div>


                            <hr class="bg-secondary">

                            <div class="d-flex align-items-center">
                                <img src="../assets/images/users/2.jpg" alt="Ícone de perfil" class="rounded-circle"
                                    width="31">
                                <div class="d-flex align-items-center ms-2">
                                    <p class="mb-0">
                                        <strong>Maria Santos:</strong> História muito divertida e educativa.
                                    </p>
                                </div>
                            </div>
                            <hr class="bg-secondary">
                        </div>

                        <div id="commentForm">
                            <form id="commentFormId">
                                <div class="mb-3">
                                    <label class="form-label">Deixe seu comentário</label>
                                    <textarea placeholder="Ótimo livro! Divertido, e etc..." class="form-control"
                                        id="commentText" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-outline-success 
                                    d-inline-flex
                                    align-items-center
                                    gap-2 
                                    float-end
                                    mb-3">
                                    <i class="mdi mdi-send"></i>
                                    <span>Enviar</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>