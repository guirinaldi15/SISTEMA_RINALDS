<div class="container py-4">

    <div class="mb-4">

        <a
            href="{{ route('reservas.index') }}"
            class="text-decoration-none"
        >
            ← Voltar
        </a>

        <h2 class="fw-bold mt-3">
            Nova Reserva
        </h2>

        <p class="text-muted">
            Cadastre uma nova reserva da Chácara Rinald's.
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


                    {{-- Data --}}

                    <div class="col-md-4">

                        <label class="form-label">
                            Data do Evento *
                        </label>

                        <input
                            type="date"
                            wire:model="data_evento"
                            class="form-control @error('data_evento') is-invalid @enderror"
                        >

                        @error('data_evento')

                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- Tipo do evento --}}

                    <div class="col-md-6">

                        <label class="form-label">
                            Tipo do Evento *
                        </label>

                        <select
                            wire:model="tipo_evento"
                            class="form-select @error('tipo_evento') is-invalid @enderror"
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

                        <label class="form-label">
                            Convidados
                        </label>

                        <input
                            type="number"
                            wire:model="quantidade_convidados"
                            class="form-control"
                            min="1"
                            placeholder="150"
                        >

                    </div>


                    {{-- Status --}}

                    <div class="col-md-3">

                        <label class="form-label">
                            Status
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


                    {{-- Horário início --}}

                    <div class="col-md-3">

                        <label class="form-label">
                            Horário de Início
                        </label>

                        <input
                            type="time"
                            wire:model="horario_inicio"
                            class="form-control"
                        >

                    </div>


                    {{-- Horário final --}}

                    <div class="col-md-3">

                        <label class="form-label">
                            Horário Final
                        </label>

                        <input
                            type="time"
                            wire:model="horario_fim"
                            class="form-control"
                        >

                    </div>


                    {{-- Valor --}}

                    <div class="col-md-6">

                        <label class="form-label">
                            Valor Total
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                R$
                            </span>

                            <input
                                type="number"
                                step="0.01"
                                wire:model="valor_total"
                                class="form-control"
                                placeholder="0,00"
                            >

                        </div>

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
                            placeholder="Informações adicionais sobre a reserva..."
                        ></textarea>

                    </div>

                </div>


                <div class="d-flex justify-content-end gap-2 mt-4">

                    <a
                        href="{{ route('reservas.index') }}"
                        class="btn btn-light"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        Salvar Reserva
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>