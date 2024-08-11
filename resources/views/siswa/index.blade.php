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
                        Siswa
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
                              <div class="col-6">
                                <select class="form-control" id="list-siswa" data-list="">
                                  <option value="" selected>--Filter Siswa--</option>
                                  <option value="approved">Approved</option>
                                  <option value="blocked">Blocked</option>
                                  <option value="pending">Pending</option>
                                </select>
                              </div>
                              <div class="col-6">
                                <input type="text" class="form-control form-control-border" id="cari-nama" placeholder="cari nama">
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
                                  <th scope="row">Sekolah</th>
                                  <th scope="row">No HP</th>
                                  <th scope="row" >Action</th>
                                </tr>
                              </thead>
                              <tbody id="siswa-table"></tbody>
                            </table>
                        </div>
                        <!-- end card-body-->
                        <div class="card-footer clearfix">
                            <ul class="pagination" id="pagination-siswa"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- container -->
    </content>
    <!-- content -->

    </div>
    <!-- /.content-wrapper -->
@endsection


@section('script')
<script>
    // constant id
    const siswaTable = $('#siswa-table');
    const paginationSiswa = $('#pagination-siswa');
    const listSiswa = $('#list-siswa');
    const cariNama = $('#cari-nama');

    // json data
    const jsonSiswa = [];

    $(function () {
        // Set up CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        fetchData(e => {processData(e); generateData();});

        cariNama.on('input', function(){
          let value = $(this).val();
          $(this).attr('data-search', value);
          generateData(1, value);
        });

        listSiswa.on('change', function(){
          let value = $(this).val();
          $(this).attr('data-list', value);
          let search = cariNama.attr('data-search');
          generateData(1, search);
        });

        paginationSiswa.on('click', 'a.page-link', function () {
            let clickedButton = $(this);
            let search = cariNama.attr('data-search');
            let page = clickedButton.attr('data-page');
            generateData(page, search);
        });

        siswaTable.on('click', 'button.bt-approve, button.bt-block', function (){
            const clickedButton = $(this);
            const uNama         = clickedButton.attr('data-name');
            const uID           = clickedButton.attr('data-id');
            var ajaxProggress   = false;
            var ajaxURL         = '';

            if (clickedButton.hasClass('bt-approve')) {
                if (confirm(`Anda menyetujui bahwa siswa(${uNama}) di terima disini?`)) {
                    ajaxProggress = true;
                    ajaxURL         = `{{ route('siswa') }}/${uID}/approve`;
                }
            } else if (clickedButton.hasClass('bt-block')) {
                if (confirm(`Anda menyetujui bahwa siswa(${uNama}) di tolak disini?`)) {
                    ajaxProggress = true;
                    ajaxURL         = `{{ route('siswa') }}/${uID}/block`;
                }
            }

            if (ajaxProggress) {
                $.ajax({
                    url: ajaxURL,
                    type: 'POST',
                    method: 'PUT',
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        makeToast(response.bg, response.message);
                    
                        if (response.bg == 'bg-success') {
                            fetchData(e => {processData(e); generateData();});
                        }
                        
                    },
                    error: function(xhr, status, error) {
                        makeToast('bg-danger', `Error: ${error}`);
                    }
                });
            }

        });
    });

    function fetchData(callback) {
        $.ajax({
            url: "{{ route('siswa.json') }}",
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
        jsonSiswa.length = 0;
        for (let i = 0; i < response.length; i++) {
            jsonSiswa.push({
                id      : response[i].id,
                userID  : response[i].user_id,
                nama    : response[i].user.name,
                email   : response[i].user.email,
                school  : response[i].school,
                phone   : response[i].phone,
                status  : response[i].status == 1 ? 'Approved' : (response[i].status == 2 ? 'Blocked' : 'Pending'),
            });
        }
    }

    function generateData(page = 1, search = null) {
      let dataPerPage = 10;
      let startIndex = (page - 1) * dataPerPage;
      let endIndex = startIndex + dataPerPage;
      let table = siswaTable;
      table.empty();
      
      let data = jsonSiswa;
      if (listSiswa.val() !== '') {        
            data = data.filter(function (item) {
                return item.status.toLowerCase().includes(listSiswa.attr('data-list').toLowerCase());
            });
      }

      if (search) {
          data = data.filter(function (item) {
              return item.nama.toLowerCase().includes(search.toLowerCase());
          });
      }

      if (data.length === 0) {
          table.append('<tr><td colspan="6" class="text-center">Siswa not found</td></tr>');
          return;
      }

      for (let i = startIndex; i < endIndex && i < data.length; i++) {
          let row = `
              <tr>
                  <td class="align-middle text-center" style="width: 50px;">${i + 1}</td>
                  <td class="align-middle">${data[i].nama}</td>
                  <td class="align-middle">${data[i].email}</td>
                  <td class="align-middle">${data[i].school}</td>
                  <td class="align-middle">${data[i].phone}</td>
                  <td class="align-middle text-center">
                    ${data[i].status == 'Pending' ? `
                        <button type="button" class="btn btn-outline-success bt-approve" title="approve" data-name="${data[i].nama}" data-id="${data[i].id}">
                            <i class="fas fa-thumbs-up"></i>
                        </button>

                        <button type="button" class="btn btn-outline-danger bt-block" data-name="${data[i].nama}" data-id="${data[i].id}" title="block">
                            <i class="fas fa-ban"></i>
                        </button>                  
                    ` : `
                        ${data[i].status}
                    `}
                  </td>
              </tr>
          `;
          table.append(row);
          let totalPages = Math.ceil(data.length / dataPerPage);
          generatePagerPagination(totalPages, page);
      }
    }

    // function generate pagination page 
    function generatePagerPagination(totalPages = 1, page = 1){

      let $pagination = paginationSiswa;
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
</script>
@endsection