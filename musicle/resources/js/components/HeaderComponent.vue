<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="/home">musicle</a>
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
                    <li class="nav-item" v-if="is_login">
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
                    <li class="nav-item" v-if="is_login">
                        <!-- <a
                            class="nav-link active"
                            aria-current="page"
                            href="/home"
                            >Home</a
                        > -->
                        <router-link class="nav-link" to="/message"
                            >ダイレクトメッセージ</router-link
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
                <div v-if="is_login">
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
                </div>
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
                    <button
                        class="btn btn-sm btn-outline-secondary"
                        @click="logout"
                    >
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
            user_id: null,
            name: null,
            image_path: null,
        };
    },
    created: function () {
        // ログイン時の処理
        if (this.is_login) {
            // // プロフィール取得
            this.get_my_profile();
        }
    },
    computed: {
        is_login() {
            return this.$store.getters["auth/is_login"];
        },
    },
    watch: {
        is_login(val, old) {
            if (val) {
                // プロフィール取得
                this.get_my_profile();
            }
        },
    },
    methods: {
        // プロフィール情報初期化
        init_profile() {
            this.user_id = null;
            this.name = null;
            this.image_path = null;
        },
        // ログアウトAPI
        logout() {
            axios.get("/sanctum/csrf-cookie").then((response) => {
                axios
                    .post("/api/logout", {})
                    .then((response) => {
                        console.log(response);
                        // ログイン状態更新
                        this.$store.dispatch("auth/logout");
                        // セッションストレージ削除
                        sessionStorage.removeItem("musicle");
                        // ログイン画面に遷移
                        this.$router.push("/login");
                        // プロフィール情報を初期化
                        this.init_profile();
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
    max-height: 40px;
    border-radius: 5px 5px 5px 5px;
}
</style>
