<!--begin::Modal Create-->
<div class="modal fade" id="createModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success white">
                <h5 class="modal-title text-white">Tambah Data Barang</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form action="{{ route('asset.store') }}" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <h5>Pemasok Barang <span class="text-danger">*</span></h5>
                        <select name="supplier_id" id="supplier_id" class="form-control">
                            <option value="">-- Pilih Pemasok --</option>
                            @foreach ($allSupplierNames as $supplier)
                                <option value="{{ $supplier->id }}"
                                    {{ request('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                    {{ $supplier->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <h5>Nama Barang <span class="text-danger">*</span></h5>
                        <input type="text" class="form-control" name="product_name" maxlength="250" minlength="3"
                            placeholder="Masukkan nama barang" required>
                    </div>

                    <div class="form-group">
                        <h5>Merk Barang <span class="text-danger">*</span></h5>
                        <input type="text" class="form-control" name="brand_name" maxlength="250" minlength="3"
                            placeholder="Masukkan merk barang" required>
                    </div>

                    <div class="form-group">
                        <h5>Gambar <span class="text-danger">*</span></h5>
                        <input type="file" id="input-users-picture" name="thumbnail" class="form-control-file"
                            data-show-upload="false" data-show-caption="true" data-show-preview="true" accept="image/*"
                            data-allowed-file-extensions='["jpg", "jpeg", "png"]'>
                    </div>

                    <div class="form-group">
                        <h5>Jumlah Stok <span class="text-danger">*</span></h5>
                        <input type="number" class="form-control" name="quantity" maxlength="250" minlength="3"
                            placeholder="Masukkan jumlah stok barang" required>
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
