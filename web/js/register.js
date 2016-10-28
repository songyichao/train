$('#send').click(function() {
    var data = $('#registerform-phone').val();
    // var phone = 'phone';
    console.log(data);

    $.post('/user/send', {data : data}, function (result) {
        console.log(result);
        if (result == true) {
            $("#send").attr("disabled", true);
            $('#send').text("已发送");
        } else {
            $('#send').text("发送验证码");
        }
    });
});