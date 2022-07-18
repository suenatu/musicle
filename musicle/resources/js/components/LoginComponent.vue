<template>
    <div class="container">
        <form @submit.prevent="login">
            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input
                    id="email"
                    type="text"
                    class="form-control"
                    v-model="email"
                />
            </div>
            <div class="form-group mb-3">
                <label for="password">パスワード</label>
                <input
                    id="password"
                    type="password"
                    class="form-control"
                    v-model="password"
                />
            </div>
            <p v-if="errors" class="error">{{ errors.message }}</p>
            <button type="submit" class="btn btn-dark">ログイン</button>
        </form>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            email: null,
            password: null,
            errors: {},
        };
    },
    created: function () {},
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
                        this.$store.dispatch("auth/login");
                        this.$router.push("/home");
                    })
                    .catch((error) => {
                        this.errors = error.response.data;
                        this.errors = { message: "ログインに失敗しました。" };
                    });
            });
        },
    },
};
</script>
