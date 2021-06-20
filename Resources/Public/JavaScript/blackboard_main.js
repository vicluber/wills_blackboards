$(document).ready(function(){
    $("#file").change(function(){
        let fileInput = document.getElementById('file'); 
          
        let filePath = fileInput.value; 

        let allowedExtensions = /(\.jpg|\.jpeg|\.png|\.gif)$/i; 
          
        if (!allowedExtensions.exec(filePath)) { 
            alert('ungültiger Dateityp'); 
            fileInput.value = ''; 
            return false; 
        }  
        else  
        { 
            $(".file-area > .file-dummy > .success").show();
            $(".file-area > .file-dummy > .default").hide();
            $(".file-area .file-dummy").css("border", "1px solid #22522e");
            if (fileInput.files && fileInput.files[0]) { 
                var reader = new FileReader(); 
                reader.onload = function(e) { 
                    document.getElementById('imagePreview').innerHTML = '<img src="' + e.target.result  + '" width="200px"/>'; 
                }; 
                  
                reader.readAsDataURL(fileInput.files[0]); 
            } 
        } 
    });
});