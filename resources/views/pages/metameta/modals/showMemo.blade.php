<div class="modal overflow-hidden" id="modalShowMemo">
    <div class="modal-dialog">
        <div class="modal-content form-group modal-max-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('app.add_memo')</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form class="add_memo modal-add-form" data-action="{{route('memos.add',['metametaId'=>$metameta->id])}}" method="post"
                      id="add-memo-form">
                    @csrf
                    <div class="form-group d-flex align-items-center mt-2">
                        <div>
                            <input class="form-control form-elements-memo-date form-datepicker" type="text" autocomplete="off"
                                   name="memo_date"
                                   placeholder="yyyy-mm-dd" value="{{date('Y-m-d')}}"
                                   id="add-memo-date">
                        </div>
                        <textarea class="form-control form-elements-memo __js-show-add form-item text-edit-comment"
                                  name="memo"
                                  id="add-memo-text"></textarea>
                        <input class="form-control metameta-elements" name="metameta_element_id" hidden="hidden">
                        <div class="submit-btn">
                            <button type="submit" class="font-20"><span class="button-add-list">+</span></button>
                        </div>
                    </div>
                    <div class="status-errors-add-memo_date d-flex"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancel-delete"
                        data-dismiss="modal">@lang('app.cancel')
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="modalShowMemoDelete">
    <div class="modal-dialog">
        <div class="modal-content modal-max-content-confirm">
            <div class="modal-header">
                <h4 class="modal-title">@lang('app.delete_memo')</h4>
                <button type="button" class="close" data-dismiss="modal" id="close-edit">&times;</button>
            </div>
            <form class="delete_modal">
                <div class="modal-body">
                    @lang('app.delete_confirm')
                </div>
                <div class="modal-footer">
                    <input class="delete-input-memo" hidden="hidden">
                    <button type="button" class="btn btn-secondary" id="cancel-delete" data-dismiss="modal">@lang('app.cancel')</button>
                    <button class="btn btn-danger" data-dismiss="modal" id="confirm-delete-memo">@lang('app.delete')</button>
                </div>
            </form>
        </div>
    </div>
</div>