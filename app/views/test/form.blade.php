<!DOCTYPE html>
<html lang="en">
<head>
    <title>Test Forms</title>
</head>
<body>
<form action="{{ asset('test/form') }}" method="POST">
    {{ csrf_field() }}
    <table border="0">
        <tr>
            <td><input type="radio" name="color" value="Red" /></td>
            <td><label for="color">Red</label></td>
        </tr>
        <tr>
            <td><input type="radio" name="color" value="Black" /></td>
            <td><label for="color">Black</label> </td>
        </tr>
        <tr>
            <td><input type="radio" name="color" value="Orange" /> </td>
            <td><label for="color">Orange</label> </td>
        </tr>
        <tr>
            <td><input type="submit" name="submit" value="Submit" /> </td>
        </tr>
    </table>
</form>
</body>
</html>