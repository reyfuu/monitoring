@extends('layout.dsn-main')
@section('title')

<title>Chat</title>
@endsection
@section('content')
  <div class="content-wrapper">
  <section class="content">
  <div class="row">

      <div class="col-md-4 col-lg-2">
        <div class="card shadow-sm">
            <div class="list-group chat-list" id="chatList" style="max-height: 525px; overflow-y: auto;">
                <ul class="list-group list-group-flush">
                     @foreach ($siswa as $s)
                    <li class="list-group-item d-flex align-items-center chat-item">
                        <img src="{{ asset('img/avatar-default.svg') }}"   class="profile_img rounded-circle mr-3" style="width: 40px; height: 40px;" alt="Profile Picture">
                        <div class="profile_info">
                            <a href="{{ route('dmn.getchat',['id'=> $s->npm]) }}" class="profile_name text-center font-weight-bold">{{  $s->name}}</a>
                            <span class="id" id="sourceNpm" style="display: none">{{ $s->npm }}</span>
                        </div>
                    </li>
                  @endforeach 
                </ul>
            </div>
        </div>
      </div>
      
      <!-- Right column: Chat area -->
      <div class="col-md-4 col-lg-9">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <div class="d-flex align-items-center">
                    <img id="chat_img" src="{{ asset('img/avatar-default.svg') }}" class="rounded-circle mr-3" alt="Profile Picture" style="width: 40px; height: 40px;">
                    <h4 class="mb-0" id="chat_name"> {{ $name }}</h4>
                </div>
            </div>
            <div class="card-body chat-window" style="height: 400px; overflow-y: auto;">
                <div class="chat-message-container" id="chatMessageContainer">
                    <!-- Chat messages will be dynamically loaded here -->

                </div>
            </div>
      
            <div class="card-footer">
                <form id="messageForm" method="POST" onsubmit="return validateForm()">
                    @csrf
                    <div class="input-group">
                      <input type="text" id="npm" name="npm" value="{{ $id }}" hidden>
                        <input type="text" id="pesan" class="form-control" placeholder="pesan" id="messageInput" name="message">
                        <button class="btn btn-primary" id="sendButton" type="submit" id="sendMessageButton">Send</button>
                    </div>
                </form>
            </div>
        </div>
      </div>
    </div>
  </section>
  </div>
  @section('script')
  <script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
 
    const toggleButton = document.querySelector('.chatbox-toggle');
    const chatbox = document.querySelector('#chat-container');


  function validateForm() {
    const message = document.getElementById('pesan').value.trim();;

    if (message == "") {
        alert(" Harap diisi pesan anda");
        return false;
    }
    return true;
}
  function formatTimestamp(timestamp){
    const date = new Date(timestamp);
    const option ={day:'2-digit',month: 'short',hour:'2-digit', minute:'2-digit'};
    return date.toLocaleString('id-ID',option);
  }


$(document).ready(function() {
  const npm = $('#npm').val();
  function fetchMessages(npm){

    $.ajax({
        url:'/dmn/fetchChat/'+npm,
        method: 'GET',
        success: function(data){
          
          $('#chatMessageContainer').empty();

          data.forEach(function(chat){
            var messageclass = (chat.sender == 'mahasiswa') ? 'sender ': 'receiver';

            $('#chatMessageContainer').append(
              '<div class= "chat-message '+messageclass+'">'+
                '<p class= "message-content">'+ chat.message +'</p>'+
                '<small class= "timestamp2">'+ formatTimestamp(chat.created_at)+'</small>'+
              '</div>'
         
            );
          });
          fetchMessages(npm);
        },
        error:function (error){
          console.error(error);
      }
    });
  }
  fetchMessages(npm);
    $("#messageForm").on('submit',function(event){
      event.preventDefault();
    const message = $("#pesan").val();
    const npm = $('#npm').val();
    const errorMessage = $("#error-message");
    
    if (message == "") {
        alert("Harap diisi pesan anda");
        return false;
    } 
  

    var userMessages= message; 
      $.ajax({
          url: '/dmn/message',
          method: 'POST',
          data:{
            userMessages: message,
            npm:npm,
            _token: '{{ csrf_token() }}'
          },
          success: function (response){
            $('#pesan').val('');
            console.log('success');
          },
          error:function (error){
            console.error(error);
          }
        });
      });
  
   
});

  </script>
  @endsection
  @endsection
