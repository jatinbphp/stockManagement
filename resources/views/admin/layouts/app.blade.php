<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="{{asset('assets/admin/dist/img/favicon.png')}}" type="image/x-icon" />
    <title>@if(isset($menu)) {{$menu}} | @endif {{ config('app.name', 'SRS') }}</title>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content = "28800; url={{ route('login') }}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/dist/css/adminlte.min.css') }}?{{ time() }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/iCheck/flat/blue.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/iCheck/all.css')}}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/jqvmap/jqvmap.min.css') }}"> -->
    <!-- <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}"> -->
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/dist/css/custom.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/admin/plugins/ladda/ladda-themeless.min.css')}}">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    @yield('style')
</head>
<body class="hold-transition sidebar-mini sidebar-collapse" id="bodyid">
<div class="wrapper">
    <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('admin/dashboard') }}" class="nav-link"></a>
            </li>
        </ul>
    </nav>
    <aside class="main-sidebar sidebar-dark-primary elevation-4" id="left-menubar" style="height: 100%; min-height:0!important; overflow-x: hidden;">
        <a href="{{ url('admin/dashboard') }}" class="brand-link" style="text-align: center">
            <img src="{{url('assets/admin/dist/img/small_logo.png')}}" style="width: 40%;" />
        </a>

        <div class="sidebar">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <li class="nav-item has-treeview @if(isset($menu) && $menu=='Edit Profile') menu-open  @endif" style="border-bottom: 1px solid #4f5962; margin-bottom: 4.5%;">

                        <a href="#" class="nav-link @if(isset($menu) && $menu=='Edit Profile') active  @endif">
                            @if(!empty(Auth::user()->image) && file_exists(Auth::user()->image))
                                <img src=" {{asset(Auth::user()->image)}}" class="img-circle elevation-2" alt="User Image" style="width: 2.1rem; margin-right: 1.5%;">
                            @else
                                <img src=" {{url('assets/admin/dist/img/no-image.png')}}" class="img-circle elevation-2" alt="User Image" style="width: 2.1rem; margin-right: 1.5%;">
                            @endif
                            <p style="padding-right: 6.5%;">
                                {{ ucfirst(Auth::user()->name) }}
                                <i class="fa fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <?php $eid = \Illuminate\Support\Facades\Auth::user()->id; ?>
                                <a href="{{ route('profile_update.edit',['profile_update'=>$eid]) }}" class="nav-link @if(isset($menu) && $menu=='Edit Profile') active @endif">
                                    <i class="nav-icon fa fa-pencil"></i><p class="text-warning">Edit Profile</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('admin.logout') }}" class="nav-link">
                                    <i class="nav-icon fa fa-sign-out"></i><p class="text-danger">Log out</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <?php
                    $login_user_role = \Illuminate\Support\Facades\Auth::user()->role;
                    $role_rights = \App\Models\Role::where('alias', $login_user_role)->first();
                    $access_rights=array();
                    if (!empty($role_rights)) {
                        $access_rights = json_decode($role_rights->access_rights);
                    } ?>

                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link @if(isset($menu) && $menu=='Dashboard') active @endif">
                            <i class="nav-icon fa fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    @if(in_array('roles', $access_rights))
                        <li class="nav-item">
                            <a href="{{ route('roles.index') }}" class="nav-link @if(isset($menu) && $menu=='Roles') active @endif">
                                <i class="nav-icon fa fa-list"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                    @endif

                    @if(in_array('users', $access_rights))
                        <li class="nav-item">
                            <a href="{{ route('users.index') }}" class="nav-link @if(isset($menu) && $menu=='Users') active @endif">
                                <i class="nav-icon fa fa-users"></i>
                                <p>Users</p>
                            </a>
                        </li>
                    @endif

                    @if(in_array('suppliers', $access_rights))
                        <li class="nav-item">
                            <a href="{{ route('suppliers.index') }}" class="nav-link @if(isset($menu) && $menu=='Suppliers') active @endif">
                                <i class="nav-icon fa fa-truck"></i>
                                <p>Suppliers</p>
                            </a>
                        </li>
                    @endif

                    @if(in_array('brands', $access_rights))
                        <li class="nav-item">
                            <a href="{{ route('brands.index') }}" class="nav-link @if(isset($menu) && $menu=='Brands') active @endif">
                                <i class="nav-icon fa fa-boxes"></i>
                                <p>Brands</p>
                            </a>
                        </li>
                    @endif

                    @if(in_array('practices', $access_rights))
                        <li class="nav-item">
                            <a href="{{ route('practices.index') }}" class="nav-link @if(isset($menu) && $menu=='Practices') active @endif">
                                <i class="nav-icon fa fa-folder"></i>
                                <p>Practices</p>
                            </a>
                        </li>
                    @endif

                    @if(in_array('stock-orders', $access_rights))
                        <li class="nav-item">
                            <a href="{{ route('stock-orders.index') }}" class="nav-link @if(isset($menu) && $menu=='Stock Orders') active @endif">
                                <i class="nav-icon fa fa-warehouse"></i>
                                <p>Stock Orders</p>
                            </a>
                        </li>
                    @endif

                    @if(in_array('reports', $access_rights))
                        <li class="nav-item">
                            <a href="{{ route('reports.index') }}" class="nav-link @if(isset($menu) && $menu=='Reports') active @endif">
                                <i class="nav-icon fa fa-flag"></i>
                                <p>Reports</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        </div>
    </aside>

    @yield('content')

    <!-- Modal -->
    <div class="modal fade" id="commonModal" tabindex="-1" role="dialog" aria-labelledby="commonModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <!-- Modal content -->
            </div>
        </div>
    </div>

    <footer class="main-footer">
        <strong>{{ config('app.name', 'Shopping Cart') }} Admin</strong>
    </footer>
