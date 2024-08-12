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
                        <div class="col-4">
                          <select id="filter-data" class="form-control" data-filter="">
                            <option value="semua">Semua</option>
                            <option value="buyed">Terbeli</option>
                            <option value="notbuy">belum Terbeli</option>
                          </select>
                        </div>
                        <div class="col-8">
                          <div class="row">
                            <div class="col-6">
                              <input type="text" class="form-control form-control-border" id="cari-nama" placeholder="cari kelas" data-search="">
                            </div>
                            <div class="col-6">
                              <select id="cari-day" class="form-control" data-day="">
                                <option value="">Pilih hari</option>
                                <option value="0">Minggu</option>
                                <option value="1">Senin</option>
                                <option value="2">Selasa</option>
                                <option value="3">Rabu</option>
                                <option value="4">Kamis</option>
                                <option value="5">Jumat</option>
                                <option value="6">Sabtu</option>                            
                              </select>
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

        $('#table-data').on('click', 'button.button-buy, button.button-enter', function (){
          let clickedButton = $(this);

          let dID = clickedButton.attr('data-id');
          let dIDBuying = clickedButton.attr('data-buying-id');
          let dName = clickedButton.attr('data-name');
          let dDeskription = clickedButton.attr('data-description');
          let dHarga = clickedButton.attr('data-harga');
          let dDayStart = clickedButton.attr('data-day-start');
          let dDayEnd = clickedButton.attr('data-day-end');
          let dTimeStart = clickedButton.attr('data-time-start');
          let dTimeEnd = clickedButton.attr('data-time-end');
          if (clickedButton.hasClass('button-buy')) {
            if (confirm(`Tetap ingin membeli Kelas(${dName})???`)) {  
                let formData = new FormData();
                formData.append('bimbel_id', dID);            
              $.ajax({
                  url: `{{ route('kelas.store') }}`,
                  type: "POST",
                  data: {
                        bimbel_id: dID
                    },
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
          } else if(clickedButton.hasClass('button-enter')){
            window.location = `{{ route('kelas') }}/show/${dIDBuying}/${dID}`;
          }
        });

        $('#filter-data').on('change', function () {
          let value = $(this).val();
          $(this).attr('data-filter', value);
          let search = $('#cari-nama').attr('data-search');
          let day = $('#cari-day').attr('data-day');
          generateData(1, search, value, day);
        });

        $('#cari-nama').on('input', function(){
          let value = $(this).val();
          $(this).attr('data-search', value);
          let filter = $('#filter-data').attr('data-filter');
          let day = $('#cari-day').attr('data-day');
          generateData(1, value, filter, day);
        });
        
        $('#cari-day').on('change', function () { 
          let value = $(this).val();
          $(this).attr('data-day', value);
          let search = $('#cari-nama').attr('data-search');
          let filter = $('#filter-data').attr('data-filter');
          generateData(1, search, filter, value);
          
        });

        $('#pagination-data').on('click', 'a.page-link', function () {
            let clickedButton = $(this);
            let search = $('#cari-nama').attr('data-search');
            let filter = $('#filter-data').attr('data-filter');
            let day = $('#cari-day').attr('data-day');
            let page = clickedButton.attr('data-page');
            generateData(page, search, filter, day);
        });
    });

    // Function untuk format ke Rupiah
    function formatRupiah(angka) {
        var reverse = angka.toString().split('').reverse().join('');
        var ribuan = reverse.match(/\d{1,3}/g);
        var formatted = ribuan.join('.').split('').reverse().join('');
        return 'Rp ' + formatted;
    }

    function fetchData(callback) {
        $.ajax({
            url: "{{ route('kelas.json') }}",
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

            const processedBuyings = response[i].buyings.map(buying => {
                return {
                    id: buying.id,
                    userId: buying.user_id,
                    courseId: buying.course_id,
                };
            });

            dataJson.push({
                id: response[i].id,
                nama: response[i].title,
                description: response[i].description,
                harga: response[i].harga,
                dayStart: response[i].day_start,
                dayEnd: response[i].day_end,
                timeStart: formatTime(response[i].time_start),
                timeEnd: formatTime(response[i].time_end),
                buyings: processedBuyings,
            });

        }
    }

    function generateData(page = 1, search = null, filter = null, day = null) {
      let dataPerPage = 10;
      let startIndex = (page - 1) * dataPerPage;
      let endIndex = startIndex + dataPerPage;
      let tableData = $('#table-data');
      tableData.empty();
      
      let data = dataJson;
      if (filter) {
        if (filter == 'buyed') {
          data = data.filter(function (item) {
              return item.buyings.length !== 0;
          });
        } else if(filter == 'notbuy'){
          data = data.filter(function (item) {
              return item.buyings.length === 0;
          });
        }
      }

      if (day) {
          data = data.filter(function (item) {
            if (item.dayStart <= item.dayEnd) {
                return item.dayStart <= day && day <= item.dayEnd;
            }
            else {
                return day >= item.dayStart || day <= item.dayEnd;
            }
          });
      }

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
                    ${data[i].buyings.length !== 0 ? `
                        ${isWithinSchedule(data[i].dayStart, data[i].dayEnd, data[i].timeStart, data[i].timeEnd) ? `
                            <button type="button" class="btn btn-outline-success button-enter" title="enter" data-name="${data[i].nama}" data-description="${data[i].description}" data-harga="${data[i].harga}" data-day-start="${data[i].dayStart}" data-day-end="${data[i].dayEnd}" data-time-start="${data[i].timeStart}" data-time-end="${data[i].timeEnd}" data-id="${data[i].id}" data-buying-id="${data[i].buying.id}">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </button>
                        ` : `
                            Diluar jadwal
                        `}
                    ` : `
                        <button type="button" class="btn btn-outline-success button-buy" data-name="${data[i].nama}" data-description="${data[i].description}" data-harga="${data[i].harga}" data-day-start="${data[i].dayStart}" data-day-end="${data[i].dayEnd}" data-time-start="${data[i].timeStart}" data-time-end="${data[i].timeEnd}" data-id="${data[i].id}" title="buy">
                            <i class="fas fa-shopping-cart"></i>
                        </button>
                    `}
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

    function isWithinSchedule(dayStart, dayEnd, timeStart, timeEnd) {
        // Get current date and time
        const now = new Date();
        const currentDay = now.getDay(); // 0 = Sunday, 1 = Monday, ..., 6 = Saturday
        const currentTime = now.getHours() * 60 + now.getMinutes(); // Convert time to minutes for easier comparison

        // Convert timeStart and timeEnd to minutes
        const [startHr, startMn] = timeStart.split(':').map(Number);
        const [endHr, endMn] = timeEnd.split(':').map(Number);
        const startTimeInMinutes = startHr * 60 + startMn;
        const endTimeInMinutes = endHr * 60 + endMn;

        // Check if the current day is within the dayStart and dayEnd range
        const isWithinDayRange = (dayStart <= currentDay && currentDay <= dayEnd) ||
                                (dayEnd < dayStart && (currentDay >= dayStart || currentDay <= dayEnd)); // Handle week overlap (e.g., Friday to Monday)

        // Check if the current time is within the timeStart and timeEnd range
        const isWithinTimeRange = startTimeInMinutes <= currentTime && currentTime <= endTimeInMinutes;

        // Return true if both conditions are met
        return isWithinDayRange && isWithinTimeRange;
    }

</script>
@endsection