    <div class="d-flex justify-content-center align-items-center">

        <!-- Tombol Show -->
        <a href="#" 
            class="btn btn-sm btn-dark btn-show mr-2" 
            data-supplier_id="{{ $row->supplier_id }}" 
            data-toggle="modal" 
            data-target="#supplierDetailModal">
            <i class="fas fa-search"></i>
        </a>

        <!-- Tombol Edit -->
        <a href="#" 
            class="btn btn-sm btn-primary btn-edit mr-2" 
            data-supplier_id="{{ $row->supplier_id }}" 
            data-toggle="modal" 
            data-target="#editSupplierModal">
            <i class='fas fa-edit'></i>
        </a>

        <!-- Tombol Delete -->
        <button type="button" 
            class="btn btn-sm btn-danger btn-delete" 
            data-supplier_id="{{ $row->supplier_id }}"
            data-toggle="modal" 
            data-target="#deleteSupplierModal">
            <i class='fas fa-trash-alt'></i>
        </button>

    </div>