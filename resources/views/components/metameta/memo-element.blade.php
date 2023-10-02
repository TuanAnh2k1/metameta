<div class="form-group memo-item" id="memo{{$memo['id']}}">
	<div class="d-flex align-items-center">
		<div>
			<input class="form-control form-elements-memo-date form-datepicker" placeholder="yyyy-dd-mm" autocomplete="off"
			       type="text" name="memo_date" disabled value="{{$memo['memo_date']}}">
		</div>
		<div class="__js-show">
            <textarea class="form-control form-elements-memo __js-item form-item text-edit-comment"
                      name="memo" disabled>{{$memo['memo']}}</textarea>
		</div>
		<input class="form-control form-elements-memo-id d-none" value="{{$memo['id']}}">
		<p class="memo-author-list align-items-center d-flex ml-2">{{$memo['created_by_user']}}</p>
		@if(!$disabled)
			<div class="item-icon d-flex">
				<a class="align-items-center cursor-pointer edit_memo d-flex">
					<i class="bi bi-pencil ml-2 text-warning btn-edit"></i>
				</a>
				<a class="align-items-center cursor-pointer update_memo d-none">
					<i class="bi bi-check-lg ml-2 text-blue btn-check"></i>
				</a>
				<a class="align-items-center d-flex cursor-pointer delete-memo">
					<i class="bi-x-lg ml-2 mr-2 text-danger btn-delete"></i>
				</a>
			</div>
		@endif
	</div>
	<div class="errors d-flex text-danger"></div>
</div>