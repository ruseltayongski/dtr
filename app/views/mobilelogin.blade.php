<html>
    <head></head>
    <body>
        <form action="{{ asset('mobile/login')}}" method="POST">
            <input type="text" name="userid" />
            <input type="text" name="imei" />
            <input type="submit" name="submit" value="Submit" />
        </form>
    </body>
</html>