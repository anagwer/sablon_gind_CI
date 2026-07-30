        </div><!-- /admin-main-content -->
        
        <footer class="bg-white border-top py-3 px-4 mt-auto w-100">
            <div class="d-flex justify-content-between align-items-center small text-muted">
                <span>&copy; <?= date('Y'); ?> <strong>Gind Screen Printing</strong> - Sistem Informasi Manajemen Produksi Sablon.</span>
                <span class="d-none d-sm-inline">CodeIgniter 3 + MySQL + DataTables</span>
            </div>
        </footer>
    </div><!-- /page-content-wrapper -->
</div><!-- /wrapper -->

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Bootstrap 5 JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS & Bootstrap 5 Integration -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<!-- Sidebar Toggle & DataTables Automatic Initialization Script -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const sidebarToggle = document.getElementById("sidebarToggle");
    const wrapper = document.getElementById("wrapper");

    if (sidebarToggle && wrapper) {
        sidebarToggle.addEventListener("click", function(e) {
            e.preventDefault();
            wrapper.classList.toggle("toggled");
        });
    }

    // Inisialisasi DataTables otomatis pada semua tabel admin/owner
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
