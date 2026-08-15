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


                    {{-- Cliente --}}
                    <div class="col-md-8">

                        <label class="form-label">
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


                    {{-- Origem --}}
                    <div class="col-md-4">

                        <label class="form-label">
                            Origem
                        </label>

                        <select
                            wire:model="origem"
                            class="form-select"
                        >

                            <option value="WhatsApp">
                                WhatsApp
                            </option>

                            <option value="Instagram">
                                Instagram
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

                    </div>


                    {{-- Evento --}}
                    <div class="col-md-6">

                        <label class="form-label">
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

                            <option value="Outro">
                                Outro
                            </option>

                        </select>

                    </div>


                    {{-- Data --}}
                    <div class="col-md-3">

                        <label class="form-label">
                            Data desejada
                        </label>

                        <input
                            type="date"
                            wire:model="data_evento"
                            class="form-control"
                        >

                    </div>


                    {{-- Status --}}
                    <div class="col-md-3">

                        <label class="form-label">
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


                    {{-- Observações --}}
                    <div class="col-12">

                        <label class="form-label">
                            Observações do atendimento
                        </label>

                        <textarea
                            wire:model="observacoes"
                            class="form-control"
                            rows="4"
                            placeholder="Ex.: Cliente perguntou valor para casamento de aproximadamente 150 convidados..."
                        ></textarea>

                    </div>


                    {{-- Motivo da perda --}}

                    @if($status === 'perdido')

                        <div class="col-12">

                            <label class="form-label text-danger">
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
                    >
                        Salvar Atendimento
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>