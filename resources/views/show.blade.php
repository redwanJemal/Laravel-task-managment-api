<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
    </head>
    <body>
    <h2>
       {{ $task->title }}
    </h2>
    <form method="POST" action="">
        <input type="text" name="title" required /></br>
        <input type="text" name="body" required /></br>
        <input type="submit" name="submit" value="submit" />
    </form>
    </body>
</html>
