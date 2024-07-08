@extends('layout.mhs-main')
@section('title')

<title>Laporan Harian</title>

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
                {{-- show days --}}
                  @foreach ($days as $day)
                  <div class="card">
                  <div class="card-body">
                    <h5 class="card-title">{{ $day['date'] }}</h5>
                    <br>
                    <div class="text-center">
                      @if ($day['has_report'])

                        <p >{{ $day['isi'] }}</p>
                        <a class="btn btn-secondary activity-button" data-toggle="modal" data-target="#modalHarianEdit{{ $day['id'] }}" 
                        data-isi="{{ $day['isi'] }}"> <i class="fas fa-pen"></i> Edit</a>
               
                  
                      @else
                      <button type="button" class="btn btn-primary activity-button " data-toggle="modal" data-target="#modalHarian"
                      data-date="{{ $day['date'] }}">
                        Buat Laporan Harian
                      </button>
                      @endif
                    {{-- end show days --}}
                    </div>
                  </div>
                </div>
                {{-- modal Harian edit --}}
                <div class="modal fade" id="modalHarianEdit{{ $day['id'] }}" tabindex="-1" aria-labelledby="modalHarianEdit{{ $day['id'] }}" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="modalHarianEdit">Edit Laporan Harian</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <form action="{{ route('mhs.update3',['id'=> $day['id']]) }}" method="post">
                        @csrf
                        @method('put')
                        <textarea class="form-control" rows="5" name="isi" >{{ $day['isi'] }}</textarea>
              

                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                      </div>
                      </form>
                    </div>
                  </div>
                </div>
                  @endforeach

                  <div class="card">
                    <div class="card-body">
                      <h5 class="card-title">Rangkuman</h5>
                      <br>
                      <div class="text-center">
                      @if ($week->isi)
                          <a class="btn btn-secondary activity-button" data-toggle="modal" data-target="#modalRangkumanEdit" data-isi="{{ $week->isi }}"> <i class="fas fa-pen"></i> Edit</a>
                      @else
                      <button type="button" class="btn btn-primary activity-button " data-toggle="modal" data-target="#modalRangkuman">
                        Buat Rangkuman
                      </button>
                      @endif
      
                        
                      </div>
                    </div>
                  </div>

                  

                  
                      <!-- Button trigger modal -->


                        <!-- Modal & form start -->
                        <div class="modal fade" id="modalHarian" tabindex="-1" aria-labelledby="modalHarian" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalHarian">Masukkan Kegiatan</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="{{ route('mhs.store2') }}" method="post">
                                @csrf
                                @method('put')
                                <textarea class="form-control" rows="5" name="isi"></textarea>
                                <input type="input" name="date" id="eDate" hidden >
                                <input type="text" name="week" value="{{ $id }}"  hidden>
    
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                              </div>
                              </form>
                            </div>
                          </div>
                        </div>
              
                        
                        
                        {{-- modal Rangkuman --}}
                        
                        <div class="modal fade" id="modalRangkuman" tabindex="-1" aria-labelledby="modalRangkuman" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalHarianEdit">Rangkuman Minggu ini</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="{{ route('mhs.store4') }}" method="post">
                                @csrf
                                <textarea class="form-control" rows="5" name="isi" id="eIsi"></textarea>
                                <input type="text" name="week" value="{{ $id }}" hidden>
    
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                              </div>
                              </form>
                            </div>
                          </div>
                        </div>
                         {{-- modal Rangkuman edit --}}
                        
                         <div class="modal fade" id="modalRangkumanEdit" tabindex="-1" aria-labelledby="modalRangkumanEdit" aria-hidden="true">
                          <div class="modal-dialog">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title" id="modalHarianEdit">Edit Rangkuman Minggu ini</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <form action="{{ route('mhs.update4',['id'=>$week->laporan_mingguan_id]) }}" method="post">
                                @csrf
                                @method('put')
                                <textarea class="form-control" rows="5" name="isi" >{{ $week->isi }}</textarea>

    
                              <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                              </div>
                              </form>
                            </div>
                          </div>
                        </div>                       
                        {{-- modal & form end --}}
                    </div>
                  </div>


                  </div>
            </div>




@endsection