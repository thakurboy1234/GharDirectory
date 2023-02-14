<template>
    <div>
        <div class="alert alert-info current-package">
            <p>{{ __('your_credits')}}: <strong>{{ account.credits }} {{ __('credits')}}</strong></p>
        </div>
        <div class="packages-listing">
            <div class="row flex-items-xs-middle flex-items-xs-center">
                <div style="margin: auto; width:30px;" v-if="isLoading">
                    <half-circle-spinner
                        :animation-duration="1000"
                        :size="15"
                        color="#808080"
                    />
                </div>
                <div :class="data.length === 2 ? 'col-xs-12 col-lg-4' : data.length === 3? 'col-xs-12 col-lg-4':'col-xs-12 col-lg-3'" v-for="item in data" :key="item.id" v-if="!isLoading && data.length && account">
                    <!-- <div class="card text-xs-center card__pack ">
                        <div class="card-block">
                            <h4 class="card-title">
                                {{ item.name }}
                            </h4>
                            <ul class="list-group packages-list">
                                <li class="list-group-item" v-if="item.price">{{ item.price_per_post_text }}</li>
                                <li class="list-group-item" v-if="!item.price">{{ item.number_posts_free }}</li>

                                <li class="list-group-item" v-if="item.price">{{ item.price_text_with_sale_off }}</li>
                                <li class="list-group-item" v-if="!item.price">&mdash;</li>
                            </ul>
                            <button :class="isSubscribing && currentPackageId === item.id ? 'btn btn-primary mt-2 button-loading' : 'btn btn-primary mt-2'" @click="postSubscribe(item.id)" :disabled="isSubscribing">{{ __('purchase') }}</button>
                        </div>
                    </div> -->
                    <!-- <div class="packages__cardWrap">
                        <h2> {{ item.name }}<br><small>(for property budget upto {{item.maximal_property_budget}})</small></h2>

                        <div class="ul__listing">
                            <ul>
                                <li>free {{ item.total_leads }} leads</li>
                                <li>{{item.number_of_listings }} property listing</li>
                                <li>{{ item.duration }} days duration</li>
                            </ul>
                        </div>
                        <h3>price: ₹{{ item.price }} <small v-if="item.price != 0"></small></h3>
                        <div class="buy__btn">
                            <button :class="isSubscribing && currentPackageId === item.id ? 'btn btn-primary mt-2 button-loading' : 'btn btn-primary mt-2'" @click="postSubscribe(item.id)" :disabled="isSubscribing">{{ __('buy now') }}</button>
                        </div>
                    </div> -->


                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12" style="margin-top: 30px;">
                            <div class="packages__cardWrapNew">
                                <h2> {{ item.name }}</h2>
                                <ul class="price__area">
                                    <li><p class="old_price">₹ 25900</p></li>
                                    <li><p class="new_price">₹ {{ item.price }}<br><small>exclusive of GST</small></p></li>
                                    <li><p class="save_amount">You save: ₹ 1000</p></li>
                                </ul>
                                <div class="buy__btn">
                                    <a href="#!">buy now</a>
                                </div>
                                <div class="list__detail">
                                    <ul>
                                        <li><p>{{item.number_of_listings }} Property Listings</p></li>
                                        <li><p>1 Featured Project Listing</p></li>
                                        <li><p>{{ item.duration }}  Days Validity</p></li>
                                        <li><p><b>{{ item.total_leads }} Qualified Leads</b></p></li>
                                        <li><p>Location Base Leads</p></li>
                                        <li><p>Budget Based Leads</p></li>
                                        <li><p>Min. 60% Qualified Leads</p></li>
                                        <li><p>Dedicated Executive</p></li>
                                        <li><p>Expert Photography/Videography</p></li>
                                        <li><p>Directory Expert Listing</p></li>
                                        <li><p>Suitable For Property Budget 60- 80 Lakhs<sup>*</sup></p></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import {HalfCircleSpinner} from 'epic-spinners'

    export default {
        components: {
            HalfCircleSpinner
        },

        data: function() {
            return {
                isLoading: true,
                isSubscribing: false,
                data: [],
                account: {},
                currentPackageId: null,
            };
        },

        mounted() {
            this.getData();
        },

        props: {
            url: {
                type: String,
                default: () => null,
                required: true
            },
            subscribe_url: {
                type: String,
                default: () => null,
                required: true
            },
        },

        methods: {
            getData() {
                this.data = [];
                this.isLoading = true;
                axios.get(this.url)
                    .then(res => {
                        if (res.data.error) {
                            Botble.showError(res.data.message);
                        } else {
                            this.data = res.data.data.packages;
                            this.account = res.data.data.account;
                        }
                        this.isLoading = false;
                    });
            },

            postSubscribe(id) {
                this.isSubscribing = true;
                this.currentPackageId = id;
                axios.put(this.subscribe_url, {id: id})
                    .then(res => {
                        if (res.data.error) {
                            Botble.showError(res.data.message);
                        } else {
                            if (res.data.data && res.data.data.next_page) {
                                window.location.href = res.data.data.next_page;
                            } else {
                                this.account = res.data.data;
                                Botble.showSuccess(res.data.message);
                                this.getData();
                            }
                        }
                        this.isSubscribing = false;
                    })
                    .catch(error => {
                        this.isSubscribing = false;
                        console.log(error)
                    });
            }
        }
    }
</script>
