<template>
    <div class="container">
        <div class="alert" v-if="message.text != null"
             :class="{ 'alert-success' : message.status, 'alert-danger' : !message.status}" role="alert">
            {{message.text}}
        </div>
        <div class="alert alert-danger" v-if="errorsValidate != null" v-for="error in errorsValidate" role="alert">
            <span v-for="er in error">{{er}}</span><br>
        </div>
        <div class="row justify-content-center">
            <div class="col-12">

                <form>
                    <div class="form-group">
                        <label>Name Currency</label>
                        <input type="text" class="form-control" v-model="currency">
                    </div>
                    <div class="form-group">
                        <label>Sell</label>
                        <input type="text" v-model="sell" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="formGroupExampleInput2">Buy</label>
                        <input type="text" v-model="buy" class="form-control" id="formGroupExampleInput2">
                    </div>
                    <button type="button" @click="save()" class="btn badge-primary">Save</button>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                currency: null,
                buy: null,
                errorsValidate: null,
                sell: null,
                message: {
                    status: false,
                    text: null
                }
            }
        },
        methods: {
            save: function () {
                this.message.text = null;
                this.errorsValidate = null;
                fetch("/currency", {
                    method: "POST",
                    headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'Bearer ' + this.$session.get('token')
                    },
                    body: JSON.stringify({currency: this.currency, buy: this.buy, sell: this.sell})
                }).then(res => {
                    return res.json();
                }).then(data => {
                    if(data.message){
                        this.message.status = data.message.status;
                        this.message.text = data.message.text;
                    }else if(data.errorsValidate){
                        console.log(data.errorsValidate);
                        this.errorsValidate = data.errorsValidate;
                    }

                });
            }
        }
    }
</script>

<style scoped>

</style>
