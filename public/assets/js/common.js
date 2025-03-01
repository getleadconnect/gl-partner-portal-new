$(document).ready(function() {
    // Function to initialize DataTable
    function initializeDataTable(tableId) {
        if ($.fn.dataTable.isDataTable(tableId)) {
            $(tableId).DataTable().clear().destroy();
        }

        $(tableId).DataTable({
            dom: '<"d-flex justify-content-between"fB>tip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    }

    // Initialize DataTables for Participants
    initializeDataTable('#participants-table');

    // Initialize DataTables for FAQs
    initializeDataTable('#faqs-table');

    // Add FAQ form submission
    $('#add-faq-form').on('submit', function(e) {
        e.preventDefault();
        var question = $('#faq-question').val();
        var answer = $('#faq-answer').val();
        var status = $('#faq-status').val();
        // Add AJAX call here to submit the form data to the server and add the FAQ to the database
        alert('FAQ added: ' + question);
        $('#addFaqModal').modal('hide');
    });
});
