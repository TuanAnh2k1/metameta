<div class="modal" id="modalShowAuthorDelete">
    <div class="modal-dialog">
        <div class="modal-content modal-max-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('app.delete_author')</h4>
                <button type="button" class="close" data-dismiss="modal" id="close-edit-author">&times;</button>
            </div>
            <form class="delete_modal">
                <div class="modal-body">
                    @lang('app.delete_confirm')
                </div>
                <div class="modal-footer">
                    <input class="delete-input-author" hidden="hidden">
                    <button type="button" class="btn btn-secondary" id="cancel-delete"
                            data-dismiss="modal">@lang('app.cancel')</button>
                    <button class="btn btn-danger" data-dismiss="modal"
                            id="confirm-delete-author">@lang('app.delete')</button>
                </div>
            </form>
        </div>
    </div>
</div>