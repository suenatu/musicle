<template>
    <div class="container">
        <h1>ユーザーの一覧</h1>
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">ユーザー名</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users" v-bind:key="user.id">
                    <th scope="row">{{ user.id }}</th>
                    <td><router-link :to="{name: 'profile', params: {id: user.id}}">{{ user.name }}</router-link></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            users: [],
        };
    },
    created: function () {
        axios
            .get("/api/userlist")
            .then((response) => {
                this.users = response.data;
            })
            .catch((err) => {
                console.error(err);
            });
    },
};
</script>