<div>
    <x-searchable
        :options="$options"
        wire:model="values"
        :selected="$values"
        multiple
    />
</div>