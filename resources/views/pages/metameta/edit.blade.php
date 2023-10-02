@extends('layouts.index')
@section('title', 'Edit comment')
@php
    use \App\Core\Helper\DateHelper;
	use App\Core\Common\CoreConst;
	use Illuminate\Support\Facades\Auth;
	use App\Models\Attachment;
@endphp
@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<div class="title">
					<h4>@lang('metameta.edit_metameta')</h4>
				</div>
			</div>
		</div>
	</div>
	<form class="comment" action="{{route('metameta.update', $metameta->id)}}" method="post">
		@csrf
		{{ method_field('PUT') }}
		<x-metameta.form-group.text :elements="$metadata_elements" :title="'id'" :hasComment="$has_comment['id']"
		                            :value="$metameta->id" :disabled="$disabled" :inputDisabled="true"/>
		<x-metameta.form-group.text :elements="$metadata_elements" :title="'dataset_name_ja'" :hasComment="$has_comment['dataset_name_ja']"
		                            :value="$metameta->dataset_name_ja" :disabled="$disabled"/>
		<x-metameta.form-group.text :elements="$metadata_elements" :title="'dataset_name_en'" :hasComment="$has_comment['dataset_name_en']"
		                            :value="$metameta->dataset_name_en" :disabled="$disabled"/>
		<x-metameta.form-group.text :elements="$metadata_elements" :title="'dataset_id'" :hasComment="$has_comment['dataset_id']"
		                            :value="$metameta->dataset_id" :disabled="$disabled"/>
		<x-metameta.form-group.text :elements="$metadata_elements" :title="'dataset_number'" :hasComment="$has_comment['dataset_number']"
		                            :value="$metameta->dataset_number" :disabled="$disabled"/>
		<x-metameta.dropdown-selector :elements="$metadata_elements" :title="'severity'" :options="CoreConst::METAMETA_VALUE['severity']"
		                              :option-selected="$metameta->severity" :disabled="$disabled" :hasComment="$has_comment['severity']"/>
		<x-metameta.form-group.text-area :elements="$metadata_elements" :title="'remarks'" :hasComment="$has_comment['remarks']"
		                                :value="$metameta->remarks" :disabled="$disabled"/>
		<x-metameta.form-group.text :elements="$metadata_elements" :title="'manager'" :hasComment="$has_comment['manager']"
		                            :value="$metameta->manager" :disabled="$disabled"/>
		<x-metameta.form-group.text :elements="$metadata_elements" :title="'reception_id'" :hasComment="$has_comment['reception_id']"
		                            :value="$metameta->reception_id" :disabled="$disabled"/>
		@foreach(App\Models\Metameta::METAMETA_ELEMENTS as $element)
			<x-metameta.dropdown-selector :elements="$metadata_elements" :title="$element" :options="CoreConst::METAMETA_VALUE[$element]"
			                              :option-selected="$metameta->$element" :disabled="$disabled" :hasMemo="true"
			                              :memos="$list_memo[$element]" :hasComment="$has_comment[$element]"/>
		@endforeach
		<fieldset class="fieldset-content">
			<legend class="d-flex align-items-center w-auto font-20">@lang('metameta.contacts_information')
				@if(!$disabled)
					<div class="btn button-add-list create-new-information">+</div>
				@endif
			</legend>
			<div class="d-none add-info-form template" data-contact-id="">
				<div class="form-group form-bottom form-contact">
					<div class="form-group d-flex">
						<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.contacts_name')</label>
						<input class="form-control contact-name" id="add-contact-name" @if($disabled) disabled @endif>
					</div>
					<div class="form-group form-bottom d-flex">
						<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.contacts_email')
							<span class="text-require-red">*</span>
						</label>
						<input type="email" class="form-control contact-email" id="add-contact-email"
						       @if($disabled) disabled @endif>
					</div>
					<div class="status-errors-add-contact d-flex">
						<label class="form-elements d-flex align-items-center mb-0"></label>
						<span class="text-danger"></span>
					</div>
				</div>
				@if(!$disabled)
					<div class="d-flex align-items-center contact-submit form-submit">
						<i class="bi bi-check action-btn accept-btn mx-1"></i>
						<i class="bi bi-x action-btn cancel-btn mx-1"></i>
					</div>
				@endif
			</div>
			<div class="add-new-info"></div>
			<div class="metameta-infomation-content" id="contact-content">
				@foreach($contacts as $contact)
					<div class="d-flex">
						<div class="form-group form-bottom form-contact list-contact">
							<div class="form-group form-bottom d-flex">
								<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.contacts_name')</label>
								<input class="form-control contact-name" value='{{$contact->name}}' disabled>
							</div>
							<div class="form-group form-bottom d-flex">
								<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.contacts_email')
									<span class="text-require-red">*</span>
								</label>
								<input type="email" class="form-control contact-email" name="email"
								       value='{{$contact->email}}' disabled>
								<div class="status-error-contact">
								</div>
								<input class="form-control contact-id" value="{{$contact->id}}" hidden="hidden">
							</div>
							<div class="status-errors-edit-list-contact d-flex">
								<label class="form-elements d-flex align-items-center mb-0"></label>
							</div>
						</div>
						@if(!$disabled)
							<div class="d-flex align-items-center contact-list">
								<a class="align-items-center cursor-pointer edit_contact d-flex">
									<i class="bi bi-pencil ml-2 text-warning btn-edit"></i>
								</a>
								<a class="align-items-center cursor-pointer update_contact d-none">
									<i class="bi bi-check-lg ml-2 text-blue btn-check"></i>
								</a>
								<a class="align-items-center d-flex cursor-pointer delete-contact">
									<i class="bi-x-lg ml-2 mr-2 text-danger btn-delete"></i>
								</a>
							</div>
						@endif
					</div>
				@endforeach
				<div class="template-add contact-item add-contact d-none">
					<meta class="form-group form-bottom " name="csrf-token" content="{{ csrf_token() }}">
					<div class="form-group form-bottom form-contact">
						<div class="form-group form-bottom d-flex">
							<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.contacts_name')</label>
							<input class="form-control form-elements-add-contact-name" disabled>
						</div>
						<div class="form-group form-bottom d-flex">
							<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.contacts_email')
								<span class="text-require-red">*</span>
							</label>
							<input type="email" class="form-control form-elements-add-contact-email" disabled>
							<input class="form-control form-elements-add-contact-id" hidden="hidden">
						</div>
						<div class="status-errors-edit-add-contact d-flex">
							<label class="form-elements d-flex align-items-center mb-0"></label>
						</div>
					</div>
					<div class="d-flex align-items-center contact-list">
						<a class="comment-author align-items-center d-flex ml-2"></a>
						<a class="align-items-center d-flex cursor-pointer edit_add_contact d-flex">
							<i class="bi bi-pencil ml-2 text-warning btn-edit"></i>
						</a>
						<a class="align-items-center cursor-pointer update_add_contact d-none">
							<i class="bi bi-check-lg ml-2 text-blue btn-check"></i>
						</a>
						<a class="align-items-center d-flex cursor-pointer delete-add-contact">
							<i class="bi-x-lg ml-2 mr-2 text-danger btn-delete"></i>
						</a>
					</div>
				</div>
			</div>
		</fieldset>
		<fieldset class="fieldset-content">
			<legend class="d-flex align-items-center w-auto font-20">@lang('metameta.authors_information')
				@if(!$disabled)
					<div class="btn button-add-list create-new-information">+</div>
				@endif
			</legend>
			<meta class="form-group form-bottom " name="csrf-token" content="{{ csrf_token() }}">
			<div class="d-none add-info-form template" data-author-id="">
				<div class="form-group form-bottom form-author">
					<div class="form-group form-bottom d-flex">
						<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.authors_name')</label>
						<input class="form-control author-name" id="add-author-name" @if($disabled) disabled @endif>
					</div>
					<div class="form-group form-bottom d-flex">
						<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.authors_email')
							<span class="text-require-red">*</span>
						</label>
						<input type="email" class="form-control author-email" id="add-author-email"
						       @if($disabled) disabled @endif>
					</div>
					<div class="status-errors-add-author d-flex">
						<label class="form-elements d-flex align-items-center mb-0"></label>
						<span class="text-danger"></span>
					</div>
				</div>
				@if(!$disabled)
					<div class="align-items-center d-flex author-submit form-submit">
						<i class="bi bi-check action-btn accept-btn mx-1"></i>
						<i class="bi bi-x action-btn cancel-btn mx-1"></i>
					</div>
				@endif
			</div>
			<div class="add-new-info"></div>
			<div class="metameta-infomation-content" id="author-content">
				<div class="template-add author-item add-author d-none">
					<div class="form-group form-bottom form-author">
						<div class="form-group form-bottom d-flex">
							<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.authors_name')</label>
							<input class="form-control form-elements-add-author-name" disabled>
						</div>
						<div class="form-group form-bottom d-flex">
							<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.authors_email')
								<span class="text-require-red">*</span>
							</label>
							<input type="email" class="form-control form-elements-add-author-email" disabled>
							<input class="form-control form-elements-add-author-id" hidden="hidden">
						</div>
						<div class="status-errors-edit-add-author d-flex">
							<label class="form-elements d-flex align-items-center mb-0"></label>
						</div>
					</div>
					<div class="d-flex align-items-center contact-list">
						<a class="align-items-center d-flex cursor-pointer edit_add_author d-flex">
							<i class="bi bi-pencil ml-2 text-warning btn-edit"></i>
						</a>
						<a class="align-items-center cursor-pointer update_add_author d-none">
							<i class="bi bi-check-lg ml-2 text-blue btn-check"></i>
						</a>
						<a class="align-items-center d-flex cursor-pointer delete-add-author">
							<i class="bi-x-lg ml-2 mr-2 text-danger btn-delete"></i>
						</a>
					</div>
				</div>
				@foreach($authors as $author)
					<div class="d-flex">
						<div class="form-group form-bottom form-author list-contact">
							<div class="form-group form-bottom d-flex">
								<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.authors_name')</label>
								<input class="form-control author-name" value='{{$author->name}}' disabled>
							</div>
							<div class="form-group form-bottom d-flex">
								<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.authors_email')
									<span class="text-require-red">*</span>
								</label>
								<input type="email" class="form-control author-email"
								       value='{{$author->email}}' disabled>
								<input class="form-control author-id" value="{{$author->id}}" hidden="hidden">
							</div>
							<div class="status-errors-edit-list-author d-flex">
								<label class="form-elements d-flex align-items-center mb-0"></label>
							</div>
						</div>
						@if(!$disabled)
							<div class="d-flex align-items-center author-list">
								<a class="align-items-center cursor-pointer edit_author d-flex">
									<i class="bi bi-pencil ml-2 text-warning btn-edit"></i>
								</a>
								<a class="align-items-center cursor-pointer update_author d-none">
									<i class="bi bi-check-lg ml-2 text-blue btn-check"></i>
								</a>
								<a class="align-items-center d-flex cursor-pointer delete-author">
									<i class="bi-x-lg ml-2 mr-2 text-danger btn-delete"></i>
								</a>
							</div>
						@endif
					</div>
				@endforeach
			</div>
		</fieldset>
		<x-metameta.form-group.text :elements="$metadata_elements" :title="'doi'" :hasComment="$has_comment['doi']"
		                            :value="$metameta->doi" :disabled="$disabled"/>
		<x-metameta.dropdown-selector :elements="$metadata_elements" :title="'category'" :options="CoreConst::METAMETA_VALUE['category']"
		                              :option-selected="$metameta->category" :disabled="$disabled" :hasComment="$has_comment[$element]"/>
		<x-metameta.dropdown-selector :elements="$metadata_elements" :title="'release_method'" :options="CoreConst::METAMETA_VALUE['release_method']"
		                              :option-selected="$metameta->release_method" :disabled="$disabled" :hasComment="$has_comment[$element]"/>
		<x-metameta.dropdown-selector :elements="$metadata_elements" :title="'access_permission'" :options="CoreConst::METAMETA_VALUE['access_permission']"
		                              :option-selected="$metameta->access_permission" :disabled="$disabled" :hasComment="$has_comment[$element]"/>
		<x-metameta.form-group.text :elements="$metadata_elements" :title="'data_directory'" :hasComment="$has_comment['data_directory']"
		                            :value="$metameta->data_directory" :disabled="$disabled"/>
		<fieldset class="fieldset-content">
			<legend class="d-flex align-items-center w-auto font-20">@lang('metameta.data_application_information')
				@if(!$disabled)
					<div class="btn button-add-list create-new-information">+</div>
				@endif
			</legend>
			<meta class="form-group form-bottom " name="csrf-token" content="{{ csrf_token() }}">
			<div class="d-none add-info-form template" data-data_application-id="">
				<div class="form-group form-bottom form-data_application">
					<div class="form-group form-bottom d-flex">
						<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.data_applications_name_ja')</label>
						<input class="form-control data_application-name_ja" id="add-data_application-name_ja"
						       @if($disabled) disabled @endif>
					</div>
					<div class="form-group form-bottom d-flex">
						<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.data_applications_name_en')
						</label>
						<input class="form-control data_application-name_en" id="add-data_application-name_en"
						       @if($disabled) disabled @endif>
						<input class="form-control data_application-metadata_no" value="{{$metameta->id}}"
						       hidden="hidden">
					</div>
					<div class="form-group form-bottom d-flex">
						<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.data_applications_url')</label>
						<input type="url" class="form-control metadata-add-link data_application-name_url"
						       placeholder="https://domain.com" id="add-data_application-name_url"
						       @if($disabled) disabled @endif>
						<a target="_blank"
						   class="pd-10 align-items-center d-flex cursor-pointer hover_icon __js-metadata-open-link">
							<i class="icon-copy bi bi-folder-symlink-fill"></i>
						</a>
					</div>
					<div class="status-errors-add-data_application d-flex">
						<label class="form-elements d-flex align-items-center mb-0"></label>
						<span class="text-danger"></span>
					</div>
				</div>
				@if(!$disabled)
					<div class="d-flex align-items-center data_application-submit form-submit">
						<i class="bi bi-check action-btn accept-btn mx-1"></i>
						<i class="bi bi-x action-btn cancel-btn mx-1"></i>
					</div>
				@endif
			</div>
			<div class="add-new-info"></div>
			<div class="metameta-infomation-content" id="data-application-content">
				<div class="template-add data_application-item add-data_application d-none">
					<div class="form-group form-bottom form-data_application">
						<div class="form-group form-bottom d-flex">
							<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.data_applications_name_ja')</label>
							<input class="form-control form-elements-add-data_application-name_ja" disabled>
						</div>
						<div class="form-group form-bottom d-flex">
							<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.data_applications_name_en')</label>
							<input class="form-control form-elements-add-data_application-name_en" disabled>
						</div>
						<div class="form-group form-bottom d-flex">
							<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.data_applications_url')
							</label>
							<input type="url"
							       class="form-control metadata-add-link form-elements-add-data_application-name_url edit-add-data_application-name_url"
							       id="edit-add-data_application-name_url" placeholder="https://domain.com" disabled>
							<a target="_blank"
							   class="pd-10 align-items-center d-flex cursor-pointer hover_icon __js-metadata-open-link">
								<i class="icon-copy bi bi-folder-symlink-fill"></i>
							</a>
							<input class="form-control form-elements-add-data_application-id" hidden="hidden">
						</div>
						<div class="status-errors-edit-add-data_application d-flex">
							<label class="form-elements d-flex align-items-center mb-0"></label>
						</div>
					</div>
					<div class="d-flex align-items-center contact-list">
						<a class="align-items-center d-flex cursor-pointer edit_add_data_application d-flex">
							<i class="bi bi-pencil ml-2 text-warning btn-edit"></i>
						</a>
						<a class="align-items-center cursor-pointer update_add_data_application d-none">
							<i class="bi bi-check-lg ml-2 text-blue btn-check"></i>
						</a>
						<a class="align-items-center d-flex cursor-pointer delete-add-data_application">
							<i class="bi-x-lg ml-2 mr-2 text-danger btn-delete"></i>
						</a>
					</div>
				</div>
				@foreach($data_applications as $data_application)
					<div class="d-flex">
						<div class="form-group form-bottom form-data_application list-contact">
							<div class="form-group form-bottom d-flex">
								<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.data_applications_name_ja')</label>
								<input class="form-control data_application-name_ja"
								       value='{{$data_application->name_ja}}' disabled>
							</div>
							<div class="form-group form-bottom d-flex">
								<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.data_applications_name_en')</label>
								<input class="form-control data_application-name_en"
								       value='{{$data_application->name_en}}' disabled>
							</div>
							<div class="form-group form-bottom d-flex">
								<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.data_applications_url')
								</label>
								<input type="url"
								       class="form-control metadata-add-link data_application-name_url edit-list-data_application-name_url"
								       id="edit-list-data_application-name_url" placeholder="https://domain.com"
								       value='{{$data_application->url}}' disabled>
								<a target="_blank"
								   class="pd-10 align-items-center d-flex cursor-pointer hover_icon __js-metadata-open-link">
									<i class="icon-copy bi bi-folder-symlink-fill"></i>
								</a>
								<input class="form-control data_application-id" value="{{$data_application->id}}"
								       hidden="hidden">
							</div>
							<div class="status-errors-edit-list-data_application d-flex">
								<label class="form-elements d-flex align-items-center mb-0"></label>
							</div>
						</div>
						@if(!$disabled)
							<div class="d-flex align-items-center data_application-list">
								<a class="align-items-center cursor-pointer edit_data_application d-flex">
									<i class="bi bi-pencil ml-2 text-warning btn-edit"></i>
								</a>
								<a class="align-items-center cursor-pointer update_data_application d-none">
									<i class="bi bi-check-lg ml-2 text-blue btn-check"></i>
								</a>
								<a class="align-items-center d-flex cursor-pointer delete-data_application">
									<i class="bi-x-lg ml-2 mr-2 text-danger btn-delete"></i>
								</a>
							</div>
						@endif
					</div>
				@endforeach
			</div>
		</fieldset>
		<x-metameta.form-group.text :elements="$metadata_elements" :title="'metadata_ja_url'" :hasComment="$has_comment['metadata_ja_url']"
		                            :value="$metameta->metadata_ja_url" :disabled="$disabled" :hasBlank="true"/>
		<x-metameta.form-group.text :elements="$metadata_elements" :title="'metadata_en_url'" :hasComment="$has_comment['metadata_en_url']"
		                            :value="$metameta->metadata_en_url" :disabled="$disabled" :hasBlank="true"/>
		<x-metameta.form-group.text :elements="$metadata_elements" :title="'search_url'" :hasComment="$has_comment['search_url']"
		                            :value="$metameta->search_url" :disabled="$disabled" :hasBlank="true"/>
		<div class="form-group form-bottom d-flex" id="attach-form">
			<label class="form-elements d-flex align-items-center mb-0">@lang('metameta.attach_form')</label>
			<div class="d-flex flex-column w-100">
				<div class="d-flex align-items-center">
					<input class="form-control w-50" name="attachments[note]" id="fileNote" placeholder="Memo"
					       @if($disabled) disabled @endif>
					<div class="input-file">
						<label for="attachFile">Choose file</label>
						<input type="file" class="form-control-file" id="attachFile" @if($disabled) disabled @endif>
					</div>
					<p id="uploading-msg" class="m-0 font-weight-bold"></p>
				</div>

			</div>
		</div>
		<div class="form-group form-bottom d-flex">
			<label class="form-elements d-flex align-items-center mb-0"></label>
			<table class="table" id="fileList">
				<tr class="row-template d-none w-100">
					<td class="form-elements-file-id d-none"></td>
					<td class="form-elements-file-url d-none"></td>
					<td class="attachment_created col-2"></td>
					<td class="attachment_note col-4 text-truncate"></td>
					<td class="attachment_author col-2"></td>
					<td class="attachment_icon col-2"><span><a></a></span></td>
					@if(!$disabled)
						<td class="attachment_action col-2"><a class="remove-file cursor-pointer"><i
										class="icon-copy bi bi-x"></i></a></td>
					@endif
				</tr>
			</table>
		</div>
		<div id="list-comment">
			<fieldset class="fieldset-content">
				<legend class="d-flex align-items-center w-auto font-20">
					@lang('app.comments')
					<div class="btn button-add-list create-new-comment">+</div>
				</legend>
				<div class="form-group form-bottom">
					<div class="add-new-comment">
						<x-metameta.comment.add-template />
					</div>
					<div id="comment-list">
						@foreach($list_comment as $comment)
							<x-metameta.comment.element :comment="$comment" :options="$metadata_elements" :disabled="true"/>
						@endforeach
					</div>
				</div>
			</fieldset>
		</div>

		<div class="text-right pb-20">
			<button type="submit" class="btn btn-primary @if($disabled) cursor-default @endif"
			        @if($disabled) disabled @endif>@lang('app.save')</button>
			<button type="button" class="btn btn-danger @if($disabled) cursor-default @endif" data-toggle="modal"
			        data-target="#deleteMetametaModal" @if($disabled) disabled @endif>{{trans('app.delete')}}</button>
			<a class="btn btn-secondary" href="{{route('metameta.index')}}">@lang('app.cancel')</a>

		</div>
	</form>
