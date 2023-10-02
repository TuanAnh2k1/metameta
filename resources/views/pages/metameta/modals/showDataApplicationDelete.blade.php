<div class="modal" id="modalShowDataApplicationDelete">
    <div class="modal-dialog">
        <div class="modal-content modal-max-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('app.delete_data_application')</h4>
                <button type="button" class="close" data-dismiss="modal" id="close-edit-data_application">&times;
                </button>
            </div>
            <form class="delete_modal">
                <div class="modal-body">
                    @lang('app.delete_confirm')
                </div>
                <div class="modal-footer">
                    <input class="delete-input-data_application" hidden="hidden">
                    <button type="button" class="btn btn-secondary" id="cancel-delete"
                            data-dismiss="modal">@lang('app.cancel')</button>
                    <button class="btn btn-danger" data-dismiss="modal"
                            id="confirm-delete-data_application">@lang('app.delete')</button>
                </div>
            </form>
        </div>
    </div>
</div>