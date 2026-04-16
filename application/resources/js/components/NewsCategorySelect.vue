<template>
    <div>
        <select
            :value="modelValue"
            :name="name"
            :class="[
                'w-full p-2 rounded',
                hasError ? 'border border-red-500' : 'border'
            ]"
            @change="$emit('update:modelValue', $event.target.value)"
        >
            <option value="">Selecione Categoria</option>

            <option
                v-for="cat in filteredCategories"
                :key="cat.id"
                :value="cat.id"
            >
                {{ cat.name }}
            </option>
        </select>
    </div>
</template>

<script>
export default {
    props: {
        categories: {
            type: Array,
            default: () => [],
        },
        modelValue: {
            type: [String, Number],
            default: '',
        },
        name: {
            type: String,
            default: 'category_id',
        },
        hasError: {
            type: Boolean,
            default: false,
        },
    },
    emits: ['update:modelValue'],
    data() {
        return {
            search: '',
        };
    },
    computed: {
        filteredCategories() {
            return this.categories.filter(c =>
                c.name.toLowerCase().includes(this.search.toLowerCase())
            );
        }
    }
}
</script>
