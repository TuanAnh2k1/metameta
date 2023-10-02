<select class="form-control form-elements metadata_element_selected" name="{{$name}}" @if($disabled) disabled @endif>
    @foreach($options as $option)
        <option value="{{$option['value']}}" @if($selected == $option['value']) selected @endif>{{trans($option['text'])}}</option>
    @endforeach
</select>