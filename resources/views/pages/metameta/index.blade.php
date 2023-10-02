@extends('layouts.index')
@php
	use \App\Core\Common\CoreConst;
@endphp
@section('title', 'MetaMeta')
@section('content')
	<div class="page-header">
		<div class="row">
			<div class="col-md-6 col-sm-12">
				<div class="title">
					<h4>@lang('metameta.metameta')</h4>
				</div>
			</div>
			<div class="col-md-6 col-sm-12 text-right action">
				@if($authUser)
					<a href="{{route('metameta.create')}}" class="dropdown-toggle no-arrow text-add-comment">
						<span class="micon bi bi-plus"></span><span class="mtext">@lang('metameta.metameta')</span>
					</a>
				@endif
				<a id="setting" data-toggle="modal" data-target="#table-setting">
					<i class="icon-copy bi bi-gear-fill cursor-pointer hover_icon"></i>
				</a>
			</div>
		</div>
	</div>
	<div class="card">
		<div class="scroll">
			<table class="table list-metameta">
				<thead>
				<tr>
					<th scope="col" class="{{$editColumnClass}}" style="{{$editColumnStyle}}"></th>
					@foreach($settings as $column_setting)
                            <?php
                            if (!$column_setting['is_display']) {
                                continue;
                            }
                            ?>
						<th scope="col" class="{{$column_setting['th-class']}} vertical-align"
						    style="{{$column_setting['style']}}">
							@if($column_setting['sortable'])
								@sortablelink($column_setting['column_name'], $column_setting['column_name_trans'])
							@else
								{{$column_setting['column_name_trans']}}
							@endif
						</th>
					@endforeach
					<th scope="col" style="{{$editColumnStyle}}"></th>
				</tr>
				</thead>
				<tbody>
				@if($metameta->isEmpty())
					<tr>
						<td class="table-no-data" style="background: transparent; border: none !important;">{{trans('app.no_data_exists')}}</td>
					</tr>
				@else
					@foreach ($metameta as $key => $value)
						<tr>
							<td class="edit-col {{$editColumnClass}}" style="{{$editColumnStyle}}">
								@can('update',$value)
									<a href="{{ route('metameta.edit', $value->id) }}" class="text-add-comment margin-icon">
										<i class="fa-solid fa-pen-to-square font-18"></i>
									</a>
								@endcan
							</td>
							@foreach($settings as $column_setting)
                                    <?php
                                    if (!$column_setting['is_display']) {
                                        continue;
                                    }
                                    $columnValue = $value[$column_setting['column_name']];
                                    $bgClass = null;
                                    $textValue = null;
                                    if(!isset(CoreConst::METAMETA_VALUE[$column_setting['column_name']])) {
                                        $textValue = $value[$column_setting['column_name']];
                                    }
                                    else {
                                        $columnProp = CoreConst::METAMETA_VALUE[$column_setting['column_name']];
                                        if(isset($columnValue)) {
                                            $bgClass = $columnProp[$columnValue]['class'];
                                            $textValue = trans($columnProp[$columnValue]['text']);
                                        }
                                    }
                                    ?>
								<td class="{{$column_setting['td-class']}} {{$bgClass}}"
								    style="{{$column_setting['style']}}">
									<p class="comment text-comment mb-0">
										@if(isset($textValue))
											{{$textValue}}
										@else
											<br>
										@endif
									</p>
								</td>
							@endforeach
							<td style="{{$editColumnStyle}}" class="edit-col">
								@can('update',$value)
									<a href="{{ route('metameta.edit', $value->id) }}" class="text-add-comment margin-icon">
										<i class="fa-solid fa-pen-to-square font-18"></i>
									</a>
								@endcan
							</td>
						</tr>
					@endforeach
				@endif
				</tbody>
			</table>
		</div>
	</div>

	<div class="input-group d-flex justify-content-between">
		<div></div>
		<div class="d-flex justify-content-between">
			<select class="select-page" name="page_size" id="page_size">
				@foreach(CoreConst::PAGE_SIZES as $size)
					<option value="{{$size}}" @if($page_size == $size) selected @endif>{{$size}}</option>
				@endforeach
			</select>
			{{$metameta->withQueryString()->links()}}
		</div>
	</div>
	<div class="modal" id="table-setting" tabindex="-1">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">@lang('metameta.setting.table_setting')</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<table class="table table-hover" id="setting-table">
						<thead>
						<tr>
							<th id="setting-table__check-column">
								<p>@lang('metameta.setting.is_display')</p>
								<input type="checkbox" class="ckeck-column" id="setting-table__check-all">
							</th>
							<th id="setting-table__name-column">@lang('metameta.setting.column_name')</th>
							<th id="setting-table__width-column">@lang('metameta.setting.width')</th>
							<th id="setting-table__is-freeze-column">@lang('metameta.setting.is_freeze')</th>
						</tr>
						</thead>
						<tbody>
						<tr class="setting-template-row d-none">
							<td>
								<input type="checkbox" class="check-column setting_check">
							</td>
							<td class="setting_name"></td>
							<td>
								<input type="number" class="form-control setting_width">
							</td>
							<td>
								<input type="checkbox" class="check-column setting_freeze">
							</td>
						</tr>
						</tbody>
					</table>
				</div>
				<div class="modal-footer">
					<meta class="form-group form-bottom" name="csrf-token" content="{{ csrf_token() }}">
					<button type="submit" class="btn btn-success update-setting">@lang('app.save')</button>
				</div>
			</div>
		</div>
	</div>
