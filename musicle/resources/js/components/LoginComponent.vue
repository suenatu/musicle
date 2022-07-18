<template>
    <div class="container">
        <div class="form-group mb-3">
            <label for="email">Email</label>
            <input id="email" type="text" class="form-control" v-model="email" />
        </div>
        <div class="form-group mb-3">
            <label for="password">パスワード</label>
            <input id="password" type="password" class="form-control" v-model="password" />
        </div>
        <button type="button" class="btn btn-dark" @click="login">
            ログイン
        </button>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            email: null,
            password: null,
        };
    },
    created: function () {
    },
    methods: {
        login() {
            axios.get("/sanctum/csrf-cookie").then((response) => {
                axios
                    .post("/api/login", {
                        email: this.email,
                        password: this.password,
                    })
                    .then((response) => {
                        console.log(response);
                        this.$store.dispatch('auth/login');
                        this.$router.push("/home");
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors;
                    });
            });
        },
    },
};
</script>
