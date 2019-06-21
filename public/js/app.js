/* --------------------------------------------- Global functions --------------------------------------------- */

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

        completedToDos   = $('.todo-list .completed').length;
        unCompletedToDos = $('.todo-list .uncompleted').length;

        if (completedToDos === 0) {
            $('.clear-completed').addClass('hidden');
        } else {
            $('.clear-completed').removeClass('hidden');
        }

        $('#todosCount').html(unCompletedToDos);

        if (data.length === 0) {
            footer.addClass('hidden');
            main.addClass('hidden');
        } else {
            footer.removeClass('hidden');
            main.removeClass('hidden');
        }
    });
}

function showCompleted() {
    $(".completed").show();
    $(".uncompleted").hide();
}

function showUncompleted() {
    $(".uncompleted").show();
    $(".completed").hide();
}

function showAll() {
    $(".uncompleted, .completed").show()
}

function deleteCompleted() {
    ids = [];

    $(".completed").each(function(index) {
        ids.push($(this).children('.view').attr('id'));
    });

    sendAJAX('api/v1/todos', ids, "json", 'DELETE', function (data) {
        refreshList();
    });
}

$(document).ready(function () {
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

    $('.todo-list').on('dblclick', 'label', function (e) {
        var $input = $(e.target).closest('li').addClass('editing').find('.edit');
        var tmpStr = $input.val();

        $input.val('');
        $input.val(tmpStr);
        $input.focus();
    });

    $('.todo-list').on('focusout', '.edit', function (e) {
        var el = e.target;
        var $el = $(el);
        var val = $el.val().trim();

        if ($el.data('abort')) {
            $el.data('abort', false);
        } else if (!val) {
            $el.parent().children('.view').children('.destroy').trigger('click');
            return;
        } else {
            todoId   = $el.parent().children('.view').attr('id');
            todoDone = $el.parent().children('.view').children('.toggle').is(':checked');

            sendAJAX('api/v1/todos/' + todoId, {
                id: todoId,
                done: todoDone,
                title: val
            }, "json", 'PUT', function (data) {
                refreshList();
            });
        }
    });

    $('.todo-list').on('keyup', function (e) {
        if (e.which === 13) {
            e.target.blur();
        }

        if (e.which === 27) {
            $(e.target).data('abort', true).blur();
        }
    });

    /* --------------------------------------------- On ready --------------------------------------------- */

    refreshList();
});