@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header d-flex justify-content-between align-items-center">
            <h1>Transaction Details </h1>
            {!! $badge !!}
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Transaction</a></div>
                <div class="breadcrumb-item">Details</div>
            </div>
        </div>

        <div class="section-body">
        <div class="row d-flex align-items-stretch">
        <!-- Seller & Customer Information -->
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h4>Seller Information</h4>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $transaction->transactionProducts->first()->product->seller->name }}</p>
                    <p><strong>Email:</strong> {{ $transaction->transactionProducts->first()->product->seller->email }}</p>
                    <p><strong>Phone:</strong> {{ $transaction->transactionProducts->first()->product->seller->phone }}</p>
                    <p><strong>Address:</strong> {{ $transaction->transactionProducts->first()->product->seller->address }}</p>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card h-100">
                <div class="card-header bg-info text-white">
                    <h4>Customer Information</h4>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $transaction->customer->name }}</p>
                    <p><strong>Email:</strong> {{ $transaction->customer->email }}</p>
                    <p><strong>Phone:</strong> {{ $transaction->customer->phone }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Shipping Address -->
    <div class="card mt-3">
        <div class="card-header bg-primary text-white justify-content-between">
            <h4>Shipping Address</h4>
            <h4 class="mb-0">{{ $transaction->shipping_number }}</h4>
        </div>
        <div class="card-body">
            <p><strong>Name:</strong> {{ $transaction->customerAddress->name }}</p>
            <p><strong>Phone:</strong> {{ $transaction->customerAddress->phone }}</p>
            <p><strong>Address:</strong> {{ $transaction->customerAddress->road }}, {{ $transaction->customerAddress->city }}, {{ $transaction->customerAddress->province }} {{ $transaction->customerAddress->zip_code }}</p>
            <p><strong>Full Address:</strong> {{ $transaction->customerAddress->address }}</p>
        </div>
    </div>

  

    <!-- Order Summary -->
    <div class="card mt-3">
        <div class="card-header bg-success text-white">
            <h4>Order Summary</h4>
        </div>
        <div class="card-body">
            <div class="d-none d-md-block">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Item</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaction->transactionProducts as $index => $product)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $product->product->name }}</td>
                                <td class="text-center">Rp {{ number_format($product->product->price, 0, ',', '.') }}</td>
                                <td class="text-center">{{ $product->qty }}</td>
                                <td class="text-right">Rp {{ number_format($product->total, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="d-block d-md-none">
                @foreach ($transaction->transactionProducts as $index => $product)
                <div class="border p-3 mb-2 rounded">
                    <p><strong>{{ $product->product->name }}</strong></p>
                    <p>Price: Rp {{ number_format($product->product->price, 0, ',', '.') }}</p>
                    <p>Quantity: {{ $product->qty }}</p>
                    <p class="text-right"><strong>Total: Rp {{ number_format($product->total, 0, ',', '.') }}</strong></p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Additional Costs -->
    <div class="card mt-3">
    <div class="card-header bg-warning text-white d-flex justify-content-between align-items-center">
        <h4>Additional Costs</h4>
        @if ($transaction->status == 1)
            <button class="btn btn-sm btn-light text-dark" id="add-other-cost">
                <i class="fas fa-plus"></i> Add Other Cost
            </button>
        @endif
    </div>
    <div class="card-body">
        <div id="other-costs">
            @php $totalOtherCosts = 0; @endphp

            <div class="table-responsive">
                <table class="table table-bordered" id="cost-table">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" style="width: 10%;">#</th>
                            <th style="width: 60%;">Cost Name</th>
                            <th class="text-end" style="width: 20%;">Amount (Rp)</th>
                            <th class="text-center" style="width: 10%;">Action</th>
                        </tr>
                    </thead>
                    <tbody id="cost-table-body">
                        @if (!empty($transaction->other_costs) && $transaction->other_costs->isNotEmpty())
                            @foreach ($transaction->other_costs as $index => $cost)
                                <tr data-id="{{ $cost->id }}">
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="cost-name">{{ $cost->name }}</td>
                                    <td class="text-end cost-amount">Rp {{ number_format($cost->amount, 0, ',', '.') }}</td>
                                    <td class="text-center">
                                        <button class="btn btn-sm btn-warning edit-cost"><i class="fas fa-edit"></i></button>
                                        <button class="btn btn-sm btn-danger delete-cost"><i class="fas fa-trash"></i></button>
                                    </td>
                                </tr>
                                @php $totalOtherCosts += $cost->amount; @endphp
                            @endforeach
                        @endif
                    </tbody>
                    <tfoot>
                        <tr class="bg-light">
                            <th colspan="2" class="text-end"><strong>Total:</strong></th>
                            <th class="text-end " id="total-cost">Rp {{ number_format($totalOtherCosts, 0, ',', '.') }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
            </div>

    
        <div class="mt-3 d-flex justify-content-end">
            <button id="submit-cost" class="btn btn-sm btn-success py-1 px-3 d-none" style="font-size: 14px; height: 32px;">
                <i class="fas fa-check"></i> Submit
            </button>
        </div>

            </div>
            </div>
        </div>
    </div>


    <!-- Total Payment Section -->
    <div class="card mt-3">
        <div class="card-header bg-danger text-white">
            <h4 class="mb-0">Total Payment</h4>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
                <h5>Subtotal:</h5>
                <h5>Rp {{ number_format($transaction->transactionProducts->sum('total'), 0, ',', '.') }}</h5>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <h5>Shipping Cost:</h5>
                <h5>Rp {{ number_format($transaction->shipping_cost ?? 0, 0, ',', '.') }}</h5>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <h5>Additional Costs:</h5>
                <h5>Rp {{ number_format($totalOtherCosts, 0, ',', '.') }}</h5>
            </div>
            <hr>
            <div class="d-flex justify-content-between align-items-center">
                <h4><strong>Total Amount Due:</strong></h4>
                <h4 class="text-danger"><strong>Rp {{ number_format($transaction->transactionProducts->sum('total') + $totalOtherCosts + ($transaction->shipping_cost ?? 0), 0, ',', '.') }}</strong></h4>
            </div>
        </div>
    </div>
      <!-- Note -->
    <div class="card mt-3">
        <div class="card-header bg-secondary text-white">
            <h4>Note</h4>
        </div>
        <div class="card-body">
            <p>{{ $transaction->note ?? 'No additional notes provided.' }}</p>
        </div>
    </div>

    <!-- Actions -->
    <div class="d-flex justify-content-end mt-4">
        @if ($transaction->status == 1)
        <button class="btn btn-success mx-1" id="confirm-transaction"><i class="fas fa-check"></i> Confirm Transaction</button>
        <button class="btn btn-danger mx-1" id="reject-transaction"><i class="fas fa-times"></i> Reject Transaction</button>
        @endif
    </div>

    <div class="d-flex justify-content-end mt-4">
        @if ($transaction->status == 4)
        <button class="btn btn-success mx-1" id="packing-now">
            <i class="fas fa-box-open"></i> Packing Now
        </button>
        @endif
    </div>

    <div class="d-flex justify-content-end mt-4">
        @if ($transaction->status == 5)
        <button class="btn btn-success mx-1" id="delivery-now">
            <i class="fas fa-truck"></i> Delivery Now
        </button>
        @endif
    </div>

    <!-- Modal Input Shipping Cost -->
    <div class="modal fade" id="shippingCostModal" tabindex="-1" aria-labelledby="shippingCostLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow-lg rounded">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="shippingCostLabel">
                        <i class="fas fa-shipping-fast"></i> Enter Shipping Cost
                    </h5>
                    <button type="button" class="btn-close text-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="shipping-cost-input" class="form-label">Shipping Cost</label>
                    <input type="number" id="shipping-cost-input" class="form-control" placeholder="Enter shipping cost">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-primary" id="save-shipping-cost">
                        <i class="fas fa-save"></i> Save
                    </button>
                </div>
                </div>
            </div>
        </div>
    </div>
    </section>
</div>
@endsection

@section('script')
<script>
$(document).ready(function() {
    let otherCosts = []; // Menyimpan biaya lain yang ditambahkan
    let costIndex = $('#cost-table tbody tr').length; // Hitung jumlah baris awal

    $('#add-other-cost').click(function () {
        costIndex++;
        let newRow = $(`
            <tr class="animate__animated animate__fadeIn">
                <td class="text-center">${costIndex}</td>
                <td><input type="text" class="form-control form-control-sm cost-name" placeholder="Cost Name"></td>
                <td class="text-end">
                    <input type="number" class="form-control form-control-sm cost-amount text-end" placeholder="Amount" min="0">
                </td>
                <td class="text-center">
                    <button class="btn btn-sm btn-danger remove-cost"><i class="fas fa-times"></i></button>
                </td>
            </tr>
        `);
        $('#cost-table tbody').append(newRow);
        $('#submit-cost').removeClass('d-none');
    });

    // Hapus Baris Saat Klik "Remove"
    $(document).on('click', '.remove-cost', function () {
        $(this).closest('tr').fadeOut(100, function () {
            $(this).remove();
            renumberRows();
            CheckSubmitOtherCost();
        });
    });

    // Fungsi untuk Mengatur Ulang Nomor Baris
    function renumberRows() {
        $('#cost-table tbody tr').each(function (index) {
            $(this).find('td:first').text(index + 1);
        });
        costIndex = $('#cost-table tbody tr').length;
    }

    // Fungsi untuk Simpan ke API
    function saveToApi(id, name, amount) {
        $.ajax({
            url: '/seller/transactions/update-other-cost/' + id, 
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Tambahkan token CSRF dengan benar
            },
            data: {
                name: name,
                amount: amount,
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Data berhasil diperbarui.',
                    timer: 1500,
                    showConfirmButton: false
                });
                window.location.reload();
            },
            error: function (xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Terjadi kesalahan saat menyimpan data.',
                });
                console.error('Gagal menyimpan data:', xhr.responseText);
            }
        });
    }

    // Fungsi untuk Hapus dari API
    function deleteFromApi(id, row) {
        Swal.fire({
            title: 'Yakin ingin menghapus?',
            text: 'Data yang dihapus tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/seller/transactions/delete-other-cost/' + id,
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Tambahkan token CSRF dengan benar
                    },
                    success: function () {
                        row.remove();
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data berhasil dihapus.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        window.location.reload();
                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Terjadi kesalahan saat menghapus data.',
                        });
                        console.error('Gagal menghapus data:', xhr.responseText);
                    }
                });
            }
        });
    }

    // Event untuk Edit Cost
    $(document).on('click', '.edit-cost', function () {
        let row = $(this).closest('tr');
        let nameCell = row.find('.cost-name');
        let amountCell = row.find('.cost-amount');

        let currentName = nameCell.text();
        let currentAmount = amountCell.text().replace('Rp ', '').replace(/\./g, '');

        // Ubah ke mode input
        nameCell.html(`<input type="text" class="form-control form-control-sm edit-name" value="${currentName}">`);
        amountCell.html(`<input type="number" class="form-control form-control-sm edit-amount" value="${currentAmount}" min="0">`);

        // Ganti tombol edit ke simpan
        $(this).removeClass('btn-warning edit-cost').addClass('btn-success save-cost').html('<i class="fas fa-check"></i>');
    });

    // Event untuk Simpan Perubahan ke API
    $(document).on('click', '.save-cost', function () {
        let row = $(this).closest('tr');
        let id = row.data('id'); 
        let newName = row.find('.edit-name').val();
        let newAmount = parseFloat(row.find('.edit-amount').val()) || 0;

        if (newName.trim() === '' || newAmount <= 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian!',
                text: 'Nama dan jumlah harus valid.',
            });
            return;
        }

        row.find('.cost-name').text(newName);
        row.find('.cost-amount').text('Rp ' + newAmount.toLocaleString('id-ID'));

        // Ganti tombol simpan kembali ke edit
        $(this).removeClass('btn-success save-cost').addClass('btn-warning edit-cost').html('<i class="fas fa-edit"></i>');

        saveToApi(id, newName, newAmount);
       
    });

    // Event untuk Delete Cost
    $(document).on('click', '.delete-cost', function () {
        let row = $(this).closest('tr');
        let id = row.data('id'); 

        deleteFromApi(id, row);
    });


    $('#submit-cost').on('click', function () {
        let submitButton = $(this);
        submitButton.prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Submitting...');

        let costs = [];
        $('.cost-item').each(function () {
            let name = $(this).find('.cost-name').val().trim();
            let amount = parseFloat($(this).find('.cost-amount').val());

            if (name !== '' && !isNaN(amount) && amount > 0) {
                costs.push({ name, amount });
            }
        });

        if (costs.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Oops!',
                text: 'Please enter at least one valid cost!',
            });
            submitButton.prop('disabled', false).html('<i class="fas fa-check"></i> Submit');
            return;
        }

        $.ajax({
            url: '/seller/transactions/submit-other-cost', // Ganti dengan endpoint API kamu
            method: 'POST',
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Tambahkan token CSRF dengan benar
            },
            data: JSON.stringify({ costs, transaction_id: '{{ $transaction->id }}' }),
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message || 'Costs submitted successfully!',
                });
                $('#other-costs').empty();
            },
            error: function (xhr) {
                let errorMessage = xhr.responseJSON?.message || 'Error submitting costs!';
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMessage,
                });
                submitButton.prop('disabled', false).html('<i class="fas fa-check"></i> Submit');
            }
        });
    });

    // Hapus baris biaya lain
    $(document).on('click', '.remove-cost', function() {
        $(this).parent().remove();
    });

    // Tampilkan SweetAlert saat tombol Confirm Transaction diklik
    $('#confirm-transaction').click(function() {
        Swal.fire({
            title: "Enter Shipping Cost",
            input: "number",
            inputPlaceholder: "Enter shipping cost",
            showCancelButton: true,
            confirmButtonText: "Submit",
            cancelButtonText: "Cancel",
            inputValidator: (value) => {
                if (!value || value <= 0) {
                    return "Please enter a valid shipping cost";
                }
            }
        }).then((result) => {
            if (result.isConfirmed) {
                let shippingCost = result.value;

                
                // AJAX kirim data ke backend
                $.ajax({
                    url: "{{ route('seller.transactions.confirm', ['id' => $transaction->id]) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        shipping_cost: shippingCost,
                        transaction_id: "{{ $transaction->id }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Transaction confirmed successfully!",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Error confirming transaction",
                            text: "Please try again later."
                        });
                    }
                });
            }
        });
    });

    //reject transaction
    $('#reject-transaction').click(function() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            input: "textarea",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, reject it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('seller.transactions.reject', ['id' => $transaction->id]) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        transaction_id: "{{ $transaction->id }}",
                        note : result.value
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Transaction rejected successfully!",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Error rejecting transaction",
                            text: "Please try again later."
                        });
                    }
                });
            }
        });
    });

    //packing now
    $('#packing-now').click(function() {
        Swal.fire({
            title: 'Packing this transaction?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, packing now!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('seller.transactions.packing', ['id' => $transaction->id]) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        transaction_id: "{{ $transaction->id }}"
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Transaction packing now successfully!",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Error packing now transaction",
                            text: "Please try again later."
                        });
                    }
                });
            }
        });
    });

    //delivery now
    $('#delivery-now').click(function() {
        Swal.fire({
            title: 'Delivery this transaction?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            input: "textarea",
            placeholder: "Enter Shipping Number",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delivery now!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('seller.transactions.delivery', ['id' => $transaction->id]) }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        transaction_id: "{{ $transaction->id }}",
                        shipping_number : result.value
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Transaction delivery now successfully!",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: "error",
                            title: "Error delivery now transaction",
                            text: "Please try again later."
                        });
                    }
                });
            }
        });
    });
                   


    function CheckSubmitOtherCost() {
        if ($('#cost-table tbody tr').length > 0) {
            $('#submit-cost').removeClass('d-none');
        } else {
            $('#submit-cost').addClass('d-none');
        }
    }

    CheckSubmitOtherCost();
});
</script>
@endsection
