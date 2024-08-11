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
            <h1 class="m-0">Pengguna</h1>
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
                        <div class="row">
                          <div class="col-6">
                            <select class="form-control" id="list-pengguna" data-list="guru">
                              <option value="guru" selected>Guru</option>
                              <option value="siswa">Siswa</option>
                              <option value="unknown">Unknown</option>
                            </select>
                          </div>
                          <div class="col-6">
                            <input type="text" class="form-control form-control-border" id="cari-nama" placeholder="cari nama">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12 d-none mt-3" id="input-section">
                    <div class="row">
                      <div class="col-6">
                        <div class="form-group">
                          <label for="u-name">Nama</label>
                          <input type="text" id="u-name" name="name" class="form-control" data-value="" placeholder="like: Abimanyu">
                          <div class="invalid-feedback d-none">
                            Nama harus unique(tidak boleh sama dengan yang lain).
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="u-pass">Password</label>
                          <input type="text" id="u-pass" name="password" class="form-control" data-value="" placeholder="password">
                          <div class="invalid-feedback d-none">
                            Password lemah.
                          </div>
                        </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                          <label for="u-email">Email</label>
                          <input type="email" id="u-email" name="email" class="form-control" data-value="" placeholder="like: abimanyu@gmail.com">
                          <div class="invalid-feedback d-none">
                            invalid email.
                          </div>
                        </div>
                        <div class="form-group">
                          <label for="u-role">Role</label>
                          <select class="form-control" name="role" id="u-role" data-value="">
                              <option value="guru" selected>Guru</option>
                              <option value="siswa">Siswa</option>
                          </select>
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

    // group button
    const btnTambah = $('#btn-tambah');
    const btnSimpan = $('#btn-simpan');
    const btnBatal = $('#btn-batal');
    const listPengguna = $('#list-pengguna');
    const cariNama = $('#cari-nama');

    // group input
    const inputDiv = $('#input-section');
    const inpName = $('#u-name');
    const inpEmail = $('#u-email');
    const inpRole = $('#u-role');
    const inpPass = $('#u-pass');
    inpRole.val('guru');

    // json data
    const email = [];
    const jsonUsers = [];

    // validation
    const emailPattern = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    // const passwordPattern = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/; //dengan spesial karakter
    const passwordPattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/; // tanpa spesial karakter

    $(function () {
        // Set up CSRF token for AJAX requests
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        fetchData(e => {processData(e); generateData();});

        btnTambah.on('click', function(){
          toggleHide();
          btnSimpan.prop('disabled', true);
          btnSimpan.attr('data-simpan', 'new');
          btnSimpan.attr('data-id', '');
          inpName.val('');
          inpEmail.val('');
          inpRole.val('guru');
          inpPass.val('');
          inpName.attr('data-value','');
          inpRole.attr('data-value', 'guru');
          inpEmail.attr('data-value','');
        });
        
        btnBatal.on('click', function(){
          toggleHide();
          btnSimpan.prop('disabled', true);
          btnSimpan.attr('data-simpan', 'new');
          btnSimpan.attr('data-id', '');
          inpName.val('');
          inpEmail.val('');
          inpRole.val('guru');
          inpPass.val('');
          inpName.attr('data-value','');
          inpRole.attr('data-value', 'guru');
          inpEmail.attr('data-value','');
        });

        function toggleHide()
        {
            btnTambah.toggleClass('d-none');
            btnSimpan.toggleClass('d-none');
            btnBatal.toggleClass('d-none');
            inputDiv.toggleClass('d-none');
        }

        $('.form-control').on('input', function() {
          let inputFocus = $(this);
          let typeInput = inputFocus.attr('type');
          let nameInput = inputFocus.attr('name');
          let oldInput = inputFocus.attr('data-value');
          let feedbackDiv = inputFocus.parent().find('.invalid-feedback');
          let typeSimpan = btnSimpan.attr('data-simpan');
          let dataRole = ['guru','siswa'];
          
          if (typeSimpan == 'update') {
            switch (nameInput) {
                case 'email':
                    let isEmail = emailPattern.test(inputFocus.val());
    
                    inputFocus.toggleClass('is-invalid', !isEmail);
                    feedbackDiv.toggleClass('d-none', isEmail);
                    feedbackDiv.html('Invalid email.');

                    
                    if (inputFocus.val() !== oldInput){                    
                      // Check if the input value exists in the array
                      if ($.inArray(inputFocus.val(), email) !== -1) {
                        inputFocus.toggleClass('is-invalid', true);
                        feedbackDiv.toggleClass('d-none', false);
                        feedbackDiv.html('Email harus unique(tidak boleh sama dengan yang lain atau masukkan email lama).');
                      }
                    }
                    break;
                case 'role':
                    if ($.inArray(inputFocus.val(), dataRole) !== -1) {
                      inputFocus.toggleClass('is-invalid', false);
                      feedbackDiv.toggleClass('d-none', true);
                    } else {
                      inputFocus.toggleClass('is-invalid', true);
                      feedbackDiv.toggleClass('d-none', false);
                    }
                    break;
                case 'password':
                    if (inputFocus.val() !== '') {                
                      let isStandarPassword = passwordPattern.test(inputFocus.val());
          
                      inputFocus.toggleClass('is-invalid', !isStandarPassword);
                      feedbackDiv.toggleClass('d-none', isStandarPassword);
                      feedbackDiv.html('Password terlalu lemah(minimal 8 karakter, satu huruf besar, satu huruf kecil, dan satu angka).');
                    } else {
                      inputFocus.toggleClass('is-invalid', false);
                      feedbackDiv.toggleClass('d-none', true);
                    }
                    break;
                default:
                    break;
            }

            btnSimpan.prop('disabled', !(
              inpName.val() && !inpName.hasClass('is-invalid') &&
              inpEmail.val() && !inpEmail.hasClass('is-invalid')
            ));

          } else {
            switch (nameInput) {
                case 'email':
                    let isEmail = emailPattern.test(inputFocus.val());
    
                    inputFocus.toggleClass('is-invalid', !isEmail);
                    feedbackDiv.toggleClass('d-none', isEmail);
                    feedbackDiv.html('Invalid email.');

                    // Check if the input value exists in the array
                    if ($.inArray(inputFocus.val(), email) !== -1) {
                        inputFocus.toggleClass('is-invalid', true);
                        feedbackDiv.toggleClass('d-none', false);
                        feedbackDiv.html('Email harus unique(tidak boleh sama dengan yang lain).');
                    }
                    break;
                case 'role':
                    if ($.inArray(inputFocus.val(), dataRole) !== -1) {
                      inputFocus.toggleClass('is-invalid', false);
                      feedbackDiv.toggleClass('d-none', true);
                    } else {
                      inputFocus.toggleClass('is-invalid', true);
                      feedbackDiv.toggleClass('d-none', false);
                    }
                    break;
                case 'password':
                    let isStandarPassword = passwordPattern.test(inputFocus.val());
                    
                    inputFocus.toggleClass('is-invalid', !isStandarPassword);
                    feedbackDiv.toggleClass('d-none', isStandarPassword);
                    feedbackDiv.html('Password terlalu lemah(minimal 8 karakter, satu huruf besar, satu huruf kecil, dan satu angka).');
                    break;
                default:
                    break;
            }

            btnSimpan.prop('disabled', !(
              inpName.val() && !inpName.hasClass('is-invalid') &&
              inpEmail.val() && !inpEmail.hasClass('is-invalid') &&
              inpPass.val() && !inpPass.hasClass('is-invalid')
            ));
          }
        });

        $('#users-table').on('click', 'button.button-edit,button.button-delete', function (){
          let clickedButton = $(this);

          let uName = clickedButton.attr('data-name');
          let uEmail = clickedButton.attr('data-email');
          let uRole = clickedButton.attr('data-role');
          let uID = clickedButton.attr('data-id');
          if (clickedButton.hasClass('button-edit')) {
            btnSimpan.attr('data-simpan', 'update');
            btnSimpan.attr('data-id', uID);
            inpName.val(uName);
            inpEmail.val(uEmail);
            inpRole.val(uRole);
            inpName.attr('data-value', uName);
            inpEmail.attr('data-value', uEmail);
            inpRole.attr('data-value', uRole);
            if (inputDiv.hasClass('d-none')) {toggleHide()}
          } else if(clickedButton.hasClass('button-delete')){

            if (confirm(`Tetap ingin menghapus pengguna ini(${uName})???`)) {              
              $.ajax({
                  url: `{{ route('users') }}/${uID}/delete`,
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

        btnSimpan.on('click', function (){
            let typeSimpan = $(this).attr('data-simpan');
            let userID = $(this).attr('data-id');
            let formData = new FormData();
            let urlSimpan = '{{ route('users.store') }}';

            if (typeSimpan === 'update') {
                urlSimpan = `{{ route('users') }}/${userID}/update`;
                formData.append('name', inpName.val());
                formData.append('email', inpEmail.val());
                formData.append('role', inpRole.val());
                formData.append('_method', 'PUT');

                // Check if the password is not empty before adding to data
                if (inpPass.val() !== '') {
                    formData.append('pass', inpPass.val());
                }
            } else {
                formData.append('name', inpName.val());
                formData.append('email', inpEmail.val());
                formData.append('role', inpRole.val());
                formData.append('pass', inpPass.val());
            }

            $.ajax({
                url: urlSimpan,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    makeToast(response.bg, response.message);
                    if (response.bg == 'bg-success') {
                      fetchData(e => {processData(e); generateData();});
                      btnBatal.click();
                    }
                },
                error: function (xhr) {
                    // Show validation error message
                    if(xhr.status === 400 && xhr.responseJSON.message){
                        makeToast('bg-danger', xhr.responseJSON.message);
                    } else {
                        console.error("Error:", xhr);
                    }
                }
            });
        });

        cariNama.on('input', function(){
          let value = $(this).val();
          $(this).attr('data-search', value);
          generateData(1, value);
        });

        listPengguna.on('change', function(){
          let value = $(this).val();
          $(this).attr('data-list', value);
          let search = cariNama.attr('data-search');
          generateData(1, search);
        });

        $('#pagination-users').on('click', 'a.page-link', function () {
            let clickedButton = $(this);
            let search = cariNama.attr('data-search');
            let page = clickedButton.attr('data-page');
            generateData(page, search);
        });

    });

    function fetchData(callback) {
        $.ajax({
            url: "{{ route('users.json') }}",
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
        jsonUsers.length = 0;
        for (let i = 0; i < response.length; i++) {
            jsonUsers.push({
                id: response[i].id,
                nama: response[i].name,
                email: response[i].email,
                role: response[i].is_guru == true ? 'guru' : (response[i].is_siswa == true ? 'siswa' : 'unknown'),
            });
            email.push(response[i].email);
        }
    }

    function generateData(page = 1, search = null) {
      let dataPerPage = 10;
      let startIndex = (page - 1) * dataPerPage;
      let endIndex = startIndex + dataPerPage;
      let userTable = $('#users-table');
      userTable.empty();
      
      let data = jsonUsers.filter(function (item) {
                      return item.role.toLowerCase().includes(listPengguna.attr('data-list').toLowerCase());
                  });
      let totalPages = Math.ceil(data.length / dataPerPage);
      generatePagerPagination(totalPages, page);

      if (search) {
          data = data.filter(function (item) {
              return item.nama.toLowerCase().includes(search.toLowerCase());
          });
      }

      if (data.length === 0) {
          userTable.append('<tr><td colspan="5" class="text-center">Pengguna not found</td></tr>');
          return;
      }

      for (let i = startIndex; i < endIndex && i < data.length; i++) {
          let row = `
              <tr>
                  <td class="align-middle text-center" style="width: 50px;">${i + 1}</td>
                  <td class="align-middle">${data[i].nama}</td>
                  <td class="align-middle">${data[i].email}</td>
                  <td class="align-middle">${data[i].role}</td>
                  <td class="align-middle text-center">
                    <button type="button" class="btn btn-outline-warning button-edit" title="edit" data-name="${data[i].nama}" data-email="${data[i].email}" data-role="${data[i].role}" data-id="${data[i].id}">
                      <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button type="button" class="btn btn-outline-danger button-delete" data-name="${data[i].nama}" data-email="${data[i].email}" data-role="${data[i].role}" data-id="${data[i].id}" title="delete">
                        <i class="fas fa-trash"></i>
                    </button>
                  </td>
              </tr>
          `;
          userTable.append(row);
      }
    }

    // function generate pagination page 
    function generatePagerPagination(totalPages = 1, page = 1){

      let $pagination = $('#pagination-users');
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