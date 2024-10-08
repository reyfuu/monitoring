@extends('layout.mhs-main')
@section('title')

<title>Dashboard</title>
{{-- dashboard bimbingan  --}}
@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Bimbingan Tugas Akhir</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Bimbingan Tugas Akhir</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small boxes (Stat box) -->

            <a href="{{ route('mhs.create') }}" class="btn btn-primary mb-3">Tambah</a>
              <div class="table-responsive">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <th>No </th>
                    <th>Tanggal</th>
                    <th>Dosen Pembimbing</th>
                    <th>Disetujui</th>
                    <th>Aksi</th>
                  </thead>
                  <tbody>
                    @foreach ($bimbingan as $d)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $d->tanggal }}</td>
                      <td style="      white-space: pre-wrap;
      word-wrap: break-word;">{{ $name }}</td>
                      <td>
                      @if ($d->status)
                      {{ $d->status }}  
             
                      @endif
                      </td>
                      <td>          
                        @if ($d->status == 'disetujui')
                            
                        @else
                        <a href="{{ route('mhs.edit',['id' =>$d->bimbingan_id ]) }}" class="btn btn-primary" > <i class="fas fa-pen"></i> Edit</a>
                        <br><br>
                        <a data-toggle="modal" data-target="#modal-delete{{ $d->bimbingan_id }}" href="{{ route('mhs.delete',['id' => $d->bimbingan_id ]) }}" class="btn btn-danger" > <i class="fas fa-trash"></i> Hapus</a>
                        <br>
                        @endif 
                        <br>
                    
                        <a data-toggle="modal" data-target="#modal2{{ $d->bimbingan_id }}"  class="btn btn-success" >  Komentar Dosen</a>

                      </td>
                    </tr>
                  </tbody>
                  <div class="modal fade" id="modal-delete{{ $d->bimbingan_id }}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Yakin Hapus data ?</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <p>Apakah Anda yakin ingin menghapus ?</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                          <form action="{{ route('mhs.delete',['id'=>$d->bimbingan_id]) }}" method="POST">
                            @csrf
                            @method('delete')
                            <div class="text-center">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Yes</button>
                          </div>
                          </form>
                        </div>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                        
      <div class="modal fade" id="modal2{{ $d->bimbingan_id }}">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modIal-title">Rekap Komentar ?</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
             
                  <p>{{ $d->komentar }}</p>
     
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
                        <!-- /.modal-dialog -->
                      @endforeach
                </table>
              </div>
        </div>
              <!-- /.row (main row) -->
  </section>
</div>
@endsection