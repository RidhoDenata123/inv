
<div class="d-flex justify-content-center align-items-center">
    <!-- Tombol Show -->
    <a href="#" 
        class="btn btn-sm btn-dark btn-show mr-2" 
        data-product_id="{{ $row->product_id }}" 
        data-toggle="modal" 
        data-target="#productDetailModal">
        <i class="fas fa-search"></i>
    </a>

    <!-- Tombol Stock Adjustment -->
    <button type="button" 
            class="btn btn-sm btn-warning btn-stock-adjustment mr-2" 
            data-product_id="{{ $row->product_id }}" 
            data-toggle="modal" 
            data-target="#stockAdjustmentModal">
        <i class="fas fa-tools"></i>
    </button>

    <!-- Dropdown Edit -->
    <div class="btn-group mr-2">
        <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
            data-boundary="window">
            <i class='fas fa-edit'></i>
        </button>
        
        <div class="dropdown-menu">
            <a href="#" 
                class="dropdown-item btn-edit" 
                data-product_id="{{ $row->product_id }}" 
                data-toggle="modal" 
                data-target="#editProductModal">
                Edit Data
            </a>
            <a href="#" 
                class="dropdown-item btn-change-image" 
                data-product_id="{{ $row->product_id }}" 
                data-toggle="modal" 
                data-target="#changeImageModal">
                Change Image
            </a>
        </div>
    </div>

    <!-- Tombol Delete -->
    <button type="button" 
            class="btn btn-sm btn-danger btn-delete" 
            data-product_id="{{ $row->product_id }}" 
            data-toggle="modal" 
            data-target="#deleteProductModal">
            <i class='fas fa-trash-alt'></i>
    </button>
</div>