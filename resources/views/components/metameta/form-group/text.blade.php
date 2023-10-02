@php
    foreach ($elements as $metametaElement) {
        if($metametaElement['column_name'] === $title) {
            $elementId = $metametaElement['value'];
            break;
        }
    }
@endphp
<div class="form-group form-bottom d-flex meta-element">
    <input class="metameta-elements-id d-none" value="{{$elementId}}">
    <label class="form-elements d-flex align-items-center mb-0">@lang('metameta.'.$title)
        <x-metameta.comment.icon-show-modal title="@lang('app.comments')" :hasComment="$hasComment"/>
    </label>
    <div class="w-100">
        <div class="d-flex">
            <input class="form-control metadata-add-link" value="{{old('metameta.'.$title,$value)}}" name="metameta[{{$title}}]"
                   @if($disabled || $inputDisabled) disabled @endif>
            @if($hasBlank)
                <a target="_blank"
                   class="pd-10 align-items-center d-flex cursor-pointer hover_icon __js-metadata-open-link">
                    <i class="icon-copy bi bi-folder-symlink-fill"></i>
                </a>
            @endif
        </div>
        @error('metameta.'.$title)
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>