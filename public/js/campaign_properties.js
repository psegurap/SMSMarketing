

$(document).ready(function(){
    $('#reachable-properties').DataTable({
        responsive : true,
        // paging: false,
    });

    $('#unreachable-properties').DataTable({
        responsive : true,
        // paging: false,
    });

    $('#reachable-properties .property-option, #unreachable-properties .property-option').click(function (){
        window.open(homepath + '/campaigns/propertyinfo/' + $(this).data('campaignid') + "/" + $(this).data('contactid'), '_blank');
    });
});


