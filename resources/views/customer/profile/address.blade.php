@extends('__layouts.__frontend.setting_profile')

@section('content-setting')
    <div class="col-12 col-lg-8 p-2 p-md-4 p-lg-4 mt-4 mt-lg-2 mt-lg-0 mx-lg-4 border border-0 border-lg-1 rounded-3">
        <div class="w-100 d-flex align-items-center justify-content-between">
            <strong class="fw-bold" style="font-size: 18px; line-height: 1.5rem">
                Daftar Alamat
            </strong>
            <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-2" data-bs-toggle="modal"
                data-bs-target="#staticBackdropAddAddress">
                <i class="fa-solid fa-plus" style="font-size: 16px;"></i>
                Alamat Baru
            </button>
        </div>
        <div id="containerCustomerAddressList" class="w-100 mt-5 p-0">
        </div>
        <div id="continerShoping" class="w-100 mt-3 p-0">
        </div>
    </div>
@endsection

@section('modal')
    {{-- Modal utk Add Address Start --}}
    <div class="modal fade" id="staticBackdropAddAddress" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropAddAddressLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropAddAddressLabel">Tambah Alamat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="customerAddressAdd" class="w-100 px-0 px-lg-2">
                        <div class="row g-3 g-lg-4 mb-4">
                            <div class="col-12 col-md-6">
                                <label for="nameAddressee" class="mb-2 fw-semibold " style="font-size: 14px;">Nama
                                    Lengkap</label>
                                <input type="text" id="nameAddressee" class="form-control fs-6 py-2"
                                    placeholder="Nama Lengkap" name="nameAddressee" autocomplete="off" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="phoneAddressee" class="mb-2 fw-semibold " style="font-size: 14px;">No
                                    Telpon</label>
                                <input type="number" id="phoneAddressee" class="form-control fs-6 py-2"
                                    placeholder="No Telpon" name="phoneAddressee" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row g-3 g-lg-4 mb-4">
                            <div class="col-12 col-md-6">
                                <label for="provinceAddressee" class="mb-2 fw-semibold "
                                    style="font-size: 14px;">Provinsi</label>
                                <select id="provinceAddressee" name="provinceAddressee" class="form-control" required>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="cityRegionAddressee" class="mb-2 fw-semibold "
                                    style="font-size: 14px;">Kabupaten/Kota</label>
                                <select id="cityRegionAddressee" name="cityRegionAddressee" class="form-control" required>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 g-lg-4 mb-4">
                            <div class="col-12 col-md-6">
                                <label for="districtAddressee" class="mb-2 fw-semibold "
                                    style="font-size: 14px;">Kelurahan/Kecamatan</label>
								<select id="districtAddressee" name="districtAddressee" class="form-control" required>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="postalCodeAddressee" class="mb-2 fw-semibold " style="font-size: 14px;">Kode
                                    POS</label>
                                <input type="text" id="postalCodeAddressee" class="form-control fs-6 py-2"
                                    placeholder="Kode POS" name="postalCodeAddressee" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row g-3 g-lg-4 mb-2">
                            <div class="col-12">
                                <label for="streetAddressee" class="mb-2 fw-semibold "
                                    style="font-size: 14px;">Jalan</label>
                                <input type="text" id="streetAddressee" class="form-control fs-6 py-2"
                                    placeholder="Jalan" name="streetAddressee" autocomplete="off" required>
                            </div>
                        </div>
						<div class="row g-3 g-lg-4 mb-2">
                            <div class="col-12">
                                <label for="streetAddressee" class="mb-2 fw-semibold "
                                    style="font-size: 14px;">Jadikan Alamat Utama</label>
								<div class="col-3">
                                <input type="radio" id="activeAddress" name="activeAddress" value="yes" /> Yes
								</div>
								<div class="col-3">
                                <input type="radio" id="activeAddress" name="activeAddress" value="no" /> No
								</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button id="customerAddressAddSubmit" type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal utk Add Address End --}}

    {{-- Modal utk Edit Address Start --}}
    <div class="modal fade" id="staticBackdropEditAddress" data-bs-backdrop="static" data-bs-keyboard="false"
        tabindex="-1" aria-labelledby="staticBackdropEditAddressLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropEditAddressLabel">Update Address</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" class="w-100 px-0 px-lg-2">
                        <div class="row g-3 g-lg-4 mb-4">
                            <div class="col-12 col-md-6">
                                <label for="nameCustomerEdit" class="mb-2 fw-semibold " style="font-size: 14px;">Nama
                                    Lengkap</label>
                                <input type="text" id="nameCustomerEdit" class="form-control fs-6 py-2"
                                    placeholder="Nama Lengkap" name="nameCustomerEdit" autocomplete="off" required>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="phoneCustomerEdit" class="mb-2 fw-semibold " style="font-size: 14px;">No
                                    Telpon</label>
                                <input type="text" id="phoneCustomerEdit" class="form-control fs-6 py-2"
                                    placeholder="No Telpon" name="phoneCustomerEdit" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row g-3 g-lg-4 mb-4">
                            <div class="col-12 col-md-6">
                                <label for="provinceCustomerEdit" class="mb-2 fw-semibold "
                                    style="font-size: 14px;">Provinsi</label>
								<select id="provinceCustomerEdit" name="provinceCustomerEdit" class="form-control" required>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="cityRegionCustomerEdit" class="mb-2 fw-semibold "
                                    style="font-size: 14px;">Kabupaten/Kota</label>
								<select id="cityRegionCustomerEdit" name="cityRegionCustomerEdit" class="form-control" required>
                                </select>
                            </div>
                        </div>
                        <div class="row g-3 g-lg-4 mb-4">
                            <div class="col-12 col-md-6">
                                <label for="districtCustomerEdit" class="mb-2 fw-semibold "
                                    style="font-size: 14px;">Kelurahan/Kecamatan</label>
								<select id="districtCustomerEdit" name="districtCustomerEdit" class="form-control" required>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="postalCodeCustomerEdit" class="mb-2 fw-semibold "
                                    style="font-size: 14px;">Kode POS</label>
                                <input type="text" id="postalCodeCustomerEdit" class="form-control fs-6 py-2"
                                    placeholder="Kode POS" name="postalCodeCustomerEdit" autocomplete="off" required>
                            </div>
                        </div>
                        <div class="row g-3 g-lg-4 mb-2">
                            <div class="col-12">
                                <label for="streetCustomerEdit" class="mb-2 fw-semibold "
                                    style="font-size: 14px;">Jalan</label>
                                <input type="text" id="streetCustomerEdit" class="form-control fs-6 py-2"
                                    placeholder="Jalan" name="streetCustomerEdit" autocomplete="off">
                            </div>
                            <div class="col-12">
                                <input type="hidden" id="idAddressEdit" class="form-control fs-6 py-2"
                                    placeholder="id edit" name="idAddressEdit" autocomplete="off">
                            </div>
                        </div>
						<div class="row g-3 g-lg-4 mb-2">
                            <div class="col-12">
                                <label for="streetAddressee" class="mb-2 fw-semibold "
                                    style="font-size: 14px;">Jadikan Alamat Utama</label>
								<div class="col-3">
                                <input type="radio" id="activeAddressEdit" name="activeAddressEdit" value="yes" /> Yes
								</div>
								<div class="col-3">
                                <input type="radio" id="activeAddressEdit2" name="activeAddressEdit" value="no" /> No
								</div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button id="customerAddressEditSubmit" type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- Modal utk Edit Address End --}}
