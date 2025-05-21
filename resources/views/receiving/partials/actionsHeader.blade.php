    <div class="d-flex justify-content-center align-items-center">
        @if ($row->receivingDetails->where('receiving_detail_status', 'Confirmed')->isNotEmpty())
            <!-- Tombol Show Detail -->
            <a href="{{ route('receiving.detail.ShowById', $row->receiving_header_id) }}" 
            class="btn btn-sm btn-dark mr-2">
                <i class="fas fa-search"></i>
            </a>
        @else
            <!-- Tombol Show -->
            <a href="{{ route('receiving.detail.ShowById', $row->receiving_header_id) }}" 
            class="btn btn-sm btn-dark mr-2">
                <i class="fas fa-search"></i>
            </a>

            <!-- Tombol Edit -->
            <a href="#" 
            class="btn btn-sm btn-primary btn-edit mr-2" 
            data-receiving_id="{{ $row->receiving_header_id }}" 
            data-toggle="modal" 
            data-target="#editReceivingHeaderModal">
                <i class="fas fa-edit"></i>
            </a>

            <!-- Tombol Delete -->
            <button type="button" 
                    class="btn btn-sm btn-danger btn-delete" 
                    data-receiving_id="{{ $row->receiving_header_id }}" 
                    data-toggle="modal" 
                    data-target="#deleteReceivingHeaderModal">
                <i class="fas fa-trash-alt"></i>
            </button>
        @endif
    </div>