@extends('layout.mhs-main')
@section('title')

<title>Chat</title>
@endsection
@section('content')
  <div class="content-wrapper">
  <section class="content">
  <div class="row">

 
      
      <!-- Right column: Chat area -->
      <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <div class="d-flex align-items-center">
                    <img id="chat_img" src="{{ asset('img/avatar-default.svg') }}" class="rounded-circle mr-3" alt="Profile Picture" style="width: 40px; height: 40px;">
                    @foreach ($name as $n)
                    <h4 class="mb-0" id="chat_name"> {{ $n->name }}</h4>
                    @endforeach
                 
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


$(document).ready(function() {
  const npm = $('#npm').val();
  function fetchMessages(npm){
    $.ajax({
        url:'/mhs/fetchChat',
        method: 'GET',
        success: function(data){
        
          $('#chatMessageContainer').empty();
          console.log(data);
          data.forEach(function(chat){
            var messageclass = (chat.sender == 'dosen') ? 'sender ': 'receiver';

            $('#chatMessageContainer').append(
              '<div class= "chat-message '+messageclass+'">'+
                '<p class= "message-content">'+ chat.message +'</p>'+
              '</div>'
            );
          });
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
          url: '/mhs/message',
          method: 'POST',
          data:{
            userMessages: message,
            npm:npm,
            _token: '{{ csrf_token() }}'
          },
          success: function (response){
            fetchMessages(npm);
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
