<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Test Email</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 0;
            color: #334155;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
        }
        .header {
            background-color: #4f46e5;
            padding: 30px 40px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .content {
            padding: 40px;
            line-height: 1.6;
        }
        .content p {
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 16px;
        }
        .success-box {
            background-color: #ecfdf5;
            border-left: 4px solid #10b981;
            padding: 15px 20px;
            border-radius: 4px;
            margin-bottom: 25px;
        }
        .success-box p {
            margin: 0;
            color: #065f46;
            font-weight: 500;
        }
        .footer {
            background-color: #f1f5f9;
            padding: 20px 40px;
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>{{ $fromName }}</h1>
        </div>
        <div class="content">
            <p>Hello there,</p>
            
            <div class="success-box">
                <p>🎉 Your SMTP configuration is working perfectly!</p>
            </div>
            
            <p>This is a test email sent from your <b>{{ $fromName }}</b> to verify that your mail settings are configured correctly.</p>
            
            <!-- <p>If you received this email, it means your application is now ready to send out notifications, password resets, and other important alerts.</p> -->
            
            <p>Best regards,<br>
            <b>The {{ $fromName }} Team</b></p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ $fromName }}. All rights reserved.
        </div>
    </div>
</body>
</html>
