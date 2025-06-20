<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>NCHE Admin user</title>

    <!-- Plugin & Vendor CSS -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">

    <!-- Custom Layout Styles -->
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body class="page-specific">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="container-scroller">
      
      <!-- partial:partials/_navbar.html -->
<nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row" style="background-color: white !important; color: black !important;">
  <div class="navbar-menu-wrapper d-flex align-items-center w-100 px-3">

    <!-- Logo container -->
    <div class="d-flex align-items-center" style="flex-shrink: 0;">
      <img src="/assets/images/logo1.png" alt="logo" style="height: 59px; width: auto;" />
    </div>

    <!-- Toggle Button -->
    <button class="navbar-toggler align-self-center ms-3" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>

    <!-- Search Field -->
    <div class="search-field d-none d-md-block ms-4">
      <form class="d-flex align-items-center h-100" action="#">
        <div class="input-group">
          <div class="input-group-prepend bg-transparent">
            <i class="input-group-text border-0 mdi mdi-magnify"></i>
          </div>
          <input type="text" class="form-control bg-transparent border-0" placeholder="Search projects" />
        </div>
      </form>
    </div>

    <!-- Profile - pushed to far right -->
    <ul class="navbar-nav ms-auto d-flex align-items-center">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle d-flex align-items-center" id="profileDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <img src="{{ Auth::user()->personalInfo?->profile_picture ? Storage::url(Auth::user()->personalInfo->profile_picture) : 'https://via.placeholder.com/180' }}"
               alt="Profile Picture"
               style="width: 40px; height: 40px; object-fit: cover; border-radius: 50%; margin-right: 10px;">
          <div class="nav-profile-text">
            <p class="mb-0 text-black">Hello {{ Auth::user()->name }}</p>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end navbar-dropdown" aria-labelledby="profileDropdown">
          <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <button type="submit" class="btn btn-link nav-link p-0" style="border: none; background: none;">
              <i class="mdi mdi-logout me-2 text-primary"></i> Sign Out
            </button>
          </a>

          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        </div>
      </li>
    </ul>

  </div>
</nav>



      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            
            <li class="nav-item">
              <a class="nav-link"  id="load-apply" >

                <span class="menu-title" style="color: #8c0378;">Dashboard</span>

                <i class="mdi mdi-home menu-icon" style="color: #8c0378;"></i>

              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"  id="load-apply">

            <span class="menu-title">   Personal Info</span>
           <i class="mdi mdi-contacts menu-icon"></i>

            </a>
              
            </li>
 <li class="nav-item">
  <a class="nav-link" data-bs-toggle="collapse" href="#qualifications-collapse" aria-expanded="false" aria-controls="qualifications-collapse" style="display: flex; justify-content: space-between; align-items: center;">
    <div style="display: flex; align-items: center;">
      <span class="menu-title">Qualifications & Verification</span>
    </div>
    <i class="mdi mdi-chevron-down" style="margin-left: 10px;"></i> <!-- Dropdown indicator -->
  </a>
</li>

  <div class="collapse" id="qualifications-collapse">
    <ul class="nav flex-column sub-menu" style="background-color: #52074f; padding-left: 20px;">
      <li class="nav-item">
<a href="{{ route('application.create') }}" class="btn btn-success">
    
          <i class="mdi mdi-file-plus menu-icon" style="margin-right: 8px;"></i> Apply
        </a>
      </li>
      <li class="nav-item">
  <a class="nav-link" href="{{ route('applications.my') }}"  style="display: flex; align-items: center;">
    <i class="mdi mdi-file-multiple menu-icon" style="margin-right: 8px;"></i> My Applications
  </a>
</li>

    </ul>
  </div>
</li>


            <li class="nav-item">
              <a class="nav-link" data-bs-toggle="collapse" href="#forms" aria-expanded="false" aria-controls="forms">
                <span class="menu-title">Payments</span>
