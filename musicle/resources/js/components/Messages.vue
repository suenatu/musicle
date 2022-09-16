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
                            selected_room_data.room_no == room.room_no
                                ? 'selected'
                                : '',
                        ]"
                    >
                        <img :src="room.image_path" class="user-image" />
                        {{ room.name }} @{{ room.login_id }}
                    </li>
                </ul>
            </div>
            <div class="col-8">
                <Message
                    v-if="selected_room_data.room_no"
                    :selected_room_data="selected_room_data"
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
            selected_room_data: {
                room_no: null,
                user_id: null,
            },
        };
    },
    created: function () {
        // メッセージ一覧取得
        this.get_rooms();
    },
    mounted() {},
    methods: {
        // メッセージ一覧取得API
        get_rooms() {
            axios
                .get("/api/get_rooms")
                .then((response) => {
                    // console.log(response.data);
                    this.rooms = response.data;

                    // クエリパラメータ付きであれば該当するメッセージを表示
                    this.update_room_data(
                        this.$route.params.room_no,
                        this.get_selected_user_id(this.$route.params.room_no)
                    );
                })
                .catch((err) => {
                    console.error(err);
                });
        },
        // メッセージへ画面遷移
        push_message(room) {
            if (this.selected_room_data.room_no !== room.room_no) {
                this.$router.push({
                    name: "message",
                    params: { room_no: room.room_no },
                });
                // 選択ルームデータ更新
                this.update_room_data(
                    room.room_no,
                    this.get_selected_user_id(room.room_no)
                );
            }
        },
        // ルームNOから選択されたユーザーを選択
        get_selected_user_id(room_no) {
            for (let i = 0; i < this.rooms.length; i++) {
                if (this.rooms[i].room_no == room_no) {
                    return this.rooms[i].user_id;
                }
            }
        },
        // ルームデータを更新
        update_room_data(room_no, user_id) {
            this.selected_room_data.room_no = room_no;
            this.selected_room_data.user_id = user_id;
        },
    },
};
</script>
<style>
/* ユーザーアイコン */
.user-image {
    max-width: 50px;
    max-height: 50px;
}

.user_list {
    overflow: scroll;
    overflow-x: hidden;
}
/* リストの中黒を削除 */
.user_list li {
    list-style: none;
}
/* 選択中のリスト */
li.selected {
    background-color: #d0d0d0;
}
/* マウスオーバー */
.user_list li:hover {
    cursor: pointer;
    background-color: #d0d0d0;
}
/*　リストの罫線 */
ul.user_list li:first-child {
    border-top: 1px solid hsl(0, 0%, 75%);
    border-bottom: 1px solid hsl(0, 0%, 75%);
}
ul.user_list li + li {
    border-bottom: 1px solid hsl(0, 0%, 75%);
}
</style>
