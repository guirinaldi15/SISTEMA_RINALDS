<div class="container-fluid py-4 px-4">

    <div
        class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4"
    >

        <div>

            <h2 class="fw-bold mb-1">
                Orçamentos
            </h2>

            <p class="text-muted mb-0">
                Gerencie os orçamentos da Chácara Rinald's.
            </p>

        </div>

        <a
            href="{{ route('orcamentos.create') }}"
            class="btn btn-success"
        >
            + Novo Orçamento
        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-8">

                    <input
                        type="text"
                        wire:model.live="search"
                        class="form-control"
                        placeholder="Pesquisar cliente ou número do orçamento..."
                    >

                </div>

                <div class="col-md-4">

                    <select
                        wire:model.live="status"
                        class="form-select"
                    >

                        <option value="">
                            Todos os status
                        </option>

                        <option value="rascunho">
                            Rascunho
                        </option>

                        <option value="enviado">
                            Enviado
                        </option>

                        <option value="aceito">
                            Aceito
                        </option>

                        <option value="recusado">
                            Recusado
                        </option>

                        <option value="expirado">
                            Expirado
                        </option>

                    </select>

                </div>

            </div>

        </div>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>
                            <th>Número</th>
                            <th>Cliente</th>
                            <th>Evento</th>
                            <th>Validade</th>
                            <th>Valor</th>
                            <th>Status</th>
                            <th class="text-end">
                                Ações
                            </th>
                        </tr>

                    </thead>

                    <tbody>

                        @forelse($orcamentos as $orcamento)

                            <tr>

                                <td class="fw-semibold">

                                    {{ $orcamento->numero }}

                                </td>


                                <td>

                                    <div class="fw-semibold">

                                        {{ $orcamento
                                            ->atendimento
                                            ->cliente
                                            ->nome }}

                                    </div>

                                    <small class="text-muted">

                                        {{ $orcamento
                                            ->atendimento
                                            ->cliente
                                            ->telefone }}

                                    </small>

                                </td>


                                <td>

                                    {{ $orcamento
                                        ->atendimento
                                        ->tipo_evento
                                        ?? '-' }}

                                </td>


                                <td>

                                    @if($orcamento->validade)

                                        {{ $orcamento
                                            ->validade
                                            ->format('d/m/Y') }}

                                    @else

                                        -

                                    @endif

                                </td>


                                <td class="fw-semibold">

                                    R$

                                    {{ number_format(
                                        $orcamento->valor_total,
                                        2,
                                        ',',
                                        '.'
                                    ) }}

                                </td>


                                <td>

                                    @switch($orcamento->status)

                                        @case('rascunho')

                                            <span class="badge bg-secondary">
                                                Rascunho
                                            </span>

                                        @break


                                        @case('enviado')

                                            <span class="badge bg-primary">
                                                Enviado
                                            </span>

                                        @break


                                        @case('aceito')

                                            <span class="badge bg-success">
                                                Aceito
                                            </span>

                                        @break


                                        @case('recusado')

                                            <span class="badge bg-danger">
                                                Recusado
                                            </span>

                                        @break


                                        @case('expirado')

                                            <span
                                                class="badge bg-warning text-dark"
                                            >
                                                Expirado
                                            </span>

                                        @break

                                    @endswitch

                                </td>


                                <td class="text-end">

                                    <div
                                        class="d-flex justify-content-end gap-1 flex-wrap"
                                    >

                                        @php

                                            $telefone =
                                                preg_replace(
                                                    '/\D/',
                                                    '',
                                                    $orcamento
                                                        ->atendimento
                                                        ->cliente
                                                        ->telefone
                                                );

                                            $mensagem =
                                                urlencode(
                                                    "Olá! Segue o orçamento {$orcamento->numero} da Chácara Rinald's. Valor total: R$ "
                                                    . number_format(
                                                        $orcamento->valor_total,
                                                        2,
                                                        ',',
                                                        '.'
                                                    )
                                                );

                                        @endphp


                                        <a
                                            href="https://wa.me/55{{ $telefone }}?text={{ $mensagem }}"
                                            target="_blank"
                                            class="btn btn-sm btn-success"
                                        >
                                            WhatsApp
                                        </a>


                                        <a
                                            href="{{ route(
                                                'orcamentos.edit',
                                                $orcamento->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            Editar
                                        </a>


                                        <a
                                            href="{{ route(
                                                'orcamentos.delete',
                                                $orcamento->id
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
                                    colspan="7"
                                    class="text-center py-5 text-muted"
                                >

                                    Nenhum orçamento encontrado.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>