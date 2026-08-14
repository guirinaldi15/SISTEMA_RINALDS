<div class="container py-4">

    <div class="mb-4">

        <a href="{{ route('clientes.index') }}" class="text-decoration-none">
            ← Voltar
        </a>

        <h2 class="fw-bold mt-3">
            Novo Cliente
        </h2>

        <p class="text-muted">
            Cadastre um novo cliente da Chácara Rinald's.
        </p>

    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form wire:submit="salvar">

                <div class="row g-3">

                    <div class="col-md-8">

                        <label class="form-label">
                            Nome *
                        </label>

                        <input
                            type="text"
                            wire:model="nome"
                            class="form-control @error('nome') is-invalid @enderror"
                        >

                        @error('nome')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">
                            Telefone *
                        </label>

                        <input
                            type="text"
                            wire:model="telefone"
                            class="form-control @error('telefone') is-invalid @enderror"
                            placeholder="(18) 99999-9999"
                        >

                        @error('telefone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            wire:model="email"
                            class="form-control @error('email') is-invalid @enderror"
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    <div class="col-md-6">

                        <label class="form-label">
                            CPF / CNPJ
                        </label>

                        <input
                            type="text"
                            wire:model="cpf_cnpj"
                            class="form-control"
                        >

                    </div>

                    <div class="col-md-8">

                        <label class="form-label">
                            Cidade
                        </label>

                        <input
                            type="text"
                            wire:model="cidade"
                            class="form-control"
                        >

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">
                            Estado
                        </label>

                        <select
                            wire:model="estado"
                            class="form-select"
                        >

                            <option value="SP">
                                SP
                            </option>

                            <option value="PR">
                                PR
                            </option>

                            <option value="MS">
                                MS
                            </option>

                            <option value="MG">
                                MG
                            </option>

                        </select>

                    </div>

                    <div class="col-12">

                        <label class="form-label">
                            Observações
                        </label>

                        <textarea
                            wire:model="observacoes"
                            class="form-control"
                            rows="4"
                        ></textarea>

                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a
                        href="{{ route('clientes.index') }}"
                        class="btn btn-light"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        Salvar Cliente
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>