<script>
    import funcs from "../functions";

    export default {
        props: ['id'],
        data: function () {
            return {
                baseUrl,
                limit:    5,
                ready:    false,
                loading:  false,
                featured: []
            }
        },

        methods: {
            getFeatured: function () {
                this.ready   = false;
                this.loading = true;
                let url      = baseUrl + "api/site/get-news-featured/" + this.id;

                axios.get(url).then(resp => {
                    console.log(resp.data.highlight);
                    this.ready    = true;
                    this.loading  = false;
                    this.featured = resp.data.highlight;
                    this.getFeaturedVehicles(this.featured.ref);
                }).catch(error => {
                    console.log('Error:')
                    console.log(error);
                });
            },

            getFeaturedVehicles: function (ref) {
                let refJson  = funcs.Base64.decode(ref),
                    refData  = JSON.parse(refJson);

                this.loading = true;
                let url      = baseUrl + "api/site/get-news-vehicles";

                axios.get(url, {params: { ref }}).then(resp => {
                    let data            = resp.data.vehicles;
                    this.loading        = false;
                    this.featured.vhNew = data.new;
                    this.featured.vhOld = data.old;
                }).catch(error => {
                    console.log('Error:')
                    console.log(error);
                });
            },

            getHideItems: function (items) {
                return items; //.slice(Math.max(items.length - this.limit, 1));
            }
        },

        mounted: function () {
            this.getFeatured();
        }
    }
</script>

<template>
    <div id="featured" class="noDivision">
        <template v-if="ready===true">
            <a :href="featured.link">
                <div class="thumb">
                    <img :src="featured.image" class="responsive" :alt="featured.caption_image">
                    <small>{{ featured.caption_image }}</small>
                </div>

                <h1>{{ featured.title }}</h1>
                <h4>Publicado em {{ featured.date }}</h4>
                <div class="description" v-html="featured.text"></div>
            </a>

            <template v-if="loading">
                <div class="viewLine loading clearfix">
                    <img :src="baseUrl + 'assets/img/loading_vehicles.svg'" /> <span>Carregando veículos</span>
                </div>
            </template>

            <template v-else>
                <div class="viewLine clearfix">
                    <template v-if="featured.vhNew.length<=limit">
                        <a v-for="i in featured.vhNew.length" :href="baseUrl + featured.vhNew[(i-1)].link" class="boxVehicle">{{ featured.vhNew[(i-1)].name }}</a>
                    </template>

                    <template v-if="featured.vhNew.length>limit">
                        <a v-for="x in limit" :href="baseUrl + featured.vhNew[x-1].link" class="boxVehicle">{{ featured.vhNew[x-1].name }}</a>
                        <a href="javascript:;" class="boxVehicle viewMore collapsed" data-toggle="collapse" :data-target="`#reverb_${ featured.id }`"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></a>

                        <div :id="`reverb_${ featured.id }`" class="col-12 no-padding collapse">
                            <a v-for="(z, index) in featured.vhNew" :href="baseUrl + z.link" v-if="index>=5" class="boxVehicle">{{ z.name }}</a>
                        </div>
                    </template>
                </div>

                <template v-if="featured.vhOld.length>0">
                    <div class="viewLine previous clearfix">
                        <div class="title">Anteriores:</div>
                        <template v-if="featured.vhOld.length<=limit">
                            <a v-for="i in featured.vhOld.length" :href="baseUrl + featured.vhOld[(i-1)].link" class="boxVehicle">{{ featured.vhOld[(i-1)].name }}</a>
                        </template>

                        <template v-if="featured.vhOld.length>limit">
                            <a v-for="x in limit" :href="baseUrl + featured.vhOld[x-1].link" class="boxVehicle">{{ featured.vhOld[x-1].name }}</a>
                            <a href="javascript:;" class="boxVehicle viewMorePre collapsed" data-toggle="collapse" :data-target="`#reverbPrev_${ featured.id }`"><i class="fa fa-plus"></i><i class="fa fa-minus"></i></a>

                            <div :id="`reverbPrev_${ featured.id }`" class="col-12 no-padding collapse">
                                <a v-for="(z, index) in featured.vhOld" :href="baseUrl + z.link"  v-if="index>=5" class="boxVehicle">{{ z.name }}</a>
                            </div>
                        </template>
                    </div>
                </template>
            </template>
        </template>

        <template v-else>
            <div class="loading">
                <div class="thumb">
                    <img :src="baseUrl + 'assets/img/no-image-news.jpg'" class="responsive">
                    <small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</small>
                </div>

                <h1>&nbsp;</h1>
                <h4>&nbsp;</h4>
                <div class="description">
                    <span>&nbsp;</span>
                    <span>&nbsp;</span>
                </div>
            </div>
        </template>
    </div>
</template>

<style scoped=""></style>
