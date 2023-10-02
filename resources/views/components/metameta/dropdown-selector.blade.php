@php
	foreach ($elements as $metametaElement) {
		if($metametaElement['column_name'] === $title) {
			$elementId = $metametaElement['value'];
			break;
		}
	}
@endphp
<div id="meta-element{{$elementId}}">
	<div class="form-group form-bottom d-flex meta-element" data-field="metameta.{{ $title }}">
		<input class="metameta-elements-id d-none" value="{{$elementId}}">
		<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.'.$title)
			<x-metameta.comment.icon-show-modal title="@lang('app.comments')" :hasComment="$hasComment"/>
		</label>
		<x-metameta.form-group.selector :name="'metameta['.$title.']'" :disabled="$disabled"
		                             :options="$options" :selected="old('metameta.'.$title,$optionSelected)" />
		@if(!$disabled && $hasMemo)
			<a class="dropdown-toggle no-arrow text-add-comment form-icon application_progress_memo"
			   title="Memos">
				<span class="hover_icon micon bi bi-book-fill"></span>
			</a>
		@endif
	</div>
	<div class="form-group form-bottom d-flex">
		<label class="form-elements d-flex align-items-center mb-0"></label>
		<div class="memo-list">
			@if(!empty($memos['memos']))
				@foreach($memos['memos'] as $memoElement)
					<x-metameta.memo-element :memo="$memoElement" :disabled="$disabled"/>
				@endforeach
			@endif
		</div>
	</div>
</div>