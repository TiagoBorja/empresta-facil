<style>
    #commentText {
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
    <div class="col-md-12 p-4">
        <div class="card shadow-lg">
            <div class="row g-0">
                <!-- Imagem dentro do Card -->
                <div class="col-md-4 d-flex align-items-center">
                    <img src="../assets/images/big/img1.jpg" class="img-fluid rounded-start p-2 w-100"
                        alt="Capa do livro">
                </div>

                <div class="col-md-1 mt-2 mb-2 d-flex justify-content-center align-items-center">
                    <div class="vr" style="height: 100%; width: 2px; background-color: #ddd;"></div>
                </div>

                <!-- Informações do Livro -->
                <div class="col-md-7 d-flex align-items-cente">
                    <div class="card-body">
                        <h1 class="card-title text-center text-dark">A abelha Zarelha</h1>
                        <hr>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><strong>Autor:</strong> <span class="text-danger">Raquel
                                    Patriarca</span></li>
                            <li class="list-group-item"><strong>Ano de Lançamento:</strong> <span
                                    class="text-danger">2014</span></li>
                            <li class="list-group-item"><strong>Idioma:</strong> <span
                                    class="text-danger">Português</span></li>
                            <li class="list-group-item"><strong>ISBN:</strong> <span
                                    class="text-danger">9789899748385</span></li>
                            <li class="list-group-item"><strong>Editora:</strong> <span class="text-danger">Verso da
                                    História</span></li>
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
        <div class="card border border-dark">
            <div class="card-title ms-2 me-2 mt-2 border border-dark">
                <h4 class="fw-bold shadow">Localizações</h4>
            </div>
            <div class="card-body border border-dark ms-2 me-2 mb-2">
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


    </div>

    <div class="col-md-12 p-4">
        <div class="card border border-dark">
            <div class="card-title ms-2 me-2 mt-2 border border-dark">
                <h4 class="fw-bold">Comentários e Avaliações</h4>
            </div>

            <div id="commentForm" class="border border-dark me-2 ms-2">
                <form id="commentFormId">
                    <div class="mb-3">
                        <label class="form-label">Deixe seu comentário</label>
                        <textarea placeholder="Ótimo livro! Divertido, e etc..." class="form-control text-dark"
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


            <div class="card-body ms-2 me-2 mb-2 mt-2 border border-dark">
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
                </div>
            </div>
        </div>
    </div>

</div>