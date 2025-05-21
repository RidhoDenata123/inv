    <div class="d-flex justify-content-center align-items-center">

        <!-- Tombol Show -->
        <a href="#" 
            class="btn btn-sm btn-dark btn-show mr-2" 
            data-category_id="{{ $row->category_id }}" 
            data-toggle="modal" 
            data-target="#categoryDetailModal">
            <i class="fas fa-search"></i>
        </a>

        <!-- Tombol Edit -->
        <a href="#" 
            class="btn btn-sm btn-primary btn-edit mr-2" 
            data-category_id="{{ $row->category_id }}" 
            data-toggle="modal" 
            data-target="#categoryEditlModal">
            <i class='fas fa-edit'></i>
        </a>

        <!-- Tombol Delete -->
        <button type="button" 
            class="btn btn-sm btn-danger btn-delete" 
            data-category_id="{{ $row->category_id }}"
            data-toggle="modal" 
            data-target="#deleteCategoryModal">
            <i class='fas fa-trash-alt'></i>
        </button>

    </div>