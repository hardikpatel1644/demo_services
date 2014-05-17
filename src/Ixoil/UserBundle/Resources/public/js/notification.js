(function($) {
    $(function() {
        var $dropdownLink = $('#notification-dropdown');
        
        // Auto-read system
        if ($dropdownLink.length > 0) {
            // On open, update read notifications
            var updated = false;
            $dropdownLink.on('show.bs.dropdown', function() {
                // If already updated, stop action
                if (updated)
                    return;

                // Get URL
                var url = $dropdownLink.data('href');
                if (!url)
                    return;

                // Send request to notify server
                $.get(url, { dataType: 'json' })
                    .done(function(data) {
                        // Check success
                        var success = (data && data.success && data.success === true);
                        if (!success)
                            updated = false;
                    })
                    .fail(function() {
                        // Re-allow sending request
                        updated = false;
                    });

                // Don't send the request several times
                updated = true;
            });
        }
        
        // Detect additionnal notification togglers
        $('[data-toggle=notification]').each(function() {
            $(this).click(function(e) {
                // Get dropdown methods
                var toggle = $dropdownLink.children('.dropdown-toggle');
                if (!toggle)
                    return;
                
               // Toggle notification
               toggle.dropdown('toggle');
               
               // Disable link
               e.preventDefault();
               e.stopPropagation();
           });
        });
    });
})(window.jQuery);