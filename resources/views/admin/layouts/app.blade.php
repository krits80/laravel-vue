<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title>AdminLTE 3 | Starter</title>

      @vite(['resources/css/app.css', 'resources/js/app.js'])

   </head>
   <body class="hold-transition sidebar-mini">
      <div class="wrapper" id="app">
         <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
               <li class="nav-item">
                  <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
               </li>
               <li class="nav-item d-none d-sm-inline-block">
                  <a href="index3.html" class="nav-link">Home</a>
               </li>
               <li class="nav-item d-none d-sm-inline-block">
                  <a href="#" class="nav-link">Contact</a>
               </li>
            </ul>
            <ul class="navbar-nav ml-auto">
               <li class="nav-item">
                  <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                  <i class="fas fa-search"></i>
                  </a>
                  <div class="navbar-search-block">
                     <form class="form-inline">
                        <div class="input-group input-group-sm">
                           <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                           <div class="input-group-append">
                              <button class="btn btn-navbar" type="submit">
                              <i class="fas fa-search"></i>
                              </button>
                              <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                              <i class="fas fa-times"></i>
                              </button>
                           </div>
                        </div>
                     </form>
                  </div>
               </li>
               <li class="nav-item">
                  <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                  <i class="fas fa-expand-arrows-alt"></i>
                  </a>
               </li>
            </ul>
         </nav>
         <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="index3.html" class="brand-link">
            <img src="https://adminlte.io/themes/v3/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">AdminLTE 3</span>
            </a>
            <div class="sidebar">
               <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                  <div class="image">
                     <img src="https://adminlte.io/themes/v3/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                  </div>
                  <div class="info">
                     <a href="#" class="d-block">Alexander Pierce</a>
                  </div>
               </div>
               <nav class="mt-2">
                  <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                     <li class="nav-item">
                        <router-link to="/admin/dashboard" active-class="active" class="nav-link">
                           <i class="nav-icon fas fa-tachometer-alt"></i>
                           <p> Dashboard </p>
                        </router-link>
                     </li>

                     <li class="nav-item">
                        <router-link to="/admin/appointments" active-class="active" class="nav-link">
                           <i class="nav-icon fas fa-calendar-alt"></i>
                           <p> Appointments </p>
                        </router-link>
                     </li>

                     <li class="nav-item">
                        <router-link to="/admin/users" active-class="active" class="nav-link">
                           <i class="nav-icon fas fa-users"></i>
                           <p> Users </p>
                        </router-link>
                     </li>

                     <li class="nav-item">
                        <router-link to="/admin/settings" active-class="active" class="nav-link">
                           <i class="nav-icon fas fa-cog"></i>
                           <p> Settings </p>
                        </router-link>
                     </li>

                     <li class="nav-item">
                        <router-link to="/admin/profile" active-class="active" class="nav-link">
                           <i class="nav-icon fas fa-user"></i>
                           <p> Profile </p>
                        </router-link>
                     </li>

                     <li class="nav-item">
                        <router-link to="/logout" active-class="active" class="nav-link">
                           <i class="nav-icon fas fa-sign-out-alt"></i>
                           <p> Logout </p>
                        </router-link>
                     </li>

                  </ul>
               </nav>
            </div>
         </aside>

         <div class="content-wrapper">
            <router-view></router-view>
         </div>

         <aside class="control-sidebar control-sidebar-dark">
            <div class="p-3">
               <h5>Title</h5>
               <p>Sidebar content</p>
            </div>
         </aside>
         <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">
               Anything you want
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
         </footer>
      </div>
   </body>
</html>
