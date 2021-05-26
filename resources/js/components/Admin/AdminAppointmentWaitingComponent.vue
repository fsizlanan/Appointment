<template>
    <div>
        <appointment-item :data="items.data" />
        <div class="row" style="margin-top : 10px;">
            <div class="col-md-12">
                <pagination :data="items" @pagination-change-page="getData" />
            </div>
        </div>
    </div>
</template>

<script>
//import AdminListAppointment from "./AdminListAppointment.vue";
export default {
  //  components: { AdminListAppointment },
    data() {
        return {
            items: {
                data: []
            }
        };
    },
    created() {
        this.getData();
    },
    mounted() {
        console.log("Beni Çağırdın");
    },
    methods: {
        getData(page) {
            if (typeof page == "undefined") {
                page = 1;
            }
            axios
                .get("http://localhost:8000/api/admin/waiting-list/?page=" + page)
                .then(res => {
                    this.items = res.data;
                });
            console.log(page);
        }
    }
};
</script>

<style></style>
