<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<style>
  @media print {
    .sidebar {
        display: none !important;
    }
}
  </style>
<aside class="sidebar z-10 flex flex-col h-screen w-64 sticky top-0 left-0 border-r border-gray-200 bg-gradient-to-b from-blue-50 to-white px-5 shadow-lg max-sm:hidden">
  {{-- Développé par : Aymen Bahiaoui --}}
  {{-- IG : aymen_bahiaoui__ --}}
  
  <div class="sidebar-header flex items-center gap-2 pt-8 pb-7 justify-center border-b border-blue-100">
    <a href="index.html" class="hover:scale-105 transition-transform duration-200">
        <img src="{{ asset('image/logo.png') }}" alt="Logo de l'entreprise" class="h-20 w-[300px] ">
    </a>
  </div>

  <div class="flex-1 overflow-y-auto py-4">
    <nav x-data="{selected: $persist('Tableau de bord')}">
      <div>
        <h3 class="mb-4 ml-2 text-xs font-semibold tracking-wider text-blue-500 uppercase">
          <span>Menu de navigation</span>
        </h3>

        <ul class="mb-6 flex flex-col gap-1">
          {{-- Dashboard - Accessible to all authorized roles --}}
          @canany(['admin', 'dg', 'df', 'dc', 'comm', 'sup', 'comp'])
          <li>
            <a href="{{ route('dashboard') }}" class="menu-item group flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
              <i class="fas fa-tachometer-alt text-blue-600 w-5 text-center"></i>
              <span class="menu-item-text font-medium">Tableau de bord</span>
            </a>
          </li>
          @endcanany
          
          {{-- Admin only section --}}
          @can('admin')
          <li>
            <a href="{{ route('users.index') }}" class="menu-item group flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
              <i class="far fa-user text-blue-600 w-5 text-center"></i>
              <span class="menu-item-text font-medium">Gestion des utilisateurs</span>
            </a>
          </li>
          @endcan
          
          {{-- Financial operations --}}
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
          
          {{-- Inventory and imports --}}
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
          @canany(['admin', 'df', 'comm'])
          <li>
            <a href="{{ route('cheques.index') }}" class="menu-item group flex items-center gap-3 px-3 py-2.5 text-gray-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all duration-200">
             <i class="fas fa-money-check-alt text-blue-600 w-5 text-center"></i>
              <span class="menu-item-text font-medium">Encaissement cheque</span>
            </a>
          </li>
          @endcanany
          
          {{-- Sales and cash --}}
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