<div class="container py-4">

    {{-- Cabeçalho --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Editar Cliente</h2>
            <p class="text-muted mb-0">
                Atualize os dados do cliente da Chácara Rinald's.
            </p>
        </div>

        <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary">
            ← Voltar
        </a>
    </div>

    {{-- Card --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">

            <form wire:submit="atualizar">

                <div class="row g-3">

                    {{-- Nome --}}
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">
                            Nome *
                        </label>

                        <input
                            type="text"
                            wire:model="nome"
                            class="form-control @error('nome') is-invalid @enderror"
                            placeholder="Nome completo"
                        >

                        @error('nome')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Telefone --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
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

                    {{-- Email --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            E-mail
                        </label>

                        <input
                            type="email"
                            wire:model="email"
                            class="form-control @error('email') is-invalid @enderror"
                            placeholder="cliente@email.com"
                        >

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- CPF/CNPJ --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            CPF / CNPJ
                        </label>

                        <input
                            type="text"
                            wire:model="cpf_cnpj"
                            class="form-control @error('cpf_cnpj') is-invalid @enderror"
                            placeholder="CPF ou CNPJ"
                        >

                        @error('cpf_cnpj')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Cidade --}}
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">
                            Cidade
                        </label>

                        <input
                            type="text"
                            wire:model="cidade"
                            class="form-control @error('cidade') is-invalid @enderror"
                            placeholder="Presidente Epitácio"
                        >

                        @error('cidade')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">
                            Estado
                        </label>

                        <select
                            wire:model="estado"
                            class="form-select @error('estado') is-invalid @enderror"
                        >
                            <option value="">Selecione</option>
                            <option value="SP">SP</option>
                            <option value="MS">MS</option>
                            <option value="PR">PR</option>
                            <option value="MG">MG</option>
                        </select>

                        @error('estado')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Observações --}}
                    <div class="col-12">
                        <label class="form-label fw-semibold">
                            Observações
                        </label>

                        <textarea
                            wire:model="observacoes"
                            class="form-control @error('observacoes') is-invalid @enderror"
                            rows="4"
                            placeholder="Informações adicionais sobre o cliente..."
                        ></textarea>

                        @error('observacoes')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                </div>

                {{-- Botões --}}
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
                        wire:loading.attr="disabled"
                    >
                        <span wire:loading.remove wire:target="atualizar">
                            Salvar Alterações
                        </span>

                        <span wire:loading wire:target="atualizar">
                            Salvando...
                        </span>
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>