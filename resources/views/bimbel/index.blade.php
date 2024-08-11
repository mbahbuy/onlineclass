@extends('dashboard.app')

@section('styles')
    
@endsection

@section('content')    
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="page-title">
                        Kelas
                    </h1>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <content class="content">
        <!-- Start Content-->
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="row">
                        <div class="col-6">
                          <button type="button" id="btn-tambah" class="btn btn-success">Tambah</button>
                          <button type="button" id="btn-simpan" data-simpan="new" data-id="" class="btn btn-success d-none" disabled>Simpan</button>
                          <button type="button" id="btn-batal" class="btn btn-secondary d-none">Batal</button>
                        </div>
                        <div class="col-6">
                            <input type="text" class="form-control form-control-border" id="cari-nama" placeholder="cari kelas">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 d-none mt-3" id="input-section">
                      <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                            <label for="u-name">Nama</label>
                            <input type="text" id="name" name="name" class="form-control" data-value="" placeholder="like: Matematika Estetika">
                            <div class="invalid-feedback d-none">
                              Nama harus unique(tidak boleh sama dengan yang lain).
                            </div>
                          </div>
                        </div>
                        <div class="col-6">
                          <div class="form-group">
                            <label for="harga">Harga</label>
                            <input id="harga" type="text" class="form-control"/>
                            <input type="hidden" name="inpharga" id="inpharga" value="">
                            <div class="invalid-feedback d-none">
                              invalid Harga.
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi</label>
                                <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3"></textarea>
                                <div class="invalid-feedback d-none">
                                    invalid.
                                  </div>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="day-start">Hari mulai</label>
                                <select name="day-start" id="day-start" class="form-control">
                                    <option value="0" selected>Minggu</option>
                                    <option value="1">Senin</option>
                                    <option value="2">Selasa</option>
                                    <option value="3">Rabu</option>
                                    <option value="4">Kamis</option>
                                    <option value="5">Jumat</option>
                                    <option value="6">Sabtu</option>                            
                                </select>
                                <div class="invalid-feedback d-none">
                                    invalid.
                                  </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="day-end">Hari berakhir</label>
                                <select name="day-end" id="day-end" class="form-control">
                                    <option value="0" selected>Minggu</option>
                                    <option value="1">Senin</option>
                                    <option value="2">Selasa</option>
                                    <option value="3">Rabu</option>
                                    <option value="4">Kamis</option>
                                    <option value="5">Jumat</option>
                                    <option value="6">Sabtu</option>                            
                                </select>
                                <div class="invalid-feedback d-none">
                                    invalid.
                                  </div>
                            </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="time-start">Waktu mulai</label>
                                <input type="time" name="time-start" id="time-start" class="form-control">
                                <div class="invalid-feedback d-none">
                                    invalid.
                                  </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="time-end">Waktu berakhir</label>
                                <input type="time" name="time-end" id="time-end" class="form-control">
                                <div class="invalid-feedback d-none">
                                    invalid.
                                  </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th scope="row">#</th>
                        <th scope="row">Nama</th>
                        <th scope="row">Email</th>
                        <th scope="row">Role</th>
                        <th scope="row" >Action</th>
                      </tr>
                    </thead>
                    <tbody id="users-table"></tbody>
                  </table>
                </div>
                <!-- end card-body-->
                <div class="card-footer clearfix">
                  <ul class="pagination" id="pagination-users"></ul>
                </div>
              </div>
              <!-- end card-->
            </div>
            <!-- end col -->
          </div>
          <!-- end row -->
        </div>
        <!-- container -->
      </content>
      <!-- content -->

    </div>
    <!-- /.content-wrapper -->
@endsection


