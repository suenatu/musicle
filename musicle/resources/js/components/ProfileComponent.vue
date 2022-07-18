<template>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <img class="profile-image" :src="image_path" />
                <div class="profile-name">{{ name }}</div>
                <div class="row">
                    <div class="col-6">フォロー: {{ follow_count }}</div>
                    <div class="col-6">フォロワー: {{ follower_count }}</div>
                </div>
                <button
                    class="btn btn-primary"
                    type="button"
                    id="follow"
                    v-on:click="follow"
                >
                    フォローする
                </button>
                <button class="btn btn-secondary" type="button" id="remove">
                    フォロー解除する
                </button>
            </div>
            <div class="col-9"></div>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            is_follow: false,
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
    mounted: function () {},
    methods: {
        follow(user_id) {
            console.log("フォローAPI");
            axios
                .post("/api/follow")
                .then((response) => {})
                .catch((err) => {
                    console.error(err);
                });
        },
        // プロフィール取得API
        get_profile() {
            axios
                .get("/api/get_profile/" + this.$route.params.login_id)
                .then((response) => {
                    this.name = response.data.name;
                    this.image_path = response.data.image_path;
                    this.follow_count = response.data.follow_count;
                    this.follower_count = response.data.follower_count;
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