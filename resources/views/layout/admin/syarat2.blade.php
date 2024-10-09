@extends('layout.admin-main')
@section('title')

<title>Syarat</title>
@endsection
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Daftar Syarat Mahasiswa</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Daftar Syarat Mahasiswa </li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

<section class="content">
    <div class="container-fluid">
        <table class="table table-hover">
            <thead>
                <th>No</th>
                <th>Syarat Ujian</th>
                <th>Keterangan</th>
                <th>File Upload</th>
                <th>Tanggal Validasi</th>
                <th>Valid</th>
                <th>Aksi</th>
              </thead>
              <tbody>
            @php
            $syarat=[
                'Lulus 135 SKS',
                'Lulus Mata Kuliah Magang',
                'Minimal IPK 2,5'
              ];
            $keterangan=[
              'Lulus 135 SKS',
                'Lulus Magang',
                'Minimal IPK 2,5'
            ];
                $file = [
                  'sks',
                  'magang',
                  'ipk'
              ];
            @endphp
            @foreach ($syarat as $index => $s)
                
        
                <tr>
                    <td >{{ $loop->iteration }}</td>
                    <td>{{ $s }}</td>
                    <td>{{ $keterangan[$index] }}</td>
              
                    <td >
                      @foreach ($data as $d)
    
                      @if ($d['syarat'] ==  $file[$index]  )
                      <a href="{{ route('admin.viewSyarat',['id' => $d['file'] ])}}" >
                        <img src="{{ asset('img/pdf.png') }}" width="50%">
                      </a>
                      @endif
         
                      @endforeach
                    </td>


                    <td>
                      @foreach ($data as $d)
                      @if ($d['dateac'] && $d['syarat'] == $file[$index])
                          {{ $d['dateac'] }}
                      @else
                          
                      @endif
                  @endforeach
                    </td>
                    <td>
           
                      @foreach ($data as $d)
                     
                    @if ($d['status'] == 'disetujui' && $d['syarat'] == $file[$index])
                      {{ $d['status'] }}
                     @elseif($d['status'] == 'ditolak' && $d['syarat'] == $file[$index])
                         
                     @endif
                     @endforeach
                    </td>
                    <td>
                    
                     @foreach ($data as $d)
                     @if ($d['syarat'] == $file[$index] && $d['status'] == 'disetujui')
                          
                    @elseif($d['syarat'] == $file[$index] )
                    <a class=" btn btn-success text-end" data-toggle="modal" data-target="#modal{{ $d['id_syarat'] }}" >Ubah Persetujuan</a>
                    @endif
                      <div class="modal fade" id="modal{{ $d['id_syarat'] }}">
                        <div class="modal-dialog">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h4 class="modal-title">Apakah Syarat Valid ?</h4>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                            <form action="{{ route('admin.update3')}}" method="post">
                              @csrf
                              @method('put')
                                <input type="text" name="id_syarat" value={{ $d['id_syarat'] }} hidden>
                                <select name="status"  class="form-control">
                                    <option value="disetujui">disetujui</option>
                                    <option value="ditolak">ditolak</option>
                                </select>
                            </div>
                            <div class="modal-footer">
                                <div class="text-center">
                                  <button type="submit" class="btn btn-primary">Yes</button>
                                </div>
                            </div>
                           </form>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>

                      @endforeach
                 
                    </tr>
                @endforeach
            </tbody>

        </table>

    </div>
</section>
</div>
@endsection
