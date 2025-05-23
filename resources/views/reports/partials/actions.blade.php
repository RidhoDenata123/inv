<div class="d-flex justify-content-center align-items-center">
    <!-- Edit Button -->
    <button class="btn btn-sm btn-primary btn-edit mr-2" data-id="{{ $row->report_id  }}" data-toggle="modal" data-target="#editReportModal">
        <i class="fas fa-edit"></i>
    </button>
    <!-- Delete Button -->
    <button class="btn btn-sm btn-danger btn-delete mr-2" data-id="{{ $row->report_id  }}" data-toggle="modal" data-target="#deleteReportModal">
        <i class="fas fa-trash-alt"></i>
    </button>
</div>