@endsection

@include('pages.metameta.modals.showMemo')

@include('pages.metameta.modals.showComment')

@include('pages.metameta.modals.showContactDelete')

@include('pages.metameta.modals.showAuthorDelete')

@include('pages.metameta.modals.showDataApplicationDelete')

<div class="modal" id="document-preview">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">File name</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<iframe src='' width='100%' height='100%' frameborder='0'></iframe>
			</div>
		</div>
	</div>
</div>

<div class="modal" id="deleteMetametaModal" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content confirm-delete-metameta">
			<div class="modal-header">
				<h5 class="modal-title">@lang('metameta.confirm_delete')</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="modal__message">
					<p>@lang('metameta.confirm_delete_text_1')</p>
					<p>@lang('metameta.confirm_delete_text_2')"<span
								style="font-weight: bold;">delete{{$metameta->id}}</span>"</p>
				</div>
				<input class="form-control .text-light" name="delete-confirm" id="delete-confirm">
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn form-control bg-danger text-white" id="deleteMetametaModal__confirm">
					@lang('metameta.confirm_delete_text_3')
				</button>
			</div>
		</div>
	</div>
</div>
@section('script')
	<script type="text/javascript">
			const metameta_no = @json($metameta->id);
			const now = @json(DateHelper::now('Y-m-d'));
			const formatDate = 'yy-mm-dd';
			const hasCommentClass = @json(CoreConst::HAS_COMMENT_CLASS);
			const allowFileTypes = @json(Attachment::MIMETYPE);
			$(document).ready(function () {
				function initDatePicker(element) {
					element.datepicker({
						dateFormat: 'yy-mm-dd',
					});
				}

				$(".form-datepicker").datepicker({dateFormat: formatDate});

				let files = @json($respondFiles);
				for (const fileItem of files) {
					appendFile(fileItem);
				}

				$(document).on('click', ".__js-metadata-open-link", function () {
					let url = $(this).parents('.meta-element').find('.metadata-add-link').val();
					if (url) {
						$(".__js-metadata-open-link").attr("href", url);
					}
				})

				$(document).on('click', '.__js-show', function () {
					let obj = $(this).children();
					if (obj.hasClass('form-item text-edit-comment')) {
						obj.removeClass("form-item text-edit-comment");
					} else {
						obj.addClass("form-item text-edit-comment");
					}
				})
				$(document).on('click', '.__js-show-add', function () {
					let obj = $(this);
					if (obj.hasClass('form-item text-edit-comment')) {
						obj.removeClass("form-item text-edit-comment");
					} else {
						obj.addClass("form-item text-edit-comment");
					}
				})

				//memo

				$('.application_progress_memo').on('click', function () {
					let metaElementParent = $(this).parents('.meta-element');
					let metaElementId = $(metaElementParent).find('.metameta-elements-id').val();
					let addMemoModal = $('#modalShowMemo');
					$(addMemoModal).find(".form-datepicker").datepicker({dateFormat: formatDate});
					$(addMemoModal).find('.form-elements-memo-date').val(now);
					$(addMemoModal).find('.metameta-elements').val(metaElementId);
					$(addMemoModal).find('.status-errors-add-memo_date').children().empty();
					$(addMemoModal).find('#add-memo-text').val('');
					$(addMemoModal).modal("show");
				});

				$('#add-memo-form').on('submit', function (event) {
					event.preventDefault();
					$('.memo-author').empty();
					$('.status-errors-add-memo_date').children().empty();
					$.ajax({
						url: $(this).attr('data-action'),
						method: 'POST',
						data: new FormData(this),
						processData: false,
						contentType: false,
						success: function (response) {
							toastr.options.timeOut = 2000;
							toastr.success(response.status_success);
							let metaElementParent = $('#meta-element' + response.metadata_element_id);
							let listMemo = $(metaElementParent).find('.memo-list');
							listMemo.append(response.memo);
							let addMemoModal = $('#modalShowMemo');
							$(addMemoModal).find('.status-errors-add-memo_date').children().empty();
							$(addMemoModal).find('#add-memo-text').val('');
							$(addMemoModal).modal('hide');
						},
						error: function (response) {
							if (response['responseJSON']) {
								$('.status-errors-add-memo_date').append(`<span class="text-danger">${response['responseJSON']['message']}</span>`)
								toastr.options.timeOut = 2000;
								toastr.error(response['responseJSON']['message']);
							}
						},
					});
				});

				$(document).on('click', '.edit_memo', function () {
					let thisParent = $(this).parents('.memo-item');
					$(thisParent).find('.update_memo').removeClass('d-none').addClass('d-flex')
					$(thisParent).find('.edit_memo').removeClass('d-flex').addClass('d-none')
					$(thisParent).find('.form-elements-memo-date').removeAttr("disabled")
					$(thisParent).find('.form-elements-memo').removeAttr("disabled")
				})
				$(document).on('click', '.update_memo', function () {
					let thisParent = $(this).parents('.memo-item');
					let id_memo = $(thisParent).find('.form-elements-memo-id').val();
					let memo_date = $(thisParent).find('.form-elements-memo-date').val();
					let memo = $(thisParent).find('.form-elements-memo').val();
					let url = `{{route('memos.edit', "id")}}`;
					$(thisParent).find('.errors').empty();
					$.ajax({
						url: url.replace("id", id_memo),
						method: 'POST',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: {
							"memo_date": memo_date,
							"memo": memo,
						},
						success: function (response) {
							toastr.options.timeOut = 2000;
							toastr.success(response.message);
							$(thisParent).find('.update_memo').removeClass('d-flex').addClass('d-none')
							$(thisParent).find('.edit_memo').removeClass('d-none').addClass('d-flex')
							$(thisParent).find('.form-elements-memo-date').attr("disabled", "disabled")
							$(thisParent).find('.form-elements-memo').attr("disabled", "disabled")
						},
						error: function (response) {
							$(thisParent).find('.errors').html(response['responseJSON']['message']);
						}
					});
				})
				$(document).on('click', '.delete-memo', function () {
					let thisParent = $(this).parents('.memo-item');
					let id_memo = $(thisParent).find('.form-elements-memo-id').val();
					$('.delete-input-memo').val(id_memo);
					let add_class = `js-parent${id_memo}`
					thisParent.addClass(add_class);
					$('#modalShowMemoDelete').modal("show")

				})
				$(document).on('click', '#confirm-delete-memo', function (event) {
					event.preventDefault();
					let modal = $(this).parents('#modalShowMemoDelete');
					let id_memo = $(modal).find('.delete-input-memo').val();
					let url = `{{route('memos.delete', "id")}}`;
					$.ajax({
						url: url.replace("id", id_memo),
						method: 'GET',
						success: function (response) {
							toastr.options.timeOut = 2000;
							toastr.success(response.message);
							$(`#memo${id_memo}`).remove();
						},
						error: function (response) {
							toastr.options.timeOut = 2000;
							toastr.success(response.response['responseJSON']['message']);
						}
					});
				})

				//comment

				$('.application_progress_comment').on('click', function (event) {
					let metaElementParent = $(this).parents('.meta-element');
					let metaElementId = $(metaElementParent).find('.metameta-elements-id').val();
					let metametaId = metameta_no;
					let commentModal = $('#modalShowComment');
					$(commentModal).find('.form-elements-comment-date').val(now);
					$(commentModal).find('.metameta-elements').val(metaElementId);
					$(commentModal).find('.status-errors-add-comment_date').children().empty();
					$(commentModal).find('#add-comment-text').val('');

					let url = "{{route('metameta.list_comment', [
    					'metametaId' => ':metametaId',
    					'elementId' => ':elementId',
						])}}";
					url = url.replace(":elementId", metaElementId);
					url = url.replace(":metametaId", metametaId);
					$.ajax({
						url: url,
						method: 'GET',
						success: function (response) {
							let listComment = $(commentModal).find('.list-comment-item');
							$(listComment).empty();
							$(listComment).append(response.comment);
							$(commentModal).modal("show");
							$(commentModal).find(".form-datepicker").datepicker({dateFormat: formatDate});
						},
					});
				});
				$('.create-new-comment').on('click', function () {
					let fieldset = $(this).parents('fieldset');
					let template = $(fieldset).find('.add-new-comment .template').clone();
					let datePicker = $(template).find(".form-datepicker");
					$(datePicker).removeAttr('id').removeClass('hasDatepicker').removeData('datepicker');
					$(datePicker).datepicker({dateFormat: formatDate});
					$(template).removeClass('d-none template');
					$(fieldset).find('.add-new-comment').append(template);
				})
				$('#add-comment-form').on('submit', function (event) {
					let parent = $(this).parents('#modalShowComment');
					event.preventDefault();
					let url = $(this).attr('data-action');
					$('.comment-author').empty();
					$('.status-errors-add-comment_date').children().empty();
					$.ajax({
						url: url,
						method: 'POST',
						data: new FormData(this),
						dataType: 'JSON',
						contentType: false,
						cache: false,
						processData: false,
						success: function (response) {
							if (response.status_success) {
								toastr.options.timeOut = 2000;
								toastr.success(response.status_success);
							}
							let modalList = $(parent).find('.list-comment-item');
							$(modalList).append(response.modal_element);
							let commentList = $('#comment-list');
							$(commentList).append(response.element);
							$(parent).find('#add-comment-text').val('');
							$(parent).find('.add-comment .form-elements-comment-date').val(now);
							addCommentClass(response.element_id);
						},
						error: function (response) {
							$('.status-errors-add-comment_date').append(`<span class="text-danger">${response['responseJSON']['message']}</span>`)
						}
					});
				});
				$(document).on('click', '.comment-submit .accept-btn', function () {
					let parent = $(this).parents('.comment-item');
					let comment_date = $(parent).find('.form-elements-comment-date').val();
					let metameta_element_id = $(parent).find('.metadata_element_selected').val();
					let comment = $(parent).find('.form-elements-comment').val();
					let data = {
						'comment_date': comment_date,
						'comment': comment,
					    'metameta_element_id': metameta_element_id,
					};
					let url = `{{route('metameta.add_comment', "metametaId")}}`;
					url = url.replace("metametaId", metameta_no);
					$.ajax({
						url: url,
						method: 'POST',
						data: data,
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						success: function (response) {
							if (response.status_success) {
								toastr.options.timeOut = 2000;
								toastr.success(response.status_success);
							}
							let commentList = $('#comment-list');
							$(commentList).append(response.element);
							$(parent).remove();
							addCommentClass(response.element_id);
						},
						error: function (response) {
							$(parent).find('.errors').html(`<span class="text-danger">${response['responseJSON']['message']}</span>`)
						}
					});
				})

				$(document).on('click', '.comment-submit .cancel-btn', function () {
					$(this).parents('.comment-item').remove();
				})

				$(document).on('click', '.edit-comment', function () {
					let parent = $(this).parents('.comment-item');
					$(parent).find('.update-comment').removeClass('d-none').addClass('d-flex');
					$(parent).find('.edit-comment').removeClass('d-flex').addClass('d-none');
					$(parent).find('.form-elements-comment-date').removeAttr("disabled");
					$(parent).find('.form-elements-comment').removeAttr("disabled");
					$(parent).find('.metadata_element_selected').removeAttr("disabled");
					$(parent).find('.form-elements-comment').removeClass("h-auto");
				})
				$(document).on('click', '.update-comment', function () {
					let parent = $(this).parents('.comment-item');
					let id_comment = $(parent).find('.comment-id').val();
					let comment_date = $(parent).find('.form-elements-comment-date').val();
					let comment = $(parent).find('.form-elements-comment').val();
					let metameta_element_id = $(parent).find('.metadata_element_selected').val();
					let data = {
						'comment_date': comment_date,
					    'comment': comment,
					    'metameta_element_id': metameta_element_id,
					};
					let url = `{{route('metameta.edit_comment',[
                            'metametaId' => 'metametaId',
                            'id' => 'id',
					])}}`;
					url = url.replace('metametaId',metameta_no);
					url = url.replace('id',id_comment);
					$('.status-errors-edit-list-comment_date').children().empty();
					$('.errors_edit_comment').removeClass('errors_edit_comment');
					$(parent).find('.status-errors-edit-list-comment_date').addClass('errors_edit_comment');
					$.ajax({
						url: url,
						method: 'POST',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: data,
						success: function (response) {
							if (response.status_success) {
								toastr.options.timeOut = 2000;
								toastr.success(response.status_success);
							}
							$(parent).find('.update-comment').removeClass('d-flex').addClass('d-none');
							$(parent).find('.edit-comment').removeClass('d-none').addClass('d-flex');
							$(parent).find('.form-elements-comment-date').attr("disabled", "disabled");
							$(parent).find('.form-elements-comment').attr("disabled", "disabled");
							$(parent).find('.metadata_element_selected').attr("disabled", "disabled");
							$(parent).find('.form-elements-comment').addClass('h-auto');
							let commentElement = $(`#comment-list .comment${id_comment}`);
							$(commentElement).find('.form-elements-comment-date').val(comment_date);
							$(commentElement).find('.form-elements-comment').val(comment);
							$(parent).find('.errors').empty();
							addCommentClass(response.new_element_id);
							removeCommentClass(response.old_element_id, response.old_element_remain);
						},
						error: function (response) {
							$(parent).find('.errors').html(`<span class="text-danger">${response['responseJSON']['message']}</span>`);
						}
					});
				})
				$(document).on('click', '.delete-comment', function () {
					let parent = $(this).parents('.comment-item');
					let id_comment = $(parent).find('.comment-id').val();
					$('.delete-input-comment').val(id_comment);
					$('#modalShowCommentDelete').modal("show")
				})
				$(document).on('click', '#confirm-delete-comment', function (event) {
					event.preventDefault();
					let modal = $(this).parents('#modalShowCommentDelete');
					let id_comment = $(modal).find('.delete-input-comment').val();
					let url = `{{route('metameta.delete_comment',[
                        'metametaId' => 'metametaId',
                        'id' => 'id',
					])}}`;
					url = url.replace("id", id_comment);
					url = url.replace("metametaId", metameta_no);
					$.ajax({
						url: url,
						method: 'GET',
						success: function (response) {
							if (response.id_comment) {
								toastr.options.timeOut = 2000;
								toastr.success(response.status_success);
								$(`.comment${response.id_comment}`).remove();
								removeCommentClass(response.element_id, response.comment_remain);
							}
						},
						error: function (response) {
						}
					});
				})

				// contact
				$(document).on('click', '.contact-submit .accept-btn', function () {
					let thisParent = $(this).parents('.add-info-form');
					$('.contact-submit').prop("disabled", true);
					let contact_name = thisParent.find('.contact-name').val().trim();
					let contact_email = thisParent.find('.contact-email').val().trim();
					let url = `{{route('metameta.add_contact')}}`;
					$.ajax({
						url: url,
						method: 'POST',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: {
							"name": contact_name,
							"email": contact_email,
							"metadata_no": metameta_no,
						},
						success: function (response) {
							if (response.status_success) {
								toastr.options.timeOut = 2000;
								toastr.success(response.status_success);
								const template = $('.contact-item.template-add').clone();
								template.find('.form-elements-add-contact-name').val(contact_name);
								template.find('.form-elements-add-contact-email').val(contact_email);
								template.find('.form-elements-add-contact-id').val(response.contact_id);
								template.removeClass('add-contact d-none template-add').addClass('d-flex');
								$('#contact-content').append(template);
								$('.contact-submit').prop("disabled", false);
								$(thisParent).remove();
							}
						},
						error: function (response) {
							$(thisParent).find('.status-errors-add-contact span').html(response['responseJSON']['message'])
							$('.contact-submit').prop("disabled", false);
						}
					});
				});
				$(document).on('click', '.edit_contact', function () {
					let thisParentDisplay = $(this).parent();
					thisParentDisplay.find('.update_contact').removeClass('update_contact d-none').addClass('update_contact d-flex')
					thisParentDisplay.find('.edit_contact').removeClass('edit_contact d-flex').addClass('edit_contact d-none')
					let thisParentContent = $(this).parent().parent();
					thisParentContent.find('.contact-name').removeAttr("disabled")
					thisParentContent.find('.contact-email').removeAttr("disabled")
					thisParentContent.find('.contact-name').val().trim();
					thisParentContent.find('.contact-email').val().trim();
				})
				$(document).on('click', '.update_contact', function () {
					let thisParentDisplay = $(this).parent();
					thisParentDisplay.find('.update_contact').removeClass('update_contact d-flex').addClass('update_contact d-none')
					thisParentDisplay.find('.edit_contact').removeClass('edit_contact d-none').addClass('edit_contact d-flex')
					let thisParentContent = $(this).parent().parent();
					thisParentContent.find('.contact-name').attr("disabled", "disabled")
					thisParentContent.find('.contact-email').attr("disabled", "disabled")
					let id_contact = thisParentContent.find('.contact-id').val();
					let contact_name = thisParentContent.find('.contact-name').val().trim();
					let contact_email = thisParentContent.find('.contact-email').val().trim();
					let url_contact_id = `{{route('metameta.edit_contact')}}`;
					$('.status-errors-edit-list-contact').children().empty();
					thisParentContent.find('.status-errors-edit-list-contact').attr('id', `${id_contact}`);
					$.ajax({
						url: url_contact_id,
						method: 'POST',
						data: {
							"id": id_contact,
							"name": contact_name,
							"email": contact_email,
							"_token": "{{ csrf_token() }}",
						},
						success: function (response) {
							if (response.status_success) {
								toastr.options.timeOut = 2000;
								toastr.success(response.status_success);
							}
						},
						error: function (response) {
							$(`#${id_contact}`).append(`<span class="text-danger">${response['responseJSON']['message']}</span>`)
						}
					});
				})
				$(document).on('click', '.edit_add_contact', function () {
					let thisParentDisplay = $(this).parent();
					thisParentDisplay.find('.update_add_contact').removeClass('update_add_contact d-none').addClass('update_add_contact d-flex')
					thisParentDisplay.find('.edit_add_contact').removeClass('edit_add_contact d-flex').addClass('edit_add_contact d-none')
					let thisParentDisabled = $(this).parent().parent();
					thisParentDisabled.find('.form-elements-add-contact-name').removeAttr("disabled")
					thisParentDisabled.find('.form-elements-add-contact-email').removeAttr("disabled")
				})
				$(document).on('click', '.update_add_contact', function () {
					let thisParentDisplay = $(this).parent();
					thisParentDisplay.find('.update_add_contact').removeClass('update_add_contact d-flex').addClass('update_add_contact d-none')
					thisParentDisplay.find('.edit_add_contact').removeClass('edit_add_contact d-none').addClass('edit_add_contact d-flex')
					let thisParentContent = $(this).parent().parent();
					thisParentContent.find('.form-elements-add-contact-name').attr("disabled", "disabled")
					thisParentContent.find('.form-elements-add-contact-email').attr("disabled", "disabled")
					let id_contact = thisParentContent.find('.form-elements-add-contact-id').val();
					let contact_name = thisParentContent.find('.form-elements-add-contact-name').val().trim();
					let contact_email = thisParentContent.find('.form-elements-add-contact-email').val().trim();
					let url_contact_id = `{{route('metameta.edit_contact')}}`;
					$('.status-errors-edit-add-contact').children().empty();
					thisParentContent.find('.status-errors-edit-add-contact').attr('id', `${id_contact}`);
					$.ajax({
						url: url_contact_id,
						method: 'POST',
						data: {
							"id": id_contact,
							"name": contact_name,
							"email": contact_email,
							"_token": "{{ csrf_token() }}",
						},
						success: function (response) {
							if (response.status_success) {
								toastr.options.timeOut = 2000;
								toastr.success(response.status_success);
							}
						},
						error: function (response) {
							$(`#${id_contact}`).append(`<span class="text-danger">${response['responseJSON']['message']}</span>`)
						}
					});
				})
				$(document).on('click', '.delete-contact', function () {
					let thisParent = $(this).parent().parent();
					let id_contact = thisParent.find('.contact-id').val();
					$('.delete-input-contact').val(id_contact);
					let add_class = `js-parent${id_contact}`
					thisParent.addClass(add_class);
					$('#modalShowContactDelete').modal("show")
				})
				$(document).on('click', '#confirm-delete-contact', function (event) {
					event.preventDefault();
					let id_contact = $(this).parent().parent().find('.delete-input-contact').val();
					let url_contact_id = `{{route('metameta.destroy_contact')}}`;
					$.ajax({
						url: url_contact_id,
						method: 'GET',
						data: {
							"id": id_contact,
						},
						success: function (response) {
							if (response.id) {
								if ($(`.js-parent${response.id}`)) {
									$(`.js-parent${response.id}`).remove();
								}
								if (response.status_success) {
									toastr.options.timeOut = 2000;
									toastr.success(response.status_success);
								}
							}
						},
						error: function (response) {
							console.log(response)
						}
					});
				})
				$(document).on('click', '.delete-add-contact', function () {
					$('#modalShowContactDelete').modal("show")
					let thisParent = $(this).parent().parent();
					let id_contact = thisParent.find('.form-elements-add-contact-id').val();
					$('.delete-input-contact').val(id_contact);
					let add_class = `js-parent${id_contact}`;
					thisParent.addClass(add_class);
				})
				$('.create-new-information').on('click', function () {
					let fieldset = $(this).parents('fieldset');
					let addFormTemplate = $(fieldset).find('.add-info-form.template');
					let addForm = $(addFormTemplate).clone();
					$(addForm).removeClass('d-none template').addClass('d-flex');
					$(fieldset).find('.add-new-info').append(addForm)
				})

				$(document).on('click', '.add-info-form .cancel-btn', function () {
					$(this).parents('.add-info-form').remove();
				})
				// author
				$(document).on('click', '.author-submit .accept-btn', function () {
					let thisParent = $(this).parents('.add-info-form');
					$('.author-submit').prop("disabled", true);
					let author_name = thisParent.find('.author-name').val();
					let author_email = thisParent.find('.author-email').val();
					let url = `{{route('metameta.add_author')}}`;
					$('.status-errors-add-author').children().empty();
					$.ajax({
						url: url,
						method: 'POST',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: {
							"name": author_name,
							"email": author_email,
							"metadata_no": metameta_no,
						},
						success: function (response) {
							if (response.status_success) {
								toastr.options.timeOut = 2000;
								toastr.success(response.status_success);
							}
							const template = $('.author-item.template-add').clone();
							template.find('.form-elements-add-author-name').val(author_name);
							template.find('.form-elements-add-author-email').val(author_email);
							template.find('.form-elements-add-author-id').val(response.author_id);
							template.removeClass('add-author d-none template-add').addClass('d-flex');
							$('#author-content').append(template);
							$(thisParent).remove();
							$('.author-submit').prop("disabled", false);
						},
						error: function (response) {
							$(thisParent).find('.status-errors-add-author span').html(response['responseJSON']['message'])
							$('.author-submit').prop("disabled", false);
						}
					});
				});
				$(document).on('click', '.edit_author', function () {
					let thisParentDisplay = $(this).parent();
					thisParentDisplay.find('.update_author').removeClass('update_author d-none').addClass('update_author d-flex')
					thisParentDisplay.find('.edit_author').removeClass('edit_author d-flex').addClass('edit_author d-none')
					let thisParentDisabled = $(this).parent().parent();
					thisParentDisabled.find('.author-name').removeAttr("disabled")
					thisParentDisabled.find('.author-email').removeAttr("disabled")
				})
				$(document).on('click', '.update_author', function () {
					let thisParentDisplay = $(this).parent();
					thisParentDisplay.find('.update_author').removeClass('update_author d-flex').addClass('update_author d-none')
					thisParentDisplay.find('.edit_author').removeClass('edit_author d-none').addClass('edit_author d-flex')
					let thisParentDisabled = $(this).parent().parent();
					thisParentDisabled.find('.author-name').attr("disabled", "disabled")
					thisParentDisabled.find('.author-email').attr("disabled", "disabled")
					let id_author = thisParentDisabled.find('.author-id').val();
					let author_name = thisParentDisabled.find('.author-name').val();
					let author_email = thisParentDisabled.find('.author-email').val();
					let url_author_id = `{{route('metameta.edit_author')}}`;
					$('.status-errors-edit-list-author').children().empty();
					thisParentDisabled.find('.status-errors-edit-list-author').attr('id', `${id_author}`);
					$.ajax({
						url: url_author_id,
						method: 'POST',
						data: {
							"id": id_author,
							"name": author_name,
							"email": author_email,
							"_token": "{{ csrf_token() }}",
						},
						success: function (response) {
							if (response.status_success) {
								toastr.options.timeOut = 2000;
								toastr.success(response.status_success);
							}
						},
						error: function (response) {
							$(`#${id_author}`).append(`<span class="text-danger">${response['responseJSON']['message']}</span>`)
						}
					});
				})
				$(document).on('click', '.edit_add_author', function () {
					let thisParentDisplay = $(this).parent();
					thisParentDisplay.find('.update_add_author').removeClass('update_add_author d-none').addClass('update_add_author d-flex')
					thisParentDisplay.find('.edit_add_author').removeClass('edit_add_author d-flex').addClass('edit_add_author d-none')
					let thisParentDisabled = $(this).parent().parent();
					thisParentDisabled.find('.form-elements-add-author-name').removeAttr("disabled")
					thisParentDisabled.find('.form-elements-add-author-email').removeAttr("disabled")
				})
				$(document).on('click', '.update_add_author', function () {
					let thisParentDisplay = $(this).parent();
					thisParentDisplay.find('.update_add_author').removeClass('update_add_author d-flex').addClass('update_add_author d-none')
					thisParentDisplay.find('.edit_add_author').removeClass('edit_add_author d-none').addClass('edit_add_author d-flex')
					let thisParentDisabled = $(this).parent().parent();
					thisParentDisabled.find('.form-elements-add-author-name').attr("disabled", "disabled")
					thisParentDisabled.find('.form-elements-add-author-email').attr("disabled", "disabled")
					let id_author = thisParentDisabled.find('.form-elements-add-author-id').val();
					let author_name = thisParentDisabled.find('.form-elements-add-author-name').val();
					let author_email = thisParentDisabled.find('.form-elements-add-author-email').val();
					let url_author_id = `{{route('metameta.edit_author')}}`;
					$('.status-errors-edit-add-author').children().empty();
					thisParentDisabled.find('.status-errors-edit-add-author').attr('id', `${id_author}`);
					$.ajax({
						url: url_author_id,
						method: 'POST',
						data: {
							"id": id_author,
							"name": author_name,
							"email": author_email,
							"_token": "{{ csrf_token() }}",
						},
						success: function (response) {
							if (response.status_success) {
								toastr.options.timeOut = 2000;
								toastr.success(response.status_success);
							}
						},
						error: function (response) {
							$(`#${id_author}`).append(`<span class="text-danger">${response['responseJSON']['message']}</span>`)
						}
					});
				})
				$(document).on('click', '.delete-author', function () {
					let thisParent = $(this).parent().parent();
					let id_author = thisParent.find('.author-id').val();
					$('.delete-input-author').val(id_author);
					let add_class = `js-parent${id_author}`
					thisParent.addClass(add_class);
					$('#modalShowAuthorDelete').modal("show")
				})
				$(document).on('click', '#confirm-delete-author', function (event) {
					event.preventDefault();
					let id_author = $(this).parent().parent().find('.delete-input-author').val();
					let url_author_id = `{{route('metameta.destroy_author')}}`;
					$.ajax({
						url: url_author_id,
						method: 'GET',
						data: {
							"id": id_author,
						},
						success: function (response) {
							if (response.id) {
								if ($(`.js-parent${response.id}`)) {
									$(`.js-parent${response.id}`).remove();
								}
								if (response.status_success) {
									toastr.options.timeOut = 2000;
									toastr.success(response.status_success);
								}
							}
						},
						error: function (response) {
							console.log(response)
						}
					});
				})
				$(document).on('click', '.delete-add-author', function () {
					$('#modalShowAuthorDelete').modal("show")
					let thisParent = $(this).parent().parent();
					let id_author = thisParent.find('.form-elements-add-author-id').val();
					$('.delete-input-author').val(id_author);
					let add_class = `js-parent${id_author}`;
					thisParent.addClass(add_class);
				})
				// data_application
				$(document).on('click', '.data_application-submit .accept-btn', function () {
					let thisParent = $(this).parents('.add-info-form');
					$('.data_application-submit').prop("disabled", true);
					let data_application_name_ja = thisParent.find('.data_application-name_ja').val();
					let data_application_name_en = thisParent.find('.data_application-name_en').val();
					let data_application_name_url = thisParent.find('.data_application-name_url').val();
					let url = `{{route('metameta.add_data_application')}}`;
					$.ajax({
						url: url,
						method: 'POST',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: {
							"name_ja": data_application_name_ja,
							"name_en": data_application_name_en,
							"url": data_application_name_url,
							"metadata_no": metameta_no,
						},
						success: function (response) {
							if (response.status_success) {
								toastr.options.timeOut = 2000;
								toastr.success(response.status_success);
								const template = $('.data_application-item.template-add').clone();
								template.find('.form-elements-add-data_application-name_ja').val(data_application_name_ja);
								template.find('.form-elements-add-data_application-name_en').val(data_application_name_en);
								template.find('.form-elements-add-data_application-name_url').val(data_application_name_url);
								template.find('.form-elements-add-data_application-id').val(response.data_application_id);
								template.removeClass('add-data_application d-none template-add').addClass('d-flex');
								$('#data-application-content').append(template);
								$('.data_application-submit').prop("disabled", false);
								$(thisParent).remove();
							}
						},
						error: function (response) {
							$(thisParent).find('.status-errors-add-data_application span').html(response['responseJSON']['message']);
							$('.data_application-submit').prop("disabled", false);
						}
					});
				});
				$(document).on('click', '.edit_data_application', function () {
					let thisParentDisplay = $(this).parent();
					thisParentDisplay.find('.update_data_application').removeClass('update_data_application d-none').addClass('update_data_application d-flex')
					thisParentDisplay.find('.edit_data_application').removeClass('edit_data_application d-flex').addClass('edit_data_application d-none')
					let thisParentDisabled = $(this).parent().parent();
					thisParentDisabled.find('.data_application-name_ja').removeAttr("disabled")
					thisParentDisabled.find('.data_application-name_en').removeAttr("disabled")
					thisParentDisabled.find('.data_application-name_url').removeAttr("disabled")
				})
				$(document).on('click', '.update_data_application', function () {
					let thisParentDisplay = $(this).parent();
					thisParentDisplay.find('.update_data_application').removeClass('update_data_application d-flex').addClass('update_data_application d-none')
					thisParentDisplay.find('.edit_data_application').removeClass('edit_data_application d-none').addClass('edit_data_application d-flex')
					let thisParentDisabled = $(this).parent().parent();
					thisParentDisabled.find('.data_application-name_ja').attr("disabled", "disabled")
					thisParentDisabled.find('.data_application-name_en').attr("disabled", "disabled")
					thisParentDisabled.find('.data_application-name_url').attr("disabled", "disabled")
					let id_data_application = thisParentDisabled.find('.data_application-id').val();
					let data_application_name_ja = thisParentDisabled.find('.data_application-name_ja').val();
					let data_application_name_en = thisParentDisabled.find('.data_application-name_en').val();
					let data_application_name_url = thisParentDisabled.find('.data_application-name_url').val();
					let url_data_application_id = `{{route('metameta.edit_data_application')}}`;
					$('.status-errors-edit-list-data_application').children().empty();
					$('.errors_edit_list_data_application').removeClass('errors_edit_list_data_application');
					thisParentDisabled.find('.status-errors-edit-list-data_application').addClass('errors_edit_list_data_application');
					$.ajax({
						url: url_data_application_id,
						method: 'POST',
						data: {
							"id": id_data_application,
							"name_ja": data_application_name_ja,
							"name_en": data_application_name_en,
							"url": data_application_name_url,
							"_token": "{{ csrf_token() }}",
						},
						success: function (response) {
							if (response.status_success) {
								// tao ra function init chung de su dung
								toastr.options.timeOut = 2000;
								toastr.success(response.status_success);
							}
							if (response.status_errors) $('.errors_edit_list_data_application').append(`<span class="text-danger">${response.status_errors}</span>`)
						},
						error: function (response) {
							toastr.options.timeOut = 2000;
							toastr.errors(response.status_errors);
						}
					});
				})
				$(document).on('click', '.edit_add_data_application', function () {
					let thisParentDisplay = $(this).parent();
					thisParentDisplay.find('.update_add_data_application').removeClass('update_add_data_application d-none').addClass('update_add_data_application d-flex')
					thisParentDisplay.find('.edit_add_data_application').removeClass('edit_add_data_application d-flex').addClass('edit_add_data_application d-none')
					let thisParentDisabled = $(this).parent().parent();
					thisParentDisabled.find('.form-elements-add-data_application-name_ja').removeAttr("disabled")
					thisParentDisabled.find('.form-elements-add-data_application-name_en').removeAttr("disabled")
					thisParentDisabled.find('.form-elements-add-data_application-name_url').removeAttr("disabled")
				})
				$(document).on('click', '.update_add_data_application', function () {
					let thisParentDisplay = $(this).parent();
					thisParentDisplay.find('.update_add_data_application').removeClass('update_add_data_application d-flex').addClass('update_add_data_application d-none')
					thisParentDisplay.find('.edit_add_data_application').removeClass('edit_add_data_application d-none').addClass('edit_add_data_application d-flex')
					let thisParentContent = $(this).parent().parent();
					thisParentContent.find('.form-elements-add-data_application-name_ja').attr("disabled", "disabled")
					thisParentContent.find('.form-elements-add-data_application-name_en').attr("disabled", "disabled")
					thisParentContent.find('.form-elements-add-data_application-name_url').attr("disabled", "disabled")
					let id_data_application = thisParentContent.find('.form-elements-add-data_application-id').val();
					let data_application_name_ja = thisParentContent.find('.form-elements-add-data_application-name_ja').val();
					let data_application_name_en = thisParentContent.find('.form-elements-add-data_application-name_en').val();
					let data_application_name_url = thisParentContent.find('.form-elements-add-data_application-name_url').val();
					let url_data_application_id = `{{route('metameta.edit_data_application')}}`;
					$('.status-errors-edit-add-data_application').children().empty()
					$.ajax({
						url: url_data_application_id,
						method: 'POST',
						data: {
							"id": id_data_application,
							"name_ja": data_application_name_ja,
							"name_en": data_application_name_en,
							"url": data_application_name_url,
							"_token": "{{ csrf_token() }}",
						},
						success: function (response) {
							if (response.status_success) {
								toastr.options.timeOut = 2000;
								toastr.success(response.status_success);
							}
							if (response.status_errors) $('.status-errors-edit-add-data_application').append(`<span class="text-danger">${response.status_errors}</span>`)
						},
						error: function (response) {
							toastr.options.timeOut = 2000;
							toastr.errors(response.status_errors);
						}
					});
				})
				$(document).on('click', '.delete-data_application', function () {
					let thisParent = $(this).parent().parent();
					let id_data_application = thisParent.find('.data_application-id').val();
					$('.delete-input-data_application').val(id_data_application);
					let add_class = `js-parent${id_data_application}`
					thisParent.addClass(add_class);
					$('#modalShowDataApplicationDelete').modal("show")
				})
				$(document).on('click', '#confirm-delete-data_application', function (event) {
					event.preventDefault();
					let id_data_application = $(this).parent().parent().find('.delete-input-data_application').val();
					let url_data_application_id = `{{route('metameta.destroy_data_application')}}`;
					$.ajax({
						url: url_data_application_id,
						method: 'GET',
						data: {
							"id": id_data_application,
						},
						success: function (response) {
							if (response.id) {
								if ($(`.js-parent${response.id}`)) {
									$(`.js-parent${response.id}`).remove();
								}
								if (response.status_success) {
									toastr.options.timeOut = 2000;
									toastr.success(response.status_success);
								}
							}
						},
						error: function (response) {
							console.log(response)
						}
					});
				})
				$(document).on('click', '.delete-add-data_application', function () {
					$('#modalShowDataApplicationDelete').modal("show")
					let thisParent = $(this).parent().parent();
					let id_data_application = thisParent.find('.form-elements-add-data_application-id').val();
					$('.delete-input-data_application').val(id_data_application);
					let add_class = `js-parent${id_data_application}`;
					thisParent.addClass(add_class);
				})


				$('#attachFile').on('change', function () {
					let parentForm = $(this).parents('#attach-form');
					let formData = new FormData();
					let note = $(parentForm).find('#fileNote').val();
					let fileElement = $(parentForm).find('#attachFile');
					let fileUpload = $(fileElement)[0].files;
					console.log($(parentForm).find('#attachFile'));
					for (let file of fileUpload) {
						toastr.options.timeOut = 2000;
						let filename = file.name;
						const extension = filename.substring(filename.lastIndexOf('.') + 1, filename.length);
						if (!allowFileTypes.includes(extension)) {
							toastr.error('{{trans('validation.rules.file_type_check')}}');
							$(fileElement).val('')
							return;
						}
						if (Math.round(file.size / 1024) >= 5 * 1024) {
							toastr.error('{{trans('app.file_size_limit')}}');
							$(fileElement).val('')
							return;
						}
						formData.append('files', file, file.name);
					}
					formData.append('note', note);
					$(parentForm).find('#uploading-msg').html(@json(trans('app.file_uploading')));
					$.ajax({
						method: 'POST',
						url: '{{route('metameta.upload_file', ['id' => $metameta->id])}}',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: formData,
						processData: false,
						contentType: false,
						success: function (data) {
							$(parentForm).find('#uploading-msg').html('');
							appendFile(data);
							$('#fileNote').val('')
							toastr.success('{{trans('app.upload_success')}}');
						},
						error: function (e) {
							$(parentForm).find('#uploading-msg').html('');
							toastr.error(e['responseJSON']['message']);
						},
					});
					$('#attachFile').val('');
				});

				$(document).on('click', '#action-preview', function () {
					let parent = $(this).parent().parent().parent();
					let name = $(parent).find('.attachment_icon span').attr('title');
					let url = $(parent).find('.form-elements-file-url').val();
					let modal = $('#document-preview');
					$(modal).find('.modal-header .modal-title').html(name);
					let src = $(modal).find('iframe').attr('src', 'https://view.officeapps.live.com/op/embed.aspx?src=' + url);
				})
				// Remove file from file list
				$(document).on('click', '.remove-file', function () {
					if (!confirm("{{trans('metameta.delete_file_confirm')}}")) return;
					let parent = $(this).parent().parent();
					let id = $(parent).find('.form-elements-file-id').val();
					let deleteURL = '{{route("metameta.delete_file", "id")}}';
					$.ajax({
						url: deleteURL.replace('id', id),
						method: 'DELETE',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						success: function () {
							toastr.success("{{trans('app.delete_successfully')}}");
							if ($(parent)) {
								$(parent).remove();
							}
						},
						error: function (e) {
							toastr.error(e['responseJSON']['message']);
						}
					});
				});

				$(document).on('click', '#deleteMetametaModal__confirm', function () {
					let url = "{{route('metameta.delete', 'id')}}";
					let id = "{{$metameta->id}}";
					$.ajax({
						url: url.replace('id', id),
						method: 'DELETE',
						headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
						data: {
							'delete-confirm': $('#deleteMetametaModal #delete-confirm').val(),
						},
						success: function () {
							window.location = "{{route('metameta.index')}}";
						},
						error: function (e) {
							toastr.error(e['responseJSON']['message']);
						}
					});
				});
			});

			function addCommentClass(elementId) {
				let elementInput = $('.meta-element').find(`.metameta-elements-id[value=${elementId}]`);
				let commentIcon = $(elementInput).parents('.meta-element').find('.application_progress_comment span');
				if(!$(commentIcon).hasClass(hasCommentClass)) {
					$(commentIcon).addClass(hasCommentClass);
				}
			}

			function removeCommentClass(elementId, count) {
				let elementInput = $('.meta-element').find(`.metameta-elements-id[value=${elementId}]`);
				let commentIcon = $(elementInput).parents('.meta-element').find('.application_progress_comment span');
				if($(commentIcon).hasClass(hasCommentClass) && count === 0) {
					console.log('change color');
					$(commentIcon).removeClass(hasCommentClass);
				}
			}

			function appendFile(data) {
				let template = $('#fileList .row-template').clone();
				template.find('.attachment_created').html(data.created);
				template.find('.attachment_note').html(data.note);
				template.find('.attachment_author').html(data.author);
				template.find('.form-elements-file-url').val(data.url);
				template.find('.attachment_icon span').attr('data-toggle', 'tooltip');
				template.find('.attachment_icon span').attr('title', data.original_name);
				if (['doc', 'docx'].includes(data.type)) {
					template.find('.attachment_icon a').attr('data-toggle', 'modal');
					template.find('.attachment_icon a').attr('data-target', '#document-preview');
					template.find('.attachment_icon a').attr('id', 'action-preview');
					template.find('.attachment_icon a').attr('style', 'cursor: pointer;');
				}
				template.find('.form-elements-file-id').val(data.id);
				addFileTypeIcon(template, data.type);
				template.removeClass('row-template d-none').addClass('d-flex');
				$('#fileList').append(template);
			}

			function addFileTypeIcon(rowRecord, fileType) {
				let iconClassTemplate = 'icon-copy bi bi-filetype-temp ic-color-temp';
				let fileList = @json(Attachment::MIMETYPE);
				let iconClass = "";
				let typeIcon = document.createElement("i");
				for (let i = 0; i < fileList.length; i++) {
					if (fileList[i] === fileType) {
						iconClass = iconClassTemplate.replaceAll('temp', fileType);
						break;
					}
				}
				$(typeIcon).attr('class', iconClass);
				rowRecord.find('.attachment_icon a').append(typeIcon);
			}
	</script>
@endsection