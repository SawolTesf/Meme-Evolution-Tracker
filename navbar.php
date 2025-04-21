
<style>
    .navbar {
        background: linear-gradient(90deg, #feda75, #d62976, #4f5bd5);
        color: white;
        padding: 1rem 2rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
        width: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 1000;
    }

    .navbar-left {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        flex-shrink: 0;
    }

    .navbar h1 {
        font-size: 1.5rem;
        font-weight: bold;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.6);
    }

    .nav-link {
        background: rgba(0, 0, 0, 0.2);
        border: none;
        color: white;
        padding: 0.45rem 1rem;
        border-radius: 4px;
        cursor: pointer;
        font-size: 0.95rem;
        font-weight: 600;
        text-shadow: 1px 1px 1px rgba(0,0,0,0.3);
        transition: background 0.2s ease;
        text-decoration: none;
        display: inline-block;
    }

    .nav-link:hover {
        background: rgba(0, 0, 0, 0.35);
    }

    .navbar-right {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-shrink: 0;
    }

    .search-bar {
        padding: 0.4rem 0.7rem;
        border: none;
        border-radius: 4px;
        font-size: 0.95rem;
        outline: none;
        background: #fff;
        color: #000;
        min-width: 180px;
        flex-shrink: 0;
        box-shadow: none !important;
    }
    .search-bar:focus {
        outline: none;
        box-shadow: 0 0 0 2px rgba(254, 44, 85, 0.4);
    }



    .nav-button {
        padding: 0.5rem 1rem;
        background: transparent;
        color: #fff;
        text-decoration: none;
        font-weight: bold;
        border: 2px solid #fff;
        border-radius: 6px;
        margin-left: auto;
        transition: 0.3s;
    }

    .nav-button:hover {
        background: #fe2c55;
        border-color: #fe2c55;
        color: #fff;
    }

</style>

<div class="navbar">
    <div class="navbar-left">
        <h1>Meme Wiki</h1>
        <a href="index.php" class="nav-link">Home</a>
        <a href="submit.php" class="nav-link">Submit Meme</a>
        <a href="random.php" class="nav-link">Random</a>
        <a href="about.php" class="nav-link">About</a>
        <?php if (!empty($_SESSION['is_admin'])): ?>
            <a href="review_memes.php" class="nav-link">Review Submissions</a>
        <?php endif; ?>

        <form action="search.php" method="GET" style="display: flex; align-items: center; gap: 0.5rem;">
            <input type="text" name="q" class="search-bar" placeholder="Search memes..." required>
        </form>
    </div>
    <div class="navbar-right">
        <?php if (isset($_SESSION['username'])): ?>
            <span style="margin-right: 1rem;">👤 <?= htmlspecialchars($_SESSION['username']) ?></span>
        <?php endif; ?>
        <a href="logout.php" class="nav-button">Logout</a>
    </div>

</div>
