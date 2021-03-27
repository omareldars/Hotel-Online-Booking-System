<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="" class="brand-link">
{{--       // الصفحه الرئيسيه--}}
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard.home') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i> <p>Dashboard</p>
                    </a>
                </li>

                @if (auth()->user()->hasRole('admin'))
                    <li class="nav-item">
                        <a href="{{ route('dashboard.managers.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i> <p>Manger</p>
                        </a>
                    </li>
                @endif

                @if (auth()->user()->hasRole(['admin', 'manager']))
                    <li class="nav-item">
                        <a href="{{ route('dashboard.receptionists.index') }}" class="nav-link">
                            <i class="nav-icon fas fa-th"></i> <p>Receptionists</p>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('dashboard.users.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i> <p> Users </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('dashboard.floors.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i> <p> Floors </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('dashboard.rooms.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i> <p> Rooms </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
