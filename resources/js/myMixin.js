import moment from 'moment';
export default {
    data() {
        return {
            global_user_id: Globals.user_info_id,
            myLang: Globals,
            BASE_URL: Globals.base_url,
            alert_icon: "error",
            alert_title: "Oops...",
            alert_text: "Something went wrong!",
            alert_footer: "May be internet or url problem",
            global_image_path: null,
            table_col_setting_list: "",
            table_col_arry: [],
            selected_columns: [],
            col_lists: [],
            buyer_info_for_saller: [],
            filter_select_box: false,
            buyers: [],
            selected_buyer: [],
            sellers: [],
            selected_seller: [],
            // loader: "",
        };
    },
    methods: {
        // Database created and updated datetime conversion 
        formatDate(date_string) {
            var date = new Date(date_string)
            return date.getFullYear() + '-' +
                this.length_fill(date.getMonth() + 1) + '-' +
                this.length_fill(date.getDate()) + ' ' +
                this.length_fill(date.getHours()) + ':' +
                this.length_fill(date.getMinutes()) + ':' +
                this.length_fill(date.getSeconds());
        },

        length_fill(data_string) {
            var strlenth = data_string.toString().length;
            var str;
            if (strlenth < 2) {
                str = "0" + data_string;
            } else {
                str = data_string;
            }
            return str;
        },
        imageSrc(image_name) {
            if (image_name) {
                this.global_image_path =
                    this.BASE_URL +
                    "/storage/app/public/backend/images/users/" +
                    image_name;
            } else {
                this.global_image_path =
                    this.BASE_URL +
                    "/storage/app/public/backend/images/default/no-image.png";
            }
            return this.global_image_path;
        },
        logout() {
            this.loader =Vue.$loading.show()
            this.app.req.post(this.BASE_URL + "logout").then(() => {
                // this.app.user=null;
                // this.$router.push('/login');
                
                window.location.reload();
                this.$router.push("home");
                his.loader.hide();
            });
        },
        display_table_col_setting() {

            console.log(this.$route.name);
            if (this.$route.name == 'order_list_detail') {
                this.$root.$emit(
                    "bv::show::modal",
                    "table_col_setting",
                    "#table_colShowHide"
                );
                axios
                    .get(this.BASE_URL + "api/tblecolsetting/" + this.$route.name)
                    .then(data => {
                        console.log(data);
                        this.table_col_setting_list = data.data.result;
                        this.table_col_arry = data.data.arrs;
                        this.selected_columns = data.data.selected_columns;
                        this.col_lists = data.data.col_lists;
                    });
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Table column setting',
                    text: 'Table column setting not found for this page'
                });
            }
        },
        update_col_setting() {
            console.log("update col setting");

            var post_data = {
                url_slug: this.$route.name,
                user_id: Globals.user_info_id,
                content_setting: this.selected_columns,
                setting_list: this.table_col_arry,
            };
            axios
                .put(
                    this.BASE_URL + "api/tblecolsetting/" + this.$route.name,
                    post_data
                )
                .then(data => {
                    this.$root.$emit(
                        "bv::hide::modal",
                        "table_col_setting",
                        "#table_colShowHide"
                    );
                    Fire.$emit('LoadByrorderDetail');
                    // window.location.reload();
                });
        },
        handleChange: function(col_setting) {
            if (col_setting.header_status === true) {
                this.selected_columns.push(col_setting.header_field);
            } else {
                for (var i = 0; i < this.selected_columns.length; i++) {
                    if (this.selected_columns[i] == col_setting.header_field) {
                        this.selected_columns.splice(i, 1)
                    }
                }
            }
        },

        sweet_normal_alert() {
            Swal.fire({
                icon: this.alert_icon,
                title: this.alert_title,
                text: this.alert_text
            });
        },
        sweet_advance_alert() {
            Swal.fire({
                icon: this.alert_icon,
                title: this.alert_title,
                text: this.alert_text,
                footer: this.alert_footer
            });
        },
        delete_sweet() {
            this.alert_icon = "warning";
            this.alert_title = "Are you sure?";
            this.alert_text = "You won't be able to revert this!";
            var status = Swal.fire({
                icon: this.alert_icon,
                title: this.alert_title,
                text: this.alert_text,
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            });
            return status;
        },
        is_disabled(is_system = 0) {
            if (is_system == 0) {
                return true;
            } else {
                return false;
            }
        },
        init() {
            // let access_token = localStorage
            let access_token = document.cookie;
            console.log(access_token);
            // console.log(localStorage);
            // return 0;
            if (!access_token) {
                window.location.reload();
            }
            // axios.post(this.BASE_URL + "user").catch(err => {
            //     window.location.reload();
            // });
        },
        selectedOption(option) {
            if (this.value) {
                return option.cmn_company_id === this.value.cmn_company_id;
            }
            return false;
        },
        allBuyerInfoBySaller(user_id) {
            // console.log(user_id);
            // return 0;
            axios.post(this.BASE_URL + "api/get_byr_slr_data", { user_id: user_id })
                .then(({ data }) => {
                    // console.log(data);
                    this.buyer_info_for_saller = data.slr_order_info;
                    // return data.slr_order_info;
                });
        },
        buyer_route_change(byr_buyer_id) {
            this.$session.start()
            this.$session.set('byr_buyer_id', byr_buyer_id);
            if (this.$route.path != '/home/selected_buyer') {
                this.$router.push("/home/selected_buyer");
            }
            // this.$router.push({
            //         name: 'selected_buyer',
            //         // params: { byr_buyer_id: byr_buyer_id }
            //     })
            // .catch(() => {
            //     console.log("error")
            // })
            Fire.$emit('selectedByuerBlog', byr_buyer_id);
            Fire.$emit('byr_has_selected', byr_buyer_id);
            Fire.$emit('permission_check_for_buyer', byr_buyer_id);
        },
        get_byr_slr_company(cmn_company_id) {
            if (cmn_company_id == null) {
                this.filter_select_box = true
                    // var company_info=this.get_byr_slr_company(this.cmn_company_id);
                axios
                    .get(this.BASE_URL + "api/get_byr_slr_company/" + this.cmn_company_id)
                    .then(({ data }) => {
                        this.buyers = data.buyer_info;
                        this.sellers = data.seller_info;
                        this.selected_buyer = this.buyers[0]
                        Fire.$emit('company_partner_list_emit', this.selected_buyer.cmn_company_id);
                        Fire.$emit('get_all_company_users_emit', this.selected_buyer.cmn_company_id);
                        // console.log(data)
                    });
            }
        }
    },
    filters: {

        subStr: function(string) {
            return string.substring(0, 300) + '...';
        },
        diffForHumans(str) {
            moment.locale('ja');
            return moment(str).from(moment());
        },
        ja_date_time(str) {
            moment.locale('ja');
            return moment(str).format('LLL');
        },
        ja_date(str) {
            moment.locale('ja');
            return moment(str).format('LL');
        },

    },
    created() {
        // this.user_data = this.app._data;

        // this.global_user_id = Globals.user_info_id;
        // axios
        //     .get(this.BASE_URL + "api/tblecolsetting/" + this.$route.name)
        //     .then(data => {
        //         this.table_col_setting_list = data.data.result;
        //         this.table_col_arry = data.data.arrs;
        //         this.selected_columns = data.data.selected_columns;
        //         this.col_lists = data.data.col_lists;
        //     });
    }
};