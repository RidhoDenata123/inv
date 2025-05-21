    
    
    <!-- Edit Button -->
    <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $row->report_id  }}" data-toggle="modal" data-target="#editReportModal">
        <i class="fas fa-edit"></i>
    </button>
    <!-- Delete Button -->
    <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $row->report_id  }}" data-toggle="modal" data-target="#deleteReportModal">
        <i class="fas fa-trash-alt"></i>
    </button>