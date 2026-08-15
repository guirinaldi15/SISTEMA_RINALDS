@extends('layouts.site')


@section('content')


{{-- ====================================================== --}}
{{-- HERO --}}
{{-- ====================================================== --}}

<section
    id="inicio"
    class="position-relative d-flex align-items-center"
    style="
        min-height: 650px;

        background:
            linear-gradient(
                90deg,
                rgba(0,0,0,.78),
                rgba(0,0,0,.25)
            ),
            url('{{ asset('site/images/hero/hero-casamento.jpg') }}');

        background-size: cover;
        background-position: center;
    "
>

    <div class="container">

        <div class="row align-items-center">

            <div class="col-lg-7 text-white">

                <div
                    class="text-uppercase mb-2"
                    style="
                        color: #e0bd70;
                        letter-spacing: 3px;
                    "
                >
                    Chácara Rinald's
                </div>


                <h1
                    class="display-3 fw-bold mb-3 hero-title"
                    style="
                        font-family: Georgia, serif;
                    "
                >
                    O lugar perfeito
                    <br>
                    para momentos
                    <br>
                    inesquecíveis
                </h1>


                <p
                    class="lead mb-4"
                    style="
                        max-width: 600px;
                    "
                >
                    Estrutura, lazer e conforto para
                    transformar seu evento em uma
                    experiência especial.
                </p>


                <div class="d-flex gap-2 flex-wrap">

                    <a
                        href="#contato"
                        class="btn btn-rinalds btn-lg"
                    >
                        Solicitar orçamento
                    </a>


                    <a
                        href="#estrutura"
                        class="btn btn-rinalds-outline btn-lg"
                    >
                        Conhecer estrutura
                    </a>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- ====================================================== --}}
{{-- DIFERENCIAIS --}}
{{-- ====================================================== --}}

<section class="bg-white border-bottom">

    <div class="container py-4">

        <div class="row g-4 text-center">


            <div class="col-6 col-lg">

                <i
                    class="bi bi-people fs-2"
                    style="color:#063426;"
                ></i>

                <div class="fw-semibold mt-2">
                    Festas e eventos
                </div>

            </div>


            <div class="col-6 col-lg">

                <i
                    class="bi bi-water fs-2"
                    style="color:#063426;"
                ></i>

                <div class="fw-semibold mt-2">
                    Piscina
                </div>

            </div>


            <div class="col-6 col-lg">

                <i
                    class="bi bi-cup-hot fs-2"
                    style="color:#063426;"
                ></i>

                <div class="fw-semibold mt-2">
                    Cozinha
                </div>

            </div>


            <div class="col-6 col-lg">

                <i
                    class="bi bi-car-front fs-2"
                    style="color:#063426;"
                ></i>

                <div class="fw-semibold mt-2">
                    Estacionamento
                </div>

            </div>


            <div class="col-6 col-lg">

                <i
                    class="bi bi-tree fs-2"
                    style="color:#063426;"
                ></i>

                <div class="fw-semibold mt-2">
                    Área de lazer
                </div>

            </div>

        </div>

    </div>

</section>


{{-- ====================================================== --}}
{{-- ESTRUTURA --}}
{{-- ====================================================== --}}

<section
    id="estrutura"
    class="py-5"
