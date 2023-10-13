<script setup>
import axios from 'axios';
import { ref, onMounted, reactive, watch } from 'vue';
import {Form, Field} from 'vee-validate';
import * as yup from 'yup';
import { useToastr } from '../../../helper/helper.js'
import UserListItem from './UserListItem.vue';
import { debounce } from 'lodash';



const users = ref([]);
const is_user_edit = ref(false);
const userFormValues = ref();
const form = ref(null);
const toastr = useToastr();
const userBeingDeleted = ref(null);
const searchQuery = ref(null);
const selectAll = ref(false);



const getUsers = () => {
    axios.get('/api/users',{
        params: {
            query: searchQuery.value
        }
    })
    .then((response) => {
        users.value = response.data.data;
    });
}

const createUserValidation = yup.object({
    name: yup.string().required(),
    email: yup.string().email().required(),
    password: yup.string().required().min(8),
});

const editUserValidation = yup.object({
    name: yup.string().required(),
    email: yup.string().email().required(),
    password: yup.string().min(8),
});

const addUser = () => {
    is_user_edit.value = false;
    $('#userFormModal').modal('show');
}

const createUser = (values, { resetForm, setErrors }) => {
    axios.post('/api/users', values)
    .then((response) => {
        users.value.unshift(response.data.data);
        $('#userFormModal').modal('hide');
        resetForm();
        toastr.success('User created successfully');
    })
    .catch((error) => {
        if (error.response.data.message) {
            setErrors(error.response.data.message);
        }
    });
};

const editUser = (user) => {
    is_user_edit.value = true;
    form.value.resetForm();
    userFormValues.value = {
        id: user.id,
        name: user.name,
        email: user.email,
    };
    $('#userFormModal').modal('show');
}

const updateUser = (values, {setErrors}) => {
    axios.put('/api/users/' + userFormValues.value.id,values)
    .then((response) => {
        // users.value.unshift(response.data.data);
        const index = users.value.findIndex(user => user.id === response.data.data.id);
        users.value[index] = response.data.data;
        $('#userFormModal').modal('hide');
        toastr.success('User updated successfully');
    })
    .catch((error) => {
        if (error.response.data.message) {
            setErrors(error.response.data.message);
        }
    });
}

const confirmUserDelete = (userId) => {
    userBeingDeleted.value = userId;
    $('#deleteUserModal').modal('show');
}

const deleteUser = () => {
    axios.delete(`/api/users/${userBeingDeleted.value}`)
    .then(() => {
        $('#deleteUserModal').modal('hide');
        users.value = users.value.filter(user => user.id !== userBeingDeleted.value);
        toastr.success('User deleted successfully');
    })
}

const selectedUsersForDelete = ref([]);
const toggleSelection = (user) => {
    const index = selectedUsersForDelete.value.indexOf(user.id);
    if (index === -1) {
        selectedUsersForDelete.value.push(user.id);
    } else {
        selectedUsersForDelete.value.splice(index, 1);
    }
    console.log(selectedUsersForDelete.value);
};

const bulkDelete = () => {
    axios.delete('/api/bulkdelete',{
        data: {
            ids: selectedUsersForDelete.value
        }
    })
    .then(response => {
        users.value = users.value.filter(user => !selectedUsersForDelete.value.includes(user.id));
        selectedUsersForDelete.value = [];
        toastr.success(response.data.message);
    })
}

const selectAllUsers = () => {
    if (selectAll.value) {
        selectedUsersForDelete.value = users.value.map(user => user.id);
    } else {
        selectedUsersForDelete.value = [];
    }
    console.log(selectedUsersForDelete.value);
}


const handelSubmit = (values,actions) => {
    // console.log(actions);
    if (is_user_edit.value) {
        updateUser(values,actions);
    }else{
        createUser(values,actions);
    }
}

watch(searchQuery, debounce(() => {
    getUsers();
}, 300));

onMounted(() => {
    getUsers();
})
</script>

