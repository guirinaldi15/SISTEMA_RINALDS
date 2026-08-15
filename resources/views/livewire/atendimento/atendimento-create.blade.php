<div class="container py-4">

    <div class="mb-4">

        <a
            href="{{ route('atendimentos.index') }}"
            class="text-decoration-none"
        >
            ← Voltar
        </a>

        <h2 class="fw-bold mt-3">
            Novo Atendimento
        </h2>

        <p class="text-muted">
            Registre um novo contato de cliente.
        </p>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form wire:submit="salvar">

                <div class="row g-3">

                    {{-- CLIENTE --}}
                    <div class="col-md-8">

                        <label class="form-label fw-semibold">
                            Cliente *
                        </label>

                        <select
                            wire:model="cliente_id"
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
                            wire:model="origem"
                            class="form-select @error('origem') is-invalid @enderror"
                        >

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
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Tipo do Evento
                        </label>

                        <select
                            wire:model="tipo_evento"
                            class="form-select"
                        >

                            <option value="">
                                Ainda não informado
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
                            wire:model="data_evento"
                            class="form-control"
                        >

                    </div>


                    {{-- STATUS --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Status
                        </label>

                        <select
                            wire:model.live="status"
                            class="form-select"
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

                    </div>


                    {{-- OBSERVAÇÕES --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Observações do atendimento
                        </label>

                        <textarea
                            wire:model="observacoes"
                            class="form-control"
                            rows="4"
                            placeholder="Ex.: Cliente perguntou valor para casamento de aproximadamente 150 convidados..."
                        ></textarea>

                    </div>


                    {{-- MOTIVO DA PERDA --}}
                    @if($status === 'perdido')

                        <div class="col-12">

                            <label class="form-label fw-semibold text-danger">
                                Motivo da perda
                            </label>

                            <textarea
                                wire:model="motivo_perda"
                                class="form-control"
                                rows="3"
                                placeholder="Ex.: preço, data indisponível, escolheu outro local..."
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
                        wire:target="salvar"
                    >

                        <span
                            wire:loading.remove
                            wire:target="salvar"
                        >
                            Salvar Atendimento
                        </span>

                        <span
                            wire:loading
                            wire:target="salvar"
                        >
                            Salvando...
                        </span>

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>