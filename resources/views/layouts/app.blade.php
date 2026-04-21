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
  <aside id="sidebar" class="w-64 bg-white shadow-md absolute md:translate-x-0 h-screen md:static md:block -translate-x-96 transition-all duration-200">
    <div class="p-6 text-xl font-bold border-b border-gray-400">
      Raudhatul Quran App
    </div>
    <nav class="p-4 space-y-2 text-sm">
      <nav class="p-4 space-y-2 text-sm">
        <a href="{{ route('dashboard') }}"
   class="block px-4 py-2 rounded-lg
   {{ Route::is('dashboard') ? 'bg-blue-500 text-white hover:bg-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
   Dashboard
</a>

<a href="{{ route('kepegawaian.index') }}"
   class="block px-4 py-2 rounded-lg
   {{ Route::is('kepegawaian.*') ? 'bg-blue-500 text-white hover:bg-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
   Kepegawaian
</a>

<a href="{{ route('kurikulum.index') }}"
   class="block px-4 py-2 rounded-lg
   {{ Route::is('kurikulum.*') ? 'bg-blue-500 text-white hover:bg-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
   Kurikulum
</a>

<a href="{{ route('tahfidz.index') }}"
   class="block px-4 py-2 rounded-lg
   {{ Route::is('tahfidz.*') ? 'bg-blue-500 text-white hover:bg-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
   Tahfidz
</a>

<a href="{{ route('kesantrian.index') }}"
   class="block px-4 py-2 rounded-lg
   {{ Route::is('kesantrian.*') ? 'bg-blue-500 text-white hover:bg-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
   Kesantrian
</a>
        <a href="{{ route('kesantrian.index') }}" class="block px-4 py-2 rounded-lg hover:bg-gray-100">APi Documentation</a>
        <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button class="block px-4 py-2 rounded-lg hover:bg-gray-100 text-red-500">Logout</button>
        </form>
    </nav>
  </aside>

  <!-- Main -->
  <div class="flex-1 flex flex-col">

    <!-- Navbar -->
    <header class="bg-white shadow-sm">
      <div class="flex justify-between items-center px-6 py-4">
        <div class="flex gap-2">
            <button id="btn" class="space-y-1 block md:hidden">
                <div class="bg-black w-8 h-1"></div>
                <div class="bg-black w-8 h-1"></div>
                <div class="bg-black w-8 h-1"></div>
            </button>
            <h1 class="text-lg font-semibold">Dashboard</h1>
        </div>
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
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const btn = document.getElementById('btn')
        const sidebar = document.getElementById('sidebar')
        btn.addEventListener('click', () => {
            if(sidebar.classList.contains('-translate-x-96')){
                sidebar.classList.add('translate-x-0')
                sidebar.classList.remove('-translate-x-96')
            }
        })
        document.addEventListener('click', (e) => {
            if (!e.target.closest('#sidebar') && !e.target.closest('#btn')) {
                sidebar.classList.remove('translate-x-0')
                sidebar.classList.add('-translate-x-96')
            }
        })
    })
</script>
</html>
