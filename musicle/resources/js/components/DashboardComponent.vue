<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h3>
                    ページ一覧
                </h3>
                <ul>
                    <li>
                        <router-link to="/login">ログイン（ログインしていたら/homeにリダイレクトします。）</router-link>
                    </li>
                    <li>
                        <router-link to="/home">ホーム</router-link>
                    </li>
                    <li>
                        <router-link to="/profile">プロフィール</router-link>
                    </li>
                </ul>
                <h3>
                    データ確認用
                </h3>
                <ul>
                    <li>
                        <router-link to="/userlist">ユーザー一覧</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
        };
    },
};
</script>