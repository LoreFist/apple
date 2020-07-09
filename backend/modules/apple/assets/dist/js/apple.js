function getRandomInt(min, max) {
    return Math.floor(Math.random() * (max - min)) + min;
}

function loadShow(self) {
    self.hide();
    $('.spinner-border').show(300);
}

function loadHide(self) {
    self.show(300);
    $('.spinner-border').hide();
}

$('#apples_create').on('click', function (event) {
    let _self = $(this);
    event.preventDefault();

    loadShow(_self);
    $.post('/create', {
        count: getRandomInt(1, 10)
    }, function (response) {
        loadHide(_self);
        $.pjax.reload({container: '#apple_grid', timeout: false, async: false});
    })
});