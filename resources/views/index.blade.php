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
                    <div class="page-pretitle">
                        Overview
                    </div>
                    <h1 class="page-title">
                        Dashboard
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
                            @if (Auth::user()->is_admin)
                                <h4 class="align-middle text-center">You are admin</h4>
                            @elseif (Auth::user()->is_guru)
                                <h4 class="align-middle text-center">You are guru</h4>
                            @elseif (Auth::user()->is_siswa)
                                <h4 class="align-middle text-center">You are siswa</h4>
                            @else 
                                @if (Auth::user()->siswa)
                                    <h4 class="align-middle text-center">Tunggu admin mempersetujui pendaftaranmu</h4>
                                @else
                                    <h4 class="align-middle text-center">Ayo daftar menjadi siswa disini sekarang</h4>        
                                    <form action="{{ route('daftarsiswa') }}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label for="phone">No WhatsApp</label>
                                            <input type="text" id="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required>
                                            @if ($errors->has('phone'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('phone') }}
                                                </div>
                                            @endif
                                        </div>
                                    
                                        <div class="form-group">
                                            <label for="school">Sekolah</label>
                                            <input type="text" id="school" name="school" class="form-control {{ $errors->has('school') ? 'is-invalid' : '' }}" placeholder="like: SMA" value="{{ old('school') }}" required>
                                            @if ($errors->has('school'))
                                                <div class="invalid-feedback">
                                                    {{ $errors->first('school') }}
                                                </div>
                                            @endif
                                        </div>
                                    
                                        <br>
                                    
                                        <button type="submit" class="btn btn-primary btn-block">Daftar</button>
                                    </form>
                                
                                @endif
                            @endif
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
    
@endsection