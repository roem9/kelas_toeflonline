<div class="modal modal-blur fade" id="addUser" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="user" id="formAddUser">
                    <div class="form-floating mb-3">
                        <input type="text" name="nama" class="form form-control form-control-sm required">
                        <label class="col-form-label">Nama User</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="username" class="form form-control form-control-sm required">
                        <label class="col-form-label">Username</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="password" class="form form-control form-control-sm required">
                        <label class="col-form-label">Password</label>
                    </div>
                    <div class="form-floating mb-3">
                        <select name="level" class="form form-control form-control-sm required">
                            <option value="">Pilih Level</option>
                            <option value="Kasir">Kasir</option>
                            <option value="Gudang">Gudang</option>
                            <option value="Super Admin">Super Admin</option>
                        </select>
                        <label class="col-form-label">Level</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn me-3" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btnTambah">Tambah</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="detailUser" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="id_admin" class="form required">
                <div class="form-floating mb-3">
                    <select name="hapus" class="form form-control form-control-sm required">
                        <option value="">Pilih Status</option>
                        <option value="0">Aktif</option>
                        <option value="1">Nonaktif</option>
                    </select>
                    <label class="col-form-label">Status</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="nama" class="form form-control form-control-sm required">
                    <label class="col-form-label">Nama User</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="username" class="form form-control form-control-sm required">
                    <label class="col-form-label">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="text" name="password" class="form form-control form-control-sm">
                    <label class="col-form-label">Password</label>
                </div>
                <div class="form-floating mb-3">
                    <select name="level" class="form form-control form-control-sm required">
                        <option value="">Pilih Level</option>
                        <option value="Kasir">Kasir</option>
                        <option value="Gudang">Gudang</option>
                        <option value="Super Admin">Super Admin</option>
                    </select>
                    <label class="col-form-label">Level</label>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn me-3" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary btnEdit">Edit</button>
                </div>
            </div>
        </div>
    </div>
</div>