<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>QuestServ Solutions Inc. | Manpower Services Philippines</title>
  <link rel="stylesheet" href="css/styles.css">
  <!-- Clean corporate typography -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

  <!-- Navigation Header -->    
  <header class="main-header">
    <div class="nav-container">
      <a href="#home" class="logo-wrapper">

        <!-- Recreated Brand Logo (SVG) -->
        <svg class="logo-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
          <path d="M 50,10 L 90,33 L 71,46 L 50,31 L 23,50 L 23,73 L 47,87 L 44,95 L 14,78 L 14,31 Z" fill="#0f3d2e"/>
          <path d="M 62,87 L 78,83 L 88,60 L 72,64 Z" fill="#3ecf6e"/>
        </svg>
        <div class="logo-text">
          <span class="brand-name">QUESTSERV</span>
          <span class="brand-sub">SOLUTIONS INC.</span>
        </div>
      </a>

      <!-- Mobile Menu Toggle -->
      <button class="mobile-menu-toggle" aria-label="Toggle navigation">
        <span class="hamburger-bar"></span>
        <span class="hamburger-bar"></span>
        <span class="hamburger-bar"></span>
      </button>

      <!-- Nav Links -->
      <nav class="nav-links">
        <a href="#home" class="nav-link active" data-tab="home">Home</a>
        <a href="#jobs" class="nav-link" data-tab="jobs">Jobs</a>
        <a href="#about" class="nav-link" data-tab="about">About Us</a>
      </nav>

      <div class="nav-action">
        <a href="../../qsi_inc/admin/login.php" class="btn btn-primary pill-btn">Employee Login</a>
      </div>
    </div>
  </header>

  <!-- The app container that becomes a horizontal swipe carousel on mobile, or active tab switching on desktop -->
  <div class="app-carousel-container" id="app-carousel">

    <!-- SLIDE 1: HOME -->
    <div class="carousel-slide active" id="slide-home" data-slide-id="home">
      <!-- Hero Section -->
      <section class="hero-section">
        <div class="hero-left">
          <div class="hero-content">
            <h1 class="hero-title">Your Trusted Manpower Partner in the Philippines</h1>
            <p class="hero-subtitle">
              Connecting skilled workers with top companies in Metro Manila, Cavite, and beyond. Be part of our growing team today.
            </p>
            
            <div class="hero-cta-group">
              <a href="#jobs" class="btn btn-primary pill-btn icon-btn">
                View Job Openings
                <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path></svg>
              </a>
              <a href="#about" class="btn btn-secondary pill-btn icon-btn">
                Partner With Us
                <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
              </a>
            </div>

            <div class="hero-badges">
              <span class="badge" style="font-weight: bold;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                SEC Registered Business
              </span>
              <span class="badge">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                Taguig | Mandaluyong | Cavite
              </span>
              <span class="badge">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                Industrial & Production Specialists
              </span>
            </div>
          </div>
        </div>
        
        <div class="hero-right">
          <div class="hero-image-container">
            <div class="hero-overlay">
              <svg class="watermark-logo-svg" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                <path d="M 50,10 L 90,33 L 71,46 L 50,31 L 23,50 L 23,73 L 47,87 L 44,95 L 14,78 L 14,31 Z" fill="rgba(15, 61, 46, 0.45)"/>
                <path d="M 62,87 L 78,83 L 88,60 L 72,64 Z" fill="rgba(62, 207, 110, 0.5)"/>
              </svg>
            </div>
          </div>
        </div>
      </section>

      <!-- Why Choose QuestServ Section -->
      <section class="info-section">
        <div class="section-container">
          <div class="section-header text-center">
            <h2 class="section-title">Why Choose QuestServ</h2>
            <p class="section-subtitle">We build supportive, reliable connections between leading businesses and skilled talent.</p>
          </div>

          <div class="grid grid-4">
            <div class="card feature-card">
              <div class="feature-icon-wrapper">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>
              </div>
              <h3>Fast Placement</h3>
              <p>We streamline recruitment processes to minimize deployment delays for both employers and job seekers.</p>
            </div>

            <div class="card feature-card">
              <div class="feature-icon-wrapper">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
              </div>
              <h3>Verified Employers</h3>
              <p>We coordinate only with reputable, established organizations ensuring safe, reliable work environments.</p>
            </div>

            <div class="card feature-card">
              <div class="feature-icon-wrapper">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12" y2="18"></line><line x1="2" y1="8" x2="22" y2="8"></line></svg>
              </div>
              <h3>Fair Wages & Benefits</h3>
              <p>Our positions provide competitive standard daily rates, regular benefits packages, and healthcare support.</p>
            </div>

            <div class="card feature-card">
              <div class="feature-icon-wrapper">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
              </div>
              <h3>End-to-End Support</h3>
              <p>From pre-employment document assistance to active onboarding, we support you through every stage.</p>
            </div>
          </div>
        </div>
      </section>

      <!-- Featured Jobs Section -->
      <section class="jobs-preview-section">
        <div class="section-container">
          <div class="section-header flex-header">
            <div>
              <h2 class="section-title">Featured Opportunities</h2>
              <p class="section-subtitle">Explore a selection of our active operational and administrative openings.</p>
            </div>
            <a href="#jobs" class="btn btn-secondary pill-btn">View All Jobs</a>
          </div>

          <!-- Static previews mimicking actual live cards -->
          <div class="grid grid-2" id="featured-jobs-grid">
            <div class="card job-card">
              <div class="job-card-header">
                <div>
                  <h3 class="job-title">Production Staff</h3>
                  <p class="job-company">QuestServ Solutions Inc.</p>
                </div>
                <span class="status-pill full-time">Full-time</span>
              </div>
              <p class="job-desc">Support daily operations for manufacturing and warehouse clients across key Metro Manila sites. Monitor machinery and maintain standard target logs.</p>
              <div class="job-meta">
                <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> Cavite</span>
                <span>₱18,000 / mo</span>
                <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> Just now</span>
              </div>
            </div>

            <div class="card job-card">
              <div class="job-card-header">
                <div>
                  <h3 class="job-title">Recruitment Coordinator</h3>
                  <p class="job-company">QuestServ Solutions Inc.</p>
                </div>
                <span class="status-pill hybrid">Hybrid</span>
              </div>
              <p class="job-desc">Coordinate interviews, schedule screenings, and organize onboarding schedules for active client projects. Maintain reliable applicant databases.</p>
              <div class="job-meta">
                <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg> Mandaluyong</span>
                <span>₱22,000 / mo</span>
                <span><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg> 1 day ago</span>
              </div>
            </div>
          </div>
        </div>
      </section>

      <!-- General Corporate Footer -->
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
            <a href="#home">Home</a>
            <a href="#jobs">Jobs</a>
            <a href="#about">About Us</a>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; 2025 QuestServ Solutions Inc. All rights reserved. Registered under the Securities and Exchange Commission (SEC).</p>
        </div>
      </footer>
    </div>

    <!-- SLIDE 2: JOBS -->
    <div class="carousel-slide" id="slide-jobs" data-slide-id="jobs">
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
            <div class="list-heading" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
              <h2 style="margin: 0; display: flex; align-items: center; gap: 12px;">Recommended Jobs <span class="count-badge" id="jobs-count">0 Total</span></h2>
              <!-- PC-only Carousel Controls -->
              <div class="jobs-carousel-controls">
                <button class="carousel-control-btn prev-btn" id="jobs-prev-btn" aria-label="Previous job" disabled>
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <button class="carousel-control-btn next-btn" id="jobs-next-btn" aria-label="Next job" disabled>
                  <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
              </div>
            </div>
            <div class="jobs-carousel-viewport">  
              <div class="jobs-list" id="jobs-cards-target">


            <?php
            include("../../qsi_inc/user/config.php");
            $delete_select = "SELECT * FROM joblist";
            $joblist_ID = mysqli_query($conn, $delete_select);
              while ($Listrow1 = mysqli_fetch_array($joblist_ID)) {
            ?>
                <div class="card job-card" data-type="full-time" data-title="<?php echo $Listrow1['title']; ?>" data-location="cavite">
                  <div class="job-card-header">
                    <div>
                      <h3 class="job-title"><?php echo $Listrow1['title']; ?></h3>
                      <p class="job-company"><?php echo $Listrow1['company1']; ?></p>
                    </div>
                    <span class="status-pill <?php echo $Listrow1['job_type']; ?>"><?php echo $Listrow1['job_type']; ?></span>
                  </div>
                  <p class="job-desc"><?php echo $Listrow1['description1']; ?></p>
                  <div class="job-meta">
                    <span>
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                      <?php echo $Listrow1['location1']; ?>
                    </span>
                    <span>₱<?php echo $Listrow1['salary1']; ?></span>
                    <span>
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                      <?php echo $Listrow1['date_time']; ?>
                    </span>
                  </div>
                </div>
              <?php
              }
              ?>
  <!-- Additional job cards can be added here -

                <div class="card job-card" data-type="hybrid" data-title="recruitment coordinator" data-location="mandaluyong">
                  <div class="job-card-header">
                    <div>
                      <h3 class="job-title">Recruitment Coordinator</h3>
                      <p class="job-company">QuestServ Solutions Inc.</p>
                    </div>
                    <span class="status-pill hybrid">Hybrid</span>
                  </div>
                  <p class="job-desc">Coordinate interviews, schedule screenings, and organize onboarding schedules for active industrial partner locations. Maintain applicant databases efficiently.</p>
                  <div class="job-meta">
                    <span>
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                      Mandaluyong
                    </span>
                    <span>₱22,000 / mo</span>
                    <span>
                      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                      1 day ago
                    </span>
                  </div>
                </div>






                  <div class="card job-card" data-type="full-time" data-title="warehouse associate" data-location="taguig">
                    <div class="job-card-header">
                      <div>
                        <h3 class="job-title">Warehouse Associate</h3>
                        <p class="job-company">QuestServ Solutions Inc.</p>
                      </div>
                      <span class="status-pill full-time">Full-time</span>
                    </div>
                    <p class="job-desc">Perform physical logistics operations including cargo staging, manual inventory checks, container receipt documentation, and general stock assembly in logistics centers.</p>
                    <div class="job-meta">
                      <span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Taguig
                      </span>
                      <span>₱17,500 / mo</span>
                      <span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        2 days ago
                      </span>
                    </div>
                  </div>

                  <div class="card job-card" data-type="on-site" data-title="quality control inspector" data-location="cavite">
                    <div class="job-card-header">
                      <div>
                        <h3 class="job-title">Quality Control Inspector</h3>
                        <p class="job-company">QuestServ Solutions Inc.</p>
                      </div>
                      <span class="status-pill on-site">On-site</span>
                    </div>
                    <p class="job-desc">Assess physical metrics of batch outputs against standardized manufacturing blueprints. Spot defects, log anomalies, and route compliance checklists.</p>
                    <div class="job-meta">
                      <span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Cavite
                      </span>
                      <span>₱19,000 / mo</span>
                      <span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        3 days ago
                      </span>
                    </div>
                  </div>

                  <div class="card job-card" data-type="on-site" data-title="hr assistant" data-location="taguig">
                    <div class="job-card-header">
                      <div>
                        <h3 class="job-title">HR Assistant</h3>
                        <p class="job-company">QuestServ Solutions Inc.</p>
                      </div>
                      <span class="status-pill on-site">On-site</span>
                    </div>
                    <p class="job-desc">Assist with standard employee onboarding, gather required statutory identification clearings, arrange document packets, and support basic benefits routing.</p>
                    <div class="job-meta">
                      <span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Taguig
                      </span>
                      <span>₱20,000 / mo</span>
                      <span>
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        4 days ago
                      </span>
                    </div>
                  </div>
  -------------------->








              </div>
            </div>

            <div class="no-results-state" id="no-jobs-fallback">
              <svg class="no-results-icon" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"></circle><line x1="8" y1="12" x2="16" y2="12"></line></svg>
              <h3>No matching roles found</h3>
              <p>Try modifying your keywords, search criteria, or filter options.</p>
            </div>
          </div>

        </div>
      </main>

      <!-- Slide 2 Footer -->
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
            <a href="#home">Home</a>
            <a href="#jobs">Jobs</a>
            <a href="#about">About Us</a>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; 2025 QuestServ Solutions Inc. All rights reserved. Registered under the Securities and Exchange Commission (SEC).</p>
        </div>
      </footer>
    </div>

    <!-- SLIDE 3: ABOUT -->
    <div class="carousel-slide" id="slide-about" data-slide-id="about">
      <!-- Corporate About Details Content -->
      <main class="page-main-content">
        <div class="about-container">
          
          <!-- Top Title Block -->
          <section class="about-hero text-center">
            <h1 class="page-title">About QuestServ Solutions Inc.</h1>
            <p class="about-lead">Connecting qualified workers with reputable companies across the Philippines.</p>
          </section>

          <!-- Content Breakdown Grid Section -->
          <section class="about-core-grid">
            <div class="grid grid-2">
              
              <!-- Column: Who We Are -->
              <div class="about-text-panel">
                <h2>Who We Are</h2>
                <p>
                  QuestServ Solutions Inc. is a Philippines-based manpower service provider and employment agency dedicated to connecting qualified workers with reputable companies across various industries. 
                </p>
                <p>
                  We specialize in placing production operators, skilled tradespeople, and support staff in industrial and manufacturing environments. Our process values reliability and fair practice in all deployments.
                </p>
              </div>

              <!-- Column: Core Commitment -->
              <div class="about-text-panel border-left-panel">
                <h2>Our Commitment</h2>
                <p>
                  Our operations aim to simplify recruitment procedures for employers while ensuring candidate profiles receive accurate mapping to appropriate operational roles.
                </p>
                <p>
                  By offering secure onboarding support and managing mandatory registration compliance, we establish structured foundations for successful career progression.
                </p>
              </div>

            </div>
          </section>

          <!-- Grid: What We Do -->
          <section class="about-services">
            <div class="section-header text-center">
              <h2>What We Do</h2>
              <p>We provide comprehensive placement services across all phases of worker hiring and support.</p>
            </div>

            <div class="grid grid-4">
              <div class="card service-about-card">
                <div class="service-icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M20 8v6"></path><path d="M23 11h-6"></path></svg>
                </div>
                <h4>End-to-End Recruitment</h4>
                <p>Comprehensive recruitment routing including verification, screening, and direct client deployment matching.</p>
              </div>

              <div class="card service-about-card">
                <div class="service-icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                </div>
                <h4>Pre-Employment Support</h4>
                <p>Assistance in organizing mandatory government records, health checks, and essential identification clearances.</p>
              </div>

              <div class="card service-about-card">
                <div class="service-icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2" ry="2"></rect><line x1="12" y1="18" x2="12" y2="18"></line><line x1="2" y1="8" x2="22" y2="8"></line></svg>
                </div>
                <h4>Competitive Daily Rates</h4>
                <p>Competitive structures that comply strictly with provincial and regional minimum rate frameworks.</p>
              </div>

              <div class="card service-about-card">
                <div class="service-icon">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                </div>
                <h4>Comprehensive Coverage</h4>
                <p>Structured deployment that includes standardized holiday structures and applicable health service contributions.</p>
              </div>
            </div>
          </section>

          <!-- Section: Industries We Serve -->
          <section class="industries-section">
            <div class="section-header text-center">
              <h2>Industries We Serve</h2>
              <p>We supply capable talent to several key operational sectors across industrial zones.</p>
            </div>

            <div class="grid grid-4 text-center">
              <div class="industry-badge">
                <span class="ind-icon">🏭</span>
                <h5>Manufacturing</h5>
              </div>
              <div class="industry-badge">
                <span class="ind-icon">📦</span>
                <h5>Warehousing & Logistics</h5>
              </div>
              <div class="industry-badge">
                <span class="ind-icon">⚙️</span>
                <h5>Industrial Production</h5>
              </div>
              <div class="industry-badge">
                <span class="ind-icon">🏢</span>
                <h5>Corporate Support Staff</h5>
              </div>
            </div>
          </section>

          <!-- Dynamic CTA Banner -->
          <section class="cta-banner">
            <div class="cta-inner text-center">
              <h2>Looking for your next career move?</h2>
              <p>View open roles at our partner facilities and submit your profile today.</p>
              <a href="#jobs" class="btn btn-cta pill-btn">View Available Jobs</a>
            </div>
          </section>

        </div>
      </main>

      <!-- Slide 3 Footer -->
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
            <a href="#home">Home</a>
            <a href="#jobs">Jobs</a>
            <a href="#about">About Us</a>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; 2025 QuestServ Solutions Inc. All rights reserved. Registered under the Securities and Exchange Commission (SEC).</p>
        </div>
      </footer>
    </div>

  </div>

  <!-- Floating Mobile Navigation Arrows -->
  <button class="mobile-swipe-arrow left-arrow hidden" id="mobile-swipe-left" aria-label="Previous Section">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="15 18 9 12 15 6"></polyline>
    </svg>
  </button>
  <button class="mobile-swipe-arrow right-arrow" id="mobile-swipe-right" aria-label="Next Section">
    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
      <polyline points="9 18 15 12 9 6"></polyline>
    </svg>
  </button>

  <script type="module" src="js/script.js"></script>
</body>
</html>
