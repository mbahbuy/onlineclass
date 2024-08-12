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
                        <th scope="row">Nama kelas</th>
                        <th scope="row">Deskripsi</th>
                        <th scope="row">Harga</th>
                        <th scope="row">Hari mulai</th>
                        <th scope="row">Hari berakhir</th>
                        <th scope="row">waktu mulai</th>
                        <th scope="row">waktu berakhir</th>
                        <th scope="row" >Action</th>
                      </tr>
                    </thead>
                    <tbody id="table-data"></tbody>
                  </table>
                </div>
                <!-- end card-body-->
                <div class="card-footer clearfix">
                  <ul class="pagination" id="pagination-data"></ul>
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
        const dayNames = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];

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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        fetchData(function (e) {            
            processData(e);
            generateData();
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
                            if ($.inArray(inputFocus.val(), uniqueName) !== -1) {
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
    
                    // case 'day-start':
                    // case 'day-end':
                    //     if (inpDayStart.val() === inpDayEnd.val()) {
                    //         feedbackDiv.html('Hari mulai dan berakhir tidak boleh sama.');
                    //         return false;
                    //     }
                    //     break;
    
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

        $('#table-data').on('click', 'button.button-edit,button.button-delete', function (){
          let clickedButton = $(this);

          let dID = clickedButton.attr('data-id');
          let dName = clickedButton.attr('data-name');
          let dDeskription = clickedButton.attr('data-description');
          let dHarga = clickedButton.attr('data-harga');
          let dDayStart = clickedButton.attr('data-day-start');
          let dDayEnd = clickedButton.attr('data-day-end');
          let dTimeStart = clickedButton.attr('data-time-start');
          let dTimeEnd = clickedButton.attr('data-time-end');
          if (clickedButton.hasClass('button-edit')) {
            btnSimpan.attr('data-simpan', 'update');
            btnSimpan.attr('data-id', dID);
            inpName.val(dName);
            inpHarga.val(dHarga);
            inpHargaNum.val(dHarga);
            inpDeskripsi.val(dDeskription);
            inpDayStart.val(dDayStart);
            inpDayEnd.val(dDayEnd);
            inpTimeStart.val(dTimeStart);
            inpTimeEnd.val(dTimeEnd);
            inpName.attr('data-value', dName);
            inpHargaNum.attr('data-value', dHarga);
            inpDeskripsi.attr('data-value', dDeskription);
            inpDayStart.attr('data-value', dDayStart);
            inpDayEnd.attr('data-value', dDayEnd);
            inpTimeStart.attr('data-value', dTimeStart);
            inpTimeEnd.attr('data-value', dTimeEnd);
            if (inputDiv.hasClass('d-none')) {toggleHide()}
          } else if(clickedButton.hasClass('button-delete')){

            if (confirm(`Tetap ingin menghapus Kelas(${dName})???`)) {              
              $.ajax({
                  url: `{{ route('class') }}/${dID}/delete`,
                  type: "POST",
                  method: 'DELETE',
                  contentType: false,
                  processData: false,
                  success: function (response) {
                    makeToast(response.bg, response.message);
                    
                    if (response.bg == 'bg-success') {
                      fetchData(e => {processData(e); generateData();});
                    }
                  },
                  error: function (error) {
                      console.error("Error:", error);
                  }
              });
            }
          }
        });

        $('#cari-nama').on('input', function(){
          let value = $(this).val();
          $(this).attr('data-search', value);
          generateData(1, value);
        });

        $('#pagination-data').on('click', 'a.page-link', function () {
            let clickedButton = $(this);
            let search = $('#cari-nama').attr('data-search');
            let page = clickedButton.attr('data-page');
            generateData(page, search);
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

    function fetchData(callback) {
        $.ajax({
            url: "{{ route('class.json') }}",
            type: 'POST',
            dataType: 'JSON',
            success: function(response) {
                callback(response);
                
            },
            error: function(xhr, status, error) {
                makeToast('bg-danger', `Error: ${error}`);
            }
        });
    }

    function processData(response) {
        dataJson.length = 0;
        for (let i = 0; i < response.length; i++) {
            // Helper functions to format time
            const formatTime = (time) => {
                let [Hr, Mn, Sc] = time.split(':');
                return Hr + ':' + Mn;
            };

            dataJson.push({
                id: response[i].id,
                nama: response[i].title,
                description: response[i].description,
                harga: response[i].harga,
                dayStart: response[i].day_start,
                dayEnd: response[i].day_end,
                timeStart: formatTime(response[i].time_start),
                timeEnd: formatTime(response[i].time_end),
            });

            uniqueName.push(response[i].title);
        }
    }

    function generateData(page = 1, search = null) {
      let dataPerPage = 10;
      let startIndex = (page - 1) * dataPerPage;
      let endIndex = startIndex + dataPerPage;
      let tableData = $('#table-data');
      tableData.empty();
      
      let data = dataJson;
      if (search) {
          data = data.filter(function (item) {
              return item.nama.toLowerCase().includes(search.toLowerCase());
          });
      }

      if (data.length === 0) {
          tableData.append('<tr><td colspan="9" class="text-center">Kelas not found</td></tr>');
          return;
      }

      for (let i = startIndex; i < endIndex && i < data.length; i++) {
          let row = `
              <tr>
                  <td class="align-middle text-center" style="width: 50px;">${i + 1}</td>
                  <td class="align-middle">${data[i].nama}</td>
                  <td class="align-middle">${data[i].description}</td>
                  <td class="align-middle">${formatRupiah(data[i].harga)}</td>
                  <td class="align-middle">${dayNames[data[i].dayStart]}</td>
                  <td class="align-middle">${dayNames[data[i].dayEnd]}</td>
                  <td class="align-middle">${indonesianTime(data[i].timeStart)}</td>
                  <td class="align-middle">${indonesianTime(data[i].timeEnd)}</td>
                  <td class="align-middle text-center">
                    <button type="button" class="btn btn-outline-warning button-edit" title="edit" data-name="${data[i].nama}" data-description="${data[i].description}" data-harga="${data[i].harga}" data-day-start="${data[i].dayStart}" data-day-end="${data[i].dayEnd}" data-time-start="${data[i].timeStart}" data-time-end="${data[i].timeEnd}" data-id="${data[i].id}">
                      <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger button-delete" data-name="${data[i].nama}" data-description="${data[i].description}" data-harga="${data[i].harga}" data-day-start="${data[i].dayStart}" data-day-end="${data[i].dayEnd}" data-time-start="${data[i].timeStart}" data-time-end="${data[i].timeEnd}" data-id="${data[i].id}" title="delete">
                        <i class="fas fa-trash"></i>
                    </button>
                  </td>
              </tr>
          `;
          tableData.append(row);
        }
        let totalPages = Math.ceil(data.length / dataPerPage);
        generatePagerPagination(totalPages, page);
    }

    // function generate pagination page 
    function generatePagerPagination(totalPages = 1, page = 1){

      let $pagination = $('#pagination-data');
      $pagination.empty();

      let startPagination = 1;
      let endPagination = totalPages;


      if (totalPages > 10) {
        if (page <= 6) {
          startPagination = 1;
          endPagination = 10;
        } else if (page >= totalPages - 5) {
          startPagination = totalPages - 9;
          endPagination = totalPages;
        } else {
          startPagination = page - 5;
          endPagination = parseInt(page) + 4;
        }
      }

      for (let i = startPagination; i <= endPagination; i++) {
          $pagination.append(`<li class="page-item ${i == page ? 'active' : ''}"><a class="page-link" href="javascript:void(0)" data-page="${i}">${i}</a></li>`);
      }
    }

    function indonesianTime(data) {
        var [hours, minutes] = data.split(':');
        return hours + '.' + minutes + ' WIB';
    }

</script>
@endsection