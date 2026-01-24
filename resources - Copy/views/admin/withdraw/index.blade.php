@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 id="title">Seller Withdraw</h1>
          
        </div>

        <div class="section-body">
        
            <div class="table-responsive">
                <table id="withdrawTable" class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th class="text-center">Seller Name</th>
                            <th class="text-center">Withdraw Number</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Date Withdraw</th>
                            <th class="text-center">Date Success</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>
</div>


<!-- Modal for Image Preview -->
<div id="imageModal" class="modal fade" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Proof of Transfer</h5>
            </div>
            <div class="modal-body text-center">
                <img src="" class="img-fluid rounded" alt="Proof of Transfer">
            </div>
        </div>
    </div>
</div>

{{-- Modal Reject Note --}}
<div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="withdrawModalLabel">Reject Withdraw</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="form-group">
                    <input type="hidden" name="withdraw_id" id="withdrawId">
                    <textarea name="withdraw_note" id="withdrawNote" cols="30" rows="10" placeholder="Beri Alasan Reject" class="form-control" required></textarea>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmWithdrawReject">Reject</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal reject View --}}

<div class="modal fade" id="rejectNote" tabindex="-1" aria-labelledby="rejectNoteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="withdrawModalLabel">Rejected Withdraw</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="form-group">
                    <input type="hidden" name="withdraw_id" id="withdrawId">
                    <textarea name="withdraw_note_view" id="withdrawNoteView" cols="30" rows="10"  class="form-control" readonly></textarea>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
$(document).ready(function() {
    var startDate = '';
    var endDate = '';

    var table = $('#withdrawTable').DataTable({
        processing: true,
        serverSide: true,
        // searching: false,
        ajax: {
            url: "{{ route('admin.withdraw') }}",
            type: "GET",
            data: function(d) {
                d.start_date = startDate;
                d.end_date = endDate;
            },
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false, className: 'align-middle text-center' },
            { data: 'seller', name: 'seller', searchable: true, className: 'align-middle text-center' },
            { 
                data: 'code', 
                name: 'code', 
                searchable: true, 
                className: 'align-middle text-center',
                render: function(data, row) {
                    return data ? `<span class="badge bg-info text-white">${data}</span>` : '-';
                }
            },

            { data: 'amount', name: 'amount', searchable: true, className: 'align-middle text-center'},
            { data: 'created_at', name: 'created_at', searchable: true, className: 'align-middle text-center' },
            { data: 'success_at', name: 'success_at', searchable: true, className: 'align-middle text-center' },
            { data: 'status', name: 'status', searchable: true, className: 'align-middle text-center'},
            { data: 'action', name: 'action', searchable: false, orderable: false, className: 'align-middle text-center' }
        ]
    });


    $('.dt-search').prepend(
    '<div class="row align-items-end mt-1">' +

        // Perbesar Filter Date Range
        '<div class="col-md-6 col-lg-6">' +
            '<label for="dateRange" class="form-label ml-2">Date Range:</label>' +
            '<input type="text" id="dateRange" class="form-control w-100" placeholder="Select date range">' +
        '</div>' +

        // Tombol Filter & Reset (Sejajar di kanan)
        '<div class="col-lg-auto d-flex justify-content-end mt-2 mt-lg-0 gap-2">' +
            '<button id="filterBtn" class="btn btn-primary mr-2">Filter</button>' +
            '<button id="resetBtn" class="btn btn-secondary">Reset</button>' +
        '</div>' +

    '</div>'
);

    // Menghilangkan filter bawaan DataTables
    $('#dt-search-0').addClass('d-none');
    $('label[for="dt-search-0"]').hide();
    $('.dt-length').addClass('mt-2');

    $('#dateRange').daterangepicker({
        autoUpdateInput: false,
        locale: { cancelLabel: 'Clear' }
    });

    $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
        startDate = picker.startDate.format('YYYY-MM-DD');
        endDate = picker.endDate.format('YYYY-MM-DD');
        $(this).val(startDate + ' - ' + endDate);
    });

    $('#dateRange').on('cancel.daterangepicker', function(ev, picker) {
        startDate = '';
        endDate = '';
        $(this).val('');
    });

    $('#withdrawTable').on('click','.btn-rejected',function() {
        let note_reject = $(this).data('note');

        $('#withdrawNoteView').val(note_reject);
    });

    $('#filterBtn').on('click', function() {
        table.ajax.reload();
    });

    $('#resetBtn').on('click', function() {
        $('#typeFilter').val('').trigger('change');
        $('#dateRange').val('');
        startDate = '';
        endDate = '';
        table.ajax.reload();
    });

    function formatRupiah(input) {
    let value = input.value.replace(/\D/g, ""); // Remove all non-numeric characters
    let formatted = new Intl.NumberFormat("id-ID").format(value); 

    input.value = formatted ? formatted : "";
}

$('#withdrawAmount').on('input', function() {
    formatRupiah(this);
});

function formatRupiahSaldo(amount) {
    return 'Rp ' + amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

$('#withdrawButton').on('click', function() {
    // Check balance before withdrawing
    $.ajax({
        url: "{{ route('seller.withdraw.checkBalance') }}",
        type: "GET",
        success: function(response) {
            if (response.balance > 0) {
                $('#availableBalance').text(formatRupiahSaldo(response.balance));
                $('#withdrawModal').modal('show');
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Insufficient Balance",
                    text: "You do not have enough balance to withdraw.",
                });
            }
        }
    });
});

