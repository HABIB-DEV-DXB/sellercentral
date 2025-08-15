// public/assets/js/landing.js

document.addEventListener('DOMContentLoaded', () => {
    const bannerSlider = document.querySelector('.banner-slider');
    
    // Function to fetch banners from the API.
    async function fetchBanners() {
        try {
            // This is a placeholder for your actual API endpoint.
            // You will need to replace this with the correct URL.
            const response = await fetch('http://api.yourplatform.com/banners');
            const banners = await response.json();
            
            if (banners.length > 0) {
                // Remove placeholder
                bannerSlider.innerHTML = '';
                
                // Dynamically create a banner for each item from the API.
                banners.forEach(banner => {
                    const bannerItem = document.createElement('div');
                    bannerItem.className = 'banner-item';
                    bannerItem.innerHTML = `
                        <img src="${banner.image_url}" alt="${banner.heading}">
                        <div class="banner-content">
                            <h2>${banner.heading}</h2>
                            <p>${banner.subtitle}</p>
                            <a href="${banner.action_link}" class="glass-button">${banner.action_text}</a>
                        </div>
                    `;
                    bannerSlider.appendChild(bannerItem);
                });
            }
        } catch (error) {
            console.error('Error fetching banners:', error);
        }
    }

    fetchBanners();

    // A simple JavaScript function for the sidebar toggle on mobile
    if (document.querySelector('.hamburger')) {
        document.querySelector('.hamburger').addEventListener('click', () => {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    }
});