<div>

    @if(session('site_success'))

        <div
            class="alert alert-success"
        >

            <div class="fw-bold mb-1">
                Solicitação enviada!
            </div>

            {{ session('site_success') }}

        </div>

    @endif


    <div
        class="card border-0 shadow-lg"
        style="
            background:
            rgba(255,255,255,.98);
        "
    >

        <div class="card-body p-4 p-lg-5">

            <h4
                class="fw-bold mb-1"
                style="
                    color:#063426;
                "
            >
                Solicite seu orçamento
            </h4>

            <p
                class="text-muted mb-4"
            >
                Conte um pouco sobre
                o evento que você está planejando.
            </p>


            <form
                wire:submit="enviar"
            >

                <div class="row g-3">


                    {{-- NOME --}}
                    <div class="col-md-6">

                        <label
                            class="form-label fw-semibold"
                        >
                            Nome completo *
                        </label>

                        <input
                            type="text"
                            wire:model="nome"
                            class="form-control
                            @error('nome')
                                is-invalid
                            @enderror"
                            placeholder="Seu nome"
                        >

                        @error('nome')

                            <div
                                class="invalid-feedback"
                            >
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- WHATSAPP --}}
                    <div class="col-md-6">

                        <label
                            class="form-label fw-semibold"
                        >
                            WhatsApp *
                        </label>

                        <input
                            type="tel"
                            wire:model="telefone"
                            class="form-control
                            @error('telefone')
                                is-invalid
                            @enderror"
                            placeholder="(18) 99999-9999"
                        >

                        @error('telefone')

                            <div
                                class="invalid-feedback"
                            >
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- EMAIL --}}
                    <div class="col-md-6">

                        <label
                            class="form-label fw-semibold"
                        >
                            E-mail
                        </label>

                        <input
                            type="email"
                            wire:model="email"
                            class="form-control
                            @error('email')
                                is-invalid
                            @enderror"
                            placeholder="seuemail@email.com"
                        >

                        @error('email')

                            <div
                                class="invalid-feedback"
                            >
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- EVENTO --}}
                    <div class="col-md-6">

                        <label
                            class="form-label fw-semibold"
                        >
                            Tipo de evento *
                        </label>

                        <select
                            wire:model="tipo_evento"
                            class="form-select
                            @error('tipo_evento')
                                is-invalid
                            @enderror"
                        >

                            <option value="">
                                Selecione
                            </option>

                            <option value="Casamento">
                                Casamento
                            </option>

                            <option value="Aniversário">
                                Aniversário
                            </option>

                            <option value="Formatura">
                                Formatura
                            </option>

                            <option value="Confraternização">
                                Confraternização
                            </option>

                            <option value="Evento corporativo">
                                Evento corporativo
                            </option>

                            <option value="Chá revelação">
                                Chá revelação
                            </option>

                            <option value="Outro">
                                Outro
                            </option>

                        </select>

                        @error('tipo_evento')

                            <div
                                class="invalid-feedback"
                            >
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- DATA --}}
                    <div class="col-md-6">

                        <label
                            class="form-label fw-semibold"
                        >
                            Data desejada
                        </label>

                        <input
                            type="date"
                            wire:model="data_evento"
                            min="{{ date('Y-m-d') }}"
                            class="form-control
                            @error('data_evento')
                                is-invalid
                            @enderror"
                        >

                        @error('data_evento')

                            <div
                                class="invalid-feedback"
                            >
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- CONVIDADOS --}}
                    <div class="col-md-6">

                        <label
                            class="form-label fw-semibold"
                        >
                            Número de convidados
                        </label>

                        <input
                            type="number"
                            wire:model="quantidade_convidados"
                            min="1"
                            class="form-control
                            @error('quantidade_convidados')
                                is-invalid
                            @enderror"
                            placeholder="Ex.: 150"
                        >

                        @error('quantidade_convidados')

                            <div
                                class="invalid-feedback"
                            >
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- MENSAGEM --}}
                    <div class="col-12">

                        <label
                            class="form-label fw-semibold"
                        >
                            Mensagem
                        </label>

                        <textarea
                            wire:model="mensagem"
                            rows="4"
                            class="form-control
                            @error('mensagem')
                                is-invalid
                            @enderror"
                            placeholder="Conte mais detalhes sobre seu evento..."
                        ></textarea>

                        @error('mensagem')

                            <div
                                class="invalid-feedback"
                            >
                                {{ $message }}
                            </div>

                        @enderror

                    </div>


                    {{-- BOTÃO --}}
                    <div class="col-12">

                        <button
                            type="submit"
                            class="btn btn-rinalds w-100 py-3"
                            wire:loading.attr="disabled"
                            wire:target="enviar"
                        >

                            <span
                                wire:loading.remove
                                wire:target="enviar"
                            >
                                Enviar solicitação
                            </span>


                            <span
                                wire:loading
                                wire:target="enviar"
                            >
                                Enviando...
                            </span>

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>

</div>