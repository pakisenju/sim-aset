<!--begin::Modal Edit-->
<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning white">
                <h5 class="modal-title text-white">Edit Data Supplier</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit_id" value="">

                    <div class="form-group">
                        <h5>Nama Supplier <span class="text-danger">*</span></h5>
                        <input type="text" class="form-control" name="name" id="supplierName" maxlength="250" minlength="3"
                            placeholder="Masukkan nama supplier" required>
                    </div>

                    <div class="form-group">
                        <h5>Email <span class="text-danger">*</span></h5>
                        <input type="email" class="form-control" name="email" id="supplierEmail" maxlength="250" minlength="3"
                            placeholder="Masukkan email" required>
                    </div>

                    <div class="form-group">
                        <h5>Username <span class="text-danger">*</span></h5>
                        <input type="text" class="form-control" name="username" id="supplierUsername" maxlength="250" minlength="6"
                            placeholder="Masukkan username" required>
                    </div>

                    <div class="form-group">
                        <h5>Password <span class="text-danger">*</span></h5>
                        <input type="password" class="form-control" name="password" maxlength="250" minlength="8"
                            placeholder="Masukkan password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-outline-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal Edit-->
