<div class="container-fluid py-4 px-4">

    <div
        class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4"
    >

        <div>

            <h2 class="fw-bold mb-1">
                Financeiro
            </h2>

            <p class="text-muted mb-0">
                Controle os pagamentos das reservas.
            </p>

        </div>

        <a
            href="{{ route('pagamentos.create') }}"
            class="btn btn-success"
        >
            + Novo Pagamento
        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- CARDS --}}

    <div class="row g-3 mb-4">

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small
                        class="text-uppercase text-muted fw-semibold"
                    >
                        Total recebido
                    </small>

                    <h3 class="fw-bold text-success mt-2 mb-0">

                        R$

                        {{ number_format(
                            $totalRecebido,
                            2,
                            ',',
                            '.'
                        ) }}

                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small
                        class="text-uppercase text-muted fw-semibold"
                    >
                        A receber
                    </small>

                    <h3 class="fw-bold mt-2 mb-0">

                        R$

                        {{ number_format(
                            $totalPendente,
                            2,
                            ',',
                            '.'
                        ) }}

                    </h3>

                </div>

            </div>

        </div>


        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <small
                        class="text-uppercase text-muted fw-semibold"
                    >
                        Em atraso
                    </small>

                    <h3 class="fw-bold text-danger mt-2 mb-0">

                        R$

                        {{ number_format(
                            $totalAtrasado,
                            2,
                            ',',
                            '.'
                        ) }}

                    </h3>

                </div>

            </div>

        </div>

    </div>


    {{-- FILTROS --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-8">

                    <input
                        type="text"
                        wire:model.live="search"
                        class="form-control"
                        placeholder="Pesquisar cliente ou descrição..."
                    >

                </div>

                <div class="col-md-4">

                    <select
                        wire:model.live="status"
                        class="form-select"
                    >

                        <option value="">
                            Todos
                        </option>

                        <option value="pendente">
                            Pendentes
                        </option>

                        <option value="pago">
                            Pagos
                        </option>

                        <option value="atrasado">
                            Atrasados
                        </option>

                        <option value="cancelado">
                            Cancelados
                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>


    {{-- TABELA --}}

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>
                            <th>Cliente</th>
                            <th>Reserva</th>
                            <th>Descrição</th>
                            <th>Vencimento</th>
                            <th>Valor</th>
                            <th>Forma</th>
                            <th>Status</th>
                            <th class="text-end">
                                Ações
                            </th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse(
                            $pagamentos
                            as $pagamento
                        )

                            <tr
                                class="{{
                                    $pagamento->atrasado
                                    ? 'table-danger'
                                    : ''
                                }}"
                            >

                                <td>

                                    <div class="fw-semibold">

                                        {{ $pagamento
                                            ->reserva
                                            ->cliente
                                            ->nome }}

                                    </div>

                                    <small class="text-muted">

                                        {{ $pagamento
                                            ->reserva
                                            ->cliente
                                            ->telefone }}

                                    </small>

                                </td>


                                <td>

                                    {{ $pagamento
                                        ->reserva
                                        ->tipo_evento }}

                                    <div>

                                        <small class="text-muted">

                                            {{ $pagamento
                                                ->reserva
                                                ->data_evento
                                                ->format(
                                                    'd/m/Y'
                                                ) }}

                                        </small>

                                    </div>

                                </td>


                                <td>

                                    {{ $pagamento->descricao }}

                                </td>


                                <td>

                                    {{ $pagamento
                                        ->data_vencimento
                                        ->format('d/m/Y') }}

                                </td>


                                <td class="fw-semibold">

                                    R$

                                    {{ number_format(
                                        $pagamento->valor,
                                        2,
                                        ',',
                                        '.'
                                    ) }}

                                </td>


                                <td>

                                    @if(
                                        $pagamento
                                            ->forma_pagamento
                                    )

                                        {{ match(
                                            $pagamento
                                                ->forma_pagamento
                                        ) {
                                            'pix' => 'PIX',
                                            'dinheiro' => 'Dinheiro',
                                            'cartao_credito' => 'Cartão de crédito',
                                            'cartao_debito' => 'Cartão de débito',
                                            'transferencia' => 'Transferência',
                                            'boleto' => 'Boleto',
                                            default => 'Outro',
                                        } }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td>

                                    @if(
                                        $pagamento->atrasado
                                    )

                                        <span
                                            class="badge bg-danger"
                                        >
                                            Atrasado
                                        </span>

                                    @elseif(
                                        $pagamento->status
                                        === 'pago'
                                    )

                                        <span
                                            class="badge bg-success"
                                        >
                                            Pago
                                        </span>

                                    @elseif(
                                        $pagamento->status
                                        === 'pendente'
                                    )

                                        <span
                                            class="badge bg-warning text-dark"
                                        >
                                            Pendente
                                        </span>

                                    @else

                                        <span
                                            class="badge bg-secondary"
                                        >
                                            Cancelado
                                        </span>

                                    @endif

                                </td>


                                <td class="text-end">

                                    <div
                                        class="d-flex justify-content-end gap-1 flex-wrap"
                                    >

                                        @if(
                                            $pagamento->status
                                            === 'pendente'
                                        )

                                            <button
                                                wire:click="marcarComoPago({{ $pagamento->id }})"
                                                class="btn btn-sm btn-success"
                                            >
                                                ✓ Pago
                                            </button>

                                        @endif


                                        <a
                                            href="{{ route(
                                                'pagamentos.edit',
                                                $pagamento->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            Editar
                                        </a>


                                        <a
                                            href="{{ route(
                                                'pagamentos.delete',
                                                $pagamento->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-danger"
                                        >
                                            Excluir
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="8"
                                    class="text-center py-5 text-muted"
                                >
                                    Nenhum pagamento encontrado.
                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>