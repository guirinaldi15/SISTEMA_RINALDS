<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Rinald's Gestão
    </title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    @livewireStyles


    <style>

        body {

            min-height: 100vh;

            background:
                #f5f6f7;

        }


        .sidebar {

            width:
                250px;

            min-height:
                100vh;

            position:
                fixed;

            left:
                0;

            top:
                0;

            background:
                #163b2b;

            color:
                white;

            z-index:
                1000;

        }


        .sidebar-brand {

            padding:
                24px;

            border-bottom:
                1px solid
                rgba(
                    255,
                    255,
                    255,
                    .1
                );

        }


        .sidebar-link {

            display:
                block;

            width:
                auto;

            padding:
                12px 18px;

            margin:
                3px 10px;

            color:
                rgba(
                    255,
                    255,
                    255,
                    .82
                );

            text-decoration:
                none;

            border-radius:
                8px;

            transition:
                .2s;

        }


        .sidebar-link:hover {

            background:
                rgba(
                    255,
                    255,
                    255,
                    .1
                );

            color:
                white;

        }


        .sidebar-link.active {

            background:
                white;

            color:
                #163b2b;

            font-weight:
                600;

        }


        .main-content {

            margin-left:
                250px;

            min-height:
                100vh;

        }


        .topbar {

            min-height:
                70px;

            background:
                white;

            border-bottom:
                1px solid
                #e9ecef;

            display:
                flex;

            align-items:
                center;

            justify-content:
                space-between;

            padding:
                0 30px;

        }


        .topbar-title {

            font-weight:
                600;

        }


        .user-avatar {

            width:
                38px;

            height:
                38px;

            border-radius:
                50%;

            display:
                flex;

            align-items:
                center;

            justify-content:
                center;

            background:
                #163b2b;

            color:
                white;

            font-weight:
                bold;

        }


        @media(
            max-width:
            991px
        ) {

            .sidebar {

                display:
                    none;

            }


            .main-content {

                margin-left:
                    0;

            }


            .topbar {

                padding:
                    0 18px;

            }

        }

    </style>

</head>


<body>


    {{-- ====================================================== --}}
    {{-- SIDEBAR --}}
    {{-- ====================================================== --}}

    <aside class="sidebar">


        <div class="sidebar-brand">

            <h4 class="fw-bold mb-0">

                RINALD'S

            </h4>


            <small class="text-white-50">

                Festas & Eventos

            </small>

        </div>


        <div class="py-3">


            {{-- DASHBOARD --}}
            <a
                href="{{ route('dashboard.index') }}"
                class="sidebar-link
                    {{
                        request()
                            ->routeIs('dashboard.*')
                            ? 'active'
                            : ''
                    }}"
            >
                🏠 Dashboard
            </a>


            {{-- ATENDIMENTOS --}}
            <a
                href="{{ route('atendimentos.index') }}"
                class="sidebar-link
                    {{
                        request()
                            ->routeIs('atendimentos.*')
                            ? 'active'
                            : ''
                    }}"
            >
                💬 Atendimentos
            </a>


            {{-- CLIENTES --}}
            <a
                href="{{ route('clientes.index') }}"
                class="sidebar-link
                    {{
                        request()
                            ->routeIs('clientes.*')
                            ? 'active'
                            : ''
                    }}"
            >
                👥 Clientes
            </a>


            {{-- AGENDA --}}
            <a
                href="{{ route('agenda.index') }}"
                class="sidebar-link
                    {{
                        request()
                            ->routeIs('agenda.*')
                            ? 'active'
                            : ''
                    }}"
            >
                📅 Agenda
            </a>


            {{-- RESERVAS --}}
            <a
                href="{{ route('reservas.index') }}"
                class="sidebar-link
                    {{
                        request()
                            ->routeIs('reservas.*')
                            ? 'active'
                            : ''
                    }}"
            >
                🎉 Reservas
            </a>


            {{-- ORÇAMENTOS --}}
            <a
                href="{{ route('orcamentos.index') }}"
                class="sidebar-link
                    {{
                        request()
                            ->routeIs('orcamentos.*')
                            ? 'active'
                            : ''
                    }}"
            >
                💰 Orçamentos
            </a>


            {{-- FINANCEIRO --}}
            @if(auth()->user()->isAdmin())

                <a
                    href="{{ route('pagamentos.index') }}"
                    class="sidebar-link
                        {{
                            request()
                                ->routeIs('pagamentos.*')
                                ? 'active'
                                : ''
                        }}"
                >
                    💳 Financeiro
                </a>

            @endif


            {{-- LEMBRETES --}}
            <a
                href="{{ route('lembretes.index') }}"
                class="sidebar-link
                    {{
                        request()
                            ->routeIs('lembretes.*')
                            ? 'active'
                            : ''
                    }}"
            >
                🔔 Lembretes
            </a>


            {{-- USUÁRIOS --}}
            @if(auth()->user()->isAdmin())

                <a
                    href="{{ route('usuarios.index') }}"
                    class="sidebar-link
                        {{
                            request()
                                ->routeIs('usuarios.*')
                                ? 'active'
                                : ''
                        }}"
                >
                    👤 Usuários
                </a>

            @endif


            <hr
                class="mx-3 my-3"
                style="
                    border-color:
                    rgba(
                        255,
                        255,
                        255,
                        .15
                    );
                "
            >


            {{-- SITE --}}
            <a
                href="{{ route('site.home') }}"
                target="_blank"
                class="sidebar-link"
            >
                🌐 Ver Site
            </a>


            {{-- SAIR --}}
            <form
                method="POST"
                action="{{ route('logout') }}"
            >

                @csrf

                <button
                    type="submit"
                    class="sidebar-link border-0 text-start"
                    style="
                        background:
                        transparent;
                    "
                >
                    🚪 Sair
                </button>

            </form>

        </div>

    </aside>


    {{-- ====================================================== --}}
    {{-- PRINCIPAL --}}
    {{-- ====================================================== --}}

    <div class="main-content">


        <nav class="topbar">


            <div>

                <span class="topbar-title">

                    Rinald's Gestão

                </span>

            </div>


            <div
                class="d-flex align-items-center gap-3"
            >


                <a
                    href="{{ route('lembretes.index') }}"
                    class="text-decoration-none text-dark"
                >
                    🔔
                </a>


                <div
                    class="d-flex align-items-center gap-2"
                >

                    <div class="user-avatar">

                        {{
                            strtoupper(
                                substr(
                                    auth()->user()->name,
                                    0,
                                    1
                                )
                            )
                        }}

                    </div>


                    <div
                        class="d-none d-md-block"
                    >

                        <div
                            class="fw-semibold"
                        >
                            {{ auth()->user()->name }}
                        </div>


                        <small class="text-muted">

                            {{
                                auth()->user()->perfil
                                === 'administrador'
                                ? 'Administrador'
                                : 'Atendente'
                            }}

                        </small>

                    </div>

                </div>


                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn btn-sm btn-outline-danger"
                    >
                        Sair
                    </button>

                </form>

            </div>

        </nav>


        <main>

            {{ $slot }}

        </main>

    </div>


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>


    @livewireScripts

</body>

</html>