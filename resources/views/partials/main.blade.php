<!DOCTYPE html>
<html lang="en">
<!-- [Head] start -->

<head>
    <title>DES - YOGI SEMBIRING</title>
    <!-- [Meta] -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description"
        content="Gradient Able is trending dashboard template made using Bootstrap 5 design framework. Gradient Able is available in Bootstrap, React, CodeIgniter, Angular,  and .net Technologies.">
    <meta name="keywords"
        content="Bootstrap admin template, Dashboard UI Kit, Dashboard Template, Backend Panel, react dashboard, angular dashboard">
    <meta name="author" content="codedthemes">
    <!-- Tambahkan favicon -->
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <!-- Favicon untuk berbagai platform -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon-16x16.png">
    <!-- [Favicon] icon -->
    {{-- <link rel="icon" href="../assets/images/favicon.svg" type="image/x-icon"> --}}
    <!-- map-vector css -->
    <link rel="stylesheet" href="../assets/css/plugins/jsvectormap.min.css">
    <!-- [Google Font : Poppins] icon -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/fb034efa9e.js" crossorigin="anonymous"></script>
    <!-- [Tabler Icons] https://tablericons.com -->
    <link rel="stylesheet" href="{{ asset('../assets/fonts/tabler-icons.min.css') }}">
    <!-- [Feather Icons] https://feathericons.com -->
    <link rel="stylesheet" href="{{ asset('../assets/fonts/feather.css') }}">
    <!-- [Font Awesome Icons] https://fontawesome.com/icons -->
    <link rel="stylesheet" href="{{ asset('../assets/fonts/fontawesome.css') }}">
    <!-- [Material Icons] https://fonts.google.com/icons -->
    <link rel="stylesheet" href="{{ asset('../assets/fonts/material.css') }}">
    <!-- [Template CSS Files] -->
    <link rel="stylesheet" href="{{ asset('../assets/css/style.css') }}" id="main-style-link">
    <link rel="stylesheet" href="{{ asset('../assets/css/style-preset.css') }}">
    {{-- Data tables --}}
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.2/js/dataTables.bootstrap5.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.0/js/dataTables.responsive.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.0/js/responsive.bootstrap5.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.0/css/responsive.bootstrap5.css">
    {{--  --}}
    <script src="{{ asset('selectbox/dselect.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('selectbox/dselect.scss') }}">
    @stack('chart')
</head>
<!-- [Head] end -->
<!-- [Body] Start -->

