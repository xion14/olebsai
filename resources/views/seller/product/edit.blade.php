@extends('__layouts.__seller.main')

@section('body')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1 id="title"></h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item"><a href="#">Seller</a></div>
              <div class="breadcrumb-item active"><a href="#">Products</a></div>
            </div>
          </div>

        <div class="section-body">
        <!-- <div class="card-header">
            <h4>Add New Product</h4>
        </div> -->
        <div class="card-body">
        <form id="editProduct">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="code">Product Code</label>
                    <input type="text" name="code" class="form-control" required value="{{ $product->code }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="name">Product Name</label>
                    <input type="text" name="name" class="form-control" required value="{{ $product->name }}">
                </div>
				<div class="form-group col-md-4">
                    <label for="type_id">Type</label>
                    <select id="type_id" name="type_id" class="form-control" required>
                        <option value="">-- Select Type --</option>
                        @foreach($dataType as $type)
                            <option value="{{ $type->id }}" {{ $type->id == $product->type_id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" class="form-control" required>
                        <option value="">-- Select Category --</option>
                        @foreach($dataCategory as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
				<div class="form-group col-md-4">
					<label for="sub_category_id">Sub Category</label>
					<select id="sub_category_id" name="sub_category_id" class="form-control">
						<option value="">-- Select Sub Category --</option>
						@if($dataSubCategory)
							@foreach ($dataSubCategory as $subCategory)
								<option value="{{ $subCategory->id }}" {{ $subCategory->id == $product->sub_category_id ? 'selected' : '' }}>{{ $subCategory->name }}</option>
							@endforeach
						@endif
					</select>
				</div>
				<div class="form-group col-md-4">
                    <label for="weight">Weight (gram)</label>
                    <input type="number" name="weight" class="form-control" required value="{{ $product->weight }}">
                </div>
			</div>
			<div class="row">
				<div class="form-group col-md-4">
                    <label for="unit_id">Unit</label>
                    <select name="unit_id" class="form-control" required>
                        <option value="">-- Select Unit --</option>
                        @foreach($dataUnit as $unit)
                            <option value="{{ $unit->id }}" {{ $unit->id == $product->unit_id ? 'selected' : '' }}>
                                {{ $unit->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="stock">Stock</label>
                    <input type="number" name="stock" class="form-control" required value="{{ $product->stock }}">
                </div>
                <div class="form-group col-md-4">
                    <label for="price">Price</label>
                    <input type="number" name="price" class="form-control" required value="{{ $product->price }}">
                </div>
                
            </div>
			<div class="row">
                <div class="form-group col-md-4">
                    <label for="slug">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ $product->slug }}">
                </div>
                
            </div>
			<div class="row">	
            </div>
			
			{{---
			<div id="file_digital" class="form-group" style="display:{{ $product->type_id==1 ? 'none' : '' }}">
			<label for="description">File Digital</label>
				<div class="form-group col-md-3">
					<label for="file_1">File 1</label> <small>(required)</small>
					<input type="file" name="file_1" class="form-control" />
					@if($product->file_1)
						<a href="{{ asset('uploads/product/' . $product->file_1) }}" download class="btn btn-primary" title="{{$product->file_1}}">Download File</a>
					@endif
				</div>
				<div class="form-group col-md-3">
					<label for="file_2">File 2</label> <small>(optional)</small>
					<input type="file" name="file_2" class="form-control">
					@if($product->file_2)
						<a href="{{ asset('uploads/product/' . $product->file_2) }}" download class="btn btn-primary" title="{{$product->file_2}}">Download File</a>
					@endif
				</div>
				<div class="form-group col-md-3">
					<label for="file_3">File 3</label> <small>(optional)</small>
					<input type="file" name="file_3" class="form-control">
					@if($product->file_3)
						<a href="{{ asset('uploads/product/' . $product->file_3) }}" download class="btn btn-primary" title="{{$product->file_3}}">Download File</a>
					@endif
				</div>
				<div class="form-group col-md-3">
					<label for="file_4">File 4</label> <small>(optional)</small>
					<input type="file" name="file_4" class="form-control">
					@if($product->file_4)
						<a href="{{ asset('uploads/product/' . $product->file_4) }}" download class="btn btn-primary" title=digi"{{$product->file_4}}">Download File</a>
					@endif
				</div>
			</div>
			---}}
			
			
			<div id="file_digital" class="form-group" style="display:{{ $product->type_id==1 ? 'none' : '' }}">
				<label for="description">File Digital</label>
				<div id="container">
				@if($product->type_id == 1)
					@php $i=0 @endphp
					<div class="form-group col-md-12 row-item" style="border:1px solid gray; border-radius: 15px;">
						<div class="form-group col-md-4">
						<label for="digital_file">File</label> <small>{{'(required)'}}</small>
						<input type="file" id="type_{{($i+1)}}" name="digitals_{{$i}}" class="form-control" />
						<input type="hidden" id="file_digitals_{{$i}}" name="file_digitals[]" value="value" />
						</div>
						@if($i > 0)
						<button class="remove-btn">Remove</button>
						@endif
					</div>
				@else
					@php $i=0 @endphp
					@if($digitals)
					@foreach($digitals as $digital)
					
						<div class="form-group col-md-12 row-item" style="border:1px solid gray; border-radius: 15px;">
							<div class="form-group col-md-4">
							<label for="digital_file">File</label> <small>{{ $product->type_id != 1 ? ($i==0 ? '(required)' : '(optional)') : '(optional)' }}</small>
							<input type="file" id="type_{{($i+1)}}" name="digitals_{{$i}}" class="form-control" />
							<input type="hidden" id="file_digitals_{{$i}}" name="file_digitals[]" value="{{ $digital['name'] }}" />
							</div>
							<div class="file_existing form-group col-md-8">
							<label for="digital_file">File existing </label> <strong>{{ $digital['name'] }}</strong>
							</div>
							@if($i > 0)
							<button class="remove-btn">Remove</button>
							@endif
						</div>
					
					@php $i++ @endphp
					@endforeach
					@endif

				@endif
				</div>
				<button id="add-btn">Add File</button>
			</div>
			
			
			<div id="subscribe_time" class="form-group" style="display:{{ $product->type_id==3 ? '' : 'none' }}">
				<label for="description">Subscribe Time & Price (If filled in, the subscription price applies & main price no longer valid)</label>
				<div id="container_subtime">
				@if($product->type_id == 3)
					@php $i=0 @endphp
					@if($digitals)
						@foreach($subtimes as $subtime)
							<div class="form-group row-item">
								<div class="row">
									<div class="form-group col-md-3">
										<label for="subscribe_time">Time Label</label>
										<input type="text" id="subtime_1" name="subtimes[]" placeholder="ex: 1minggu, 1bulan, dll" class="form-control" value="{{ $subtime['subtime'] }}" required />
									</div>
									<div class="form-group col-md-3">
										<label for="subscribe_price">Price</label>
										<input type="text" name="subprices[]"  value="{{ $subtime['subprice'] }}" placeholder="subscribe price" class="form-control" required />
									</div>
								</div>
								<div class="row">
									<div class="form-group col-md-3">
									<button class="remove-btn-subtime">Remove Time & Price</button>
									</div>
								</div>
							</div>
							@php $i++ @endphp
						@endforeach
					@endif
				@endif
				</div>
				<button id="add-subtime">Add Subscribe Time Label & Price</button>
			</div>

			
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control">{{ $product->description }}</textarea>
            </div>
            <div class="row">
                <div class="form-group col-md-3">
                    <label for="image_1">Image 1</label>
                    <input type="file" name="image_1" class="form-control">
                    @if($product->image_1)
                        <img src="{{ asset('uploads/product/' . $product->image_1) }}" alt="Image 1" width="100">
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="image_2">Image 2</label>
                    <input type="file" name="image_2" class="form-control">
                    @if($product->image_2)
                        <img src="{{ asset('uploads/product/' . $product->image_2) }}" alt="Image 2" width="100">
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="image_3">Image 3</label>
                    <input type="file" name="image_3" class="form-control">
                    @if($product->image_3)
                        <img src="{{ asset('uploads/product/' . $product->image_3) }}" alt="Image 3" width="100">
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="image_4">Image 4</label>
                    <input type="file" name="image_4" class="form-control">
                    @if($product->image_4)
                        <img src="{{ asset('uploads/product/' . $product->image_4) }}" alt="Image 4" width="100">
                    @endif
                </div>
            </div>
            <!-- <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                </select>
            </div> -->
            <button type="submit" class="btn btn-primary">Submit</button>
            <a href="#" class="btn btn-secondary" id="cancel_btn">Cancel</a>
        </form>
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
		
		$('#add-btn').on('click', function(e) {
			e.preventDefault(); // Prevent form submission if in a form
			$('#container').append(createNewRow()); // Append the new row to the container
			$('#container').find('input[type="file"]').each(function(index) {
				$(this).attr('name', 'digitals_'+index);
			});
			$('#container').find('input[type="hidden"]').each(function(index) {
				$(this).attr('id', 'file_digitals_'+index);
				
			});
		});
	
		
		$('#container').on('click', '.remove-btn', function(e) {
			e.preventDefault();add-subtime
			$(this).parent('.row-item').remove(); // Find the parent div with class 'row-item' and remove it
			$('#container').find('input[type="file"]').each(function(index) {
				$(this).attr('name', 'digitals_'+index);
			});
			$('#container').find('input[type="hidden"]').each(function(index) {
				$(this).attr('id', 'file_digitals_'+index);
			});
		});
		
		
		$('#add-subtime').on('click', function(e) {
			e.preventDefault(); // Prevent form submission if in a form
			$('#container_subtime').append(createNewRowSubtime()); // Append the new row to the container
		});
		
		
		$('#container_subtime').on('click', '.remove-btn-subtime', function(e) {
			e.preventDefault();
			$(this).parent().parent().parent().remove(); // Find the parent div with class 'row-item' and remove it
		});
		
		
		x=1;
		function createNewRow() {
			x++;
			return `
				<div class="form-group col-md-12 row-item" style="border:1px solid gray; border-radius: 15px;">
					<div class="form-group col-md-4">
					<label for="digital_file">File</label> <small>(optional)</small>
					<input type="file" name="digitals" class="form-control">
					<input type="hidden" name="file_digitals[]" value="value" />
					</div>
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
		
        var path = window.location.pathname.trim(); 
        var basePath = path.split('/').slice(0, 3).join('/'); 
        var url = "";
        var success_url = "";
        var cancel_url = "";

        if (basePath === '/seller/my-products') {
            $('#title').html("Edit My Products");
            var url = "{{ route('seller.my-products.update', $product->id) }}";
            var success_url = "{{ route('seller.my-products') }}";
            var cancel_url = "{{ route('seller.my-products') }}";
            //set href cancel button
            $('#cancel_btn').attr('href', cancel_url);
        } else {
            $('#title').html("Edit Product");
            var url = "{{ route('seller.products.update', $product->id) }}";
            var success_url = "{{ route('seller.products') }}"; 
            var cancel_url = "{{ route('seller.products') }}";
            $('#cancel_btn').attr('href', cancel_url);
        }


        $('#editProduct').on('submit', function(e) {
            e.preventDefault(); // Mencegah reload halaman

            let formData = new FormData(this);
            formData.append('basePath', basePath); 
            formData.append('status', 1);
            $.ajax({
                url: url, 
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait while we update your product.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Product updated successfully!',
                        timer: 2000, // Swal akan otomatis tertutup setelah 2 detik
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href =success_url ; // Redirect ke halaman daftar produk
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = "";
                        $.each(errors, function(key, value) {
                            errorMessage += value[0] + "<br>";
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error!',
                            html: errorMessage,
                        });

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong! Please try again.',
                        });
                    }
                }
            });
        });
		
		
		$("#type_id").change(function() {
			if($('#type_id').val() == 1) {
				$('#file_digital').hide();
				$('#type_1').prop('required', false);
			} else {
				$('#file_digital').show();
				$('#type_1').prop('required', true);
			}
		});

    });
</script>


@endsection