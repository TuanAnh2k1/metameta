@foreach($comments as $commentElement)
    <x-metameta.comment.element :comment="$commentElement" />
@endforeach
