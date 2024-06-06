@extends('layout.mhs-main')
@section('title')

<title>Laporan Mingguan</title>
@endsection
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Laporan Harian</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Laporan Mingguan</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
    <section class="content">
        <div class="container">
          <div class="col-md-12">
            <div class="card card-primary">

                  @foreach ($days as $d)
                  <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">{{ $d }}</h5>
                    <br>
                    <div class="text-center">
                      @if (!isset($activities[$d]))
                      <button type="button" class="btn btn-primary activity-button " data-toggle="modal" data-target="#exampleModal"
                      data-date="{{ $d }}">
                        Buat Laporan Harian
                      </button>
                      @endif

                    </div>
                  </div>
                </div>

                  @endforeach

                  
                      <!-- Button trigger modal -->


                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Masukkan Kegiatan</h5>
                                <p id="modalDate"></p>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="{{ route('mhs.store2') }}" method="post">
                                @csrf
                                <textarea class="form-control" rows="5" name="isi"></textarea>
                                <input type="input" name="date" id="eDate" hidden>
    
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                              </div>
                              </form>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>


                  </div>
            </div>




@endsection