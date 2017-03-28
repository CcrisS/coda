/**
 * Created by cristina.sanz on 20/05/16.
 */

$(function(){

    /**
     * Table sorted
     */
    $('.table .sorted a').each(function(i, elem){
        if($(elem).hasClass('asc')){
            $(elem).append('&nbsp;<i class="fa fa-sort-asc"></i>');
        } else if($(elem).hasClass('desc')){
            $(elem).append('&nbsp;<i class="fa fa-sort-desc"></i>');
        }
    });

    /**
     * Confirm dialog
     */
    $(document).on('click', '.jConfirm', function() {
        if(confirm('¿Está seguro de que desea continuar?')){
            return true;
        }

        return false;
    });

});
