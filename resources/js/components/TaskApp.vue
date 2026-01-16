<template>
  <div>
    <h2>Task Manager</h2>

    <!-- Create Task -->
    <form @submit.prevent="createTask">
      <input
        v-model="newTask.title"
        placeholder="Task title"
        required
      />

      <select v-model="newTask.status">
        <option value="pending">Pending</option>
        <option value="in_progress">In Progress</option>
        <option value="completed">Completed</option>
      </select>

      <button type="submit" class="btn-add">Add Task</button>
    </form>

    <hr />

    <!-- Task List -->
    <div v-if="tasks.length">
      <div class="task" v-for="task in tasks" :key="task.id">
        <div>
          <strong>{{ task.title }}</strong><br />
          <small>Status:</small>
        </div>

        <div>
          <select
            class="status"
            v-model="task.status"
            @change="updateStatus(task)"
          >
            <option value="pending">Pending</option>
            <option value="in_progress">In Progress</option>
            <option value="completed">Completed</option>
          </select>

          <button
            class="btn-delete"
            @click="deleteTask(task.id)"
          >
            Delete
          </button>
        </div>
      </div>
    </div>

    <p v-else>No tasks found.</p>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      tasks: [],
      newTask: {
        title: '',
        status: 'pending',
      },
    };
  },

  mounted() {
    this.fetchTasks();
  },

  methods: {
    fetchTasks() {
      axios.get('/api/tasks').then((res) => {
        this.tasks = res.data;
      });
    },

    createTask() {
      axios.post('/api/tasks', this.newTask).then(() => {
        this.newTask.title = '';
        this.newTask.status = 'pending';
        this.fetchTasks();
      });
    },

    updateStatus(task) {
      axios.put(`/api/tasks/${task.id}`, {
        status: task.status,
      });
    },

    deleteTask(id) {
      axios.delete(`/api/tasks/${id}`).then(() => {
        this.fetchTasks();
      });
    },
  },
};
</script>
