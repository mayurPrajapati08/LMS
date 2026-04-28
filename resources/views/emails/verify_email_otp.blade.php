<!DOCTYPE html>
<html lang="en">

<head>
    <link rel='apple-touch-icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel='shortcut icon' href='https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg'>
    <link rel="icon" type="image/png" href="https://res.cloudinary.com/dqxg5hhfi/image/upload/e_background_removal/f_png/v1777354122/cyis_favicon_kkrbmh.jpg">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Email</title>
</head>

<body style="margin:0;padding:0;background:#fcf9fe;font-family:Arial,sans-serif;color:#231a28;">
    @php
        $isLoginOtp = ($purpose ?? 'email_verification') === 'login_two_factor';
        $isPasswordResetOtp = ($purpose ?? 'email_verification') === 'password_reset';
        $headline = $isLoginOtp
            ? 'Your Login OTP is ready'
            : ($isPasswordResetOtp ? 'Your Password Reset OTP is ready' : 'Your Signup OTP is ready');
        $intro = $isLoginOtp
            ? 'Hi '.$user->name.', use the login OTP below to finish signing in to your account.'
            : ($isPasswordResetOtp
                ? 'Hi '.$user->name.', use the password reset OTP below to continue changing your account password.'
                : 'Hi '.$user->name.', welcome to CodeInYourself. Use the signup OTP below to finish creating your account.');
        $finalNote = $isLoginOtp
            ? 'If you did not try to sign in, change your password right away and review your account activity.'
            : ($isPasswordResetOtp
                ? 'If you did not request a password reset, ignore this email and keep your current password private.'
                : 'If you did not create this account, you can ignore this no-reply email safely.');
        $otpLabel = $isLoginOtp ? 'Login OTP' : ($isPasswordResetOtp ? 'Password Reset OTP' : 'Signup OTP');
    @endphp
    <div style="width:100%;background:linear-gradient(180deg,#2f1236 0%,#6a3378 100%);padding:34px 18px;">
        <div style="max-width:640px;margin:0 auto;">
            <div style="padding:0 6px 18px;">
                <p style="margin:0;color:#e9d5f0;font-size:12px;font-weight:700;letter-spacing:.24em;text-transform:uppercase;">CodeInYourself</p>
                <h1 style="margin:10px 0 0;color:#ffffff;font-size:32px;line-height:1.15;font-weight:800;">{{ $headline }}</h1>
            </div>

            <div style="background:#ffffff;border-radius:28px;overflow:hidden;box-shadow:0 24px 60px rgba(75,35,86,0.18);">
                <div style="background:radial-gradient(circle at top left,#c79ad4 0%,#8f52a3 42%,#4b2356 100%);padding:32px;">
                    <table role="presentation" style="width:100%;border-collapse:collapse;">
                        <tr>
                            <td style="vertical-align:top;">
                                <div style="display:inline-block;padding:10px 14px;border-radius:999px;background:rgba(255,255,255,0.14);color:#f7edf9;font-size:12px;font-weight:700;letter-spacing:.14em;text-transform:uppercase;">
                                    No-Reply Mail
                                </div>
                                <p style="margin:18px 0 0;color:#f6edf9;font-size:15px;line-height:1.7;">
                                    {{ $intro }}
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>

                <div style="padding:34px 32px 22px;">
                    <div style="margin:0 0 14px;color:#7b6385;font-size:13px;font-weight:700;letter-spacing:.18em;text-transform:uppercase;">
                        {{ $otpLabel }}
                    </div>

                    <div style="margin:0 0 26px;padding:22px 20px;border-radius:22px;background:linear-gradient(135deg,#fcf6fe 0%,#f0e3f5 100%);border:1px solid #dbcde4;text-align:center;">
                        <span style="display:inline-block;font-size:38px;line-height:1;letter-spacing:.32em;font-weight:800;color:#4b2356;">{{ $otp }}</span>
                    </div>

                    <table role="presentation" style="width:100%;border-collapse:separate;border-spacing:0 12px;">
                        <tr>
                            <td style="width:42px;vertical-align:top;">
                                <div style="width:42px;height:42px;border-radius:14px;background:#f0e3f5;color:#6a3378;text-align:center;line-height:42px;font-size:20px;">1</div>
                            </td>
                            <td style="padding-left:14px;color:#5f4f67;font-size:15px;line-height:1.7;">
                                Enter this {{ strtolower($otpLabel) }} on the verification screen in your browser.
                            </td>
                        </tr>
                        <tr>
                            <td style="width:42px;vertical-align:top;">
                                <div style="width:42px;height:42px;border-radius:14px;background:#f7edf9;color:#6a3378;text-align:center;line-height:42px;font-size:20px;">2</div>
                            </td>
                            <td style="padding-left:14px;color:#5f4f67;font-size:15px;line-height:1.7;">
                                This {{ strtolower($otpLabel) }} expires in <strong style="color:#4b2356;">10 minutes</strong>.
                            </td>
                        </tr>
                        <tr>
                            <td style="width:42px;vertical-align:top;">
                                <div style="width:42px;height:42px;border-radius:14px;background:#f3e8f8;color:#6a3378;text-align:center;line-height:42px;font-size:20px;">3</div>
                            </td>
                            <td style="padding-left:14px;color:#5f4f67;font-size:15px;line-height:1.7;">
                                {{ $finalNote }}
                            </td>
                        </tr>
                    </table>
                </div>

                <div style="padding:0 32px 30px;">
                    <div style="border-radius:20px;background:#faf4fc;border:1px solid #e7d8ec;padding:18px 20px;">
                        <p style="margin:0 0 8px;color:#4b2356;font-size:14px;font-weight:700;">Important</p>
                        <p style="margin:0;color:#6d5a76;font-size:14px;line-height:1.7;">
                            This mailbox is not monitored for replies. For help, contact the CodeInYourself support team from inside the platform.
                        </p>
                    </div>
                </div>
            </div>

            <p style="margin:18px 8px 0;color:#eadcf1;font-size:12px;line-height:1.7;text-align:center;">
                Sent by CodeInYourself | No-Reply
            </p>
        </div>
    </div>
</body>

</html>
