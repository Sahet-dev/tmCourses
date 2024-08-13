<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Course App')</title>
    <!-- Add your CSS and JS files here -->
</head>
<body>
<header>
    <!-- Navigation bar -->
</header>

<main>
    @yield('content')
</main>

<footer>
    <!-- Footer content -->
</footer>
</body>
</html>
