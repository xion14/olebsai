@extends('__layouts.__seller.main')

@section('head')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/brands.min.css"
        integrity="sha512-58P9Hy7II0YeXLv+iFiLCv1rtLW47xmiRpC1oFafeKNShp8V5bKV/ciVtYqbk2YfxXQMt58DjNfkXFOn62xE+g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

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
                <div class="row d-flex flex-column-reverse flex-lg-row gap-4">
                    <div class="col-12 col-lg-7 col-xxl-8">
                        <!-- Order Summary -->
                        <div class="w-100 d-flex flex-column gap-2 px-3 py-3 card mb-4 bg-white"
                            style="border-radius: 0.5rem;">
                            <strong style="font-size: 16px; line-height: 1.5;">Order Summary</strong>
                            <section class="w-100 mt-3">
                                @foreach ($transaction->transactionProducts as $index => $product)
                                    <div class="w-100 mb-3 d-flex align-items-start">
                                        <div class=""
                                            style="width: 4rem; height: 4rem; border-radius:0.25rem; overflow:hidden; flex-shrink: 0;">
                                            <img src="/uploads/product/{{ $product->product->image_1 }}" alt=""
                                                class="object-cover w-100 h-100">
                                        </div>
                                        <div class="w-100 px-3">
                                            <strong class="d-inline-block" style="font-size: 14px; line-height: 1.5;">
                                                {{ $product->product->name }} {{ $product->variant }}
                                            </strong>
                                            <div class="w-100 d-flex align-items-center gap-3 mt-1">
                                                <span class="d-inline-block"
                                                    style="font-size: 14px; line-height: 1.5; word-break: break-all;">
                                                    {{ $product->qty }}
                                                </span>
                                                <span class="d-inline-block px-2"
                                                    style="font-size: 14px; line-height: 1.5; word-break: break-all;">
                                                    x
                                                </span>
                                                <span class="d-inline-block"
                                                    style="font-size: 14px; line-height: 1.5; word-break: break-all;">
                                                    Rp {{ number_format($product->price, 0, ',', '.') }}
                                                </span>
                                            </div>
                                            <strong class="d-inline-block text-primary mt-1"
                                                style="font-size: 14px; line-height: 1.5;">
                                                Rp {{ number_format($product->total, 0, ',', '.') }}
                                            </strong>
                                        </div>
                                    </div>
                                @endforeach
                            </section>
                        </div>

                        <!-- Additional Costs -->
                        <div class="w-100 d-flex flex-column gap-2 px-3 py-3 card mb-4 bg-white">
                            <strong style="font-size: 16px; line-height: 1.5;">Additional Costs</strong>
                            <div class="w-100 mt-3">
                                @if ($transaction->status == 1)
                                    <div class="d-flex justify-content-end">
                                        <button class="btn btn-sm btn-primary text-white" id="add-other-cost">
                                            <i class="fas fa-plus"></i> Add Other Cost
                                        </button>
                                    </div>
                                @endif
                                <div class="w-100 mt-2">
                                    <div id="other-costs">
                                        @php $totalOtherCosts = 0; @endphp
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="cost-table">
                                                <thead class="table-dark">
                                                    <tr>
                                                        <th class="text-center" style="width: 10%;">#</th>
                                                        <th style="width: 40%;">Cost Name</th>
                                                        <th class="text-end" style="width: 40%;">Amount (Rp)</th>
                                                        <th class="text-center" style="width: 10%;">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="cost-table-body">
                                                    @if (!empty($transaction->other_costs) && $transaction->other_costs->isNotEmpty())
                                                        @foreach ($transaction->other_costs as $index => $cost)
                                                            <tr data-id="{{ $cost->id }}" class="old-data">
                                                                <td class="text-center">{{ $index + 1 }}</td>
                                                                <td class="cost-name old-data">{{ $cost->name }}</td>
                                                                <td class="text-end cost-amount old-data">Rp
                                                                    {{ number_format($cost->amount, 0, ',', '.') }}</td>
                                                                <td class="text-center">
                                                                    @if ($transaction->status == 1)
                                                                        <button class="btn btn-sm btn-warning edit-cost"><i
                                                                                class="fas fa-edit"></i></button>
                                                                        <button class="btn btn-sm btn-danger delete-cost"><i
                                                                                class="fas fa-trash"></i></button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                            @php $totalOtherCosts += $cost->amount; @endphp
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <tr class="bg-light">
                                                        <th colspan="2" class="text-end"><strong>Total:</strong></th>
                                                        <th class="text-end " id="total-cost">Rp
                                                            {{ number_format($totalOtherCosts, 0, ',', '.') }}</th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>


                                        <div class="mt-3 d-flex justify-content-end">
                                            <button id="submit-cost" class="btn btn-sm btn-success py-1 px-3 d-none"
                                                style="font-size: 14px; height: 32px;">
                                                <i class="fas fa-check"></i> Submit
                                            </button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Summary -->
                        <div class="w-100 d-flex flex-column gap-2 px-3 pt-3 pb-2 card mb-0 bg-white">
                            <strong style="font-size: 16px; line-height: 1.5;">Payment Summary </strong>
                            <div class="w-100 mt-3">
                                <div class="w-100 d-flex flex-row align-items-center justify-content-between gap-2 mb-1">
                                    <span class="text-start" style="font-size: 14px; line-height: 1.5;">Sub Total</span>
                                    <strong class="text-end text-dark" style="font-size: 14px; line-height: 1.5;">
                                        Rp
                                        {{ number_format($transaction->transactionProducts->sum('total'), 0, ',', '.') }}
                                    </strong>
                                </div>
                                <div class="w-100 d-flex flex-row align-items-center justify-content-between gap-2 mb-1">
                                    <span class="text-start" style="font-size: 14px; line-height: 1.5;">Shipping Cost</span>
                                    <strong class="text-end text-dark" style="font-size: 14px; line-height: 1.5;">
                                        Rp {{ number_format($transaction->shipping_cost ?? 0, 0, ',', '.') }}
                                    </strong>
                                </div>
                                @php
                                    $shippingCost = $transaction->shipping_cost;
                                    $discount = 0;

                                    if ($transaction->voucher && $transaction->voucher->type == 2) {
                                        $discount = ($shippingCost * $transaction->voucher->percentage) / 100;
                                        if ($discount > $transaction->voucher->max_discount) {
                                            $discount = $transaction->voucher->max_discount;
                                        }
                                    }
                                @endphp

                                <div class="w-100 d-flex flex-row align-items-center justify-content-between gap-2 mb-1">
                                    <span class="text-start" style="font-size: 14px; line-height: 1.5;">Shipping Discount</span>
                                    <strong class="text-end text-danger" style="font-size: 14px; line-height: 1.5;">
                                        -Rp {{ number_format($discount, 0, ',', '.') }}
                                    </strong>
                                </div>

                                <div class="w-100 d-flex flex-row align-items-center justify-content-between gap-2 mb-1">
                                    <span class="text-start" style="font-size: 14px; line-height: 1.5;">Additional
                                        Costs</span>
                                    <strong class="text-end text-dark" style="font-size: 14px; line-height: 1.5;">
                                        Rp {{ number_format($totalOtherCosts, 0, ',', '.') }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <div class="w-100 d-flex flex-row align-items-center justify-content-between gap-2 px-3 py-2 card mb-4 rounded-bottom"
                            style="background-color: #fafafa;">
                            <strong class="text-start text-dark fw-bold" style="font-size: 14px; line-height: 1.5;">
                                Total Amount Due
                            </strong>
                            <strong class="text-end text-primary" style="font-size: 14px; line-height: 1.5;">
                                Rp
                                {{ number_format($transaction->total , 0, ',', '.') }}
                            </strong>
                        </div>
                    </div>
                    <div class="col-12 col-lg-5 col-xxl-4">
                        <!-- Customer Information -->
                        <div class="w-100 d-flex flex-column gap-2 px-3 py-3 card mb-4 bg-white"
                            style="border-radius: 0.5rem;">
                            <strong style="font-size: 16px; line-height: 1.5;">Seller Information</strong>
                            <section class="w-100 mt-3">
                                <div class="w-100 d-flex align-items-start gap-3">
                                    <div class="d-flex justify-content-center align-items-center bg-primary text-white"
                                        style="width: 2.5rem; height: 2.5rem; border-radius:9999px; overflow:hidden; flex-shrink: 0;">
                                        <i class="fa-solid fa-store" style="font-size: 1rem;"></i>
                                    </div>
                                    <div class="px-3 py-0 px-lg-3 py-lg-0">
                                        <strong class="d-inline-block text-dark"
                                            style="font-size: 14px; line-height: 1.5;">{{ $transaction->transactionProducts->first()->product->seller->name }}
                                        </strong>
                                        <div class="w-100 d-flex align-items-center gap-3 mt-2">
                                            <i class="fa-solid fa-envelope" style="font-size: 1rem;"></i>
                                            <span class="d-inline-block px-2"
                                                style="font-size: 14px; line-height: 1.5; word-break: break-all;">
                                                {{ $transaction->transactionProducts->first()->product->seller->email }}
                                            </span>
                                        </div>
                                        <div class="w-100 d-flex align-items-center gap-3 mt-2">
                                            <i class="fa-solid fa-phone" style="font-size: 1rem;"></i>
                                            <span class="d-inline-block px-2" style="font-size: 14px; line-height: 1.5;">
                                                {{ $transaction->transactionProducts->first()->product->seller->phone }}
                                            </span>
                                        </div>
                                        <div class="w-100 d-flex align-items-center gap-3 mt-2">
                                            <i class="fa-solid fa-map-location-dot" style="font-size: 1rem;"></i>
                                            <span class="d-inline-block px-2" style="font-size: 14px; line-height: 1.5;">
                                                {{ $transaction->transactionProducts->first()->product->seller->address }}
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </section>
                        </div>

                        <!-- Customer Information -->
                        <div class="w-100 d-flex flex-column gap-2 px-3 py-3 card mb-4 bg-white"
                            style="border-radius: 0.5rem;">
                            <strong style="font-size: 16px; line-height: 1.5;">Customer Information</strong>
                            <section class="w-100 mt-3">
                                <div class="w-100 d-flex align-items-start gap-3">
                                    <div class="d-flex justify-content-center align-items-center bg-primary text-white"
                                        style="width: 2.5rem; height: 2.5rem; border-radius:9999px; overflow:hidden; flex-shrink: 0;">
                                        <i class="fa-regular fa-user" style="font-size: 1rem;"></i>
                                    </div>
                                    <div class="px-3 py-0 px-lg-3 py-lg-0">
                                        <strong class="d-inline-block text-dark"
                                            style="font-size: 14px; line-height: 1.5;">
                                            {{ $transaction->customer->name }}
                                        </strong>
                                        <div class="w-100 d-flex align-items-center gap-3 mt-2">
                                            <i class="fa-solid fa-envelope" style="font-size: 1rem;"></i>
                                            <span class="d-inline-block px-2"
                                                style="font-size: 14px; line-height: 1.5; word-break: break-all;">
                                                {{ $transaction->customer->email }}
                                            </span>
                                        </div>
                                        <div class="w-100 d-flex align-items-center gap-3 mt-2">
                                            <i class="fa-solid fa-phone" style="font-size: 1rem;"></i>
                                            <span class="d-inline-block px-2" style="font-size: 14px; line-height: 1.5;">
                                                {{ $transaction->customer->phone }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- Shipping Address -->
                        <div class="w-100 d-flex flex-column gap-2 px-3 py-3 card mb-4 bg-white"
                            style="border-radius: 0.5rem;">
                            <strong style="font-size: 16px; line-height: 1.5;">Shipping Address</strong>
                            <section class="w-100 mt-3">
                                <div class="w-100 d-flex align-items-start gap-3">
                                    <div class="d-flex justify-content-center align-items-center bg-primary text-white"
                                        style="width: 2.5rem; height: 2.5rem; border-radius: 9999px; overflow: hidden; flex-shrink: 0;">
                                        <i class="fa-solid fa-truck-fast" style="font-size: 1rem;"></i>
                                    </div>
                                    <div class="px-3 py-0 px-lg-3 py-lg-0 d-flex flex-column">
                                        <span class="badge rounded-pill bg-success text-white" style="width: fit-content">
                                            {{ $transaction->shipping_number }}
                                        </span>
                                        <strong class="fw-bold text-dark" style="font-size: 16px; line-height: 1.5;">
                                            {{ $transaction->customerAddress->name }}
                                        </strong>
                                        <span class="fw-medium" style="font-size: 14px; line-height: 1.5rem">
                                            {{ $transaction->customerAddress->phone }}
                                        </span>
                                        <span class="fw-medium text-wrap" style="font-size: 14px; line-height: 1.5rem;">
                                            {{ $transaction->customerAddress->address }},
                                        </span>
                                        <span class="fw-medium text-wrap" style="font-size: 14px; line-height: 1.5rem;">
                                            {{ $transaction->customerAddress->road }},
                                            {{ $transaction->customerAddress->city }},{{ $transaction->customerAddress->province }},
                                            {{ $transaction->customerAddress->zip_code }}
                                        </span>
                                    </div>
                                </div>
                            </section>
                        </div>

                        <!-- Note -->
                        <div class="w-100 d-flex flex-column gap-2 px-3 py-3 card mb-4 bg-white"
                            style="border-radius: 0.5rem;">
                            <strong style="font-size: 16px; line-height: 1.5;">Note</strong>
                            <section class="w-100 mt-3">
                                <p>{{ $transaction->note ?? 'No additional notes provided.' }}</p>
                            </section>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="d-flex justify-content-end mt-4">
                @if ($transaction->status == 1)
                    <button class="btn btn-success mx-1" id="confirm-transaction"><i class="fas fa-check"></i> Confirm
                        Transaction</button>
                    <button class="btn btn-danger mx-1" id="reject-transaction"><i class="fas fa-times"></i> Reject
                        Transaction</button>
                @endif

                @if ($transaction->status == 4)
                    <button class="btn btn-success mx-1" id="packing-now">
                        <i class="fas fa-box-open"></i> Packing Now
                    </button>
                @endif

                @if ($transaction->status == 5)
                    <button class="btn btn-success mx-1" id="delivery-now">
                        <i class="fas fa-truck"></i> Delivery Now
                    </button>
                @endif
            </div>

            <!-- Modal Input Shipping Cost -->
            <div class="modal fade" id="shippingCostModal" tabindex="-1" aria-labelledby="shippingCostLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content shadow-lg rounded">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="shippingCostLabel">
                                <i class="fas fa-shipping-fast"></i> Enter Shipping Cost
                            </h5>
                            <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <label for="shipping-cost-input" class="form-label">Shipping Cost</label>
                            <input type="number" id="shipping-cost-input" class="form-control"
                                placeholder="Enter shipping cost">
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

            $('#add-other-cost').click(function() {
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
            $(document).on('click', '.remove-cost', function() {
                $(this).closest('tr').fadeOut(100, function() {
                    $(this).remove();
                    renumberRows();
                    CheckSubmitOtherCost();
                });
            });

            // Fungsi untuk Mengatur Ulang Nomor Baris
            function renumberRows() {
                $('#cost-table tbody tr').each(function(index) {
                    $(this).find('td:first').text(index + 1);
                });
                costIndex = $('#cost-table tbody tr').length;
            }

            // Fungsi untuk Simpan ke API
            function saveToApi(id, name, amount) {
                $.ajax({
                    url: '/seller/transactions/other-cost/update/' + id,
                    method: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Tambahkan token CSRF dengan benar
                    },
                    data: {
                        name: name,
                        amount: amount,
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: 'Data berhasil diperbarui.',
                            timer: 1500,
                            showConfirmButton: false
                        });
                        window.location.reload();
                    },
                    error: function(xhr) {
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
                            url: '/seller/transactions/other-cost/delete/' + id,
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}' // Tambahkan token CSRF dengan benar
                            },
                            success: function() {
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
                            error: function(xhr) {
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
            $(document).on('click', '.edit-cost', function() {
                let row = $(this).closest('tr');
                let nameCell = row.find('.cost-name');
                let amountCell = row.find('.cost-amount');

                let currentName = nameCell.text();
                let currentAmount = amountCell.text().replace('Rp ', '').replace(/\./g, '');

                // Ubah ke mode input
                nameCell.html(
                    `<input type="text" class="form-control form-control-sm edit-name" value="${currentName}">`
                );
                amountCell.html(
                    `<input type="number" class="form-control form-control-sm edit-amount" value="${currentAmount}" min="0">`
                );

                // Ganti tombol edit ke simpan
                $(this).removeClass('btn-warning edit-cost').addClass('btn-success save-cost').html(
                    '<i class="fas fa-check"></i>');
            });

            // Event untuk Simpan Perubahan ke API
            $(document).on('click', '.save-cost', function() {
                let row = $(this).closest('tr');
                let id = row.data('id');
                let newName = row.find('.edit-name').val();
                let newAmount = parseFloat(row.find('.edit-amount').val()) || 0;

                if (newName.trim() === '') {
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
                $(this).removeClass('btn-success save-cost').addClass('btn-warning edit-cost').html(
                    '<i class="fas fa-edit"></i>');

                saveToApi(id, newName, newAmount);

            });

            // Event untuk Delete Cost
            $(document).on('click', '.delete-cost', function() {
                let row = $(this).closest('tr');
                let id = row.data('id');

                deleteFromApi(id, row);
            });


            $('#submit-cost').on('click', function() {
                let submitButton = $(this);
                submitButton.prop('disabled', true).html(
                    '<i class="fas fa-spinner fa-spin"></i> Submitting...');

                let costs = [];
                $('#cost-table tbody tr').each(function() {
                    let name = $(this).find('.cost-name').val().trim();
                    let amount = parseFloat($(this).find('.cost-amount').val());

                    if (name !== '' && !isNaN(amount)) {
                        costs.push({
                            name,
                            amount
                        });
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
                    url: '/seller/transactions/other-cost/submit', // Ganti dengan endpoint API kamu
                    method: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Tambahkan token CSRF dengan benar
                    },
                    data: JSON.stringify({
                        costs,
                        transaction_id: '{{ $transaction->id }}'
                    }),
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Submit Other Cost Successfully!",
                            showConfirmButton: false,
                            timer: 1500
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function(xhr) {
                        let errorMessage = xhr.responseJSON?.message ||
                            'Error submitting costs!';
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: errorMessage,
                        });
                        submitButton.prop('disabled', false).html(
                            '<i class="fas fa-check"></i> Submit');
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
                    title: "Enter Shipping Details",
                    html: `
                        <input type="number" id="shipping-cost" class="swal2-input" placeholder="Enter shipping cost">
                        <input type="text" id="shipping-name" class="swal2-input" placeholder="Enter shipping name">
                    `,
                    showCancelButton: true,
                    confirmButtonText: "Submit",
                    cancelButtonText: "Cancel",
                    preConfirm: () => {
                        const cost = document.getElementById('shipping-cost').value;
                        const name = document.getElementById('shipping-name').value;

                        if (!cost || parseFloat(cost) <= 0) {
                            Swal.showValidationMessage(
                                "Please enter a valid shipping cost greater than 0");
                            return false;
                        } else if (!name || name.trim() === "") {
                            Swal.showValidationMessage("Please enter a valid shipping name");
                            return false;
                        }

                        return {
                            cost,
                            name
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        let shippingCost = result.value.cost;
                        let shippingName = result.value.name;

                        // AJAX kirim data ke backend
                        $.ajax({
                            url: "{{ route('seller.transactions.confirm', ['id' => $transaction->id]) }}",
                            type: "POST",
                            data: {
                                _token: "{{ csrf_token() }}",
                                shipping_cost: shippingCost,
                                shipping_name: shippingName,
                                transaction_id: "{{ $transaction->id }}"
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Transaction confirmed successfully!",
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.open('https://wa.me/62{{ $contactAdmin->contact }}?text=Pesanan%20{{ $transaction->code }}%20memerlukan%20persetujuan%20admin,%20mohon%20untuk%20di%20konfirmasi', '_blank');
                                    window.location.href = '/seller/transactions/admin/confirm';
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
                                note: result.value
                            },
                            success: function(response) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Transaction rejected successfully!",
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.location.href = '/seller/transactions/cancelled';
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
                                    window.location.href = '/seller/transactions/on_packing';
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
                    html: `
                <input type="text" id="shipping-name" class="swal2-input" value="{{ $transaction->shipping_name }}" readonly>
                <input type="text" id="shipping-number" class="swal2-input" placeholder="Enter Shipping Number">
                <input type="file" id="shipping-image" class="swal2-file" accept="image/*">
            `,
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delivery now!',
                    preConfirm: () => {
                        const shippingNumber = document.getElementById('shipping-number').value;
                        const shippingImage = document.getElementById('shipping-image').files[
                            0];
                        const shippingName = document.getElementById('shipping-name').value;

                        if (!shippingNumber || shippingNumber.trim() === "") {
                            Swal.showValidationMessage("Please enter a valid shipping number");
                            return false;
                        }

                        if (!shippingImage) {
                            Swal.showValidationMessage("Please attach a shipping image");
                            return false;
                        }

                        return {
                            shippingNumber,
                            shippingImage,
                            shippingName
                        };
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const formData = new FormData();
                        formData.append('_token', "{{ csrf_token() }}");
                        formData.append('transaction_id', "{{ $transaction->id }}");
                        formData.append('shipping_number', result.value.shippingNumber);
                        formData.append('shipping_name', result.value.shippingName);
                        formData.append('shipping_image', result.value.shippingImage);

                        $.ajax({
                            url: "{{ route('seller.transactions.delivery', ['id' => $transaction->id]) }}",
                            type: "POST",
                            enctype: "multipart/form-data", 
                            processData: false, 
                            contentType: false,
                            data: formData,
                            success: function(response) {
                                Swal.fire({
                                    icon: "success",
                                    title: "Transaction delivery now successfully!",
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(() => {
                                    window.open('https://wa.me/62{{ $contactAdmin->contact }}?text=Pesanan%20{{ $transaction->code }}%20sudah%20dikirim%20ke%20pihak%20pengiriman,%20mohon%20untuk%20admin%20melakukan%20update%20resi ', '_blank');
                                    window.location.href = '/seller/transactions/on_delivery';
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    icon: "error",
                                    title: "Error delivering transaction",
                                    text: "Please try again later."
                                });
                            }
                        });
                    }
                });
            });



            function CheckSubmitOtherCost() {
                // Hitung jumlah baris yang bukan data lama
                let newRows = $('#cost-table tbody tr:not(.old-data)').length;

                if (newRows > 0) {
                    $('#submit-cost').removeClass('d-none');
                } else {
                    $('#submit-cost').addClass('d-none');
                }
            }


            CheckSubmitOtherCost();
        });
    </script>
@endsection
