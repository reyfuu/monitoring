@extends('layout.dsn-main-revisi')
@section('title')

<title>Revisi</title>
{{-- show laporan --}}
@endsection
@section('content')
<section class="content">
          <div class="row">
            <div class="col">
              <div class="card card-primary  ">
                {{-- show data --}}
                <form>
                    <div class="card-body rounded rounded shadow-lg ">
                      <div class="form-group">
                        @foreach ($days as $d)
                            <h5>{{ $d['date'] }}</h5>
                            <p>{{ $d['isi'] }}</p>
                        @endforeach
                        <h5>Rangkuman minggu ini</h5>
                        <p>{{ $laporan_mingguan->isi }}</p>
                      </div>
                    </div>
                </form>
              </div>
            </div>
            {{-- end show data --}}
            {{-- form start --}}
            <div class="col">
              <form action="{{ route('dmn.update') }}" method="post">
                @csrf
                <div class="card card-primary">
                  <div class="card-body rounded shadow-lg">
                    <div class="form-group">
                      <div class="text-center">
                        <p>Apakah Laporan ini perlu revisi ?</p>
                        <input type="radio" name="status" value="Revisi">
                        <label for="">Yes</label>
                        &nbsp;
                        <input type="radio" name="status" value="Finish">
                        <label for="">No</label>
                      </div>
                    </div>
                    <div class="form-group">
                      <textarea class="form-control" name="comment" placeholder="Enter Komentar" required></textarea>
                      @error('komentar')
                          <small>{{$message}}</small>
                      @enderror
                    </div>
                    <input type="text" name="id" value="{{ $laporan_mingguan->laporan_mingguan_id }}" hidden>
                  <div class="form-group text-center">
                   <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
                  </div>
                 

                </div>
              </form>

            </div>
          </div>
        </div>
       </div>
      </form>
      {{-- form end --}}
  </div>
</section>

</section>
@endsection
