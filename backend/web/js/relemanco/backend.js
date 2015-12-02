var _blockUIContent = $("#_block_ui_message").html();
function blockScreenOnAction(){
    $.blockUI({ message: _blockUIContent});
}
function blockFormOnAction(idForm){
    $("#" + idForm).blockUI({ message: _blockUIContent});
}