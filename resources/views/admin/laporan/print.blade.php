<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Aplikasi Penjualan Produk Pertanian UD Dison</title>
    <!-- Tambahkan link ke file CSS dan JavaScript yang diperlukan -->
</head>

<body>
    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ Sidebar Menu ] start -->
    <nav class="pc-sidebar">
        <!-- Tambahkan menu sidebar sesuai dengan tampilan yang Anda berikan -->
    </nav>
    <!-- [ Sidebar Menu ] end -->

    <!-- [ Header Topbar ] start -->
    <header class="pc-header">
        <!-- Tambahkan header topbar sesuai dengan tampilan yang Anda berikan -->
    </header>
    <!-- [ Header ] end -->

    <!-- [ Main Content ] start -->
    <div class="pc-container content">
        @yield('main')
    </div>
    <!-- [ Main Content ] end -->

    <!-- [ Footer ] start -->
    <footer class="pc-footer">
        <!-- Tambahkan footer sesuai dengan tampilan yang Anda berikan -->
    </footer>
    <!-- [ Footer ] end -->

    <!-- Tambahkan script JavaScript yang diperlukan -->
</body>

</html>
