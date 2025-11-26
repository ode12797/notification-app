<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Real-Time Messages</title>

    <!-- Pusher CDN -->
    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>

    <!-- Laravel Echo CDN -->
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>

    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }
        #messages {
            border: 1px solid #ccc;
            padding: 10px;
            height: 300px;
            overflow-y: auto;
        }
        .msg {
            padding: 6px;
            background: #f3f3f3;
            border-radius: 4px;
            margin-bottom: 6px;
        }
    </style>

    <script>
        // Enable console logs for Pusher
        Pusher.logToConsole = true;

        // Initialize Laravel Echo using Pusher
        window.Echo = new Echo({
            broadcaster: "pusher",
            key: "{{ env('PUSHER_APP_KEY') }}",
            cluster: "{{ env('PUSHER_APP_CLUSTER') }}",
            forceTLS: true
        });
    </script>
</head>

<body>

    <h2>Real-Time Messages</h2>

    <div id="messages"></div>

    <br>

    <form id="sendForm">
        <input type="number" id="sender_id" placeholder="Sender ID" required>
        <input type="text" id="message" placeholder="Type a message..." required>
        <button type="submit">Send</button>
    </form>

    <script>
        // Listen for broadcasted events
        window.Echo.channel("messages.channel")
            .listen(".message.received", (event) => {
                console.log("Broadcast received:", event);

                const box = document.getElementById("messages");

                box.innerHTML += `
                    <p class="msg">
                        <strong>${event.message.sender_id}:</strong> ${event.message.message}
                    </p>
                `;

                // Autoscroll
                box.scrollTop = box.scrollHeight;
            });

        // Handle form submission (send new message)
        document.getElementById("sendForm").addEventListener("submit", function(e) {
            e.preventDefault();

            fetch("http://localhost/notification/public/api/messages", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    sender_id: document.getElementById("sender_id").value,
                    message: document.getElementById("message").value
                })
            })
            .then(r => r.json())
            .then(res => {
                console.log("Message sent:", res);
            })
            .catch(err => console.error("Error:", err));
        });
    </script>

</body>
</html>
