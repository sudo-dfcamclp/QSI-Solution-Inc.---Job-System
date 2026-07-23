// GLOBAL LOGIC
document.addEventListener("DOMContentLoaded", () => {
  initMobileNav();
  initAppCarousel();
  initJobsEngine();
});

/**
 * Top-Level Application Carousel and Tab System
 * On mobile, turns Home, Jobs, and About sections into a horizontal swipe carousel.
 * On desktop, provides tab-switching without browser reloads.
 */
function initAppCarousel() {
  const container = document.getElementById("app-carousel");
  const slides = document.querySelectorAll(".carousel-slide");
  const navLinks = document.querySelectorAll(".nav-link, .main-footer .footer-links a, .hero-cta-group a, .jobs-preview-section a, .cta-banner a");
  const headerLinks = document.querySelectorAll(".nav-links .nav-link");
  const mobileLeftBtn = document.getElementById("mobile-swipe-left");
  const mobileRightBtn = document.getElementById("mobile-swipe-right");

  if (!container || slides.length === 0) return;

  const tabIndexMap = {
    "home": 0,
    "jobs": 1,
    "about": 2
  };
  const slideIds = ["home", "jobs", "about"];

  let isProgrammaticScrolling = false;
  let scrollTimeout;

  // Update visibility of left/right arrow icons on mobile
  function updateMobileArrows(activeIndex) {
    if (mobileLeftBtn && mobileRightBtn) {
      if (activeIndex === 0) {
        mobileLeftBtn.classList.add("hidden");
        mobileRightBtn.classList.remove("hidden");
      } else if (activeIndex === slides.length - 1) {
        mobileLeftBtn.classList.remove("hidden");
        mobileRightBtn.classList.add("hidden");
      } else {
        mobileLeftBtn.classList.remove("hidden");
        mobileRightBtn.classList.remove("hidden");
      }
    }
  }

  // Switch to selected slide/tab
  function switchToTab(tabId, smooth = true) {
    const targetIndex = tabIndexMap[tabId] !== undefined ? tabIndexMap[tabId] : 0;
    const isMobile = window.innerWidth <= 768;

    // Desktop: Update active class to show/hide slides
    slides.forEach((slide, idx) => {
      if (idx === targetIndex) {
        slide.classList.add("active");
      } else {
        slide.classList.remove("active");
      }
    });

    // Update active state of navigation links
    headerLinks.forEach(link => {
      const dataTab = link.getAttribute("data-tab");
      if (dataTab === tabId) {
        link.classList.add("active");
      } else {
        link.classList.remove("active");
      }
    });

    // Update mobile navigation arrows visibility
    if (isMobile) {
      container.style.transform = ""; // Reset transform to allow native swiping on mobile
      updateMobileArrows(targetIndex);
      
      isProgrammaticScrolling = true;
      clearTimeout(scrollTimeout);

      // Scroll container horizontally using actual client width
      const slideWidth = container.clientWidth || window.innerWidth;
      container.scrollTo({
        left: targetIndex * slideWidth,
        behavior: smooth ? "smooth" : "auto"
      });

      // Reset individual active slide scroll back to top gracefully
      const activeSlide = container.querySelector(".carousel-slide.active");
      if (activeSlide) {
        activeSlide.scrollTop = 0;
      }

      // Release programmatic flag after scroll duration
      scrollTimeout = setTimeout(() => {
        isProgrammaticScrolling = false;
      }, 400);
    } else {
      // Hide arrows on desktop always
      if (mobileLeftBtn) mobileLeftBtn.classList.add("hidden");
      if (mobileRightBtn) mobileRightBtn.classList.add("hidden");

      // Slide using CSS transform on desktop!
      if (!smooth) {
        const originalTransition = container.style.transition;
        container.style.setProperty("transition", "none", "important");
        container.style.transform = `translateX(-${targetIndex * 100}%)`;
        // Force browser layout reflow
        container.offsetHeight;
        container.style.transition = originalTransition;
      } else {
        container.style.transform = `translateX(-${targetIndex * 100}%)`;
      }
    }

    // Update browser URL hash quietly
    if (window.location.hash !== `#${tabId}`) {
      history.replaceState(null, null, `#${tabId}`);
    }
  }

  // Handle Hash Changes (e.g., back navigation)
  window.addEventListener("hashchange", () => {
    const hash = window.location.hash.replace("#", "") || "home";
    switchToTab(hash);
  });

  // Attach link listeners
  navLinks.forEach(link => {
    link.addEventListener("click", (e) => {
      const href = link.getAttribute("href");
      if (href && href.startsWith("#")) {
        e.preventDefault();
        const tabId = href.replace("#", "");
        switchToTab(tabId);
        
        // Close mobile drawer menu
        const menuToggle = document.querySelector(".mobile-menu-toggle");
        const navLinksWrapper = document.querySelector(".nav-links");
        if (menuToggle && navLinksWrapper) {
          navLinksWrapper.classList.remove("open");
          menuToggle.classList.remove("active");
          if (window.innerWidth <= 768) {
            document.body.style.overflow = "hidden";
          } else {
            document.body.style.overflow = "auto";
          }
        }
      }
    });
  });

  // High performance scroll listener to sync swipe gesture with active headers
  let scrollDebounce;
  container.addEventListener("scroll", () => {
    if (isProgrammaticScrolling) return;

    clearTimeout(scrollDebounce);
    scrollDebounce = setTimeout(() => {
      const scrollLeft = container.scrollLeft;
      const slideWidth = container.clientWidth || window.innerWidth;
      const activeIndex = Math.round(scrollLeft / slideWidth);
      
      const activeSlideId = slideIds[activeIndex];
      
      if (activeSlideId) {
        // Update arrows state based on scroll slide
        updateMobileArrows(activeIndex);

        // Update active class on slides for correct height tracking
        slides.forEach((slide, idx) => {
          if (idx === activeIndex) {
            slide.classList.add("active");
          } else {
            slide.classList.remove("active");
          }
        });

        headerLinks.forEach(link => {
          const dataTab = link.getAttribute("data-tab");
          if (dataTab === activeSlideId) {
            link.classList.add("active");
          } else {
            link.classList.remove("active");
          }
        });

        if (window.location.hash !== `#${activeSlideId}`) {
          history.replaceState(null, null, `#${activeSlideId}`);
        }
      }
    }, 60);
  }, { passive: true });

  // Attach click listeners to mobile navigation arrow buttons
  if (mobileLeftBtn) {
    mobileLeftBtn.addEventListener("click", () => {
      const activeSlide = container.querySelector(".carousel-slide.active");
      if (activeSlide) {
        const currentTabId = activeSlide.getAttribute("data-slide-id") || "home";
        const currentIndex = tabIndexMap[currentTabId] !== undefined ? tabIndexMap[currentTabId] : 0;
        if (currentIndex > 0) {
          switchToTab(slideIds[currentIndex - 1]);
        }
      } else {
        // Fallback to URL hash
        const hash = window.location.hash.replace("#", "") || "home";
        const currentIndex = tabIndexMap[hash] !== undefined ? tabIndexMap[hash] : 0;
        if (currentIndex > 0) {
          switchToTab(slideIds[currentIndex - 1]);
        }
      }
    });
  }

  if (mobileRightBtn) {
    mobileRightBtn.addEventListener("click", () => {
      const activeSlide = container.querySelector(".carousel-slide.active");
      if (activeSlide) {
        const currentTabId = activeSlide.getAttribute("data-slide-id") || "home";
        const currentIndex = tabIndexMap[currentTabId] !== undefined ? tabIndexMap[currentTabId] : 0;
        if (currentIndex < slides.length - 1) {
          switchToTab(slideIds[currentIndex + 1]);
        }
      } else {
        // Fallback to URL hash
        const hash = window.location.hash.replace("#", "") || "home";
        const currentIndex = tabIndexMap[hash] !== undefined ? tabIndexMap[hash] : 0;
        if (currentIndex < slides.length - 1) {
          switchToTab(slideIds[currentIndex + 1]);
        }
      }
    });
  }

  // Auto-init on page load
  const initialHash = window.location.hash.replace("#", "") || "home";
  switchToTab(initialHash, false);

  // Recalculate alignments on resizing (e.g., orientation change)
  window.addEventListener("resize", () => {
    const currentHash = window.location.hash.replace("#", "") || "home";
    switchToTab(currentHash, false);
  });
}

