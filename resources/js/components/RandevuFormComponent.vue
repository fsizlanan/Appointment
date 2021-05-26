<template>
    <div>
        <div class="container" v-if="completeForm">
            <div class="main">
                <h2>Randevu Takip Sistemi</h2>
                <h3>Randevu oluşturmak için bilgileri doğru giriniz</h3>
            </div>
            <div>
                <div class="row">
                    <ul>
                        <li class="errors" v-for="i in errors" :key="i">
                            {{ i }}
                        </li>
                    </ul>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Ad & Soyad</label>
                            <input
                                v-model="name"
                                id="name"
                                type="text"
                                class="form-control"
                                placeholder="Ad Soyad"
                            />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input
                                v-model="email"
                                id="email"
                                type="email"
                                class="form-control"
                                placeholder="E-mail"
                            />
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="tel">Telefon</label>
                            <input
                                v-mask="'##-###-###-##-##'"
                                v-model="tel"
                                id="tel"
                                type="text"
                                class="form-control"
                                placeholder="Telefon"
                            />
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="date">Tarih</label>
                            <input
                                :min="minDate"
                                @change="selectDate"
                                v-model="date"
                                id="date"
                                type="date"
                                class="form-control"
                                placeholder="Tarih"
                            />
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <ul class="select-time-ul">
                            <li
                                class="select-time"
                                v-for="item in workingHours"
                                :key="item.id"
                            >
                                <input
                                    v-if="item.isActive"
                                    type="radio"
                                    v-model="hours"
                                    :value="item.id"
                                />
                                {{ item.hours }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="form-group">
                            <textarea
                                class="form-control"
                                v-model="text"
                                id="text"
                                cols="10"
                                rows="5"
                            ></textarea>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-md-12 notification-area">
                        <div class="form-group ">
                            <input
                                id="sms"
                                type="radio"
                                v-model="notificationType"
                                value="0"
                            />
                            <label for="sms">Sms</label>

                            <input
                                id="email"
                                type="radio"
                                v-model="notificationType"
                                value="1"
                            />
                            <label for="email">Email</label>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div
                        class="col-md-4"
                        style="
                            justify-content: center;
                            text-align: center;
                        "
                    >
                        <button
                            @click="formGonder"
                            type="submit"
                            class="btn btn-success mb-2 text-center"
                        >
                            Randevu Oluştur
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="completeForm" v-else>
            <div>
                <i class="fas fa-check-double"></i>
                <span>Randevunuz başarılı bir şekilde oluşturulmuştur</span>
            </div>
        </div>
    </div>
</template>

<script>
// import io from "socket.io-client";
// var socket = io("http://localhost:3000");
export default {
    mounted() {
        axios.get("http://localhost:8000/api/working-hours").then(res => {
            this.workingHours = res.data;
        });
    },
    data() {
        return {
            completeForm: true,
            name: null,
            email: null,
            tel: null,
            date: new Date().toISOString().slice(0, 10),
            minDate: new Date().toISOString().slice(0, 10),
            text: null,
            workingHours: [],
            hours: 0,
            errors: [],
            notificationType: null,
        };
    },
    created() {
        // socket.emit("Hello");
    },
    methods: {
        formGonder() {
            if (
                this.name &&
                this.email &&
                this.tel &&
                this.hours != 0 &&
                this.notificationType
            ) {
                axios
                    .post("http://localhost:8000/api/appointment-store", {
                        fullName: this.name,
                        phone: this.tel,
                        email: this.email,
                        date: this.date,
                        workingHour: this.hours,
                        text: this.text,
                        notificationType: this.notificationType
                    })
                    .then(res => {
                        console.log(res);
                        if (res.status) {
                            // socket.emit("new_appointment_create");
                            this.completeForm = false;
                        }
                    });
                console.log("Form Gönderilmeye Hazır");
            }
            this.errors = [];
            if (!this.notificationType) {
                this.errors.push("Bildirim tipi seçilmelidir.");
            }
            if (!this.name) {
                this.errors.push("isim soyisim girilmelidir");
            }
            if (!this.email) {
                this.errors.push("email girilmelidir");
            }
            if (!this.tel) {
                this.errors.push("telefon numarası girilmelidir");
            }
            if (!this.hours) {
                this.errors.push("çalışma saati girilmelidir");
            }
        },

        selectDate() {
            axios
                .get("http://localhost:8000/api/working-hours/"+this.date)
                .then(res => {
                    this.workingHours = res.data;
                    console.log(res.data);
                });
        }
    }
};
</script>

<style></style>
