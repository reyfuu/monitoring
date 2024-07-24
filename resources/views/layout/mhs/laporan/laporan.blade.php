@extends('layout.mhs-main')
@section('title')




<title>Laporan Mingguan</title>
@endsection
@section('content')

<div class="content-wrapper">

  <div class="container">
    <div class="row ">
      <div class="col-12">
        <div class="card">
          <div class="card-body">
            <div id="calendar">
  
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="eventModal" tabindex="-1" aria-labelledby="eventModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="eventModalLabel">Event</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body">
      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" id="title" class="form-control" required>
      </div>
      <div class="form-group">
        <label for="start">Deskripsi</label>
        <textarea name="deskripsi" class="form-control" rows="5"></textarea>
      </div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      <button type="button" class="btn btn-primary" >Submit</button">
    </div>
    </div>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
     var calendarEl = document.getElementById('calendar');
     var calendar = new FullCalendar.Calendar(calendarEl, {
       initialView: 'dayGridMonth',
       initialDate: new Date(),
       headerToolBar: {
         left: 'prev,next today',
         center: 'title',
         right: 'dayGridMonth,timeGridWeek,timeGridDay',
       },
       dateClick:function (info){
        console.log(info)
          $('#eventModal').modal('show');
       }
     });
     calendar.render();
   });
</script>
 
@endsection
