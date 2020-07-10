function alertMessage(text = 'Изменения успешно внесены', type = 'success') {
    let _options = {
        notify       : "container",
        timeOut      : 5000,
        closeButton  : true,
        positionClass: "toast-top-right",
        showEasing   : "swing",
        showMethod   : "slideDown",
        showDuration : 300,
    };
    if (type === 'success')
        toastr.success(text, '', _options);
    if (type === 'error')
        toastr.error(text, '', _options);
}