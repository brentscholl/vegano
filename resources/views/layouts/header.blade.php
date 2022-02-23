<?php
    /**
     * Template Displays Head section
     *
     * @package         Vegano
     * @author          Stealth Media
     * @copyright       2019 Vegano
     * @link            http://www.vegano.ca
     * @since           1.0.0
     */
?>
        <!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <style>
        .se-pre-con {
            position: fixed;
            display: table-cell;
            vertical-align: middle;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            z-index: 9998;
            background: #fff;
            color: #00b1b3;
            text-align: center;
        }

        .spinner {
            width: 40px;
            height: 40px;
            position: absolute;
            top: 50%;
            left: 50%;
            margin-top: -20px;
            margin-left: -20px;
            text-align: center;

            -webkit-animation: sk-rotate 2.0s infinite linear;
            animation: sk-rotate 2.0s infinite linear;
        }

        .dot1, .dot2 {
            width: 60%;
            height: 60%;
            display: inline-block;
            position: absolute;
            top: 0;
            background-color: #122e34;
            border-radius: 100%;

            -webkit-animation: sk-bounce 2.0s infinite ease-in-out;
            animation: sk-bounce 2.0s infinite ease-in-out;
        }

        .dot2 {
            top: auto;
            bottom: 0;
            -webkit-animation-delay: -1.0s;
            animation-delay: -1.0s;
            background-color: #90a169!important;
        }

        @-webkit-keyframes sk-rotate { 100% { -webkit-transform: rotate(360deg) }}
        @keyframes sk-rotate { 100% { transform: rotate(360deg); -webkit-transform: rotate(360deg) }}

        @-webkit-keyframes sk-bounce {
            0%, 100% { -webkit-transform: scale(0.0) }
            50% { -webkit-transform: scale(1.0) }
        }

        @keyframes sk-bounce {
            0%, 100% {
                transform: scale(0.0);
                -webkit-transform: scale(0.0);
            } 50% {
                  transform: scale(1.0);
                  -webkit-transform: scale(1.0);
              }
        }
    </style>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
            content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">
    <meta name="theme-color" content="#1d5086"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('layouts.meta')
    @yield('meta')

    <script type='application/ld+json'>{"@context":"https:\/\/schema.org","@type":"WebSite","@id
        ":"#website","url":"https:\/\/www.vegano.ca\/","name":"Vegano","potentialAction":{"@type":"SearchAction","target":"http:\/\/www.vegano.ca\/?s={search_term_string}","query-input":"required name=search_term_string"}}


    </script>
    <script type='application/ld+json'>{"@context
        ":"https:\/\/schema.org","@type":"Organization","url":"http:\/\/www.vegano.ca\/","sameAs":["https:\/\/www.facebook.com\/vegano\/","https:\/\/twitter.com\/Vegano"],"@id
        ":"http:\/\/www.vegano.ca\/#organization","name":"Vegano","logo":"http:\/\/www.vegano.ca\/images\/vegano-social-fb-image.png"}


    </script>

{{--    <link rel="shortcut icon" type="image/png" href="/images/favicon.png"/>--}}

    <!--[if lt IE 9]>
    <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fonts -->
    <link href="https://use.typekit.net/meh1zjj.css" rel="stylesheet">

    <!-- Style Sheets -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
            integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    @yield('scripts.header')
    <link href="{{ asset('css/main.css') }}" media="all" rel="stylesheet" type="text/css"/>
@yield('styles')

<!-- Global site tag (gtag.js) - Google Analytics -->
{{--    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-127106150-1"></script>--}}
{{--    <script>--}}
{{--        window.dataLayer = window.dataLayer || [];--}}

{{--        function gtag() {--}}
{{--            dataLayer.push(arguments);--}}
{{--        }--}}

{{--        gtag('js', new Date());--}}

{{--        gtag('config', 'UA-127106150-1');--}}
{{--    </script>--}}

    <title>
        @yield('title', 'Vegano')
    </title>
</head>
<body class="@yield('body-class')">

<div class="se-pre-con">
    <div class="spinner">
        <div class="dot1"></div>
        <div class="dot2"></div>
    </div>
</div>
