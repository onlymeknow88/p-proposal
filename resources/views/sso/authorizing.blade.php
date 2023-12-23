<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Loading Redirect ....</title>

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <style>
        /* body {
            background-color: #000;
        } */

        .center {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        main {
            text-align: center;

        }

        .loader {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            position: relative;
            animation: rotate 1s linear infinite
        }

        .loader::before,
        .loader::after {
            content: "";
            box-sizing: border-box;
            position: absolute;
            inset: 0px;
            border-radius: 50%;
            border: 5px solid #11181C;
            animation: prixClipFix 2s linear infinite;
        }

        .loader::after {
            border-color: #17c964;
            animation: prixClipFix 2s linear infinite, rotate 0.5s linear infinite reverse;
            inset: 6px;
        }

        @keyframes rotate {
            0% {
                transform: rotate(0deg)
            }

            100% {
                transform: rotate(360deg)
            }
        }

        @keyframes prixClipFix {
            0% {
                clip-path: polygon(50% 50%, 0 0, 0 0, 0 0, 0 0, 0 0)
            }

            25% {
                clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 0, 100% 0, 100% 0)
            }

            50% {
                clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 100% 100%, 100% 100%)
            }

            75% {
                clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 0 100%, 0 100%)
            }

            100% {
                clip-path: polygon(50% 50%, 0 0, 100% 0, 100% 100%, 0 100%, 0 0)
            }
        }
    </style>
</head>

<body>
    <div class="center">
        <span class="loader"></span>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('/js/app.js') }}" defer></script>
    <script>
        const data = {{ Js::from($data) }};
        const nik = {{ Js::from($nik) }};
        const isLogin = {{ Js::from($isLogin) }};

        fetch('http://homepage.test/oauth/token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data)
        }).then(res => res.json()).then(res => {

            console.log(res)
            let redirect = `${data.redirect_uri}?error=1`;

            if (res.access_token && res.refresh_token) {

                redirect =
                    `${data.redirect_uri}?access_token=${res.access_token}&refresh_token=${res.refresh_token}&expires_in=${res.expires_in}&nik=${nik}&isLogin=${isLogin}`;
            }

            setTimeout(() => {
                return window.location.href = redirect;
            }, 3000);


        });
    </script>
</body>

</html>
