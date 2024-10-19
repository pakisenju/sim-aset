<!--begin::Modal Create-->
<div class="modal fade" id="createModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success white">
                <h5 class="modal-title text-white">Pengajuan Restock</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form id="requestForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <h5>Pilih Barang <span class="text-danger">*</span></h5>
                        <select name="assets_id" id="assets_id" class="form-control" required>
                            <option value="">-- Pilih Barang --</option>
                            @foreach ($assets as $asset)
                                <option value="{{ $asset->id }}">{{ $asset->product_name }} -
                                    {{ $asset->brand_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <h5>Deskripsi <span class="text-danger">*</span></h5>
                        <textarea class="form-control" name="description" rows="3" placeholder="Masukkan deskripsi pengajuan" required></textarea>
                    </div>

                    <div class="form-group">
                        <h5>Gambar Bukti <span class="text-danger">*</span></h5>
                        <input type="file" name="evidance" class="form-control-file" accept="image/*" required>
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
