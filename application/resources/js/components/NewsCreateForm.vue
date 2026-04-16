<template>
    <div class="bg-white p-6 rounded-xl shadow space-y-4">

        <h1 class="text-xl font-bold">Cadastrar Notícia</h1>

        <p
            v-if="successMessage"
            class="rounded bg-green-100 px-3 py-2 text-sm text-green-800"
        >
            {{ successMessage }}
        </p>

        <p
            v-if="errorMessage"
            class="rounded bg-red-100 px-3 py-2 text-sm text-red-800"
        >
            {{ errorMessage }}
        </p>

        <input
            v-model="form.title"
            type="text"
            placeholder="Título"
            :class="[
                'w-full rounded p-2',
                fieldErrors.title ? 'border border-red-500' : 'border'
            ]"
        />
        <p v-if="fieldErrors.title" class="text-sm text-red-600">
            {{ fieldErrors.title[0] }}
        </p>

        <textarea
            v-model="form.content"
            placeholder="Conteúdo"
            :class="[
                'w-full rounded p-2 h-40',
                fieldErrors.content ? 'border border-red-500' : 'border'
            ]"
        />
        <p v-if="fieldErrors.content" class="text-sm text-red-600">
            {{ fieldErrors.content[0] }}
        </p>

        <news-category-select
            v-model="form.category_id"
            :categories="categories"
            :has-error="Boolean(fieldErrors.category_id)"
        ></news-category-select>
        <p v-if="fieldErrors.category_id" class="text-sm text-red-600">
            {{ fieldErrors.category_id[0] }}
        </p>


        <button
            @click="submit"
            :disabled="loading"
            class="bg-blue-500 text-white px-4 py-2 rounded"
        >
            {{ loading ? 'Publicando...' : 'Publicar notícia' }}
        </button>

    </div>
</template>

<script>
import axios from 'axios'

export default {
    props: {
        categories: {
            type: Array,
            default: () => [],
        },
    },

    data() {
        return {
            form: {
                title: '',
                content: '',
                category_id: '',
            },
            loading: false,
            successMessage: '',
            errorMessage: '',
            fieldErrors: {},
        }
    },

    methods: {
        async submit() {
            this.loading = true
            this.successMessage = ''
            this.errorMessage = ''
            this.fieldErrors = {}

            try {
                await axios.post('/api/news', this.form)
                this.successMessage = 'Notícia publicada com sucesso.'
                this.form = {
                    title: '',
                    content: '',
                    category_id: '',
                }
                this.fieldErrors = {}
            } catch (e) {
                console.error(e)

                if (e.response?.status === 422) {
                    this.errorMessage = 'Preencha os campos obrigatórios corretamente.'
                    this.fieldErrors = e.response?.data?.errors || {}
                } else {
                    this.errorMessage = 'Erro ao publicar notícia. Tente novamente.'
                }
            } finally {
                this.loading = false
            }
        }
    }
}
</script>
