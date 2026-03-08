<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Absensi</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-100">

<div class="flex h-screen">

  <!-- Sidebar -->
  <aside class="w-64 bg-white shadow-md hidden md:block">
    <div class="p-6 text-xl font-bold border-b border-gray-400">
      Absensi App
    </div>
    <nav class="p-4 space-y-2 text-sm">
      <nav class="p-4 space-y-2 text-sm">
        <a href="{{ route('/') }}" class="block px-4 py-2 rounded-lg bg-blue-500 text-white">Dashboard</a>
        <a href="{{ route('kepegawaian.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">Kepegawaian</a>
        <a href="{{ route('kurikulum.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">Kurikulum</a>
        <a href="{{ route('tahfidz.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">Tahfidz</a>
        <a href="{{ route('kesantrian.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">Kesantrian</a>
        <a href="{{ route('kesantrian.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">APi Documentation</a>
        {{-- <a href="{{ route('logout') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100 text-red-500">Logout</a> --}}
    </nav>
  </aside>

  <!-- Main -->
  <div class="flex-1 flex flex-col">

    <!-- Navbar -->
    <header class="bg-white shadow-sm">
      <div class="flex justify-between items-center px-6 py-4">
        <h1 class="text-lg font-semibold">Dashboard</h1>
        <div class="flex items-center space-x-3">
          <span class="text-sm text-gray-600">Senin, 24 Feb 2026</span>
          <div class="w-9 h-9 bg-gray-300 rounded-full"></div>
        </div>
      </div>
    </header>

    <!-- Content -->
    <main class="p-6 overflow-y-auto">
        @yield('content')
    </main>
  </div>
</div>

</body>
</html>