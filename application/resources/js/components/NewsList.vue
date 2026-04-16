<template>
    <div class="max-w-6xl mx-auto px-4">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

            <article
                v-for="item in news"
                :key="item.id"
                class="bg-white rounded-xl shadow p-5 flex flex-col gap-3"
            >

                <h3 class="text-base font-semibold">
                    <span v-html="item.title"></span>
                </h3>

                <p class="text-sm text-gray-600">
                    {{ item.content.substring(0, 140) }}...
                </p>

                <a
                    :href="`/news/${item.uuid}`"
                    class="mt-auto bg-gray-200 hover:bg-gray-300 py-2 rounded-lg text-sm text-center block"
                >
                    Acessar
                </a>

            </article>

        </div>

        <div v-if="loading" class="text-center mt-6 text-sm text-gray-500">
            Carregando...
        </div>

        <div ref="trigger"></div>

    </div>
</template>

<script>
import axios from 'axios';

export default {
    props: {
        initialNews: Array
    },

    data() {
        return {
            news: this.initialNews || [],
            page: 2,
            loading: false,
            finished: false,
        }
    },

    mounted() {
        this.observeScroll();
    },

    methods: {
        async loadNews() {
            if (this.loading || this.finished) return;

            this.loading = true;

            try {
                const res = await axios.get(`/api/news?page=${this.page}`);

                this.news.push(...res.data.data);

                if (!res.data.next_page_url) {
                    this.finished = true;
                } else {
                    this.page++;
                }

            } catch (err) {
                console.error(err);
            } finally {
                this.loading = false;
            }
        },

        observeScroll() {
            const observer = new IntersectionObserver((entries) => {
                if (entries[0].isIntersecting) {
                    this.loadNews();
                }
            });

            observer.observe(this.$refs.trigger);
        }
    }
}
</script>
