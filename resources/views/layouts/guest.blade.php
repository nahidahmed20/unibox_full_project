<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <style>
        body{margin:0;background:#f3f4f6;color:#111827;font:16px/1.6 system-ui,sans-serif}
        main{max-width:440px;margin:8vh auto;padding:32px;background:white;border-radius:12px}
        input{box-sizing:border-box;display:block;width:100%;padding:10px;margin:6px 0 16px;border:1px solid #9ca3af;border-radius:6px}
        button{padding:10px 18px;background:#047857;color:white;border:0;border-radius:6px;cursor:pointer}
        a{color:#047857} label{display:block} input[type=checkbox]{display:inline;width:auto}
        @media(max-width:520px){main{margin:24px 12px;padding:20px}}
    </style>
</head>
<body><main><a href="{{ route('home') }}">{{ config('app.name') }}</a>{{ $slot }}</main></body>
</html>
