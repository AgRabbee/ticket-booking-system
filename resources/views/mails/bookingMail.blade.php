@php
    $fee = 21;
    $ticketPrice = $data[0]->fare * count($data);
@endphp
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Your booking · Ticket Booking System</title>
    </head>
    <body style="margin:0; padding:24px 12px; background:#F4F7F5; color:#16201B; font-family:Roboto, Arial, Helvetica, sans-serif; font-size:16px; line-height:1.5;">
        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:600px; margin:0 auto; background:#FFFFFF; border-radius:16px; overflow:hidden;">
            <tr>
                <td style="background:#003527; color:#FFFFFF; padding:24px 28px;">
                    <div style="font-size:14px; color:#B4D8C9;">Ticket Booking System</div>
                    <div style="font-size:26px; font-weight:bold; margin-top:6px;">Your seats are booked</div>
                </td>
            </tr>
            <tr>
                <td style="padding:28px;">
                    <p style="margin:0 0 16px;">Hi {{ $data[0]->first_name . ' ' . $data[0]->last_name }},</p>
                    <p style="margin:0 0 20px;">Here are the details of your journey. Show this email or your printed ticket at the counter before boarding.</p>

                    <div style="font-size:22px; font-weight:bold; color:#006A4E; margin-bottom:16px;">{{ $data[0]->startPoint }} to {{ $data[0]->endPoint }}</div>

                    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom:24px;">
                        <tr>
                            <td style="padding:6px 0; color:#44524B;">Operator</td>
                            <td style="padding:6px 0; text-align:right;">{{ $data[0]->company_name }}</td>
                        </tr>
                        <tr>
                            <td style="padding:6px 0; color:#44524B;">Payment ID</td>
                            <td style="padding:6px 0; text-align:right;">#{{ $data[0]->id }}</td>
                        </tr>
                        <tr>
                            <td style="padding:6px 0; color:#44524B;">Payment date</td>
                            <td style="padding:6px 0; text-align:right;">{{ date('j M Y', strtotime($data[0]->created_at)) }}</td>
                        </tr>
                    </table>

                    <table width="100%" cellpadding="0" cellspacing="0" style="border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th align="left" style="padding:10px 0; border-bottom:1px solid #D3DDD7; font-size:12px; color:#44524B;">SEAT</th>
                                <th align="left" style="padding:10px 0; border-bottom:1px solid #D3DDD7; font-size:12px; color:#44524B;">DATE</th>
                                <th align="left" style="padding:10px 0; border-bottom:1px solid #D3DDD7; font-size:12px; color:#44524B;">DEPARTS</th>
                                <th align="right" style="padding:10px 0; border-bottom:1px solid #D3DDD7; font-size:12px; color:#44524B;">FARE (BDT)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $line)
                                <tr>
                                    <td style="padding:10px 0; border-bottom:1px solid #D3DDD7;"><strong>{{ $line->seat_number }}</strong></td>
                                    <td style="padding:10px 0; border-bottom:1px solid #D3DDD7;">{{ $line->date }}</td>
                                    <td style="padding:10px 0; border-bottom:1px solid #D3DDD7;">{{ $line->start_time }}</td>
                                    <td align="right" style="padding:10px 0; border-bottom:1px solid #D3DDD7;">{{ number_format($line->fare) }}</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td colspan="3" style="padding:10px 0; color:#44524B;">Ticket price</td>
                                <td align="right" style="padding:10px 0;">{{ number_format($ticketPrice) }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="padding:4px 0 10px; color:#44524B;">System fee</td>
                                <td align="right" style="padding:4px 0 10px;">{{ $fee }}</td>
                            </tr>
                            <tr>
                                <td colspan="3" style="padding:12px 0; border-top:2px solid #16201B;"><strong>Total</strong></td>
                                <td align="right" style="padding:12px 0; border-top:2px solid #16201B;"><strong>BDT {{ number_format($ticketPrice + $fee) }}</strong></td>
                            </tr>
                        </tbody>
                    </table>

                    <p style="margin:24px 0 0; color:#44524B;">Thanks for travelling with us.</p>
                </td>
            </tr>
        </table>
    </body>
</html>
