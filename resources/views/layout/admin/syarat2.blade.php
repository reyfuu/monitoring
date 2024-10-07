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
            <h1 class="m-0">Dashboard Admin</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard </li>
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
                <th>AKsi</th>
              </thead>
              <tbody>
                @php
                $syarat=[
                'Kredit Poin Kegiatan Kemahasiswaan > 200 Poin---Kredit Poin Kegiatan Kemahasiswaan (KPKK) dengan nilai lebih besar dari 200 ',
                'Lulus 120 SKS---Telah lulus 120 SKS',
                'Lulus In House---Telah lulus in house',
                'Lulus LKMM Etika Moral---Telah lulus LKMM Etika Moral',
                'Lulus LKMM-TD---Telah lulus LKMM-TD',
                'Lulus LKMM-TM---Telah lulus LKMM-TM',
                'Lulus Out Bond---Telah lulus out bond',
                'Lunas Administrasi Keuangan---Telah melunasi administrasi keuangan ( SPP semester sebelumnya dan Dana Pengembangan)',
                'Maksimal Nilai D 10 % Dari Total SKS---Maksimal untuk nilai D adalah 10 % dari total SKS',
                'Sedang Menempuh 144 SKS---Sedang menempuh 144 SKS saat mengajukan proposal',
                'TOEFL > 400---Skor test TOEFL lebih besar dari 400'
              ];
                $keterangan = [
                'Kredit Poin Kegiatan Kemahasiswaan > 200 Poin',
                'Lulus 120 SKS',
                'Lulus In House',
                'Lulus LKMM Etika Moral',
                'Lulus LKMM-TD',
                'Lulus LKMM-TM',
                'Lulus Out Bond',
                'Lunas Administrasi Keuangan',
                'Maksimal Nilai D 10 % Dari Total SKS',
                'Sedang Menempuh 144 SKS',
                'TOEFL > 400'
            ];
            $file = [
                'kpk',
                'sks',
                'inhouse',
                'wm',
                'lkmmtd',
                'lkmmtm',
                'outbond',
                'spp',
                'nilai',
                'sumsks',
                'toefl'

              ];
                @endphp
                @foreach ($syarat as $index => $s)
                <tr>
                    <td >{{ $loop->iteration  }}</td>
                    <td>{{ $s }}</td>
                    <td>{{ $keterangan[$index] }} </td>
              
                    <td >
                      @foreach ($data as $d)
    
                      @if ($d['syarat'] == $file[$index])
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
                      <i class="fa fa-check" style="color:#008d4c"></i>
                     @elseif($d['status'] == 'ditolak' && $d['syarat'] == $file[$index])
                         <i class="fa fa-times" style="color: red"></i>
                     @endif
                     @endforeach
                    </td>
                    <td>
                    @foreach ($data as $d)
                      @if ($d['syarat'] == $file[$index])
                           <a class=" btn btn-success text-end" data-toggle="modal" data-target="#modal{{ $d['id_syarat'] }}" >Ubah Persetujuan</a>
                    </tr>
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
                            <div class="modal-footer justify-content-between">

                                <div class="text-center">
                                  <button type="submit" class="btn btn-primary text-center">Yes</button>
                                </div>
                            </div>
                           </form>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                      @endif
                      @endforeach
                    </td> 
                @endforeach
            </tbody>

        </table>

    </div>
</section>
</div>
@endsection
