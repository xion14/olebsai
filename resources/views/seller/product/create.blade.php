@extends('__layouts.__seller.main')

@section('body')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Add New Product</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="#">Seller</a></div>
                    <div class="breadcrumb-item active"><a href="#">Products</a></div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <div class="card-body">
                        <form id="addProducts" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="code">Product Code</label>
                                    <input type="text" name="code" class="form-control" placeholder="Product Code" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="name">Product Name</label>
                                    <input type="text" name="name" class="form-control" placeholder="Product Name" required>
                                </div>
								<div class="form-group col-md-4">
                                    <label for="type_id">Type</label>
                                    <select id="type_id" name="type_id" class="form-control" required>
                                        <option value="">-- Select Type --</option>
                                        @foreach ($dataType as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
							</div>
							<div class="row">
                                <div class="form-group col-md-4">
                                    <label for="category_id">Category</label>
                                    <select id="category_id" name="category_id" class="form-control" required>
                                        <option value="">-- Select Category --</option>
                                        @foreach ($dataCategory as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
								<div class="form-group col-md-4">
                                    <label for="sub_category_id">Sub Category</label>
                                    <select id="sub_category_id" name="sub_category_id" class="form-control">
                                        <option value="">-- Select Sub Category --</option>
										{{---
                                        @foreach ($dataSubcategory as $subcategory)
                                            <option value="{{ $subcategory->id }}">{{ $subcategory->name }}</option>
                                        @endforeach
										---}}
                                    </select>
                                </div>
								<div class="form-group col-md-4">
                                    <label for="price">Weight (gram)</label>
                                    <input type="number" name="weight" class="form-control" placeholder="Minimal 0" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label for="unit_id">Unit</label>
                                    <select name="unit_id" class="form-control" required>
                                        <option value="">-- Select Unit --</option>
                                        @foreach ($dataUnit as $unit)
                                            <option value="{{ $unit->id }}">{{ $unit->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="stock">Stock</label>
                                    <input type="number" name="stock" class="form-control" placeholder="Minimal 1" required>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="price">Price</label>
                                    <input type="number" name="price" class="form-control" placeholder="Price" required>
                                </div>
                            </div>
                            <div class="row">
							
                            </div>
							
							
							<div id="file_digital" class="form-group" style="display:none">
								<label for="description">File Digital</label>
								<div id="container">
									<div class="form-group col-md-3 row-item">
										<label for="digital_file">File</label> <small>(required)</small>
										<input type="file" id="type_1" name="digitals[]" class="form-control" />
									</div>
								</div>
                                <button id="add-btn">Add File</button>
                            </div>
							
							
							<div id="subscribe_time" class="form-group" style="display:none">
								<label for="description">Subscribe Time & Price (If filled in, the subscription price applies & main price no longer valid)</label>
								<div id="container_subtime">
									
								</div>
                                <button id="add-subtime">Add Subscribe Time Label & Price</button>
                            </div>
							
							
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" class="form-control" placeholder="Description"></textarea>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-3">
                                    <label for="image_1">Image 1</label>
                                    <input type="file" name="image_1" class="form-control" required>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="image_2">Image 2</label> <small>(optional)</small>
                                    <input type="file" name="image_2" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="image_3">Image 3</label> <small>(optional)</small>
                                    <input type="file" name="image_3" class="form-control">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="image_4">Image 4</label> <small>(optional)</small>
                                    <input type="file" name="image_4" class="form-control">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit <i class="fas fa-paper-plane"></i></button>
                            <a href="{{ route('seller.products') }}" class="btn btn-secondary">Cancel <i class="fas fa-times"></i></a>
                        </form>
                    </div>
                </div>
            </div>
    </div>
@endsection


@section('script')
    <script>
        $(document).ready(function() {

			$('#category_id').on('change', function() {
				var category_id = $(this).val();
				// Clear previous options in the item select
				$('#sub_category_id').empty().append('<option value="">Loading...</option>');

				if (category_id) {
					$.ajax({
						
						url: "{{ url('sub-category') }}/?cath_id="+category_id,
						type: 'GET',
						// data: { province_id: provinceId },
						dataType: 'json', // Expecting a JSON response
						success: function(data) {
							var datas = data['data'];
							console.log(datas);
							$('#sub_category_id').empty().append('<option value="">-- Select Sub Category --</option>');
							
							// Loop through the data and add options
							$.each(datas, function(key, value) {
								$('#sub_category_id').append('<option value="' + key + '">' + value + '</option>');
							});
						},
						error: function(xhr, status, error) {
							console.error("An error occurred: " + status + " " + error);
							$('#sub_category_id').empty().append('<option value="">Error loading items</option>');
						}
					});
				} else {
					// If no category is selected, reset the item select
					$('#sub_category_id').empty().append('<option value="">-- Select Sub Category --</option>');
				}
			});
			
			
			
			$('#file_digital').hide();
			
			$('#add-btn').on('click', function(e) {
				e.preventDefault(); // Prevent form submission if in a form
				$('#container').append(createNewRow()); // Append the new row to the container
			});
			
			$('#add-subtime').on('click', function(e) {
				e.preventDefault(); // Prevent form submission if in a form
				$('#container_subtime').append(createNewRowSubtime()); // Append the new row to the container
			});
			
			$('#container').on('click', '.remove-btn', function(e) {
				e.preventDefault();
				$(this).parent('.row-item').remove(); // Find the parent div with class 'row-item' and remove it
			});
			
			$('#container_subtime').on('click', '.remove-btn-subtime', function(e) {

				e.preventDefault();
				$(this).parent().parent().parent().remove(); // Find the parent div with class 'row-item' and remove it
			});
			
			x=1;
			function createNewRow() {
				x++;
				return `
					<div class="form-group col-md-3 row-item">
						<label for="digital_file">File</label> <small>(optional)</small>
						<input type="file" name="digitals[]" class="form-control">
						<button class="remove-btn">Remove</button>
					</div>
				`;
			}
			
			function createNewRowSubtime() {
				x++;
				return `
					<div class="form-group row-item">
						<div class="row">
							<div class="form-group col-md-3">
								<label for="subscribe_time">Time Label</label>
								<input type="text" id="subtime_1" name="subtimes[]" placeholder="ex: 1minggu, 1bulan, dll" class="form-control" required />
							</div>
							<div class="form-group col-md-3">
								<label for="subscribe_price">Price</label>
								<input type="text" name="subprices[]" placeholder="subscribe price" class="form-control" required />
							</div>
						</div>
						<div class="row">
							<div class="form-group col-md-3">
							<button class="remove-btn-subtime">Remove Time & Price</button>
							</div>
						</div>
					</div>
				`;
			}

            function processForm(formData) {
                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: '{{ route('seller.products.store') }}',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            resolve(response);
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                $('.is-invalid').removeClass('is-invalid');
                                $('.invalid-feedback').remove();

                                let errors = xhr.responseJSON.errors;
                                for (let field in errors) {
                                    let input = $(`[name="${field}"]`);
                                    input.addClass('is-invalid');
                                    input.after(
                                        `<div class="invalid-feedback">${errors[field][0]}</div>`
                                        );
                                }
                            }
                            reject(xhr);
                        }
                    });
                });
            }

            $('#addProducts').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);
                formData.append('_token', '{{ csrf_token() }}');

                processForm(formData)
                    .then(response => {
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').remove();
                        $('#addProducts')[0].reset();

                        if (response.status === 200) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.text,
                                icon: 'success',
                                timer: 2000, 
                                showConfirmButton: false
                            }).then(() => {
                                window.open('https://wa.me/62{{ $contactAdmin->contact }}?text=Product%20Name%20'+ formData.get('name') +'%20baru%20saja%20diajukan', '_blank');
                                window.location.href = '{{ route('seller.products') }}';
                            });
                        } else if (response.status === 400) {
                            Swal.fire('Error!', response.text, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Terjadi Masalah:', error);
                    });
            });
			
			$("#type_id").change(function() {
				if($('#type_id').val() == 1) {
					$('#subscribe_time').hide();
					$('#file_digital').hide();
					$('#type_1').prop('required', false);
				} else {
					if($('#type_id').val() == 3) $('#subscribe_time').show(); else $('#subscribe_time').hide();
					$('#file_digital').show();
					$('#type_1').prop('required', true);
				}
			});

        });
    </script>
@endsection
