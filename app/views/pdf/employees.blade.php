
<!DOCTYPE html>
<html>
<head>

    <title>
       Employees Print out
    </title>
    <style>
        .table-info tr td:first-child {
            font-weight:bold;
            color: #2b542c;
        }
        body {
            font-family: "DejaVu Sans", sans-serif;
            font-size: x-small;
            padding: -25px;
        }
        table{
            border-spacing: 0;
            margin-top: 30px;
        }

        table td {
            padding-top: 10px;
            padding-right: 5px;
            padding-bottom: 3px;
            padding-left: 5px;
        }
    </style>

</head>

<body>
<table border="1">
    <tr>
        <td class="col-md-1"><img height="120" width="120" src="{{ asset('public/img/ro7.png') }}" /></td>
        <td class="col-lg-10" style="text-align: center;">
            Repulic of the Philippines <br />
            <strong>DEPARTMENT OF HEALTH REGIONAL OFFICE NO. VII</strong><br />
            Osmeña Boulevard, Cebu City, 6000 Philippines <br />
            Regional Director's Office Tel. No. (032) 253-635-6355 Fax No. (032) 254-0109 <br />
            Official Website:<a target="_blank" href="http://www.ro7.doh.gov.ph"><u>http://www.ro7.doh.gov.ph</u></a> Email Address: dohro7{{ '@' }}gmail.com
        </td>
        <td class="col-md-10"><img height="120" width="120" src="{{ asset('public/img/ro7.png') }}" /> </td>
    </tr>
</table>

@if(count($users) > 0)
    <h3>
        @if($type == "JO")
            Job Order employee list
        @elseif($type == "REG")
            Regular employee list
        @endif
    </h3>
    <p>Total : <strong>{{ count($users) }}</strong></p>
    @foreach($users as $user)
        <p>
            <b>{{ $user->userid }}</b>
            <span style="margin-left: 10px;">{{ $user->lname . ", " . $user->fname }}</span>
        </p>
    @endforeach
@endif

</body>
</html>