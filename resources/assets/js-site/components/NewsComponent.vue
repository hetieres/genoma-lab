<script>
    import funcs from "../functions";

    export default {
        props: ['featured'],
        data: function () {
            return {
                baseUrl,
                ready:         false,
                page:          1,
                international: 0,
                loading:       false,
                ended:         false,
                list:          []
            }
        },

        methods: {
            getNews: function () {
                this.loading = true;
                if(this.page===1) this.ready = false;
                if (this.ended) return false;

                let url = baseUrl + "api/site/get-news" + (this.international > 0 ? '/' + this.international : '');

                axios.get(url, {
                    params: {
                        page:     this.page,
                        featured: this.featured
                    }
                }).then(resp => {
                    let data = resp.data.news;

                    if (this.page>=1 && data.length>0) {
                        data.forEach((el, index) => {
                            this.list.push(el);
                        });
                    }

                    if (data.length===0) this.ended = true;

                    // Variables
                    this.ready   = true;
                    this.loading = false;
                    this.page    = this.page+1;
                }).catch(error => {
                    console.log('Error:')
                    console.log(error);
                });
            },

            _bindSelect: function (rel) {
                if (this.international!==rel) {
                    this.international = rel;
                    this.ready         = false;
                    this.page          = 1;
                    this.ended         = false;
                    this.list           = [];

                    this.getNews();
                }
            },

            _scrollNews: function () {
                $(window).on('scroll', document, (e) => {
                    let scrollTop     = $(e.currentTarget).scrollTop(),
                        screenHeight  = $(e.currentTarget).innerHeight(),
                        contentHeight = ($('body #publications').length ? $('body #publications')[0].scrollHeight : null);

                    if((scrollTop + screenHeight) >= contentHeight) {
                        if (!this.loading && !this.ended) {
                            this.getNews();
                        }
                    }
                });
            }
        },

        mounted: function () {
            this.getNews();
            this._scrollNews();
        },
    }
</script>

<template>
    <div class="col-xs-12">
        <div id="select" class="clearfix">
            <h3 class="pull-left">Filtrar</h3>

            <div class="pull-right">
                <a href="javascript:;" @click="_bindSelect(0)" :class="`select-link ${international===0 ? 'active' : '' }`">Todas</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="javascript:;" @click="_bindSelect(1)" :class="`select-link ${international===1 ? 'active' : '' }`">Nacionais</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <a href="javascript:;" @click="_bindSelect(2)" :class="`select-link ${international===2 ? 'active' : '' }`">Internacionais</a>
            </div>
        </div>

        <div v-if="ready==true" id="publications">
            <template v-for="(pub, index) in this.list">
                <hr v-if="index>0">

                <h2>&nbsp;Publicações de {{ pub.date }}</h2>

                <ul>
                    <nm-news-box-home v-for="news in pub.news" :item="news" :key="news.id"></nm-news-box-home>
                </ul>
            </template>

            <div v-if="loading==true" id="pageLoading" class="pageLoadingBox">
                <img :src="baseUrl + 'assets/vendor/page-lazy-load/loading.svg'" />
            </div>
        </div>

        <div v-else id="pageLoading" class="pageLoadingBox">
            <img :src="baseUrl + 'assets/vendor/page-lazy-load/loading.svg'" />
        </div>
    </div>
</template>

<style scoped=""></style>
