@extends('layout.mhs-main')
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

  <br>
  <section class="content">
    <div class="container-fluid">
        <div class="table-responsive">

            <table class="table table-hover text-nowrap">
              <thead>
                <th>No</th>
                <th>Syarat Ujian</th>
                <th>Keterangan</th>
                <th>File Upload</th>
                <th>Tanggal Validasi</th>
                <th>Valid</th>
                <th>Save</th>
              </thead>
              <tbody>
                <tr>
                  <form id="myForm" action="{{ route('mhs.store5') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <td >1</td>
                    <td class="limit">Kredit Poin Kegiatan Kemahasiswaan > 200 Poin---Kredit Poin Kegiatan Kemahasiswaan (KPKK) dengan nilai lebih besar dari 200 Poin</td>
                    <td >Kredit Poin Kegiatan Kemahasiswaan (KPKK) dengan nilai lebih besar dari 200 Poin</td>
                    <td >
                        <input type="file" class="form-control" name="kpk" >
                        <div class="text-info">jpg, JPG, png, PNG, pdf, jpeg, JPEG (maxsize: 2 MB)</div>
                    </td >
                    <td>
                    </td>
                    <td>
                      @if ($status == 'disetujui')
                      <i class="fa fa-check" style="color:#008d4c"></i>
                     @else
                         
                     @endif
                    </td>
                    <td>
                        <button  type="submit" class="btn btn-success text-end">Simpan</button>
                    </td>
                  </form>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Lulus 120 SKS---Telah lulus 120 SKS</td>
                    <td>Telah lulus 120 SKS</td>
                    <td>
                       <input type="file" class="form-control" name="sks" >
                       <div class="text-info">jpg, JPG, png, PNG, pdf, jpeg, JPEG (maxsize: 2 MB)</div>
                    </td>
                    <td></td>
                    <td>
                    @if ($status == 'disetujui')
                      <i class="fa fa-check" style="color:#008d4c"></i>
                      
                     @else
                         
                     @endif
                    </td>
                </tr>
                <tr>
                  <td>3</td>
                  <td>Lulus In House---Telah lulus in house</td>
                  <td>Telah lulus in house</td>
                  <td>
                     <input type="file" class="form-control" name="lulus" >
                     <div class="text-info">jpg, JPG, png, PNG, pdf, jpeg, JPEG (maxsize: 2 MB)</div>
                  </td>
                  <td></td>
                  <td>
                    @if ($status == 'disetujui')
                    <i class="fa fa-check" style="color:#008d4c"></i>
                   @else
                       
                   @endif
                  </td>
                </tr>
                <tr>
                  <td>4</td>
                  <td>Lulus LKMM Etika Moral---Telah lulus LKMM Etika Moral</td>
                  <td>Telah lulus LKMM Etika Moral</td>
                  <td>
                     <input type="file" class="form-control" name="wm" >
                     <div class="text-info">jpg, JPG, png, PNG, pdf, jpeg, JPEG (maxsize: 2 MB)</div>
                  </td>
                  <td></td>
                  <td>
                    @if ($status == 'disetujui')
                    <i class="fa fa-check" style="color:#008d4c"></i>
                   @else
                       
                   @endif
                  </td>
                </tr>
                <tr>
                  <td>5</td>
                  <td>Lulus LKMM-TD---Telah lulus LKMM-TD</td>
                  <td>Telah lulus LKMM-TD</td>
                  <td>
                     <input type="file" class="form-control" name="lkmmtd" >
                     <div class="text-info">jpg, JPG, png, PNG, pdf, jpeg, JPEG (maxsize: 2 MB)</div>
                  </td>
                  <td></td>
                  <td>
                    @if ($status == 'disetujui')
                    <i class="fa fa-check" style="color:#008d4c"></i>
                   @else
                       
                   @endif
                  </td>
                </tr>
                <tr>
                  <td>6</td>
                  <td>Lulus LKMM-TM---Telah lulus LKMM-TM</td>
                  <td>Telah lulus LKMM-TM</td>
                  <td>
                     <input type="file" class="form-control" name="lkmmtm" >
                     <div class="text-info">jpg, JPG, png, PNG, pdf, jpeg, JPEG (maxsize: 2 MB)</div>
                  </td>
                  <td></td>
                  <td>
                    @if ($status == 'disetujui')
                    <i class="fa fa-check" style="color:#008d4c"></i>
                   @else
                       
                   @endif
                  </td>
                </tr>
                <tr>
                  <td>7</td>
                  <td>Lulus Out Bond---Telah lulus out bond</td>
                  <td>Telah lulus out bond</td>
                  <td>
                     <input type="file" class="form-control" name="outBond">
                     <div class="text-info">jpg, JPG, png, PNG, pdf, jpeg, JPEG (maxsize: 2 MB)</div>
                  </td>
                  <td></td>
                  <td>
                    @if ($status == 'disetujui')
                    <i class="fa fa-check" style="color:#008d4c"></i>
                   @else
                       
                   @endif
                  </td>
                </tr>
                <tr>
                  <td>8</td>
                  <td>Lunas Administrasi Keuangan---Telah melunasi administrasi keuangan ( SPP semester sebelumnya dan Dana Pengembangan)</td>
                  <td>Telah melunasi administrasi keuangan ( SPP semester sebelumnya dan Dana Pengembangan)</td>
                  <td>
                     <input type="file" class="form-control" name="spp" >
                     <div class="text-info">jpg, JPG, png, PNG, pdf, jpeg, JPEG (maxsize: 2 MB)</div>
                  </td>
                  <td></td>
                  <td>
                    @if ($status == 'disetujui')
                    <i class="fa fa-check" style="color:#008d4c"></i>
                   @else
                       
                   @endif
                  </td>
                </tr>
                <tr>
                  <td>9</td>
                  <td>Maksimal Nilai D 10 % Dari Total SKS---Maksimal untuk nilai D adalah 10 % dari total SKS</td>
                  <td>Maksimal untuk nilai D adalah 10 % dari total SKS</td>
                  <td>
                     <input type="file" class="form-control" name="nilai">
                     <div class="text-info">jpg, JPG, png, PNG, pdf, jpeg, JPEG (maxsize: 2 MB)</div>
                  </td>
                  <td></td>
                  <td>
                    @if ($status == 'disetujui')
                    <i class="fa fa-check" style="color:#008d4c"></i>
                   @else
                       
                   @endif
                  </td>
                </tr>
                <tr>
                  <td>10</td>
                  <td>Sedang Menempuh 144 SKS---Sedang menempuh 144 SKS saat mengajukan proposal</td>
                  <td>Sedang menempuh 144 SKS saat mengajukan proposal</td>
                  <td>
                     <input type="file" class="form-control" name="sumSks">
                     <div class="text-info">jpg, JPG, png, PNG, pdf, jpeg, JPEG (maxsize: 2 MB)</div>
                  </td>
                  <td>
                    <p></p>
                  </td>
                  <td>
                    @if ($status == 'disetujui')
                    <i class="fa fa-check" style="color:#008d4c"></i>
                   @else
                       
                   @endif
                  </td>
                </tr>
                <tr>
                  <td>11</td>
                  <td>TOEFL > 400---Skor test TOEFL lebih besar dari 400</td>
                  <td>Skor test TOEFL lebih besar dari 400</td>
                  <td>
                     <input type="file" class="form-control" name="toefl" >
                     <div class="text-info">jpg, JPG, png, PNG, pdf, jpeg, JPEG (maxsize: 2 MB)</div>
                  </td>
                  <td>

                  </td>
                  <td>
                    @if ($status == 'disetujui')
                    <i class="fa fa-check" style="color:#008d4c"></i>
                   @else
                       
                   @endif
                  </td>
                </tr>
            </tbody>
          </form>
        </table>
    </div>
</div>
</section>
</div>
   
@endsection