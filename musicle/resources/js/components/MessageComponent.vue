<template>
    <div class="container">
        <div class="row">
            <div class="chat bg-light p-4">
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
                    <!-- <div
                    class="
                        message-icon
                        rounded-circle
                        bg-secondary
                        text-white
                        fs-3
                    "
                >
                    <i class="fas fa-user"></i>
                </div> -->
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
                <textarea v-model="text" class="input-text"></textarea>
                <button
                    @click="postMessage"
                    :disabled="!textExists"
                    class="send-btn"
                >
                    送信
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            user_id: null,
            text: "",
            messages: [],
            user_data: [],
        };
    },
    computed: {
        textExists() {
            return this.text.length > 0;
        },
    },
    mounted() {
        // メッセージ取得
        this.fetchMessages();
        // ユーザーデータ取得
        this.getUsersData();

        Echo.private("chat").listen("MessageSent", (e) => {
            this.messages.push({
                message: e.message.message,
                user: e.user,
            });
        });
    },
    methods: {
        fetchMessages() {
            axios
                .get("/messages/" + this.$route.params.room_no)
                .then((response) => {
                    console.log(response.data);
                    this.user_id = response.data.user_id;
                    this.messages = response.data.messages;
                });
        },
        postMessage(message) {
            axios
                .post("/messages", {
                    room_no: this.$route.params.room_no,
                    message: this.text,
                })
                .then((response) => {
                    this.text = "";
                });
        },
        // ユーザーデータ取得
        getUsersData() {
            axios
                .get(
                    "/api/get_user_data_in_message/" +
                        this.$route.params.room_no
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
    },
};
</script>
<style>
.chat {
    max-width: 600px;
    margin: 0 auto;
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
    width: 80%;
}
.send-btn {
    width: 10%;
}
</style>