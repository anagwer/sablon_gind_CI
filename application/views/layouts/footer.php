    </div><!-- /container -->
</div><!-- /main-content -->

<!-- Footer -->
<footer class="bg-dark text-white py-4 mt-auto">
    <div class="container">
        <div class="row gy-3 align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <div class="d-flex align-items-center justify-content-center justify-content-md-start mb-2">
                    <img src="<?= base_url('assets/images/gind_logo.png'); ?>" alt="Gind Logo" height="30" class="me-2" onerror="this.style.display='none'">
                    <span class="fw-bold text-white fs-5">GIND SCREEN PRINTING</span>
                </div>
                <p class="text-secondary small mb-0">Sistem Informasi Manajemen Produksi Sablon Berbasis Web. Menyediakan layanan cetak sablon kaos custom dengan pemantauan alur produksi real-time.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <p class="text-secondary small mb-1"><i class="fas fa-map-marker-alt text-danger me-1"></i> Jl. Screen Printing No. 88, Magelang, Jawa Tengah</p>
                <p class="text-secondary small mb-2"><i class="fab fa-whatsapp text-success me-1"></i> 0812-3456-7890 | <i class="fas fa-envelope text-warning me-1"></i> info@gindscreenprinting.com</p>
                <small class="text-muted">&copy; <?= date('Y'); ?> Gind Screen Printing. All rights reserved.</small>
            </div>
        </div>
    </div>
</footer>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS & Bootstrap 5 Integration -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    if (window.jQuery && $.fn.DataTable) {
        $('table.table').not('.table-borderless, .no-datatable').each(function() {
            if (!$.fn.DataTable.isDataTable(this)) {
                $(this).DataTable({
                    "language": {
                        "sProcessing":   "Sedang memproses...",
                        "sLengthMenu":   "Tampilkan _MENU_ entri",
                        "sZeroRecords":  "Tidak ditemukan data yang sesuai",
                        "sInfo":         "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                        "sInfoEmpty":    "Menampilkan 0 sampai 0 dari 0 entri",
                        "sInfoFiltered": "(disaring dari _MAX_ entri keseluruhan)",
                        "sSearch":       "Cari:",
                        "oPaginate": {
                            "sFirst":    "Pertama",
                            "sPrevious": "Sebelumnya",
                            "sNext":     "Selanjutnya",
                            "sLast":     "Terakhir"
                        }
                    },
                    "pageLength": 10,
                    "responsive": true,
                    "autoWidth": false
                });
            }
        });
    }
});
</script>
</body>
</html>