<i class="mdi mdi-credit-card menu-icon"></i>
              </a>
              
            </li>
           
          
            
            
            <li class="nav-item">
              <a class="nav-link" href="docs/documentation.html" target="_blank" id="documentation">
                <span class="menu-title">Documentation</span>
                <i class="mdi mdi-file-document menu-icon"></i>
              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="docs/documentation.html" target="_blank" id="documentation">
                <span class="menu-title">FAQ</span>
                <i class="mdi mdi-help-circle menu-icon"></i>
              </a>
            </li>
            
            <li class="nav-item">
              <a class="nav-link" href="docs/documentation.html" target="_blank" id="documentation">
                <span class="menu-title">Help</span>
              <i class="mdi mdi-help-circle menu-icon"></i>
              </a>
            </li>

          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel" >
         
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
         
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="assets/vendors/chart.js/chart.umd.js"></script>
    <script src="assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/misc.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <script>
      // Load the personal information form into .main-panel
      $('#load-apply').on('click', function (e) {
          e.preventDefault();
  
          $.ajax({
              url: '/personal-info',
              method: 'GET',
              success: function (response) {
                  $('.main-panel').html(response);
              },
              error: function (xhr) {
                  alert('Error loading personal info.');
                  console.error(xhr.responseText);
              }
          });
      });
  
      // Load application form into .main-panel
      $('#profile').on('click', function (e) {
          e.preventDefault();
  
          $.ajax({
              url: '/application',
              method: 'GET',
              success: function (response) {
                  $('.main-panel').html(response);
              },
              error: function (xhr) {
                  alert('Error loading profile details.');
                  console.error(xhr.responseText);
              }
          });
      });
  
   // Load documentation into .main-panel
   $('#documentation').on('click', function (e) {
          e.preventDefault();
  
          $.ajax({
              url: '/documentation',
              method: 'GET',
              success: function (response) {
                  $('.main-panel').html(response);
              },
              error: function (xhr) {
                  alert('Error loading profile details.');
                  console.error(xhr.responseText);
              }
          });
      });
      //main-panel
      function loadMainPanel() {
            $.ajax({
                url: '/personal-info',
                method: 'GET',
                success: function (response) {
                    $('.main-panel').html(response);
                },
                error: function (xhr) {
                    alert('Error loading profile details.');
                    console.error(xhr.responseText);
                }
            });
        }

        $(document).ready(function () {
            loadMainPanel();

            $('#main-panel').on('click', function (e) {
                e.preventDefault();
                loadMainPanel();
            });
        });
 
      // Handle personal info form submission (new or update)
      $(document).on('submit', '#personalInfoForm', function (e) {
          e.preventDefault();
  
          let form = $(this);
          let formData = new FormData(this);
  
          // Check for _method override (PUT for updates)
          const methodOverride = form.find('input[name="_method"]').val();
          if (methodOverride) {
              formData.append('_method', methodOverride);
          }
  
          $.ajax({
              url: form.attr('action'),
              method: 'POST', // Always POST when using method override
              data: formData,
              processData: false,
              contentType: false,
              success: function (response) {
                  if (response.success) {
                      alert('Information saved successfully.');
                      $('.main-panel').html(response.html); // Re-render the form with new/updated data
                  }
              },
              error: function (xhr) {
                  alert('An error occurred while saving your information.');
                  console.error(xhr.responseText);
              }
          });
      });
  </script>

  </body>
<style>


  /* Global Styles */
body {
  font-family: 'Inter', 'Segoe UI', sans-serif;
  margin: 0;
  padding: 0;
  background-color: #f5f7fa;
  color: #333;
}
.sidebar .nav-item a,
.sidebar .nav-item i,
.sidebar .nav-item .menu-title {
  color: #ffffff !important;
}

/* Navbar */
.navbar {
  background-color: #ffffff;
  border-bottom: 1px solid #e0e6ed;
  box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  padding: 0.75rem 1.5rem;
  z-index: 10;
}

/* Sidebar */
.sidebar {
  width: 250px;
  background-color: #52074f;
  color: #fff;
  position: fixed;
  height: 100vh;
  padding-top: 2rem;
  box-shadow: 2px 0 10px rgba(0,0,0,0.15);
  transition: width 0.3s ease;
}

.sidebar .nav {
  display: flex;
  flex-direction: column;
  padding: 0 1rem;
}

.sidebar .nav-item {
  margin-bottom: 1rem;
  border-radius: 8px;
  transition: background 0.3s ease;
}

.sidebar .nav-item a {
  display: flex;
  align-items: center;
  padding: 0.75rem 1rem;
  color: #fff;
  text-decoration: none;
  font-weight: 500;
}

.sidebar .nav-item a:hover,
.sidebar .nav-item.active a {
  background-color: #dd8027;
  color: #fff;
}

.sidebar .nav-item i {
  margin-right: 0.75rem;
  font-size: 1.2rem;
}

/* Main Content */
.main-panel {
  margin-left: 250px;
  padding: 2rem;
}

.page-title {
  font-size: 1.8rem;
  font-weight: 600;
  color: #222;
  margin-bottom: 1rem;
}

/* Cards / Widgets */
.card {
  background: #fff;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0,0,0,0.06);
  padding: 1.5rem;
  margin-bottom: 2rem;
  transition: transform 0.2s ease;
}

.card:hover {
  transform: translateY(-2px);
}

/* Buttons */
.btn-primary {
  background-color: #dd8027;
  border-color: #dd8027;
  color: #fff;
  font-weight: 500;
  padding: 0.5rem 1.25rem;
  border-radius: 6px;
  transition: background 0.3s ease;
}

.btn-primary:hover {
  background-color: #c86f1f;
}

/* Scrollbar (nice touch) */
::-webkit-scrollbar {
  width: 8px;
}
::-webkit-scrollbar-track {
  background: #f1f1f1;
}
::-webkit-scrollbar-thumb {
  background: #b981af;
  border-radius: 8px;
}
::-webkit-scrollbar-thumb:hover {
  background: #a3679e;
}

</style>
</html>