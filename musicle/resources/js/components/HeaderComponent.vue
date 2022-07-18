<template>
    <div class="container-fluid bg-dark mb-3">
        <div class="container">
            <nav class="navbar navbar-dark">
                <span class="navbar-brand mb-0 h1">Musicle</span>
                <img class="header-profile-image" :src="image_path" />
                <div class="text-light">{{ name }}</div>
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
            name: null,
            image_path: null,
        };
    },
    created: function () {
        this.get_my_profile();
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
        // プロフィール取得API
        get_my_profile() {
            axios
                .get("/api/get_my_profile")
                .then((response) => {
                    this.name = response.data.name;
                    this.image_path = response.data.image_path;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
};
</script>
<style>
.header-profile-image {
    width: 40px;
    border-radius: 5px 5px 5px 5px;
}

</style>