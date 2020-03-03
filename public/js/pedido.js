$(document).ready(function () {

    setInterval(function(){
     
        if($('[category="cart"]').attr('class') == "bg-yellow")
            $('[category="cart"]').removeClass("bg-yellow")
        else if($('[category="cart"]').attr('class') != "bg-yellow")
            $('[category="cart"]').addClass("bg-yellow")
    
    }, 1000);
    
  
});
