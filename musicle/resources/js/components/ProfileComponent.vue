<template>
    <div class="container">
        <div v-if="is_user" class="row">
            <div class="col-3">
                <img class="profile-image" :src="image_path" />
                <div class="profile-name">{{ name }}</div>
                <div class="row">
                    <div class="col-6">フォロー: {{ follow_count }}</div>
                    <div class="col-6">フォロワー: {{ follower_count }}</div>
                </div>
                <div v-if="is_login">
                    <div v-if="is_follow">
                        <button
                            class="btn btn-secondary"
                            type="button"
                            id="remove"
                            v-on:click="remove"
                        >
                            フォロー解除する
                        </button>
                    </div>
                    <div v-if="!is_follow">
                        <button
                            class="btn btn-primary"
                            type="button"
                            id="follow"
                            v-on:click="follow"
                        >
                            フォローする
                        </button>
                    </div>
                        <button
                            class="btn btn-primary"
                            type="button"
                            id="direct_message"
                        >
                            ダイレクトメッセージ
                        </button>
                </div>
            </div>
            <div class="col-9"></div>
        </div>
        <div v-else class="row">
            <p>ユーザーが見つかりません。</p>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            is_user: true,
            user_id: null,
            is_follow: null,
            name: null,
            image_path: null,
            follow_count: 0,
            follower_count: 0,
        };
    },
    created: function () {
        // プロフィール取得API
        this.get_profile();
    },
    computed: {
        is_login() {
            return this.$store.getters["auth/is_login"];
        },
    },
    mounted: function () {},
    methods: {
        // フォローAPI
        follow() {
            this.is_follow = true;
            axios
                .post("/api/follow", {
                    user_id: this.user_id
                })
                .then((response) => {
                    this.follower_count = response.data.follower_count;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        //　リムーブAPI
        remove() {
            if (!confirm('フォローを解除しますか？')) {
                return;
            }
            this.is_follow = false;
            axios
                .post("/api/remove", {
                    user_id: this.user_id
                })
                .then((response) => {
                    this.follower_count = response.data.follower_count;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        // プロフィール取得API
        get_profile() {
            axios
                .get("/api/get_profile/" + this.$route.params.login_id)
                .then((response) => {
                    if (response.data.is_user) {
                        this.is_user = response.data.is_user;
                        this.user_id = response.data.user_id;
                        this.name = response.data.name;
                        this.image_path = response.data.image_path;
                        this.follow_count = response.data.follow_count;
                        this.follower_count = response.data.follower_count;
                        this.is_follow = response.data.is_follow;
                    } else {
                        this.is_user = response.data.is_user;
                    }
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        //　フォロー状態取得API
        get_follow_status() {
            axios
                .get("/api/get_is_follow")
                .then((response) => {})
                .catch((err) => {
                    console.error(err);
                });
        },
    },
};
</script>
<style>
.profile-image {
    width: 100%;
    border-radius: 10px 10px 10px 10px;
}

.profile-name {
    text-align: center;
    font-size: 30px;
}
</style>