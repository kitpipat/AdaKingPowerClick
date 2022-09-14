function JCNxOpenModal(pnModalWidth) {

    nModalID = Math.floor(Math.random() * 90000) + 10000;

    var tModal = '<div class="modal fade" id="odvModal' + nModalID + '" tabindex="-1" role="dialog">';
    tModal += '<div class="modal-dialog" id="modal-customs' + nModalID + '" role="document" >';
    tModal += '<div class="modal-header">';
    tModal += '<h5 class="modal-title" id="exampleModalLabel">New message</h5>';
    tModal += '<button type="button" class="close"  aria-label="Close" onclick="JCNxCloseModal(' + "'" + nModalID + "'" + ')">';
    tModal += '<span aria-hidden="true">&times;</span>';
    tModal += '</button>';
    tModal += '</div>';
    tModal += '<div class="modal-content">';
    tModal += '<div class="modal-body">';
    tModal += '<div id="odvModalBody" style="background:#ffffff"> <iframe  id="info" class="iframe" name="info" seamless="" height="70%" width="100%"></iframe></div>';
    tModal += '</div>';
    tModal += '</div>';
    tModal += '</div>';
    tModal += '</div>';

    $("body").append(tModal);
    $('#modal-customs' + nModalID).attr("style", 'min-width:' + pnModalWidth + '%; margin: 1.75rem auto;');

    $('#odvModal' + nModalID).modal({ backdrop: 'static', show: true, keyboard: false });
}

function JCNxCloseModal(pnModalID) {
    $('#odvModal' + pnModalID).modal('hide');
    $('#odvModal' + pnModalID).remove();
    $('.modal-backdrop').remove();
}

function JCNxOpenBrowser(ptRouteData, ptSltClbVal, ptSltClbText, ptClbType, pnModalWidth) {

    JCNxOpenModal(pnModalWidth);

}