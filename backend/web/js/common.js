$(function() {
    $(document).on("click",".start",function(){        
         
            $(this).datepicker({                        
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd'                       
                }).datepicker("show");
        });

    $(document).on("click",".end",function(){        
         
            $(this).datepicker({                        
                    changeMonth: true,
                    changeYear: true,
                    dateFormat: 'yy-mm-dd'                       
                }).datepicker("show");
        }); 
});