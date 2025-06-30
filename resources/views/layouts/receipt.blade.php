<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resit Pembayaran</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <style>
        body { background: #f9f9f9; font-family: 'Courier New', Courier, monospace; }
        .receipt-box { background: white; padding: 30px; border: 1px solid #eee; margin: 40px auto; width: 100%; max-width: 800px; }
        .logo { max-height: 80px; }
        .receipt-header { text-align: center; margin-bottom: 40px; }
        .receipt-header h2 { font-weight: bold; }
        .footer { text-align: center; margin-top: 20px; font-size: 0.9rem; color: #666; }

        .no-select {
            user-select: none;            /* Modern browsers */
            -webkit-user-select: none;    /* Safari */
            -moz-user-select: none;       /* Firefox */
            -ms-user-select: none;        /* IE/Edge */
        }

    </style>
</head>
<body class="no-select">
    @yield('content')
</body>
<script>
    document.addEventListener('contextmenu', event => event.preventDefault());
</script>
</html>