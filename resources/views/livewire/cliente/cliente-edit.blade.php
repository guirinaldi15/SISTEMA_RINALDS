<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Editar Cliente
            </h2>

            <p class="text-muted mb-0">
                Atualize os dados do cliente.
            </p>

        </div>

        <a
            href="{{ route('clientes.index') }}"
            class="btn btn-outline-secondary"
        >
            ← Voltar
        </a>

    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form wire:submit="atualizar">

                <div class="row g-3">

                    {{-- Nome --}}
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

                    {{-- Telefone --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            Telefone *
                        </label>

                        <input
                            type="text"
                            wire:model="telefone"
                            class="form-control @error('telefone') is-invalid @enderror"
                        >

                        @error('telefone')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                    {{-- Email --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Email
                        </label>

                        <input
                            type="email"
                            wire:model="email"
                            class="form-control"
                        >

                    </div>

                    {{-- CPF / CNPJ --}}
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

                    {{-- CEP --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            CEP
                        </label>

                        <input
                            type="text"
                            id="cep"
                            wire:model="cep"
                            class="form-control"
                            maxlength="9"
                            placeholder="00000-000"
                            onblur="buscarCep()"
                        >

                    </div>

                    {{-- Cidade --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Cidade
                        </label>

                        <input
                            type="text"
                            id="cidade"
                            wire:model="cidade"
                            class="form-control"
                        >

                    </div>

                    {{-- Estado --}}
                    <div class="col-md-2">

                        <label class="form-label">
                            Estado
                        </label>

                        <input
                            type="text"
                            id="estado"
                            wire:model="estado"
                            class="form-control"
                            maxlength="2"
                            readonly
                        >

                    </div>

                    {{-- Observações --}}
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
                        wire:loading.attr="disabled"
                    >

                        <span
                            wire:loading.remove
                            wire:target="atualizar"
                        >
                            Salvar Alterações
                        </span>

                        <span
                            wire:loading
                            wire:target="atualizar"
                        >
                            Salvando...
                        </span>

                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>
        async function buscarCep() {

            let cepInput =
                document.getElementById('cep');

            let cep =
                cepInput.value.replace(/\D/g, '');

            if (cep.length === 0) {
                return;
            }

            if (cep.length !== 8) {

                alert('CEP inválido.');

                return;
            }

            try {

                const response =
                    await fetch(
                        `https://viacep.com.br/ws/${cep}/json/`
                    );

                const dados =
                    await response.json();

                if (dados.erro) {

                    alert('CEP não encontrado.');

                    return;
                }

                const cidade =
                    document.getElementById('cidade');

                const estado =
                    document.getElementById('estado');

                cidade.value =
                    dados.localidade ?? '';

                estado.value =
                    dados.uf ?? '';

                cidade.dispatchEvent(
                    new Event(
                        'input',
                        { bubbles: true }
                    )
                );

                estado.dispatchEvent(
                    new Event(
                        'input',
                        { bubbles: true }
                    )
                );

                cepInput.value =
                    cep.replace(
                        /^(\d{5})(\d{3})$/,
                        '$1-$2'
                    );

                cepInput.dispatchEvent(
                    new Event(
                        'input',
                        { bubbles: true }
                    )
                );

            } catch (erro) {

                alert(
                    'Não foi possível consultar o CEP.'
                );

                console.error(erro);
            }
        }
    </script>

</div>