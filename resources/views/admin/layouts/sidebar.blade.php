<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-seedling"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Vegano <small>Admin</small></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ $page == 'dashboard' ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Content
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed {{ $page == 'meals' ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapseMeals" aria-expanded="true" aria-controls="collapseMeals">
            <i class="fas fa-fw fa-utensils"></i>
            <span>Meals</span>
        </a>
        <div id="collapseMeals" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('admin.meals.create') }}">Add New Meal</a>
                <a class="collapse-item" href="{{ route('admin.meals.index') }}">View All Meals</a>
                <a class="collapse-item" href="{{ route('admin.meals.index', ['country' => 'cad']) }}"><i class="fab fa-canadian-maple-leaf"></i> View Canadian Meals</a>
                <a class="collapse-item" href="{{ route('admin.meals.index', ['country' => 'usa']) }}"><i class="fas fa-flag-usa"></i> View American Meals</a>
{{--                <a class="collapse-item" href="#">Meals Categories</a>--}}
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
{{--    <li class="nav-item">--}}
{{--        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducts" aria-expanded="true" aria-controls="collapseProducts">--}}
{{--            <i class="fas fa-fw fa-shopping-basket"></i>--}}
{{--            <span>Products</span>--}}
{{--        </a>--}}
{{--        <div id="collapseProducts" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">--}}
{{--            <div class="bg-white py-2 collapse-inner rounded">--}}
{{--                <a class="collapse-item" href="{{ route('admin.products.create') }}">Add New Product</a>--}}
{{--                <a class="collapse-item" href="{{ route('admin.products.index') }}">View All Products</a>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </li>--}}

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed {{ $page == 'chefs' ? 'active' : '' }}" href="#" data-toggle="collapse" data-target="#collapseChefs" aria-expanded="true" aria-controls="collapseChefs">
            <i class="fas fa-fw fa-user"></i>
            <span>Chefs</span>
        </a>
        <div id="collapseChefs" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{ route('admin.chefs.create') }}">Add New Chef</a>
                <a class="collapse-item" href="{{ route('admin.chefs.index') }}">View All Chefs</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Orders
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link {{ $page == 'orders' ? 'active' : '' }}" href="{{ route('admin.order.index') }}">
            <i class="fas fa-fw fa-box"></i>
            <span>All Orders</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        <i class="fab fa-canadian-maple-leaf"></i> Canadian Orders
    </div>
    <li class="nav-item">
        <a class="nav-link {{ $page == 'orders' ? 'active' : '' }}" href="{{ route('admin.order.index', ['country' => 'cad']) }}">
            <i class="fas fa-fw fa-box"></i>
            <span>Canadian Orders</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $page == 'prep' ? 'active' : '' }}" href="{{ route('admin.order.prep-station', ['country' => 'cad']) }}">
            <i class="fas fa-fw fa-people-carry"></i>
            <span>Prep Station <i class="fab fa-canadian-maple-leaf"></i></span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        <i class="fas fa-flag-usa"></i> American Orders
    </div>
    <li class="nav-item">
        <a class="nav-link {{ $page == 'orders' ? 'active' : '' }}" href="{{ route('admin.order.index', ['country' => 'usa']) }}">
            <i class="fas fa-fw fa-box"></i>
            <span>American Orders</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link {{ $page == 'prep' ? 'active' : '' }}" href="{{ route('admin.order.prep-station', ['country' => 'usa']) }}">
            <i class="fas fa-fw fa-people-carry"></i>
            <span>Prep Station <i class="fas fa-flag-usa"></i></span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Users
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link {{ $page == 'users' ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Subscribers</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $page == 'admin' ? 'active' : '' }}" href="{{ route('admin.users.admins') }}">
            <i class="fas fa-fw fa-user-tie"></i>
            <span>Admins</span></a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ $page == 'add-admin' ? 'active' : '' }}" href="{{ route('admin.users.create-admin') }}">
            <i class="fas fa-fw fa-user-plus"></i>
            <span>Add New Admin</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

</ul>
<!-- End of Sidebar -->
