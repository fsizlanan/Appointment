<template>
    <div>
        <div class="row">
            <div
                v-for="item in data"
                @click="openModal(item.id)"
                :key="item.id"
                class="col-md-4"
            >
                <div class="card appointment-card">
                    <span class="appointment-number"
                        >#Randevu

                        <span
                            class="new-appointment bg-info"
                            v-if="item.isActive == 0"
                            >Yeni</span
                        >
                        <span
                            class="new-appointment bg-success"
                            v-if="item.isActive == 1"
                            >Onaylanmış</span
                        >
                        <span class="new-appointment" v-if="item.isActive == 2"
                            >İptal Edilen</span
                        >
                    </span>
                    <div class="appointment-detail">
                        <span>{{ item.fullName }}</span>
                        <span>{{ item.date }}</span>
                        <span>{{ item.working }}</span>
                    </div>

                    <div v-if="!item.isActive">
                        <button
                            @click="appointmentOkey(item.id)"
                            class="btn btn-success btn-sm"
                        >
                            Onayla
                        </button>
                        <button
                            @click="appointmentCancel(item.id)"
                            class="btn btn-sm btn-danger"
                        >
                            İptal
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <admin-appointment-modal v-if="showModal" @close="showModal = false" :modalId = 'showModalId' />
    </div>
</template>

<script>
import AdminAppointmentModal from "./AdminAppointmentModal.vue";
export default {
    components: { AdminAppointmentModal },
    props: ["data"],
    data() {
        return {
            showModalId : 0,
            showModal: false
        };
    },
    created() {},
    methods: {
        appointmentOkey(id) {
            this.$emit("updateOkey", id);
        },
        appointmentCancel(id) {
            this.$emit("updateCancel", id);
        },
        openModal(id) {
            this.showModalId = id,
            this.showModal = true; 
        }
    }
};
</script>

<style></style>
