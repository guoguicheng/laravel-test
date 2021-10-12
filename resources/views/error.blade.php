<!doctype html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Error</title>

    @include('block.head')
</head>

<body>
    <div class="center">
        <h2>{{$msg??''}}</h2>
    </div>
</body>

</html>