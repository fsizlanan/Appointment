<template>
    <div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link active"
                    id="waiting-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#waiting"
                    type="button"
                    role="tab"
                    aria-controls="home"
                    aria-selected="true"
                >
                    Onay Bekleyen Randevular
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link"
                    id="home-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#home"
                    type="button"
                    role="tab"
                    aria-controls="home"
                    aria-selected="true"
                >
                    Günü Gelen Randevular
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link"
                    id="profile-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#profile"
                    type="button"
                    role="tab"
                    aria-controls="profile"
                    aria-selected="false"
                >
                    Gelecek Randevular
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link"
                    id="contact-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#contact"
                    type="button"
                    role="tab"
                    aria-controls="contact"
                    aria-selected="false"
                >
                    Geçmiş Randevular
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button
                    class="nav-link"
                    id="cancel-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#cancel"
                    type="button"
                    role="tab"
                    aria-controls="contact"
                    aria-selected="false"
                >
                    İptal Edilen Randevular
                </button>
            </li>
        </ul>
        <div class="tab-content" id="myTabContent">
            <div
                class="tab-pane fade show active"
                id="waiting"
                role="tabpanel"
                aria-labelledby="home-tab"
            >
                <appointment-item
                    :data="waiting.data"
                    @updateOkey="updateOkey"
                    @updateCancel="updateCancel"
                />
                <div class="row" style="margin-top : 10px;">
                    <div class="col-md-12">
                        <pagination
                            :data="waiting"
                            @pagination-change-page="getData"
                        />
                    </div>
                </div>
            </div>
            <div
                class="tab-pane fade"
                id="home"
                role="tabpanel"
                aria-labelledby="home-tab"
            >
                <appointment-item
                    :data="today.data"
                    @updateOkey="updateOkey"
                    @updateCancel="updateCancel"
                />
                <div class="row" style="margin-top : 10px;">
                    <div class="col-md-12">
                        <pagination
                            :data="today"
                            @pagination-change-page="getData"
                        />
                    </div>
                </div>
            </div>
            <div
                class="tab-pane fade"
                id="profile"
                role="tabpanel"
                aria-labelledby="profile-tab"
            >
                <appointment-item
                    :data="list.data"
                    @updateOkey="updateOkey"
                    @updateCancel="updateCancel"
                />
                <div class="row" style="margin-top : 10px;">
                    <div class="col-md-12">
                        <pagination
                            :data="list"
                            @pagination-change-page="getData"
                        />
                    </div>
                </div>
            </div>
            <div
                class="tab-pane fade"
                id="contact"
                role="tabpanel"
                aria-labelledby="contact-tab"
            >
                <appointment-item
                    :data="last.data"
                    @updateOkey="updateOkey"
                    @updateCancel="updateCancel"
                />
                <div class="row" style="margin-top : 10px;">
                    <div class="col-md-12">
                        <pagination
                            :data="last"
                            @pagination-change-page="getData"
                        />
                    </div>
                </div>
            </div>
            <div
                class="tab-pane fade"
                id="cancel"
                role="tabpanel"
                aria-labelledby="cancel-tab"
            >
                <appointment-item
                    :data="cancel.data"
                    @updateOkey="updateOkey"
                    @updateCancel="updateCancel"
                />
                <div class="row" style="margin-top : 10px;">
                    <div class="col-md-12">
                        <pagination
                            :data="cancel"
                            @pagination-change-page="getData"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
// import io from 'socket.io-client';
// var socket = io("http://localhost:3000");

export default {
    data() {
        return {
            waiting: {
                data: []
            },
            list: {
                data: []
            },
            today: {
                data: []
            },
            last: {
                data: []
            },
            cancel: {
                data: []
            }
        };
    },
    created() {
        this.getData();
    },
    methods: {
        updateOkey(id) {
            axios
                .post("http://localhost:8000/api/admin/process", {
                    type: 1,
                    id: id
                })
                .then(res => {
                    this.getData();
                });
        },
        updateCancel(id) {
            axios
                .post("http://localhost:8000/api/admin/process", {
                    type: 2,
                    id: id
                })
                .then(res => {
                    this.getData();
                });
        },
        getData(page) {
            if (typeof page == "undefined") {
                page = 1;
            }
            axios
                .get("http://localhost:8000/api/admin/all/?page=" + page)
                .then(res => {
                  //  console.log(res.data.cancel.data);
                    this.waiting = res.data.waiting;
                    this.list = res.data.list;
                    this.today = res.data.today_list;
                    this.last = res.data.last_list;
                    this.cancel = res.data.cancel;

                });
        }
    }
};
</script>

<style></style>
