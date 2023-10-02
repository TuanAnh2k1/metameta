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
            <textarea class="form-control " value="" name="metameta[{{$title}}]"
                      @if($disabled) disabled @endif>{{old('metameta.'.$title,$value)}}</textarea>
        </div>
        @error('metameta.'.$title)
        <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>
</div>