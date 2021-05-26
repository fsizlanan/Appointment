<template>
    <transition name="modal">
        <div class="modal-mask">
            <div class="modal-wrapper">
                <div class="modal-container">
                    <div class="modal-header">
                        <slot name="header">
                            <h3 slot="header">
                                {{ data.fullName }}
                            </h3>
                            <button
                                class="btn btn-danger modal-default-button"
                                @click="$emit('close')"
                            >
                                X
                            </button>
                        </slot>
                    </div>

                    <div class="modal-body">
                        <slot name="body">
                            <div>
                                <span>Telefon</span> :
                                <span>{{ data.phone }}</span>
                            </div>
                            <div>
                                <span>Email</span> :
                                <span>{{ data.email }}</span>
                            </div>
                            <div>
                                <span>Tarih</span> :
                                <span>{{ data.date }}</span>
                            </div>
                            <div>
                                <span>Saat</span> :
                                <span>{{ data.working }}</span>
                            </div>
                            <div>
                                <span>Bildirim Tipi</span> :
                                <span>{{ data.notification }}</span>
                            </div>
                            <div>
                                <span>Not</span> :
                                <span>{{ data.text }}</span>
                            </div>
                        </slot>
                        <div class="mt-2" style="border-top : 1px solid #ddd;">
                            <div
                                class="mt-2"
                                v-for="item in comment"
                                :key="item.id"
                            >
                                {{ item.text }}
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div>
                            <textarea
                                v-model="text"
                                class="form-control"
                                id=""
                                cols="60"
                                rows="5"
                            ></textarea>
                            <button @click="store" class="btn btn-primary mt-2">
                                Gönder
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </transition>
</template>

<script>
export default {
    data() {
        return {
            data: [],
            comment: [],
            text: ""
        };
    },

    props: ["modalId"],

    created() {
        this.getData();
    },
    methods: {
        store() {
            axios
                .post("http://localhost:8000/api/admin/detail", {
                    id: this.modalId,
                    text: this.text
                })
                .then(res => {
                    if (res.status) {
                        this.text = "";
                        this.getData();
                    }
                });
        },
        getData() {
            axios
                .get("http://localhost:8000/api/admin/detail/" + this.modalId)
                .then(res => {
                    this.data = res.data.data;
                    this.comment = res.data.comment;
                });
        }
    }
};
</script>

<style></style>