$('#confirmWithdraw').on('click', function() {
    var rawAmount = $('#withdrawAmount').val();
    
    // Convert from formatted currency to pure number
    var amount = parseInt(rawAmount.replace(/\D/g, ""), 10);

    if (!amount || amount < 10000) {
        $('#withdrawAmount').addClass('is-invalid');
        Swal.fire({
            icon: "warning",
            title: "Minimum Withdraw Rp 10,000",
            text: "Please enter a valid amount.",
        });
    } else {
        $('#withdrawAmount').removeClass('is-invalid');

        Swal.fire({
            title: "Confirm Withdraw",
            text: "Are you sure you want to withdraw Rp " + new Intl.NumberFormat("id-ID").format(amount) + "?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Proceed",
            cancelButtonText: "Cancel"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('seller.withdraw.store') }}",
                    type: "POST",
                    data: {
                        amount: amount, // Send the raw number
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Withdrawal Successful",
                            text: "Your withdrawal request has been submitted.",
                        });
                        $('#withdrawModal').modal('hide');
                        table.ajax.reload();
                    },
                    error: function() {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "An error occurred while processing your withdrawal request.",
                        });
                    }
                });
            }
        });
    }
});
$('#withdrawTable').on('click','.btn-reject',function() {
    var id = $(this).data('id');

    $('#withdrawId').val(id);
    $('#withdrawModal').modal('show');
})

$('#confirmWithdrawReject').on('click',function() {

    let id = $('#withdrawId').val();
    let reject_note = $('#withdrawNote').val();

    $.ajax({
        url: "{{ route('admin.withdraw.reject', 'id') }}".replace('id', id),
        type: "POST",
        data: {
            _token: "{{ csrf_token() }}",
            note: reject_note
        },
        success: function(response) {
            Swal.fire({
                title: "Rejected!",
                text: "The withdrawal request has been rejected.",
                icon: "success"
            });
            table.ajax.reload();
        },
        error: function() {
            Swal.fire({
                title: "Error!",
                text: "Failed to reject the withdrawal request.",
                icon: "error"
            });
        }
    });

    $('#withdrawModal').modal('hide');
    
})

$('#withdrawTable').on('click', '.test', function() {
    var id = $(this).data('id');

    Swal.fire({
        title: "Are you sure?",
        text: "Do you really want to reject this withdrawal request?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, reject it!",
        cancelButtonText: "No, keep it"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('admin.withdraw.reject', 'id') }}".replace('id', id),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire({
                        title: "Rejected!",
                        text: "The withdrawal request has been rejected.",
                        icon: "success"
                    });
                    table.ajax.reload();
                },
                error: function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to reject the withdrawal request.",
                        icon: "error"
                    });
                }
            });
        }
    });
});

$('#withdrawTable').on('click', '.btn-accept', function() {
    var id = $(this).data('id');

    Swal.fire({
        title: "Approve Withdrawal",
        text: "Please upload the proof of transfer before approving.",
        input: "file",
        inputAttributes: {
            accept: "image/*",
            "aria-label": "Upload proof of transfer"
        },
        showCancelButton: true,
        confirmButtonColor: "#28a745",
        cancelButtonColor: "#d33",
        confirmButtonText: "Upload",
        cancelButtonText: "Cancel",
        preConfirm: (file) => {
            return new Promise((resolve, reject) => {
                if (!file) {
                    reject("You must upload proof of transfer!");
                } else if (!file.type.startsWith("image/")) {
                    reject("Only image files are allowed!");
                } else {
                    // Menampilkan pratinjau gambar sebelum dikonfirmasi
                    const reader = new FileReader();
                    reader.readAsDataURL(file);
                    reader.onload = (e) => {
                        Swal.fire({
                            title: "Confirm Approval",
                            html: `<p>Ensure the uploaded image is correct before approving.</p>
                                   <img src="${e.target.result}" alt="Proof" class="img-fluid rounded" style="max-height: 200px; margin-top: 10px;">`,
                            showCancelButton: true,
                            confirmButtonText: "Approve",
                            cancelButtonText: "Cancel",
                            confirmButtonColor: "#28a745",
                            cancelButtonColor: "#d33"
                        }).then((confirmResult) => {
                            if (confirmResult.isConfirmed) {
                                processApproval(id, file);
                            }
                        });
                    };
                }
            });
        }
    });
});

//onclick image
$('#withdrawTable').on('click', '.btn-view-images', function() {
    var image = $(this).data('image');
    var imageModal = $('#imageModal');
 
    if (!image) {
        Swal.fire({
            icon: "error",
            title: "Error",
            text: "No image available."
        });
        return;
    }

    imageModal.find('.modal-body img').attr('src', image);
    imageModal.modal('show');
});


// Fungsi untuk mengirimkan data ke server
function processApproval(id, file) {
    var formData = new FormData();
    formData.append("proof", file);
    formData.append("_token", "{{ csrf_token() }}");

    Swal.fire({
        title: "Processing...",
        text: "Please wait while we approve the withdrawal.",
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    $.ajax({
        url: "{{ route('admin.withdraw.accept', 'id') }}".replace('id', id),
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            Swal.fire({
                title: "Approved!",
                text: "The withdrawal has been approved successfully.",
                icon: "success",
                confirmButtonColor: "#28a745"
            });
            table.ajax.reload();
        },
        error: function() {
            Swal.fire({
                title: "Error!",
                text: "Failed to approve the withdrawal.",
                icon: "error",
                confirmButtonColor: "#d33"
            });
        }
    });
}



});
</script>
@endsection