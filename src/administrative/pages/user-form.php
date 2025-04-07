<div class="row justify-content-center">
    <div class="col-md-12 me-3">

        <a class="text-info" href="?page=users">
            <i class="mdi mdi-undo"></i>
            Voltar
        </a>

        <form id="example-form" action="#" class="mt-5" novalidate="novalidate">
            <div role="application" class="wizard clearfix" id="steps-uid-0">
                <div class="steps clearfix">
                    <ul role="tablist">
                        <li class="first current" role="tab" aria-selected="true">
                            <a href="#steps-uid-0-h-0"><span class="number">1.</span> Conta</a>
                        </li>
                        <li class="disabled" role="tab" aria-selected="false">
                            <a href="#steps-uid-0-h-1"><span class="number">2.</span> Perfil</a>
                        </li>
                        <li class="disabled last" role="tab" aria-selected="false">
                            <a href="#steps-uid-0-h-2"><span class="number">3.</span> Acesso</a>
                        </li>
                    </ul>
                </div>

                <div class="content clearfix">
                    <!-- Step 1: Conta -->
                    <h3 id="steps-uid-0-h-0" tabindex="-1" class="title current">Conta</h3>
                    <section id="steps-uid-0-p-0" role="tabpanel" aria-labelledby="steps-uid-0-h-0"
                        class="body current">
                        <label for="username">Nome de Utilizador *</label>
                        <input id="username" name="username" type="text" class="required form-control">

                        <label for="email">Email *</label>
                        <input id="email" name="email" type="email" class="required form-control">

                        <label for="password">Palavra-passe *</label>
                        <input id="password" name="password" type="password" class="required form-control">

                        <label for="confirm">Confirmar Palavra-passe *</label>
                        <input id="confirm" name="confirm" type="password" class="required form-control">
                    </section>

                    <!-- Step 2: Perfil -->
                    <h3 id="steps-uid-0-h-1" tabindex="-1" class="title">Perfil</h3>
                    <section id="steps-uid-0-p-1" role="tabpanel" aria-labelledby="steps-uid-0-h-1" class="body"
                        style="display: none;">
                        <label for="first_name">Primeiro Nome *</label>
                        <input id="first_name" name="first_name" type="text" class="required form-control">

                        <label for="last_name">Último Nome *</label>
                        <input id="last_name" name="last_name" type="text" class="required form-control">

                        <label for="birth_date">Data de Nascimento *</label>
                        <input id="birth_date" name="birth_date" type="date" class="required form-control">

                        <label for="nif">NIF</label>
                        <input id="nif" name="nif" type="text" class="form-control">

                        <label for="cc">Cartão de Cidadão</label>
                        <input id="cc" name="cc" type="text" class="form-control">

                        <label for="gender">Género</label>
                        <input id="gender" name="gender" type="text" class="form-control">

                        <label for="address">Morada</label>
                        <input id="address" name="address" type="text" class="form-control">

                        <label for="phone_number">Telemóvel</label>
                        <input id="phone_number" name="phone_number" type="text" class="form-control">
                    </section>

                    <!-- Step 3: Acesso -->
                    <h3 id="steps-uid-0-h-2" tabindex="-1" class="title">Acesso</h3>
                    <section id="steps-uid-0-p-2" role="tabpanel" aria-labelledby="steps-uid-0-h-2" class="body"
                        style="display: none;">
                        <label for="user_type_fk">Tipo de Utilizador *</label>
                        <select id="user_type_fk" name="user_type_fk" class="required form-select">
                            <option value="">Selecionar</option>
                            <option value="1">Administrador</option>
                            <option value="2">Bibliotecário</option>
                            <option value="3">Aluno</option>
                        </select>

                        <label for="active">Ativo</label>
                        <select id="active" name="active" class="form-select">
                            <option value="Y">Sim</option>
                            <option value="N">Não</option>
                        </select>

                        <div class="form-check mt-3">
                            <input id="acceptTerms" name="acceptTerms" type="checkbox"
                                class="required form-check-input">
                            <label class="form-check-label" for="acceptTerms">Concordo com os termos e
                                condições.</label>
                        </div>
                    </section>
                </div>

                <div class="actions clearfix">
                    <ul role="menu" aria-label="Pagination">
                        <li class="disabled" aria-disabled="true"><a href="#previous" role="menuitem">Anterior</a></li>
                        <li aria-hidden="false" aria-disabled="false"><a href="#next" role="menuitem">Seguinte</a></li>
                        <li aria-hidden="true" style="display: none;"><a href="#finish" role="menuitem">Finalizar</a>
                        </li>
                    </ul>
                </div>
            </div>
        </form>
    </div>
</div>