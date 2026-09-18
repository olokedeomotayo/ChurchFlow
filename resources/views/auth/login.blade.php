<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>ChurchFlow — Login</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            min-height: 100%;
            margin: 0;
        }

        body {
            font-family:
                Inter,
                ui-sans-serif,
                system-ui,
                -apple-system,
                BlinkMacSystemFont,
                "Segoe UI",
                sans-serif;

            background: #f4f1f7;

            color: #181525;
        }

        .login-page {
            min-height: 100dvh;

            display: flex;

            align-items: center;
            justify-content: center;

            padding: 25px;
        }

        .login-card {
            width: min(430px, 100%);

            padding: 38px;

            background: #ffffff;

            border-radius: 20px;

            box-shadow:
                0 20px 50px
                rgba(45, 20, 70, .12);
        }

        .logo {
            text-align: center;

            margin-bottom: 24px;
        }

        .logo img {
            width: 50px;
            height: 50px;

            object-fit: contain;
        }

        .brand {
            margin-top: 7px;

            font-size: 25px;

            font-weight: 800;

            color: #7021a8;
        }

        .brand span {
            color: #b22962;

            font-weight: 400;
        }

        .heading {
            margin-bottom: 22px;

            text-align: center;
        }

        .heading h1 {
            margin: 0 0 6px;

            font-size: 25px;

            letter-spacing: -.5px;

            color: #211b30;
        }

        .heading p {
            margin: 0;

            color: #8b8595;

            font-size: 13px;
        }

        .errors {
            margin-bottom: 16px;

            padding: 10px;

            border-radius: 8px;

            background: #fff1f2;

            border: 1px solid #fecdd3;

            color: #be123c;

            font-size: 12px;
        }

        .errors ul {
            margin: 0;

            padding-left: 18px;
        }

        .field {
            margin-bottom: 16px;
        }

        .field label {
            display: block;

            margin-bottom: 6px;

            font-size: 13px;

            font-weight: 700;

            color: #332c40;
        }

        .field input {
            width: 100%;

            height: 48px;

            padding: 0 14px;

            border: 1px solid #ddd9e5;

            border-radius: 9px;

            background: #ffffff;

            color: #211d32;

            font-size: 14px;

            outline: none;

            transition: .2s ease;
        }

        .field input:focus {
            border-color: #7021a8;

            box-shadow:
                0 0 0 3px
                rgba(112, 33, 168, .07);
        }

        .field input::placeholder {
            color: #aaa5b3;
        }

        .remember-row {
            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 18px;
        }

        .remember {
            display: flex;

            align-items: center;

            gap: 7px;

            font-size: 12px;

            color: #777389;
        }

        .remember input {
            accent-color: #7021a8;
        }

        .forgot-link {
            font-size: 12px;

            color: #7021a8;

            font-weight: 700;

            text-decoration: none;
        }

        .login-button {
            width: 100%;

            height: 48px;

            border: 0;

            border-radius: 9px;

            background:
                linear-gradient(
                    90deg,
                    #7021a8,
                    #b22962
                );

            color: #ffffff;

            font-size: 13px;

            font-weight: 800;

            cursor: pointer;

            box-shadow:
                0 8px 18px
                rgba(112, 33, 168, .18);

            transition: .2s ease;
        }

        .login-button:hover {
            transform: translateY(-1px);

            box-shadow:
                0 10px 22px
                rgba(112, 33, 168, .24);
        }

        .register-link {
            margin-top: 22px;

            padding-top: 18px;

            border-top: 1px solid #eeeaf2;

            text-align: center;

            color: #8b8595;

            font-size: 12px;
        }

        .register-link a {
            color: #7021a8;

            font-weight: 800;

            text-decoration: none;
        }

        .register-link a:hover {
            color: #b22962;

            text-decoration: underline;
        }

        .security-note {
            margin-top: 16px;

            text-align: center;

            color: #aaa4b2;

            font-size: 10px;
        }

        @media (max-width: 500px) {

            .login-page {
                padding: 15px;
            }

            .login-card {
                padding: 28px 22px;
            }

            .remember-row {
                align-items: flex-start;

                gap: 10px;
            }

        }

    </style>

</head>


<body>


<div class="login-page">


    <div class="login-card">


        <div class="logo">

            <img
                src="{{ asset('images/techcrossbreed-logo.png') }}"
                alt="ChurchFlow"
            >

            <div class="brand">
                Church<span>Flow</span>
            </div>

        </div>


        <div class="heading">

            <h1>
                Welcome back
            </h1>

            <p>
                Sign in to manage your church.
            </p>

        </div>


        @if ($errors->any())

            <div class="errors">

                <ul>

                    @foreach ($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form
            method="POST"
            action="{{ route('login') }}"
        >

            @csrf


            <div class="field">

                <label for="email">
                    Email Address
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email"
                    required
                    autofocus
                    autocomplete="email"
                >

            </div>


            <div class="field">

                <label for="password">
                    Password
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="Enter your password"
                    required
                    autocomplete="current-password"
                >

            </div>


            <div class="remember-row">

                <label class="remember">

                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                    >

                    Remember me

                </label>


                @if (Route::has('password.request'))

                    <a
                        href="{{ route('password.request') }}"
                        class="forgot-link"
                    >
                        Forgot password?
                    </a>

                @endif

            </div>


            <button
                type="submit"
                class="login-button"
            >
                Login to ChurchFlow →
            </button>


        </form>


        <div class="register-link">

            Don't have a ChurchFlow account?

            <a href="{{ route('register') }}">
                Register your church
            </a>

        </div>


        <div class="security-note">

            🔒 Your information is securely protected.

        </div>


    </div>


</div>


</body>

</html>