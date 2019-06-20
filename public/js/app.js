$(document).ready(function() {
    /* --------------------------------------------- Functions --------------------------------------------- */
    function sendAJAX(url, data, dataType, onSuccess, onError = function (data, textStatus, errorThrown) {
        console.log(data);
        console.log(textStatus);
        console.log(errorThrown);
    }) {
        $.ajax({
            url: url,
            method: "POST",
            dataType: dataType,
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(data),
            success: onSuccess,
            error: onError,
        });
    }

    function refreshList() {
        sendAJAX('to-do/ajax', {}, "html", function (data) {
            $('#dynamic-todo-list').html( data );
        });
    }

    /* --------------------------------------------- Events --------------------------------------------- */

    $('.new-todo').on('keyup', function (e) {
        var input = $(e.target);
        var val   = input.val().trim();

        if (e.which !== 13 || !val) {
            return;
        }

        sendAJAX('to-do/create', {title: val}, "json", function (data) {
            refreshList();
        });

        input.val('');
    });

    $('.todo-list').on('click', '.destroy', function (e) {
        var button = $(e.target);

        todoId = button.parent().attr('id');

        sendAJAX('to-do/remove', {id: todoId}, "json", function (data) {
            refreshList();
        });
    });

    $('.todo-list').on('change', '.toggle', function (e) {
        var toggle = $(e.target);

        todoId    = toggle.parent().attr('id');
        todoTitle = toggle.parent().children('.title').text().trim();

        sendAJAX('to-do/edit', {
            id: todoId,
            done: toggle.is(':checked'),
            title: todoTitle
        }, "json", function (data) {
            refreshList();
        });
    });

    /* --------------------------------------------- On ready --------------------------------------------- */

    refreshList();
});