</div>
<script src="{{ URL('assets/admin/plugins/jquery/jquery.min.js')}}"></script>
<script src="{{ URL('assets/admin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{ URL('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{ URL('assets/admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ URL('assets/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{ URL('assets/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{ URL('assets/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ URL('assets/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{ URL('assets/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<!-- <script src="{{ URL('assets/admin/plugins/jszip/jszip.min.js')}}"></script> -->
<script src="{{ URL::asset('assets/admin/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{ URL('assets/admin/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<script src="{{ URL('assets/admin/plugins/moment/moment.min.js')}}"></script>
<script src="{{ URL('assets/admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{ URL('assets/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<script src="{{ URL('assets/admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- <script src="{{ URL('assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script> -->
<script src="{{ URL('assets/admin/dist/js/adminlte.js')}}"></script>
<script src="{{ URL('assets/admin/dist/js/demo.js')}}"></script>
<!-- <script src="{{ URL('assets/admin/dist/js/pages/dashboard.js')}}"></script> -->
<script src="{{ URL('assets/admin/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{ URL('assets/admin/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{ URL('assets/admin/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
<script src="{{ URL::asset('assets/admin/plugins/iCheck/icheck.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="{{ URL::asset('assets/admin/plugins/ladda/spin.min.js')}}"></script>
<script src="{{ URL::asset('assets/admin/plugins/ladda/ladda.min.js')}}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="{{ URL('assets/admin/dist/js/table-actions.js')}}?{{ time() }}"></script>
<script>Ladda.bind( 'input[type=submit]' );</script>
<script>
$(function () {
    $('[data-toggle="tooltip"]').tooltip()
    $('.select2').select2();

    /*Datepicker*/
    $('.datepicker').datepicker({
        format: 'yyyy-m-d',
        autoclose: true,
    });
});
</script>

<script type="text/javascript">
    /*DISPLAY IMAGE*/
    function AjaxUploadImage(obj,id){
        var file = obj.files[0];
        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])))
        {
            $('#previewing'+URL).attr('src', 'noimage.png');
            alert("<p id='error'>Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
            return false;
        } else{
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(obj.files[0]);
        }

        function imageIsLoaded(e){
            $('#DisplayImage').css("display", "block");
            $('#DisplayImage').css("margin-top", "1.5%");
            $('#DisplayImage').attr('src', e.target.result);
            $('#DisplayImage').attr('width', '150');
        }
    }

    function upload_image(file, el) {
        var form_data = new FormData();
        form_data.append('image', file);
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            data: form_data,
            url: '{{url('admin/image/upload')}}',
            type: "post",
            cache: false,
            contentType: false,
            processData: false,
            success: function(img){
                $(el).summernote('editor.insertImage', img);
            }
        });
    }

    $( function() {
        /SUMMER NOTE CODE/
        $("textarea[id=description]").summernote({
            height: 250,
            toolbar: [
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize', 'height']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['insert', ['table','picture','link','map','minidiag']],
                ['misc', ['fullscreen', 'codeview']],
            ],
            callbacks: {
                onImageUpload: function(files) {
                    for (var i = 0; i < files.length; i++)
                        upload_image(files[i], this);
                }
            },
        });
    });

    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
        checkboxClass: 'icheckbox_flat-green',
        radioClass   : 'iradio_flat-green'
    });

    /* date range picker */
    $(function() {
        $('input[name="daterange"]').daterangepicker({
            opens: 'left',
            locale: {
                format: 'YYYY/MM/DD'
            },
        }, function(start, end, label) {
            console.log("A new date selection was made: " + start.format('DD-MM-YYYY') + ' to ' + end.format('DD-MM-YYYY'));
        });

        $('input[name="daterange"]').val('');
    });
</script>
@yield('jquery')
</body>
</html>
