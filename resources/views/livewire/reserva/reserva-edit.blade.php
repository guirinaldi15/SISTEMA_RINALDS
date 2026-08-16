<div class="container py-4">

    <div class="mb-4">

        <a
            href="{{ route('reservas.index') }}"
            class="text-decoration-none"
        >
            ← Voltar
        </a>


        <h2 class="fw-bold mt-3">
            Editar Reserva
        </h2>


        <p class="text-muted">
            Atualize os dados da reserva.
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
                            wire:model="cliente_id"
                            class="form-select
                            @error('cliente_id')
                                is-invalid
                            @enderror"
                        >

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

                                    @if($espaco->capacidade_maxima)

                                        -
                                        até
                                        {{ $espaco->capacidade_maxima }}
                                        pessoas

                                    @endif

                                    @if(!$espaco->ativo)

                                        - Inativo

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


                    {{-- RESUMO DO ESPAÇO --}}
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
                                    class="border rounded bg-light p-3 h-100"
                                >

                                    <div class="fw-semibold">

                                        {{ $espacoSelecionado->nome }}

                                    </div>


                                    <small class="text-muted">

                                        Capacidade:

                                        {{
                                            $espacoSelecionado
                                                ->capacidade_maxima
                                            ?? 'Não informada'
                                        }}

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


                    {{-- TIPO --}}
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
                            class="form-select"
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

                    </div>


                    {{-- HORÁRIO --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Início
                        </label>


                        <input
                            type="time"
                            wire:model="horario_inicio"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Final
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
                                class="form-control"
                            >

                        </div>

                    </div>


                    {{-- OBSERVAÇÕES --}}
                    <div class="col-12">

                        <label class="form-label fw-semibold">
                            Observações
                        </label>


                        <textarea
                            wire:model="observacoes"
                            class="form-control"
                            rows="4"
                        ></textarea>

                    </div>

                </div>


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