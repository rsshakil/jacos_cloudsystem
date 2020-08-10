export default {
    data() {
        return {
            global_user_id: Globals.user_info_id,
            myLang: Globals,
            BASE_URL: Globals.base_url,
            alert_icon: 'error',
            alert_title: 'Oops...',
            alert_text: 'Something went wrong!',
            alert_footer: 'May be internet or url problem',
            table_col_modal: false
        }
    },
    methods: {
        logout() {
            this.app.req.post(this.BASE_URL + 'logout').then(() => {
                // this.app.user=null;
                // this.$router.push('/login');
                window.location.reload();
            })
        },
        display_table_col_setting() {
            console.log('load modal')
            this.table_col_modal = true;

        },
        sweet_normal_alert() {
            Swal.fire({
                icon: this.alert_icon,
                title: this.alert_title,
                text: this.alert_text
            })
        },
        sweet_advance_alert() {
            Swal.fire({
                icon: this.alert_icon,
                title: this.alert_title,
                text: this.alert_text,
                footer: this.alert_footer
            })
        },
        delete_sweet() {
            this.alert_icon = 'warning'
            this.alert_title = 'Are you sure?'
            this.alert_text = "You won't be able to revert this!"
            var status = Swal.fire({
                icon: this.alert_icon,
                title: this.alert_title,
                text: this.alert_text,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            })
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
            var post_data = { url_slug: url_slug, user_id: Globals.user_info_id }
            axios
                .post(this.BASE_URL + "api/tblecolsetting", post_data)
                .then(data => {
                    console.log(data);
                });
        },
        init() {
            axios.post(this.BASE_URL + 'user').catch(err => { window.location.reload(); })
        }
    }
};