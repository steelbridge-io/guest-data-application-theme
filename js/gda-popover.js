jQuery(document).ready(function($) {
    function initializePopovers() {
        const popoverTriggerList = [].slice.call(document.querySelectorAll('.btn-popover'));
        const popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
            return new bootstrap.Popover(popoverTriggerEl, {
                trigger: 'click',
                html: true
            });
        });

        // Handle button click events to toggle popovers
        $(popoverTriggerList).on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var $this = $(this);

            // Hide other popovers before showing the current one
            popoverList.forEach(popover => {
                if (popover._element !== this) {
                    popover.hide();
                }
            });

            // Toggle the current popover
            bootstrap.Popover.getOrCreateInstance($this[0]).toggle();
        });
    }

    // Initial call to bind popovers on page load
    initializePopovers();

    // Event handler for dynamically loaded content
    $(document).on('content-loaded', function() {
        // Re-initialize popovers after content load
        initializePopovers();
    });

    // Close popovers when clicking outside
    $(document).on('click', function(e) {
        const popoverTriggerList = [].slice.call(document.querySelectorAll('.btn-popover'));
        popoverTriggerList.forEach(popoverTriggerEl => {
            const popoverInstance = bootstrap.Popover.getInstance(popoverTriggerEl);
            if (popoverInstance && !popoverTriggerEl.contains(e.target) && !popoverInstance.tip.contains(e.target)) {
                popoverInstance.hide();
            }
        });
    });

    // Function to update and show full content in popover
    window.showFullContent = function(link) {
        const $link = $(link);
        const popoverTrigger = $link.closest('.popover').prev('.btn-popover')[0];

        // Fetch full content from the data attribute or an alternative source
        const fullContent = popoverTrigger.getAttribute('data-full-content');

        // Update popover content
        const popoverInstance = bootstrap.Popover.getInstance(popoverTrigger);
        popoverInstance.setContent({
            '.popover-body': fullContent
        });
        popoverInstance.show();
    };
});

// Second part for loading content via AJAX
jQuery(document).ready(function($) {
    // Example function to load content via AJAX
    function loadContent(formId) {
        $.ajax({
            url: ajaxurl,
            method: 'POST',
            data: { action: 'fetch_content', form_id: formId },
            success: function(response) {
                var data = JSON.parse(response);
                $('.dynamic-content-container').html(data.content);  // Replace container content

                // Trigger custom event for dynamic content loaded
                $(document).trigger('content-loaded');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log("AJAX Error: " + textStatus);
            }
        });
    }

    // Initialize popover for dynamically loaded content
    $(document).on('content-loaded', function() {
        initializePopovers();
    });

    // Demo load call (replace your actual event/call trigger)
    // loadContent(someFormId);
});