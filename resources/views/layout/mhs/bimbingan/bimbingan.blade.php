@extends('layout.mhs-main')
@section('title')

<title>Bimbingan</title>
{{-- dashboard bimbingan  --}}
@endsection
@section('content')
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0">Bimbingan Proposal</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Bimbingan Proposal</li>
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
                    <th  style="      white-space: pre-wrap;
      word-wrap: break-word;">No </th>
                    <th  style="      white-space: pre-wrap;
      word-wrap: break-word;">Tanggal</th>
                    <th  style="      white-space: pre-wrap;
      word-wrap: break-word;">Dosen Pembimbing</th>
                    <th  style="      white-space: pre-wrap;
      word-wrap: break-word;">Bahasan</th>
                    <th  style="      white-space: pre-wrap;
      word-wrap: break-word;">Status</th>
                    <th style="      white-space: pre-wrap;
      word-wrap: break-word;">Komentar</th>
                    <th style="      white-space: pre-wrap;
      word-wrap: break-word;">Aksi</th> 
                  </thead>
                  <tbody>
                    @foreach ($bimbingan as $d)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $d->tanggal }}</td>
                      <td style="      white-space: pre-wrap;
      word-wrap: break-word;">{{ $name }}</td>
                      <td style="      white-space: pre-wrap;
                      word-wrap: break-word;">{{ $d->isi }}</td>        
                    <td>
                      @if ($d->status_domen)
                      {{ $d->status_domen }}
                      </span>            
                      @else
                        submit
                      @endif
                    </td>
                    
                    <td style="      white-space: pre-wrap;
                    word-wrap: break-word;">@if ($d->komentar){{ $d->komentar }}@else belum ada komentar @endif
                    </td>

                      <td>           
                        @if ($d->status_domen == 'disetujui')
                            
                        @else
                      
                        <a href="{{ route('mhs.edit',['id' =>$d->bimbingan_id ]) }}" class="btn btn-primary" > <i class="fas fa-pen"></i> Edit</a>
                        <br><br>
                        <a data-toggle="modal" data-target="#modal-delete{{ $d->bimbingan_id }}" href="{{ route('mhs.delete',['id' => $d->bimbingan_id ]) }}" class="btn btn-danger" > <i class="fas fa-trash"></i> Hapus</a>
                        <br>
                        @endif 
                        <br>
                    
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
          
              <!-- /.row (main row) -->
  </section>
</div>
@endsection