<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>{{ $page_title or "ProGest" }}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- Bootstrap 3.3.2 -->
        <link href="{{ asset("/bower_components/admin-lte/bootstrap/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
        <!-- Bootstrap 3.3.2 -->
        <link href="{{ asset("/css/style.css") }}" rel="stylesheet" type="text/css" />
        <!-- Font Awesome Icons -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        <link href="http://code.ionicframework.com/ionicons/2.0.0/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{asset("/bower_components/admin-lte/plugins/select2/select2.min.css")}}" rel="stylesheet" type="text/css" />
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        -->
        <link href="{{ asset("/bower_components/admin-lte/dist/css/skins/skin-green.min.css")}}" rel="stylesheet" type="text/css" />
        <link href="{{ asset("/bower_components/admin-lte/plugins/datepicker/datepicker3.css")}}" rel="stylesheet" type="text/css" />

        <!-- jQuery 2.1.3 -->
        <script src="{{ asset ("/bower_components/admin-lte/plugins/jQuery/jQuery-2.1.4.min.js") }}"></script>
        <script src="{{asset("/js/jquery.maskedinput.js")}}" type="text/javascript"></script>
        <script src="{{asset("/js/jquery.maskMoney.js")}}" type="text/javascript"></script>
        <script src="{{asset("/bower_components/admin-lte/plugins/select2/select2.full.min.js")}}" type="text/javascript"></script>
        <script src="{{asset("/bower_components/admin-lte/plugins/datatables/jquery.dataTables.min.js")}}" type="text/javascript"></script>
        <script src="{{asset("/bower_components/admin-lte/plugins/datatables/dataTables.bootstrap.min.js")}}" type="text/javascript"></script>
        <script src="{{asset("/bower_components/admin-lte/plugins/datepicker/bootstrap-datepicker.js")}}" type="text/javascript"></script>
        <script src="{{asset("/bower_components/admin-lte/plugins/datepicker/locales/bootstrap-datepicker.pt-BR.js")}}" type="text/javascript"></script>
        <script src="{{asset("/js/mask_validator.js")}}" type="text/javascript"></script>


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-green fixed">
        <div class="wrapper">

            <!-- Header -->
            @include('template/header')

            <!-- Sidebar -->
            @include('template/sidebar')

            @yield('content')

            <!-- Footer -->
            @include('template/footer')

        </div><!-- ./wrapper -->

        <!-- REQUIRED JS SCRIPTS -->


        <!-- Bootstrap 3.3.2 JS -->
        <script src="{{ asset ("/bower_components/admin-lte/bootstrap/js/bootstrap.min.js") }}" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset ("/bower_components/admin-lte/dist/js/app.min.js") }}" type="text/javascript"></script>
        <!-- Optionally, you can add Slimscroll and FastClick plugins.
              Both of these plugins are recommended to enhance the
              user experience -->
        <!-- Laravel DELETE plugin -->
        <script src="{{ asset ("/js/laravel.js") }}"></script>
        <script src="{{ asset ("/js/empenho.js?v=3") }}"></script>
        <script src="{{ asset ("/js/materiais.js") }}"></script>
        <script src="{{ asset ("/js/getPDF.js") }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" integrity="sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwKvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs" crossorigin="anonymous"></script>

    </body>
</html>