@endsection
@section('script')
	<script type="text/javascript">
			$page = '1';
			$(document).ready(function () {
				let setting_table = $('#setting-table');
				$('#setting-table tbody').sortable({
					connectWith: "#setting-table tbody",
					items: "> tr",
					appendTo: setting_table,
					helper: "clone",
					zIndex: 999990,
					// revert: true,
					start: function () {
						setting_table.addClass("dragging")
					},
					stop: function () {
						setting_table.removeClass("dragging")
					},
					distance: 10,
					opacity: 1,
				}).disableSelection();

				$('#setting').on('click', () => {
					let template = $('.setting-template-row.d-none');
					let body = $('#setting-table tbody');
					$(body).find('.setting-row').remove();
					for (const settingItem of @json($settings)) {
						let columnName = 'meta.' + settingItem.column_name;
						let row = template.clone();
						$(row).find('.setting_check').prop('checked', settingItem.is_display);
						$(row).find('.setting_width').val(settingItem.width);
						$(row).find('.setting_freeze').prop('checked', settingItem.is_freeze);
						$(row).find('.setting_name').html(settingItem.column_name_trans);
						row.removeClass('d-none setting-template-row').addClass('setting-row d-flex');
						body.append(row);
					}
					let isAllChecked = true;
					$('.setting-row').find(".setting_check").each(function () {
						let row = $(this).parent().parent();
						if (!this.checked) {
							isAllChecked = false;
							$(row).find('.setting_width').attr('disabled', 'disabled');
							$(row).find('.setting_freeze').attr('disabled', 'disabled');
						}
					});
					$("#setting-table__check-all").prop('checked', isAllChecked);
				});

				$('.update-setting').on('click', function () {
					let settings = []
					let rowsSetting = $(setting_table).find('tbody .setting-row');
					$(rowsSetting).each((index, row) => {
						let isChecked = $(row).find('.setting_check:checked').length !== 0 ? 1 : 0;
						let name = $(row).find('.setting_name').html();
						let width = $(row).find('.setting_width').val();
						let isFreeze = $(row).find('.setting_freeze:checked').length !== 0 ? 1 : 0;
						settings.push({
							'is_display': isChecked,
							'column_name': name,
							'width': width,
							'is_freeze': isFreeze,
						});

					})
					$.ajaxSetup({
						headers: {
							'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
						}
					});
					$.ajax({
						method: 'POST',
						url: '{{route('metameta.update_settings')}}',
						data: {settings: settings},
						success: function (data) {
							window.location = "{{route('metameta.index')}}";
						},
						error: function (e) {
							toastr.error(e['responseJSON']['message']);
						}
					})
				});

				$(document).on('click', '.comment', function () {
					let obj = $(this);
					if (obj.hasClass('text-comment')) {
						obj.removeClass("text-comment");
					} else {
						obj.addClass("text-comment");
					}
				})

				$('#page_size').on('change', function () {
					setURL();
				})

				$('.js-paginate').on('click', function () {
					$page = $(this).html().trim();
					setURL();
				})

				$("#setting-table__check-all").click(function () {
					let settingChecks = $('.setting_check');
					for (const settingCheckElement of settingChecks) {
						$(settingCheckElement).prop('checked', this.checked);
						let row = $(settingCheckElement).parent().parent();
						checkDisableRow(row);
					}
				})

				$(document).on('click', '.setting_check', function () {
					let row = $(this).parent().parent();
					checkDisableRow(row);
					let isAllChecked = true;
					let isDisplay = $(".setting_check")
					for (const checkbox of isDisplay) {
						let row = $(checkbox).parent().parent();
						if ($(row).hasClass('setting-row') && !$(checkbox).prop('checked')) {
							isAllChecked = false;
							break;
						}
					}
					$("#setting-table__check-all").prop('checked', isAllChecked);
				})
			});

			function checkDisableRow(row) {
				let column_width = $(row).find('.setting_width');
				let column_freeze = $(row).find('.setting_freeze');
				let column_display = $(row).find('.setting_check');
				if (!$(column_display).is(':checked')) {
					$(column_width).attr('disabled', 'disabled');
					$(column_freeze).attr('disabled', 'disabled');
				} else {
					$(column_width).removeAttr("disabled");
					$(column_freeze).removeAttr("disabled");
				}
			}

			function setURL() {
				$page = $page.trim();
				$page_size = $('#page_size').val().trim();
				$url_res = `../metameta?page_size=${$page_size}&page=${$page}`;
				window.location = $url_res;
			};
	</script>
@endsection