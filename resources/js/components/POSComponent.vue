<template>
    <div class="content">
        <div class="d-xl-none push m-0">
            <button type="button" class="btn btn-light btn-block" data-toggle="class-toggle" data-target=".js-ecom-div-cart" data-class="d-none">
                <i class="fa fa-fw fa-shopping-cart text-muted mr-1"></i> Cart (3)
            </button>
        </div>
        <div class="row push m-0">
            <div class="col-xl-6 order-xl-1">
                <div class="block js-ecom-div-cart d-none d-xl-block pos-mt pos-mb">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">
                            <i class="fa fa-fw fa-shopping-cart text-muted mr-1"></i> Shopping Cart (3)
                        </h3>
                    </div>
                    <div class="block-content cart-box">
                        <table class="table table-borderless table-hover table-vcenter">
                            <tbody>
                                <tr v-for="processing in processings" :key="processing.id">
                                    <td style="width: 60px;">
                                        <input class="form-control input-qty" type="" name="" :value="processing.qty">
                                    </td>
                                    <td>
                                        <a class="h5" href="">{{ processing.stock.product.name }}</a>
                                        <div class="font-size-sm text-muted">{{ processing.stock.sku_upc }}</div>
                                    </td>
                                    <td class="text-right">
                                        <div class="font-w600 text-success">{{ processing.stock.price | currency(currency['sign']) }}</div>
                                    </td>
                                    <td class="text-center" width="10%">
                                        <a class="text-danger" href="javascript:void(0)"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                
                            </tfoot>
                        </table>
                    </div>
                    <div class="block-content block-content-full bg-body-light text-right">
                        <table class="table table-borderless table-hover table-vcenter">
                            <tr class="bg-success-light">
                                    <td class="text-right" colspan="3">
                                        <span class="h4 font-w600">Total</span>
                                    </td>
                                    <td class="text-right">
                                        <span class="h4 font-w600 text-success">{{ total_price | currency(currency['sign']) }}</span>
                                    </td>
                                </tr>
                        </table>
                        <a class="btn btn-sm btn-primary" href="https://demo.pixelcave.com/oneui-remastered/be_pages_ecom_store_checkout.html">
                            <i class="fa fa-check mr-1"></i> Complete Checkout
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 order-xl-0">
                <h2 class="content-heading">SKU/UPC</h2>
                <div class="row">
                    <div class="col-md-12 col-xl-12">
                        <div class="block barcode">
                            <input class="form-control input-barcode" type="" name="" v-model="input_sku" @keyup="searchitems">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-xl-12">
                        <h2 class="content-heading">Results</h2>
                        <div class="block">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
    	data() {
    		return {
                currency: {},
    			processings: {},
                input_qty: null,
                total_price: 0,
                form_search: new Form({
                    sku_upc: ''
                }),
    		}
    	},
        methods: {
            load_helpers() {
                //Currency
                axios.get('/get-currency')
                    .then((response) => {
                        this.currency = response.data
                    });
            },
            searchitems:
                _.debounce(() => { //search items in items tab
                    Fire.$emit('searching');
                }, 1000),
        	load_processings() {
				axios.get('api/cart')
                    .then((response) => {
                        console.log(response.data);
                        this.processings = response.data.processing;
                        this.total_price = response.data.sum;
                    })
                    .catch((error) => {
                        console.log(error)
                    });
        	},
            store_processing() {
                axios.post('api/addCart')
                    .then((response) => {
                        console.log(response.data);
                    })
                    .catch((error) => {
                        console.log(error)
                    })
                    .then(() => {
                        console.log('im working')
                    });
            }
        },
        mounted() {
            console.log('Component mounted.');
        },
        created() {
            this.load_helpers();
            this.load_processings();

            Fire.$on('searching',() => {
                let query = this.itemsearch;
                axios.get('api/findProduct?q=' + query)
                    .then((data) => {
                        this.items = data.data
                    })
                    .catch((error) => {
                        console.log(error)
                    })
            })
        }
    }
</script>