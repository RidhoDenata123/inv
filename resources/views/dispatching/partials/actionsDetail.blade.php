<div class="d-flex justify-content-center align-items-center">
    @if ($row->dispatching_detail_status === 'Confirmed')
        <!-- Tombol Show Detail -->
        <a href="#" 
        class="btn btn-sm btn-dark btn-show mr-2" 
        data-product_id="{{ $row->product_id }}" 
        data-toggle="modal" 
        data-target="#productDetailModal">
            <i class="fas fa-search"></i>
        </a>
    @elseif ($row->dispatching_detail_status === 'Pending')
        <!-- Tombol Confirm -->
        <button type="button" 
                class="btn btn-sm btn-success btn-confirm mr-2" 
                data-dispatching_detail_id="{{ $row->dispatching_detail_id }}" 
                data-toggle="modal" 
                data-target="#confirmDetailModal">
            <i class="fas fa-check"></i>
        </button>

        <!-- Tombol Show Detail -->
        <a href="#" 
        class="btn btn-sm btn-dark btn-show mr-2" 
        data-product_id="{{ $row->product_id }}" 
        data-toggle="modal" 
        data-target="#productDetailModal">
            <i class="fas fa-search"></i>
        </a>

        <!-- Tombol Edit -->
        <a href="#" 
        class="btn btn-sm btn-primary btn-edit mr-2" 
        data-dispatching_detail_id="{{ $row->dispatching_detail_id }}" 
        data-toggle="modal" 
        data-target="#editDispatchingDetailModal">
            <i class="fas fa-edit"></i>
        </a>

        <!-- Tombol Delete -->
        <button type="button" 
                class="btn btn-sm btn-danger btn-delete" 
                data-dispatching_detail_id="{{ $row->dispatching_detail_id }}" 
                data-toggle="modal" 
                data-target="#deleteDispatchingDetailModal">
            <i class="fas fa-trash-alt"></i>
        </button>
    @endif
</div>