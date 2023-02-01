<template>
    <div>
        <div class="form-group mb-3" v-for="(item, index) in items">
            <div class="row">
                <div class="col-md-3 col-sm-5">
                    <div class="form-group mb-3">
                        <div class="ui-select-wrapper">
                            <select :name="'facilities[' + (item.id ? item.id : 0) + '][id]'" v-model="item.id" class="ui-select">
                                <option value="">{{ __('select_facility')}}</option>
                                <option :value="facility.id" @change="removeSelectedItem(facility.id)" v-for="facility in facilities">{{ facility.name }}</option>
                            </select>
                            <svg class="svg-next-icon svg-next-icon-size-16">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#select-chevron"></use>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-5">
                    <div class="form-group mb-3">
                        <input type="number" :name="'facilities[' + (item.id ? item.id : 0) + '][distance]'" v-model="item.distance" class="form-control"
                               :placeholder="__('distance')">
                    </div>
                </div>
                <div class="col-md-3 col-sm-2">
                    <div class="form-group mb-1">
                        <div class="ui-select-wrapper">
                        <select :name="'facilities[' + (item.id ? item.id : 0) + '][distance_unit]'"   v-model="item.distance_unit" class="ui-select">
                            <option   value=" km" >Km</option>
                            <option  value=" mtr">Mtr</option>
                        </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-2">
                    <button class="btn btn-warning" type="button" @click="deleteRow(index)"><i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="form-group mb-3">
            <button class="btn btn-info" type="button" @click="addRow">{{ __('add_new') }}</button>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {

        return {
            items: [{id: '', distance: '',distance_unit:''}]
        };
    },
    mounted() {
        if (this.selected_facilities.length) {
            this.items = [];
            for (const item of this.selected_facilities) {
            var unit='';
            var dist='';
            if(item.distance.search(' km') != -1){
                dist =  item.distance.replace(' km','')
                unit=' km';
            }else if(item.distance.search(' mtr') != -1){
                dist =  item.distance.replace(' mtr','')
                unit=' mtr';
            }else{
                dist =  item.distance;
                unit='';
            }
       
            this.items.push({id: item.id, distance: dist,distance_unit:unit});
            }
        }
    },
    props: {
        selected_facilities: {
            type: Array,
            default: () => [],
        },
        facilities: {
            type: Array,
            default: () => [],
        }
    },

    methods: {
        addRow: function () {
            this.items.push({id: '', distance: '',distance_unit:' km'});
        },
        deleteRow: function (index) {
            this.items.splice(index, 1);
        },
        removeSelectedItem: function () {
            for (let i = 0; i < this.facilities.length; i++) {
                for(const item of this.items) {
                    if (item.id === this.facilities[i].id) {

                        this.facilities.slice(i, 1);
                    }
                }
            }
        }
    }
}
</script>
