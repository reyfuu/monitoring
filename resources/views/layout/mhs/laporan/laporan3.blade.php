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
              <h1 class="m-0">Laporan Mingguan</h1>
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
                <div class="card">

                    <div class="card-body">
                      <h5 class="card-title">Senin 4 Februari 2024</h5>
                      <p class="card-text">Hari ini mengerjakan code lab dasar-dasar compose</p>
                    </div>
                  </div>
                  <div class="card">

                    <div class="card-body">
                      <h5 class="card-title">Selasa 5 Februari 2024 </h5>
                      <br>
                      <div class="text-center">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                          Buat Laporan Harian
                        </button>
                      </div>
                      <!-- Button trigger modal -->


                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <textarea class="form-control" rows="5" name="isi"></textarea>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="card">

                    <div class="card-body">
                      <h5 class="card-title">Rabu 6 Februari 2024 </h5>
                      <br>
                      <div class="text-center">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal2">
                          Buat Laporan Harian
                        </button>
                      </div>
                      <!-- Button trigger modal -->


                        <!-- Modal -->
                        <div class="modal fade" id="modal2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <textarea class="form-control" rows="5" name="isi"></textarea>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                  </div>
            </div>
          </div>
        </div>
    </section>
</div>

</section>
@endsection