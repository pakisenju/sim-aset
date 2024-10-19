<!--begin::Modal Edit-->
<div class="modal fade" id="editModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning white">
                <h5 class="modal-title text-white">Edit Data Barang</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form id="editForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit_id" value="">
                    <input type="hidden" name="supplier_id" id="supplierid" value="">

                    <div class="form-group">
                        <h5>Nama Barang</h5>
                        <input type="text" class="form-control" id="productName" name="product_name" maxlength="250"
                            minlength="3" placeholder="Masukkan nama barang" required>
                    </div>

                    <div class="form-group">
                        <h5>Merk Barang</h5>
                        <input type="text" class="form-control" id="brandName" name="brand_name" maxlength="250"
                            minlength="3" placeholder="Masukkan merk barang" required>
                    </div>

                    <div class="form-group">
                        <h5>Gambar</h5>
                        <img id="photoPreview" src="" alt="Thumbnail"
                            style="display: none; width: 150px; height: auto; margin-bottom: 10px;">
                        <input type="file" id="input-users-picture" id="thumbnail" name="thumbnail"
                            class="form-control-file" data-show-upload="false" data-show-caption="true"
                            data-show-preview="true" accept="image/*"
                            data-allowed-file-extensions='["jpg", "jpeg", "png"]'>
                    </div>

                    <div class="form-group">
                        <h5>Jumlah Stok</h5>
                        <input type="number" class="form-control" id="quantity" name="quantity" maxlength="250"
                            minlength="3" placeholder="Masukkan jumlah stok barang" required>
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
