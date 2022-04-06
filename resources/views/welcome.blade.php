<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>PROFINANCE TEST</title>

    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
    <form id="mainForm">
        <label> Input url
            <input name="url" type="url" id="url"/>
        </label>
        <button id="submitMainForm">Submit</button>
    </form>
    <div id="serverAnswer"></div>
</body>
<script src="{{ mix('/js/app.js') }}"></script>
</html>
