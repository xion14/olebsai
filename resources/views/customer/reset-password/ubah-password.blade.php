<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Ganti Kata Sandi</h1>
                <button type="button" class="btn-close close-modal-pw" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="customerLogin" class="w-100">
                    <div class="mb-3 position-relative">
                        <label for="old-password" class="mb-2 fw-semibold" style="font-size: 14px;">
                            Password Lama
                        </label>
                        <input type="password" class="form-control" name="old-password" id="old-password"
                            placeholder="Masukkan password lama" autocomplete="off" autofocus required>
                        <button id="showPasswordOld" type="button"
                            style="border: none; background-color: transparent; position: absolute; top: 82%; right: 4px; transform: translateY(-82%);">
                            <i class="fa-solid fa-eye-slash" style="font-size: 16px;"></i>
                        </button>
                        <button id="hidePasswordOld" type="button" class="d-none"
                            style="border: none; background-color: transparent; position: absolute; top: 82%; right: 4px; transform: translateY(-82%);">
                            <i class="fa-solid fa-eye" style="font-size: 16px;"></i>
                        </button>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="new-password" class="mb-2 fw-semibold" style="font-size: 14px;">
                            Password Baru
                        </label>
                        <input type="password" class="form-control" name="new-password" id="new-password"
                            placeholder="Masukkan password baru" autocomplete="off" required>
                        <button id="showPasswordNew" type="button"
                            style="border: none; background-color: transparent; position: absolute; top: 82%; right: 4px; transform: translateY(-82%);">
                            <i class="fa-solid fa-eye-slash" style="font-size: 16px;"></i>
                        </button>
                        <button id="hidePasswordNew" type="button" class="d-none"
                            style="border: none; background-color: transparent; position: absolute; top: 82%; right: 4px; transform: translateY(-82%);">
                            <i class="fa-solid fa-eye" style="font-size: 16px;"></i>
                        </button>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="confirm-password" class="mb-2 fw-semibold" style="font-size: 14px;">
                            Konfirmasi Password Baru
                        </label>
                        <input type="password"" class="form-control" name="confirm-password" id="confirm-password"
                            placeholder="Masukkan konfirmasi password" autocomplete="off" required>
                        <div class="invalid-feedback">
                            Kata sandi baru tidak sama
                        </div>
                        <button id="showPasswordConfirmNew" type="button"
                            style="border: none; background-color: transparent; position: absolute; top: 38px; right: 4px;">
                            <i class="fa-solid fa-eye-slash" style="font-size: 16px;"></i>
                        </button>
                        <button id="hidePasswordConfirmNew" type="button" class="d-none"
                            style="border: none; background-color: transparent; position: absolute; top: 38px; right: 4px;">
                            <i class="fa-solid fa-eye" style="font-size: 16px;"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close-modal-pw" data-bs-dismiss="modal">
                    Batal
                </button>
                <button id="btnChangePassword" type="submit" class="btn btn-primary">
                    Ubah Password
                </button>
            </div>
        </div>
    </div>
</div>
