<div class="modal" id="modalShowContactDelete">
    <div class="modal-dialog">
        <div class="modal-content modal-max-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('app.delete_contact')</h4>
                <button type="button" class="close" data-dismiss="modal" id="close-edit-contact">&times;</button>
            </div>
            <form class="delete_modal">
                <div class="modal-body">
                    @lang('app.delete_confirm')
                </div>
                <div class="modal-footer">
                    <input class="delete-input-contact" hidden="hidden">
                    <button type="button" class="btn btn-secondary" id="cancel-delete"
                            data-dismiss="modal">@lang('app.cancel')</button>
                    <button class="btn btn-danger" data-dismiss="modal"
                            id="confirm-delete-contact">@lang('app.delete')</button>
                </div>
            </form>
        </div>
    </div>
</div>