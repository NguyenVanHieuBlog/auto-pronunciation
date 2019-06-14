$(document).ready(function(){
    $('.btn-submit').on('click', function(e){
        var text = $('#text').val();

        $.ajax({
            type: "POST",
            url: 'query.php',
            data: {text: text},
            success: function(data){
                if(data && data != ""){
                    $('.result-content').text(data)
                    $('.result').fadeIn(1000);
                }
            },
        });
    });
    $('.btn-reset').on('click', function(e){
        $('#text').val("");
        $('.result').fadeOut(1000);
    });

    $('.result').on('click', function(e){
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($('.result-content').text()).select();
        document.execCommand("copy");
        $temp.remove();
        alert('Copied to your clipboard!');
    });
});