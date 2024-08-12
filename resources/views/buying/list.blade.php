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
                        Pembelian Kelas
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
                <div class="card-body">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th scope="row">Siswa</th>
                        <th scope="row">Kelas</th>
                      </tr>
                    </thead>
                    <tbody>
                        @if (count($data))
                            @foreach ($data as $d)
                                <tr>
                                    <td class="align-middle">{{ $d->user->name }}</td>
                                    <td class="align-middle">{{ $d->bimbel->title }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="2">Belum ada pembelian</td></tr>
                        @endif
                    </tbody>
                  </table>
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

@endsection