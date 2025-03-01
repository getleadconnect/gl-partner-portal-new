$(document).ready(function() {
    // Make elements draggable
    $(".draggable-element").draggable({
        helper: "clone"
    });

    // Make badge area droppable
    $("#badge-area").droppable({
        accept: ".draggable-element",
        drop: function(event, ui) {
            var elementType = ui.helper.data("type");
            var newElement;

            switch (elementType) {
                case "name":
                    newElement = $("<div class='draggable-item'>Name</div>");
                    break;
                case "company-name":
                    newElement = $("<div class='draggable-item'>Company Name</div>");
                    break;
                case "qr-code":
                    newElement = $("<div class='draggable-item'><img src='assets/images/qr-placeholder.png' alt='QR Code'></div>");
                    break;
            }

            newElement.css({
                top: ui.offset.top - $(this).offset().top,
                left: ui.offset.left - $(this).offset().left
            }).appendTo("#badge-area").draggable({
                containment: "#badge-area"
            }).resizable();
        }
    });

    // Upload badge background
    $("#badge-upload").on("change", function(event) {
        var reader = new FileReader();
        reader.onload = function(event) {
            $("#badge-area").css("background-image", "url('" + event.target.result + "')");
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    // Save badge
    $("#save-badge").on("click", function() {
        html2canvas($("#badge-area")[0]).then(function(canvas) {
            var link = document.createElement('a');
            link.href = canvas.toDataURL();
            link.download = 'badge.png';
            link.click();
        });
    });
});
