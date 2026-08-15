<div class="container-fluid py-4 px-4">

    <div class="mb-4">

        <a
            href="{{ route('pagamentos.index') }}"
            class="text-decoration-none"
        >
            ← Voltar
        </a>

        <h2 class="fw-bold mt-3 mb-1">
            Novo Pagamento
        </h2>

        <p class="text-muted">
            Registre uma cobrança ou pagamento de uma reserva.
        </p>

    </div>


    @if($reserva_id)

        <div class="alert alert-success">

            <strong>
                ✓ Reserva selecionada automaticamente
            </strong>

        </div>

    @endif


    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form wire:submit="salvar">

                <div class="row g-3">


                    <div class="col-md-12">

                        <label
                            class="form-label fw-semibold"
                        >
                            Reserva *
                        </label>

                        <select
                            wire:model="reserva_id"
                            class="form-select
                            @error('reserva_id')
                                is-invalid
                            @enderror"
                        >

                            <option value="">
                                Selecione uma reserva
                            </option>

                            @foreach(
                                $reservas
                                as $reserva
                            )

                                <option
                                    value="{{ $reserva->id }}"
                                >

                                    {{ $reserva
                                        ->cliente
                                        ->nome }}

                                    -

                                    {{ $reserva
                                        ->tipo_evento }}

                                    -

                                    {{ $reserva
                                        ->data_evento
                                        ->format('d/m/Y') }}

                                </option>

                            @endforeach

                        </select>

                        @error('reserva_id')

                            <div
                                class="invalid-feedback"
                            >
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    <div class="col-md-8">

                        <label
                            class="form-label fw-semibold"
                        >
                            Descrição *
                        </label>

                        <input
                            type="text"
                            wire:model="descricao"
                            class="form-control"
                            placeholder="Ex.: Sinal, Parcela 1..."
                        >

                    </div>


                    <div class="col-md-4">

                        <label
                            class="form-label fw-semibold"
                        >
                            Valor *
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                R$
                            </span>

                            <input
                                type="number"
                                step="0.01"
                                min="0.01"
                                wire:model="valor"
                                class="form-control"
                            >

                        </div>

                    </div>


                    <div class="col-md-4">

                        <label
                            class="form-label fw-semibold"
                        >
                            Vencimento *
                        </label>

                        <input
                            type="date"
                            wire:model="data_vencimento"
                            class="form-control"
                        >

                    </div>


                    <div class="col-md-4">

                        <label
                            class="form-label fw-semibold"
                        >
                            Status
                        </label>

                        <select
                            wire:model.live="status"
                            class="form-select"
                        >

                            <option value="pendente">
                                Pendente
                            </option>

                            <option value="pago">
                                Pago
                            </option>

                            <option value="cancelado">
                                Cancelado
                            </option>

                        </select>

                    </div>


                    <div class="col-md-4">

                        <label
                            class="form-label fw-semibold"
                        >
                            Forma de pagamento
                        </label>

                        <select
                            wire:model="forma_pagamento"
                            class="form-select"
                        >

                            <option value="">
                                Não informada
                            </option>

                            <option value="pix">
                                PIX
                            </option>

                            <option value="dinheiro">
                                Dinheiro
                            </option>

                            <option value="cartao_credito">
                                Cartão de crédito
                            </option>

                            <option value="cartao_debito">
                                Cartão de débito
                            </option>

                            <option value="transferencia">
                                Transferência
                            </option>

                            <option value="boleto">
                                Boleto
                            </option>

                            <option value="outro">
                                Outro
                            </option>

                        </select>

                    </div>


                    @if($status === 'pago')

                        <div class="col-md-6">

                            <label
                                class="form-label fw-semibold"
                            >
                                Data do pagamento
                            </label>

                            <input
                                type="date"
                                wire:model="data_pagamento"
                                class="form-control"
                            >

                        </div>

                    @endif


                    <div class="col-12">

                        <label
                            class="form-label fw-semibold"
                        >
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
                        href="{{ route('pagamentos.index') }}"
                        class="btn btn-light"
                    >
                        Cancelar
                    </a>

                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        Salvar Pagamento
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>