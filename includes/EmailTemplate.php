<?php

/**
 * Generates a professional HTML email template for sending an OTP.
 * @param string $otp The 6-digit OTP code.
 * @return string The complete HTML email body.
 */
function getOtpEmailTemplate($otp) {
    $currentYear = date('Y');
    
    // The core of the email content
    $emailBody = "
        <p style='font-size: 16px; color: #555; line-height: 1.6;'>
            Hello,
        </p>
        <p style='font-size: 16px; color: #555; line-height: 1.6;'>
            Thank you for starting your registration with Barakath Seller. To complete the process and verify your email address, please use the following security code:
        </p>
        <div style='text-align: center; margin: 25px 0;'>
            <h1 style='font-size: 36px; color: #4CAF50; letter-spacing: 5px; background-color: #f1f1f1; padding: 20px; border-radius: 8px; display: inline-block; font-family: monospace;'>
                {$otp}
            </h1>
        </div>
        <p style='font-size: 16px; color: #555; line-height: 1.6;'>
            This code will expire in 5 minutes. If you did not request this code, please ignore this email.
        </p>
        <p style='font-size: 16px; color: #555; line-height: 1.6;'>
            Sincerely,<br>
            The Barakath Team
        </p>
    ";

    // The full HTML template with a professional design
    $htmlTemplate = "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Barakath Seller - Verification Code</title>
        <style>
            body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; background-color: #f4f4f4; margin: 0; padding: 0; }
            .email-container { max-width: 600px; margin: 20px auto; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.05); }
            .header { text-align: center; padding-bottom: 20px; border-bottom: 1px solid #eeeeee; }
            .header h1 { color: #4CAF50; margin: 0; font-size: 24px; }
            .content { padding: 20px 0; }
            .footer { text-align: center; padding-top: 20px; border-top: 1px solid #eeeeee; font-size: 12px; color: #999; }
        </style>
    </head>
    <body>
        <div class='email-container'>
            <div class='header'>
                <h1>Barakath Seller</h1>
            </div>
            <div class='content'>
                {$emailBody}
            </div>
            <div class='footer'>
                <p>&copy; {$currentYear} Barakath Seller. All rights reserved.</p>
            </div>
        </div>
    </body>
    </html>";

    return $htmlTemplate;
}
