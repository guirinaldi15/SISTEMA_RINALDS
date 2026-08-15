<!DOCTYPE html>

<html lang="pt-BR">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Login | Rinald's Gestão
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

        :root {

            --rinalds-green:
                #062f22;

            --rinalds-dark:
                #031f17;

            --rinalds-gold:
                #c99a3d;

            --rinalds-light-gold:
                #e0bd70;

        }


        body {

            min-height: 100vh;

            margin: 0;

            background:
                linear-gradient(
                    135deg,
                    #031f17,
                    #062f22
                );

        }


        .login-page {

            min-height: 100vh;

            display: flex;

            align-items: center;

            justify-content: center;

            padding: 30px 15px;

        }


        .login-card {

            width: 100%;

            max-width: 440px;

            border: 0;

            border-radius: 20px;

            overflow: hidden;

            box-shadow:
                0 25px 60px
                rgba(
                    0,
                    0,
                    0,
                    .28
                );

        }


        .login-logo {

            font-family:
                Georgia,
                'Times New Roman',
                serif;

            color:
                var(--rinalds-gold);

            letter-spacing: 2px;

        }


        .login-subtitle {

            color:
                #6c757d;

        }


        .form-control {

            min-height: 50px;

            border-radius: 10px;

        }


        .form-control:focus {

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


        .btn-login {

            min-height: 50px;

            background:
                var(--rinalds-green);

            border:
                1px solid
                var(--rinalds-green);

            color:
                white;

            font-weight:
                600;

            border-radius:
                10px;

        }


        .btn-login:hover {

            background:
                var(--rinalds-dark);

            border-color:
                var(--rinalds-dark);

            color:
                white;

        }


        .back-site {

            color:
                var(--rinalds-light-gold);

            text-decoration:
                none;

        }


        .back-site:hover {

            color:
                white;

        }

    </style>

</head>


<body>


    {{ $slot }}


    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    ></script>


    @livewireScripts

</body>

</html>