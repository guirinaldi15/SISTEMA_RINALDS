<div class="container py-4">

    {{-- Cabeçalho --}}
    <div class="mb-4">

        <a
            href="{{ route('reservas.index') }}"
            class="text-decoration-none"
        >
            ← Voltar
        </a>

        <h2 class="fw-bold mt-3 mb-1">
            Nova Reserva
        </h2>

        <p class="text-muted">
            Cadastre uma nova reserva da Chácara Rinald's.
        </p>

    </div>


    {{-- Reserva originada de atendimento --}}
    @if($atendimento_id)

        <div class="alert alert-success shadow-sm">

            <div class="fw-bold">
                ✓ Reserva originada de um atendimento
            </div>

            <div class="small mt-1">
                Cliente, data desejada e tipo do evento foram preenchidos
                automaticamente com os dados do atendimento.
            </div>

        </div>

    @endif


    {{-- Card principal --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form wire:submit="salvar">

                <div class="row g-3">


                    {{-- Cliente --}}
                    <div class="col-md-8">

                        <label class="form-label fw-semibold">
                            Cliente *
                        </label>

                        <select
                            wire:model="cliente_id"
                            class="form-select
                            @error('cliente_id')
                                is-invalid
                            @enderror"
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


                    {{-- Data --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Data do Evento *
                        </label>

                        <input
                            type="date"
                            wire:model="data_evento"
                            class="form-control
                            @error('data_evento')
                                is-invalid
                            @enderror"
                        >

                        @error('data_evento')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Tipo do evento --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Tipo do Evento *
                        </label>

                        <select
                            wire:model="tipo_evento"
                            class="form-select
                            @error('tipo_evento')
                                is-invalid
                            @enderror"
                        >

                            <option value="">
                                Selecione
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

                        @error('tipo_evento')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Convidados --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Convidados
                        </label>

                        <input
                            type="number"
                            wire:model="quantidade_convidados"
                            class="form-control
                            @error('quantidade_convidados')
                                is-invalid
                            @enderror"
                            min="1"
                            placeholder="Ex.: 150"
                        >

                        @error('quantidade_convidados')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Status --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Status *
                        </label>

                        <select
                            wire:model="status"
                            class="form-select
                            @error('status')
                                is-invalid
                            @enderror"
                        >

                            <option value="pre_reserva">
                                Pré-reserva
                            </option>

                            <option value="confirmada">
                                Confirmada
                            </option>

                            <option value="cancelada">
                                Cancelada
                            </option>

                            <option value="realizada">
                                Realizada
                            </option>

                        </select>

                        @error('status')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Horário inicial --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Horário de Início
                        </label>

                        <input
                            type="time"
                            wire:model="horario_inicio"
                            class="form-control
                            @error('horario_inicio')
                                is-invalid
                            @enderror"
                        >

                        @error('horario_inicio')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Horário final --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Horário Final
                        </label>

                        <input
                            type="time"
                            wire:model="horario_fim"
                            class="form-control
                            @error('horario_fim')
                                is-invalid
                            @enderror"
                        >

                        @error('horario_fim')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Valor --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Valor Total
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                R$
                            </span>

                            <input
                                type="number"
                                step="0.01"
                                min="0"
                                wire:model="valor_total"
                                class="form-control
                                @error('valor_total')
                                    is-invalid
                                @enderror"
                                placeholder="0,00"
                            >

                            @error('valor_total')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>


                    {{-- Observações --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Observações
                        </label>

                        <textarea
                            wire:model="observacoes"
                            class="form-control
                            @error('observacoes')
                                is-invalid
                            @enderror"
                            rows="4"
                            placeholder="Informações adicionais sobre a reserva..."
                        ></textarea>

                        @error('observacoes')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>

                </div>


                {{-- Atendimento relacionado --}}
                @if($atendimento_id)

                    <input
                        type="hidden"
                        wire:model="atendimento_id"
                    >

                @endif


                {{-- Botões --}}
                <div
                    class="d-flex justify-content-end gap-2 mt-4"
                >

                    <a
                        href="{{ route('reservas.index') }}"
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
                            Salvar Reserva
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