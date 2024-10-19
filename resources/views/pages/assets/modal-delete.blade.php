<!--begin::Modal Delete-->
<div class="modal fade" id="deleteModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title text-white">Apa anda yakin ingin menghapus data ini?</h5>
                <button type="button" class="close text-white" data-dismiss="modal"
                    aria-label="Close">&times;</button>
            </div>
            <form id="deleteForm" method="POST">
                <div class="modal-footer">
                    @csrf
                    <button type="button" class="btn grey btn-outline-secondary"
                        data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-outline-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!--end::Modal Delete-->
