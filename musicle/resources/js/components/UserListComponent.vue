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
                <tr v-for="item in users" v-bind:key="item.id">
                    <th scope="row">{{ item.id }}</th>
                    <td>{{ item.name }}</td>
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
            .get("/api/user")
            .then((response) => {
                this.users = response.data;
            })
            .catch((err) => {
                console.error(err);
            });
    },
};
</script>