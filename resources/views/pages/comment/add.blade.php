@extends('layouts.index')
@section('title', 'Add comment')
@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<div class="title">
					<h4>@lang('app.add_comment')</h4>
				</div>
			</div>
		</div>
	</div>
	<form class="comment" action="{{route('comments.store')}}" method="post">
		@csrf
		<div class="form-group">
			<label>@lang('app.comment')</label>
			<span class="text-require-red">*</span>
			<textarea class="form-control" name="comment">{{old('comment')}}</textarea>
			@error('comment')
			<span class="text-danger">{{ $message }}</span>
			@enderror
		</div>
		<div class="form-group">
			<label>@lang('metameta.id')</label>
			<span class="text-require-red">*</span>
			<input class="form-control" name="metadata_no" value="{{old('metadata_no')}}">
			@error('metadata_no')
			<span class="text-danger">{{ $message }}</span>
			@enderror
		</div>
		<div class="form-group">
			<label for="metameta_element_id">@lang('metameta.metameta_element_id')</label>
			<span class="text-require-red">*</span>
			<select class="form-control" name="metameta_element_id" id="metameta_element_id">
				<option value=0 selected></option>
				@foreach($metadata_elements as $metadataElementItem)
					<option value={{$metadataElementItem->id}}
					@if(old('metameta_element_id') == $metadataElementItem->id) selected @endif>{{$metadataElementItem->name}}</option>
				@endforeach
			</select>
			@error('metameta_element_id')
			<span class="text-danger">{{ $message }}</span>
			@enderror
		</div>
		<div class="text-right">
			<a class="btn btn-secondary" href="{{route('comments.index')}}">@lang('app.cancel')</a>
			<button type="submit" class="btn btn-primary">@lang('app.save')</button>
		</div>
	</form>
@endsection