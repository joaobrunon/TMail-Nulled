$(document).on('click', '#update-button', function () {
    var link = $(this).attr('link');
    $(".description_details").hide();
    $("#update-progress").show();
    $("#update-progress").append("Fetching Files<br>");
    $.get(link, {
        "step": 1
    }, function (result, status) {
        if (result == "SUCCESS") {
            $("#update-progress").append("Making Database Changes<br>");
            $.get(link, {
                "step": 2
            }, function (result, status) {
                if (result == "SUCCESS") {
                    $("#update-progress").append("Finalizing Update<br>");
                    $.get(link, {
                        "step": 3
                    }, function (result, status) {
                        if (result == "SUCCESS") {
                            $("#update-progress").append("<br><strong class='green-color'>Update Completed Successfully!</strong><br>");
                            $(".update_available").hide();
                        } else {
                            $("#update-progress").append("<strong class='red-color'>" + result + "</strong><br><br>Update Reversed. Please refresh page and start again<br>If problem persist, please contact Developer<br>");
                        }
                    });
                } else {
                    $("#update-progress").append("<strong class='red-color'>" + result + "</strong><br><br>Update Reversed. Please refresh page and start again<br>If problem persist, please contact Developer<br>");
                }
            });
        } else {
            $("#update-progress").append("<strong class='red-color'>" + result + "</strong><br><br>Update Reversed. Please refresh page and start again<br>If problem persist, please contact Developer<br>");
        }
    });
});

if ($("#manual").length) {
    if ($("#manual").text() == "TRUE") {
        var link = $("#manual").attr("link");
        $("#update-progress").show();
        $("#update-progress").append("Files Uploaded<br>");
        $("#update-progress").append("Making Database Changes<br>");
        $.get(link, {
            "step": 2
        }, function (result, status) {
            if (result == "SUCCESS") {
                $("#update-progress").append("Finalizing Update<br>");
                $("#update-progress").append("<br><strong class='green-color'>Update Completed Successfully!</strong><br>");
            } else {
                $("#update-progress").append("<strong class='red-color'>" + result + "</strong><br><br>Update Reversed. Please refresh page and start again<br>If problem persist, please contact Developer<br>");
            }
        });
    }
}