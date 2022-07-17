<template>
    <div class="container">
        <div class="row">
            <div class="col-3">
                <img
                    class="profile-image"
                    src="https://ton-log.com/wp-content/uploads/2018/11/s512_f_object_112_0bg.png"
                />
                <div class="profile-name">プロフィール名</div>
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
        };
    },
    created: function () {
        // プロフィール取得API
        axios
            .get("/api/get_profile")
            .then((response) => {})
            .catch((err) => {
                console.error(err);
            });
        //　フォロー状態取得API
        axios
            .get("/api/get_is_follow")
            .then((response) => {})
            .catch((err) => {
                console.error(err);
            });
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