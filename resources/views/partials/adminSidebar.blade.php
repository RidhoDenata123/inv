<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
    <div class="sidebar-brand-icon">
        <img src="{{ asset('img/logo.png') }}" alt="Logo" width="35px" height="35px">
    </div>
    <div class="sidebar-brand-text mx-3">E-INV<sup>2</sup></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item active">
    <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Interface
</div>

<!-- Nav Item - Data Master Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#masterCollapsePages"
        aria-expanded="true" aria-controls="MasterData">
        <i class="fas fa-fw fa-coins"></i>
        <span>Master Data</span>
    </a>
    <div id="masterCollapsePages" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Master Data :</h6>
            <a class="collapse-item" href="{{ route('products.index') }}">Product</a>
            <a class="collapse-item" href="{{ route('categories.index') }}">Category</a>
            <a class="collapse-item" href="{{ route('units.index') }}">Unit</a>
            <a class="collapse-item" href="{{ route('suppliers.index') }}">Supplier</a>
            <a class="collapse-item" href="{{ route('customers.index') }}">Customer</a>


        </div>
    </div>
</li>

<!-- Nav Item - Transaction Collapse Menu -->
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#transactionsCollapsePages"
        aria-expanded="true" aria-controls="Transaction">
        <i class="fas fa-fw fa-dollar-sign"></i>
        <span>Transaction</span>
    </a>
    <div id="transactionsCollapsePages" class="collapse" aria-labelledby="headingUtilities"
        data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Transaction :</h6>
            <a class="collapse-item" href="{{ route('receiving.header') }}">Receiving</a>
            <a class="collapse-item" href="{{ route('dispatching.header') }}">Dispatching</a>
           
        </div>
    </div>
</li>

<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
    Addons
</div>

<!-- Nav Item - Pages Collapse Menu
<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#CollapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-history"></i>
        <span>History</span>
    </a>
    <div id="CollapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Transaction History :</h6>
            <a class="collapse-item" href="">Receiving</a>
            <a class="collapse-item" href="">Dispatching</a>
        </div>
    </div>
</li> -->

<li class="nav-item">
    <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#reportCollapsePages"
        aria-expanded="true" aria-controls="collapsePages">
        <i class="far fa-fw fa-file-alt"></i>
        <span>Report</span>
    </a>
    <div id="reportCollapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Reports :</h6>
            <a class="collapse-item" href="{{ route('reports.stock') }}">Stock Report</a>
            <a class="collapse-item" href="{{ route('reports.stockMovement') }}">Stock Movement Report</a>
            <a class="collapse-item" href="{{ route('reports.minimumStock') }}">Minimum Stock Report</a>
            <a class="collapse-item" href="{{ route('reports.receiving') }}">Receiving Report</a>
            <a class="collapse-item" href="{{ route('reports.dispatching') }}">Dispatching Report</a>
            <a class="collapse-item" href="{{ route('reports.stockAdjustment') }}">Stock Adjustment Report</a>

        </div>
    </div>
</li>

<!-- Nav Item - Charts -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('reports.archive') }}">
        <i class="fas fa-fw fa-archive"></i>
        <span>Archive</span>
    </a>
</li>

<!-- Nav Item - Tables -->
<li class="nav-item">
    <a class="nav-link" href="{{ route('setting.admin') }}">
        <i class="fas fa-fw fa-cogs"></i>
        <span>Setting</span></a>
</li>

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
    <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

<!-- Sidebar Message -->
<div class="sidebar-card d-none d-lg-flex">
    <img class="sidebar-card-illustration mb-2" src="{{ asset('img/undraw_rocket.svg') }}" alt="...">
    <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and more!</p>
    <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
</div>

</ul>