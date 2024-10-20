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
            <div class="list-group chat-list" id="chatList" style="max-height: 500px; overflow-y: auto;">
                <ul class="list-group list-group-flush">
                     @foreach ($siswa as $s)
                    <li class="list-group-item d-flex align-items-center chat-item">
                        <img src="{{ asset('img/avatar-default.svg') }}"   class="profile_img rounded-circle mr-3"alt="Profile Picture">
                        <div class="profile_info">
                            <a href="{{ route('dmn.getchat',['id'=> $s->npm]) }}" 
                              style="      white-space: pre-wrap;
      word-wrap: break-word;"class="profile_name text-center font-weight-bold">{{  $s->name}}</a>
        
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
            {{-- <div class="card-header bg-primary text-white">
                <div class="d-flex align-items-center">
                    <img id="chat_img" src="{{ asset('img/avatar-default.svg') }}" class="rounded-circle mr-3" alt="Profile Picture" style="width: 40px; height: 40px;">
                    <h4 class="mb-0" id="chat_name">Chatting with</h4>
                </div>
            </div>--}}
            <div class="card-body chat-window" style="height: 600px; overflow-y: auto;">
                {{-- <div class="chat-message-container" id="chatMessageContainer"> --}}
                    <!-- Chat messages will be dynamically loaded here -->
                    <div class="text-center obrolan">
                      <p class="obrolan">silahkan pilih obrolan untuk mulai mengirim pesan</p>
                    </div>
                     </div>
                {{-- </div> --}}
            </div>
            {{--
            <div class="card-footer">
                <form id="messageForm" method="POST" onsubmit="return validateForm()">
                    @csrf
                    <div class="input-group">
                        <input type="text" id="pesan" class="form-control" placeholder="Type your message here..." id="messageInput" name="message">
                        <button class="btn btn-primary" id="sendButton" type="submit" id="sendMessageButton">Send</button>
                    </div>
                </form>
            </div> --}}
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
    $("#messageForm").on('submit',function(event){
      event.preventDefault();
    const message = $("#pesan").val();
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
            _token: '{{ csrf_token() }}'
          },
          success: function (response){
            console.log('success');
          },
          error:function (error){
            console.error(error);
          }
        });
  })
});

  </script>
  @endsection
  @endsection
