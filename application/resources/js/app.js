import '../css/app.css'
import './bootstrap'

import { createApp } from 'vue'
import NewsList from './components/NewsList.vue'
import NewsCreateForm from './components/NewsCreateForm.vue'
import NewsCategorySelect from './components/NewsCategorySelect.vue'

const app = createApp({})

app.component('news-list', NewsList)
app.component('news-create-form', NewsCreateForm)
app.component('news-category-select', NewsCategorySelect)

app.mount('#app')
