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
            col_lists: []
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
            this.app.req.post(this.BASE_URL + "logout").then(() => {
                // this.app.user=null;
                // this.$router.push('/login');
                window.location.reload();
            });
        },
        display_table_col_setting() {
            console.log("load modal");
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
                    console.log(data);
                    this.$root.$emit(
                        "bv::hide::modal",
                        "table_col_setting",
                        "#table_colShowHide"
                    );
                    this.get_all_byr_order_detail();
                });
        },
        handleChange: function(col_setting) {
            if(col_setting.header_status===true){
                this.selected_columns.push(col_setting.header_field);
            }else{
                for (var i = 0; i < this.selected_columns.length; i++ ) {
                    if (this.selected_columns[i] == col_setting.header_field) {
                      this.selected_columns.splice(i, 1)
                    }
                  }
            }
            console.log(this.table_col_arry);
            console.log(this.selected_columns);
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
                return false;
            } else {
                return true;
            }
        },
        col_show_hide_setting(url_slug) {
            var post_data = {
                url_slug: url_slug,
                user_id: Globals.user_info_id
            };
            axios
                .post(this.BASE_URL + "api/tblecolsetting", post_data)
                .then(data => {
                    console.log(data);
                });
        },
        init() {
            axios.post(this.BASE_URL + "user").catch(err => {
                window.location.reload();
            });
        }
    },
    created() {

        axios
            .get(this.BASE_URL + "api/tblecolsetting/" + this.$route.name)
            .then(data => {
                this.table_col_setting_list = data.data.result;
                this.table_col_arry = data.data.arrs;
                this.selected_columns = data.data.selected_columns;
                this.col_lists = data.data.col_lists;
            });
    }
};