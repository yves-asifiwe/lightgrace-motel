<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation - Lightgrace Motel</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff;">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #0d4a35 0%, #1a6b4f 100%); padding: 30px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 28px;">Lightgrace Motel</h1>
            <p style="color: #38ef7d; margin: 10px 0 0 0; font-size: 16px;">Your Comfort, Our Priority</p>
        </div>

        <!-- Thank You Message -->
        <div style="padding: 30px;">
            <h2 style="color: #0d4a35; margin-top: 0;">Thank You for Your Booking!</h2>
            <p style="color: #666; line-height: 1.6;">
                Dear {{ $booking->customer_name }},
            </p>
            <p style="color: #666; line-height: 1.6;">
                Thank you for choosing Lightgrace Motel for your stay. We are pleased to confirm your reservation and look forward to welcoming you. Below are the details of your booking:
            </p>

            <!-- Booking Details -->
            <div style="background-color: #f9fbf9; border: 2px solid #e8f5e9; border-radius: 8px; padding: 20px; margin: 25px 0;">
                <h3 style="color: #0d4a35; margin-top: 0; border-bottom: 2px solid #38ef7d; padding-bottom: 10px;">Booking Details</h3>
                
                <div style="margin-bottom: 15px;">
                    <strong style="color: #0d4a35;">Booking Reference:</strong>
                    <span style="color: #666; margin-left: 10px;">#{{ $booking->id }}</span>
                </div>

                <div style="margin-bottom: 15px;">
                    <strong style="color: #0d4a35;">Room:</strong>
                    <span style="color: #666; margin-left: 10px;">{{ $booking->room->name ?? 'N/A' }}</span>
                </div>

                <div style="margin-bottom: 15px;">
                    <strong style="color: #0d4a35;">Check-in Date:</strong>
                    <span style="color: #666; margin-left: 10px;">{{ $booking->check_in ? $booking->check_in->format('F d, Y') : 'N/A' }}</span>
                </div>

                <div style="margin-bottom: 15px;">
                    <strong style="color: #0d4a35;">Check-out Date:</strong>
                    <span style="color: #666; margin-left: 10px;">{{ $booking->check_out ? $booking->check_out->format('F d, Y') : 'N/A' }}</span>
                </div>

                <div style="margin-bottom: 15px;">
                    <strong style="color: #0d4a35;">Total Price:</strong>
                    <span style="color: #38ef7d; margin-left: 10px; font-weight: bold; font-size: 18px;">${{ number_format($booking->total_price, 2) }}</span>
                </div>

                <div style="margin-bottom: 15px;">
                    <strong style="color: #0d4a35;">Payment Status:</strong>
                    <span style="color: #38ef7d; margin-left: 10px; font-weight: bold;">{{ ucfirst($booking->payment_status) }}</span>
                </div>

                <div style="margin-bottom: 15px;">
                    <strong style="color: #0d4a35;">Booking Status:</strong>
                    <span style="color: #38ef7d; margin-left: 10px; font-weight: bold;">{{ ucfirst($booking->booking_status) }}</span>
                </div>
            </div>

            <!-- Room Information -->
            @if($booking->room)
            <div style="background-color: #f9fbf9; border: 2px solid #e8f5e9; border-radius: 8px; padding: 20px; margin: 25px 0;">
                <h3 style="color: #0d4a35; margin-top: 0; border-bottom: 2px solid #38ef7d; padding-bottom: 10px;">Room Information</h3>
                
                <div style="margin-bottom: 15px;">
                    <strong style="color: #0d4a35;">Room Name:</strong>
                    <span style="color: #666; margin-left: 10px;">{{ $booking->room->name }}</span>
                </div>

                <div style="margin-bottom: 15px;">
                    <strong style="color: #0d4a35;">Price per Night:</strong>
                    <span style="color: #666; margin-left: 10px;">${{ $booking->room->price }}</span>
                </div>

                <div style="margin-bottom: 15px;">
                    <strong style="color: #0d4a35;">Capacity:</strong>
                    <span style="color: #666; margin-left: 10px;">{{ $booking->room->capacity ?? 'N/A' }} guest(s)</span>
                </div>

                @if($booking->room->description)
                <div style="margin-bottom: 15px;">
                    <strong style="color: #0d4a35;">Description:</strong>
                    <p style="color: #666; margin: 10px 0 0 0; line-height: 1.6;">{{ $booking->room->description }}</p>
                </div>
                @endif
            </div>
            @endif

            <!-- Important Information -->
            <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 25px 0;">
                <h4 style="color: #856404; margin-top: 0;">Important Information</h4>
                <ul style="color: #856404; margin: 10px 0; padding-left: 20px;">
                    <li>Please arrive at the reception by 2:00 PM for check-in</li>
                    <li>Check-out time is 11:00 AM</li>
                    <li>Valid ID is required at check-in</li>
                    <li>Contact us for any changes or cancellations</li>
                </ul>
            </div>

            <!-- Contact Information -->
            <div style="text-align: center; margin: 30px 0;">
                <p style="color: #666; margin-bottom: 10px;">Need help? Contact us:</p>
                <p style="color: #0d4a35; margin: 5px 0;">Email: info@lightgrace.com</p>
                <p style="color: #0d4a35; margin: 5px 0;">Phone: +1 (555) 123-4567</p>
            </div>

            <!-- Thank You Again -->
            <div style="text-align: center; margin-top: 30px;">
                <p style="color: #666; font-style: italic;">"We look forward to making your stay memorable!"</p>
                <p style="color: #0d4a35; font-weight: bold; margin-top: 10px;">The Lightgrace Motel Team</p>
            </div>
        </div>

        <!-- Footer -->
        <div style="background-color: #0d4a35; padding: 20px; text-align: center;">
            <p style="color: #ffffff; margin: 0; font-size: 14px;">&copy; {{ date('Y') }} Lightgrace Motel. All rights reserved.</p>
            <p style="color: #38ef7d; margin: 10px 0 0 0; font-size: 12px;">This is an automated email. Please do not reply.</p>
        </div>
    </div>
</body>
</html>
