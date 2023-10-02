<div class="form-group comment-item comment{{$comment['id']}}">
    <div class="d-flex align-items-center">
        <x-metameta.comment.date-picker :date="$comment['comment_date']" :disabled="true" />
        <x-metameta.comment.textarea :comment="$comment['comment']" :disabled="true" />
        <input class="form-control comment-id d-none" value="{{$comment['id']}}">
        <x-metameta.comment.author :author="$comment['created_by_user']"/>
        <div class="item-icon d-flex">
            @if($comment['can_edit'])
                <a class="align-items-center cursor-pointer edit-comment d-flex">
                    <i class="bi bi-pencil ml-2 text-warning btn-edit"></i>
                </a>
                <a class="align-items-center cursor-pointer update-comment d-none">
                    <i class="bi bi-check-lg ml-2 text-blue btn-check"></i>
                </a>
                <a class="align-items-center d-flex cursor-pointer delete-comment">
                    <i class="bi-x-lg ml-2 mr-2 text-danger btn-delete"></i>
                </a>
            @endif
        </div>
    </div>
    <div class="errors text-danger"></div>
</div>