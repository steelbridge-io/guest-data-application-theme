/**
 * CSV Export functionality for Guest Data App
 * 
 * Handles client-side CSV export trigger and communicates with
 * the server-side export handler via AJAX.
 * 
 * @package Guest_Data_Application_Theme
 * Author: Chris Parsons
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        // Handle CSV export button click
        $(document).on('click', '#exportCsvBtn', function(e) {
            e.preventDefault();

            const button = $(this);
            const originalHtml = button.html();
            
            // Get form ID from the page
            const formId = $('#gda-table').data('form-id');
            
            if (!formId) {
                alert('Error: Form ID not found. Cannot export data.');
                return;
            }

            // Get current filter values
            const hidePastDates = $('#hidePastDates').is(':checked') ? '1' : '0';
            const filterYear = $('#filterYear').val() || '';
            const filterArrivalDate = $('#filter_arrival_date').val() || '';
            const destinationTitle = $('h1').first().text() || 'Guest Data';

            // Show loading state
            button.prop('disabled', true);
            button.html('<i class="bi bi-hourglass-split me-1"></i>Exporting...');

            // Prepare AJAX data
            const ajaxData = {
                action: 'export_guest_data_csv',
                security: gda_csv_export.nonce,
                form_id: formId,
                hide_past_dates: hidePastDates,
                filter_year: filterYear,
                filter_arrival_date: filterArrivalDate,
                destination_title: destinationTitle
            };

            // Create a form and submit it to download the CSV
            // Using form submission instead of AJAX to trigger browser download
            const form = $('<form>', {
                method: 'POST',
                action: gda_csv_export.ajax_url
            });

            // Add all data as hidden fields
            $.each(ajaxData, function(key, value) {
                form.append($('<input>', {
                    type: 'hidden',
                    name: key,
                    value: value
                }));
            });

            // Append to body and submit
            $('body').append(form);
            form.submit();

            // Clean up form after a delay
            setTimeout(function() {
                form.remove();
                // Restore button state
                button.prop('disabled', false);
                button.html(originalHtml);
            }, 1000);
        });
    });

})(jQuery);
