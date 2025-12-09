  <!-- Begin Page Content -->
  <div class="container-fluid">

      <!-- Page Heading -->
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
          <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
          <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                  class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
      </div>

      <!-- Content Row -->
      <div class="row">

          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                  <div class="card-body">
                      <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                  Jumlah Pengajuan</div>
                              <div class="h5 mb-0 font-weight-bold text-gray-800">$40,000</div>
                          </div>
                          <div class="col-auto">
                              <i class="fas fa-clipboard fa-2x text-gray-300"></i>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                  <div class="card-body">
                      <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                  Dokumen NIB</div>
                              <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                          </div>
                          <div class="col-auto">
                              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                  <div class="card-body">
                      <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks
                              </div>
                              <div class="row no-gutters align-items-center">
                                  <div class="col-auto">
                                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">50%</div>
                                  </div>
                                  <div class="col">
                                      <div class="progress progress-sm mr-2">
                                          <div class="progress-bar bg-info" role="progressbar"
                                              style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                              aria-valuemax="100"></div>
                                      </div>
                                  </div>
                              </div>
                          </div>
                          <div class="col-auto">
                              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                          </div>
                      </div>
                  </div>
              </div>
          </div>

          <!-- Pending Requests Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                  <div class="card-body">
                      <div class="row no-gutters align-items-center">
                          <div class="col mr-2">
                              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                  Pending Requests</div>
                              <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                          </div>
                          <div class="col-auto">
                              <i class="fas fa-comments fa-2x text-gray-300"></i>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>


      <!-- Modal Lengkapi Data Perusahaan -->
      <div class="modal fade" id="perusahaanModal" tabindex="-1" role="dialog" aria-labelledby="perusahaanModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header bg-warning text-white">
                      <h5 class="modal-title" id="perusahaanModalLabel">
                          <i class="fas fa-building me-2"></i>Lengkapi Data Perusahaan
                      </h5>
                      <!-- <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button> -->
                  </div>
                  <div class="modal-body">
                      <div class="alert alert-info">
                          <i class="fas fa-info-circle me-2"></i>
                          Data perusahaan Anda belum lengkap. Silakan lengkapi informasi untuk melanjutkan.
                      </div>
                  </div>
                  <div class="modal-footer">
                      <!-- <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Nanti Saja</button> -->
                      <a href="index.php?page=dataperusahaan" class="btn btn-primary">Lengkapi Data</a>
                  </div>
              </div>
          </div>
      </div>

      <!-- Modal Lengkapi Data Gudang -->
      <div class="modal fade" id="gudangModal" tabindex="-1" role="dialog" aria-labelledby="gudangModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                  <div class="modal-header bg-warning text-white">
                      <h5 class="modal-title" id="gudangModalLabel">
                          <i class="fas fa-warehouse me-2"></i>Lengkapi Data Gudang
                      </h5>
                      <!-- <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                      </button> -->
                  </div>
                  <div class="modal-body">
                      <div class="alert alert-info">
                          <i class="fas fa-info-circle me-2"></i>
                          Data gudang Anda belum lengkap. Silakan lengkapi informasi gudang untuk melanjutkan.
                      </div>
                  </div>
                  <div class="modal-footer">
                      <!-- <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Nanti Saja</button> -->
                      <a href="index.php?page=datagudang" class="btn btn-primary">Lengkapi Data</a>
                  </div>
              </div>
          </div>
      </div>


      <script>
          $(document).ready(function() {
              // Debug: Tampilkan nilai PHP variables
              console.log('PHP Variables from data attributes:', {
                  perusahaan: $('#modalData').data('need-perusahaan'),
                  gudang: $('#modalData').data('need-gudang')
              });

              console.log('PHP Variables from JS vars:', {
                  perusahaan: typeof needCompletePerusahaan !== 'undefined' ? needCompletePerusahaan : 'undefined',
                  gudang: typeof needCompleteGudang !== 'undefined' ? needCompleteGudang : 'undefined'
              });

              // Method 1: Ambil dari data attributes (lebih reliable)
              const modalData = $('#modalData');
              const needPerusahaanFromAttr = modalData.data('need-perusahaan') === true || modalData.data('need-perusahaan') === 'true';
              const needGudangFromAttr = modalData.data('need-gudang') === true || modalData.data('need-gudang') === 'true';

              console.log('From Attributes:', {
                  perusahaan: needPerusahaanFromAttr,
                  gudang: needGudangFromAttr
              });

              // Method 2: Ambil dari JS variables (jika ada)
              const needPerusahaanFromJS = typeof needCompletePerusahaan !== 'undefined' ? needCompletePerusahaan : false;
              const needGudangFromJS = typeof needCompleteGudang !== 'undefined' ? needCompleteGudang : false;

              console.log('From JS Variables:', {
                  perusahaan: needPerusahaanFromJS,
                  gudang: needGudangFromJS
              });

              // Gabungkan kedua method
              const showPerusahaanModal = needPerusahaanFromAttr || needPerusahaanFromJS;
              const showGudangModal = needGudangFromAttr || needGudangFromJS;

              console.log('Final Decision:', {
                  perusahaan: showPerusahaanModal,
                  gudang: showGudangModal
              });

              // Cek dari sessionStorage (setelah login)
              const fromSessionPerusahaan = sessionStorage.getItem('showPerusahaanModal') === 'true';
              const fromSessionGudang = sessionStorage.getItem('showGudangModal') === 'true';

              console.log('From Session Storage:', {
                  perusahaan: fromSessionPerusahaan,
                  gudang: fromSessionGudang
              });

              // Hapus sessionStorage setelah dicek
              sessionStorage.removeItem('showPerusahaanModal');
              sessionStorage.removeItem('showGudangModal');

              // Tampilkan modal berdasarkan priority (Perusahaan dulu, baru Gudang)
              if (showPerusahaanModal || fromSessionPerusahaan) {
                  console.log('Menampilkan modal perusahaan');
                  $('#perusahaanModal').modal({
                      backdrop: 'static',
                      keyboard: false
                  });
                  $('#perusahaanModal').modal('show');
              } else if (showGudangModal || fromSessionGudang) {
                  console.log('Menampilkan modal gudang');
                  $('#gudangModal').modal({
                      backdrop: 'static',
                      keyboard: false
                  });
                  $('#gudangModal').modal('show');
              } else {
                  console.log('Tidak ada modal yang perlu ditampilkan');
              }
          });
      </script>