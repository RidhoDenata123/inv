    <div class="d-flex justify-content-center align-items-center">

        <!-- Tombol Show -->
        <a href="#" 
            class="btn btn-sm btn-dark btn-show mr-2" 
            data-unit_id="{{ $row->unit_id }}" 
            data-toggle="modal" 
            data-target="#unitDetailModal">
            <i class="fas fa-search"></i>
        </a>

        <!-- Tombol Edit -->
        <a href="#" 
            class="btn btn-sm btn-primary btn-edit mr-2" 
            data-unit_id="{{ $row->unit_id }}" 
            data-toggle="modal" 
            data-target="#unitEditModal">
            <i class='fas fa-edit'></i>
        </a>

        <!-- Tombol Delete -->
        <button type="button" 
            class="btn btn-sm btn-danger btn-delete" 
            data-unit_id="{{ $row->unit_id }}"
            data-toggle="modal" 
            data-target="#deleteUnitModal">
            <i class='fas fa-trash-alt'></i>
        </button>

    </div>