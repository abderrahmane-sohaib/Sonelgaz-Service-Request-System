<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f4f8; /* light blue background */
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
            border-top: 5px solid #ff7f50; /* orange border on top */
        }
        h2 {
            color: #1e90ff; /* blue color for the heading */
        }
        input[type="text"],
        input[type="password"],
        button {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }
        input[type="text"],
        input[type="password"] {
            height: 40px;
            border-color: #1e90ff; /* blue border for inputs */
        }
        button {
            background-color: #ff7f50; /* orange background for button */
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #e67347; /* slightly darker orange on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <input type="text" id="resetSecurityWord" name="resetSecurityWord" placeholder="Enter Security Word">
        <form id="createForm" action="javascript:void(0)">
            <button type="submit" id="checkSecurityWordBtn">Check Security Word</button>
        </form>
        <form id="resetForm" action="{{route('reset')}}" method="POST">
            @csrf
            <input type="hidden" id="hiddenSecurityWord" name="security_word">
            <input type="password" id="newPassword" name="newPassword" placeholder="New Password" style="display: none">
            <button type="submit" id="resetPasswordBtn" style="display: none">Reset Password</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#checkSecurityWordBtn').click(function() {
                var securityWord = $('#resetSecurityWord').val();
                
                $.ajax({
                    url: '{{ url('verify_mot') }}', // Remplacez par votre route réelle
                    method: 'POST',
                    data: { 
                        security_word: securityWord,
                        _token: '{{ csrf_token() }}' // Ajoutez le jeton CSRF
                    },
                    success: function(response) {
                        if (response.success) {
                            console.log("success");
                            // Enable and show password reset fields
                            $('#hiddenSecurityWord').val(securityWord);
                            $('#newPassword').show();
                            $('#resetPasswordBtn').show();
                        } else {
                            alert('Security word not found.');
                        }
                    },
                    error: function(error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>
</body>
</html>