>

    <div class="container py-lg-5">


        <div class="text-center mb-5">

            <div class="section-label">
                Nossa estrutura
            </div>


            <h2 class="section-title display-6">

                Tudo o que você precisa
                para realizar seu evento

            </h2>


            <p
                class="text-muted mx-auto"
                style="
                    max-width: 650px;
                "
            >
                Conheça alguns dos espaços disponíveis
                para receber você e seus convidados.
            </p>

        </div>


        @php
            $estruturas = [
                ['imagem' => 'piscina.jpg', 'titulo' => 'Piscina e lazer', 'texto' => 'Piscina, hidro e área externa para aproveitar com amigos e familiares.'],
                ['imagem' => 'salao.jpg', 'titulo' => 'Salão de festas', 'texto' => 'Salão amplo e coberto, preparado para diferentes formatos de evento.'],
                ['imagem' => 'espaco-gourmet.jpg', 'titulo' => 'Espaço gourmet', 'texto' => 'Churrasqueira e área de apoio integradas para receber seus convidados.'],
                ['imagem' => 'area-verde.jpg', 'titulo' => 'Área verde', 'texto' => 'Gramado e ambientes ao ar livre para celebrações e momentos especiais.'],
            ];
        @endphp

        <div class="row g-4 justify-content-center">
            @foreach ($estruturas as $estrutura)
                <div class="col-md-6 col-lg-3">
                    <div class="card rinalds-card h-100 overflow-hidden">
                        <img
                            src="{{ asset('site/images/estrutura/' . $estrutura['imagem']) }}"
                            class="card-img-top estrutura-img"
                            alt="{{ $estrutura['titulo'] }} da Chácara Rinald's"
                        >

                        <div class="card-body p-4">
                            <h5 class="fw-bold">{{ $estrutura['titulo'] }}</h5>
                            <p class="text-muted mb-0">{{ $estrutura['texto'] }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

</section>


{{-- ====================================================== --}}
{{-- EVENTOS --}}
{{-- ====================================================== --}}

<section id="eventos" class="py-5 bg-white">
    <div class="container py-lg-5">
        <div class="text-center mb-5">
            <div class="section-label">Seu evento aqui</div>
            <h2 class="section-title display-6">Um espaço, muitas possibilidades</h2>
            <p class="text-muted">Ambientes que se transformam para celebrar cada ocasião.</p>
        </div>

        @php
            $eventos = [
                ['imagem' => 'casamento.jpg', 'titulo' => 'Casamentos'],
                ['imagem' => 'aniversario.jpg', 'titulo' => 'Aniversários'],
                ['imagem' => 'festa-infantil.jpg', 'titulo' => 'Festas infantis'],
                ['imagem' => 'confraternizacao.jpg', 'titulo' => 'Confraternizações'],
            ];
        @endphp

        <div class="row g-4">
            @foreach ($eventos as $evento)
                <div class="col-sm-6 col-lg-3">
                    <div class="card rinalds-card h-100 overflow-hidden">
                        <img
                            src="{{ asset('site/images/eventos/' . $evento['imagem']) }}"
                            class="card-img-top estrutura-img"
                            alt="{{ $evento['titulo'] }} na Chácara Rinald's"
                        >
                        <div class="card-body text-center">
                            <h5 class="fw-bold mb-0">{{ $evento['titulo'] }}</h5>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>


{{-- ====================================================== --}}
{{-- PACOTES --}}
{{-- ====================================================== --}}

<section
    id="pacotes"
    class="py-5 bg-white"
>

    <div class="container py-lg-5">


        <div class="text-center mb-5">

            <div class="section-label">
                Nossos pacotes
            </div>


            <h2 class="section-title display-6">

                Escolha a opção ideal
                para seu evento

            </h2>


            <p class="text-muted">

                Entre em contato para receber
                um orçamento personalizado.

            </p>

        </div>


        <div
            class="row g-4 justify-content-center"
        >


            {{-- ====================================================== --}}
            {{-- BÁSICO --}}
            {{-- ====================================================== --}}

            <div class="col-lg-4">

                <div class="card rinalds-card h-100">

                    <div class="card-body p-4">


                        <div class="text-center mb-4">

                            <i
                                class="bi bi-star fs-1"
                                style="
                                    color:#c99a3d;
                                "
                            ></i>


                            <h4 class="fw-bold mt-2">
                                Básico
                            </h4>


                            <p class="text-muted">
                                Para eventos mais simples.
                            </p>

                        </div>


                        <ul class="list-unstyled">

                            <li class="mb-3">
                                ✓ Locação do espaço
                            </li>

                            <li class="mb-3">
                                ✓ Cozinha
                            </li>

                            <li class="mb-3">
                                ✓ Área de lazer
                            </li>

                            <li class="mb-3">
                                ✓ Piscina
                            </li>

                            <li class="mb-3">
                                ✓ Estrutura para convidados
                            </li>

                        </ul>


                        <hr>


                        <a
                            href="#contato"
                            class="btn btn-outline-success w-100"
                        >
                            Solicitar orçamento
                        </a>

                    </div>

                </div>

            </div>


            {{-- ====================================================== --}}
            {{-- COMPLETO --}}
            {{-- ====================================================== --}}

            <div class="col-lg-4">

                <div
                    class="card rinalds-card h-100"
                    style="
                        border: 2px solid #c99a3d;
                    "
                >

                    <div class="card-body p-4">


                        <div class="text-center mb-4">

                            <span
                                class="badge mb-3"
                                style="
                                    background:#c99a3d;
                                    color:#062f22;
                                "
                            >
                                MAIS ESCOLHIDO
                            </span>


                            <div>

                                <i
                                    class="bi bi-gem fs-1"
                                    style="
                                        color:#c99a3d;
                                    "
                                ></i>

                            </div>


                            <h4 class="fw-bold mt-2">
                                Completo
                            </h4>


                            <p class="text-muted">
                                Mais estrutura para sua festa.
                            </p>

                        </div>


                        <ul class="list-unstyled">

                            <li class="mb-3">
                                ✓ Tudo do pacote básico
                            </li>

                            <li class="mb-3">
                                ✓ Estrutura completa
                            </li>

                            <li class="mb-3">
                                ✓ Mais comodidade
                            </li>

                            <li class="mb-3">
                                ✓ Área de lazer completa
                            </li>

                            <li class="mb-3">
                                ✓ Atendimento personalizado
                            </li>

                        </ul>


                        <hr>


                        <a
                            href="#contato"
                            class="btn btn-rinalds w-100"
                        >
                            Solicitar orçamento
                        </a>

                    </div>

                </div>

            </div>


            {{-- ====================================================== --}}
            {{-- PREMIUM --}}
            {{-- ====================================================== --}}

            <div class="col-lg-4">

                <div class="card rinalds-card h-100">

                    <div class="card-body p-4">


                        <div class="text-center mb-4">

                            <i
                                class="bi bi-stars fs-1"
                                style="
                                    color:#c99a3d;
                                "
                            ></i>


                            <h4 class="fw-bold mt-2">
                                Premium
                            </h4>


                            <p class="text-muted">
                                Uma experiência completa.
                            </p>

                        </div>


                        <ul class="list-unstyled">

                            <li class="mb-3">
                                ✓ Estrutura completa
                            </li>

                            <li class="mb-3">
                                ✓ Mais tempo de evento
                            </li>

                            <li class="mb-3">
                                ✓ Serviços adicionais
                            </li>

                            <li class="mb-3">
                                ✓ Atendimento personalizado
                            </li>

                            <li class="mb-3">
                                ✓ Experiência exclusiva
                            </li>

                        </ul>


                        <hr>


                        <a
                            href="#contato"
                            class="btn btn-outline-success w-100"
                        >
                            Solicitar orçamento
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- ====================================================== --}}
{{-- GALERIA --}}
{{-- ====================================================== --}}

