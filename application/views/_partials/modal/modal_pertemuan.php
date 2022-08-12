<div class="modal modal-blur fade" id="addPertemuan" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Pertemuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="user" id="formAddPertemuan">
                    <input type="hidden" name="id_program" class="form required" value="<?= $id_program?>">
                    <div class="form-floating mb-3">
                        <input type="text" name="nama_pertemuan" class="form form-control form-control-sm required">
                        <label class="col-form-label">Nama Pertemuan</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" name="tgl_pembuatan" class="form form-control form-control-sm required">
                        <label class="col-form-label">Tgl Pembuatan</label>
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

<div class="modal modal-blur fade" id="detailPertemuan" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Pertemuan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="user" id="formEditPertemuan">
                    <input type="hidden" name="id_pertemuan" class="form required">
                    <div class="form-floating mb-3">
                        <select name="hapus" class="form form-control form-control-sm required">
                            <option value="">Pilih Status</option>
                            <option value="0">Aktif</option>
                            <option value="1">Nonaktif</option>
                        </select>
                        <label class="col-form-label">Status</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="text" name="nama_pertemuan" class="form form-control form-control-sm required">
                        <label class="col-form-label">Nama Pertemuan</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="date" name="tgl_pembuatan" class="form form-control form-control-sm required">
                        <label class="col-form-label">Tgl Pembuatan</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn me-3" data-bs-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success btnEdit">Ubah</button>
                </div>
            </div>
        </div>
    </div>
</div>