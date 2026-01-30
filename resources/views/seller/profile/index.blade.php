@extends('__layouts.__seller.main')

@section('body')
  <div class="main-content">
    <section class="section">
      <div class="section-header d-flex justify-content-between align-items-center">
        <h1> Seller Profile</h1>
        <div class="section-header-breadcrumb">
          <div class="breadcrumb-item"><a href="#">Seller</a></div>
          <div class="breadcrumb-item active"><a href="#">Profile</a></div>
        </div>
      </div>

      <div class="section-body">
        <div class="row">
          <div class="col-md-8 mx-auto">
            <div class="card shadow-sm border-0 rounded-lg">
              <div class="card-header bg-primary text-white text-center">
                <h4>Status: 
                  @if ($seller->status == 1)
                    <span class="badge bg-info">On Verification</span>
                  @elseif ($seller->status == 4)
                    <span class="badge bg-success">Verified</span>
                  @elseif ($seller->status == 3)
                    <span class="badge bg-danger">Rejected</span>
                    <p class="mt-2">Reason: <strong>{{ $seller->note }}</strong></p>
                  @endif
                </h4>
              </div>
              <div class="card-body">
                <form id="profileForm">
                <div class="row">
                  <div class="col-md-6">
                      <div class="mb-3">
                          <label for="name" class="form-label">Name</label>
                          <input type="text" name="name" id="name" class="form-control" value="{{ $seller->name }}" {{ $seller->status == 1 ? 'disabled' : '' }}>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="mb-3">
                          <label for="tax_number" class="form-label">Tax Number</label>
                          <input type="text" name="tax_number" id="tax_number" class="form-control" value="{{ $seller->tax_number }}" {{ $seller->status == 1 ? 'disabled' : '' }}>
                      </div>
                  </div>
                </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="business_number" class="form-label">Business Number</label>
                        <input type="text" name="business_number" id="business_number" class="form-control" value="{{ $seller->business_number }}"{{ $seller->status == 1 ? 'disabled' : '' }}>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ $seller->phone }}" {{ $seller->status == 1 ? 'disabled' : '' }}>
                      </div>
                    </div>
                  </div>
                  
                  <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $seller->email }}" {{ $seller->status == 1 ? 'disabled' : '' }}>
                  </div>

                  <div class="mb-3 d-none">
                    <label for="password" class="form-label">Password <small class="text-muted">(Leave blank to keep current password)</small></label>
                    <div class="input-group">
                      <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
                      <span class="input-group-text" id="togglePassword" style="cursor: pointer;">
                        <i class="fas fa-eye"></i>
                      </span>
                    </div>
                  </div>

                  <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" id="address" value="{{ $seller->address }}" class="form-control" rows="3" {{ $seller->status == 1 ? 'disabled' : '' }}>{{ $seller->address }}</textarea>
                  </div>

                  <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                          <label for="province" class="form-label">Province</label>
                          <input type="text" name="province" id="province"  class="form-control"  value="{{ $seller->province }}" {{ $seller->status == 1 ? 'disabled' : '' }}>
                        </div>
                    </div>
                    <div class="col-md-4">
                      <div class="mb-3">
                        <label for="city" class="form-label">City</label>
                        <input type="text" name="city" id="city"  class="form-control"  value="{{ $seller->city }}" {{ $seller->status == 1 ? 'disabled' : '' }}>
                      </div>
                    </div>
                   
                    <div class="col-md-4">
                      <div class="mb-3">
                        <label for="zip_code" class="form-label">Zip Code</label>
                        <input type="text" name="zip_code" id="zip_code" class="form-control" value="{{ $seller->zip }}" {{ $seller->status == 1 ? 'disabled' : '' }}>
                      </div>
                    </div>
                  </div>
                  
                  <div class="d-flex justify-content-end m-4">
                    <button type="submit" class="btn btn-lg btn-success px-4 py-2 shadow-sm rounded mr-3 {{ $seller->status == 1 ? 'd-none' : '' }}">
                      <i class="fas fa-save"></i> Save Changes
                    </button>
                    
                    <button type="button" class="btn btn-lg btn-warning px-4 py-2 shadow-sm rounded {{ $seller->status == 1 ? 'd-none' : '' }}" id="changePasswordBtn" >
                      <i class="fas fa-lock"></i> Change Password
                    </button>

                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    </div>


    <div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
      <div class="modal-dialog">
          <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
              </div>
              <div class="modal-body">
                  <!-- Old Password -->
                  <div class="mb-3">
                      <label for="oldPassword" class="form-label">Old Password</label>
                      <div class="input-group">
                          <input type="password" id="oldPassword" class="form-control" required>
                          <span class="input-group-text toggle-password" data-target="oldPassword" style="cursor: pointer;">
                              <i class="fas fa-eye"></i>
                          </span>
                          <div class="invalid-feedback">Old Password must be filled.</div>
                      </div>
                  </div>

                  <!-- New Password -->
                  <div class="mb-3">
                      <label for="newPassword" class="form-label">New Password</label>
                      <div class="input-group">
                          <input type="password" id="newPassword" class="form-control" required minlength="8">
                          <span class="input-group-text toggle-password" data-target="newPassword" style="cursor: pointer;">
                              <i class="fas fa-eye"></i>
                          </span>
                          <div class="invalid-feedback">New Password minimal 8 characters.</div>
                      </div>
                  </div>

                  <!-- Confirm Password -->
                  <div class="mb-3">
                      <label for="confirmPassword" class="form-label">Confirm Password</label>
                      <div class="input-group">
                          <input type="password" id="confirmPassword" class="form-control" required>
                          <span class="input-group-text toggle-password" data-target="confirmPassword" style="cursor: pointer;">
                              <i class="fas fa-eye"></i>
                          </span>
                          <div class="invalid-feedback">Confirm Password must be same.</div>
                      </div>
                  </div>
              </div>

              <div class="modal-footer d-flex justify-content-end">
                  <button type="button" class="btn btn-secondary" id="closeResetPasswordModal">Cancel</button>
                  <button type="button" class="btn btn-danger btn-update-password">Update Password</button>
              </div>
          </div>
      </div>
    </div> 
