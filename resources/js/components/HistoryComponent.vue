<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row">
                    <div class="col-4">
                        <div class="list-group" id="list-tab" role="tablist">
                            <a class="list-group-item list-group-item-action list-group-item-dark" :id="currency.id" data-toggle="list" href="#list-home" role="tab" aria-controls="home" v-for="currency in currencies">{{currency.currency + ' Buy: ' + currency.buy +' Sell: '+ currency.sell}}</a>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="tab-content" id="nav-tabContent">
                            <div class="tab-pane fade show" id="list-home" role="tabpanel" :aria-labelledby="currency.id" v-for="currency in currencies">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Buy</th>
                                        <th scope="col">Sell</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="history in currency.history_currencies">
                                        <td>{{history.id}}</td>
                                        <th>{{history.buy}}</th>
                                        <td>{{history.sell}}</td>
                                        <td>{{history.created_at}}</td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            this.history();
        },
        data: function () {
            return {
                currencies: [],
            }
        },
        methods: {
            history: function () {
                fetch('/history')
                    .then((responce) => {
                        return responce.json();
                    }).then((dataJson) => {
                    this.currencies = dataJson;
                    console.log(dataJson);
                });
            }
        }

    }
</script>

