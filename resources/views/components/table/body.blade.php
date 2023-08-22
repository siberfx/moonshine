@props([
    'rows',
    'actions',
    'vertical' => false,
    'editable' => false,
    'preview' => false,
])
@foreach($rows as $row)
    <tr {{ $row->trAttributes($loop->index) }}>
        @if(!$preview && $actions->isNotEmpty())
            <td {{ $row->tdAttributes($loop->index, 0)
                ->merge(['class' => 'w-10 text-center']) }}
                @if($vertical) width="5%" @endif
            >
                <x-moonshine::form.input type="checkbox"
                     @change="actions('row')"
                     name="items[{{ $row->getKey() }}]"
                     class="tableActionRow"
                     value="{{ $row->getKey() }}"
                />
            </td>
        @endif

        @if($vertical && !$preview)
            <td {{ $row->tdAttributes($loop->parent->index, 0 + $actions->isNotEmpty())->merge(['class' => 'space-y-3']) }}>
                @foreach($row->getFields() as $index => $field)
                    @if($field->isSee($field->toValue()))
                        <x-moonshine::field-container :field="$field">
                            {!! $field->{$editable ? 'render' : 'preview'}() !!}
                        </x-moonshine::field-container>
                    @endif
                @endforeach
            </td>
        @else
            @foreach($row->getFields() as $index => $field)
                @if($vertical) <tr {{ $row->trAttributes($index) }}>
                    <td {{ $row->tdAttributes($index, 0) }}>
                        {{$field->label()}}
                    </td>
                    @endif

                    <td {{ $vertical
                            ? $row->tdAttributes($index, 1)
                            : $row->tdAttributes($loop->parent->index, $index + $actions->isNotEmpty()) }}
                    >
                        {!! $field->isSee($field->toValue())
                            ? $field->{$editable ? 'render' : 'preview'}()
                            : ''
                        !!}
                    </td>

                    @if($vertical)
                </tr>
                @endif
            @endforeach
        @endif

        @if(!$preview)
            <td {{ $row->tdAttributes($loop->index, $row->getFields()->count() + $actions->isNotEmpty()) }}
                @if($vertical) width="5%" @endif
            >
                <x-moonshine::table.actions
                    :actions="$row->getActions()"
                />
            </td>
        @endif
    </tr>
@endforeach
