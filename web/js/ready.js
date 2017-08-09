$(document).ready(function(){
    $("input[type='file']").fileinput({
         browseClass: "btn btn-success",
         //browseLabel: "Cargar...",
        showUpload: false,
        showRemove: false,
        language:'es',
        allowedFileExtensions:['png', 'jpg', 'pdf']
    }).on('filezoomshown', function(event, params) {
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
    })
});