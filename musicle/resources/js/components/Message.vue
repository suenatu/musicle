<template>
    <div class="content">
        <div class="header p-3">
            <img :src="get_target_image_path()" class="target_user_image" />
            {{ get_target_user_name() }} @{{ get_target_login_id() }}
        </div>
        <div class="body">
            <div class="message_body p-3" id="message_body">
                <div
                    v-for="(message, key) in messages"
                    :key="key"
                    class="message d-flex flex-row align-items-start mb-4"
                    v-bind:class="[
                        message.user.id == user_id
                            ? 'flex-row-reverse'
                            : 'flex-row',
                    ]"
                >
                    <div>{{ get_user_name(message.user.id) }}</div>
                    <img
                        :src="get_user_image(message.user.id)"
                        class="message-user-image"
                    />
                    <p
                        class="message-text p-2 mb-0"
                        v-bind:class="[
                            message.user.id == user_id
                                ? 'bg-info me-2'
                                : 'bg-warning ms-2',
                        ]"
                    >
                        {{ message.message }}
                    </p>
                </div>
            </div>
            <div class="row textarea p-3">
                <div class="col-10">
                    <textarea
                        v-model="text"
                        class="form-control input-text"
                    ></textarea>
                </div>
                <div class="col-2">
                    <button
                        @click="send_message"
                        :disabled="!textExists"
                        class="btn btn-primary send-btn"
                    >
                        送信
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const btn = document.getElementById("btn");

export default {
    props: ["selected_room_data"],
    data() {
        return {
            user_id: null,
            text: "",
            messages: [],
            user_data: [],
            is_one_room: true,
        };
    },
    computed: {
        textExists() {
            return this.text.length > 0;
        },
    },
    watch: {
        selected_room_data: {
            handler: function (val, oldVal) {
                // メッセージ取得
                this.fetch_messages();
                // ユーザーデータ取得
                this.getUsersData();
            },
            deep: true,
        },
    },
    mounted() {
        // メッセージ取得
        this.fetch_messages();
        // ユーザーデータ取得
        this.getUsersData();
        // メッセージ受信
        Echo.private("message").listen("MessageSent", (e) => {
            this.messages.push({
                message: e.message.message,
                user: e.user,
            });
            // ルーム一覧再取得
            this.$emit("get_rooms");
        });

        // 画面下にスクロール
        this.scroll_to_buttom();
    },
    methods: {
        // メッセージ一覧取得API
        fetch_messages() {
            axios
                .get("/fetch_messages/" + this.selected_room_data.room_no)
                .then((response) => {
                    this.user_id = response.data.user_id;
                    this.messages = response.data.messages;

                    // 画面下にスクロール
                    this.$nextTick(function () {
                        this.scroll_to_buttom();
                    });
                });
        },
        // メッセージ送信API
        send_message(message) {
            axios
                .post("/send_messages", {
                    room_no: this.selected_room_data.room_no,
                    message: this.text,
                })
                .then((response) => {
                    this.text = "";
                    // ルーム一覧再取得
                    this.$emit("get_rooms");
                    // 画面下にスクロール
                    this.$nextTick(function () {
                        this.scroll_to_buttom();
                    });
                });
        },
        // ユーザーデータ取得API
        getUsersData() {
            axios
                .get(
                    "/api/get_user_data_in_message/" +
                        this.selected_room_data.room_no
                )
                .then((response) => {
                    this.user_data = response.data.map((user) => user);
                    console.log(response.data);
                });
        },

        // ユーザーネーム取得
        get_user_name(user_id) {
            for (let i = 0; i < this.user_data.length; i++) {
                if (this.user_data[i].id == user_id) {
                    return this.user_data[i].name;
                }
            }
        },
        // ユーザーイメージ取得
        get_user_image(user_id) {
            for (let i = 0; i < this.user_data.length; i++) {
                if (this.user_data[i].id == user_id) {
                    return this.user_data[i].image_path;
                }
            }
        },
        // ユーザーログインID取得
        get_user_login_id(user_id) {
            for (let i = 0; i < this.user_data.length; i++) {
                if (this.user_data[i].id == user_id) {
                    return this.user_data[i].login_id;
                }
            }
        },
        // 相手のユーザー名取得
        get_target_user_name() {
            for (let i = 0; i < this.user_data.length; i++) {
                if (this.user_data[i].id == this.selected_room_data.user_id) {
                    return this.user_data[i].name;
                }
            }
        },
        // 相手のログインID取得
        get_target_login_id() {
            for (let i = 0; i < this.user_data.length; i++) {
                if (this.user_data[i].id == this.selected_room_data.user_id) {
                    return this.user_data[i].login_id;
                }
            }
        },
        // 相手の画像取得
        get_target_image_path() {
            for (let i = 0; i < this.user_data.length; i++) {
                if (this.user_data[i].id == this.selected_room_data.user_id) {
                    return this.user_data[i].image_path;
                }
            }
        },
        // 画面下にスクロール
        scroll_to_buttom() {
            console.log("scroll_to_buttom");
            // スクロールを画面下に移動
            const message_body = document.getElementById("message_body");
            // スクロールバーの位置をリストの最下部に設定
            message_body.scrollTo(0, message_body.scrollHeight);
        },
    },
};
</script>
<style>
.content {
    width: 100%;
    /* border-left: solid 1px; */
    /* max-height: 100vh; */
}

.header {
    text-align: center;
    border-top: 1px solid hsl(0, 0%, 75%);
    border-bottom: 1px solid hsl(0, 0%, 75%);
}

.message_body {
    overflow: scroll;
    overflow-x: hidden;
    height: 600px;
}

.footer {
    background-color: #89c7de;
    position: absolute;
    bottom: 0;
}

.textarea {
    width: 100%;
    border-top: 1px solid hsl(0, 0%, 75%);
    border-bottom: 1px solid hsl(0, 0%, 75%);
}
.message-icon {
    width: 48px;
    height: 48px;
    text-align: center;
    line-height: 48px;
}

.message-text {
    display: inline-block;
    max-width: 70%;
    border-radius: 0.3rem;
}
.input-text {
    width: 100%;
    height: 100%;
}
.send-btn {
    width: 100%;
    height: 100%;
}

.target_user_image {
    max-width: 40px;
    max-height: 40px;
}

.message-user-image {
    max-width: 40px;
    max-height: 40px;
}
</style>