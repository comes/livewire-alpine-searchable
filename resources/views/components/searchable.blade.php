@props([
    'options',
    'required' => false,
    'multiple' => false,
    'selected' => [],
    'searchFloor' => 3,
    'renderLimit' => 50,
    'name' => null,
])
<div {{ $attributes }}
        x-id="['searchable-input']"
        wire:ignore x-data="{
        multiple: {{ $multiple?'true':'false' }},
        value: @js($selected),
        options: @js($options),
        init() {
            this.$nextTick(() => {
                let choices = new Choices(this.$refs.select, {
                    removeItems: true,
                    removeItemButton: true,
                    allowHTML: true,
                    searchFields: ['label', 'value'],
                    searchFloor: {{ intval($searchFloor) }}, // minimum number of characters to start search
                    renderChoiceLimit: {{ intval($renderLimit) }}, // maximum number of items to show choices for
                    classNames: {
                        containerOuter: 'choices',
                        containerInner: 'choices__inner',
                        input: 'choices__input',
                        inputCloned: 'choices__input--cloned',
                        list: 'choices__list',
                        listItems: 'choices__list--multiple',
                        listSingle: 'choices__list--single',
                        listDropdown: 'choices__list--dropdown',
                        item: 'choices__item',
                        itemSelectable: 'choices__item--selectable',
                        itemDisabled: 'choices__item--disabled',
                        itemChoice: 'choices__item--choice',
                        placeholder: 'choices__placeholder',
                        group: 'choices__group',
                        groupHeading: 'choices__heading',
                        button: 'choices__button',
                        activeState: 'is-active',
                        focusState: 'is-focused',
                        openState: 'is-open',
                        disabledState: 'is-disabled',
                        highlightedState: 'is-highlighted',
                        selectedState: 'is-selected',
                        flippedState: 'is-flipped',
                        loadingState: 'is-loading',
                        noResults: 'has-no-results',
                        noChoices: 'has-no-choices'
                    },
                })

                let refreshChoices = () => {
                    let selection = this.multiple ? this.value : [this.value]

                    choices.clearStore()
                    choices.setChoices(this.options.map(({ value, label }) => ({
                        value,
                        label,
                        selected: selection.includes(value),
                    })))
                }

                refreshChoices()

                this.$refs.select.addEventListener('change', () => {
                    this.value = choices.getValue(true)
                })

                // send to livewire
                this.$watch('value', (newValue) => this.$dispatch('input', newValue))

                this.$watch('value', () => refreshChoices())
                this.$watch('options', () => refreshChoices())
            })
        }
    }" class="mx-auto w-full">
    <select
        x-ref="select"
        :id="$id('{{ $name }}')"
        @if($name)
            name="{{ $name }}"
        @endif
        @if($required)
            required
        @endif
        @if($multiple)
            multiple
        @endif>
    </select>
</div>
