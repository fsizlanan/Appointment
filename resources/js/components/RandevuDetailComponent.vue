<template>
    <div>
        <div class="container">
            <div class="main">
                <h2>Randevu Takip Sistemi</h2>
                <h3>Randevu görmek için bilgileri doğru giriniz</h3>
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
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="name">Randevu Kodunuz</label>
                            <input
                                v-model="code"
                                id="name"
                                type="text"
                                class="form-control"
                                placeholder="Randevu Kodu"
                            />
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div
                        class="col-md-12"
                        style="
                            justify-content: center;
                            text-align: center;
                        "
                    >
                        <button
                            @click="store"
                            type="submit"
                            class="btn btn-success mb-2 text-center"
                        >
                            Randevu ara
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container" v-if="completeForm" style="margin-top : 20px; text-align:center;">
            <h3>Randevu Bilgileriniz</h3>
            <div class="completeForm" style="margin-top : 20px; border : 1px solid #ddd" >
                <div class="row" style="text-align : center">
                    <div class="col-md-12">Tarih : {{ info.date }}</div>
                    <div class="col-md-12">Saat : {{ info.working }}</div>
                    <div class="col-md-12">Bildirim Tipi : {{ info.notification }}</div>
                </div>
                <div class="row">
                    <div v-for="item in notes" :key="item" class="col-md-12">
                        {{item.text}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            completeForm: false,
            code: null,
            errors: [],
            info: [],
            notes: []
        };
    },
    methods: {
        store() {
            if (this.code != null) {
                axios
                    .post("/api/appointment-detail", {
                        code: this.code
                    })
                    .then(res => {
                        if (res.data.status) {
                            this.info = res.data.info;
                            this.notes = res.data.note;
                            this.completeForm = true;
                        } else {
                            this.errors = [];
                            this.code = null;
                            this.errors.push(res.data.message);
                        }
                        console.log(res);
                    })
                    .catch(e => {
                        console.log(e);
                    });
            } else {
                this.errors = [];
                this.errors.push("Randevu Kodu Boş Bırakılamaz");
            }
        }
    }
};
</script>

<style></style>
