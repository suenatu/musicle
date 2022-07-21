<template>
    <div class="container">
        <ul>
            <li v-for="(rooms, key) in rooms" :key="key">
                <router-link
                    :to="{
                        name: 'message',
                        params: { room_id: rooms.room_id },
                    }"
                    >{{ rooms.name }}</router-link
                >
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data: function () {
        return {
            rooms: [],
        };
    },
    created: function () {
        this.get_rooms();
    },
    methods: {
        // メッセージ一覧取得API
        get_rooms() {
            axios
                .get("/api/get_rooms", {})
                .then((response) => {
                    console.log(response.data);
                    this.rooms = response.data;
                })
                .catch((err) => {
                    console.error(err);
                });
        },
    },
};
</script>