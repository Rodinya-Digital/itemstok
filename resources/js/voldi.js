(function($){
    $(document).ready( function () {
        $('table').DataTable({
            responsive: true,
            searching: true,
            order:[[ 0, 'desc' ]],
            language: {
                url: dtJsLangUrl
            }
        });
    } );
    $('.select2').select2();
    if($('#kt_docs_ckeditor_classic').length){
        ClassicEditor.create(document.querySelector('#kt_docs_ckeditor_classic'))
    }
    if($('#kt_docs_ckeditor_classic2').length){
        ClassicEditor.create(document.querySelector('#kt_docs_ckeditor_classic2'))
    }
})(jQuery);

