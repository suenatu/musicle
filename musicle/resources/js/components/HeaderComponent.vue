<template>
    <div class="container-fluid bg-dark mb-3">
        <div class="container">
            <nav class="navbar navbar-dark">
                <span class="navbar-brand mb-0 h1">Musicle</span>
                <div v-if="is_login">
                    <button type="button" class="btn btn-light" @click="logout">
                        ログアウト
                    </button>
                </div>
            </nav>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            is_login: localStorage.getItem("auth"),
        };
    },
    methods: {
        logout() {
            axios.get("/sanctum/csrf-cookie").then((response) => {
                axios
                    .post("/api/logout", {})
                    .then((response) => {
                        console.log(response);
                        localStorage.removeItem("auth");
                        this.is_login = false;
                        this.$router.push("/login");
                    })
                    .catch((error) => {
                        this.errors = error.response.data.errors;
                    });
            });
        },
    },
};
</script>