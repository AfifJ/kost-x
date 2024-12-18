<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="/">Kost-X</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/cari-kost">Cari Kost</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="/about">Tentang Kami</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact">Kontak</a>
                    </li> -->
                </ul>
                <div class="ms-3">
                    <?php if (!isLoggedIn()): ?>
                        <a href="/login" class="btn btn-outline-light me-2">Login</a>
                        <a href="/register" class="btn btn-light">Daftar</a>
                    <?php else: ?>
                        <a href="/dashboard" class="btn btn-light">Dashboard</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>
