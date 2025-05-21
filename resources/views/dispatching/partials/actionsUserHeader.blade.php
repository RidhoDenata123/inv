<div class="d-flex justify-content-center align-items-center">
    @if ($row->dispatchingDetails->where('dispatching_detail_status', 'Confirmed')->isNotEmpty())
        <!-- Tombol Show Detail -->
        <a href="{{ route('dispatching.user_detail.UserShowDetail', $row->dispatching_header_id) }}" 
        class="btn btn-sm btn-dark mr-2">
            <i class="fas fa-search"></i>
        </a>
    @else
        <!-- Tombol Show -->
        <a href="{{ route('dispatching.user_detail.UserShowDetail', $row->dispatching_header_id) }}" 
        class="btn btn-sm btn-dark mr-2">
            <i class="fas fa-search"></i>
        </a>

        <!-- Tombol Edit -->
        <a href="#" 
        class="btn btn-sm btn-primary btn-edit mr-2" 
        data-dispatching_id="{{ $row->dispatching_header_id }}" 
        data-toggle="modal" 
        data-target="#editDispatchingHeaderModal">
            <i class="fas fa-edit"></i> 
        </a>

        <!-- Tombol Delete -->
        <button type="button" 
                class="btn btn-sm btn-danger btn-delete" 
                data-dispatching_id="{{ $row->dispatching_header_id }}" 
                data-toggle="modal" 
                data-target="#deleteDispatchingHeaderModal">
            <i class="fas fa-trash-alt"></i>
        </button>
    @endif
</div>