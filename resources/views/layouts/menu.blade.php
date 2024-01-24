@access('delete', 'Project')
    <li class="nav-item">

        <a href="{{ route('home') }}" class="nav-link {{ Request::is('home') ? 'bg-orange' : '' }}">
            <i class="nav-icon fas fa-home"></i>
            <p>Accueil</p>
        </a>

    </li>
@endaccess

@access('read', 'Project')
    <li class="nav-item">
        <a href="{{ route('projects.index') }}" class="nav-link {{ Request::is('projects') ? 'bg-orange' : '' }}">
            <i class="nav-icon fas fa-folder"></i>
            <p>Projets <span class="badge bg-secondary">
                    {{ Illuminate\Support\Facades\Cache::get('projects') ?? '0' }}</span>
            </p>
        </a>
    </li>
@endaccess

<li class="nav-item">
    <a href="{{ route('approuving.index') }}" class="nav-link {{ Request::is('approuvings') ? 'bg-orange' : '' }}">
        <i class="nav-icon fas fa-user-shield"></i>
        <p>Mes Collaborateurs <span class="badge badge-danger">{{ Cache::get('members') }}</span></p>
    </a>
</li>

@access('delete', 'Project')
    <li class="nav-item">
        <a href="{{ route('rapport.index') }}" class="nav-link {{ Request::is('rapport') ? 'bg-orange' : '' }}">
            <i class="nav-icon fa fa-table"></i>
            <p>Rapports</p>
        </a>
    </li>
@endaccess
@access('delete', 'Project')
    <li class="nav-item">
        <a href="{{ route('archivage.index') }}" class="nav-link {{ Request::is('archivage') ? 'bg-orange' : '' }}">
            <i class="nav-icon fas fa-bell-slash"></i>
            <p>Archive <span class="badge badge-danger">{{Cache::get("members")}}</span></p></p>
        </a>
    </li>
@endaccess


@if (auth()->user()
        ?->roles->where('name', env('AdminSys'))->first() or
        auth()->user()
            ?->roles->where('name', env('RootAdmin'))->first())
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
                    class="nav-link {{ Request::is('messagesMails') ? 'bg-orange' : '' }}">
                    <i class="nav-icon fas fa-envelope"></i>
                    <p>Courriels</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.index') }}" class="nav-link {{ Request::is('users') ? 'bg-orange' : '' }}">
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
                            class="nav-link {{ Request::is('demande.index') ? 'bg-orange' : '' }}">
                            <i class="nav-icon fa fa-file" aria-hidden="true"></i>
                            <p>Demandes</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categoryDemandes.index') }}"
                            class="nav-link {{ Request::is('categoryDemandes.index') ? 'bg-orange' : '' }}">
                            <i class="nav-icon fa fa-folder" aria-hidden="true"></i>
                            <p>Catégories</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('jalons.index') }}" class="nav-link {{ Request::is('jalons') ? 'bg-orange' : '' }}">
                    <i class="nav-icon fas fa-history"></i>
                    <p>Jalons</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('directions.index') }}"
                    class="nav-link {{ Request::is('directions') ? 'bg-orange' : '' }}">
                    <i class="nav-icon fas fa-address-book disabled"></i>
                    <p>Directions</p>
                </a>
            </li>
            {{-- <li class="nav-item">
                    <a href="{{ route('metiers.index') }}"
                        class="nav-link {{ Request::is('metiers') ? 'bg-orange' : '' }}">
                        <i class="nav-icon fas fa-address-book"></i>
                        <p>Métiers</p>
                    </a>
                </li> --}}
            <li class="nav-item">
                <a href="{{ route('optionsttm.index') }}"
                    class="nav-link {{ Request::is('optionsttm') ? 'bg-orange' : '' }}">
                    <i class="nav-icon fas fa-columns"></i>
                    <p>Options TTM</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('roles.index') }}" class="nav-link {{ Request::is('roles') ? 'bg-orange' : '' }}">
                    <i class="nav-icon fas fa-columns"></i>
                    <p>Rôles</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('writelist.index') }}"
                    class="nav-link {{ Request::is('writes') ? 'bg-orange' : '' }}">
                    <i class="nav-icon fas fa-history"></i>
                    <p>Whrite List</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('projectType.index') }}"
                    class="nav-link {{ Request::is('projectType') ? 'bg-orange' : '' }}">
                    <i class="nav-icon fas fa-solid fa-bars"></i>
                    <p>Types de projet</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('ComplexityItem.index') }}"
                    class="nav-link {{ Request::is('ComplexityItem') ? 'bg-orange' : '' }}">
                    <i class="nav-icon fas fa-square"></i>
                    <p>Points de complexités</p>
                </a>
            </li>
        </ul>
    </li>
@endif
