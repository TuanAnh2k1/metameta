@foreach($comments as $commentElement)
	<x-metameta.comment.modal-element :comment="$commentElement" />
@endforeach
