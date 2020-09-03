<!--
=========================================================
 Paper Dashboard 2 - v2.0.0
=========================================================

 Product Page: https://www.creative-tim.com/product/paper-dashboard-2
 Copyright 2019 Creative Tim (https://www.creative-tim.com)
 Licensed under MIT (https://github.com/creativetimofficial/paper-dashboard/blob/master/LICENSE)

 Coded by Creative Tim

=========================================================

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software. -->



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('assets/img/hospital-logo.png')}}">
  <link rel="icon" type="image/png" href="{{asset('assets/img/hospital-logo.png')}}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Hospital Information Management System
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  @include('includes.styles')
  @yield('styles')
  </head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="white" data-active-color="danger">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
      <div class="logo">
        <a href="#" class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="{{asset('assets/img/hospital-logo.png')}}">
          </div>
        </a>
        <a href="{{ url('home') }}" class="simple-text logo-normal">
          HIMS
          <!-- <div class="logo-image-big">
            <img src="../assets/img/logo-big.png">
          </div> -->
        </a>
      </div>
      <div class="sidebar-wrapper">
        <ul class="nav">
          @include('layouts.sidenav')
        </ul>
      </div>
    </div>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="{{ url('home') }}">Hospital Information Management System v1.0</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
              <li class="nav-item btn-rotate dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownAccount" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="fa fa-user-circle"></i>
                  <p>
                    <span class="d-lg-none d-md-block"></span>
                  </p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownAccount">
                  @if(Auth::User()->account_type==3)
                    <a class="dropdown-item" href="{{ url('patients/profile/'.Auth::User()->user_id) }}">Hello, {{ Auth::User()->patientInfo->last_name }}, {{ Auth::User()->patientInfo->first_name }} {{ Auth::User()->patientInfo->middle_name[0] }}</a>
                  @else
                    <a class="dropdown-item" href="{{ url('employee/profile/'.Auth::User()->user_id) }}">Hello, {{ Auth::User()->employeeInfo->last_name }}, {{ Auth::User()->employeeInfo->first_name }} {{ Auth::User()->employeeInfo->middle_name[0] }}</a>
                  @endif
                  <a class="dropdown-item" href="{{ url('user-logout') }}">Logout</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
      <!-- End Navbar -->
      <!-- <div class="panel-header panel-header-lg">

  <canvas id="bigDashboardChart"></canvas>


</div> -->
      <div class="content">
        
        @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>  
        @elseif(session('danger'))
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Notice!</strong> {{ session('danger') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>  
        @endif
        @if ($errors->any())
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
            <strong>Sorry!</strong>
              <ul>
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
        @endif
        
        @yield('content')

      </div>
    </div>
  </div>
  @include('includes.scripts')
  
  @yield('script')
  
  @if(Auth::User()->account_type==3)
    <script type="text/javascript">
      $('.forPatient').prop('hidden',false);
    </script>
  @else
    <script type="text/javascript">

    var acct_type = {{ Auth::User()->account_type }};
   
    if(acct_type==1) {

      $('.forAdmin').prop('hidden',false);
    } else if(acct_type==2) {
      
      var dept = {{ Auth::User()->employeeInfo->department_id }};

      switch(dept) {
        case 1: $('.forMED').prop('hidden',false);break;
        case 2: $('.forHRS').prop('hidden',false);break;
        case 3: $('.forNRS').prop('hidden',false);break;
        case 4: $('.forPHR').prop('hidden',false);break;
        case 5: $('.forBLL').prop('hidden',false);break;
        case 6: $('.forLAB').prop('hidden',false);break;
        case 7: $('.forPAT').prop('hidden',false);break;
        case 8: $('.forXRY').prop('hidden',false);break;
      }

    } 
  </script>
  @endif
  <script type="text/javascript">
     $("input:file").change(function (){
       var fileName = $(this).val();
       if($(this).attr('name')=='pds')
        $(".f2").html(fileName)
       else
        $(".f1").html(fileName);
     });
    function printThis(id, title, name, flag) {

          //flag
          //1 = Patient Chart
          //2 = Billing Statement
          //3 = DTR
          //4 = Payslip
          //5 = Batch printing
          //6 = OR

          var contentStyle;
          if(flag==1) {
            contentStyle = '<style>.no-print{display:none;} .table{width:100%;margin-bottom:1rem;background-color:transparent}.table td,.table th{padding:.75rem;vertical-align:top;border-top:1px solid #dee2e6}.table thead th{vertical-align:bottom;border-bottom:2px solid #dee2e6}.table tbody+tbody{border-top:2px solid #dee2e6}.table .table{background-color:#fff}.table-sm td,.table-sm th{padding:.3rem}.table-bordered{border:1px solid #dee2e6}.table-bordered td,.table-bordered th{border:1px solid #dee2e6}.table-bordered thead td,.table-bordered thead th{border-bottom-width:2px}</style>';
            position = "Printed Name and Signature";
          } else if(flag==2){
            contentStyle = '<style>.no-print{display:none;} .table{width:100%;border-top:2px solid #dee2e6;border-bottom:2px solid #dee2e6;} td{border-top:2px solid #dee2e6;}</style>';
            position = "Printed Name and Signature";
          } else if(flag==3){
            contentStyle = '<style>.table-bordered{border-collapse: collapse;}.table-bordered, th.bordered, td.bordered {border: 1px solid black;font-size:10}</style>';
            position = "Printed Name and Signature";
          } else if(flag==4){
            contentStyle = "<style>.table,table,tr,td{border:1px solid black;border-collapse: collapse;}</style>";
            name = 'Printed Name and Signature';
            position = 'Supervising Administrative Officer';
          } else if(flag==5){
            contentStyle = "<style>.table,table,tr,td{font-size:7px;border:1px solid black;border-collapse: collapse;}.col-4 {width:30%; float:left;margin-right:12px}.col-12{width:100%; float:left;}</style>";
            name = '';
            position = '';
          } else if(flag==6){
            contentStyle = "<style>input{background-color:transparent;border: 0px solid;}.col-4 {width:30%; float:left;margin-right:10px}.col-12{width:100%; float:left;}</style>";
            name = '';
            position = '';
          }

          var hosp_name = 'HOSPITAL NAME';
          var hosp_address = 'HOSPITAL ADDRESS';
          var hosp_contact = 'HOSPITAL CONTACT';
          var content = document.getElementById(id).innerHTML;
          var mywindow = window.open('', title, 'width=8.5');
          mywindow.document.write('<html><head><title>'+title+'</title>');
          mywindow.document.write(contentStyle);
          mywindow.document.write('</head><body >');
          mywindow.document.write('<center><h3>'+hosp_name+'</h3>');
          mywindow.document.write('<h5>'+hosp_address+'</h5>');
          mywindow.document.write('<h5>'+hosp_contact+'</h5></center>');
          mywindow.document.write(content+'<br>');
          //mywindow.document.write('<p><u>'+name+'</u></p>');
          if(flag!=5)
          mywindow.document.write('<p>________________________</p>');
          mywindow.document.write('<p>'+position+'</p>');
          mywindow.document.write('</body></html>');

          mywindow.document.close();
          mywindow.focus();
          mywindow.print();
          mywindow.close();
        }

  </script>
</body>

</html>