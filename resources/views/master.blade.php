<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <meta name="base-url" content="{{ url('/') }}">
    <title>{{setting()->get('company_name')}} - @yield('title')</title>

    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons'
          rel="stylesheet"
          type="text/css"
    >
{{--    <link href="{{ url (mix('/css/app.css')) }}" rel="stylesheet">--}}
<!-- Styles -->
    <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
</head>
<body>

<div id="app">
    <v-app id="inspire">
        <app-navbar></app-navbar>
        <v-content>
            <v-container fluid fill-height>
                @yield('content')
            </v-container>
        </v-content>
{{--        --}}
{{--        <v-footer color="indigo" app>--}}
{{--            <span class="white--text">&copy; {{\Illuminate\Support\Carbon::now()->year}}</span>--}}
{{--        </v-footer>--}}
{{--        --}}
    </v-app>
</div>
<script src="{{ url (mix('/js/app.js')) }}" type="text/javascript"></script>
</body>
</html>
