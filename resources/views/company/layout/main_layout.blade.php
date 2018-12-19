<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ $data['title'] or 'Home' }}</title>

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('/sb_assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="{{ asset('/sb_assets/vendor/metisMenu/metisMenu.min.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="{{ asset('/sb_assets/dist/css/sb-admin-2.css') }}" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="{{ asset('/sb_assets/vendor/morrisjs/morris.css') }}" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="{{ asset('/sb_assets/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">

    <!-- DataTables CSS -->
    <link href="{{ asset('/sb_assets/vendor/datatables-plugins/dataTables.bootstrap.css') }}" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="{{ asset('/sb_assets/vendor/datatables-responsive/dataTables.responsive.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

    <link href="{{ asset('/css/custom_accounts.css') }}" rel="stylesheet">

    <!-- jQuery -->
    <script src="{{ asset('/sb_assets/vendor/jquery/jquery.min.js') }}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" {{--style="margin-bottom: 0"--}} >
        <div class="navbar-header custom_header">
            {{--<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>--}}
            <a href="{{ route('home')  }}" class="">
                <img src="{{asset('/images/logo/logo.png')}}" alt="JobHelp">
            </a>
            {{--<a class="navbar-brand" href="{{ url('/') }}">JobHelp</a>--}}
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">

            <li class="dropdown">
                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                    <i class="fa fa-bell fa-fw"></i> {{--<i class="fa fa-caret-down"></i>--}}
                    <span class="label label-success" id="new_app_bill">{{ $new_applications or 0 }}</span>
                </a>
                <ul class="dropdown-menu dropdown-alerts">
                    @if((int)$new_applications > 0)
                    <li>
                        <a href="{{ url('/company/jobs') }}">
                            <div>
                                <i class="fa fa-tasks fa-fw"></i> New Applications
                                <span class="pull-right text-muted small">{{ $new_applications or 0 }}</span>
                            </div>
                        </a>
                    </li>
                    @else
                        <li><a href="">You have not new notifications</a></li>
                    @endif
                </ul>
                <!-- /.dropdown-alerts -->
            </li>
            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="{{ url('/company/profile') }}"><i class="fa fa-user fa-fw"></i> Your Profile</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="{{ url('/company/logout') }}"
                           onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                            <i class="fa fa-sign-out fa-fw"></i>
                            Logout
                        </a>
                        <form id="logout-form" action="{{ url('/company/logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

       @include('company.layout.left_sidebar')
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">

    @yield('content')

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Bootstrap Core JavaScript -->
<script src="{{ asset('/sb_assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="{{ asset('/sb_assets/vendor/metisMenu/metisMenu.min.js') }}"></script>

<!-- Morris Charts JavaScript -->
{{--<script src="{{ asset('/sb_assets/vendor/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('/sb_assets/vendor/morrisjs/morris.min.js') }}"></script>
<script src="{{ asset('/sb_assets/data/morris-data.js') }}"></script>--}}

<!-- DataTables JavaScript -->
<script src="{{ asset('/sb_assets/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/sb_assets/vendor/datatables-plugins/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('/sb_assets/vendor/datatables-responsive/dataTables.responsive.js') }}"></script>

<!-- Custom Theme JavaScript -->
<script src="{{ asset('/sb_assets/dist/js/sb-admin-2.js') }}"></script>

<!-- Bootstrap Date-Picker Plugin -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>


<script>
    $(document).ready(function() {

        $('#dataTables-example').DataTable({
            responsive: true,
            "order": [[0 , "desc"]]
        });

        var date_input=$('input[name="closing_date"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        var options={
            format: 'yyyy-mm-dd',
            container: container,
            todayHighlight: true,
            autoclose: true,
        };
        date_input.datepicker(options);

    });

    $(".job_skills").select2({
        placeholder: "Select Skills",
        allowClear: true,
        closeOnSelect: true,
        width: 'resolve'
    });

</script>

</body>

</html>
