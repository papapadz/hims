<li 
  @if($currPage=='home') 
    class="active" 
  @endif
>
  <a href="{{ url('home') }}">
    <i class="fa fa-home"></i>
    <p>Dashboard</p>
  </a>
</li>

<li 
  @if($currPage=='user-accounts') 
    class="active forAdmin" 
  @else
    class="forAdmin"
  @endif
  hidden="true" 
>
  <a href="{{ url('user-accounts') }}">
    <i class="fa fa-list-alt"></i>
    <p>User Accounts</p>
  </a>
</li>

<li 
  @if($currPage=='patients') 
    class="active forAdmin forPAT forMED forNRS forPHR forBLL forLAB forXRY" 
  @else
    class="forAdmin forPAT forMED forNRS forPHR forBLL forLAB forXRY" 
  @endif
  hidden="true" 
>
  <a href="{{ url('patients') }}">
    <i class="fa fa-hospital-o"></i>
    <p>Patients</p>
  </a>
</li>

<li 
  @if($currPage=='lab-requests') 
    class="active forAdmin forLAB" 
  @else
    class="forAdmin forLAB" 
  @endif
  hidden="true" 
>
  <a href="{{ url('lab-requests') }}">
    <i class="fa fa-flask"></i>
    <p>Lab Requests</p>
  </a>
</li>

<li 
  @if($currPage=='xray-requests') 
    class="active forAdmin forXRY" 
  @else
    class="forAdmin forXRY" 
  @endif
  hidden="true" 
>
  <a href="{{ url('xray-requests') }}">
    <i class="fa fa-flash"></i>
    <p>X-RAY Requests</p>
  </a>
</li>

<li 
  @if($currPage=='supplies') 
    class="active forAdmin forPHR" 
  @else
    class="forAdmin forPHR" 
  @endif
  hidden="true" 
>
  <a href="{{ url('supplies') }}">
    <i class="fa fa-shopping-cart"></i>
    <p>Supplies</p>
  </a>
</li>

<li 
  @if($currPage=='pharmacy') 
    class="active forAdmin forPHR" 
  @else
    class="forAdmin forPHR" 
  @endif
  hidden="true" 
>
  <a href="{{ url('pharmacy') }}">
    <i class="fa fa-tag"></i>
    <p>Pharmacy</p>
  </a>
</li>

<li 
  @if($currPage=='billings') 
    class="active forAdmin forBLL" 
  @else
    class="forAdmin forBLL" 
  @endif
  hidden="true" 
>
  <a href="{{ url('billings') }}">
    <i class="fa fa-list"></i>
    <p>Billings</p>
  </a>
</li>

<li 
  @if($currPage=='employees') 
    class="active forAdmin forHRS"
  @else
    class="forAdmin forHRS" 
  @endif
  hidden="true" 
>
  <a href="{{ url('employees') }}">
    <i class="fa fa-user"></i>
    <p>Employees</p>
  </a>
</li>

<li 
  @if($currPage=='schedules') 
    class="active forAdmin forHRS"
  @else
    class="forAdmin forHRS" 
  @endif
  hidden="true" 
>
  <a href="{{ url('schedules') }}">
    <i class="fa fa-sticky-note"></i>
    <p>Schedules</p>
  </a>
</li>

<li 
  @if($currPage=='payroll') 
    class="active forAdmin forHRS"
  @else
    class="forAdmin forHRS" 
  @endif
  hidden="true" 
>
  <a href="{{ url('payroll') }}">
    <i class="fa fa-money"></i>
    <p>Payroll</p>
  </a>
</li>

<li 
  @if($currPage=='dtr') 
    class="active forAdmin forHRS"
  @else
    class="forAdmin forHRS" 
  @endif
  hidden="true" 
>
  <a href="{{ url('attendance') }}">
    <i class="fa fa-calendar"></i>
    <p>DTR</p>
  </a>
</li>