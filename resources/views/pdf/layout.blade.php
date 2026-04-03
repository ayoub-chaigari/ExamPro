<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>@yield('title', 'Examen OFPPT')</title>
    <style>
        /* ============================================================
         *  DomPDF PAGE SETUP
         * ============================================================ */
        @page {
            margin: 160px 40px 80px 40px; /* Space for the larger header */
        }

        /* ============================================================
         *  HEADER — fixed at top of every page
         * ============================================================ */
        header {
            position: fixed;
            top: -140px;   /* Position within top margin */
            left: 0;
            right: 0;
            height: 140px;
        }

        /* ---- OPTION 2: IMAGE HEADER (ACTIVE — recommended) -------- */
        .header-image {
            width: 100%;
            display: block;
        }

        /* ---- OPTION 1: HTML fallback — logo left, text image right -- */
        .header-table {
            width: 100%;
            border-collapse: collapse;
            border-bottom: 4px solid #1e3a8a;
            margin-bottom: 10px;
        }

        .logo-td {
            width: 130px;
            vertical-align: middle;
            text-align: left;
            padding-bottom: 8px;
        }

        .logo-img {
            height: 120px;
            width: auto;
            display: block;
        }

        .text-td {
            vertical-align: middle;
            text-align: right;
            padding-bottom: 8px;
        }

        .text-img {
            height: 110px;
            width: auto;
            display: block;
            margin-left: auto;
        }

        /* ============================================================
         *  FOOTER
         * ============================================================ */
        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 11px;
            color: #6b7280;
            font-style: italic;
        }

        /* ============================================================
         *  BODY & UTILITIES
         * ============================================================ */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 14px;
            color: #1f2937;
        }

        .w-full          { width: 100%; }
        .text-center     { text-align: center; }
        .font-bold       { font-weight: bold; }
        .border-collapse { border-collapse: collapse; }

        /* ============================================================
         *  EXAM INFO LAYOUT
         * ============================================================ */
        .exam-title-box {
            background-color: #1e3a8a;
            color: white;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            font-size: 15px;
            margin-bottom: 14px;
        }

        .info-table    { width: 100%; border-collapse: collapse; margin-bottom: 22px; }
        .info-table td { border: 1px solid #374151; padding: 7px 10px; font-size: 12px; width: 50%; }
        .info-label    { font-weight: bold; color: #374151; }
    </style>
</head>
<body>

    {{-- ================================================================
         HEADER SECTION
         ================================================================

         ✅ OPTION 2: IMAGE HEADER (ACTIVE — recommended for OFPPT)
         Save your cropped header image to: public/header.png
         ================================================================ --}}
    <header>
        <table class="header-table" style="width: 100%; border-collapse: collapse; border-bottom: 4px solid #1e3a8a;">
            <tr>
                <td style="text-align: center; vertical-align: middle; padding-bottom: 12px;">
                    {{-- Logo on the LEFT (now part of the centered block) --}}
                    <img src="{{ public_path('logo.png') }}" style="height: 100px; width: auto; vertical-align: middle; margin-right: 20px;" alt="Logo">

                    {{-- Arabic/French Text Image in the MIDDLE/RIGHT --}}
                    @php
                        $headerTextFile = null;
                        if(file_exists(public_path('header.png'))) {
                            $headerTextFile = 'header.png';
                        } elseif(file_exists(public_path('logo_ofppt.jpg'))) {
                            $headerTextFile = 'logo_ofppt.jpg';
                        }
                    @endphp

                    @if($headerTextFile)
                        <img src="{{ public_path($headerTextFile) }}" style="height: 80px; width: auto; vertical-align: middle;" alt="Header Text">
                    @else
                        {{-- Text fallback if no images found --}}
                        <div style="display: inline-block; vertical-align: middle; text-align: center;">
                            <div style="font-family:'DejaVu Sans',sans-serif; font-size:24px; font-weight:bold; direction:rtl; margin-bottom:5px;">
                                مكتب التكوين المهني وإنعاش الشغل
                            </div>
                            <div style="font-size:12px; font-weight:bold; font-style:italic; color:#111;">
                                _Office de la Formation Professionnelle et de la<br>
                                Promotion du Travail
                            </div>
                        </div>
                    @endif
                </td>
            </tr>
        </table>
    </header>

    {{-- FOOTER --}}
    <footer>
        <div>Bonne chance &mdash; Good luck</div>
    </footer>

    {{-- ================================================================
         MAIN CONTENT
         ================================================================ --}}
    <div>
        {{-- Exam Type Title (EFM / EXAMEN) --}}
        <div class="exam-title-box">
            @yield('exam_title', 'EVALUATION DE FIN DE MODULE LOCAL')
        </div>

        {{-- Info Table --}}
        <table class="info-table">
            <tr>
                <td><span class="info-label">Filière :</span> @yield('filiere', '______________________')</td>
                <td><span class="info-label">N° du module :</span> @yield('module_no', '_____')</td>
            </tr>
            <tr>
                <td><span class="info-label">Niveau :</span> @yield('niveau', '______________________')</td>
                <td><span class="info-label">Variante :</span> @yield('variante', '1')</td>
            </tr>
            <tr>
                <td><span class="info-label">Durée :</span> @yield('duree', '90') min</td>
                <td><span class="info-label">Barème :</span> @yield('bareme', '/20')</td>
            </tr>
            <tr>
                <td colspan="2"><span class="info-label">Intitulé du module :</span> @yield('module_name', '______________________')</td>
            </tr>
            <tr>
                <td colspan="2"><span class="info-label">Date d'évaluation :</span> @yield('date', date('d/m/Y'))</td>
            </tr>
        </table>

        @yield('content')
    </div>

</body>
</html>