<template>
    <div class="content-header">
       <div class="container-fluid">
          <div class="row mb-2">
             <div class="col-sm-6">
                <h1 class="m-0">Users</h1>
             </div>
             <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                   <li class="breadcrumb-item"><a href="#">Home</a></li>
                   <li class="breadcrumb-item active">Users</li>
                </ol>
             </div>
          </div>
       </div>
    </div>
    <div class="content">
       <div class="container-fluid">
          <div class="d-flex justify-content-between">
            <div class="d-flex">
                <button @click="addUser" type="button" class="btn btn-secondary mb-2">
                    Add User
                </button>
                <button v-if="selectedUsersForDelete.length > 0" @click="bulkDelete" type="button" class="btn btn-danger mb-2 ml-2">
                    <i class="fa fa-trash mr-1"></i>
                    Delete Selected
                </button>
            </div>
            <div>
                <input type="text" v-model="searchQuery" class="form-control" placeholder="Search..." />
            </div>
          </div>
          <div class="row">
             <div class="col-lg-12">
                <table class="table table-bordered">
                   <thead>
                      <tr>
                        <th><input type="checkbox" v-model="selectAll" @change="selectAllUsers" /></th>
                         <th>#</th>
                         <th>Name test</th>
                         <th>Email</th>
                         <th>Registered Date</th>
                         <th>Role</th>
                         <th>Options</th>
                      </tr>
                   </thead>
                   <tbody v-if="users.length > 0">
                    <UserListItem v-for="(user, index) in users"
                    :key="user.id"
                    :user=user
                    :index=index
                    @edit-user="editUser"
                    @confirm-user-delete="confirmUserDelete"
                    @toggle-selection="toggleSelection"
                    :selectAll="selectAll"
                    />
                   </tbody>
                   <tbody v-else>
                    <tr>
                        <td colspan="6" class="text-center"> No recored found </td>
                    </tr>
                   </tbody>
                </table>
             </div>
          </div>
       </div>
    </div>
    <!-- create user modal -->
    <div class="modal fade" id="userFormModal">
       <div class="modal-dialog">
          <div class="modal-content">
             <div class="modal-header">
                <h4 class="modal-title">
                    <span v-if="is_user_edit">Edit User</span>
                    <span v-else>Add New User</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
             </div>
             <div class="modal-body">
                <Form ref="form" @submit="handelSubmit" :validation-schema="is_user_edit ? editUserValidation : createUserValidation" v-slot="{errors}" :initial-values="userFormValues">
                    <div class="form-group">
                      <label for="name">Name</label>
                      <Field  type="text" name="name" class="form-control" :class="{'is-invalid':errors.name}" id="name" placeholder="Enter name"/>
                      <span class="invalid-feedback">{{ errors.name }}</span>
                    </div>
                   <div class="form-group">
                      <label for="email">Email address</label>
                      <Field type="email" name="email" class="form-control" :class="{'is-invalid':errors.email}" id="email" placeholder="Enter email"/>
                      <span class="invalid-feedback">{{ errors.email }}</span>
                   </div>
                   <div class="form-group">
                      <label for="password">Password</label>
                      <Field type="password" name="password" class="form-control" :class="{'is-invalid':errors.password}" id="password" placeholder="Password"/>
                      <span class="invalid-feedback">{{ errors.password }}</span>
                   </div>
                   <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </Form>
             </div>
          </div>
       </div>
    </div>

    <!-- Delete User Modal -->
    <div class="modal fade" id="deleteUserModal">
       <div class="modal-dialog">
          <div class="modal-content">
             <div class="modal-header">
                <h4 class="modal-title">
                    <span>Delete user</span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
             </div>
             <div class="modal-body">
                <h6>Are you sure, you want to delete this user?</h6>
             </div>
             <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" @click="deleteUser" class="btn btn-danger">Delete</button>
            </div>
          </div>
       </div>
    </div>
 </template>
