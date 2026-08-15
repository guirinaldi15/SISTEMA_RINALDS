<div class="container py-4">

    {{-- Cabeçalho --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

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


    {{-- Mensagem de sucesso --}}
    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    {{-- Filtros --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3">

                {{-- Pesquisa --}}
                <div class="col-md-8">

                    <input
                        type="text"
                        wire:model.live="search"
                        class="form-control"
                        placeholder="Pesquisar cliente ou telefone..."
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


    {{-- Tabela --}}
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

                                {{-- Cliente --}}
                                <td>

                                    <div class="fw-semibold">
                                        {{ $atendimento->cliente->nome }}
                                    </div>

                                    <small class="text-muted">
                                        {{ $atendimento->cliente->telefone }}
                                    </small>

                                </td>


                                {{-- Origem --}}
                                <td>

                                    @if($atendimento->origem === 'WhatsApp')

                                        <span class="badge bg-success">
                                            WhatsApp
                                        </span>

                                    @elseif($atendimento->origem === 'Instagram')

                                        <span class="badge bg-danger">
                                            Instagram
                                        </span>

                                    @elseif($atendimento->origem === 'Telefone')

                                        <span class="badge bg-primary">
                                            Telefone
                                        </span>

                                    @elseif($atendimento->origem === 'Indicação')

                                        <span class="badge bg-warning text-dark">
                                            Indicação
                                        </span>

                                    @elseif($atendimento->origem === 'Presencial')

                                        <span class="badge bg-secondary">
                                            Presencial
                                        </span>

                                    @else

                                        <span class="badge bg-dark">
                                            {{ $atendimento->origem }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Evento --}}
                                <td>
                                    {{ $atendimento->tipo_evento ?? '-' }}
                                </td>


                                {{-- Data --}}
                                <td>

                                    @if($atendimento->data_evento)

                                        {{ $atendimento->data_evento->format('d/m/Y') }}

                                    @else

                                        <span class="text-muted">
                                            Não informada
                                        </span>

                                    @endif

                                </td>


                                {{-- Status --}}
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


                                {{-- Último contato --}}
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


                                {{-- Ações --}}
                                <td class="text-end">

                                    @php

                                        $telefone = preg_replace(
                                            '/\D/',
                                            '',
                                            $atendimento->cliente->telefone
                                        );

                                    @endphp


                                    {{-- Criar lembrete --}}
                                    <a
                                        href="{{ route(
                                            'lembretes.create',
                                            [
                                                'atendimento' =>
                                                    $atendimento->id
                                            ]
                                        ) }}"
                                        class="btn btn-sm btn-outline-warning mb-1"
                                    >
                                        ⏰ Lembrar
                                    </a>


                                    {{-- WhatsApp --}}
                                    <a
                                        href="https://wa.me/55{{ $telefone }}"
                                        target="_blank"
                                        class="btn btn-sm btn-success mb-1"
                                    >
                                        WhatsApp
                                    </a>


                                    {{-- Editar --}}
                                    <a
                                        href="{{ route(
                                            'atendimentos.edit',
                                            $atendimento->id
                                        ) }}"
                                        class="btn btn-sm btn-outline-primary mb-1"
                                    >
                                        Editar
                                    </a>


                                    {{-- Excluir --}}
                                    <a
                                        href="{{ route(
                                            'atendimentos.delete',
                                            $atendimento->id
                                        ) }}"
                                        class="btn btn-sm btn-outline-danger mb-1"
                                    >
                                        Excluir
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center text-muted py-5"
                                >

                                    Nenhum atendimento encontrado.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>