const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});

$(function () {
    $("#menu-structure, #available-menu-items").sortable({
        connectWith: ".menu-list"
    }).disableSelection();
});

$(document).on('click', '.delete', function () {
    var id = $(this).attr('data-id');
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value) {
            if($(".menu-updater input[name='id']").val() == id) {
                clearForm("menu-updater");
                $(".menu-updater").slideUp();
                $("#save-menu-structure").fadeIn();
            }
            $("#"+id).remove();
        }
    })
});

$(document).on('click', '.edit', function () {
    var id = $(this).attr('data-id');
    $(".menu-updater input[name='name']").val($("#"+id).attr("data-name"));
    $(".menu-updater input[name='link']").val($("#"+id).attr("data-link"));
    if(parseInt($("#"+id).attr("data-type")) == 3) {
        $(".menu-updater input[name='new_tab']").prop('checked', true);
    }
    $(".menu-updater input[name='id']").val(id);
    $(".menu-updater").slideDown();
    $("#save-menu-structure").fadeOut();
});

$(document).on('click', '#menu-updater button', function () {
    if($(this).attr("action") == "update") {
        var data = [];
        data.name = $("#menu-updater input[name='name']").val();
        data.link = $("#menu-updater input[name='link']").val();
        data.new_tab = $("#new_tab_update").is(":checked");
        if ($.trim(data.link) == "" || $.trim(data.name) == "") {
            alert("Nopa");
            return;
        }
        data.id = parseInt($("#menu-updater input[name='id']").val());
        updateMenu(data);
    }
    clearForm("menu-updater");
    $(".menu-updater").slideUp();
    $("#save-menu-structure").fadeIn();
});

$(document).on('click', '#menu-adder button', function () {
    var data = [];
    data.name = $("#menu-adder input[name='name']").val();
    data.link = $("#menu-adder input[name='link']").val();
    data.new_tab = $("#new_tab_add").is(":checked");
    if ($.trim(data.link) == "" || $.trim(data.name) == "") {
        alert("Nopa");
        return;
    }
    data.id = parseInt($("#next-id").text());
    $("#next-id").html(data.id + 1);
    addToMenu(data);
    clearForm("menu-adder");
});

function updateMenu(data) {
    var actions = "<span data-id='"+data.id+"' class='delete'><i class='far fa-trash-alt'></i></span><span data-id='"+data.id+"' class='edit'><i class='far fa-edit'></i></span>";
    $("#" + data.id).attr('data-link', data.link).attr('data-name', data.name);
    $("#" + data.id).html(data.name + actions);
    if(data.new_tab) {
        $("#" + data.id).attr('data-type', 3);
    } else {
        $("#" + data.id).attr('data-type', 1);
    }
}

function addToMenu(data) {
    var additional = "";
    if (data.new_tab) {
        additional = "data-type='3'";
    }
    var actions = "<span data-id='"+data.id+"' class='delete'><i class='far fa-trash-alt'></i></span><span data-id='"+data.id+"' class='edit'><i class='far fa-edit'></i></span>";
    var element = "<li id='" + data.id + "' data-link='" + data.link + "' data-name='" + data.name + "' " + additional + ">" + data.name + actions + "</li>";
    $("#menu-structure").append(element);
    $("#menu-structure").sortable("refresh");
}

function clearForm(form) {
    $("#"+form+" input[name='link']").val("");
    $("#"+form+" input[name='name']").val("");
}

$(document).on('click', '#save-menu-structure', function () {
    Swal.fire({
        title: 'Are you sure?',
        text: "All previous structure will be removed!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, save it!',
        allowOutsideClick: false,
    }).then((result) => {
        if(result.value) {
            Swal.fire({
                title: 'Please Wait..!',
                text: 'Saving..',
                type: 'warning',
                animation: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                onOpen: () => {
                    swal.showLoading()
                }
            })
            var output = {};
            var list = $("#menu-structure").find('li');
            for (i = 0; i < list.length; i++) {
                if (!$.isEmptyObject(list[i].dataset)) {
                    var item = {};
                    item["link"] = list[i].dataset.link;
                    item["name"] = list[i].dataset.name;
                    item["type"] = list[i].dataset.type;
                    item["status"] = true;
                    output[i] = item;
                }
            }
            var inactive = $("#available-menu-items").find('li');
            for (j = 0; j < inactive.length; j++) {
                if (!$.isEmptyObject(inactive[j].dataset)) {
                    var item = {};
                    item["link"] = inactive[j].dataset.link;
                    item["name"] = inactive[j].dataset.name;
                    item["type"] = inactive[j].dataset.type;
                    item["status"] = false;
                    output[i] = item;
                    i++;
                }
            }
            $.post("./menu/submit", {
                "_token": $('#token').val(),
                "menu": JSON.stringify(output)
            }, function (data, status) {
                if (data == "done") {
                    Swal.fire(
                        'Saved!',
                        'Your menu structure saved successfully!',
                        'success'
                    )
                } else {
                    Swal.fire(
                        'Failed!',
                        'Oops! encountered some error. Try again later.',
                        'error'
                    )
                }
            });
        }
    });

});