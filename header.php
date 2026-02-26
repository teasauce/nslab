<header>
  <div class="header-inner">

    <div class="header-left">
      <h1>JTIK Lab Article Platform</h1>
      <nav>
        <a href="../index.php">Home</a>
        <a href="../browse.php">Browse</a>
      </nav>
    </div>

    <div class="header-right">
      <form method="GET" action="search.php" class="search-form compact">
        <input 
          type="text" 
          name="q" 
          placeholder="Search..."
          value="<?= htmlspecialchars($_GET['q'] ?? '') ?>"
          required
        >
        <button type="submit">🔍</button>
      </form>
    </div>

  </div>
</header>