<body data-pc-header="header-1" data-pc-preset="preset-1" data-pc-sidebar-theme="light" data-pc-sidebar-caption="true"
    data-pc-direction="ltr" data-pc-theme="light">
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->
    <!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar">
        <div class="navbar-wrapper">
            <div class="m-header">
                <a href="{{ route('dashboard') }}" class="b-brand text-primary">
                    <!-- ========   Change your logo from here   ============ -->
                    <h4 class="text-primary">DES Produk Pertanian UD Dison<i class="fa-solid fa-stethoscope"></i></h4>
                </a>
            </div>
            <div class="navbar-content">
                <ul class="pc-navbar">
                    <li class="pc-item">
                        <a href="{{ route('dashboard') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="fa-solid fa-display me-2"></i>
                            </span>
                            <span class="pc-mtext">Dashboard</span>
                        </a>
                    </li>
                    <li class="pc-item pc-caption">
                        <i class="ph ph-suitcase"></i>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('medicine.index') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="fa-solid fa-seedling me-2"></i> <!-- Menggunakan ikon tanaman -->
                            </span>
                            <span class="pc-mtext">Data Produk Pertanian</span>
                        </a>
                    </li>
                    <li class="pc-item">
                        <a href="{{ route('sales.index') }}" class="pc-link">
                            <span class="pc-micon">
                                <i class="fa-solid fa-basket-shopping me-2"></i>
                            </span>
                            <span class="pc-mtext">Data Penjualan</span>
                        </a>
                    </li>
                    <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i class="fa-solid fa-brain me-2"></i>
                            </span>
                            <span class="pc-mtext">Prediksi Permintaan</span>
                            <span class="pc-arrow">
                                <i class="fa-solid fa-angle-down"></i>
                            </span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item">
                                <a class="pc-link" href="{{ route('train.index') }}">
                                    <span class="pc-micon">
                                        <i class="fa-solid fa-gears me-2"></i>
                                    </span>
                                    Lakukan Prediksi
                                </a>
                            </li>
                            <li class="pc-item">
                                <a class="pc-link" href="#">
                                    <span class="pc-micon">
                                        <i class="fa-solid fa-chart-simple me-2"></i>
                                    </span>
                                    Hasil Prediksi
                                </a>
                            </li>
                        </ul>
                    </li>
                    {{-- <li class="pc-item pc-hasmenu">
                        <a href="#!" class="pc-link">
                            <span class="pc-micon">
                                <i data-feather="bar-chart-2"></i>
                            </span>
                            <span class="pc-mtext">Analisis dan Laporan</span>
                            <span class="pc-arrow"><i data-feather="chevron-right"></i></span>
                        </a>
                        <ul class="pc-submenu">
                            <li class="pc-item"><a class="pc-link" href="{{ route('train.index') }}">Laporan Stok Obat</a></li>
                            <li class="pc-item"><a class="pc-link" href="{{ route('predict.index') }}">Laporan Penjualan dan Permintaan</a></li>
                        </ul>
                    </li> --}}
                    </li>
                    {{-- <li class="pc-item">
                        <a href="{{ route('report') }}" class="pc-link"><span class="pc-micon">
                                <i class="fa-solid fa-paperclip me-2"></i></span><span
                                class="pc-mtext">Laporan</span></a>
                    </li> --}}
                </ul>
            </div>
        </div>
    </nav>
    <!-- [ Sidebar Menu ] end --> <!-- [ Header Topbar ] start -->
    <header class="pc-header">
        <div class="m-header">
            <a href="{{ route('dashboard') }}" class="b-brand text-decoration-none">
                <!-- Logo dan text dalam satu link -->
                <h4 class="text-light pt-2 d-flex align-items-center">
                    METODE DES
                    <i class="fas fa-project-diagram ms-2"></i>
                </h4>
            </a>
        </div>

        <style>
        .b-brand {
            transition: all 0.3s ease;
        }

        .b-brand:hover {
            opacity: 0.9;
        }

        .b-brand:hover .text-light {
            color: #e9ecef !important;
        }

        .b-brand:hover i {
            transform: translateY(-2px);
        }
        </style>
        <div class="header-wrapper"> <!-- [Mobile Media Block] start -->
            <div class="me-auto pc-mob-drp">
                <ul class="list-unstyled">
                    <!-- ======= Menu collapse Icon ===== -->
                    <li class="pc-h-item pc-sidebar-collapse">
                        <a href="#" class="pc-head-link ms-0" id="sidebar-hide">
                            <i class="ph ph-list"></i>
                        </a>
                    </li>
                    <li class="pc-h-item pc-sidebar-popup">
                        <a href="#" class="pc-head-link ms-0" id="mobile-collapse">
                            <i class="ph ph-list"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- [Mobile Media Block end] -->
            <div class="ms-auto">
                <ul class="list-unstyled">
                    <li class="dropdown pc-h-item header-user-profile">
                        <a class="pc-head-link dropdown-toggle arrow-none me-0" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" data-bs-auto-close="outside"
                            aria-expanded="false">
                            <img src="{{ asset('../assets/images/user/avatar-2.jpg') }}" alt="user-image"
                                class="user-avtar">
                        </a>
                        <div class="dropdown-menu dropdown-user-profile dropdown-menu-end pc-h-dropdown">
                            <div class="dropdown-body">
                                <div class="profile-notification-scroll position-relative"
                                    style="max-height: calc(100vh - 225px)">
                                    <ul class="list-group list-group-flush w-100">
                                        <li class="list-group-item">
                                            <a href="{{ route('logout') }}" class="dropdown-item">
                                                <span class="d-flex align-items-center">
                                                    <i class="ph ph-power"></i>
                                                    <span>Logout</span>
                                                </span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <!-- [ Header ] end -->



    <!-- [ Main Content ] start -->
    <div class="pc-container content">
        @yield('main')
    </div>


    <!-- [ Main Content ] end -->
    <footer class="pc-footer">
        <div class="footer-wrapper container-fluid">
            <div class="row">

                <div class="col-sm-6 my-1">
                    <p class="footer-minimal m-0 d-flex align-items-center">
                        <span class="text-primary fw-bold">METODE DES</span>
                        <span class="mx-2">|</span>
                        <span>Double Exponential Smoothing</span>
                        <i class="fas fa-code mx-2 text-muted"></i>
                        <a href="{{ route('dashboard') }}" class="minimal-link">Program</a>
                    </p>
                </div>

                <style>
                .footer-minimal {
                    font-size: 0.9rem;
                    color: #6c757d;
                    letter-spacing: 0.5px;
                }

                .minimal-link {
                    color: #4099ff;
                    text-decoration: none;
                    position: relative;
                    padding-bottom: 2px;
                }

                .minimal-link::after {
                    content: '';
                    position: absolute;
                    width: 0;
                    height: 2px;
                    bottom: 0;
                    left: 0;
                    background-color: #4099ff;
                    transition: width 0.3s ease;
                }

                .minimal-link:hover::after {
                    width: 100%;
                }
                </style>




                <div class="col-sm-6 ms-auto my-1">
                    <ul class="list-inline footer-link mb-0 justify-content-sm-end d-flex">
                        <li class="list-inline-item">
                            <a href="{{ route('dashboard') }}" class="text-decoration-none">
                                <i class="fas fa-home me-1"></i>Home
                            </a>
                        </li>
                    </ul>
                </div>

                <style>
                .footer-link a {
                    color: #6c757d;
                    transition: all 0.3s ease;
                    padding: 5px 10px;
                    border-radius: 4px;
                }

                .footer-link a:hover {
                    color: #4099ff;
                    background: rgba(64, 153, 255, 0.1);
                }

                .footer-link li {
                    margin-left: 10px;
                }
                </style>
            </div>

        </div>
    </footer>

    <script src="{{ asset('../assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('../assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('../assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('../assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('../assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('../assets/js/plugins/feather.min.js') }}"></script>




    {{-- @include('sweetalert::alert') --}}

    <script>
        layout_change('light');
    </script>

    <script>
        $(document).ready(function() {
            new DataTable('#example', {
                responsive: true,
                scrollX: true
            });
        })
    </script>


    <script>
        layout_sidebar_change('light');
    </script>



    <script>
        change_box_container('false');
    </script>


    <script>
        layout_caption_change('true');
    </script>




    <script>
        layout_rtl_change('false');
    </script>


    <script>
        preset_change("preset-1");
    </script>


    <script>
        header_change("header-1");
    </script>

</body>
<!-- [Body] end -->

</html>
