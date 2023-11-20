<li class="nav-item">
    @access('delete', 'Project')
        <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'active' : '' }}">
            <i class="nav-icon fas fa-home"></i>
            <p>Accueil</p>
        </a>
    @endaccess
</li>
<li class="nav-item">
    <a href="{{ route('projects.index') }}" class="nav-link {{ Request::is('projects') ? 'active' : '' }}">
        <i class="nav-icon fas fa-folder"></i>
        <p>Projets <span class="badge bg-danger"> {{ Illuminate\Support\Facades\Cache::get('projects') ?? '0' }}</span>
        </p>
    </a>
</li>

{{-- @if (Cache::get('members') != null)
    <li class="nav-item">
        <a href="{{ route('approuving.index') }}" class="nav-link {{ Request::is('approuvings') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-shield"></i>
            <p>Mes Collaborateurs <span class="badge badge-danger">{{Cache::get("members")}}</span></p>
        </a>
    </li>
@endif --}}

@access('read', 'Rapport')
    <li class="nav-item">
        <a href="{{ route('rapport.index') }}" class="nav-link {{ Request::is('reporting') ? 'active' : '' }}">
            <i class="nav-icon fa fa-table" aria-hidden="true"></i>
            <p>Rapports</p>
        </a>
    </li>
@endaccess
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fa fa-bell" aria-hidden="true"></i>
        <p>
            Notifications
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('approbationCollaborateur.index') }}"
                class="nav-link {{ Request::is('approbations.collaborateurs') ? 'active' : '' }}">
                <i class="nav-icon fa fa-users" aria-hidden="true"></i>
                <p>Collaborateurs</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('approbationLivrable.index') }}"
                class="nav-link {{ Request::is('pprobations.collaborateurs') ? 'active' : '' }}">
                <i class="nav-icon fa fa-tasks" aria-hidden="true"></i>
                <p>Livrables</p>
            </a>
        </li>
    </ul>
</li>
@access('read', 'ComplexityItem')
    <li class="nav-item">
        <a href="#" class="nav-link">
            <i class="nav-icon fas  fa-cogs"></i>
            <p>
                Configurations
                <i class="right fas fa-angle-left"></i>
            </p>
        </a>
        <ul class="nav nav-treeview">
            <li class="nav-item">
                <a href="{{ route('messagesMails.index') }}"
                    class="nav-link {{ Request::is('messagesMails') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-envelope"></i>
                    <p>Courriels</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>Listes des utilisateurs</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="nav-icon fa fa-file" aria-hidden="true"></i>
                    <p>
                        Demandes
                        <i class="right fas fa-angle-left"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('demande.index') }}"
                            class="nav-link {{ Request::is('demande.index') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-file" aria-hidden="true"></i>
                            <p>Demandes</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categoryDemandes.index') }}"
                            class="nav-link {{ Request::is('categoryDemandes.index') ? 'active' : '' }}">
                            <i class="nav-icon fa fa-folder" aria-hidden="true"></i>
                            <p>Catégories</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('jalons.index') }}" class="nav-link {{ Request::is('jalons') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-history"></i>
                    <p>Jalons</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('directions.index') }}"
                    class="nav-link {{ Request::is('directions') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-address-book"></i>
                    <p>Directions</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('metiers.index') }}" class="nav-link {{ Request::is('metiers') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-address-book"></i>
                    <p>Métiers</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('optionsttm.index') }}"
                    class="nav-link {{ Request::is('optionsttm') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-columns"></i>
                    <p>Options TTM</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link {{ Request::is('roles') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-columns"></i>
                    <p>Rôles</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('writelist.index') }}" class="nav-link {{ Request::is('writes') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-history"></i>
                    <p>Whrite List</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('projectType.index') }}"
                    class="nav-link {{ Request::is('projectType') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-solid fa-bars"></i>
                    <p>Types de projet</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ComplexityItem.index') }}"
                    class="nav-link {{ Request::is('ComplexityItem') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-square"></i>
                    <p>Points de complexités</p>
                </a>
            </li>
        </ul>
    </li>
@endaccess
