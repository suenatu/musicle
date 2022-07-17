<template>
    <div class="container">
        <div class="row">
            <div class="col-4"></div>
            <div class="col-4">あ</div>
            <div class="col-4">あ</div>
        </div>
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