@props([
    'name',
])
<div
    x-id="['remote=searchable-input']"
    x-data="{
        multiple: true,
        value: [],
        options: {},
        init() {
            this.$nextTick(() => {
                let choices = new Choices(this.$refs.select, {
                    removeItems: true,
                    removeItemButton: true,
                    allowHTML: true,
                    searchFields: ['label', 'value'],
                    searchFloor: 1, // minimum number of characters to start search
                    renderChoiceLimit: 10, // maximum number of items to show choices for
                })

                this.$refs.select.addEventListener('search', async (e) => {
                    // let data = await doSearch(e.detail.value)
                    let data = await fetch(
                            // below api is only used for this example. it doesn't support query filtering, but its returns some data.
                            '/api/example?q=' + event.detail.value
                        )
                        .then(res => {
                            return res.json();
                        });
                    console.log(data);
                    this.options = data;
                    refreshChoices();
                });

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
    <select x-ref="select" :id="$id('{{ $name }}')" multiple></select>
</div>
