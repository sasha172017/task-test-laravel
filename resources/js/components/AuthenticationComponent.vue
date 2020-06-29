<template>
    <div class="container">
        <div class="alert" v-if="message.text != null" :class="{ 'alert-success' : message.status, 'alert-danger' : !message.status}" role="alert">
            {{message.text}}
        </div>
        <div class="row justify-content-center">
            <div class="col-12">
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input v-model="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email"></div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input v-model="password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                    </div>
                    <button type="button" @click="logIn()" class="btn btn-primary">Log In</button>
                </form>
            </div>
        </div>
    </div>
</template>


<script>
    export default {
        mounted() {

        },
        data: function () {
            return {
                email: null,
                password: null,
                message: {
                    status: false,
                    text: null
                }
            }
        },
        methods: {
            logIn: function () {
                this.message.text = null;
                fetch("/authentication", {
                    method: "POST",
                    body: JSON.stringify({email: this.email, password: this.password})
                }).then(res => {
                    return res.json();
                }).then(data => {
                    this.message.status = data.message.status;
                    this.message.text = data.message.text;
                    if(data.token){
                        this.$session.set('token', data.token);
                        this.$parent.isAuth();

                    }
                });
            }
        }

    }
</script>

<style scoped>

</style>
