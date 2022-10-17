     $('#type').change(function(){
        var selection = $(this).children("option:selected").val();
        if(selection == "externe")
        {
            $('#password').slideUp();
        }
        else{
            $('#password').slideDown();
            $('#pass').required = true;
        }
    })



    