<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="styleindex.css" rel="stylesheet">
    <title>Admin Chat</title>
    <style>
        .chat-box {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            border: 1px solid #ddd;
            border-radius: 8px;
            background-color: #fff;
        }

        .chat-header {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
        }

        .chat-body {
            height: 400px;
            overflow-y: auto;
            padding: 10px;
        }

        .chat-input {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ddd;
        }

        .chat-input input {
            flex-grow: 1;
            padding: 5px;
            margin-right: 5px;
        }

        .message {
            margin: 5px 0;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .user-message {
            background-color: #007bff;
            color: #fff;
            align-self: flex-end;
        }

        .admin-message {
            background-color: #f1f1f1;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="chat-box">
        <div class="chat-header">
            <h5>Admin Chat</h5>
            <button type="button" class="btn-close" aria-label="Close" onclick="closeChat()"></button>
        </div>
        <div class="chat-body" id="chatBody">
            <!-- Chat messages will be displayed here -->
        </div>
        <div class="chat-input">
            <input type="text" placeholder="Write message" id="chatInput">
            <button type="button" onclick="sendMessage()">Send</button>
        </div>
    </div>

    <script>
        function fetchMessages() {
            fetch('retrieve_messages.php')
                .then(response => response.json())
                .then(data => {
                    const chatBody = document.getElementById('chatBody');
                    chatBody.innerHTML = '';
                    data.forEach(message => {
                        const msgDiv = document.createElement('div');
                        msgDiv.textContent = `${message.sender}: ${message.message}`;
                        msgDiv.className = message.sender === 'Admin' ? 'message admin-message' : 'message user-message';
                        chatBody.appendChild(msgDiv);
                    });
                    chatBody.scrollTop = chatBody.scrollHeight; // Scroll to the bottom
                })
                .catch(error => {
                    console.error('Error fetching messages:', error);
                });
        }

        function sendMessage() {
            var input = document.getElementById('chatInput');
            var message = input.value.trim();
            if (message) {
                fetch('send_message.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `sender=Admin&message=${encodeURIComponent(message)}`,
                })
                .then(() => {
                    input.value = '';
                    fetchMessages();
                })
                .catch(error => {
                    console.error('Error sending message:', error);
                });
            }
        }

        setInterval(fetchMessages, 2000); // Poll for new messages every 2 seconds
    </script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-JuwPQFqYZV5DHTBbMS+m5pJqO1lt9J3/eVBFeJ3C2dM3kBTHP6Yc0q1rEVi5h+z2" crossorigin="anonymous">
    </script>
</body>

</html>
