$(document).ready(function () {

    $(function(){

        $('#upload').change(function(){
        
            var imagem = document.querySelector('input[id=upload]').files[0];
            var preview = document.querySelector('#img');
            var reader = new FileReader();
            $('#img').width(400).height(400);
            
            reader.onloadend = function (){

                preview.src = reader.result;
                
            }
                if(imagem){
                    reader.readAsDataURL(imagem);
                }else{
        
                }
        })
    })
 
});
