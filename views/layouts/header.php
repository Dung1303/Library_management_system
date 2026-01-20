 <html lang="en">


 <head>
     <meta charset="UTF-8">
     <title>LibraSys</title>


     <!-- Bootstrap 5 -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


     <!-- Custom CSS -->
     <link rel="stylesheet" href="/css/layouts.css">
 </head>


 <body>


     <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
         <div class="container">


             <!-- Logo -->
             <a class="navbar-brand d-flex align-items-center" href="/">
                 <img src="/images/logo.jpg" alt="LibraSys Logo" height="40" class="me-2">
                 <span class="fw-bold">LibraSys</span>
             </a>


             <!-- Toggle mobile -->
             <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                 <span class="navbar-toggler-icon"></span>
             </button>


             <!-- Menu -->
             <div class="collapse navbar-collapse" id="navbarContent">
                 <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                     <li class="nav-item">
                         <a class="nav-link active nav-item-custom" href="/">
                             Home
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link nav-item-custom" href="/borrowed-books">
                             Borrowed Books
                         </a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link nav-item-custom" href="/profile">
                             Profile
                         </a>
                     </li>
                 </ul>


                 <!-- User info -->
                 <div class="d-flex align-items-center gap-3">
                     <div class="text-end">
                         <div class="fw-semibold">
                             <?php echo $_SESSION['user_name'] ?? 'Guest'; ?>
                         </div>
                         <small class="text-muted">Member</small>
                     </div>


                     <a href="/auth/login.php" class="btn btn-danger btn-sm">
                         Login
                     </a>
                 </div>
             </div>


         </div>
     </nav>