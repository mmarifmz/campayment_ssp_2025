<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kursus Kepimpinan SSP</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fffdfc;
      color: #333;
    }
    .hero {
      background: linear-gradient(to right, #fbe6f5, #d4eaf7);
      padding: 60px 20px;
      text-align: center;
    }
    .btn-ssp {
      background-color: #e91e63;
      color: white;
      border-radius: 25px;
      padding: 10px 30px;
      text-decoration: none;
      transition: 0.3s;
    }
    .btn-ssp:hover {
      background-color: #d81b60;
      text-decoration: none;
      color: white;
    }
  </style>
</head>
<body>

  <main>
    @yield('content')
  </main>

  @if (session('status'))
    <div class="alert alert-success text-center">{{ session('status') }}</div>
  @endif

  <footer style="text-align: center; font-size: 12px; color: #888; margin-top: 40px;">
      Sistem direka oleh <strong>Biro ICT, PIBG Sekolah Kebangsaan Sri Petaling</strong> 2025/2026 | Pembangun Sistem 
      <strong><a href="https://arif.my" target="_blank" style="color: #888; text-decoration: none;">Arif + Co.</a></strong>
  </footer>

</body>
</html>