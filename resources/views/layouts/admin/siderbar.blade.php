<!-- partial:partials/_sidebar.html -->
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
          <li class="nav-item {{ Request::is('home') ? 'active' : '' }} {{ Request::is('/') ? 'active' : '' }}">
            <a class="nav-link" href="{{ url('/home') }}">
              <i class="mdi mdi-home menu-icon"></i>
              <span class="menu-title">Inicio</span>
            </a>
          </li>





          <li class="nav-item">
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
