import Dashboard from './components/Dashboard.vue';
import ListAppointment from './pages/admin/appintments/ListAppointments.vue';
import UserList from './pages/admin/users/UserList.vue';
import UpdateSettings from './pages/admin/settings/UpdateSettings.vue';
import UpdateProfile from './pages/admin/profile/UpdateProfile.vue';

export default [

    {
        path: '/admin/dashboard',
        name: 'admin.dashboard',
        component: Dashboard,
    },
    {
        path: '/admin/appointments',
        name: 'admin.appointments',
        component: ListAppointment,
    },
    {
        path: '/admin/users',
        name: 'admin.users',
        component: UserList,
    },
    {
        path: '/admin/settings',
        name: 'admin.settings',
        component: UpdateSettings,
    },
    {
        path: '/admin/profile',
        name: 'admin.profile',
        component: UpdateProfile,
    },
    {
        path: '/logout',
        name: 'logout',
        component: UpdateProfile,
    }

]
