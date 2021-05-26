<template>
    <div class="container">
        <link
            rel="stylesheet"
            href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"
        />

        <div class="row">
            <admin-working-item-component
                @add="add"
                day="monday"
                title="Pazartesi"
                :data="monday"
            />
            <admin-working-item-component
                @add="add"
                day="tuesday"
                title="Salı"
                :data="tuesday"
            />
            <admin-working-item-component
                @add="add"
                day="wednesday"
                title="Çarşamba"
                :data="wednesday"
            />
            <admin-working-item-component
                @add="add"
                day="thursday"
                title="Perşembe"
                :data="thursday"
            />
            <admin-working-item-component
                @add="add"
                day="friday"
                title="Cuma"
                :data="friday"
            />
            <admin-working-item-component
                @add="add"
                day="saturday"
                title="Cumartesi"
                :data="saturday"
            />
            <admin-working-item-component
                @add="add"
                day="sunday"
                title="Pazar"
                :data="sunday"
            />

            <button class="btn btn-success" @click="store">Kaydet</button>
        </div>
    </div>
</template>

<script>
import AdminWorkingItemComponent from "./AdminWorkingItemComponent.vue";
export default {
    components: { AdminWorkingItemComponent },
    data() {
        return {
            monday: [],
            tuesday: [],
            wednesday: [],
            thursday: [],
            friday: [],
            saturday: [],
            sunday: []
        };
    },
    created() {
        axios.get("http://localhost:8000/api/working-list").then(res => {
            this.monday =
                typeof res.data.monday !== "undefined" ? res.data.monday : [];
            this.tuesday =
                typeof res.data.tuesday !== "undefined" ? res.data.tuesday : [];
            this.wednesday =
                typeof res.data.wednesday !== "undefined"
                    ? res.data.wednesday
                    : [];
            this.thursday =
                typeof res.data.thursday !== "undefined"
                    ? res.data.thursday
                    : [];
            this.friday =
                typeof res.data.friday !== "undefined" ? res.data.friday : [];
            this.saturday =
                typeof res.data.saturday !== "undefined"
                    ? res.data.saturday
                    : [];
            this.sunday =
                typeof res.data.sunday !== "undefined" ? res.data.sunday : [];
        });
    },

    methods: {
        add(data) {
            console.log(data);
            this[data.day].push(data.text);
        },
        store() {
            axios
                .post("http://localhost:8000/api/working-store", {
                    monday: this.monday,
                    tuesday: this.tuesday,
                    wednesday: this.wednesday,
                    thursday: this.thursday,
                    friday: this.friday,
                    saturday: this.saturday,
                    sunday: this.sunday
                })
                .then(res => {
                    console.log(res);
                });
        }
    }
};
</script>

<style scoped></style>
