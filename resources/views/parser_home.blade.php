@extends('layouts.app2')

@section('content')
    <el-container  :style="{ height: window.height + 'px' }">
        <el-aside width="300px">
            {{--Aside--}}
            <div class="search-wrapper">
                <el-form :label-position="searchForm.labelPosition" label-width="100px" :model="searchForm">
                    <el-form-item label="Поиск">
                        <el-input v-model="searchForm.name" @change="getItems()" clearable></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="getItems()">Искать</el-button>
                    </el-form-item>
                </el-form>
            </div>
        </el-aside>
        <el-container>
            <el-header>
                {{--Header--}}
                <el-menu  class="el-menu-demo" mode="horizontal">
                    <el-menu-item index="1"><a href="{{URL::to('/')}}">Home</a></el-menu-item>
                    <el-menu-item index="2"><a href="{{URL::to('/import')}}">Import</a></el-menu-item>
                </el-menu>
            </el-header>
            <el-main>
                <div  class="products">
                    <template>
                        <el-table
                                :data="products"
                                style="width: 100%">
                            <el-table-column
                                    label="Sku"
                                    width="100">
                                <template slot-scope="scope">
                                        @{{ scope.row.raw_id }}
                                </template>
                            </el-table-column>
                            <el-table-column
                                    label="Name"
                                    width="350">
                            <template slot-scope="scope">
                                <a :href="'/id/' + scope.row.id" target="_blank">
                                    @{{ scope.row.name }}
                                </a>
                            </template>
                            </el-table-column>
                            <el-table-column
                                    label="Category"
                                    width="350">
                                <template slot-scope="scope">
                                    @{{ scope.row. cat_name }}
                                </template>
                            </el-table-column>

                            <el-table-column
                                    label="Price"
                                    width="">
                                <template slot-scope="scope">
                                        @{{ scope.row.price }}
                                </template>
                            </el-table-column>

                        </el-table>
                    </template>
                </div>
            </el-main>
            <el-footer>
                {{--Footer--}}
            </el-footer>
        </el-container>
    </el-container>
    </div>
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // bootstrap the demo
        var app = new Vue({
            el: '#app',
            data: {
                defaultActive:1,
                activeIndex: 1,
                products: [],
                window: {
                    width: 0,
                    height: 0
                },
                searchForm: {
                    labelPosition: 'top',
                    name: '',
                    region: '',
                    type: ''
                },
                hello: 'im vue',
            },
            methods: {
                init: function () {
                    this.getItems();
                },
                showProduct: function () {
                   console.log(12);
                },
                getItems: function () {

                    var name = '';

                    if(this.searchForm.name !== undefined){
                        name = this.searchForm.name;
                    }

                    axios.post('/items/get', {
                        name: name
                    })
                        .then(function (response) {
                            console.log(response.data);
                            app.products = response.data;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                handleResize() {
                    this.window.width = window.innerWidth;
                    this.window.height = window.innerHeight;
                }
            },
            mounted() {

            },
            created() {
                window.addEventListener('resize', this.handleResize);
                this.handleResize();
                this.init();
            },
            destroyed() {
                window.removeEventListener('resize', this.handleResize)
            }
        });


    </script>

@endsection