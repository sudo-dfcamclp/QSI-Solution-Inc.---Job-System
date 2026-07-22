<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Available Positions | QuestServ Solutions Inc.</title>
  <script type="text/javascript">
    window.location.replace("index.html#jobs");
  </script>
</head>
<body>

  <!-- Navigation Header -->
  <header class="main-header">
    <div class="nav-container">
      <a href="index.html" class="logo-wrapper">
        <svg class="logo-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
          <path d="M 50,10 L 90,33 L 71,46 L 50,31 L 23,50 L 23,73 L 47,87 L 44,95 L 14,78 L 14,31 Z" fill="#0f3d2e"/>
          <path d="M 62,87 L 78,83 L 88,60 L 72,64 Z" fill="#3ecf6e"/>
        </svg>
        <div class="logo-text">
          <span class="brand-name">QUESTSERV</span>
          <span class="brand-sub">SOLUTIONS INC.</span>
        </div>
      </a>

      <button class="mobile-menu-toggle" aria-label="Toggle navigation">
        <span class="hamburger-bar"></span>
        <span class="hamburger-bar"></span>
        <span class="hamburger-bar"></span>
      </button>

      <nav class="nav-links">
        <a href="index.php" class="nav-link">Home</a>
        <a href="jobs.php" class="nav-link active">Jobs</a>
        <a href="about.php" class="nav-link">About Us</a>
      </nav>

      <div class="nav-action">
        <a href="jobs.php" class="btn btn-primary pill-btn">Find Job</a>
      </div>
    </div>
  </header>

  <!-- Search & Filter Area (matching Image 4 layout layout style) -->
  <main class="page-main-content">
    <div class="jobs-wrapper-container">
      
      <!-- Top Hero Header of Jobs Panel -->
      <div class="jobs-header-card">
        <h1 class="page-title text-center">Available Positions</h1>
        <p class="page-desc-sub text-center">Discover your next career move with QuestServ. We are looking for talented individuals to join our partners across the country.</p>
        
        <!-- Search and inputs card -->
        <div class="search-panel-card">
          <div class="search-row">
            <div class="input-with-icon">
              <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
              <input type="text" id="role-search" placeholder="Find Your Dream Role">
            </div>
            
            <div class="input-with-icon border-left">
              <svg class="input-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
              <input type="text" id="location-search" placeholder="Location">
            </div>

            <button class="btn btn-primary pill-btn" id="search-btn">Search Jobs</button>
          </div>

          <!-- Filter toggle row -->
          <div class="filter-toggle-row">
            <button class="btn btn-filter" id="filter-toggle-btn">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"></polygon></svg>
              Filter
              <svg class="chevron-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
            </button>
          </div>

          <!-- Expanding Filters Options Drawer -->
          <div class="collapsible-filters-drawer" id="filters-drawer">
            <div class="filters-drawer-content">
              <div class="filter-group">
                <span class="filter-group-title">Job Arrangement</span>
                <label class="custom-checkbox">
                  <input type="checkbox" name="type" value="Full-time">
                  <span class="checkmark"></span> Full-time
                </label>
                <label class="custom-checkbox">
                  <input type="checkbox" name="type" value="Hybrid">
                  <span class="checkmark"></span> Hybrid
                </label>
                <label class="custom-checkbox">
                  <input type="checkbox" name="type" value="On-site">
                  <span class="checkmark"></span> On-site
                </label>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Live Interactive Jobs Grid Section -->
      <div class="jobs-list-container">
        <div class="list-heading">
          <h2>Recommended Jobs <span class="count-badge" id="jobs-count">0 Total</span></h2>
        </div>

        <!-- Horizontal Swipe Prompt on Mobile -->
        <div class="swipe-indicator" style="justify-content: flex-start; margin-bottom: 20px;">
          <svg class="swipe-indicator-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
          <span>Swipe to explore jobs</span>
          <svg class="swipe-indicator-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </div>

        <!-- Populated Dynamically via script.js -->
        <div class="jobs-list" id="jobs-cards-target">
          <!-- Dynamically inserted cards go here -->
        </div>

        <div class="no-results-state" id="no-jobs-fallback">
          <svg class="no-results-icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line></svg>
          <h3>No matching roles found</h3>
          <p>Try modifying your keywords, search criteria, or filter options.</p>
        </div>
      </div>

    </div>
  </main>

  <footer class="main-footer">
    <div class="footer-container">
      <div class="footer-brand">
        <div class="footer-logo">
          <svg class="logo-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" style="width: 28px; height: 28px;">
            <path d="M 50,10 L 90,33 L 71,46 L 50,31 L 23,50 L 23,73 L 47,87 L 44,95 L 14,78 L 14,31 Z" fill="#3ecf6e"/>
            <path d="M 62,87 L 78,83 L 88,60 L 72,64 Z" fill="#ffffff"/>
          </svg>
          <span class="brand-name white-text">QUESTSERV</span>
        </div>
        <p class="footer-desc">Professional manpower service provider and employment agency dedicated to verified job placement services in the Philippines.</p>
      </div>
      <div class="footer-links">
        <h4>Navigation</h4>
        <a href="index.php">Home</a>
        <a href="jobs.php">Jobs</a>
        <a href="about.php">About Us</a>
      </div>
    </div>
    <div class="footer-bottom">
      <p>&copy; 2026 QuestServ Solutions Inc. All rights reserved. Registered under the Securities and Exchange Commission (SEC).</p>
    </div>
  </footer>

  <script type="module" src="js/script.js"></script>
</body>
</html>
