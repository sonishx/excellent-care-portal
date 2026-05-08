<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: 'Inter', sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 10px; }
        .header { text-align: center; margin-bottom: 30px; }
        .btn { display: inline-block; padding: 12px 24px; background: #6f2dbd; color: white; text-decoration: none; border-radius: 8px; font-weight: bold; }
        .footer { margin-top: 30px; font-size: 12px; color: #777; text-align: center; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1 style="color: #6f2dbd;">Excellent Care Services</h1>
        </div>
        
        <h2>You've Been Invited!</h2>
        <p>Hello,</p>
        <p>You have been invited to join the **Excellent Care Portal** as a **{{ ucfirst($invitation->role) }}**.</p>
        <p>Our portal provides a secure environment for managing care plans, documents, and clinical communication.</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <a href="{{ $link }}" class="btn">Create Your Account</a>
        </div>
        
        <p>Alternatively, you can copy and paste this link into your browser:</p>
        <p style="word-break: break-all; color: #6f2dbd;">{{ $link }}</p>
        
        <p>This invitation will expire on **{{ $invitation->expires_at->format('M d, Y') }}**.</p>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Excellent Care Services. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
