<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sumber Motor - Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            -webkit-text-size-adjust: none;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dddddd;
        }
        .email-header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #dddddd;
        }
        .email-header h1 {
            margin: 0;
            color: #333333;
        }
        .email-body {
            padding: 20px;
            color: #555555;
        }
        .email-body p {
            margin: 0 0 15px 0;
            line-height: 1.6;
        }
        .email-body a {
            display: inline-block;
            background-color: #007bff;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .email-footer {
            text-align: center;
            padding: 20px;
            border-top: 1px solid #dddddd;
            color: #888888;
            font-size: 12px;
        }
        a {
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Sumber Motor</h1>
        </div>
        <div class="email-body">
            <p>Hello,</p>
            <p>You are receiving this email because we received a password reset request for your account.</p>
            <p>
                <a href="{{ $resetUrl }}" target="_blank">Reset Password</a>
            </p>
            <p>If you did not request a password reset, no further action is required.</p>
        </div>
        <div class="email-footer">
            <p>&copy; Sumber Motor. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
