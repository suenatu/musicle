<template>
    <div class="container">
        <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" v-model="email" />
        </div>
        <div class="form-group">
            <label>パスワード</label>
            <input type="password" class="form-control" v-model="password" />
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
                        localStorage.setItem("auth", "ture");
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
