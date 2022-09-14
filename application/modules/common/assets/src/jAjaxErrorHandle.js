function JCNtMessageError(ptError) {
    alert('xxxxx');
    $("body").append(tModal);
    $('#modal-customs').attr("style", 'min-width: 150px; margin: 1.75rem auto;');

    $('#myModal').modal({ show: true });
    $('#odvModalBody').html(tError);

}