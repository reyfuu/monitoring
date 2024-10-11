const chatboxToggle = document.querySelector('.chatbox-toggle');
const chatboxMessage = document.querySelector('.chatbox-message-wrapper');

chatboxToggle.addEventListener('click',function(){
    chatboxMessage.classList.toggle('show');
});
const toggleButton = document.querySelector('.chatbox-toggle');
const chatbox = document.querySelector('.chatbox');

toggleButton.addEventListener('click', () => {
    chatbox.style.display = chatbox.style.display === 'none' ? 'flex' : 'none';
});
function validateForm() {
          const message = document.getElementById('message').value.trim();
          if (message === '') {
              alert('Harap isi pesan');
              return false;
          }
          return true;
}