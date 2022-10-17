 <!-- ======= Sidebar ======= -->
 <!-- style="background-color:rgb(1,41,112)" -->
 <aside id="sidebar" class="sidebar bg-secondary" style="font-color:white" >
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item mt-4">
          <a class="nav-link " href="{{route('home')}}">
            <i class="bi bi-grid"></i>
            <span>Dashboard </span>
          </a>
        </li><!-- End Dashboard Nav -->
        {{-- <li class="nav-heading">Pages</li> --}}
      <li class="nav-item mt-4">
        <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
        <i class="fa-solid fa-users"></i><span>Personnels</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          {{-- <li>
            <a href="{{ route('personnes.index') }}">
              <i class="bi bi-circle"></i><span>Utilisateurs</span>
            </a>
          </li> --}}
          <li>
            <a style="color:white"  href="{{ route('personnels.index') }}">
              <i class="bi bi-circle"></i><span>espace de personnel COFMA</span>
            </a>
          </li>
        </ul>
      </li>
        <li class="nav-item2  mt-4">
          <a class="nav-link collapsed" data-bs-target="#components-nav2" data-bs-toggle="collapse" href="#">
          <i class="fa-solid fa-chalkboard-user"></i><span>Formations</span><i class="bi bi-chevron-down ms-auto"></i>
          </a>
          <ul id="components-nav2" class="nav-content collapse " data-bs-parent="#nav-item2">
            <li>
              <a style="color:white"  href="{{route('categories.index')}}">
                <i class="bi bi-circle"></i><span>domaine de formation</span>
              </a>
            </li>
            <li>
              <a style="color:white" href="{{route('formations.index')}}">
                <i class="bi bi-circle"></i><span>thèmes</span>
              </a>
            </li>
            <li>
              <a style="color:white" href="{{route('formateurs.index')}}">
                <i class="bi bi-circle"></i><span>formateurs</span>
              </a>
            </li>
            <li>
              <a style="color:white" href="{{route('cabinets.index')}}">
                <i class="bi bi-circle"></i><span>cabinets externes</span>
              </a>
            </li>
            <li>
              <a style="color:white" href="{{route('salles.index')}}">
                <i class="bi bi-circle"></i><span>Lieu de formation</span>
              </a>
            </li>
          </ul>
        </li><!-- End Components Nav -->
        <li class="nav-item3  mt-4">
            <a class="nav-link collapsed" data-bs-target="#components-nav3" data-bs-toggle="collapse" href="#">
              <i class="bi bi-menu-button-wide"></i><span>Séances</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav3" class="nav-content collapse " data-bs-parent="#nav-item3">
              <li>
                <a style="color:white" href="{{route('tests.index')}}">
                  <i class="bi bi-circle"></i><span>planifier une séance de formation</span>
                </a>
              </li>
              <li>
                <a style="color:white" href="{{route('seances.index')}}">
                  <i class="bi bi-circle"></i><span>formations en cours</span>
                </a>
              </li>
              <li>
                <a  style="color:white" href="{{route('seances.cloture')}}">
                  <i  class="bi bi-circle"></i><span>formations cloturées</span>
                </a>
              </li>
            </ul>
          </li><!-- End Components Nav -->
          <li class="nav-item6  mt-4">
            <a class="nav-link collapsed" data-bs-target="#components-nav6" data-bs-toggle="collapse" href="#">
            <i class="bi bi-graph-up"></i><span>Statistiques</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav6" class="nav-content collapse " data-bs-parent="#nav-item6">
              <li>
                <a style="color:white" href="{{route('statistiques.index')}}">
                  <i  class="bi bi-circle"></i><span>voir les statistiques</span>
                </a>
              </li>
            </ul>
          </li> 
          <!-- End component nav -->
          <li class="nav-item7  mt-4">
            <a class="nav-link collapsed" data-bs-target="#components-nav7" data-bs-toggle="collapse" href="#">
            <i class="fa-solid fa-user-plus"></i><span>Gestion des comptes</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav7" class="nav-content collapse " data-bs-parent="#nav-item7">
              <li>
                <a  style="color:white" href="{{route('users.index')}}">
                  <i  class="bi bi-circle"></i><span>Liste des utilisateurs</span>
                </a>
              </li>
            
            </ul>
          </li>
    
      </ul>

</aside><!-- End Sidebar-->