<section
    id="galeria"
    class="py-5"
>

    <div class="container py-lg-5">


        <div class="text-center mb-5">

            <div class="section-label">
                Galeria
            </div>


            <h2 class="section-title display-6">
                Conheça nosso espaço
            </h2>


            <p class="text-muted">

                Alguns momentos e detalhes
                da Chácara Rinald's.

            </p>

        </div>


        @php
            $galeria = [
                ['arquivo' => 'galeria-01.jpg', 'alt' => 'Piscina e hidro'],
                ['arquivo' => 'galeria-02.jpg', 'alt' => 'Área coberta integrada à piscina'],
                ['arquivo' => 'galeria-03.jpg', 'alt' => 'Lavabo da chácara'],
                ['arquivo' => 'galeria-04.jpg', 'alt' => 'Cerimônia ao ar livre'],
                ['arquivo' => 'galeria-05.jpg', 'alt' => 'Salão decorado para festa infantil'],
                ['arquivo' => 'galeria-06.jpg', 'alt' => 'Mesa posta para convidados'],
                ['arquivo' => 'galeria-07.jpg', 'alt' => 'Decoração da mesa principal'],
                ['arquivo' => 'galeria-08.jpg', 'alt' => 'Bolo e detalhes da decoração'],
                ['arquivo' => 'galeria-09.jpg', 'alt' => 'Carruagem decorativa'],
                ['arquivo' => 'galeria-10.jpg', 'alt' => 'Evento montado no jardim'],
                ['arquivo' => 'galeria-11.jpg', 'alt' => 'Recepção de casamento'],
                ['arquivo' => 'galeria-12.jpg', 'alt' => 'Detalhes de festa na chácara'],
            ];
        @endphp

        <div class="row g-3">
            @foreach ($galeria as $foto)
                <div class="col-6 col-lg-4">
                    <img
                        src="{{ asset('site/images/galeria/' . $foto['arquivo']) }}"
                        class="galeria-img shadow-sm"
                        alt="{{ $foto['alt'] }} na Chácara Rinald's"
                        loading="lazy"
                    >
                </div>
            @endforeach
        </div>

    </div>

