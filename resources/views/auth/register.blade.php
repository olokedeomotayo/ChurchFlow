<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>ChurchFlow — Create Your Account</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        /* =====================================================
           RESET
        ===================================================== */

        * {
            box-sizing: border-box;
        }

        html,
        body {
            width: 100%;
            height: 100%;
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

        .login-link {
    margin-top: 8px;

    text-align: center;

    font-size: 8px;

    color: #9992a3;
}

.login-link a {
    color: #7021a8;

    font-weight: 800;

    text-decoration: none;

    margin-left: 3px;
}

.login-link a:hover {
    color: #b22962;

    text-decoration: underline;
}


        /* =====================================================
           PAGE
        ===================================================== */

        .register-page {
            width: 100%;
            height: 100dvh;

            display: flex;

            align-items: center;
            justify-content: center;

            padding: 14px 24px;

            overflow: hidden;
        }


        /* =====================================================
           MAIN CONTAINER
        ===================================================== */

        .register-container {
            width: min(
                1100px,
                calc(100vw - 48px)
            );

            height: min(
                720px,
                calc(100dvh - 28px)
            );

            display: grid;

            grid-template-columns: 44% 56%;

            overflow: hidden;

            background: #ffffff;

            border-radius: 22px;

            box-shadow:
                0 20px 55px
                rgba(45, 20, 70, .14);
        }


        /* =====================================================
           LEFT BRAND PANEL
        ===================================================== */

        .brand-panel {
            position: relative;

            height: 100%;

            overflow: hidden;

            padding: 28px 38px;

            color: #ffffff;

            background:
                radial-gradient(
                    circle at 10% 5%,
                    rgba(190, 70, 180, .28),
                    transparent 32%
                ),

                radial-gradient(
                    circle at 90% 90%,
                    rgba(190, 40, 80, .22),
                    transparent 32%
                ),

                linear-gradient(
                    145deg,
                    #351052 0%,
                    #541879 50%,
                    #761c69 100%
                );
        }


        .brand-panel::before {
            content: "";

            position: absolute;

            width: 500px;
            height: 500px;

            border:
                65px solid
                rgba(255,255,255,.035);

            border-radius: 50%;

            top: -310px;
            right: -220px;
        }


        .brand-panel::after {
            content: "";

            position: absolute;

            width: 320px;
            height: 320px;

            border:
                45px solid
                rgba(255,255,255,.035);

            border-radius: 50%;

            bottom: -230px;
            left: -220px;
        }


        .brand-content {
            position: relative;

            z-index: 2;

            width: 100%;
            height: 100%;

            display: flex;

            flex-direction: column;
        }


        /* =====================================================
           BRAND
        ===================================================== */

        .brand-logo {
            display: flex;

            align-items: center;

            gap: 10px;

            margin-bottom: 17px;
        }


        .brand-logo img {
            width: 43px;
            height: 43px;

            object-fit: contain;

            filter:
                brightness(0)
                invert(1);
        }


        .brand-name {
            font-size: 23px;

            font-weight: 800;

            line-height: 1;

            letter-spacing: -1px;
        }


        .brand-name span {
            font-weight: 400;

            opacity: .82;
        }


        .brand-tagline {
            margin-top: 4px;

            font-size: 8px;

            opacity: .68;
        }


        /* =====================================================
           HERO
        ===================================================== */

        .hero-title {
            max-width: 460px;

            margin: 0 0 8px;

            font-size: 39px;

            line-height: .99;

            letter-spacing: -1.8px;

            font-weight: 800;
        }


        .hero-title span {
            display: block;

            color: #ff7898;
        }


        .hero-description {
            max-width: 470px;

            margin: 0 0 15px;

            font-size: 11px;

            line-height: 1.45;

            color:
                rgba(255,255,255,.72);
        }


        /* =====================================================
           DASHBOARD
        ===================================================== */

        .dashboard-preview {
            position: relative;

            width: 100%;

            padding: 9px;

            background: #ffffff;

            border-radius: 13px;

            color: #19162c;

            box-shadow:
                0 18px 40px
                rgba(20,5,30,.28);
        }


        .dashboard-user {
            position: absolute;

            right: 15px;

            top: -28px;

            width: 56px;
            height: 56px;

            border-radius: 50%;

            border:
                3px solid #ffffff;

            overflow: hidden;

            background: #ddd;

            box-shadow:
                0 7px 17px
                rgba(0,0,0,.22);
        }


        .dashboard-user img {
            width: 100%;
            height: 100%;

            object-fit: cover;
        }


        .dashboard-top {
            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 6px;
        }


        .dashboard-title {
            font-size: 9px;

            font-weight: 800;
        }


        .dashboard-period {
            padding: 3px 6px;

            border-radius: 5px;

            background: #f6f3f9;

            color: #817a8d;

            font-size: 5px;
        }


        /* =====================================================
           STAT CARDS
        ===================================================== */

        .stat-grid {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 4px;

            margin-bottom: 6px;
        }


        .stat-card {
            padding: 5px;

            border-radius: 6px;

            background: #faf9fc;

            border:
                1px solid #efedf3;
        }


        .stat-label {
            margin-bottom: 2px;

            color: #938da0;

            font-size: 5px;
        }


        .stat-value {
            font-size: 9px;

            font-weight: 800;
        }


        .stat-growth {
            margin-top: 1px;

            color: #25945e;

            font-size: 4px;

            font-weight: 700;
        }


        /* =====================================================
           FINANCE CHART
        ===================================================== */

        .finance-chart {
            padding: 7px;

            border-radius: 7px;

            background: #ffffff;

            border:
                1px solid #ece9f1;
        }


        .finance-chart-header {
            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 4px;
        }


        .finance-chart-title {
            font-size: 8px;

            font-weight: 800;
        }


        .finance-chart-subtitle {
            margin-top: 1px;

            font-size: 4px;

            color: #9993a5;
        }


        .chart-period {
            padding: 3px 5px;

            border-radius: 4px;

            background: #f7f4fa;

            color: #716a7d;

            font-size: 4px;
        }


        .finance-summary {
            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 4px;

            margin-bottom: 4px;
        }


        .finance-summary-item {
            padding: 4px;

            border-radius: 5px;

            background: #faf9fc;
        }


        .summary-label {
            font-size: 4px;

            color: #938da0;
        }


        .summary-value {
            margin-top: 1px;

            font-size: 7px;

            font-weight: 800;
        }


        .summary-value.income {
            color: #7021a8;
        }


        .summary-value.expense {
            color: #d63c62;
        }


        .summary-value.giving {
            color: #b22962;
        }


        .summary-growth {
            margin-top: 1px;

            font-size: 4px;

            color: #23905d;

            font-weight: 700;
        }


        .finance-chart-area {
            display: flex;

            height: 58px;
        }


        .chart-y-axis {
            width: 18px;

            display: flex;

            flex-direction: column;

            justify-content: space-between;

            padding:
                2px 0 8px;

            font-size: 4px;

            color: #aaa4b2;

            text-align: right;
        }


        .chart-graph {
            position: relative;

            flex: 1;

            height: 100%;

            margin-left: 4px;
        }


        .chart-grid-line {
            position: absolute;

            left: 0;
            right: 0;

            border-top:
                1px dashed #ebe8ef;
        }


        .line-1 {
            top: 1px;
        }


        .line-2 {
            top: 33%;
        }


        .line-3 {
            top: 66%;
        }


        .line-4 {
            bottom: 8px;
        }


        .financial-svg {
            position: absolute;

            top: 0;
            left: 0;

            width: 100%;

            height:
                calc(100% - 8px);
        }


        .chart-months {
            position: absolute;

            bottom: 0;

            left: 0;
            right: 0;

            display: flex;

            justify-content:
                space-between;

            font-size: 4px;

            color: #aaa4b2;
        }


        .chart-legend {
            display: flex;

            align-items: center;

            gap: 7px;

            margin-top: 2px;

            font-size: 4px;

            color: #858092;
        }


        .chart-legend span {
            display: flex;

            align-items: center;

            gap: 2px;
        }


        .chart-legend i {
            width: 4px;
            height: 4px;

            border-radius: 50%;

            display: inline-block;
        }


        .legend-income {
            background: #7021a8;
        }


        .legend-giving {
            background: #b22962;
        }


        .chart-performance {
            margin-left: auto;

            color: #23905d;

            font-weight: 700;
        }


        /* =====================================================
           FEATURES
        ===================================================== */

        .features {
            margin-top: auto;

            padding-top: 11px;

            display: grid;

            grid-template-columns:
                repeat(3, 1fr);

            gap: 10px;
        }


        .feature-icon {
            width: 28px;
            height: 28px;

            display: flex;

            align-items: center;
            justify-content: center;

            margin-bottom: 4px;

            border-radius: 7px;

            background:
                rgba(255,255,255,.12);

            font-size: 12px;
        }


        .feature-title {
            margin-bottom: 2px;

            font-size: 7px;

            font-weight: 700;
        }


        .feature-text {
            font-size: 6px;

            line-height: 1.3;

            color:
                rgba(255,255,255,.60);
        }


        /* =====================================================
           RIGHT PANEL
        ===================================================== */

        .form-panel {
            height: 100%;

            display: flex;

            align-items: center;
            justify-content: center;

            padding: 18px 30px;

            overflow: hidden;
        }


        .form-container {
            width: 100%;

            max-width: 600px;

            max-height: 100%;

            display: flex;

            flex-direction: column;

            justify-content: center;
        }


        /* =====================================================
           PROGRESS
        ===================================================== */

        .progress-wrapper {
            margin-top: 6px;

            margin-bottom: 14px;

            padding: 0 10px;
        }


        .progress {
            display: grid;

            grid-template-columns:
                repeat(4, 1fr);

            gap: 5px;
        }


        .progress-step {
            position: relative;

            text-align: center;
        }


        .progress-step::after {
            content: "";

            position: absolute;

            top: 14px;

            left:
                calc(50% + 16px);

            width:
                calc(100% - 32px);

            height: 2px;

            background: #ebe7f0;
        }


        .progress-step:last-child::after {
            display: none;
        }


        .progress-number {
            position: relative;

            z-index: 2;

            width: 28px;
            height: 28px;

            margin:
                0 auto 4px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #f1edf5;

            color: #91899c;

            font-size: 9px;

            font-weight: 800;
        }


        .progress-step.active .progress-number,
        .progress-step.completed .progress-number {
            background: #7021a8;

            color: #ffffff;

            box-shadow:
                0 5px 14px
                rgba(112,33,168,.22);
        }


        .progress-step.completed::after {
            background: #7021a8;
        }


        .progress-label {
            font-size: 7px;

            font-weight: 600;

            color: #96909f;
        }


        .progress-step.active .progress-label,
        .progress-step.completed .progress-label {
            color: #7021a8;

            font-weight: 800;
        }


        /* =====================================================
           FORM HEADER
        ===================================================== */

        .form-header {
            margin-bottom: 10px;
        }


        .form-header h1 {
            margin: 0;

            font-size: 29px;

            line-height: 1.05;

            letter-spacing: -1px;

            color: #181525;
        }


        .form-header p {
            margin: 4px 0 0;

            color: #777389;

            font-size: 9px;
        }


        /* =====================================================
           ERRORS
        ===================================================== */

        .errors {
            margin-bottom: 8px;

            padding: 7px;

            border-radius: 7px;

            background: #fff1f2;

            border:
                1px solid #fecdd3;

            color: #be123c;

            font-size: 8px;
        }


        .errors ul {
            margin: 0;

            padding-left: 15px;
        }


        /* =====================================================
           STEPS
        ===================================================== */

        .step {
            display: none;
        }


        .step.active {
            display: block;

            animation:
                stepFade .2s ease;
        }


        @keyframes stepFade {

            from {
                opacity: 0;

                transform:
                    translateX(6px);
            }

            to {
                opacity: 1;

                transform:
                    translateX(0);
            }

        }


        /* =====================================================
           STEP CARD
        ===================================================== */

        .step-card {
            padding:
                14px 18px;

            border:
                1px solid #ece9f1;

            border-radius: 13px;

            background: #ffffff;

            box-shadow:
                0 8px 25px
                rgba(40,20,60,.04);
        }


        .step-title {
            margin-bottom: 2px;

            font-size: 15px;

            font-weight: 800;

            color: #26213b;
        }


        .step-description {
            margin-bottom: 9px;

            font-size: 8px;

            line-height: 1.3;

            color: #8b8595;
        }


        /* =====================================================
           FIELDS
        ===================================================== */

        .field {
            margin-bottom: 6px;
        }


        .field label {
            display: block;

            margin-bottom: 3px;

            font-size: 8px;

            font-weight: 700;

            color: #353047;
        }


        .input-wrapper {
            position: relative;
        }


        .input-icon {
            position: absolute;

            left: 11px;

            top: 50%;

            transform:
                translateY(-50%);

            color: #9992a9;

            font-size: 11px;

            pointer-events: none;
        }


        .form-input {
            width: 100%;

            height: 39px;

            padding:
                0 11px
                0 36px;

            border:
                1px solid #ddd9e5;

            border-radius: 8px;

            background: #ffffff;

            color: #211d32;

            font-size: 10px;

            outline: none;

            transition: .2s ease;
        }


        .form-input:focus {
            border-color: #7626aa;

            box-shadow:
                0 0 0 3px
                rgba(118,38,170,.06);
        }


        .form-input::placeholder {
            color: #aaa5b3;
        }


        textarea.form-input {
            height: 47px;

            padding-top: 9px;

            resize: none;
        }


        .field-grid {
            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 9px;
        }


        select.form-input {
            appearance: none;

            cursor: pointer;
        }


        /* =====================================================
           PASSWORD
        ===================================================== */

        .password-toggle {
            position: absolute;

            right: 10px;

            top: 50%;

            transform:
                translateY(-50%);

            border: 0;

            background: transparent;

            color: #8e879e;

            cursor: pointer;

            font-size: 10px;
        }


        /* =====================================================
           BUTTONS
        ===================================================== */

        .step-actions {
            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-top: 8px;
        }


        .back-button,
        .continue-button {
            height: 38px;

            border-radius: 8px;

            font-size: 8px;

            font-weight: 800;

            cursor: pointer;
        }


        .back-button {
            padding:
                0 16px;

            border:
                1px solid #ddd9e5;

            background: #ffffff;

            color: #716a7d;
        }


        .back-button:disabled {
            opacity: .35;

            cursor: not-allowed;
        }


        .continue-button {
            padding:
                0 21px;

            border: 0;

            background:
                linear-gradient(
                    90deg,
                    #7021a8,
                    #b22962
                );

            color: #ffffff;

            box-shadow:
                0 7px 16px
                rgba(112,33,168,.20);

            transition: .2s ease;
        }


        .continue-button:hover {
            transform:
                translateY(-1px);
        }


        /* =====================================================
           PLAN
        ===================================================== */

        .plan-card {
            position: relative;

            padding: 17px;

            border:
                2px solid #7021a8;

            border-radius: 12px;

            background:
                linear-gradient(
                    135deg,
                    #fbf7ff,
                    #ffffff
                );
        }


        .plan-badge {
            position: absolute;

            top: -9px;

            right: 16px;

            padding:
                4px 8px;

            border-radius: 20px;

            background: #7021a8;

            color: #ffffff;

            font-size: 6px;

            font-weight: 800;

            text-transform: uppercase;

            letter-spacing: .4px;
        }


        .plan-header {
            display: flex;

            align-items: center;

            justify-content: space-between;

            margin-bottom: 8px;
        }


        .plan-name {
            font-size: 17px;

            font-weight: 800;

            color: #541679;
        }


        .plan-price {
            font-size: 20px;

            font-weight: 900;

            color: #7021a8;
        }


        .plan-price span {
            font-size: 7px;

            font-weight: 600;

            color: #938da0;
        }


        .plan-description {
            margin-bottom: 10px;

            font-size: 8px;

            line-height: 1.4;

            color: #777389;
        }


        .plan-features {
            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 6px;
        }


        .plan-feature {
            display: flex;

            align-items: center;

            gap: 5px;

            font-size: 7px;

            color: #4d4758;
        }


        .plan-feature span {
            width: 16px;
            height: 16px;

            display: flex;

            align-items: center;
            justify-content: center;

            border-radius: 50%;

            background: #efe4f7;

            color: #7021a8;

            font-size: 7px;

            font-weight: 800;
        }


        /* =====================================================
           REVIEW
        ===================================================== */

        .review-card {
            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 7px;
        }


        .review-item {
            padding: 8px;

            border-radius: 7px;

            background: #faf9fc;

            border:
                1px solid #eeeaf2;
        }


        .review-label {
            margin-bottom: 2px;

            color: #9992a3;

            font-size: 6px;

            text-transform: uppercase;

            letter-spacing: .4px;
        }


        .review-value {
            color: #302a3d;

            font-size: 9px;

            font-weight: 700;

            word-break: break-word;
        }


        .activation-message {
            margin-top: 8px;

            padding: 9px;

            border-radius: 7px;

            background: #f8f3fb;

            color: #6d5580;

            font-size: 7px;

            line-height: 1.4;
        }


        /* =====================================================
           TERMS
        ===================================================== */

        .terms {
            display: flex;

            align-items: flex-start;

            gap: 6px;

            margin-top: 8px;

            margin-bottom: 6px;
        }


        .terms input {
            width: 13px;
            height: 13px;

            margin: 0;

            accent-color: #7021a8;
        }


        .terms label {
            font-size: 7px;

            line-height: 1.4;

            color: #777389;
        }


        .terms a {
            color: #7021a8;

            font-weight: 700;

            text-decoration: none;
        }


        /* =====================================================
           SECURITY
        ===================================================== */

        .security-note {
            margin-top: 6px;

            text-align: center;

            font-size: 6px;

            color: #aaa4b2;
        }


        /* =====================================================
           TABLET
        ===================================================== */

        @media (max-width: 1100px) {

            .register-container {
                width:
                    calc(100vw - 32px);

                grid-template-columns:
                    42% 58%;
            }

            .brand-panel {
                padding:
                    25px 28px;
            }

            .hero-title {
                font-size: 34px;
            }

            .form-panel {
                padding:
                    16px 24px;
            }
        }


        /* =====================================================
           MOBILE
        ===================================================== */

        @media (max-width: 850px) {

            body {
                overflow: auto;
            }


            .register-page {
                height: auto;

                min-height: 100dvh;

                padding: 0;

                overflow: visible;
            }


            .register-container {
                width: 100%;

                height: auto;

                min-height: 100dvh;

                grid-template-columns: 1fr;

                border-radius: 0;
            }


            .brand-panel {
                height: 390px;

                min-height: 390px;
            }


            .form-panel {
                height: auto;

                min-height: 600px;

                padding:
                    30px 20px;

                overflow: visible;
            }


            .form-container {
                max-height: none;
            }
        }


        @media (max-width: 520px) {

            .brand-panel {
                height: 340px;

                min-height: 340px;

                padding:
                    22px 18px;
            }


            .hero-title {
                font-size: 28px;
            }


            .features {
                display: none;
            }


            .stat-grid {
                grid-template-columns:
                    repeat(2, 1fr);
            }


            .field-grid {
                grid-template-columns: 1fr;

                gap: 0;
            }


            .progress-label {
                font-size: 6px;
            }


            .form-panel {
                padding:
                    25px 16px;
            }


            .review-card {
                grid-template-columns: 1fr;
            }


            .plan-features {
                grid-template-columns: 1fr;
            }
        }

    </style>

</head>


<body>


<div class="register-page">


    <div class="register-container">


        {{-- =====================================================
             LEFT SIDE
        ====================================================== --}}

        <section class="brand-panel">


            <div class="brand-content">


                <div class="brand-logo">

                    <img
                        src="{{ asset('images/techcrossbreed-logo.png') }}"
                        alt="ChurchFlow"
                    >

                    <div>

                        <div class="brand-name">
                            Church<span>Flow</span>
                        </div>

                        <div class="brand-tagline">
                            Church Management. Simplified.
                        </div>

                    </div>

                </div>


                <h2 class="hero-title">

                    Everything your church needs.

                    <span>
                        One simple platform.
                    </span>

                </h2>


                <p class="hero-description">

                    Manage members, finances,
                    attendance, giving and church
                    operations from one powerful platform.

                </p>


                <div class="dashboard-preview">


                    <div class="dashboard-user">

                        <img
                            src="{{ asset('images/churchflow-avatar.jpg') }}"
                            alt="ChurchFlow"
                        >

                    </div>


                    <div class="dashboard-top">

                        <div class="dashboard-title">
                            ChurchFlow Overview
                        </div>

                        <div class="dashboard-period">
                            August 2026
                        </div>

                    </div>


                    <div class="stat-grid">


                        <div class="stat-card">

                            <div class="stat-label">
                                Members
                            </div>

                            <div class="stat-value">
                                1,248
                            </div>

                            <div class="stat-growth">
                                ↑ 8.4%
                            </div>

                        </div>


                        <div class="stat-card">

                            <div class="stat-label">
                                Tithes
                            </div>

                            <div class="stat-value">
                                ₦1.28M
                            </div>

                            <div class="stat-growth">
                                ↑ 14.2%
                            </div>

                        </div>


                        <div class="stat-card">

                            <div class="stat-label">
                                Offerings
                            </div>

                            <div class="stat-value">
                                ₦685K
                            </div>

                            <div class="stat-growth">
                                ↑ 9.7%
                            </div>

                        </div>


                        <div class="stat-card">

                            <div class="stat-label">
                                Attendance
                            </div>

                            <div class="stat-value">
                                86%
                            </div>

                            <div class="stat-growth">
                                ↑ 5.1%
                            </div>

                        </div>


                    </div>


                    <div class="finance-chart">


                        <div class="finance-chart-header">

                            <div>

                                <div class="finance-chart-title">
                                    Financial Overview
                                </div>

                                <div class="finance-chart-subtitle">
                                    Church income & giving performance
                                </div>

                            </div>

                            <div class="chart-period">
                                This Month
                            </div>

                        </div>


                        <div class="finance-summary">


                            <div class="finance-summary-item">

                                <div class="summary-label">
                                    Income
                                </div>

                                <div class="summary-value income">
                                    ₦2.45M
                                </div>

                                <div class="summary-growth">
                                    ↑ 12.8%
                                </div>

                            </div>


                            <div class="finance-summary-item">

                                <div class="summary-label">
                                    Expenses
                                </div>

                                <div class="summary-value expense">
                                    ₦1.32M
                                </div>

                                <div class="summary-growth">
                                    ↓ 4.3%
                                </div>

                            </div>


                            <div class="finance-summary-item">

                                <div class="summary-label">
                                    Balance
                                </div>

                                <div class="summary-value giving">
                                    ₦1.13M
                                </div>

                                <div class="summary-growth">
                                    ↑ 15.7%
                                </div>

                            </div>


                        </div>


                        <div class="finance-chart-area">


                            <div class="chart-y-axis">

                                <span>₦3M</span>
                                <span>₦2M</span>
                                <span>₦1M</span>
                                <span>₦0</span>

                            </div>


                            <div class="chart-graph">


                                <div class="chart-grid-line line-1"></div>
                                <div class="chart-grid-line line-2"></div>
                                <div class="chart-grid-line line-3"></div>
                                <div class="chart-grid-line line-4"></div>


                                <svg
                                    viewBox="0 0 600 180"
                                    preserveAspectRatio="none"
                                    class="financial-svg"
                                >

                                    <path
                                        d="
                                            M0 135
                                            C45 128
                                            65 110
                                            100 116
                                            C140 122
                                            155 82
                                            200 91
                                            C245 100
                                            260 58
                                            305 67
                                            C350 76
                                            370 38
                                            410 52
                                            C450 66
                                            470 29
                                            510 39
                                            C545 48
                                            565 22
                                            600 28
                                        "
                                        fill="none"
                                        stroke="#7021a8"
                                        stroke-width="4"
                                        stroke-linecap="round"
                                    />


                                    <path
                                        d="
                                            M0 152
                                            C45 148
                                            70 136
                                            105 140
                                            C145 145
                                            170 117
                                            205 125
                                            C245 133
                                            270 102
                                            305 110
                                            C350 119
                                            370 92
                                            410 101
                                            C450 110
                                            475 77
                                            510 88
                                            C550 98
                                            570 69
                                            600 75
                                        "
                                        fill="none"
                                        stroke="#b22962"
                                        stroke-width="3"
                                        stroke-linecap="round"
                                        stroke-dasharray="6 5"
                                    />


                                    <circle
                                        cx="305"
                                        cy="67"
                                        r="5"
                                        fill="#7021a8"
                                        stroke="#ffffff"
                                        stroke-width="2"
                                    />


                                    <circle
                                        cx="510"
                                        cy="39"
                                        r="5"
                                        fill="#7021a8"
                                        stroke="#ffffff"
                                        stroke-width="2"
                                    />

                                </svg>


                                <div class="chart-months">

                                    <span>Jan</span>
                                    <span>Feb</span>
                                    <span>Mar</span>
                                    <span>Apr</span>
                                    <span>May</span>
                                    <span>Jun</span>

                                </div>


                            </div>

                        </div>


                        <div class="chart-legend">

                            <span>
                                <i class="legend-income"></i>
                                Income
                            </span>

                            <span>
                                <i class="legend-giving"></i>
                                Giving
                            </span>

                            <span class="chart-performance">
                                +12.8% this month
                            </span>

                        </div>


                    </div>


                </div>


                <div class="features">


                    <div>

                        <div class="feature-icon">
                            👥
                        </div>

                        <div class="feature-title">
                            Member Management
                        </div>

                        <div class="feature-text">
                            Organize and manage church members.
                        </div>

                    </div>


                    <div>

                        <div class="feature-icon">
                            💰
                        </div>

                        <div class="feature-title">
                            Church Finances
                        </div>

                        <div class="feature-text">
                            Track giving, income and expenses.
                        </div>

                    </div>


                    <div>

                        <div class="feature-icon">
                            📊
                        </div>

                        <div class="feature-title">
                            Smart Reports
                        </div>

                        <div class="feature-text">
                            Understand your church through reports.
                        </div>

                    </div>


                </div>


            </div>


        </section>


        {{-- =====================================================
             RIGHT SIDE
        ====================================================== --}}

        <section class="form-panel">


            <div class="form-container">


                {{-- PROGRESS --}}

                <div class="progress-wrapper">

                    <div class="progress">


                        <div
                            class="progress-step active"
                            data-step="1"
                        >

                            <div class="progress-number">
                                1
                            </div>

                            <div class="progress-label">
                                Church Information
                            </div>

                        </div>


                        <div
                            class="progress-step"
                            data-step="2"
                        >

                            <div class="progress-number">
                                2
                            </div>

                            <div class="progress-label">
                                Church Owner
                            </div>

                        </div>


                        <div
                            class="progress-step"
                            data-step="3"
                        >

                            <div class="progress-number">
                                3
                            </div>

                            <div class="progress-label">
                                Plan
                            </div>

                        </div>


                        <div
                            class="progress-step"
                            data-step="4"
                        >

                            <div class="progress-number">
                                4
                            </div>

                            <div class="progress-label">
                                Activate
                            </div>

                        </div>


                    </div>

                </div>


                {{-- HEADER --}}

                <div class="form-header">

                    <h1 id="page-title">
                        Create your ChurchFlow account
                    </h1>

                    <p id="page-description">
                        Let's start by setting up your church profile.
                    </p>

                </div>


                {{-- ERRORS --}}

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
                    action="{{ route('register.store') }}"
                    id="registrationForm"
                >

                    @csrf


                    {{-- =================================================
                         STEP 1
                    ================================================== --}}

                    <div
                        class="step active"
                        data-step="1"
                    >

                        <div class="step-card">


                            <div class="step-title">
                                Church Information
                            </div>


                            <div class="step-description">
                                Tell us a little about your church.
                            </div>


                            <div class="field">

                                <label for="church_name">
                                    Church Name *
                                </label>

                                <div class="input-wrapper">

                                    <span class="input-icon">
                                        ⛪
                                    </span>

                                    <input
                                        id="church_name"
                                        name="church_name"
                                        type="text"
                                        class="form-input"
                                        value="{{ old('church_name') }}"
                                        placeholder="Enter your church name"
                                        required
                                    >

                                </div>

                            </div>


                            <div class="field-grid">


                                <div class="field">

                                    <label for="church_email">
                                        Church Email
                                    </label>

                                    <div class="input-wrapper">

                                        <span class="input-icon">
                                            ✉
                                        </span>

                                        <input
                                            id="church_email"
                                            name="church_email"
                                            type="email"
                                            class="form-input"
                                            value="{{ old('church_email') }}"
                                            placeholder="church@example.com"
                                        >

                                    </div>

                                </div>


                                <div class="field">

                                    <label for="church_phone">
                                        Phone Number
                                    </label>

                                    <div class="input-wrapper">

                                        <span class="input-icon">
                                            ☎
                                        </span>

                                        <input
                                            id="church_phone"
                                            name="church_phone"
                                            type="text"
                                            class="form-input"
                                            value="{{ old('church_phone') }}"
                                            placeholder="080..."
                                        >

                                    </div>

                                </div>


                            </div>


                            <div class="field">

                                <label for="address">
                                    Church Address
                                </label>

                                <div class="input-wrapper">

                                    <span class="input-icon">
                                        📍
                                    </span>

                                    <textarea
                                        id="address"
                                        name="address"
                                        class="form-input"
                                        placeholder="Enter church address"
                                    >{{ old('address') }}</textarea>

                                </div>

                            </div>


                            <div class="field-grid">


                                <div class="field">

                                    <label for="city">
                                        City
                                    </label>

                                    <div class="input-wrapper">

                                        <span class="input-icon">
                                            🏙
                                        </span>

                                        <input
                                            id="city"
                                            name="city"
                                            type="text"
                                            class="form-input"
                                            value="{{ old('city') }}"
                                            placeholder="Lagos"
                                        >

                                    </div>

                                </div>


                                <div class="field">

                                    <label for="state">
                                        State
                                    </label>

                                    <div class="input-wrapper">

                                        <span class="input-icon">
                                            📌
                                        </span>

                                        <input
                                            id="state"
                                            name="state"
                                            type="text"
                                            class="form-input"
                                            value="{{ old('state') }}"
                                            placeholder="Lagos State"
                                        >

                                    </div>

                                </div>


                            </div>


                            <div class="field-grid">


                                <div class="field">

                                    <label for="country">
                                        Country
                                    </label>

                                    <div class="input-wrapper">

                                        <span class="input-icon">
                                            🌍
                                        </span>

                                        <select
                                            id="country"
                                            name="country"
                                            class="form-input"
                                        >

                                            <option value="Nigeria">
                                                Nigeria
                                            </option>

                                            <option value="Ghana">
                                                Ghana
                                            </option>

                                            <option value="Kenya">
                                                Kenya
                                            </option>

                                            <option value="South Africa">
                                                South Africa
                                            </option>

                                            <option value="United Kingdom">
                                                United Kingdom
                                            </option>

                                            <option value="United States">
                                                United States
                                            </option>

                                        </select>

                                    </div>

                                </div>


                                <div class="field">

                                    <label for="timezone">
                                        Timezone
                                    </label>

                                    <div class="input-wrapper">

                                        <span class="input-icon">
                                            🕐
                                        </span>

                                        <select
                                            id="timezone"
                                            name="timezone"
                                            class="form-input"
                                        >

                                            <option value="Africa/Lagos">
                                                Africa/Lagos (WAT)
                                            </option>

                                            <option value="Africa/Accra">
                                                Africa/Accra (GMT)
                                            </option>

                                            <option value="Africa/Nairobi">
                                                Africa/Nairobi (EAT)
                                            </option>

                                            <option value="Africa/Johannesburg">
                                                Africa/Johannesburg (SAST)
                                            </option>

                                            <option value="Europe/London">
                                                Europe/London
                                            </option>

                                            <option value="America/New_York">
                                                America/New_York
                                            </option>

                                        </select>

                                    </div>

                                </div>


                            </div>


                            <div class="step-actions">

                                <button
                                    type="button"
                                    class="back-button"
                                    disabled
                                >
                                    ← Back
                                </button>

                                <button
                                    type="button"
                                    class="continue-button"
                                    onclick="nextStep()"
                                >
                                    Continue →
                                </button>

                            </div>


                        </div>

                    </div>


                    {{-- =================================================
                         STEP 2
                    ================================================== --}}

                    <div
                        class="step"
                        data-step="2"
                    >

                        <div class="step-card">


                            <div class="step-title">
                                Church Owner Information
                            </div>


                            <div class="step-description">
                                Create the administrator account
                                that will manage this church.
                            </div>


                            <div class="field">

                                <label for="name">
                                    Full Name *
                                </label>

                                <div class="input-wrapper">

                                    <span class="input-icon">
                                        👤
                                    </span>

                                    <input
                                        id="name"
                                        name="name"
                                        type="text"
                                        class="form-input"
                                        value="{{ old('name') }}"
                                        placeholder="Enter your full name"
                                    >

                                </div>

                            </div>


                            <div class="field">

                                <label for="email">
                                    Email Address *
                                </label>

                                <div class="input-wrapper">

                                    <span class="input-icon">
                                        ✉
                                    </span>

                                    <input
                                        id="email"
                                        name="email"
                                        type="email"
                                        class="form-input"
                                        value="{{ old('email') }}"
                                        placeholder="Enter your email address"
                                    >

                                </div>

                            </div>


                            <div class="field-grid">


                                <div class="field">

                                    <label for="password">
                                        Password *
                                    </label>

                                    <div class="input-wrapper">

                                        <span class="input-icon">
                                            🔒
                                        </span>

                                        <input
                                            id="password"
                                            name="password"
                                            type="password"
                                            class="form-input"
                                            placeholder="Create password"
                                            autocomplete="new-password"
                                        >

                                        <button
                                            type="button"
                                            class="password-toggle"
                                            onclick="
                                                togglePassword(
                                                    'password',
                                                    this
                                                )
                                            "
                                        >
                                            👁
                                        </button>

                                    </div>

                                </div>


                                <div class="field">

                                    <label for="password_confirmation">
                                        Confirm Password *
                                    </label>

                                    <div class="input-wrapper">

                                        <span class="input-icon">
                                            🔒
                                        </span>

                                        <input
                                            id="password_confirmation"
                                            name="password_confirmation"
                                            type="password"
                                            class="form-input"
                                            placeholder="Confirm password"
                                            autocomplete="new-password"
                                        >

                                        <button
                                            type="button"
                                            class="password-toggle"
                                            onclick="
                                                togglePassword(
                                                    'password_confirmation',
                                                    this
                                                )
                                            "
                                        >
                                            👁
                                        </button>

                                    </div>

                                </div>


                            </div>


                            <div class="step-actions">

                                <button
                                    type="button"
                                    class="back-button"
                                    onclick="previousStep()"
                                >
                                    ← Back
                                </button>

                                <button
                                    type="button"
                                    class="continue-button"
                                    onclick="nextStep()"
                                >
                                    Continue →
                                </button>

                            </div>


                        </div>

                    </div>


                    {{-- =================================================
                         STEP 3
                    ================================================== --}}

                    <div
                        class="step"
                        data-step="3"
                    >

                        <div class="step-card">


                            <div class="step-title">
                                Choose Your Plan
                            </div>


                            <div class="step-description">
                                Start with our free 30-day trial.
                                No payment is required.
                            </div>


                            <div class="plan-card">


                                <div class="plan-badge">
                                    Recommended
                                </div>


                                <div class="plan-header">

                                    <div class="plan-name">
                                        Free Trial
                                    </div>

                                    <div class="plan-price">

                                        ₦0

                                        <span>
                                            / 30 days
                                        </span>

                                    </div>

                                </div>


                                <div class="plan-description">

                                    Get full access to ChurchFlow
                                    and explore how it can help
                                    your church operate more
                                    efficiently.

                                </div>


                                <div class="plan-features">


                                    <div class="plan-feature">
                                        <span>✓</span>
                                        Member Management
                                    </div>


                                    <div class="plan-feature">
                                        <span>✓</span>
                                        Church Finances
                                    </div>


                                    <div class="plan-feature">
                                        <span>✓</span>
                                        Attendance & Check-In
                                    </div>


                                    <div class="plan-feature">
                                        <span>✓</span>
                                        Reports & Analytics
                                    </div>


                                    <div class="plan-feature">
                                        <span>✓</span>
                                        Church Administration
                                    </div>


                                    <div class="plan-feature">
                                        <span>✓</span>
                                        Email Notifications
                                    </div>


                                </div>


                            </div>


                            <div class="step-actions">

                                <button
                                    type="button"
                                    class="back-button"
                                    onclick="previousStep()"
                                >
                                    ← Back
                                </button>

                                <button
                                    type="button"
                                    class="continue-button"
                                    onclick="nextStep()"
                                >
                                    Review →
                                </button>

                            </div>


                        </div>

                    </div>


                    {{-- =================================================
                         STEP 4
                    ================================================== --}}

                    <div
                        class="step"
                        data-step="4"
                    >

                        <div class="step-card">


                            <div class="step-title">
                                Review & Activate
                            </div>


                            <div class="step-description">
                                Review your information before
                                activating your ChurchFlow account.
                            </div>


                            <div class="review-card">


                                <div class="review-item">

                                    <div class="review-label">
                                        Church
                                    </div>

                                    <div
                                        class="review-value"
                                        id="reviewChurch"
                                    >
                                        —
                                    </div>

                                </div>


                                <div class="review-item">

                                    <div class="review-label">
                                        Church Email
                                    </div>

                                    <div
                                        class="review-value"
                                        id="reviewChurchEmail"
                                    >
                                        —
                                    </div>

                                </div>


                                <div class="review-item">

                                    <div class="review-label">
                                        Location
                                    </div>

                                    <div
                                        class="review-value"
                                        id="reviewLocation"
                                    >
                                        —
                                    </div>

                                </div>


                                <div class="review-item">

                                    <div class="review-label">
                                        Church Owner
                                    </div>

                                    <div
                                        class="review-value"
                                        id="reviewOwner"
                                    >
                                        —
                                    </div>

                                </div>


                                <div class="review-item">

                                    <div class="review-label">
                                        Owner Email
                                    </div>

                                    <div
                                        class="review-value"
                                        id="reviewEmail"
                                    >
                                        —
                                    </div>

                                </div>


                                <div class="review-item">

                                    <div class="review-label">
                                        Selected Plan
                                    </div>

                                    <div class="review-value">
                                        Free Trial — 30 Days
                                    </div>

                                </div>


                            </div>


                            <div class="activation-message">

                                🎉 You're almost ready!

                                Your church will receive a
                                <strong>30-day free trial</strong>
                                when you activate your account.

                                No payment is required.

                            </div>


                            <div class="terms">

                                <input
                                    type="checkbox"
                                    id="terms"
                                    name="terms"
                                >

                                <label for="terms">

                                    I agree to the

                                    <a href="#">
                                        Terms & Conditions
                                    </a>

                                    and

                                    <a href="#">
                                        Privacy Policy
                                    </a>

                                </label>

                            </div>


                            <div class="step-actions">

                                <button
                                    type="button"
                                    class="back-button"
                                    onclick="previousStep()"
                                >
                                    ← Back
                                </button>

                                <button
                                    type="submit"
                                    class="continue-button"
                                >
                                    Activate ChurchFlow →
                                </button>

                            </div>


                        </div>

                    </div>


                </form>


                <div class="security-note">
                    🔒 Your information is securely protected.
                </div>

                <div class="login-link">
                    Already have a ChurchFlow account?
                    <a href="{{ route('login') }}">
                        Login here
                    </a>
                </div>


            </div>

        </section>

    </div>

</div>


<script>

    let currentStep = 1;

    const totalSteps = 4;


    const stepTitles = {

        1: {
            title:
                "Create your ChurchFlow account",

            description:
                "Let's start by setting up your church profile."
        },

        2: {
            title:
                "Create your administrator account",

            description:
                "Tell us who will manage this church."
        },

        3: {
            title:
                "Choose your plan",

            description:
                "Start your church with a 30-day free trial."
        },

        4: {
            title:
                "Review & activate",

            description:
                "Everything looks good? Let's get your church started."
        }

    };


    function showStep(step) {

        currentStep = step;


        document
            .querySelectorAll('.step')
            .forEach(function(element) {

                element.classList.remove('active');

            });


        const activeStep =
            document.querySelector(
                '.step[data-step="' + step + '"]'
            );


        if (activeStep) {

            activeStep.classList.add('active');

        }


        document
            .querySelectorAll('.progress-step')
            .forEach(function(element) {

                const number =
                    Number(element.dataset.step);


                element.classList.remove(
                    'active',
                    'completed'
                );


                if (number === step) {

                    element.classList.add(
                        'active'
                    );

                }


                if (number < step) {

                    element.classList.add(
                        'completed'
                    );

                }

            });


        document.getElementById(
            'page-title'
        ).textContent =
            stepTitles[step].title;


        document.getElementById(
            'page-description'
        ).textContent =
            stepTitles[step].description;


        if (step === 4) {

            updateReview();

        }

    }


    function nextStep() {

        if (!validateCurrentStep()) {

            return;

        }


        if (currentStep < totalSteps) {

            showStep(
                currentStep + 1
            );

        }

    }


    function previousStep() {

        if (currentStep > 1) {

            showStep(
                currentStep - 1
            );

        }

    }


    function validateCurrentStep() {

        if (currentStep === 1) {

            const churchName =
                document.getElementById(
                    'church_name'
                );


            if (!churchName.value.trim()) {

                churchName.focus();

                return false;

            }

        }


        if (currentStep === 2) {

            const name =
                document.getElementById(
                    'name'
                );


            const email =
                document.getElementById(
                    'email'
                );


            const password =
                document.getElementById(
                    'password'
                );


            const confirmation =
                document.getElementById(
                    'password_confirmation'
                );


            if (!name.value.trim()) {

                name.focus();

                return false;

            }


            if (!email.value.trim()) {

                email.focus();

                return false;

            }


            if (!password.value) {

                password.focus();

                return false;

            }


            if (
                password.value !==
                confirmation.value
            ) {

                alert(
                    'Passwords do not match.'
                );

                confirmation.focus();

                return false;

            }

        }


        if (currentStep === 4) {

            const terms =
                document.getElementById(
                    'terms'
                );


            if (!terms.checked) {

                alert(
                    'Please accept the Terms & Conditions and Privacy Policy.'
                );

                terms.focus();

                return false;

            }

        }


        return true;

    }


    function updateReview() {

        const church =
            document.getElementById(
                'church_name'
            ).value;


        const churchEmail =
            document.getElementById(
                'church_email'
            ).value;


        const city =
            document.getElementById(
                'city'
            ).value;


        const state =
            document.getElementById(
                'state'
            ).value;


        const owner =
            document.getElementById(
                'name'
            ).value;


        const email =
            document.getElementById(
                'email'
            ).value;


        document.getElementById(
            'reviewChurch'
        ).textContent =
            church || '—';


        document.getElementById(
            'reviewChurchEmail'
        ).textContent =
            churchEmail || 'Not provided';


        document.getElementById(
            'reviewLocation'
        ).textContent =
            [city, state]
                .filter(Boolean)
                .join(', ') || 'Not provided';


        document.getElementById(
            'reviewOwner'
        ).textContent =
            owner || '—';


        document.getElementById(
            'reviewEmail'
        ).textContent =
            email || '—';

    }


    function togglePassword(
        fieldId,
        button
    ) {

        const input =
            document.getElementById(
                fieldId
            );


        if (
            input.type ===
            'password'
        ) {

            input.type = 'text';

            button.innerHTML = '🙈';

        } else {

            input.type = 'password';

            button.innerHTML = '👁';

        }

    }


    document
        .getElementById(
            'registrationForm'
        )
        .addEventListener(
            'submit',
            function(event) {

                if (
                    currentStep !== 4 ||
                    !validateCurrentStep()
                ) {

                    event.preventDefault();

                }

            }
        );


    showStep(1);

</script>


</body>

</html>