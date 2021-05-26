<template>
    <div class="panel panel-default">
        <div class="panel-heading">
            {{ title }}
            <button class="btn btn-secondary btn-sm" @click="showForm">
                Göster
            </button>
        </div>
        <div class="" v-if="isShow">
            <input
                type="text"
                v-model="time"
                class="form-control"
                placeholder="Çalışma Saati : 10.00 - 19.00"
            />
            <button @click="addTime" class="btn btn-primary mt-4">Ekle</button>
        </div>
        <div class="panel-body">
            <div v-for="item in data" :key="item">{{ item }}</div>
        </div>
    </div>
</template>

<script>
export default {
    props: ["title", "data", "day"],

    data() {
        return {
            isShow: false,
            time: ""
        };
    },
    methods: {
        showForm() {
            this.isShow = !this.isShow;
        },
        addTime() {
            this.$emit("add", { text: this.time, day: this.day });
            this.time = "";
            this.isShow = false;
        }
    }
};
</script>

<style></style>
