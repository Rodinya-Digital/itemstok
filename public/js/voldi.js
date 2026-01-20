(function($){
    $(document).ready( function () {
        if($('table')){
            $('table:not(.no-dt)').DataTable({
                dom: "<'row'<'col-sm-6'l><'col-sm-6 text-end'f>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-6'i><'col-sm-6 text-end'p>>",
                responsive: false,
                searching: true,
                order:[[ 0, 'desc' ]],
                language: {
                    url: dtJsLangUrl
                }
            });
        }
    } );

    if($('#kt_docs_ckeditor_classic').length){
        ClassicEditor.create(document.querySelector('#kt_docs_ckeditor_classic'))
    }
    if($('#kt_docs_ckeditor_classic2').length){
        ClassicEditor.create(document.querySelector('#kt_docs_ckeditor_classic2'))
    }
})(jQuery);

