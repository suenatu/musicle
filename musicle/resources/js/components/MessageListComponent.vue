<template>
    <div class="container">
        <div class="row">
            <div class="col-4">
                <ul class="user_list">
                    <li
                        v-for="(room, key) in rooms"
                        :key="key"
                        v-on:click="push_message(room)"
                        v-bind:class="[
                            selected_room_no == room.room_no ? 'selected' : '',
                        ]"
                    >
                        <img :src="room.image_path" class="user-image" />
                        {{ room.name }} @{{ room.login_id }}
                    </li>
                </ul>
            </div>
            <div class="col-8">
                <Message
                    v-if="selected_room_no"
                    :room_no="selected_room_no"
                    :selected_user_id="selected_user_id"
                    @get_rooms="get_rooms"
                ></Message>
            </div>
        </div>
    </div>
</template>

<script>
import Message from "./Message";
export default {
    components: {
        Message: Message,
    },
    data: function () {
        return {
            rooms: [],
            selected_room_no: "",
            selected_user_id: null,
        };
    },
    created: function () {
        // メッセージ一覧取得
        this.get_rooms();
        this.selected_room_no = this.$route.params.room_no;
    },
    methods: {
        // メッセージ一覧取得API
        get_rooms() {
            console.log('get_rooms');
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
        // メッセージへ画面遷移
        push_message(room) {
            if (this.selected_room_no !== room.room_no) {
                this.selected_room_no = room.room_no;
                this.selected_user_id = room.user_id;
                this.$router.push({
                    name: "message",
                    params: { room_no: room.room_no },
                });
            }
        },
    },
};
</script>
<style>
/** ユーザーアイコン */
.user-image {
    max-width: 50px;
    max-height: 50px;
}

/** リストの中黒を削除 */
.user_list li {
    list-style: none;
}

/** 選択中のリスト */
li.selected {
    background-color: #d0d0d0;
}

/* マウスオーバーでの背景色の設定 ここから */
.user_list li:hover {
    cursor: pointer;
    background-color: #d0d0d0;
}

/**　リストの罫線 */
ul.user_list li:first-child {
    border-top: 1px solid hsl(0, 0%, 75%);
    border-bottom: 1px solid hsl(0, 0%, 75%);
}
ul.user_list li + li {
    border-bottom: 1px solid hsl(0, 0%, 75%);
}
</style>
