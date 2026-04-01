<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Credentials</title>
</head>
<body style="margin:0;padding:0;background:#eef2ff;font-family:Arial,sans-serif;color:#172033;">
    <div style="width:100%;padding:34px 18px;background:linear-gradient(180deg,#07152b 0%,#123a74 100%);">
        <div style="max-width:640px;margin:0 auto;">
            <div style="padding:0 6px 18px;">
                <p style="margin:0;color:#9ec5ff;font-size:12px;font-weight:700;letter-spacing:.24em;text-transform:uppercase;">CodeInYourself</p>
                <h1 style="margin:10px 0 0;color:#ffffff;font-size:30px;line-height:1.15;font-weight:800;">Your {{ $roleLabel }} account is ready</h1>
            </div>

            <div style="background:#ffffff;border-radius:28px;overflow:hidden;box-shadow:0 24px 60px rgba(7,21,43,0.22);">
                <div style="background:radial-gradient(circle at top left,#60a5fa 0%,#2563eb 42%,#0f172a 100%);padding:32px;">
                    <p style="margin:0;color:#e0f2fe;font-size:15px;line-height:1.7;">
                        Hi {{ $recipientName }}, your CodeInYourself {{ strtolower($roleLabel) }} account has been created successfully. Use the credentials below to sign in.
                    </p>
                </div>

                <div style="padding:34px 32px 22px;">
                    <div style="margin-bottom:20px;border-radius:22px;background:#f8fbff;border:1px solid #d8e7ff;padding:22px 20px;">
                        <p style="margin:0 0 8px;color:#5a6780;font-size:12px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;">Login Email</p>
                        <p style="margin:0;color:#0f172a;font-size:20px;line-height:1.5;font-weight:700;">{{ $email }}</p>
                    </div>

                    <div style="margin-bottom:24px;border-radius:22px;background:linear-gradient(135deg,#eff6ff 0%,#dbeafe 100%);border:1px solid #bfdbfe;padding:22px 20px;">
                        <p style="margin:0 0 8px;color:#5a6780;font-size:12px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;">Temporary Password</p>
                        <p style="margin:0;color:#0f172a;font-size:28px;line-height:1.2;font-weight:800;letter-spacing:.08em;">{{ $password }}</p>
                    </div>

                    <div style="margin-bottom:24px;border-radius:20px;background:#f8fbff;border:1px solid #d8e7ff;padding:18px 20px;">
                        <p style="margin:0 0 8px;color:#0f172a;font-size:14px;font-weight:700;">Next step</p>
                        <p style="margin:0;color:#5b677d;font-size:14px;line-height:1.7;">
                            Sign in with these credentials, then change the password from settings after your first login for better security.
                        </p>
                    </div>

                    <a href="{{ $loginUrl }}" style="display:inline-block;border-radius:16px;background:#2563eb;color:#ffffff;text-decoration:none;font-size:14px;font-weight:700;padding:14px 22px;">
                        Open Login Page
                    </a>
                </div>

                <div style="padding:0 32px 30px;">
                    <div style="border-radius:20px;background:#fff7ed;border:1px solid #fed7aa;padding:18px 20px;">
                        <p style="margin:0;color:#7c2d12;font-size:14px;line-height:1.7;">
                            This message contains a temporary password. Please keep it private and do not forward this email.
                        </p>
                    </div>
                </div>
            </div>

            <p style="margin:18px 8px 0;color:#d7e7ff;font-size:12px;line-height:1.7;text-align:center;">
                Sent automatically by CodeInYourself Accounts
            </p>
        </div>
    </div>
</body>
</html>

