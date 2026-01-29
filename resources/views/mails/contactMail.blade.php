<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Ticket Booking System</title>
    </head>
    <body>
        <div class="container">
            <div class="row col-md-12">
                <h4>User Registration request</h4>
                <p>
                    <strong>Subject: </strong>{{$data['subject']}}
                </p>
                <p>
                    <strong>Email: </strong>{{$data['email']}}
                </p>
                <p>
                    <strong>Message Body: </strong>{{$data['msg']}}
                </p>
            </div>
        </div>
    </body>
</html>
