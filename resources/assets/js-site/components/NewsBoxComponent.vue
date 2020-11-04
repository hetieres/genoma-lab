<script>
    import funcs from "../functions";

    export default {
        props: ['item'],
        data: function () {
            return {
                baseUrl,
                limit:   5,
                ready:   false,
                loading: false,
                news:    []
            }
        },

        methods: {
            getNewsVehicles: function (ref) {
                this.ready   = false;
                this.loading = true;
                let url      = baseUrl + "api/site/get-news-vehicles";

                axios.get(url, {params: { ref }}).then(resp => {
                    let data        = resp.data.vehicles;
                    this.ready      = true;
                    this.news.vhNew = data.new;
                    this.news.vhOld = data.old;
                }).catch(error => {
                    console.log('Error:')
                    console.log(error);
                });
            },

            getHideItems: function (items) {
                return items; //.slice(Math.max(items.length - this.limit, 1));
            },

            loadVehicles: function () {
                this.getNewsVehicles(this.item.ref);
            }
        },

        mounted: function () {
            this.news = this.item;
        },
    }
</script>

<template>
    <li :data-rel="`news_${news.id}`">
        <a :href="baseUrl + news.link">
            <h3> {{ news.title }}</h3>
            <div class="description" v-html="news.text"></div>
        </a>

        <lazy-component @show="loadVehicles">
            <template v-if="ready==false">
                <div class="viewLine loading clearfix">
                    <img :src="baseUrl + 'assets/img/loading_vehicles.svg'" /> <span>Carregando veículos</span>
                </div>
            </template>

            <template v-else>
                <div class="viewLine clearfix">
                    <template v-if="news.vhNew.length<=limit">
                        <a v-for="i in news.vhNew.length" :href="baseUrl + news.vhNew[(i-1)].link" class="boxVehicle">{{ news.vhNew[(i-1)].name }}</a>
                    </template>

                    <template v-if="news.vhNew.length>limit">
                        <a v-for="x in limit" :href="baseUrl + news.vhNew[x-1].link" class="boxVehicle">{{ news.vhNew[x-1].name }}</a>
                        <a href="javascript:;" class="boxVehicle viewMore collapsed" data-toggle="collapse" :data-target="`#reverb_${ news.id }`"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></a>

                        <div :id="`reverb_${ news.id }`" class="col-12 no-padding collapse">
                            <a v-for="(z, index) in news.vhNew" :href="baseUrl + z.link" v-if="index>=5" class="boxVehicle">{{ z.name }}</a>
                        </div>
                    </template>
                </div>

                <template v-if="news.vhOld.length>0">
                    <div class="viewLine previous clearfix">
                        <div class="title">Anteriores:</div>
                        <template v-if="news.vhOld.length<=limit">
                            <a v-for="i in news.vhOld.length" :href="baseUrl + news.vhOld[(i-1)].link" class="boxVehicle">{{ news.vhOld[(i-1)].name }}</a>
                        </template>

                        <template v-if="news.vhOld.length>limit">
                            <a v-for="x in limit" :href="baseUrl + news.vhOld[x-1].link" class="boxVehicle">{{ news.vhOld[x-1].name }}</a>
                            <a href="javascript:;" class="boxVehicle viewMorePre collapsed" data-toggle="collapse" :data-target="`#reverbPrev_${ news.id }`"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></a>

                            <div :id="`reverbPrev_${ news.id }`" class="col-12 no-padding collapse">
                                <a v-for="(z, index) in news.vhOld" :href="baseUrl + z.link" v-if="index>=5" class="boxVehicle">{{ z.name }}</a>
                            </div>
                        </template>
                    </div>
                </template>
            </template>
        </lazy-component>
    </li>
</template>

<style scoped=""></style>
