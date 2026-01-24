@extends('__layouts.__seller.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 id="title"></h1>
            <div class="section-header-breadcrumb">
                <button class="btn btn-primary mr-1 col-sm-12 d-none" id="create_btn" onclick="window.location.href='{{ route('seller.products.create') }}'">
                    <i class="fas fa-plus"></i> Create
                </button>
            </div>
          </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="productsTable" class="table table-striped" id="table-1">
                        <thead>                                 
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th class="text-center">Code</th>
                            <th class="text-center">Name</th>
                            <th class="text-center">Category</th>
                            <th class="text-center">Unit</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Seller Price</th>
                            <th class="text-center">Admin Cost</th>
                            <th class="text-center">Price</th>
                            <!-- <th class="text-center">Slug</th> -->
                            <th class="text-center">Description</th>
                            <!-- <th class="text-center">Note</th> -->
                            <th class="text-center">Status</th>
                            <th width="20%" class="text-center">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>

        


    </section>
        <!-- Modal -->
        <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered" role="document"> <!-- modal-md untuk ukuran medium -->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel">Product Images</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Bootstrap Carousel -->
                        <div id="productCarousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner"></div>
                            <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


@endsection

@section('script')
<script>
$(document).ready(function() {
    var path = window.location.pathname.trim();
    console.log("Current Path:", path); // Debugging path

    if (path === '/seller/my-products') {
        $('#title').html("My Products");
        $('#create_btn').addClass('d-none'); // Sembunyikan tombol
    } else {
        $('#title').html("Register Products");
        $('#create_btn').removeClass('d-none'); // Tampilkan tombol
    }

    var table = $('#productsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('seller.products') }}",
            type: "GET",
            data: function (d) {
                d.page_url = path; 
            }
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false ,className: 'align-middle text-center'},
            { data: 'code', name: 'code', searchable: true ,className: 'align-middle text-center'},
            { data: 'name', name: 'name', searchable: true ,className: 'align-middle text-center'},
            { data: 'category', name: 'category', searchable: true ,className: 'align-middle text-center'},
            { data: 'unit', name: 'unit', searchable: true ,className: 'align-middle text-center' },
            { data: 'stock', name: 'stock', searchable: true , className: 'align-middle text-center'},
            {
            data: 'seller_price', 
            name: 'seller_price', 
            searchable: true,
            className: 'whitespace-nowrap align-middle text-center',
            render: function(data, type, row ) {
                if (data !== null) {
                    return 'Rp.' + data.toLocaleString('id-ID');  
                }
                return '';  
            }
            }, {
                data: 'admin_cost', 
                name: 'admin_cost', 
                searchable: true,
                className: 'whitespace-nowrap align-middle text-center',
                render: function(data, type, row ) {
                    if (data !== null) {
                        return 'Rp.' + data.toLocaleString('id-ID');  
                    }
                    return '';  
                }
            },
            {
            data: 'price', 
            name: 'price', 
            searchable: true,
            className: 'whitespace-nowrap align-middle text-center',
            render: function(data, type, row ) {
                if (data !== null) {
                    return 'Rp.' + data.toLocaleString('id-ID');  
                }
                return '';  
            }
            },
            // { data: 'slug', name: 'slug', searchable: true ,className: 'align-middle text-center'},
            { data: 'description', name: 'description', searchable: true ,className: 'align-middle text-center'},      
            // { data: 'note', name: 'note', searchable: true },
            { data: 'status', name: 'status', searchable: false, orderable: false, className: 'text-center' ,className: 'align-middle text-center' },
            { data: 'action', name: 'action', searchable: false, orderable: false, className: 'text-center',className: 'align-middle text-center' }
        ]
    });

    $('#productsTable').on('click', '.btn-view-images', function() {
        let images = JSON.parse($(this).attr('data-images')); 
        let carouselInner = $('#productCarousel .carousel-inner');
        carouselInner.html(''); 
        images.forEach((image, index) => {
            if (image && image !== 'null') {
                let activeClass = index === 0 ? 'active' : '';
                carouselInner.append(`
                    <div class="carousel-item ${activeClass}">
                        <img src="${image}" class="d-block w-100 rounded" alt="Product Image">
                    </div>
                `);
            }
        });

        $('#imageModal').modal('show'); 
    });
    
    $('#productsTable').on('click', '.btn-info', function() {
        let logs = JSON.parse($(this).attr('data-logs')); // Ambil log dari atribut data
        
        if (logs.length === 0) {
            Swal.fire({
                title: "Product Logs",
                html: "<p>No logs available.</p>",
                icon: "info",
                confirmButtonText: "Close"
            });
            return;
        }

        let logHtml = `
            <div style="max-height: 400px; overflow-y: auto;">
                <table class="table table-bordered table-striped text-center w-100">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 25%;">Name</th>
                            <th style="width: 20%;">Time</th>
                            <th style="width: 20%;">Action</th>
                            <th style="width: 35%;">Note</th>
                        </tr>
                    </thead>
                    <tbody>
        `;

        logs.forEach(log => {
            // Menentukan warna badge berdasarkan activity
            let badgeClass = "bg-secondary"; // Default warna abu-abu
            if (log.activity.toLowerCase() === "create") badgeClass = "bg-primary"; // Biru
            else if (log.activity.toLowerCase() === "update") badgeClass = "bg-warning text-dark"; // Kuning
            else if (log.activity.toLowerCase() === "approve") badgeClass = "bg-success"; // Hijau
            else if (log.activity.toLowerCase() === "reject") badgeClass = "bg-danger"; // Merah

            let note = log.activity.toLowerCase() === "reject" ? log.note || "-" : "-";

            logHtml += `
                <tr>
                    <td>${log.user_name}</td>
                    <td>${new Date(log.created_at).toLocaleString()}</td>
                    <td><span class="badge ${badgeClass} text-white">${log.activity}</span></td>
                    <td>${note}</td>
                </tr>
            `;
        });

        logHtml += `</tbody></table></div>`;

        Swal.fire({
            title: "Product Logs",
            html: logHtml,
            icon: "info",
            confirmButtonText: "Close",
            width: "800px" // Menambah lebar modal
        });
    });
            

    function deleteData(unitId) {
    return new Promise((resolve, reject) => {
        $.ajax({
        url: '{{ route('seller.products.destroy', ':id') }}'.replace(':id', unitId),
        method: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            _method: 'delete',
        },
        success: function(response) {
            resolve(response);
        },
        error: function(xhr) {
            reject(xhr);
        }
        });
    });
    }

    $('#productsTable').on('click', '.btn-delete', function() {
    const id = $(this).data('id');
    const form = $(`#delete-form-${id}`);

    Swal.fire({
        title: 'Apakah anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
        deleteData(id)
            .then((rs) => {
            if(rs.status === 200) { 
                sweetAlertSuccess(rs.text);
                table.ajax.reload(null, false);
            }else if(rs.status === 400){
                sweetAlertDanger(rs.text);
            }
            });
        }
    });
    });

});

      
</script>
@endsection
