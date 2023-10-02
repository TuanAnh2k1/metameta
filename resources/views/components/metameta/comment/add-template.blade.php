<div class="form-group comment-item template d-none">
    <div class="d-flex align-flex-start">
        <x-metameta.comment.date-picker />
        <x-metameta.comment.selector name="metadata_element_selected" :options="$options" />
        <x-metameta.comment.textarea />
        <input class="form-control comment-id d-none">
        <div class="d-flex align-items-center comment-submit form-submit">
            <i class="bi bi-check action-btn accept-btn mx-1"></i>
            <i class="bi bi-x action-btn cancel-btn mx-1"></i>
        </div>
    </div>
    <div class="errors d-flex text-danger"></div>
</div>