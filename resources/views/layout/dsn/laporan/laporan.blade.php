@extends('layout.dsn-main-revisi')
@section('title')

<title>Revisi</title>

@endsection
@section('content')
<section class="content">
          <div class="row">
            <div class="col">
              <div class="card card-primary  ">
                <form>
                    <div class="card-body rounded rounded shadow-lg ">
                      <div class="form-group">
                          <h5>Senin 4 Maret 2024</h3>
                          <p>Hari ini saya mengerjakan figma</p>

                          <h5>Selasa 5 Maret 2024</h3>
                          <p>Hari ini saya mengerjakan laravel</p>
                            
                          <h5>Rabu 6 Maret 2024</h3>
                          <p>Hari ini saya mengerjakan x11</p>

                          <h5>Kamis 7 Maret 2024</h3>
                          <p>Hari ini saya mengerjakan adnroid</p>

                          <h5>Jumat 8 Maret 2024</h3>
                          <p>Hari ini saya lanjut mengerjakan android</p>

                          <h5>Sabtu 9 Maret 2024</h3>
                          <p>Hari ini saya mengerjakan google cloud</p>

                          <h5>Rangkuman</h3>
                          <p>Minggu ini saya mengerjakan figma,laravel,x11,codelabs,android 
                                dan google cloud</p>
                      </div>
                    </div>
                </form>
              </div>
            </div>
            <div class="col">
              <form action="{{ route('dmn.laporan') }}" method="post">
                <div class="card card-primary">
                  <div class="card-body rounded shadow-lg">
                    <div class="form-group">
                      <div class="text-center">
                        <p>Apakah Laporan ini perlu revisi ?</p>
                        <input type="radio" name="status" value="Yes">
                        <label for="">Yes</label>
                        &nbsp;
                        <input type="radio" name="status" value="No">
                        <label for="">No</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <textarea class="form-control" name="komentar" placeholder="Enter Komentar" required></textarea>
                      @error('komentar')
                          <small>{{$message}}</small>
                      @enderror
                    </div>
                    <div class="form-group">
                      <label for="">Dokumen</label>
                      <input type="file" class="form-control-file" name="file" required>
                      @error('file')
                          <small>{{$message}}</small>
                      @enderror
                  </div>
                  <div class="form-group text-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                  </div>
                 

                </div>
              </form>
            </div>
          </div>
        </div>
       </div>
      </form>
  </div>
</section>

</section>
@endsection
