<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="<?= base_url('assets/css/chat.css') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

  <style>
    .msg-body {
      height: 520px;
      overflow-y: auto;
    }

    .send-box {
      margin-top: 10px;
      position: sticky;
      bottom: 0;
      background: #fff;
      padding: 10px;
    }
  </style>
</head>

<body>
  <section class="message-area">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <div class="chat-area">
            <!-- chatlist -->
            <div class="chatlist">
              <div class="modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="chat-header">
                    <div class="msg-search">
                      <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="Search" aria-label="search">
                      <a class="add" href="#"><img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/add.svg" alt="add"></a>
                    </div>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="Open-tab" data-bs-toggle="tab" data-bs-target="#Open" type="button" role="tab" aria-controls="Open" aria-selected="true">Open</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="Closed-tab" data-bs-toggle="tab" data-bs-target="#Closed" type="button" role="tab" aria-controls="Closed" aria-selected="false">Closed</button>
                      </li>
                    </ul>
                  </div>

                  <!-- chat-list -->

                  <?php $loggedInUser   = session()->get('name'); ?>
                  <div class="modal-body">
                    <div class="chat-lists">
                      <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="Open" role="tabpanel" aria-labelledby="Open-tab">
                          <div class="chat-list">
                            <?php foreach ($user as $users): ?>
                              <?php if ($users['name'] !== $loggedInUser):
                              ?>
                                <a href="#" class="d-flex align-items-center" onclick="selectUser  ('<?= $users['name'] ?>')">
                                  <div class="flex-shrink-0">
                                    <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                                    <span class="active"></span>
                                  </div>
                                  <div class="flex-grow-1 ms-3">
                                    <h3><?= $users['name'] ?></h3>
                                    <p>online</p>
                                  </div>
                                </a>
                              <?php endif; ?>
                            <?php endforeach; ?>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- chatlist -->
            <!-- chatbox -->
            <div class="chatbox">
              <div class="modal-dialog-scrollable">
                <div class="modal-content">
                  <div class="msg-head">
                    <div class="row">
                      <div class="col-8">
                        <div class="d-flex align-items-center">
                          <span class="chat-icon"><img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/arroleftt.svg" alt="image title"></span>
                          <div class="flex-shrink-0">
                            <img class="img-fluid" src="https://mehedihtml.com/chatbox/assets/img/user.png" alt="user img">
                          </div>
                          <div class="flex-grow-1 ms-3">
                            <h3 id="receiverName">Select a user</h3>
                            <p id="receiverStatus">Online</p>
                          </div>
                        </div>
                      </div>

                      <div class="modal-body">
                        <div class="msg-body">
                          <ul>
                            <li class="sender">
                              <p> Hey, Are you there? </p>
                              <span class="time">10:06 am</span>
                            </li>
                            <li class="sender">
                              <p> Hey, Are you there? </p>
                              <span class="time">10:16 am</span>
                            </li>
                            <li class="repaly">
                              <p>yes!</p>
                              <span class="time">10:20 am</span>
                            </li>
                            <li class="sender">
                              <p> Hey, Are you there? </p>
                              <span class="time">10:26 am</span>
                            </li>
                            <li class="sender">
                              <p> Hey, Are you there? </p>
                              <span class="time">10:32 am</span>
                            </li>
                            <li class="repaly">
                              <p>How are you?</p>
                              <span class="time">10:35 am</span>
                            </li>
                            <ul id="chats"></ul>
                          </ul>
                        </div>
                        <div class="send-box">
                          <form action="" id="form">
                            <input type="text" id="input" autocomplete="off" class="form-control" aria-label="message…" placeholder="Write message…">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send</button>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- chatbox -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- char-area -->

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="<?= base_url('assets/js/chat.js') ?>"></script>
  <script src="https://cdn.socket.io/4.8.1/socket.io.min.js"></script>

  <script>
    const socket = io("http://localhost:2999");

    const form = document.getElementById('form');
    const input = document.getElementById('input');
    const ul = document.getElementById('chats');
    const msgBody = document.querySelector('.msg-body');

    let sender = '<?= $loggedInUser ?>';
    let receiver = '';

    // Notify server when user joins
    socket.emit('join', sender);

    function scrollToBottom() {
      msgBody.scrollTop = msgBody.scrollHeight;
    }

    // Function to update the active status UI
    function updateUserStatus(activeUsers) {
      document.querySelectorAll('.chat-list a').forEach((chatItem) => {
        const userName = chatItem.querySelector('h3').innerText;
        const statusElement = chatItem.querySelector('p');
        const activeIndicator = chatItem.querySelector('span.active');

        if (activeUsers.includes(userName)) {
          statusElement.innerText = 'Online';
          activeIndicator.style.background = 'green';
        } else {
          statusElement.innerText = 'Offline';
          activeIndicator.style.background = 'gray';
        }
      });

      // Update chatbox user status
      if (receiver) {
        const receiverStatus = document.getElementById('receiverStatus');
        receiverStatus.innerText = activeUsers.includes(receiver) ? 'Online' : 'Offline';
      }
    }

    // Listen for active users update
    socket.on('updateActiveUsers', (activeUsers) => {
      updateUserStatus(activeUsers);
    });

    function selectUser(receiverName) {
      receiver = receiverName;
      document.getElementById('receiverName').innerText = receiver;
      socket.emit('fetchMessages', {
        sender,
        receiver
      });
      ul.innerHTML = "";
    }

    // Load past messages when received from server
    socket.on('pastMessages', (messages) => {
      ul.innerHTML = "";
      messages.forEach((msg) => {
        displayMessage(msg);
      });
      scrollToBottom();
    });

    form.addEventListener('submit', (e) => {
      e.preventDefault();
      if (input.value.trim() && receiver) {
        const msg = {
          message: input.value,
          sender,
          receiver,
          timestamp: new Date().toLocaleTimeString()
        };
        socket.emit('chatMessage', msg);
        input.value = '';
      }
    });

    socket.on('chats', (msg) => {
      displayMessage(msg);
    });

    function displayMessage(msg) {
      const li = document.createElement('li');
      li.classList.add(msg.sender === sender ? 'repaly' : 'sender');
      li.innerHTML = `
    <p>${msg.message}</p>
    <span class="time">${msg.timestamp}</span>
  `;
      ul.appendChild(li);
      scrollToBottom();
    }
  </script>
</body>

</html>