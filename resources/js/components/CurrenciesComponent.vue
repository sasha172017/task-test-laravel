<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="alert" v-if="messageDelete != null" role="alert">
                    {{messageDelete}}
                </div>

                <table class="table table-dark">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Currency</th>
                        <th scope="col">Buy</th>
                        <th scope="col">sell</th>
                        <th scope="col">edit</th>
                        <th scope="col">delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="currency in currencies">
                        <th scope="row">{{currency.id}}</th>
                        <td><a href="#" class="text-white" @click="show(currency.id)">{{currency.currency}}</a></td>
                        <td>{{currency.buy}}</td>
                        <td>{{currency.sell}}</td>
                        <td><a class="text-white" v-if="$parent.authentication" @click="edit(currency.id)"
                               href="#">edit</a></td>
                        <td><a class="text-white" v-if="$parent.authentication" @click="remove(currency.id)" href="#">delete</a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <nav aria-label="...">
            <ul class="pagination">
                <li class="page-item" :class="{ 'disabled' : !prevPageUrl}">
                    <a class="page-link" href="#" @click="index(prevPageUrl)" tabindex="-1">Last</a>
                </li>
                <li class="page-item" :class="{ 'disabled' : !nextPageUrl}">
                    <a class="page-link" @click="index(nextPageUrl)" href="#">Next</a>
                </li>
            </ul>
        </nav>

        <div class="modal" tabindex="-1" id="myModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{modalCurrency}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="alert" v-if="message.text != null"
                             :class="{ 'alert-success' : message.status, 'alert-danger' : !message.status}"
                             role="alert">
                            {{message.text}}
                        </div>
                        <div class="alert alert-danger" v-if="errorsValidate != null" v-for="error in errorsValidate"
                             role="alert">
                            <span v-for="er in error">{{er}}</span><br>
                        </div>
                        <div class="form-group">
                            <label>Buy</label>
                            <input type="text" class="form-control" v-model="modalBuy" placeholder="Example input">
                        </div>
                        <div class="form-group">
                            <label>Sell</label>
                            <input type="text" class="form-control" v-model="modalSell">
                        </div>
                        <input type="hidden" class="form-control" v-model="modalId">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" @click="save()">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal" tabindex="-1" id="showModal" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">{{showCurrency}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Currency: {{showCurrency}}</p>
                        <p>Buy: {{showBuy}}</p>
                        <p>Sell: {{showSell}}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        mounted() {
            this.index('/currencies');
        },
        data: function () {
            return {
                currencies: [],
                prevPageUrl: null,
                nextPageUrl: null,
                modalCurrency: null,
                modalBuy: null,
                modalId: null,
                showCurrency: null,
                showBuy: null,
                showSell: null,
                messageDelete: null,
                modalSell: null,
                errorsValidate: null,
                message: {
                    status: false,
                    text: null
                }
            }
        },
        methods: {
            index: function (url) {
                fetch(url)
                    .then((responce) => {
                        return responce.json();
                    }).then((dataJson) => {
                    this.currencies = dataJson.data;
                    this.prevPageUrl = dataJson.prev_page_url;
                    this.nextPageUrl = dataJson.next_page_url;
                });
            },
            show: function (id) {
                fetch('/currency/' + id)
                    .then((responce) => {
                        return responce.json();
                    }).then((dataJson) => {
                    this.showBuy = dataJson.buy;
                    this.showSell = dataJson.sell;
                    this.showCurrency = dataJson.currency;
                    $('#showModal').modal('show');
                });
            },
            edit(id) {
                fetch('/currency/' + id)
                    .then((responce) => {
                        return responce.json();
                    }).then((dataJson) => {
                    this.modalCurrency = dataJson.currency;
                    this.modalBuy = dataJson.buy;
                    this.modalId = dataJson.id;
                    this.modalSell = dataJson.sell;
                });
                $('#myModal').modal('show');
            },
            save: function () {
                this.message.text = null;
                this.errorsValidate = null;
                fetch("/currency/" + this.modalId, {
                    method: "PUT",
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + this.$session.get('token')
                    },
                    body: JSON.stringify({buy: this.modalBuy, sell: this.modalSell})
                }).then(res => {
                    return res.json();
                }).then(data => {
                    if (data.message) {
                        this.message.status = data.message.status;
                        this.message.text = data.message.text;
                        if (data.message.status == true) {
                            this.currencies.forEach((d) => {
                                if (d.id == this.modalId) {
                                    d.buy = this.modalBuy;
                                    d.sell = this.modalSell;
                                }
                                $('#myModal').modal('hide');
                            });
                        }
                    } else if (data.errorsValidate) {
                        console.log(data.errorsValidate);
                        this.errorsValidate = data.errorsValidate;
                    }
                });
            },
            remove(id) {
                fetch("/currency/" + id, {
                    method: "DELETE",
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + this.$session.get('token')
                    },
                }).then(res => {
                    return res.json();
                }).then(data => {
                    if (data.messageDelete) {
                        this.index('/currencies');
                    }
                });
            }
        }

    }
</script>

<style scoped>

</style>
