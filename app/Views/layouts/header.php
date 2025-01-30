<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Slash Admin Panel</title>
    <link href="<?= base_url('/assets/css/bootstrap.css') ?>" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        /* Custom styles to show dropdown on hover */
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
    <script>
        function handleUserClick(event) {
            event.preventDefault(); // Prevent the default link behavior
        }
    </script>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-white">
        <div class="container-fluid">
            <img src="/assets/img/Slash Logo.png" style="height: 45px; width: 45px;" alt="">
            <div class="ml-auto d-flex gap-4">
            <h4>Welcome, <?= session()->get('name') ?: 'Guest' ?></h4>
            <!-- <a href=""class="btn btn-info"><i class="fa-solid fa-right-from-bracket"></i>Logout</a> -->
            <a href="#" onclick="confirmLogout()" class="btn btn-primary ms-3"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
            </div>
        </div>
    </nav>

    <table class="table border-top">
        <thead>
            <tr class="d-flex flex-row justify-content-center gap-5">
                <th scope="col" class="border-0">
                    <a class="nav-link" href="<?= base_url('/view') ?>"><i class="fa-solid fa-gauge mx-1"></i>Dashboard</a>
                </th>
                <th scope="col" class="border-0">
                    <a class="nav-link" href="#"><i class="fa-solid fa-wifi mx-1"></i>Live</a>
                </th>
                <th scope="col" class="border-0 dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-bug mx-1"></i>Reports
                    </a>
                    <div class="dropdown-menu" aria-labelledby="operationsDropdown">
                        <a class="dropdown-item" href="<?= base_url('/reports/cdr') ?>">CDR</a>
                        <a class="dropdown-item" href="<?= base_url('/reports/summary') ?>">Summarize report</a>
                    </div>
                </th>
                <th scope="col" class="border-0">
                    <a class="nav-link" href="#"><i class="fa-solid fa-comment mx-1"></i>Conversations</a>
                </th>
                <th scope="col" class="border-0">
                    <a class="nav-link" href="#"><i class="fa-solid fa-address-book mx-1"></i>Contacts</a>
                </th>
                <th scope="col" class="border-0 dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" id="operationsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-gear mx-1"></i>Operations
                    </a>
                    <div class="dropdown-menu" aria-labelledby="operationsDropdown">
                        <a class="dropdown-item" href="/users">User</a>
                        <a class="dropdown-item" href="#">Access Level</a>
                        <a class="dropdown-item" href="/campaigns">Campaign</a>
                        <a class="dropdown-item" href="/chatApp/index">Chat</a>
                    </div>
                </th>
                <th scope="col" class="border-0">
                    <a class="nav-link" href="#"><i class="fa-solid fa-sliders mx-1"></i>Advanced Settings</a>
                </th>
            </tr>
        </thead>
    </table>
</body>
<script>
  function confirmLogout() {
    const isConfirmed = confirm("Are you sure you want to log out?");
    if (isConfirmed) {
      // Redirect to the logout page if confirmed
      window.location.href = '/logout';
    }
  }
</script>
</html>