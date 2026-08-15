<div class="container py-4">

    {{-- CABEÇALHO --}}
    <div class="mb-4">

        <a
            href="{{ route('atendimentos.index') }}"
            class="text-decoration-none"
        >
            ← Voltar
        </a>

        <h2 class="fw-bold mt-3">
            Editar Atendimento
        </h2>

        <p class="text-muted">
            Atualize o andamento da negociação.
        </p>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form wire:submit="atualizar">

                <div class="row g-3">

                    {{-- CLIENTE --}}
                    <div class="col-md-8">

                        <label class="form-label fw-semibold">
                            Cliente *
                        </label>

                        <select
                            wire:model.live="cliente_id"
                            class="form-select @error('cliente_id') is-invalid @enderror"
                        >

                            <option value="">
                                Selecione um cliente
                            </option>

                            @foreach($clientes as $cliente)

                                <option value="{{ $cliente->id }}">

                                    {{ $cliente->nome }}

                                    @if($cliente->telefone)

                                        - {{ $cliente->telefone }}

                                    @endif

                                </option>

                            @endforeach

                        </select>

                        @error('cliente_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- ORIGEM --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Origem *
                        </label>

                        <select
                            wire:model.live="origem"
                            class="form-select @error('origem') is-invalid @enderror"
                        >

                            <option value="">
                                Selecione
                            </option>

                            <option value="WhatsApp">
                                WhatsApp
                            </option>

                            <option value="Instagram">
                                Instagram
                            </option>

                            <option value="Site">
                                Site
                            </option>

                            <option value="Telefone">
                                Telefone
                            </option>

                            <option value="Indicação">
                                Indicação
                            </option>

                            <option value="Presencial">
                                Presencial
                            </option>

                            <option value="Outro">
                                Outro
                            </option>

                        </select>

                        @error('origem')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- EVENTO --}}
                    <div class="col-md-5">

                        <label class="form-label fw-semibold">
                            Tipo do Evento
                        </label>

                        <select
                            wire:model.live="tipo_evento"
                            class="form-select"
                        >

                            <option value="">
                                Não informado
                            </option>

                            <option value="Casamento">
                                Casamento
                            </option>

                            <option value="Aniversário">
                                Aniversário
                            </option>

                            <option value="Formatura">
                                Formatura
                            </option>

                            <option value="Confraternização">
                                Confraternização
                            </option>

                            <option value="Evento corporativo">
                                Evento corporativo
                            </option>

                            <option value="Chá revelação">
                                Chá revelação
                            </option>

                            <option value="Outro">
                                Outro
                            </option>

                        </select>

                    </div>


                    {{-- DATA --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Data desejada
                        </label>

                        <input
                            type="date"
                            wire:model.live="data_evento"
                            class="form-control"
                        >

                    </div>


                    {{-- STATUS --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Status *
                        </label>

                        <select
                            wire:model.live="status"
                            class="form-select @error('status') is-invalid @enderror"
                        >

                            <option value="novo">
                                Novo
                            </option>

                            <option value="aguardando_data">
                                Aguardando data
                            </option>

                            <option value="orcamento_enviado">
                                Orçamento enviado
                            </option>

                            <option value="aguardando_cliente">
                                Aguardando cliente
                            </option>

                            <option value="negociacao">
                                Negociação
                            </option>

                            <option value="fechado">
                                Fechado
                            </option>

                            <option value="perdido">
                                Perdido
                            </option>

                        </select>

                        @error('status')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- ÚLTIMO CONTATO --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Último contato
                        </label>

                        <input
                            type="datetime-local"
                            wire:model.live="ultimo_contato"
                            class="form-control"
                        >

                    </div>


                    {{-- OBSERVAÇÕES --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Observações
                        </label>

                        <textarea
                            wire:model.live="observacoes"
                            class="form-control"
                            rows="5"
                            placeholder="Informações sobre o atendimento..."
                        ></textarea>

                    </div>


                    {{-- MOTIVO DA PERDA --}}
                    @if($status === 'perdido')

                        <div class="col-12">

                            <label class="form-label fw-semibold text-danger">
                                Motivo da perda
                            </label>

                            <textarea
                                wire:model.live="motivo_perda"
                                class="form-control"
                                rows="3"
                                placeholder="Ex.: preço, data indisponível, cliente escolheu outro local..."
                            ></textarea>

                        </div>

                    @endif

                </div>


                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a
                        href="{{ route('atendimentos.index') }}"
                        class="btn btn-light"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-success"
                        wire:loading.attr="disabled"
                        wire:target="atualizar"
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

</div>