@endsection

@section('script-setting')
    <script type="text/javascript">
	console.log('reza');
        $(document).ready(function() {
			
			$.ajax({
				headers: {
					'X-API-KEY': '{{ env('API_KEY') }}'
				},
				url: '{{ route('api.rajaongkir.provinces') }}',
				type: "GET", // or "POST"
				dataType: "json", // Expect a JSON response
				success: function(data) {
					// console.log(data['data']);
					var datas = data['data'];
					// Clear existing options (except the default "Select an option")
					$('#provinceAddressee').empty();		
					$('#provinceCustomerEdit').empty(); 
					$('#provinceAddressee').append('<option value="">-- Provinsi --</option>');
					$('#provinceCustomerEdit').append('<option value="">-- Provinsi --</option>');
					console.log(data['data']);
					$.each(datas, function(key, value) {
						
						var newOption = new Option(value.name, value.id);
						$('#provinceAddressee').append('<option value="' + value.id + '">' + value.name + '</option>');
						$('#provinceCustomerEdit').append('<option value="' + value.id + '">' + value.name + '</option>');
					});
					
				},
				error: function(jqXHR, textStatus, errorThrown) {
					console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
				}
			});
			
			
			$('#provinceAddressee').on('change', function() {
				var provinceId = $(this).val();
				
				// Clear previous options in the item select
				$('#cityRegionAddressee').empty().append('<option value="">Loading...</option>');
				$('#districtAddressee').empty();

				if (provinceId) {
					$.ajax({
						headers: {
							'X-API-KEY': '{{ env('API_KEY') }}'
						},
						url: "{{ route('api.rajaongkir.cities') }}/?province_id="+provinceId,
						type: 'GET',
						// data: { province_id: provinceId },
						dataType: 'json', // Expecting a JSON response
						success: function(data) {
							var datas = data['data'];
							console.log(datas);
							$('#cityRegionAddressee').empty().append('<option value="">-- Kabupaten/Kota --</option>');
							
							// Loop through the data and add options
							$.each(datas, function(key, value) {
								$('#cityRegionAddressee').append('<option value="' + value.id + '">' + value.name + '</option>');
							});
						},
						error: function(xhr, status, error) {
							console.error("An error occurred: " + status + " " + error);
							$('#cityRegionAddressee').empty().append('<option value="">Error loading items</option>');
						}
					});
				} else {
					// If no category is selected, reset the item select
					$('#cityRegionAddressee').empty().append('<option value="">Select Item</option>');
				}
			});

			$('#provinceCustomerEdit').on('change', function() {
				var provinceId = $(this).val();
				
				// Clear previous options in the item select
				$('#cityRegionCustomerEdit').empty().append('<option value="">Loading...</option>');
				$('#districtCustomerEdit').empty();

				if (provinceId) {
					$.ajax({
						headers: {
							'X-API-KEY': '{{ env('API_KEY') }}'
						},
						url: "{{ route('api.rajaongkir.cities') }}/?province_id="+provinceId,
						type: 'GET',
						// data: { province_id: provinceId },
						dataType: 'json', // Expecting a JSON response
						success: function(data) {
							var datas = data['data'];
							$('#cityRegionCustomerEdit').empty().append('<option value="">-- Kabupaten/Kota --</option>');
							
							// Loop through the data and add options
							$.each(datas, function(key, value) {
								$('#cityRegionCustomerEdit').append('<option value="' + value.id + '">' + value.name + '</option>');
							});
						},
						error: function(xhr, status, error) {
							console.error("An error occurred: " + status + " " + error);
							$('#cityRegionCustomerEdit').empty().append('<option value="">Error loading items</option>');
						}
					});
				} else {
					// If no category is selected, reset the item select
					$('#cityRegionCustomerEdit').empty().append('<option value="">-- Kabupaten/Kota --</option>');
				}
			});
			
			$('#cityRegionAddressee').on('change', function() {
				var cityId = $(this).val();
				
				// Clear previous options in the item select
				$('#districtAddressee').empty().append('<option value="">Loading...</option>');

				if (cityId) {
					$.ajax({
						headers: {
							'X-API-KEY': '{{ env('API_KEY') }}'
						},
						url: "{{ route('api.rajaongkir.districts') }}/?city_id="+cityId,
						type: 'GET',
						dataType: 'json', // Expecting a JSON response
						success: function(data) {
							var datas = data['data'];
							$('#districtAddressee').empty().append('<option value="">-- Kelurahan/Kecamatan --</option>');
							
							// Loop through the data and add options
							$.each(datas, function(key, value) {
								$('#districtAddressee').append('<option value="' + value.id + '">' + value.name + '</option>');
							});
						},
						error: function(xhr, status, error) {
							console.error("An error occurred: " + status + " " + error);
							$('#districtAddressee').empty().append('<option value="">Error loading items</option>');
						}
					});
				} else {
					// If no category is selected, reset the item select
					$('#districtAddressee').empty().append('<option value="">-- Kelurahan/Kecamatan --</option>');
				}
			});
			
			$('#cityRegionCustomerEdit').on('change', function() {
				var cityId = $(this).val();
				
				// Clear previous options in the item select
				$('#districtCustomerEdit').empty().append('<option value="">Loading...</option>');

				if (cityId) {
					$.ajax({
						headers: {
							'X-API-KEY': '{{ env('API_KEY') }}'
						},
						url: "{{ route('api.rajaongkir.districts') }}/?city_id="+cityId,
						type: 'GET',
						dataType: 'json', // Expecting a JSON response
						success: function(data) {
							var datas = data['data'];
							$('#districtCustomerEdit').empty().append('<option value="">-- Kelurahan/Kecamatan --</option>');
							
							// Loop through the data and add options
							$.each(datas, function(key, value) {
								$('#districtCustomerEdit').append('<option value="' + value.id + '">' + value.name + '</option>');
							});
						},
						error: function(xhr, status, error) {
							console.error("An error occurred: " + status + " " + error);
							$('#districtCustomerEdit').empty().append('<option value="">Error loading items</option>');
						}
					});
				} else {
					// If no category is selected, reset the item select
					$('#districtCustomerEdit').empty().append('<option value="">-- Kelurahan/Kecamatan --</option>');
				}
			});
			
			
            // handle get address
            function getAddressCustomer() {
                $.ajax({
                    headers: {
                        'X-API-KEY': '{{ env('API_KEY') }}'
                    },
                    url: '{{ route('api.customer.address.index') }}?customer_id={{ session('customer_id') }}',
                    method: 'GET',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // console.log("Response API Get Address Customer: ", response.data);
                        let dataAddress = response.data;

                        if (dataAddress !== null) {
                            if (dataAddress.length == 1) {
                                $("#continerShoping").html(
                                    `<div class="w-100 d-flex flex-column align-items-center justify-content-center">
                                    <p class="text-center mb-1">
                                        Udah ada barang yang pengen kamu beli? atau masuk wishlist kamu?
                                    </p>
                                    <a class="link-offset-2 link-offset-3-hover link-underline link-underline-opacity-0 link-underline-opacity-75-hover"
                                        href="{{ url('/shop') }}" style="font-size: 14px; line-height: 1.5; font-weight: 700;">
                                        Lihat - lihat dulu yuk!
                                    </a>
                                </div>`);
                            }
                            if (dataAddress.length > 0) {
                                $("#containerCustomerAddressList").html(
                                    dataAddress.map((address, index) => {
                                        return `
                                            <div class="w-100 d-flex align-items-start justify-content-between gap-4 gap-lg-5 py-4 px-4 rounded-2 border border-1 mb-3 ${index == 0 ? "bg-primary-subtle border-primary" : ""}">
                                                <div class="d-flex flex-column">
                                                    <strong class="fw-bold" style="font-size: 16px; line-height: 1.5rem">${address.name}</strong>
                                                    <span class="fw-medium" style="font-size: 14px; line-height: 1.5rem">${address.phone}</span>
                                                    <div class="fw-medium text-wrap w-md-75 w-lg-75" style="font-size: 14px; line-height: 1.5rem;">Jl.
                                                        ${address.address}, ${address.road}, ${address.city}, ${address.province}
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-row gap-3">
                                                    <button type="button" class="edit-address"
                                                        style="border: none; background-color: transparent; padding: 0; margin: 0; color: #229FE1;"
                                                        data-bs-toggle="modal" data-bs-target="#staticBackdropEditAddress" data-id="${address.id}" data-name="${address.name}" data-phone="${address.phone}" data-address="${address.address}" data-road="${address.district_id}" data-city="${address.city_id}" data-province="${address.province_id}" data-zip_code="${address.zip_code}" data-active="${address.active}">
                                                        <i class="fa-solid fa-pen-to-square" style="font-size: 20px;"></i>
                                                    </button>
                                                    <button type="button" class="delete-address"
                                                        style="border: none; background-color: transparent; padding: 0; margin: 0; color: #EE0000;" data-id="${address.id}">
                                                        <i class="fa-solid fa-trash-can" style="font-size: 20px;"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        `;
                                    }).join("")
                                );
                            } else {
                                $("#containerCustomerAddressList").html(
                                    `<div class="w-100 d-flex align-items-center justify-content-center">
                                        <p>Alamat masih kosong, silahkan tambahkan alamat</p>
                                    </div>`);
                            }
                        } else {
                            $("#containerCustomerAddressList").html(
                                `<div class="w-100 d-flex align-items-center justify-content-center">
                                        <p>Terjadi kesalahan: ${response.message}</p>
                                    </div>`);
                        }
                    },
                    error: function(error) {
                        console.error("Terjadi kesalahan dalam mengambil data address:", xhr);
                    }
                });
            }

            $(document).on("click", ".delete-address", function() {
                let addressId = $(this).data("id");
                handleDeleteAddress(addressId);
            });

            $(document).on("click", ".edit-address", function() {
                let addressId = $(this).data("id");
                let addressName = $(this).data("name");
                let addressPhone = $(this).data("phone");
                let addressAddress = $(this).data("address");
                let addressRoad = $(this).data("road");
                let addressCity = $(this).data("city");
				let activeAddress = $(this).data("active");
				
				if (addressCity) {
					$.ajax({
						headers: {
							'X-API-KEY': '{{ env('API_KEY') }}'
						},
						url: "{{ route('api.rajaongkir.districts') }}/?city_id="+addressCity,
						type: 'GET',
						dataType: 'json', // Expecting a JSON response
						success: function(data) {
							var datas = data['data'];
							$('#districtCustomerEdit').empty().append('<option value="">-- Kelurahan/Kecamatan --</option>');
							
							// Loop through the data and add options
							$.each(datas, function(key, value) {
								if(value.id == addressRoad)
									$('#districtCustomerEdit').append('<option value="' + value.id + '" selected>' + value.name + '</option>');
								else
									$('#districtCustomerEdit').append('<option value="' + value.id + '">' + value.name + '</option>');
							});
						},
						error: function(xhr, status, error) {
							console.error("An error occurred: " + status + " " + error);
							$('#districtCustomerEdit').empty().append('<option value="">Error loading items</option>');
						}
					});
				}
				
                let addressProvince = $(this).data("province");
				if (addressProvince) {
					
					$.ajax({
						headers: {
							'X-API-KEY': '{{ env('API_KEY') }}'
						},
						url: "{{ route('api.rajaongkir.cities') }}/?province_id="+addressProvince,
						type: 'GET',
						dataType: 'json', // Expecting a JSON response
						success: function(data) {
							var datas = data['data'];
							$('#cityRegionCustomerEdit').empty().append('<option value="">-- Kabupaten/Kota --</option>');
							
							// Loop through the data and add options
							$.each(datas, function(key, value) {
								if(value.id==addressCity) 
									$('#cityRegionCustomerEdit').append('<option value="' + value.id + '" selected>' + value.name + '</option>');
								else
									$('#cityRegionCustomerEdit').append('<option value="' + value.id + '">' + value.name + '</option>');
							});
						},
						error: function(xhr, status, error) {
							console.error("An error occurred: " + status + " " + error);
							$('#cityRegionAddressee').empty().append('<option value="">Error loading items</option>');
						}
					});
				}
				
                let addressZipCode = $(this).data("zip_code");

                $("#nameCustomerEdit").val(addressName);
                $("#phoneCustomerEdit").val(addressPhone);
                $("#provinceCustomerEdit").val(addressProvince);
                $("#postalCodeCustomerEdit").val(addressZipCode);
                $("#streetCustomerEdit").val(addressAddress);
				if(activeAddress=='yes') $('input[name="activeAddressEdit"][value="yes"]').prop('checked', true);
				else $('input[name="activeAddressEdit"][value="no"]').prop('checked', true);
                $("#idAddressEdit").val(addressId);
            });

            getAddressCustomer();

            // handle add address
            function addAddressCustomer(nameAddressee, phoneAddressee, provinceAddressee, cityRegionAddressee,
                districtAddressee, postalCodeAddressee, streetAddressee, provinceAddresseeText, cityRegionAddresseeText, districtAddresseeText, activeAddress) {
                return new Promise((resolve, reject) => {
                    sweetAlertLoading()
                    let formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('customer_id', '{{ session('customer_id') }}');
                    formData.append('name', nameAddressee);
                    formData.append('phone', phoneAddressee);
                    formData.append('road', districtAddressee);
					formData.append('road_text', districtAddresseeText);
                    formData.append('city', cityRegionAddressee);
					formData.append('city_text', cityRegionAddresseeText);
                    formData.append('province', provinceAddressee);
					formData.append('province_text', provinceAddresseeText);
                    formData.append('zip_code', postalCodeAddressee);
                    formData.append('address', streetAddressee);
					formData.append('active', activeAddress);

                    $.ajax({
                        headers: {
                            'X-API-KEY': '{{ env('API_KEY') }}'
                        },
                        url: '{{ route('api.customer.address.store') }}',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            resolve(response);
                        },
                        error: function(xhr, status, error) {
                            reject(xhr);
                        }
                    });
                });
            }

            $("#customerAddressAddSubmit").on('click', function(e) {
                e.preventDefault();

                let nameAddressee = $("#nameAddressee").val();
                let phoneAddressee = $("#phoneAddressee").val();
                let provinceAddressee = $("#provinceAddressee").val();
				let provinceAddresseeText =  $('#provinceAddressee option:selected').text();
                let cityRegionAddressee = $("#cityRegionAddressee").val();
				let cityRegionAddresseeText =  $('#cityRegionAddressee option:selected').text();
                let districtAddressee = $("#districtAddressee").val();
				let districtAddresseeText =  $('#districtAddressee option:selected').text();
                let postalCodeAddressee = $("#postalCodeAddressee").val();
                let streetAddressee = $("#streetAddressee").val();
				let activeAddress = $("#activeAddress").val();

                if (nameAddressee == "" || phoneAddressee == "" || provinceAddressee == "" ||
                    cityRegionAddressee == "" ||
                    districtAddressee == "" || postalCodeAddressee == "" || streetAddressee == "") {
                    sweetAlertWarning("Harap isi semua field");
                    return;
                }

                $("#staticBackdropAddAddress").modal("hide");

                addAddressCustomer(nameAddressee, phoneAddressee, provinceAddressee,
                        cityRegionAddressee,
                        districtAddressee, postalCodeAddressee, streetAddressee, provinceAddresseeText, cityRegionAddresseeText, districtAddresseeText, activeAddress)
                    .then((response) => {
                        console.log("Response API Add Address Customer: ", response);
                        if (response.success === true && response.message == 'Success') {
                            Swal.close();
                            sweetAlertSuccess("Berhasil menambahkan alamat customer");
                            getAddressCustomer();
                            $("#nameAddressee, #phoneAddressee, #provinceAddressee, #cityRegionAddressee, #districtAddressee, #postalCodeAddressee, #streetAddressee")
                                .val("");
                        } else {
                            Swal.close();
                            sweetAlertDanger(response.message);
                        }
                    })
                    .catch((error) => {
                        Swal.close();
                        console.error('Terjadi Masalah Add Address Customer:', error);
                        sweetAlertDanger(error.responseJSON.message);
                    });
            });

            // handle delete address
            function deleteAddressCustomer(idAddressee) {
                return new Promise((resolve, reject) => {
                    sweetAlertLoading()
                    let formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');

                    $.ajax({
                        headers: {
                            'X-API-KEY': '{{ env('API_KEY') }}'
                        },
                        url: `{{ url('api/customer/delete/address') }}/${idAddressee}`,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            resolve(response);
                        },
                        error: function(xhr, status, error) {
                            reject(xhr);
                        }
                    });
                });
            }

            function handleDeleteAddress(id) {
                Swal.fire({
                    title: "Hapus Alamat",
                    text: "Apakah Anda yakin ingin menghapus alamat ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#229FE1",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, hapus",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteAddressCustomer(id)
                            .then((response) => {
                                console.log("Response API Delete Address Customer: ", response);
                                if (response.success === true && response.message == 'Success') {
                                    Swal.close();
                                    sweetAlertSuccess("Berhasil menghapus alamat customer");
                                    getAddressCustomer();
                                } else {
                                    Swal.close();
                                    sweetAlertDanger(response.message);
                                }
                            })
                            .catch((error) => {
                                Swal.close();
                                console.error('Terjadi Masalah Delete Address Customer:', error);
                                sweetAlertDanger(error.responseJSON.message);
                            });
                    }
                });
            }

            // handle edit address
            function editAddressCustomer(nameAddressee, phoneAddressee, provinceAddressee, cityRegionAddressee,
                districtAddressee, postalCodeAddressee, streetAddressee, idAddresseeEdit, provinceAddresseeText, cityRegionAddresseeText, districtAddresseeText, activeAddress) {
                return new Promise((resolve, reject) => {
                    sweetAlertLoading()
                    let formData = new FormData();
                    formData.append('_token', '{{ csrf_token() }}');
                    formData.append('customer_id', '{{ session('customer_id') }}');
                    formData.append('name', nameAddressee);
                    formData.append('phone', phoneAddressee);
                    formData.append('road', districtAddressee);
					formData.append('road_text', districtAddresseeText);
                    formData.append('city', cityRegionAddressee);
					formData.append('city_text', cityRegionAddresseeText);
                    formData.append('province', provinceAddressee);
					formData.append('province_text', provinceAddresseeText);
                    formData.append('zip_code', postalCodeAddressee);
                    formData.append('address', streetAddressee);
					formData.append('active', activeAddress);

                    $.ajax({
                        headers: {
                            'X-API-KEY': '{{ env('API_KEY') }}'
                        },
                        url: `{{ url('api/customer/update/address/') }}/${idAddresseeEdit}`,
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            resolve(response);
                        },
                        error: function(xhr, status, error) {
                            reject(xhr);
                        }
                    });
                });
            }

            $("#customerAddressEditSubmit").on('click', function(e) {
                e.preventDefault();

                let nameAddressee = $("#nameCustomerEdit").val();
                let phoneAddressee = $("#phoneCustomerEdit").val();
                let provinceAddressee = $("#provinceCustomerEdit").val();
				let provinceAddresseeText =  $('#provinceCustomerEdit option:selected').text();
                let cityRegionAddressee = $("#cityRegionCustomerEdit").val();
				let cityRegionAddresseeText =  $('#cityRegionCustomerEdit option:selected').text();
                let districtAddressee = $("#districtCustomerEdit").val();
				let districtAddresseeText =  $('#districtCustomerEdit option:selected').text();
                let postalCodeAddressee = $("#postalCodeCustomerEdit").val();
                let streetAddressee = $("#streetCustomerEdit").val();
                let idAddresseeEdit = $("#idAddressEdit").val();
				let activeAddress = $("#activeAddressEdit").val();

                if (nameAddressee == "" || phoneAddressee == "" || provinceAddressee == "" ||
                    cityRegionAddressee == "" ||
                    districtAddressee == "" || postalCodeAddressee == "" || streetAddressee == "") {
                    sweetAlertWarning("Harap isi semua field");
                    return;
                }

                $("#staticBackdropEditAddress").modal("hide");

                editAddressCustomer(nameAddressee, phoneAddressee, provinceAddressee, cityRegionAddressee,
                        districtAddressee, postalCodeAddressee, streetAddressee, idAddresseeEdit, provinceAddresseeText, cityRegionAddresseeText, districtAddresseeText, activeAddress)
                    .then((response) => {
                        console.log("Response API Update Address Customer: ", response);
                        if (response.success === true && response.message == 'Success') {
                            Swal.close();
                            sweetAlertSuccess("Update alamat customer berhasil");
                            getAddressCustomer();
                        } else {
                            Swal.close();
                            sweetAlertDanger(response.message);
                        }
                    })
                    .catch((error) => {
                        Swal.close();
                        console.error('Terjadi Masalah Update Address Customer:', error);
                        sweetAlertDanger(error.responseJSON.message);
                    });
            });
        });
    </script>
@endsection
