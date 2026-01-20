@extends('__layouts.__seller.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 id="title">Withdraw Menu</h1>
            <div class="section-header-breadcrumb">
            <button class="btn btn-primary mb-3" id="withdrawButton"><i class="fas fa-plus"></i> Withdraw</button>
            </div>
        </div>

        <div class="section-body">
        
            <div class="table-responsive">
                <table id="withdrawTable" class="table table-striped mt-3">
                    <thead>
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th class="text-center">Withdraw Number</th>
                            <th class="text-center">Amount</th>
                            <th class="text-center">Date Withdraw</th>
                            <th class="text-center">Date Success</th>
                            <th class="text-center">Note</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<div class="modal fade" id="withdrawModal" tabindex="-1" aria-labelledby="withdrawModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="withdrawModalLabel">Withdraw Funds</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <h6 class="text-muted">Available Balance:</h6>
                    <h4 class="font-weight-bold" id="availableBalance">Rp 0</h4>
                </div>
                <div class="form-group">
                    <label for="withdrawAmount" class="font-weight-bold">Enter Amount</label>
                    <input type="text" id="withdrawAmount" class="form-control text-center" 
                           placeholder="Enter amount" oninput="formatRupiah(this)">
                    <div class="invalid-feedback">Please enter a valid amount.</div>
                </div>
                <div class="form-group">
                    <textarea name="withdraw_note" id="withdrawNote" cols="30" rows="5" placeholder="Beri informasi Norek" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="confirmWithdraw">Withdraw</button>
            </div>
        </div>
    </div>
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

<!-- Bank Information Modal -->
<div class="modal fade" id="bankDataModal" tabindex="-1" aria-labelledby="bankDataModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form id="bankDataForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="bankDataModalLabel">Add Bank Information</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="bank_name" class="form-label">Bank Name</label>
            <input type="text" class="form-control" id="bank_name" name="bank_name" required>
          </div>
          <div class="mb-3">
            <label for="bank_account_number" class="form-label">Account Number</label>
            <input type="text" class="form-control" id="bank_account_number" name="bank_account_number" required>
          </div>
          <div class="mb-3">
            <label for="bank_account_name" class="form-label">Account Holder Name</label>
            <input type="text" class="form-control" id="bank_account_name" name="bank_account_name" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </div>
    </form>
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
            url: "{{ route('seller.withdraw') }}",
            type: "GET",
            data: function(d) {
                d.start_date = startDate;
                d.end_date = endDate;
            },
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false, className: 'align-middle text-center' },
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
            { data: 'note', name: 'note', searchable: true, className: 'align-middle text-center' },
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

    $('#filterBtn').on('click', function() {
        table.ajax.reload();
    });

    $('#withdrawTable').on('click','.btn-rejected',function() {
        let note_reject = $(this).data('note');

        $('#withdrawNoteView').val(note_reject);
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
        },
        error: function(xhr) {
            if(xhr.responseJSON.message == "Bank name is empty"){
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Bank Information is not added yet.",
                    showCancelButton: true,
                    confirmButtonText: "Insert Bank Information ?",
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('#bankDataModal').modal('show');
                    }
                });
            }
        }
    });
});

$('#bankDataForm').on('submit', function(e) {
    e.preventDefault();

    let formData = {
        bank_name: $('#bank_name').val(),
        bank_account_number: $('#bank_account_number').val(),
        bank_account_name: $('#bank_account_name').val(),
        _token: '{{ csrf_token() }}'
    };

    $.ajax({
        url: "{{ route('seller.profile.add-bank-account') }}", // Ganti dengan route yang sesuai
        type: "POST",
        data: formData,
        success: function(response) {
            $('#bankDataModal').modal('hide');
            Swal.fire({
                icon: "success",
                title: "Berhasil",
                text: "Data bank berhasil disimpan.",
            });
        },
        error: function(xhr) {
            Swal.fire({
                icon: "error",
                title: "Gagal",
                text: "Gagal menyimpan data bank.",
            });
        }
    });
});





$('#confirmWithdraw').on('click', function() {
    var rawAmount = $('#withdrawAmount').val();
    var note = $('#withdrawNote').val();
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
                        note: note,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Withdrawal Successful",
                            text: "Your withdrawal request has been submitted.",
                        });
                        window.open('https://wa.me/62{{ $contactAdmin->contact }}?text=Seller%20name%20melakukan%20pengajuan%20withdraw%20sebesar%20Rp.%20' + new Intl.NumberFormat("id-ID").format(amount), '_blank');
                        $('#withdrawModal').modal('hide');
                        table.ajax.reload();
                    },
                    error: function(error) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: error.responseJSON.message
                        });
                    }
                });
            }
        });
    }
});
$('#withdrawTable').on('click', '.btn-cancel', function() {
    var id = $(this).data('id');

    Swal.fire({
        title: "Are you sure?",
        text: "Do you really want to cancel this withdrawal request?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Yes, cancel it!",
        cancelButtonText: "No, keep it"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "{{ route('seller.withdraw.cancel', 'id') }}".replace('id', id),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function(response) {
                    Swal.fire({
                        title: "Canceled!",
                        text: "The withdrawal request has been canceled.",
                        icon: "success"
                    });
                    $('#withdrawTable').DataTable().ajax.reload(); // Reload DataTable
                },
                error: function() {
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to cancel the withdrawal request.",
                        icon: "error"
                    });
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

});
</script>
@endsection