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
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Create  Manger
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if (auth()->user()->hasRole(['admin', 'manager']))
                            <li class="nav-item">
                                <a href="{{ route('dashboard.admins.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-th"></i> <p>Create  Manger</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>

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
