$(document).ready(function () {

    $("#gerar").on('click', function () {
     
        var doc = new jsPDF();

        doc.formHTML($('#a').get(0), 20, 20,{
                        'width' :500});

        
            doc.save('teste.pdf');
    });

    


      
 
});
