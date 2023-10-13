<script setup>
import { formatDate } from '../../../helper/helper.js'
    defineProps({ //Props are used to send data from the parent element to the child component
        user: Object,
        index: Number,
        selectAll: Boolean,
    });

    const emit = defineEmits(['editUser','confirmUserDelete','toggleSelection']); //emit are used to pass information from the child component to the parent


</script>

<template>
	<tr>
        <td><input type="checkbox" :checked="selectAll" @change="$emit('toggleSelection',user)" /></td>
		<td>{{ index + 1 }}</td>
		<td>{{ user.name }}</td>
		<td>{{user.email}}</td>
		<td>{{ formatDate(user.created_at) }}</td>
		<td>-</td>
		<td>
		<i class="text-primary btn fa fa-edit" @click="$emit('editUser',user)"></i>
		<i class="text-danger fa fa-trash" @click="$emit('confirmUserDelete',user.id)"></i>
		</td>
	</tr>
</template>
