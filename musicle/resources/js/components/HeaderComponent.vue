<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Musicle</a>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <router-link class="nav-link" to="/"
                            >ダッシュボード</router-link
                        >
                    </li>
                    <li class="nav-item">
                        <!-- <a
                            class="nav-link active"
                            aria-current="page"
                            href="/home"
                            >Home</a
                        > -->
                        <router-link class="nav-link" to="/home"
                            >ホーム</router-link
                        >
                    </li>
                    <!-- <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            id="navbarDropdown"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            Dropdown
                        </a>
                        <ul
                            class="dropdown-menu"
                            aria-labelledby="navbarDropdown"
                        >
                            <li>
                                <a class="dropdown-item" href="#">Action</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#"
                                    >Another action</a
                                >
                            </li>
                            <li><hr class="dropdown-divider" /></li>
                            <li>
                                <a class="dropdown-item" href="#"
                                    >Something else here</a
                                >
                            </li>
                        </ul>
                    </li> -->
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <router-link to="/myprofile">
                            <img
                                :src="image_path"
                                class="header-profile-image"
                            />
                        </router-link>
                        <!-- <a href="/myprofile">
                        <img class="header-profile-image" :src="image_path" />
                        </a> -->
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/myprofile">{{
                            name
                        }}</router-link>
                    </li>
                </ul>
                <!-- <form class="d-flex">
                    <input
                        class="form-control me-2"
                        type="search"
                        placeholder="Search"
                        aria-label="Search"
                    />
                    <button class="btn btn-outline-success" type="submit">
                        Search
                    </button>
                </form> -->
                <div v-if="is_login">
                    <button class="btn btn-sm btn-outline-secondary" @click="logout">
                        ログアウト
                    </button>
                </div>
                <div v-else>
                    <button class="btn btn-sm btn-secondary" @click="logout">
                        ログイン
                    </button>
                </div>
            </div>
        </div>
    </nav>
</template>

<script>
export default {
    data() {
        return {
            is_login: localStorage.getItem("auth"),
            user_id: null,
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
                    this.user_id = response.data.user_id;
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