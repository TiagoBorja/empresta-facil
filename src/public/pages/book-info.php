<?php
$isGuest = !isset($_SESSION['user']);
?>

<div class="row justify-content-center">
    <div class="col-md-12 p-4">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <a class="text-info" href="?page=catalog">
                <i class="mdi mdi-undo"></i> Voltar
            </a>
            <?php if ($isGuest): ?>
                <button type="button" class="btn btn-warning" id="loginRequired" data-bs-toggle="modal"
                    data-bs-target="#loginRequiredModal">
                    <i class="mdi mdi-bookmark-plus-outline me-1"></i> Reservar
                </button>
            <?php endif; ?>

            <?php if (!$isGuest): ?>
                <button type="button" class="btn btn-warning" id="reservationBtn">
                    <i class="mdi mdi-bookmark-plus-outline me-1"></i> Reservar
                </button>
            <?php endif; ?>
        </div>

        <div class="card shadow-lg">
            <div class="row g-0">
                <div class="col-md-4 ms-3 mt-2 mb-2 d-flex align-items-center">
                    <img id="bookCover"
                        class="img-fluid rounded-start p-2 w-100" alt="Book Cover">
                </div>

                <div class="col-md-1 mt-3 mb-3 d-flex justify-content-center align-items-center">
                    <div class="vertical-row bg-dark"></div>
                </div>

                <div class="col-md-6 d-flex align-items-center">
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
                            <div class="comment-widgets scrollable bg-white" id="commentsContainer">
                                <div class="no-comments-placeholder text-center p-5 d-none" id="noComments">
                                    <div class="d-flex flex-column align-items-center justify-content-center py-5">
                                        <i class="mdi mdi-comment-text-outline mdi-48px text-muted mb-3"></i>
                                        <h5 class="text-muted fw-light">Nenhum comentário ainda</h5>
                                        <p class="text-muted mb-0">Seja o primeiro a compartilhar sua opinião!</p>
                                    </div>
                                </div>
                                <!-- Scrollbars -->
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
                                    <th class="text-white">Morada</th>
                                    <th class="text-white">Quantidade Disponível</th>
                                </tr>
                            </thead>
                            <tbody id="locationsTableBody" class="bg-white">
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
                                        <input id="userId" type="hidden"
                                            value="<?php echo $_SESSION['user']['id'] ?? null; ?>">
                                        <textarea placeholder="Ótimo livro! Divertido, e etc..."
                                            class="form-control text-dark border rounded-3 shadow-sm mt-3"
                                            id="commentText" name="commentText" rows="3"></textarea>
                                    </div>
                                    <?php if ($isGuest): ?>
                                        <button type="button"
                                            class="btn btn-outline-success d-flex align-items-center gap-2 float-end"
                                            data-bs-toggle="modal" data-bs-target="#loginRequiredModal">
                                            <i class="mdi mdi-send"></i>
                                            <span>Enviar</span>
                                        </button>
                                    <?php else: ?>
                                        <button type="submit" name="saveData"
                                            class="btn btn-outline-success d-flex align-items-center gap-2 float-end">
                                            <i class="mdi mdi-send"></i>
                                            <span>Enviar</span>
                                        </button>
                                    <?php endif; ?>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/modal/book-reservation.php'; ?>
<?php include '../includes/modal/login-required.php'; ?>
<script type="module" src="../js/public-pages/book-info.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const toastMessage = sessionStorage.getItem('toastMessage');

        if (toastMessage === 'success') {
            toastr.success("Operação realizada com sucesso!", "Sucesso!");
        } else if (toastMessage === 'inProcess') {
            toastr.info("Reserva criada com sucesso! Um email de confirmação será enviado em breve.", "Sucesso!");
        }
        else if (toastMessage === 'error') {
            toastr.error("Ocorreu um erro ao processar a solicitação.", "Erro!");
        }
        sessionStorage.removeItem('toastMessage');

    });
</script>