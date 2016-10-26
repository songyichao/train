$('#send').click(function() {
    var data = $('#registerform-phone').val();
    // var phone = 'phone';
    console.log(data);

    $.post('/user/send', {data : data}, function (result) {
        console.log(result);
        if (result) {
            // location.href = location.href;
        } else {
            alert('删除失败');
        }
    });
});