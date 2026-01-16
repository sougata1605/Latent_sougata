<template>
  <div>
    <h2>Task Manager</h2>

    <!-- Create Task -->
    <form @submit.prevent="createTask">
      <input v-model="newTask.title" placeholder="Task title" required />
      
      <select v-model="newTask.status">
        <option value="pending">Pending</option>
        <option value="in_progress">In Progress</option>
        <option value="completed">Completed</option>
      </select>

      <button type="submit">Add Task</button>
    </form>

    <hr />

    <!-- Task List -->
    <ul>
      <li v-for="task in tasks" :key="task.id">
        <strong>{{ task.title }}</strong>

        <select v-model="task.status" @change="updateStatus(task)">
          <option value="pending">Pending</option>
          <option value="in_progress">In Progress</option>
          <option value="completed">Completed</option>
        </select>

        <button @click="deleteTask(task.id)">Delete</button>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from 'axios'

export default {
  name: 'TaskApp',

  data() {
    return {
      tasks: [],
      newTask: {
        title: '',
        status: 'pending'
      }
    }
  },

  mounted() {
    this.fetchTasks()
  },

  methods: {
    async fetchTasks() {
      const response = await axios.get('/api/tasks')
      this.tasks = response.data.data
    },

    async createTask() {
      await axios.post('/api/tasks', this.newTask)
      this.newTask.title = ''
      this.newTask.status = 'pending'
      this.fetchTasks()
    },

    async updateStatus(task) {
      await axios.put(`/api/tasks/${task.id}`, {
        status: task.status
      })
    },

    async deleteTask(id) {
      await axios.delete(`/api/tasks/${id}`)
      this.fetchTasks()
    }
  }
}
</script>