</section>


{{-- ====================================================== --}}
{{-- CHAMADA --}}
{{-- ====================================================== --}}

<section
    class="py-5 bg-white"
>

    <div class="container">

        <div
            class="p-4 p-lg-5 rounded-4 text-center"
            style="
                background:#f3eee3;
            "
        >

            <div class="section-label">
                Seu evento começa aqui
            </div>


            <h2 class="section-title">

                Consulte a disponibilidade
                da sua data

            </h2>


            <p
                class="text-muted mx-auto"
                style="
                    max-width:600px;
                "
            >

                Conte para nossa equipe como será
                seu evento e receba um atendimento
                personalizado.

            </p>


            <a
                href="#contato"
                class="btn btn-rinalds btn-lg"
            >
                Quero solicitar um orçamento
            </a>

        </div>

    </div>

</section>


{{-- ====================================================== --}}
{{-- CONTATO / ORÇAMENTO --}}
{{-- ====================================================== --}}

<section
    id="contato"
    class="py-5"
    style="
        background:#062f22;
    "
>

    <div class="container py-lg-5">

        <div
            class="row g-5 align-items-center"
        >


            {{-- INFORMAÇÕES --}}
            <div class="col-lg-5 text-white">


                <div
                    class="text-uppercase small mb-2"
                    style="
                        color:#e0bd70;
                        letter-spacing:2px;
                    "
                >
                    Vamos planejar
                </div>


                <h2
                    class="display-6 fw-bold mb-3"
                    style="
                        font-family:
                        Georgia,
                        serif;
                    "
                >
                    Seu próximo
                    evento começa aqui
                </h2>


                <p class="text-white-50">

                    Preencha o formulário e nossa
                    equipe entrará em contato para
                    preparar uma proposta de acordo
                    com seu evento.

                </p>


                <div class="mt-4">


                    <div class="mb-3">

                        <i
                            class="bi bi-whatsapp me-2"
                            style="
                                color:#e0bd70;
                            "
                        ></i>

                        Atendimento pelo WhatsApp

                    </div>


                    <div class="mb-3">

                        <i
                            class="bi bi-geo-alt me-2"
                            style="
                                color:#e0bd70;
                            "
                        ></i>

                        Presidente Epitácio - SP

                    </div>


                    <div class="mb-3">

                        <i
                            class="bi bi-calendar-check me-2"
                            style="
                                color:#e0bd70;
                            "
                        ></i>

                        Consulte a disponibilidade
                        da sua data

                    </div>


                    <div>

                        <i
                            class="bi bi-stars me-2"
                            style="
                                color:#e0bd70;
                            "
                        ></i>

                        Atendimento personalizado

                    </div>

                </div>

            </div>


            {{-- FORMULÁRIO --}}
            <div class="col-lg-7">

                <livewire:site.solicitar-orcamento />

            </div>

        </div>

    </div>

</section>


@endsection
