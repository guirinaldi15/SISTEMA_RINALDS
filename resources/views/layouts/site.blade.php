<!DOCTYPE html>
<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="Chácara Rinald's Festas & Eventos em Presidente Epitácio - SP. Conheça nossa estrutura e solicite seu orçamento."
    >

    <title>
        Chácara Rinald's | Festas & Eventos
    </title>


    {{-- ====================================================== --}}
    {{-- BOOTSTRAP --}}
    {{-- ====================================================== --}}

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >


    {{-- ====================================================== --}}
    {{-- BOOTSTRAP ICONS --}}
    {{-- ====================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >


    @livewireStyles


    <style>

        :root {

            --rinalds-green:
                #062f22;

            --rinalds-green-dark:
                #031f17;

            --rinalds-green-light:
                #164c39;

            --rinalds-gold:
                #c99a3d;

            --rinalds-gold-light:
                #e0bd70;

            --rinalds-bg:
                #f8f5ee;

            --rinalds-text:
                #1e2d27;

        }


        html {

            scroll-behavior:
                smooth;

        }


        body {

            margin: 0;

            background:
                var(--rinalds-bg);

            color:
                var(--rinalds-text);

        }


        section {

            scroll-margin-top:
                80px;

        }


        /* ===================================================== */
        /* NAVBAR */
        /* ===================================================== */

        .site-navbar {

            background:
                rgba(
                    3,
                    31,
                    23,
                    .98
                );

            box-shadow:
                0
                2px
                15px
                rgba(
                    0,
                    0,
                    0,
                    .12
                );

        }


        .site-navbar
        .navbar-brand {

            color:
                var(--rinalds-gold-light);

            font-family:
                Georgia,
                'Times New Roman',
                serif;

            font-size:
                1.6rem;

            letter-spacing:
                1px;

        }


        .site-navbar
        .navbar-brand:hover {

            color:
                var(--rinalds-gold-light);

        }


        .site-navbar
        .nav-link {

            color:
                rgba(
                    255,
                    255,
                    255,
                    .88
                );

            font-size:
                .9rem;

            font-weight:
                500;

            margin:
                0 5px;

        }


        .site-navbar
        .nav-link:hover {

            color:
                var(--rinalds-gold-light);

        }


        /* ===================================================== */
        /* BOTÕES */
        /* ===================================================== */

        .btn-rinalds {

            background:
                var(--rinalds-gold);

            border-color:
                var(--rinalds-gold);

            color:
                #16271f;

            font-weight:
                600;

        }


        .btn-rinalds:hover {

            background:
                var(--rinalds-gold-light);

            border-color:
                var(--rinalds-gold-light);

            color:
                #16271f;

        }


        .btn-rinalds-outline {

            border:
                1px solid
                var(--rinalds-gold);

            color:
                var(--rinalds-gold-light);

            background:
                transparent;

        }


        .btn-rinalds-outline:hover {

            background:
                var(--rinalds-gold);

            border-color:
                var(--rinalds-gold);

            color:
                var(--rinalds-green-dark);

        }


        /* ===================================================== */
        /* TÍTULOS */
        /* ===================================================== */

        .section-label {

            color:
                var(--rinalds-gold);

            font-size:
                .85rem;

            text-transform:
                uppercase;

            letter-spacing:
                2px;

            font-weight:
                600;

            margin-bottom:
                8px;

        }


        .section-title {

            font-family:
                Georgia,
                'Times New Roman',
                serif;

            color:
                var(--rinalds-green);

            font-weight:
                bold;

        }


        /* ===================================================== */
        /* CARDS */
        /* ===================================================== */

        .rinalds-card {

            border:
                1px solid
                rgba(
                    201,
                    154,
                    61,
                    .35
                );

            border-radius:
                14px;

            background:
                white;

            transition:
                transform
                .2s ease,
                box-shadow
                .2s ease;

        }


        .rinalds-card:hover {

            transform:
                translateY(-4px);

            box-shadow:
                0
                12px
                30px
                rgba(
                    0,
                    0,
                    0,
                    .08
                );

        }


        /* ===================================================== */
        /* IMAGENS */
        /* ===================================================== */

        .estrutura-img {

            width:
                100%;

            height:
                240px;

            object-fit:
                cover;

        }


        .galeria-img {

            width:
                100%;

            height:
                260px;

            object-fit:
                cover;

            border-radius:
                12px;

            transition:
                transform
                .2s ease;

        }


        .galeria-img:hover {

            transform:
                scale(1.02);

        }


        /* ===================================================== */
        /* FORMULÁRIOS */
        /* ===================================================== */

        .form-control:focus,
        .form-select:focus {

            border-color:
                var(--rinalds-gold);

            box-shadow:
                0 0 0
                .2rem
                rgba(
                    201,
                    154,
                    61,
                    .15
                );

        }


        /* ===================================================== */
        /* FOOTER */
        /* ===================================================== */

        .site-footer {

            background:
                var(--rinalds-green-dark);

            color:
                rgba(
                    255,
                    255,
                    255,
                    .8
                );

        }


        .site-footer strong {

            color:
                var(--rinalds-gold-light);

        }


        /* ===================================================== */
        /* MOBILE */
        /* ===================================================== */

        @media (
            max-width:
            768px
        ) {

            .hero-title {

                font-size:
                    2.7rem !important;

            }


            .galeria-img {

                height:
                    180px;

            }

        }

    </style>

</head>


<body>


    {{-- ====================================================== --}}
    {{-- NAVBAR --}}
    {{-- ====================================================== --}}

    <nav
        class="navbar navbar-expand-lg navbar-dark site-navbar sticky-top"
    >

        <div class="container">


            {{-- LOGO / NOME --}}
            <a
                class="navbar-brand"
                href="{{ route('site.home') }}"
            >

                <strong>
                    RINALD'S
                </strong>

                <small
                    class="d-block"
                    style="
                        font-size: .55rem;
                        letter-spacing: 3px;
                    "
                >
                    FESTAS & EVENTOS
                </small>

            </a>


            {{-- MOBILE --}}
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#siteNavbar"
                aria-controls="siteNavbar"
                aria-expanded="false"
                aria-label="Abrir menu"
            >

                <span
                    class="navbar-toggler-icon"
                ></span>

            </button>


            {{-- MENU --}}
            <div
                class="collapse navbar-collapse"
                id="siteNavbar"
            >

                <ul
                    class="navbar-nav ms-auto align-items-lg-center"
                >


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('site.home') }}#inicio"
                        >
                            HOME
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('site.home') }}#estrutura"
                        >
                            ESTRUTURA
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('site.home') }}#pacotes"
                        >
                            PACOTES
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('site.home') }}#galeria"
                        >
                            GALERIA
                        </a>

                    </li>


                    <li class="nav-item">

                        <a
                            class="nav-link"
                            href="{{ route('site.home') }}#contato"
                        >
                            CONTATO
                        </a>

                    </li>


                    <li
                        class="nav-item ms-lg-3 mt-3 mt-lg-0"
                    >

                        <a
                            href="{{ route('site.home') }}#contato"
                            class="btn btn-rinalds"
                        >
                            Solicite seu orçamento
                        </a>

                    </li>

                </ul>

            </div>

        </div>

    </nav>


    {{-- ====================================================== --}}
    {{-- CONTEÚDO --}}
    {{-- ====================================================== --}}

    @yield('content')


    {{-- ====================================================== --}}
    {{-- FOOTER --}}
    {{-- ====================================================== --}}

    <footer
        class="site-footer py-5"
    >

        <div class="container">


            <div class="row g-4">


                {{-- EMPRESA --}}
                <div class="col-lg-5">

                    <h4
                        class="mb-2"
                        style="
                            font-family:
                            Georgia,
                            serif;

                            color:
                            #e0bd70;
                        "
                    >
                        Rinald's
                    </h4>


                    <p class="mb-2">
                        Festas & Eventos
                    </p>


                    <p
                        class="text-white-50 mb-0"
                    >
                        Um espaço especial para
                        transformar celebrações
                        em momentos inesquecíveis.
                    </p>

                </div>


                {{-- NAVEGAÇÃO --}}
                <div class="col-lg-3">

                    <strong>
                        Navegação
                    </strong>


                    <div class="mt-3">

                        <a
                            href="{{ route('site.home') }}#inicio"
                            class="text-white-50 text-decoration-none d-block mb-2"
                        >
                            Home
                        </a>


                        <a
                            href="{{ route('site.home') }}#estrutura"
                            class="text-white-50 text-decoration-none d-block mb-2"
                        >
                            Estrutura
                        </a>


                        <a
                            href="{{ route('site.home') }}#pacotes"
                            class="text-white-50 text-decoration-none d-block mb-2"
                        >
                            Pacotes
                        </a>


                        <a
                            href="{{ route('site.home') }}#galeria"
                            class="text-white-50 text-decoration-none d-block mb-2"
                        >
                            Galeria
                        </a>


                        <a
                            href="{{ route('site.home') }}#contato"
                            class="text-white-50 text-decoration-none d-block"
                        >
                            Contato
                        </a>

                    </div>

                </div>


                {{-- CONTATO --}}
                <div class="col-lg-4">

                    <strong>
                        Contato
                    </strong>


                    <div class="mt-3">

                        <p class="mb-2">

                            <i
                                class="bi bi-geo-alt me-2"
                            ></i>

                            Presidente Epitácio - SP

                        </p>


                        <p class="mb-2">

                            <i
                                class="bi bi-whatsapp me-2"
                            ></i>

                            Atendimento via WhatsApp

                        </p>


                        <p class="mb-0">

                            <i
                                class="bi bi-calendar-check me-2"
                            ></i>

                            Consulte nossa disponibilidade

                        </p>

                    </div>

                </div>

            </div>


            <hr
                class="border-secondary my-4"
            >


            <div
                class="d-flex justify-content-between align-items-center flex-wrap gap-3"
            >


                <small
                    class="text-white-50"
                >

                    © {{ date('Y') }}
                    Chácara Rinald's.
                    Todos os direitos reservados.

                </small>


                {{-- ====================================================== --}}
                {{-- ÁREA ADMINISTRATIVA --}}
                {{-- CORRIGIDO: dashboard.index --}}
                {{-- ====================================================== --}}

                <a
                    href="{{ route('dashboard.index') }}"
                    class="text-white-50 text-decoration-none small"
                >
                    <i
                        class="bi bi-lock me-1"
                    ></i>

                    Área administrativa
                </a>

            </div>

        </div>

    </footer>


    {{-- ====================================================== --}}
    {{-- BOOTSTRAP JS --}}
    {{-- ====================================================== --}}

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>


    @livewireScripts

</body>

</html>