document.addEventListener('DOMContentLoaded', function() {
    // Find all WhatsApp buttons
    const whatsappButtons = document.querySelectorAll('a[href^="https://wa.me/"]');
    
    if (whatsappButtons.length > 0) {
        // For offplan pages, extract property name from the page title
        const pageTitle = document.title;
        let propertyName = '';
        
        // Extract the property name (everything before the first | character)
        if (pageTitle.includes('|')) {
            propertyName = pageTitle.split('|')[0].trim();
        } else {
            // Fallback: try to find property name in head-title
            propertyName = document.querySelector('.head-title .title')?.textContent.trim() || '';
        }
        
        // If we have a property name, update all WhatsApp buttons
        if (propertyName) {
            // Create template message specifically for offplan properties
            const templateMessage = `Hi, I'm interested in ${propertyName} and could you please share more details and payment plan? I saw it on your website and would like to know availability and next steps.`;
            
            // Encode the message for URL
            const encodedMessage = encodeURIComponent(templateMessage);
            
            // Update all WhatsApp buttons
            whatsappButtons.forEach(function(button) {
                // Get the original WhatsApp number from the href
                const originalHref = button.getAttribute('href');
                const phoneNumber = originalHref.split('?')[0].replace('https://wa.me/', '');
                
                // Set the new href with template message
                button.setAttribute('href', `https://wa.me/${phoneNumber}?text=${encodedMessage}`);
            });
        }
    }
});