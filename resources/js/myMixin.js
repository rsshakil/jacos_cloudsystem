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
        init() {
            axios.post(this.BASE_URL + 'user').catch(err => { window.location.reload(); })
        }
    }
};