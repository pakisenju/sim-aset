<!--begin::Modal Restock-->
<div class="modal fade" id="restockModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning white">
                <h5 class="modal-title text-white">Restock Data Barang</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">&times;</button>
            </div>
            <form id="restockForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    @csrf
                    @method('PUT')

                    <input type="hidden" name="id" id="edit_id" value="">

                    <div class="form-group">
                        <h5>Stok saat ini</h5>
                        <input type="number" class="form-control" id="prevQuantity" disabled>
                    </div>

                    <div class="form-group">
                        <h5>Jumlah Stok</h5>
                        <input type="number" class="form-control" id="quantity" name="quantity" min="1" placeholder="Masukkan jumlah stok barang" required>
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
<!--end::Modal Restock-->
