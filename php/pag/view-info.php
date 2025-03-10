<div class="row justify-content-center">
    <div class="col-md-12 p-4">
        <div class="card shadow-lg">
            <div class="row g-0">
                <!-- Imagem dentro do Card -->
                <div class="col-md-4 d-flex align-items-center">
                    <img src="../assets/images/big/img1.jpg" class="img-fluid rounded-start p-2 w-100"
                        alt="Capa do livro">
                </div>

                <div class="col-md-1 mt-2 mb-2 d-flex justify-content-center align-items-center">
                    <div class="vertical-row"></div>
                </div>

                <!-- Informações do Livro -->
                <div class="col-md-7 d-flex align-items-cente">
                    <div class="card-body">
                        <h1 class="card-title text-center text-dark">A abelha Zarelha</h1>
                        <hr>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Autor:</strong>
                                <span class="text-danger">Raquel
                                    Patriarca</span>
                            </li>
                            <li class="list-group-item"><strong>Ano de Lançamento:</strong>
                                <span class="text-danger">2014</span>
                            </li>
                            <li class="list-group-item"><strong>Idioma:</strong>
                                <span class="text-danger">Português</span>
                            </li>
                            <li class="list-group-item"><strong>ISBN:</strong>
                                <span class="text-danger">9789899748385</span>
                            </li>
                            <li class="list-group-item"><strong>Editora:</strong>
                                <span class="text-danger">Verso da História</span>
                            </li>
                            <li class="list-group-item"><strong>Sinopse:</strong>
                                <span class="text-danger">A Abelha Zarelha é o primeiro volume da coleção "Livro com
                                    Bicho",
                                    destinada a entreter os primeiros leitores. A história apresenta a Abelha Zarelha,
                                    sempre
                                    ocupada a zumbir de um lado para o outro.</span>
                            </li>
                            <li class="list-group-item"><strong>Avaliação:</strong> <span
                                    class="text-danger">4.73</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 p-4">
        <div class="card shadow-lg">
            <div class="card-header bg-light border border-2 border-dark">
                <h4 class="fw-bold text-dark text-center mb-0">Localizações</h4>
            </div>
            <div class="card-body">
                <table class="table table-hover text-center">
                    <thead class="bg-dark">

                        <tr>
                            <th class="fw-bold text-white">Biblioteca</th>
                            <th class="fw-bold text-white">Quantidade Disponível</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr class="border-bottom border-dark">
                            <td class="fw-normal text-dark">Biblioteca Central</td>
                            <td class="fw-normal text-dark">4</td>
                        </tr>
                        <tr class="border-bottom border-dark">
                            <td class="fw-normal text-dark">Biblioteca de Gaia</td>
                            <td class="fw-normal text-dark">3</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="col-md-12 p-4">
        <div class="card shadow-lg rounded-3">
            <div class="card-header bg-light border border-dark">
                <h4 class="fw-bold text-dark text-center mb-0">Comentários e Avaliações</h4>
            </div>

            <!-- Formulário de Comentário -->
            <div id="commentForm" class="p-3 rounded shadow-sm">
                <form id="commentFormId">
                    <div class="mb-3">
                        <label class="form-label fw-semibold fs-5">Deixe sua avaliação e seu comentário (opcional):</label>
                        <div class="rate">
                            <input type="radio" id="star5" name="rate" value="5" />
                            <label for="star5" title="5 estrelas">★</label>
                            <input type="radio" id="star4" name="rate" value="4" />
                            <label for="star4" title="4 estrelas">★</label>
                            <input type="radio" id="star3" name="rate" value="3" />
                            <label for="star3" title="3 estrelas">★</label>
                            <input type="radio" id="star2" name="rate" value="2" />
                            <label for="star2" title="2 estrelas">★</label>
                            <input type="radio" id="star1" name="rate" value="1" />
                            <label for="star1" title="1 estrela">★</label>
                        </div>
                        <textarea placeholder="Ótimo livro! Divertido, e etc..."
                            class="form-control text-dark border rounded-3 shadow-sm mt-3" id="commentText"
                            rows="3"></textarea>
                    </div>
                    <button type="submit" class="btn btn-success text-white d-flex align-items-center gap-2 float-end">
                        <i class="mdi mdi-send"></i>
                        <span>Enviar</span>
                    </button>
                </form>
            </div>


            <hr class="m-0">

            <div id="commentsList" class="p-3 mt-3">
                <div class="comment-widgets scrollable bg-white rounded-3 shadow-lg">
                    <!-- Comment Row -->
                    <div class="d-flex flex-row comment-row mt-0">
                        .
                        <img src="../assets/images/users/2.jpg" alt="user" width="50" class="rounded-circle" />

                        <div class="comment-text w-100">

                            <span class="text-muted float-end">Publicado em: 04 de Março, 2025</span>

                            <h6 class="fw-bold text-info">Maria Santos</h6>
                            <span class="d-block ms-2">História muito divertida e educativa.</span>
                        </div>
                    </div>
                </div>
            </div>
            <div id="commentsList" class="p-3">
                <div class="comment-widgets scrollable bg-white rounded-3 shadow-lg">
                    <!-- Comment Row -->
                    <div class="d-flex flex-row comment-row mt-0">
                        .
                        <img src="../assets/images/users/2.jpg" alt="user" width="50" class="rounded-circle" />

                        <div class="comment-text w-100">

                            <span class="text-muted float-end">Publicado em: 04 de Março, 2025</span>

                            <h6 class="fw-bold text-info">Maria Santos</h6>
                            <span class="d-block ms-2">História muito divertida e educativa.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>