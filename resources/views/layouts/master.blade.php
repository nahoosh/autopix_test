<!DOCTYPE html>

<html>
<head>
	@include('include.head')
</head>
<body id="page-top">


	<div class="container-scroller">
	
	<div class="container-fluid page-body-wrapper">
	@include('include.sidebar')
		<div class="main-panel">

          <div class="content-wrapper">
          	
          	@yield('content')
          </div>
      </div>

	</div>
	</div>
	<div id="wrapper">
		

  <!-- Content Wrapper 
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content 
      <div id="content">
			

				
			</div>
			

	    </div>
	    @include('include.footer')	
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->
</body>
</html>