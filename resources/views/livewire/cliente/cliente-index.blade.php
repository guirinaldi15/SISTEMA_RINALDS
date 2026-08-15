<div class="container-fluid py-4 px-4">

    {{-- ====================================================== --}}
    {{-- CABEÇALHO --}}
    {{-- ====================================================== --}}

    <div
        class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4"
    >

        <div>

            <h2 class="fw-bold mb-1">
                Clientes
            </h2>

            <p class="text-muted mb-0">
                Gerencie os clientes da Chácara Rinald's.
            </p>

        </div>


        <a
            href="{{ route('clientes.create') }}"
            class="btn btn-success"
        >
            + Novo Cliente
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
    {{-- PESQUISA --}}
    {{-- ====================================================== --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3 align-items-center">

                <div class="col-md-9">

                    <input
                        type="text"
                        wire:model.live="search"
                        class="form-control"
                        placeholder="Pesquisar por nome ou telefone..."
                    >

                </div>


                <div class="col-md-3">

                    <div class="text-md-end text-muted">

                        <small>
                            {{ $clientes->count() }}
                            {{ $clientes->count() == 1 ? 'cliente encontrado' : 'clientes encontrados' }}
                        </small>

                    </div>

                </div>

            </div>

        </div>

    </div>


    {{-- ====================================================== --}}
    {{-- LISTAGEM --}}
    {{-- ====================================================== --}}

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>

                        <tr>
                            <th>Cliente</th>
                            <th>Telefone</th>
                            <th>E-mail</th>
                            <th>Localização</th>
                            <th>CEP</th>
                            <th class="text-end">
                                Ações
                            </th>
                        </tr>

                    </thead>


                    <tbody>

                        @forelse($clientes as $cliente)

                            <tr>


                                {{-- Cliente --}}
                                <td>

                                    <div class="d-flex align-items-center gap-3">

                                        {{-- Avatar simples --}}
                                        <div
                                            class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center fw-bold"
                                            style="
                                                width: 42px;
                                                height: 42px;
                                                min-width: 42px;
                                            "
                                        >

                                            {{ strtoupper(
                                                substr(
                                                    $cliente->nome,
                                                    0,
                                                    1
                                                )
                                            ) }}

                                        </div>


                                        <div>

                                            <div class="fw-semibold">

                                                {{ $cliente->nome }}

                                            </div>


                                            @if($cliente->cpf_cnpj)

                                                <small class="text-muted">

                                                    CPF/CNPJ:
                                                    {{ $cliente->cpf_cnpj }}

                                                </small>

                                            @else

                                                <small class="text-muted">
                                                    Sem CPF/CNPJ
                                                </small>

                                            @endif

                                        </div>

                                    </div>

                                </td>


                                {{-- Telefone --}}
                                <td>

                                    {{ $cliente->telefone }}

                                </td>


                                {{-- Email --}}
                                <td>

                                    @if($cliente->email)

                                        {{ $cliente->email }}

                                    @else

                                        <span class="text-muted">
                                            Não informado
                                        </span>

                                    @endif

                                </td>


                                {{-- Localização --}}
                                <td>

                                    @if(
                                        $cliente->cidade
                                        || $cliente->estado
                                    )

                                        {{ $cliente->cidade ?? '' }}

                                        @if(
                                            $cliente->cidade
                                            && $cliente->estado
                                        )
                                            /
                                        @endif

                                        {{ $cliente->estado ?? '' }}

                                    @else

                                        <span class="text-muted">
                                            Não informada
                                        </span>

                                    @endif

                                </td>


                                {{-- CEP --}}
                                <td>

                                    @if($cliente->cep)

                                        {{ $cliente->cep }}

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
                                            $cliente->telefone
                                        );

                                    @endphp


                                    <div
                                        class="d-flex justify-content-end gap-1 flex-wrap"
                                    >


                                        {{-- Visualizar --}}
                                        <a
                                            href="{{ route(
                                                'clientes.show',
                                                $cliente->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-success"
                                        >
                                            Visualizar
                                        </a>


                                        {{-- WhatsApp --}}
                                        <a
                                            href="https://wa.me/55{{ $telefone }}"
                                            target="_blank"
                                            class="btn btn-sm btn-success"
                                        >
                                            WhatsApp
                                        </a>


                                        {{-- Editar --}}
                                        <a
                                            href="{{ route(
                                                'clientes.edit',
                                                $cliente->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-primary"
                                        >
                                            Editar
                                        </a>


                                        {{-- Excluir --}}
                                        <a
                                            href="{{ route(
                                                'clientes.delete',
                                                $cliente->id
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
                                    colspan="6"
                                    class="text-center py-5"
                                >

                                    <div class="fs-1 mb-3">
                                        👥
                                    </div>

                                    <div class="fw-semibold">
                                        Nenhum cliente encontrado
                                    </div>

                                    <p class="text-muted mb-3">
                                        Cadastre seu primeiro cliente para começar.
                                    </p>

                                    <a
                                        href="{{ route('clientes.create') }}"
                                        class="btn btn-success"
                                    >
                                        + Novo Cliente
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