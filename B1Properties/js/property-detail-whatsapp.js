// WhatsApp Template Generator for Property Detail Pages
document.addEventListener('DOMContentLoaded', function() {
    // Find all WhatsApp buttons
    const whatsappButtons = document.querySelectorAll('a[href^="https://wa.me/"]');
    
    whatsappButtons.forEach(function(button) {
        // For exclusive property detail pages, we look for the main property title and details
        // Try to find property title in head-title
        const propertyName = document.querySelector('.head-title .title')?.textContent.trim() || '';
        // Target the location element specifically with the class 'text-content capitalize-first-word'
        const propertyLocation = document.querySelector('.head-title .location .text-content.capitalize-first-word')?.textContent.trim() || 
                              document.querySelector('.head-title .location .text-content')?.textContent.trim() || '';
        const propertyPrice = document.querySelector('.head-title .price')?.textContent.trim() || '';
        
        if (propertyName) {
            // Create template message
            const templateMessage = `Hi, I'm interested in ${propertyName}${propertyLocation ? ' at '+propertyLocation : ''}${propertyPrice ? ' ('+propertyPrice+')' : ''}. Could you please share more details? I saw it on your website and would like to know availability and next steps.`;
            
            // Encode the message for URL
            const encodedMessage = encodeURIComponent(templateMessage);
            
            // Get the original WhatsApp number from the href
            const originalHref = button.getAttribute('href');
            const phoneNumber = originalHref.split('?')[0].replace('https://wa.me/', '');
            
            // Set the new href with template message
            button.setAttribute('href', `https://wa.me/${phoneNumber}?text=${encodedMessage}`);
        }
    });
});