@extends('__layouts.__admin.main')

@section('body')
<div class="main-content">
  <section class="section">
    <div class="section-header">
      <h1>Products Confirmation</h1>
      <div class="section-header-breadcrumb">
        <div class="breadcrumb-item"><a href="#">Admin</a></div>
        <div class="breadcrumb-item active"><a href="#">Products</a></div>
        <div class="breadcrumb-item active"><a href="#">Confirmation</a></div>
      </div>
    </div>

    <div class="section-body">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table id="productsTable" class="table table-striped" id="table-1">
                  <thead>                                 
                    <tr>
                      <th width="5%" class="text-center">#</th>
                      <th class="text-center">Seller</th>
                      <th class="text-center">Code</th>
					  <th class="text-center">Type</th>
                      <th class="text-center">Name</th>
                      <th class="text-center">Category</th>
                      <th class="text-center">Unit</th>
                      <th class="text-center">Stock</th>
                      <th class="text-center">Seller Price</th>
                      <th class="text-center">Admin Cost</th>
                      <th class="text-center">Price</th>
                      <!-- <th class="text-center">Slug</th> -->
                      <th class="text-center">Description</th>
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
      </div>
    </div>
  </section>
</div>
@endsection

@section('script')
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

<script>
$(document).ready(function() {
  var table = $('#productsTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: "{{ route('admin.products.confirmation') }}",
        type: "GET",
    },
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', searchable: false, orderable: false },
      {
        data: 'seller', 
        name: 'seller', 
        searchable: true,
        render: function(data, type, row) {
          return data ? data.toUpperCase() : ''; 
        }
      },
      { data: 'code', name: 'code', searchable: true },
	  { data: 'type', name: 'type', searchable: true },
      { data: 'name', name: 'name', searchable: true },
	  
      { data: 'category', name: 'category', searchable: true },
      { data: 'unit', name: 'unit', searchable: true },
      { data: 'stock', name: 'stock', searchable: true },
      {
        data: 'seller_price', 
        name: 'seller_price', 
        searchable: true,
        className: 'whitespace-nowrap',
        render: function(data, type, row ) {
          if (data !== null) {
              return 'Rp.' + data.toLocaleString('id-ID');
          }
          return '';  
        }
      },
      {
        data: 'admin_cost', 
        name: 'admin_cost', 
        searchable: true,
        className: 'whitespace-nowrap',
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
        className: 'whitespace-nowrap',
        render: function(data, type, row ) {
          if (data !== null) {
              return 'Rp.' + data.toLocaleString('id-ID');
          }
          return '';  
        }
      },
      // { data: 'slug', name: 'slug', searchable: true },
      { data: 'description', name: 'description', searchable: true },
      { data: 'status', name: 'status', searchable: false, orderable: false, className: 'text-center' },
      { data: 'action', name: 'action', searchable: false, orderable: false, className: 'text-center' }
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

  $('#productsTable').on('click', '.btn-approve', function () {
    let id = $(this).data('id');
    const form = $(`#delete-form-${id}`);
    Swal.fire({
      title: "Approve Product?",
      text: "Are you sure you want to approve this product?",
      icon: "question",
      showCancelButton: true,
      confirmButtonText: "Yes, Approve",
      cancelButtonText: "Cancel"
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("{{ url('/admin/products') }}/" + id + "/approve", {
            _token: "{{ csrf_token() }}"
        }, function (data) {
          Swal.fire({
            title: 'Success!',
            text: data.text,
            icon: 'success',
            timer: 2000,
            showConfirmButton: false
          }).then(() => {
            window.open('https://wa.me/62' + data.data.phone + '?text=Product%20Name%20'+ data.data.name +'%20baru%20saja%20disetujui%20oleh%20admin', '_blank');
            $('.table').DataTable().ajax.reload();
          });
        });
      }
    });
  });

  $('#productsTable').on('click', '.btn-info', function() {
    let logs = JSON.parse($(this).attr('data-logs'));
    
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
      let badgeClass = "bg-secondary";
      if (log.activity.toLowerCase() === "create") badgeClass = "bg-primary";
      else if (log.activity.toLowerCase() === "update") badgeClass = "bg-warning text-dark";
      else if (log.activity.toLowerCase() === "approve") badgeClass = "bg-success";
      else if (log.activity.toLowerCase() === "reject") badgeClass = "bg-danger";

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
      width: "800px"
    });
  });

  $('#productsTable').on('click', '.btn-reject', function () {
    let id = $(this).data('id');

    Swal.fire({
      title: "Reject Product?",
      text: "Please enter the reason for rejection:",
      icon: "warning",
      input: "textarea",
      inputPlaceholder: "Enter reason here...",
      showCancelButton: true,
      confirmButtonText: "Yes, Reject",
      cancelButtonText: "Cancel",
      preConfirm: (note) => {
          if (!note) {
              Swal.showValidationMessage("You must enter a reason for rejection.");
          }
          return note;
      }
    }).then((result) => {
      if (result.isConfirmed) {
        $.post("{{ url('/admin/products') }}/" + id + "/reject", {
          _token: "{{ csrf_token() }}",
          note: result.value // Kirim alasan penolakan ke backend
        }, function (data) {
          Swal.fire("Success", data.success, "success");
          $('.table').DataTable().ajax.reload(); // Reload DataTables
        }).fail(function () {
          Swal.fire("Error", "Failed to reject product. Try again!", "error");
        });
      }
    });
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

  function deleteData(unitId) {
    return new Promise((resolve, reject) => {
        $.ajax({
        url: '{{ route('admin.products.destroy', ':id') }}'.replace(':id', unitId),
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
