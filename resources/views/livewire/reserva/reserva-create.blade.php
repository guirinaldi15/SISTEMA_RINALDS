<div class="container py-4">

    {{-- ====================================================== --}}
    {{-- CABEÇALHO --}}
    {{-- ====================================================== --}}

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


    {{-- ====================================================== --}}
    {{-- ORIGEM DA RESERVA --}}
    {{-- ====================================================== --}}

    @if($orcamento_id)

        <div class="alert alert-success shadow-sm">

            <div class="fw-bold">
                ✓ Reserva originada de orçamento aceito
            </div>

            <div class="small mt-1">

                Cliente, espaço, data, tipo do evento,
                convidados e valor foram preenchidos
                automaticamente com os dados do orçamento.

            </div>

        </div>

    @elseif($atendimento_id)

        <div class="alert alert-success shadow-sm">

            <div class="fw-bold">
                ✓ Reserva originada de um atendimento
            </div>

            <div class="small mt-1">

                Cliente, data desejada e tipo do evento
                foram preenchidos automaticamente.

            </div>

        </div>

    @endif


    {{-- ====================================================== --}}
    {{-- CARD --}}
    {{-- ====================================================== --}}

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
                            class="form-select
                            @error('cliente_id')
                                is-invalid
                            @enderror"
                        >

                            <option value="">
                                Selecione um cliente
                            </option>


                            @foreach(
                                $clientes
                                as $cliente
                            )

                                <option
                                    value="{{ $cliente->id }}"
                                >

                                    {{ $cliente->nome }}

                                    @if($cliente->telefone)

                                        -
                                        {{ $cliente->telefone }}

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


                    {{-- DATA --}}
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


                    {{-- ESPAÇO --}}
                    <div class="col-md-8">

                        <label class="form-label fw-semibold">
                            Espaço *
                        </label>


                        <select
                            wire:model.live="espaco_id"
                            class="form-select
                            @error('espaco_id')
                                is-invalid
                            @enderror"
                        >

                            <option value="">
                                Selecione um espaço
                            </option>


                            @foreach(
                                $espacos
                                as $espaco
                            )

                                <option
                                    value="{{ $espaco->id }}"
                                >

                                    {{ $espaco->nome }}

                                    @if(
                                        $espaco->capacidade_maxima
                                    )

                                        -
                                        até
                                        {{
                                            $espaco
                                                ->capacidade_maxima
                                        }}
                                        pessoas

                                    @endif

                                </option>

                            @endforeach

                        </select>


                        @error('espaco_id')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- INFORMAÇÕES DO ESPAÇO --}}
                    <div class="col-md-4">

                        @if($espaco_id)

                            @php

                                $espacoSelecionado =
                                    $espacos->firstWhere(
                                        'id',
                                        $espaco_id
                                    );

                            @endphp


                            @if($espacoSelecionado)

                                <div
                                    class="border rounded p-3 bg-light h-100"
                                >

                                    <div class="fw-semibold">

                                        {{
                                            $espacoSelecionado
                                                ->nome
                                        }}

                                    </div>


                                    <small class="text-muted">

                                        Capacidade:

                                        {{
                                            $espacoSelecionado
                                                ->capacidade_maxima
                                            ??
                                            'Não informada'
                                        }}

                                        pessoas

                                    </small>


                                    <br>


                                    <small class="text-muted">

                                        Mesas:

                                        {{
                                            $espacoSelecionado
                                                ->quantidade_mesas
                                        }}

                                    </small>


                                    <br>


                                    <small class="text-muted">

                                        Cadeiras:

                                        {{
                                            $espacoSelecionado
                                                ->quantidade_cadeiras
                                        }}

                                    </small>

                                </div>

                            @endif

                        @endif

                    </div>


                    {{-- TIPO DO EVENTO --}}
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

                            <option value="Debutante">
                                Debutante
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


                    {{-- CONVIDADOS --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Convidados
                        </label>


                        <input
                            type="number"
                            min="1"
                            wire:model="quantidade_convidados"
                            class="form-control
                            @error('quantidade_convidados')
                                is-invalid
                            @enderror"
                            placeholder="Ex.: 150"
                        >


                        @error('quantidade_convidados')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- STATUS --}}
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


                    {{-- HORÁRIO --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Horário de Início
                        </label>


                        <input
                            type="time"
                            wire:model="horario_inicio"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Horário Final
                        </label>


                        <input
                            type="time"
                            wire:model="horario_fim"
                            class="form-control"
                        >

                    </div>


                    {{-- VALOR --}}
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


                    {{-- OBSERVAÇÕES --}}
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


                {{-- IDs RELACIONADOS --}}

                @if($atendimento_id)

                    <input
                        type="hidden"
                        wire:model="atendimento_id"
                    >

                @endif


                @if($orcamento_id)

                    <input
                        type="hidden"
                        wire:model="orcamento_id"
                    >

                @endif


                {{-- BOTÕES --}}
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