<template>
    <div class="content">
        <div class="header p-3">
            {{ get_one_user_name() }} @{{ get_one_login_id() }}
        </div>
        <div class="body p-3">
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
                    class="header-profile-image"
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
        <div class="footer p-3">
            <div class="row">
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
    },
    methods: {
        // メッセージ一覧取得API
        fetch_messages() {
            axios
                .get("/fetch_messages/" + this.selected_room_data.room_no)
                .then((response) => {
                    console.log(response.data);
                    this.user_id = response.data.user_id;
                    this.messages = response.data.messages;
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
                });
            // ルーム一覧再取得
            this.$emit("get_rooms");
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

        get_one_user_name() {
            for (let i = 0; i < this.user_data.length; i++) {
                if (this.user_data[i].id == this.selected_room_data.user_id) {
                    return this.user_data[i].name;
                }
            }
        },
        get_one_login_id() {
            for (let i = 0; i < this.user_data.length; i++) {
                if (this.user_data[i].id == this.selected_room_data.user_id) {
                    return this.user_data[i].login_id;
                }
            }
        },
    },
};
</script>
<style>
.content {
    width: 100%;
}

.header {
    text-align: center;
}

.body {
    height: 600px;
    overflow: scroll;
}

.footer {
    background-color: #89c7de;
    /* color: #fff; */
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
</style>