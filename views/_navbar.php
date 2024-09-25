<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand">MovieApp</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a href="blogs.php" class="nav-link active">Blogs</a>
                </li>
                <li class="nav-item">
                    <a href="admin-blogs.php" class="nav-link active">Admin Blogs</a>
                </li>
                <li class="nav-item">
                    <a href="admin-categories.php" class="nav-link active">Admin Categories</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-center">
                <?php if (isset($_COOKIE["auth"])): ?>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link active">Logout</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active">Hoş geldiniz, <?php echo $_COOKIE["auth"]["name"]; ?></a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link active">Login</a>
                    </li>
                    <li class="nav-item">
                        <a href="register.php" class="nav-link active">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
            <form class="d-flex ms-2" action="blogs.php" method="GET">
                <input type="text" name="q" class="form-control me-2" placeholder="Search">
                <button class="btn btn-outline-light">Search</button>
            </form>
        </div>
    </div>
</nav>