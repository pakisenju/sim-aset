<!--begin::Modal Create-->
<div class="modal fade" id="createModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success white">
                <h5 class="modal-title text-white">Tambah Data Supplier</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="{{ route('supplier.store') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <h5>Nama Supplier <span class="text-danger">*</span></h5>
                        <input type="text" class="form-control" name="name" maxlength="250" minlength="3"
                            placeholder="Masukkan nama supplier" required>
                    </div>

                    <div class="form-group">
                        <h5>Email <span class="text-danger">*</span></h5>
                        <input type="email" class="form-control" name="email" maxlength="250" minlength="3"
                            placeholder="Masukkan email" required>
                    </div>

                    <div class="form-group">
                        <h5>Username <span class="text-danger">*</span></h5>
                        <input type="text" class="form-control" name="username" maxlength="250" minlength="3"
                            placeholder="Masukkan username" required>
                    </div>

                    <div class="form-group">
                        <h5>Password <span class="text-danger">*</span></h5>
                        <input type="password" class="form-control" name="password" maxlength="250" minlength="3"
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
<!--end::Modal Create-->
