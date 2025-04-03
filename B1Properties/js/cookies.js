// Enhanced cookies.js with consent management

// Check if user has given cookie consent
function hasCookieConsent() {
    return getCookie('cookie_consent') === 'true';
  }
  
  // Check if user has rejected cookies
  function hasRejectedCookies() {
    return getCookie('cookie_consent') === 'false';
  }
  
  // Get cookie value by name
  function getCookie(name) {
    const cookies = document.cookie.split(';');
    for (const cookie of cookies) {
      const [cookieName, cookieValue] = cookie.trim().split('=');
      if (cookieName === name) {
        return decodeURIComponent(cookieValue);
      }
    }
    return null;
  }
  
  // Set cookie with options
  function setCookie(name, value, days = 30) {
    const date = new Date();
    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = `expires=${date.toUTCString()}`;
    document.cookie = `${name}=${encodeURIComponent(value)}; ${expires}; path=/`;
  }
  
  // Delete cookie
  function deleteCookie(name) {
    document.cookie = `${name}=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
  }
  
  // Show cookie consent banner
  function showCookieConsentBanner() {
    const banner = document.getElementById('cookie-consent-banner');
    if (banner && !getCookie('cookie_consent')) {
      banner.style.display = 'block';
    }
  }
  
  // Hide cookie consent banner
  function hideCookieConsentBanner() {
    const banner = document.getElementById('cookie-consent-banner');
    if (banner) banner.style.display = 'none';
  }
  
  // Set form submission cookie (only if consent given)
  function setFormSubmissionCookie() {
    if (!hasCookieConsent()) return;
    
    const now = new Date();
    // Set cookie to expire in 5 seconds (for testing)
    const expires = new Date(now.getTime() + 5 * 1000).toUTCString();
    document.cookie = `formSubmitted=${now.getTime()}; expires=${expires}; path=/`;
  }
  
  // Check if form was recently submitted
  function wasFormRecentlySubmitted() {
    if (!hasCookieConsent()) return false;
    
    const submissionTime = parseInt(getCookie('formSubmitted'));
    if (!submissionTime) return false;
    
    const now = new Date().getTime();
    return (now - submissionTime) < 5000; // 5 seconds
  }
  
  // Initialize cookie consent
  function initCookieConsent() {
    // Show banner if no consent decision exists
    if (!getCookie('cookie_consent')) {
      showCookieConsentBanner();
    }
    
    // Set up event listeners for consent buttons
    const acceptBtn = document.getElementById('accept-cookies');
    const rejectBtn = document.getElementById('reject-cookies');
    
    if (acceptBtn) {
      acceptBtn.addEventListener('click', () => {
        setCookie('cookie_consent', 'true', 365);
        hideCookieConsentBanner();
      });
    }
    
    if (rejectBtn) {
      rejectBtn.addEventListener('click', () => {
        setCookie('cookie_consent', 'false', 365);
        hideCookieConsentBanner();
        // Delete any existing cookies
        deleteCookie('formSubmitted');
      });
    }
    
    // Add form submission handlers
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
      form.addEventListener('submit', function(e) {
        if (hasRejectedCookies()) {
          // User rejected cookies - submit form normally
          return true;
        }
        
        if (wasFormRecentlySubmitted()) {
          e.preventDefault();
          alert('Please wait a few seconds before submitting another form.');
          return false;
        }
        
        setFormSubmissionCookie();
        return true;
      });
    });
  }
  
  // Initialize when DOM is loaded
  document.addEventListener('DOMContentLoaded', initCookieConsent);