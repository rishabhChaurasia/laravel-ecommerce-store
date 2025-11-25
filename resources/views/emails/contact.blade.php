<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
            background-color: #ffffff;
            color: #09090b;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .card {
            border: 1px solid #e4e4e7;
            border-radius: 12px;
            padding: 32px;
            background-color: #ffffff;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        }
        .header {
            margin-bottom: 24px;
        }
        .title {
            font-size: 24px;
            font-weight: 600;
            letter-spacing: -0.025em;
            margin: 0 0 8px 0;
            color: #09090b;
        }
        .subtitle {
            font-size: 14px;
            color: #71717a;
            margin: 0;
        }
        .divider {
            height: 1px;
            background-color: #e4e4e7;
            margin: 24px 0;
            border: none;
        }
        .field {
            margin-bottom: 20px;
        }
        .label {
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #71717a;
            margin-bottom: 8px;
            display: block;
        }
        .value {
            font-size: 16px;
            color: #09090b;
            background-color: #f4f4f5;
            padding: 12px 16px;
            border-radius: 6px;
            margin: 0;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #a1a1aa;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1 class="title">New Contact Message</h1>
                <p class="subtitle">You have received a new message from your website contact form.</p>
            </div>

            <hr class="divider">

            <div class="field">
                <span class="label">From</span>
                <p class="value">{{ $data['name'] }} <span style="color: #71717a; font-size: 14px;">&lt;{{ $data['email'] }}&gt;</span></p>
            </div>

            <div class="field">
                <span class="label">Message</span>
                <p class="value" style="white-space: pre-wrap;">{{ $data['message'] }}</p>
            </div>
            
            <hr class="divider">
            
            <div style="text-align: center;">
                <a href="mailto:{{ $data['email'] }}" style="display: inline-block; background-color: #18181b; color: #ffffff; text-decoration: none; padding: 10px 20px; border-radius: 6px; font-size: 14px; font-weight: 500;">Reply via Email</a>
            </div>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
