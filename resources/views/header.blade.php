<header class="h-16 flex items-center justify-end max-sm:justify-between bg-white px-3 shadow-md sidebar">
  <div class="hidden max-sm:block cursor-pointer" id="open">&#9776;</div>
  <h1>Mr {{ Auth::user()->name }}</h1>
</header>

<div id="sidebar-overlay" class="hidden fixed inset-0 bg-black bg-opacity-50 z-[5]"></div>

<aside id="sidebar" class="sidebar z-10 flex-col fixed -left-full top-0 h-full w-64 max-sm:w-full  max-sm:h-full border-r border-gray-200 bg-gradient-to-b from-blue-50 to-white px-5 shadow-lg transition-all duration-300 ease-in-out">
  
  
  
  <div class="sidebar-header flex items-center gap-2 pt-8 pb-7 justify-center border-b border-blue-100">
    <a href="index.html" class="hover:scale-105 transition-transform duration-200">
      <span class="logo">
        <img src="{{ asset('image/logo.png') }}" alt="Logo de l'entreprise" class="h-10 w-auto">
      </span>
    </a>
    <div class="sm:hidden absolute right-4 top-4 cursor-pointer" id="close">
      <i class="fas fa-times text-gray-500"></i>
    </div>
  </div>

  <div class="flex-1 overflow-y-auto py-4">
    <nav x-data="{selected: $persist('Tableau de bord')}">
      <div>
        <h3 class="mb-4 ml-2 text-xs font-semibold tracking-wider text-blue-500 uppercase">
          <span>Menu de navigation</span>
        </h3>

        <ul class="mb-6 flex flex-col gap-1">
          
          @canany(['admin', 'dg', 'df', 'dc', 'comm', 'sup', 'comp'])
          <li>
            <a href="{{ route('dashboard') }}" class="menu-item group flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
              <i class="fas fa-tachometer-alt text-blue-600 w-5 text-center"></i>
              <span class="menu-item-text font-medium">Tableau de bord</span>
            </a>
          </li>
          @endcanany
          
          
          @can('admin')
          <li>
            <a href="{{ route('users.index') }}" class="menu-item group flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
              <i class="far fa-user text-blue-600 w-5 text-center"></i>
              <span class="menu-item-text font-medium">Gestion des utilisateurs</span>
            </a>
          </li>
          @endcan
          
          
          @canany(['dg', 'df', 'admin', 'dc', 'comm'])
          <li>
            <a href="{{ route('verement.index') }}" class="menu-item group flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
              <i class="fas fa-wallet text-blue-600 w-5 text-center"></i>
              <span class="menu-item-text font-medium">Versements</span>
            </a>
          </li>
          @endcanany
          
          @canany(['admin', 'comp', 'df'])
          <li>
            <a href="{{ route('cheque.index') }}" class="menu-item group flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
              <i class="fas fa-money-check text-blue-600 w-5 text-center"></i>  
              <span class="menu-item-text font-medium">État de chèque</span>
            </a>
          </li>
          
          @endcanany
          @canany(['admin', 'df', 'comm'])
          <li>
            <a href="{{ route('cheques.index') }}" class="menu-item group flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
             <i class="fas fa-money-check-alt text-blue-600 w-5 text-center"></i>
              <span class="menu-item-text font-medium">Encaissement cheque</span>
            </a>
          </li>
          @endcanany
          
          
          @canany(['admin', 'dg', 'df', 'dc'])
          <li>
            <a href="{{ route('stock.index') }}" class="menu-item group flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
              <i class="fas fa-warehouse text-blue-600 w-5 text-center"></i>  
              <span class="menu-item-text font-medium">Analyse de stock</span>
            </a>
          </li>
          
          <li>
            <a href="{{ route('importations.index') }}" class="menu-item group flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
              <i class="fas fa-truck text-blue-600 w-5 text-center"></i>
              <span class="menu-item-text font-medium">Gestion des importations</span>
            </a>
          </li>
          @endcanany
          
          
          @canany(['admin', 'dg', 'df', 'dc', 'sup', 'comm'])
          <li>
            <a href="{{ route('ca.index') }}" class="menu-item group flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
              <i class="fa-solid fa-chart-simple text-blue-600 w-5 text-center"></i>
              <span class="menu-item-text font-medium">Analyse C.A.</span>
            </a>
          </li>
          
          <li>
            <a href="{{ route('caise.index') }}" class="menu-item group flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
              <i class="fa fa-cash-register text-blue-600 w-5 text-center"></i>
              <span class="menu-item-text font-medium">État de caisse</span>
            </a>
          </li>
          @endcanany
        </ul>
      </div>
    </nav>
  </div>

  <div class="py-4 text-center text-xs text-gray-400 border-t border-gray-100">
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="w-full flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all duration-200">
        <i class="fas fa-sign-out-alt text-red-500 w-5 text-center"></i>
        <span class="font-medium">Déconnexion</span>
      </button>
    </form>
  </div>
</aside>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function () {
  
  $("#open").click(function () {
      $('#sidebar').removeClass('-left-full').addClass('left-0');
      $('#sidebar-overlay').removeClass('hidden');  
      $('body').addClass('overflow-hidden'); 
  });

  
  $("#close").click(function () {
      $('#sidebar').removeClass('left-0').addClass('-left-full');
      $('#sidebar-overlay').addClass('hidden');  
      $('body').removeClass('overflow-hidden'); 
  });

  
  $("#sidebar-overlay").click(function () {
      $('#sidebar').removeClass('left-0').addClass('-left-full');
      $(this).addClass('hidden');  
      $('body').removeClass('overflow-hidden'); 
  });
});
</script>