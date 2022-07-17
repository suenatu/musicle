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
        <div class="form-group">
            <label>
                <input type="checkbox" v-model="remember" /> 次回から省略
            </label>
        </div>
        <button type="button" class="btn btn-dark btn-block" @click="login">
            ログイン
        </button>
    </div>
</template>

<script>
export default {
    data: function () {
        return {};
    },
    methods: {
        login: function () {
            var url = "/api/login";
            var params = {
                email: this.email,
                password: this.password,
                remember: this.remember,
            };
            axios
                .post(url, params)
                .then(function (response) {
                    // ログイン成功
                })
                .catch(function (error) {
                    // ログイン失敗
                });
        },
    },
};
</script>