@section('script')
<script>
        // data json
        const uniqueName = [];
        const dataJson = [];

      // group button
        const btnTambah = $('#btn-tambah');
        const btnSimpan = $('#btn-simpan');
        const btnBatal = $('#btn-batal');

        // group input
        const inputDiv = $('#input-section');
        const inpName = $('#name');
        const inpHarga = $('#harga');
        const inpHargaNum = $('#inpharga');
        const inpDeskripsi = $('#deskripsi');
        const inpDayStart = $('#day-start');
        const inpDayEnd = $('#day-end');
        const inpTimeStart = $('#time-start');
        const inpTimeEnd = $('#time-end');

    $(function () {
        // Set up CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        btnTambah.on('click', function(){
          toggleHide();
          btnSimpan.prop('disabled', true);
          btnSimpan.attr('data-simpan', 'new');
          btnSimpan.attr('data-id', '');
          inpName.val('');
          inpHarga.val('');
          inpHargaNum.val('');
          inpDeskripsi.val('');
          inpDayStart.val('');
          inpDayEnd.val('');
          inpTimeStart.val('');
          inpTimeEnd.val('');
          inpName.attr('data-value', '');
          inpHargaNum.attr('data-value', '');
          inpDeskripsi.attr('data-value', '');
          inpDayStart.attr('data-value', '');
          inpDayEnd.attr('data-value', '');
          inpTimeStart.attr('data-value', '');
          inpTimeEnd.attr('data-value', '');
        });
        
        btnBatal.on('click', function(){
            toggleHide();
          btnSimpan.prop('disabled', true);
          btnSimpan.attr('data-simpan', 'new');
          btnSimpan.attr('data-id', '');
          inpName.val('');
          inpHarga.val('');
          inpHargaNum.val('');
          inpDeskripsi.val('');
          inpDayStart.val('');
          inpDayEnd.val('');
          inpTimeStart.val('');
          inpTimeEnd.val('');
          inpName.attr('data-value', '');
          inpHargaNum.attr('data-value', '');
          inpDeskripsi.attr('data-value', '');
          inpDayStart.attr('data-value', '');
          inpDayEnd.attr('data-value', '');
          inpTimeStart.attr('data-value', '');
          inpTimeEnd.attr('data-value', '');
        });

        $('.form-control').on('input', function() {
            let inputFocus = $(this);
            let nameInput = inputFocus.attr('name');
            let oldInput = inputFocus.attr('data-value');
            let feedbackDiv = inputFocus.parent().find('.invalid-feedback');
            let typeSimpan = btnSimpan.attr('data-simpan');
    
            // Harga field formatting and number extraction
            if (inputFocus.attr('id') === 'harga') {
                let sanitized = inputFocus.val().replace(/[^0-9]/g, ''); // Remove non-numeric characters
                let number = parseInt(sanitized, 10) || 0; // Convert to number, default to 0 if NaN
                inputFocus.val(formatRupiah(number)); // Format as Rupiah
                $('#inpharga').val(number); // Set hidden input with numeric value
            }
    
            // Define validation rules for each input
            const validateInput = () => {
                switch (nameInput) {
                    case 'name':
                        if (inputFocus.val() !== oldInput) {                
                            if ($.inArray(inputFocus.val(), name) !== -1) {
                                feedbackDiv.html('Nama harus unique(tidak boleh sama dengan yang lain atau masukkan nama lama).');
                                return false;
                            }
                        }
                        break;
    
                    case 'inpharga':
                        if (!/^\d+$/.test($('#inpharga').val()) || $('#inpharga').val() <= 0) { // Check for valid number and non-zero
                            feedbackDiv.html('Invalid Harga.');
                            return false;
                        }
                        break;
    
                    case 'deskripsi':
                        if (inpDeskripsi.val().trim() === "") {
                            feedbackDiv.html('Deskripsi tidak boleh kosong.');
                            return false;
                        }
                        break;
    
                    case 'day-start':
                    case 'day-end':
                        if (inpDayStart.val() === inpDayEnd.val()) {
                            feedbackDiv.html('Hari mulai dan berakhir tidak boleh sama.');
                            return false;
                        }
                        break;
    
                    case 'time-start':
                    case 'time-end':
                        if (inpTimeStart.val() === inpTimeEnd.val()) {
                            feedbackDiv.html('Waktu mulai dan berakhir tidak boleh sama.');
                            return false;
                        }
                        break;
    
                    default:
                        break;
                }
                return true;
            };
    
            const isValid = validateInput();
            inputFocus.toggleClass('is-invalid', !isValid);
            feedbackDiv.toggleClass('d-none', isValid);
    
            btnSimpan.prop('disabled', !(
                inpName.val() && !inpName.hasClass('is-invalid') &&
                $('#inpharga').val() && !$('#inpharga').hasClass('is-invalid') &&
                inpDeskripsi.val() && !inpDeskripsi.hasClass('is-invalid') &&
                inpDayStart.val() && !inpDayStart.hasClass('is-invalid') &&
                inpDayEnd.val() && !inpDayEnd.hasClass('is-invalid') &&
                inpTimeStart.val() && !inpTimeStart.hasClass('is-invalid') &&
                inpTimeEnd.val() && !inpTimeEnd.hasClass('is-invalid')
            ));
        });

        btnSimpan.on('click', function () {
            let typeSimpan = $(this).attr('data-simpan');
            let dataID = $(this).attr('data-id');
            let formData = new FormData();
            let urlSimpan = '{{ route('class.store') }}';

            formData.append('name', inpName.val());
            formData.append('harga', inpHargaNum.val());
            formData.append('deskripsi', inpDeskripsi.val());
            formData.append('day_start', inpDayStart.val());
            formData.append('day_end', inpDayEnd.val());
            formData.append('time_start', inpTimeStart.val());
            formData.append('time_end', inpTimeEnd.val());

            if (typeSimpan === 'update') {
                urlSimpan = `{{ route('class') }}/${dataID}/update`;
                formData.append('_method', 'PUT');
            }

            $.ajax({
                url: urlSimpan,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    makeToast(response.bg, response.message);
                    if (response.bg === 'bg-success') {
                        fetchData(function (e) {
                            processData(e);
                            generateData();
                        });
                        btnBatal.click();
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 400 && xhr.responseJSON && xhr.responseJSON.message) {
                        makeToast('bg-danger', xhr.responseJSON.message);
                    } else {
                        console.error("Error:", xhr);
                    }
                }
            });
        });
    });

    function toggleHide()
    {
        btnTambah.toggleClass('d-none');
        btnSimpan.toggleClass('d-none');
        btnBatal.toggleClass('d-none');
        inputDiv.toggleClass('d-none');
    }

    // Function untuk format ke Rupiah
    function formatRupiah(angka) {
        var reverse = angka.toString().split('').reverse().join('');
        var ribuan = reverse.match(/\d{1,3}/g);
        var formatted = ribuan.join('.').split('').reverse().join('');
        return 'Rp ' + formatted;
    }

</script>
@endsection