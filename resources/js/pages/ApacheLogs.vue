<script>
import axios from 'axios';

export default {
  name: 'ApacheLogs',
  data() {
    return {
      logs: [],
      filters: {
        ip_address: '',
        status_code: '',
      },
      sortBy: 'timestamp',
      sortDir: 'asc',
    };
  },
  methods: {
    async parseLogs(){
        const { data } = await axios.post('/api/parse-logs', {}, {});
    },
    async fetchLogs(url) {
      const { data } = await axios.get(url, {
        params: {
          ...this.filters,
          sort_by: this.sortBy,
          sort_dir: this.sortDir,
        },
      });
      this.logs = data;
    },
    applyFilters() {
      this.fetchLogs();
    },
    sort(column) {
      this.sortDir = this.sortBy === column && this.sortDir === 'asc' ? 'desc' : 'asc';
      this.sortBy = column;
      this.fetchLogs();
    },
  },
  mounted() {
    this.parseLogs();
    this.fetchLogs('/api/logs');
  },
};
</script>

<template>
    <div>
      <div  class="filters">
        <input v-model="filters.ip" placeholder="Фильтр IP" @input="applyFilters" />
        <input v-model="filters.status_code" placeholder="Фильтр Status Code" @input="applyFilters" />
      </div>

      <table>
        <thead>
          <tr>
            <th>Hostname</th>
            <th @click="sort('ip')">IP</th>
            <th @click="sort('timestamp')">Timestamp</th>
            <th @click="sort('timezone')">Timezone</th>
            <th>Method</th>
            <th>URL</th>
            <th>Protocol</th>
            <th @click="sort('status_code')">Status</th>
            <th @click="sort('response_size')">Response size</th>
            <th>Referrer</th>
            <th>User agent</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="log in logs.data" :key="log.id">
            <td>{{ log.hostname }}</td>
            <td>{{ log.ip }}</td>
            <td>{{ log.timestamp }}</td>
            <td>{{ log.timezone }}</td>
            <td>{{ log.request_method }}</td>
            <td>{{ log.url }}</td>
            <td>{{ log.protocol }}</td>
            <td>{{ log.status_code }}</td>
            <td>{{ log.response_size }}</td>
            <td>{{ log.referrer }}</td>
            <td>{{ log.user_agent }}</td>
          </tr>
        </tbody>
      </table>

      <div class="pagination">
        <button :disabled="!logs.prev_page_url" @click="fetchLogs(logs.prev_page_url)">Previous</button>
        <button :disabled="!logs.next_page_url" @click="fetchLogs(logs.next_page_url)">Next</button>
      </div>
    </div>
  </template>

<style scoped>
/* Контейнер фильтров */
.filters {
  margin-bottom: 1rem;
  display: flex;
  gap: 10px;
}

.filters input {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  outline: none;
  font-size: 14px;
  transition: border-color 0.3s ease;
}

.filters input:focus {
  border-color: #007bff;
}

/* Таблица */
table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 10px;
  background-color: #fff;
  border: 1px solid #ddd;
}

thead {
  background-color: #f8f9fa;
}

thead th {
  padding: 10px;
  font-weight: bold;
  text-align: left;
  cursor: pointer;
  border-bottom: 2px solid #ddd;
}

tbody tr {
  transition: background-color 0.2s ease;
}

tbody tr:hover {
  background-color: #f1f3f5;
}

td {
  padding: 10px;
  border-bottom: 1px solid #ddd;
}

/* Кнопки пагинации */
.pagination {
  margin-top: 20px;
  display: flex;
  justify-content: center;
  gap: 10px;
}

.pagination button {
  padding: 10px 20px;
  border: none;
  background-color: #007bff;
  color: white;
  border-radius: 4px;
  cursor: pointer;
  font-size: 14px;
  transition: background-color 0.3s ease;
}

.pagination button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

.pagination button:hover:not(:disabled) {
  background-color: #0056b3;
}

.pagination button:focus {
  outline: none;
}
</style>

