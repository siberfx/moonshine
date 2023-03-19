@foreach($components as $fieldOrDecoration)
    @if($fieldOrDecoration instanceof \Leeto\MoonShine\Decorations\Decoration)
        {{ $resource->renderDecoration($fieldOrDecoration, $item) }}
    @elseif($fieldOrDecoration instanceof \Leeto\MoonShine\Fields\Field
        && $fieldOrDecoration->canDisplayOnForm($item)
        && !$fieldOrDecoration->isResourceModeField()
    )
        @if($fieldOrDecoration->hasFieldContainer())
            <x-moonshine::field-container :field="$fieldOrDecoration" :item="$item" :resource="$resource">
                {{ $resource->renderField($fieldOrDecoration, $item) }}
            </x-moonshine::field-container>
        @else
            {{ $resource->renderField($fieldOrDecoration, $item) }}
        @endif
    @endif
@endforeach