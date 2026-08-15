<div class="container-fluid py-4 px-4">

    {{-- ====================================================== --}}
    {{-- CABEÇALHO --}}
    {{-- ====================================================== --}}

    <div
        class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4"
    >

        <div>

            <h2 class="fw-bold mb-1">
                Orçamentos
            </h2>

            <p class="text-muted mb-0">
                Gerencie as propostas comerciais da Chácara Rinald's.
            </p>

        </div>

        <a
            href="{{ route('orcamentos.create') }}"
            class="btn btn-success"
        >
            + Novo Orçamento
        </a>

    </div>


    {{-- ====================================================== --}}
    {{-- MENSAGEM DE SUCESSO --}}
    {{-- ====================================================== --}}

    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- ====================================================== --}}
    {{-- FILTROS --}}
    {{-- ====================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3">

                {{-- Pesquisa --}}
                <div class="col-md-8">

                    <input
                        type="text"
                        wire:model.live="search"
                        class="form-control"
                        placeholder="Pesquisar cliente ou número do orçamento..."
                    >

                </div>


                {{-- Status --}}
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


    {{-- ====================================================== --}}
    {{-- TABELA --}}
    {{-- ====================================================== --}}

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

                                {{-- ====================================================== --}}
                                {{-- NÚMERO --}}
                                {{-- ====================================================== --}}

                                <td>

                                    <a
                                        href="{{ route(
                                            'orcamentos.show',
                                            $orcamento->id
                                        ) }}"
                                        class="fw-semibold text-decoration-none"
                                    >
                                        {{ $orcamento->numero }}
                                    </a>

                                </td>


                                {{-- ====================================================== --}}
                                {{-- CLIENTE --}}
                                {{-- ====================================================== --}}

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


                                {{-- ====================================================== --}}
                                {{-- EVENTO --}}
                                {{-- ====================================================== --}}

                                <td>

                                    <div class="fw-semibold">

                                        {{ $orcamento
                                            ->atendimento
                                            ->tipo_evento
                                            ?? 'Não informado' }}

                                    </div>


                                    @if(
                                        $orcamento
                                            ->atendimento
                                            ->data_evento
                                    )

                                        <small class="text-muted">

                                            {{ $orcamento
                                                ->atendimento
                                                ->data_evento
                                                ->format('d/m/Y') }}

                                        </small>

                                    @endif

                                </td>


                                {{-- ====================================================== --}}
                                {{-- VALIDADE --}}
                                {{-- ====================================================== --}}

                                <td>

                                    @if($orcamento->validade)

                                        {{ $orcamento
                                            ->validade
                                            ->format('d/m/Y') }}


                                        @if(
                                            $orcamento->status !== 'aceito'
                                            &&
                                            $orcamento->status !== 'recusado'
                                            &&
                                            $orcamento->validade->isPast()
                                        )

                                            <div class="mt-1">

                                                <span
                                                    class="badge bg-danger"
                                                >
                                                    Vencido
                                                </span>

                                            </div>

                                        @endif

                                    @else

                                        <span class="text-muted">
                                            Não informada
                                        </span>

                                    @endif

                                </td>


                                {{-- ====================================================== --}}
                                {{-- VALOR --}}
                                {{-- ====================================================== --}}

                                <td>

                                    <div class="fw-bold">

                                        R$

                                        {{ number_format(
                                            (float) $orcamento->valor_total,
                                            2,
                                            ',',
                                            '.'
                                        ) }}

                                    </div>


                                    @if(
                                        $orcamento->desconto
                                        &&
                                        $orcamento->desconto > 0
                                    )

                                        <small class="text-success">

                                            Desconto:
                                            R$

                                            {{ number_format(
                                                (float) $orcamento->desconto,
                                                2,
                                                ',',
                                                '.'
                                            ) }}

                                        </small>

                                    @endif

                                </td>


                                {{-- ====================================================== --}}
                                {{-- STATUS --}}
                                {{-- ====================================================== --}}

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


                                        @default

                                            <span class="badge bg-dark">

                                                {{ ucfirst(
                                                    $orcamento->status
                                                ) }}

                                            </span>

                                    @endswitch

                                </td>


                                {{-- ====================================================== --}}
                                {{-- AÇÕES --}}
                                {{-- ====================================================== --}}

                                <td class="text-end">

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


                                        $cliente =
                                            $orcamento
                                                ->atendimento
                                                ->cliente
                                                ->nome;


                                        $evento =
                                            $orcamento
                                                ->atendimento
                                                ->tipo_evento
                                                ?? 'evento';


                                        $dataEvento =
                                            $orcamento
                                                ->atendimento
                                                ->data_evento
                                                ?->format('d/m/Y');


                                        $validade =
                                            $orcamento
                                                ->validade
                                                ?->format('d/m/Y');


                                        $valor =
                                            number_format(
                                                (float)
                                                $orcamento->valor_total,
                                                2,
                                                ',',
                                                '.'
                                            );


                                        $mensagem =
                                            "Olá {$cliente}! Tudo bem?\n\n"
                                            . "Preparamos o orçamento da Chácara Rinald's para seu {$evento}.\n\n"
                                            . "📄 Orçamento: {$orcamento->numero}\n"
                                            . (
                                                $dataEvento
                                                ? "📅 Data do evento: {$dataEvento}\n"
                                                : ''
                                            )
                                            . "💰 Valor total: R$ {$valor}\n"
                                            . (
                                                $validade
                                                ? "⏳ Validade da proposta: {$validade}\n"
                                                : ''
                                            )
                                            . "\nQualquer dúvida, estamos à disposição!";


                                        $mensagemWhatsapp =
                                            urlencode($mensagem);

                                    @endphp


                                    <div
                                        class="d-flex justify-content-end gap-1 flex-wrap"
                                    >


                                        {{-- Visualizar --}}
                                        <a
                                            href="{{ route(
                                                'orcamentos.show',
                                                $orcamento->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-success"
                                        >
                                            Visualizar
                                        </a>


                                        {{-- WhatsApp --}}
                                        <a
                                            href="https://wa.me/55{{ $telefone }}?text={{ $mensagemWhatsapp }}"
                                            target="_blank"
                                            class="btn btn-sm btn-success"
                                        >
                                            WhatsApp
                                        </a>


                                        {{-- Editar --}}
                                        <a
                                            href="{{ route(
                                                'orcamentos.edit',
                                                $orcamento->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            Editar
                                        </a>


                                        {{-- Excluir --}}
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
                                    class="text-center py-5"
                                >

                                    <div class="fs-1 mb-3">
                                        💰
                                    </div>

                                    <div class="fw-semibold">
                                        Nenhum orçamento encontrado
                                    </div>

                                    <p class="text-muted mb-3">
                                        Crie seu primeiro orçamento para começar.
                                    </p>

                                    <a
                                        href="{{ route('orcamentos.create') }}"
                                        class="btn btn-success"
                                    >
                                        + Novo Orçamento
                                    </a>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>