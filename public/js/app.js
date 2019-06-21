$(document).ready(function () {
    /* --------------------------------------------- Functions --------------------------------------------- */
    function sendAJAX(url, data, dataType, method = 'POST', onSuccess = function () {
    }, onError = function (data, textStatus, errorThrown) {
        console.log(data);
        console.log(textStatus);
        console.log(errorThrown);
    }) {
        $.ajax({
            url: url,
            method: method,
            dataType: dataType,
            contentType: "application/json; charset=utf-8",
            data: JSON.stringify(data),
            success: onSuccess,
            error: onError,
        });
    }

    function refreshList() {
        sendAJAX('todos', {}, "html", 'POST', function (data) {
            $('#dynamic-todo-list').html(data);

            footer = $('.footer');
            main   = $('.main');

            $('#todosCount').html($('.todo-list .uncompleted').length);

            if (data.length === 0) {
                footer.addClass('hidden');
                main.addClass('hidden');
            } else {
                footer.removeClass('hidden');
                main.removeClass('hidden');
            }
        });
    }

    /* --------------------------------------------- Events --------------------------------------------- */

    $('.new-todo').on('keyup', function (e) {
        var input = $(e.target);
        var val   = input.val().trim();

        if (e.which !== 13 || !val) {
            return;
        }

        sendAJAX('api/v1/todos', {title: val}, "json", 'POST', function (data) {
            refreshList();
            input.val('');
        });
    });

    $('.todo-list').on('click', '.destroy', function (e) {
        var button = $(e.target);

        todoId = button.parent().attr('id');

        sendAJAX('api/v1/todos/' + todoId, {}, "json", 'DELETE', function (data) {
            refreshList();
        });
    });

    $('.todo-list').on('change', '.toggle', function (e) {
        var toggle = $(e.target);

        todoId    = toggle.parent().attr('id');
        todoTitle = toggle.parent().children('.title').text().trim();

        sendAJAX('api/v1/todos/' + todoId, {
            id: todoId,
            done: toggle.is(':checked'),
            title: todoTitle
        }, "json", 'PUT', function (data) {
            refreshList();
        });
    });

    /* --------------------------------------------- On ready --------------------------------------------- */

    refreshList();
});