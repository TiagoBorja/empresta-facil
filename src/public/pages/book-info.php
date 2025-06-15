<div class="row justify-content-center">
    <div class="col-md-12 p-4">
        <nav aria-label="Navegação secundária">
            <a class="text-info" href="?page=catalog">
                <i class="mdi mdi-undo"></i>
                Voltar
            </a>
        </nav>
        <div class="card shadow-lg">
            <div class="row g-0">
                <div class="col-md-4 ms-3 mt-2 mb-2 d-flex align-items-center">
                    <img id="bookCover" src="../public/assets/images/big/img1.jpg"
                        class="img-fluid rounded-start p-2 w-100" alt="Book Cover">
                </div>

                <div class="col-md-1 mt-3 mb-3 d-flex justify-content-center align-items-center">
                    <div class="vertical-row bg-dark"></div>
                </div>

                <div class="col-md-6 md-flex align-items-center">
                    <div class="card-body">
                        <h1 id="bookTitle" class="card-title text-center text-dark">Book Title</h1>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Autor:</strong>
                                <span id="bookAuthor" class="text-danger"></span>
                            </li>
                            <li class="list-group-item"><strong>Ano de Lançamento:</strong>
                                <span id="bookYear" class="text-danger"></span>
                            </li>
                            <li class="list-group-item"><strong>Idioma:</strong>
                                <span id="bookLanguage" class="text-danger"></span>
                            </li>
                            <li class="list-group-item"><strong>ISBN:</strong>
                                <span id="bookISBN" class="text-danger"></span>
                            </li>
                            <li class="list-group-item"><strong>Editora:</strong>
                                <span id="bookPublisher" class="text-danger"></span>
                            </li>
                            <li class="list-group-item"><strong>Sinopse:</strong>
                                <span id="bookSynopsis" class="text-danger"></span>
                            </li>
                            <li class="list-group-item"><strong>Avaliação:</strong>
                                <span id="bookRating" class="text-danger"></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col-md-12 p-4">
        <div class="card">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="tab" href="#commentsList" role="tab"
                        aria-selected="true">
                        Comentários e Avaliações
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#libraryLocation" role="tab" aria-selected="false">
                        Localizações
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="tab" href="#userComment" role="tab" aria-selected="false">
                        Comentar
                    </a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content tabcontent-border">
                <!-- Comentários e Avaliações Tab -->
                <div class="tab-pane fade show active" id="commentsList" role="tabpanel">
                    <div class="rounded-3">
                        <div class="card-body">
                            <div class="comment-widgets scrollable ps-container bg-white"
                                data-ps-id="1e4dd06c-c079-4682-737c-ce90567c7b40">

                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2">
                                        <img src="../assets/images/users/2.jpg" alt="user" width="50"
                                            class="rounded-circle">
                                    </div>
                                    <div class="comment-text w-100">
                                        <div class="d-flex justify-content align-items-center">
                                            <h6 class="font-medium text-info mb-0">Fulano da Silva</h6>
                                            <span class="star-shadow fs-3 me-2 text-warning ms-2">
                                                <i class="mdi mdi-star"></i>
                                                <i class="mdi mdi-star"></i>
                                                <i class="mdi mdi-star"></i>
                                                <i class="mdi mdi-star-outline"></i>
                                                <i class="mdi mdi-star-outline"></i>
                                            </span>
                                        </div>
                                        <span class="mb-3 d-block">Lorem Ipsum is simply dummy text of the printing
                                            andLorem Ipsum
                                            is simply dummy text of the printing andLorem Ipsum is simply dummy text of
                                            the printing
                                            andLorem Ipsum is simply dummy text of the printing andLorem Ipsum is simply
                                            dummy text</span>
                                        <div class="comment-footer">
                                            <span class="text-muted float-start">18 de Março, 2025</span>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2">
                                        <img src="../assets/images/users/5.jpg" alt="user" width="50"
                                            class="rounded-circle">
                                    </div>
                                    <div class="comment-text w-100">
                                        <div class="d-flex align-items-center justify-content">
                                            <h6 class="font-medium text-info fs-5 mb-0">Fulano da Silva</h6>
                                            <span class="star-shadow fs-3 me-2 text-warning ms-2">
                                                <i class="mdi mdi-star"></i>
                                                <i class="mdi mdi-star"></i>
                                                <i class="mdi mdi-star"></i>
                                                <i class="mdi mdi-star-outline"></i>
                                                <i class="mdi mdi-star-outline"></i>
                                            </span>
                                        </div>
                                        <span class="mb-3 d-block">Lorem Ipsum is simply dummy text of the printing
                                            andLorem Ipsum
                                            is simply dummy text of the printing andLorem Ipsum is simply dummy text of
                                            the printing
                                            andLorem Ipsum is simply dummy text of the printing andLorem Ipsum is simply
                                            dummy text</span>
                                        <div class="comment-footer">
                                            <span class="text-muted float-start">18 de Março, 2025</span>
                                        </div>
                                    </div>
                                </div>
                                <!-- Comment Row -->
                                <hr>

                                <div class="d-flex flex-row comment-row">
                                    <div class="p-2">
                                        <img src="../assets/images/users/5.jpg" alt="user" width="50"
                                            class="rounded-circle">
                                    </div>
                                    <div class="comment-text w-100">
                                        <div class="d-flex justify-content align-items-center">
                                            <h6 class="font-medium fs-5 text-info mb-0">Johnathan Doeting</h6>
                                            <span class="star-shadow fs-3 me-2 text-warning ms-2">
                                                <i class="mdi mdi-star"></i>
                                                <i class="mdi mdi-star"></i>
                                                <i class="mdi mdi-star"></i>
                                                <i class="mdi mdi-star-outline"></i>
                                                <i class="mdi mdi-star-outline"></i>
                                            </span>
                                        </div>
                                        <span class="mb-3 d-block">Lorem Ipsum is simply dummy text of the printing
                                            andLorem Ipsum
                                            is simply dummy text of the printing andLorem Ipsum is simply dummy text of
                                            the printing
                                            andLorem Ipsum is simply dummy text of the printing andLorem Ipsum is simply
                                            dummy text</span>
                                        <div class="comment-footer">
                                            <span class="text-muted float-start">18 de Março, 2025</span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                                    <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;">
                                    <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                </div>
                                <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;">
                                    <div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div>
                                </div>
                                <div class="ps-scrollbar-y-rail" style="top: 0px; right: 3px;">
                                    <div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Localizações Tab -->
                <div class="tab-pane fade" id="libraryLocation" role="tabpanel">
                    <div class="card-body">
                        <table class="table table-hover text-center">
                            <thead class="bg-dark">
                                <tr>
                                    <th class="text-white">Biblioteca</th>
                                    <th class="text-white">Quantidade Disponível</th>
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
                <div class="tab-pane fade" id="userComment" role="tabpanel">
                    <div class="card-body">
                        <div class="card shadow-lg rounded-3">

                            <div id="commentForm" class="p-3 rounded shadow-sm">
                                <form id="commentFormId">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold fs-5">Deixe sua avaliação e seu comentário
                                            (opcional):</label>
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
                                            class="form-control text-dark border rounded-3 shadow-sm mt-3"
                                            id="commentText" rows="3"></textarea>
                                    </div>
                                    <button type="submit"
                                        class="btn btn-outline-success d-flex align-items-center gap-2 float-end">
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
</div>

<script type="module" src="../js/public-pages/book-info.js"></script>