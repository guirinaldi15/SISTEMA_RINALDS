<div class="container-fluid py-4 px-4">

    {{-- CABEÇALHO --}}
    <div
        class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4"
    >

        <div>

            <h2 class="fw-bold mb-1">
                Atendimentos
            </h2>

            <p class="text-muted mb-0">
                Acompanhe os clientes interessados na Chácara Rinald's.
            </p>

        </div>


        <a
            href="{{ route('atendimentos.create') }}"
            class="btn btn-success"
        >
            + Novo Atendimento
        </a>

    </div>


    {{-- SUCESSO --}}
    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- FILTROS --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-8">

                    <input
                        type="text"
                        wire:model.live="search"
                        class="form-control"
                        placeholder="Pesquisar cliente ou telefone..."
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
                            <th>Origem</th>
                            <th>Evento</th>
                            <th>Data desejada</th>
                            <th>Status</th>
                            <th>Último contato</th>
                            <th class="text-end">
                                Ações
                            </th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($atendimentos as $atendimento)

                            <tr>

                                {{-- CLIENTE --}}
                                <td>

                                    <div class="fw-semibold">
                                        {{ $atendimento->cliente->nome }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $atendimento->cliente->telefone }}
                                    </small>

                                </td>


                                {{-- ORIGEM --}}
                                <td>

                                    @switch($atendimento->origem)

                                        @case('WhatsApp')

                                            <span class="badge bg-success">
                                                WhatsApp
                                            </span>

                                        @break


                                        @case('Instagram')

                                            <span class="badge bg-danger">
                                                Instagram
                                            </span>

                                        @break


                                        @case('Site')

                                            <span class="badge bg-info text-dark">
                                                🌐 Site
                                            </span>

                                        @break


                                        @case('Telefone')

                                            <span class="badge bg-primary">
                                                Telefone
                                            </span>

                                        @break


                                        @case('Indicação')

                                            <span class="badge bg-warning text-dark">
                                                Indicação
                                            </span>

                                        @break


                                        @case('Presencial')

                                            <span class="badge bg-secondary">
                                                Presencial
                                            </span>

                                        @break


                                        @default

                                            <span class="badge bg-dark">
                                                {{ $atendimento->origem }}
                                            </span>

                                    @endswitch

                                </td>


                                {{-- EVENTO --}}
                                <td>

                                    {{ $atendimento->tipo_evento ?? '-' }}

                                </td>


                                {{-- DATA --}}
                                <td>

                                    @if($atendimento->data_evento)

                                        {{ $atendimento
                                            ->data_evento
                                            ->format('d/m/Y') }}

                                    @else

                                        <span class="text-muted">
                                            Não informada
                                        </span>

                                    @endif

                                </td>


                                {{-- STATUS --}}
                                <td>

                                    @switch($atendimento->status)

                                        @case('novo')

                                            <span class="badge bg-primary">
                                                Novo
                                            </span>

                                        @break


                                        @case('aguardando_data')

                                            <span class="badge bg-info text-dark">
                                                Aguardando data
                                            </span>

                                        @break


                                        @case('orcamento_enviado')

                                            <span class="badge bg-warning text-dark">
                                                Orçamento enviado
                                            </span>

                                        @break


                                        @case('aguardando_cliente')

                                            <span class="badge bg-warning text-dark">
                                                Aguardando cliente
                                            </span>

                                        @break


                                        @case('negociacao')

                                            <span class="badge bg-secondary">
                                                Negociação
                                            </span>

                                        @break


                                        @case('fechado')

                                            <span class="badge bg-success">
                                                Fechado
                                            </span>

                                        @break


                                        @case('perdido')

                                            <span class="badge bg-danger">
                                                Perdido
                                            </span>

                                        @break

                                    @endswitch

                                </td>


                                {{-- ÚLTIMO CONTATO --}}
                                <td>

                                    @if($atendimento->ultimo_contato)

                                        {{ $atendimento
                                            ->ultimo_contato
                                            ->format('d/m/Y H:i') }}

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>


                                {{-- AÇÕES --}}
                                <td class="text-end">

                                    @php

                                        $telefone =
                                            preg_replace(
                                                '/\D/',
                                                '',
                                                $atendimento
                                                    ->cliente
                                                    ->telefone
                                            );

                                    @endphp


                                    <div
                                        class="d-flex justify-content-end gap-1 flex-wrap"
                                    >

                                        {{-- ORÇAMENTO --}}
                                        <a
                                            href="{{ route(
                                                'orcamentos.create',
                                                [
                                                    'atendimento'
                                                    =>
                                                    $atendimento->id
                                                ]
                                            ) }}"
                                            class="btn btn-sm btn-outline-dark"
                                        >
                                            💰 Orçamento
                                        </a>


                                        {{-- RESERVA --}}
                                        @if(!$atendimento->reserva)

                                            <a
                                                href="{{ route(
                                                    'reservas.create',
                                                    [
                                                        'atendimento'
                                                        =>
                                                        $atendimento->id
                                                    ]
                                                ) }}"
                                                class="btn btn-sm btn-primary"
                                            >
                                                🎉 Criar Reserva
                                            </a>

                                        @else

                                            <span
                                                class="badge bg-success d-flex align-items-center"
                                            >
                                                ✓ Reservado
                                            </span>

                                        @endif


                                        {{-- LEMBRETE --}}
                                        <a
                                            href="{{ route(
                                                'lembretes.create',
                                                [
                                                    'atendimento'
                                                    =>
                                                    $atendimento->id
                                                ]
                                            ) }}"
                                            class="btn btn-sm btn-outline-warning"
                                        >
                                            ⏰ Lembrar
                                        </a>


                                        {{-- WHATSAPP --}}
                                        <a
                                            href="https://wa.me/55{{ $telefone }}"
                                            target="_blank"
                                            class="btn btn-sm btn-success"
                                        >
                                            WhatsApp
                                        </a>


                                        {{-- EDITAR --}}
                                        <a
                                            href="{{ route(
                                                'atendimentos.edit',
                                                $atendimento->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            Editar
                                        </a>


                                        {{-- EXCLUIR --}}
                                        <a
                                            href="{{ route(
                                                'atendimentos.delete',
                                                $atendimento->id
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
                                        💬
                                    </div>

                                    <div class="fw-semibold">
                                        Nenhum atendimento encontrado
                                    </div>

                                    <p class="text-muted mb-3">
                                        Registre um atendimento para começar.
                                    </p>

                                    <a
                                        href="{{ route('atendimentos.create') }}"
                                        class="btn btn-success"
                                    >
                                        + Novo Atendimento
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