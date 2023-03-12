window.addEventListener('load', function(){
    
    var search_form = document.getElementsByName('m_name')[0];
    
    
    // Create an XMLHttpRequest object
    const xhttp = new XMLHttpRequest();

    // Define a callback function
    xhttp.onload = function() {
      
    };

    
    
    window.send_movie_name = (function( xhttp ){
        
        return function( data ){
            
            xxhttp.open("POST", "movies/");
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("fname=Henry&lname=Ford");
        };
    }( xhttp ));
    
    
    
    search_form.addEventListener( 'keyup' , function(e){
        
        var text_value = e.target.value; 
        
        text_value = text_value.trim();
        
        send_movie_name()
        
        console.log(text_value);
    });
});