/**
 * Mobile Navigation Drawer Control
 */
function initMobileNav() {
  const menuToggle = document.querySelector(".mobile-menu-toggle");
  const navLinks = document.querySelector(".nav-links");

  if (menuToggle && navLinks) {
    menuToggle.addEventListener("click", () => {
      const isOpen = navLinks.classList.contains("open");
      if (isOpen) {
        navLinks.classList.remove("open");
        menuToggle.classList.remove("active");
        if (window.innerWidth <= 768) {
          document.body.style.overflow = "hidden";
        } else {
          document.body.style.overflow = "auto";
        }
      } else {
        navLinks.classList.add("open");
        menuToggle.classList.add("active");
        document.body.style.overflow = "hidden"; // Prevent scrolling when menu is open
      }
    });

    // Close menu when clicking a link
    navLinks.querySelectorAll("a").forEach(link => {
      link.addEventListener("click", () => {
        navLinks.classList.remove("open");
        menuToggle.classList.remove("active");
        if (window.innerWidth <= 768) {
          document.body.style.overflow = "hidden";
        } else {
          document.body.style.overflow = "auto";
        }
      });
    });
  }
}

/**
 * Core Dynamic Client-Side Jobs Listing & Live Search Engine with Desktop Carousel support
 */
function initJobsEngine() {
  const jobsListWrapper = document.getElementById("jobs-cards-target");
  if (!jobsListWrapper) return;

  const roleSearch = document.getElementById("role-search");
  const locationSearch = document.getElementById("location-search");
  const searchBtn = document.getElementById("search-btn");
  const filterToggleBtn = document.getElementById("filter-toggle-btn");
  const filtersDrawer = document.getElementById("filters-drawer");
  const fallbackState = document.getElementById("no-jobs-fallback");
  const jobsCountBadge = document.getElementById("jobs-count");

  const prevBtn = document.getElementById("jobs-prev-btn");
  const nextBtn = document.getElementById("jobs-next-btn");
  let currentJobIndex = 0;

  function updateJobsCarousel() {
    const visibleCards = Array.from(jobsListWrapper.querySelectorAll(".job-card")).filter(card => card.style.display !== "none");
    const isMobile = window.innerWidth <= 768;

    if (isMobile) {
      jobsListWrapper.style.transform = "";
      if (prevBtn) prevBtn.disabled = true;
      if (nextBtn) nextBtn.disabled = true;
      return;
    }

    if (visibleCards.length === 0) {
      if (prevBtn) prevBtn.disabled = true;
      if (nextBtn) nextBtn.disabled = true;
      return;
    }

    const cardsToShow = 2;
    const maxIndex = Math.max(0, visibleCards.length - cardsToShow);

    if (currentJobIndex > maxIndex) {
      currentJobIndex = maxIndex;
    }
    if (currentJobIndex < 0) {
      currentJobIndex = 0;
    }

    if (prevBtn) prevBtn.disabled = currentJobIndex === 0;
    if (nextBtn) nextBtn.disabled = currentJobIndex === maxIndex;

    const firstCard = visibleCards[0];
    if (firstCard) {
      const cardWidth = firstCard.getBoundingClientRect().width;
      const gap = 20;
      const offset = currentJobIndex * (cardWidth + gap);
      jobsListWrapper.style.transform = `translateX(-${offset}px)`;
    } else {
      jobsListWrapper.style.transform = "translateX(0px)";
    }
  }

  function renderJobsList() {
    const cards = jobsListWrapper.querySelectorAll(".job-card");
    const roleQuery = (roleSearch?.value || "").toLowerCase().trim();
    const locationQuery = (locationSearch?.value || "").toLowerCase().trim();
    const selectedTypes = Array.from(document.querySelectorAll('input[name="type"]:checked')).map(cb => cb.value.toLowerCase());

    let visibleCount = 0;

    cards.forEach(card => {
      const cardType = (card.getAttribute("data-type") || "").toLowerCase();
      const cardTitle = (card.getAttribute("data-title") || card.querySelector(".job-title")?.textContent || "").toLowerCase();
      const cardLocation = (card.getAttribute("data-location") || card.querySelector(".job-meta")?.textContent || "").toLowerCase();

      const matchesType = selectedTypes.length === 0 || selectedTypes.includes(cardType);
      const matchesRole = cardTitle.includes(roleQuery);
      const matchesLocation = cardLocation.includes(locationQuery);
      const isVisible = matchesType && matchesRole && matchesLocation;

      card.style.display = isVisible ? "" : "none";
      if (isVisible) visibleCount++;
    });

    if (fallbackState) {
      fallbackState.style.display = visibleCount > 0 ? "none" : "block";
    }

    if (jobsCountBadge) {
      jobsCountBadge.textContent = `${visibleCount} Total`;
    }

    currentJobIndex = 0;
    updateJobsCarousel();
  }

  if (filterToggleBtn && filtersDrawer) {
    filterToggleBtn.addEventListener("click", () => {
      const isOpen = filtersDrawer.classList.contains("open");
      if (isOpen) {
        filtersDrawer.classList.remove("open");
        filterToggleBtn.classList.remove("active");
      } else {
        filtersDrawer.classList.add("open");
        filterToggleBtn.classList.add("active");
      }
    });
  }

  if (searchBtn) {
    searchBtn.addEventListener("click", renderJobsList);
  }

  if (roleSearch) {
    roleSearch.addEventListener("keyup", renderJobsList);
  }

  if (locationSearch) {
    locationSearch.addEventListener("keyup", renderJobsList);
  }

  document.querySelectorAll('input[name="type"]').forEach(cb => {
    cb.addEventListener("change", renderJobsList);
  });

  if (prevBtn) {
    prevBtn.addEventListener("click", () => {
      if (currentJobIndex > 0) {
        currentJobIndex--;
        updateJobsCarousel();
      }
    });
  }

  if (nextBtn) {
    nextBtn.addEventListener("click", () => {
      const visibleCards = Array.from(jobsListWrapper.querySelectorAll(".job-card")).filter(card => card.style.display !== "none");
      const cardsToShow = 2;
      const maxIndex = Math.max(0, visibleCards.length - cardsToShow);
      if (currentJobIndex < maxIndex) {
        currentJobIndex++;
        updateJobsCarousel();
      }
    });
  }

  window.addEventListener("resize", updateJobsCarousel);
  renderJobsList();
}
