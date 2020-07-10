function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}

/**
 * открытие анимации загрузки
 * @param self
 */
function loadShow(self) {
    self.hide();
    $('.spinner-border').show(300);
}

/**
 * закрытие анимации загрузки
 * @param self
 */
function loadHide(self) {
    self.show(300);
    $('.spinner-border').hide();
}

/**
 * обработка ответа
 * @param response
 */
function setMessage(response) {
    $.pjax.reload({container: '#apple_grid', timeout: false, async: false});
    if (response.status) {
        alertMessage(response.message, 'success');
    }
    else {
        alertMessage(response.message, 'error');
    }
}

function init() {
    $('#apples_create').on('click', function (event) {
        let _self = $(this);
        event.preventDefault();

        loadShow(_self);
        $.post('/create', {
            count: getRandomInt(1, 10)
        }, function (response) {
            loadHide(_self);
            setMessage(response);
        })
    });

    $('.btn_drop').on('click', function (event) {
        let _self = $(this);
        event.preventDefault();
        loadShow(_self);
        $.get('/drop', {
            id: _self.data('id')
        }, function (response) {
            loadHide(_self);
            setMessage(response);
        })
    });

    $('.btn_eat').on('click', function (event) {
        let _self = $(this);
        event.preventDefault();
        loadShow(_self);
        $.get('/eat', {
            id     : _self.data('id'),
            percent: getRandomInt(1, 50)
        }, function (response) {
            loadHide(_self);
            setMessage(response);
        })
    });

    $('.btn_delete').on('click', function (event) {
        let _self = $(this);
        event.preventDefault();
        loadShow(_self);
        $.get('/delete', {
            id: _self.data('id'),
        }, function (response) {
            loadHide(_self);
            setMessage(response);
        })
    });
}

$('#apple_grid').ajaxSuccess(function () {
    init();
});

init();