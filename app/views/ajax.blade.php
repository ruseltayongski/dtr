@extends('layouts.app')

@section('content')

    <p>
        <button onclick="request()">Ajax</button>
    </p>

@endsection

@section('js')
    <script>
        function request()
        {
            var data = 'data=1';
            $.get('ajax1',data,function(data){
                console.log(data);
            });
        }

    </script>
@endsection