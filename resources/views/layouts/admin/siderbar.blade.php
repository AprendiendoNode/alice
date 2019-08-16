<!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item {{ Request::is('home') ? 'active' : '' }} {{ Request::is('/') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/home') }}">
              <i class="mdi mdi-home menu-icon"></i>
              <span class="menu-title">Inicio</span>
            </a>
          </li>
          @forelse (auth()->user()->menus->groupBy('section_id') as $menu)
          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#{{ App\Section::find($menu[0]->section_id)->display_name }}" aria-expanded="false" aria-controls="{{ App\Section::find($menu[0]->section_id)->display_name }}">
              <i class="mdi mdi-equal-box menu-icon"></i>
              <span class="menu-title">{{ App\Section::find($menu[0]->section_id)->display_name }}</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="{{ App\Section::find($menu[0]->section_id)->display_name }}">
              <ul class="nav flex-column sub-menu">
                @foreach (auth()->user()->menus->where('section_id', $menu[0]->section_id) as $submenu)
                  <li class="nav-item {{ Request::is($submenu->url) ? 'active' : '' }}"> <a class="nav-link" href="{{ url($submenu->url) }}"><i class="{{ $submenu->icons }} mr-2"></i>{{ $submenu->display_name }}</a></li>
                @endforeach
              </ul>
            </div>
          </li>
        @empty
        @endforelse


          {{-- <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
              <i class="mdi mdi-circle-outline menu-icon"></i>
              <span class="menu-title">UI Elements</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="ui-basic">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
                <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
              </ul>
            </div>
          </li> --}}

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#section_cfdi" aria-expanded="false" aria-controls="section_cfdi">
              <i class="mdi mdi-account-card-details menu-icon"></i>
              <span class="menu-title">CFDI</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="section_cfdi">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ Request::is('dashboard_cfdi') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/dashboard_cfdi') }}"><i class="fas fa-tachometer-alt mr-2"></i>Dashboard</a></li>
                <li class="nav-item {{ Request::is('/sales/customer-invoices') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/sales/customer-invoices') }}"><i class="fas fa-file-medical-alt mr-2"></i>Facturación</a></li>
                <li class="nav-item {{ Request::is('') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/') }}"><i class="fas fa-passport mr-2"></i> Verificador</a></li>
                <li class="nav-item {{ Request::is('') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/') }}"><i class="far fa-handshake mr-2"></i>Creditos</a></li>
                <li class="nav-item {{ Request::is('/sales/customer-credit-notes') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/sales/customer-credit-notes') }}"><i class="fas fa-file-invoice mr-2"></i>Notas de crédito</a></li>
                <li class="nav-item {{ Request::is('/base/exchange-rate') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/base/exchange-rate') }}"><i class="fas fa-passport mr-2"></i> Tipo Cambio</a></li>
                <li class="nav-item {{ Request::is('/base/branch-office') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/base/branch-office') }}"><i class="fas fa-home mr-2"></i> Sucursales</a></li>
                <li class="nav-item {{ Request::is('/base/companies') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/base/companies') }}"><i class="fas fa-university mr-2"></i> Empresa</a></li>
              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#electronic_billing" aria-expanded="false" aria-controls="electronic_billing">
              <i class="mdi mdi-tag-faces menu-icon"></i>
              <span class="menu-title">Facturación Electrónica</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="electronic_billing">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ Request::is('/sales/salespersons') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/sales/salespersons') }}"><i class="fas fa-user-tie mr-2"></i>Vendedores</a></li>
                <li class="nav-item {{ Request::is('/sales/customers') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/sales/customers') }}"><i class="fas fa-user-tag mr-2"></i>Clientes</a></li>
                <li class="nav-item {{ Request::is('/catalogs/categories') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/categories') }}"><i class="fas fa-box-open mr-2"></i>Categorias de producto</a></li>
                <li class="nav-item {{ Request::is('/catalogs/brands') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/brands') }}"><i class="fas fa-box-open mr-2"></i>Marcas de productos</a></li>
                <li class="nav-item {{ Request::is('/catalogs/models') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/models') }}"><i class="fas fa-box-open mr-2"></i>Modelos de productos</a></li>
                <li class="nav-item {{ Request::is('/catalogs/especificacions') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/especificacions') }}"><i class="fas fa-box-open mr-2"></i>Especificaciones de prod</a></li>
                <li class="nav-item {{ Request::is('/catalogs/products') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/products') }}"><i class="fas fa-boxes mr-2"></i>Admón de Productos</a></li>
                <li class="nav-item {{ Request::is('/base/document-types') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/base/document-types') }}"><i class="far fa-file-word mr-2"></i> Tipos de documentos</a></li>
                <li class="nav-item {{ Request::is('/base/settings_pac') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/base/settings_pac') }}"><i class="fas fa-cogs mr-2"></i> PAC</a></li>

              </ul>
            </div>
          </li>

          <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#billing_catalog" aria-expanded="false" aria-controls="billing_catalog">
              <i class="mdi mdi-clipboard-text menu-icon"></i>
              <span class="menu-title">Catalogo de facturación</span>
              <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="billing_catalog">
              <ul class="nav flex-column sub-menu">
                <li class="nav-item {{ Request::is('/catalogs/taxes') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/taxes') }}"><i class="fas fa-balance-scale mr-2"></i>Impuestos</a></li>
                <li class="nav-item {{ Request::is('/catalogs/banks') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/banks') }}"><i class="fas fa-university mr-2"></i>Bancos</a></li>
                <li class="nav-item {{ Request::is('/catalogs/unit-measures') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/unit-measures') }}"><i class="fas fa-weight mr-2"></i>Unidades de medida</a></li>
                <li class="nav-item {{ Request::is('/catalogs/currencies') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/currencies') }}"><i class="fas fa-donate mr-2"></i>Monedas</a></li>
                <li class="nav-item {{ Request::is('/catalogs/countries') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/countries') }}"><i class="fas fa-globe-americas mr-2"></i> Paises</a></li>
                <li class="nav-item {{ Request::is('/catalogs/states') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/states') }}"><i class="fas fa-globe-americas mr-2"></i> Estados</a></li>
                <li class="nav-item {{ Request::is('/catalogs/cities') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/cities') }}"><i class="fas fa-globe-americas mr-2"></i> Ciudades</a></li>
                <li class="nav-item {{ Request::is('/catalogs/payment-terms') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/payment-terms') }}"><i class="fas fa-ruler mr-2"></i> Términos de pago</a></li>
                <li class="nav-item {{ Request::is('/catalogs/payment-methods') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/payment-methods') }}"><i class="fas fa-paste mr-2"></i> Métodos de pago</a></li>
                <li class="nav-item {{ Request::is('/catalogs/payment-way') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/payment-way') }}"><i class="fas fa-exchange-alt mr-2"></i>Formas de pago</a></li>
                <li class="nav-item {{ Request::is('/catalogs/cfdi-relation') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/cfdi-relation') }}"><i class="fas fa-file-alt mr-2"></i>Tipos de relación CFDI</a></li>
                <li class="nav-item {{ Request::is('/catalogs/cfdi-types') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/cfdi-types') }}"><i class="fas fa-file-invoice mr-2"></i>Tipos de comprobantes</a></li>
                <li class="nav-item {{ Request::is('/catalogs/sat-products') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/sat-products') }}"><i class="fas fa-cart-arrow-down mr-2"></i>Productos/Servicios SAT</a></li>
                <li class="nav-item {{ Request::is('/catalogs/tax-regimens') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/tax-regimens') }}"><i class="fas fa-pencil-ruler mr-2"></i>Regimen fiscal</a></li>
                <li class="nav-item {{ Request::is('/catalogs/cfdi-uses') ? 'active' : '' }}"> <a class="nav-link" href="{{ url('/catalogs/cfdi-uses') }}"><i class="fas fa-chalkboard-teacher mr-2"></i>Usos de CFDI</a></li>


              </ul>
            </div>
          </li>

          <li class="nav-item {{ Request::is('profile') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/profile') }}">
              <i class="mdi mdi-account menu-icon"></i>
              <span class="menu-title">Perfil</span>
            </a>
          </li>

          <li class="nav-item {{ Request::is('Classification') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/Classification') }}">
              <i class="mdi mdi-file-tree menu-icon"></i>
              <span class="menu-title">Clasificación</span>
            </a>
          </li>

          <li class="nav-item {{ Request::is('Configuration') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/Configuration') }}">
              <i class="mdi mdi-settings menu-icon"></i>
              <span class="menu-title">Configuración</span>
            </a>
          </li>

        </ul>
      </nav>
      <!-- partial -->