@endsection

@section('script')
  <script>
    $(document).ready(function() {
      let seller_id = @json($seller->id);

      function processForm(name, tax_number, business_number, phone, email, password, country, province, city,
        zip_code, address) {
        return new Promise((resolve, reject) => {
          let formData = new FormData();
          formData.append('_token', '{{ csrf_token() }}');
          formData.append('_method','put');
          formData.append('id',seller_id);
          formData.append('name', name);
          formData.append('tax_number', tax_number);
          formData.append('business_number', business_number);
          formData.append('phone', phone);
          formData.append('email', email);
          formData.append('password', password);
          formData.append('country', country);
          formData.append('province', province);
          formData.append('city', city);
          formData.append('zip_code', zip_code);
          formData.append('address', address)


          $.ajax({
            url: '{{ route('seller.profile.update', ':id') }}'.replace(':id', seller_id),
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
              resolve(response);
            },
            error: function(xhr) {
              reject(xhr);
            }
          });
        });
      }

      $('#profileForm').on('submit', function(e) {
        e.preventDefault();

        let name = $('#name').val();
        let tax_number = $('#tax_number').val();
        let business_number = $('#business_number').val();
        let phone = $('#phone').val();
        let email = $('#email').val();
        let password = $('#password').val();
        let country = $('#country').val();
        let province = $('#province').val();
        let city = $('#city').val();
        let zip_code = $('#zip_code').val();
        let address = $('#address').val();

        processForm(name, tax_number, business_number, phone, email, password, country, province, city, zip_code,
            address)
          .then((response) => {
            $('.is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').remove();
            if (response.status === 200) {
              sweetAlertSuccess(response.text);
            } else if (response.status === 400) {
              sweetAlertDanger(response.text);
            }
          })
          .catch(error => {
            console.error('Terjadi Masalah:', error);
          });
      });

      $('.togglePassword').on('click', function() {
        let passwordInput = document.getElementById('password');
        let icon = this.querySelector('i');

        if (passwordInput.type === "password") {
          passwordInput.type = "text";
          icon.classList.remove('fa-eye');
          icon.classList.add('fa-eye-slash');
        } else {
          passwordInput.type = "password";
          icon.classList.remove('fa-eye-slash');
          icon.classList.add('fa-eye');
        }
      });

      //change password
      $('#changePasswordBtn').on('click', function (event) {
        event.preventDefault();
        $('#resetPasswordModal').modal('show');
      });

      $('.btn-update-password').on('click', function (e) {
          e.preventDefault();

          let oldPassword = $('#oldPassword');
          let newPassword = $('#newPassword');
          let confirmPassword = $('#confirmPassword');
          let isValid = true;

          // Reset validation
          $('.form-control').removeClass('is-invalid');

          if (oldPassword.val().trim() === '') {
              oldPassword.addClass('is-invalid');
              isValid = false;
          }
          if (newPassword.val().trim() === '') {
              newPassword.addClass('is-invalid');
              newPassword.next('.invalid-feedback').text('New Password must be filled.');
              isValid = false;
          } else if (newPassword.val().length < 8) {
              newPassword.addClass('is-invalid');
              newPassword.next('.invalid-feedback').text('New Password minimal is 8 characters.');
              isValid = false;
          }
          if (confirmPassword.val().trim() === '') {
              confirmPassword.addClass('is-invalid');
              confirmPassword.next('.invalid-feedback').text('Confirm Password must be filled.');
              isValid = false;
          } else if (confirmPassword.val() !== newPassword.val()) {
              confirmPassword.addClass('is-invalid');
              confirmPassword.next('.invalid-feedback').text('Confirm Password must be same.');
              isValid = false;
          }

          if (!isValid) {
              return;
          }

          // Jika valid, kirim data via AJAX
          $.ajax({
              url: '{{ route('seller.profile.change-password', ':id') }}'.replace(':id', seller_id),
              method: 'POST',
              data: {
                  _token: '{{ csrf_token() }}',
                  oldPassword: oldPassword.val(),
                  newPassword: newPassword.val(),
                  confirmPassword: confirmPassword.val()
              },
              success: function (response) {
                  Swal.fire({
                      icon: 'success',
                      title: 'Berhasil!',
                      text: response.text,
                  });

                  $('#oldPassword').val('');
                  $('#newPassword').val('');
                  $('#confirmPassword').val('');

                  $('#resetPasswordModal').modal('hide');
              },
              error: function (xhr) {
                  if (xhr.status === 422) {
                      let errors = xhr.responseJSON.errors;
                      let errorMessages = Object.values(errors).map(error => error[0]).join("\n");

                      Swal.fire({
                          icon: 'error',
                          title: 'Gagal!',
                          text: errorMessages,
                      });
                  } else {
                      Swal.fire({
                          icon: 'error',
                          title: 'Gagal!',
                          text: 'Error occurred. Please try again.',
                      });
                  }
              }
          });
        });



      $('#forgotPasswordBtn').on('click', function(e) {
        e.preventDefault();
        let adminPhoneNumber = '6281234567890'; // Ganti dengan nomor WhatsApp admin
        let message = encodeURIComponent("Halo Admin, saya mengalami kendala dalam mengakses akun saya karena lupa password. Mohon bantuan untuk proses reset password. Terima kasih.");
        let waLink = `https://wa.me/${adminPhoneNumber}?text=${message}`;

        window.open(waLink, '_blank');
      });

      //close modal
      $('#closeResetPasswordModal').on('click', function () {
        //kosongkan value 
        $('#oldPassword').val('');
        $('#newPassword').val('');
        $('#confirmPassword').val('');
        $('#resetPasswordModal').modal('hide');
      });




      document.querySelectorAll(".toggle-password").forEach(button => {
          button.addEventListener("click", function() {
              const targetId = this.getAttribute("data-target");
              const input = document.getElementById(targetId);
              const icon = this.querySelector("i");

              if (input.type === "password") {
                  input.type = "text";
                  icon.classList.replace("fa-eye", "fa-eye-slash");
              } else {
                  input.type = "password";
                  icon.classList.replace("fa-eye-slash", "fa-eye");
              }
          });
      });

    });
  </script>
@endsection
