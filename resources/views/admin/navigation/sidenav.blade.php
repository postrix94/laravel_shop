<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin.dashboard')}}" class="brand-link text-center">
        <span class="brand-text font-weight-light text-gray">Laravel Shop</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{Vite::asset('resources/images/admin/avatar5.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <span class="d-block">{{Auth::user()->name}}</span>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <x-side-nav-link link="{{route('admin.dashboard')}}" icon="fas fa-tachometer-alt" name="Главная"></x-side-nav-link>

                <li class="nav-header">КАТЕГОРИИ</li>
                <x-side-nav-link link="{{route('admin.categories.index')}}" icon="fa fa-list" name="Все категории"></x-side-nav-link>
                <x-side-nav-link link="{{route('admin.categories.create')}}" icon="far fa-plus-square" name="Добавить категорию"></x-side-nav-link>

                <li class="nav-header">ТОВАРЫ</li>
                <x-side-nav-link link="{{ route('admin.products.index') }}" icon="fa-list" name="Все товары"/>
                <x-side-nav-link link="{{route('admin.products.create')}}" icon="far fa-plus-square" name="Добавить новый товар"></x-side-nav-link>


            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
