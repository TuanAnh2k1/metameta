<div class="modal overflow-hidden" id="modalShowComment">
    <div class="modal-dialog">
        <div class="modal-content form-group modal-max-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('app.add_comment')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="add_comment modal-add-form" data-action="{{route('metameta.add_comment',['metametaId'=>$metameta->id])}}" method="post"
                      id="add-comment-form">
                    @csrf
                    <div class="form-group d-flex align-items-center add-comment mt-2">
                        <div><x-metameta.comment.date-picker /></div>
                        <textarea class="form-control form-elements-comment __js-show-add form-item text-edit-comment"
                                  name="comment" id="add-comment-text"></textarea>
                        <input class="form-control metameta-elements" name="metameta_element_id" hidden="hidden">
                        <div class="submit-btn">
                            <button type="submit" class="font-20"><span class="button-add-list">+</span></button>
                        </div>
                    </div>
                    <div class="status-errors-add-comment_date d-flex"></div>
                </form>
                <div class="list-comment-item"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancel-delete"
                        data-dismiss="modal">@lang('app.cancel')
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalShowCommentDelete">
    <div class="modal-dialog">
        <div class="modal-content modal-max-content-confirm">
            <div class="modal-header">
                <h4 class="modal-title">@lang('app.delete_comment')</h4>
                <button type="button" class="close" data-dismiss="modal" id="close-edit">&times;</button>
            </div>
            <form class="delete_modal">
                <div class="modal-body">
                    @lang('app.delete_confirm')
                </div>
                <div class="modal-footer">
                    <input class="delete-input-comment" hidden="hidden">
                    <button type="button" class="btn btn-secondary" id="cancel-delete" data-dismiss="modal">@lang('app.cancel')</button>
                    <button class="btn btn-danger" data-dismiss="modal" id="confirm-delete-comment">@lang('app.delete')</button>
                </div>
            </form>
        </div>
    </div>
</div>
